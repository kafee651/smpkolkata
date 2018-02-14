<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @package	   TGM-Plugin-Activation
 * @subpackage Example
 * @version	   2.6.1
 * @author	   Thomas Griffin <thomas@thomasgriffinmedia.com>
 * @author	   Gary Jones <gamajo@gamajo.com>
 * @copyright  Copyright (c) 2012, Thomas Griffin
 * @license	   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/framework/extensions/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'theneeds_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function theneeds_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		/* WordPress Importer */
		array(
            'name'      => esc_html__('Wordpress Importer','theneeds'),
            'slug'      => esc_html__('wordpress-importer','theneeds'),
            'required'  => true,
			'force_activation' => false,
        ),

		/* WP Globus Translation */
		array(
            'name'      => esc_html__('WP Globus','theneeds'),
            'slug'      => esc_html__('wpglobus','theneeds'),
            'required'  => false,
        ),
		
		/* Event Manager */
		array(
            'name'      => esc_html__('Event Manager','theneeds'),
            'slug'      => esc_html__('events-manager','theneeds'),
            'required'  => true,
        ),
		
		/* WooCommerce Shopping */
		array(
            'name'      => esc_html__('WooCommerce Shopping','theneeds'),
            'slug'      => esc_html__('woocommerce','theneeds'),
            'required'  => true,
        ),
		
		/* Give - Donation Plugin */
		array(
            'name'      => esc_html__('Give - Donation Plugin','theneeds'),
            'slug'      => esc_html__('give','theneeds'),
            'required'  => true,
        ),
		
		/* Contact Form 7 */
		array(
            'name'      => esc_html__('Contact Form 7', 'theneeds'),
            'slug'      => esc_html__('contact-form-7','theneeds'),
            'required'  => false,
        ),
		
		/* Charitable Charity Plugin */
		array(
            'name'      => esc_html__('Charitable', 'theneeds'),
            'slug'      => esc_html__('charitable','theneeds'),
            'required'  => false,
        ),
		
		
		/* Visual Composer */
		array(
			'name'     				=> esc_html__('WPBakery Visual Composer','theneeds'), 	/* The plugin name */
			'slug'     				=> esc_html__('js_composer','theneeds'), /* The plugin slug (typically the folder name) */
			'source'   				=> get_template_directory() . '/framework/extensions/plugins/js_composer.zip', /* The plugin source */
			'required' 				=> true, 	/* If false, the plugin is only 'recommended' instead of required */
			'version' 				=> '', 		/* E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented */
			'force_activation' 		=> false, 	/* If true, plugin is activated upon theme activation and cannot be deactivated until theme switch */
			'force_deactivation' 	=> false, 	/* If true, plugin is deactivated upon theme switch, useful for theme-specific plugins */
			'external_url' 			=> '', 		/* If set, overrides default API URL and points to an external URL */
		),
		
		/* Addon - Visual Composer */
		array(
			'name'     				=> esc_html__('CP Addons For VC','theneeds'), /* The plugin name */
			'slug'     				=> esc_html__('cp-addons-for-vc','theneeds'), /* The plugin slug (typically the folder name) */
			'source'   				=> get_template_directory() . '/framework/extensions/plugins/cp-addons-for-vc.zip', /* The plugin source */
			'required' 				=> true, 	/* If false, the plugin is only 'recommended' instead of required */
			'version' 				=> '',		/* E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented */
			'force_activation' 		=> false, 	/* If true, plugin is activated upon theme activation and cannot be deactivated until theme switch */
			'force_deactivation' 	=> false, 	/* If true, plugin is deactivated upon theme switch, useful for theme-specific plugins */
			'external_url' 			=> '', 		/* If set, overrides default API URL and points to an external URL */
		),
		
		/* CrunchPress Framework */
		array(
			'name'     				=> esc_html__('CrunchPress Framework','theneeds'), /* The plugin name */
			'slug'     				=> esc_html__('cp-framework','theneeds'), /* The plugin slug (typically the folder name) */
			'source'   				=> get_template_directory() . '/framework/extensions/plugins/cp-framework.zip', /* The plugin source */
			'required' 				=> true, 	/* If false, the plugin is only 'recommended' instead of required */
			'version' 				=> '', 		/* E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented */
			'force_activation' 		=> false, 	/* If true, plugin is activated upon theme activation and cannot be deactivated until theme switch */
			'force_deactivation' 	=> false, 	/* If true, plugin is deactivated upon theme switch, useful for theme-specific plugins */
			'external_url' 			=> '', 		/* If set, overrides default API URL and points to an external URL */
		),
		
		/* CrunchPress Shortcodes */
		array(
			'name'     				=> esc_html__('CrunchPress Shortcodes','theneeds'), /* The plugin name */
			'slug'     				=> esc_html__('cp-shortcode-core','theneeds'), /* The plugin slug (typically the folder name)	 */
			'source'   				=> get_template_directory() . '/framework/extensions/plugins/cp-shortcode-core.zip', /* The plugin source */
			'required' 				=> true, 	/* If false, the plugin is only 'recommended' instead of required */
			'version' 				=> '', 		/* E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented */
			'force_activation' 		=> false, 	/* If true, plugin is activated upon theme activation and cannot be deactivated until theme switch */
			'force_deactivation' 	=> false, 	/* If true, plugin is deactivated upon theme switch, useful for theme-specific plugins */
			'external_url' 			=> '', 		/* If set, overrides default API URL and points to an external URL */
		),
		
	);
	
	/* Change this to your theme text domain, used for internationalising strings */
	$theme_text_domain = 'theneeds';

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'theneeds',         			/*  Text domain - likely want to be the same as your theme. */
		'default_path' 		=> '',                         	/* Default absolute path to pre-packaged plugins */
		'menu'         		=> 'install-required-plugins', 	/* Menu slug */
		'has_notices'      	=> true,                       	/* Show admin notices or not */
		'is_automatic'    	=> false,					   	/* Automatically activate plugins after installation or not */
		'message' 			=> '',							/* Message to output right before the plugins table */
		'strings'      		=> array(
			'page_title'                       			=> esc_html__( 'Install Required Plugins', 'theneeds' ),
			'menu_title'                       			=> esc_html__( 'Install Plugins', 'theneeds' ),
			'installing'                       			=> esc_html__( 'Installing Plugin: %s', 'theneeds' ), // %1$s = plugin name
			'oops'                             			=> esc_html__( 'Something went wrong with the plugin API.', 'theneeds' ),
			'notice_can_install_required'     			=> _n_noop( esc_html__('This theme requires the following plugin: %1$s.', 'theneeds'), esc_html__('This theme requires the following plugins: %1$s.', 'theneeds' )), /* %1$s = plugin name(s) */
			'notice_can_install_recommended'			=> _n_noop( esc_html__('This theme recommends the following plugin: %1$s.', 'theneeds'), esc_html__('This theme recommends the following plugins: %1$s.', 'theneeds' )), /* %1$s = plugin name(s) */
			'notice_cannot_install'  					=> _n_noop( esc_html__('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'theneeds'), esc_html__('Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'theneeds' )), /* %1$s = plugin name(s) */
			'notice_can_activate_required'    			=> _n_noop( esc_html__('The following required plugin is currently inactive: %1$s.', 'theneeds'), esc_html__('The following required plugins are currently inactive: %1$s.', 'theneeds' )), /* %1$s = plugin name(s) */
			'notice_can_activate_recommended'			=> _n_noop( esc_html__('The following recommended plugin is currently inactive: %1$s.', 'theneeds'), esc_html__('The following recommended plugins are currently inactive: %1$s.', 'theneeds' )), /* %1$s = plugin name(s) */
			'notice_cannot_activate' 					=> _n_noop( esc_html__('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'theneeds'), esc_html__('Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'theneeds' )), /* %1$s = plugin name(s) */
			'notice_ask_to_update' 						=> _n_noop( esc_html__('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'theneeds'), esc_html__('The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'theneeds' )), /* %1$s = plugin name(s) */
			'notice_cannot_update' 						=> _n_noop( esc_html__('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'theneeds'), esc_html__('Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'theneeds' )), /* %1$s = plugin name(s) */
			'install_link' 					  			=> _n_noop( esc_html__('Begin installing plugin', 'theneeds'), esc_html__('Begin installing plugins', 'theneeds' )),
			'activate_link' 				  			=> _n_noop( esc_html__('Activate installed plugin', 'theneeds'), esc_html__('Activate installed plugins', 'theneeds' )),
			'return'                           			=> esc_html__( 'Return to Required Plugins Installer', 'theneeds' ),
			'plugin_activated'                 			=> esc_html__( 'Plugin activated successfully.', 'theneeds' ),
			'complete' 									=> esc_html__( 'All plugins installed and activated successfully. %s', 'theneeds' ), /* %1$s = dashboard link */
			'nag_type'									=> 'updated' /* Determines admin notice type - can only be 'updated' or 'error' */
		)
	);

	tgmpa( $plugins, $config );

}