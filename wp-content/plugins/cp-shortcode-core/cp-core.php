<?php
/*
Plugin Name: CrunchPress Core
Plugin URI: http://www.crunchpress.com
Description: Crunchpress Shortcodes
Version: 1.0
Author: Eddie Forbes
Author URI: http://www.crunchpress.com
*/

class theneeds_Shortcodes {

    function __construct()
    {
    	require_once( 'shortcodes.php' );
    	define('theneeds_TINYMCE_URI', plugin_dir_url( __FILE__ ) . 'tinymce');
		define('theneeds_TINYMCE_DIR', plugin_dir_path( __FILE__ ) .'tinymce');
		define('theneeds_FRONTEND_URL', plugin_dir_url( __FILE__ ) .'frontend');
		define('theneeds_FRONTEND_DIR', plugin_dir_path( __FILE__ ) .'frontend');

        add_action('init', array(&$this, 'init'));
        add_action('admin_init', array(&$this, 'admin_init'));
        add_action('wp_ajax_theneeds_shortcodes_popup', array(&$this, 'popup'));
	}

	/**
	 * Registers TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function init()
	{

		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;

		if ( get_user_option('rich_editing') == 'true' )
		{
			add_filter( 'mce_external_plugins', array(&$this, 'add_rich_plugins') );
			add_filter( 'mce_buttons', array(&$this, 'register_rich_buttons') );
		}

	}

	// --------------------------------------------------------------------------

	/**
	 * Defins TinyMCE rich editor js plugin
	 *
	 * @return	void
	 */
	function add_rich_plugins( $plugin_array )
	{
		if( is_admin() ) {
			$plugin_array['theneeds_button'] = theneeds_TINYMCE_URI . '/plugin.js';
		}

		return $plugin_array;
	}

	// --------------------------------------------------------------------------

	/**
	 * Adds TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function register_rich_buttons( $buttons )
	{
		array_push( $buttons, 'theneeds_button' );
		return $buttons;
	}

	/**
	 * Enqueue Scripts and Styles
	 *
	 * @return	void
	 */
	function admin_init()
	{
		// css
		wp_enqueue_style( 'cp-popup', theneeds_TINYMCE_URI . '/css/popup.css', false, '1.0', 'all' );
		wp_enqueue_style( 'jquery.chosen', theneeds_TINYMCE_URI . '/css/chosen.css', false, '1.0', 'all' );
		wp_enqueue_style( 'font-awesome', theneeds_TINYMCE_URI . '/css/font-awesome.css', false, '3.2.1', 'all' );
		wp_enqueue_style( 'wp-color-picker' );

		// js
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-livequery', theneeds_TINYMCE_URI . '/js/jquery.livequery.js', false, '1.1.1', false );
		wp_enqueue_script( 'jquery-appendo', theneeds_TINYMCE_URI . '/js/jquery.appendo.js', false, '1.0', false );
		wp_enqueue_script( 'base64', theneeds_TINYMCE_URI . '/js/base64.js', false, '1.0', false );
		wp_enqueue_script( 'jquery.chosen', theneeds_TINYMCE_URI . '/js/chosen.jquery.min.js', false, '1.0', false );
    	wp_enqueue_script( 'wp-color-picker' );

		wp_enqueue_script( 'cp-popup', theneeds_TINYMCE_URI . '/js/popup.js', false, '1.0', false );

		// Developer mode
		$dev_mode = current_theme_supports( 'theneeds_shortcodes_embed' );
		if( $dev_mode ) {
			$dev_mode = 'true';
		} else {
			$dev_mode = 'false';
		}

		wp_localize_script( 'jquery', 'theneeds_Shortcodes', array('plugin_folder' => plugins_url( '', __FILE__ ), 'dev' => $dev_mode) );
	}

	/**
	 * Popup function which will show shortcode options in thickbox.
	 *
	 * @return void
	 */
	function popup() {

		require_once( theneeds_TINYMCE_DIR . '/cp-sc.php' );

		die();

	}

}
$theneeds_shortcodes_obj = new theneeds_Shortcodes();
?>