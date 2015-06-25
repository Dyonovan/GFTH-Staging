<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $woocommerce_loop, $product, $porto_settings;

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

$woocommerce_loop['product_loop']++;

// Extra post classes
$classes = array();

if (!$porto_settings['category-hover'])
    $classes[] = 'hover';

if (isset($woocommerce_loop['addlinks_pos']) && $woocommerce_loop['addlinks_pos'] == 'onimage')
    $classes[] = 'show-links-onimage';

if ($woocommerce_loop['product_loop'] == 1)
    $classes[] = 'first';

global $porto_products_cols_lg, $porto_products_cols_md, $porto_products_cols_xs, $porto_products_cols_ls;
if ($woocommerce_loop['product_loop'] % $porto_products_cols_lg == 1)
    $classes[] = 'pcols-lg-first';
if ($woocommerce_loop['product_loop'] % $porto_products_cols_md == 1)
    $classes[] = 'pcols-md-first';
if ($woocommerce_loop['product_loop'] % $porto_products_cols_xs == 1)
    $classes[] = 'pcols-xs-first';
if ($woocommerce_loop['product_loop'] % $porto_products_cols_ls == 1)
    $classes[] = 'pcols-ls-first';
?>
<li <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

    <div class="product-image">


        <a class="quick-view-button button" href="<?php echo get_site_url() . '/?wc-api=WC_Quick_View&product=' . $product->id . '&width=70%&height=60%&ajax=true';//the_permalink(); ?>">
            <?php
                /**
                 * woocommerce_before_shop_loop_item_title hook
                 *
                 * @hooked woocommerce_show_product_loop_sale_flash - 10
                 * @hooked woocommerce_template_loop_product_thumbnail - 10
                 */
                do_action( 'woocommerce_before_shop_loop_item_title' );
            ?>
        </a>

        <div class="links-on-image">
            <?php woocommerce_template_loop_add_to_cart() ?>
        </div>
    </div>

    <h3>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h3>

    <?php
        /**
         * woocommerce_after_shop_loop_item_title hook
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action( 'woocommerce_after_shop_loop_item_title' );
    ?>

    <?php
        /**
         * woocommerce_after_shop_loop_item hook
        *
        * @hooked woocommerce_template_loop_add_to_cart - 10
        */
        do_action( 'woocommerce_after_shop_loop_item' );
    ?>

</li>