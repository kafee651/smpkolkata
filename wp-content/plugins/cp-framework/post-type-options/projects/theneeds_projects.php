<?php 
/* Condition for Parent Class */
if(class_exists('theneeds_function_library')){
	
	add_action( 'plugins_loaded', 'theneeds_fun_override' );
	
	function theneeds_fun_override() {
		
		$theneeds_class = new theneeds_arkeytect;
	}

	class theneeds_arkeytect extends theneeds_function_library{
		
		public $theneeds_array = array(
		
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
		
		public function theneeds_theneeds_init(){
			
			/* Yet To Be Implemented */
			
		}
		
		/* Constructor */
		public function __construct(){
			
			add_action( 'init', array( $this, 'theneeds_create_arkeytect' ) );
			add_action( 'add_meta_boxes', array( $this, 'theneeds_add_theneeds_option' ) );
			add_action( 'save_post', array( $this, 'save_theneeds_option_meta' ) );
		}
		
		public function theneeds_create_arkeytect() {
			
			$labels = array(
				'name' => _x('Projects', 'Projects General Name', 'eventco'),
				'singular_name' => _x('Project', 'Event Singular Name', 'eventco'),
				'add_new' => _x('Add New', 'Add New Projects', 'eventco'),
				'add_new_item' => __('Add New Project', 'eventco'),
				'edit_item' => __('Edit Project', 'eventco'),
				'new_item' => __('New Project', 'eventco'),
				'view_item' => __('View Project', 'eventco'),
				'search_items' => __('Search Projects', 'eventco'),
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
				'menu_icon' => 'dashicons-tagcloud',
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				'supports' => array('title','editor','author','thumbnail','excerpt','comments'),
				'has_archive' => true,
				'rewrite' => array('slug' => '', 'with_front' => false)
			  ); 
			  
			register_post_type( 'projects' , $args);	

			register_taxonomy(
				"projects-categories", array("projects"), array(
					"hierarchical" => true,
					"label" => "Project Categories", 
					"singular_label" => "Project Categories", 
					"rewrite" => true));
			register_taxonomy_for_object_type('projects-categories', 'projects');

			register_taxonomy(
				'projects-tags',
				'projects',
				array(
					'hierarchical'  => false,
					'label'         => "Project Tags",
					'singular_name' => "Project Tag",
					'rewrite'       => true,
					'query_var'     => true
				)
			);	
						
		}
		
		
		
		public function theneeds_add_theneeds_option(){	
		
			add_meta_box('team-option', __('Our Projects Options','theneeds'), array($this,'theneeds_add_our_theneeds_element'),
				'projects', 'normal', 'high');
				
		}
		

		public function theneeds_add_our_theneeds_element(){
			
			$theneeds_social = '';
			$sidebar_ecoist = '';
			$right_sidebar_ecoist = '';
			$left_sidebar_ecoist = '';
			$projects_icons = '';
			$projects_duration = '';
			
		

		foreach($_REQUEST as $keys=>$values){
			$$keys = $values;
		}
		global $post;
	
		$theneeds_projects_detail_xml = get_post_meta($post->ID, 'theneeds_projects_detail_xml', true);
		
		if($theneeds_projects_detail_xml <> ''){
			
			$theneeds_theneeds_theneeds_xml = new DOMDocument ();
			
			$theneeds_theneeds_theneeds_xml->loadXML ( $theneeds_projects_detail_xml );
			
			$theneeds_social = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_theneeds_xml->documentElement,'theneeds_social');
			$sidebar_ecoist = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_theneeds_xml->documentElement,'sidebar_ecoist');
			$left_sidebar_ecoist = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_theneeds_xml->documentElement,'left_sidebar_ecoist');
			$right_sidebar_ecoist = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_theneeds_xml->documentElement,'right_sidebar_ecoist');
			$projects_icons = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_theneeds_xml->documentElement,'projects_icons');
			$projects_duration = theneeds_function_library::theneeds_find_xml_value($theneeds_theneeds_theneeds_xml->documentElement,'projects_duration');
			
	
		}
		?>

        	<div class="event_options project_options">
            <div class="op-gap">
				<ul class="panel-body recipe_class row-fluid">
					<li class="panel-input span12">
						<span class="panel-title">
							<h3 for="theneeds_social" > <?php esc_html_e('Social Networking', 'theneeds'); ?> </h3>
						</span>	
						
						<label for="theneeds_social"><div class="checkbox-switch <?php
						
						echo ($theneeds_social=='enable' || ($theneeds_social=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; 

					?>"></div></label>
					<input type="checkbox" name="theneeds_social" class="checkbox-switch" value="disable" checked>
					<input type="checkbox" name="theneeds_social" id="theneeds_social" class="checkbox-switch" value="enable" <?php 
						
						echo ($theneeds_social=='enable' || ($theneeds_social=='' && empty($default)))? 'checked': ''; 
					
					?>>
					<p><?php esc_html_e('Turn On/Off Social Sharing.', 'theneeds'); ?></p>
					</li>
				</ul>
				<div class="clear"></div>
				<?php echo theneeds_function_library::theneeds_show_sidebar($sidebar_ecoist,'right_sidebar_ecoist','left_sidebar_ecoist',$right_sidebar_ecoist,$left_sidebar_ecoist);?>
				<div class="row-fluid">
					<div class="span6">
						<ul class="panel-body recipe_class">
							<li class="panel-input">
								<span class="panel-title">
									<h3 for="projects_icons" > <?php esc_html_e('Font Awesome Icon', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="projects_icons" id="projects_icons" value="<?php if($projects_icons <> ''){echo $projects_icons;};?>" />
								<p><?php esc_html_e('Please Enter Font Awesome Icon Here, i.e fa fa-globe', 'theneeds'); ?></p>
							</li>
						</ul>
					</div>
					<div class="span6">
						<ul class="panel-body recipe_class">
							<li class="panel-input">
								<span class="panel-title">
									<h3 for="projects_duration" > <?php esc_html_e('Duration', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="projects_duration" id="projects_duration" value="<?php if($projects_duration <> ''){echo $projects_duration;};?>" />
								<p><?php esc_html_e('Please Enter Duration of Completed Project, i.e 2004-2009', 'theneeds'); ?></p>
							</li>
						</ul>
					</div>
				</div>
				<div class="clear"></div>
				<input type="hidden" name="theneeds_submit" value="projects"/>
				<div class="clear"></div>
			</div>	
        </div>	
			
        <?php }
		
		public function save_theneeds_option_meta($post_id){
			
			$theneeds_social = '';
			$sidebars = '';
			$right_sidebar_ecoist = '';
			$left_sidebar_ecoist = '';
			$projects_icons = '';
		

			foreach($_REQUEST as $keys=>$values){
				$$keys = $values;
			}
		
			if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;
		
				if(isset($theneeds_submit) AND $theneeds_submit == 'projects'){
					$new_data = '<theneeds_theneeds_detail>';
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('theneeds_social',$theneeds_social);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('sidebar_ecoist',$sidebars);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('right_sidebar_ecoist',$right_sidebar_ecoist);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('left_sidebar_ecoist',$left_sidebar_ecoist);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('projects_icons',$projects_icons);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('projects_duration',$projects_duration);
					
		
					$new_data = $new_data . '</theneeds_theneeds_detail>';
				
				/* Saving Sidebar and Social Sharing Settings as XML */
				$old_data = get_post_meta($post_id, 'theneeds_projects_detail_xml',true);
				theneeds_function_library::theneeds_save_meta_data($post_id, $new_data, $old_data, 'theneeds_projects_detail_xml');

			}
		}	

	}
}