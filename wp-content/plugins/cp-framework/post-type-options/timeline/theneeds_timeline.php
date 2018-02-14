<?php
//Condition for Parent Class
if(class_exists('theneeds_function_library')){
	
	add_action( 'plugins_loaded', 'timeline_override' );
	function timeline_override() {
		$testi_class = new theneeds_timeline_class;
	}

	class theneeds_timeline_class extends theneeds_function_library{

		public $testi_array = array(

			/* Yet To be Implemented */
			
		);
		
		public $testi_slider_array = array(
		
			/* Yet To be Implemented */

		);
		
		
		public $testi_size_array =  array('element1-1'=>'1/1');		
		public $slider_testi_size_array =  array('element1-1'=>'1/1');		


		public function page_builder_size_class(){
			
			/* Yet To be Implemented */
		
		}
		
		public function page_builder_element_class(){
			
			/* Yet To be Implemented */
		}
		
		public function __construct(){
			add_action( 'init', array( $this, 'theneeds_create_timeline' ) );
			add_action( 'add_meta_boxes', array( $this, 'theneeds_add_timeline_option' ) );	
			add_action( 'save_post', array( $this, 'save_timeline_option_meta' ) );	
		}
		
		
		public function theneeds_create_timeline() {
			
			$labels = array(
				'name' => _x('Timeline', 'Timeline General Name', 'rider-wordpress'),
				'singular_name' => _x('Timeline', 'Timeline Singular Name', 'rider-wordpress'),
				'add_new' => _x('Add New', 'Add New Timeline Name', 'rider-wordpress'),
				'add_new_item' => __('Add New Timeline', 'rider-wordpress'),
				'edit_item' => __('Edit Timeline', 'rider-wordpress'),
				'new_item' => __('New Timeline', 'rider-wordpress'),
				'view_item' => __('View Timeline', 'rider-wordpress'),
				'search_items' => __('Search Timeline', 'rider-wordpress'),
				'not_found' =>  __('Nothing found', 'rider-wordpress'),
				'not_found_in_trash' => __('Nothing found in Trash', 'rider-wordpress'),
				'parent_item_colon' => ''
			);
			
			$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'menu_icon' => 'dashicons-clock',
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				'supports' => array('title','editor','author','thumbnail','excerpt','comments'),
				'has_archive' => true,
				'rewrite' => array('slug' => '', 'with_front' => false)
			  ); 
			  
			register_post_type( 'timeline' , $args);	

			register_taxonomy(
				"timeline-category", array("timeline"), array(
					"hierarchical" => true,
					"label" => "Timeline Categories", 
					"singular_label" => "Timeline Category", 
					"rewrite" => true));
			register_taxonomy_for_object_type('timeline-category', 'timeline');			
		}
		
		public function theneeds_add_timeline_option(){	
		
			add_meta_box('testi-option', __('Timeline Option','rider-wordpress'),array($this,'theneeds_add_timeline_option_element'),
				'timeline', 'normal', 'high');
				
		}
		
		public function theneeds_add_timeline_option_element(){
			
			foreach($_REQUEST as $keys=>$values){
				$$keys = $values;
			}
			global $post,$countries;
			
			$timeline_year = get_post_meta($post->ID, 'timeline_year', true);
		
		?>
			<div class="event_options">		
				<div class="op-gap row-fluid">
					<ul class="panel-body designation_class recipe_class span12">
						<li class="panel-input">
							<span class="panel-title">
								<h3> <?php _e('Timeline Year (Duration)', 'rider-wordpress'); ?> </h3>
							</span>
							<input type="text" name="timeline_year" id="timeline_year" value="<?php if($timeline_year <> ''){echo esc_attr($timeline_year);};?>" />
							<p><?php esc_html_e('Add Timeline Duration or Period i.e 2016-2019', 'rider-wordpress'); ?></p>
						</li>
					</ul>
				</div>			
				
				<input type="hidden" name="timeline_submit" value="timeline"/>
				<div class="clear"></div>
			</div>	
			<div class="clear"></div>
		<?php }
		
		
		public function save_timeline_option_meta($post_id){
			
	
			foreach($_REQUEST as $keys=>$values){
				$$keys = $values;
			}
		
			if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;
		
				if(isset($timeline_submit) AND $timeline_submit == 'timeline'){
				
					//Saving Sidebar and Social Sharing Settings as XML
					$old_data = get_post_meta($post_id, 'timeline_year',true);
					theneeds_save_meta_data($post_id, $timeline_year, $old_data, 'timeline_year');
					
					
				}
		}
	}
}	