<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_features_grid")){
	class theneeds_features_grid{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_features_grid_init"));
			add_shortcode('theneeds_features_grid',array($this,'theneeds_features_grid_shortcode'));
		}
		function theneeds_features_grid_init(){

			if(function_exists("vc_map")){
			
				/* Features Cat */
				$args = array(
					'type'                     => 'features',
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'date',
					'order'                    => 'DESC',
					'hide_empty'               => 1,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => 'features-categories',
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
					"base" => "theneeds_features_grid",
					"name" => __( "Features Grid", "js_composer" ),
					"class" => "theneeds_features_grid_class",
					"icon" => "theneeds_features_grid",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"params" => array(

							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Element Sub Title", "js_composer" ),
								"param_name" => "element_subtitle",
								"description" => __( "Enter Element Sub Title", "js_composer" )
							),
							
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Element Title", "js_composer" ),
								"param_name" => "element_title",
								"description" => __( "Enter Element Title Here", "js_composer" )
							),
							

							array(
								'type' => 'textarea',
								"holder" => "p",
								'heading' => __( 'Description', 'js_composer' ),
								'param_name' => 'content',
								'description' => __( 'Add Description For Element.', 'js_composer' ),
							),
							
							array(
								"type" => "dropdown",
								"holder" => "p",
								"heading" => __( "Category Features", "js_composer" ),
								"param_name" => "category_name",
								"value" => $categoryArray,
								"description" => __( "Select Category From The Dropdown", "js_composer" )
							),
							
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Number of Posts", "js_composer" ),
								"param_name" => "num_posts",
								"description" => __( "Enter Number of Features To Display", "js_composer" )
							),	
							
						)
					) 
				);
			}
		}
		
		
		function theneeds_features_grid_shortcode( $atts, $content = null ) {
		
			$result = shortcode_atts( array(
			
				'element_subtitle' => '',
				'element_title' => '',
				'category_name' => '',
				'num_posts' => '6',				
			
				
			), $atts );

			extract( $result );
			
			global $wpdb,$post;

			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			
			if($category_name != 'All' && !empty($category_name)){
				
				$term = '';
				
				$term = get_term_by('name', $category_name, 'features-categories');
				
				if(is_object($term)){
				
					$category_id = $term->term_id;
					
					$stack_cat_all = array('tax_query' => array(
							array(
								'taxonomy' => 'features-categories',
								'terms' => $category_id,
								'field' => 'term_id',
							)
						),
					);
					
					$args = array( 
						'post_type' => 'features',
						'posts_per_page' => $num_posts,
						'paged' 			=> $paged,
						'tax_query' => array(
							array(
								'taxonomy' => 'features-categories',
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
						'post_type' 		=> 'features',
						'post_status'       => 'publish',
						'paged' 			=> $paged,
						'posts_per_page' 	=> $num_posts,
						'orderby'		 	=> 'date',
						'order' 			=> 'ASC'
					);
				
				}
			
			}else{
			
				
				$args = array( 
					'post_type' 		=> 'features',
					'post_status'       => 'publish',
					'paged' 			=> $paged,
					'posts_per_page' 	=> $num_posts,
					'orderby'		 	=> 'date',
					'order' 			=> 'ASC'
				);
			
			}

			query_posts($args);	
			
			/* HTML Markup */
				
				$output = '
				
					<section class="welcome-section welcome-style-2">
					  <div class="element_wrap">
						<div class="row">
						  <div class="heading-style-1"> 
							<span class="title">'.$element_subtitle.'</span>
							<h2>'.$element_title.'</h2>
							<em>&#34;'.$content.'&#34;</em>
						  </div>
						  <div class="row">';
						  
							/* Loop Begins */
								if ( have_posts() ) {
								 
									while ( have_posts() ) { the_post(); global $post;
									
									$theneeds_features_detail_xml = get_post_meta($post->ID, 'theneeds_features_detail_xml', true);
									
									$features_caption = '';
									
									if($theneeds_features_detail_xml <> ''){
									
										$features_xml = new DOMDocument ();
										
										$features_xml->loadXML ( $theneeds_features_detail_xml );
										
										$features_caption = theneeds_find_xml_value($features_xml->documentElement,'features_caption');	
									}
									
									$output .='
									
									<div class="col-md-4 col-sm-6">
									  <div class="box">
										<div class="icon-col"> <i class="'.esc_attr($features_caption).'" aria-hidden="true"></i> </div>
										<div class="text-col">
										  <h4><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h4>
										  <p>'.get_the_content().'</p>
										</div>
									  </div>
									</div>';
									  
									} /* endwhile */ wp_reset_query();
								} /*endif*/
								$output .='
							</div>
						</div>
					  </div>
					</section>';

			return $output;

			wp_reset_postdata();

		} /* end of function */
		
		
	}
	
	new theneeds_features_grid;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_features_grid extends WPBakeryShortCode {
		}
	}
}