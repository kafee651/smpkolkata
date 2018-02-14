<?php
class theneeds_contact_info extends WP_Widget
{

	public function __construct() { 
	
		$widget_ops = array('classname' => 'box', 'description' => 'Widget To Display Contact Info' );
		parent::__construct('theneeds_contact_info', 'CrunchPress : Show Contact Info', $widget_ops);
	
	}
	
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $theneeds_title = $instance['title'];
	$theneeds_address = isset( $instance['address'] ) ? esc_attr( $instance['address'] ) : '';
	$theneeds_phone = isset( $instance['phone'] ) ? esc_attr( $instance['phone'] ) : '';
	$theneeds_skype = isset( $instance['skype'] ) ? esc_attr( $instance['skype'] ) : '';
	$theneeds_email = isset( $instance['email'] ) ? esc_attr( $instance['email'] ) : '';
	$theneeds_website = isset( $instance['website'] ) ? esc_attr( $instance['website'] ) : '';
	

	
?>

	<p>
	  <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
		 <?php esc_html_e('Title:','theneeds');?>  
		  <input class="widefat"  id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($theneeds_title); ?>" />
	  </label>
	</p>  

	<p>
	  <label for="<?php echo esc_attr($this->get_field_id('address')); ?>">
		 <?php esc_html_e('Address:','theneeds');?>  
		  <input class="widefat"  id="<?php echo esc_attr($this->get_field_id('address')); ?>" name="<?php echo esc_attr($this->get_field_name('address')); ?>" type="text" value="<?php echo esc_attr($theneeds_address); ?>" />
	  </label>
	</p> 

	<p>
	  <label for="<?php echo esc_attr($this->get_field_id('phone')); ?>">
		 <?php esc_html_e('Phone:','theneeds');?>  
		  <input class="widefat"  id="<?php echo esc_attr($this->get_field_id('phone')); ?>" name="<?php echo esc_attr($this->get_field_name('phone')); ?>" type="text" value="<?php echo esc_attr($theneeds_phone); ?>" />
	  </label>
	</p>

	<p>
	  <label for="<?php echo esc_attr($this->get_field_id('skype')); ?>">
		 <?php esc_html_e('Skype:','theneeds');?>  
		  <input class="widefat"  id="<?php echo esc_attr($this->get_field_id('skype')); ?>" name="<?php echo esc_attr($this->get_field_name('skype')); ?>" type="text" value="<?php echo esc_attr($theneeds_skype); ?>" />
	  </label>
	</p>
  
	<p>
	  <label for="<?php echo esc_attr($this->get_field_id('email')); ?>">
		 <?php esc_html_e('Email:','theneeds');?>  
		  <input class="widefat"  id="<?php echo esc_attr($this->get_field_id('email')); ?>" name="<?php echo esc_attr($this->get_field_name('email')); ?>" type="text" value="<?php echo esc_attr($theneeds_email); ?>" />
	  </label>
	</p>
	
	<p>
	  <label for="<?php echo esc_attr($this->get_field_id('website')); ?>">
		 <?php esc_html_e('Website:','theneeds');?>  
		  <input class="widefat"  id="<?php echo esc_attr($this->get_field_id('website')); ?>" name="<?php echo esc_attr($this->get_field_name('website')); ?>" type="text" value="<?php echo esc_url($theneeds_website); ?>" />
	  </label>
	</p>
	

<?php
  
  }/* end of form function*/
 
  function update($new_instance, $old_instance)
  {

    $instance = $old_instance;
		$instance['title'] 		= $new_instance['title'];
		$instance['address'] 	= $new_instance['address'];
		$instance['phone'] 		= $new_instance['phone'];
		$instance['skype'] 		= $new_instance['skype'];
		$instance['email'] 		= $new_instance['email'];
		$instance['website'] 	= $new_instance['website'];
	
		return $instance;
  
  }/* end of update function */
 
	function widget($args, $instance)
	{
		
		extract($args, EXTR_SKIP);

		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$address = isset( $instance['address'] ) ? esc_attr( $instance['address'] ) : '';
		$phone = isset( $instance['phone'] ) ? esc_attr( $instance['phone'] ) : '';	
		$skype = isset( $instance['skype'] ) ? esc_attr( $instance['skype'] ) : '';	
		$email = isset( $instance['email'] ) ? esc_attr( $instance['email'] ) : '';	
		$website = isset( $instance['website'] ) ? esc_attr( $instance['website'] ) : '';	
		
		echo html_entity_decode($before_widget);	
		
		/* Start WIDGET display CODE Start*/

		if (!empty($title)){
			
			echo html_entity_decode($before_title);
			echo esc_attr($title);
			echo html_entity_decode($after_title);
		}
		?>
		
			<div class="address">
                <ul>
					<?php /* Address */ 
					  if(!empty($address)){ ?>
						<li><i class="fa fa-home" aria-hidden="true"></i> <?php echo esc_attr($address); ?></li>
					<?php } 
					
					/* Phone */
					if(!empty($phone)){ ?>
						<li><i class="fa fa-phone-square" aria-hidden="true"></i><?php echo esc_attr($phone); ?></li>
					<?php } 
					
					 /* skype */
						if(!empty($skype)){ ?>
						 <li><i class="fa fa-skype" aria-hidden="true"></i><?php echo esc_attr($skype);?></li>
					<?php } 
                 
					 /* Email */
						if(!empty($email)){ ?>
							<li><i class="fa fa-envelope-o" aria-hidden="true"></i><a><?php echo esc_attr($email); ?></a></li>
					<?php } 
					
					/* Website */
					  if(!empty($website)){ ?>
						<li><i class="fa fa-globe" aria-hidden="true"></i><a href="<?php echo esc_url($website); ?>"><?php echo esc_url($website); ?></a></li>
					<?php } ?>
                </ul>
            </div>

		<?php 

	
	/* WIDGET display CODE End*/
	echo html_entity_decode($after_widget);
		
		
	}/* end of widegat function */
	
}/* end of theneeds_contact_info class */
	
	
add_action( 'widgets_init', create_function('', 'return register_widget("theneeds_contact_info");') );?>