<?php
class theneeds_quick_links_widget extends WP_Widget
{
	
	public function __construct() { 
	
		$widget_ops = array('classname' => 'box', 'description' => 'Display Quick Links Of Post-Types' );
		parent::__construct('theneeds_quick_links_widget', 'CrunchPress : Quick Links Widget', $widget_ops);
	
	}

  function form($instance)
  {

    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
	$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
	$select_post_type = empty($instance['select_post_type']) ? ' ' : apply_filters('widget_title', $instance['select_post_type']);
	$number_of_posts = empty($instance['number_of_posts']) ? ' ' : apply_filters('widget_title', $instance['number_of_posts']);
?>
  <p>
  <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
	 <?php esc_html_e('Title:','theneeds');?> 
	  <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
  </p>
  <p>
  <label for="<?php echo esc_attr($this->get_field_id('select_post_type')); ?>">
	  <?php esc_html_e('Select Post Type:','theneeds');?>
	  <select class="widefat" id="<?php echo esc_attr($this->get_field_id('select_post_type')); ?>" name="<?php echo esc_attr($this->get_field_name('select_post_type')); ?>" style="width:225px">
		<?php
				foreach ( get_post_types( '', 'names' ) as $post_type){ ?>
                    <option <?php if(esc_attr($select_post_type) == ucfirst($post_type)){echo 'selected';}?> value="<?php echo esc_attr(ucfirst($post_type));?>" >
	                    <?php echo substr(esc_attr(ucfirst($post_type)), 0, 20);	if ( strlen(ucfirst($post_type)) > 20 ) echo "...";?>
                    </option>						
			<?php }?>
      </select>
  </label>
  </p>  
  <p>
  <label for="<?php echo esc_attr($this->get_field_id('number_of_posts')); ?>">
	  <?php esc_html_e('Number of Posts To Display','theneeds');?>
	<input class="widefat" id="<?php echo esc_attr($this->get_field_id('number_of_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('number_of_posts')); ?>" type="text" value="<?php echo esc_attr($number_of_posts); ?>" />
  </label>
  </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['select_post_type'] = $new_instance['select_post_type'];
		$instance['number_of_posts'] = $new_instance['number_of_posts'];
    return $instance;
  }
 
	function widget($args, $instance)
	{
		
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$select_post_type = isset( $instance['select_post_type'] ) ? esc_attr( $instance['select_post_type'] ) : '';		
		$number_of_posts = isset( $instance['number_of_posts'] ) ? esc_attr( $instance['number_of_posts'] ) : '';		
		if(!isset($number_of_posts)){$number_of_posts = '-1';}
		echo html_entity_decode($before_widget);	
		
		if (!empty($title))
			echo html_entity_decode($before_title);
			echo esc_attr($title);
			echo html_entity_decode($after_title);


			global $wpdb, $post, $wp_query;
				
				$args = array(
					'posts_per_page'			=> $number_of_posts,
					'post_type'					=> $select_post_type,
					'post_status'				=> 'publish',
					'orderby'					=> 'date',
					'order'						=> 'DESC',
				);
					
				query_posts($args);
				
		
					if ( have_posts() ) { ?>
					
					<div class="doing">
						
						<ul>
  
								<?php /* HTML Markup */
									
									static $counter_news = 0;		
										
										while ( have_posts() ): the_post();
										
											$counter_news++;
		
											echo '<li><a href="'.esc_url(get_the_permalink()).'"><i class="fa fa-arrow-right" aria-hidden="true"></i>'.esc_attr(mb_substr(get_the_title(), 0 , 27)).'...</a></li>';
										
										endwhile; /* end while */
								
									wp_reset_query();
							
								?>
							</ul>
														
						</div>
					
					<?php 
					
					}else{
					
						echo '<h4>'.esc_html__('There is no Recent Post to Show From This Post-Type','theneeds').'</h4>';
					}
			
			echo html_entity_decode($after_widget);
				
	}
		
}
add_action( 'widgets_init', create_function('', 'return register_widget("theneeds_quick_links_widget");') );?>