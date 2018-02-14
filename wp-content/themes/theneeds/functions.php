<?php 
	
	/*	
	*	CrunchPress function.php
	*	---------------------------------------------------------------------
	* 	@version	1.0
	*   @ Package   WP Theme
	* 	@author		CrunchPress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) CrunchPress
	*	---------------------------------------------------------------------
	*	This file contains all important functions and features of the theme.
	*	---------------------------------------------------------------------
	*/	
	
	
	/************** Frequently Used Image Sizes In The Theme *************/
	
	add_image_size('theneeds-project-medium',360,220, true);			/* Current Projects Image**********(1) */
	add_image_size('theneeds-blog-thumbnail',265,250, true);			/* News Thumbnail Image************(2) */	
	add_image_size('theneeds-testi-thumbnail',100,100, true);			/* Testi Thumb ********************(3) */
	add_image_size('theneeds-team-thumbnail',285,345, true);			/* Testi Thumb ********************(4) */
	add_image_size('theneeds-projects-thumbnail',585,350, true);		/* Testi Thumb ********************(5) */
	add_image_size('theneeds-product-thumbnail',290,300, true);			/* Testi Thumb ********************(6) */
	add_image_size('theneeds-causes-listing',390,320, true);			/* Projects Listing****************(7) */	
	add_image_size('theneeds-causes-full',650,450, true);				/* Blog Full***********************(8) */
	add_image_size('theneeds-event-full',850,450, true);				/* Event Full**********************(9) */

	/************** Defined For the Theme  *************/
	
	if(!defined( 'theneeds_PATH_URL' )){ define('theneeds_PATH_URL', esc_url(get_template_directory_uri()));}  	 	/* logical location for CP framework */
	
	if(!defined( 'theneeds_PATH_SER' )){define('theneeds_PATH_SER', esc_url(get_template_directory()));}      	 	/* Physical location for CP framework */      
	
	if(!defined( 'theneeds_FW_URL' )){define( 'theneeds_FW_URL', esc_url(theneeds_PATH_URL . '/framework' ));}  	/* Define URL path of framework directory */
	
	if(!defined( 'theneeds_FW' )){define( 'theneeds_FW', esc_url(theneeds_PATH_SER . '/framework' ));}			 	/* Define server path of framework directory */
	
	if(!defined( 'AJAX_URL' )){define('AJAX_URL', esc_url(admin_url( 'admin-ajax.php' )));} 						 /* Define admin url */

					
	/************** SSL Checks *************/

	if ( is_ssl() ) {
	
		define('HTTP', 'https://');
		
	}else{
	
		define('HTTP', 'http://');
		
	}
	
	/************** File Path If Needed For Child Theme  *************/
						
		if( !function_exists('theneeds_get_root_directory') ){                      /* Get file path ( to support child theme ) */
			
			function theneeds_get_root_directory( $path ){
			
				if( file_exists( get_stylesheet_directory() . '/' . $path ) ){
				
					return esc_url(get_stylesheet_directory() . '/');
					
				}else{
				
					return esc_url(get_stylesheet_directory() . '/');
				}
			}
		}

		add_filter( 'wpcf7_support_html5_fallback', '__return_true' ); 
	
					
	/************** include essential files to enhance framework functionality *************/
					
		include_once(theneeds_FW.	'/script-handler.php');							/* It includes all javacript and style in theme */
		include_once(theneeds_FW.	'/extensions/super-object.php'); 				/* Super object function */
		include_once(theneeds_FW.	'/cp-functions.php'); 							/* Registered CP framework functions */
	
	/************** Theme and Framework Essential Files ************************************/ 
					
		include_once(theneeds_FW.	'/cp-option.php');								/* CP framework control panel */
		include_once(theneeds_FW.	'/theneeds_options_typography.php');			/* CP Typography control panel */
		include_once(theneeds_FW.	'/theneeds_options_slider.php');				/* CP Slider control panel */
		include_once(theneeds_FW.	'/theneeds_options_social.php');				/* CP Social Sharing */
		include_once(theneeds_FW.	'/theneeds_options_sidebar.php');				/* CP Sidebar Option Page */
		include_once(theneeds_FW.	'/theneeds_options_default_pages.php');			/* CP Default Options control panel */
		include_once(theneeds_FW.	'/theneeds_dummy_data_import.php');				/* CP Dummy Data control panel */
	
		/* Backend or Dashboard Options */
		include_once(theneeds_FW. '/options/meta-template.php'); 					/* templates for post portfolio and gallery */
		include_once(theneeds_FW. '/options/post-option.php');						/* Register meta fields for post_type */
		include_once(theneeds_FW. '/options/page-option.php'); 						/* Register meta fields page post_type */
		include_once(theneeds_FW. '/options/product-option.php');					/* WooCommerce Elements */
	
	
	/************** Widgets Included In The Theme ************************/ 
	
		include_once(theneeds_FW. '/extensions/widgets/theneeds_contact_info.php'); 			/* Contact Info Widget */
		include_once(theneeds_FW. '/extensions/widgets/theneeds_events_widget.php'); 			/* Custom About Widget */
		include_once(theneeds_FW. '/extensions/widgets/theneeds_popular_posts_widget.php'); 	/* Custom Popular Posts */
		include_once(theneeds_FW. '/extensions/widgets/theneeds_quick_links_widget.php'); 		/* Custom Quick Links Posts */
		include_once(theneeds_FW. '/extensions/widgets/theneeds_recent_posts_widget.php'); 		/* Custom Recent Posts Widget */
		include_once(theneeds_FW. '/extensions/widgets/theneeds_projects_widget.php'); 			/* Custom Projects Widget */
		

	/************** Plugins and Contact Files ************************/ 
	
		include_once(theneeds_FW. '/extensions/plugins.php'); 								/* Custom Or External Plugins */
	
	/************** Essential Theme Files  **************************/ 
					
		if(!is_admin()){
			include_once(theneeds_FW. '/extensions/sliders.php');	                            /* Functions to print sliders */
			include_once(theneeds_FW. '/options/page-elements.php');	                        /* Organize page item element */
			include_once(theneeds_FW. '/options/blog-elements.php');							/* Organize blog item element */
			include_once(theneeds_FW. '/extensions/comment.php'); 								/* function to get list of comment */
			include_once(theneeds_FW. '/extensions/pagination.php'); 							/* Register pagination plugin */
			include_once(theneeds_FW. '/extensions/social-shares.php'); 						/* Register social shares  */
			include_once(theneeds_FW. '/extensions/loadstyle.php');                  			/* Register breadcrumbs navigation */
			include_once(theneeds_FW. '/extensions/breadcrumbs.php');                 			/* Register breadcrumbs navigation */
			include_once(theneeds_FW. '/extensions/featured-content.php');                		/* Register Feature content */
			include_once(theneeds_FW. '/extensions/cp-headers.php'); 							/* Registered CP Header style */
			include_once(theneeds_FW. '/extensions/cp-footers.php'); 							/* Registered CP Header style */
		}
				
	/************** Fetch Values From Theme Panel  **************************/ 

		function theneeds_get_themeoption_value($para_val='',$get_option=''){
		
			/* Fetch Data From Theme Options */
			$theneeds_general_settings = get_option($get_option);
			
			if($theneeds_general_settings <> ''){
			
				$theneeds_logo = new DOMDocument ();
				
				$theneeds_logo->loadXML ( $theneeds_general_settings );
				
				return theneeds_find_xml_value($theneeds_logo->documentElement,$para_val);
				
			}else{
			
				return $para_val;
			}
		
		}
		
		
		/* 
	
			* ThemeForest Recommendation
			
			* "after_setup_theme" hook added
			
			* Calling required files/functions through setup function
			
			* Intialize Custom Functions On Theme Setup
	
		
		*/
		
		
		add_action( 'after_setup_theme', 'theneeds_theme_setup' );

		function theneeds_theme_setup() {
			
			add_action('woocommerce_before_main_content', 'theneeds_wrapper_start', 10);
		
			add_action('woocommerce_after_main_content', 'theneeds_wrapper_end', 10);
		
			add_action('woocommerce_before_main_content', 'theneeds_woocommerce_remove_breadcrumb');
		
			add_action( 'woo_custom_breadcrumb', 'theneeds_woocommerce_custom_breadcrumb' );	

			/* Theme Customize Class Hooks */
		
			add_action( 'customize_register' , array( 'theneeds_Customize' , 'theneeds_register' ) );
			
			add_action( 'wp_head' , array( 'theneeds_Customize' , 'theneeds_header_output' ) );
			
			add_action( 'customize_preview_init' , array( 'theneeds_Customize' , 'theneeds_live_preview' ) );


			/* Audio Player Hook */
			if ( ! has_action( 'audio_player', 'wp_print_styles' ) )
			add_action( 'audio_player', 'wp_print_styles', 11 );
			
			
			/* Register your custom function to override some LayerSlider data */
			add_action('layerslider_ready', 'theneeds_my_layerslider_overrides');
			
			
			
			/* Theme Dummy Installation */
			add_action('wp_ajax_theneeds_themeple_ajax_dummy_data', 'theneeds_themeple_ajax_dummy_data');
			
			
			/* Dummy Importer */
			add_action('wp_ajax_cp_dummy_import', 'theneeds_dummy_import');
			
			
			/* Dequeue LayerSlider Fonts */
			add_action( 'wp_enqueue_scripts', 'theneeds_wpse_dequeue_google_fonts', 10 );
			
		}
		
		/************** WooCommerce Sections  **************************/ 
				

		function theneeds_wrapper_start() {

			$select_layout_jobinn = '';	
			$theneeds_general_settings = get_option('general_settings');
			
			if($theneeds_general_settings <> ''){
				$theneeds_logo = new DOMDocument ();
				$theneeds_logo->loadXML ( $theneeds_general_settings );
				$select_layout_jobinn = theneeds_find_xml_value($theneeds_logo->documentElement,'select_layout_cp');
				
			}
			
			$theneeds_breadcrumbs = theneeds_get_themeoption_value('breadcrumbs','general_settings');
			
			$theneeds_header_style = '';
			$theneeds_html_class = theneeds_print_header_class($theneeds_header_style);
		?>
		
		<div id="inner-banner">
			<div class="container">
				<h1><?php if(is_single()){ echo esc_attr(get_the_title());}else{ woocommerce_page_title();};?></h1>
				<em><?php esc_html_e('WooCommerce Shop','theneeds');?></em>
				<?php /* Breadcrumb Only */
					$theneeds_breadcrumbs = '';
					$theneeds_breadcrumbs = theneeds_get_themeoption_value('breadcrumbs','general_settings');
					
					if($theneeds_breadcrumbs == 'enable'){

						echo do_action('woo_custom_breadcrumb');

					} /* breadcrumbs ends */ 
				?>
			</div>
		</div>
		
		<section class="container" id="main-woo"><div class = "product-page">	
		<?php }
		  
		function theneeds_wrapper_end() {
			
			echo '</div></section>';
		}
	
		/*  Reposition WooCommerce breadcrumb */
		function theneeds_woocommerce_remove_breadcrumb(){
			remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
		}

		/*  Custom WooCommerce breadcrumb */
		function theneeds_woocommerce_custom_breadcrumb(){
			woocommerce_breadcrumb();
		}


		/* Theme Dummy Installation Function */
		function theneeds_themeple_ajax_dummy_data(){
			require_once theneeds_FW . '/extensions/importer/dummy_data.inc.php';
			die(esc_html__('themeple_dummy','theneeds'));
		}
	
	
		/* Theme Dummy Data Installation */
		function theneeds_dummy_import(){
			foreach ($_REQUEST as $keys=>$values) {
				$$keys = trim($values);
			}
			$theneeds_layout = $layout;
			if(wp_verify_nonce( $theneeds_nonce_dummy, 'theneeds_nonce_dummy' )){
				require_once theneeds_FW . '/extensions/importer/dummy_data.inc.php';
				die(esc_html__('dummy_import','theneeds'));
			}else{
				die(esc_html__('Not Loaded','theneeds'));
			}
		}
	
	/**
	 * Contains methods for customizing the theme customization screen.
	 * 
	 * @link http://codex.wordpress.org/Theme_Customization_API
	 * @since MyTheme 1.0
	 */
	class theneeds_Customize {
	   
	   public static function theneeds_register ( $wp_customize ) {
		  //1. Define a new section (if desired) to the Theme Customizer
		  $wp_customize->add_section( 'theneeds', 
			 array(
				'title' => esc_html__( 'The Needs Options', 'theneeds' ), //Visible title of section
				'priority' => 35, //Determines what order this appears in
				'capability' => 'edit_theme_options', //Capability needed to tweak
				'description' => esc_html__('Allows you to customize some example settings for crunchpress.', 'theneeds'), //Descriptive tooltip
			 ) 
		  );
		  
		  //2. Register new settings to the WP database...
		  $wp_customize->add_setting( 'theneeds_options[link_textcolor]', //Give it a SERIALIZED name (so all theme settings can live under one db record)
			 array(
				'default' => '#ffffff', //Default setting/value to save
				'type' => 'option', //Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
				'sanitize_callback' => 'sanitize_hex_color'
			 ) 
		  );      
				
		  //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		  $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
			 $wp_customize, //Pass the $wp_customize object (required)
			 'theneeds_link_textcolor', //Set a unique ID for the control
			 array(
				'label' => esc_html__( 'Link Color & Button Color', 'theneeds' ), //Admin-visible name of the control
				'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'theneeds[link_textcolor]', //Which setting to load and manipulate (serialized is okay)
				'priority' => 10, //Determines the order this control appears in for the specified section
			 ) 
		  ) );
		  
		  
		  //4. We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
		  $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		  $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		  $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
		  $wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
	   }

	   /**
		* This will output the custom WordPress settings to the live theme's WP head.
		* 
		* Used by hook: 'wp_head'
		* 
		* @see add_action('wp_head',$func)
		* @since MyTheme 1.0
		*/
	   public static function theneeds_header_output() {
		  ?>
		  <!--Customizer CSS--> 
		  <style type="text/css">
			   <?php self::theneeds_generate_css('#site-title a', 'color', 'header_textcolor', '#'); ?> 
			   <?php self::theneeds_generate_css('body', 'background-color', 'background_color', '#'); ?> 
			   <?php self::theneeds_generate_css('a', 'color', 'theneeds[link_textcolor]'); ?>
		  </style> 
		  <!--/Customizer CSS-->
		  <?php
	   }
	   
	   /**
		* This outputs the javascript needed to automate the live settings preview.
		* Also keep in mind that this function isn't necessary unless your settings 
		* are using 'transport'=>'postMessage' instead of the default 'transport'
		* => 'refresh'
		* 
		* Used by hook: 'customize_preview_init'
		* 
		* @see add_action('customize_preview_init',$func)
		* @since MyTheme 1.0
		*/
	   public static function theneeds_live_preview() {
		  wp_enqueue_script( 
			   'theneeds-themecustomizer', // Give the script a unique ID
			   esc_url(get_template_directory_uri() . '/frontend/js/theme-customizer.js'), // Define the path to the JS file
			   array(  'jquery', 'customize-preview' ), // Define dependencies
			   '', // Define a version (optional) 
			   true // Specify whether to put in footer (leave this true)
		  );
	   }

		/**
		 * This will generate a line of CSS for use in header output. If the setting
		 * ($mod_name) has no defined value, the CSS will not be output.
		 * 
		 * @uses get_theme_mod()
		 * @param string $selector CSS selector
		 * @param string $style The name of the CSS *property* to modify
		 * @param string $mod_name The name of the 'theme_mod' option to fetch
		 * @param string $prefix Optional. Anything that needs to be output before the CSS property
		 * @param string $postfix Optional. Anything that needs to be output after the CSS property
		 * @param bool $echo Optional. Whether to print directly to the page (default: true).
		 * @return string Returns a single line of CSS with selectors and a property.
		 * @since MyTheme 1.0
		 */
		public static function theneeds_generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
		  $theneeds_return = '';
		  $theneeds_mod = get_theme_mod($mod_name);
		  if ( ! empty( $theneeds_mod ) ) {
			 $theneeds_return = sprintf('%s { %s:%s; }',
				$selector,
				$style,
				$prefix.$theneeds_mod.$postfix
			 );
			 if ( $echo ) {
				echo esc_attr($theneeds_return);
			 }
		  }
		  return $theneeds_return;
		}
	}

	function theneeds_my_layerslider_overrides() {
 
        /* Disable auto-updates for LayerSlider */
        $GLOBALS['lsAutoUpdateBox'] = false;
    
	}
	
	
	/* Admin Dashboard Notice HTML */
	function theneeds_admin_notice_framework() { ?>
		
		<div class="updated">
			<p><strong><?php esc_html_e( 'Please install theme required plug-ins to use all functionalities of theme', 'theneeds' ); ?></strong> - <?php esc_html_e('in case of deactivating the theme required plug-ins you may not able to use theme extra functionality.','theneeds');?></p>
		</div>
		
		<?php
	}

	/* DeQueue LayerSlider Fonts */
	function theneeds_wpse_dequeue_google_fonts() {
		
		wp_dequeue_style( 'ls-google-fonts' );

	}
	
	/* Avoiding Index.php Issue */
	function theneeds_get_featured_posts() {
		
		return apply_filters( 'theneeds_get_featured_posts', array() );
	
	}