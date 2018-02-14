<?php
class recent_event_widget extends WP_Widget
{

	public function __construct() { 
	
		$widget_ops = array('classname' => '', 'description' => 'Show Events using this widget' );
		parent::__construct('recent_event_widget', 'CrunchPress : Event Listing Widget', $widget_ops);
	
	}
	
  function form($instance)
  {

    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
	$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $recent_event_category = empty($instance['recent_event_category']) ? ' ' : apply_filters('widget_title', $instance['recent_event_category']);
	$number_of_events = empty($instance['number_of_events']) ? ' ' : apply_filters('widget_title', $instance['number_of_events']);
?>
  <p>
  <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
	 <?php esc_html_e('Title:','theneeds');?>  
	  <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
  </p>
  <p>
  <label for="<?php echo esc_attr($this->get_field_id('recent_event_category')); ?>">
	  <?php esc_html_e('Select Category:','theneeds');?>
	  <select class="widefat" id="<?php echo esc_attr($this->get_field_id('recent_event_category')); ?>" name="<?php echo esc_attr($this->get_field_name('recent_event_category')); ?>" style="width:225px">
		<?php
		
				foreach ( theneeds_get_category_list_array('event-categories') as $category){ ?>
                    <option <?php if(esc_attr($recent_event_category) == $category->term_id){echo 'selected';}?> value="<?php echo esc_attr($category->term_id);?>" >
	                    <?php echo substr(esc_attr($category->name), 0, 20);	if ( strlen($category->name) > 20 ) echo "...";?>
                    </option>						
			<?php }?>
      </select>
  </label>
  </p>  
  <p>
  <label for="<?php echo esc_attr($this->get_field_id('number_of_events')); ?>">
	  <?php esc_html_e('Number of events','theneeds');?>
	<input class="widefat" id="<?php echo esc_attr($this->get_field_id('number_of_events')); ?>" name="<?php echo esc_attr($this->get_field_name('number_of_events')); ?>" type="text" value="<?php echo esc_attr($number_of_events); ?>" />
  </label>
  </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['recent_event_category'] = $new_instance['recent_event_category'];
		$instance['number_of_events'] = $new_instance['number_of_events'];
    return $instance;
  }
 
	function widget($args, $instance)
	{
		
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$recent_event_category = isset( $instance['recent_event_category'] ) ? esc_attr( $instance['recent_event_category'] ) : '';		
		$number_of_events = isset( $instance['number_of_events'] ) ? esc_attr( $instance['number_of_events'] ) : '';		
		if(!isset($number_of_events)){$number_of_events = '-1';}
		
		echo html_entity_decode($before_widget);	
		
		/* Slider 4 Timer CSS */
		wp_enqueue_script('cp-plugin', theneeds_PATH_URL.'/frontend/js/jquery.plugin.min.js', false, '1.0', true);
		
		wp_enqueue_style('cp-countdowncs',theneeds_PATH_URL.'/frontend/css/jquery.countdown.css');
		
		wp_enqueue_script('cp-countdown', theneeds_PATH_URL.'/frontend/js/jquery.countdown.js', false, '1.0', true);
		
		/* WIDGET display CODE Start */
		if (!empty($title))
			echo html_entity_decode($before_title);
			echo esc_attr($title);
			echo html_entity_decode($after_title);

			?>
			<div class="event-widget">
			<ul>
                <?php
				global $EM_Events,$bp;
				/* Get the Set Array of Events those */
				$EM_Events = EM_Events::get( array('category'=>$recent_event_category, 'group'=>'this','scope'=>'future', 'limit' => $number_of_events, 'order' => 'DESC') );
				$events_count = count ( $EM_Events );
		
				if($events_count > 0){ 
					$counter_new = 0;
					foreach ( $EM_Events as $event ) {
					$post_id = $event->post_id;
					$counter_new++;
					$location_address = $event->get_location()->location_address;
					$location_name =  $event->get_location()->location_name; 
									
					/* Get Date in Parts */
						$event_year = date('Y',$event->start);
						$event_month = date('m',$event->start);
						$event_month_alpha = date('M',$event->start);
						$event_day = date('d',$event->start);

						/* Change time format */
						$event_start_time_count = date("G,i,s", strtotime($event->start_time));
						
						/* Event Day and Month */
						
						$event_day = date('d',$event->start);
						
						
						/* Get Dates In Parts */
						
						$event_year_4digit = date('Y',$event->start);
						$event_month = date('m',$event->start);
						
						$event_day = date('d',$event->start);
						
						if(($event->start_time) <> ''){
											  
						 $event_time = date("g:i a", strtotime($event->start_time)) .'-'.  date("g:i a", strtotime($event->end_time));
											  
											
						}
											
					?>

					<li> 
						<strong class="date"><?php echo esc_attr($event_day);?> <span><?php echo esc_attr($event_month_alpha);?>, <?php echo esc_attr($event_year);?></span></strong> 
						<a href="<?php echo esc_url($event->guid);?>"><?php echo esc_attr($event->event_name);?></a> 
						<span class="time"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo esc_attr($event_time);?></span> 
					</li>
					
				<?php } /* end foreach */
				}else{ ?>
					<h3><?php esc_html_e('Please Check If You Have Any Published Upcoming Event.','theneeds');?></h3>
				<?php
				}
				echo '
				</ul>
		 </div>';
		
			
	
	echo html_entity_decode($after_widget);
	
	}
		
}
add_action( 'widgets_init', create_function('', 'return register_widget("recent_event_widget");') );?>