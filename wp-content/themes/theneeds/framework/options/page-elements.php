<?php

	/*
	*	CrunchPress Page Item File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		CrunchPress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) CrunchPress
	*	---------------------------------------------------------------------
	*	This file contains the function that can print each page item in 
	*	different conditions.
	*	---------------------------------------------------------------------
	*/

	/*  Print column */
	function theneeds_print_column_item($item_xml){
		
		//echo do_shortcode(html_entity_decode(theneeds_find_xml_value($item_xml,'column-text')));
	}

	
	
	
	/* Print Sidebar */
	function theneeds_print_sidebar_item($item_xml){ 
	
		$theneeds_select_layout = theneeds_find_xml_value($item_xml, 'sidebar-layout-select'); 
		
		dynamic_sidebar( $theneeds_select_layout );
		
	
	}
	
	/* Division Ends Here */
	function theneeds_print_div_end_item ( $item_xml ){
		
	}
	
	/* Division Ends Here */
	function theneeds_print_div_end_item_old ( $item_xml ){
		
	}
	
	
	/* Division of sections */
	function theneeds_print_div_item ( $item_xml ){
		
		
	}
	
	/* Division of sections */
	function theneeds_print_div_item_old ( $item_xml ){
		
	
	}

	$theneeds_gallery_div_size_listing_class = array(
		
	); 	
	
	/* Print gallery */
	function theneeds_print_gallery_item($item_xml){
	
		
	} 
	
	
	
	function theneeds_heading_style($item_xml,$echo=''){
	

	}

	
	/* Newest Album Section */
	function theneeds_print_newest_album_item($item_xml){
		
		
	}
	
	/* Newest Album Section */
	function theneeds_print_footer_shop_item($category_product="",$bg_img=""){
		
	}
	

	/* Blog Item */
	function theneeds_print_blog_item_item($item_xml){
		
	
	}
	
	/* WooProduct Slider */
	function theneeds_print_woo_product_slider_item($item_xml){ 
	
		
	}	
	
	
	/* Print Content Item */
	function theneeds_print_default_content_item(){
		
		while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<a href="<?php echo esc_url(get_permalink());?>">
			<?php
				
			?>
			</a>
			<div class="entry-content-cp">
				<?php
					the_content();
					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'theneeds' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					) );

					edit_post_link( esc_html__( 'Edit', 'theneeds' ), '<span class="edit-link">', '</span>' );
				?>
			</div><!-- .entry-content -->
		</div><!-- #post-## -->
		
		<?php
		
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				echo '<div class="comment-box">';
					comments_template();
				echo '</div>';
			}
		
		endwhile;
	}
	
	/* Print Tab */
	function theneeds_print_tab_item($item_xml){
	
		
	}
	
	
	
	
	/* Print column service */
	function theneeds_print_column_service($item_xml){		
		
	}

	/* Print contact form */
	function theneeds_print_contact_form($item_xml){

	}
	
	/* News Slider */
	function theneeds_print_news_slider_box($item_xml){
		
	}
	
	/* News Headline Function Starts Here */
	function theneeds_print_news_headline($item_xml){

		
	}


	/* size is when no sidebar, side2 is use when 1 sidebar, side 3 is use when 3 sidebar */
	
	$theneeds_is_responsive = 'enable';
	
	if( $theneeds_is_responsive ){
		
		$theneeds_port_div_size_num_class = array(	);	
	}else{
		
		$theneeds_port_div_size_num_class = array( );
	}
	
	$theneeds_class_to_num = array( );
	

	/* Donation Box */
	function theneeds_print_donate_item($item_xml){
		
	}
	
	/* Blog Slider  */
	function theneeds_print_blog_slider_item($item_xml){ 
	
		
	}
	
	/* Crowd Funding Functions to Fetch Products */
	function theneeds_print_funds_item_item($item_xml){ 
		
	}
	
	/* WooCommerece Feature Products */
	function theneeds_print_woo_product_feature_item($item_xml){ 
		
	}
	
	/* News Bar Under Slider */
	function theneeds_news_bar_frontpage($news_button,$news_title,$news_category){

		
	}

	/* Top Meta Items */
	function theneeds_top_meta_items(){
		
	}