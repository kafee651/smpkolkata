<?php
/*
 * This file is used to generate WordPress standard archive/category pages.
 */
	get_header ();
	
	/* Get Default Option for Archives, Category, Search. */
	$theneeds_num_excerpt = '';
	$theneeds_default_settings = get_option('default_pages_settings');
	
	if($theneeds_default_settings != ''){
		$theneeds_default = new DOMDocument ();
		$theneeds_default->loadXML ( $theneeds_default_settings );
		$theneeds_sidebar = theneeds_find_xml_value($theneeds_default->documentElement,'sidebar_default');
		$theneeds_right_sidebar = theneeds_find_xml_value($theneeds_default->documentElement,'right_sidebar_default');
		$theneeds_left_sidebar = theneeds_find_xml_value($theneeds_default->documentElement,'left_sidebar_default');
		$theneeds_num_excerpt = theneeds_find_xml_value($theneeds_default->documentElement,'default_excerpt');
		
	}	
	/* Get Default Excerpt */
	$theneeds_num_excerpt = 250;

	if(empty($paged)){
		$paged = (get_query_var('page')) ? get_query_var('page') : 1; 
	}
	
	$theneeds_sidebar_class = '';
	$theneeds_content_class = '';
		
	/* Get Sidebar for page */
	$theneeds_sidebar_class = theneeds_sidebar_func($theneeds_sidebar);
	$theneeds_breadcrumbs = '';
	$theneeds_breadcrumbs = theneeds_get_themeoption_value('breadcrumbs','general_settings');
?>
	<div id="inner-banner">
		<div class="container">
		     <?php /* Only if it is search page */
				if (is_search()) { ?>
					<h1><?php esc_html_e('Searched', 'theneeds'); ?> : <?php echo esc_attr(get_search_query()); ?></h1>
					<em><?php esc_html_e('All Searched Results Listed Here On This Page.','theneeds');?></em>
			<?php } ?>
		</div>
	</div>

	<div id="main"> 
		<section class="blog-style-1 blog-space search_page">
			<div class="container">
				<div class="row">
					<?php /* Sidebar Settings */
						if($theneeds_sidebar == "left-sidebar" || $theneeds_sidebar == "both-sidebar" || $theneeds_sidebar == "both-sidebar-left"){?>
							<div id="block_first" class="sidebar side-bar <?php echo esc_attr($theneeds_sidebar_class[0]);?>">
								<aside>
									<div class="cp-sidebar">
										<?php if(is_active_sidebar($theneeds_left_sidebar)){ dynamic_sidebar( $theneeds_left_sidebar ); }?>
									</div>
								</aside>
							</div>
							<?php
						}
						if($theneeds_sidebar == 'both-sidebar-left'){?>
							<div id="block_first_left" class="sidebar side-bar <?php echo esc_attr($theneeds_sidebar_class[0]);?>">
								<aside>
									<div class="cp-sidebar">
										<?php if(is_active_sidebar($theneeds_right_sidebar)){  dynamic_sidebar( $theneeds_right_sidebar ); }?>
									</div>
								</aside>
							</div>
						<?php 
						} 
					?>
					
					<div id="search-<?php the_ID(); ?>" class="blog_listing blog-home <?php echo esc_attr($theneeds_sidebar_class[1]);?>">						
						<?php /* Loop */
							if ( have_posts() ) { 
	
								while ( have_posts() ) : the_post(); global $post; 
							
									/* Get Comment Count */
									$comment_count = wp_count_comments( $post->ID );
									
									$comment_count = $comment_count->total_comments; ?>
									
								<div class="cp_search_page">
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
									<?php 
								endwhile; /* endwhile */
							}else{ ?>
							
								<section class="error-section">
									<div class="inner">
									  <h1><?php esc_html_e('Oh!','theneeds');?></h1>
									  <span><?php esc_html_e('Nothing Found!','theneeds');?></span> 
									  <strong class="title"><?php esc_html_e('The Requested Search Not Found','theneeds');?></strong>
										<form method="get" action="<?php  echo esc_url(home_url('/')); ?>">
											<input type="text" placeholder="<?php esc_html_e('Enter your words for search again','theneeds');?>" value="<?php the_search_query(); ?>" name="s"  autocomplete="off" />
											<button type="submit" value="Search"><i class="fa fa-search"></i></button>
										</form>
									</div>
								</section>

								<?php 
							} ?>
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
						if($theneeds_sidebar == 'both-sidebar-right' || $theneeds_sidebar == "right-sidebar" || $theneeds_sidebar == "both-sidebar"){?>
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