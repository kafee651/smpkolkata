<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_blog_posts")){
	class theneeds_blog_posts{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_blog_posts_init"));
			add_shortcode('theneeds_blog_posts',array($this,'theneeds_blog_posts_shortcode'));
		}
		function theneeds_blog_posts_init(){

			if(function_exists("vc_map")){
				
				 $args = array(
					'type'                     => 'post',
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'date',
					'order'                    => 'DESC',
					'hide_empty'               => 1,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => 'category',
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
					"base" => "theneeds_blog_posts",
					"name" => __( "Blog Posts", "js_composer" ),
					"class" => "theneeds_blog_posts_class",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"icon" => "campers_blog_news_small",
					"params" => array(
					
						array(
								"type" => "dropdown",
								"holder" => "p",
								"heading" => __( "Select Style", "js_composer" ),
								"param_name" => "blog_style",
								"value" =>  array( __( 'Grid', 'js_composer' ) => 'grid',
													__( 'List', 'js_composer' ) => 'list',
													__( 'Full', 'js_composer' ) => 'full',
													__( 'Small', 'js_composer' ) => 'small'
													
												),
								"description" => __( "Select Element Style", "js_composer" )
						),
						
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Element Sub Title", "js_composer" ),
							"param_name" => "element_subtitle",
							"description" => __( "Enter Sub Title For Element", "js_composer" )
						),
					
						array(
								'type' => 'textfield',
								"holder" => "p",
								'heading' => __( 'Add Element Title', 'js_composer' ),
								'param_name' => 'element_title',
								'description' => __( 'Add Title For Element', 'js_composer' ),
						),
							
						
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Element Caption", "js_composer" ),
							"param_name" => "element_caption",
							"description" => __( "Enter Caption For Element i.e 4 Column", "js_composer" )
						),
						

						array(
							"type" => "textfield",
							"class" => "",
							"holder" => "p",
							"heading" => __( "Number of posts", "js_composer" ),
							"param_name" => "num_posts",	
							"description" => __( "Enter Number of Posts To Fetch", "js_composer" )
						),
						
						array(
							"type" => "textfield",
							"class" => "",
							"holder" => "p",
							"heading" => __( "Excerpt Length", "js_composer" ),
							"param_name" => "num_characters",
							"description" => __( "Enter Number For Excerpt Length", "js_composer" )
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
		
		
		function theneeds_blog_posts_shortcode( $atts, $content = null ) {
			
			$result = shortcode_atts( array(
				
				'blog_style' => 'grid',
				'element_subtitle' => '',
				'element_title' => '',
				'element_caption' => '',
				'num_posts' => '3',
				'num_characters' => '112',
				'category_name' => '',
				'show_pagination' => '',
				
			), $atts );
			
			extract( $result );
			
			global $wpdb,$post;

			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			
			if($category_name != 'All' && !empty($category_name)){
				
				$term = '';
				
				$term = get_term_by('name', $category_name, 'category');
				
				if(is_object($term)){
				
					$category_id = $term->term_id;
					
					$stack_cat_all = array('tax_query' => array(
							array(
								'taxonomy' => 'category',
								'terms' => $category_id,
								'field' => 'term_id',
							)
						),
					);
					
					$args = array( 
						'post_type' => 'post',
						'posts_per_page' => $num_posts,
						'ignore_sticky_posts' => 1,
						'paged' 			=> $paged,
						'tax_query' => array(
							array(
								'taxonomy' => 'category',
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
						'post_type' 		=> 'post',
						'ignore_sticky_posts' => 1,
						'post_status'       => 'publish',
						'paged' 			=> $paged,
						'posts_per_page' 	=> $num_posts,
						'orderby'		 	=> 'date',
						'order' 			=> 'DESC'
					);
				
				}
			
			}else{
			
				
				$args = array( 
					'post_type' 		=> 'post',
					'post_status'       => 'publish',
					'ignore_sticky_posts' => 1,
					'paged' 			=> $paged,
					'posts_per_page' 	=> $num_posts,
					'orderby'		 	=> 'date',
					'order' 			=> 'DESC'
				);
			
			}
			
			
			query_posts($args);
			
			
			if($blog_style == 'grid'){
			
			$output = '
			
			<section class="blog-style-1">
			  <div class="element_wrap">';
				if(!empty($element_title) || !empty($element_caption)){
					$output .= '
					<div class="heading-style-1"> <span class="title">'.$element_subtitle.'</span>
					  <h2>'.$element_title.'</h2>
					  <em>'.$element_caption.'</em> 
					</div>';
				}
				$output .= '
				<div class="row">';
			
					/* Loop Begins */
					if ( have_posts() ) {
						
						while ( have_posts() ) { the_post(); global $post;
						
							/* Content */
							if (strlen(get_the_content()) > $num_characters){
								
								$post_content = mb_substr(strip_tags(get_the_content()), 0, $num_characters).'...';
							
							}else{
							
								$post_content = strip_tags(get_the_content()); 
								
							}
							
							$post_detail_xml = get_post_meta($post->ID, 'post_detail_xml', true);

							if($post_detail_xml <> ''){

								$theneeds_post_xml = new DOMDocument ();

								$theneeds_post_xml->loadXML ( $post_detail_xml );

								$link = theneeds_find_xml_value($theneeds_post_xml->documentElement,'seperate_link');
								
								$thumbnail_types = theneeds_find_xml_value($theneeds_post_xml->documentElement,'post_thumbnail');
							
							}
							
							/* Get Comment Count */
							$comment_count = wp_count_comments( $post->ID );
							
							$comment_count = $comment_count->total_comments;
								
						  
							$output .= '
								
								<div class="col-md-3 col-sm-6">
									<div class="style-1">
									  <div class="frame"><a href="'.get_the_permalink().'">'.theneeds_print_blog_thumbnail($post->ID,array(265,250)).'</a></div>
									  <div class="text-box">
										<div class="clearfix">
										  <div class="thumb">'.get_avatar( get_the_author_meta( 'ID' ), 60 ).'</div>
										  <div class="btn-row"> 
											<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ).'" class="link"><i class="fa fa-user" aria-hidden="true"></i>'.get_the_author().'</a> 
											<a href="'.get_the_permalink().'" class="link"><i class="fa fa-clock-o" aria-hidden="true"></i>'.get_the_date('M d, Y').'</a> 
										  </div>
										</div>
										<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>
										<p>'.$post_content.'</p>
										<a href="'.get_the_permalink().'" class="btn-more">'.esc_html__('Read Details','theneeds').'</a> </div>
									</div>
								</div>';	
	  
							} /* endwhile */ 
							
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
							}
		
						} /* endif have post */ wp_reset_query(); 
						
					$output .= '
				</div>
			  </div>
			</section>';
			
			}
			
			if($blog_style == 'small'){
			
			$output = '
			
			<section class="blog-style-1 blog-list">
			  <div class="element_wrap">
				<div class="row">';
			
					/* Loop Begins */
					if ( have_posts() ) {
						
						while ( have_posts() ) { the_post(); global $post;
						
							/* Content */
							if (strlen(get_the_content()) > $num_characters){
								
								$post_content = mb_substr(strip_tags(get_the_content()), 0, $num_characters).'...';
							
							}else{
							
								$post_content = strip_tags(get_the_content()); 
								
							}
							
							$post_detail_xml = get_post_meta($post->ID, 'post_detail_xml', true);

							if($post_detail_xml <> ''){

								$theneeds_post_xml = new DOMDocument ();

								$theneeds_post_xml->loadXML ( $post_detail_xml );

								$link = theneeds_find_xml_value($theneeds_post_xml->documentElement,'seperate_link');
								
								$thumbnail_types = theneeds_find_xml_value($theneeds_post_xml->documentElement,'post_thumbnail');
							
							}
							
							/* Get Comment Count */
							$comment_count = wp_count_comments( $post->ID );
							
							$comment_count = $comment_count->total_comments;
								
						  
							$output .= '
							
							<div class="style-1">
							  <div class="row">
								<div class="col-md-5">
								  <div class="frame"><a href="'.get_the_permalink().'">'.theneeds_print_blog_thumbnail($post->ID, array(390,320)).'</a></div>
								</div>
								<div class="col-md-7">
								  <div class="text-box">
									<div class="clearfix">
									  <div class="btn-row"> 
										<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ).'" class="link"><i class="fa fa-user" aria-hidden="true"></i>Smith Alvin</a>
										<a href="'.get_the_permalink().'" class="link"><i class="fa fa-clock-o" aria-hidden="true"></i>'.get_the_date().'</a> 
										<a href="'.get_the_permalink().'" class="link"><i class="fa fa-map-marker" aria-hidden="true"></i>'.$comment_count. esc_html__(' Comments','theneeds').' </a> 
									  </div>
									</div>
									<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>
									<p>'.$post_content.'</p>
									<a href="'.get_the_permalink().'" class="btn-more">'.esc_html__('Read Details','theneeds').'</a> 
								  </div>
								</div>
							  </div>
							</div>';

							} /* endwhile */ 
							
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
							}
		
						} /* endif have post */ wp_reset_query(); 
						
					$output .= '
				</div>
			  </div>
			</section>';
			
			}
			
			
			if($blog_style == 'slider'){
			
			
			/* Owl Scripts */
			wp_enqueue_script( 'cp-owl', theneeds_PATH_URL.'/frontend/js/owl.carousel.min.js', false, '1.0', true);

			wp_enqueue_style('cp-owl',theneeds_PATH_URL.'/frontend/css/owl.carousel.css');
			
			/* Build Link First */
			
			$readmore_url = vc_build_link( $readmore_url );

			if(!empty($readmore_url['url'])){ $readmore_url_link =  esc_url($readmore_url['url']); }else{ $readmore_url_link = ''; }

			if(!empty($readmore_url['title'])){ $readmore_text =  esc_attr($readmore_url['title']); }else{ $readmore_text = ''; }

			$output = '
			
			<section class="post-news-row">
			  <div class="element_wrap">
				<div class="">
				  <div class="left-box">
					<div class="heading-left">
					  <h2>'.$title_content.'</h2>
					</div>
					<a href="'.esc_url($readmore_url_link).'" class="btn-readmore">'.$readmore_text.'</a>
					<div id="post-slider" class="owl-carousel owl-theme">';
					/* Loop Begins */
					if ( have_posts() ) {
					 
						while ( have_posts() ) { the_post(); global $post;
						
							/* Content */
							if (strlen(get_the_content()) > $num_characters){
								
								$post_content = mb_substr(strip_tags(get_the_content()), 0, $num_characters).'...';
							
							}else{
							
								$post_content = strip_tags(get_the_content()); 
								
							}
							
							/* Get Comment Count */
							$comment_count = wp_count_comments( $post->ID );
							
							$comment_count = $comment_count->total_comments;
							
						  
							$output .= '
							  
							  <div class="item">
								<div class="post-box">
								  <div class="frame">'.theneeds_print_blog_thumbnail($post->ID,array(555,350)).'</div>
								  <div class="text-box">
									<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>
									<div class="tags-row"> 
										<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ).'" class="link"><i class="fa fa-user" aria-hidden="true"></i>'.get_the_author().'</a> 
										<a href="'.get_the_permalink().'" class="link"><i class="fa fa-calendar" aria-hidden="true"></i>'.get_the_date().'</a> 
										<a href="'.get_the_permalink().'" class="link"><i class="fa fa-comments-o" aria-hidden="true"></i>'.$comment_count.'</a> 
									</div>
									<p>'.$post_content.'</p>
									<a href="'.get_the_permalink().'" class="btn-readmore">'.esc_html__('Read News Detail','theneeds').'</a> </div>
								</div>
							  </div>';
					
						} /* endwhile */
	
					} wp_reset_query(); /* endif have post */
				

					$output .= '
					
					</div>
				</div>
				</div>
				</div>
			</section>';
			
			}
			
			if($blog_style == '4_column'){
			
			$output = '
			
			<section class="recent-post-style-2">
			  <div class="container">
				<div class="heading-center">
				  <h2>'.$title_content.'</h2>
				</div>
				<p><em>'.$element_caption.'</em></p>
				<div class="row">';
			
					/* Loop Begins */
					if ( have_posts() ) {
					 
						while ( have_posts() ) { the_post(); global $post;
						
							/* Content */
							if (strlen(get_the_content()) > $num_characters){
								
								$post_content = mb_substr(strip_tags(get_the_content()), 0, $num_characters).'...';
							
							}else{
							
								$post_content = strip_tags(get_the_content()); 
								
							}
							
							/* Get Comment Count */
							$comment_count = wp_count_comments( $post->ID );
							
							$comment_count = $comment_count->total_comments;
							
						  
							$output .= '
							
							<div class="col-md-3 col-sm-6">
								<div class="box">
								  <h4><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4>
								  <div class="frame"><a href="'.get_the_permalink().'">'.theneeds_print_blog_thumbnail($post->ID,array(340,370)).'</a></div>
								  <div class="text-box">
									<div class="tags-row"> 
										<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ).'" class="link"><i class="fa fa-user" aria-hidden="true"></i>'.get_the_author().'</a> 
										<a href="'.get_the_permalink().'" class="link"><i class="fa fa-calendar" aria-hidden="true"></i>'.get_the_date().'</a>
										<a href="'.get_the_permalink().'" class="link"><i class="fa fa-comments-o" aria-hidden="true"></i>'.$comment_count.'</a> 
									</div>
									<p>'.$post_content.'</p>
									<a href="'.get_the_permalink().'" class="btn-readmore">'.esc_html__('Post Detail','theneeds').'</a> </div>
								</div>
							</div>';
							  
						} /* endwhile */
	
					} wp_reset_query(); /* endif have post */
				

					$output .= '
					
				</div>
			  </div>
			</section>';
			
			}
			
			if($blog_style == 'list'){
			
			$output = '
			
			<section class="blog-style-1 news-grid news-list">
			  <div class="container">
				  <div class="row">';
			
					/* Loop Begins */
					if ( have_posts() ) {
					

						while ( have_posts() ) { the_post(); global $post;
						
							/* Content */
							if (strlen(get_the_content()) > $num_characters){
								
								$post_content = mb_substr(strip_tags(get_the_content()), 0, $num_characters).'...';
							
							}else{
							
								$post_content = strip_tags(get_the_content()); 
								
							}
							
							$post_detail_xml = get_post_meta($post->ID, 'post_detail_xml', true);

							if($post_detail_xml <> ''){

								$theneeds_post_xml = new DOMDocument ();

								$theneeds_post_xml->loadXML ( $post_detail_xml );

								$link = theneeds_find_xml_value($theneeds_post_xml->documentElement,'seperate_link');
								
								$thumbnail_types = theneeds_find_xml_value($theneeds_post_xml->documentElement,'post_thumbnail');
							
							}
							
							/* Get Comment Count */
							$comment_count = wp_count_comments( $post->ID );
							
							$comment_count = $comment_count->total_comments;
							
						  
							$output .= '
							
							<div class="col-md-6 col-sm-6">
								<div class="style-1">
								  <div class="row">
									<div class="col-md-6">
									  <div class="frame"><a href="'.get_the_permalink().'">'.theneeds_print_blog_thumbnail($post->ID,array(265,250)).'</a></div>
									</div>
									<div class="col-md-6">
									  <div class="text-box">
										<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>
										<div class="clearfix">
										  <div class="btn-row"> 
											<a href="'.get_the_permalink().'" class="link"><i class="fa fa-user" aria-hidden="true"></i>'.get_the_author().'</a> 
											<a href="#" class="link"><i class="fa fa-clock-o" aria-hidden="true"></i>'.get_the_date().'</a> 
										  </div>
										</div>
										<p>'.$post_content.'</p>
										<a href="'.get_the_permalink().'" class="btn-more">'.esc_html__('Read Details','theneeds').'</a> 
									  </div>
									</div>
								  </div>
								</div>
							</div>';
		
	  
						} /* endwhile */
						
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
	
					} wp_reset_query(); /* endif have post */
				

					$output .= '
				  </div>
			  </div>
			</section>';
			
			}
			
			
			if($blog_style == 'listing'){
			
			$output = '
			
			<section class="post-news-row blog-post blog-listings">
			  <div class="element_wrap">
				<div class="row">
					<div class = "col-md-12">';
			
					/* Loop Begins */
					if ( have_posts() ) {
					

						while ( have_posts() ) { the_post(); global $post;
						
							/* Content */
							if (strlen(get_the_content()) > $num_characters){
								
								$post_content = mb_substr(strip_tags(get_the_content()), 0, $num_characters).'...';
							
							}else{
							
								$post_content = strip_tags(get_the_content()); 
								
							}
							
							$post_detail_xml = get_post_meta($post->ID, 'post_detail_xml', true);

							if($post_detail_xml <> ''){

								$theneeds_post_xml = new DOMDocument ();

								$theneeds_post_xml->loadXML ( $post_detail_xml );

								$link = theneeds_find_xml_value($theneeds_post_xml->documentElement,'seperate_link');
								
								$thumbnail_types = theneeds_find_xml_value($theneeds_post_xml->documentElement,'post_thumbnail');
							
							}
							
							/* Get Comment Count */
							$comment_count = wp_count_comments( $post->ID );
							
							$comment_count = $comment_count->total_comments;
							
						  
							$output .= '
							
								<div class="row">
								  <div class="col-md-5">
									<div class="frame"> '.theneeds_print_blog_thumbnail($post->ID, array(340,220)).' </div>
								  </div>
								  <div class="col-md-7">
									<div class="post-box">
									  <div class="text-box">
										<h3><a href="'.get_the_permalink().'">'.mb_substr(get_the_title(), 0 , 35).'</a></h3>
										<div class="tags-row">
											<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ).'" class="link"><i class="fa fa-user" aria-hidden="true"></i>'.get_the_author().'</a>
											<a href="'.get_the_permalink().'" class="link"><i class="fa fa-calendar" aria-hidden="true"></i>'.get_the_date().'</a> 
											<a href="'.get_the_permalink().'" class="link"><i class="fa fa-comments-o" aria-hidden="true"></i>'.$comment_count.'</a> 
										</div>
										<p>'.$post_content.'</p>
										<a href="'.get_the_permalink().'" class="btn-readmore">'.esc_html__('Read Blog Detail','theneeds').'</a> </div>
									</div>
								  </div>
								</div>';
	  
						} /* endwhile */
						
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
	
					} wp_reset_query(); /* endif have post */
				

					$output .= '
					</div>
				</div>
			  </div>
			</section>';
			
			}
			
			if($blog_style == 'full'){
			
			$output = '
			
			<section class="blog-style-1 blog-space">
			  <div class="element_wrap">
				<div class="row">';
			
					/* Loop Begins */
					if ( have_posts() ) {
					

						while ( have_posts() ) { the_post(); global $post;
						
							/* Content */
							if (strlen(get_the_content()) > $num_characters){
								
								$post_content = mb_substr(strip_tags(get_the_content()), 0, $num_characters).'...';
							
							}else{
							
								$post_content = strip_tags(get_the_content()); 
								
							}
							
							$post_detail_xml = get_post_meta($post->ID, 'post_detail_xml', true);

							if($post_detail_xml <> ''){

								$theneeds_post_xml = new DOMDocument ();

								$theneeds_post_xml->loadXML ( $post_detail_xml );

								$link = theneeds_find_xml_value($theneeds_post_xml->documentElement,'seperate_link');
								
								$thumbnail_types = theneeds_find_xml_value($theneeds_post_xml->documentElement,'post_thumbnail');
							
							}
							
							/* Get Comment Count */
							$comment_count = wp_count_comments( $post->ID );
							
							$comment_count = $comment_count->total_comments;
							
						  
							$output .= '
							
							<div class="col-md-12">
								<div class="style-1">';
									if($thumbnail_types == 'link'){
				
										$output .='
										
										<div class="link-post">
											<div class="text-box">
											  <div class="btn-row"> 
												<a href="'.get_the_permalink().'" class="link"><i class="fa fa-user" aria-hidden="true"></i>'.get_the_author().'</a> 
												<a href="'.get_the_permalink().'" class="link"><i class="fa fa-clock-o" aria-hidden="true"></i>'.get_the_date().'</a> 
												<a href="'.get_the_permalink().'" class="link"><i class="fa fa-map-marker" aria-hidden="true"></i>'.$comment_count.' '. esc_html__('Comments','theneeds').'</a> 
											  </div>
											  <a href="'.esc_url($link).'" class="link-text">'.esc_url($link).'</a> 
											</div>
										</div>';
									
									}else{
										$output .='
										<div class="frame">
											<a href="'.get_the_permalink().'">'.theneeds_print_blog_thumbnail($post->ID,array(850,450)).'</a>
										';
										
										if(is_sticky($post->ID)){
												
												$output .= '<strong class="sticky">'.esc_html__('Sticky Post','theneeds').'</strong>';
										}
										
										$output .= '</div>';
	
									}
									
									if($thumbnail_types != 'link'){
										
										$output .= '
										
										<div class="text-box">
											<div class="clearfix">
											  <div class="thumb">'.get_avatar( get_the_author_meta( 'ID' ), 60 ).'</div>
											  <div class="btn-row"> 
												<a href="'.get_the_permalink().'" class="link"><i class="fa fa-user" aria-hidden="true"></i>'.get_the_author().'</a> 
												<a href="'.get_the_permalink().'" class="link"><i class="fa fa-clock-o" aria-hidden="true"></i>'.get_the_date().'</a> 
												<a href="'.get_the_permalink().'" class="link"><i class="fa fa-map-marker" aria-hidden="true"></i>'.$comment_count.' '. esc_html__('Comments','theneeds').'</a> 
											  </div>
											</div>
											<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>
											<p>'.$post_content.'</p>
											<a href="'.get_the_permalink().'" class="btn-more">'.esc_html__('Read Details','theneeds').'</a> 
										</div>';
									}
									
									
									
									$output .= '
								</div>
							</div>';
						} /* endwhile */
						
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
	
					} wp_reset_query(); /* endif have post */
				

					$output .= '
					
				</div>
			  </div>
			</section>';
			
			}
			
			
			return $output;
			
			wp_reset_postdata();
				
		} /* OutPut Function Ends Here */
		
		
	} /* class ends here */
	
	new theneeds_blog_posts;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_blog_posts extends WPBakeryShortCode {
		}
	}
}