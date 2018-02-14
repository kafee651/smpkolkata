<?php get_header(); 

if ( have_posts() ){ while (have_posts()){ the_post();

	global $post,$EM_Event;

	/* Get Post Meta Elements detail */

	$theneeds_sidebar = '';

	$theneeds_left_sidebar = '';

	$theneeds_right_sidebar = '';
	
	$theneeds_event_post_caption = '';

	$theneeds_event_detail_xml = get_post_meta($post->ID, 'event_detail_xml', true);

	if($theneeds_event_detail_xml <> ''){

		$theneeds_event_xml = new DOMDocument ();

		$theneeds_event_xml->loadXML ( $theneeds_event_detail_xml );

		$theneeds_sidebar = theneeds_find_xml_value($theneeds_event_xml->documentElement,'sidebar_event');

		$theneeds_left_sidebar = theneeds_find_xml_value($theneeds_event_xml->documentElement,'left_sidebar_event');

		$theneeds_right_sidebar = theneeds_find_xml_value($theneeds_event_xml->documentElement,'right_sidebar_event');
		
		$theneeds_event_post_caption = theneeds_find_xml_value($theneeds_event_xml->documentElement,'event_post_caption');
		
		

	}

	$theneeds_breadcrumbs =  theneeds_get_themeoption_value('breadcrumbs','general_settings');

	$theneeds_thumbnail_types = '';

	$theneeds_sidebar_class = '';
	
	$theneeds_get_post =get_post($post);

	/*Get Sidebar for page*/

	$theneeds_sidebar_class =  theneeds_sidebar_func($theneeds_sidebar);
	
	/* Event Timmings */
	
	if(!empty($EM_Event->start_time)){
												  
	  $theneeds_event_time = date("g:i a", strtotime($EM_Event->start_time)) .esc_attr(' to ','theneeds').  date("g:i a", strtotime($EM_Event->end_time));

	}
	
	/* Event Location */
	
	if($EM_Event){
		if(is_object($EM_Event->get_location())){
			if($EM_Event->get_location()->location_name){
				$theneeds_event_location = $EM_Event->get_location()->location_name;
			}
		}
	}else{
	
		$theneeds_event_location = '';
	}
	
	/* Event Date */
	$theneeds_formatted_event_date =  date(get_option('date_format'),strtotime($EM_Event->start_date));

	/* If banner is NOT Selected Then Display Breadcrumb Section */
		
		$theneeds_selected_banner = '';

			if($theneeds_breadcrumbs == 'enable'){ 
				
				if(!is_front_page()){ ?>
				
					<div id="inner-banner">
						<div class="container">
						  <h1><?php esc_html_e('Event Details','theneeds');?></h1>
						  <em><?php echo esc_attr($theneeds_event_post_caption);?></em>
							<?php /* Breadcrumb Only */
				
							$theneeds_breadcrumbs = theneeds_get_themeoption_value('breadcrumbs','general_settings');
							
							if($theneeds_breadcrumbs == 'enable'){?>

								<?php echo theneeds_breadcrumbs(); 

							} /* breadcrumbs ends */ ?>
						</div>
					</div>
				<?php 
				}
			}
		?>		
		
		<div class="cp-main-content"> 
   
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
					} ?>

					<div id="<?php the_ID(); ?>" class="<?php echo esc_attr($theneeds_sidebar_class[1]);?> <?php echo esc_attr($theneeds_thumbnail_types);?>">
						
						<?php /* Event Meta */
							$theneeds_event_year = date('Y',$EM_Event->start);
							$theneeds_event_year2dig = date('y',$EM_Event->start);
							$theneeds_event_month = date('m',$EM_Event->start);
							$theneeds_event_month_alpha = date('M',$EM_Event->start);
							$theneeds_event_day = date('d',$EM_Event->start);
							$theneeds_event_start_time_count = date("G,i,s", strtotime($EM_Event->start_time));
						?>
						
						<div class="style-1">
						  <div class="frame"> <?php echo get_the_post_thumbnail($EM_Event->post_id, array(850,450));?> 
							<div class="event-timer">
							  <div class="defaultCountdown<?php echo esc_attr($EM_Event->post_id);?>"></div>
							</div>
						  </div>
						  <div class="text-box">
							<h3><?php echo esc_attr(get_the_title()); ?></h3>
							<div class="clearfix">
							  <div class="btn-row"> 
								<a class="link"><i class="fa fa-user" aria-hidden="true"></i><?php echo esc_attr(get_the_author());?></a> 
								<a class="link"><i class="fa fa-clock-o" aria-hidden="true"></i>
									<?php echo esc_attr($theneeds_event_day) . ' ' .esc_attr($theneeds_event_month_alpha);?>, <?php echo esc_attr($theneeds_event_year);?> 
								</a>
								<a class="link"><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo esc_attr($theneeds_event_location);?></a> 
							  </div>
							</div>
							<div class = "the-content">
								<?php 
								/* Event Content */
									$theneeds_content = str_replace(']]>', ']]&gt;',$EM_Event->post_content); 
									
									echo wpautop(do_shortcode($theneeds_content));
								?>
							</div>

							<div class="share-row"> <strong class="title"><?php esc_html_e('Share:','theneeds');?></strong>
							  <ul>
								<?php echo theneeds_include_social_shares();?>
							  </ul>
							</div>
							
							<div class="event-booking-form">
								<strong class="title booking-form-title"><?php esc_html_e('Booking Form','theneeds')?></strong>
								<div class="search-form">
									<?php theneeds_booking_form_event_manager();?>							
								</div>
							</div>
							
							<div class="comment-box">
								<?php comments_template(); ?>
							</div>
						  </div>
						</div>
						<script>
							jQuery(function () {
								"use strict";
								var austDay = new Date();
								austDay = new Date(<?php echo esc_js(intval($theneeds_event_year));?>, <?php echo esc_js(intval($theneeds_event_month));?>-1, <?php echo esc_js(intval($theneeds_event_day));?>,<?php echo esc_js(intval($theneeds_event_start_time_count));?>)
								jQuery('.defaultCountdown<?php echo esc_attr($EM_Event->post_id); ?>').countdown({
									labels: ['<?php esc_html_e('YRS','theneeds');?>', '<?php esc_html_e('MNTH','theneeds');?>', '<?php esc_html_e('Weeks','theneeds');?>', '<?php esc_html_e('Days','theneeds');?>', '<?php esc_html_e('HRS','theneeds');?>', '<?php esc_html_e('MIN','theneeds');?>', '<?php esc_html_e('SEC','theneeds');?>'],
									until: austDay
								});
								jQuery('#year').text(austDay.getFullYear());
							});                
						</script>	
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
					} ?>				

				</div><!--End of row-->
				
			</div><!--End of container-->

		</section><!--End of section-->

	</div><!--End of main -->
<?php 
	}
}
get_footer(); ?>