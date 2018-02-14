<?php 
/*	
*	CrunchPress Headers File
*	---------------------------------------------------------------------
* 	@version	1.0
* 	@author		CrunchPress
* 	@link		http://crunchpress.com
* 	@copyright	Copyright (c) CrunchPress
*	---------------------------------------------------------------------
*	This file Contain all the custom Built in function 
*	Developer Note: do not update this file.
*	---------------------------------------------------------------------
*/

	function theneeds_header_style_1(){ 

		if(is_front_page()){
		
			$header_class = '';
			
		}else{
			
			$header_class = 'inner-header';
		
		}
	?>
	
		  <header id="header" class = "<?php echo esc_attr($header_class);?>">
			<section class="top-bar">
			  <div class="container">
				<div class="holder">
				  <div class="row">
					<div class="col-md-7">
					  <div class="left-box">
						<ul>
							<?php /* Language Dropdown */
							if ( class_exists( 'WPGlobus' ) ) { ?>
								<li> 
									<div class="dropdown">
									  <button class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <i class="fa fa-globe" aria-hidden="true"></i> <?php esc_html_e('Language: ENG ','theneeds');?> <i class="fa fa-angle-down" aria-hidden="true"></i> </button>
									  <ul class="dropdown-menu">
										<?php
											foreach( WPGlobus::Config()->enabled_languages as $lang ) {
												if ( $lang == WPGlobus::Config()->language ) {
													continue;
												}
												$flag = WPGlobus::Config()->flags_url . WPGlobus::Config()->flag[ $lang ];
												echo '<li><a href="' . WPGlobus_Utils::localize_current_url( $lang ). '">'.esc_attr(strtoupper($lang)).'</a></li>';
											}
										?>
									  </ul>	
									</div>
								</li>
							<?php } /* endif */ ?>
							
							<?php
								/* 1. Cause Link field */
								$theneeds_header_causes_link = '';
								$theneeds_header_causes_link = theneeds_get_themeoption_value('volunteer_page_link','general_settings'); 
								if(!empty($theneeds_header_causes_link)){
									echo '<li><a href="'.esc_url($theneeds_header_causes_link).'">'.esc_html__('Causes','theneeds').'</a></li>';
								}
							
								/* 2. Make Donation Link field */
								$theneeds_header_donation_link = '';
								$theneeds_header_donation_link = theneeds_get_themeoption_value('make_donation_link','general_settings'); 
								if(!empty($theneeds_header_donation_link)){
									echo '<li><a href="'.esc_url($theneeds_header_donation_link).'">'.esc_html__('Make Donation','theneeds').'</a></li>';
								}
							
								/* 3. Address field */
								$theneeds_header_address = '';
								$theneeds_header_address = theneeds_get_themeoption_value('volunteer_text','general_settings'); 
								if(!empty($theneeds_header_address)){
									echo '<li><i class="fa fa-map-marker" aria-hidden="true"></i>'.esc_attr($theneeds_header_address).'</li>';
								}
							?>
						</ul>
					  </div>
					</div>
					<div class="col-md-5">
						<div class="right-box">
							<div class="login-box"> 
								<?php /* Login & Signup */ echo theneeds_login_signup_btns(); ?>
							</div>
							<div class="topbar-social">
							  <ul>
								<?php /* Social Icons For Header */ theneeds_social_icons_list_header(); ?>
							  </ul>
							</div>
						</div>
					</div>
				  </div>
				</div>
			  </div>
			</section>
			<section class="logo-row">
			  <div class="container">
				<div class="holder"> <strong class="logo"><?php theneeds_default_logo(); ?></strong>
				  <nav class="navbar navbar-inverse">
					<div class="navbar-header">
					  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> 
						<span class="sr-only"><?php esc_html_e('Toggle navigation','theneeds');?></span> 
						<span class="icon-bar"></span> 
						<span class="icon-bar"></span> 
						<span class="icon-bar"></span> 
					  </button>
					</div>
					<div id="navbar" class="collapse navbar-collapse">
					  <?php echo theneeds_normal_menu('header-menu','header-menu'); ?>
					</div>
				  </nav>
				  <?php
				  /* Search Button */ 
					$search_btn = '';
					$search_btn = theneeds_get_themeoption_value('search_btn','general_settings');
					if($search_btn == 'enable'){ ?>
					  <div class="search-box">
						<div class="dropdown">
						  <button class="dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> 
							<i class="fa fa-search" aria-hidden="true"></i> 
						  </button>
						  <ul class="dropdown-menu">
							<li>
								<form method="get" action="<?php  echo esc_url(home_url('/')); ?>">
									<input name="s" type="text" value="<?php esc_attr(the_search_query()); ?>" placeholder="<?php esc_html_e('Enter Your Search','theneeds');?>" required>
								</form>
							</li>
						  </ul>
						</div>
					  </div>
					<?php } /* search ends here */ ?>
					<?php
						/* Get A Donate Link */
						$theneeds_header_donate_link = theneeds_get_themeoption_value('header_get_quote_link','general_settings'); 
						if(!empty($theneeds_header_donate_link)){
							echo '<a href="'.esc_url($theneeds_header_donate_link).'" class="btn-donate"><i class="fa fa-money" aria-hidden="true"></i>'.esc_html__('Donate','theneeds').'</a>';
						}
					?>
				</div>
			  </div>
			</section>
		</header>
		<?php 	
	}  
	/* End Of Header Function */
	
	/***************************************************************/
	
	/* Header 2 Start From Here*/
	
	function theneeds_header_style_2() { ?> 
	
		<header id="header" class="header-style-2">
			<section class="logo-row">
			  <div class="container-fluid">
				<div class="holder"> <strong class="logo"><?php theneeds_default_logo(); ?></strong>
				  <nav class="navbar navbar-inverse">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> 
							<span class="sr-only"><?php esc_html_e('Toggle navigation','theneeds');?></span> 
							<span class="icon-bar"></span> 
							<span class="icon-bar"></span> 
							<span class="icon-bar"></span>
						</button>
					</div>
					<div id="navbar" class="collapse navbar-collapse">
					  <?php echo theneeds_normal_menu('header-menu','header-menu'); ?>
					</div>
				  </nav>
				   <?php
					/* Search Button */ 
					$search_btn = '';
					$search_btn = theneeds_get_themeoption_value('search_btn','general_settings');
					if($search_btn == 'enable'){ ?>
					  <div class="search-box">
						<div class="dropdown">
							<button class="dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> 
								<i class="fa fa-search" aria-hidden="true"></i> 
							</button>
							<ul class="dropdown-menu">
								<li>
									<form method="get" action="<?php  echo esc_url(home_url('/')); ?>">
										<input name="s" type="text" value="<?php esc_attr(the_search_query()); ?>" placeholder="<?php esc_html_e('Enter Your Search','theneeds');?>" required>
									</form>
								</li>
							</ul>
						</div>
					  </div>
					<?php } /* search ends here */?>
					<?php
						/* Get A Donate Link */
						$theneeds_header_donate_link = theneeds_get_themeoption_value('header_get_quote_link','general_settings'); 
						if(!empty($theneeds_header_donate_link)){
							echo '<a href="#" class="btn-donate"><i class="fa fa-money" aria-hidden="true"></i>'.esc_html__('Donate','theneeds').'</a>';
						}
					?>
				</div>
			  </div>
			</section>
		  </header>

	<?php
	}  /* End Of Header Function */
	
	/************************************************************/

	function theneeds_header_style_3(){ ?>
		
	<header id="header" class="header-style-2 nav-style-3"> 
    <!--TOPBAR SECTION START-->
    <section class="topbar">
      <div class="container">
		<div class="left-box">
		  <ul>
			<?php /* Language Dropdown */
			if ( class_exists( 'WPGlobus' ) ) { ?>
				<li> 
					<i class="fa fa-globe" aria-hidden="true"></i> 
					<span><?php esc_html_e('Language: ','theneeds');?> </span>
					<button class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <?php esc_html_e('ENG ','theneeds');?> <i class="fa fa-angle-down" aria-hidden="true"></i> </button>
						<ul class="dropdown-menu">
							<?php
								foreach( WPGlobus::Config()->enabled_languages as $lang ) {
									if ( $lang == WPGlobus::Config()->language ) {
										continue;
									}
									$flag = WPGlobus::Config()->flags_url . WPGlobus::Config()->flag[ $lang ];
									echo '<li><a href="' . WPGlobus_Utils::localize_current_url( $lang ). '">'.esc_attr(strtoupper($lang)).'</a></li>';
								}
							?>
						</ul>
				</li>
			<?php } /* endif */ ?>
				<li><?php /* Mailing Address */ echo theneeds_mailto_field(); ?> </li>
				<li> 
				<?php
					/* Phone/Tel Button */
					$theneeds_header_contact_text = '';
					$theneeds_header_contact_text = theneeds_get_themeoption_value('header_contact_text','general_settings'); 
					$theneeds_contact_us_code = theneeds_get_themeoption_value('contact_us_code','general_settings'); 
					if(!empty($theneeds_contact_us_code)){
						echo ' <i class="fa fa-phone" aria-hidden="true"></i><span>'.esc_attr($theneeds_header_contact_text).' <a href="tel:'.esc_attr($theneeds_contact_us_code).'">'.esc_attr($theneeds_contact_us_code).'</a></span>';
					}
				?>
				</li>
		  </ul>
		</div>
        <div class="right-box">
          <div class="topbar-social">
            <ul>
             <?php /* Social Icons For Header */ theneeds_social_icons_list_header(); ?>
             <?php /* Login & Signup */ echo theneeds_login_signup_btns(); ?>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <!--TOPBAR SECTION END--> 
    
    <!--NAVIGATION ROW START-->
    <section class="navigation-row">
      <div class="container"> <strong class="logo"><?php theneeds_default_logo(); ?></strong>
        <div class="shop-box">
			<?php /* Cart Button */
			$cart_btn = theneeds_get_themeoption_value('cart_btn','general_settings');
			if($cart_btn == 'enable'){
				if ( class_exists( 'WooCommerce' ) ) { ?>
				  <div class="cart-box-outer">
					<div class="dropdown">
						<?php global $woocommerce; 
							/* If Woocommerce is object to avoid non-object issue */
							if(is_object($woocommerce)){ ?>
								<button class="dropdown-toggle" type="button" id="dropdownMenu12" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <i class="fa fa-shopping-bag" aria-hidden="true"></i><span class="number"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'theneeds'), $woocommerce->cart->cart_contents_count);?></span> </button>
								<?php 
							} ?>
							<ul class="dropdown-menu">
								<li><strong class="title"><?php esc_html_e('You have', 'theneeds');?> <i> <?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'theneeds'), $woocommerce->cart->cart_contents_count);?> <?php esc_html_e('item(s)', 'theneeds');?> </i> <?php esc_html_e('in your cart.', 'theneeds');?></strong></li>
								<li><?php /* Mini Cart */ if( function_exists( 'woocommerce_mini_cart' ) ) { woocommerce_mini_cart(); } ?></li>	
							</ul>
					</div>
				  </div>
					<?php 
				} 
			}
			
			/* Search Button */ 
			$search_btn = theneeds_get_themeoption_value('search_btn','general_settings');
			if($search_btn == 'enable'){ ?>
				  <div class="cp-search-holder">
					<button id="trigger-overlay" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
				  </div>
				<?php 
			} 
			
			/* Get A Donate Link */
			$theneeds_header_donate_link = theneeds_get_themeoption_value('header_get_quote_link','general_settings'); 
			if(!empty($theneeds_header_donate_link)){
				echo  '<a class="btn-donate" href="'.esc_url($theneeds_header_donate_link).'"><i aria-hidden="true" class="fa fa-money"></i>'.esc_html__('Donate','theneeds').'</a>';
			}
			?>
		</div>
      </div>
    </section>
    <!--NAVIGATION ROW END--> 
    
    <!--NAVIGATION STYLE 3 START-->
    <section class="navigation-row nav-style-3">
      <div class="container">
        <nav class="navbar navbar-inverse">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only"><?php esc_html_e('Toggle navigation','theneeds');?></span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
          </div>
          <div id="navbar" class="collapse navbar-collapse">
			 <?php echo theneeds_normal_menu('header-menu','header-menu'); ?>
          </div>
			<?php 
			/* Become A Volunteer Btn */
				$volunteer_text = '';
				$volunteer_page_link = '';
				$volunteer_text = theneeds_get_themeoption_value('volunteer_text','general_settings');
				$volunteer_page_link = theneeds_get_themeoption_value('volunteer_page_link','general_settings'); 
				$beamember_btn = theneeds_get_themeoption_value('beamember_btn','general_settings'); 					
				if($beamember_btn == 'enable'){
					if(!empty($volunteer_text) || !empty($volunteer_page_link)){
						echo '<a href="'.esc_url($volunteer_page_link).'" class="btn-volunteer">'.esc_attr($volunteer_text).'</a>';
					}
				}
			?>
		</nav>
      </div>
    </section>
    
	<div class="overlay overlay-contentscale">
	  <button type="button" class="overlay-close"><?php esc_html_e('Close','theneeds');?></button>
	  <!--Search Bar Inner Start-->
	  <div class="cp-search-inner">
		<form method="get" action="<?php  echo esc_url(home_url('/')); ?>">
		  <input name="s" type="text" value="<?php esc_attr(the_search_query()); ?>" placeholder="<?php esc_html_e('Enter Your Search','theneeds');?>" required>
		  <button class="submit"><i class="fa fa-search"></i></button>
		</form>
	  </div>
	</div> 
  </header>

	<?php 	
	}  
	/* End Of Header Function */
	
	/********************************************/
	
	function theneeds_header_style_4(){ ?>
	
	  <header class="header-style-3">
		<div class=" container">
		  <div class="head-top-2"> <strong class="header-3-logo"><?php theneeds_default_logo(); ?></strong>
			<div class="left-col">
			  <ul>
				<?php
					/* Login/Signup Buttons Header */
					echo theneeds_login_signup_btns_for_header4();
				?>
			  </ul>
			</div>
			<div class="head-3-social">
			  <ul>
				<?php
				/* Social Icons For Header */
				theneeds_social_icons_list_header();
				?>
			  </ul>
			</div>
		  </div>
		  <div class="head-btm-row"> 
			<!--NAVIGATION START-->
			<div class="navigation">
			  <nav class="navbar navbar-inverse">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only"><?php esc_html_e('Toggle navigation','theneeds');?></span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<?php echo theneeds_normal_menu('header-menu','header-menu'); ?>
				</div>
			  </nav>
			</div>
			<!--NAVIGATION END-->
			<div class="head-btm-right">
			  <div class="top-search-2">
				<form action="#">
				  <input type="text" placeholder="<?php esc_html_e('Search','theneeds');?>" required>
				  <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
				</form>
			  </div>
			  <div class="language-box">
					<?php  /* Language Dropdown */
						if ( class_exists( 'WPGlobus' ) ) {
							echo '<div class="wpglobus-selector-box dropdown lang-dropdown">
									<button class="btn btn-default dropdown-toggle" id="dropdownMenu1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'.esc_attr__('EN','theneeds').'<i class="fa fa-angle-down" aria-hidden="true"></i>
									</button>
									<ul class="dropdown-menu">';
									foreach( WPGlobus::Config()->enabled_languages as $lang ) {
										if ( $lang == WPGlobus::Config()->language ) {
											continue;
										}
										$flag = WPGlobus::Config()->flags_url . WPGlobus::Config()->flag[ $lang ];
										echo '<li><a class = "cp-languages" href="' . WPGlobus_Utils::localize_current_url( $lang ). '">'.esc_attr(strtoupper($lang)).'</a></li>';
									}
							echo '</ul></div><!-- .wpglobus-selector-box -->';
						}
					?>
				</div>
			  <?php
				/* Get A Quote Link */
				$theneeds_header_get_quote_link = theneeds_get_themeoption_value('header_get_quote_link','general_settings'); 
				if(!empty($theneeds_header_get_quote_link)){
					echo '<a href="'.esc_url($theneeds_header_get_quote_link).'" class="btn-style-2">'.esc_html__('Get a Quote','theneeds').'</a>';
				}
			  ?>  
			 </div>
		  </div>
		</div>
	  </header>
	  
	<?php 	
	}  
	/* End Of Header Function */
	
  
	/* Header Function html */
	function theneeds_print_header_html($header=""){
		
		$header_style_apply = theneeds_get_themeoption_value('header_style_apply','general_settings');
		
		if($header_style_apply == 'enable'){$header = 'enable';}else{}
		
		if($header == 'Style 1'){
			
			theneeds_header_style_1();
		
		}else if($header == 'Style 2'){
			
			theneeds_header_style_2();
		
		}else if($header == 'Style 3'){
			
			theneeds_header_style_3();
		
		}else if($header == 'Style 4'){
			
			theneeds_header_style_4();
		
		}else{
			
			$select_header_cp = theneeds_get_themeoption_value('select_header_cp','general_settings');
			
			if($select_header_cp == 'Style 1'){
				
				theneeds_header_style_1();
			
			}else if($select_header_cp == 'Style 2'){
				
				theneeds_header_style_2();
			
			}else if($select_header_cp == 'Style 3'){
				
				theneeds_header_style_3();
			
			}else if($select_header_cp == 'Style 4'){
				
				theneeds_header_style_4();
			
			}else{
				theneeds_header_style_1();
			}
		}
	}
	
	
	
	/* Header Function html */
	function theneeds_print_header_html_val($header=""){
		$header_style_apply = theneeds_get_themeoption_value('header_style_apply','general_settings');
		
		if($header_style_apply == 'enable'){$header = 'enable';}else{}
		if(esc_attr($header) == 'enable'){
			$select_header_cp = theneeds_get_themeoption_value('select_header_cp','general_settings');
			return esc_attr($select_header_cp);
		}else{
			return esc_attr($header);
		}
	}
	
	/* print header style */
	function theneeds_print_header_class($header=""){
		
		$banner_class = '';
		
		$header_style_apply = theneeds_get_themeoption_value('header_style_apply','general_settings');
		
		if(esc_attr($header_style_apply) == 'enable'){$header = 'enable';}else{}
		
		if(esc_attr($header) == 'Style 1'){
			$banner_class = 'banner-inner';
			
		}else if(esc_attr($header) == 'Style 2'){
			$banner_class = 'banner banner-inner';
			
		}else if(esc_attr($header) == 'Style 3'){
			$banner_class = 'banner banner-inner';
			
		}else if(esc_attr($header) == 'Style 4'){
			$banner_class = 'banner banner-inner';
			
		}else if(esc_attr($header) == 'Style 1'){
			$banner_class = '';
		}else{
			$select_header_cp = theneeds_get_themeoption_value('select_header_cp','general_settings');
			
			if(esc_attr($select_header_cp) == 'Style 1'){
				
				$banner_class = 'banner-inner';
				
			}else if(esc_attr($select_header_cp) == 'Style 2'){
				
				$banner_class = 'banner banner-inner';
				
			}else if(esc_attr($select_header_cp) == 'Style 3'){
				
				$banner_class = 'banner banner-inner';
				
			}else if(esc_attr($select_header_cp) == 'Style 4'){
				
				$banner_class = 'banner banner-inner';
				
			}else{
				$banner_class = 'banner-inner';
			}
		}
		return $banner_class;
	}
	
	
	
	/* Normal Header Menu */
	function theneeds_normal_menu($location='',$class=''){
		
		global $counter;
		
		$defaults = array(
		'theme_location'  => $location,
		'menu'            => '', 
		'container'       => '', 
		'container_class' => 'menu-{menu slug}-container', 
		'container_id'    => 'navbar',
		'menu_class'      => 'navbar-nav',
		'menu_id'         => 'nav',
		'echo'            => true,
		'fallback_cb'     => '',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth'           => 0,
		'walker'          => '',);				
		if(has_nav_menu($location)){ 
			echo '<div id="default-menu'.$counter.'" class="'.$class.'">';
				wp_nav_menu( $defaults);
			echo '</div>';
		}
	} /* End Top Bar Function Here */
	
	
	/* Top Bar Menu */
	function theneeds_topbar_menu($location='',$class=''){
		
		global $counter;
		
		$defaults = array(
		'theme_location'  => $location,
		'menu'            => '', 
		'container'       => '', 
		'container_class' => 'menu-{menu slug}-container', 
		'container_id'    => 'navbar',
		'menu_class'      => 'navbar-nav',
		'menu_id'         => 'nav-top',
		'echo'            => true,
		'fallback_cb'     => '',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth'           => 0,
		'walker'          => '',);				
		if(has_nav_menu($location)){ 
			echo '<div id="default-menu-top'.$counter.'" class="'.$class.'">';
				wp_nav_menu( $defaults);
			echo '</div>';
		} /* End Condition for Location Set */
	} /* End Top Bar Function Here */

	
	/* Social Networking Icons */
	function theneeds_social_icons_list_header($class=''){
		
		$theneeds_social_settings = get_option('social_settings');
		if($theneeds_social_settings <> ''){
			$theneeds_social = new DOMDocument ();
			$theneeds_social->loadXML ( $theneeds_social_settings );
			/* Social Networking Values */
			$facebook_network = '';
			$facebook_network = theneeds_get_themeoption_value('facebook_network','social_settings');
			$twitter_network = '';
			$twitter_network = theneeds_get_themeoption_value('twitter_network','social_settings');
			$delicious_network = '';
			$delicious_network = theneeds_get_themeoption_value('delicious_network','social_settings');
			$google_plus_network = '';
			$google_plus_network = theneeds_get_themeoption_value('google_plus_network','social_settings');
			$linked_in_network = '';
			$linked_in_network = theneeds_get_themeoption_value('linked_in_network','social_settings');
			$youtube_network = '';
			$youtube_network = theneeds_get_themeoption_value('youtube_network','social_settings');
			$flickr_network = '';
			$flickr_network = theneeds_get_themeoption_value('flickr_network','social_settings');
			$vimeo_network = '';
			$vimeo_network = theneeds_get_themeoption_value('vimeo_network','social_settings');
			$pinterest_network = '';
			$pinterest_network = theneeds_get_themeoption_value('pinterest_network','social_settings');
			$Instagram_network = '';
			$Instagram_network = theneeds_get_themeoption_value('Instagram_network','social_settings'); 
			$github_network = '';
			$github_network = theneeds_get_themeoption_value('github_network','social_settings'); 
			$skype_network = '';
			$skype_network = theneeds_get_themeoption_value('skype_network','social_settings');
		}
			/* Googleplus */
			if(esc_attr($google_plus_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($google_plus_network);?>" title="Google Plus"><i class="fa fa-google-plus"></i></a></li><?php 
			}
			/* Twitter */
			if(esc_attr($twitter_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($twitter_network);?>" title="Twitter"><i class="fa fa-twitter"></i></a></li><?php 
			}
			/* LinkedIn */
			if(esc_attr($linked_in_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($linked_in_network);?>" title="Linkedin"><i class="fa fa-linkedin"></i></a></li><?php 
			}
			/* Facebook */
			if(esc_attr($facebook_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($facebook_network);?>" title="Facebook"><i class="fa fa-facebook"></i></a></li><?php 
			}
			/* Delicious */
			if(esc_attr($delicious_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($delicious_network);?>" title="Delicious"><i class="fa fa-delicious"></i></a></li><?php 
			}
			/* Youtube */
			if(esc_attr($youtube_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($youtube_network);?>" title="Youtube"><i class="fa fa-youtube"></i></a></li><?php 
			}
			/* Flickr */
			if(esc_attr($flickr_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($flickr_network);?>" title="Flickr"><i class="fa fa-flickr"></i></a></li><?php 
			}
			/* Vimeo */
			if(esc_attr($vimeo_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($vimeo_network);?>" title="Vimeo"><i class="fa fa-vimeo-square"></i></a></li><?php 
			}
			/* Pinterest */
			if(esc_attr($pinterest_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($pinterest_network);?>" title="Pinterest"><i class="fa fa-pinterest"></i></a></li><?php 
			}
			/* Instagram */
			if(esc_attr($Instagram_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($Instagram_network);?>" title="Instagram"><i class="fa fa-instagram"></i></a></li><?php 
			}
			/* Github */
			if(esc_attr($github_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($github_network);?>" title="github"><i class="fa fa-github"></i></a></li><?php 
			}
			/* Skype */
			if(esc_attr($skype_network) <> ''){ ?>
				<li><a data-rel='tooltip' href="<?php echo esc_url($skype_network);?>" title="Skype"><i class="fa fa-skype"></i></a></li><?php 
			}?>
	<?php 
	} 
	
	/* Function For Logo */
	function theneeds_default_logo($logo_url =''){ ?>

			<?php global $post;
			
			if(esc_attr($logo_url) == '' || esc_attr($logo_url) == ' '){
			
				$theneeds_header_style = '';
				
				if(is_search() || is_404()){
			
					$theneeds_header_style = '';
					
				}else{
					
					$theneeds_header_style = get_post_meta ( $post->ID, "page-option-top-header-style", true );
				}
				
				if($theneeds_header_style == 'Style 2'){
					
					$logo_url = 'logo-2.png';
					
				}else{
				
					$logo_url = 'logo.png';
				}
				
			}
			
			$header_logo_btn = theneeds_get_themeoption_value('header_logo_btn','general_settings');
			
			if(esc_attr($header_logo_btn) == 'enable'){
				
				$header_logo = theneeds_get_themeoption_value('header_logo','general_settings');

				if($theneeds_header_style == 'Style 1'){
					/* Logo width */
					$logo_width = '230';
					$logo_width = theneeds_get_themeoption_value('logo_width','general_settings');
					/* Logo height */
					$logo_height = '99';
					$logo_height = theneeds_get_themeoption_value('logo_height','general_settings');
				
				}elseif($theneeds_header_style == 'Style 2' && empty($header_logo)){
				
					$logo_width = '174';
					$logo_height = '50';
				
				}else{
					
					/* Logo width */
					$logo_width = '';
					$logo_width = theneeds_get_themeoption_value('logo_width','general_settings');
					/* Logo height */
					$logo_height = '';
					$logo_height = theneeds_get_themeoption_value('logo_height','general_settings');
					
				}
				
				$image_src = '';
				if(!empty($header_logo)){ 
					$image_src = wp_get_attachment_image_src( $header_logo, 'full' );
					$image_src = (empty($image_src))? '': esc_url($image_src[0]);			
				} ?>
				<a href="<?php echo esc_url(home_url('/')); ?>">
					<img width="<?php if(esc_attr($logo_width) == '' or esc_attr($logo_width) == ' '){ echo '230'; }else{echo esc_attr($logo_width);}?>" height="<?php if(esc_attr($logo_height) == '' or esc_attr($logo_height) == ' '){ echo '99'; }else{echo esc_attr($logo_height);}?>" src="<?php if(esc_url($image_src) <> ''){echo esc_url($image_src);}else{echo esc_url(theneeds_PATH_URL.'/images/'.esc_attr($logo_url).'');}?>" alt="<?php echo esc_attr(bloginfo( 'name' ));?>">
				</a>
			
			<?php }else{
				
				$logo_text_cp = theneeds_get_themeoption_value('logo_text_cp','general_settings');
				$logo_subtext = theneeds_get_themeoption_value('logo_subtext','general_settings');

				if(esc_attr($logo_url) == '' || esc_attr($logo_url) == ' '){
					
					$logo_url = 'logo.png';
				}
			
				if($logo_text_cp == 'logo_text_cp' && $logo_subtext == 'logo_subtext' ){?>
					
					<a href="<?php echo esc_url(home_url('/')); ?>">
						<img class="logo_img" src="<?php echo esc_url(theneeds_PATH_URL.'/images/'.esc_attr($logo_url).'');?>" alt="<?php echo esc_attr(bloginfo( 'name' ));?>">
					</a>
				<?php } else{ ?>
					
					<div class = "cp-heading-1">
					
						<a href="<?php echo esc_url(home_url('/')); ?>">
								
							<h1><?php echo esc_attr($logo_text_cp);?></h1>
								
							<em><?php echo esc_attr($logo_subtext);?></em> 
						
						</a>	
					
					</div>
					
				
			<?php }
			
			}?>
		
	<?php }
	

	function theneeds_search_html(){?>
		
		<form method="get" action="<?php  echo esc_url(home_url('/')); ?>">
			<input name="s" type="text" value="<?php esc_attr(the_search_query()); ?>" placeholder="<?php esc_html_e('Enter Your Search...','theneeds');?>" required="">
			<button type="submit"><i class="fa fa-search"></i></button>
		</form>
		
	<?php }
	
	/* Mail To Field for header */
	function theneeds_mailto_field(){ 

		$theneeds_mailto_field = theneeds_get_themeoption_value('mailto','general_settings');

	    if(!empty($theneeds_mailto_field)){?> 
			
			<i class="fa fa-envelope-o" aria-hidden="true"></i> 
			<span><?php esc_html_e('Email:','theneeds');?> 
				<a href="mailto:<?php echo is_email($theneeds_mailto_field); ?>"><?php echo is_email($theneeds_mailto_field); ?></a>
			</span> 
			
		<?php } 
	}
	

	/* Login/signup Buttons */
	function theneeds_login_signup_btns(){
		/* Login/Signup Buttons */
		$sign_in = theneeds_get_themeoption_value('sign_in','general_settings'); 
		$sign_up = theneeds_get_themeoption_value('sign_up','general_settings'); 
		
		if(!empty($sign_in)){
		
			echo '<a href="'.esc_url($sign_in).'"><i class="fa fa-sign-in" aria-hidden="true"></i>'.esc_html__('Login','theneeds').'</a>';
			
		}
		
		if(!empty($sign_up)){
			
			echo '<a href="'.esc_url($sign_up).'"><i class="fa fa-user" aria-hidden="true"></i>'.esc_html__('Signup','theneeds').'</a>';
			
		}
	}
	
	/* Login/signup Buttons */
	function theneeds_login_signup_btns_for_header4(){
		/* Login/Signup Buttons */
		$sign_in = theneeds_get_themeoption_value('sign_in','general_settings'); 
		$sign_up = theneeds_get_themeoption_value('sign_up','general_settings'); 
		$mailto = theneeds_get_themeoption_value('mailto','general_settings'); 
			
		if(!empty($sign_in)){
			
			echo '<li><a href="'.esc_url($sign_in).'"><i class="fa fa-key" aria-hidden="true"></i></a></li>';
			
		}
		
           
            
		
		if(!empty($sign_up)){
			
			echo '<li><a href="'.esc_url($sign_up).'"><i class="fa fa-unlock" aria-hidden="true"></i></a></li>';
			
		}
		
		if(!empty($mailto)){
			
			echo '<li><a href="mailto:'.is_email($mailto).'"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>';
			
		}
		
		
	}
	
	/* Woocommerce Cart Function */
	function theneeds_woo_commerce_cart($shop_text='',$shop_icon='',$shop_val=''){

		$cart_html = '';

		if(class_exists("Woocommerce")){

			$shop_html = '';

			if($shop_val == 'icon'){

				$shop_html = $shop_icon;

			}else if($shop_val == 'text'){

				if($shop_text <> ''){

					$shop_html = $shop_text;

				}else{

					$shop_html = 'Shopping Cart';

				}

			}

			

			global $post,$post_id,$product,$woocommerce;	

			$currency = get_woocommerce_currency_symbol();


			if($woocommerce->cart->cart_contents_count <> 0){ 

					$shopping_cart_div = '<div class="widget_shopping_cart_content"></div>';

			}else{ 

				$shopping_cart_div = '<div class="hide_cart_widget_if_empty"></div>';

			}	

			$cart_html = '<li>

				<a href="#" class="btn-login" title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Shopping" id="no-active-btn-shopping">

					'.html_entity_decode($shop_html).'</a>' .html_entity_decode($shopping_cart_div) .'</li>';		

		}

		

		return $cart_html;

	}
	
	/* For WMPL Plugin */
	if ( function_exists('icl_object_id') ) {

		function theneeds_language_selector(){
			
			$languages = icl_get_languages('skip_missing=0&orderby=name');
			
			if(!empty($languages)){	
				foreach($languages as $l){
					/* For Inactive */
					echo '<li>';
					if(!$l['active'] || $l['active']) echo '<a href="'.esc_url($l['url']).'">';
						echo ''.strtoupper($l['language_code']).'';
						if(!$l['active']) echo '</a>';
					echo '</li>';
				}
			}
		}	
	}