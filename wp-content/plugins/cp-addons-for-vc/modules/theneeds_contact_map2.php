<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_contact_map2")){
	class theneeds_contact_map2{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_contact_map2_init"));
			add_shortcode('theneeds_contact_map2',array($this,'theneeds_contact_map2_shortcode'));
		}
		function theneeds_contact_map2_init(){

			if(function_exists("vc_map")){
				
				
				vc_map( array(
					"base" => "theneeds_contact_map2",
					"name" => __( "Map + Contact 2", "js_composer" ),
					"class" => "theneeds_contact_map2_class",
					"icon" => "theneeds_contact_map2_icon",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"params" => array(
					
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Enter Map Location Latitude", "js_composer" ),
								"param_name" => "location_lat",
								"description" => __( "Enter Location Latitude Here i.e 48.85661", "js_composer" )
							),
							
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Enter Map Location Logitude", "js_composer" ),
								"param_name" => "location_long",
								"description" => __( "Enter Location Logitude Here i.e 2.35222", "js_composer" )
							),		
					
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Form Title", "js_composer" ),
								"param_name" => "element_title",
								"description" => __( "Enter Element Form Title Here", "js_composer" )
							),
							
							array(
								'type' => 'attach_image',
								"holder" => "p",
								'heading' => __( 'Image', 'js_composer' ),
								'param_name' => 'bg_image',
								'value' => '',
								'description' => __( 'Add Image Here.', 'js_composer' )
							),
							
							array(
								"type" => "textarea",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Add Description", "js_composer" ),
								"param_name" => "description_html",
								"description" => __( "Enter Description For Contact Details Here", "js_composer" )
							),

							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Add Address", "js_composer" ),
								"param_name" => "address",
								"description" => __( "Enter Contact Address Here", "js_composer" )
							),
							
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Add Phone", "js_composer" ),
								"param_name" => "phone",
								"description" => __( "Enter Contact Phone Here", "js_composer" )
							),
							
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Add Fax", "js_composer" ),
								"param_name" => "fax",
								"description" => __( "Enter Contact Fax Here", "js_composer" )
							),
							
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Add Web", "js_composer" ),
								"param_name" => "web",
								"description" => __( "Enter Web Address Here", "js_composer" )
							),
							
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Add Email Address", "js_composer" ),
								"param_name" => "email",
								"description" => __( "Enter Email Address Here", "js_composer" )
							),

							array(
								"type" => "textarea_html",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Add Contact Form 7 Shortcode", "js_composer" ),
								"param_name" => "content",
								"description" => __( "Add Contact Form 7 Shortcode Here", "js_composer" )
							),							
				
						)
					) 
				);
			}
		}
		
		
		function theneeds_contact_map2_shortcode( $atts, $content = null ) {
		
			$result = shortcode_atts( array(
				
				'element_title' => '',
				'address' => '',
				'phone' => '',
				'fax' => '',
				'email' => '',
				'web' => '',
				'location_lat' => '',
				'location_long' => '',
				'description_html' => '',
				'bg_image' => '',
				
			), $atts );

			extract( $result );
			
			/* Background Image */
				
			$bg_image = wpb_getImageBySize( array( 'attach_id' => $bg_image, 'thumb_size' => '100', 'class' => 'vc_single_image-img' ) );
			
			$bg_image =  $bg_image['p_img_large'][0];
			
		
			if(!empty($location_lat)){ $location_lat =  esc_attr($location_lat); }else{ $location_lat = ''; }
			
			if(!empty($location_long)){ $location_long =  esc_attr($location_long); }else{ $location_long = ''; }
			
			$output = '';
			
			if(function_exists('theneeds_get_themeoption_value')){
				
				$theneeds_google_api_key = '';
			
				$theneeds_google_api_key = theneeds_get_themeoption_value('google_map_api','general_settings'); 
			
				if(!empty($theneeds_google_api_key)){ ?>

					<script src="http://maps.googleapis.com/maps/api/js?key=<?php echo esc_attr($theneeds_google_api_key); ?>"></script>
					<script>
						jQuery(document).ready(function($) {
							"use strict";
							if ($('#map_contact_1').length) {
								var map;
								var myLatLng = new google.maps.LatLng(<?php echo esc_attr($location_lat);?>, <?php echo esc_attr($location_long);?>);
								//Initialize MAP
								 var myOptions = {
									zoom: 11,
									center: myLatLng,
									//disableDefaultUI: true,
									zoomControl: true,
									mapTypeId: google.maps.MapTypeId.ROADMAP,
									mapTypeControl: false,
									scrollwheel: false,
									styles: [{
										stylers: [{
											hue: '#cacaca'
										}, {
											saturation: -100,
										}, {
											lightness: 10
										}]
									}],
								}
								map = new google.maps.Map(document.getElementById('map_contact_1'), myOptions);
								//End Initialize MAP
								//Set Marker
								var marker = new google.maps.Marker({
									// zoom: 7,
									position: map.getCenter(),
									map: map,
									
								});
								marker.getPosition();
								//End marker
							}
						});
					</script>
					<?php
				}
			}

					$output = '
					
						<section class="contact-section">';
						
							/* If Not Empty Map Lat Long API KEY */
							if(!empty($theneeds_google_api_key) && !empty($location_lat) && !empty($location_long)){
								
								$output .= '
								
								 <div class="contact-map">
									<div id="map_contact_1" class="map_canvas active"></div>
								  </div>';
							
							}else{
								
								$output .= '
								 
								 <div class="contact-map">
									<div class="map_canvas">
										<h3>'.esc_html__('Please Enter Correct Map Details i.e API Key, Latitude, Longitude','theneeds').'</h3>
									</div>
								  </div>';
								
							}
					
							 $output .= '
							 
							 <div class="contact-2">
								<div class="container">
								  <div class="contact-2-address">
									<div class="heading-col">
									  <h2>'.$element_title.'</h2>
									</div>
									<div class="img-col"><img src="'.esc_url($bg_image).'" alt="'.esc_html__('img','theneeds').'"></div>
									<div class="address-col">
									  <p>'.$description_html.'</p>
									  <ul>
										<li> <i class="fa fa-paper-plane" aria-hidden="true"></i>
										  <p>'.$address.'</p>
										</li>
										<li> <i class="fa fa-phone" aria-hidden="true"></i>
										  <p>'.$phone.' <span>'.$fax.'</span></p>
										</li>
										<li> <i class="fa fa-envelope" aria-hidden="true"></i>
										  <p><a href="mailto:'.is_email($email).'">'.is_email($email).'</a></p>
										  <p><a href="'.esc_url($web).'">'.esc_url($web).'</a></p>
										</li>
									  </ul>
									</div>
								  </div>
								  <div class="contact-form">
									'.do_shortcode($content).'
								  </div>
								</div>
							  </div>
							</section>';
	

			return $output;

		} /* end of function */
		
		
	}
	
	new theneeds_contact_map2;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_contact_map2 extends WPBakeryShortCode {
		}
	}
}