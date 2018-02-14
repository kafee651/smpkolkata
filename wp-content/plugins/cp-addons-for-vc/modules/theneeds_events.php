<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_events")){
	class theneeds_events{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_events_init"));
			add_shortcode('theneeds_events',array($this,'theneeds_events_shortcode'));
		}
		function theneeds_events_init(){

			if(function_exists("vc_map")){
				
				 $args = array(
					'type'                     => 'event',
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'date',
					'order'                    => 'DESC',
					'hide_empty'               => 1,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => 'event-categories',
					'pad_counts'               => false 
				);
				
				$categories = get_categories( $args ); 				
						
				
				$taxonomies = get_taxonomies();
				
				if($categories){
					$categoryArray[0] = "All";
					foreach($categories as $category_list){
						$categoryArray[$category_list->term_id] = $category_list->name;
					}
				} else {
					$categoryArray = array();
				}
				
				vc_map( array(
					"base" => "theneeds_events",
					"name" => __( "Events", "js_composer" ),
					"class" => "theneeds_events_class",
					"icon" => "theneeds_events_icon",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"params" => array(
					
						array(
								"type" => "dropdown",
								"heading" => __( "Select Style", "js_composer" ),
								"param_name" => "select_style",
								"holder" => "p",
								"value" =>  array( __( 'Slider (Vertical)', 'js_composer' ) => 'slider',
													__( 'List View', 'js_composer' ) => 'list',
													__( 'Block View', 'js_composer' ) => 'block',
													__( 'Small', 'js_composer' ) => 'small'
												),
								"description" => __( "Select Element Style", "js_composer" )
						),
						
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Element Title", "js_composer" ),
							"param_name" => "element_title",
							"description" => __( "Enter Element Title Here", "js_composer" )
						),
						
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Element Caption", "js_composer" ),
							"param_name" => "element_caption",
							"description" => __( "Enter Element Caption Here i.e Slider (Single)", "js_composer" )
						),
						
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Content Length", "js_composer" ),
							"param_name" => "excerpt_length",
							"description" => __( "Enter Excerpt Length Here", "js_composer" )
						),
						
						
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Events Count", "js_composer" ),
							"param_name" => "num_posts",
							"description" => __( "Enter Number of Events To Display", "js_composer" )
						),
						
						array(
							"type" => "dropdown",
							"holder" => "p",
							"heading" => __( "Categories", "js_composer" ),
							"param_name" => "category_name",
							"value" => $categoryArray,
							"description" => __( "Select Category From The Dropdown", "js_composer" )
						),
						
						array(
								'type' => 'vc_link',
								"holder" => "p",
								'heading' => __( 'More Events (Link)', 'js_composer' ),
								'param_name' => 'readmore_url',
								'description' => __( 'Add Link For Button.', 'js_composer' ),
						),
					)
				) );
			}
		}
		
		
		function theneeds_events_shortcode( $atts, $content = null ) {
			
			$result = shortcode_atts( array(

				'select_style' => 'slider',
				'element_title' => '',
				'num_posts' => '6',
				'category_name' => '',
				'excerpt_length' => '',
				'element_caption' => '',
				'readmore_url' => '',
				

			), $atts );
			
			extract( $result );
			
		
			global $wpdb,$post;

			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			
			if($category_name != 'All' && !empty($category_name)){
				
				$term = '';
				
				$term = get_term_by('name', $category_name, 'event-categories');
				
				if(is_object($term)){
				
					$category_id = $term->term_id;
					
					$stack_cat_all = array('tax_query' => array(
							array(
								'taxonomy' => 'event-categories',
								'terms' => $category_id,
								'field' => 'term_id',
							)
						),
					);
					
					$args = array( 
						'post_type' => 'event',
						'posts_per_page' => $num_posts,
						'paged' 			=> $paged,
						'tax_query' => array(
							array(
								'taxonomy' => 'event-categories',
								'terms' => $category_id,
								'field' => 'term_id',
							)
						), 
						'post_status'       => 'publish',
						'orderby' 			=> 'date',
						'order' 			=> 'ASC'
					);
					
				}else{
				
					$args = array( 
						'post_type' 		=> 'event',
						'post_status'       => 'publish',
						'paged' 			=> $paged,
						'posts_per_page' 	=> $num_posts,
						'orderby'		 	=> 'date',
						'order' 			=> 'ASC'
					);
				
				}
			
			}else{
			
				
				$args = array( 
					'post_type' 		=> 'event',
					'post_status'       => 'publish',
					'paged' 			=> $paged,
					'posts_per_page' 	=> $num_posts,
					'orderby'		 	=> 'date',
					'order' 			=> 'ASC'
				);
			
			}
			
			
			query_posts($args);
		
			if($select_style == 'slider'){
			
			/* Slider 4 Timer CSS */
			wp_enqueue_script('cp-plugin', theneeds_PATH_URL.'/frontend/js/jquery.plugin.min.js', false, '1.0', true);
			
			wp_enqueue_style('cp-countdowncs',theneeds_PATH_URL.'/frontend/css/jquery.countdown.css');
			
			wp_enqueue_script('cp-countdown', theneeds_PATH_URL.'/frontend/js/jquery.countdown.js', false, '1.0', true);
			
			/* Bx Slider Script and CSS file  */
		
			wp_enqueue_style('cp-bx-slider',theneeds_PATH_URL.'/frontend/css/jquery.bxslider.css');
			
			wp_enqueue_script( 'cp-bx-slider', theneeds_PATH_URL.'/frontend/js/jquery.bxslider.min.js', false, '1.0', true);
			
				$output = '
					
					<section class="event-style-1">
					  <div class="container">
						<div class="heading-style-1"> <span class="title">'.$element_caption.' </span>
						  <h2>'.$element_title.'</h2>
						</div>
						<div class="row">
						  <div class="col-md-10"> <a href="#" class="plus"><i class="fa fa-plus" aria-hidden="true"></i></a>
							<div id="event-slider">';
			
								if (class_exists('EM_Events')) {
																		 
								global $EM_Events,$bp;
												
								$counter = rand(1,1000);
								
								$order = 'ASC';
								$limit = $num_posts;
								$offset = '';
								$rowno = 0;
								$event_count = 0;
						
								$EM_Events = EM_Events::get( array('category'=>$category_name, 'group'=>'this','scope'=>'future', 'limit' => $limit, 'order' => $order) );
															
								$events_count = count ( $EM_Events );

								if($events_count > 0){
															
									foreach ( $EM_Events as $event ) {
									
										/* International Date Format */
										$localised_start_date = date_i18n(get_option('dbem_date_format'), $event->start);
										$localised_end_date = date_i18n(get_option('dbem_date_format'), $event->end);
										
										$today = date ( "Y-m-d" );
										
										if(!empty($event->location_id->name)){
											$location_summary = "<b>" . $event->get_location()->name . "</b><br/>" . $event->get_location()->address . " - " . $event->get_location()->town;
										}else{
											$location_summary = '';
										}
										
										if ($event->start_date < $today && $event->end_date < $today){
											$class .= " past";
										}
										
										/* Check Event Status */
										if ( !$event->status ){
											$class .= " pending";
										}	
										
										
										/* Event Day and Month */
										$event_month_alpha = date('M',$event->start);
										$event_day = date('d',$event->start);
										
										
										/* Get Dates In Parts */
										$event_year = date('y',$event->start);
										$event_year_4digit = date('Y',$event->start);
										$event_month = date('m',$event->start);
										$event_month_alpha = date('M',$event->start);
										$event_day = date('d',$event->start);
										
										/* Change Time Format */
										if($event->start_time <> ''){
											$event_start_time_count = date("G,i,s", strtotime($event->start_time));
										}
										
										$thumbnail_id = get_post_thumbnail_id( $event->post_id );
										$thumbnail = wp_get_attachment_image_src( $thumbnail_id , array(555,350));
										
										$event_element_id = $counter.$event->event_id; 
									
										$content = str_replace(']]>', ']]&gt;',$event->post_content); 
										
										if(strlen($content >  $excerpt_length)){
										
												$content = mb_substr($content, 0 , $excerpt_length).'...';
												
										}else{
										
												$content = $content;
										}
										
										if(($event->start_time) <> ''){
										  
										  $event_time = date("g:i a", strtotime($event->start_time)) .'-'.  date("g:i a", strtotime($event->end_time));
										  
										
										}
										
										if(!empty($event->get_location()->name)){
										
											$event_location = $event->get_location()->name;
										
										}else{
										
											$event_location = '';
										}
										

										$formatted_event_date =  date(get_option('date_format'),strtotime($event->start_date));
										
										$output .= '
										
											<div class="slide">
												<div class="clearfix">
												  <div class="event-style-1-box">
													<div class="left-box"> <strong class="date">'.$event_day.' <span>'.$event_month_alpha.', '.$event_year.'</span></strong>
													  <div class="holde">
														<h3><a href="'.esc_url($event->guid).'">'.esc_attr($event->event_name).'</a></h3>
														<div class="btn-row"> 
															<a href="'.esc_url($event->guid).'" class="link"><i class="fa fa-user" aria-hidden="true"></i>'.get_the_author().'</a>
															<a href="'.esc_url($event->guid).'" class="link"><i class="fa fa-clock-o" aria-hidden="true"></i>'. $event_time .'</a> 
															<a href="'.esc_url($event->guid).'" class="link"><i class="fa fa-map-marker" aria-hidden="true"></i>'.$event_location.'</a> 
														</div>
														<p>'.$content.'. ...<a href="'.esc_url($event->guid).'">[+]</a></p>
													  </div>
													</div>
													<div class="right-box"> 
														<a href="'.esc_url($event->guid).'" class="btn-detail">'.esc_html__('Buy Tickets','theneeds').'</a> 
														<a href="'.esc_url($event->guid).'" class="btn-detail">'.esc_html__('More Details','theneeds').'</a>
													  <div class="event-style1-timer-box">
														<div class="defaultCountdown-'.$event_element_id.'"></div>
													  </div>
													</div>
												  </div>
												</div>
											</div>'; ?>
											
											<script>
												jQuery(function () {
													var austDay = new Date();
													austDay = new Date(<?php echo esc_html($event_year_4digit);?>, <?php echo esc_html($event_month);?>-1, <?php echo esc_html($event_day);?>,<?php echo esc_html($event_start_time_count);?>)
													jQuery('.defaultCountdown-<?php echo esc_attr($event_element_id);?>').countdown({
														labels: ['<?php esc_html_e('Years','theneeds');?>', '<?php esc_html_e('Months','theneeds');?>', '<?php esc_html_e('Weeks','theneeds');?>', '<?php esc_html_e('Days','theneeds');?>', '<?php esc_html_e('Hours','theneeds');?>', '<?php esc_html_e('MNTS','theneeds');?>', '<?php esc_html_e('SECS','theneeds');?>'],
														until: austDay
													});
													jQuery('#year').text(austDay.getFullYear());
												});                
											</script>
											
										<?php	
	
									} /*end foreach */
											
								}else{

									$output .= '
									
									<div class="section-title orange-border">
					
										<h2>'.esc_attr('No Published Future Event Found','theneeds').'</h2>
									
									</div>';
									
								}
							
							} wp_reset_query(); /* endif */ 
					
						$output .= '
						</div>
					</div>
				  </div>
				</div>
			  </section>';
			
			}
			
	
			if($select_style == 'list'){
			
			
			/* Slider 4 Timer CSS */
			wp_enqueue_script('cp-plugin', theneeds_PATH_URL.'/frontend/js/jquery.plugin.min.js', false, '1.0', true);
			
			wp_enqueue_style('cp-countdowncs',theneeds_PATH_URL.'/frontend/css/jquery.countdown.css');
			
			wp_enqueue_script('cp-countdown', theneeds_PATH_URL.'/frontend/js/jquery.countdown.js', false, '1.0', true);
			
			
				$output = '
				
				<section class="event-style-1 events">
					  <div class="element_wrap">
						<div class="row">
							<div class="col-md-12">';
							if (class_exists('EM_Events')) {
																		 
								global $EM_Events,$bp;
												
								$counter = rand(1,1000);
								
								$order = 'ASC';
								$limit = $num_posts;
								$offset = '';
								$rowno = 0;
								$event_count = 0;
						
								$EM_Events = EM_Events::get( array('category'=>$category_name, 'group'=>'this','scope'=>'future', 'limit' => $limit, 'order' => $order) );
															
								$events_count = count ( $EM_Events );

								if($events_count > 0){
															
									foreach ( $EM_Events as $event ) {
									
										/* International Date Format */
										$localised_start_date = date_i18n(get_option('dbem_date_format'), $event->start);
										$localised_end_date = date_i18n(get_option('dbem_date_format'), $event->end);
										
										$today = date ( "Y-m-d" );
										
										if(!empty($event->location_id->name)){
											$location_summary = "<b>" . $event->get_location()->name . "</b><br/>" . $event->get_location()->address . " - " . $event->get_location()->town;
										}else{
											$location_summary = '';
										}
										
										if ($event->start_date < $today && $event->end_date < $today){
											$class .= " past";
										}
										
										/* Check Event Status */
										if ( !$event->status ){
											$class .= " pending";
										}	
										
										
										/* Event Day and Month */
										$event_month_alpha = date('M',$event->start);
										$event_day = date('d',$event->start);
										
										
										/* Get Dates In Parts */
										$event_year = date('y',$event->start);
										$event_year_4digit = date('Y',$event->start);
										$event_month = date('m',$event->start);
										$event_month_alpha = date('M',$event->start);
										$event_day = date('d',$event->start);
										
										/* Change Time Format */
										if($event->start_time <> ''){
											$event_start_time_count = date("G,i,s", strtotime($event->start_time));
										}
										
										$thumbnail_id = get_post_thumbnail_id( $event->post_id );
										$thumbnail = wp_get_attachment_image_src( $thumbnail_id , array(1140,400));
										
										$event_element_id = $counter.$event->event_id; 
									
										$content = str_replace(']]>', ']]&gt;',$event->post_content); 
										
										if(strlen($content >  $excerpt_length)){
										
												$content = mb_substr($content, 0 , $excerpt_length).'...';
												
										}else{
										
												$content = $content;
										}
										
										if(($event->start_time) <> ''){
										  
										  $event_time = date("g:i a", strtotime($event->start_time)) .'-'.  date("g:i a", strtotime($event->end_time));
										  
										
										}
										
										if(!empty($event->get_location()->name)){
										
											$event_location = $event->get_location()->name;
										
										}else{
										
											$event_location = '';
										}
										

										$formatted_event_date =  date(get_option('date_format'),strtotime($event->start_date));
										
										$output .= '
										
										<div class="event-style-1-box">
										  <div class="left-box"> <strong class="date">'.$event_day.' <span>'.$event_month_alpha.', '.$event_year.'</span></strong>
											<div class="holde">
											  <h3><a href="'.esc_url($event->guid).'">'.esc_attr($event->event_name).'</a></h3>
											  <div class="btn-row"> 
												<a href="'.esc_url($event->guid).'" class="link"><i class="fa fa-user" aria-hidden="true"></i>'.get_the_author().'</a> 
												<a href="'.esc_url($event->guid).'" class="link"><i class="fa fa-clock-o" aria-hidden="true"></i>'. $event_time .'</a> 
												<a href="'.esc_url($event->guid).'" class="link"><i class="fa fa-map-marker" aria-hidden="true"></i>'.$event_location.'</a> 
											  </div>
											  <p>'.$content.' <a href="'.esc_url($event->guid).'">[+]</a></p>
											</div>
										  </div>
										  <div class="right-box"> 
											<a href="'.esc_url($event->guid).'" class="btn-detail">'.esc_html__('Buy Tickets','theneeds').'</a> 
											<a href="'.esc_url($event->guid).'" class="btn-detail">'.esc_html__('More Details','theneeds').'</a>
											<div class="event-style1-timer-box">
											  <div class="defaultCountdown-'.$event_element_id.'"></div>
											</div>
										   </div>
										</div>'; ?>
										
									
										
										<script>
											jQuery(function () {
												var austDay = new Date();
												austDay = new Date(<?php echo esc_html($event_year_4digit);?>, <?php echo esc_html($event_month);?>-1, <?php echo esc_html($event_day);?>,<?php echo esc_html($event_start_time_count);?>)
												jQuery('.defaultCountdown-<?php echo esc_attr($event_element_id);?>').countdown({
													labels: ['<?php esc_html_e('Years','theneeds');?>', '<?php esc_html_e('Months','theneeds');?>', '<?php esc_html_e('Weeks','theneeds');?>', '<?php esc_html_e('Days','theneeds');?>', '<?php esc_html_e('Hours','theneeds');?>', '<?php esc_html_e('MNTS','theneeds');?>', '<?php esc_html_e('SECS','theneeds');?>'],
													until: austDay
												});
												jQuery('#year').text(austDay.getFullYear());
											});                
										</script>
										
										<?php
										
									} /*end foreach */
											
								}else{

									$output .= '
									
									<div class="section-title orange-border">
					
										<h3>'.esc_attr('No Published Future Event Found','theneeds').'</h3>
									
									</div>';
									
								}
							
							} wp_reset_query(); /* endif */ 
					
						$output .= '
					</div>
				  </div>
				</div>
			  </section>';
			
			}
			
			if($select_style == 'block'){
			
			
			/* Slider 4 Timer CSS */
			wp_enqueue_script('cp-plugin', theneeds_PATH_URL.'/frontend/js/jquery.plugin.min.js', false, '1.0', true);
			
			wp_enqueue_style('cp-countdowncs',theneeds_PATH_URL.'/frontend/css/jquery.countdown.css');
			
			wp_enqueue_script('cp-countdown', theneeds_PATH_URL.'/frontend/js/jquery.countdown.js', false, '1.0', true);
			
			
				$output = '
				
				<section class="event-style-1 events event-list">
					  <div class="element_wrap">
						<div class="row">
							<div class="col-md-12">';
							if (class_exists('EM_Events')) {
																		 
								global $EM_Events,$bp;
												
								$counter = rand(1,1000);
								
								$order = 'ASC';
								$limit = $num_posts;
								$offset = '';
								$rowno = 0;
								$event_count = 0;
						
								$EM_Events = EM_Events::get( array('category'=>$category_name, 'group'=>'this','scope'=>'future', 'limit' => $limit, 'order' => $order) );
															
								$events_count = count ( $EM_Events );

								if($events_count > 0){
															
									foreach ( $EM_Events as $event ) {
									
										/* International Date Format */
										$localised_start_date = date_i18n(get_option('dbem_date_format'), $event->start);
										$localised_end_date = date_i18n(get_option('dbem_date_format'), $event->end);
										
										$today = date ( "Y-m-d" );
										
										if(!empty($event->location_id->name)){
											$location_summary = "<b>" . $event->get_location()->name . "</b><br/>" . $event->get_location()->address . " - " . $event->get_location()->town;
										}else{
											$location_summary = '';
										}
										
										if ($event->start_date < $today && $event->end_date < $today){
											$class .= " past";
										}
										
										/* Check Event Status */
										if ( !$event->status ){
											$class .= " pending";
										}	
										
										
										/* Event Day and Month */
										$event_month_alpha = date('M',$event->start);
										$event_day = date('d',$event->start);
										
										
										/* Get Dates In Parts */
										$event_year = date('y',$event->start);
										$event_year_4digit = date('Y',$event->start);
										$event_month = date('m',$event->start);
										$event_month_alpha = date('M',$event->start);
										$event_day = date('d',$event->start);
										
										/* Change Time Format */
										if($event->start_time <> ''){
											$event_start_time_count = date("G,i,s", strtotime($event->start_time));
										}
										
										$thumbnail_id = get_post_thumbnail_id( $event->post_id );
										$thumbnail = wp_get_attachment_image_src( $thumbnail_id , array(1140,400));
										
										$event_element_id = $counter.$event->event_id; 
									
										$content = str_replace(']]>', ']]&gt;',$event->post_content); 
										
										if(strlen($content >  $excerpt_length)){
										
												$content = mb_substr($content, 0 , $excerpt_length).'...';
												
										}else{
										
												$content = $content;
										}
										
										if(($event->start_time) <> ''){
										  
										  $event_time = date("g:i a", strtotime($event->start_time)) .'-'.  date("g:i a", strtotime($event->end_time));
										  
										
										}
										
										if(!empty($event->get_location()->name)){
										
											$event_location = $event->get_location()->name;
										
										}else{
										
											$event_location = '';
										}
										

										$formatted_event_date =  date(get_option('date_format'),strtotime($event->start_date));
										
										$output .= '
										
										<div class="event-style-1-box">
										  <div class="thumb"> '.get_the_post_thumbnail($event->post_id, array(390,320)).' </div>
										  <div class="outer">
											<div class="left-box"> <strong class="date">'.$event_day.' <span>'.$event_month_alpha.', '.$event_year.'</span></strong>
											  <div class="holde">
												<h3><a href="'.esc_url($event->guid).'">'.esc_attr($event->event_name).'</a></h3>
												<div class="btn-row"> 
													<a href="'.esc_url($event->guid).'" class="link"><i class="fa fa-user" aria-hidden="true"></i>'.get_the_author().'</a>
													<a href="'.esc_url($event->guid).'" class="link"><i class="fa fa-clock-o" aria-hidden="true"></i>'. $event_time .'</a> 
												</div>
												<p>'.$content.'<a href="'.esc_url($event->guid).'">[+]</a></p>
												<div class="right-box">
												  <div class="event-style1-timer-box">
													<div class="defaultCountdown-'.$event_element_id.'"></div>
												  </div>
												  <a href="'.esc_url($event->guid).'" class="btn-detail">'.esc_html__('Buy Tickets','theneeds').'</a> 
												  <a href="'.esc_url($event->guid).'" class="btn-detail">'.esc_html__('More Details','theneeds').'</a>
												  </div>
											  </div>
											</div>
										  </div>
										</div>';
										
										?>
										
									
										
										<script>
											jQuery(function () {
												var austDay = new Date();
												austDay = new Date(<?php echo esc_html($event_year_4digit);?>, <?php echo esc_html($event_month);?>-1, <?php echo esc_html($event_day);?>,<?php echo esc_html($event_start_time_count);?>)
												jQuery('.defaultCountdown-<?php echo esc_attr($event_element_id);?>').countdown({
													labels: ['<?php esc_html_e('Years','theneeds');?>', '<?php esc_html_e('Months','theneeds');?>', '<?php esc_html_e('Weeks','theneeds');?>', '<?php esc_html_e('Days','theneeds');?>', '<?php esc_html_e('Hours','theneeds');?>', '<?php esc_html_e('MNTS','theneeds');?>', '<?php esc_html_e('SECS','theneeds');?>'],
													until: austDay
												});
												jQuery('#year').text(austDay.getFullYear());
											});                
										</script>
										
										<?php
										
									} /*end foreach */
											
								}else{

									$output .= '
									
									<div class="section-title orange-border">
					
										<h3>'.esc_attr('No Published Future Event Found','theneeds').'</h3>
									
									</div>';
									
								}
							
							} wp_reset_query(); /* endif */ 
					
						$output .= '
					</div>
				  </div>
				</div>
			  </section>';
			
			}
			
			if($select_style == 'small'){
			
			/* Slider 4 Timer CSS */
			wp_enqueue_script('cp-plugin', theneeds_PATH_URL.'/frontend/js/jquery.plugin.min.js', false, '1.0', true);
			
			wp_enqueue_style('cp-countdowncs',theneeds_PATH_URL.'/frontend/css/jquery.countdown.css');
			
			wp_enqueue_script('cp-countdown', theneeds_PATH_URL.'/frontend/js/jquery.countdown.js', false, '1.0', true);
	
				$output = '
				
				 <section class="event-section event-small">
				  <div class="element_wrap">
					<div class="upcoming-event-box">
					  <div class="row">';
							if (class_exists('EM_Events')) {
																		 
								global $EM_Events,$bp;
												
								$counter = rand(1,1000);
								
								$order = 'ASC';
								$limit = $num_posts;
								$offset = '';
								$rowno = 0;
								$event_count = 0;
						
								$EM_Events = EM_Events::get( array('category'=>$category_name, 'group'=>'this','scope'=>'future', 'limit' => $limit, 'order' => $order) );
															
								$events_count = count ( $EM_Events );

								if($events_count > 0){
															
									foreach ( $EM_Events as $event ) {
									
										/* International Date Format */
										$localised_start_date = date_i18n(get_option('dbem_date_format'), $event->start);
										$localised_end_date = date_i18n(get_option('dbem_date_format'), $event->end);
										
										$today = date ( "Y-m-d" );
										
										if(!empty($event->location_id->name)){
											$location_summary = "<b>" . $event->get_location()->name . "</b><br/>" . $event->get_location()->address . " - " . $event->get_location()->town;
										}else{
											$location_summary = '';
										}
										
										if ($event->start_date < $today && $event->end_date < $today){
											$class .= " past";
										}
										
										/* Check Event Status */
										if ( !$event->status ){
											$class .= " pending";
										}	
										
										
										/* Event Day and Month */
										$event_month_alpha = date('M',$event->start);
										$event_day = date('d',$event->start);
										
										
										/* Get Dates In Parts */
										$event_year = date('y',$event->start);
										$event_year_4digit = date('Y',$event->start);
										$event_month = date('m',$event->start);
										$event_month_alpha = date('M',$event->start);
										$event_day = date('d',$event->start);
										
										/* Change Time Format */
										if($event->start_time <> ''){
											$event_start_time_count = date("G,i,s", strtotime($event->start_time));
										}
										
										$thumbnail_id = get_post_thumbnail_id( $event->post_id );
										$thumbnail = wp_get_attachment_image_src( $thumbnail_id , array(1140,400));
										
										$event_element_id = $counter.$event->event_id; 
									
										$content = str_replace(']]>', ']]&gt;',$event->post_content); 
										
										if(strlen($content >  $excerpt_length)){
										
												$content = mb_substr($content, 0 , $excerpt_length).'...';
												
										}else{
										
												$content = $content;
										}
										
										if(($event->start_time) <> ''){
										  
										  $event_time = date("g:i a", strtotime($event->start_time)) .'-'.  date("g:i a", strtotime($event->end_time));
										  
										
										}
										
										if(!empty($event->get_location()->name)){
										
											$event_location = $event->get_location()->name;
										
										}else{
										
											$event_location = '';
										}
										

										$formatted_event_date =  date(get_option('date_format'),strtotime($event->start_date));
										
										$output .= '
										
										<div class="col-md-4 col-sm-6">
										  <div class="outer"> <strong class="date">'.$event_day.' <span>'.$event_month_alpha.'. '.$event_year.'</span></strong>
											<div class="frame">
											  <div class="caption">
												<div class="event-counter-box">
												   <div class="defaultCountdown-'.$event_element_id.'"></div>
												</div>
											  </div>
											   '.get_the_post_thumbnail($event->post_id, array(340,220)).' 
											</div>
										  </div>
										  <div class="text-box">
											<h3><a href="'.esc_url($event->guid).'">'.esc_attr(mb_substr($event->event_name, 0 , 31)).'...</a></h3>
											<div class="tags-row"> 
												<a href="'.esc_url($event->guid).'" class="link"><i class="fa fa-clock-o" aria-hidden="true"></i>'. $event_time .'</a> 
												<a href="'.esc_url($event->guid).'" class="link"><i class="fa fa-map-marker" aria-hidden="true"></i>'.$event_location.'.</a> 
											</div>
											<a href="'.esc_url($event->guid).'" class="btn-readmore">'.esc_html__('Read Event Detail','theneeds').'</a> 
											<a href="'.esc_url($event->guid).'" class="btn-readmore">'.esc_html__('Get Invitation','theneeds').'</a> 
									      </div>
										</div>';
										?>
									
										
										<script>
											jQuery(function () {
												var austDay = new Date();
												austDay = new Date(<?php echo esc_html($event_year_4digit);?>, <?php echo esc_html($event_month);?>-1, <?php echo esc_html($event_day);?>,<?php echo esc_html($event_start_time_count);?>)
												jQuery('.defaultCountdown-<?php echo esc_attr($event_element_id);?>').countdown({
													labels: ['<?php esc_html_e('Years','theneeds');?>', '<?php esc_html_e('Months','theneeds');?>', '<?php esc_html_e('Weeks','theneeds');?>', '<?php esc_html_e('Days','theneeds');?>', '<?php esc_html_e('Hours','theneeds');?>', '<?php esc_html_e('MNTS','theneeds');?>', '<?php esc_html_e('SECS','theneeds');?>'],
													until: austDay
												});
												jQuery('#year').text(austDay.getFullYear());
											});                
										</script>
										
										<?php
										
									} /*end foreach */
											
								}else{

									$output .= '
									
									<div class="section-title orange-border">
					
										<h3>'.esc_attr('No Published Future Event Found','golfclub').'</h3>
									
									</div>';
									
								}
							
							} wp_reset_query(); /* endif */ 
					
						$output .= '
					</div>';
					if(!empty($readmore_url_link) || !empty($readmore_text)){
						$output .= '<div class="btn-row"><a href="'.$readmore_url_link.'" class="btn-style-1">'.$readmore_text.'</a></div>';
					}
					$output .= '
				  </div>
				</div>
			  </section>';
			
			}
	
			return $output;

			wp_reset_postdata();
				

		} /* OutPut Function Ends Here */
		
		
	} /* class ends here */
	
	new theneeds_events;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_events extends WPBakeryShortCode {
		}
	}
}