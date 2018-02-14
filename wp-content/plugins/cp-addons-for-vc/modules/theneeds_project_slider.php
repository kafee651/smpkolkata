<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_projects_slider")){
	class theneeds_projects_slider{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_projects_slider_init"));
			add_shortcode('theneeds_projects_slider',array($this,'theneeds_projects_slider_shortcode'));
		}
		function theneeds_projects_slider_init(){

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
					"base" => "theneeds_projects_slider",
					"name" => __( "Projects Slider", "js_composer" ),
					"class" => "theneeds_projects_slider_class",
					"icon" => "theneeds_projects_slider",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"params" => array(
					
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Element Sub Title", "js_composer" ),
								"param_name" => "element_subtitle",
								"description" => __( "Add Element Sub Title", "js_composer" )
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
								"heading" => __( "Element Caption", "js_composer" ),
								"param_name" => "element_caption",
								"description" => __( "Add Element Caption", "js_composer" )
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
	
						)
					) 
				);
			}
		}
		
		
		function theneeds_projects_slider_shortcode( $atts, $content = null ) {
		
			$result = shortcode_atts( array(
			
				'element_subtitle' => '',
				'element_caption' => '',
				'element_title' => '',
				'category_name' => '',
				'project_count' => '6',

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
			
			
			$output = '
			
			<section class="project-style-1">
			  <div class="container-fluid">
				<div class="container">
				  <div class="heading-style-1"> <span class="title">'.$element_subtitle.'</span>
					<h2>'.$element_title.'</h2>
					<em>'.$element_caption.'</em>
				  </div>
				</div>
				<div id="project-1" class="owl-carousel project-1">';
	
					if(have_posts()){ 
					
						while( have_posts() ){ the_post(); global $post;
						
						$theneeds_projects_detail_xml = get_post_meta($post->ID, 'theneeds_projects_detail_xml', true);
						
						$projects_duration = '';
						
						if($theneeds_projects_detail_xml <> ''){
						
							$features_xml = new DOMDocument ();
							
							$features_xml->loadXML ( $theneeds_projects_detail_xml );
							
							$projects_duration = theneeds_find_xml_value($features_xml->documentElement,'projects_duration');	
						}
									
				  
						$output .= '
							
							<div class="item">
								<div class="box">
								  <div class="frame"><a href="#">'.get_the_post_thumbnail($post->ID, array(585,350)).'</a></div>
								  <div class="outer">
									<div class="text-box">
									  <h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>
									  <strong class="month">('.$projects_duration.')</strong> </div>
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
	
	new theneeds_projects_slider;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_projects_slider extends WPBakeryShortCode {
		}
	}
}