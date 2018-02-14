<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_testimonials_slider")){
	class theneeds_testimonials_slider{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_testimonials_slider_init"));
			add_shortcode('theneeds_testimonials_slider',array($this,'theneeds_testimonials_slider_shortcode'));
		}
		function theneeds_testimonials_slider_init(){

			if(function_exists("vc_map")){
				
				 $args = array(
					'type'                     => 'testimonial',
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'date',
					'order'                    => 'DESC',
					'hide_empty'               => 1,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => 'testimonial-category',
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
					"base" => "theneeds_testimonials_slider",
					"name" => __( "Testimonials Slider", "js_composer" ),
					"class" => "theneeds_testimonials_slider_class",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"icon" => "theneeds_testimonials_slider_icon",
					"params" => array(
					
						array(
								"type" => "dropdown",
								"heading" => __( "Element Style", "js_composer" ),
								"param_name" => "testi_styles",
								"value" =>  array( __( 'Vertical Slide', 'js_composer' ) => 'vertical',
													__( 'Vertical Slide 2', 'js_composer' ) => 'vertical2',
													__( 'Dual Slides', 'js_composer' ) => 'dual',
														
													),
								"description" => __( "Select Element Style", "js_composer" )
							),

						
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Enter Element Title", "js_composer" ),
							"param_name" => "element_title",
							"description" => __( "Enter Element Title To Display", "js_composer" )
						),
						
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Number Of Testimonials", "js_composer" ),
							"param_name" => "num_posts",
							"description" => __( "Enter Number Of Testimonials To Display", "js_composer" )
						),
							
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Excerpt Length", "js_composer" ),
							"param_name" => "num_characters",
							"description" => __( "Enter Number of Excerpt Length", "js_composer" )
						),
						
						array(
							"type" => "dropdown",
							"holder" => "p",
							"heading" => __( "Categories", "js_composer" ),
							"param_name" => "category_name",
							"value" => $categoryArray,
							"description" => __( "Select Category To Fetch Testimonials From", "js_composer" )
						),
						
						array(
								'type' => 'attach_image',
								"holder" => "p",
								'heading' => __( 'Background Image', 'js_composer' ),
								'param_name' => 'bg_image',
								'value' => '',
								'description' => __( 'Select Background Image For Element.', 'js_composer' )
						),
	
					)
				) );
			}
		}
		
		
		function theneeds_testimonials_slider_shortcode( $atts, $content = null ) {
		
			$result = shortcode_atts( array(

				'element_title' => '',
				'num_posts' => '',
				'num_characters' => '307',
				'category_name' => '',
				'bg_image' => '',
				'testi_styles' => 'vertical',
				

			), $atts );
			
			extract( $result );
			

			global $wpdb,$post;
			
			$args = array();
			$category_id = 0;
			

			if($category_name != 'All' && !empty($category_name)){
				
				$term = '';
				
				$term = get_term_by('name', $category_name, 'testimonial-category');
				
				if(is_object($term)){
				
					$category_id = $term->term_id;
					
					$args = array( 
						'post_type' 		=> 'testimonial',
						'posts_per_page' 	=> $num_posts,
						'tax_query' => array(
							array(
								'taxonomy' 	=> 'testimonial-category',
								'terms' 	=> $category_id,
								'field' 	=> 'term_id',
							)
						), 
						'post_status'      	=> 'publish',
						'orderby' 			=> 'date',
						'order' 			=> 'ASC'
					);
				
				}else{
					
					$args = array( 
						'post_type' 		=> 'testimonial',
						'post_status'       => 'publish',
						'posts_per_page' 	=> $num_posts,
						'orderby' 			=> 'date',
						'order' 			=> 'ASC'
					);
				}
			
			}else{
			
				$args = array( 
					'post_type' 		=> 'testimonial',
					'post_status'       => 'publish',
					'posts_per_page' 	=> $num_posts,
					'orderby' 			=> 'date',
					'order' 			=> 'ASC'
				);
			
			
			}
			
			query_posts($args);	
			
			if($testi_styles == "vertical"){
				
				/* Bx Slider Script and CSS file  */
			
				wp_enqueue_style('cp-bx-slider',theneeds_PATH_URL.'/frontend/css/jquery.bxslider.css');
				
				wp_enqueue_script( 'cp-bx-slider', theneeds_PATH_URL.'/frontend/js/jquery.bxslider.min.js', false, '1.0', true);
				
				/* Single Image */
				if(!empty($bg_image)){
				
					$bg_image = wpb_getImageBySize( array( 'attach_id' => $bg_image, 'thumb_size' => '100', 'class' => 'vc_single_image-img' ) );
					
					$bg_image =  $bg_image['p_img_large'][0];
				
				}else{
					
					$bg_image = '';
				}
				
	
				$output = '
				
				<section class="testimonial-style-2">
					  <div class="element_wrap">
						<div class="holder" style = "background: url('.esc_url($bg_image).') no-repeat left top/cover;">
						  <h2>'.$element_title.'</h2>
						  <div id="testimonial-2">';
						  
							if ( have_posts() ) {
		
								while ( have_posts() ) { the_post(); global $post;
								
									$designation_text = get_post_meta($post->ID, 'designation_text', true);
									
									if(!empty($num_characters)){
										
										if (strlen(get_the_content()) > $num_characters){
											
											$testimonial_content = mb_substr(get_the_content(), 0, $num_characters);
										
										}else{
											
											$testimonial_content = htmlspecialchars_decode(get_the_content());
										
										}
									
									}else{
										
										$testimonial_content = htmlspecialchars_decode(get_the_content());
									}
							
									$output .= '
									
										<div class="slide">
										  <div class="clearfix"> 
											<em>'.strip_tags($testimonial_content).'</em>
											<div class="btn-row">
											  <div class="thumb">'.get_the_post_thumbnail($post->ID, array(100,100)).'</div>
											  <div class="holde">
												<h4>'.get_the_title().'</h4>
												<span class="disp">'.$designation_text.'</span> </div>
											</div>
										  </div>
										</div>';
										
								} wp_reset_query(); /* endwhile */
							}
		
							$output .= '
						</div>
					  </div>
				  </div>
				</section>';
				
			}
			
			if($testi_styles == "vertical2"){
				
				/* Bx Slider Script and CSS file  */
			
				wp_enqueue_style('cp-bx-slider',theneeds_PATH_URL.'/frontend/css/jquery.bxslider.css');
				
				wp_enqueue_script( 'cp-bx-slider', theneeds_PATH_URL.'/frontend/js/jquery.bxslider.min.js', false, '1.0', true);
				
				/* Single Image */
				
				if(!empty($bg_image)){
				
				$bg_image = wpb_getImageBySize( array( 'attach_id' => $bg_image, 'thumb_size' => '100', 'class' => 'vc_single_image-img' ) );
				
				$bg_image =  $bg_image['p_img_large'][0];
				
				}else{
				
					$bg_image = '';
				}
				
	
				$output = '
				
				<section class="testimonial-style-2 testimonial-space-3 testimonial-bg">
				  <div class="element_wrap">
					<div class="holder" style = "background: url('.esc_url($bg_image).') no-repeat left top/cover;">
					  <div id="testimonial-2">';
						  
							if ( have_posts() ) {
		
								while ( have_posts() ) { the_post(); global $post;
								
									$designation_text = get_post_meta($post->ID, 'designation_text', true);
									
									if(!empty($num_characters)){
										
										if (strlen(get_the_content()) > $num_characters){
											
											$testimonial_content = mb_substr(get_the_content(), 0, $num_characters);
										
										}else{
											
											$testimonial_content = htmlspecialchars_decode(get_the_content());
										
										}
									
									}else{
										
										$testimonial_content = htmlspecialchars_decode(get_the_content());
									}
							
									$output .= '
									
										<div class="slide">
										  <div class="clearfix"> 
										  <em>'.strip_tags($testimonial_content).'</em>
											<div class="btn-row">
											  <div class="thumb">'.get_the_post_thumbnail($post->ID, array(100,100)).'</div>
											  <div class="holde">
												<h4>'.get_the_title().' </h4>
												<span class="disp">'.$designation_text.'</span> 
											  </div>
											</div>
										  </div>
										</div>';
		
								} wp_reset_query(); /* endwhile */
							}
		
							$output .= '
						</div>
					  </div>
				  </div>
				</section>';
				
			}
			
			if($testi_styles == "dual"){
				
				/* Owl Scripts */
				wp_enqueue_script( 'cp-owl', theneeds_PATH_URL.'/frontend/js/owl.carousel.min.js', false, '1.0', true);

				wp_enqueue_style('cp-owl',theneeds_PATH_URL.'/frontend/css/owl.carousel.css');
				
				/* Single Image */
				if(!empty($bg_image)){
				
					$bg_image = wpb_getImageBySize( array( 'attach_id' => $bg_image, 'thumb_size' => '100', 'class' => 'vc_single_image-img' ) );
					
					$bg_image =  $bg_image['p_img_large'][0];
				
				}else{
				
					$bg_image = '';
				}
				

				$output = '
				
				<section class="testimonial-style-3">
				  <div class="element_wrap">
					<div class="owl-carousel" id="testimonial-3">';
						  
							if ( have_posts() ) {
		
								while ( have_posts() ) { the_post(); global $post;
								
									$designation_text = get_post_meta($post->ID, 'designation_text', true);
									
									if(!empty($num_characters)){
										
										if (strlen(get_the_content()) > $num_characters){
											
											$testimonial_content = mb_substr(get_the_content(), 0, $num_characters);
										
										}else{
											
											$testimonial_content = htmlspecialchars_decode(get_the_content());
										
										}
									
									}else{
										
										$testimonial_content = htmlspecialchars_decode(get_the_content());
									}
							
									$output .= '
									
									<div class="item">
										<div class="testimonial-style-3-box testimonial-style-3-box-bg" style = "background: url('.esc_url($bg_image).') no-repeat left top/cover;">
										<em>'.strip_tags($testimonial_content).'</em>
										  <div class="btn-row">
											<div class="thumb">'.get_the_post_thumbnail($post->ID, array(100,100)).'</div>
											<div class="holde">
											  <h4>'.get_the_title().'</h4>
											  <span class="disp">'.$designation_text.'</span> 
											</div>
										  </div>
										</div>
									</div>';
									
										
								} wp_reset_query(); /* endwhile */
							}
		
							$output .= '
					</div>
				  </div>
				</section>';
				
			}

				
			return $output;
		
			wp_reset_postdata();
		} /* end of function */
	} /* end of class */
	
	new theneeds_testimonials_slider;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_testimonials_slider extends WPBakeryShortCode {
		}
	}
}