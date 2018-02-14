<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_testimonials_contactform")){
	class theneeds_testimonials_contactform{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_testimonials_contactform_init"));
			add_shortcode('theneeds_testimonials_contactform',array($this,'theneeds_testimonials_contactform_shortcode'));
		}
		function theneeds_testimonials_contactform_init(){

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
					"base" => "theneeds_testimonials_contactform",
					"name" => __( "Testimonials w/ Form", "js_composer" ),
					"class" => "theneeds_testimonials_contactform_class",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"icon" => "theneeds_testimonials_contactform_icon",
					"params" => array(

						array(
							"type" => "dropdown",
							"holder" => "p",
							"heading" => __( "Testimonials Style", "js_composer" ),
							"param_name" => "testimonials_list_styles",
							"value" =>  array( __( 'Half Slider', 'js_composer' ) => 'half_slider',
												__( 'Full Slider', 'js_composer' ) => 'full_slider',
												__( 'Two Half Slides', 'js_composer' ) => '2_half_slider'
											),
							"description" => __( "Select Testimonials Element Style", "js_composer" )
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
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Add Contact Form Title", "js_composer" ),
							"param_name" => "form_title",
							"description" => __( "Enter Contact Form Title Here", "js_composer" )
						),
						
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Add Contact Form Caption", "js_composer" ),
							"param_name" => "form_caption",
							"description" => __( "Enter Form Caption Here", "js_composer" )
						),
						
						array(
							"type" => "textarea_html",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Add Contact Form 7 Shortcode Here", "js_composer" ),
							"param_name" => "content",
							"description" => __( "Add Contact Form 7 Shortcode Here", "js_composer" )
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
		
		
		function theneeds_testimonials_contactform_shortcode( $atts, $content = null ) {
		
			$result = shortcode_atts( array(

				'element_title' => '',
				'num_posts' => '',
				'testimonials_list_styles' => 'half_slider',
				'num_characters' => '',
				'category_name' => '',
				'element_caption' => '',
				'form_title' => '',
				'form_caption' => '',
				'bg_image' => '',

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
			
			if($testimonials_list_styles == 'half_slider'){
			
	
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
			
			 <section class="testimonial-style-1">
			  <div class="holder" style = "background: url('.esc_url($bg_image).') no-repeat left top/cover;">
					<div id="testimonial-1" class="owl-carousel">';
					  
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
									<div class="left-box"> 
										<strong class="title">'.$element_title.'</strong>
										<em>'.strip_tags($testimonial_content).'</em>
									  <div class="thumb">'.get_the_post_thumbnail($post->ID, array(100,100)).'</div>
									  <div class="holde">
										<h4>'.get_the_title().'</h4>
										<span class="name"><em>'.$designation_text.'</em></span>
									  </div>
									</div>
								  </div>';
								
							} wp_reset_query(); /* endwhile */
						}
	
						$output .= '
					</div>
					<div class="join-form">
					  <div class="heading-style-1">
						<h2>'.$form_title.'</h2>
						<em>'.$form_caption.'</em> 
					  </div>
					  '.do_shortcode($content).'
					</div>
			  </div>
			</section>';
			
			}
			
			
			if($testimonials_list_styles == 'full_slider'){
			
	
			/* Bx Slider Script and CSS file  */
		
			wp_enqueue_style('cp-bx-slider',theneeds_PATH_URL.'/frontend/css/jquery.bxslider.css');
			
			wp_enqueue_script( 'cp-bx-slider', theneeds_PATH_URL.'/frontend/js/jquery.bxslider.min.js', false, '1.0', true);
			
			if($title_style == 'left'){
				
				$add_custom_class = 'testo-page';
			
			}else{
				
				$add_custom_class = '';
			}
			
			
			$output = '
			
			<section class="testimonials-style-2 '.$add_custom_class.'">
			  <div class="element_wrapper">';
			  
				if( $title_style == 'center' && !empty($element_title)){
				  
				  $output .= '
					
					<div class="heading-center">
					  <h2>'.$element_title.'</h2>
					</div>';
				}
				
				if( $title_style == 'left' && !empty($element_title)){
				  
				  $output .= '
					
					<div class = "container">
						<div class="heading-left">
						  <h2>'.$element_title.'</h2>
						</div>
					</div>';
				}
					
					
				if(!empty($element_caption)){
				  
				  $output .= '<p><em>'.$element_caption.'</em></p>';
				}
				
			$output .= '	
			  </div>
			  <div class="holder">
				<div class="container">
				  <ul class="bxslider">';
					  
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
								
								$instagram_testi = '';
								$behance_testi ='';
								$google_plus_testi  = '';
								$twitter_testi = '';
								$linkedin_testi = '';
								$facebook_testi = '';
								
								/* Social links */
								$instagram_testi = get_post_meta($post->ID, 'instagram_testi', true);
								$behance_testi = get_post_meta($post->ID, 'behance_testi', true);
								$google_plus_testi = get_post_meta($post->ID, 'google_plus_testi', true);
								$twitter_testi = get_post_meta($post->ID, 'twitter_testi', true);
								$linkedin_testi = get_post_meta($post->ID, 'linkedin_testi', true);
								$facebook_testi = get_post_meta($post->ID, 'facebook_testi', true);
						
								$output .= '
								
								<li>
								  <div class="row">
									<div class="col-md-4 col-sm-4">
									  <div class="frame">'.get_the_post_thumbnail($post->ID, array(360,425)).'</div>
									</div>
									<div class="col-md-8 col-sm-8">
									  <div class="text-box">
										<h4><a>'.get_the_title().'</a></h4>
										<span>'.$designation_text.'</span> <em>'.$testimonial_content.'</em>
										<div class="testimonials-style-2-social">
										  <ul>';
											/* Social Links */
												if(!empty($instagram_testi)){
													$output .= '<li><a href="'.esc_url($instagram_testi).'"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>';
												} 
												if(!empty($behance_testi)){
													$output .= '<li><a href="'.esc_url($behance_testi).'"><i class="fa fa-behance" aria-hidden="true"></i></a></li>';
												}
												if(!empty($google_plus_testi)){
													$output .= '<li><a href="'.esc_url($google_plus_testi).'"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>';
												}
												if(!empty($twitter_testi)){
													$output .= '<li><a href="'.esc_url($twitter_testi).'"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>';
												}
												if(!empty($linkedin_testi)){
													$output .= '<li><a href="'.esc_url($linkedin_testi).'"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>';
												}
												if(!empty($facebook_testi)){
													$output .= '<li><a href="'.esc_url($facebook_testi).'"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>';
												}	
													
											$output .= '	
										  </ul>
										</div>
									  </div>
									</div>
								  </div>
								</li>';
			
							} 
						}
	
						$output .= '
					  
					  </ul>
					  
					  <div id="bx-pager">';
						
						/* Bx Pager */
						if ( have_posts() ) {
	
							while ( have_posts() ) { the_post(); global $post;

								static $counter = 0;
		
								$designation_text = get_post_meta($post->ID, 'designation_text', true);
								
								$output .= '<a data-slide-index="'.$counter.'" href="">'.get_the_post_thumbnail($post->ID, array(68,68)).'</a>';
			
								$counter++;	
	
							} wp_reset_query(); /*endwhile */
					
						} /* endif */
	
					  
						
						$output .= '
					
					  </div>
				</div>
			  </div>
			</section>';
			
			}
			
			if($testimonials_list_styles == '2_half_slider'){
			
			/* Owl Scripts */
			wp_enqueue_script( 'cp-owl', theneeds_PATH_URL.'/frontend/js/owl.carousel.min.js', false, '1.0', true);

			wp_enqueue_style('cp-owl',theneeds_PATH_URL.'/frontend/css/owl.carousel.css');
			
			
			$output = '
			
			<section class="testimonials-team-section testo-page">
			  <div class="element_wrap">
				<div class="col-md-12">';
				
				if(!empty($element_title)){
				 
				 $output .= '
					 <div class="heading-left">
						<h2>'.$element_title.'</h2>
					  </div>';
				}
				  
				$output .= '
				  <div class="testimonials-outer">
					<div id="testimonials-01" class="owl-carousel owl-theme">';
					  
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
									<div class="testimonials-style-1"> <i class="fa fa-quote-left" aria-hidden="true"></i> 
									<em>'.strip_tags($testimonial_content).'</em>
									  <div class="thumb">'.get_the_post_thumbnail($post->ID, array(80,80)).'</div>
									  <div class="text-col"> <strong class="name">'.get_the_title().'</strong> <span>'.$designation_text.'</span> </div>
									</div>
								</div>';
	
							
							} wp_reset_query(); /* endwhile */
						}
	
						$output .= '
					  </div>
					</div>
				  </div>
				</div>
			</section>';
			
			}
			
				
			return $output;
		
			wp_reset_postdata();
		} /* end of function */
	} /* end of class */
	
	new theneeds_testimonials_contactform;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_testimonials_contactform extends WPBakeryShortCode {
		}
	}
}