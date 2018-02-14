<?php
/**
 * The template for displaying featured content
 *
 * @package CrunchPress
 * @subpackage WP Theme
 */
	/* getting values from backend */
	$theneeds_num_excerpt = '';
	$theneeds_default_settings = get_option('default_pages_settings');

	if($theneeds_default_settings != ''){
		$theneeds_default = new DOMDocument ();
		$theneeds_default->loadXML ( $theneeds_default_settings );
		$theneeds_num_excerpt = theneeds_find_xml_value($theneeds_default->documentElement,'default_excerpt');
	}
	if($theneeds_num_excerpt == '' || $theneeds_num_excerpt == 0 ) {
		$theneeds_num_excerpt = 250;
	}
?>
	<div class="main-content margin-top-bottom">
		<div class="single_content blog_listing">
			<div id="<?php the_ID(); ?>" class="blog_post_detail cp_sticky_post">
			<?php
			/*
			 * Fires before the WP featured content.
			 *
			 * @since WP 1.0
			 */
		
			$theneeds_thumbnail_types = '';
			$theneeds_featured_posts = theneeds_get_featured_posts();
			foreach ( (array) $theneeds_featured_posts as $order => $post ) :
				setup_postdata( $post ); 
				$theneeds_thumbnail_types = '';
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
				}
				
				$theneeds_thumbnail_id = get_post_thumbnail_id( $post->ID );
				$theneeds_image_thumb = wp_get_attachment_image_src($theneeds_thumbnail_id, array(1170,600));
				$theneeds_image_thumb = wp_get_attachment_image_src($theneeds_thumbnail_id, 'full');
				$theneeds_mask_html = '';
				$theneeds_image_class = 'no-image';
				
				if(get_the_post_thumbnail($post->ID, array(1170,600)) <> ''){
					$theneeds_mask_html = '<div class="mask">
						<a href="'.esc_url(get_permalink()).'#comments" class="anchor"><span> </span> <i class="fa fa-comment"></i></a>
						<a href="'.esc_url(get_permalink()).'" class="anchor"> <i class="fa fa-link"></i></a>
					</div>';
					$theneeds_mask_html = 'image-exists';
				}			

				$theneeds_get_post_cp = get_post($post); 
				/* Markup */
				?>
				
				<div <?php post_class(); ?>>
					<div class="post-box">
						<div class="frame"> 
							<?php echo get_the_post_thumbnail($post->ID, array(850,450)); ?>
							<strong class="sticky"><?php esc_html_e('Sticky Post','theneeds');?></strong>
						</div>
						<div class="text-box">
							<h3><a href="<?php echo esc_url(get_the_permalink());?>"><?php echo esc_attr(get_the_title());?></a></h3>
								<div class="tags-row"> 
									<a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ));?>" class="link"><i class="fa fa-user" aria-hidden="true"></i><?php echo esc_attr(get_the_author());?></a> 
									<a href="<?php echo esc_url(get_the_permalink());?>" class="link"><i class="fa fa-calendar" aria-hidden="true"></i><?php echo esc_attr(get_the_date());?></a> 
									<a href="<?php echo esc_url(get_the_permalink());?>" class="link"><i class="fa fa-comments-o" aria-hidden="true"></i><?php echo esc_attr($comment_count);?></a> 
								</div>
								<div class = "index_content">
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
							<a href="<?php echo esc_url(get_the_permalink());?>" class="btn-readmore"><?php esc_html_e('Read Blog Detail','theneeds');?></a>
						</div>  
					</div>
				</div>
				<?php
			endforeach;
			/**
			 * Fires after the featured content.
			 *
			 * @since WP
			 */

			wp_reset_postdata(); ?> 
			</div><!-- .featured-content-inner -->
		</div><!-- #featured-content .featured-content -->
	</div><!-- #featured-content .featured-content -->