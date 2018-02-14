<?php
if(class_exists('theneeds_function_library')){
	
	class theneeds_shortcode extends theneeds_function_library{
		
		public $div_start = array(
		
			/* Yet To Be Implemented */
		);
		
		public $div_end = array(
		
			/* Yet To Be Implemented */

		);
	
		public $service_variable = array(

			/* Yet To Be Implemented */
		);

				
		public $accordion_var = array(
		
			/* Yet To Be Implemented */

		);
		
		
		public $sidebar_section = array(
		
			/* Yet To Be Implemented */		

		);


		public $column_var = array(
		
			/* Yet To Be Implemented */	

		);


		public $divider_var = array(
		
			/* Yet To Be Implemented */	
			
		);

		public $tab_variable = array(
		
			/* Yet To Be Implemented */	
		);				

		public $toggle_box = array(

			/* Yet To Be Implemented */	

		);
	
		
		public $toggle_size_array = array( );
		
		public $tab_size_array = array( );	
		
		public $divider_size_array = array( );
		
		public $div_start_size = array( );
	
		public $div_end_size = array( );
		
		public $column_size_array = array( );
		
		public $accordion_size_array = array( );
		
		public $sidebar_size_array = array( );		
		
		public $service_size_array = array( );	
			
		public function page_builder_size_class(){
		
			global $div_size;
			
			/* Yet To Be Implemented */
		}
		
		
		public function page_builder_element_class(){
			
			global $page_meta_boxes;
			
			/* Yet To Be Implemented */
		}
		
		public function theneeds_layer_slider_title(){
			if(class_exists('LS_Sliders')){
				if(function_exists('layerslider_activation_scripts')){
					global $wpdb;
					$table_name = $wpdb->prefix . "layerslider";
						$sliders = $wpdb->get_results( "SELECT * FROM $table_name
							WHERE flag_hidden = '0' AND flag_deleted = '0'
							ORDER BY date_c ASC LIMIT 100" );
					if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$table_name."'"))==1) {
						foreach($sliders as $keys=>$values){
							$post_title[] = $values->name;
											
						}
						return $post_title;
					}
				}
			}
		}	
		
		/* Return the Id of each slide added in layerslider */
		public function theneeds_layer_slider_id(){
			if(class_exists('LS_Sliders')){
				if(function_exists('layerslider_activation_scripts')){
					global $wpdb,$post_id_slider;
					$post_id_slider = '';
					$table_name = $wpdb->prefix . "layerslider";
					$sliders = $wpdb->get_results( "SELECT * FROM $table_name
						WHERE flag_hidden = '0' AND flag_deleted = '0'
						ORDER BY date_c ASC LIMIT 100" );
					if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$table_name."'"))==1) {
						foreach($sliders as $keys=>$values){
							$post_id_slider[] = $values->id;
											
						}
						return $post_id_slider;
					}			
				} /* Scripts are activated */
			} /* Check Layer Class Exists */
		} /* Get LayerSlider Id */
		
		
		/* Rev Slider Function Moved From Super Object */
		public function theneeds_print_revolution_slider(){
			
			global $wpdb,$post;
		
			$revolution_slider = get_post_meta ( $post->ID, "page-option-top-slider-revolution", true );
			
			$post_rev_slider = '';
			$table_name = $wpdb->prefix . "revslider_sliders";
			$revsliders = $wpdb->get_row( "SELECT * FROM $table_name where id = '$revolution_slider'" );

			putRevSlider($revsliders->alias);
		}
	
	
	
	}
	
	$theneeds_shortcode = new theneeds_shortcode;
}
?>