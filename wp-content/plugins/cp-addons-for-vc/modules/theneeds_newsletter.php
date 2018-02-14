<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_newsletter")){
	class theneeds_newsletter{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_newsletter_init"));
			add_shortcode('theneeds_newsletter',array($this,'theneeds_newsletter_shortcode'));
		}
		function theneeds_newsletter_init(){

			if(function_exists("vc_map")){
				
				
				vc_map( array(
					"base" => "theneeds_newsletter",
					"name" => __( "Newsletter ", "js_composer" ),
					"class" => "theneeds_newsletter_class",
					"icon" => "theneeds_newsletter_icon",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"params" => array(
					
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Element Form Sub Title", "js_composer" ),
								"param_name" => "element_subtitle",
								"description" => __( "Enter Element Form Sub Title Here", "js_composer" )
							),
					
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Element Form Title", "js_composer" ),
								"param_name" => "element_title",
								"description" => __( "Enter Element Form Title Here", "js_composer" )
							),
							
							array(
								"type" => "textarea_html",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Add MailPoet Shortcode", "js_composer" ),
								"param_name" => "content",
								"description" => __( "Add MailPoet Newsletter Plugin Shortcode Here", "js_composer" )
							),
							
		
						)
					) 
				);
			}
		}
		
		
		function theneeds_newsletter_shortcode( $atts, $content = null ) {
		
			$result = shortcode_atts( array(
				
				'element_title' => '',
				'element_subtitle' => '',

			), $atts );

			extract( $result );
			
			$output = '
			
				<section class="newsletter-row">
				  <div class="element_wrap">
					<div class="row">
					  <div class="col-md-12">
						<div class="newsletter-box">
						  <div class="heading-style-1"> <span class="title">'.$element_subtitle.'</span>
							<h2>'.$element_title.'</h2>
						  </div>
						   '.do_shortcode($content).'
						</div>
					  </div>
					</div>
				  </div>
				</section>';
				
				
			return $output;

		} /* end of function */
		
		
	}
	
	new theneeds_newsletter;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_newsletter extends WPBakeryShortCode {
		}
	}
}