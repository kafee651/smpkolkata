<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_products_grid")){
	class theneeds_products_grid{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_products_grid_init"));
			add_shortcode('theneeds_products_grid',array($this,'theneeds_products_grid_shortcode'));
		}
		function theneeds_products_grid_init(){

			if(function_exists("vc_map")){
				
				 $args = array(
					'type'                     => 'product',
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'date',
					'order'                    => 'ASC',
					'hide_empty'               => 1,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => 'product_cat',
					'pad_counts'               => false 
				);
				
				$categories = get_categories( $args ); 				
						
				
				$taxonomies = get_taxonomies();
				
				if($categories){
					$categoryArray[0] = "All";
					foreach($categories as $category_list){
						$categoryArray[$category_list->term_id] = $category_list->name;
					}
				} else {
					$categoryArray = array();
				}
				
				vc_map( array(
					"base" => "theneeds_products_grid",
					"name" => __( "Product Grid", "js_composer" ),
					"class" => "theneeds_products_grid_class",
					"icon" => "theneeds_products_grid_icon",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"params" => array(
		
						array(
							"type" => "dropdown",
							"holder" => "p",
							"heading" => __( "Categories", "js_composer" ),
							"param_name" => "category_name",
							"value" => $categoryArray,
							"description" => __( "Select Category From The Dropdown", "js_composer" )
						),
						
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Products Count", "js_composer" ),
							"param_name" => "num_posts",
							"description" => __( "Enter Number of Products To Display.", "js_composer" )
						),
						
						array(
							'type' => 'checkbox',
							"holder" => "p",
							'heading' => __( 'Show Pagination', 'js_composer' ),
							'param_name' => 'show_pagination',
							'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
							'description' => __( 'Show pagination', 'js_composer' ),
						),
						
					)
				) );
			}
		}
		
		
		function theneeds_products_grid_shortcode( $atts, $content = null ) {
			
			$result = shortcode_atts( array(

				'category_name' => '',
				'num_posts' => '12',
				'show_pagination' => '',
				
				
			), $atts );
			
			extract( $result );
			
			global $wpdb,$post, $paged;

			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			
			if($category_name != 'All' && !empty($category_name)){
				
				$term = '';
				
				$term = get_term_by('name', $category_name, 'product_cat');
				
				if(is_object($term)){
				
					$category_id = $term->term_id;
					
					$stack_cat_all = array('tax_query' => array(
							array(
								'taxonomy' => 'product_cat',
								'terms' => $category_id,
								'field' => 'term_id',
							)
						),
					);
					
					$args = array( 
						'post_type' 		=> 'product',
						'posts_per_page' 	=> $num_posts,
						'paged' 			=> $paged,
						'tax_query' => array(
							array(
								'taxonomy' => 'product_cat',
								'terms' => $category_id,
								'field' => 'term_id',
							)
						), 
						'post_status'       => 'publish',
						'orderby' 			=> 'date',
						'order' 			=> 'ASC'
					);
					
				}else{
				
					$args = array( 
						'post_type' 		=> 'product',
						'post_status'       => 'publish',
						'paged' 			=> $paged,
						'posts_per_page' 	=> $num_posts,
						'orderby'		 	=> 'date',
						'order' 			=> 'ASC'
					);
				
				}
			
			}else{
			
				
				$args = array( 
					'post_type' 		=> 'product',
					'post_status'       => 'publish',
					'paged' 			=> $paged,
					'posts_per_page' 	=> $num_posts,
					'orderby'		 	=> 'date',
					'order' 			=> 'ASC'
				);
			
			}
			
			
		query_posts($args);
		
		
		$output = '
		  
		   <section class="shop-style-1 shop-space">
			  <div class="element_wrap">';
					
					if(have_posts()){
						
						while( have_posts() ){ the_post(); global $post;

							global $post,$product,$product_url,$woocommerce;
							
								$permalink_structure = get_option('permalink_structure');
								if($permalink_structure <> ''){
									$permalink_structure = '?';
								}else{
									$permalink_structure = '&';
								}
								
								$regular_price = get_post_meta($post->ID, '_regular_price', true);
								if($regular_price == ''){
									$regular_price = get_post_meta($post->ID, '_max_variation_regular_price', true);
								}
								$sale_price = get_post_meta($post->ID, '_sale_price', true);
								$sku_num = get_post_meta($post->ID, '_sku', true);
									
								if($sale_price == ''){
									$sale_price = get_post_meta($post->ID, '_min_variation_sale_price', true);
								}
								$currency = get_woocommerce_currency_symbol();
				
								
								$output .= '
								
								<div class="col-md-3 col-sm-4">
									<div class="box">
									  <div class="frame"><a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail($post->ID, array(290,300)).'</a></div>
									  <div class="outer">
										<div class="text-box">
										  <h3><a href="'.esc_url(get_the_permalink()).'">'.esc_attr(get_the_title()).'</a></h3>
										  <span class="cut-price">'.$currency.$regular_price.' <em>/</em> </span> 
										  <span class="price">'.$currency.$sale_price.'</span> 
										  <a href="'.esc_url(get_the_permalink()).'" class="like"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a> 
										  <a href="'.esc_url(get_the_permalink()).'" class="like"><i class="fa fa-heart" aria-hidden="true"></i></a> 
										</div>
									  </div>
									</div>
								</div>';

						} /* endwhile */  

							/* 1 2 3 Pagination */
							if($show_pagination == 'yes'){
							
								$output .= '
										<div class="pagination-box">
											<nav>
												<ul class="pagination">
													<li>'.
														theneeds_pagination().'
													</li>
												</ul>
											</nav>
										</div>';
							}
							
					} /* endif */ wp_reset_query();	

					$output .= '
			</div>
		</section>';
				
		return $output;
				

		} /* OutPut Function Ends Here */
		
		
	} /* class ends here */
	
	new theneeds_products_grid;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_products_grid extends WPBakeryShortCode {
		}
	}
}