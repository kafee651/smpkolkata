<?php 
 	
	get_header(); 
	
	if ( have_posts() ){ while (have_posts()){ the_post(); global $post;
	
		$theneeds_ignition_date = get_post_meta($post->ID, 'ign_fund_end', true);
		
		$theneeds_ignition_datee = date('d-m-Y h:i:s',strtotime($theneeds_ignition_date));

		$theneeds_ign_project_id = get_post_meta($post->ID, 'ign_project_id', true);

		$theneeds_ign_fund_goal = get_post_meta($post->ID, 'ign_fund_goal', true);
		
		$theneeds_thumbnail_id = get_post_thumbnail_id( $post->ID, 'ign_project_id', true );
		
		$theneeds_thumbnail = wp_get_attachment_image_src( $theneeds_thumbnail_id , array(650,450) );

		$theneeds_ignition_value = '';
		
		$theneeds_sidebar = '';
		
		$theneeds_left_sidebar = '';
		
		$theneeds_right_sidebar = '';
		
		$projects_address = '';
		
		$ignition_post_caption = '';

		/* Get Post Meta Elements detail */
		
		$theneeds_ignition_detail_xml = get_post_meta($post->ID, 'ignition_detail_xml', true);
		
		if($theneeds_ignition_detail_xml <> ''){
			
			$theneeds_team_xml = new DOMDocument ();
			
			$theneeds_team_xml->loadXML ( $theneeds_ignition_detail_xml );
			
			$theneeds_ignition_value = theneeds_find_xml_value($theneeds_team_xml->documentElement,'ignition_value');
			
			$theneeds_sidebar = theneeds_find_xml_value($theneeds_team_xml->documentElement,'sidebar_ignition');
			
			$theneeds_left_sidebar = theneeds_find_xml_value($theneeds_team_xml->documentElement,'left_sidebar_ignition');
			
			$theneeds_right_sidebar = theneeds_find_xml_value($theneeds_team_xml->documentElement,'right_sidebar_ignition');
			
			$projects_address = theneeds_find_xml_value($theneeds_team_xml->documentElement,'projects_address');
			
			$ignition_post_caption = theneeds_find_xml_value($theneeds_team_xml->documentElement,'ignition_post_caption');

			
		}
		
	
	
		$theneeds_getPledge_cp = theneeds_getPledge_cp($theneeds_ign_project_id);
		
		$theneeds_current_date = date('d-m-Y h:i:s');
		
		$theneeds_project_date = new DateTime($theneeds_ignition_datee);
		
		$theneeds_current = new DateTime($theneeds_current_date);
		
		$theneeds_days = round(($theneeds_project_date->format('U') - $theneeds_current->format('U')) / (60*60*24));
	
		$theneeds_currency = get_option('currency_code_default');
		
		$theneeds_purchase_url = '';
		$theneeds_purchaseform = '';
		$theneeds_sidebar_class = '';
		$theneeds_content_class = '';
		
		$theneeds_sidebar_class = theneeds_sidebar_func($theneeds_sidebar);
	
	?>
	<div id="inner-banner">
		<div class="container">
		  <h1><?php esc_html_e('Cause Details','theneeds');?></h1>
		  <em><?php echo esc_attr($ignition_post_caption);?></em>
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
		<section class="causes-style-1 causes-detail news-grid">
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
						<?php /* If submitted */
							if (isset($_GET['purchaseform'])) {
								echo do_shortcode('[project_purchase_form]');
							}else{ ?>
							
							<?php /* Get Currency Code */
								$currency_code = '';
								$theneeds_project = new ID_Project($theneeds_ign_project_id);
								$currency_code = $theneeds_project->currency_code();
						
							  /* Pledge Counter */
							
								$theneeds_getPledge = array();
								$theneeds_getPledge = theneeds_getPledge_cp($theneeds_ign_project_id);
								
								/* Raised Amount */
								
								$theneeds_raised = '';
								$theneeds_raised = apply_filters('id_funds_raised', $theneeds_project->get_project_raised(), $theneeds_project->get_project_postid());
							
								/* Remove Currency Symbol from Raised Amount */
								$theneeds_raised = str_replace($currency_code,'',$theneeds_raised);
							?>
							
							<!-- Main Content -->
							<div class="box">
							  <div class="frame"><a><img src="<?php echo esc_url($theneeds_thumbnail[0]);?>" alt="<?php echo esc_html__('causes-details','theneeds');?>"></a></div>
							  <div class="text-box">
								<div class="causes-goal-box">
								  <ul>
									<li> 
										<span class="title"><?php esc_html_e('Goal:','theneeds');?></span> 
										<strong class="amount"><sup><?php echo esc_attr($currency_code);?></sup><?php echo esc_attr(intval($theneeds_ign_fund_goal));?></strong> 
									</li>
									<li> 
										<span class="title"><?php esc_html_e('Raised:','theneeds');?></span> 
										<strong class="amount"><sup><?php echo esc_attr($currency_code);?></sup><?php echo esc_attr($theneeds_raised);?></strong> 
									</li>
									<li> 
										<span class="title"><?php esc_html_e('Donators:','theneeds');?></span>
										<strong class="amount"><?php echo esc_attr($theneeds_getPledge[0]->p_number) . esc_html__('Donors','theneeds');?></strong>
									</li>
									<li> 
										<span class="title"><?php esc_html_e('Time Remain:','theneeds');?></span>
										<strong class="amount"><?php if($theneeds_days < 0){ echo esc_html__('0 Days Left','theneeds'); }else{echo esc_attr($theneeds_days) . esc_html__(' Days Left','theneeds');}?></strong> 
									</li>
								  </ul>
								  <div class="pie-title-center demo-pie-1" data-percent="<?php echo esc_attr(theneeds_getPercentRaised_cp($theneeds_ign_project_id));?>"> 
									<span class="pie-value"></span>
									<b><?php esc_html_e('completed','theneeds');?></b> 
								  </div>
								</div>
								<a href="<?php echo theneeds_getPurchaseURLfromType($theneeds_ign_project_id, "purchaseform");?>" class="btn-style-1"><?php esc_html_e('Donate Now','theneeds');?><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a> 
							  </div>
							</div>
							<div class="style-1">
							  <div class="text-box">
								<h3><?php echo esc_attr(get_the_title()); ?></h3>
								<div class="btn-row">
									<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>" class="link"><i class="fa fa-user" aria-hidden="true"></i><?php echo esc_attr(get_the_author());?></a>
									<a class="link"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo esc_attr(get_the_date());?></a>
									<a class="link"><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo esc_attr($projects_address);?></a> 
								</div>
								<div class = "the-content">
									<?php /* Project Content */ the_content(); ?>
									<?php /* Project Levels */
									
									$theneeds_project_type = get_post_meta( $post->ID, "ign_project_type", true );
									$theneeds_meta_no_levels = get_post_meta( $post->ID, $name="ign_product_level_count", true );
									
									if($theneeds_project_type == 'level-based'){ ?>
							
										<h3><?php esc_html_e('Project Levels','theneeds');?></h3>
										<div class="donors-list">
											<ul>
												<?php /* Each Leve Meta Description */
													$i = 1;
													$theneeds_meta_title = stripslashes(get_post_meta( $post->ID, $name="ign_product_title", true ));
													$theneeds_meta_limit = get_post_meta( $post->ID, $name="ign_product_limit", true );
													$theneeds_meta_price = get_post_meta( $post->ID, $name="ign_product_price", true );
													$theneeds_meta_desc = stripslashes(get_post_meta( $post->ID, $name="ign_product_details", true ));
													$theneeds_short_desc = stripslashes(get_post_meta( $post->ID, $name="ign_product_short_description", true ));
												?>
												<!-- Table Headers -->
												<li>
													<span class="number"><?php echo esc_attr($i);?></span> 
													<strong class="title"><?php echo esc_attr($theneeds_meta_title);?> <?php echo esc_attr($theneeds_short_desc);?></strong> 
													<strong class="amount"><?php echo esc_attr($theneeds_meta_price);?> 
														<span>
															<a href="<?php echo theneeds_getPurchaseURLfromType($theneeds_ign_project_id, "purchaseform");?>" class="btn-donate"><?php esc_html_e('Donate','theneeds');?></a>
														</span>
													</strong> 
												</li>
												
												<?php /* Table Rows */
												for ($i=2 ; $i <= $theneeds_meta_no_levels ; $i++) {
													
													$theneeds_meta_title = stripslashes(get_post_meta( $post->ID, $name="ign_product_level_".($i)."_title", true ));
													$theneeds_meta_limit = get_post_meta( $post->ID, $name="ign_product_level_".($i)."_limit", true );
													$theneeds_meta_price = get_post_meta( $post->ID, $name="ign_product_level_".($i)."_price", true );
													$theneeds_meta_desc = stripslashes(get_post_meta( $post->ID, $name="ign_product_level_".($i)."_desc", true )); ?>
											
													<li>
														<span class="number"><?php echo esc_attr($i);?></span> 
														<strong class="title"><?php echo esc_attr($theneeds_meta_title);?> <?php echo esc_attr($theneeds_short_desc);?></strong> 
														<strong class="amount"><?php echo esc_attr($theneeds_meta_price);?> 
															<span>
																<a href="<?php echo theneeds_getPurchaseURLfromType($theneeds_ign_project_id, "purchaseform");?>" class="btn-donate"><?php esc_html_e('Donate','theneeds');?></a>
															</span>
														</strong> 
													</li>
													<?php
												} ?>  
											</ul>
										</div>
									<?php } /* endif project levels */ ?>
										
									<?php /* Causes Short/Long Description */ ?>
									<div class = "list-box">
										<!-- Short Description -->
										<div class = "cause_short_dec">
											<p><?php echo do_shortcode(html_entity_decode(get_post_meta( $post->ID, "ign_project_description", true ))); ?></p>
										</div>
										<!-- Long Description -->
											<?php echo do_shortcode(html_entity_decode(get_post_meta( $post->ID, "ign_project_long_description", true ))); ?>
										<!-- Cause Video Message -->
										<?php $theneeds_ign_product_video = get_post_meta( $post->ID, "ign_product_video", true ); ?>
										<!-- If Video Added -->
										<?php if(!empty($theneeds_ign_product_video)){ ?>
										<div class = "causes-video-message">
											<?php echo do_shortcode(html_entity_decode($theneeds_ign_product_video)); ?>
										</div>
										<?php } ?>
										
									</div>
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
						<?php } ?>
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