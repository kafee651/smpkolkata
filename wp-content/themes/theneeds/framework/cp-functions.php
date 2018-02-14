<?php

	/*	
	*	Crunchpress Function Registered File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		Crunchpress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) Crunchpress
	*	---------------------------------------------------------------------
	*	This file use to register the wordpress function to the framework,
	*	and also use filter to hook some necessary events.
	*	---------------------------------------------------------------------
	*/
	
	
	if (function_exists('register_sidebar')){	
	
		/* default sidebar array */
		$theneeds_sidebar_attr = array(
			'name' => '',
			'description' => '',
			'before_widget' => '<div class="widget sidebar-recent-post sidebar_section %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		);

			
		$theneeds_footer_col_layout = '';
		$theneeds_footer_col_layout = theneeds_get_themeoption_value('footer_col_layout','general_settings');
		
		$theneeds_sidebar_id = 0;
		$theneeds_sidebar = array();
		
		/* Print Footer Widget Areas */
		$theneeds_select_footer_cp = theneeds_get_themeoption_value('select_footer_cp','general_settings');
		$theneeds_select_footer_cp = 'Style 1';

		
		if($theneeds_select_footer_cp == 'Style 1'){
			$theneeds_sidebar = array("Footer");
			$theneeds_sidebar_upper = array("Instagram");
		}else if($theneeds_select_footer_cp == 'Style 6'){
			$theneeds_sidebar = array();
			$theneeds_sidebar_upper = array("Instagram");
		}else{
			$theneeds_sidebar = array("Footer");
			$theneeds_sidebar_upper = array();
		}
		
		/* Home Page Layout */
		if($theneeds_footer_col_layout == 'footer-style1'){
			
			foreach( $theneeds_sidebar as $sidebar_name ){
				$theneeds_sidebar_attr['name'] = $sidebar_name;
				$sidebar_slug = strtolower(str_replace(' ','-',$sidebar_name));
				$theneeds_sidebar_attr['id'] = 'sidebar-' . $sidebar_slug ;
				$theneeds_sidebar_attr['before_widget'] = '<div class="col-md-3 col-sm-6"><div class="widget box-1 box %2$s">' ;
				$theneeds_sidebar_attr['before_title'] = '<h3>' ;
				$theneeds_sidebar_attr['after_widget'] = '</div></div>' ;
				$theneeds_sidebar_attr['after_title'] = '</h3>' ;
				$theneeds_sidebar_attr['description'] = 'Please Place Widgets Here' ;				
				register_sidebar($theneeds_sidebar_attr);
			}
		
		}else{
			
			foreach( $theneeds_sidebar as $sidebar_name ){
				$theneeds_sidebar_attr['name'] = $sidebar_name;
				$sidebar_slug = strtolower(str_replace(' ','-',$sidebar_name));
				$theneeds_sidebar_attr['id'] = 'sidebar-' . $sidebar_slug ;
				$theneeds_sidebar_attr['before_widget'] = '<div class="col-md-4 col-sm-6"><div class="widget box-1 box %2$s">' ;
				$theneeds_sidebar_attr['after_widget'] = '</div></div>' ;
				$theneeds_sidebar_attr['before_title'] = '<h3>';
				$theneeds_sidebar_attr['after_title'] = '</h3>' ;
				$theneeds_sidebar_attr['description'] = 'Please Place Widgets Here' ;
				register_sidebar($theneeds_sidebar_attr);
			}
		}

		$theneeds_footer_upper_layout = theneeds_get_themeoption_value('footer_upper_layout','general_settings');
	  
		/* Home Page Layout */
		if($theneeds_footer_upper_layout == 'footer-style-upper-1'){
			
			foreach( $theneeds_sidebar_upper as $sidebar_name ){
				$theneeds_sidebar_attr['name'] = $sidebar_name;
				$sidebar_slug = strtolower(str_replace(' ','-',$sidebar_name));
				$theneeds_sidebar_attr['id'] = 'sidebar-' . $sidebar_slug ;
				$theneeds_sidebar_attr['before_widget'] = '<div class="widget %2$s">' ;
				$theneeds_sidebar_attr['after_widget'] = '</div>' ;
				$theneeds_sidebar_attr['before_title'] = '<div class="container"><h3>';
				$theneeds_sidebar_attr['after_title'] = '</h3></div>' ;
				$theneeds_sidebar_attr['description'] = 'Please Place Widgets Here' ;				
				register_sidebar($theneeds_sidebar_attr);
			}
		
		}else{
			
			foreach( $theneeds_sidebar_upper as $sidebar_name ){
				$theneeds_sidebar_attr['name'] = $sidebar_name;
				$sidebar_slug = strtolower(str_replace(' ','-',$sidebar_name));
				$theneeds_sidebar_attr['id'] = 'sidebar-' . $sidebar_slug ;
				$theneeds_sidebar_attr['before_widget'] = '<div class="%2$s">' ;
				$theneeds_sidebar_attr['after_widget'] = '</div>' ;
				$theneeds_sidebar_attr['before_title'] = '<div class="container"><h3>';
				$theneeds_sidebar_attr['after_title'] = '</h3></div>' ;
				$theneeds_sidebar_attr['description'] = 'Please Place Widgets Here' ;
				register_sidebar($theneeds_sidebar_attr);
			}
		}			
		

		$theneeds_sidebar = '';
		$theneeds_sidebar = get_option('sidebar_settings');
		
		
		if(!empty($theneeds_sidebar)){
			$theneeds_xml = new DOMDocument();
			$theneeds_xml->loadXML($theneeds_sidebar);
			foreach( $theneeds_xml->documentElement->childNodes as $sidebar_name ){
				$theneeds_sidebar_attr['name'] = $sidebar_name->nodeValue;
				$theneeds_sidebar_attr['id'] = 'custom-sidebar' . $theneeds_sidebar_id++ ;
				$theneeds_sidebar_attr['before_widget'] = '<div class="widget sidebar-box sidebar-recent-post %2$s">' ;
				$theneeds_sidebar_attr['after_widget'] = '</div>' ;
				$theneeds_sidebar_attr['before_title'] = '<h3>' ;
				$theneeds_sidebar_attr['after_title'] = '</h3>' ;
				register_sidebar($theneeds_sidebar_attr);
			}
		}

	}
	
	
	/* Add Theme Support */
	if(function_exists('add_theme_support')){
	
		/* Decalare WooCommerce Support */
		add_theme_support( 'woocommerce' );
		
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		*/
		 
		add_theme_support( 'html5', array('search-form', 'comment-form', 'comment-list',) );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		 
		add_theme_support( 'post-formats', array('aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery') );
		
		/* enable featured image */
		
		add_theme_support('post-thumbnails');
		
		/*  enable editor style */
		
		add_editor_style('editor-style.css');
		
		/* enable navigation menu */
		add_theme_support('menus');
		
		register_nav_menus(array('header-menu'=>'Header Menu'));
		
		add_theme_support( 'title-tag' );
	}
	
	/* add filter to hook when user press "insert into post" to include the attachment id */
	add_filter('media_send_to_editor', 'theneeds_add_para_media_to_editor', 20, 2);
	
	function theneeds_add_para_media_to_editor($html, $id){

		if(strpos($html, 'href')){
			$pos = strpos($html, '<a') + 2;
			$html = substr($html, 0, $pos) . ' attid="' . $id . '" ' . substr($html, $pos);
		}
		
		return $html ;
		
	}
	
	/* enable theme to support the localization */
	add_action('init', 'theneeds_word_translation');
	
	function theneeds_word_translation(){
		
		load_theme_textdomain( 'theneeds', get_template_directory() . '/languages/' );		
	}

	/*  excerpt filter */
	add_filter('excerpt_length','theneeds_excerpt_length');
	
	function theneeds_excerpt_length(){
		
		return 250;
	}
	
	add_action('wp_footer', 'theneeds_add_javascript_code');
	
	/* Javascript Code */
	function theneeds_add_javascript_code(){
		$theneeds_javascript_code = '';
		/* Get Options */
		$theneeds_general_settings = get_option('general_settings');
		if($theneeds_general_settings <> ''){
			$theneeds_logo = new DOMDocument ();
			$theneeds_logo->loadXML ( $theneeds_general_settings );
			$theneeds_javascript_code = theneeds_find_xml_value($theneeds_logo->documentElement,'theneeds_javascript_code');
			}
		echo esc_js($theneeds_javascript_code);
	
	}
	
	add_action('wp_footer', 'theneeds_add_header_code');
	
	/* Header Style or Script */
	function theneeds_add_header_code(){
		$theneeds_header_css_code = '';
		/* Get Options */
		$theneeds_general_settings = get_option('general_settings');
		if($theneeds_general_settings <> ''){
			$theneeds_logo = new DOMDocument ();
			$theneeds_logo->loadXML ( $theneeds_general_settings );
			$theneeds_header_css_code = theneeds_find_xml_value($theneeds_logo->documentElement,'header_css_code');
		}
		echo esc_attr($theneeds_header_css_code);
	}
	
	/* Typekit Code */
	add_action('wp_footer', 'theneeds_add_typekit_code');

	function theneeds_add_typekit_code(){
		$theneeds_embed_typekit_code = '';
		$theneeds_typography_settings = get_option('typography_settings');
		if($theneeds_typography_settings <> ''){
			$theneeds_typo = new DOMDocument ();
			$theneeds_typo->loadXML ( $theneeds_typography_settings );
			$theneeds_embed_typekit_code = theneeds_find_xml_value($theneeds_typo->documentElement,'embed_typekit_code');
		}
		echo esc_attr($theneeds_embed_typekit_code);
	
	}
	
	/* Custom Post type Feed */
	add_filter('request', 'theneeds_myfeed_request');
	function theneeds_myfeed_request($qv) {
		
		if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('post'); /* array('post','team') */
		return $qv;
	}

	/* Translate the wpml shortcode */
	function theneeds_webtreats_lang_test( $atts, $content = null ) {
		extract(shortcode_atts(array( 'lang' => '' ), $atts));
		
		$theneeds_lang_active = ICL_LANGUAGE_CODE;
		
		if($lang == $theneeds_lang_active){
			return $content;
		}
	}
	
	/*  Add Another theme support */
	add_theme_support( 'automatic-feed-links' );	
	
	if ( ! isset( $content_width ) ){ $content_width = 980; }
	
	if ( ! isset( $theneeds_content_width ) ){ $theneeds_content_width = 980; }
	
	/* update the option if new value is exists and not equal to old one  */
	function theneeds_save_option($theneeds_name, $theneeds_old_value, $theneeds_new_value){
	
		if(empty($theneeds_new_value) && !empty($theneeds_old_value)){
		
			if(!delete_option($theneeds_name)){
			
				return false;
				
			}
			
		}else if($theneeds_old_value != $theneeds_new_value){
		
			if(!update_option($theneeds_name, $theneeds_new_value)){
			
				return false;
				
			}
			
		}
		
		return true;
	}
	
	
	/* Add Newsletter Table */
	function theneeds_add_newsletter_table() {
		global $wpdb;
		$wpdb->query("
			CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."theneeds_newsletter` (
			  `name` varchar(100) NOT NULL,
			  `email` varchar(100) NOT NULL,
			  `ip` varchar(16) NOT NULL,
			  `date_time` datetime NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		");
	}
	
	
	/* Flush rewrite rules for custom post types. */
		global $pagenow;
		if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ){
			
			add_action('init', 'theneeds_add_newsletter_table');	
			
			if(get_option('default_pages_settings') == ''){$default_pages_xml = "<default_pages_settings><sidebar_default>right-sidebar</sidebar_default><right_sidebar_default>Default Sidebar</right_sidebar_default><left_sidebar_default>Post Sidebar</left_sidebar_default><default_excerpt>150</default_excerpt></default_pages_settings>";save_option('default_pages_settings', get_option('default_pages_settings'),$default_pages_xml);}if(get_option('general_settings') == ''){$general_settings = "<general_settings><header_logo_btn>enable</header_logo_btn><header_logo_bg></header_logo_bg><logo_text_cp>The Needs</logo_text_cp><logo_subtext>Charity WordPress Theme</logo_subtext><header_logo></header_logo><logo_width>230</logo_width><logo_height>99</logo_height><select_layout_cp></select_layout_cp><boxed_scheme></boxed_scheme><color_scheme>#14afb4</color_scheme><body_color></body_color><heading_color></heading_color><select_bg_pat>Background-Color</select_bg_pat><bg_scheme>#ffffff</bg_scheme><body_patren></body_patren><color_patren></color_patren><body_image></body_image><position_image_layout>top</position_image_layout><image_repeat_layout>no-repeat</image_repeat_layout><image_attachment_layout>fixed</image_attachment_layout><sign_up></sign_up><sign_in></sign_in><header_get_quote_link></header_get_quote_link><topbar_content></topbar_content><contact_us_code></contact_us_code><mailto></mailto><select_header_cp>Style 1</select_header_cp><header_style_apply>disable</header_style_apply><topsocial_icon></topsocial_icon><header_address_field></header_address_field><header_contact_text></header_contact_text><cart_btn></cart_btn><search_btn>enable</search_btn><beamember_btn></beamember_btn><volunteer_text></volunteer_text><volunteer_page_link></volunteer_page_link><make_donation_link></make_donation_link><copyright_code>TheNeeds 2017, All Rights Reserved, Design &amp; Developed By: CrunchPress</copyright_code><select_footer_cp></select_footer_cp><footer_style_apply></footer_style_apply><footer_bg></footer_bg><footer_col_layout>footer-style1</footer_col_layout><footer_upper_layout></footer_upper_layout><social_networking>enable</social_networking><newsletter_mailpoet_ID>1</newsletter_mailpoet_ID><newsletter_title>NEWSLETTER SUBSCRIPTION</newsletter_title><street_address>TheNeeds Building, 546 South, Eco Avenue, New York, U.S.A.</street_address><location_address></location_address><email_address>info@example.com</email_address><footer_contact_number>Phone: 0123 456 7890</footer_contact_number><skype_address>Skype: +12 8564 232</skype_address><footer_website>http://www.example.com</footer_website><footer_logo></footer_logo><footer_description></footer_description><footer_4_title1></footer_4_title1><footer_4_title2></footer_4_title2><footer_4_title3></footer_4_title3><footer_4_desc1></footer_4_desc1><footer_4_desc2></footer_4_desc2><footer_4_desc3></footer_4_desc3><footer_4_link1></footer_4_link1><footer_4_link2></footer_4_link2><footer_4_link3></footer_4_link3><google_map_api></google_map_api><breadcrumbs>enable</breadcrumbs><rtl_layout></rtl_layout><charity_page>2</charity_page><charity_color>#826455</charity_color><politics_page>2</politics_page><politics_color>#82b441</politics_color><theneeds_maintenance_mode_swtich>enable</theneeds_maintenance_mode_swtich><theneeds_maintenace_title>we are Coming soon</theneeds_maintenace_title><theneeds_countdown_time>March 16, 2018</theneeds_countdown_time><theneeds_email_maintenance>example@example.com</theneeds_email_maintenance><theneeds_mainte_description>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut at odio odio. In ultrices massa tristique ullamcorper aliquet orci, egestas dapibus.</theneeds_mainte_description><theneeds_social_icons_maintenance>1</theneeds_social_icons_maintenance></general_settings>";save_option('general_settings', get_option('general_settings'),$general_settings);}if(get_option('typography_settings') == ''){$typography_settings = "<typography_settings><font_google>Roboto</font_google><font_size_normal>14</font_size_normal><font_google_heading>Default</font_google_heading><menu_font_google>Default</menu_font_google><heading_h1>72</heading_h1><heading_h2>52</heading_h2><heading_h3>30</heading_h3><heading_h4>26</heading_h4><heading_h5>20</heading_h5><heading_h6>18</heading_h6><embed_typekit_code></embed_typekit_code></typography_settings>";save_option('typography_settings', get_option('typography_settings'),$typography_settings);}if(get_option('slider_settings') == ''){$slider_settings = "<slider_settings><select_slider>bx_slider</select_slider><bx_slider_settings><slide_order_bx>slide</slide_order_bx><auto_play_bx>enable</auto_play_bx><pause_on_bx>enable</pause_on_bx><animation_speed_bx>1500</animation_speed_bx><show_bullets>enable</show_bullets><show_arrow>enable</show_arrow><video_slider_on_off></video_slider_on_off><video_banner_url></video_banner_url><video_banner_caption></video_banner_caption><video_banner_title></video_banner_title><safari_banner></safari_banner><safari_banner_link></safari_banner_link><safari_banner_width></safari_banner_width><safari_banner_height></safari_banner_height></bx_slider_settings></slider_settings>";save_option('slider_settings', get_option('slider_settings'),$slider_settings);}if(get_option('social_settings') == ''){$social_settings = "<social_settings><facebook_network>http://facebook.com</facebook_network><twitter_network>http://twitter.com</twitter_network><delicious_network></delicious_network><google_plus_network>https://plus.google.com/</google_plus_network><dribble_network></dribble_network><linked_in_network>http://linkedin.com</linked_in_network><youtube_network></youtube_network><flickr_network></flickr_network><vimeo_network></vimeo_network><pinterest_network></pinterest_network><Instagram_network></Instagram_network><github_network></github_network><skype_network></skype_network><facebook_sharing>enable</facebook_sharing><twitter_sharing>enable</twitter_sharing><stumble_sharing>disable</stumble_sharing><delicious_sharing>enable</delicious_sharing><googleplus_sharing>enable</googleplus_sharing><digg_sharing>disable</digg_sharing><myspace_sharing>enable</myspace_sharing><reddit_sharing>enable</reddit_sharing></social_settings>";save_option('social_settings', get_option('social_settings'),$social_settings);}if(get_option('sidebar_settings') == ''){$sidebar_settings = "<sidebar_settings><sidebar_name>Post Sidebar</sidebar_name><sidebar_name>Default Sidebar</sidebar_name><sidebar_name>Project Sidebar</sidebar_name><sidebar_name>Events Sidebar</sidebar_name><sidebar_name>Causes Sidebar</sidebar_name></sidebar_settings>";save_option('sidebar_settings', get_option('sidebar_settings'),$sidebar_settings);}
		}

	/* Custom background Support */
	$args = array(
		'default-color'          => '',
		'default-image'          => '',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	);

	/* Custom Header Support */
	$defaults = array(
		'default-image'          => '',
		'random-default'         => false,
		'width'                  => 950,
		'height'                 => 200,
		'flex-height'            => false,
		'flex-width'             => false,
		'default-text-color'     => '',
		'header-text'            => true,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);
		
	global $wp_version;
		
	if ( version_compare( $wp_version, '3.4', '>=' ) ){ 
		add_theme_support( 'custom-background', $args );
		add_theme_support( 'custom-header', $defaults );
	}
	

	function theneeds_maintenance_mode(){
	
		/* Yet to be Implement */
		
	}