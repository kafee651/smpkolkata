<?php
/*
* Add-on Name: CP Addons For Visual Composer
* Add-on URI: http://dev.crunchpress.com
*/
if(!class_exists("theneeds_video_detail")){
	class theneeds_video_detail{
		static $add_plugin_script;
		function __construct(){
			add_action("init",array($this,"theneeds_video_detail_init"));
			add_shortcode('theneeds_video_detail',array($this,'theneeds_video_detail_shortcode'));
		}
		function theneeds_video_detail_init(){

			if(function_exists("vc_map")){
			
				vc_map( array(
					"base" => "theneeds_video_detail",
					"name" => __( "Video Detail", "js_composer" ),
					"class" => "theneeds_video_detail_class",
					"icon" => "theneeds_video_detail",
					"category" => __( 'CrunchPress', 'js_composer' ),
					"params" => array(
					
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Element Caption", "js_composer" ),
								"param_name" => "element_caption",
								"description" => __( "Add Element Caption", "js_composer" )
							),

							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Element Title", "js_composer" ),
								"param_name" => "element_title",
								"description" => __( "Add Element Title", "js_composer" )
							),

							array(
								"type" => "textarea",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Description", "js_composer" ),
								"param_name" => "content",
								"description" => __( "Enter Video Description Here", "js_composer" )
							),
							

							array(
								'type' => 'vc_link',
								"holder" => "p",
								'heading' => __( 'View More (Link)', 'js_composer' ),
								'param_name' => 'readmore_url',
								'description' => __( 'Add Text & Link For Button.', 'js_composer' ),
							),
							
							array(
								"type" => "textfield",
								"holder" => "p",
								"class" => "",
								"heading" => __( "Add Video Link", "js_composer" ),
								"param_name" => "video_link",
								"description" => __( "Add Video Link Here i.e https://player.vimeo.com/video/72029895", "js_composer" )
							),
							
							array(
								'type' => 'attach_image',
								"holder" => "p",
								'heading' => __( 'Video Image', 'js_composer' ),
								'param_name' => 'bg_image',
								'value' => '',
								'description' => __( 'Select Image that will appear as Video Banner.', 'js_composer' )
							),
						)
					) 
				);
			}
		}
		
		
		function theneeds_video_detail_shortcode( $atts, $content = null ) {
		
			$result = shortcode_atts( array(
			
				'element_caption' => '',
				'element_title' => '',
				'readmore_url' => '',
				'video_link' => '',
				'bg_image' => '',

			), $atts );

			extract( $result );

			
			/* Pretty Photo Scripts */
			wp_enqueue_style('prettyPhoto',theneeds_PATH_URL.'/frontend/css/prettyphoto.min.css');
		
			wp_enqueue_script( 'prettyPhoto', theneeds_PATH_URL.'/frontend/js/jquery.prettyphoto.min.js', false, '1.0', true);
				

			/* Background Image */
			if(!empty($bg_image)){
			
				$bg_image = wpb_getImageBySize( array( 'attach_id' => $bg_image, 'thumb_size' => '100', 'class' => 'vc_single_image-img' ) );
			
				$bg_image =  $bg_image['p_img_large'][0];
			
			}else{
				
				$bg_image = '';
			}
			
			/* Build Link First */
			
			$readmore_url = vc_build_link( $readmore_url );

			if(!empty($readmore_url['url'])){ $readmore_url_link =  esc_url($readmore_url['url']); }else{ $readmore_url_link = ''; }

			if(!empty($readmore_url['title'])){ $readmore_text =  esc_attr($readmore_url['title']); }else{ $readmore_text = ''; }
				
			$output = '
			
			 <section class="recent-project-video recent-project-video-2">
			  <div class="container">
				<div class="row">
				  <div class="col-md-9 col-sm-7">
					<div class="video-box" style = "background: url('.esc_url($bg_image).') no-repeat left top;"> 
					  <a href="#" class="btn-play" data-toggle="modal" data-target="#myModal"></a>
					  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
						<div class="modal-dialog" role="document">
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div>
							<div class="modal-body">
							  <iframe src="'.esc_url($video_link).'"></iframe>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				  <div class="col-md-3 col-sm-5">
					<div class="text-col">
					  <div class="heading-style-1"> <span class="title">'.$element_caption.'</span>
						<h2>'.$element_title.'</h2>
					  </div>
					  <p>'.$content.'</p>
					  <a href="'.$readmore_url_link.'" class="btn-style-1">'.$readmore_text.'</a> 
					</div>
				  </div>
				</div>
			  </div>
			</section>';
			
		return $output;

		wp_reset_postdata();

		} /* end of function */
		
		
	}
	
	new theneeds_video_detail;
	
	if(class_exists('WPBakeryShortCode'))
	{
		class WPBakeryShortCode_theneeds_video_detail extends WPBakeryShortCode {
		}
	}
}