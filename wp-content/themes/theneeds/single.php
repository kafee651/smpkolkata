<?php 
get_header();
if (have_posts()){ while (have_posts()){ the_post(); global $post;

	/* Get Post Meta Elements detail */
	$theneeds_post_social = '';
	$theneeds_sidebar = '';
	$theneeds_right_sidebar = '';
	$theneeds_left_sidebar = '';
	$theneeds_thumbnail_types = '';
	$post_caption_field = '';
	$theneeds_post_caption_field = '';

	
	$theneeds_post_format = get_post_meta($post->ID, 'post_format', true);
	$theneeds_post_detail_xml = get_post_meta($post->ID, 'post_detail_xml', true);
	
	if($theneeds_post_detail_xml <> ''){
		
		$theneeds_post_xml = new DOMDocument ();
		$theneeds_post_xml->loadXML ( $theneeds_post_detail_xml );
		$theneeds_post_social = theneeds_find_xml_value($theneeds_post_xml->documentElement,'post_social');
		$theneeds_sidebar = theneeds_find_xml_value($theneeds_post_xml->documentElement,'sidebar_post');
		$theneeds_right_sidebar = theneeds_find_xml_value($theneeds_post_xml->documentElement,'right_sidebar_post');
		$theneeds_left_sidebar = theneeds_find_xml_value($theneeds_post_xml->documentElement,'left_sidebar_post');
		$theneeds_thumbnail_types = theneeds_find_xml_value($theneeds_post_xml->documentElement,'post_thumbnail');
		$theneeds_video_url_type = theneeds_find_xml_value($theneeds_post_xml->documentElement,'video_url_type');
		$theneeds_select_slider_type = theneeds_find_xml_value($theneeds_post_xml->documentElement,'select_slider_type');
		$theneeds_post_caption_field = theneeds_find_xml_value($theneeds_post_xml->documentElement,'post_caption_field');
		
	}
	
	if($theneeds_thumbnail_types == 'Video') {
		
		$custom_class = "video_class";
	
	}elseif($theneeds_thumbnail_types == 'Slider'){
		
		$custom_class = "slider_class";
	
	}else{
		
		$custom_class = '';
	}
	
	$theneeds_sidebar_class = '';
	$theneeds_get_post= get_post($post);
	
	/*Get Sidebar for page*/
	$theneeds_sidebar_class = theneeds_sidebar_func($theneeds_sidebar);
	$theneeds_breadcrumbs = '';
	$theneeds_breadcrumbs = theneeds_get_themeoption_value('breadcrumbs','general_settings');
	
?>
	<div id="inner-banner">
		<div class="container">
		  <h1><?php echo esc_attr(get_the_title());?></h1>
		  <em><?php echo esc_attr($theneeds_post_caption_field);?></em>
			<?php /* Breadcrumb Only */
			$theneeds_breadcrumbs = '';
			$theneeds_breadcrumbs = theneeds_get_themeoption_value('breadcrumbs','general_settings');
			
			if($theneeds_breadcrumbs == 'enable'){?>

				<?php echo theneeds_breadcrumbs(); 

			} /* breadcrumbs ends */ 
			?>
		</div>
	</div>
	
	
	<div id="main"> 
		<section class="blog-style-1 news-grid news-detail">
			<div class="container">
				<div class="row">
					<?php /* Sidebar Settings */
					if($theneeds_sidebar == "left-sidebar" || $theneeds_sidebar == "both-sidebar" || $theneeds_sidebar == "both-sidebar-left"){?>
						<div id="block_first" class="sidebar side-bar <?php echo esc_attr($theneeds_sidebar_class[0]);?>">
							<?php dynamic_sidebar( $theneeds_left_sidebar ); ?>
						</div>
						<?php
					}
					if($theneeds_sidebar == 'both-sidebar-left'){?>
						<div id="block_first_left" class="sidebar side-bar <?php echo esc_attr($theneeds_sidebar_class[0]);?>">
							<?php dynamic_sidebar( $theneeds_right_sidebar );?>
						</div>
					<?php 
					} 
					
					/* Content Section */
					$theneeds_get_post_cp = get_post($post);?>
					
					<div id="post-<?php the_ID(); ?>" class="<?php echo esc_attr($theneeds_sidebar_class[1]);?>">
						
						<?php /* Archive Date Partials */
							$archive_year  = get_the_time('Y'); 
							$archive_month = get_the_time('m'); 
							$archive_day   = get_the_time('d'); 
							
							/* Get Comment Count */
							$comment_count = wp_count_comments( $post->ID );
							$comment_count = $comment_count->total_comments;
						?>
						
						<div class="style-1">
							<?php if($theneeds_thumbnail_types == 'Video') { ?>
								<div class="frame video-added">
									<a> <?php echo theneeds_print_blog_thumbnail($post->ID, array(850,450));?></a>
								</div>
							<?php }else{ ?>
								<div class="frame">
									<a> <?php echo theneeds_print_blog_thumbnail($post->ID, 'full');?></a>
								</div>
							<?php } ?>
							
						  <div class="text-box">
							<h3><?php echo esc_attr(get_the_title());?></h3>
							<div class="clearfix">
							  <div class="btn-row"> 
								<a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ));?>" class="link"><i class="fa fa-user" aria-hidden="true"></i><?php echo esc_attr(get_the_author());?></a> 
								<a href="<?php echo esc_url(get_day_link( $archive_year, $archive_month, $archive_day));?>" class="link"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo esc_attr(get_the_date(get_option('date_format')));?></a>
								<a href="<?php echo esc_url(get_day_link( $archive_year, $archive_month, $archive_day));?>" class="link"><i class="fa fa-comment" aria-hidden="true"></i><?php echo esc_attr($comment_count);?> <?php esc_html_e(' Comments','theneeds');?></a> 
							  </div>
							</div>
							<div class = "the-content">
								<?php /* The Content */
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
							<div class="share-row"> <strong class="title"><?php esc_html_e('Share:','theneeds');?></strong>
							  <ul>
								<?php echo theneeds_include_social_shares();?>
							  </ul>
							</div>
							<div class="comment-box">
							  <?php comments_template(); ?>
							</div>
						  </div>
						</div>		
					</div>	
						
					<?php /* Sidebar Settings */
						if($theneeds_sidebar == "both-sidebar-right"){?>
							<div class="<?php echo esc_attr($theneeds_sidebar_class[0]);?> side-bar">
								<?php dynamic_sidebar( $theneeds_left_sidebar ); ?>
							</div>
						<?php
						}
						if($theneeds_sidebar == 'both-sidebar-right' || $theneeds_sidebar == "right-sidebar" || $theneeds_sidebar == "both-sidebar"){?>
								<div class="<?php echo esc_attr($theneeds_sidebar_class[0]);?> side-bar">
									<?php dynamic_sidebar( $theneeds_right_sidebar );?>
								</div>
						<?php 
						}
					?>				
				</div>
			</div>
		</section>
	</div>
<?php 
	}/*end of while statement*/

} /*end of if statement*/
get_footer(); ?>