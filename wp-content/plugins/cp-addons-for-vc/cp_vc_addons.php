<?php

    /*
    Plugin Name: CrunchPress Addons
    Plugin URI: http://www.crunchpress.com
    Description: CrunchPress Addons for Visual Composer
    Author: CrunchPress
    Version: 1.0
    Author URI: http://www.crunchpress.com
    */
	
	//echo site_url();exit;
	
	function campers_addons() {
		//include('includes/install/ag-install.php'); // install
	}

	register_activation_hook(__FILE__, 'campers_addons');
	
	add_action( 'admin_print_scripts', 'campers_addon_js' );
	
	function campers_addon_js(){
		//wp_enqueue_style( 'my-css', plugin_dir_url( __FILE__ ) . 'css/campers_vc_addons.css');
	}
	
	class campers_VC_Addons{
		var $paths = array();
		var $module_dir;
		var $params_dir;
		var $assets_js;
		var $assets_css;
		var $admin_js;
		var $admin_css;
		var $vc_template_dir;
		var $vc_dest_dir;
		function __construct()
		{
			$this->module_dir = plugin_dir_path( __FILE__ ).'modules/';
			add_action( 'admin_menu', array($this,'register_crunchpress_addons_menu'));
			add_action('after_setup_theme',array($this,'aio_init'));
			//add_action('init', array($this,'myajax_submit') );
			add_action( 'init', array($this,'example_ajax_request') );
			add_action( 'init', array($this,'contact_ajax_request') );
		}// end constructor
		
		function register_crunchpress_addons_menu(){
			if(!current_user_can( 'manage_options' ))
				return false;
			global $submenu;
			
			/* 			
			 add_submenu_page(
				"bsf-dashboard",
				__("About Ultimate","ultimate_vc"),
				__("About Ultimate","ultimate_vc"),
				"administrator",
				"about-ultimate",
				array($this,'load_about')
			);*/
			//$icon_url=plugins_url( '/images/logo.png' , __FILE__ );
		    //add_menu_page('CrunchPress Addons', 'CrunchPress Addons', 'manage_options', 'bsf-dashboard', '', "$icon_url");
	
		}
		
		function aio_init(){
			// activate addons one by one from modules directory
			$ultimate_modules = get_option('ultimate_modules');
			
			$ultimate_modules[] = 'theneeds_features_charity_project';
			$ultimate_modules[] = 'theneeds_projects_video';
			$ultimate_modules[] = 'theneeds_causes_slider';
			$ultimate_modules[] = 'theneeds_events';
			$ultimate_modules[] = 'theneeds_blog_posts';
			$ultimate_modules[] = 'theneeds_testimonials_contactform';
			$ultimate_modules[] = 'theneeds_team_members';
			$ultimate_modules[] = 'theneeds_newsletter';
			$ultimate_modules[] = 'theneeds_sponsors_gallery';
			$ultimate_modules[] = 'theneeds_features_grid';
			$ultimate_modules[] = 'theneeds_video_detail';
			$ultimate_modules[] = 'theneeds_project_slider';
			$ultimate_modules[] = 'theneeds_testimonials_slider';
			$ultimate_modules[] = 'theneeds_product_slider';
			$ultimate_modules[] = 'theneeds_join_us';
			$ultimate_modules[] = 'theneeds_causes_grid';
			$ultimate_modules[] = 'theneeds_causes_list';
			$ultimate_modules[] = 'theneeds_projects_displays';
			$ultimate_modules[] = 'theneeds_products_grid';
			$ultimate_modules[] = 'theneeds_gallery_layouts';
			$ultimate_modules[] = 'theneeds_contact_map';
			$ultimate_modules[] = 'theneeds_contact_map2';
			$ultimate_modules[] = 'theneeds_campaign_grid';
			$ultimate_modules[] = 'theneeds_campaign_list';
			$ultimate_modules[] = 'theneeds_campaign_slider';
			$ultimate_modules[] = 'theneeds_features_campaign_project';
			
			
			
			if(get_option('ultimate_row') == "enable")
				$ultimate_modules[] = 'ultimate_parallax';
			
			//echo "<pre>";print_r(glob($this->module_dir."/*.php"));
			
			foreach(glob($this->module_dir."/*.php") as $module)
			{
				
				$ultimate_file = basename($module);
				$ultimate_fileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $ultimate_file);
				
				if(is_array($ultimate_modules) && !empty($ultimate_modules)){ 
				
					if(in_array(strtolower($ultimate_fileName),$ultimate_modules) ){
						
						require_once($module);
					}
				}
			}
			
			if(in_array("woocomposer",$ultimate_modules) ){
				if(defined('WOOCOMMERCE_VERSION'))
				{
					if(version_compare( '2.1.0', WOOCOMMERCE_VERSION, '<' )) {
						foreach(glob(plugin_dir_path( __FILE__ ).'woocomposer/modules/*.php') as $module)
						{
							require_once($module);
						}
					} else {
						//add_action( 'admin_notices', array($this, 'woocomposer_admin_notice_for_woocommerce'));
					}
				} else {
					//add_action( 'admin_notices', array($this, 'woocomposer_admin_notice_for_woocommerce'));
				}
			}
		}
		
		function example_ajax_request() {	
		  
		   require_once( 'contact_submit.php' );
		}
		
		function contact_ajax_request(){	
			
			require_once( 'contact_submit.php' );
			
		}
		
	}
	
	new campers_VC_Addons;