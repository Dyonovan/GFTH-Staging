<?php
/**
 * Variable product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product, $post;

$porto_woo_version = porto_get_woo_version_number();

if (function_exists('wcva_get_woo_version_number')) {
    $displaytypenumber = 0;
    if ($product && $post) {//if (is_product()) {
        $displaytypenumber = wcva_return_displaytype_number($product,$post);
    }

    $goahead = 1;

    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $agent = $_SERVER['HTTP_USER_AGENT'];
    }

    if (preg_match('/(?i)msie [5-8]/', $agent))  {
        $goahead = 0;
    }

    if ( ($goahead == 1) && ($displaytypenumber > 0)) {
        $template = wcva_plugin_path() . '/woocommerce/single-product/add-to-cart/variable.php';
        require $template;
    }

} else {

?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php if ( ! empty( $available_variations ) ) : ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>
					<tr>
						<td class="label"><label for="<?php echo sanitize_title($name); ?>"><?php echo wc_attribute_label( $name ); ?></label></td>
						<td class="value"><select id="<?php echo esc_attr( sanitize_title( $name ) ); ?>" name="attribute_<?php echo sanitize_title( $name ); ?>"<?php if ( version_compare($porto_woo_version, '2.3', '>=') ) : ?> data-attribute_name="attribute_<?php echo sanitize_title( $name ); ?>"<?php endif; ?>>
							<option value=""><?php echo __( 'Choose an option', 'woocommerce' ) ?>&hellip;</option>
							<?php
								if ( is_array( $options ) ) {

									if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
										$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
									} elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
										$selected_value = $selected_attributes[ sanitize_title( $name ) ];
									} else {
										$selected_value = '';
									}

                                    if ( version_compare($porto_woo_version, '2.3', '<') ) {
                                        // Get terms if this is a taxonomy - ordered
                                        if ( taxonomy_exists( sanitize_title( $name ) ) ) {

                                            $orderby = wc_attribute_orderby( sanitize_title( $name ) );

                                            switch ( $orderby ) {
                                                case 'name' :
                                                    $args = array( 'orderby' => 'name', 'hide_empty' => false, 'menu_order' => false );
                                                break;
                                                case 'id' :
                                                    $args = array( 'orderby' => 'id', 'order' => 'ASC', 'menu_order' => false, 'hide_empty' => false );
                                                break;
                                                case 'menu_order' :
                                                    $args = array( 'menu_order' => 'ASC', 'hide_empty' => false );
                                                break;
                                            }

                                            $terms = get_terms( sanitize_title( $name ), $args );

                                            foreach ( $terms as $term ) {
                                                if ( ! in_array( $term->slug, $options ) )
                                                    continue;

                                                echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
                                            }
                                        } else {

                                            foreach ( $options as $option ) {
                                                echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
                                            }

                                        }
                                    } else {
                                        if ( taxonomy_exists( $name ) ) {

                                            $terms = wc_get_product_terms( $post->ID, $name, array( 'fields' => 'all' ) );

                                            foreach ( $terms as $term ) {
                                                if ( ! in_array( $term->slug, $options ) ) {
                                                    continue;
                                                }
                                                echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
                                            }

                                        } else {

                                            foreach ( $options as $option ) {
                                                echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
                                            }

                                        }
                                    }
								}
							?>
						</select> <?php
							if ( sizeof( $attributes ) === $loop ) {
								echo '<a class="reset_variations" href="#reset">' . __( 'Clear selection', 'woocommerce' ) . '</a>';
                            }
						?></td>
					</tr>
		        <?php endforeach;?>
			</tbody>
		</table>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap" style="display:none;">
			<?php do_action( 'woocommerce_before_single_variation' ); ?>

			<div class="single_variation"></div>

			<div class="variations_button">
				<?php woocommerce_quantity_input(); ?>
				<button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
			</div>

			<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
			<input type="hidden" name="variation_id"<?php if ( version_compare($porto_woo_version, '2.3', '>=') ) : ?> class="variation_id"<?php endif; ?>value="" />

			<?php do_action( 'woocommerce_after_single_variation' ); ?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php else : ?>

		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>

	<?php endif; ?>

</form>

<?php
    do_action( 'woocommerce_after_add_to_cart_form' );
}
?>
