<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_features_campaign_project")){
	
	class theneeds_features_campaign_project{
		
		static $add_plugin_script;
		
		function __construct(){
			
			add_action("init",array($this,"theneeds_features_campaign_project_init"));
			
			add_shortcode('theneeds_features_campaign_project',array($this,'theneeds_features_campaign_project_shortcode'));
		}
		
		function theneeds_features_campaign_project_init(){

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
				
				/* Charity Project */
				 $charity_args = array(
					'type'                     => 'campaign',
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'date',
					'order'                    => 'DESC',
					'hide_empty'               => 1,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => 'campaign_category',
					'pad_counts'               => false 
				);
				
				$charity_categories = get_categories( $charity_args ); 				
						
				
				$charity_taxonomies = get_taxonomies();
				
				if($charity_categories){
					$charity_categoryArray[0] = "All";
					foreach($charity_categories as $charity_category_list){
						$charity_categoryArray[$charity_category_list->term_id] = $charity_category_list->name;
					}
				} else {
					$charity_categoryArray = array();
				}
				
	
				vc_map( array(
					"base" => "theneeds_features_campaign_project",
					"name" => __( "Features w/ Campaign", "js_composer" ),
					"class" => "theneeds_features_campaign_project_class",
					"icon" => "theneeds_features_campaign_project",
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
							
							array(
								'type' => 'vc_link',
								'heading' => __( 'Learn More (Link)', 'js_composer' ),
								'param_name' => 'readmore_url',
								'description' => __( 'Add Text & Link For Button.', 'js_composer' ),
							),
							
							array(
								"type" => "dropdown",
								"holder" => "p",
								"heading" => __( "Category Project", "js_composer" ),
								"param_name" => "project_category_name",
								"value" => $charity_categoryArray,
								"description" => __( "Select Project Category From The Dropdown", "js_composer" )
							),
							
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Campaign Sub Title", "js_composer" ),
								"param_name" => "campaign_subtitle",
								"description" => __( "Enter Campaign Sub Title To Display", "js_composer" )
							),	
							
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Campaign Title", "js_composer" ),
								"param_name" => "campaign_title",
								"description" => __( "Enter Campaign Title To Display", "js_composer" )
							),	
							
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Campaign Caption", "js_composer" ),
								"param_name" => "campaign_caption",
								"description" => __( "Enter Campaign Caption To Display", "js_composer" )
							),	
							
							array(
								'type' => 'attach_image',
								"holder" => "p",
								'heading' => __( 'Bg Image', 'js_composer' ),
								'param_name' => 'bg_image',
								'value' => '',
								'description' => __( 'Select Background Image For Charity Project.', 'js_composer' )
							),
							
						)
					) 
				);
			}
		}
		
		
		function theneeds_features_campaign_project_shortcode( $atts, $content = null ) {
		
			$result = shortcode_atts( array(
			
				'element_subtitle' => '',
				'element_title' => '',
				'category_name' => '',
				'num_posts' => '4',
				'readmore_url' => '',
				'project_category_name' => '',
				'bg_image' => '',
				'campaign_subtitle' => '',
				'campaign_title' => '',
				'campaign_caption' => '',
				
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
		
			
			/* Single Image */
			
			$bg_image = wpb_getImageBySize( array( 'attach_id' => $bg_image, 'thumb_size' => '100', 'class' => 'vc_single_image-img' ) );
			
			$bg_image =  $bg_image['p_img_large'][0];
			

			/* Build Link First */
			
			$readmore_url = vc_build_link( $readmore_url );

			if(!empty($readmore_url['url'])){ $readmore_url_link =  esc_url($readmore_url['url']); }else{ $readmore_url_link = ''; }

			if(!empty($readmore_url['title'])){ $readmore_text =  esc_attr($readmore_url['title']); }else{ $readmore_text = ''; }			
			
			/* HTML Markup */
				
				$output = '
				
					<section class="welcome-section">
					  <div class="container">
						<div class="row">
						  <div class="col-md-8 col-sm-7">
							<div class="heading-style-1"> <span class="title">'.$element_subtitle.'</span>
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
									  <div class="col-md-6">
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
							<a href="'.esc_url($readmore_url_link).'" class="btn-style-1">'.esc_html__('Learn More','theneeds').'<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> 
						</div>';
						
						global $wpdb,$post;

						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						
						if($project_category_name != 'All' && !empty($project_category_name)){
							
							$term = '';
							
							$term = get_term_by('name', $project_category_name, 'campaign_category');
							
							if(is_object($term)){
							
								$category_id = $term->term_id;
								
								$stack_cat_all = array('tax_query' => array(
										array(
											'taxonomy' => 'campaign_category',
											'terms' => $category_id,
											'field' => 'term_id',
										)
									),
								);
								
								$args = array( 
									'post_type' => 'campaign',
									'posts_per_page' => 1,
									'paged' 			=> $paged,
									'tax_query' => array(
										array(
											'taxonomy' => 'campaign_category',
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
									'post_type' 		=> 'campaign',
									'post_status'       => 'publish',
									'paged' 			=> $paged,
									'posts_per_page' 	=> 1,
									'orderby'		 	=> 'date',
									'order' 			=> 'DESC'
								);
							
							}
						
						}else{
						
							
							$args = array( 
								'post_type' 		=> 'campaign',
								'post_status'       => 'publish',
								'paged' 			=> $paged,
								'posts_per_page' 	=> 1,
								'orderby'		 	=> 'date',
								'order' 			=> 'DESC'
							);
						
						}
						
						
						query_posts($args);
						
						/* Loop Begins */
						if ( have_posts() ) {
						 
							while ( have_posts() ) { the_post(); global $post;
							
								/* Get Campaign Object */
								$campaign = charitable_get_current_campaign();
								
								/* Percentage Donated */
								$percentage_donated_raw = intval($campaign->get_percent_donated_raw());
								
								/* Days Left */
								$campaign_days_left = $campaign->get_time_left();
								
								/* Get Donor Count */
								$campaign_donor_count = $campaign->get_donor_count();
								
								/* Get Currency Symbol */
								//$currency_symbol = charitable_get_currency(); /* Returns USD */
		
								//$currency_symbol = Charitable_Currency::get_currency_symbol();
								$obje = Charitable_Currency::get_instance();
								$currency_symbol= $obje->get_currency_symbol();
								
								/* Initialize Variables */
								$donated_amount = $goal_amount = $needed_amount = '';
								
								/* Campaign Goal */
								$goal_amount = $campaign->sanitize_campaign_goal( $campaign->get( 'goal' ) );
								
								/* Donated Amount */
								$donated_amount = intval($campaign->get_donated_amount());
								
								/* Amount Left */
								$needed_amount = $goal_amount - $donated_amount;
						  
									$output .= '
								
									<div class="col-md-4 col-sm-5">
										<div class="welcome-donate-box" style = "background:#000 url('.esc_url($bg_image).') no-repeat left top/cover">
										  <div class="holder"> <strong class="title"><a href = "'.esc_url(get_the_permalink()).'">'.$campaign_subtitle.'</a></strong>
											<h2><a href = "'.esc_url(get_the_permalink()).'">'.$campaign_title.'</a></h2>
											<strong class="title"><a href = "'.esc_url(get_the_permalink()).'">'.$campaign_caption.'</a></strong>
											<p>'.mb_substr(strip_tags(get_the_content()), 0 , 94).'</p>
											<div class="donate-goal-box">
											  <ul>
												<li> 
													<span class="title">'.esc_html__('Goal:','theneeds').'</span>
													<strong class="amount"><sup>'.$currency_symbol.'</sup>'.esc_attr(number_format(intval($goal_amount))).'</strong> 
												</li>
												<li> 
													<span class="title">'.esc_html__('Raised:','theneeds').'</span> 
													<strong class="amount"><sup>'.$currency_symbol.'</sup>'.esc_attr($donated_amount).'</strong> 
												</li>
												<li> 
													<span class="title">'.esc_html__('Donators:','theneeds').'</span> 
													<strong class="amount">'.esc_attr($campaign_donor_count). esc_html__(' Donors','theneeds').' </strong> 
												</li>
												<li> 
													<span class="title">'.esc_html__('Time Remain:','theneeds').'</span>
													'.esc_attr($percentage_donated_raw).'
												</li>
											  </ul>
											  <div class="progress progress-bar-vertical">
												<div class="progress-bar" role="progressbar" aria-valuenow="'.esc_attr($percentage_donated_raw).'" aria-valuemin="0" aria-valuemax="100" style="height: '.esc_attr($percentage_donated_raw).'%;"> <span class="sr-only">'.esc_attr($percentage_donated_raw).'<sup>%</sup></span> </div>
											  </div>
											  <div class="btn-row">
												<a href="'.esc_url(charitable_get_permalink( 'campaign_donation_page', array( 'campaign' => $campaign ) )).'" class="btn-style-1">'.esc_html__('Donate Now','theneeds').'<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
											  </div>
											</div>
										  </div>
										</div>
									</div>';
						  
							} /* endwhile */ wp_reset_query();
						} /* endif */
						
						$output .= '  
						</div>
					  </div>
					</section>';

			return $output;

			wp_reset_postdata();

		} /* end of function */
		
		
	}
	
	new theneeds_features_campaign_project;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_features_campaign_project extends WPBakeryShortCode {
		}
	}
}