<?php 
/* Condition for Parent Class */
if(class_exists('theneeds_function_library')){
	
	add_action( 'plugins_loaded', 'features_fun_override' );
	
	function features_fun_override() {
		
		$features_class = new theneeds_features;
	}

	class theneeds_features extends theneeds_function_library{
		
		public $features_array = array(
		
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
		
		public function theneeds_features_init(){
			
			/* Yet To Be Implemented */
			
		}
		
		/* Constructor */
		public function __construct(){
			
			add_action( 'init', array( $this, 'theneeds_create_features' ) );
			add_action( 'add_meta_boxes', array( $this, 'theneeds_add_features_option' ) );
			add_action( 'save_post', array( $this, 'save_features_option_meta' ) );
		}
		
		public function theneeds_create_features() {
			
			$labels = array(
				'name' => _x('Features', 'Features General Name', 'eventco'),
				'singular_name' => _x('Feature', 'Event Singular Name', 'eventco'),
				'add_new' => _x('Add New', 'Add New Features', 'eventco'),
				'add_new_item' => __('Add New Feature', 'eventco'),
				'edit_item' => __('Edit Feature', 'eventco'),
				'new_item' => __('New Feature', 'eventco'),
				'view_item' => __('View Feature', 'eventco'),
				'search_items' => __('Search Features', 'eventco'),
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
				'menu_icon' => 'dashicons-yes',
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				'supports' => array('title','editor','author','thumbnail','excerpt','comments'),
				'has_archive' => true,
				'rewrite' => array('slug' => '', 'with_front' => false)
			  ); 
			  
			register_post_type( 'features' , $args);	

			register_taxonomy(
				"features-categories", array("features"), array(
					"hierarchical" => true,
					"label" => "Features Categories", 
					"singular_label" => "Features Categories", 
					"rewrite" => true));
			register_taxonomy_for_object_type('features-categories', 'features');	

			
			
		}
		
		
		
		public function theneeds_add_features_option(){	
		
			add_meta_box('team-option', __('Our Features Options','theneeds'), array($this,'theneeds_add_our_features_element'),
				'features', 'normal', 'high');
				
		}
		

		public function theneeds_add_our_features_element(){
			$features_social = '';
			$sidebar_features = '';
			$right_sidebar_features = '';
			$left_sidebar_features = '';
			$features_caption = '';
			$features_facebook = '';
			$features_linkedin = '';
			$features_twitter = '';
			$google_plus = '';
			$features_svg_icon = '';
			
			
		foreach($_REQUEST as $keys=>$values){
			$$keys = $values;
		}
		global $post;
			
		$theneeds_features_detail_xml = get_post_meta($post->ID, 'theneeds_features_detail_xml', true);
		
		if($theneeds_features_detail_xml <> ''){
			
			$theneeds_theneeds_features_xml = new DOMDocument ();
			
			$theneeds_theneeds_features_xml->loadXML ( $theneeds_features_detail_xml );
			
			$features_social = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_features_xml->documentElement,'features_social');
			$sidebar_features = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_features_xml->documentElement,'sidebar_features');
			$left_sidebar_features = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_features_xml->documentElement,'left_sidebar_features');
			$right_sidebar_features = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_features_xml->documentElement,'right_sidebar_features');
			
			$features_caption = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_features_xml->documentElement,'features_caption');
			$features_svg_icon = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_features_xml->documentElement,'features_svg_icon');
			
			
			$features_facebook = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_features_xml->documentElement,'features_facebook');
			$features_linkedin = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_features_xml->documentElement,'features_linkedin');
			$features_twitter = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_features_xml->documentElement,'features_twitter');
			$google_plus = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_features_xml->documentElement,'google_plus');
		}
		?>

        	<div class="event_options">
            <div class="op-gap">
				<!--<ul class="panel-body recipe_class row-fluid">
					<li class="panel-input span12">
						<span class="panel-title">
							<h3 for="features_social" > <?php esc_html_e('SOCIAL NETWORKING', 'theneeds'); ?> </h3>
						</span>	
						
						<label for="features_social"><div class="checkbox-switch <?php
						
						echo ($features_social=='enable' || ($features_social=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; 

					?>"></div></label>
					<input type="checkbox" name="features_social" class="checkbox-switch" value="disable" checked>
					<input type="checkbox" name="features_social" id="features_social" class="checkbox-switch" value="enable" <?php 
						
						echo ($features_social=='enable' || ($features_social=='' && empty($default)))? 'checked': ''; 
					
					?>>
					<p><?php esc_html_e('Turn On/Off Social Sharing on Team Detail.', 'theneeds'); ?></p>
					</li>
					
				</ul>-->
				<div class="clear"></div>
				<?php //echo theneeds_function_library::theneeds_show_sidebar($sidebar_features,'right_sidebar_features','left_sidebar_features',$right_sidebar_features,$left_sidebar_features);?>
				<div class="clear"></div>
				<div class="row-fluid">
					<div class="span6">
						<ul class="panel-body recipe_class">
							<li class="panel-input">
								<span class="panel-title">
									<h3 for="features_caption" > <?php esc_html_e('Font Awesome Icon', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="features_caption" id="features_caption" value="<?php if($features_caption <> ''){echo $features_caption;};?>" />
								<p><?php esc_html_e('Please Enter Font Awesome Icon Here, i.e fa fa-globe', 'theneeds'); ?></p>
							</li>
						</ul>
					</div>
				</div>
				<!--<div class="row-fluid">
					<div class="span6">
						<ul class="panel-body recipe_class">
							<li class="panel-input">
								<span class="panel-title">
									<h3 for="features_caption" > <?php esc_html_e('Project Caption', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="features_caption" id="features_caption" value="<?php if($features_caption <> ''){echo $features_caption;};?>" />
								<p><?php esc_html_e('Please Enter Project Caption Here.', 'theneeds'); ?></p>
							</li>
						</ul>
					</div>
					<div class="span6">
						<ul class="panel-body recipe_class">
							<li class="panel-input">
								<span class="panel-title">
									<h3 for="features_svg_icon" > <?php esc_html_e('Project SVG Icon', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="features_svg_icon" id="features_svg_icon" value="<?php if($features_svg_icon <> ''){echo $features_svg_icon;};?>" />
								<p><?php esc_html_e('Please Enter Project Svg Icon Here.', 'theneeds'); ?></p>
							</li>
						</ul>
					</div>
				</div>-->
				
				<!--<div class="row-fluid">	
					<div class="span3">
						<ul class="panel-body recipe_class">
							<li class="panel-title">
								<h3 for="features_facebook" > <?php esc_html_e('Facebook Profile', 'theneeds'); ?> </h3>
							</li>				
							<li class="panel-input">
								<input type="text" name="features_facebook" id="features_facebook" value="<?php if($features_facebook <> ''){echo $features_facebook;};?>" />
							</li>
							<p><?php esc_html_e('Please Enter Url for social profile.', 'theneeds'); ?></p>
						</ul>	                
					</div>
					<div class="span3">
						<ul class="panel-body recipe_class">
							<li class="panel-title">
								<h3 for="features_linkedin" > <?php esc_html_e('Linked In Profile', 'theneeds'); ?> </h3>
							</li>				
							<li class="panel-input">
								<input type="text" name="features_linkedin" id="features_linkedin" value="<?php if($features_linkedin <> ''){echo $features_linkedin;};?>" />
							</li>
							<p><?php esc_html_e('Please Enter Url for social profile.', 'theneeds'); ?></p>
						</ul>	
					</div>
					<div class="span3">
						<ul class="panel-body recipe_class">
							<li class="panel-title">
								<h3 for="features_twitter" > <?php esc_html_e('Twitter Profile', 'theneeds'); ?> </h3>
							</li>				
							<li class="panel-input">
								<input type="text" name="features_twitter" id="features_twitter" value="<?php if($features_twitter <> ''){echo $features_twitter;};?>" />
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
                </div>--->                		
				<input type="hidden" name="features_submit" value="teams"/>
				<div class="clear"></div>
			</div>	
        </div>	
			
        <?php }
		
		public function save_features_option_meta($post_id){
			
			$features_social = '';
			$sidebars = '';
			$right_sidebar_features = '';
			$left_sidebar_features = '';
			$features_facebook = '';
			$features_linkedin = '';
			$features_twitter = '';
			$google_plus = '';
			$features_caption = '';
			$features_svg_icon = '';
			
			
			foreach($_REQUEST as $keys=>$values){
				$$keys = $values;
			}
		
			if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;
		
				if(isset($features_submit) AND $features_submit == 'teams'){
					$new_data = '<theneeds_features_detail>';
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('features_social',$features_social);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('sidebar_features',$sidebars);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('right_sidebar_features',$right_sidebar_features);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('left_sidebar_features',$left_sidebar_features);
					
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('features_caption',$features_caption);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('features_svg_icon',$features_svg_icon);
					
					
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('features_facebook',$features_facebook);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('features_linkedin',$features_linkedin);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('features_twitter',$features_twitter);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('google_plus',$google_plus);
					$new_data = $new_data . '</theneeds_features_detail>';
				
				/* Saving Sidebar and Social Sharing Settings as XML */
				$old_data = get_post_meta($post_id, 'theneeds_features_detail_xml',true);
				theneeds_function_library::theneeds_save_meta_data($post_id, $new_data, $old_data, 'theneeds_features_detail_xml');
				
				
			}
		}	

	}
}