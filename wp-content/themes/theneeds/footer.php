<?php
/** 

* The template for displaying the footer 

* Contains footer content and the closing of the #main and #page div elements. 

* @package CrunchPress 

* @subpackage WP

*/
	global $post;
	
	if (isset($post)) {
		
		$theneeds_footer_style = get_post_meta($post->ID, "page-option-bottom-footer-style", true);
	
	} else {
		
		$theneeds_footer_style = '';
	}
	
	theneeds_footer_html($theneeds_footer_style); ?> 
   
</div>

<?php wp_footer(); ?>

</body>

</html>