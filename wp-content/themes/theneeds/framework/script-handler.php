<?php

	/*	
	*	CrunchPress Include Script File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	*   @ Package   CrunchPress
	* 	@author		CrunchPress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) CrunchPress
	*	---------------------------------------------------------------------
	*	This file manage to embed the stylesheet and javascript to each page
	*	based on the content of that page.
	*	---------------------------------------------------------------------
	*/
	
	/* Add Scripts in Theme */
	if(is_admin()){
		add_action('admin_enqueue_scripts', 'theneeds_register_meta_script');
		add_action('admin_enqueue_scripts','theneeds_register_crunchpress_panel_scripts');
		add_action('admin_enqueue_scripts','theneeds_register_crunchpress_panel_styles');
	}else{
		add_action('wp_enqueue_scripts','theneeds_register_non_admin_styles');
		add_action('wp_enqueue_scripts','theneeds_register_non_admin_scripts');

	}

	
	/* 	---------------------------------------------------------------------
	*	This section include the back-end script
	*	---------------------------------------------------------------------
	*/ 
	
	function theneeds_register_meta_script(){
		
		global $post_type;
		
		wp_enqueue_style('bootstrap', theneeds_PATH_URL.'/framework/stylesheet/bootstrap.css');
		
		wp_enqueue_style('thickbox');
		
		/* Font Awesome */
		
		wp_enqueue_style('font-awesome',theneeds_PATH_URL.'/frontend/font-awesome/font-awesome.min.css');
		
		wp_enqueue_style('admin-css',theneeds_PATH_URL.'/framework/stylesheet/admin-css.css');
		
		/* register style and script when access to the "page" post_type page */
		
		if( $post_type == 'page' ){
		
			wp_enqueue_style('meta-css',theneeds_PATH_URL.'/framework/stylesheet/meta-css.css');
			
			wp_enqueue_style('page-dragging',theneeds_PATH_URL.'/framework/stylesheet/page-dragging.css');
			
			wp_enqueue_style('image-picker',theneeds_PATH_URL.'/framework/stylesheet/image-picker.css');
			
			wp_enqueue_script( 'image-picker', theneeds_PATH_URL.'/framework/javascript/image-picker.js', false, '1.0', true);
			
			wp_enqueue_script( 'page-dragging', theneeds_PATH_URL.'/framework/javascript/page-dragging.js', false, '1.0', true);
		
			wp_enqueue_script( 'edit-box', theneeds_PATH_URL.'/framework/javascript/edit-box.js', false, '1.0', true);
			
			wp_enqueue_script( 'confirm-dialog', theneeds_PATH_URL.'/framework/javascript/jquery.confirm.js', false, '1.0', true);
			
			
	
		/*  register style and script when access to the "post" post_type page */
		}else if( $post_type == 'event' || $post_type == 'post' || $post_type == 'team'  || $post_type == 'portfolio' || $post_type == 'theneeds_slider' || $post_type == 'gallery' || $post_type == 'product' ){
		
			wp_deregister_style('admin-css');
			
			wp_enqueue_style('meta-css',theneeds_PATH_URL.'/framework/stylesheet/meta-css.css');
			
			wp_enqueue_style('image-picker',theneeds_PATH_URL.'/framework/stylesheet/image-picker.css');
			
			wp_enqueue_style('confirm-dialog',theneeds_PATH_URL.'/framework/stylesheet/jquery.confirm.css');
			
			wp_enqueue_script( 'post-effects', theneeds_PATH_URL.'/framework/javascript/post-effects.js', false, '1.0', true);
			
			wp_enqueue_script( 'image-picker', theneeds_PATH_URL.'/framework/javascript/image-picker.js', false, '1.0', true);
			
			wp_localize_script('image-picker', 'URL', array('theneeds' => theneeds_PATH_URL ));
			
			wp_enqueue_script( 'confirm-dialog', theneeds_PATH_URL.'/framework/javascript/jquery.confirm.js', false, '1.0', true);
		
		/* register style and script when access to the "testimonial" post_type page */
		
		}else if( $post_type == 'testimonial' ){
		
			wp_enqueue_style('meta-css',theneeds_PATH_URL.'/framework/stylesheet/meta-css.css');
		
		}
		
	}
	
	
	/* register script in CrunchPress panel */
	function theneeds_register_crunchpress_panel_scripts(){
		
		global $post_type;
		
		if($post_type == 'page'){
		
		}else{
			
			wp_enqueue_style('bootstrap',theneeds_PATH_URL.'/framework/stylesheet/bootstrap.css');
			
			$theneeds_script_url = theneeds_PATH_URL.'/framework/javascript/cp-panel.js';
			
			wp_enqueue_script('theneeds_scripts_admin', $theneeds_script_url, array('jquery','media-upload','cp-bootstrap','thickbox', 'jquery-ui-droppable','jquery-ui-datepicker','jquery-ui-tabs', 'jquery-ui-slider','jquery-timepicker','jquery-ui-position','mini-color','confirm-dialog','dummy_content'));

			wp_enqueue_script( 'cp-bootstrap', theneeds_PATH_URL.'/framework/javascript/bootstrap.js', false, '1.0', true);
			
			/* Font Awesome */
			wp_enqueue_style('font-awesome',theneeds_PATH_URL.'/frontend/theneeds_font/css/font-awesome.css');
			
			wp_enqueue_style('font-awesome',theneeds_PATH_URL.'/frontend/theneeds_font/css/font-awesome-ie7.css');

			wp_enqueue_script('mini-color', theneeds_PATH_URL.'/framework/javascript/jquery.miniColors.js', false, '1.0', true);
			
			wp_enqueue_script('confirm-dialog', theneeds_PATH_URL.'/framework/javascript/jquery.confirm.js', false, '1.0', true);
			
			wp_enqueue_script('jquery-timepicker', theneeds_PATH_URL.'/framework/javascript/jquery.ui.timepicker.js', false, '1.0', true);
			
			wp_enqueue_script('dummy_content', theneeds_PATH_URL.'/framework/javascript/dummy_content.js', false, '1.0', true);
		}		
	}

	/* register style in CrunchPress panel */
	function theneeds_register_crunchpress_panel_styles(){
	
		wp_enqueue_style('jquery-ui',theneeds_PATH_URL.'/framework/stylesheet/jquery-ui.css');
		
		wp_enqueue_style('cp-panel',theneeds_PATH_URL.'/framework/stylesheet/cp-panel.css');
		
		wp_enqueue_style('mini-color',theneeds_PATH_URL.'/framework/stylesheet/jquery.miniColors.css');
		
		wp_enqueue_style('confirm-dialog',theneeds_PATH_URL.'/framework/stylesheet/jquery.confirm.css');
		
		wp_enqueue_style('jquery-timepicker',theneeds_PATH_URL.'/framework/stylesheet/jquery.ui.timepicker.css');
		
	}
	
	/* 	---------------------------------------------------------------------
	*	this section include the front-end script
	*	---------------------------------------------------------------------
	*/ 
	
	/* Register all stylesheet */

	function theneeds_register_non_admin_styles(){
	
		$theneeds_page_xml = '';
		
		$theneeds_slider_type = '';
	
		global $post,$post_id,$theneeds_page_xml,$theneeds_slider_type;
		
		$theneeds_page_xml = get_post_meta($post_id,'page-option-item-xml', true);
		
		$theneeds_slider_type = get_post_meta ( $post_id, "page-option-top-slider-types", true );

		
		/* Default Stylesheet */
		wp_enqueue_style( 'default-style', get_stylesheet_uri() );  

		
		/* Widgets CSS */
		wp_enqueue_style('cp-widgets',theneeds_PATH_URL.'/frontend/css/widgets.css');

		/* Responsive CSS */
		wp_enqueue_style('responsive-css',theneeds_PATH_URL.'/frontend/css/responsive.css');
		
		/* Woocommerce CSS */
		wp_enqueue_style('custom-woostyle',theneeds_PATH_URL.'/frontend/css/wp-commerce.css');
		
		/* modernizr */
		wp_enqueue_script('cp-scripts_modernizr', theneeds_PATH_URL.'/frontend/js/modernizr.min.js', false, '1.0', true);

		/* All Scripts */
		wp_enqueue_script( 'custom-scripts', theneeds_PATH_URL.'/frontend/js/custom.js', false, '1.0', true);

		/* Bootstrap Css */
		wp_enqueue_style('cp-bootstrap',theneeds_PATH_URL.'/frontend/css/bootstrap.min.css');
		
		/* Animate CSS */
		wp_enqueue_style('cp-animate',theneeds_PATH_URL.'/frontend/css/animate.css');
		
		/* SVG CSS */
		wp_enqueue_style('cp-svg',theneeds_PATH_URL.'/frontend/css/svg.css');
		
		/* Form CSS */
		wp_enqueue_style('cp-form',theneeds_PATH_URL.'/frontend/css/form.css');
		
		/* Pretty Photo Scripts */	
		wp_enqueue_style('prettyPhoto',theneeds_PATH_URL.'/frontend/css/prettyphoto.min.css');
			
		wp_enqueue_script('prettyPhoto', theneeds_PATH_URL.'/frontend/js/jquery.prettyphoto.min.js', false, '1.0', true);
			
		/* Pie Chart */ 
		wp_enqueue_script( 'cp-piechart', theneeds_PATH_URL.'/frontend/js/pie-chart.js', false, '1.0', true); 

		
		/* Font Awesome CSS */
		wp_enqueue_style('font-awesome',theneeds_PATH_URL.'/frontend/font-awesome/font-awesome.min.css');
	
		
		$theneeds_rtl_layout = '';
		$theneeds_site_loader = '';
		$theneeds_element_loader = '';
		//General Settings Values
		$theneeds_general_settings = get_option('general_settings');
		if($theneeds_general_settings <> ''){
			$theneeds_logo = new DOMDocument ();
			$theneeds_logo->loadXML ( $theneeds_general_settings );
			$theneeds_rtl_layout = theneeds_find_xml_value($theneeds_logo->documentElement,'rtl_layout');
			$theneeds_site_loader = theneeds_find_xml_value($theneeds_logo->documentElement,'site_loader');
			$theneeds_element_loader = theneeds_find_xml_value($theneeds_logo->documentElement,'element_loader');
		}
		
		wp_deregister_style('woocommerce-general');
		wp_deregister_style('ls-google-fonts-css');
		wp_deregister_style('woocommerce-layout');
		wp_deregister_style('woocommerce_frontend_styles');		
		wp_deregister_style('events-manager');		
		wp_deregister_style('mm_font-awesome');		
		
		
		/* RTL Layouts */
		if($theneeds_rtl_layout == 'enable'){
			
			wp_enqueue_style('cp-rtl',theneeds_PATH_URL.'/frontend/css/rtl.css');
		}		
		
		if(isset($post)){
			
			$content = strip_tags(get_the_content());
		}
		
		
		/* Widget Active */
		if(is_active_widget( '', '', 'twitter_widget')){			
			
			/* If widget is active then enqueue */
		}

		
		/* is search or archive */
		if( is_search() || is_archive() ){
			
			/* yet to be implemented */
	
		/* Post post_type */
		}else if( isset($post) && $post->post_type == 'post' || isset($post) && $post->post_type == 'event' ){

			if(!is_home()){
					
				$thumbnail_types = '';
				
				$post_detail_xml = get_post_meta($post->ID, 'post_detail_xml', true);
				
				if($post_detail_xml <> ''){
					
					$theneeds_post_xml = new DOMDocument ();
					
					$theneeds_post_xml->loadXML ( $post_detail_xml );
					
					$thumbnail_types = theneeds_find_xml_value($theneeds_post_xml->documentElement,'post_thumbnail');
					
					if( $thumbnail_types == 'Slider'){
				
						wp_enqueue_style('cp-bx-slider',theneeds_PATH_URL.'/frontend/css/bxslider.css');
						
					}
				}
					

				$event_detail_xml = get_post_meta($post->ID, 'event_detail_xml', true);
				
				if($event_detail_xml <> ''){
						
					$theneeds_event_xml = new DOMDocument ();
						
					$theneeds_event_xml->loadXML ( $event_detail_xml );
					
					$event_thumbnail = theneeds_find_xml_value($theneeds_event_xml->documentElement,'event_thumbnail');
						
					wp_enqueue_style('cp-countdown',theneeds_PATH_URL.'/frontend/css/jquery.countdown.css'); /* load countdown */		
						
				}
					
			}
								
			/* Page post_type */

		}else if( isset($post) && $post->post_type == 'page' ){
		
			global $post,$theneeds_page_xml, $theneeds_slider_type, $theneeds_top_slider_type;
			$theneeds_page_xml = get_post_meta($post->ID,'page-option-item-xml', true);
			$theneeds_top_slider_switch = get_post_meta($post->ID,'page-option-top-slider-on', true);
			$theneeds_slider_type = get_post_meta ( $post->ID, "page-option-top-slider-types", true );
			$theneeds_top_slider_type = get_post_meta($post->ID,'page-option-top-slider-types', true);

			/* detect element, then enqueue the script or style */
		}
		
		$font_google = '';
		$font_size_normal = '';
		$menu_font_google = '';
		$fonts_array = '';
		$font_google_heading = '';
		$heading_h1 = '';
		$heading_h2 = '';
		$heading_h3 = '';
		$heading_h4 = '';
		$heading_h5 = '';
		$heading_h6 = '';
		$embed_typekit_code = '';
		$theneeds_typography_settings = get_option('typography_settings');
		
		
		if($theneeds_typography_settings <> ''){
			$theneeds_typo = new DOMDocument ();
			$theneeds_typo->loadXML ( $theneeds_typography_settings );
			$font_google = theneeds_find_xml_value($theneeds_typo->documentElement,'font_google');
			$font_size_normal = theneeds_find_xml_value($theneeds_typo->documentElement,'font_size_normal');
			$menu_font_google = theneeds_find_xml_value($theneeds_typo->documentElement,'menu_font_google');
			$font_google_heading = theneeds_find_xml_value($theneeds_typo->documentElement,'font_google_heading');
			$heading_h1 = theneeds_find_xml_value($theneeds_typo->documentElement,'heading_h1');
			$heading_h2 = theneeds_find_xml_value($theneeds_typo->documentElement,'heading_h2');
			$heading_h3 = theneeds_find_xml_value($theneeds_typo->documentElement,'heading_h3');
			$heading_h4 = theneeds_find_xml_value($theneeds_typo->documentElement,'heading_h4');
			$heading_h5 = theneeds_find_xml_value($theneeds_typo->documentElement,'heading_h5');
			$heading_h6 = theneeds_find_xml_value($theneeds_typo->documentElement,'heading_h6');
			$embed_typekit_code = theneeds_find_xml_value($theneeds_typo->documentElement,'embed_typekit_code');
			
		}
		
		/* Body Font Installing */
		if(theneeds_get_font_type($font_google) == 'Google_Font'){
			/* Google Font Body */
			if($font_google <> ''){
				wp_enqueue_style('googleFonts', theneeds_get_google_font_url($font_google));
			}	
		} else{
			/* Adobe Edge Font (TypeKit)  */
			// if($font_google <> ''){
				// wp_register_script( 'adobe-edge-font', "http://use.edgefonts.net/".$font_google.".js", false, '1.0', false);
				// wp_enqueue_script('adobe-edge-font');	
			// }
		}
		
		if(theneeds_get_font_type($font_google_heading) == 'Google_Font'){
			if($font_google_heading <> ''){				
				wp_enqueue_style('googleFonts-heading', theneeds_get_google_font_url($font_google_heading) );
			}
		}else{
			// if($font_google_heading <> ''){
				// wp_enqueue_script( 'adobe-edge-heading', "http://use.edgefonts.net/".$font_google_heading.".js", false, '1.0', false);
				
			// }
		}

		/* Menu Font Installing	 */
		if(theneeds_get_font_type($menu_font_google) == 'Google_Font'){
			if($menu_font_google <> ''){
				wp_enqueue_style('menu-googleFonts-heading', theneeds_get_google_font_url($menu_font_google));
			}
		}else{
			// if($menu_font_google <> ''){
				// wp_enqueue_script( 'menu-edge-heading', "http://use.edgefonts.net/".$menu_font_google.".js", false, '1.0', false);
				
			// }
		}
		
	}
		 
    /* Register all scripts */
	function theneeds_register_non_admin_scripts(){
		
		global $post,$post_id;
		global $theneeds_is_responsive;
		global $crunchpress_element;		
		global $wp_scripts;
		$theneeds_is_responsive = 'enable';
		$theneeds_page_xml = get_post_meta($post_id,'page-option-item-xml', true);
		$theneeds_slider_type = get_post_meta ( $post_id, "page-option-top-slider-types", true );

		$social_networking = '';
		$site_loader = '';
		$element_loader = '';
		$theneeds_general_settings = get_option('general_settings');
		
		if($theneeds_general_settings <> ''){
			$theneeds_logo = new DOMDocument ();
			$theneeds_logo->loadXML ( $theneeds_general_settings );
			$social_networking = theneeds_find_xml_value($theneeds_logo->documentElement,'social_networking');
			$site_loader = theneeds_find_xml_value($theneeds_logo->documentElement,'site_loader');
			$element_loader = theneeds_find_xml_value($theneeds_logo->documentElement,'element_loader');
			$topweather_icon = theneeds_find_xml_value($theneeds_logo->documentElement,'topweather_icon');
			
		}
		
		wp_enqueue_script('jquery');
	
		if ( is_singular() && get_option( 'thread_comments' ) ) 	wp_enqueue_script( 'comment-reply' );
			
		/* BootStrap Script Loaded */
		wp_enqueue_script('cp-bootstrap', theneeds_PATH_URL.'/frontend/js/bootstrap.min.js', array('jquery'), '1.0', true);
		
		wp_localize_script('cp-bootstrap', 'ajax_var', array('url' => admin_url('admin-ajax.php'),'nonce' => wp_create_nonce('ajax-nonce')));
		
		/* modernizr */
		wp_enqueue_script('cp-scripts_modernizr', theneeds_PATH_URL.'/frontend/js/modernizr.min.js', false, '1.0', true);
		
		
		
		
			
		if(isset($post)){
			
			$content = strip_tags(get_the_content($post_id));
			
			/* Yet to be implemented */
		}
		
		global $wp_scripts,$post;
		
		wp_enqueue_script('html5shiv',theneeds_PATH_URL.'/frontend/js/html5shive.js',array(),'1.5.1',false);
		
		$wp_scripts->add_data( 'html5shiv', 'conditional', 'lt IE 9' );		
					
		
		
		/* Search and archive page */
		if( is_search() || is_archive() ){
		
			/* Yet to be implemented */
		
		/* Post post_type */
		}else if(isset($post) && $post->post_type == 'timeline' ){
		
			/* Yet to be implemented */
					
		}else if(isset($post) && $post->post_type == 'ignition_product' ){
		
			wp_enqueue_script('cp-progressjs', theneeds_PATH_URL.'/frontend/js/progress.js', false, '1.0', true);
					
		}else if( isset($post) &&  $post->post_type == 'sermons' && !is_home()){
		
			/* Yet to be implemented */

		}else if(isset($post) &&  $post->post_type == 'event' && !is_home()){
		
			wp_enqueue_script('cp-plugin', theneeds_PATH_URL.'/frontend/js/jquery.plugin.min.js', false, '1.0', true);
		
			wp_enqueue_style('cp-countdowncs',theneeds_PATH_URL.'/frontend/css/jquery.countdown.css');
		
			wp_enqueue_script('cp-countdown', theneeds_PATH_URL.'/frontend/js/jquery.countdown.js', false, '1.0', true);
			
			/* Pretty Photo Scripts */
			
			wp_enqueue_style('prettyPhoto',theneeds_PATH_URL.'/frontend/css/prettyphoto.min.css');
			
			wp_enqueue_script('prettyPhoto', theneeds_PATH_URL.'/frontend/js/jquery.prettyphoto.min.js', false, '1.0', true);
			
		
		}else if(isset($post) &&  $post->post_type == 'service' && !is_home()){
		
			/* Yet to be implemented */
			
		}else if(isset($post) &&  $post->post_type == 'post' && !is_home() ){
		
			/* Yet to be implemented */
		
		/*  Page post_type */
		}else if( isset($post) &&  $post->post_type == 'page' ){
			
			global $post,$theneeds_page_xml, $theneeds_slider_type, $theneeds_top_slider_type;
			$theneeds_page_xml = get_post_meta($post->ID,'page-option-item-xml', true);
			$theneeds_top_slider_switch = get_post_meta($post->ID,'page-option-top-slider-on', true);
			$theneeds_slider_type = get_post_meta ( $post->ID, "page-option-top-slider-types", true );
			$theneeds_top_slider_type = get_post_meta($post->ID,'page-option-top-slider-types', true);
			$paraluxx = get_post_meta($post->ID,'page-option-attachment-bg-cp', true);

			/* Yet to be implemented */
		}
	}

?>