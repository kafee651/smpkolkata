<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $woocommerce_loop;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

if ( ! $related = $product->get_related( $posts_per_page ) ) {
	return;
}

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products                    = new WP_Query( $args );
$woocommerce_loop['name']    = 'related';
$woocommerce_loop['columns'] = apply_filters( 'woocommerce_related_products_columns', $columns );

if ( $related_products ) : 

	
		/* Owl Scripts */
		wp_enqueue_script( 'cp-owl', theneeds_PATH_URL.'/frontend/js/owl.carousel.min.js', false, '1.0', true);

		wp_enqueue_style('cp-owl',theneeds_PATH_URL.'/frontend/css/owl.carousel.css'); ?>
		

	<div class="shop-style-1 shop-space shop-slider">
		
		<div class="container">

			<h3><?php esc_html_e( 'Related Products', 'theneeds' ); ?></h3>
		
			<div class="owl-carousel" id="shop-slider-2">

					<?php while ( $products->have_posts() ) : $products->the_post();

					$regular_price = get_post_meta( get_the_ID(), '_regular_price', true);
					$sale_price = get_post_meta( get_the_ID(), '_sale_price', true);
					$currency = get_woocommerce_currency_symbol(); ?>

							<div class="item">
							  <div class="box">
								<div class="frame"><a href="<?php echo esc_url(get_the_permalink());?>"><?php echo get_the_post_thumbnail($products->ID, array(285,345));?></a></div>
								<div class="outer">
								  <div class="text-box">
									<h3><a href="<?php echo esc_url(get_the_permalink());?>"><?php echo esc_attr(get_the_title());?></a></h3>
									<span class="cut-price"><?php echo esc_attr($currency);?> <?php echo esc_attr($regular_price); ?> <em>/</em></span>
									 <span class="price"><?php echo esc_attr($currency);?> <?php echo esc_attr($sale_price); ?></span> 
									<a href="<?php echo esc_url(get_the_permalink());?>" class="like"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a> 
									<a href="<?php echo esc_url(get_the_permalink());?>" class="like"><i class="fa fa-heart" aria-hidden="true"></i></a> 
								 </div>
								</div>
							  </div>
							</div>

					<?php endwhile; // end of the loop. ?>
			
			</div>
		
		</div>

	</div>

<?php endif;

wp_reset_postdata();

