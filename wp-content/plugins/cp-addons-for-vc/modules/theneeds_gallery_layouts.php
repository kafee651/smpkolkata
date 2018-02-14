<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_gallery_layouts")){
	class theneeds_gallery_layouts{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_gallery_layouts_init"));
			add_shortcode('theneeds_gallery_layouts',array($this,'theneeds_gallery_layouts_shortcode'));
		}
		function theneeds_gallery_layouts_init(){

			if(function_exists("vc_map")){
			
				/* Fetch Hotspot Posts */
				$gallery_title = array();
				
				$galleries = get_posts(array('post_type' => 'gallery', 'numberposts'=>100));
				
				if(is_array($galleries)){
					foreach ($galleries as $gallery) {
						$gallery_title[$gallery->ID] = $gallery->ID;
					}
				}else{
					$gallery_title = array();
				}
				
				vc_map( array(
					"base" => "theneeds_gallery_layouts",
					"name" => __( "Gallery Layouts", "js_composer" ),
					"class" => "theneeds_gallery_layouts_class",
					"icon" => "theneeds_gallery_layouts_icon",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"params" => array(
					
						array(
								"type" => "dropdown",
								"holder" => "p",
								"heading" => __( "Select Gallery", "js_composer" ),
								"param_name" => "category_name",
								"value" => $gallery_title,
								"description" => __( "Select Gallery From The Dropdown", "js_composer" )
						),
						
						array(
							'type' => 'dropdown',
							"holder" => "p",
							'heading' => __( 'Select Gallery Layout Style', 'js_composer' ),
							'param_name' => 'select_style',
							'value' =>  array( __( 'Full', 'js_composer' ) => 'full',
												__( 'Large', 'js_composer' ) => 'large',
												__( 'Medium', 'js_composer' ) => 'medium',
												
												),
							'description' => __( 'Select Gallery Style From Given Options', 'js_composer' ),
						),
						
						array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Image Count", "js_composer" ),
								"param_name" => "img_count",
								"description" => __( "Enter Images To Display On First Page", "js_composer" )
						),

					)
				) );
			}
		}
		
		
		function theneeds_gallery_layouts_shortcode( $atts, $content = null ) {
			
			$result = shortcode_atts( array(
				
				'category_name' => '',
				'select_style' => 'full',
				'img_count' => '8',

			), $atts );
			
			
			extract( $result );
			
			/* Pretty Photo Scripts */
			wp_enqueue_style('prettyPhoto',theneeds_PATH_URL.'/frontend/css/prettyphoto.min.css');
		
			wp_enqueue_script( 'prettyPhoto', theneeds_PATH_URL.'/frontend/js/jquery.prettyphoto.min.js', false, '1.0', true);
			
			
			/*** Full Gallery ***/
			if($select_style == 'full'){
			
				global $theneeds_gallery_layouts_div_size_listing_class;
				
				global $paged,$sidebar,$post_id,$wp_query;	

				$output = '';

				if(empty($paged)){
					
					$theneeds_paged = (get_query_var('page')) ? get_query_var('page') : 1; 
				}
			
				$theneeds_gal_counter = 3;
				$theneeds_gallery_layouts_size = 'Catalogue View';
				$theneeds_gallery_layouts_size = '';
				$theneeds_num_size = $img_count;
				$theneeds_gallery_layouts_class = '';

				/* Gallery XML */
				$theneeds_slider_xml_string = get_post_meta($category_name,'post-option-gallery-xml', true);
				
				if($theneeds_slider_xml_string <> ''){
					
					$theneeds_slider_xml_dom = new DOMDocument();
						
						if( !empty( $theneeds_slider_xml_string ) ){
							
							$theneeds_slider_xml_dom->loadXML($theneeds_slider_xml_string);
							
							$output .= '
							
							<section class="gallery-section">
							  <div class="element_wrap">
								<div class="gallery">';
								
										$theneeds_children = $theneeds_slider_xml_dom->documentElement->childNodes;
							
										if ( empty($wp_query->query['paged']) ) $wp_query->query['paged'] = 1;
								
											$theneeds_total_page = '';
											
											if($theneeds_num_size > 0){
												
												$theneeds_limit_start = $theneeds_num_size * ($wp_query->query['paged']-1);
												
												$theneeds_limit_end = $theneeds_limit_start + $theneeds_num_size;
												
												if ( $theneeds_limit_end > $theneeds_slider_xml_dom->documentElement->childNodes->length ) {
	
													$theneeds_limit_end = $theneeds_slider_xml_dom->documentElement->childNodes->length;
												}
												
												if($theneeds_num_size < $theneeds_slider_xml_dom->documentElement->childNodes->length){
													
													$theneeds_total_page = ceil($theneeds_slider_xml_dom->documentElement->childNodes->length/$theneeds_num_size);
													
												}else{
													
													$theneeds_total_page = 1;
												}
											
											}else {
										
												$theneeds_limit_start = 0;
												
												$theneeds_limit_end = $theneeds_slider_xml_dom->documentElement->childNodes->length;
											
											}
											
											$theneeds_counter_gal_element = 0;
											
											$theneeds_single_col = 0;
								
											for($i=$theneeds_limit_start;$i<$theneeds_limit_end;$i++) { 
												
												$theneeds_thumbnail_id = theneeds_find_xml_value($theneeds_children->item($i), 'image');
												$theneeds_title = theneeds_find_xml_value($theneeds_children->item($i), 'title');
												$theneeds_caption = theneeds_find_xml_value($theneeds_children->item($i), 'caption');
												$theneeds_link_type = theneeds_find_xml_value($theneeds_children->item($i), 'linktype');
												$theneeds_video = theneeds_find_xml_value($theneeds_children->item($i), 'video');
												
												$theneeds_image_url = wp_get_attachment_image_src($theneeds_thumbnail_id, 'full');
												$theneeds_alt_text = get_post_meta($theneeds_thumbnail_id , '_wp_attachment_image_alt', true);	
												
												
													
													$output .= '
													
													<div class="col-md-12 col-sm-6">
														<div class="thumb"> <img src="'.esc_url($theneeds_image_url[0]).'" alt="'.esc_html__('img','theneeds').'">
														  <div class="caption">
															<div class="inner">
															  <div class="btn-row"> 
																<a href="'.esc_url($theneeds_image_url[0]).'" class="link" data-rel="prettyPhoto[gallery1]"><i class="fa fa-plus" aria-hidden="true"></i></a> 
																<a data-rel="prettyPhoto[gallery1]" href="'.esc_url($theneeds_image_url[0]).'" class="link"><i class="fa fa-link" aria-hidden="true"></i></a> 
															   </div>
															</div>
														  </div>
														</div>
													</div>';
		
											} /* end forloop */
										
						} /* endif */
						
						/***** Pagination ****/
						$output .= pagination_crunch($pg_style = '',$style = '', $theneeds_total_page, $range = 4);
								
					} /* endif */
					
						$output .= '
					</div>
				  </div>
				</section>';
			
				return $output;
			
			} /* endif style 1 */
			
			
			/*** Large ***/
			if($select_style == 'large'){
			
				global $theneeds_gallery_layouts_div_size_listing_class;
				
				global $paged,$sidebar,$post_id,$wp_query;	

				$output = '';

				if(empty($paged)){
					
					$theneeds_paged = (get_query_var('page')) ? get_query_var('page') : 1; 
				}
			
				$theneeds_gal_counter = 3;
				$theneeds_gallery_layouts_size = 'Catalogue View';
				$theneeds_gallery_layouts_size = '';
				$theneeds_num_size = $img_count;
				$theneeds_gallery_layouts_class = '';

				/* Gallery XML */
				$theneeds_slider_xml_string = get_post_meta($category_name,'post-option-gallery-xml', true);
				
				if($theneeds_slider_xml_string <> ''){
					
					$theneeds_slider_xml_dom = new DOMDocument();
						
						if( !empty( $theneeds_slider_xml_string ) ){
							
							$theneeds_slider_xml_dom->loadXML($theneeds_slider_xml_string);
							
							$output .= '
							
							<section class="gallery-section">
							  <div class="element_wrap">
								<div class="gallery">';
								
										$theneeds_children = $theneeds_slider_xml_dom->documentElement->childNodes;
							
										if ( empty($wp_query->query['paged']) ) $wp_query->query['paged'] = 1;
								
											$theneeds_total_page = '';
											
											if($theneeds_num_size > 0){
												
												$theneeds_limit_start = $theneeds_num_size * ($wp_query->query['paged']-1);
												
												$theneeds_limit_end = $theneeds_limit_start + $theneeds_num_size;
												
												if ( $theneeds_limit_end > $theneeds_slider_xml_dom->documentElement->childNodes->length ) {
	
													$theneeds_limit_end = $theneeds_slider_xml_dom->documentElement->childNodes->length;
												}
												
												if($theneeds_num_size < $theneeds_slider_xml_dom->documentElement->childNodes->length){
													
													$theneeds_total_page = ceil($theneeds_slider_xml_dom->documentElement->childNodes->length/$theneeds_num_size);
													
												}else{
													
													$theneeds_total_page = 1;
												}
											
											}else {
										
												$theneeds_limit_start = 0;
												
												$theneeds_limit_end = $theneeds_slider_xml_dom->documentElement->childNodes->length;
											
											}
											
											$theneeds_counter_gal_element = 0;
											
											$theneeds_single_col = 0;
								
											for($i=$theneeds_limit_start;$i<$theneeds_limit_end;$i++) { 
												
												$theneeds_thumbnail_id = theneeds_find_xml_value($theneeds_children->item($i), 'image');
												$theneeds_title = theneeds_find_xml_value($theneeds_children->item($i), 'title');
												$theneeds_caption = theneeds_find_xml_value($theneeds_children->item($i), 'caption');
												$theneeds_link_type = theneeds_find_xml_value($theneeds_children->item($i), 'linktype');
												$theneeds_video = theneeds_find_xml_value($theneeds_children->item($i), 'video');
												
												$theneeds_image_url = wp_get_attachment_image_src($theneeds_thumbnail_id, array(585,350));
												$theneeds_alt_text = get_post_meta($theneeds_thumbnail_id , '_wp_attachment_image_alt', true);	
												
													$output .= '
													
													<div class="col-md-6 col-sm-6">
														<div class="thumb"> <img src="'.esc_url($theneeds_image_url[0]).'" alt="'.esc_html__('gallery image','theneeds').'">
														  <div class="caption">
															<div class="inner">
															  <div class="btn-row"> 
																<a href="'.esc_url($theneeds_image_url[0]).'" class="link" data-rel="prettyPhoto[gallery1]"><i class="fa fa-plus" aria-hidden="true"></i></a> 
																<a data-rel="prettyPhoto[gallery1]" href="'.esc_url($theneeds_image_url[0]).'" class="link"><i class="fa fa-link" aria-hidden="true"></i></a> 
															   </div>
															</div>
														  </div>
														</div>
													</div>';
													
			
											} /* end forloop */
										
						} /* endif */
					
						/***** Pagination ****/
						$output .= pagination_crunch($pg_style = '',$style = '', $theneeds_total_page, $range = 4);
				
												
					} /* endif */
					
						$output .= '
					</div>
				  </div>
				</section>';
			
				return $output;
			
			} /* endif style 2 */
			
			/*** Medium Layouts ***/
			if($select_style == 'medium'){
			
				global $theneeds_gallery_layouts_div_size_listing_class;
				
				global $paged,$sidebar,$post_id,$wp_query;	

				$output = '';

				if(empty($paged)){
					
					$theneeds_paged = (get_query_var('page')) ? get_query_var('page') : 1; 
				}
			
				$theneeds_gal_counter = 3;
				$theneeds_gallery_layouts_size = 'Catalogue View';
				$theneeds_gallery_layouts_size = '';
				$theneeds_num_size = $img_count;
				$theneeds_gallery_layouts_class = '';

				/* Gallery XML */
				$theneeds_slider_xml_string = get_post_meta($category_name,'post-option-gallery-xml', true);
				
				if($theneeds_slider_xml_string <> ''){
					
					$theneeds_slider_xml_dom = new DOMDocument();
						
						if( !empty( $theneeds_slider_xml_string ) ){
							
							$theneeds_slider_xml_dom->loadXML($theneeds_slider_xml_string);
							
							$output .= '
							
							<section class="gallery-section">
							  <div class="element_wrap">
								<div class="gallery">';
								
										$theneeds_children = $theneeds_slider_xml_dom->documentElement->childNodes;
							
										if ( empty($wp_query->query['paged']) ) $wp_query->query['paged'] = 1;
								
											$theneeds_total_page = '';
											
											if($theneeds_num_size > 0){
												
												$theneeds_limit_start = $theneeds_num_size * ($wp_query->query['paged']-1);
												
												$theneeds_limit_end = $theneeds_limit_start + $theneeds_num_size;
												
												if ( $theneeds_limit_end > $theneeds_slider_xml_dom->documentElement->childNodes->length ) {
	
													$theneeds_limit_end = $theneeds_slider_xml_dom->documentElement->childNodes->length;
												}
												
												if($theneeds_num_size < $theneeds_slider_xml_dom->documentElement->childNodes->length){
													
													$theneeds_total_page = ceil($theneeds_slider_xml_dom->documentElement->childNodes->length/$theneeds_num_size);
													
												}else{
													
													$theneeds_total_page = 1;
												}
											
											}else {
										
												$theneeds_limit_start = 0;
												
												$theneeds_limit_end = $theneeds_slider_xml_dom->documentElement->childNodes->length;
											
											}
											
											$theneeds_counter_gal_element = 0;
											
											$theneeds_single_col = 0;
								
											for($i=$theneeds_limit_start;$i<$theneeds_limit_end;$i++) { 
												
												$theneeds_thumbnail_id = theneeds_find_xml_value($theneeds_children->item($i), 'image');
												$theneeds_title = theneeds_find_xml_value($theneeds_children->item($i), 'title');
												$theneeds_caption = theneeds_find_xml_value($theneeds_children->item($i), 'caption');
												$theneeds_link_type = theneeds_find_xml_value($theneeds_children->item($i), 'linktype');
												$theneeds_video = theneeds_find_xml_value($theneeds_children->item($i), 'video');
												
												$theneeds_image_url = wp_get_attachment_image_src($theneeds_thumbnail_id, array(290,300));
												$theneeds_alt_text = get_post_meta($theneeds_thumbnail_id , '_wp_attachment_image_alt', true);	
												
												$output .= '
													
													<div class="col-md-3 col-sm-4">
														<div class="thumb"> <img src="'.esc_url($theneeds_image_url[0]).'" alt="'.esc_html__('gallery image','theneeds').'">
														  <div class="caption">
															<div class="inner">
															  <div class="btn-row"> 
																<a href="'.esc_url($theneeds_image_url[0]).'" class="link" data-rel="prettyPhoto[gallery1]"><i class="fa fa-plus" aria-hidden="true"></i></a> 
																<a href="'.esc_url($theneeds_image_url[0]).'" data-rel="prettyPhoto[gallery1]" class="link"><i class="fa fa-link" aria-hidden="true"></i></a> 
															  </div>
															</div>
														  </div>
														</div>
													</div>';
													
		
											} /* end forloop */
										
						} /* endif */
					
						/***** Pagination ****/
						$output .= pagination_crunch($pg_style = '',$style = '', $theneeds_total_page, $range = 4);
				
												
					} /* endif */
					
						$output .= '
					</div>
				</div>
			</section>';
			
				return $output;
			
			} /* endif style 3 */
			
			/*** Small Layout ***/
			if($select_style == 'small'){
			
				global $theneeds_gallery_layouts_div_size_listing_class;
				
				global $paged,$sidebar,$post_id,$wp_query;	

				$output = '';

				if(empty($paged)){
					
					$theneeds_paged = (get_query_var('page')) ? get_query_var('page') : 1; 
				}
			
				$theneeds_gal_counter = 3;
				$theneeds_gallery_layouts_size = 'Catalogue View';
				$theneeds_gallery_layouts_size = '';
				$theneeds_num_size = $img_count;
				$theneeds_gallery_layouts_class = '';

				/* Gallery XML */
				$theneeds_slider_xml_string = get_post_meta($category_name,'post-option-gallery-xml', true);
				
				if($theneeds_slider_xml_string <> ''){
					
					$theneeds_slider_xml_dom = new DOMDocument();
						
						if( !empty( $theneeds_slider_xml_string ) ){
							
							$theneeds_slider_xml_dom->loadXML($theneeds_slider_xml_string);
							
							$output .= '
							
							 <section class="gallery-section">
							  <div class="element_wrap">
								<div class="gallery">';
								
										$theneeds_children = $theneeds_slider_xml_dom->documentElement->childNodes;
							
										if ( empty($wp_query->query['paged']) ) $wp_query->query['paged'] = 1;
								
											$theneeds_total_page = '';
											
											if($theneeds_num_size > 0){
												
												$theneeds_limit_start = $theneeds_num_size * ($wp_query->query['paged']-1);
												
												$theneeds_limit_end = $theneeds_limit_start + $theneeds_num_size;
												
												if ( $theneeds_limit_end > $theneeds_slider_xml_dom->documentElement->childNodes->length ) {
	
													$theneeds_limit_end = $theneeds_slider_xml_dom->documentElement->childNodes->length;
												}
												
												if($theneeds_num_size < $theneeds_slider_xml_dom->documentElement->childNodes->length){
													
													$theneeds_total_page = ceil($theneeds_slider_xml_dom->documentElement->childNodes->length/$theneeds_num_size);
													
												}else{
													
													$theneeds_total_page = 1;
												}
											
											}else {
										
												$theneeds_limit_start = 0;
												
												$theneeds_limit_end = $theneeds_slider_xml_dom->documentElement->childNodes->length;
											
											}
											
											$theneeds_counter_gal_element = 0;
											
											$theneeds_single_col = 0;
								
											for($i=$theneeds_limit_start;$i<$theneeds_limit_end;$i++) { 
												
												$theneeds_thumbnail_id = theneeds_find_xml_value($theneeds_children->item($i), 'image');
												$theneeds_title = theneeds_find_xml_value($theneeds_children->item($i), 'title');
												$theneeds_caption = theneeds_find_xml_value($theneeds_children->item($i), 'caption');
												$theneeds_link_type = theneeds_find_xml_value($theneeds_children->item($i), 'linktype');
												$theneeds_video = theneeds_find_xml_value($theneeds_children->item($i), 'video');
												
												$theneeds_image_url = wp_get_attachment_image_src($theneeds_thumbnail_id, 'full');
												$theneeds_alt_text = get_post_meta($theneeds_thumbnail_id , '_wp_attachment_image_alt', true);	
												
												
													
													$output .= '
													
													<div class="col-md-3 col-sm-4">
														<div class="frame"> <img src="'.esc_url($theneeds_image_url[0]).'" alt="'.esc_html__('gallery image','theneeds').'">
														  <div class="caption">
															<div class="holder"> 
															<a href="'.esc_url($theneeds_image_url[0]).'" class="link" data-rel="prettyPhoto[gallery1]"><i class="fa fa-plus" aria-hidden="true"></i></a> 
															<a href="'.esc_url($theneeds_image_url[0]).'" class="link"><i class="fa fa-link" aria-hidden="true"></i></a>
															  <h3><a>'.esc_attr($theneeds_caption).'</a></h3>
															</div>
														  </div>
														</div>
													</div>';
		
											} /* end forloop */
										
						} /* endif */
					
						/***** Pagination ****/
						$output .= pagination_crunch($pg_style = '',$style = '', $theneeds_total_page, $range = 4);
				
												
					} /* endif */
					
						$output .= '
					</div>
				  </div>
			 </section>';
			
				return $output;
			
			} /* endif style 4 */
			
			/*** 4 Column Layout ***/
			if($select_style == '4_col'){
			
				global $theneeds_gallery_layouts_div_size_listing_class;
				
				global $paged,$sidebar,$post_id,$wp_query;	

				$output = '';

				if(empty($paged)){
					
					$theneeds_paged = (get_query_var('page')) ? get_query_var('page') : 1; 
				}
			
				$theneeds_gal_counter = 3;
				$theneeds_gallery_layouts_size = 'Catalogue View';
				$theneeds_gallery_layouts_size = '';
				$theneeds_num_size = $img_count;
				$theneeds_gallery_layouts_class = '';

				/* Gallery XML */
				$theneeds_slider_xml_string = get_post_meta($category_name,'post-option-gallery-xml', true);
				
				if($theneeds_slider_xml_string <> ''){
					
					$theneeds_slider_xml_dom = new DOMDocument();
						
						if( !empty( $theneeds_slider_xml_string ) ){
							
							$theneeds_slider_xml_dom->loadXML($theneeds_slider_xml_string);
							
							$output .= '
							
							 <section class="portfolio-style-1 padd-none gallery-large gallery-4-col">
								
								<div class="container">
									
									<div class="gallery padd-btm-90">
										
										<div class="row">';
								
										$theneeds_children = $theneeds_slider_xml_dom->documentElement->childNodes;
							
										if ( empty($wp_query->query['paged']) ) $wp_query->query['paged'] = 1;
								
											$theneeds_total_page = '';
											
											if($theneeds_num_size > 0){
												
												$theneeds_limit_start = $theneeds_num_size * ($wp_query->query['paged']-1);
												
												$theneeds_limit_end = $theneeds_limit_start + $theneeds_num_size;
												
												if ( $theneeds_limit_end > $theneeds_slider_xml_dom->documentElement->childNodes->length ) {
	
													$theneeds_limit_end = $theneeds_slider_xml_dom->documentElement->childNodes->length;
												}
												
												if($theneeds_num_size < $theneeds_slider_xml_dom->documentElement->childNodes->length){
													
													$theneeds_total_page = ceil($theneeds_slider_xml_dom->documentElement->childNodes->length/$theneeds_num_size);
													
												}else{
													
													$theneeds_total_page = 1;
												}
											
											}else {
										
												$theneeds_limit_start = 0;
												
												$theneeds_limit_end = $theneeds_slider_xml_dom->documentElement->childNodes->length;
											
											}
											
											$theneeds_counter_gal_element = 0;
											
											$theneeds_single_col = 0;
								
											for($i=$theneeds_limit_start;$i<$theneeds_limit_end;$i++) { 
												
												$theneeds_thumbnail_id = theneeds_find_xml_value($theneeds_children->item($i), 'image');
												$theneeds_title = theneeds_find_xml_value($theneeds_children->item($i), 'title');
												$theneeds_caption = theneeds_find_xml_value($theneeds_children->item($i), 'caption');
												$theneeds_link_type = theneeds_find_xml_value($theneeds_children->item($i), 'linktype');
												$theneeds_video = theneeds_find_xml_value($theneeds_children->item($i), 'video');
												
												$theneeds_image_url = wp_get_attachment_image_src($theneeds_thumbnail_id, 'full');
												$theneeds_alt_text = get_post_meta($theneeds_thumbnail_id , '_wp_attachment_image_alt', true);	
												
												
													
													$output .= '
													
													<div class="col-md-3 col-sm-6">
													  <div class="outer">
														<div class="thumb"> <img src="'.esc_url($theneeds_image_url[0]).'" alt="img">
														  <div class="caption">
															<div class="inner">
															  <div class="btn-row"> 
																<a href="'.esc_url($theneeds_image_url[0]).'" class="link" data-rel="prettyPhoto[gallery1]"><i class="fa fa-plus" aria-hidden="true"></i></a> 
																<a href="'.esc_url($theneeds_image_url[0]).'" class="link"><i class="fa fa-link" aria-hidden="true"></i></a> 
															</div>
															  <h3><a href="'.esc_url($theneeds_image_url[0]).'">'.esc_attr($theneeds_title).'</a></h3>
															  <span>'.esc_attr($theneeds_caption).'</span> </div>
														  </div>
														</div>
													  </div>
													</div>';
					
											} /* end forloop */
										
						} /* endif */
					
						/***** Pagination ****/
						$output .= pagination_crunch($pg_style = '',$style = '', $theneeds_total_page, $range = 4);
				
												
					} /* endif */
					
						$output .= '
					</div>
				  </div>
				</div>
			 </section>';
			
			return $output;
			
			} /* endif style 4 */
			
			
			/*** 4 Column Layout ***/
			if($select_style == 'classic'){
			
				wp_enqueue_script( 'cp-isotope', theneeds_PATH_URL.'/frontend/js/isotope.pkgd.min.js', false, '1.0', true);
			
				global $theneeds_gallery_layouts_div_size_listing_class;
				
				global $paged,$sidebar,$post_id,$wp_query;	

				$output = '';

				if(empty($paged)){
					
					$theneeds_paged = (get_query_var('page')) ? get_query_var('page') : 1; 
				}
			
				$theneeds_gal_counter = 3;
				$theneeds_gallery_layouts_size = 'Catalogue View';
				$theneeds_gallery_layouts_size = '';
				$theneeds_num_size = $img_count;
				$theneeds_gallery_layouts_class = '';

				/* Gallery XML */
				$theneeds_slider_xml_string = get_post_meta($category_name,'post-option-gallery-xml', true);
				
				if($theneeds_slider_xml_string <> ''){
					
					$theneeds_slider_xml_dom = new DOMDocument();
						
						if( !empty( $theneeds_slider_xml_string ) ){
							
							$theneeds_slider_xml_dom->loadXML($theneeds_slider_xml_string);
							
							$output .= '
							
							<section class="cp-gallery gallery-section gallery">
							  <div class="element_wrap">
								<div class="row">
								  <div class="cp-gallery-metro-2 gallery-grid gallery">
									<ul class="cp-grid isotope items">';
								
										$theneeds_children = $theneeds_slider_xml_dom->documentElement->childNodes;
							
										if ( empty($wp_query->query['paged']) ) $wp_query->query['paged'] = 1;
								
											$theneeds_total_page = '';
											
											if($theneeds_num_size > 0){
												
												$theneeds_limit_start = $theneeds_num_size * ($wp_query->query['paged']-1);
												
												$theneeds_limit_end = $theneeds_limit_start + $theneeds_num_size;
												
												if ( $theneeds_limit_end > $theneeds_slider_xml_dom->documentElement->childNodes->length ) {
	
													$theneeds_limit_end = $theneeds_slider_xml_dom->documentElement->childNodes->length;
												}
												
												if($theneeds_num_size < $theneeds_slider_xml_dom->documentElement->childNodes->length){
													
													$theneeds_total_page = ceil($theneeds_slider_xml_dom->documentElement->childNodes->length/$theneeds_num_size);
													
												}else{
													
													$theneeds_total_page = 1;
												}
											
											}else {
										
												$theneeds_limit_start = 0;
												
												$theneeds_limit_end = $theneeds_slider_xml_dom->documentElement->childNodes->length;
											
											}
											
											$theneeds_counter_gal_element = 0;
											
											$theneeds_single_col = 0;
								
											for($i=$theneeds_limit_start;$i<$theneeds_limit_end;$i++) { 
												
												$theneeds_thumbnail_id = theneeds_find_xml_value($theneeds_children->item($i), 'image');
												$theneeds_title = theneeds_find_xml_value($theneeds_children->item($i), 'title');
												$theneeds_caption = theneeds_find_xml_value($theneeds_children->item($i), 'caption');
												$theneeds_link_type = theneeds_find_xml_value($theneeds_children->item($i), 'linktype');
												$theneeds_video = theneeds_find_xml_value($theneeds_children->item($i), 'video');
												
												$theneeds_image_url = wp_get_attachment_image_src($theneeds_thumbnail_id, 'full');
												$theneeds_alt_text = get_post_meta($theneeds_thumbnail_id , '_wp_attachment_image_alt', true);	
												
													static $image_counter_classic = 1;
													
													if($image_counter_classic % 6 == 1){
													
														$li_class = "width2 height2 col-md-8";
													
													}else{
													
														$li_class = "col-md-4";
													}
													
													$output .= '
													
													<li class="item '.$li_class.'">
														<div class="cp-box">
														  <div class="frame"> <img src="'.esc_url($theneeds_image_url[0]).'" alt="'.esc_html__('img','theneeds').'">
															<div class="caption">
															  <div class="holder"> 
																<a href="'.esc_url($theneeds_image_url[0]).'" class="link" data-rel="prettyPhoto[gallery1]"><i class="fa fa-plus" aria-hidden="true"></i></a> 
																<a data-rel="prettyPhoto[gallery1]" href="'.esc_url($theneeds_image_url[0]).'" class="link"><i class="fa fa-link" aria-hidden="true"></i></a>
																<h3><a data-rel="prettyPhoto[gallery1]" href="'.esc_url($theneeds_image_url[0]).'">'.esc_attr($theneeds_caption).'</a></h3>
															  </div>
															</div>
														  </div>
														</div>
													</li>';
													
													$image_counter_classic++;
													
													
				
											} /* end forloop */
										
						} /* endif */
					
												
					} /* endif */
					
						$output .= '
					</ul>
				  </div>
				</div>';
						/***** Pagination ****/
						$output .= pagination_crunch($pg_style = '',$style = '', $theneeds_total_page, $range = 4).'
				</div>
			 </section>';
			
			return $output;
			
			} /* endif style 4 */
			
			/*** 4 Column Layout ***/
			if($select_style == 'elite'){
			
				wp_enqueue_script( 'cp-isotope-main', theneeds_PATH_URL.'/frontend/js/jquery.isotope.js', false, '1.0', true);
			
				wp_enqueue_script( 'cp-isotope', theneeds_PATH_URL.'/frontend/js/isotope.pkgd.min.js', false, '1.0', true);
			
				global $theneeds_gallery_layouts_div_size_listing_class;
				
				global $paged,$sidebar,$post_id,$wp_query;	

				$output = '';

				if(empty($paged)){
					
					$theneeds_paged = (get_query_var('page')) ? get_query_var('page') : 1; 
				}
			
				$theneeds_gal_counter = 3;
				$theneeds_gallery_layouts_size = 'Catalogue View';
				$theneeds_gallery_layouts_size = '';
				$theneeds_num_size = $img_count;
				$theneeds_gallery_layouts_class = '';

				/* Gallery XML */
				$theneeds_slider_xml_string = get_post_meta($category_name,'post-option-gallery-xml', true);
				
				if($theneeds_slider_xml_string <> ''){
					
					$theneeds_slider_xml_dom = new DOMDocument();
						
						if( !empty( $theneeds_slider_xml_string ) ){
							
							$theneeds_slider_xml_dom->loadXML($theneeds_slider_xml_string);
							
							$output .= '
							
							<section class="cp-gallery gallery-section gallery">
							  <div class="container-fluid">
								<div class="cp-gallery-metro-1 gallery-grid gallery">
								  <ul class="cp-grid isotope items">';
								
										$theneeds_children = $theneeds_slider_xml_dom->documentElement->childNodes;
							
										if ( empty($wp_query->query['paged']) ) $wp_query->query['paged'] = 1;
								
											$theneeds_total_page = '';
											
											if($theneeds_num_size > 0){
												
												$theneeds_limit_start = $theneeds_num_size * ($wp_query->query['paged']-1);
												
												$theneeds_limit_end = $theneeds_limit_start + $theneeds_num_size;
												
												if ( $theneeds_limit_end > $theneeds_slider_xml_dom->documentElement->childNodes->length ) {
	
													$theneeds_limit_end = $theneeds_slider_xml_dom->documentElement->childNodes->length;
												}
												
												if($theneeds_num_size < $theneeds_slider_xml_dom->documentElement->childNodes->length){
													
													$theneeds_total_page = ceil($theneeds_slider_xml_dom->documentElement->childNodes->length/$theneeds_num_size);
													
												}else{
													
													$theneeds_total_page = 1;
												}
											
											}else {
										
												$theneeds_limit_start = 0;
												
												$theneeds_limit_end = $theneeds_slider_xml_dom->documentElement->childNodes->length;
											
											}
											
											$theneeds_counter_gal_element = 0;
											
											$theneeds_single_col = 0;
								
											for($i=$theneeds_limit_start;$i<$theneeds_limit_end;$i++) { 
												
												$theneeds_thumbnail_id = theneeds_find_xml_value($theneeds_children->item($i), 'image');
												$theneeds_title = theneeds_find_xml_value($theneeds_children->item($i), 'title');
												$theneeds_caption = theneeds_find_xml_value($theneeds_children->item($i), 'caption');
												$theneeds_link_type = theneeds_find_xml_value($theneeds_children->item($i), 'linktype');
												$theneeds_video = theneeds_find_xml_value($theneeds_children->item($i), 'video');
												
												$theneeds_image_url = wp_get_attachment_image_src($theneeds_thumbnail_id, 'full');
												$theneeds_alt_text = get_post_meta($theneeds_thumbnail_id , '_wp_attachment_image_alt', true);	
												
													static $image_counter_classic = 1;
													
													if($image_counter_classic == 3  || $image_counter_classic == 7 || $image_counter_classic == 9 || $image_counter_classic == 12){
													
														$li_class = "width2";
													
													}elseif($image_counter_classic == 2 || $image_counter_classic == 10){
													
														$li_class = "height2";
													
													}else{
													
														$li_class  = "";
													}
													
													$output .= '
													
													<li class="item '.$li_class.'">
													  <div class="cp-box">
														<div class="frame"> <img src="'.esc_url($theneeds_image_url[0]).'" alt="'.esc_html__('img','theneeds').'">
														  <div class="caption">
															<div class="holder">
															<a href="'.esc_url($theneeds_image_url[0]).'" class="link" data-rel="prettyPhoto[gallery1]"><i class="fa fa-plus" aria-hidden="true"></i></a> 
															<a data-rel="prettyPhoto[gallery1]" href="'.esc_url($theneeds_image_url[0]).'" class="link"><i class="fa fa-link" aria-hidden="true"></i></a>
															  <h3><a data-rel="prettyPhoto[gallery1]" href="'.esc_url($theneeds_image_url[0]).'">'.esc_attr($theneeds_caption).'</a></h3>
															</div>
														  </div>
														</div>
													  </div>
													</li>';
													
												
													
													$image_counter_classic++;
													
													
				
											} /* end forloop */
										
						} /* endif */
					
												
					} /* endif */
					
						$output .= '
					</ul>
				  </div>
				</div>';
						/***** Pagination ****/
						$output .= pagination_crunch($pg_style = '',$style = '', $theneeds_total_page, $range = 4).'
			 </section>';
			
			return $output;
			
			} /* endif style 4 */
			
			
		}
		
	}
	new theneeds_gallery_layouts;
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_gallery_layouts extends WPBakeryShortCode {
		}
	}
}