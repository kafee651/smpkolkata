<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_join_us")){
	class theneeds_join_us{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_join_us_init"));
			add_shortcode('theneeds_join_us',array($this,'theneeds_join_us_shortcode'));
		}
		function theneeds_join_us_init(){

			if(function_exists("vc_map")){

				vc_map( array(
					"base" => "theneeds_join_us",
					"name" => __( "Join Us Form", "js_composer" ),
					"class" => "theneeds_join_us_class",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"icon" => "theneeds_join_us_icon",
					"params" => array(

						
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Add Contact Form Title", "js_composer" ),
							"param_name" => "form_title",
							"description" => __( "Enter Contact Form Title Here", "js_composer" )
						),
						
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Add Contact Form Caption", "js_composer" ),
							"param_name" => "form_caption",
							"description" => __( "Enter Form Caption Here", "js_composer" )
						),
						
						array(
							"type" => "textarea_html",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Add Contact Form 7 Shortcode Here", "js_composer" ),
							"param_name" => "content",
							"description" => __( "Add Contact Form 7 Shortcode Here", "js_composer" )
						),
						
						array(
								'type' => 'attach_image',
								"holder" => "p",
								'heading' => __( 'Background Image', 'js_composer' ),
								'param_name' => 'bg_image',
								'value' => '',
								'description' => __( 'Select Background Image For Element.', 'js_composer' )
						),
	
					)
				) );
			}
		}
		
		
		function theneeds_join_us_shortcode( $atts, $content = null ) {
		
			$result = shortcode_atts( array(

				'form_title' => '',
				'form_caption' => '',
				'bg_image' => '',

			), $atts );
			
			extract( $result );
			
			/* Single Image */
			if(!empty($bg_image)){
			
				$bg_image = wpb_getImageBySize( array( 'attach_id' => $bg_image, 'thumb_size' => '100', 'class' => 'vc_single_image-img' ) );
				
				$bg_image =  $bg_image['p_img_large'][0];
			
			}else{
			
				$bg_image = '';
			}

			$output = '
			
			<section class="newsletter-row">
			  <div class="element_wrap">
				<div class="row">
					<div class="col-md-12">
						<div class="newsletter-box newsletter-2" style = "background: #222 url('.$bg_image.') no-repeat right top;">
						  <div class="heading-style-1">
								<h2>'.$form_title.'</h2>
								<em>'.$form_caption.'</em> 
							</div>
							'.do_shortcode($content).'
						</div>
					</div>
				</div>
			  </div>
			</section>';
			
	
			return $output;
		
			wp_reset_postdata();
		} /* end of function */
	} /* end of class */
	
	new theneeds_join_us;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_join_us extends WPBakeryShortCode {
		}
	}
}