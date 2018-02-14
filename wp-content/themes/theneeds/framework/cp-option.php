<?php

	/*	
	*	CrunchPress Options File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		CrunchPress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) CrunchPress
	*	---------------------------------------------------------------------
	*	This file contains the CrunchPress panel elements and create the 
	*	CrunchPress panel at the back-end of the framework
	*	---------------------------------------------------------------------
	*/
	
	
	/* add action to embeded the panel in to dashboard */
	add_action('admin_menu','theneeds_add_crunchpress_panel');
	function theneeds_add_crunchpress_panel(){
	
			add_theme_page('CrunchPress Option','CrunchPress Option','administrator', 'theneeds_general_options', 'theneeds_general_options' );
			add_theme_page('Typography Settings', 'Typography Settings', 'administrator','theneeds_typography_settings', 'theneeds_typography_settings' );
			add_theme_page('Slider Settings', 'Slider Settings', 'administrator','theneeds_slider_settings', 'theneeds_slider_settings' );
			add_theme_page('Social Network', 'Social Network', 'administrator','theneeds_social_settings', 'theneeds_social_settings' );
			add_theme_page('Sidebar Settings', 'Sidebar Settings', 'administrator','theneeds_sidebar_settings', 'theneeds_sidebar_settings' );
			add_theme_page('Default Pages Settings', 'Default Pages Settings', 'administrator','theneeds_default_pages_settings', 'theneeds_default_pages_settings' );
			add_theme_page('Import Dummy Data', 'Import Dummy Data', 'administrator','theneeds_dummydata_import', 'theneeds_dummydata_import' );
	}
		
	add_action('wp_ajax_general_options','theneeds_general_options');
	
	/* General Options */
	function theneeds_general_options(){
		
		foreach ($_REQUEST as $keys=>$values) {
			$$keys = trim($values);
		}

		$theneeds_return_data = array('success'=>'-1', 'alert'=>'Save option failed, please try contacting your host provider to increase the post_max_size and suhosin.post.max_vars varialble on the server.');?>
	
		<div class="cp-wrapper bootstrap_admin cp-margin-left"> 
			<!--content area start -->	  
			<div class="hbg top_navigation row-fluid">
				<div class="cp-logo span2">
					<img src="<?php echo esc_url(theneeds_PATH_URL.'/framework/images/logo.png');?>" class="logo" alt="<?php esc_html_e('logo','theneeds');?>" />
				</div>
				<div class="sidebar span10">
					<?php echo esc_attr(theneeds_top_navigation_html_tooltip());?>
				</div>
			</div>
			<div class="content-area-main row-fluid"> 
			  <!--sidebar start -->
			  <div class="sidebar-wraper span2">
				<div class="sidebar-sublinks">
				  <ul id="wp_t_o_right_menu">
					<li id="active_tab" class="logo" >
					  <?php esc_html_e('Logo Settings', 'theneeds'); ?>
					</li>
					<li class="color_style">
					  <?php esc_html_e('Style & Color Scheme', 'theneeds'); ?>
					</li>
					<li class="hr_settings">
					  <?php esc_html_e('Header Settings', 'theneeds'); ?>
					</li>
					<li class="ft_settings">
					  <?php esc_html_e('Footer Settings', 'theneeds'); ?>
					  </li>
					<li class="misc_settings">
					  <?php esc_html_e('MISC Settings', 'theneeds'); ?>
					</li>
					<!--<li class="default_color_settings">
						<?php esc_html_e('Page Colors', 'theneeds'); ?>
					</li>-->
					<li class="maintenance_mode_settings">
					  <?php esc_html_e('Set Counter', 'theneeds'); ?>
					</li>
		 
					<?php if(!class_exists( 'Envato_WordPress_Theme_Upgrader' )){}else{?>
					<li class="envato_api">
					  <?php esc_html_e('User API Settings', 'theneeds'); ?>
					</li>
					<?php }?>
				  </ul>
				</div>
			  </div>
			<!--sidebar end --> 
      
	  <!--content start -->
      <div class="content-area span10">
        <form id="options-panel-form" name="cp-panel-form">
          <div class="panel-elements" id="panel-elements">
            <div class="panel-element" id="panel-element-save-complete">
              <div class="panel-element-save-text">
                <?php esc_html_e('Save Options Complete', 'theneeds'); ?>
                </div>
              <div class="panel-element-save-arrow"></div>
            </div>
            <div class="panel-element">
              <?php  /* Create Xml Tags 'General Settings' ingenio */
				if(isset($action) AND $action == 'general_options'){
					$general_logo_xml = '<general_settings>';
						
						/****** 1. Logo Section ****/		
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('header_logo_btn',esc_attr($header_logo_btn));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('header_logo_bg',esc_html($header_logo_bg));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('logo_text_cp',esc_attr($logo_text_cp));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('logo_subtext',esc_attr($logo_subtext));	
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('header_logo',esc_html($header_logo));	
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('logo_width',esc_attr($logo_width));						
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('logo_height',esc_attr($logo_height));
						
						/****** 2. Color & Style Section ****/	
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('select_layout_cp',esc_attr($select_layout_cp));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('boxed_scheme',esc_attr($boxed_scheme));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('color_scheme',esc_attr($color_scheme));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('body_color',esc_attr($body_color));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('heading_color',esc_attr($heading_color));							
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('select_bg_pat',esc_attr($select_background_patren));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('bg_scheme',esc_attr($bg_scheme));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('body_patren',esc_html($body_patren));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('color_patren',esc_attr($color_patren));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('body_image',esc_html($body_image));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('position_image_layout',esc_html($position_image_layout));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('image_repeat_layout',esc_html($image_repeat_layout));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('image_attachment_layout',esc_html($image_attachment_layout));
						
						
						/****** 3. Header Section ****/	
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('sign_up',esc_attr($sign_up));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('sign_in',esc_attr($sign_in));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('header_get_quote_link',esc_url($header_get_quote_link));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('topbar_content',esc_attr($topbar_content));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('contact_us_code',esc_attr($contact_us_code));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('mailto',is_email($mailto));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('select_header_cp',esc_attr($select_header_cp));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('header_style_apply',esc_attr($header_style_apply));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('topsocial_icon',esc_attr($topsocial_icon));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('header_address_field',esc_attr($header_address_field));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('header_contact_text',esc_attr($header_contact_text));
						
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('cart_btn',esc_attr($cart_btn));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('search_btn',esc_attr($search_btn));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('beamember_btn',esc_attr($beamember_btn));
						
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('volunteer_text',esc_attr($volunteer_text));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('volunteer_page_link',esc_attr($volunteer_page_link));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('make_donation_link',esc_attr($make_donation_link));
						
						/**** 4. Footer Section ****/
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('copyright_code',esc_attr($copyright_code));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('select_footer_cp',esc_attr($select_footer_cp));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_style_apply',esc_attr($footer_style_apply));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_bg',esc_html($footer_bg));	
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_col_layout',esc_attr($footer_col_layout));	
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_upper_layout',esc_attr($footer_upper_layout));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('social_networking',esc_attr($social_networking));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('newsletter_mailpoet_ID',esc_attr($newsletter_mailpoet_ID));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('newsletter_title',esc_attr($newsletter_title));
						
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('street_address',esc_html($street_address));	
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('location_address',esc_attr($location_address));	
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('email_address',esc_attr($email_address));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_contact_number',esc_attr($footer_contact_number));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('skype_address',esc_attr($skype_address));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_website',esc_url($footer_website));
						
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_logo',esc_attr($footer_logo));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_description',esc_attr($footer_description));

						/* Footer Style 4 Text Options */						
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_4_title1',esc_html($footer_4_title1));	
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_4_title2',esc_attr($footer_4_title2));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_4_title3',esc_attr($footer_4_title3));		
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_4_desc1',esc_attr($footer_4_desc1));	
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_4_desc2',esc_attr($footer_4_desc2));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_4_desc3',$footer_4_desc3);												$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_4_link1',esc_url($footer_4_link1));	
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_4_link2',esc_url($footer_4_link2));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('footer_4_link3',esc_url($footer_4_link3));
							
						/****** 5. Misc Section ****/		
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('google_map_api',esc_attr($google_map_api));
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('breadcrumbs',esc_attr($breadcrumbs));	
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('rtl_layout',esc_attr($rtl_layout));
						
						
						/****** 6. Color Section ****/		
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('charity_page',$charity_page);
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('charity_color',$charity_color);
						
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('politics_page',$politics_page);
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('politics_color',$politics_color);
								
						/***** 7. Maintanance section ***/
	
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('theneeds_maintenance_mode_swtich',$theneeds_maintenance_mode_swtich);
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('theneeds_maintenace_title',$theneeds_maintenace_title);
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('theneeds_countdown_time',$theneeds_countdown_time);
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('theneeds_email_maintenance',$theneeds_email_maintenance);
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('theneeds_mainte_description',$theneeds_mainte_description);
						$general_logo_xml = $general_logo_xml . theneeds_create_xml_tag('theneeds_social_icons_maintenance',$theneeds_social_icons_maintenance);
						
								$general_logo_xml = $general_logo_xml . '</general_settings>';

								if(!theneeds_save_option('general_settings', get_option('general_settings'), $general_logo_xml)){
								
									die( json_encode($theneeds_return_data) );
									
								}
								
								die( json_encode( array('success'=>'0') ) );
								
				} /* end if */ ?>
            </div>
            <?php /* Initialize Variables */
			
				/*** 1. Logo Section */
					
					$header_logo_btn = '';
					$logo_text_cp = '';
					$logo_subtext = '';
					$header_logo_upload = '';
					$logo_width = '';
					$logo_height = '';
				
				/*** 2. Color & Style Section */
				
					$select_layout_cp = '';
					$boxed_scheme = '';
					$select_bg_pat = '';
					$scheme_color_scheme = '';
					$color_scheme = '';
					$body_color = '';
					$heading_color = '';
					$border_color = '';
					$button_color = '';
					$button_hover_color = '';
					$color_patren = '';
					$bg_scheme = '';
					$body_patren = '';
					$body_image = '';
					$position_image_layout = '';
					$image_repeat_layout = '';
					$image_attachment_layout = '';
				
				/*** 3. Header Section */	
					
					$header_logo = '';
					$header_logo_bg = '';
					$header_get_quote_link = '';
					$topbar_content = '';
					$contact_us_code = '';
					$mailto = '';
					$sign_up = '';
					$sign_in = '';
					$select_header_cp = '';
					$header_style_apply = '';
					$topsocial_icon = '';
					$topsearch_icon = '';
					$social_networking = '';
					$header_address_field = '';
					$header_contact_text = '';
					
					$cart_btn = '';
					$search_btn = '';
					$beamember_btn = '';
					
					$volunteer_text = '';
					$volunteer_page_link = '';
					$make_donation_link = '';

				/*** 4. Footer Section */		
					
					$footer_logo_bg = '';
					$footer_style_apply = '';
					$select_footer_cp = '';
					$footer_upper_layout = '';
					$copyright_code = '';
					$footer_banner = '';
					$footer_layout = '';
					$footer_col_layout = '';
					$footer_bg = '';
					$newsletter_mailpoet_ID = '';
					$newsletter_title = '';
					
					$street_address = '';
					$location_address = '';
					$email_address = '';
					$footer_contact_number = '';
					$skype_address = '';
					$footer_website = '';
					
					$footer_logo = '';
					$footer_description = '';
					
				/* Footer 4 Options */						
					$footer_4_title1 = '';						
					$footer_4_title2 = '';						
					$footer_4_title3 = '';											
					$footer_4_desc1 = '';						
					$footer_4_desc2 = '';						
					$footer_4_desc3 = '';											
					$footer_4_link1 = '';						
					$footer_4_link2 = '';						
					$footer_4_link3 = '';					
						
				/*** 5. Misc Section */	
					
					$google_map_api = '';
					$breadcrumbs = '';			
					$rtl_layout = '';
				
				/** 6. Colors Settings */
					
					$charity_page = '';
					$charity_color = '';

					$politics_page = '';
					$politics_color = '';
					
				/** 7. Coming Soon Settings */
					
					$theneeds_maintenance_mode_swtich = '';
					$theneeds_maintenace_title = '';
					$theneeds_countdown_time = '';
					$theneeds_email_maintenance = '';
					$theneeds_mainte_description = '';
					$theneeds_social_icons_maintenance = '';
					
				$theneeds_general_settings = get_option('general_settings');
				
					if($theneeds_general_settings <> ''){
						
						$theneeds_logo = new DOMDocument ();
						$theneeds_logo->loadXML ( $theneeds_general_settings );
						
						/**** 1. Logo Section ***/
						$header_logo_btn = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'header_logo_btn'));
						$header_logo_bg = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'header_logo_bg'));
						$logo_text_cp = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'logo_text_cp'));
						$logo_subtext = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'logo_subtext'));
						$header_logo = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'header_logo'));
						$logo_width = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'logo_width'));
						$logo_height = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'logo_height'));
						
						
						/**** 2. Color & Style Section ***/
						$select_layout_cp = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'select_layout_cp'));
						$boxed_scheme = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'boxed_scheme'));
						$color_scheme = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'color_scheme'));					
						$select_bg_pat = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'select_bg_pat'));
						$bg_scheme = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'bg_scheme'));				
						$body_color = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'body_color'));
						$heading_color = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'heading_color'));	
						$body_patren = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'body_patren'));
						$color_patren = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'color_patren'));
						$body_image = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'body_image'));
						$position_image_layout = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'position_image_layout'));
						$image_repeat_layout = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'image_repeat_layout'));
						$image_attachment_layout = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'image_attachment_layout'));
						
						/**** 3. Header Section ***/
						$header_get_quote_link = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'header_get_quote_link'));
						$topbar_content = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'topbar_content'));
						$select_header_cp = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'select_header_cp'));
						$header_style_apply = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'header_style_apply'));
						$contact_us_code = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'contact_us_code'));
						$mailto = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'mailto'));
						$topsocial_icon = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'topsocial_icon'));
						$sign_up = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'sign_up'));
						$sign_in = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'sign_in'));
						$header_address_field = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'header_address_field'));
						$header_contact_text = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'header_contact_text'));
						
						$cart_btn = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'cart_btn'));
						$search_btn = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'search_btn'));
						$beamember_btn = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'beamember_btn'));
						
						$volunteer_text = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'volunteer_text'));
						$volunteer_page_link = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'volunteer_page_link'));
						$make_donation_link = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'make_donation_link'));
					
						/**** 4. Footer Section ***/
						$select_footer_cp = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'select_footer_cp'));
						$footer_style_apply = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_style_apply'));
						$footer_upper_layout = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_upper_layout'));
						$copyright_code = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'copyright_code'));
						$footer_banner = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_banner'));
						$footer_col_layout = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_col_layout'));
						$footer_bg = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_bg'));
						$social_networking = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'social_networking'));
						$newsletter_mailpoet_ID = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'newsletter_mailpoet_ID'));
						$newsletter_title = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'newsletter_title'));
						
						$street_address = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'street_address'));
						$location_address = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'location_address'));
						$email_address = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'email_address'));
						$footer_contact_number = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_contact_number'));
						$skype_address = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'skype_address'));
						$footer_website = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_website'));
						
						$footer_logo = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_logo'));
						$footer_description = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_description'));
						/* Footer options 4 */						
						$footer_4_title1 = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_4_title1'));					
						$footer_4_title2 = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_4_title2'));					
						$footer_4_title3 = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_4_title3'));												$footer_4_desc1 = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_4_desc1'));						
						$footer_4_desc2 = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_4_desc2'));						
						$footer_4_desc3 = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_4_desc3'));				
						$footer_4_link1 = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_4_link1'));	
						$footer_4_link2 = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_4_link2'));						
						$footer_4_link3 = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'footer_4_link3'));

						/**** 5. Misc Section ***/
						$google_map_api = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'google_map_api'));
						$breadcrumbs = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'breadcrumbs'));
						$rtl_layout = esc_html(theneeds_find_xml_value($theneeds_logo->documentElement,'rtl_layout'));
					
						/**** 6. Color Section ***/
						$charity_page = theneeds_find_xml_value($theneeds_logo->documentElement,'charity_page');
						$charity_color = theneeds_find_xml_value($theneeds_logo->documentElement,'charity_color');
					
						$politics_page = theneeds_find_xml_value($theneeds_logo->documentElement,'politics_page');
						$politics_color = theneeds_find_xml_value($theneeds_logo->documentElement,'politics_color');
						
						/**** 7. Maintanance Section ***/
						$theneeds_maintenance_mode_swtich = theneeds_find_xml_value($theneeds_logo->documentElement,'theneeds_maintenance_mode_swtich');
						$theneeds_maintenace_title = theneeds_find_xml_value($theneeds_logo->documentElement,'theneeds_maintenace_title');
						$theneeds_countdown_time = theneeds_find_xml_value($theneeds_logo->documentElement,'theneeds_countdown_time');
						$theneeds_email_maintenance = theneeds_find_xml_value($theneeds_logo->documentElement,'theneeds_email_maintenance');
						$theneeds_mainte_description = theneeds_find_xml_value($theneeds_logo->documentElement,'theneeds_mainte_description');
						$theneeds_social_icons_maintenance = theneeds_find_xml_value($theneeds_logo->documentElement,'theneeds_social_icons_maintenance');
						
					} /* endif */
				?>
			
			
            <ul class="logo_tab">
              <li id="logo" class="logo_dimenstion active_tab">
                <div id="header_logo_cp" class="row-fluid">
					<ul class="panel-body recipe_class span4 header_logo_btn">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3><?php esc_html_e('HEADER LOGO', 'theneeds'); ?></h3>
							</span>
							<label for="header_logo_btn">
								<div class="checkbox-switch
									<?php echo (esc_attr($header_logo_btn) == 'enable' || (esc_attr($header_logo_btn) == '' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; ?>">
								</div>
							</label>
							<input type="checkbox" name="header_logo_btn" class="checkbox-switch" value="disable" checked>
							<input type="checkbox" name="header_logo_btn" id="header_logo_btn" class="checkbox-switch" value="enable" <?php 

							echo (esc_attr($header_logo_btn) =='enable' || (esc_attr($header_logo_btn)=='' && empty($default)))? 'checked': ''; 

							?>>
							<div class="clear"></div>
							<p> <?php esc_html_e('You can switch between header logo image and header logo text, turning it on it will show logo as image, turning it off it will disable image and show text which you have entered in wordpress settings.','theneeds');?></p>
						</li>
					</ul>
					<ul class="panel-body recipe_class span4 theneeds_logo_text">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('LOGO TEXT', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="logo_text_cp" id="logo_text_cp" value="<?php echo (esc_attr($logo_text_cp) == '')? esc_attr($logo_text_cp): esc_attr($logo_text_cp);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Please paste logo text.','theneeds');?></p>
						</li>
					</ul>
					<ul class="panel-body recipe_class span4 theneeds_logo_text">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('LOGO SUBTEXT', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="logo_subtext" id="logo_subtext" value="<?php echo (esc_attr($logo_subtext) == '')? esc_attr($logo_subtext): esc_attr($logo_subtext);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Please paste logo subtext.','theneeds');?></p>
						</li>
					</ul>
				</div>
				<ul class="panel-body recipe_class logo_upload row-fluid theneeds_logo">
                  <?php 
					$image_src_head = '';
					if(!empty($header_logo)){ 
						$image_src_head = wp_get_attachment_image_src( $header_logo, 'full' );
						$image_src_head = (empty($image_src_head))? '': esc_url($image_src_head[0]);
					}
					?>
					<li class="panel-input span8 eql_height">
						<span class="panel-title">
							<h3 for="header_logo" >
							  <?php esc_html_e('Logo', 'theneeds'); ?>
							</h3>
						</span>
						<div class="content_con">
							<input name="header_logo" type="hidden" class="clearme" id="upload_image_attachment_id" value="<?php echo esc_attr($header_logo); ?>" />
							<input name="header_link" id="upload_image_text" class="clearme upload_image_text" type="text" value="<?php echo esc_url($image_src_head); ?>" />
							<input class="upload_image_button" type="button" value="Upload" />
						</div>
						<p> <?php esc_html_e('Upload logo image here, PNG, Gif, JPEG, JPG format supported only.','theneeds');?> </p>  
					</li>
					<li class="panel-right-box span4 eql_height">
						<div class="admin-logo-image">
						  <?php 
							if(!empty($header_logo)){ 
								$image_src_head = wp_get_attachment_image_src( $header_logo, 'full' );
								$image_src_head = (empty($image_src_head))? '': esc_url($image_src_head[0]);
								$thumb_src_preview = wp_get_attachment_image_src( $header_logo, array(150,150)); ?>
									<img class="clearme img-class" src="<?php if(!empty($image_src_head)){echo esc_url($thumb_src_preview[0]);}?>" alt="<?php esc_html__('Save and Refresh, For Uploaded Logo Preview','theneeds');?>" />
									<span class="close-me"></span>
						  <?php } ?>
						</div>
					</li>
                </ul>
				
                
                <ul class="panel-body recipe_class row-fluid theneeds_logo">
                  <li class="panel-input span8">
					  <span class="panel-title">
						<h3 for="logo_width" >
						  <?php esc_html_e('Width', 'theneeds'); ?>
						</h3>
					  </span>
                    <div id="logo_width" class="sliderbar" rel="logo_bar"></div>
                    <input type="hidden" name="logo_width" value="<?php echo esc_attr($logo_width);?>">
					<p> <?php esc_html_e('Please scroll Left to Right to adjust logo image width, you can also use Arrow keys UP,Down - Left,Right.','theneeds');?> </p>                  
                  </li>
                  <li class="span4 right-box-sec" id="slidertext"><?php echo esc_attr($logo_width);?> <?php esc_html_e('px','theneeds');?> </li>
                </ul>
                <div class="clear"></div>
                <ul class="panel-body recipe_class row-fluid theneeds_logo">
                  <li class="panel-input span8">
					  <span class="panel-title">
						<h3 for="logo_height" >
						  <?php esc_html_e('Height', 'theneeds'); ?>
						</h3>
					  </span>
                    <div id="logo_height" class="sliderbar" rel="logo_bar"></div>
                    <input type="hidden" name="logo_height" value="<?php echo esc_attr($logo_height);?>">
					<p> <?php esc_html_e('Please scroll Left to Right to adjust logo image height, you can also use Arrow keys UP,Down - Left,Right.','theneeds');?> </p>  
                  </li>
				  <li class="span4 right-box-sec" id="slidertext"><?php echo esc_attr($logo_height);?> <?php esc_html_e('px','theneeds');?> </li>
                </ul>
              </li>
              <li id="color_style" class="style_color_scheme">
                <div class="clear"></div>
				<ul id="boxed_layout" class="panel-body recipe_class row-fluid">
                   <li class="panel-input span8">
					<span class="panel-title">
						<h3>
						  <?php esc_html_e('BOXED LAYOUT BACKGROUND', 'theneeds'); ?>
						</h3>
					</span>
					<div class="color-picker-container">
						<input type="text" name="boxed_scheme" class="color-picker" value="<?php if(esc_attr($boxed_scheme) <> ''){echo esc_attr($boxed_scheme);}?>" />
					</div>
					<p> <?php esc_html_e('Please select any color from color palette to use as color scheme, leaving blank color scheme will be auto selected as default.','theneeds');?> </p>
                  </li>
                  <li class="span4 right-box-sec"> </li>
                </ul>
                <div class="clear"></div>
				<div class="row-fluid">
					<ul class="recipe_class span4">
						<li class="panel-radioimage panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('COLOR SCHEME', 'theneeds'); ?>
								</h3>
							</span>

							<div class="color-picker-container">
								<input type="text" name="color_scheme" class="color-picker" value="<?php if(esc_attr($color_scheme) <> ''){echo esc_attr($color_scheme);}?>" />
							</div>
							<p> <?php esc_html_e('Please select any color from color palette to use as color scheme (it will effect on all headings and anchors), leaving blank color scheme will be auto selected as default.','theneeds');?> </p>
						</li>
					</ul>
					<ul class="recipe_class span4">
						<li class="panel-radioimage panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('SECONDARY COLOR', 'theneeds'); ?>
								</h3>
							</span>

							<div class="color-picker-container">
								<input type="text" name="body_color" class="color-picker" value="<?php if(esc_attr($body_color) <> ''){echo esc_attr($body_color);}?>" />
							</div>
							<p> <?php esc_html_e('Please select any color from color palette to use as color scheme (it will effect on all headings and anchors), leaving blank color scheme will be auto selected as default.','theneeds');?> </p>
						</li>
					</ul>
					
				</div>
				<div class="clear"></div>
                <ul class="panel-body recipe_class row-fluid"> 
                  <li class="panel-input span8">
				  <span class="panel-title">
                    <h3>
                      <?php esc_html_e('SELECT BACKGROUND TYPE', 'theneeds'); ?>
                    </h3>
                  </span>
                    <div class="combobox">
                      <select name="select_background_patren" class="select_background_patren" id="select_background_patren">
                        <option <?php if(esc_attr($select_bg_pat) == 'Background-Patren'){echo sanitize_text_field('selected');}?> value="Background-Patren" class="select_bg_patren"> <?php esc_html_e('Background Pattern','theneeds');?> </option>
                        <option <?php if(esc_attr($select_bg_pat) == 'Background-Color'){echo sanitize_text_field('selected');}?> value="Background-Color" class="select_bg_color"> <?php esc_html_e('Background Color','theneeds');?> </option>
                        <option <?php if(esc_attr($select_bg_pat) == 'Background-Image'){echo sanitize_text_field('selected');}?> value="Background-Image" class="select_bg_image"> <?php esc_html_e('Background Image','theneeds');?> </option>
                      </select>
                    </div>
					<p> <?php esc_html_e('Please select background pattern or background color.','theneeds');?> </p>
                  </li>
                  <li id="select_bg_patren" class="span4 pattern-container">
				  <?php 
								$options = array(
									'1'=>array('value'=>'1', 'image'=>'/framework/images/pattern/pattern-1.png'),
									'2'=>array('value'=>'2','image'=>'/framework/images/pattern/pattern-2.png'),
									'3'=>array('value'=>'3','image'=>'/framework/images/pattern/pattern-3.png'),
									'4'=>array('value'=>'4','image'=>'/framework/images/pattern/pattern-4.png'),
									'5'=>array('value'=>'5','image'=>'/framework/images/pattern/pattern-5.png'),
									'6'=>array('value'=>'6','image'=>'/framework/images/pattern/pattern-6.png'),
									'7'=>array('value'=>'7','image'=>'/framework/images/pattern/pattern-7.png'),
									'8'=>array('value'=>'8','image'=>'/framework/images/pattern/pattern-8.png'),
									'9'=>array('value'=>'9','image'=>'/framework/images/pattern/pattern-9.png'),
									'10'=>array('value'=>'10','image'=>'/framework/images/pattern/pattern-10.png'),
									'11'=>array('value'=>'11','image'=>'/framework/images/pattern/pattern-11.png'),
									'12'=>array('value'=>'12','image'=>'/framework/images/pattern/pattern-12.png'),
									'13'=>array('value'=>'13','image'=>'/framework/images/pattern/pattern-13.png'),
									'14'=>array('value'=>'14','image'=>'/framework/images/pattern/pattern-14.png'),
									'15'=>array('value'=>'15','image'=>'/framework/images/pattern/pattern-15.png'),
									'16'=>array('value'=>'16','image'=>'/framework/images/pattern/pattern-16.png'),
									'17'=>array('value'=>'17','image'=>'/framework/images/pattern/pattern-17.png'),
									'18'=>array('value'=>'18','image'=>'/framework/images/pattern/pattern-18.png'),
									'19'=>array('value'=>'19','image'=>'/framework/images/pattern/pattern-19.png'),
									'20'=>array('value'=>'20','image'=>'/framework/images/pattern/pattern-20.png'),
									'21'=>array('value'=>'21','image'=>'/framework/images/pattern/pattern-21.png'),
									'22'=>array('value'=>'22','image'=>'/framework/images/pattern/pattern-22.png'),
									'23'=>array('value'=>'23','image'=>'/framework/images/pattern/pattern-45.png'),
								);
								$value = '';
								$default = '';
								foreach( $options as $option ){ 
								?>
                    <div class='radio-image-wrapper'>
                      <label for="<?php echo esc_attr($option['value']); ?>">
                      <img src=<?php echo esc_url(theneeds_PATH_URL.$option['image'])?> class="color_patren" alt="<?php esc_html_e('color_patren','theneeds');?>">
                      <div id="check-list"></div>
                      </label>
                      <input type="radio" class="checkbox_class" name="color_patren" value="<?php echo esc_attr($option['image']); ?>" <?php if(esc_attr($color_patren) == esc_attr($option['image'])){	echo sanitize_text_field('checked'); }else if(esc_attr($color_patren) == '' && $default == esc_attr($option['image'])){	echo sanitize_text_field('checked');}?> id="<?php echo esc_attr($option['value']); ?>" class=""	>
                    </div>
                    <?php } ?> 
				  </li>
                </ul>
                <div class="clear"></div>
                <ul id="select_bg_color" class="panel-body recipe_class row-fluid">
                  
                  <li class="panel-input span8">
				  <span class="panel-title">
                    <h3 for="bg_scheme" >
                      <?php esc_html_e('BACKGROUND COLOR', 'theneeds'); ?>
                    </h3>
                  </span>
                    <div class="color-picker-container">
						<input type="text" name="bg_scheme" class="color-picker" value="<?php if(esc_attr($bg_scheme) <> ''){echo esc_attr($bg_scheme);}?>"/>
					</div>
					<p> <?php esc_html_e('Please select any color from color palette to use as background color, leaving blank background will be auto selected as default background.','theneeds');?> </p>
                  </li>
                  <li class="span4 right-box-sec"></li>
                </ul>
                <div class="clear"></div>
                <ul id="bg_upload_id" class="recipe_class logo_upload row-fluid">
                  <li class="panel-input span8 ">
					  <span class="panel-title">
						<h3 for="body_patren" >
						  <?php esc_html_e('Upload Background Pattern', 'theneeds'); ?>
						</h3>
					  </span>
					  <?php
					  $image_src_head = '';
								
								if(!empty($header_logo)){ 
								
									$image_src_head = wp_get_attachment_image_src( $body_patren, 'full' );
									$image_src_head = (empty($image_src_head))? '': esc_url($image_src_head[0]);

									
								} 
					  ?>
					<div class="content_con">
						<input name="body_patren" class="emptyme" type="hidden" id="upload_image_attachment_id" value="<?php echo esc_attr($body_patren); ?>" />
						<input id="upload_image_text" class="emptyme upload_image_text" type="text" value="<?php echo esc_url($image_src_head); ?>" />
						<input class="upload_image_button" type="button" value="Upload" />
					</div>
					<p> <?php esc_html_e('Upload background pattern for your theme this option provide you access to put your own image to use as background pattern.','theneeds');?> </p>
                  </li>
                  
				   <li class="panel-right-box span4">
					   <div class="admin-logo-image">
						  <?php 
							if(!empty($body_patren)){ 
								$image_src_head = wp_get_attachment_image_src( $body_patren, 'full' );
								$image_src_head = (empty($image_src_head))? '': esc_url($image_src_head[0]);
								$thumb_src_preview = wp_get_attachment_image_src( $body_patren, array(150,150));?>
						  <img class="clearme img-class" src="<?php if(!empty($image_src_head)){echo esc_url($thumb_src_preview[0]);}?>" /><span class="close-me"></span>
						  <?php } ?>
						</div>
					</li>
                </ul>
                <ul id="image_upload_id" class="recipe_class logo_upload row-fluid">
                 
                  <li class="panel-input span8">
					   <span class="panel-title">
						<h3 for="body_image" >
						  <?php esc_html_e('Upload Background Image', 'theneeds'); ?>
						</h3>
					  </span>
					  <?php
					   $image_src_head = '';
								
								if(!empty($body_image)){ 
								
									$image_src_head = wp_get_attachment_image_src( $body_image, 'full' );
									$image_src_head = (empty($image_src_head))? '': esc_url($image_src_head[0]);
									
								}
						
					  ?>
                    <div class="content_con">
						<input name="body_image" class="clearme" type="hidden" id="upload_image_attachment_id" value="<?php echo esc_attr($body_image); ?>" />
						<input id="upload_image_text" class="clearme upload_image_text" type="text" value="<?php echo esc_url($image_src_head); ?>" />
						<input class="upload_image_button" type="button" value="Upload" />
					</div>
					<p> <?php esc_html_e('Upload background Image for your theme this option provide you access to put your own image to use as background Image.','theneeds');?> </p>
                  </li>
				   <li class="span4 description" >
					   <div class="admin-logo-image">
						  <?php 
							if(!empty($body_image)){ 
								$image_src_head = wp_get_attachment_image_src( $body_image, 'full' );
								$image_src_head = (empty($image_src_head))? '': esc_url($image_src_head[0]);
								$thumb_src_preview = wp_get_attachment_image_src( $body_image, array(150,150));?>
						  <img class="clearme img-class" src="<?php if(!empty($image_src_head)){echo esc_url($thumb_src_preview[0]);}?>" /><span class="close-me"></span>
						  <?php } ?>
						</div>
					</li>
					
                </ul>
                <div class="clear"></div>
				<div class="row-fluid">
                <ul class="recipe_class image_upload_options span4">
                 
                  <li class="panel-radioimage panel-input full-width">
				   <span class="panel-title">
                    <h3 for="position_image_layout">
                      <?php esc_html_e('Image Position', 'theneeds'); ?>
                    </h3>
                  </span>
				  <div class="combobox cp-select-wrap">
					<select name="position_image_layout" class="position_image_layout" id="position_image_layout">
							<?php 
								$value = '';
								$options = array(
									
									'1'=>array('value'=>'top','title'=>'Position Top'),
									'2'=>array('value'=>'right','title'=>'Position Right'),
									'3'=>array('value'=>'left','title'=>'Position Left'),
									'4'=>array('value'=>'bottom','title'=>'Position Bottom'),
									'5'=>array('value'=>'center','title'=>'Position Center'),
									
								);
								foreach( $options as $option ){ ?>
									<option <?php if(esc_attr($position_image_layout) == esc_attr($option['value'])){echo sanitize_text_field('selected');}?> value="<?php echo esc_attr($option['value']);?>" class="position_image_layout"><?php echo esc_attr($option['title']);?></option>
								<?php } ?>
                    </select>
					</div>
					<p> <?php esc_html_e('You can manage background image position in this area.','theneeds');?> </p>
                  </li>
				  
                </ul>
                <ul class="panel-body recipe_class image_upload_options span4">
                  <li class="panel-input full-width">
				  <span class="panel-title">
                    <h3 for="image_repeat_layout">
                      <?php esc_html_e('SELECT BACKGROUND TYPE', 'theneeds'); ?>
                    </h3>
                  </span>
                    <div class="combobox cp-select-wrap">
                      <select name="image_repeat_layout" class="image_repeat_layout" id="image_repeat_layout">
					  			<?php
								$value = '';
								$options = array(
									'1'=>array('value'=>'no-repeat','title'=>'No Repeat'),
									'2'=>array('value'=>'repeat-x','title'=>'Repeat Horizontal'),
									'3'=>array('value'=>'repeat-y','title'=>'Repeat Vertical'),
									'4'=>array('value'=>'repeat','title'=>'Repeat'),
								);
								foreach( $options as $option ){ ?>
							<option <?php if(esc_attr($image_repeat_layout) == esc_attr($option['value'])){echo sanitize_text_field('selected');}?> value="<?php echo esc_attr($option['value']);?>" class="select_bg_patren"><?php echo esc_attr($option['title']);?></option>
						<?php }?>
                      </select>
                    </div>
					<p> <?php esc_html_e('You can manage your image repeat whether its repeated horizontal verticle or both.','theneeds');?> </p>
                  </li>
                </ul>
                <ul class="recipe_class image_upload_options span4">
                  
                  <li class="panel-radioimage panel-input full-width">
				  <span class="panel-title ">
                    <h3 for="image_attachment_layout">
                      <?php esc_html_e('Image Attachment', 'theneeds'); ?>
                    </h3>
                  </span>
				  <div class="combobox cp-select-wrap">
				   <select name="image_attachment_layout" class="image_attachment_layout" id="image_attachment_layout">
						<?php 
						$value = '';
						$options = array(
							'1'=>array('value'=>'fixed','title'=>'Fixed'),
							'2'=>array('value'=>'scroll','title'=>'Scroll'),
						);
						foreach( $options as $option ){ ?>
							<option <?php if(esc_attr($image_attachment_layout) == esc_attr($option['value'])){echo sanitize_text_field('selected');}?> value="<?php echo esc_attr($option['value']);?>" class="image_attachment_layout"><?php echo esc_attr($option['title']);?></option>                   
						<?php } ?>
					</select>
					</div>
					<p> <?php esc_html_e('You can manage your background image attachment fixed or scroll.','theneeds');?> </p>
                  </li>
				 
                </ul>
				</div>
              </li>
              <li id="hr_settings" class="logo_dimenstion">
				<div class="row-fluid">
					<ul class="panel-body recipe_class span12">
						<li class="panel-input full-width">
							<?php
								$images = array(
									'1'=>array('value'=>'header_1', 'image'=>'/frontend/header/header_1.png'),
									'2'=>array('value'=>'header_2','image'=>'/frontend/header/header_2.png'),
									'3'=>array('value'=>'header_3','image'=>'/frontend/header/header_3.png'),
								);							
								echo '<div class="select_header_img">';
									foreach($images as $keys=>$val){
										echo '<div class="header_image_cp" id="'.esc_attr($val['value']).'"><img src="'.esc_url(theneeds_PATH_URL.$val['image']).'" atl="'.esc_html__('theneeds','theneeds').'"></div>';
									}
								echo '</div>';
							?>
						</li>
					</ul>
				</div>
				<div class="row-fluid">
					<ul class="panel-body recipe_class span8">
						 <li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="select_header_cp">
								  <?php esc_html_e('Select Header Style', 'theneeds'); ?>
								</h3>
							</span>
							<div class="combobox">
							  <select name="select_header_cp" class="select_header_cp" id="select_header_cp">
								<option <?php if($select_header_cp == 'Style 1'){echo 'selected';}?> value="Style 1" class="header_1"><?php echo esc_attr__('Style 1','theneeds');?></option>
								<option <?php if($select_header_cp == 'Style 2'){echo 'selected';}?> value="Style 2" class="header_2"><?php echo esc_attr__('Style 2','theneeds');?></option>
							  </select>
							</div>
							<p> <?php esc_html_e('Please select website default header style from dropdown.','theneeds');?> </p>
						  </li>
					</ul>    
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="" >
									<?php esc_html_e('Apply Header Style On All Pages', 'theneeds'); ?>
								</h3>
							</span>
							<label for="header_style_apply">
								<div class="checkbox-switch <?php echo ($header_style_apply=='enable' || ($header_style_apply=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; ?>"></div>
							</label>
							<input type="checkbox" name="header_style_apply" class="checkbox-switch" value="disable" checked>
							<input type="checkbox" name="header_style_apply" id="header_style_apply" class="checkbox-switch" value="enable" 
							<?php echo ($header_style_apply=='enable' || ($header_style_apply=='' && empty($default)))? 'checked': ''; ?>>
							<p><?php esc_html_e('You can turn On/Off Top Bar. Note: Turning it off Search and Top Social Networking Icons will be activated.','theneeds');?></p>
							<p><?php esc_html_e('You can turn On/Off to add above header style apply on all pages turning it off page settings will be apply on each page.','theneeds');?></p>
						</li>
					</ul>
				</div>
				 <div class="row-fluid">
					<ul class="panel-body recipe_class logo_upload row-fluid">
					  <?php 
						$image_src_head_bg = '';
						if(!empty($header_logo_bg)){ 
							$image_src_head_bg = wp_get_attachment_image_src( $header_logo_bg, 'full' );
							$image_src_head_bg = (empty($image_src_head_bg))? '': esc_url($image_src_head_bg[0]);
						}
						?>
						<li class="panel-input span8 eql_height">
							<span class="panel-title">
								<h3 for="header_logo" >
								  <?php esc_html_e('Header background', 'theneeds'); ?>
								</h3>
							</span>
							<div class="content_con">
								<input name="header_logo_bg" type="hidden" class="clearme" id="upload_image_attachment_id" value="<?php echo esc_attr($header_logo_bg); ?>" />
								<input name="header_link_bg" id="upload_image_text" class="clearme upload_image_text" type="text" value="<?php echo esc_url($image_src_head_bg); ?>" />
								<input class="upload_image_button" type="button" value="Upload" />
							</div>
							<p> <?php esc_html_e('Upload image for header section background for inner pages.','theneeds');?> </p>  
						</li>
						<li class="panel-right-box span4 eql_height">
							<div class="admin-logo-image">
							  <?php 
								if(!empty($header_logo_bg)){ 
									$image_src_head_bg = wp_get_attachment_image_src( $header_logo_bg, 'full' );
									$image_src_head_bg = (empty($image_src_head_bg))? '': esc_url($image_src_head_bg[0]);
									$thumb_src_preview = wp_get_attachment_image_src( $header_logo_bg, array(150,150)); ?>
										<img class="clearme img-class" src="<?php if(!empty($image_src_head_bg)){echo esc_url($thumb_src_preview[0]);}?>" alt="<?php esc_html__('header background image','theneeds');?>" />
										<span class="close-me"></span>
							  <?php } ?>
							</div>
						</li>
					</ul>
					
				</div>	
				
				<div class="row-fluid">
					<!--<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('Mail To:', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="mailto" id="mailto" value="<?php echo (is_email($mailto) == '')? is_email($mailto): is_email($mailto);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Add Email ID For Header Topbar','theneeds');?></p>
						</li>
					</ul>-->
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('Sign In Page URL:', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="sign_in" id="sign_in" value="<?php echo (esc_url($sign_in) == '')? esc_url($sign_in): esc_url($sign_in);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Sign In Page URL For Header Section','theneeds');?></p>
						</li>
					</ul>
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('Sign Up Page URL:', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="sign_up" id="sign_up" value="<?php echo (esc_url($sign_up) == '')? esc_url($sign_up): esc_url($sign_up);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Sign Up Page URL For Header Section','theneeds');?></p>
						</li>
					</ul>
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3><?php esc_html_e('Display Search Button', 'theneeds'); ?></h3>
							</span>
							<label for="search_btn">
								<div class="checkbox-switch
									<?php echo (esc_attr($search_btn) == 'enable' || (esc_attr($search_btn) == '' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; ?>">
								</div>
							</label>
							<input type="checkbox" name="search_btn" class="checkbox-switch" value="disable" checked>
							<input type="checkbox" name="search_btn" id="search_btn" class="checkbox-switch" value="enable" <?php 

							echo (esc_attr($search_btn) =='enable' || (esc_attr($search_btn)=='' && empty($default)))? 'checked': ''; 

							?>>
							<div class="clear"></div>
							<p> <?php esc_html_e('Turn On/Off Search Button In Header','theneeds');?></p>
						</li>
					</ul>
				</div>
				<!--Sign In Sign Out Button -->
				<div class="row-fluid">
					<!--<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('Text For Contact: ', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="header_contact_text" id="header_contact_text" value="<?php echo (esc_attr($header_contact_text) == '')? esc_attr($header_contact_text): esc_attr($header_contact_text);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Add Text For Contact Number','theneeds');?></p>
						</li>
					</ul>
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('Contact Number', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="contact_us_code" id="contact_us_code" value="<?php echo (esc_attr($contact_us_code) == '')? esc_attr($contact_us_code): esc_attr($contact_us_code);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Please Paste Here Contact Number .','theneeds');?></p>
						</li>
					</ul>-->
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('Donate Page Link: ', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="header_get_quote_link" id="header_get_quote_link" value="<?php echo (esc_url($header_get_quote_link) == '')? esc_url($header_get_quote_link): esc_url($header_get_quote_link);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Donate Page Link Here.','theneeds');?></p>
						</li>
					</ul>
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('Causes Page Link: ', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="volunteer_page_link" id="volunteer_page_link" value="<?php echo (esc_url($volunteer_page_link) == '')? esc_url($volunteer_page_link): esc_url($volunteer_page_link);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Add Link For Causes Page. Leave Blank To Hide','theneeds');?></p>
						</li>
					</ul>
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('Make Donation Link: ', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="make_donation_link" id="make_donation_link" value="<?php echo (esc_url($make_donation_link) == '')? esc_url($make_donation_link): esc_url($make_donation_link);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Add Link For Make Donation Page. Leave Blank To Hide','theneeds');?></p>
						</li>
					</ul>
				</div>
				<div class="row-fluid">
					<!--<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3><?php esc_html_e('Display Cart Button', 'theneeds'); ?></h3>
							</span>
							<label for="cart_btn">
								<div class="checkbox-switch
									<?php echo (esc_attr($cart_btn) == 'enable' || (esc_attr($cart_btn) == '' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; ?>">
								</div>
							</label>
							<input type="checkbox" name="cart_btn" class="checkbox-switch" value="disable" checked>
							<input type="checkbox" name="cart_btn" id="cart_btn" class="checkbox-switch" value="enable" <?php 

							echo (esc_attr($cart_btn) =='enable' || (esc_attr($cart_btn)=='' && empty($default)))? 'checked': ''; 

							?>>
							<div class="clear"></div>
							<p> <?php esc_html_e('Turn On/Off Cart Button In Header','theneeds');?></p>
						</li>
					</ul>-->
					
					<!--<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3><?php esc_html_e('Become A Volunteer Button', 'theneeds'); ?></h3>
							</span>
							<label for="beamember_btn">
								<div class="checkbox-switch
									<?php echo (esc_attr($beamember_btn) == 'enable' || (esc_attr($beamember_btn) == '' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; ?>">
								</div>
							</label>
							<input type="checkbox" name="beamember_btn" class="checkbox-switch" value="disable" checked>
							<input type="checkbox" name="beamember_btn" id="beamember_btn" class="checkbox-switch" value="enable" <?php 

							echo (esc_attr($beamember_btn) =='enable' || (esc_attr($beamember_btn)=='' && empty($default)))? 'checked': ''; 

							?>>
							<div class="clear"></div>
							<p> <?php esc_html_e('Turn On/Off Be a Volunteer Button In Header','theneeds');?></p>
						</li>
					</ul>-->
				</div>
				<div class = "row-fluid">
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('Address Field: ', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="volunteer_text" id="volunteer_text" value="<?php echo (esc_attr($volunteer_text) == '')? esc_attr($volunteer_text): esc_attr($volunteer_text);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Add Address Here For Top Bar.','theneeds');?></p>
						</li>
					</ul>
					
					
				</div>
            </li>
            <li id="ft_settings" class="logo_dimenstion">
				<div class="row-fluid">
					<ul class="panel-body recipe_class span8">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="copyright_code" >
									<?php esc_html_e('COPY RIGHT TEXT', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="copyright_code" id="copyright_code" value="<?php echo (esc_attr($copyright_code) == '')? esc_attr($copyright_code): esc_attr($copyright_code);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Please paste here your copy right text.','theneeds');?></p>
						</li>
					</ul>
					<ul class="recipe_class span4 footer_widget">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="">
								  <?php esc_html_e('Footer Widget Layout', 'theneeds'); ?>
								</h3>
							</span>
							<?php 
								$value = '';
								$options = array(
								'1'=>array('value'=>'footer-style1','image'=>'/framework/images/footer-style1.png'),
								'2'=>array('value'=>'footer-style2','image'=>'/framework/images/footer-style-3.png'),
								);
								foreach( $options as $option ){ ?>
							<div class='radio-image-wrapper'>
								<label for="<?php echo esc_attr($option['value']); ?>">
								  <img src=<?php echo esc_url(theneeds_PATH_URL.$option['image'])?> class="footer_col_layout" alt="<?php esc_html_e('footer_col_layout','theneeds');?>" />
								  <div id="check-list"></div>
								</label>
								<input type="radio" name="footer_col_layout" value="<?php echo esc_attr($option['value']); ?>" id="<?php echo esc_attr($option['value']); ?>" class="dd"
								<?php if(esc_attr($footer_col_layout) == esc_attr($option['value'])){ echo sanitize_text_field('checked');}?>>
							</div>
							<?php } ?>
							<div class="clear"></div>
							<p> <?php esc_html_e('Please select home page layout style.','theneeds');?></p>
						</li>
					</ul>
				</div>
				<!--<div class = "row-fluid">
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="newsletter_title" >
									<?php esc_html_e('Newsletter Title', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="newsletter_title" id="newsletter_title" value="<?php echo (esc_attr($newsletter_title) == '')? esc_attr($newsletter_title): esc_attr($newsletter_title);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Please Add Newsletter Title For Footer.','theneeds');?></p>
						</li>
					</ul>
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="newsletter_mailpoet_ID" >
									<?php esc_html_e('MailPoet Form ID', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="newsletter_mailpoet_ID" id="newsletter_mailpoet_ID" value="<?php echo (esc_attr($newsletter_mailpoet_ID) == '')? esc_attr($newsletter_mailpoet_ID): esc_attr($newsletter_mailpoet_ID);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Please Add Newsletter Title For Footer i.e 1','theneeds');?></p>
						</li>
					</ul>
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="street_address" >
									<?php esc_html_e('Location', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="street_address" id="street_address" value="<?php echo (esc_attr($street_address) == '')? esc_attr($street_address): esc_attr($street_address);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Please Add Address For Footer Bottom Bar.','theneeds');?></p>
						</li>
					</ul>
				</div>				
	
				<div class = "row-fluid">
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="email_address" >
									<?php esc_html_e('Email Address', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="email_address" id="email_address" value="<?php echo (esc_attr($email_address) == '')? esc_attr($email_address): esc_attr($email_address);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Please Add Email Address For Footer','theneeds');?></p>
						</li>
					</ul>
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="footer_contact_number" >
									<?php esc_html_e('Add Contact Number:', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="footer_contact_number" id="footer_contact_number" value="<?php echo (esc_attr($footer_contact_number) == '')? esc_attr($footer_contact_number): esc_attr($footer_contact_number);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Please Contact Number For Footer.','theneeds');?></p>
						</li>
					</ul>
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="skype_address" >
									<?php esc_html_e('Skype Address', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="skype_address" id="skype_address" value="<?php echo (esc_attr($skype_address) == '')? esc_attr($skype_address): esc_attr($skype_address);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Please Add Skype Address ','theneeds');?></p>
						</li>
					</ul>
				</div>
				<div class = "row-fluid">
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="footer_website" >
									<?php esc_html_e('Website Address', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="footer_website" id="footer_website" value="<?php echo (esc_url($footer_website) == '')? esc_url($footer_website): esc_url($footer_website);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Please Add Website Address For Footer','theneeds');?></p>
						</li>
					</ul>
				</div>-->
            </li>
              <li id="misc_settings">
				<div class="row-fluid">
					<ul class="panel-body recipe_class span4">
					  <li class="panel-input full-width">
					   <span class="panel-title">
						<h3 for="" >
						  <?php esc_html_e('BREADCRUMBS', 'theneeds'); ?>
						</h3>
					  </span>
						<label for="breadcrumbs">
						<div class="checkbox-switch <?php echo (esc_attr($breadcrumbs) =='enable' || (esc_attr($breadcrumbs) =='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; ?>"></div>
						</label>
						<input type="checkbox" name="breadcrumbs" class="checkbox-switch" value="disable" checked>
						<input type="checkbox" name="breadcrumbs" id="breadcrumbs" class="checkbox-switch" value="enable" <?php if(esc_attr($breadcrumbs) =='enable' ){echo '';} echo (esc_attr($breadcrumbs) =='enable' || (esc_attr($breadcrumbs) =='' && empty($default)))? 'checked': ''; ?>>
						<p> <?php esc_html_e('You can turn On/Off BreadCrumbs from Top of the page.','theneeds');?></p>
					  </li>
					</ul>
					
					<ul class="panel-body recipe_class span4">
					  <li class="panel-input full-width">
					   <span class="panel-title">
						<h3 for="" >
						  <?php esc_html_e('RTL Layout', 'theneeds'); ?>
						</h3>
					  </span>
						<label for="rtl_layout">
						<div class="checkbox-switch <?php echo (esc_attr($rtl_layout) =='disable' || (esc_attr($rtl_layout) =='' && empty($default)))? 'checkbox-switch-off': 'checkbox-switch-on'; ?>"></div>
						</label>
						<input type="checkbox" name="rtl_layout" class="checkbox-switch" value="enable" checked>
						<input type="checkbox" name="rtl_layout" id="rtl_layout" class="checkbox-switch" value="disable" <?php if(esc_attr($rtl_layout) =='disable' ){echo '';} echo (esc_attr($rtl_layout) =='disable' || (esc_attr($rtl_layout) =='' && empty($default)))? 'checked': ''; ?>>
						<p> <?php esc_html_e('You can turn On/Off RTL.','theneeds');?></p>
					  </li>
					</ul>

					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('Google MAP API KEY:', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="google_map_api" id="google_map_api" value="<?php echo (esc_attr($google_map_api) == '')? esc_attr($google_map_api): esc_attr($google_map_api);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Add Google Map API key Here. You can get it from https://developers.google.com/maps/documentation/javascript/get-api-key','theneeds');?></p>
						</li>
					</ul>
					
				</div>
              </li>
			  
			<li id="default_color_settings">
				<div class="row-fluid">
					<!-- 1.0 Charity Section --->
					<ul id="charity" class="panel-body recipe_class">
						<li class="panel-input span3">
							<span class="panel-title">
								<h3 for="charity_page">
								  <?php esc_html_e('Select Page 1', 'theneeds'); ?>
								</h3>
							</span>
							<div class="combobox">
								<select name="charity_page" class="charity_page" id="charity_page">
								<?php  foreach(theneeds_get_title_list_array('page') as $values){ ?>
									<option <?php if($values->ID == $charity_page){echo 'selected';}?> value="<?php echo esc_attr($values->ID);?>"><?php echo esc_attr($values->post_title);?></option>
									<?php }?>
								</select>
							</div>
							<p> <?php esc_html_e('Select Page To Apply Color.','theneeds');?> </p>
						</li>
						<li class="panel-input span3">
							<span class="panel-title">
								<h3 for="charity_color" >
									<?php esc_html_e('Page 1 Color', 'theneeds'); ?>
								</h3>
							</span>
							<div class="color-picker-container">
								<input type="text" name="charity_color" class="color-picker" value="<?php if($charity_color <> ''){echo esc_attr($charity_color);}?>"/>
							</div>
							<p> <?php esc_html_e('Selected Color Will Be applied to the Page. *Default: #169ad8 (Charity)','theneeds');?> </p>
						</li>
					</ul>
					<!-- 2.0 Politics Section --->
					<ul id="politics" class="panel-body recipe_class">
						<li class="panel-input span3">
							<span class="panel-title">
								<h3 for="politics_page">
								  <?php esc_html_e('Select Page 2', 'theneeds'); ?>
								</h3>
							</span>
							<div class="combobox">
								<select name="politics_page" class="politics_page" id="politics_page">
								<?php  foreach(theneeds_get_title_list_array('page') as $values){ ?>
									<option <?php if($values->ID == $politics_page){echo 'selected';}?> value="<?php echo esc_attr($values->ID);?>"><?php echo esc_attr($values->post_title);?></option>
									<?php }?>
								</select>
							</div>
							<p> <?php esc_html_e('Select Page To Apply Color.','theneeds');?> </p>
						</li>
						<li class="panel-input span3">
							<span class="panel-title">
								<h3 for="politics_color">
									<?php esc_html_e('Page 2 Color', 'theneeds'); ?>
								</h3>
							</span>
							<div class="color-picker-container">
								<input type="text" name="politics_color" class="color-picker" value="<?php if($politics_color <> ''){echo esc_attr($politics_color);}?>"/>
							</div>
							<p> <?php esc_html_e('Selected Color Will Be applied to the Page. *Default: #d01a39 (Politics)','theneeds');?> </p>
						</li>
					</ul>
				</div>
            </li>
			 <!--- ********** HTML MARKUP : 6 . Maintainance Settings ******************* -->
			  
			  <li id="maintenance_mode_settings">
				<div class="row-fluid">
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
						   <span class="panel-title">
								<h3>
								  <?php esc_html_e('Maintenance Mode', 'theneeds'); ?>
								</h3>
							</span>
							<label for="theneeds_maintenance_mode_swtich">
								<div class="checkbox-switch <?php echo (esc_attr($theneeds_maintenance_mode_swtich) =='enable' || (esc_attr($theneeds_maintenance_mode_swtich) =='' && empty($theneeds_default)))? 'checkbox-switch-on': 'checkbox-switch-off'; 	?>"></div>
							</label>
							<input type="checkbox" name="theneeds_maintenance_mode_swtich" class="checkbox-switch" value="disable" checked>
							<input type="checkbox" name="theneeds_maintenance_mode_swtich" id="theneeds_maintenance_mode_swtich" class="checkbox-switch" value="enable" 
							<?php if(esc_attr($theneeds_maintenance_mode_swtich) =='enable' ){echo '';} echo (esc_attr($theneeds_maintenance_mode_swtich) =='enable' || (esc_attr($theneeds_maintenance_mode_swtich) =='' && empty($theneeds_default)))? 'checked': ''; ?>>
							<p><?php esc_html_e('You can turn On/Off Maintenance mode from here.','theneeds');?></p>
						</li>
					</ul>
					
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('Maintenance Title', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="theneeds_maintenace_title" id="theneeds_maintenace_title" value="<?php echo (esc_attr($theneeds_maintenace_title) == '')? esc_attr($theneeds_maintenace_title): esc_attr($theneeds_maintenace_title);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Please Add Title To Display On Page.','theneeds');?></p>
						</li>
					</ul>
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('Countdown Time', 'theneeds'); ?>
								</h3>
							</span>
							<script>
								jQuery(document).ready(function($) {
									"use strict";
									$( "#theneeds_countdown_time" ).datepicker();
								});
							</script>
							<input type="text" name="theneeds_countdown_time" id="theneeds_countdown_time" placeholder = "<?php esc_attr_e('Nov 18, 2016','theneeds');?>" value="<?php echo (esc_attr($theneeds_countdown_time) == '')? esc_attr($theneeds_countdown_time): esc_attr($theneeds_countdown_time);?>" />
							<p><?php esc_html_e('Please Select Date To Set Counter Off, It will coundown upto that date.','theneeds');?></p>
						</li>
					</ul>
				</div>
				<div class="row-fluid">
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('Email', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="theneeds_email_maintenance" id="theneeds_email_maintenance" value="<?php echo (is_email($theneeds_email_maintenance) == '')? is_email($theneeds_email_maintenance): is_email($theneeds_email_maintenance);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Add Email For The Contact.','theneeds');?></p>
						</li>
					</ul>
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3 for="theneeds_mainte_description" >
									<?php esc_html_e('Description', 'theneeds'); ?>
								</h3>
							</span>
							<textarea name="theneeds_mainte_description" id="theneeds_mainte_description" ><?php if(esc_attr($theneeds_mainte_description) <> '') { echo esc_textarea(esc_attr($theneeds_mainte_description));}?></textarea>
							<p><?php esc_html_e('Please Add Description Text For The Maintanance Page.','theneeds');?></p>
						</li> 
					</ul>  
					<ul class="panel-body recipe_class span4">
						<li class="panel-input full-width">
							<span class="panel-title">
								<h3>
									<?php esc_html_e('Add MailPoet Form ID', 'theneeds'); ?>
								</h3>
							</span>
							<input type="text" name="theneeds_social_icons_maintenance" id="theneeds_social_icons_maintenance" value="<?php echo (esc_attr($theneeds_social_icons_maintenance) == '')? esc_attr($theneeds_social_icons_maintenance): esc_attr($theneeds_social_icons_maintenance);?>" />
							<div class="clear"></div>
							<p><?php esc_html_e('Add MailPoet Form ID Here i.e 1.','theneeds');?></p>
						</li>
					</ul>					
				</div>	
              </li>
             
              
            </ul>
            <div class="clear"></div>
            <div class="panel-element-tail">
              <div class="tail-save-changes">
                <div class="loading-save-changes"></div>
                <input type="submit" value="<?php echo esc_html_e('Save Changes','theneeds') ?>">
                <input type="hidden" name="action" value="general_options">
                
              </div>
            </div>
          </div>
        </form>
      </div>
      <!--content End --> 
    </div>
    <!--content area end --> 
  </div>
<?php
	}

?>
