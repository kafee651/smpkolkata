<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_sponsors_gallery")){
	class theneeds_sponsors_gallery{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_sponsors_gallery_init"));
			add_shortcode('theneeds_sponsors_gallery',array($this,'theneeds_sponsors_gallery_shortcode'));
		}
		function theneeds_sponsors_gallery_init(){

			if(function_exists("vc_map")){
				
				vc_map( array(
					"base" => "theneeds_sponsors_gallery",
					"name" => __( "Sponsors Gallery", "js_composer" ),
					"class" => "theneeds_sponsors_gallery_class",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"icon" => "theneeds_sponsors_gallery_icon",
					"params" => array(
					
						array(
							"type" => "dropdown",
							"holder" => "p",
							"heading" => __( "Select Style", "js_composer" ),
							"param_name" => "select_style",
							"value" =>  array( __( '2 Column', 'js_composer' ) => '2_col',
												__( '4 Column', 'js_composer' ) => '4_col',
											),
							"description" => __( "Select Element Style", "js_composer" )
						),
						
						array(
							"type" => "textfield",
							"holder" => "p",
							"class" => "",
							"heading" => __( "Element Caption", "js_composer" ),
							"param_name" => "element_caption",
							"description" => __( "Enter Element Title Here", "js_composer" )
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
							"heading" => __( "Element Tag Line", "js_composer" ),
							"param_name" => "element_tagline",
							"description" => __( "Enter Element Tagline Here", "js_composer" )
						),
					
	
						array(
							'type' => 'attach_images',
							"holder" => "p",
							'heading' => __( 'Images', 'js_composer' ),
							'param_name' => 'images',
							'value' => '',
							'description' => __( 'Select Images From Media Library', 'js_composer' )
						),
			
					)
				) );
			}
		}
		
		
		function theneeds_sponsors_gallery_shortcode( $atts, $content = null ) {
			
			$result = shortcode_atts( array(
				
				'element_title' => '',
				'element_caption' => '',
				'images' => '',
				'select_style' => '2_col',
				'element_tagline' => '',
	
			), $atts );
			
			extract( $result );
			
		
			$ex_images = explode(',',$images);
			
			if($select_style == '2_col'){
			
				$col_class = 'col-md-12';
				$content_class = 'sponsors-box-images sponsors-2';
				$tagline = '<em>'.$element_tagline.'</em>';
			
			}else{
				
				$col_class = 'col-md-12';
				$content_class = 'sponsors-box-images';
				$tagline = '';
			
			}
	

			$output = '
			
			<section class="newsletter-row sponsors-row">
			  <div class="element_wrap">
				<div class="row">
					<div class="'.$col_class.'">
						<div class="'.$content_class.'">
						  <div class="heading-style-1"> <span class="title">'.$element_caption.'</span>
							<h2>'.$element_title.'</h2>
							'.$tagline.'
						  </div>
							<ul>';
								foreach($ex_images as $image_id){
								
									$image = wpb_getImageBySize( array( 'attach_id' => $image_id, 'thumb_size' => '100', 'class' => 'vc_single_image-img' ) );
									$feat_image =  $image['p_img_large'][0];
									$output .= '<li><a><img src="'.$feat_image.'" alt="'.esc_html__('img','theneeds').'"></a></li>';
		
								}
								$output .= '
							</ul>
						</div>
					</div>
				</div>
			  </div>
			</section>';
						
			return $output;
			
		}
		
	}
	new theneeds_sponsors_gallery;
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_sponsors_gallery extends WPBakeryShortCode {
		}
	}
}