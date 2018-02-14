<?php
/**
 * Template Name: Coming Soon Template
 *
 * @package WordPress
 * @subpackage CrunchPress
 * @since Themeforest
 */
	/* Include Head */
	wp_head(); 
	
	/* include content from plugin */
	if(shortcode_exists('comingsoon1')){
		
		do_shortcode('[comingsoon1]');
	}

	/* Include Footer */
	wp_footer();
?>