<?php
/* Condition for Parent Class */
if(class_exists('theneeds_function_library')){
	
	add_action( 'plugins_loaded', 'slider_fun_override' );
	function slider_fun_override() {
		$slider_class = new theneeds_slider_class;
	}

	class theneeds_slider_class extends theneeds_function_library{
		
		public $slider_array =	array(

			/* Yet To Be Implemented */
		
		);
		
		
		
		public $slider_size_array = array( );
			
		public function page_builder_size_class(){
			
			global $div_size;
			
			$div_size['Slider'] = $this->slider_size_array;	  
		}
		
		public function page_builder_element_class(){
			
			global $page_meta_boxes;
				

			$page_meta_boxes['Page Item']['name']['Slider'] = $this->slider_array;
			$page_meta_boxes['Page Item']['name']['Slider']['slider-slide']['options'] = theneeds_function_library::theneeds_get_title_list_array('theneeds_slider');
			$page_meta_boxes['Top Slider Images']['options'] = theneeds_function_library::theneeds_get_title_list_array('theneeds_slider');
			
			if(class_exists('LS_Sliders')){
				$page_meta_boxes['Page Item']['name']['Slider']['slider-slide-layer']['options'] = theneeds_function_library::theneeds_layer_slider_id();
				$page_meta_boxes['Top Slider Layer']['options'] = theneeds_function_library::theneeds_layer_slider_id();
			}
				
		}
		
		/* Class Constructor */
		public function __construct(){
			
			add_action( 'init', array( $this, 'theneeds_create_slider' ) );
			add_action( 'add_meta_boxes', array( $this, 'theneeds_add_slider_option' ) );
			add_action( 'save_post', array( $this, 'save_slider_option_meta' ) );
		}

		public function theneeds_create_slider() {
		
			$labels = array(
				'name' => _x('Slider', 'Slider General Name', 'theneeds'),
				'singular_name' => _x('Slider Item', 'Slider Singular Name', 'theneeds'),
				'add_new' => _x('Add New', 'Add New Slider Name', 'theneeds'),
				'add_new_item' => __('Add New Slider', 'theneeds'),
				'edit_item' => __('Edit Slider', 'theneeds'),
				'new_item' => __('New Slider', 'theneeds'),
				'view_item' => '',
				'search_items' => __('Search Slider', 'theneeds'),
				'not_found' =>  __('Nothing found', 'theneeds'),
				'not_found_in_trash' => __('Nothing found in Trash', 'theneeds'),
				'parent_item_colon' => ''
			);
			
			$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'menu_icon' => '',
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				"show_in_nav_menus" => false,
				'supports' => array('title','thumbnail','custom-fields'),
				'rewrite' => array('slug' => 'cpslider', 'with_front' => false)
			); 
			  
			register_post_type( 'theneeds_slider' , $args);
			
		}
		
		public $slider_meta_box = array(	
			"Slider Picker" => array(
				'type'=>'sliderpicker',
				'title'=> 'SELECT IMAGES',
				'xml'=>'cp-slider-xml',
				'name'=>array(
					'image'=>'slider-option-inside-thumbnail-slider-image',
					'title'=>'slider-option-inside-thumbnail-slider-title',
					'caption'=>'slider-option-cp-slider-caption',
					'subtitle'=>'slider-option-cp-slider-subtitle',
					'link'=>'slider-option-inside-thumbnail-slider-link',
					'contact_url'=>'slider-option-inside-thumbnail-slider-contact_url',
					'linktype'=>'slider-option-inside-thumbnail-slider-linktype',
					//'slide_style'=>'slider-option-inside-thumbnail-slider-slide-style',
					
					),
				'hr'=>'none'
			)	
		);
		
		
		public function theneeds_add_slider_option(){
		
			add_meta_box('theneeds_slider_option', __('Slider Images','theneeds'), array( $this, 'theneeds_add_slider_option_element' ),
				'theneeds_slider', 'normal', 'high');
				
		}
		
		public function theneeds_add_slider_option_element(){
			$slider_meta_box = $this->slider_meta_box;
			
			global $post;
			echo '<div id="cp-overlay-wrapper">';
			
			?> <div class="gallery-option-meta" id="gallery-option-meta"> <?php
			
				
				
				foreach($slider_meta_box as $meta_box){
				

					if( $meta_box['type'] == 'sliderpicker' ){
					
						$xml_string = get_post_meta($post->ID, $meta_box['xml'], true);
						if( !empty($xml_string) ){

							$xml_val = new DOMDocument();
							$xml_val->loadXML( $xml_string );
							$meta_box['value'] = $xml_val->documentElement;
							
						}
						self::theneeds_print_slider_picker($meta_box);
						
					}else{
					
						$meta_box['value'] = get_post_meta($post->ID, $meta_box['name'], true);
						print_meta($meta_box);
					
					}				
					
				}
				
			?> </div> <?php
			
			echo '</div>';
			
		}
		
		public function save_slider_option_meta($post_id){
			
			$slider_meta_box = $this->slider_meta_box;
			//global $slider_meta_box;
			$edit_meta_boxes = $slider_meta_box;
			
			// save
			foreach ($edit_meta_boxes as $edit_meta_box){
			
				// save function for slider
				if( $edit_meta_box['type'] == 'sliderpicker' ){
				
					if(isset($_POST[$edit_meta_box['name']['image']])){
					
						$num = sizeof($_POST[$edit_meta_box['name']['image']]) - 1;
						
					}else{
					
						$num = -1;
						
					}
					
					$slider_xml_old = get_post_meta($post_id,$edit_meta_box['xml'],true);
					if(isset($_POST[$edit_meta_box['name']['image']])){
						$slider_xml = "<slider-item>";
						
						for($i=0; $i<=$num; $i++){
						
							$slider_xml = $slider_xml. "<slider>";
							
							$image_new = stripslashes($_POST[$edit_meta_box['name']['image']][$i]);
							$slider_xml = $slider_xml. theneeds_function_library::theneeds_create_xml_tag('image',$image_new);
							
							$linktype_new = stripslashes($_POST[$edit_meta_box['name']['linktype']][$i]);
							$slider_xml = $slider_xml. theneeds_function_library::theneeds_create_xml_tag('linktype',$linktype_new);
							
							/*$slide_style_new = stripslashes($_POST[$edit_meta_box['name']['slide_style']][$i]);
							$slider_xml = $slider_xml. theneeds_function_library::theneeds_create_xml_tag('slide_style',$slide_style_new);*/
							
							$link_new = stripslashes(htmlspecialchars($_POST[$edit_meta_box['name']['link']][$i]));
							$slider_xml = $slider_xml. theneeds_function_library::theneeds_create_xml_tag('link',$link_new);
							
							$contact_new = stripslashes($_POST[$edit_meta_box['name']['contact_url']][$i]);
							$slider_xml = $slider_xml. theneeds_function_library::theneeds_create_xml_tag('contact_url',$contact_new);
							
							
							$title_new = stripslashes(htmlspecialchars($_POST[$edit_meta_box['name']['title']][$i]));
							$slider_xml = $slider_xml. theneeds_function_library::theneeds_create_xml_tag('title',$title_new);
							
							$caption_new = stripslashes(htmlspecialchars($_POST[$edit_meta_box['name']['caption']][$i]));
							$slider_xml = $slider_xml. theneeds_function_library::theneeds_create_xml_tag('caption',$caption_new);
							
							$subtitle_new = stripslashes(htmlspecialchars($_POST[$edit_meta_box['name']['subtitle']][$i]));
							$slider_xml = $slider_xml. theneeds_function_library::theneeds_create_xml_tag('subtitle',$subtitle_new);
							
							$slider_xml = $slider_xml . "</slider>";
							
						}
						
						$slider_xml = $slider_xml . "</slider-item>";
						theneeds_save_meta_data($post_id, $slider_xml, $slider_xml_old, $edit_meta_box['xml']);
					}
					
					
				}else{
				
					if(isset($_POST[$edit_meta_box['name']])){
					
						$new_data = stripslashes($_POST[$edit_meta_box['name']]);
						
					}else{
					
						$new_data = '';
						
					}
					
					$old_data = get_post_meta($post_id, $edit_meta_box['name'],true);
					save_meta_data($post_id, $new_data, $old_data, $edit_meta_box['name']);
					
				}
				
			}
			
		}

		
		public function theneeds_print_slider_picker($args){
		
			extract($args);
			
			global $post;
		?>
			
					<div class="meta-body image-picker-wrapper">
					<div class="meta-input-slider">
						<div class="image-picker" id="image-picker">
							<input type='hidden' class="slider-num" id="slider-num" name='<?php 
							
								echo (isset($name['slider-num']))? $name['slider-num'] . '[]' : '' ; 
							
							?>' value=<?php 
								
								echo empty($value)? 0: $value->childNodes->length;
								
							?> />
							<div class="selected-image" id="selected-image">
								<div id="selected-image-none"><?php esc_html_e('No Image Inserted', 'theneeds'); ?></div>
								<ul>
									<li id="default" class="default">
										<div class="selected-image-wrapper">
											<img src="#"/>
											<div class="selected-image-element">
												<div id="edit-image" class="edit-image"></div>
												<div id="unpick-image" class="unpick-image"></div>
												<br class="clear">
											</div>
										</div>
										<input type="hidden" class='slider-image-url' id='<?php echo $name['image']; ?>' />
										
										<div id="slider-detail-wrapper" class="slider-detail-wrapper">									
										<div id="slider-detail" class="slider-detail">
										<hr class="separator">
											<!--<div class="meta-title meta-detail-title"><?php esc_html_e('Slide Style', 'theneeds'); ?></div> 
											<div class="meta-input meta-detail-input">
												<div class="combobox">
													<select id='<?php echo $name['slide_style']; ?>'>
														<option><?php esc_html_e('Style 1', 'theneeds'); ?></option>
														<option><?php esc_html_e('Style 2', 'theneeds'); ?></option>
														<option><?php esc_html_e('Style 3', 'theneeds'); ?></option>															
													</select>
												</div>
											</div>
											<hr class="separator">-->
											<div class="meta-title meta-detail-title">
												<?php esc_html_e('SLIDER TITLE', 'theneeds'); ?>
											</div> 
											<div class="meta-detail-input meta-input">
												<input type="text" id='<?php echo $name['title']; ?>' />
											</div>
											<br class="clear">
											<hr class="separator">
											<div class="meta-title meta-detail-title">
												<?php esc_html_e('SLIDER CAPTION', 'theneeds'); ?>
											</div>
											<div class="meta-detail-input meta-input">
												<textarea id='<?php echo $name['caption']; ?>' ></textarea>
											</div>
											<br class="clear">
											<hr class="separator">
											<div class="meta-title meta-detail-title">
												<?php esc_html_e('SLIDER SUBTITLE', 'theneeds'); ?>
											</div>
											<div class="meta-detail-input meta-input">
												<input type="text" id='<?php echo $name['subtitle']; ?>' />
											</div>
											<br class="clear">
											<hr class="separator">
											<div class="meta-title meta-detail-title"><?php esc_html_e('LINK TYPE', 'theneeds'); ?></div> 
											<div class="meta-input meta-detail-input">
												<div class="combobox">
													<select id='<?php echo $name['linktype']; ?>'>
														<option><?php esc_html_e('No Link', 'theneeds'); ?></option>
														<option><?php esc_html_e('Link to URL', 'theneeds'); ?></option>	
													</select>
												</div>
											</div><br class="clear">
											<div class="url">
												<div class="meta-title meta-detail-title" rel="url"><?php esc_html_e('Learn More', 'theneeds'); ?></div> 
												<div class="meta-detail-input meta-input"><input class="mt10" type="text"  id='<?php echo $name['link']; ?>' /></div>
											</div>
											<hr class="separator">
											<br class="clear">
											<div class="meta-detail-input meta-input"><input type="text" id='<?php echo $name['contact_url']; ?>' /></div><br class="clear">
											<hr class="separator">
											
											
											<br class="clear">
											<div class="meta-detail-done-wrapper">
												<input type="button" id="cp-detail-edit-done" class="cp-button" value="Done" /><br class="clear">
											</div>
												<input type="hidden" id="cp-detail-edit-done" class="cp-button" name="submit_button" value="submit_button" /><br class="clear">
										</div>
										</div>
									</li>
									
									<?php 
									
										if(!empty($value)){
											
											foreach ($value->childNodes as $slider){ ?> 
											
												<li class="slider-image-init">
													<div class="selected-image-wrapper">
														<img src="<?php 
														
															$thumb_src_preview = wp_get_attachment_image_src( theneeds_function_library::theneeds_find_xml_value($slider, 'image'), '160x110');
															echo $thumb_src_preview[0]; 
															
														?>"/>
														<div class="selected-image-element">
															<div id="edit-image" class="edit-image"></div>
															<div id="unpick-image" class="unpick-image"></div>
															<br class="clear">
														</div>
													</div>
													<input type="hidden" class='slider-image-url' name='<?php echo esc_attr($name['image']); ?>[]' id='<?php echo $name['image']; ?>[]' value="<?php echo theneeds_find_xml_value($slider, 'image'); ?>" /> 
													<div id="slider-detail-wrapper" class="slider-detail-wrapper">
													<div id="slider-detail" class="slider-detail">
														<!--<div class="meta-title meta-detail-title"><?php esc_html_e('Slide Style', 'theneeds'); ?></div> 
														<div class="meta-input meta-detail-input">
															<div class="combobox">
																<?php $slide_style_value =  theneeds_function_library::theneeds_find_xml_value($slider, 'slide_style'); ?>
																<select name='<?php echo $name['slide_style']; ?>[]' id='<?php echo $name['slide_style']; ?>' >
																	<option <?php echo ($slide_style_value == 'Style 1')? "selected" : ''; ?> ><?php esc_html_e('Style 1', 'theneeds'); ?></option>
																	<option <?php echo ($slide_style_value == 'Style 2')? "selected" : ''; ?>><?php esc_html_e('Style 2', 'theneeds'); ?></option>
																	<option <?php echo ($slide_style_value == 'Style 3')? "selected" : ''; ?>><?php esc_html_e('Style 3', 'theneeds'); ?></option>
																</select>
															</div>
														</div>-->
														<br class="clear">
														<div class="meta-title meta-detail-title"><?php esc_html_e('SLIDER TITLE', 'theneeds'); ?></div> 
														<div class="meta-detail-input meta-input"><input type="text" name='<?php echo esc_attr($name['title']); ?>[]' id='<?php echo $name['title']; ?>[]' value="<?php echo theneeds_find_xml_value($slider, 'title'); ?>" /></div><br class="clear">
														<hr class="separator">
														<div class="meta-title meta-detail-title"><?php esc_html_e('SLIDER CAPTION', 'theneeds'); ?></div>
														<div class="meta-detail-input meta-input"><textarea name='<?php echo esc_textarea ($name['caption']); ?>[]' id='<?php echo $name['caption']; ?>[]' ><?php echo theneeds_find_xml_value($slider, 'caption'); ?></textarea></div><br class="clear">
														<hr class="separator">
														<div class="meta-title meta-detail-title"><?php esc_html_e('SLIDER SUBTITLE', 'theneeds'); ?></div> 
														<div class="meta-detail-input meta-input"><input type="text" name='<?php echo esc_attr($name['subtitle']); ?>[]' id='<?php echo $name['subtitle']; ?>[]' value="<?php echo theneeds_find_xml_value($slider, 'subtitle'); ?>" /></div><br class="clear">														
														<div class="meta-title meta-detail-title"><?php esc_html_e('LINK TYPE', 'theneeds'); ?></div>
														<div class="meta-input meta-detail-input">
															<div class="combobox">
																<?php $linktype_val =  theneeds_function_library::theneeds_find_xml_value($slider, 'linktype'); ?>
																<select name='<?php echo $name['linktype']; ?>[]' id='<?php echo $name['linktype']; ?>' >
																	<option <?php echo ($linktype_val == 'No Link')? "selected" : ''; ?> ><?php esc_html_e('No Link', 'theneeds'); ?></option>
																	<option <?php echo ($linktype_val == 'Link to URL')? "selected" : ''; ?>><?php esc_html_e('Link to URL', 'theneeds'); ?></option>
																</select>
															</div>
														</div><br class="clear">
														<div class="url">
															<div class="meta-title meta-detail-title" rel="url"><?php esc_html_e('Learn More', 'theneeds'); ?></div> 
															<div class="meta-detail-input meta-input"><input class="mt10" type="text" name='<?php echo esc_attr($name['link']); ?>[]' id='<?php echo $name['link']; ?>[]' value="<?php echo esc_url(theneeds_find_xml_value($slider, 'link')); ?>" /></div>
														</div>
														<div class="clear"></div>
														
														<div class="meta-title meta-detail-title"><?php esc_html_e('Donate Funds', 'theneeds'); ?></div> 
														<div class="meta-detail-input meta-input"><input type="text" name='<?php echo esc_attr($name['contact_url']); ?>[]' id='<?php echo $name['contact_url']; ?>[]' value="<?php echo theneeds_find_xml_value($slider, 'contact_url'); ?>" /></div><br class="clear">
														
														<input type="hidden" value="slider_images" name="slider_images">
														<br class="clear">
														<div class="meta-detail-done-wrapper">
															<input type="button" id="cp-detail-edit-done" class="cp-button" value="Done" /><br class="clear">
														</div>
													</div>
													</div>
													</li> 
													
												<?php
												
											}
											
										}
										
									?>	
									
								</ul>
								<br class="clear">
								<div id="show-media" class="show-media">							
									<span id="show-media-text"></span>
									
									<div id="show-media-image"></div>
								</div>
							</div>
							<div class="media-image-gallery-wrapper">
							<input class="upload_image_button white_color" type="button" value="Upload" />
								<div class="media-image-gallery" id="media-image-gallery">
									<?php theneeds_function_library::theneeds_get_media_image(); ?>
								</div>
							</div>
						</div>
					</div>
					<br class="clear">
				</div>
				
			<?php
			
		}	

	}
}	