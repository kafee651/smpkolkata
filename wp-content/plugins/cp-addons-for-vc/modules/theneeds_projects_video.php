<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_projects_video")){
	class theneeds_projects_video{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_projects_video_init"));
			add_shortcode('theneeds_projects_video',array($this,'theneeds_projects_video_shortcode'));
		}
		function theneeds_projects_video_init(){

			if(function_exists("vc_map")){
			
				$args = array(
					'type'                     => 'projects',
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'date',
					'order'                    => 'DESC',
					'hide_empty'               => 1,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => 'projects-categories',
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
					"base" => "theneeds_projects_video",
					"name" => __( "Projects w/ Video", "js_composer" ),
					"class" => "theneeds_projects_video_class",
					"icon" => "theneeds_projects_video",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"params" => array(
					
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Element Caption", "js_composer" ),
								"param_name" => "element_caption",
								"description" => __( "Add Element Caption", "js_composer" )
							),

							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Element Title", "js_composer" ),
								"param_name" => "element_title",
								"description" => __( "Add Element Title", "js_composer" )
							),

							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Excerpt Length", "js_composer" ),
								"param_name" => "num_characters",
								"description" => __( "Enter Number For Excerpt Length", "js_composer" )
							),
							
							array(
								"type" => "dropdown",
								"holder" => "p",
								"heading" => __( "Select Category", "js_composer" ),
								"param_name" => "category_name",
								"value" => $categoryArray,
								"description" => __( "Select Category From The Dropdown", "js_composer" )
							),
							
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Project Count", "js_composer" ),
								"param_name" => "project_count",
								"description" => __( "Add Number of Projects To Display", "js_composer" )
							),
							

							array(
								'type' => 'vc_link',
								"holder" => "p",
								'heading' => __( 'View More (Link)', 'js_composer' ),
								'param_name' => 'readmore_url',
								'description' => __( 'Add Text & Link For Button.', 'js_composer' ),
							),
							
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Add Video Link", "js_composer" ),
								"param_name" => "video_link",
								"description" => __( "Add Video Link Here i.e https://player.vimeo.com/video/72029895", "js_composer" )
							),
							
							array(
								'type' => 'attach_image',
								"holder" => "p",
								'heading' => __( 'Video Image', 'js_composer' ),
								'param_name' => 'bg_image',
								'value' => '',
								'description' => __( 'Select Image that will appear as Video Banner.', 'js_composer' )
							),
						)
					) 
				);
			}
		}
		
		
		function theneeds_projects_video_shortcode( $atts, $content = null ) {
		
			$result = shortcode_atts( array(
			
				'element_caption' => '',
				'element_title' => '',
				'num_characters' => '110',
				'category_name' => '',
				'project_count' => '2',
				'readmore_url' => '',
				'video_link' => '',
				'bg_image' => '',

			), $atts );

			extract( $result );
			
			global $wpdb,$post;

			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			
			if($category_name != 'All' && !empty($category_name)){
				
				$term = '';
				
				$term = get_term_by('name', $category_name, 'projects-categories');
				
				if(is_object($term)){
				
					$category_id = $term->term_id;
					
					$stack_cat_all = array('tax_query' => array(
							array(
								'taxonomy' => 'projects-categories',
								'terms' => $category_id,
								'field' => 'term_id',
							)
						),
					);
					
					$args = array( 
						'post_type' 		=> 'projects',
						'posts_per_page' 	=> $project_count,
						'paged' 			=> $paged,
						'tax_query' => array(
							array(
								'taxonomy' => 'projects-categories',
								'terms' => $category_id,
								'field' => 'term_id',
							)
						), 
						'post_status'       => 'publish',
						'orderby' 			=> 'title',
						'order' 			=> 'ASC'
					);
					
				}else{
				
					$args = array( 
						'post_type' 		=> 'projects',
						'post_status'       => 'publish',
						'paged' 			=> $paged,
						'posts_per_page' 	=> $project_count,
						'orderby'		 	=> 'title',
						'order' 			=> 'ASC'
					);
				
				}
			
			}else{
			
				
				$args = array( 
					'post_type' 		=> 'projects',
					'post_status'       => 'publish',
					'paged' 			=> $paged,
					'posts_per_page' 	=> $project_count,
					'orderby'		 	=> 'title',
					'order' 			=> 'ASC'
				);
			
			}

			query_posts($args);
			
			/* Pretty Photo Scripts */
			wp_enqueue_style('prettyPhoto',theneeds_PATH_URL.'/frontend/css/prettyphoto.min.css');
		
			wp_enqueue_script( 'prettyPhoto', theneeds_PATH_URL.'/frontend/js/jquery.prettyphoto.min.js', false, '1.0', true);
				

			/* Background Image */
			
			if(!empty($bg_image)){
				
				$bg_image = wpb_getImageBySize( array( 'attach_id' => $bg_image, 'thumb_size' => '100', 'class' => 'vc_single_image-img' ) );
				
				$bg_image =  $bg_image['p_img_large'][0];
			
			}else{
				
				$bg_image = '';
			}
			

			/* Build Link First */
			
			$readmore_url = vc_build_link( $readmore_url );

			if(!empty($readmore_url['url'])){ $readmore_url_link =  esc_url($readmore_url['url']); }else{ $readmore_url_link = ''; }

			if(!empty($readmore_url['title'])){ $readmore_text =  esc_attr($readmore_url['title']); }else{ $readmore_text = ''; }
				
			$output = '
			
			<section class="recent-project-video">
			  <div class="holder" style = "background: url('.esc_url($bg_image).') no-repeat left top;">
				<div class="video-box"> <a href="#" class="btn-play" data-toggle="modal" data-target="#myModal"></a>
				  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
					<div class="modal-dialog" role="document">
					  <div class="modal-content">
						<div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<div class="modal-body">
						  <iframe src="'.esc_url($video_link).'"></iframe>
						</div>
					  </div>
					</div>
				  </div>
				</div>
				<div class="text-col">
				  <div class="heading-style-1"> <span class="title">'.$element_caption.'</span>
					<h2>'.$element_title.'</h2>
				  </div>
				  <ul>';
				  /* Fetch & Display All */
					if(have_posts()){ 
					
						while( have_posts() ){ the_post(); global $post;
						
						$theneeds_projects_detail_xml = get_post_meta($post->ID, 'theneeds_projects_detail_xml', true);
						
						$projects_icons = '';
						
						if($theneeds_projects_detail_xml <> ''){
						
							$features_xml = new DOMDocument ();
							
							$features_xml->loadXML ( $theneeds_projects_detail_xml );
							
							$projects_icons = theneeds_find_xml_value($features_xml->documentElement,'projects_icons');	
						}
									
				  
							$output .= '
								<li>
								  <div class="icon-col"><i class="'.$projects_icons.'" aria-hidden="true"></i></div>
								  <div class="box">
									<h4>'.get_the_title().'</h4>
									<p>'.mb_substr(get_the_content(), 0 , $num_characters).'</p>
								  </div>
								</li>';
						} /* endwhile */ wp_reset_query();
					} /* endif */ 
					$output .= '
				  </ul>
				  <a href="'.$readmore_url_link.'" class="btn-style-1">'.$readmore_text.'<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> 
				</div>
			  </div>
			</section>';
			
		return $output;

		wp_reset_postdata();

		} /* end of function */
		
		
	}
	
	new theneeds_projects_video;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_projects_video extends WPBakeryShortCode {
		}
	}
}