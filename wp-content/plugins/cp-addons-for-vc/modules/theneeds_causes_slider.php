<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_causes_slider")){
	class theneeds_causes_slider{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_causes_slider_init"));
			add_shortcode('theneeds_causes_slider',array($this,'theneeds_causes_slider_shortcode'));
		}
		function theneeds_causes_slider_init(){

			if(function_exists("vc_map")){
				
				 $args = array(
					'type'                     => 'ignition_product',
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'date',
					'order'                    => 'DESC',
					'hide_empty'               => 1,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => 'project_category',
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
					"base" => "theneeds_causes_slider",
					"name" => __( "Causes Slider", "js_composer" ),
					"class" => "theneeds_causes_slider_class",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"icon" => "theneeds_causes_slider_news_full",
					"params" => array(
					
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Enter Sub Title", "js_composer" ),
							"param_name" => "element_subtitle",
							"description" => __( "Enter Sub Title Here For Element", "js_composer" )
						),
					
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Enter Title", "js_composer" ),
							"param_name" => "element_title",
							"description" => __( "Enter Title Here For Element", "js_composer" )
						),
						
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Enter Caption", "js_composer" ),
							"param_name" => "element_caption",
							"description" => __( "Enter Caption Here For Element", "js_composer" )
						),

						array(
							"type" => "dropdown",
							"holder" => "p",
							"heading" => __( "Categories", "js_composer" ),
							"param_name" => "category_name",
							"value" => $categoryArray,
							"description" => __( "Select Category From The Dropdown", "js_composer" )
						),
						
						array(
								'type' => 'vc_link',
								"holder" => "p",
								'heading' => __( 'View All Causes (Link)', 'js_composer' ),
								'param_name' => 'readmore_url',
								'description' => __( 'Add Text & Link For Button.', 'js_composer' ),
						),
	
					)
				) );
			}
		}
		
		
		function theneeds_causes_slider_shortcode( $atts, $content = null ) {
			
			$result = shortcode_atts( array(

				'element_subtitle' => '',
				'element_title' => '',
				'element_caption' => '',
				'category_name' => '',
				'readmore_url' => '',
	
			), $atts );
			
			extract( $result );

			global $wpdb,$post;

			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			
			if($category_name != 'All' && !empty($category_name)){
				
				$term = '';
				
				$term = get_term_by('name', $category_name, 'project-category');
				
				if(is_object($term)){
				
					$category_id = $term->term_id;
					
					$stack_cat_all = array('tax_query' => array(
							array(
								'taxonomy' => 'project-category',
								'terms' => $category_id,
								'field' => 'term_id',
							)
						),
					);
					
					$args = array( 
						'post_type' => 'ignition_product',
						'posts_per_page' => $num_posts,
						'paged' 			=> $paged,
						'tax_query' => array(
							array(
								'taxonomy' => 'project-category',
								'terms' => $category_id,
								'field' => 'term_id',
							)
						), 
						'post_status'       => 'publish',
						'orderby' 			=> 'date',
						'order' 			=> 'DESC'
					);
					
				}else{
				
					$args = array( 
						'post_type' 		=> 'ignition_product',
						'post_status'       => 'publish',
						'paged' 			=> $paged,
						'posts_per_page' 	=> $num_posts,
						'orderby'		 	=> 'date',
						'order' 			=> 'DESC'
					);
				
				}
			
			}else{
			
				
				$args = array( 
					'post_type' 		=> 'ignition_product',
					'post_status'       => 'publish',
					'paged' 			=> $paged,
					'posts_per_page' 	=> $num_posts,
					'orderby'		 	=> 'date',
					'order' 			=> 'DESC'
				);
			
			}
			
			
			query_posts($args);
			
			
			$output = '';
			
			/* Pie Chart */ 
			wp_enqueue_script( 'cp-piechart', theneeds_PATH_URL.'/frontend/js/pie-chart.js', false, '1.0', true); 

			/* Owl Scripts */
			wp_enqueue_script('cp-owl', theneeds_PATH_URL.'/frontend/js/owl.carousel.min.js', false, '1.0', true);

			wp_enqueue_style('cp-owl',theneeds_PATH_URL.'/frontend/css/owl.carousel.css');
			
			/* Build Link First */
			
			$readmore_url = vc_build_link( $readmore_url );

			if(!empty($readmore_url['url'])){ $readmore_url_link =  esc_url($readmore_url['url']); }else{ $readmore_url_link = ''; }

			if(!empty($readmore_url['title'])){ $readmore_text =  esc_attr($readmore_url['title']); }else{ $readmore_text = ''; }
			
			$output = '
			
				<section class="causes-style-1">
				  <div class="element_wrap">
					<div class="heading-style-1"> 
						<span class="title">'.$element_subtitle.'</span>
						<h2>'.$element_subtitle.'</h2>
						<em>'.$element_caption.'</em> 
					</div>
					<div id="causes-slider" class="owl-carousel">';

					/* Loop Begins */
						if ( have_posts() ) {
						 
							while ( have_posts() ) { the_post(); global $post;
							
								/* Check If IgnitionDeck Exists */
								if(class_exists("Deck")){
								
									$theneeds_features_detail_xml = get_post_meta($post->ID, 'ignition_detail_xml', true);
										
									$projects_address = '';
									
									if($theneeds_features_detail_xml <> ''){
									
										$features_xml = new DOMDocument ();
										
										$features_xml->loadXML ( $theneeds_features_detail_xml );
										
										$projects_address = theneeds_find_xml_value($features_xml->documentElement,'projects_address');	
									}
			
									/* Ignition Project Goal */
									$theneeds_ign_fund_goal = get_post_meta($post->ID, 'ign_fund_goal', true);

									/* Ignition Project Meta Details */
										$theneeds_ign_project_id = get_post_meta($post->ID, 'ign_project_id', true);
									
									/* Get Currency Code */
										$currency_code = '';
										$theneeds_project = new ID_Project($theneeds_ign_project_id);
										$currency_code = $theneeds_project->currency_code();
								
									/* Pledge Counter */
									
										$theneeds_getPledge = array();
										$theneeds_getPledge = theneeds_getPledge_cp($theneeds_ign_project_id);
										
									/* Raised Amount */
										
										$theneeds_raised = '';
										$theneeds_raised = apply_filters('id_funds_raised', $theneeds_project->get_project_raised(), $theneeds_project->get_project_postid());
									
									/* Remove Currency Symbol from Raised Amount */
										$theneeds_raised = str_replace($currency_code,'',$theneeds_raised);
										
									/* Ignition Date Settings */
										$theneeds_ignition_date = get_post_meta($post->ID, 'ign_fund_end', true);
										$theneeds_ignition_datee = date('d-m-Y h:i:s',strtotime($theneeds_ignition_date));
										$theneeds_current_date = date('d-m-Y h:i:s');
										$theneeds_project_date = new DateTime($theneeds_ignition_datee);
										$theneeds_current = new DateTime($theneeds_current_date);
										$theneeds_days = round(($theneeds_project_date->format('U') - $theneeds_current->format('U')) / (60*60*24));
										
									/* Array For Tags */
									$tagArray = array();
									
									/* Project tags */
									$tags = get_the_terms( $post->ID, 'post_tag' );
										
									if(!empty($tags)){
										
										foreach ( $tags as $tag ) {
			
											$tagArray[] =  '<a href="'.get_tag_link($tag->term_id).'" class="link">'.esc_attr($tag->name).',</a>';
										}
										
										$tags_list = implode(' ',$tagArray);
									}
									

									$output .= '
									
									<div class="item">
										<div class="box">
										  <div class="frame"><a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail($post->ID, array(360,220)).'</a></div>
										  <div class="text-box">
											<h3>'.get_the_title().'</h3>
											<div class="btn-row"> 
												<a href="'.esc_url(get_the_permalink()).'" class="link"><i class="fa fa-user" aria-hidden="true"></i>'.get_the_author().'</a> 
												<a href="'.esc_url(get_the_permalink()).'" class="link"><i class="fa fa-clock-o" aria-hidden="true"></i>'.get_the_date().'</a> 
												
												
												<a href="'.esc_url(get_the_permalink()).'" class="link"><i class="fa fa-map-marker" aria-hidden="true"></i>'.$projects_address.'</a> 
											</div>
											<div class="causes-goal-box">
											  <ul>
												<li> 
													<span class="title">'.esc_html__('Goal:','theneeds').'</span> 
													<strong class="amount"><sup>'.$currency_code.'</sup>'.esc_attr(number_format(intval($theneeds_ign_fund_goal))).'</strong> 
												</li>
												<li>
													<span class="title">'.esc_html__('Raised:','theneeds').'</span> 
													<strong class="amount"><sup>'.$currency_code.'</sup>'.esc_attr($theneeds_raised).'</strong> 
												</li>
												<li> 
													<span class="title">'.esc_html__('Donators:','theneeds').'</span> 
													<strong class="amount">'.esc_attr($theneeds_getPledge[0]->p_number). esc_html__(' Donors','theneeds').'</strong>
												</li>
												<li> 
													<span class="title">'.esc_html__('Time Remain:','theneeds').'</span> ';
													
													/* Remaining Days */
													if($theneeds_days < 0){
														$output .= '<strong class="amount">'.esc_html__('0 Days Left','theneeds').'</strong>'; 
													}else{
														$output .= '<strong class="amount">'.esc_attr($theneeds_days). esc_html__(' Days Left','theneeds').'</strong>';
													}
													$output .= '	
												</li>
											  </ul>
											  <div class="pie-title-center demo-pie-1" data-percent="'.esc_attr(theneeds_getPercentRaised_cp($theneeds_ign_project_id)).'"> 
											  <span class="pie-value"></span><b>'.esc_html__('Completed','theneeds').'</b> 
											</div>
											</div>
											<a href="'.theneeds_getPurchaseURLfromType($theneeds_ign_project_id, "purchaseform").'" class="btn-style-1">'.esc_html__('Donate Now','theneeds').'<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> 
										  </div>
										</div>
									</div>';
								
								}else{ /* If IgnitionDeck Not Exists */
								
									$output .= '
									
									<div class="item">
										<div class="box">
										  <div class="text-box">
											<h3>'.esc_html__('Please Install/Activate IgnitionDeck Plugin','theneeds').'</h3>
										  </div>
										</div>
									</div>';
									
								}

							} /* endwhile */ wp_reset_query();
		
						} 	 /* endif have post */
						
						$output .= '
					
					</div>';
					if(!empty($readmore_url_link) && !empty($readmore_text)) {
						
						$output .= '
						<div class="btn-row">
							<a href="'.esc_url($readmore_url_link).'" class="btn-style-2">'.esc_attr($readmore_text).'<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
						</div>';
					}
					$output .= '
				  </div>
				</section>';
				
			
			return $output;
				
			wp_reset_postdata();
					

		} /* OutPut Function Ends Here */
		
		
	} /* class ends here */
	
	new theneeds_causes_slider;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_causes_slider extends WPBakeryShortCode {
		}
	}
}