<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 4.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $woocommerce;
do_action( 'woocommerce_before_mini_cart' ); ?>

<div class="cart-toggler">
	<a href="<?php echo wc_get_cart_url(); ?>"> 
		<span class="cart-title"><?php esc_html_e('My cart', 'monsta');?></span>
		
		<span class="cart-quantity">
			<?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'monsta'), $woocommerce->cart->cart_contents_count);?>
		</span>
		<span class="cart-total"><?php echo WC()->cart->get_cart_subtotal(); ?></span> 
	</a> 
</div> 
<div class="mini_cart_content">
	<div class="mini_cart_inner">
		<div class="mini_cart_arrow"></div>
		<?php if ( ! WC()->cart->is_empty() ) : ?>

			<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
				<?php
					do_action( 'woocommerce_before_mini_cart_contents' );

					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
							$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
							$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
							?>
							<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
								
								<?php if ( ! $_product->is_visible() ) : ?>
									<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . $product_name . '&nbsp;'; ?>
								<?php else : ?>
									<a href="<?php echo esc_url( $product_permalink ); ?>" class="product-image">
										<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
									</a>
								<?php endif; ?>
								<div class="product-details">
									<a class="product-name" href="<?php echo esc_url(get_permalink( $product_id )); ?>"><?php echo ''.$product_name; ?></a>
									<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?> 
									<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">Qty: ' . sprintf( '%s', $cart_item['quantity'] ) . '</span>', $cart_item, $cart_item_key ); ?>
									<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="price-cart">' . sprintf( '%s', $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
									<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="ion-android-close"></i></a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										__( 'Remove this item', 'monsta' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									), $cart_item_key );
									?>
									
								</div> 
							</li>
							<?php
						}
					}

					do_action( 'woocommerce_mini_cart_contents' );
				?>
			</ul>

			<p class="woocommerce-mini-cart__total total"><strong><?php _e( 'Subtotal', 'monsta' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

			<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

			<p class="woocommerce-mini-cart__buttons buttons"><?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?></p>

		<?php else : ?>

			<p class="woocommerce-mini-cart__empty-message"><?php _e( 'No products in the cart.', 'monsta' ); ?></p>

		<?php endif; ?>
	</div>
	<div class="loading"></div>
</div>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
