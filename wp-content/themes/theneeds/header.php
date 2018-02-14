<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
	
	<meta charset="<?php esc_html(bloginfo( 'charset' )); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php esc_html(bloginfo( 'pingback_url' )); ?>">
	
	<?php wp_head(); ?>
	
    
</head>

<body <?php body_class();?>>
	
	<!--Wrapper Start-->
	
	<div id="wrapper" class="theme-style-1">
	
		<?php

			/* For 404 & Search Page 
			
			* Default or Selected will Be used
			
			*/
			
			if(is_search() || is_404() || is_archive()){
			
				$theneeds_header_style = '';
				
			}else{
			
				/* Fetch Header Selected From CP Theme Panel 
				*
				* Custom File For Header Functions
				*
				*/
				$theneeds_header_style = get_post_meta ( $post->ID, "page-option-top-header-style", true );
				
			}
		
			if(theneeds_print_header_html_val($theneeds_header_style) <> 'Style 7'){
			
				/* If Not Header 7 then Use the header normal layout 
				
				* Else you might need to tweak html in case of header 7
				
				*/
				
				theneeds_print_header_html($theneeds_header_style);
			
			}
?>