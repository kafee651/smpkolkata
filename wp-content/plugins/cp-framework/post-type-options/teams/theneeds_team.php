<?php 
/* Condition for Parent Class */
if(class_exists('theneeds_function_library')){
	
	add_action( 'plugins_loaded', 'team_fun_override' );
	
	function team_fun_override() {
		$team_class = new theneeds_team;
	}

	class theneeds_team extends theneeds_function_library{
		
		public $team_array = array(
		
			/* Yet To Be Implemented */
			
		);
		
		public $speakers_array = array(
		
			/* Yet To Be Implemented */		
			
		);
		

		
		public function page_builder_size_class(){
		
		
		}
		
		public function page_builder_element_class(){
		
			global $page_meta_boxes;
				
				/* Yet To Be Implemented */
		}
		
		public function theneeds_team_init(){
			
			/* Yet To Be Implemented */
			
		}
		
		/* Constructor */
		public function __construct(){
			
			add_action( 'init', array( $this, 'theneeds_create_ourteam' ) );
			add_action( 'add_meta_boxes', array( $this, 'theneeds_add_team_option' ) );
			add_action( 'save_post', array( $this, 'save_team_option_meta' ) );
		}
		
		public function theneeds_create_ourteam() {
			
			$labels = array(
				'name' => _x('Our Team', 'Our Team General Name', 'eventco'),
				'singular_name' => _x('Our Team', 'Event Singular Name', 'eventco'),
				'add_new' => _x('Add New', 'Add New Our Team Name', 'eventco'),
				'add_new_item' => __('Add New Our Team', 'eventco'),
				'edit_item' => __('Edit Our Team', 'eventco'),
				'new_item' => __('New Our Team', 'eventco'),
				'view_item' => __('View Our Team', 'eventco'),
				'search_items' => __('Search Our Team', 'eventco'),
				'not_found' =>  __('Nothing found', 'eventco'),
				'not_found_in_trash' => __('Nothing found in Trash', 'eventco'),
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
				'supports' => array('title','editor','author','thumbnail','excerpt','comments'),
				'has_archive' => true,
				'rewrite' => array('slug' => '', 'with_front' => false)
			  ); 
			  
			register_post_type( 'team' , $args);	

			register_taxonomy(
				"team-category", array("team"), array(
					"hierarchical" => true,
					"label" => "Team Categories", 
					"singular_label" => "Team Categories", 
					"rewrite" => true));
			register_taxonomy_for_object_type('team-category', 'team');			
		}
		
		
		
		public function theneeds_add_team_option(){	
		
			add_meta_box('team-option', __('Our Team Options','eventco'), array($this,'theneeds_add_our_team_element'),
				'team', 'normal', 'high');
				
		}
		

		public function theneeds_add_our_team_element(){
			$team_social = '';
			
			$team_designation = '';
			$team_facebook = '';
			$team_linkedin = '';
			
			$team_twitter = '';
			$google_plus = '';
			$theneeds_instagram = '';
			$theneeds_pinterest = '';
			$theneeds_youtube = '';
			
			$why_choose_me = '';
			$link_text = '';
			$link_to_url = '';
			
			
		foreach($_REQUEST as $keys=>$values){
			$$keys = $values;
		}
		global $post;
		
		/* Portfolio Gallery Section */
		$gallery_name_event= get_post_meta($post->ID, 'gallery_name_event', true);
		
		/* Portfolio Gallery Section */
		$recent_work_gallery= get_post_meta($post->ID, 'recent_work_gallery', true);
		
			
		/* Professional Experience Section */
		$theneeds_field_title = get_post_meta($post->ID, 'cp_field_title', true);
		$theneeds_field_percent = get_post_meta($post->ID, 'cp_field_percent', true);
		
		$team_detail_xml = get_post_meta($post->ID, 'team_detail_xml', true);
		
		if($team_detail_xml <> ''){
			
			$theneeds_team_xml = new DOMDocument ();
			
			$theneeds_team_xml->loadXML ( $team_detail_xml );
			
			$team_social = theneeds_function_library::theneeds_find_xml_value($theneeds_team_xml->documentElement,'team_social');
			
			$team_designation = theneeds_function_library::theneeds_find_xml_value($theneeds_team_xml->documentElement,'team_designation');
			
			
			$team_facebook = theneeds_function_library::theneeds_find_xml_value($theneeds_team_xml->documentElement,'team_facebook');
			$team_linkedin = theneeds_function_library::theneeds_find_xml_value($theneeds_team_xml->documentElement,'team_linkedin');
			$team_twitter = theneeds_function_library::theneeds_find_xml_value($theneeds_team_xml->documentElement,'team_twitter');
			$google_plus = theneeds_function_library::theneeds_find_xml_value($theneeds_team_xml->documentElement,'google_plus');
			$theneeds_pinterest = theneeds_function_library::theneeds_find_xml_value($theneeds_team_xml->documentElement,'theneeds_pinterest');
			$theneeds_youtube = theneeds_function_library::theneeds_find_xml_value($theneeds_team_xml->documentElement,'theneeds_youtube');
			$theneeds_instagram = theneeds_function_library::theneeds_find_xml_value($theneeds_team_xml->documentElement,'theneeds_instagram');
			
			$why_choose_me = theneeds_function_library::theneeds_find_xml_value($theneeds_team_xml->documentElement,'why_choose_me');
			$link_text = theneeds_function_library::theneeds_find_xml_value($theneeds_team_xml->documentElement,'link_text');
			$link_to_url = theneeds_function_library::theneeds_find_xml_value($theneeds_team_xml->documentElement,'link_to_url');
			
			$awards_cat = theneeds_function_library::theneeds_find_xml_value($theneeds_team_xml->documentElement,'awards_cat');

		}
		?>

        	<div class="event_options">
            <div class="op-gap">
				<ul class="panel-body recipe_class row-fluid">
					<li class="panel-input span12">
						<span class="panel-title">
							<h3 for="team_social" > <?php esc_html_e('Social Networking', 'theneeds'); ?> </h3>
						</span>	
						
						<label for="team_social"><div class="checkbox-switch <?php
						
						echo ($team_social=='enable' || ($team_social=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; 

					?>"></div></label>
					<input type="checkbox" name="team_social" class="checkbox-switch" value="disable" checked>
					<input type="checkbox" name="team_social" id="team_social" class="checkbox-switch" value="enable" <?php 
						
						echo ($team_social=='enable' || ($team_social=='' && empty($default)))? 'checked': ''; 
					
					?>>
					<p><?php esc_html_e('Turn On/Off Social Sharing on Team Detail.', 'theneeds'); ?></p>
					</li>
					
				</ul>
				
				<div class="row-fluid">
					<div class="span4">
						<ul class="panel-body recipe_class">
							<li class="panel-input">
								<span class="panel-title">
									<h3 for="team_designation" > <?php esc_html_e('Designation', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="team_designation" id="team_designation" value="<?php if($team_designation <> ''){echo $team_designation;};?>" />
								<p><?php esc_html_e('Please Enter Here Designation of the person.', 'theneeds'); ?></p>
							</li>
						</ul>
					</div>
					<div class="span4">
						<ul class="panel-body recipe_class">
							<li class="panel-input">
								<span class="panel-title">
									<h3 for="theneeds_pinterest" > <?php esc_html_e('Pinterest', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="theneeds_pinterest" id="theneeds_pinterest" value="<?php if($theneeds_pinterest <> ''){echo $theneeds_pinterest;};?>" />
								<p><?php esc_html_e('Add Pinterest Address Here.', 'theneeds'); ?></p>
							</li>
						</ul>
					</div>
					<div class="span4">
						<ul class="panel-body recipe_class">
							<li class="panel-input">
								<span class="panel-title">
									<h3 for="theneeds_youtube" > <?php esc_html_e('Youtube', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="theneeds_youtube" id="theneeds_youtube" value="<?php if($theneeds_youtube <> ''){echo $theneeds_youtube;};?>" />
								<p><?php esc_html_e('Add Youtube Address Here.', 'theneeds'); ?></p>
							</li>
						</ul>
					</div>
				</div>

				<div class="row-fluid">	
					<div class="span3">
						<ul class="panel-body recipe_class">
							<li class="panel-title">
								<h3 for="team_facebook" > <?php esc_html_e('Facebook Profile', 'theneeds'); ?> </h3>
							</li>				
							<li class="panel-input">
								<input type="text" name="team_facebook" id="team_facebook" value="<?php if($team_facebook <> ''){echo $team_facebook;};?>" />
							</li>
							<p><?php esc_html_e('Please Enter Url for social profile.', 'theneeds'); ?></p>
						</ul>	                
					</div>
					<div class="span3">
						<ul class="panel-body recipe_class">
							<li class="panel-title">
								<h3 for="team_linkedin" > <?php esc_html_e('LinkedIn Profile', 'theneeds'); ?> </h3>
							</li>				
							<li class="panel-input">
								<input type="text" name="team_linkedin" id="team_linkedin" value="<?php if($team_linkedin <> ''){echo $team_linkedin;};?>" />
							</li>
							<p><?php esc_html_e('Please Enter Url for social profile.', 'theneeds'); ?></p>
						</ul>	
					</div>
					<div class="span3">
						<ul class="panel-body recipe_class">
							<li class="panel-title">
								<h3 for="team_twitter" > <?php esc_html_e('Twitter Profile', 'theneeds'); ?> </h3>
							</li>				
							<li class="panel-input">
								<input type="text" name="team_twitter" id="team_twitter" value="<?php if($team_twitter <> ''){echo $team_twitter;};?>" />
							</li>
							<p><?php esc_html_e('Please Enter Url for social profile.', 'theneeds'); ?></p>
						</ul>		                
					</div>
					<div class="span3">
						<ul class="panel-body recipe_class">
							<li class="panel-title">
								<h3> <?php esc_html_e('Google Plus', 'theneeds'); ?> </h3>
							</li>				
							<li class="panel-input">
								<input type="text" name="google_plus" id="google_plus" value="<?php if($google_plus <> ''){echo $google_plus;};?>" />
							</li>
							<p><?php esc_html_e('Please Enter Url for social profile.', 'theneeds'); ?></p>
						</ul>		                
					</div>
                </div> 

				<!--<div class="row-fluid">
					<div class="span5">
						<ul class="panel-body recipe_class">
							<li class="panel-input">
								<span class="panel-title">
									<h3 for="why_choose_me" > <?php esc_html_e('Why Choose Me', 'theneeds'); ?> </h3>
								</span>
								<textarea name="why_choose_me" id="why_choose_me" ><?php echo (esc_attr($why_choose_me) == '')? esc_textarea($why_choose_me): esc_textarea($why_choose_me);?></textarea>
								
								
								<p><?php esc_html_e('Add Why Choose Me Description.', 'theneeds'); ?></p>
							</li>
						</ul>
					</div>
					<div class="span3">
						<ul class="panel-body recipe_class">
							<li class="panel-input">
								<span class="panel-title">
									<h3 for="link_text" > <?php esc_html_e('Button Text', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="link_text" id="link_text" value="<?php if($link_text <> ''){echo $link_text;};?>" />
								<p><?php esc_html_e('Add Link Button Text.', 'theneeds'); ?></p>
							</li>
						</ul>
					</div>
					<div class="span4">
						<ul class="panel-body recipe_class">
							<li class="panel-input">
								<span class="panel-title">
									<h3 for="link_to_url" > <?php esc_html_e('Link To URL', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="link_to_url" id="link_to_url" value="<?php if($link_to_url <> ''){echo $link_to_url;};?>" />
								<p><?php esc_html_e('Add Link To URL.', 'theneeds'); ?></p>
							</li>
						</ul>
					</div>
				</div>-->
				<!-- Professional Experience Section -->
					<!--<div class = "professional_section">
						<div class="row-fluid cp-head-section">
							<div class="span12 panel-title">
								<h2 class="text-center"><?php esc_html_e('Add Progress Bar Fields','golfclub');?></h2>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="progress_bar_section">
							<div class="row-fluid">
								<ul class="recipe_class span5">
									<li class="panel-input padding-right-left">
										<div class="panel-title">
											<h3> <?php esc_html_e('Field Title', 'golfclub'); ?> </h3>
										</div>
										<input type="text" class="theneeds_field_title" value="<?php esc_html_e('Architectural Design','golfclub');?>" />
										<p>
										<?php echo esc_html__('Enter Field Title Here i.e Interior Design', 'golfclub'); ?></p>
									</li>
								</ul>
								<ul class="recipe_class span2">
									<li class="panel-input padding-right-left">
										<div class="panel-title">
											<h3> <?php esc_html_e('Add Field Value', 'golfclub'); ?></h3>
										</div>
										<input type="text" class="theneeds_field_percent" value="<?php esc_html_e('90','golfclub');?>" />
										<p><?php esc_html_e('Add Field Value Here i.e 70', 'golfclub'); ?></p>
									</li>
								</ul>
								<ul class="recipe_class span1 add-more-data-cp">
									<li class="panel-input padding-right-left">
										<div class="panel-title">
											<h3> <?php esc_html_e('Add More', 'golfclub'); ?> </h3>
										</div>
										<a id="add-more-data" class="add-more-data"><i class="fa fa-plus"></i></a>
									</li>
								</ul>
							</div>
						</div>
						<div class="progress_bar_section">						
							<div id="add_data_elements" class="row">
								<ul class="recipe_class span4 cp-element-item">
									<li class="panel-input padding-right-left">
										<div class="panel-title">
											<h3> <?php esc_html_e('Field Value', 'golfclub'); ?> </h3>
											<input type="hidden" id="theneeds_field_title" class="theneeds_field_title" value="<?php esc_html_e('Architectural Design','golfclub');?>" />
										</div>
										<input type="text" id="theneeds_field_percent" class="theneeds_field_percent" value="<?php esc_html_e('Add Field Value','golfclub');?>" />
										<p><?php esc_html_e('Update Page To Save These Details.', 'golfclub'); ?></p>
										<a class="panel-delete-field"><i class="fa fa-close"></i></a>
									</li>
								</ul>
								<?php
									$children = '';
									$children_title = '';
									$nofields = '';
									//Sidebar addition
									if($theneeds_field_title <> ''){
										$cp_field_n_xml = new DOMDocument();
										$cp_field_n_xml->loadXML($theneeds_field_title);
										$cp_field_data = $cp_field_n_xml->documentElement->childNodes;
										$nofields = $cp_field_n_xml->documentElement->childNodes->length;
									}		
									
									if($theneeds_field_percent <> ''){	
										$cp_field_t_xml = new DOMDocument();
										$cp_field_t_xml->loadXML($theneeds_field_percent);
										$cp_field_title = $cp_field_t_xml->documentElement->childNodes;
									}
										
									$counter = 0;
									
									if($nofields <> ''){
										for($i=0;$i<$nofields;$i++) { 
											$counter++;?>
												<ul class="recipe_class span4 element-item">
													<li class="panel-input padding-right-left">
														<div class="panel-title">
															<h3> <?php echo esc_attr($cp_field_data->item($i)->nodeValue);?> </h3>
															<input type="hidden" name="theneeds_field_title[]" value="<?php echo esc_attr($cp_field_data->item($i)->nodeValue);?>" />
														</div>
														<input type="text" name="theneeds_field_percent[]" value="<?php echo $cp_field_title->item($i)->nodeValue;?>" />
													
														<p><?php esc_html_e('View of Entered Values.', 'golfclub'); ?></p>
														<a class="panel-delete-field"><i class="fa fa-close"></i></a>
													</li>
												</ul>
											<?php
										}
									} ?>
							</div>						
						</div>
					</div>-->
					
					<!--<div class="row-fluid">
						<ul class="recipe_class span4">
						  <li class="panel-title">
							<h3 for="gallery_cat">
							  <?php esc_html_e('Select Sponsors Gallery', 'rider-wordpress'); ?>
							</h3>
							<select name="gallery_name_event" id="gallery_name_event" class="widefat">
								<option><?php esc_html_e("--Select--","rider-wordpress");?></option>
								<?php
									foreach (theneeds_get_title_list_array('gallery') as $gallery){ ?>
										<option value="<?php echo $gallery->ID?>"<?php if($gallery_name_event==$gallery->ID){echo"selected";}?>><?php echo $gallery->post_title?></option>					
								<?php }?>
							</select>	
							<p><?php esc_html_e('Please select Gallery Name.', 'rider-wordpress'); ?></p>
						  </li>
						</ul>
						<ul class="recipe_class span4">
						  <li class="panel-title">
							<h3 for="gallery_cat">
							  <?php esc_html_e('Select Recent Work', 'rider-wordpress'); ?>
							</h3>
							<select name="recent_work_gallery" id="recent_work_gallery" class="widefat">
								<option><?php esc_html_e("--Select--","rider-wordpress");?></option>
								<?php
									foreach (theneeds_get_title_list_array('gallery') as $gallery){ ?>
										<option value="<?php echo $gallery->ID?>"<?php if($recent_work_gallery==$gallery->ID){echo"selected";}?>><?php echo $gallery->post_title?></option>					
								<?php }?>
							</select>	
							<p><?php esc_html_e('Please select Gallery Name.', 'rider-wordpress'); ?></p>
						  </li>
						</ul>
						<ul class="recipe_class span4">
						  <li class="panel-title">
							<h3 for="gallery_cat">
							  <?php esc_html_e('Select Awards Category', 'rider-wordpress'); ?>
							</h3>
							<select name="awards_cat" id="awards_cat" class="widefat">
								<option><?php esc_html_e("--Select--","rider-wordpress");?></option>
								<?php
									foreach (theneeds_get_category_list_array('award-category') as $gallery){ ?>
										<option value="<?php echo $gallery->term_id?>"<?php if($awards_cat==$gallery->term_id){echo"selected";}?>><?php echo $gallery->name;?></option>		
								<?php }?>
							</select>	
							<p><?php esc_html_e('Please select Gallery Name.', 'rider-wordpress'); ?></p>
						  </li>
						</ul>
					</div>-->

				
				<input type="hidden" name="team_submit" value="teams"/>
				<div class="clear"></div>
			</div>	
        </div>	
			
        <?php }
		
		public function save_team_option_meta($post_id){
			
			$team_social = '';
			
			$team_facebook = '';
			$team_linkedin = '';
			$team_twitter = '';
			$google_plus = '';
			$team_designation = '';
			$theneeds_instagram = '';
			
			$gallery_name_event = '';
			$recent_work_gallery = '';
			$awards_cat = '';
			
			
			
			$why_choose_me = '';
			$link_text = '';
			$link_to_url = '';
			
			
			foreach($_REQUEST as $keys=>$values){
				$$keys = $values;
			}
		
			if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;
		
				if(isset($team_submit) AND $team_submit == 'teams'){
					$new_data = '<team_detail>';
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('team_social',$team_social);
					
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('team_designation',$team_designation);
					
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('team_facebook',$team_facebook);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('team_linkedin',$team_linkedin);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('team_twitter',$team_twitter);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('google_plus',$google_plus);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('theneeds_instagram',$theneeds_instagram);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('theneeds_pinterest',$theneeds_pinterest);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('theneeds_youtube',$theneeds_youtube);
					
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('why_choose_me',$why_choose_me);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('link_text',$link_text);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('link_to_url',$link_to_url);
					
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('awards_cat',$awards_cat);
					
					

					$new_data = $new_data . '</team_detail>';
				
				/* Saving Sidebar and Social Sharing Settings as XML */
				$old_data = get_post_meta($post_id, 'team_detail_xml',true);
				theneeds_function_library::theneeds_save_meta_data($post_id, $new_data, $old_data, 'team_detail_xml');
				
				/*********** Project Details ************************/
				
				/* 1. Field Name */
				$cp_field_title_xml = '<cp_field_title_xml>';
				if(isset($_POST['theneeds_field_title'])){$cp_field_title = $_POST['theneeds_field_title'];
					foreach($cp_field_title as $keys=>$values){
						$cp_field_title_xml = $cp_field_title_xml . theneeds_create_xml_tag('cp_field_title',esc_attr($values));
					}
				}else{$cp_field_title = '';}
				$cp_field_title_xml = $cp_field_title_xml . '</cp_field_title_xml>';
			
				/* Save Seperately */
				$old_data = get_post_meta($post_id, 'cp_field_title',true);
				theneeds_save_meta_data($post_id, $cp_field_title_xml, $old_data, 'cp_field_title');
				
				
				/* 2. Field value */
				$cp_field_percent_xml = '<cp_field_percent_xml>';
				if(isset($_POST['theneeds_field_percent'])){$cp_field_percent = $_POST['theneeds_field_percent'];
					foreach($cp_field_percent as $keys=>$values){
						$cp_field_percent_xml = $cp_field_percent_xml . theneeds_create_xml_tag('cp_field_percent',esc_attr($values));
					}
				}else{$cp_field_percent = '';}
				$cp_field_percent_xml = $cp_field_percent_xml . '</cp_field_percent_xml>';
			
				/* Save Seperately */
				$old_data = get_post_meta($post_id, 'cp_field_percent',true);
				theneeds_save_meta_data($post_id, $cp_field_percent_xml, $old_data, 'cp_field_percent');
				
				/* 6. Gallery ID */
				$old_data = get_post_meta($post_id, 'gallery_name_event',true);
				theneeds_function_library::theneeds_save_meta_data($post_id, $gallery_name_event, $old_data, 'gallery_name_event');
				
				/* 6. Gallery ID */
				$old_data = get_post_meta($post_id, 'recent_work_gallery',true);
				theneeds_function_library::theneeds_save_meta_data($post_id, $recent_work_gallery, $old_data, 'recent_work_gallery');
				
				
				
				
			}
		}	

	}
}	
