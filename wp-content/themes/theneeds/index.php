<?php
/*
 * This file is used to generate main index page.
 */
	$theneeds_num_excerpt = '';
	$theneeds_default_settings = get_option('default_pages_settings');

	if($theneeds_default_settings != ''){
		$theneeds_default = new DOMDocument ();
		$theneeds_default->loadXML ( $theneeds_default_settings );
		$theneeds_num_excerpt = theneeds_find_xml_value($theneeds_default->documentElement,'default_excerpt');
	}
	
	if($theneeds_num_excerpt == '' || $theneeds_num_excerpt == 0 ) {
		$theneeds_num_excerpt = 300;
	}
	
	@get_header();
	
	$theneeds_header_style = '';

		$theneeds_item_class = '';
		$theneeds_sidebar = '';
		/* Fetch sidebar theme option */
		$theneeds_default_settings = get_option('default_pages_settings');		
		if($theneeds_default_settings != ''){		
			$theneeds_default = new DOMDocument ();
			$theneeds_default->loadXML ( $theneeds_default_settings );
			$theneeds_sidebar = theneeds_find_xml_value($theneeds_default->documentElement,'sidebar_default');
			$theneeds_right_sidebar = theneeds_find_xml_value($theneeds_default->documentElement,'right_sidebar_default');
			$theneeds_left_sidebar = theneeds_find_xml_value($theneeds_default->documentElement,'left_sidebar_default');
		}
			
		$theneeds_breadcrumbs = '';
		$theneeds_breadcrumbs = theneeds_get_themeoption_value('breadcrumbs','general_settings');
		/* Get Sidebar for index */
		$theneeds_sidebar_class = theneeds_sidebar_func($theneeds_sidebar);	
	?>
	
	<div id="inner-banner">
		<div class="container">
		    <h1><?php esc_html_e('Blog Posts','theneeds');?></h1>
			<em><?php esc_html_e('All Blog Posts Listed Here On This Page.','theneeds');?></em>
			<?php /* Breadcrumb Only */
			$theneeds_breadcrumbs = '';
			$theneeds_breadcrumbs = theneeds_get_themeoption_value('breadcrumbs','general_settings');
			
			if($theneeds_breadcrumbs == 'enable'){?>

				<?php echo theneeds_breadcrumbs(); 

			} /* breadcrumbs ends */ 
			?>
		</div>
	</div>

	<!-- Main Content Section Start -->
	<div id="main"> 
		<section class="blog-style-1 blog-space index_page">
			<div class="container">
				<div class="row">
						<?php /* sidebar settings */
							if($theneeds_sidebar == "left-sidebar" || $theneeds_sidebar == "both-sidebar" || $theneeds_sidebar == "both-sidebar-left"){?>
								<div id="block_first" class="sidebar side-bar <?php echo esc_attr($theneeds_sidebar_class[0]);?>">
									<aside>
										<div class="cp-sidebar">
											<?php dynamic_sidebar( $theneeds_left_sidebar ); ?>
										</div>
									</aside>
								</div>
								<?php
							}
							if($theneeds_sidebar == 'both-sidebar-left'){?>
								<div id="block_first_left" class="sidebar side-bar <?php echo esc_attr($theneeds_sidebar_class[0]);?>">
									<aside>
										<div class="cp-sidebar">
											<?php dynamic_sidebar( $theneeds_left_sidebar );?>
										</div>
									</aside>
							    </div>
							<?php 
							} 
						?>
						<div class="<?php echo esc_attr($theneeds_sidebar_class[1]);?>">
							<div id="<?php the_ID(); ?>">
								<?php
								/* Feature Sticky Post */
									if ( is_front_page() && has_post_thumbnail() ) { 
										/* Include the featured content template. */
										get_template_part( 'featured-content' );
									}
									
									while ( have_posts() ) : the_post();
										
										/* If image exists print its mask */
										
										$theneeds_post_format = get_post_format();
										
										global $post;
										
										/* Get Comment Count */
										$comment_count = wp_count_comments( $post->ID );
										
										$comment_count = $comment_count->total_comments;
										
										$posttags = get_the_tags();
										
										$post_categories = wp_get_post_categories( $post->ID );
										
										$cats = array();
	
								?>
								
								<div class="cp_index_page">
									<div <?php post_class(); ?>>
										
											<div class="style-1">
												<div class="frame">
													<a href="<?php echo esc_url(get_the_permalink());?>"><?php echo get_the_post_thumbnail($post->ID, 'full'); ?></a>
													<?php /* if Sticky Add Sticky Message */
													if(is_sticky($post->ID)){ ?>
														<strong class="sticky"><?php esc_html_e('Sticky Post','theneeds');?></strong>
													<?php
													} ?>										
												</div>
												<div class="text-box">
													<div class="clearfix">
													  <div class="thumb"><?php echo get_avatar( get_the_author_meta( 'ID' ), 60 );?></div>
													  <div class="btn-row"> 
														<a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ));?>" class="link"><i class="fa fa-user" aria-hidden="true"></i><?php echo esc_attr(get_the_author());?></a> 
														<a href="<?php echo esc_url(get_the_permalink());?>" class="link"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo esc_attr(get_the_date());?></a> 
													  </div>
													</div>
													<h3><a href="<?php echo esc_url(get_the_permalink());?>"><?php echo esc_attr(get_the_title());?></a></h3>
													<div class = "the-content">
														<?php /* Content */
															the_content();
															wp_link_pages( array(
																'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'theneeds' ) . '</span>',
																'after'       => '</div>',
																'link_before' => '<span>',
																'link_after'  => '</span>',
																'pagelink'    => '<span class="screen-reader-text"></span>%',
																'separator'   => '<span class="screen-reader-text"></span>',
															) );
															?>
													</div>
													<a href="<?php echo esc_url(get_the_permalink());?>" class="btn-more"><?php esc_html_e('Read Details','theneeds');?></a> 
													<div class = "tags">
														<?php /* Get Post Tags */
															if ($posttags) { ?>
															<strong><?php esc_html_e('Tags: ','theneeds');?></strong>
															<span>
															<?php
																foreach($posttags as $tag) {
																	echo '<a class = "tags-class" href = "'.esc_url(get_tag_link($tag->term_id)).'">'.esc_attr($tag->name).'</a>'; 
																}
															?>
															</span>
														<?php } ?>
													</div>
													<div class = "cp-categories">	
														<?php /* Post Categories */
															if ($post_categories) { ?>
															<strong><?php esc_html_e('Categories: ','theneeds');?></strong>
															<span>
																<?php	
																	foreach($post_categories as $c){
																		$cat = get_category( $c );
																		echo '<a class = "cats-class" href = "'.esc_url(get_category_link($cat->term_id)).'">'.esc_attr($cat->name).'</a>';
																	}
																?>
															</span>
														<?php } ?>
													</div>
												</div>
											</div>
										
									</div>
								</div>
							<?php endwhile; /* endwhile */ ?>
							<div class="pagination-box">
								<nav>
									<ul class="pagination">
										<li>
											<?php echo theneeds_pagination();?>
										</li>
									</ul>
								</nav>
							</div>	
						  
						  </div>
						</div>
						<?php /* Sidebar Settings */
							if($theneeds_sidebar == "both-sidebar-right"){?>
								<div class="<?php echo esc_attr($theneeds_sidebar_class[0]);?> side-bar">
								<aside>
									<div class="cp-sidebar">
										<?php dynamic_sidebar($theneeds_right_sidebar);  ?>
									</div>
								</aside>
								</div>
								<?php
							}
							if($theneeds_sidebar == 'both-sidebar-right' || $theneeds_sidebar == "right-sidebar" || $theneeds_sidebar == "both-sidebar"){ ?>
								<div class="<?php echo esc_attr($theneeds_sidebar_class[0]);?> side-bar">
									<aside>
										<div class="cp-sidebar">
											<?php dynamic_sidebar( $theneeds_right_sidebar); ?>
										</div>
								</aside>
								</div>
							<?php 
							} 
						?>	
				</div>	
			</div>
		</section>
	</div> 
<?php @get_footer(); ?>