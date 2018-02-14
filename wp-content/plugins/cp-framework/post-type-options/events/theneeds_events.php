<?php
if(class_exists('theneeds_function_library')){

	add_action( 'plugins_loaded', 'event_fun_override' );

	function event_fun_override() {
		// your code here
		$events_class = new theneeds_events_class;
	}


	class theneeds_events_class extends theneeds_function_library{
				
		
		public function page_builder_size_class(){
		
			/* Yet To Be Implemented */
		
		}
		

		public function page_builder_element_class(){
		
			/* Yet To Be Implemented */
			
		}
		
		public function __construct(){
			
			add_action( 'add_meta_boxes', array( $this, 'theneeds_add_events_option' ) );
			add_action( 'save_post', array( $this, 'save_event_option_meta' ) );
			
		}

		
		public function theneeds_create_events() {
			
			
			$labels = array(
				'name' => _x('Events', 'Event General Name', 'campers'),
				'singular_name' => _x('Event Item', 'Event Singular Name', 'campers'),
				'add_new' => _x('Add New', 'Add New Event Name', 'campers'),
				'add_new_item' => __('Add New Event', 'campers'),
				'edit_item' => __('Edit Event', 'campers'),
				'new_item' => __('New Event', 'campers'),
				'view_item' => __('View Event', 'campers'),
				'search_items' => __('Search Event', 'campers'),
				'not_found' =>  __('Nothing found', 'campers'),
				'not_found_in_trash' => __('Nothing found in Trash', 'campers'),
				'parent_item_colon' => ''
			);
			
			$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'menu_icon' => theneeds_PATH_URL . '/framework/images/calendar-icon.png',
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 5,								'has_archive' => true,
				'supports' => array('title','editor','author','thumbnail','excerpt','comments'),
				'rewrite' => array('slug' => 'events', 'with_front' => false)
			  ); 
			  
			register_post_type( 'events' , $args);
			
			/* Add Locations */
			$labels = array(
				'name' => __('Manage Location', 'campers'),
				'add_new_item' => __('Add New Location (Venue Title)', 'campers'),
				'edit_item' => __('Edit Location', 'campers'),
				'new_item' => __('New Location Item', 'campers'),
				'add_new' => __('Add New Location', 'campers'),
				'view_item' => __('View Location Item', 'campers'),
				'search_items' => __('Search Location', 'campers'),
				'not_found' =>  __('Nothing found', 'campers'),
				'not_found_in_trash' => __('Nothing found in Trash', 'campers'),
				'parent_item_colon' => ''
			);
			$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'menu_icon' => '',
				'show_in_menu' => 'edit.php?post_type=events',
				'show_in_nav_menus'=>true,
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => null,
				'supports' => array('title')
			); 
			register_post_type( 'event_location' , $args );  
		
			
			register_taxonomy(
				"event-category", array("events"), array(
					"hierarchical" => true,
					"label" => "Event Categories", 
					"singular_label" => "Event Categories", 
					"rewrite" => true));
			register_taxonomy_for_object_type('events-categories', 'events');
			
			register_taxonomy(
				"event-tag", array("events"), array(
					"hierarchical" => false, 
					"label" => "Event Tag", 
					"singular_label" => "Event Tag", 
					"rewrite" => true));
			register_taxonomy_for_object_type('events-tag', 'events');
			
		}
		
		
		
		public function theneeds_add_events_option(){	
		
			add_meta_box('event-option', __('Event Options','campers'), array($this,'theneeds_add_event_option_element'),
				'event', 'normal', 'high');
				
		}

		
		public function theneeds_add_event_option_element(){

			$event_detail_xml = '';
			$event_social = '';
			$sidebar_event = '';
			$right_sidebar_event = '';
			$left_sidebar_event = '';
			$event_start_date = '';
			$event_end_date = '';
			$event_start_time = '';
			$event_end_time = '';
			$additional_info = '';
			$entry_level = '';
			$booking_url = '';
			$event_thumbnail = '';
			$video_url_type = '';
			$select_slider_type = '';
			$event_location_select = '';
			$schedule_head = '';
			$schedule_descrip = '';
			$team_parti_head = '';
			$team_parti_descrip = '';
			$name_post_schedule = '';
			$title_post_schedule = '';
			$des_post_schedule = '';
			$sch_select_organizer = '';
			$event_post_caption = '';
			
			/* Trips Options */
			$event_trip_options = '';
			
			foreach($_REQUEST as $keys=>$values){
				$$keys = $values;
			}
			global $post,$EM_Event;
			
			$theneeds_field_name = get_post_meta($post->ID, 'cp_field_name', true);
			$theneeds_field_val = get_post_meta($post->ID, 'cp_field_val', true);
			
			$event_detail_xml = get_post_meta($EM_Event->ID, 'event_detail_xml', true);
			
			if($event_detail_xml <> ''){
				$theneeds_event_xml = new DOMDocument ();
				$theneeds_event_xml->loadXML ( $event_detail_xml );
				$event_social = theneeds_find_xml_value($theneeds_event_xml->documentElement,'event_social');
				$sidebar_event = theneeds_find_xml_value($theneeds_event_xml->documentElement,'sidebar_event');
				$left_sidebar_event = theneeds_find_xml_value($theneeds_event_xml->documentElement,'left_sidebar_event');
				$right_sidebar_event = theneeds_find_xml_value($theneeds_event_xml->documentElement,'right_sidebar_event');
				$event_thumbnail = theneeds_find_xml_value($theneeds_event_xml->documentElement,'event_thumbnail');
				$video_url_type = theneeds_find_xml_value($theneeds_event_xml->documentElement,'video_url_type');
				$select_slider_type = theneeds_find_xml_value($theneeds_event_xml->documentElement,'select_slider_type');
				$event_post_caption = theneeds_find_xml_value($theneeds_event_xml->documentElement,'event_post_caption');
				
				/* Trip Option Values */
				$event_trip_options = theneeds_find_xml_value($theneeds_event_xml->documentElement,'event_trip_options');
	
			}
		?>

		<div class="event_options">	

			<?php echo theneeds_function_library::theneeds_show_sidebar($sidebar_event,'right_sidebar_event','left_sidebar_event',$right_sidebar_event,$left_sidebar_event);?>
			
			<div class="row-fluid">
				<div class="span6">
					<ul class="panel-body recipe_class">
						<li class="panel-input">
							<span class="panel-title">
								<h3 for="event_post_caption" > <?php esc_html_e('Add Event Caption Here', 'theneeds'); ?> </h3>
							</span>
							<input type="text" name="event_post_caption" id="event_post_caption" value="<?php if($event_post_caption <> ''){echo esc_attr($event_post_caption);};?>" />
						</li>
					</ul>
				</div>
			</div>
	
			<input type="hidden" name="event_submit" value="events"/>	
		</div>
	
<?php }
		
		public function save_event_option_meta($post_id){
			
			$event_social = '';
			$sidebars = '';
			$right_sidebar_event = '';
			$left_sidebar_event = '';
			$event_detail_xml = '';
			$event_thumbnail = '';
			$video_url_type = '';
			$event_post_caption = '';
			$select_slider_type = '';
			
			/* Events Trips Options */
			$event_trip_options= '';
			
			
			foreach($_REQUEST as $keys=>$values){
				$$keys = $values;
			}
		
			if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;
		
				if(isset($event_submit) AND $event_submit == 'events'){
					$new_data = '<event_detail>';
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('event_social',$event_social);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('sidebar_event',$sidebars);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('right_sidebar_event',$right_sidebar_event);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('left_sidebar_event',$left_sidebar_event);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('event_post_caption',$event_post_caption);
					
					
					/* Events Trips Options */
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('event_trip_options',$event_trip_options);
					$new_data = $new_data . '</event_detail>';
					
					/* Saving Sidebar and Social Sharing Settings as XML */
					$old_data = get_post_meta($post_id, 'event_detail_xml',true);
					theneeds_function_library::theneeds_save_meta_data($post_id, $new_data, $old_data, 'event_detail_xml');
					
						/* Add Custom Fields Code */
					$cp_field_name_xml = '<cp_field_name_xml>';
					if(isset($_POST['theneeds_field_name'])){$cp_field_name = $_POST['theneeds_field_name'];
						foreach($cp_field_name as $keys=>$values){
							$cp_field_name_xml = $cp_field_name_xml . theneeds_create_xml_tag('cp_field_name',esc_attr($values));
						}
					}else{$cp_field_name = '';}
					$cp_field_name_xml = $cp_field_name_xml . '</cp_field_name_xml>';
				
					/* Add Custom Fields Code */
					$old_data = get_post_meta($post_id, 'cp_field_name',true);
					theneeds_save_meta_data($post_id, $cp_field_name_xml, $old_data, 'cp_field_name');
					
					$cp_field_val_xml = '<cp_field_val_xml>';
					if(isset($_POST['theneeds_field_val'])){$cp_field_val = $_POST['theneeds_field_val'];
						foreach($cp_field_val as $keys=>$values){
							$cp_field_val_xml = $cp_field_val_xml . theneeds_create_xml_tag('cp_field_val',$values);
						}
					}else{$cp_field_val = '';}
					$cp_field_val_xml = $cp_field_val_xml . '</cp_field_val_xml>';
				
					/* Add Custom Fields Code */
					$old_data = get_post_meta($post_id, 'cp_field_val',true);
					theneeds_save_meta_data($post_id, $cp_field_val_xml, $old_data, 'cp_field_val');
					
					

				}
		}
			
	}
}