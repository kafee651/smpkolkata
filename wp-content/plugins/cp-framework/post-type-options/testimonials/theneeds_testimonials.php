<?php
/* Condition for Parent Class */
if(class_exists('theneeds_function_library')){
	
	add_action( 'plugins_loaded', 'testimonial_override' );
	
	function testimonial_override() {
		$testi_class = new theneeds_testi_class;
	}

	class theneeds_testi_class extends theneeds_function_library{
		
		public $testi_array = array(		
			
			/* Yet To Be Implemented */

		);
		
		public $testi_slider_array = array(
		
			/* Yet To Be Implemented */

		);
		
		
		public $testi_size_array =  array( );		
		
		public $slider_testi_size_array =  array( );		


		public function page_builder_size_class(){
			
			global $div_size;
			
			/* Yet To Be Implemented */
		}
		
		public function page_builder_element_class(){
			
			global $page_meta_boxes;
			
			/* Yet To Be Implemented */	

		}
		
		/* Constructor */
		public function __construct(){
			
			add_action( 'init', array( $this, 'theneeds_create_testi' ) );
			add_action( 'add_meta_boxes', array( $this, 'theneeds_add_testi_option' ) );	
			add_action( 'save_post', array( $this, 'save_testimonial_option_meta' ) );	
		}
		
		
		public function theneeds_create_testi() {
			
			$labels = array(
				'name' => _x('Testimonial', 'Testimonial General Name', 'theneeds'),
				'singular_name' => _x('Testimonial', 'Event Singular Name', 'theneeds'),
				'add_new' => _x('Add New', 'Add New Testimonial Name', 'theneeds'),
				'add_new_item' => __('Add New Testimonial', 'theneeds'),
				'edit_item' => __('Edit Testimonial', 'theneeds'),
				'new_item' => __('New Testimonial', 'theneeds'),
				'view_item' => __('View Testimonial', 'theneeds'),
				'search_items' => __('Search Testimonial', 'theneeds'),
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
				'menu_icon' => 'dashicons-microphone',
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				'supports' => array('title','editor','author','thumbnail','excerpt','comments'),
				'has_archive' => true,
				'rewrite' => array('slug' => '', 'with_front' => false)
			  ); 
			  
			register_post_type( 'testimonial' , $args);	

			register_taxonomy(
				"testimonial-category", array("testimonial"), array(
					"hierarchical" => true,
					"label" => "Testimonial Categories", 
					"singular_label" => "Testimonial Categories", 
					"rewrite" => true));
			register_taxonomy_for_object_type('testimonial-category', 'testimonial');			
		}
		
		public function theneeds_add_testi_option(){	
		
			add_meta_box('testi-option', __('Testimonial Option','theneeds'),array($this,'theneeds_add_testimonial_option_element'),
				'testimonial', 'normal', 'high');
				
		}
		
		public function theneeds_add_testimonial_option_element(){
			
			foreach($_REQUEST as $keys=>$values){
				$$keys = $values;
			}
			global $post,$countries;
			
			$designation_text 	= get_post_meta($post->ID, 'designation_text', true);
			$instagram_testi 	= get_post_meta($post->ID, 'instagram_testi', true);
			$behance_testi 		= get_post_meta($post->ID, 'behance_testi', true);
			$google_plus_testi 	= get_post_meta($post->ID, 'google_plus_testi', true);
			$twitter_testi 		= get_post_meta($post->ID, 'twitter_testi', true);
			$linkedin_testi 	= get_post_meta($post->ID, 'linkedin_testi', true);
			$facebook_testi 	= get_post_meta($post->ID, 'facebook_testi', true);	
		?>
			<div class="event_options">	
				<div class="op-gap">
					<div class="row-fluid">
						<ul class="designation_class recipe_class span4">
							<li class="panel-input">
								<span class="panel-title">
									<h3> <?php _e('Designation Text', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="designation_text" id="designation_text" value="<?php if($designation_text <> ''){echo esc_attr($designation_text);};?>" />
								<p><?php esc_html_e('Add designation text here.', 'theneeds'); ?></p>
							</li>
						</ul>
						<ul class="instagram_class recipe_class span4">
							<li class="panel-input">
								<span class="panel-title">
									<h3> <?php _e('Instagram', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="instagram_testi" id="instagram_testi" value="<?php if($instagram_testi <> ''){echo esc_url($instagram_testi);};?>" />
								<p><?php esc_html_e('Add Instagram Profile Here.', 'theneeds'); ?></p>
							</li>
						</ul>
						<ul class="behance_class recipe_class span4">
							<li class="panel-input">
								<span class="panel-title">
									<h3> <?php _e('Behance', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="behance_testi" id="behance_testi" value="<?php if($behance_testi <> ''){echo esc_url($behance_testi);};?>" />
								<p><?php esc_html_e('Add Behance Profile Here.', 'theneeds'); ?></p>
							</li>
						</ul>
					</div>
					<div class="row-fluid">
						<ul class="google_plus_class recipe_class span3">
							<li class="panel-input">
								<span class="panel-title">
									<h3> <?php _e('Google Plus', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="google_plus_testi" id="google_plus_testi" value="<?php if($google_plus_testi <> ''){echo esc_url($google_plus_testi);};?>" />
								<p><?php esc_html_e('Add Google Plus Here.', 'theneeds'); ?></p>
							</li>
						</ul>
						<ul class="twitter_class recipe_class span3">
							<li class="panel-input">
								<span class="panel-title">
									<h3> <?php _e('Twitter', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="twitter_testi" id="twitter_testi" value="<?php if($twitter_testi <> ''){echo esc_url($twitter_testi);};?>" />
								<p><?php esc_html_e('Add Twitter Profile Here.', 'theneeds'); ?></p>
							</li>
						</ul>
						<ul class="linkedin_class recipe_class span3">
							<li class="panel-input">
								<span class="panel-title">
									<h3> <?php _e('LinkedIn', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="linkedin_testi" id="linkedin_testi" value="<?php if($linkedin_testi <> ''){echo esc_url($linkedin_testi);};?>" />
								<p><?php esc_html_e('Add LinkedIn Profile Here.', 'theneeds'); ?></p>
							</li>
						</ul>
						<ul class="facebook_class recipe_class span3">
							<li class="panel-input">
								<span class="panel-title">
									<h3> <?php _e('Facebook', 'theneeds'); ?> </h3>
								</span>
								<input type="text" name="facebook_testi" id="facebook_testi" value="<?php if($facebook_testi <> ''){echo esc_url($facebook_testi);};?>" />
								<p><?php esc_html_e('Add Facebook Profile Here.', 'theneeds'); ?></p>
							</li>
						</ul>
					</div>
				</div>
				<input type="hidden" name="testimonial_submit" value="testimonial"/>
			</div>
		<?php }
		
		
		public function save_testimonial_option_meta($post_id){
			
	
			foreach($_REQUEST as $keys=>$values){
				$$keys = $values;
			}
		
			if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;
		
				if(isset($testimonial_submit) AND $testimonial_submit == 'testimonial'){
				
					//Saving Sidebar and Social Sharing Settings as XML
					$old_data = get_post_meta($post_id, 'designation_text',true);
					theneeds_save_meta_data($post_id, $designation_text, $old_data, 'designation_text');
					
					//Saving Sidebar and Social Sharing Settings as XML
					$old_data = get_post_meta($post_id, 'instagram_testi',true);
					theneeds_save_meta_data($post_id, $instagram_testi, $old_data, 'instagram_testi');
					
					//Saving Sidebar and Social Sharing Settings as XML
					$old_data = get_post_meta($post_id, 'google_plus_testi',true);
					theneeds_save_meta_data($post_id, $google_plus_testi, $old_data, 'google_plus_testi');
					
					//Saving Sidebar and Social Sharing Settings as XML
					$old_data = get_post_meta($post_id, 'behance_testi',true);
					theneeds_save_meta_data($post_id, $behance_testi, $old_data, 'behance_testi');
					
					//Saving Sidebar and Social Sharing Settings as XML
					$old_data = get_post_meta($post_id, 'twitter_testi',true);
					theneeds_save_meta_data($post_id, $twitter_testi, $old_data, 'twitter_testi');
					
					//Saving Sidebar and Social Sharing Settings as XML
					$old_data = get_post_meta($post_id, 'linkedin_testi',true);
					theneeds_save_meta_data($post_id, $linkedin_testi, $old_data, 'linkedin_testi');
					
					//Saving Sidebar and Social Sharing Settings as XML
					$old_data = get_post_meta($post_id, 'facebook_testi',true);
					theneeds_save_meta_data($post_id, $facebook_testi, $old_data, 'facebook_testi');
					
				}
		} /* end of function */
		
	}
}	