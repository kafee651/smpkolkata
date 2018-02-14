<?php /*
	
* CrunchPress Headers File
*---------------------------------------------------------------------*
* @version		1.0
* @author		CrunchPress
* @link			http://crunchpress.com
* @copyright	Copyright (c) CrunchPress 
 *---------------------------------------------------------------------*
 	This file Contain all the custom Built in function *
	Developer Note: do not update this file.*
 ---------------------------------------------------------------------*/

	function theneeds_footer_style_1(){ ?>
	
		<footer id="footer">
			<section class="footer-section-1">
			  <div class="container">
				<div class="row">
					<?php dynamic_sidebar('sidebar-footer'); ?>
				</div>
			  </div>
			</section>
			<?php /* If Instagram Widget exists */
			if(is_active_sidebar('Instagram')){ ?>
				<section class="instagram-row">
				  <div class="container">
					<h3><?php esc_html_e('Follow us on Instagram','theneeds');?></h3>
					<?php dynamic_sidebar('Instagram'); ?>
				  </div>
				</section>
			<?php } ?>
			<section class="copyrights-section">
				<?php	
					/* getting copyright text from back-end settings */
					$theneeds_copyright = theneeds_get_themeoption_value('copyright_code','general_settings');
					if(!empty($theneeds_copyright)){ 
						$allowed_html = array(
							'a' => array(
								'href' => array(),
								'title' => array()
							),
							'br' => array(),
							'em' => array(),
							'strong' => array(),
						);
					}
					?>
				<strong class="copy"><?php echo wp_kses($theneeds_copyright, $allowed_html); ?></strong>
			</section>
		</footer>

	<?php
	
	} /* function ends here */
	
	
	function theneeds_footer_style_2(){ ?>
	
		<footer id="footer" class="footer-style-2"> 
			<!--NEWSLETTER SECTION START-->
			<section class="newsletter-section">
			  <div class="holder">
				<div class="container">
					<?php /* Newsletter Title */
						$newsletter_title = '';
						$newsletter_title = theneeds_get_themeoption_value('newsletter_title','general_settings');
						
						$newsletter_mailpoet_ID = '';
						$newsletter_mailpoet_ID = theneeds_get_themeoption_value('newsletter_mailpoet_ID','general_settings');
						
					?>
				  <h3><?php echo esc_attr($newsletter_title);?></h3>
				  <?php if(shortcode_exists('wysija_form')){ echo do_shortcode('[wysija_form id="'.esc_attr($newsletter_mailpoet_ID).'"]');}?>
				</div>
			  </div>
			</section>
			
			<section class="footer-2-logo-row">
				<?php /* Footer Logo */
					$footer_logo = '';
					$footer_logo = theneeds_get_themeoption_value('footer_logo','general_settings');
					
					$footer_description = '';
					$footer_description = theneeds_get_themeoption_value('footer_description','general_settings');
					
				?>
				<?php if(!empty($footer_logo)) { ?>
						<strong class="footer-logo">
							<a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo esc_url($footer_logo);?>" alt="<?php esc_html__('footer_logo','theneeds'); ?>"></a>
						</strong>
				<?php } ?>
				
				<?php if(!empty($footer_description)) { ?>
						<div class="holder">
							<p><?php echo esc_attr($footer_description);?></p>
						</div>
				<?php } ?>
						<div class="container">
							<div class="row">
							  <div class="col-md-4">
								<?php /* Address Fields */
									$street_address = '';
									$street_address = theneeds_get_themeoption_value('street_address','general_settings');
									
									$location_address = '';
									$location_address = theneeds_get_themeoption_value('location_address','general_settings');
								?>
								<?php if(!empty($street_address) || !empty($location_address)){ ?>
								<div class="style-2-box">
								  <p><?php echo esc_attr($street_address);?>,
									<?php echo esc_attr($location_address); ?>.</p>
								</div>
								<?php } ?>
							  </div>
							  <div class="col-md-4">
								<?php /* Skype & Phone */
									$skype_address = '';
									$skype_address = theneeds_get_themeoption_value('skype_address','general_settings');
									
									$footer_contact_number = '';
									$footer_contact_number = theneeds_get_themeoption_value('footer_contact_number','general_settings');
								?>
								<?php if(!empty($skype_address) || !empty($footer_contact_number)){ ?>
								<div class="style-2-box">
								  <p><?php echo esc_attr($footer_contact_number); ?></p>
								  <p><?php echo esc_attr($skype_address);?></p>
								</div>
								<?php } ?>
							  </div>
							  <div class="col-md-4">
								<?php /* Website & Email */
									$email_address = '';
									$email_address = theneeds_get_themeoption_value('email_address','general_settings');
									
									$footer_website = '';
									$footer_website = theneeds_get_themeoption_value('footer_website','general_settings');
								?>
								<?php if(!empty($email_address) || !empty($footer_website)){ ?>
								<div class="style-2-box"> 
									<a href="mailto:<?php echo is_email($email_address);?>"><?php echo is_email($email_address);?></a>
									<a href="<?php echo esc_url($footer_website); ?>"><?php echo esc_url($footer_website); ?></a> 
								</div>
								<?php } ?>
							  </div>
							</div>
						</div>
			</section>
			
			<section class="footer-social">
			  <ul>
				<?php /* Footer Social Icons */
					$social_networking = '';
					$social_networking = theneeds_get_themeoption_value('social_networking','general_settings');
						if($social_networking == 'enable'){
							theneeds_social_icons_footer();
						}
				?>
			  </ul>
			</section>
			
			<section class="footer-section-3">
			  <div class="container">
				<div class="row">
					<div class=" col-md-6">
						<div class="footer-menu">
							<?php wp_nav_menu( array( 'menu'=> 'topbar-menu', 'menu_class' => 'sidebar-nav mm-menu__items footer-menu', )); ?>
						</div>
					</div>
					<div class="col-md-6"> 
					<?php	
						/* getting copyright text from back-end settings */
						$theneeds_copyright = theneeds_get_themeoption_value('copyright_code','general_settings');
						if(!empty($theneeds_copyright)){ ?>
							<strong class="copyrights"><?php echo esc_attr($theneeds_copyright); ?></strong>
						<?php } ?>
					</div>
				</div>
			  </div>
			</section>
		</footer>
		
	<?php
	
	} /* function ends here */
	
	function theneeds_footer_style_3(){ ?>
	
		 <footer id="footer" class="footer-3"> 
			<!--NEWSLETTER SECTION START-->
			<section class="footer-section-1">
			  <div class="container">
				<div class="row">
					<?php dynamic_sidebar('sidebar-footer'); ?>
				</div>
			  </div>
			</section>

			<section class="footer-section-3">
			  <div class="container">
				<div class="row">
				  <div class=" col-md-6">
					<div class="footer-menu">
					  <?php wp_nav_menu( array( 'menu'=> 'topbar-menu', 'menu_class' => 'sidebar-nav mm-menu__items', )); ?>
					</div>
				  </div>
				  <div class="col-md-6"> 
					<?php	
					/* getting copyright text from back-end settings */
					$theneeds_copyright = theneeds_get_themeoption_value('copyright_code','general_settings');
					if(!empty($theneeds_copyright)){ ?>
						<strong class="copyrights"><?php echo esc_attr($theneeds_copyright); ?></strong>
					<?php } ?>
				  </div>
				</div>
			  </div>
			</section>
		</footer>
		
	<?php
	
	} /* function ends here */

	function theneeds_footer_style_4(){
	
	
		/* Getting Values of Footer Sections */
		$footer_4_title1 = theneeds_get_themeoption_value('footer_4_title1','general_settings');
		$footer_4_title2 = theneeds_get_themeoption_value('footer_4_title2','general_settings');
		$footer_4_title3 = theneeds_get_themeoption_value('footer_4_title3','general_settings');
		
		$footer_4_desc1 = theneeds_get_themeoption_value('footer_4_desc1','general_settings');
		$footer_4_desc2 = theneeds_get_themeoption_value('footer_4_desc2','general_settings');
		$footer_4_desc3 = theneeds_get_themeoption_value('footer_4_desc3','general_settings');
		
		$footer_4_link1 = theneeds_get_themeoption_value('footer_4_link1','general_settings');
		$footer_4_link2 = theneeds_get_themeoption_value('footer_4_link2','general_settings');
		$footer_4_link3 = theneeds_get_themeoption_value('footer_4_link3','general_settings');
	?>


		<footer id="footer" class="footer-2"> 
			<section class="footer-section-1">
			  <div class="container">
				<div class="row">
				  <div class="col-md-4 col-sm-4">
					<div class="footer-box">
					  <h3><?php if(!empty($footer_4_title1)){echo esc_attr($footer_4_title1);}?></h3>
					  <p><?php if(!empty($footer_4_desc1)){echo esc_textarea($footer_4_desc1);}?></p>
					  <a href="<?php if(!empty($footer_4_link1)){echo esc_url($footer_4_link1);}?>" class="btn-style-2"><?php esc_html_e('Read More','theneeds');?></a> 
					</div>
				  </div>
				  <div class="col-md-4 col-sm-4">
					<div class="footer-box">
					  <h3><?php if(!empty($footer_4_title2)){echo esc_attr($footer_4_title2);}?></h3>
					  <p><?php if(!empty($footer_4_desc2)){echo esc_textarea($footer_4_desc2);}?></p>
					  <a href="<?php if(!empty($footer_4_link2)){echo esc_url($footer_4_link2);}?>" class="btn-style-2"><?php esc_html_e('Get Free Quote','theneeds');?></a> 
					</div>
				  </div>
				  <div class="col-md-4 col-sm-4">
					<div class="footer-box">
					  <h3><?php if(!empty($footer_4_title3)){echo esc_attr($footer_4_title3);}?></h3>
					  <?php if(!empty($footer_4_desc3)){ echo wpautop($footer_4_desc3);}?>
					  <?php if(!empty($footer_4_link3)){ ?>
						<a href="<?php if(!empty($footer_4_link3)){echo esc_url($footer_4_link3);}?>" class="btn-style-2"><?php esc_html_e('Contact Us','theneeds');?></a> 
					  <?php } ?>
					  <div class="footer-social">
						<ul>
							<?php /* Footer Social Icons */
							$social_networking = '';
							$social_networking = theneeds_get_themeoption_value('social_networking','general_settings');
								if($social_networking == 'enable'){
									theneeds_social_icons_footer();
								}
							?>
						</ul>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</section>

			<section class="footer-section-3">
			  <div class="container">
				<div class="row">
				  <div class=" col-md-6">
					<div class="footer-menu">
					  <?php wp_nav_menu( array( 'menu'=> 'topbar-menu', 'menu_class' => 'sidebar-nav mm-menu__items', )); ?>
					</div>
				  </div>
				  <div class="col-md-6"> 
					<?php	
					/* getting copyright text from back-end settings */
					$theneeds_copyright = theneeds_get_themeoption_value('copyright_code','general_settings');
					if(!empty($theneeds_copyright)){ ?>
						<strong class="copyrights"><?php echo esc_attr($theneeds_copyright); ?></strong>
					<?php } ?>
				  </div>
				</div>
			  </div>
			</section>
		</footer>
		
	<?php
	
	} /* function ends here */
	
	function theneeds_footer_html($footer=""){
		
		$footer_style_apply = theneeds_get_themeoption_value('footer_style_apply','general_settings');
		if($footer_style_apply == 'enable'){$footer = 'enable';}else{}
		
		if($footer == 'Style 1'){
			theneeds_footer_style_1();
		}else if($footer == 'Style 2'){
			theneeds_footer_style_2();
		}else if($footer == 'Style 3'){
			theneeds_footer_style_3();
		}else if($footer == 'Style 4'){
			theneeds_footer_style_4();
		}else if($footer == 'Style 5'){
			theneeds_footer_style_5();
		}else if($footer == 'Style 6'){
			theneeds_footer_style_6();
		}else{
			$select_footer_cp = theneeds_get_themeoption_value('select_footer_cp','general_settings');
			if($select_footer_cp == 'Style 1'){
				theneeds_footer_style_1();
			}else if($select_footer_cp == 'Style 2'){
				theneeds_footer_style_2();
			}else if($select_footer_cp == 'Style 3'){
				theneeds_footer_style_3();
			}else if($select_footer_cp == 'Style 4'){
				theneeds_footer_style_4();
			}else if($select_footer_cp == 'Style 5'){
				theneeds_footer_style_5();
			}else if($select_footer_cp == 'Style 6'){
				theneeds_footer_style_6();
			}else{
				theneeds_footer_style_1();
			}
		}
	}
	
	/* Social Networking Icons */
	function theneeds_social_icons_footer($class=''){
		
		$theneeds_social_settings = get_option('social_settings');
		if($theneeds_social_settings <> ''){
			$theneeds_social = new DOMDocument ();
			$theneeds_social->loadXML ( $theneeds_social_settings );
			/* Social Networking Values */
			$facebook_network = theneeds_get_themeoption_value('facebook_network','social_settings');
			$twitter_network = theneeds_get_themeoption_value('twitter_network','social_settings');
			$delicious_network = theneeds_get_themeoption_value('delicious_network','social_settings');
			$google_plus_network = theneeds_get_themeoption_value('google_plus_network','social_settings');
			$linked_in_network = theneeds_get_themeoption_value('linked_in_network','social_settings');
			$youtube_network = theneeds_get_themeoption_value('youtube_network','social_settings');
			$flickr_network = theneeds_get_themeoption_value('flickr_network','social_settings');
			$vimeo_network = theneeds_get_themeoption_value('vimeo_network','social_settings');
			$pinterest_network = theneeds_get_themeoption_value('pinterest_network','social_settings');
			$Instagram_network = theneeds_get_themeoption_value('Instagram_network','social_settings'); 
			$github_network = theneeds_get_themeoption_value('github_network','social_settings'); 
			$skype_network = theneeds_get_themeoption_value('skype_network','social_settings');
			$dribble_network = theneeds_get_themeoption_value('dribble_network','social_settings');
			
		}
			/* Twitter */
			if(esc_attr($twitter_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($twitter_network);?>" title="Twitter"><i class="fa fa-twitter"></i></a></li>
			<?php }
			/* Facebook */
			if(esc_attr($facebook_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($facebook_network);?>" title="Facebook"><i class="fa fa-facebook"></i></a></li>
			<?php }
			/* Delicious */
			if(esc_attr($delicious_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($delicious_network);?>" title="Delicious"><i class="fa fa-delicious"></i></a></li>
			<?php }
			/* Google Plus */
			if(esc_attr($google_plus_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($google_plus_network);?>" title="Google Plus"><i class="fa fa-google-plus"></i></a></li>
			<?php }
			/* LinkedIn Network */
			if(esc_attr($linked_in_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($linked_in_network);?>" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
			<?php }
			/* Youtube */
			if(esc_attr($youtube_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($youtube_network);?>" title="Youtube"><i class="fa fa-youtube"></i></a></li>
			<?php }
			/* Flickr */
			if(esc_attr($flickr_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($flickr_network);?>" title="Flickr"><i class="fa fa-flickr"></i></a></li>
			<?php }
			/* Vimeo */
			if(esc_attr($vimeo_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($vimeo_network);?>" title="Vimeo"><i class="fa fa-vimeo-square"></i></a></li>
			<?php }
			/* Pinterest */
			if(esc_attr($pinterest_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($pinterest_network);?>" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
			<?php }
			/* Instagram */
			if(esc_attr($Instagram_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($Instagram_network);?>" title="Instagram"><i class="fa fa-instagram"></i></a></li>
			<?php }
			/* Github */
			if(esc_attr($github_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($github_network);?>" title="github"><i class="fa fa-github"></i></a></li>
			<?php }
			/* Skype */
			if(esc_attr($skype_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($skype_network);?>" title="Skype"><i class="fa fa-skype"></i></a></li>
			<?php }
			
			/* Dribble */
			if(esc_attr($dribble_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($dribble_network);?>" title="Skype"><i class="fa fa-dribbble"></i></a></li>
			<?php }
	} 