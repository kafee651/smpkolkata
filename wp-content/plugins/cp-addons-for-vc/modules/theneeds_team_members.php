<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI:  http://dev.crunchpress.com
*/
if(!class_exists("theneeds_team_members")){
	class theneeds_team_members{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_team_members_init"));
			add_shortcode('theneeds_team_members',array($this,'theneeds_team_members_shortcode'));
		}
		function theneeds_team_members_init(){

			if(function_exists("vc_map")){
				
				 $args = array(
					'type'                     => 'team',
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => 1,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => 'team-category',
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
					"base" => "theneeds_team_members",
					"name" => __( "Team Members", "js_composer" ),
					"class" => "theneeds_team_members_class",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"icon" => "theneeds_team_members_icon",
					"params" => array(
					
							array(
								"type" => "dropdown",
								"heading" => __( "Element Style", "js_composer" ),
								"param_name" => "team_styles",
								"value" =>  array( __( '3 Col', 'js_composer' ) => '3_col',
													__( 'Grid', 'js_composer' ) => 'grid',
														
													),
								"description" => __( "Select Element Style", "js_composer" )
							),
							
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Element Sub Title", "js_composer" ),
								"param_name" => "element_subtitle",
								"description" => __( "Enter Element Sub Title Here", "js_composer" )
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
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Element Caption", "js_composer" ),
								"param_name" => "element_caption",
								"description" => __( "Enter Element Caption i.e Grid", "js_composer" )
							),
							
						
							array(
								"type" => "textfield",
								"class" => "",
								"heading" => __( "Number of Team Members", "js_composer" ),
								"param_name" => "num_posts",
								"description" => __( "Enter Number of Team Members To Display", "js_composer" )
							),
							
							
							array(
								"type" => "dropdown",
								"holder" => "p",
								"heading" => __( "Categories", "js_composer" ),
								"param_name" => "category_name_about",
								"value" => $categoryArray,
								"description" => __( "Select Category To Fetch Tour Guides From", "js_composer" )
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
		
		
		function theneeds_team_members_shortcode( $atts, $content = null ) {
			

			$result = shortcode_atts( array(

				'element_title' => '',
				'element_subtitle' => '',
				'team_styles' => '3_col',
				'num_posts' => '',
				'category_name_about' => '',
				'element_caption' => '',
				'display_pagination' => '',

			), $atts );
			
			extract( $result );
			
			global $wpdb,$post;
			
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

			if($category_name_about != 'All' && !empty($category_name_about)){
				
				$term = '';
				
				$term = get_term_by('name', $category_name_about, 'team-category');
				
				if(is_object($term)){
				
					$category_id = $term->term_id;
					
					$args = array( 
						'post_type' 		=> 'team',
						'posts_per_page' 	=> $num_posts,
						'paged' 			=> $paged,
						'tax_query' => array(
							array(
								'taxonomy' => 'team-category',
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
						'post_type' 		=> 'team',
						'paged' 			=> $paged,
						'posts_per_page' 	=> $num_posts,
						'post_status'       => 'publish',
						'orderby' 			=> 'date',
						'order' 			=> 'ASC'
					);
				
				}

			}else{
				
				$args = array( 
					'post_type' 		=> 'team',
					'paged' 			=> $paged,
					'posts_per_page' 	=> $num_posts,
					'post_status'       => 'publish',
					'orderby' 			=> 'date',
					'order' 			=> 'ASC'
				);
				
			}

			query_posts($args);	
			
			
			/* 3 Column Layout */
			
			if($team_styles == '3_col'){
	
			$output = '
			
			<section class="team-style-1">
			  <div class="container">';
				
				if(!empty($element_title) || !empty($element_caption)){
					
					$output .='
					<div class="heading-style-1"> <span class="title">'.$element_subtitle.'</span>
					  <h2>'.$element_title.'</h2>
					  <em>'.$element_caption.'</em> 
					</div>';
				}
				
				$output .='
				<div class="row">';
				  
					if ( have_posts() ) {
							
						while ( have_posts() ) { the_post(); global $post;

							if(!empty($num_characters)){
								
								if (strlen(get_the_content()) > $num_characters){
									
									$team_content =  mb_substr(strip_shortcodes(get_the_content()), 0, $num_characters);
								
								}else{
									
									$team_content = htmlspecialchars_decode(strip_shortcodes(get_the_content()));
								}
							}else{
									$team_content = htmlspecialchars_decode(strip_shortcodes(get_the_content()));
							}
							
							/* Single Team Information */
								
								$team_detail_xml = get_post_meta($post->ID, 'team_detail_xml', true);
								
								if($team_detail_xml <> ''){
								
									$team_xml = new DOMDocument ();
									
									$team_xml->loadXML ( $team_detail_xml );
									$team_designation = theneeds_find_xml_value($team_xml->documentElement,'team_designation');
									$team_facebook = theneeds_find_xml_value($team_xml->documentElement,'team_facebook');
									$team_linkedin = theneeds_find_xml_value($team_xml->documentElement,'team_linkedin');
									$team_twitter = theneeds_find_xml_value($team_xml->documentElement,'team_twitter');
									$google_plus = theneeds_find_xml_value($team_xml->documentElement,'google_plus');
									$theneeds_pinterest = theneeds_find_xml_value($team_xml->documentElement,'theneeds_pinterest');
									$theneeds_youtube = theneeds_find_xml_value($team_xml->documentElement,'theneeds_youtube');
									$theneeds_instagram = theneeds_find_xml_value($team_xml->documentElement,'theneeds_instagram');
									
								}
								
								/* Facebook URl */
								if(isset($team_facebook) AND $team_facebook <> ''){
									$facebook_li = '<li><a href="'.esc_url($team_facebook).'"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>';
								}else{
									$facebook_li ='';
								}
								
								/* Twitter URl */
								if(isset($team_twitter) AND $team_twitter <> ''){
									$twitter_li = '<li><a href="'.esc_url($team_twitter).'"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>';
								}else{
									$twitter_li = '';
								}
								
								/* LinkedIn URl */
								if(isset($team_linkedin) AND $team_linkedin <> ''){
									$linkedin_li = '<li><a href="'.esc_url($team_linkedin).'"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>';
								}else{
									$linkedin_li = '';
								}
								
								/* google_plus URl */
								if(isset($google_plus) AND $google_plus <> ''){
									$google_plus = '<li><a href="'.esc_url($google_plus).'"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>';
								}else{
									$google_plus = '';
								}
								
								/* Pinterest URl */
								if(isset($theneeds_pinterest) AND $theneeds_pinterest <> ''){
									$pinterest_li = '<li><a href="'.esc_url($theneeds_pinterest).'"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>';
								}else{
									$pinterest_li ='';
								}
								
								/* Facebook URl */
								if(isset($theneeds_youtube) AND $theneeds_youtube <> ''){
									$youtube_li = '<li><a href="'.esc_url($theneeds_youtube).'"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>';
								}else{
									$youtube_li ='';
								}
				
								$output .= '
								
								<div class="col-md-4 col-sm-4">
									<div class="box">
									  <div class="team-social-box-1">
										<ul>
										 '.$google_plus.$twitter_li.$linkedin_li.$facebook_li.$pinterest_li.$youtube_li.'
										</ul>
									  </div>
									  <div class="thumb"><a href="'.get_the_permalink().'">'.get_the_post_thumbnail($post->ID, array(285,345)).'</a></div>
									  <div class="text-box">
										<h4><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
										<em class="disp">'.$team_designation.' </em> 
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
						
					}wp_reset_query();
					
					$output .= '
				  </div>
			   </div>
			</section>';

			}
			
			
			
			/* Grid Column Layout */
			
			if($team_styles == 'grid'){
	
			$output = '
			
			<section class="team-style-2">
			  <div class="container">';
				
				if(!empty($element_title) || !empty($element_caption)){
					
					$output .='
					<div class="heading-style-1"> <span class="title">'.$element_subtitle.'</span>
					  <h2>'.$element_title.'</h2>
					  <em>'.$element_caption.'</em> 
					</div>';
				}
				
				$output .='
				<div class="row">';
				  
					if ( have_posts() ) {
							
						while ( have_posts() ) { the_post(); global $post;

							if(!empty($num_characters)){
								
								if (strlen(get_the_content()) > $num_characters){
									
									$team_content =  mb_substr(strip_shortcodes(get_the_content()), 0, $num_characters);
								
								}else{
									
									$team_content = htmlspecialchars_decode(strip_shortcodes(get_the_content()));
								}
							}else{
									$team_content = htmlspecialchars_decode(strip_shortcodes(get_the_content()));
							}
							
							/* Single Team Information */
								
								$team_detail_xml = get_post_meta($post->ID, 'team_detail_xml', true);
								
								if($team_detail_xml <> ''){
								
									$team_xml = new DOMDocument ();
									
									$team_xml->loadXML ( $team_detail_xml );
									$team_designation = theneeds_find_xml_value($team_xml->documentElement,'team_designation');
									$team_facebook = theneeds_find_xml_value($team_xml->documentElement,'team_facebook');
									$team_linkedin = theneeds_find_xml_value($team_xml->documentElement,'team_linkedin');
									$team_twitter = theneeds_find_xml_value($team_xml->documentElement,'team_twitter');
									$google_plus = theneeds_find_xml_value($team_xml->documentElement,'google_plus');
									$theneeds_pinterest = theneeds_find_xml_value($team_xml->documentElement,'theneeds_pinterest');
									$theneeds_youtube = theneeds_find_xml_value($team_xml->documentElement,'theneeds_youtube');
									$theneeds_instagram = theneeds_find_xml_value($team_xml->documentElement,'theneeds_instagram');
									
								}
								
								/* Facebook URl */
								if(isset($team_facebook) AND $team_facebook <> ''){
									$facebook_li = '<li><a href="'.esc_url($team_facebook).'"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>';
								}else{
									$facebook_li ='';
								}
								
								/* Twitter URl */
								if(isset($team_twitter) AND $team_twitter <> ''){
									$twitter_li = '<li><a href="'.esc_url($team_twitter).'"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>';
								}else{
									$twitter_li = '';
								}
								
								/* LinkedIn URl */
								if(isset($team_linkedin) AND $team_linkedin <> ''){
									$linkedin_li = '<li><a href="'.esc_url($team_linkedin).'"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>';
								}else{
									$linkedin_li = '';
								}
								
								/* google_plus URl */
								if(isset($google_plus) AND $google_plus <> ''){
									$google_plus = '<li><a href="'.esc_url($google_plus).'"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>';
								}else{
									$google_plus = '';
								}
								
								/* Pinterest URl */
								if(isset($theneeds_pinterest) AND $theneeds_pinterest <> ''){
									$pinterest_li = '<li><a href="'.esc_url($theneeds_pinterest).'"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>';
								}else{
									$pinterest_li ='';
								}
								
								/* Facebook URl */
								if(isset($theneeds_youtube) AND $theneeds_youtube <> ''){
									$youtube_li = '<li><a href="'.esc_url($theneeds_youtube).'"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>';
								}else{
									$youtube_li ='';
								}
				
								$output .= '
								
								<div class="col-md-4 col-sm-4">
									<div class="box">
									  <div class="thumb"><a href="'.get_the_permalink().'">'.get_the_post_thumbnail($post->ID, array(285,345)).'</a></div>
									  <div class="text-box">
										<h4><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
										<em>'.$team_designation.'</em>
										<div class="team-social-box-2">
										  <ul>
											'.$google_plus.$twitter_li.$linkedin_li.$facebook_li.$pinterest_li.$youtube_li.'
										  </ul>
										</div>
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
						
					}wp_reset_query();
					
					$output .= '
				  </div>
			   </div>
			</section>';

			}
			
			
			

			return $output;

			wp_reset_postdata();
		} /* end of function */
	} /* end of class */
	
	new theneeds_team_members;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_team_members extends WPBakeryShortCode {
		}
	}
}