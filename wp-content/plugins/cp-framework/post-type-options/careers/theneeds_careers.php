<?php 
/* Condition for Parent Class */
if(class_exists('theneeds_function_library')){
	
	add_action( 'plugins_loaded', 'careers_fun_override' );
	
	function careers_fun_override() {
		
		$careers_class = new theneeds_careers;
	}

	class theneeds_careers extends theneeds_function_library{
		
		public $careers_array = array(
		
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
		
		public function theneeds_careers_init(){
			
			/* Yet To Be Implemented */
			
		}
		
		/* Constructor */
		public function __construct(){
			
			add_action( 'init', array( $this, 'theneeds_create_careers' ) );
			add_action( 'add_meta_boxes', array( $this, 'theneeds_add_careers_option' ) );
			add_action( 'save_post', array( $this, 'save_careers_option_meta' ) );
		}
		
		public function theneeds_create_careers() {
			
			$labels = array(
				'name' => _x('Careers', 'Careers General Name', 'eventco'),
				'singular_name' => _x('Career', 'Event Singular Name', 'eventco'),
				'add_new' => _x('Add New', 'Add New Careers', 'eventco'),
				'add_new_item' => __('Add New Career', 'eventco'),
				'edit_item' => __('Edit Career', 'eventco'),
				'new_item' => __('New Career', 'eventco'),
				'view_item' => __('View Career', 'eventco'),
				'search_items' => __('Search Careers', 'eventco'),
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
				'menu_icon' => 'dashicons-hammer',
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				'supports' => array('title','editor','author','thumbnail','excerpt','comments'),
				'has_archive' => true,
				'rewrite' => array('slug' => '', 'with_front' => false)
			  ); 
			  
			register_post_type( 'careers' , $args);	

			register_taxonomy(
				"careers-categories", array("careers"), array(
					"hierarchical" => true,
					"label" => "Careers Categories", 
					"singular_label" => "Careers Categories", 
					"rewrite" => true));
			register_taxonomy_for_object_type('careers-categories', 'careers');			
		}
		
		
		
		public function theneeds_add_careers_option(){	
		
			//add_meta_box('team-option', __('Our Career Options','theneeds'), array($this,'theneeds_add_our_careers_element'),'careers', 'normal', 'high');
				
				
		}
		

		public function theneeds_add_our_careers_element(){
			$careers_social = '';
			$sidebar_careers = '';
			$right_sidebar_careers = '';
			$left_sidebar_careers = '';
			$careers_caption = '';
			$careers_facebook = '';
			$careers_linkedin = '';
			$careers_twitter = '';
			$google_plus = '';
			$careers_svg_icon = '';
			
			
		foreach($_REQUEST as $keys=>$values){
			$$keys = $values;
		}
		global $post;
			
		$theneeds_careers_detail_xml = get_post_meta($post->ID, 'theneeds_careers_detail_xml', true);
		
		if($theneeds_careers_detail_xml <> ''){
			
			$theneeds_theneeds_careers_xml = new DOMDocument ();
			
			$theneeds_theneeds_careers_xml->loadXML ( $theneeds_careers_detail_xml );
			
			$careers_social = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_careers_xml->documentElement,'careers_social');
			$sidebar_careers = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_careers_xml->documentElement,'sidebar_careers');
			$left_sidebar_careers = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_careers_xml->documentElement,'left_sidebar_careers');
			$right_sidebar_careers = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_careers_xml->documentElement,'right_sidebar_careers');
			
			$careers_caption = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_careers_xml->documentElement,'careers_caption');
			$careers_svg_icon = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_careers_xml->documentElement,'careers_svg_icon');
			
			
			$careers_facebook = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_careers_xml->documentElement,'careers_facebook');
			$careers_linkedin = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_careers_xml->documentElement,'careers_linkedin');
			$careers_twitter = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_careers_xml->documentElement,'careers_twitter');
			$google_plus = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_careers_xml->documentElement,'google_plus');
		}
		?>

        	<div class="event_options">
            <div class="op-gap">
				<ul class="panel-body recipe_class row-fluid">
					<li class="panel-input span12">
						<span class="panel-title">
							<h3 for="careers_social" > <?php esc_html_e('SOCIAL NETWORKING', 'theneeds'); ?> </h3>
						</span>	
						
						<label for="careers_social"><div class="checkbox-switch <?php
						
						echo ($careers_social=='enable' || ($careers_social=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; 

					?>"></div></label>
					<input type="checkbox" name="careers_social" class="checkbox-switch" value="disable" checked>
					<input type="checkbox" name="careers_social" id="careers_social" class="checkbox-switch" value="enable" <?php 
						
						echo ($careers_social=='enable' || ($careers_social=='' && empty($default)))? 'checked': ''; 
					
					?>>
					<p><?php esc_html_e('Turn On/Off Social Sharing on Team Detail.', 'theneeds'); ?></p>
					</li>
					
				</ul>
				<div class="clear"></div>
				<?php echo theneeds_function_library::theneeds_show_sidebar($sidebar_careers,'right_sidebar_careers','left_sidebar_careers',$right_sidebar_careers,$left_sidebar_careers);?>
				<div class="clear"></div>
				<div class="row-fluid">
					<div class="span6">
						<ul class="panel-body recipe_class">
							<li class="panel-input">
								<span class="panel-title">
									<h3 for="careers_caption" > <?php esc_html_e('Project Caption', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="careers_caption" id="careers_caption" value="<?php if($careers_caption <> ''){echo $careers_caption;};?>" />
								<p><?php esc_html_e('Please Enter Project Caption Here.', 'theneeds'); ?></p>
							</li>
						</ul>
					</div>
					<div class="span6">
						<ul class="panel-body recipe_class">
							<li class="panel-input">
								<span class="panel-title">
									<h3 for="careers_svg_icon" > <?php esc_html_e('Project SVG Icon', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="careers_svg_icon" id="careers_svg_icon" value="<?php if($careers_svg_icon <> ''){echo $careers_svg_icon;};?>" />
								<p><?php esc_html_e('Please Enter Project Svg Icon Here.', 'theneeds'); ?></p>
							</li>
						</ul>
					</div>
				</div>
				
				<div class="row-fluid">	
					<div class="span3">
						<ul class="panel-body recipe_class">
							<li class="panel-title">
								<h3 for="careers_facebook" > <?php esc_html_e('Facebook Profile', 'theneeds'); ?> </h3>
							</li>				
							<li class="panel-input">
								<input type="text" name="careers_facebook" id="careers_facebook" value="<?php if($careers_facebook <> ''){echo $careers_facebook;};?>" />
							</li>
							<p><?php esc_html_e('Please Enter Url for social profile.', 'theneeds'); ?></p>
						</ul>	                
					</div>
					<div class="span3">
						<ul class="panel-body recipe_class">
							<li class="panel-title">
								<h3 for="careers_linkedin" > <?php esc_html_e('Linked In Profile', 'theneeds'); ?> </h3>
							</li>				
							<li class="panel-input">
								<input type="text" name="careers_linkedin" id="careers_linkedin" value="<?php if($careers_linkedin <> ''){echo $careers_linkedin;};?>" />
							</li>
							<p><?php esc_html_e('Please Enter Url for social profile.', 'theneeds'); ?></p>
						</ul>	
					</div>
					<div class="span3">
						<ul class="panel-body recipe_class">
							<li class="panel-title">
								<h3 for="careers_twitter" > <?php esc_html_e('Twitter Profile', 'theneeds'); ?> </h3>
							</li>				
							<li class="panel-input">
								<input type="text" name="careers_twitter" id="careers_twitter" value="<?php if($careers_twitter <> ''){echo $careers_twitter;};?>" />
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
				<input type="hidden" name="careers_submit" value="teams"/>
				<div class="clear"></div>
			</div>	
        </div>	
			
        <?php }
		
		public function save_careers_option_meta($post_id){
			
			$careers_social = '';
			$sidebars = '';
			$right_sidebar_careers = '';
			$left_sidebar_careers = '';
			$careers_facebook = '';
			$careers_linkedin = '';
			$careers_twitter = '';
			$google_plus = '';
			$careers_caption = '';
			$careers_svg_icon = '';
			
			
			foreach($_REQUEST as $keys=>$values){
				$$keys = $values;
			}
		
			if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;
		
				if(isset($careers_submit) AND $careers_submit == 'teams'){
					$new_data = '<theneeds_careers_detail>';
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('careers_social',$careers_social);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('sidebar_careers',$sidebars);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('right_sidebar_careers',$right_sidebar_careers);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('left_sidebar_careers',$left_sidebar_careers);
					
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('careers_caption',$careers_caption);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('careers_svg_icon',$careers_svg_icon);
					
					
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('careers_facebook',$careers_facebook);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('careers_linkedin',$careers_linkedin);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('careers_twitter',$careers_twitter);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('google_plus',$google_plus);
					$new_data = $new_data . '</theneeds_careers_detail>';
				
				/* Saving Sidebar and Social Sharing Settings as XML */
				$old_data = get_post_meta($post_id, 'theneeds_careers_detail_xml',true);
				theneeds_function_library::theneeds_save_meta_data($post_id, $new_data, $old_data, 'theneeds_careers_detail_xml');
				
				
			}
		}	

	}
}	
