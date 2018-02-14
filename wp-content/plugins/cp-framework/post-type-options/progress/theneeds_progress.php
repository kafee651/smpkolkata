<?php 
if(class_exists('theneeds_function_library')){

	add_action( 'plugins_loaded', 'progress_post_type' );

	function progress_post_type() {
		// your code here
		$progress_class = new theneeds_progress_class;
	}


	class theneeds_progress_class extends theneeds_function_library{
		
		public $progress_array = array(
		
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
		
		public function theneeds_progress_init(){
			
			/* Yet To Be Implemented */
			
		}
		
		public function __construct(){
			
			add_action( 'init', array( $this, 'theneeds_progress' ) );
			add_action( 'add_meta_boxes', array( $this, 'theneeds_add_progress_option' ) );
			add_action( 'save_post', array( $this, 'save_progress_option_meta' ) );
			
		}
	
		public function theneeds_progress() {
			
			$labels = array(
				'name' => _x('Work Progress', 'Progress General Name', 'theneeds'),
				'singular_name' => _x('Progress', 'Progress Singular Name', 'theneeds'),
				'add_new' => _x('Add New', 'Add New Progress Name', 'theneeds'),
				'add_new_item' => __('Add New Progress', 'theneeds'),
				'edit_item' => __('Edit Progress', 'theneeds'),
				'new_item' => __('New Progress', 'theneeds'),
				'view_item' => __('View Progress', 'theneeds'),
				'search_items' => __('Search Progress', 'theneeds'),
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
				'menu_icon' => 'dashicons-upload',
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				'supports' => array('title','editor','author','thumbnail','comments'),
				'has_archive' => true,
				'rewrite' => array('slug' => '', 'with_front' => false)
			  ); 
			  
			register_post_type( 'progress' , $args);	

			register_taxonomy(
				"progress-category", array("progress"), array(
					"hierarchical" => true,
					"label" => "Progress Category", 
					"singular_label" => "Progress Category", 
					"rewrite" => true));
			register_taxonomy_for_object_type('progress-category', 'progress');			
		}
		
		
	
		
		public function theneeds_add_progress_option(){	
		
			add_meta_box('event-option', __('Work Progress Options','theneeds'), array($this,'theneeds_add_progress_option_element'),
				'progress', 'normal', 'high');
				
		}
		
		public function theneeds_add_progress_option_element(){
	
			$select_slider = '';
			$progress_caption = '';
			
			$sidebar_progress = '';
			$right_sidebar_progress = '';
			$left_sidebar_progress = '';
			
			foreach($_REQUEST as $keys=>$values){
				
				$$keys = $values;
			}
			
			global $post;
			
			$progress_detail_xml = get_post_meta($post->ID, 'progress_detail_xml', true);
			
			if($progress_detail_xml <> ''){
				
				$theneeds_progress_xml = new DOMDocument ();
				
				$theneeds_progress_xml->loadXML ( $progress_detail_xml );
				
				$select_slider = theneeds_find_xml_value($theneeds_progress_xml->documentElement,'select_slider');
				
				$progress_caption = theneeds_find_xml_value($theneeds_progress_xml->documentElement,'progress_caption');
				
				$right_sidebar_progress = theneeds_find_xml_value($theneeds_progress_xml->documentElement,'right_sidebar_progress');
				
				$left_sidebar_progress = theneeds_find_xml_value($theneeds_progress_xml->documentElement,'left_sidebar_progress');
					
			}
		?>

		<div class="event_options cp-wrapper" id="event_backend_options" > 
			<div class="op-gap">
				<div class = "row-fluid">
					<?php echo theneeds_function_library::theneeds_show_sidebar($sidebar_progress,'right_sidebar_progress','left_sidebar_progress',$right_sidebar_progress,$left_sidebar_progress);?>
				</div>
				<div class = "row-fluid">
					<ul class="recipe_class span6">
					  <li class="panel-title">
						<h3 for="gallery_cat">
						  <?php esc_html_e('Select Slider Name', 'rider-wordpress'); ?>
						</h3>
						<select name="select_slider" id="select_slider" class="widefat">
							<option value = "0"><?php esc_html_e("--Select--","rider-wordpress");?></option>
							<?php
								foreach (theneeds_get_title_list_array('theneeds_slider') as $gallery){ ?>
									<option value="<?php echo $gallery->ID?>"<?php if($select_slider==$gallery->ID){echo"selected";}?>><?php echo $gallery->post_title?></option>					
							<?php }?>
						</select>
						<p>
							<?php esc_html_e('Please Select Slider It will be displayed instead of Featured Image.', 'rider-wordpress'); ?>
						</p>						
					  </li>
					  
					</ul>
					<ul class="recipe_class span6">
						<li class="panel-title">
							<h3 for="progress_caption" >
								<?php esc_html_e('Progress Caption', 'theneeds'); ?> 
							</h3>
							<input type="text" name="progress_caption" id="progress_caption" value="<?php if($progress_caption <> ''){echo $progress_caption;};?>" />
							<p><?php esc_html_e('Please Enter Progress Caption Here.', 'theneeds'); ?></p>
						</li>
					</ul>
				</div>					
			</div>	
			<input type="hidden" name="progress_submit" value="work_progress"/>	
		</div>
	
		<?php 
		}

		public function save_progress_option_meta($post_id){
			
			$select_slider = '';
			$progress_caption = '';
			
			$sidebars = '';
			$sidebar_progress = '';
			$right_sidebar_progress = '';
			$left_sidebar_progress = '';
			
			
			foreach($_REQUEST as $keys=>$values){
				$$keys = $values;
			}
		
			if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;
		
				if(isset($progress_submit) AND $progress_submit == 'work_progress'){
					
					$new_data = '<progress_detail>';
					
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('select_slider',$select_slider);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('progress_caption',$progress_caption);
					
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('sidebar_progress',$sidebars);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('right_sidebar_progress',$right_sidebar_progress);
					$new_data = $new_data . theneeds_function_library::theneeds_create_xml_tag('left_sidebar_progress',$left_sidebar_progress);
					
					
					$new_data = $new_data . '</progress_detail>';
					
					/* Saving Sidebar and Social Sharing Settings as XML */
					$old_data = get_post_meta($post_id, 'progress_detail_xml',true);
					theneeds_function_library::theneeds_save_meta_data($post_id, $new_data, $old_data, 'progress_detail_xml');
					
				}
		}
	
	}
	
}
?>