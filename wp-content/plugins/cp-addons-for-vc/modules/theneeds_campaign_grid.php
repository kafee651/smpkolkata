<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_campaign_grid")){
	class theneeds_campaign_grid{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_campaign_grid_init"));
			add_shortcode('theneeds_campaign_grid',array($this,'theneeds_campaign_grid_shortcode'));
		}
		function theneeds_campaign_grid_init(){

			if(function_exists("vc_map")){
				
				 $args = array(
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
					"base" => "theneeds_campaign_grid",
					"name" => __( "Campaign Grid", "js_composer" ),
					"class" => "theneeds_campaign_grid_class",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"icon" => "theneeds_campaign_grid_news_full",
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
							"heading" => __( "Number Of Campaigns", "js_composer" ),
							"param_name" => "num_posts",
							"description" => __( "Enter Number Of Campaigns To Display", "js_composer" )
						),
						
						array(
							'type' => 'checkbox',
							"holder" => "p",
							'heading' => __( 'Display Pagination', 'js_composer' ),
							'param_name' => 'display_pagination',
							'value' => array( __( 'Yes, Please', 'js_composer' ) => 'yes' ),
							'description' => __( 'Display Pagination At The End of Section', 'js_composer' ),
						),
	
					)
				) );
			}
		}
		
		
		function theneeds_campaign_grid_shortcode( $atts, $content = null ) {
			
			$result = shortcode_atts( array(

				'category_name' => '',
				'num_posts' => '',
				'display_pagination' => '',
	
			), $atts );
			
			extract( $result );

			global $wpdb,$post;

			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			
			if($category_name != 'All' && !empty($category_name)){
				
				$term = '';
				
				$term = get_term_by('name', $category_name, 'campaign_category');
				
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
						'posts_per_page' => $num_posts,
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
						'posts_per_page' 	=> $num_posts,
						'orderby'		 	=> 'date',
						'order' 			=> 'DESC'
					);
				
				}
			
			}else{
			
				
				$args = array( 
					'post_type' 		=> 'campaign',
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

	
			
			$output = '
			
				<section class="causes-style-1 causes-grid">
				  <div class="element_wrap">
					<div class="row">';

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
								$currency_symbol = Charitable_Currency::get_currency_symbol();
								
								/* Initialize Variables */
								$donated_amount = $goal_amount = $needed_amount = '';
								
								/* Campaign Goal */
								$goal_amount = $campaign->sanitize_campaign_goal( $campaign->get( 'goal' ) );
								
								/* Donated Amount */
								$donated_amount = intval($campaign->get_donated_amount());
								
								/* Amount Left */
								$needed_amount = $goal_amount - $donated_amount;
								

								$output .= '
								
									<div class="col-md-4 col-sm-6">
										<div class="box">
										  <div class="frame"><a href="'.esc_url(get_the_permalink()).'">'.get_the_post_thumbnail($post->ID, array(360,220)).'</a></div>
										  <div class="text-box">
											<h3>'.get_the_title().'</h3>
											<div class="btn-row"> 
												<a href="'.esc_url(get_the_permalink()).'" class="link"><i class="fa fa-user" aria-hidden="true"></i>'.get_the_author().'</a> 
												<a href="'.esc_url(get_the_permalink()).'" class="link"><i class="fa fa-clock-o" aria-hidden="true"></i>'.get_the_date().'</a> 
											</div>
											<div class="causes-goal-box">
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
														<strong class="amount">'.esc_attr($campaign_donor_count). esc_html__(' Donors','theneeds').'</strong>
													</li>
													<li> 
														<span class="title">'.esc_html__('Time Remain:','theneeds').'</span>
														'.html_entity_decode($campaign_days_left).'
													</li>
												</ul>
												<div class="pie-title-center demo-pie-1" data-percent="'.esc_attr($percentage_donated_raw).'"> 
													<span class="pie-value"></span><b>'.esc_html__('Completed','theneeds').'</b> 
												</div>
											</div>
											<a href="'.esc_url(charitable_get_permalink( 'campaign_donation_page', array( 'campaign' => $campaign ) )).'" class="btn-style-1">'.esc_html__('Donate Now','theneeds').'<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> 
											</div>
										</div>
									</div>';
									
							} /* endwhile */ 
							
							if($display_pagination == 'yes'){
								
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
		
						} 	 /* endif have post */ wp_reset_query();
						
						$output .= '
					
					</div>';
					
					$output .= '
				  </div>
				</section>';
				
			
			return $output;
				
			wp_reset_postdata();
					

		} /* OutPut Function Ends Here */
		
		
	} /* class ends here */
	
	new theneeds_campaign_grid;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_campaign_grid extends WPBakeryShortCode {
		}
	}
}