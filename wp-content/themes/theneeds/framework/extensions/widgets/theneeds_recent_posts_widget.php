<?php
class theneeds_recent_posts_widget extends WP_Widget
{
 

	public function __construct() { 
	
		$widget_ops = array('classname' => '', 'description' => 'Select Widget To Display Recent Posts' );
		parent::__construct('theneeds_recent_posts_widget', 'CrunchPress : Show Recent Posts', $widget_ops);
	
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
		// WIDGET display CODE Start

		if (!empty($title))
			echo html_entity_decode($before_title);
			echo esc_attr($title);
			echo html_entity_decode($after_title);
			
			?>       
			<div class="recent-widget">
				<ul>      
				<?php
				
				$category_array = get_term_by('id', esc_attr($get_cate_posts), 'category');
				
				$popularpost = new WP_Query( array( 'ignore_sticky_posts' => true,'posts_per_page' => $nop, 'post_type'=> 'post', 'orderby' => 'date', 'order' => 'DESC'  ) );
					
					while ( $popularpost->have_posts() ) : $popularpost->the_post(); global $post;
					

					?>
					<!-- Widget Popular Post Code -->
					
					<li>
                        <div class="thumb"><a href="<?php echo esc_url(get_the_permalink());?>"><?php echo get_the_post_thumbnail($post->ID, array(67,67));?></a></div>
                        <div class="text-col"> 
							<a href="<?php echo esc_url(get_the_permalink());?>">
								<?php  
									$title = get_the_title();
									if (strlen($title) < 36){ 
										$title = esc_attr(get_the_title());
									}
									else {
										$title = esc_attr(substr((get_the_title()),0,45));
									}
									
									echo wordwrap(ucwords($title),20, "<br />\n");
								?>
							</a>
							<span class="date"><i class="fa fa-calendar" aria-hidden="true"></i><?php echo esc_attr(get_the_date(get_option('date_format')));?></span> 
						</div>
                    </li>
					 
					<?php  endwhile; wp_reset_postdata(); ?>				
				</ul>
			</div>
		
<?php  	
	

	echo html_entity_decode($after_widget);
		}
	}
add_action( 'widgets_init', create_function('', 'return register_widget("theneeds_recent_posts_widget");') );?>