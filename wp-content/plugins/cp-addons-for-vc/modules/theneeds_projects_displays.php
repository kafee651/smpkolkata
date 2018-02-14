<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_projects_displays")){
	class theneeds_projects_displays{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_projects_displays_init"));
			add_shortcode('theneeds_projects_displays',array($this,'theneeds_projects_displays_shortcode'));
		}
		function theneeds_projects_displays_init(){

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
					"base" => "theneeds_projects_displays",
					"name" => __( "Projects Styles", "js_composer" ),
					"class" => "theneeds_projects_displays_class",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"icon" => "theneeds_projects_displays_news_full",
					"params" => array(
		
						array(
								"type" => "dropdown",
								"holder" => "p",
								"heading" => __( "Styles", "js_composer" ),
								"param_name" => "blog_list_styles",
								"value" =>  array(  __( '2 Column', 'js_composer' ) => '2_column',
													__( '2 Column w/ Filter', 'js_composer' ) => '2_col_filter',
													__( '2 Column w/ Full Filter', 'js_composer' ) => '2_col_filter_full',
													__( '3 Column', 'js_composer' ) => '3_column',
													__( 'Projects List', 'js_composer' ) => 'list',
													
												),
								"description" => __( "Select Element Style", "js_composer" )
						),
							
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Number of Posts", "js_composer" ),
							"param_name" => "num_posts",	
							"description" => __( "Enter Number of Posts To Fetch", "js_composer" )
						),
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Excerpt Length", "js_composer" ),
							"param_name" => "num_characters",
							"description" => __( "Enter Number For Excerpt Length, Only For List Style", "js_composer" )
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
		
		
		function theneeds_projects_displays_shortcode( $atts, $content = null ) {
			
			$result = shortcode_atts( array(
	
				'blog_list_styles' => '2_column',
				'num_posts' => '5',
				'num_characters' => '',
				'category_name' => '',
				'show_pagination' => '',

			), $atts );
			
			extract( $result );
			
			wp_reset_query();
			
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
						'post_type' => 'projects',
						'posts_per_page' => $num_posts,
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
						'posts_per_page' 	=> $num_posts,
						'orderby'		 	=> 'title',
						'order' 			=> 'ASC'
					);
				
				}
			
			}else{
			
				
				$args = array( 
					'post_type' 		=> 'projects',
					'post_status'       => 'publish',
					'paged' 			=> $paged,
					'posts_per_page' 	=> $num_posts,
					'orderby'		 	=> 'title',
					'order' 			=> 'ASC'
				);
			
			}
			
			
			query_posts($args);
			

			if($blog_list_styles == '2_column'){
				
				$output = '
						
				<section class="project-style-1 project-2-col">
				  <div id="project">
					<div class="element_wrap">
					  <div class="row">';

						/* Loop Begins */
						if ( have_posts() ) {
						 
							while ( have_posts() ) { the_post();		 
											
							$categories = get_the_category();
							
							$catArray = array();
							
							foreach($categories as $category) {	
								$catArray[] = '<a href="'.esc_url(get_category_link( $category->term_id )).'" title="' . esc_attr( $category->name  ) . '">'.esc_attr($category->cat_name).'</a>';
							}
							
							$category_csv = implode(', ',$catArray);
							
							$archive_year  = get_the_time('Y'); 
							$archive_month = get_the_time('m'); 
							$archive_day   = get_the_time('d');
							
							if (strlen(get_the_content()) > $num_characters){
								
								$post_content = mb_substr(get_the_content(), 0, $num_characters).'...';
							
							}else{
							
								$post_content = strip_tags(get_the_content()); 
								
							}
							
							$theneeds_projects_detail_xml = get_post_meta($post->ID, 'theneeds_projects_detail_xml', true);

							if($theneeds_projects_detail_xml <> ''){

								$campers_post_xml = new DOMDocument ();

								$campers_post_xml->loadXML ( $theneeds_projects_detail_xml );

								$projects_duration = theneeds_find_xml_value($campers_post_xml->documentElement,'projects_duration');	
							
							}
							
							/* Get Comment Count */
							$comment_count = wp_count_comments( $post->ID );
							
							$comment_count = $comment_count->total_comments;
							
							/* Add Sticky Class To Sticky Post */
							if(is_sticky($post->ID)){
								$sticky_class = "sticky";
							}else{
								$sticky_class = "";
							}
								
		
							/* if Post has thumbnail */
							
							$output .= '
							
							<div class="col-md-6 col-sm-6">
							  <div class="box">
								<div class="frame"><a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, array(585,350)).'</a></div>
								<div class="outer">
								  <div class="text-box">
									<h3><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h3>
									<strong class="month">('.$projects_duration.')</strong> 
								  </div>
								</div>
							  </div>
							</div>';
			
						} /* endwhile */
						
						$output .= '</div>'; /* end row before pagination */

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
						}else{
							
							/* Yet To Be Implemented */
						
						}
									
							
					} wp_reset_query(); /* endif have post */
					

				$output .= '
				
					</div>
					
				  </div>
				
				</section>';
				
			}
			
			if($blog_list_styles == '2_col_filter'){
			
				/* Isotope Scripts */
				wp_enqueue_script( 'isotope-packaged', theneeds_PATH_URL.'/frontend/js/jquery.isotope.js', false, '1.0', true);
				wp_enqueue_script( 'isotope-sorting', theneeds_PATH_URL.'/frontend/js/sorting.js', false, '1.0', true);
				
				$output = '
						
				<section class="project-style-1 project-2-col">
				  <div id="project">
					<div class="element_wrap">
					  <div class="row">'; 
					   
					   $counter = rand(1, 1000);  
						
						$output .= '
						
						<div id="options" class="col-md-12">
						  <ul id="filter" class="option-set" data-option-key="filter">';
						  
								$categories = get_categories( array('child_of' => $category_name, 'taxonomy' => 'projects-categories', 'hide_empty' => 0, 'orderby' => 'date', 'order' => 'DESC') );
								
								if(!empty($categories)){

									foreach($categories as $values){
									
										if (get_category($values)->category_count > 1){;
											
											
											$output .= '<li><a href="#filter" data-option-value=".'.esc_attr($values->term_id).'">'.esc_attr($values->name).'</a></li>';
										}                               
									}
								}
								$output .= '
								
						  </ul>
						</div>
						<div class="portfolio_block" data-animated="fadeIn">';
	
						/* Loop Begins */
						if ( have_posts() ) {
						 
							while ( have_posts() ) { the_post(); global $post;	

							$theneeds_projects_detail_xml = get_post_meta($post->ID, 'theneeds_projects_detail_xml', true);

							if($theneeds_projects_detail_xml <> ''){

								$campers_post_xml = new DOMDocument ();

								$campers_post_xml->loadXML ( $theneeds_projects_detail_xml );

								$projects_duration = theneeds_find_xml_value($campers_post_xml->documentElement,'projects_duration');	
							
							}
											
							/* Array For Categories */
							$catArray = array();
							
							/* Project Categories */
							$categories = get_the_terms( $post->ID, 'projects-categories' );
								
							if($categories <> ''){
								foreach ( $categories as $category ) {
									/* Error Check */
									if(is_object($category)){
										$catArray[] =  esc_attr($category->term_id)." ";
									}else{
										$catArray = array();
									}
								}
								
								$cat = implode(' ',$catArray);
							}
							
							$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
							
							$output .= '
							
							<div class="element col-md-6 col-sm-6 gall '.$cat.'">
								<div class="box">
								  <div class="frame"><a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, array(585,350)).'</a></div>
								  <div class="outer">
									<div class="text-box">
									  <h3><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h3>
									  <strong class="month">('.$projects_duration.')</strong> 
									</div>
								  </div>
								</div>
							</div>';
	
			
						} /* endwhile */
						
						$output .= '</div>'; /* end row before pagination */
	
					} wp_reset_query(); /* endif have post */
					

					$output .= '
				   </div>
				</div>
			   </div>
			</section>';
				
			}
			
			if($blog_list_styles == '3_column'){
				
				$output = '
						
				<section class="project-style-1 project-2-col project-3-col">
				  <div id="project">
					<div class="element_wrap">
					  <div class="row">';

						/* Loop Begins */
						if ( have_posts() ) {
						 
							while ( have_posts() ) { the_post();		 
											
							$theneeds_projects_detail_xml = get_post_meta($post->ID, 'theneeds_projects_detail_xml', true);

							if($theneeds_projects_detail_xml <> ''){

								$campers_post_xml = new DOMDocument ();

								$campers_post_xml->loadXML ( $theneeds_projects_detail_xml );

								$projects_duration = theneeds_find_xml_value($campers_post_xml->documentElement,'projects_duration');	
							
							}
											
							/* Array For Categories */
							$catArray = array();
							
							/* Project Categories */
							$categories = get_the_terms( $post->ID, 'projects-categories' );
								
							if($categories <> ''){
								foreach ( $categories as $category ) {
									/* Error Check */
									if(is_object($category)){
										$catArray[] =  esc_attr($category->term_id)." ";
									}else{
										$catArray = array();
									}
								}
								
								$cat = implode(' ',$catArray);
							}
								
		
							/* if Post has thumbnail */
							
							$output .= '
							
							<div class="col-md-4 col-sm-4">
							  <div class="box">
								<div class="frame"><a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, array(390,320)).'</a></div>
								<div class="text-box">
								  <h3><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h3>
								  <strong class="month">('.$projects_duration.')</strong> </div>
							  </div>
							</div>';
	
						} /* endwhile */
						
						$output .= '</div>'; /* end row before pagination */

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
						}else{
							
							/* Yet To Be Implemented */
						
						}
									
							
					} wp_reset_query(); /* endif have post */
					

				$output .= '
					
					</div>
				  </div>
				
				</section>';
				
			}
			
			if($blog_list_styles == '2_col_filter_full'){
			
				/* Isotope Scripts */
				wp_enqueue_script( 'isotope-packaged', theneeds_PATH_URL.'/frontend/js/jquery.isotope.js', false, '1.0', true);
				wp_enqueue_script( 'isotope-sorting', theneeds_PATH_URL.'/frontend/js/sorting.js', false, '1.0', true);
				//wp_enqueue_script( 'isotope-packaged-mini', theneeds_PATH_URL.'/frontend/js/isotope.pkgd.min.js', false, '1.0', true);
				
				$output = '
						
				<section class="project-style-1 project-2-col">
				  <div id="project">
					<div class="container-fluid">
					  <div class="row">';
					   
					   $counter = rand(1, 1000);  
						
						$output .= '
						
						<div id="options" class="col-md-12">
						  <ul id="filter" class="option-set" data-option-key="filter">';
						  
								$categories = get_categories( array('child_of' => $category_name, 'taxonomy' => 'projects-categories', 'hide_empty' => 0, 'orderby' => 'date', 'order' => 'DESC') );
								
								if(!empty($categories)){

									foreach($categories as $values){
									
										if (get_category($values)->category_count > 1){;
											
											
											$output .= '<li><a href="#filter" data-option-value=".'.esc_attr($values->term_id).'">'.esc_attr($values->name).'</a></li>';
										}                               
									}
								}
								$output .= '
								
						  </ul>
						</div>
						<div class="portfolio_block" data-animated="fadeIn">';
	
						/* Loop Begins */
						if ( have_posts() ) {
						 
							while ( have_posts() ) { the_post(); global $post;	

							$theneeds_projects_detail_xml = get_post_meta($post->ID, 'theneeds_projects_detail_xml', true);

							if($theneeds_projects_detail_xml <> ''){

								$campers_post_xml = new DOMDocument ();

								$campers_post_xml->loadXML ( $theneeds_projects_detail_xml );

								$projects_duration = theneeds_find_xml_value($campers_post_xml->documentElement,'projects_duration');	
							
							}
											
							/* Array For Categories */
							$catArray = array();
							
							/* Project Categories */
							$categories = get_the_terms( $post->ID, 'projects-categories' );
								
							if($categories <> ''){
								foreach ( $categories as $category ) {
									/* Error Check */
									if(is_object($category)){
										$catArray[] =  esc_attr($category->term_id)." ";
									}else{
										$catArray = array();
									}
								}
								
								$cat = implode(' ',$catArray);
							}
							
							
							$output .= '
							
							<div class="element col-md-4 col-sm-6 gall '.$cat.'">
								<div class="box">
								  <div class="frame"><a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, array(585,350)).'</a></div>
								  <div class="outer">
									<div class="text-box">
									  <h3><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h3>
									  <strong class="month">('.$projects_duration.')</strong> 
									</div>
								  </div>
								</div>
							</div>';
	
			
						} /* endwhile */
						
						$output .= '</div>'; /* end row before pagination */
	
					} wp_reset_query(); /* endif have post */
					

					$output .= '
				   </div>
				</div>
			   </div>
			</section>';
				
			}
			
			if($blog_list_styles == 'list'){
				
				$output = '
						
				<section class="project-style-1 project-3-col project-list">
				  <div id="project">
					<div class="element_wrap">';

						/* Loop Begins */
						if ( have_posts() ) {
						 
							while ( have_posts() ) { the_post();		 
											
							$theneeds_projects_detail_xml = get_post_meta($post->ID, 'theneeds_projects_detail_xml', true);
							
							if($theneeds_projects_detail_xml <> ''){

								$campers_post_xml = new DOMDocument ();

								$campers_post_xml->loadXML ( $theneeds_projects_detail_xml );

								$projects_duration = theneeds_find_xml_value($campers_post_xml->documentElement,'projects_duration');	
							
							}
											
							/* Array For Categories */
							$catArray = array();
							
							/* Project Categories */
							$categories = get_the_terms( $post->ID, 'projects-categories' );
								
							if($categories <> ''){
								foreach ( $categories as $category ) {
									/* Error Check */
									if(is_object($category)){
										$catArray[] =  esc_attr($category->term_id)." ";
									}else{
										$catArray = array();
									}
								}
								
								$cat = implode(' ',$catArray);
							}
		
							/* if Post has thumbnail */
							
							$output .= '
							
							<div class="box">
								<div class="row">
									<div class="col-md-7 col-sm-6">
										<div class="frame"><a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail($post->ID, array(585,350)).'</a></div>
									</div>
									<div class="col-md-5 col-sm-6">
										<div class="text-box">
										  <h3><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h3>
										  <strong class="month">(2000 - 2004)</strong>
										  <p>'.mb_substr(get_the_content(), 0 , $num_characters).'</p>
										  <a href="'.esc_url(get_permalink()).'" class="btn-style-1">'.esc_html__('Project Deatils','theneeds').'</a> 
										</div>
									</div>
								</div>
							</div>';
							
	
						} /* endwhile */
						
						$output .= '</div>'; /* end row before pagination */

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
						}else{
							
							/* Yet To Be Implemented */
						
						}
									
							
					} wp_reset_query(); /* endif have post */
					
					$output .= '
				</div>
			</section>';
				
			}
			

			return $output;
				
				

		} /* OutPut Function Ends Here */
		
		
	} /* class ends here */
	
	new theneeds_projects_displays;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_projects_displays extends WPBakeryShortCode {
		}
	}
}