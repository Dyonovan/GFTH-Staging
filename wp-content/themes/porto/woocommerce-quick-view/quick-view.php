<?php
/**
 * Quick view template
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product, $post, $woocommerce;

do_action('wc_quick_view_before_single_product');
?>
<div class="woocommerce quick-view">

    <div class="product">
        <div class="quick-view-image images">

            <?php if (has_post_thumbnail()) : ?>

                <?php echo get_the_post_thumbnail($post->ID, apply_filters('single_product_large_thumbnail_size', 'shop_single')) ?>

            <?php else : ?>

                <img src="<?php echo woocommerce_placeholder_img_src(); ?>"
                     alt="<?php _e('Placeholder', 'wc_quick_view'); ?>"/>

            <?php endif; ?>

        </div>

        <div class="quick-view-content entry-summary qv-size">

            <?php woocommerce_template_single_title(); ?>
            <?php //woocommerce_template_single_price(); ?>
            <?php woocommerce_template_single_excerpt(); ?>
            <?php
            /*
             * Output Individual Add To Cart
             */
            do_action('custom_single_product_add_to_cart');
            ?>

        </div>


    </div>
</div>
