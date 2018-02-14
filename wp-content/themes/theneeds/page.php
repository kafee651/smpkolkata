<?php
/*
 * This file is used to generate different page layouts set from backend.
 */

	get_header ();


		$theneeds_page_builder_full = get_post_meta ( $post->ID, "cp-show-full-layout", true );      
		
		/* PageBuilder Full View  (Depr) */
		if(isset($theneeds_page_builder_full)){

			$theneeds_sidebar_class = '';
			$theneeds_content_class = '';
			$theneeds_sidebar = get_post_meta ( $post->ID, 'page-option-sidebar-template', true );
			$theneeds_sidebar_class = theneeds_sidebar_func($theneeds_sidebar);
			
			$theneeds_left_sidebar = get_post_meta ( $post->ID, "page-option-choose-left-sidebar", true );
			
			$theneeds_right_sidebar = get_post_meta ( $post->ID, "page-option-choose-right-sidebar", true );
			
		}else{
			$theneeds_sidebar_class = array('0'=>'no-sidebar','1'=>'col-md-12',);
			$theneeds_content_class = array();
			$theneeds_sidebar = array();
			$theneeds_left_sidebar = '';
			$theneeds_right_sidebar = '';
		}	
		
		
		$theneeds_slider_off = '';
		$theneeds_slider_type = '';
		$theneeds_slider_slide = '';
		$theneeds_slider_height = '';
		
		/* Page Meta Data */
		$theneeds_slider_off = get_post_meta ( $post->ID, "page-option-top-slider-on", true );
		$theneeds_page_builder_full = get_post_meta ( $post->ID, "cp-show-full-layout", true );
		$theneeds_page_title_breadcrumb = get_post_meta ( $post->ID, "page-option-item-page-title", true );
		$theneeds_banner_text = get_post_meta ( $post->ID, "page-option-top-banner-text", true );
		$theneeds_page_caption = get_post_meta ( $post->ID, "cp-show-page-caption-pageant", true );
		
		
		
		if(class_exists('theneeds_slider_class')){
		
			if($theneeds_slider_off == 'Yes'){
				
				theneeds_page_slider();
				
			}elseif($theneeds_slider_off == 'Yes' && !is_front_page()){
				
				/* Yet To Be Implemented */
			
			}else{
				
				/* Yet To Be Implemented */
			}		
		
		}

		
		if(is_search() || is_404()){
			
			$theneeds_header_style = '';
		
		}else{
			
			$theneeds_header_style = get_post_meta ( $post->ID, "page-option-top-header-style", true );
		}
		
		$theneeds_html_class = theneeds_print_header_class($theneeds_header_style);
		
		
		if(theneeds_print_header_html_val($theneeds_header_style) == 'Style 7'){
			
			theneeds_print_header_html($theneeds_header_style);
		}
		
		$theneeds_breadcrumbs = theneeds_get_themeoption_value('breadcrumbs','general_settings');
		
		/* Page Caption */
		global $post;
		$theneeds_page_caption = '';
		$theneeds_page_caption = get_post_meta ( $post->ID, "page-option-item-page-caption-below-bread", true );

	?>

	<div class="content">
	
	<?php /* If banner is NOT Selected Then Display Breadcrumb Section */
		$theneeds_selected_banner = '';
		if($theneeds_slider_off !== 'Yes'){
			if($theneeds_slider_off <> 'Yes' || !is_front_page()){ ?>
				<div id="inner-banner">
					<div class="container">
					  <h1><?php  echo get_the_title();?></h1>
						<em><?php echo esc_attr($theneeds_page_caption);?></em>
						<?php /* Breadcrumb Only */
						$theneeds_breadcrumbs = '';
						$theneeds_breadcrumbs = theneeds_get_themeoption_value('breadcrumbs','general_settings');
						
						if($theneeds_breadcrumbs == 'enable'){?>

							<?php echo theneeds_breadcrumbs(); 

						} /* breadcrumbs ends */ ?>
					</div>
				</div>
				<?php 
			}
		} 
	?>
					
		
		<div class="<?php if($theneeds_page_builder_full <> 'Yes'){echo '';}else{echo 'full-width-content margin-top-bottom-cp ';}?>">
			<?php 
				if($theneeds_slider_off == 'No'){
					if($theneeds_page_builder_full == 'Yes'){echo '<div class="container">';}
					if($theneeds_page_builder_full == 'Yes'){echo '</div>';}
				}
			?>    
			
			<div class="main-content <?php if($theneeds_page_builder_full <> 'Yes'){echo 'margin-top-bottom-cp';}?>">
				<div class="page_content">
					<div class = "container">
						<div class = "row">
							<?php /* Sidebar Settings */
							if($theneeds_sidebar == "left-sidebar" || $theneeds_sidebar == "both-sidebar" || $theneeds_sidebar == "both-sidebar-left"){ ?>
								<div id="block_first" class="sidebar side-bar padd-tb <?php echo esc_attr($theneeds_sidebar_class[0]);?>">
								  <?php dynamic_sidebar( $theneeds_left_sidebar ); ?>
								</div>
							<?php
							}
							if($theneeds_sidebar == 'both-sidebar-left'){ ?>
								<div id="block_first_left" class="sidebar side-bar padd-tb <?php echo esc_attr($theneeds_sidebar_class[0]);?>">
								  <?php dynamic_sidebar( $theneeds_right_sidebar );?>
								</div>
							<?php 
							} ?>
						
							<div id="block_content_first" class="<?php echo esc_attr($theneeds_sidebar_class[1]);?>">
								<div class="container-res">
									<div class="<?php if(theneeds_get_themeoption_value('select_layout_cp','general_settings') == 'boxed_layout'){echo 'row';}else{echo 'row';}?>">
									<?php /* Page Content */
										$theneeds_page_xml = get_post_meta($post->ID,'page-option-item-xml', true);		
										$theneeds_item_row_size = 0;	
										$theneeds_counter = 0;
										
										if (! empty ( $theneeds_page_xml )) {
											$theneeds_page_xml_val = new DOMDocument ();
											$theneeds_page_xml_val->loadXML ( $theneeds_page_xml );
											foreach ( $theneeds_page_xml_val->documentElement->childNodes as $item_xml ) {
												$theneeds_counter++;
												switch ($item_xml->nodeName) {

												}
											}
											/* Content Area */
											if($theneeds_page_xml_val->documentElement->childNodes->length == 0){
												echo '<div class="">';
													theneeds_print_default_content_item();
												echo '</div>';
											}										
										}else{
											echo '<div class="">';
												theneeds_print_default_content_item();
											echo '</div>';
										}
									?>
									</div>
								</div>
							</div>
							
							<?php
							/* Sidebar Settings */
							if($theneeds_sidebar == "both-sidebar-right"){ ?>
								<div id="block_second" class="sidebar side-bar padd-tb <?php echo esc_attr($theneeds_sidebar_class[0]);?>">
								  <?php dynamic_sidebar( $theneeds_left_sidebar ); ?>
								</div>
							<?php
							}
							if($theneeds_sidebar == 'both-sidebar-right' || $theneeds_sidebar == "right-sidebar" || $theneeds_sidebar == "both-sidebar"){ ?>
								<div id="block_second_right" class="sidebar side-bar padd-tb <?php echo esc_attr($theneeds_sidebar_class[0]);?>">
								  <?php dynamic_sidebar( $theneeds_right_sidebar );?>
								</div>
							<?php 
							} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php /* Reset all data now */ wp_reset_postdata();
	get_footer(); 
?>