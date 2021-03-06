<?php
/**
 * Variable product add to cart
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product, $post;

$variations = find_valid_variations();

// Check if the special 'price_grid' meta is set, if it is, load the default template:
if (get_post_meta($post->ID, 'price_grid', true)) {
    // Enqueue variation scripts
    wp_enqueue_script('wc-add-to-cart-variation');

    // Load the template
    wc_get_template('single-product/add-to-cart/variable.php', array(
        'available_variations' => $product->get_available_variations(),
        'attributes' => $product->get_variation_attributes(),
        'selected_attributes' => $product->get_variation_default_attributes()
    ));
    return;
}

// Cool, lets do our own template!
?>
<div class="div-tables">
    <table class="variations_atc" cellspacing="0">
        <col class="col-atc-size">
        <col class="col-atc">
        <col class="col-atc">
        <col class="col-atc-btn">
        <?php
        $loop = false;
        foreach ($variations as $key => $value) {
        $productvar = new WC_Product($value['variation_id']);
        if (strcmp(substr($productvar->get_sku(), -2), 'BB') !== 0 ) {
        if ($loop === false) { ?>
            <thead>

            <th class="reg-frame" colspan="5">Regular Framing</th>
            </thead>
            <?php $loop = true;
        } ?>
        <tbody>
        <?php if (!$value['variation_is_visible']) continue;
        ?>
        <tr>
            <td class="var-td">
                <?php foreach ($value['attributes'] as $key => $val) {
                    $val = str_replace(array('-', '_'), ' ', $val); ?>
                    <?php echo str_replace(array('No', 'Yes'), '', ucwords($val)); ?>
                <?php
                } ?>
            </td>
            <td class="var-td">
                <?php $productvar = new WC_Product($value['variation_id']); ?>
                $<?php echo $productvar->get_price(); ?>
            </td>
            <td class="var-td">
                <?php if ($productvar->get_sku() == '') {
                    echo $product->get_sku();
                } else {
                    echo $productvar->get_sku();
                }?>
            </td>
            <td>
                <?php if ($value['is_in_stock']) { ?>
                    <form class="cart" action="<?php echo esc_url($product->add_to_cart_url()); ?>"
                          method="post"
                          enctype='multipart/form-data'>
                        <?php woocommerce_quantity_input(); ?>
                        <?php
                        if (!empty($value['attributes'])) {
                            foreach ($value['attributes'] as $attr_key => $attr_value) {
                                ?>
                                <input type="hidden" name="<?php echo $attr_key ?>"
                                       value="<?php echo $attr_value ?>">
                            <?php
                            }
                        }
                        ?>
                        <button type="submit" class="single_add_to_cart_button btn btn-primary"><span
                                class="glyphicon glyphicon-tag"></span> Add to cart
                        </button>
                        <input type="hidden" name="variation_id" value="<?php echo $value['variation_id'] ?>"/>
                        <input type="hidden" name="product_id" value="<?php echo esc_attr($post->ID); ?>"/>
                        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($post->ID); ?>"/>
                    </form>
                <?php } else { ?>
                    <p class="stock out-of-stock"><?php _e('This product is currently out of stock and unavailable.', 'woocommerce'); ?></p>
                <?php } ?>
            </td>
        </tr>
        <?php }
        } ?>
        </tbody>
    </table>

    <table class="variations_atc" cellspacing="0">
        <col class="col-atc-size">
        <col class="col-atc">
        <col class="col-atc">
        <col class="col-atc-btn">
        <?php
        $loop = false;
        foreach ($variations as $key => $value) {
        $product = new WC_Product($value['variation_id']);
        if (strcmp(substr($product->get_sku(), -2), 'BB') === 0 ) {
        if ($loop === false) { ?>
            <thead>

            <th class="barnboard" colspan="5">Authentic Grey Barnboard</th>
            <th class="reg-frame-mobile" colspan="5">Barnboard Frame</th>
            </thead>
            <?php $loop = true;
        } ?>
        <tbody>
        <?php if (!$value['variation_is_visible']) continue;
        ?>
        <tr>
            <td class="var-td">
                <?php foreach ($value['attributes'] as $key => $val) {
                    $val = str_replace(array('-', '_'), ' ', $val); ?>
                    <?php echo str_replace(array('Yes', 'No'), '', ucwords($val)); ?>
                <?php
                } ?>
            </td>
            <td class="var-td">
                $<?php echo $product->get_price(); ?>
            </td>
            <td class="var-td">
                <?php echo $product->get_sku(); ?>
            </td>
            <td>
                <?php if ($value['is_in_stock']) { ?>
                    <form class="cart" action="<?php echo esc_url($product->add_to_cart_url()); ?>"
                          method="post"
                          enctype='multipart/form-data'>
                        <?php woocommerce_quantity_input(); ?>
                        <?php
                        if (!empty($value['attributes'])) {
                            foreach ($value['attributes'] as $attr_key => $attr_value) {
                                ?>
                                <input type="hidden" name="<?php echo $attr_key ?>"
                                       value="<?php echo $attr_value ?>">
                            <?php
                            }
                        }
                        ?>
                        <button type="submit" class="single_add_to_cart_button btn btn-primary"><span
                                class="glyphicon glyphicon-tag"></span> Add to cart
                        </button>
                        <input type="hidden" name="variation_id" value="<?php echo $value['variation_id'] ?>"/>
                        <input type="hidden" name="product_id" value="<?php echo esc_attr($post->ID); ?>"/>
                        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($post->ID); ?>"/>
                    </form>
                <?php } else { ?>
                    <p class="stock out-of-stock"><?php _e('This product is currently out of stock and unavailable.', 'woocommerce'); ?></p>
                <?php } ?>
            </td>
        </tr>
        <?php }
        } ?>
        </tbody>
    </table>
</div>
<?php
function find_valid_variations()
{
    global $product;

    $variations = $product->get_available_variations();
    $attributes = $product->get_attributes();
    $new_variants = array();

    // Loop through all variations
    foreach ($variations as $variation) {

        // Peruse the attributes.

        // 1. If both are explicitly set, this is a valid variation
        // 2. If one is not set, that means any, and we must 'create' the rest.

        $valid = true; // so far
        foreach ($attributes as $slug => $args) {
            if (array_key_exists("attribute_$slug", $variation['attributes']) && !empty($variation['attributes']["attribute_$slug"])) {
                // Exists

            } else {
                // Not exists, create
                $valid = false; // it contains 'anys'
                // loop through all options for the 'ANY' attribute, and add each
                foreach (explode('|', $attributes[$slug]['value']) as $attribute) {
                    $attribute = trim($attribute);
                    $new_variant = $variation;
                    $new_variant['attributes']["attribute_$slug"] = $attribute;
                    $new_variants[] = $new_variant;
                }

            }
        }

        // This contains ALL set attributes, and is itself a 'valid' variation.
        if ($valid)
            $new_variants[] = $variation;

    }

    return $new_variants;
}