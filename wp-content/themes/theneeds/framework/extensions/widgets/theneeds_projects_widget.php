<?php
class theneeds_projects_widget extends WP_Widget
{
	public function __construct() { 
	
		$widget_ops = array('classname' => '', 'description' => 'Select Project Category To Show Posts' );
		parent::__construct('theneeds_projects_widget', 'CrunchPress : Show Projects', $widget_ops);
	
	}
	

  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
	$get_cate_posts = isset( $instance['get_cate_posts'] ) ? esc_attr( $instance['get_cate_posts'] ) : '';
	$nop = isset( $instance['nop'] ) ? esc_attr( $instance['nop'] ) : '';
?>
	<p>
	  <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
		 <?php esc_html_e('Title:','theneeds');?>  
		  <input class="widefat"  id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
	  </label>
	</p>   
  
	<p>
	  <label for="<?php echo esc_attr($this->get_field_id('get_cate_posts')); ?>">
		  <?php esc_html_e('Select Category:','theneeds');?>
		  <select id="<?php echo esc_attr($this->get_field_id('get_cate_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('get_cate_posts')); ?>" class="widefat">
			<?php
					foreach ( theneeds_get_category_list_array('projects-categories') as $category){ ?>
						<option <?php if(esc_attr($get_cate_posts) == $category->slug){echo 'selected';}?> value="<?php echo esc_attr($category->slug);?>" >
							<?php echo substr($category->name, 0, 20);	if ( strlen($category->name) > 20 ) echo "...";?>
						</option>						
				<?php }?>
		  </select>
	  </label>
	 </p> 
	 
	<p>
	  <label for="<?php echo esc_attr($this->get_field_id('nop')); ?>">
		 <?php esc_html_e('Number of Posts To Display:','theneeds');?> 
		  <input class="widefat" size="2" id="<?php echo esc_attr($this->get_field_id('nop')); ?>" name="<?php echo esc_attr($this->get_field_name('nop')); ?>" type="text" value="<?php echo esc_attr($nop); ?>" />
	  </label>
	</p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
  
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['get_cate_posts'] = $new_instance['get_cate_posts'];	
	$instance['nop'] = $new_instance['nop'];
    return $instance;
  }
 
	function widget($args, $instance)
	{
		
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$get_cate_posts = isset( $instance['get_cate_posts'] ) ? esc_attr( $instance['get_cate_posts'] ) : '';		
		$nop = isset( $instance['nop'] ) ? esc_attr( $instance['nop'] ) : '';	
	
		if($nop == ""){$nop = '-1';}
		
		echo html_entity_decode($before_widget);	
	

			echo html_entity_decode($before_title);
			
			echo esc_attr($title);
			
			echo html_entity_decode($after_title);
			
			global $wpdb;
			
			/* Owl Scripts */
			wp_enqueue_script( 'cp-owl', theneeds_PATH_URL.'/frontend/js/owl.carousel.min.js', false, '1.0', true);

			wp_enqueue_style('cp-owl',theneeds_PATH_URL.'/frontend/css/owl.carousel.css');
		    
                 
			echo '<div class="recent-news">
					
					<div id="recent-slider" class="owl-carousel">';
			
						$category_array = get_term_by('id', esc_attr($get_cate_posts), 'category');
				
						$popularpost = new WP_Query( 
							array( 'ignore_sticky_posts' 	=> false,
									'posts_per_page' 		=> $nop, 
									'post_type'				=> 'projects', 
									'meta_key' 				=> 'popular_post_views_count', 
									'orderby' 				=> 'popular_post_views_count meta_value_num', 
									'order'					=> 'DESC'  
								) 
						);
				
						while ( $popularpost->have_posts() ) : $popularpost->the_post(); global $post;
						
						/* Get Post Meta Elements detail */
						$theneeds_projects_detail_xml = get_post_meta($post->ID, 'theneeds_projects_detail_xml', true);
						
						if($theneeds_projects_detail_xml <> ''){
						
							$theneeds_project_caption_xml = new DOMDocument ();

							$theneeds_project_caption_xml->loadXML ( $theneeds_projects_detail_xml );
							
							$theneeds_project_caption = theneeds_find_xml_value($theneeds_project_caption_xml->documentElement,'theneeds_project_caption');
							
						}
						
						echo '
						
						 <div class="item">
							<div class="frame">'.get_the_post_thumbnail($post->ID, array(265,250)).'</div>
							<a href="'.esc_attr(get_the_permalink()).'" class="link">'.esc_attr(get_the_title()).'</a> 
						</div>';

						endwhile; wp_reset_postdata();
					echo '
					
					</div>
				
				</div>';

			echo html_entity_decode($after_widget);	
	}
}
add_action( 'widgets_init', create_function('', 'return register_widget("theneeds_projects_widget");') );?>