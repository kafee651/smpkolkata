<?php 
 	
	get_header(); 
	
	if ( have_posts() ){ while (have_posts()){ the_post(); global $post;

		$theneeds_sidebar = '';
		
		$theneeds_left_sidebar = '';
		
		$theneeds_right_sidebar = '';

		$theneeds_sidebar_class = '';
		
		$theneeds_campaign_caption = '';
		
		/* Get Post Meta Elements detail */
		
		$theneeds_campaigndetail_xml = get_post_meta($post->ID, 'campaigndetail_xml', true);
		
		if($theneeds_campaigndetail_xml <> ''){
			
			$theneeds_team_xml = new DOMDocument ();
			
			$theneeds_team_xml->loadXML ( $theneeds_campaigndetail_xml );
			
			$theneeds_sidebar = theneeds_find_xml_value($theneeds_team_xml->documentElement,'sidebar_campaign');
			
			$theneeds_left_sidebar = theneeds_find_xml_value($theneeds_team_xml->documentElement,'left_sidebar_campaign');
			
			$theneeds_right_sidebar = theneeds_find_xml_value($theneeds_team_xml->documentElement,'right_sidebar_campaign');
			
			$theneeds_campaign_caption = theneeds_find_xml_value($theneeds_team_xml->documentElement,'campaign_post_caption');
		}

		$theneeds_content_class = '';
		
		$theneeds_sidebar_class = theneeds_sidebar_func($theneeds_sidebar);
	
	?>
	
	<div id="inner-banner">
		<div class="container">
		  <h1><?php esc_html_e('Campaign Details','theneeds');?></h1>
		  <em><?php echo esc_attr($theneeds_campaign_caption);?></em>
			<?php /* Breadcrumb Only */
			$theneeds_breadcrumbs = '';
			$theneeds_breadcrumbs = theneeds_get_themeoption_value('breadcrumbs','general_settings');
			
			if($theneeds_breadcrumbs == 'enable'){?>

				<?php echo theneeds_breadcrumbs(); 

			} /* breadcrumbs ends */ 
			?>
		</div>
	</div>
					
	<div id ="main">	
		<section class="causes-style-1 causes-detail news-grid campaign-details">
			<div class="container">
				<div class="row">
					<?php /* Sidebar Settings */
					if($theneeds_sidebar == "left-sidebar" || $theneeds_sidebar == "both-sidebar" || $theneeds_sidebar == "both-sidebar-left"){?>
						<div id="block_first" class="sidebar side-bar <?php echo esc_attr($theneeds_sidebar_class[0]);?>">
							<?php 	
								dynamic_sidebar( $theneeds_left_sidebar );
							?>
						</div>
						<?php
					} /* Sidebar Settings */
					if($theneeds_sidebar == 'both-sidebar-left'){?>
						<div id="block_first_left" class="sidebar side-bar <?php echo esc_attr($theneeds_sidebar_class[0]);?>">
							<?php 	
								dynamic_sidebar( $theneeds_right_sidebar );
							?>
						</div>
					<?php } ?>
					<!-- HTML Content -->
					<div id="<?php the_ID(); ?>" class="<?php echo esc_attr($theneeds_sidebar_class[1]);?>">
						<div <?php post_class(); ?>>
						<?php
							/* Get Campaign Object */
							$campaign = charitable_get_current_campaign();
							
							/* Percentage Donated */
							$percentage_donated_raw = intval($campaign->get_percent_donated_raw());
							
							/* Days Left */
							$campaign_days_left = $campaign->get_time_left();
							
							/* Get Donor Count */
							$campaign_donor_count = $campaign->get_donor_count();
							
							/* Get Currency Symbol */
							$currency_symbol = Charitable_Currency::get_currency_symbol();
							
							/* Initialize Variables */
							$donated_amount = $goal_amount = $needed_amount = '';
							
							/* Campaign Goal */
							$goal_amount = $campaign->sanitize_campaign_goal( $campaign->get( 'goal' ) );
							
							/* Donated Amount */
							$donated_amount = intval($campaign->get_donated_amount());
							
							/* Amount Left */
							$needed_amount = $goal_amount - $donated_amount; ?>	
						
							<!-- Main Content -->
							<div class="box">
							  <div class="frame"><?php echo get_the_post_thumbnail($post->ID, array(650,450));?></div>
							  <div class="text-box">
								<div class="causes-goal-box">
								  <ul>
									<li> 
										<span class="title"><?php esc_html_e('Goal:','theneeds');?></span> 
										<strong class="amount"><sup><?php echo esc_attr($currency_symbol);?></sup><?php echo esc_attr(intval($goal_amount));?></strong> 
									</li>
									<li> 
										<span class="title"><?php esc_html_e('Raised:','theneeds');?></span> 
										<strong class="amount"><sup><?php echo esc_attr($currency_symbol);?></sup><?php echo esc_attr($donated_amount);?></strong> 
									</li>
									<li> 
										<span class="title"><?php esc_html_e('Donators:','theneeds');?></span>
										<strong class="amount"><?php echo esc_attr($campaign_donor_count) . esc_html__('Donors','theneeds');?></strong>
									</li>
									<li> 
										<span class="title"><?php esc_html_e('Time Remain:','theneeds');?></span>
										<strong class="amount"><?php echo html_entity_decode($campaign_days_left);?></strong> 
									</li>
								  </ul>
								  <div class="pie-title-center demo-pie-1" data-percent="<?php echo esc_attr($percentage_donated_raw);?>"> 
									<span class="pie-value"></span>
									<b><?php esc_html_e('completed','theneeds');?></b> 
								  </div>
								</div>
								<a href="<?php echo esc_url(charitable_get_permalink( 'campaign_donation_page', array( 'campaign' => $campaign ) ));?>" class="btn-style-1"><?php esc_html_e('Donate Now','theneeds');?><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> 
							  </div>
							</div>
							<div class="style-1">
							  <div class="text-box">
								<h3><?php echo esc_attr(get_the_title()); ?></h3>
								<div class="btn-row">
									<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>" class="link"><i class="fa fa-user" aria-hidden="true"></i><?php echo esc_attr(get_the_author());?></a>
									<a class="link"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo esc_attr(get_the_date());?></a>
								</div>
								<div class = "the-content">
									<?php 
									/* Campaign Content */ 
										echo wpautop($campaign->description); 
									?>
									<blockquote>
										<p><?php echo esc_attr($campaign->post_content);?></p>
									</blockquote>
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
					</div>
					<?php /* Sidebar Settings */
					if($theneeds_sidebar == "both-sidebar-right"){?>
						<div class="<?php echo esc_attr($theneeds_sidebar_class[0]);?> side-bar">
							<?php 	
								dynamic_sidebar( $theneeds_left_sidebar );
							?>
						</div>
						<?php
					} /* Sidebar Settings */
					if($theneeds_sidebar == 'both-sidebar-right' || $theneeds_sidebar == "right-sidebar" || $theneeds_sidebar == "both-sidebar"){?>
						<div class="<?php echo esc_attr($theneeds_sidebar_class[0]);?> side-bar">
							<?php 	
								dynamic_sidebar( $theneeds_right_sidebar );
							?>
						</div>
					<?php } ?>				
				</div>
			</div>
		</section>
	</div>
<?php 
	}
  }
get_footer(); 
?>