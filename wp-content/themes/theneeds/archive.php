<?php
/*
 * This file is used to generate WordPress standard archive/category pages.
 */
	get_header();
	
	/* Get Default Option for Archives, Category, Search. */
	$theneeds_default_settings = get_option('default_pages_settings');
	/* Default Settings */
	if($theneeds_default_settings != ''){
		$theneeds_default = new DOMDocument ();
		$theneeds_default->loadXML ( $theneeds_default_settings );
		$theneeds_sidebar = theneeds_find_xml_value($theneeds_default->documentElement,'sidebar_default');
		$theneeds_right_sidebar = theneeds_find_xml_value($theneeds_default->documentElement,'right_sidebar_default');
		$theneeds_left_sidebar = theneeds_find_xml_value($theneeds_default->documentElement,'left_sidebar_default');
		$theneeds_num_excerpt = theneeds_find_xml_value($theneeds_default->documentElement,'default_excerpt');
	}
	
	/* Check Default Excerpt */
	if($theneeds_num_excerpt == '' || $theneeds_num_excerpt == 0 ) {
		$theneeds_num_excerpt = 250;
	}

	if(empty($paged)){
		$paged = (get_query_var('page')) ? get_query_var('page') : 1; 
	}
	
	$theneeds_select_layout_cp = '';
	$theneeds_general_settings = get_option('general_settings');
	if($theneeds_general_settings <> ''){
		$theneeds_logo = new DOMDocument ();
		$theneeds_logo->loadXML ( $theneeds_general_settings );
		$theneeds_select_layout_cp = theneeds_find_xml_value($theneeds_logo->documentElement,'select_layout_cp');
	}
		
	$theneeds_sidebar_class = '';
	$theneeds_content_class = '';
		
	/* Get Sidebar for page */
	$theneeds_sidebar_class = theneeds_sidebar_func($theneeds_sidebar);
	$theneeds_header_style = '';
	$theneeds_html_class_banner = '';
	$theneeds_html_class = theneeds_print_header_class($theneeds_header_style);
	if($theneeds_html_class <> ''){$theneeds_html_class_banner = 'banner';}
	$theneeds_breadcrumbs = '';
	$theneeds_breadcrumbs = theneeds_get_themeoption_value('breadcrumbs','general_settings');
	$theneeds_page_caption = '';
?>
	<div id="inner-banner">
		<div class="container">
		    <?php the_archive_title( '<h1>', '</h1>' );?>
			<em><?php esc_html_e('Archive Posts Listed On This Page','theneeds');?></em>
			<?php
			/* Breadcrumb Only */
			$theneeds_breadcrumbs = '';
			$theneeds_breadcrumbs = theneeds_get_themeoption_value('breadcrumbs','general_settings');
			if($theneeds_breadcrumbs == 'enable'){?>

				<?php echo theneeds_breadcrumbs(); 

			} /* breadcrumbs ends */ ?>
		</div>
	</div>

	<div id="main">
		<section class="blog-section blog-full archive_page">
			<div class="container">
				<div class="row">
					<?php /* Sidebar Settings */
						if($theneeds_sidebar == "left-sidebar" || $theneeds_sidebar == "both-sidebar" || $theneeds_sidebar == "both-sidebar-left"){?>
							<div id="block_first" class="sidebar side-bar <?php echo esc_attr($theneeds_sidebar_class[0]);?>">
								<aside>
									<div class="cp-sidebar">
										<?php if(is_active_sidebar($theneeds_left_sidebar)){dynamic_sidebar( $theneeds_left_sidebar );} ?>
									</div>
								</aside>
							</div>
							<?php
						}
						if($theneeds_sidebar == 'both-sidebar-left'){ ?>
							<div id="block_first_left" class="sidebar side-bar <?php echo esc_attr($theneeds_sidebar_class[0]);?>">
								<aside>
									<div class="cp-sidebar">
										<?php if(is_active_sidebar($theneeds_right_sidebar)){dynamic_sidebar( $theneeds_right_sidebar );} ?>
									</div>
								</aside>
							</div>
						<?php } 
					?>
					<div class="<?php echo esc_attr($theneeds_sidebar_class[1]);?>">
						<div id="<?php the_ID(); ?>" class="cp-post-box">
							<?php
							/* Feature Sticky Post */
								if ( is_front_page() && theneeds_has_featured_posts() ) { 
									/* Include the featured content template. */
									get_template_part( 'featured-content' );
								}
							?>
							
							<div <?php post_class(); ?>>
								<?php /* Loop Starts */
									while ( have_posts() ) : the_post(); global $post;
									
									/* If image exists print its mask */
									$theneeds_post_format = get_post_format();
									
									/* Get Comment Count */
									$comment_count = wp_count_comments( $post->ID );
									$comment_count = $comment_count->total_comments;	
								?> 
								<div class="cp_archive_page">
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
												</div>
											</div>
									</div>
								</div>
								<?php endwhile; /*endwhile */ ?>
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
					</div>
					<?php /* Sidebar Settings */
					if($theneeds_sidebar == "both-sidebar-right"){?>
						<div class="<?php echo esc_attr($theneeds_sidebar_class[0]);?> side-bar">
							<aside>
								<div class="cp-sidebar">
									<?php dynamic_sidebar( $theneeds_left_sidebar ); ?>
								</div>
							</aside>
						</div>
						<?php
					}
					if($theneeds_sidebar == 'both-sidebar-right' || $theneeds_sidebar == "right-sidebar" || $theneeds_sidebar == "both-sidebar"){ ?>
						<div class="<?php echo esc_attr($theneeds_sidebar_class[0]);?> side-bar">
							<aside>
								<div class="cp-sidebar">
									<?php dynamic_sidebar( $theneeds_right_sidebar ); ?>
								</div>
							</aside>
						</div>
						<?php 
					} ?>	      						
				</div>	
			</div>
		</section>
	</div>
<?php get_footer(); ?>