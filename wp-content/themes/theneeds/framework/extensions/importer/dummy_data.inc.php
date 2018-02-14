<?php
/** 
     * @author CrunchPress
     * @copyright crunchpress[www.themeforest.net/user/crunchpress]
     * @version 2017
     */

if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

require_once ABSPATH . 'wp-admin/includes/import.php';

$import_filepath = get_template_directory()."/framework/extensions/importer/dummy_data";
$errors = false;

if ( !class_exists( 'WP_Importer' ) ) {

	require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';	
}

if ( !class_exists( 'WP_Import' ) ) {
	
	require_once theneeds_FW. '/extensions/importer/wordpress-importer.php';
}

if($errors){
	
	echo esc_html__("Errors while loading classes. Please use the standart wordpress importer.", "theneeds"); 

}else{
     
	include_once get_template_directory() . '/framework/extensions/importer/default_dummy_data.inc.php';
	
	if(!is_file($import_filepath.'_1.xml')){
	
		echo esc_html__("Problem with dummy data file. Please check the permisions of the xml file", "theneeds");
	
	}else{  
	   
	   if(class_exists( 'WP_Import' )){
	       global $wp_version;
			
			$our_class = new themeple_dummy_data();
			$our_class->fetch_attachments = true;
			$our_class->import($import_filepath.'_1.xml');
		
$widget_recent_event_widget = array (
  2 => 
  array (
    'title' => 'Upcoming Events',
    'recent_event_category' => '14',
    'number_of_events' => '3',
  ),
  3 => 
  array (
    'title' => 'Upcoming Events',
    'recent_event_category' => '14',
    'number_of_events' => '3',
  ),
  4 => 
  array (
    'title' => 'Upcoming Events',
    'recent_event_category' => '14',
    'number_of_events' => '3',
  ),
  5 => 
  array (
    'title' => 'Upcoming Events',
    'recent_event_category' => '14',
    'number_of_events' => '3',
  ),
  6 => 
  array (
    'title' => 'Upcoming Events',
    'recent_event_category' => '14',
    'number_of_events' => '3',
  ),
  7 => 
  array (
    'title' => 'Upcoming Events',
    'recent_event_category' => '14',
    'number_of_events' => '3',
  ),
  8 => 
  array (
    'title' => 'Upcoming Events',
    'recent_event_category' => '14',
    'number_of_events' => '3',
  ),
  '_multiwidget' => 1,
);$widget_theneeds_quick_links_widget = array (
  2 => 
  array (
    'title' => 'We Are Doing',
    'select_post_type' => 'Projects',
    'number_of_posts' => '6',
  ),
  '_multiwidget' => 1,
);$widget_twitter_widget = array (
  2 => 
  array (
    'title' => 'Latest Tweets',
    'consumer_key' => 'LiNR6cJamz1oTq76YCmOCg',
    'consumer_secret' => '7DziOUahT3cVHjUFZdv9DWGYxgs3dThwQdlxhlBLRo',
    'user_token' => '95420785-lc52fpbTrJYM02imucymoidZ0xzHabkWP5wEcbXkB',
    'user_secret' => 'vm642ki1HnOSMw6DTUPW8SrVcUaqCSsVolUhTssGI',
    'username_widget' => 'CrunchPress',
    'num_of_tweets' => '2',
  ),
  '_multiwidget' => 1,
);$widget_theneeds_contact_info = array (
  2 => 
  array (
    'title' => 'Stay in Touch',
    'address' => 'Care Building, 546 South, Smith Avenue, New York',
    'phone' => '+44 1234 5678',
    'fax' => '',
    'skype' => 'the.needs@skype.com',
    'email' => 'contact@theneeds.com',
    'website' => 'www.theneeds.com',
  ),
  '_multiwidget' => 1,
);$widget_cp_instagram = array (
  2 => 
  array (
    'title' => '',
    'nofimage' => '8',
    'username' => 'unicefusa',
  ),
  3 => 
  array (
    'title' => NULL,
    'nofimage' => '6',
    'username' => 'unicefusa',
  ),
  4 => 
  array (
    'title' => NULL,
    'nofimage' => '6',
    'username' => 'unicefusa',
  ),
  5 => 
  array (
    'title' => NULL,
    'nofimage' => '',
    'username' => '',
  ),
  '_multiwidget' => 1,
);$widget_search = array (
  2 => 
  array (
    'title' => 'Search',
  ),
  3 => 
  array (
    'title' => 'Search',
  ),
  4 => 
  array (
    'title' => 'Search',
  ),
  5 => 
  array (
    'title' => 'Search',
  ),
  6 => 
  array (
    'title' => 'Search',
  ),
  7 => 
  array (
    'title' => 'Search',
  ),
  '_multiwidget' => 1,
);$widget_text = array (
  2 => 
  array (
    'title' => 'Text Widget',
    'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer.',
    'filter' => true,
  ),
  3 => 
  array (
    'title' => 'Text Widget',
    'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer.',
    'filter' => true,
  ),
  4 => 
  array (
    'title' => 'Text Widget',
    'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer.',
    'filter' => true,
  ),
  5 => 
  array (
    'title' => 'Text Widget',
    'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer.',
    'filter' => true,
  ),
  6 => 
  array (
    'title' => 'Text Widget',
    'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer.',
    'filter' => true,
  ),
  7 => 
  array (
    'title' => 'Text Widget',
    'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer.',
    'filter' => true,
  ),
  '_multiwidget' => 1,
);$widget_theneeds_recent_posts_widget = array (
  2 => 
  array (
    'title' => 'Recent Posts',
    'get_cate_posts' => NULL,
    'nop' => '4',
  ),
  3 => 
  array (
    'title' => 'Recent Posts',
    'get_cate_posts' => NULL,
    'nop' => '4',
  ),
  4 => 
  array (
    'title' => 'Recent Posts',
    'get_cate_posts' => NULL,
    'nop' => '4',
  ),
  5 => 
  array (
    'title' => 'Recent Posts',
    'get_cate_posts' => NULL,
    'nop' => '4',
  ),
  6 => 
  array (
    'title' => 'Recent Posts',
    'get_cate_posts' => NULL,
    'nop' => '4',
  ),
  7 => 
  array (
    'title' => 'Recent Posts',
    'get_cate_posts' => NULL,
    'nop' => '4',
  ),
  '_multiwidget' => 1,
);$widget_theneeds_projects_widget = array (
  2 => 
  array (
    'title' => 'Recent Projects',
    'get_cate_posts' => 'projects-completed',
    'nop' => '2',
  ),
  3 => 
  array (
    'title' => 'Recent Projects',
    'get_cate_posts' => 'projects-completed',
    'nop' => '2',
  ),
  4 => 
  array (
    'title' => 'Recent Projects',
    'get_cate_posts' => 'projects-completed',
    'nop' => '2',
  ),
  5 => 
  array (
    'title' => 'Recent Projects',
    'get_cate_posts' => 'projects-completed',
    'nop' => '2',
  ),
  6 => 
  array (
    'title' => 'Recent Projects',
    'get_cate_posts' => 'projects-completed',
    'nop' => '2',
  ),
  7 => 
  array (
    'title' => 'Recent Projects',
    'get_cate_posts' => 'projects-completed',
    'nop' => '2',
  ),
  '_multiwidget' => 1,
);$widget_give_forms_widget = array (
  2 => 
  array (
    'title' => 'Make Donation',
    'id' => '457',
    'display_style' => 'onpage',
    'float_labels' => 'global',
  ),
  3 => 
  array (
    'title' => 'Make Donation',
    'id' => '457',
    'display_style' => 'onpage',
    'float_labels' => 'enabled',
  ),
  4 => 
  array (
    'title' => 'Make Donation',
    'id' => '457',
    'display_style' => 'onpage',
    'float_labels' => 'enabled',
  ),
  '_multiwidget' => 1,
);$sidebars_widgets=array (
  'wp_inactive_widgets' => 
  array (
  ),
  'sidebar-footer' => 
  array (
    0 => 'recent_event_widget-2',
    1 => 'theneeds_quick_links_widget-2',
    2 => 'twitter_widget-2',
    3 => 'theneeds_contact_info-2',
  ),
  'sidebar-instagram' => 
  array (
    0 => 'cp_instagram-2',
  ),
  'custom-sidebar0' => 
  array (
    0 => 'search-7',
    1 => 'text-7',
    2 => 'theneeds_recent_posts_widget-7',
    3 => 'theneeds_projects_widget-7',
    4 => 'recent_event_widget-8',
  ),
  'custom-sidebar1' => 
  array (
    0 => 'search-5',
    1 => 'text-5',
    2 => 'theneeds_recent_posts_widget-5',
    3 => 'theneeds_projects_widget-5',
    4 => 'recent_event_widget-6',
    5 => 'cp_instagram-4',
  ),
  'custom-sidebar2' => 
  array (
  ),
  'custom-sidebar3' => 
  array (
    0 => 'search-6',
    1 => 'text-6',
    2 => 'theneeds_recent_posts_widget-6',
    3 => 'theneeds_projects_widget-6',
    4 => 'recent_event_widget-7',
    5 => 'cp_instagram-5',
  ),
  'custom-sidebar4' => 
  array (
    0 => 'search-2',
    1 => 'text-2',
    2 => 'theneeds_recent_posts_widget-2',
    3 => 'theneeds_projects_widget-2',
    4 => 'recent_event_widget-3',
    5 => 'give_forms_widget-2',
  ),
  'give-forms-sidebar' => 
  array (
  ),
  'array_version' => 3,
);$show_on_front = 'page';$page_on_front = 14;$theme_mods_needs = array (
  0 => false,
  'custom_css_post_id' => -1,
  'nav_menu_locations' => 
  array (
    'header-menu' => 2,
  ),
);

			/* Default Widgets */
			save_option('sidebars_widgets','', $sidebars_widgets);
			save_option('widget_recent_event_widget','', $widget_recent_event_widget);
			save_option('widget_theneeds_quick_links_widget','', $widget_theneeds_quick_links_widget);			
			save_option('widget_twitter_widget','', $widget_twitter_widget);			
			save_option('widget_theneeds_contact_info','', $widget_theneeds_contact_info);	
			save_option('widget_cp_instagram','', $widget_cp_instagram);	
			save_option('widget_search','', $widget_search);
			save_option('widget_text','', $widget_text);
			save_option('widget_theneeds_recent_posts_widget','', $widget_theneeds_recent_posts_widget);
			save_option('widget_theneeds_projects_widget','', $widget_theneeds_projects_widget);
			save_option('widget_give_forms_widget','', $widget_give_forms_widget);
	

			/* Default Selective Options */
			save_option('show_on_front','', $show_on_front);
			save_option('page_on_front','', $page_on_front);
			save_option('theme_mods_needs','', $theme_mods_needs);			
		

        }
	}    
}


?>