<?php 
/* custom post type for Awards */
function theneeds_award() {
			
			$labels = array(
				'name' => _x('Awards', 'Awards General Name', 'theneeds'),
				'singular_name' => _x('Award', 'Award Singular Name', 'theneeds'),
				'add_new' => _x('Add New', 'Add New Award Name', 'theneeds'),
				'add_new_item' => __('Add New Award', 'theneeds'),
				'edit_item' => __('Edit Award', 'theneeds'),
				'new_item' => __('New Award', 'theneeds'),
				'view_item' => __('View Award', 'theneeds'),
				'search_items' => __('Search Award', 'theneeds'),
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
				'menu_icon' => 'dashicons-awards',
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => 100,
				'supports' => array('title','editor','author','thumbnail','comments'),
				'has_archive' => true,
				'rewrite' => array('slug' => '', 'with_front' => false)
			  ); 
			  
			register_post_type( 'award' , $args);	

			register_taxonomy(
				"award-category", array("award"), array(
					"hierarchical" => true,
					"label" => "Award Categories", 
					"singular_label" => "Award Category", 
					"rewrite" => true));
			register_taxonomy_for_object_type('award-category', 'award');			
		}
		
		add_action( 'init', 'theneeds_award' );

?>