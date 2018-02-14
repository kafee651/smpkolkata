<?php

	/*
	*	CrunchPress Misc File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		CrunchPress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) CrunchPress
	*	---------------------------------------------------------------------
	*	This file contains all of the necessary function for the front-end to
	*	easily used. You can see the description of each function below.
	*	---------------------------------------------------------------------
	*/

	
	/* Check if url is from youtube or vimeo */
	function theneeds_get_video($url, $width = 640, $height = 480){
	
		$videoHtml = '';
		
		if(strpos(esc_url($url),'youtube')){		
		
			$videoHtml = theneeds_get_youtube($url, $width, $height);
		
		}else if(strpos($url,'youtu.be')){
		
			$videoHtml = theneeds_get_youtube($url, $width, $height, 'youtu.be');
			
		}else{
		
			$videoHtml = theneeds_get_vimeo($url, $width, $height);
		}
		
		return $videoHtml;
	}
	
	// Print youtube video
	function theneeds_get_youtube($url, $width = 640, $height = 480, $type = 'youtube'){
		
		if( $type == 'youtube' ){
			preg_match('/[\\?\\&]v=([^\\?\\&]+)/',$url,$id);
			
		}else{
			preg_match('/youtu.be\/([^\\?\\&]+)/', $url, $id);
		}
		
		$width_html = '';
		
		if($width  == '100%'){
			$width_html .= 'class="full-width-video"   ';
			$width_html .= 'width="100"';
		}else{
			$width_html = 'width='.esc_attr($width);
		}
		
		
		//return esc_html__('URL NOT FOUND','theneeds');
		
		
		$return_html = '<iframe width="'.$width.'" height="'.$height.'" src="'.esc_url($url).'"></iframe>';

		return $return_html;
		
	}
	
	/* Get Audio Player OR SoundCloud */
	function theneeds_get_audio_track($url,$counter_track){
		$audio_html = '';
		if(strpos($url,'soundcloud')){
			$audio_html .= do_shortcode('[soundcloud type="visual-embed" url="'.esc_url($url).'" color="#1e73be" auto_play="false" hide_related="true" show_artwork_or_visual="true" width="100%" height="300" iframe="true" /]');
		}else{
			if($url <> '' ){
				$audio_html  .= do_shortcode('[audio mp3="'.esc_url($url).'"][/audio]');
			} 
		}
		
		return $audio_html;
	}
	
	/* Print vimeo video */
	function theneeds_get_vimeo($url, $width = 640, $height = 480){
		
		preg_match('/http:\/\/vimeo.com\/(\d+)$/', $url, $id);
		$width_html = '';
		if($width  == '100%'){
			$width_html .= 'class="full-width-video"  ';
			$width_html .= 'width="100"';
		}else{
			$width_html = esc_html('width='.strip_tags($width));
		}
		if(!empty($id)){
		return '
		<object type="video/x-ms-wmv" '.$width_html.' height="'.strip_tags($height).'">
			<param name="allowscriptaccess" value="always" >
			<param name="allowfullscreen" value="true" >
			<param name="wmode" value="transparent" >
			<param name="bgcolor" value="#000000" >
			<param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id='.$id[1].'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" />
			<embed src="http://vimeo.com/moogaloop.swf?clip_id='.$id[1].'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" '.$width_html.' height="'.$height.'" wmode="transparent" bgcolor="#000000">
		</object>';
		}
		
	}
	
	/* Owl - Post Slider */
	function theneeds_print_owl_slider_for_post($slider_xml,$size,$slider_id){
		
		global $post;

		$slider_html = '';
		
		/* Owl Scripts */
		wp_enqueue_script( 'cp-owl', theneeds_PATH_URL.'/frontend/js/owl.carousel.min.js', false, '1.0', true);

		wp_enqueue_style('cp-owl',theneeds_PATH_URL.'/frontend/css/owl.carousel.css');
		
		$slider_html .= '
		
		<div class="slider-thumb">
            
			<div class="owl-carousel" id="blog-slider">';
				
				if(!empty($slider_xml)){

					foreach($slider_xml->childNodes as $slider){

						if(theneeds_get_width($size) == '5000'){
							$image_url = wp_get_attachment_image_src(theneeds_find_xml_value($slider, 'image'),'full');
						}else{
							$image_url = wp_get_attachment_image_src(theneeds_find_xml_value($slider, 'image'), $size);
						}
						$alt_text = get_post_meta(theneeds_find_xml_value($slider, 'image') , '_wp_attachment_image_alt', true);

						$slider_html .= '
							
							<div class="item"> <img src="'. esc_url($image_url[0]).'" alt="'.esc_attr__('img','theneeds').'"> </div>';
		
					}/* end for each */
	
				}
				
				$slider_html .= '
			
			</div>
		
		</div>';
			
	
		return $slider_html;
	}

	
	/* Bx Slider For Theme */
	function theneeds_print_bx_slider($slider_xml,$size,$slider_id){
	
		/* Bx Slider Script and CSS file  */
		
		wp_enqueue_style('cp-bx-slider',theneeds_PATH_URL.'/frontend/css/jquery.bxslider.css');
			
		wp_enqueue_script( 'cp-bx-slider', theneeds_PATH_URL.'/frontend/js/jquery.bxslider.min.js', false, '1.0', true);
		
		global $post;
	
		/* BX slider */
		$slider_html = 'false';
		$slide_order_bx = '';
		$auto_play_bx = '';
		$pause_on_bx = '';
		$animation_speed_bx = '';
		$anchor_hr = '';
		$show_bullets = '';
		$show_arrow = '';
		
		
		
		$theneeds_slider_settings = get_option('slider_settings');
		if($theneeds_slider_settings <> ''){
			$theneeds_slider = new DOMDocument ();
			$theneeds_slider->loadXML ( $theneeds_slider_settings );
			/* Bx Slider Values */
			$slide_order_bx = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','slide_order_bx');
			$auto_play_bx = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','auto_play_bx');
			if($auto_play_bx == 'enable'){$auto_play_bx = 'true';}else{$auto_play_bx = 'false';}
			$pause_on_bx = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','pause_on_bx');
			if($pause_on_bx == 'enable'){$pause_on_bx = 'true';}else{$pause_on_bx = 'false';}
			$animation_speed_bx = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','animation_speed_bx');
			$show_bullets = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','show_bullets');
			$show_arrow = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','show_arrow');
		}
		$mode_slide = '';
		if($slide_order_bx == 'slide'){}else{$mode_slide = "mode: 'fade',";}
		if($animation_speed_bx == ''){$animation_speed_bx = '2000';}
		if($show_bullets == 'enable'){$show_bullets = 'true';}else{$show_bullets = 'false';}
		if($show_arrow == 'enable'){$show_arrow = 'true';}else{$show_arrow = 'false';}
		
		$counter = rand(1,1000);


		if(!empty($slider_xml)){
		$slider_html = '<div id="banner'.$counter.'" class="banner-2">';
		$slider_html = $slider_html . '<script type="text/javascript">jQuery(document).ready(function($){$(".main-bx-slider'.$counter.'").bxSlider({'.esc_js($mode_slide).'minSlides: 1,maxSlides: 1,pager:'.esc_js($show_bullets).',controls:'.esc_js($show_arrow).',hideControlOnEnd: true,easing: "swing",auto: '.esc_js($auto_play_bx).',autoHover:'.esc_js($pause_on_bx).',speed:'.esc_js($animation_speed_bx).', pagerCustom: "#bx-pager"});});</script>';
			$slider_html = $slider_html . '<div id="home-banner'.$counter.'" class="main-bx-slider'.$counter.' bx-wrap">';
				foreach($slider_xml->childNodes as $slider){
					$title = theneeds_find_xml_value($slider, 'title');
					$caption = html_entity_decode(theneeds_find_xml_value($slider, 'caption'));
					$link = theneeds_find_xml_value($slider, 'link');
					$contact_url = theneeds_find_xml_value($slider, 'contact_url');
					$link_type = theneeds_find_xml_value($slider, 'linktype');
					$btn_txt = theneeds_find_xml_value($slider, 'btn_txt');
					$slide_style = theneeds_find_xml_value($slider, 'slide_style');
					if(theneeds_get_width($size) == '5000'){
						$image_url = wp_get_attachment_image_src(theneeds_find_xml_value($slider, 'image'),'full');
					}else{
						$image_url = wp_get_attachment_image_src(theneeds_find_xml_value($slider, 'image'), $size);
					}
					$alt_text = get_post_meta(theneeds_find_xml_value($slider, 'image') , '_wp_attachment_image_alt', true);

					
					/* for link case */	
					if($link_type == 'No Link'){
						$anchor_hr = '';
					}else if($link_type == 'Link to URL' && isset($link)){
						$anchor_hr = '<a href="'.esc_url($link).'" class="btn-style-1">'.esc_attr('Check Availability','theneeds').'</a> ';
					}else{
						$anchor_hr = '';
					}
					
					/* contact URl case */
					if($link_type == 'No Link'){
						$contact_url = '';
					}else if($link_type == 'Link to URL' && isset($contact_url)){
						$contact_url = '<a href="'.esc_url($contact_url).'" class="btn-style-1 btn-style-2">'.esc_attr('View Locations','theneeds').'</a> ';
					}else{
						$contact_url = '';
					}
					
					/* If Title & Caption is Not Empty */
					if($slide_style == 'Style 1'){
						
						$slider_html .= '
					
							<div class="item">
								<div class="caption">
								  <div class="container">
									<div class="caption-style-1"> <em>'.$title.'</em>
									  <h1>'. $caption.'</h1>
									   '.$anchor_hr.$contact_url.'
									</div>
								  </div>
								</div>
								<img src="'. esc_url($image_url[0]).'" alt="'.esc_attr__('img','theneeds').'"> 
							</div>';
						
					}elseif($slide_style == 'Style 2'){
					
						$slider_html .= '
						
							<div class="item">
								<div class="caption">
								  <div class="container">
									<div class="caption-style-1 caption-style-2">
									  <h1>'. $caption.'</h1>
									   '.$anchor_hr.$contact_url.' 
									</div>
								  </div>
								</div>
								<img src="'. esc_url($image_url[0]).'" alt="'.esc_attr__('img','theneeds').'"> 
							</div>';
		
					}elseif($slide_style == 'Style 3'){
						
						$slider_html .= '
						
							<div class="item">
								<div class="caption">
								  <div class="container">
									<div class="caption-style-1 caption-style-3">
									  <h1>'. $caption.'</h1>
									  <div class="btn-row"> <div class="btn-row"> '.$anchor_hr.$contact_url.' </div> </div>
									</div>
								  </div>
								</div>
								<img src="'. esc_url($image_url[0]).'" alt="'.esc_attr__('img','theneeds').'"> 
							</div>';
						
							
					}else{
					
					/* If title & Description is empty */
							$slider_html = $slider_html  .'<div class="item">';							
							$slider_html = $slider_html  .'<img src="'. esc_url($image_url[0]).'" alt="'.esc_attr('img','theneeds').'"/>
														  </div>';
					}
				}/* end for each */
				
				$slider_html = $slider_html . '</div></div>';
				
		}
	return $slider_html;
	
	}
	
	/* Owl - Slider WORK PROGRESS */
	function theneeds_work_progress_owl_slider($slider_xml,$size,$slider_id){
		
		global $post;

		$slider_html = '';
		
		/* Owl Scripts */
		wp_enqueue_script( 'cp-owl', theneeds_PATH_URL.'/frontend/js/owl.carousel.min.js', false, '1.0', true);

		wp_enqueue_style('cp-owl',theneeds_PATH_URL.'/frontend/css/owl.carousel.css');
		
		
		if(!empty($slider_xml)){

			foreach($slider_xml->childNodes as $slider){

				if(theneeds_get_width($size) == '5000'){
					$image_url = wp_get_attachment_image_src(theneeds_find_xml_value($slider, 'image'),'full');
				}else{
					$image_url = wp_get_attachment_image_src(theneeds_find_xml_value($slider, 'image'), $size);
				}
				$alt_text = get_post_meta(theneeds_find_xml_value($slider, 'image') , '_wp_attachment_image_alt', true);

				$slider_html .= '
					
					<div class="item"> <img src="'. esc_url($image_url[0]).'" alt="'.esc_attr__('img','theneeds').'"> </div>';
		
			}/* end for each */
	
		}
	
		return $slider_html;
	}
	
	/* Owl - Slider Single Project */
	function theneeds_single_project_bx_slider($slider_xml,$size,$slider_id){
		
		global $post;

		$slider_html = '';
		
		/* Bx Slider Script and CSS file  */
		
		wp_enqueue_style('cp-bx-slider',theneeds_PATH_URL.'/frontend/css/jquery.bxslider.css');
		
		wp_enqueue_script( 'cp-bx-slider', theneeds_PATH_URL.'/frontend/js/jquery.bxslider.min.js', false, '1.0', true);
	
	
		if(!empty($slider_xml)){
			
			$slider_html .= '<ul class="single-project">';
				
				foreach($slider_xml->childNodes as $slider){

					if(theneeds_get_width($size) == '5000'){
						$image_url = wp_get_attachment_image_src(theneeds_find_xml_value($slider, 'image'),'full');
					}else{
						$image_url = wp_get_attachment_image_src(theneeds_find_xml_value($slider, 'image'), $size);
					}
					$alt_text = get_post_meta(theneeds_find_xml_value($slider, 'image') , '_wp_attachment_image_alt', true);

					$slider_html .= '<li><img src="'. esc_url($image_url[0]).'" alt="'.esc_attr__('img','theneeds').'"></li>';
                  
				}/* end for each */
			
			$slider_html .= '</ul>';
			
			$slider_html .= '<div id="bx-pager">';
			
				foreach($slider_xml->childNodes as $slider){
				
					if(theneeds_get_width($size) == '5000'){
						$image_url = wp_get_attachment_image_src(theneeds_find_xml_value($slider, 'image'), array(275,260));
					}else{
						$image_url = wp_get_attachment_image_src(theneeds_find_xml_value($slider, 'image'),  array(275,260));
					}
					$alt_text = get_post_meta(theneeds_find_xml_value($slider, 'image') , '_wp_attachment_image_alt', true);
				
					static $project_slide_count = 0;
	
					$slider_html .= ' <a data-slide-index="'.esc_attr($project_slide_count).'" href="">
										<img class = "pager_small_image" src="'. esc_url($image_url[0]).'" alt="'.esc_attr__('img','theneeds').'" />
									</a>';
					
					$project_slide_count++;
				 
				}
			
			$slider_html .= '</div>';
		}
	
		return $slider_html;
	}
	
	
	/* Owl - Slider */
	function theneeds_inner_owl_slider($slider_xml,$size,$slider_id){
		
		global $post;

		static $pager_counter = 1;
		
		$slider_html = '';
		
		
		/* Owl Scripts */
		wp_enqueue_script( 'cp-owl', theneeds_PATH_URL.'/frontend/js/owl.carousel.min.js', false, '1.0', true);

		wp_enqueue_style('cp-owl',theneeds_PATH_URL.'/frontend/css/owl.carousel.css');
		
	
			if(!empty($slider_xml)){
			

				$slider_html .= $slider_html . '<div id="banner"><div id="home-banner" class="owl-carousel">';
				
					foreach($slider_xml->childNodes as $slider){
					
						$title = theneeds_find_xml_value($slider, 'title');
						$caption = theneeds_find_xml_value($slider, 'caption');
						$subtitle = theneeds_find_xml_value($slider, 'subtitle');
						$link = theneeds_find_xml_value($slider, 'link');
						$contact_url = theneeds_find_xml_value($slider, 'contact_url');
						$link_type = theneeds_find_xml_value($slider, 'linktype');
						$slide_style = theneeds_find_xml_value($slider, 'slide_style');
						$btn_txt = theneeds_find_xml_value($slider, 'btn_txt');
						if(theneeds_get_width($size) == '5000'){
							$image_url = wp_get_attachment_image_src(theneeds_find_xml_value($slider, 'image'),'full');
						}else{
							$image_url = wp_get_attachment_image_src(theneeds_find_xml_value($slider, 'image'), $size);
						}
						$alt_text = get_post_meta(theneeds_find_xml_value($slider, 'image') , '_wp_attachment_image_alt', true);
						
						/* Slider Title Allowed HTML */
						$slider_title_allowed_html = array(
															'a' => array(
																'href' => array(),
																'title' => array()
															),
															'span' => array(),
															'br' => array(),
															'strong' => array(),
													);
						
						/* Slider Title */
						$slider_title = wp_kses($title, $slider_title_allowed_html);
		

						$slider_html .= '
						
						<div class="item"> 
							<img src="'. esc_url($image_url[0]).'" alt="'.esc_attr__('img','theneeds').'">
							<div class="caption">
							  <div class="container"> <strong class="title">'.$slider_title.'</strong>
									<h1>'.$caption.'</h1>
									<span class="title">'.esc_attr($subtitle).'</span>';
									/* First Link */
									if(!empty($link)){
										$slider_html .= '<a href="'.esc_url($link).'" class="btn-style-1">'.esc_html__('Join us Now','theneeds').'</a>'; 
									}
									/* Contact URl */
									if(!empty($contact_url)){
										$slider_html .= '<a href="'.esc_url($contact_url).'" class="btn-style-2">'.esc_html__('Donate Today','theneeds').'<i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>';
									}
									$slider_html .= '
								</div>
							</div>
						</div>';

					}/* end for each */
					
					$slider_html = $slider_html . '</div></div>';
					
			}
		
		return $slider_html;

	}
	

	function theneeds_print_bx_post_slider($slider_xml,$size,$slider_id){
		global $post;
		/* BX slider */
		$slider_html = 'false';
		$slide_order_bx = '';
		$auto_play_bx = '';
		$pause_on_bx = '';
		$animation_speed_bx = '';
		$anchor_hr = '';
		
		$theneeds_slider_settings = get_option('slider_settings');
		if($theneeds_slider_settings <> ''){
			$theneeds_slider = new DOMDocument ();
			$theneeds_slider->loadXML ( $theneeds_slider_settings );
			/* Bx Slider Values */
			$slide_order_bx = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','slide_order_bx');
			$auto_play_bx = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','auto_play_bx');
			if($auto_play_bx == 'enable'){$auto_play_bx = 'true';}else{$auto_play_bx = 'false';}
			$pause_on_bx = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','pause_on_bx');
			if($pause_on_bx == 'enable'){$pause_on_bx = 'true';}else{$pause_on_bx = 'false';}
			$animation_speed_bx = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','animation_speed_bx');
		}
		
		if($slide_order_bx == 'slide'){}else{$mode_slide = "mode: 'fade',";}
		if($animation_speed_bx == ''){$animation_speed_bx = '2000';}
	
	
		if(!empty($slider_xml)){
		$slider_html = '<section class="border_slider">';
		$slider_html = $slider_html . '<script type="text/javascript">jQuery(document).ready(function($){var blockexist = $(".post-type-bar");$("#'.$slider_id.'").bxSlider({'.$mode_slide.'minSlides: 1,maxSlides: 1,slideMargin: 0,hideControlOnEnd: true,easing: "swing",auto: '.$auto_play_bx.',autoHover:'.$pause_on_bx.',speed:'.$animation_speed_bx.',onSliderLoad:function(){if(blockexist.length){var para_post = "slider-'.$post->ID.'";equalheight_fun(para_post);}}});});</script>';
			$slider_html = $slider_html . '<ul id="'.$slider_id.'" class="banner_sliderr" >';
				foreach($slider_xml->childNodes as $slider){
					$title = theneeds_find_xml_value($slider, 'title');
					$caption = html_entity_decode(theneeds_find_xml_value($slider, 'caption'));
					$link = theneeds_find_xml_value($slider, 'link');
					$link_type = theneeds_find_xml_value($slider, 'linktype');
					$btn_txt = theneeds_find_xml_value($slider, 'btn_txt');
					if(theneeds_get_width($size) == '5000'){
						$image_url = wp_get_attachment_image_src(theneeds_find_xml_value($slider, 'image'),'full');
					}else{
						$image_url = wp_get_attachment_image_src(theneeds_find_xml_value($slider, 'image'),$size);
					}
					$alt_text = get_post_meta(theneeds_find_xml_value($slider, 'image') , '_wp_attachment_image_alt', true);
					
						if($link_type == 'No Link'){
							$anchor_hr = '<strong class="f-post-title">'. esc_attr($title).'</strong>';
						}else if($link_type == 'Link to URL'){
							$anchor_hr = '<strong class="f-post-title"><a href="'.esc_url($link).'">'. esc_attr($title).'</a></strong>';
						}else{
							$anchor_hr = '';
						}
						
						$slider_html = $slider_html  .'<li>';
						$slider_html = $slider_html  .'<img src="'. esc_url($image_url[0]).'" alt="'.esc_attr('img','theneeds').'"/>';
						/* Condition for Title and Description if Empty */
						if($title <> '' AND $caption <> ''){
							$slider_html = $slider_html  .'<div class="post-slide-cap"><span class="post-type">'.esc_attr(get_the_date(get_option('date_format'))).'<i class="icon-facetime-video"></i></span>';
							$slider_html = $slider_html  .$anchor_hr;
							$slider_html = $slider_html  .'</div>';
						}
						$slider_html = $slider_html  .'</li>';
				}
				
			$slider_html = $slider_html . '</ul>';
			$slider_html = $slider_html . '</section>';
		
		}
	return $slider_html;
	
	}
	
	function theneeds_print_bx_slider_shortcode($slider_xml,$size,$slider_id){
	global $post;
	//BX slider
	$slider_html = 'false';
	$slide_order_bx = '';
	$auto_play_bx = '';
	$pause_on_bx = '';
	$animation_speed_bx = '';
	
	$theneeds_slider_settings = get_option('slider_settings');
	if($theneeds_slider_settings <> ''){
		$theneeds_slider = new DOMDocument ();
		$theneeds_slider->loadXML ( $theneeds_slider_settings );
		//Bx Slider Values
		$slide_order_bx = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','slide_order_bx');
		$auto_play_bx = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','auto_play_bx');
		if($auto_play_bx == 'enable'){$auto_play_bx = 'true';}else{$auto_play_bx = 'false';}
		$pause_on_bx = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','pause_on_bx');
		if($pause_on_bx == 'enable'){$pause_on_bx = 'true';}else{$pause_on_bx = 'false';}
		$animation_speed_bx = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','animation_speed_bx');
	}
	
	if($slide_order_bx == 'slide'){ $mode_slide = 'mode: horizontal'; }else{$mode_slide = 'mode: fade';}
	if($animation_speed_bx == ''){$animation_speed_bx = '2000';}
	
	
		if(!empty($slider_xml)){
		$slider_html = '<section class="border_slider">';
		$slider_html = $slider_html . '<script type="text/javascript">jQuery(document).ready(function($){var blockexist = $(".post-type-bar");$("#'.$slider_id.'").bxSlider({'.$mode_slide.',minSlides: 1,maxSlides: 1,slideMargin: 0,hideControlOnEnd: true,easing: "swing",auto: '.$auto_play_bx.',autoHover:'.$pause_on_bx.',speed:'.$animation_speed_bx.',onSliderLoad:function(){if(blockexist.length){var para_post = "slider-'.$post->ID.'";equalheight_fun(para_post);}}});});</script>';
			$slider_html = $slider_html . '<ul id="'.$slider_id.'" class="banner_sliderr" >';
				foreach($slider_xml->childNodes as $slider){
					$title = theneeds_find_xml_value($slider, 'title');
					$caption = html_entity_decode(theneeds_find_xml_value($slider, 'caption'));
					$link = theneeds_find_xml_value($slider, 'link');
					$link_type = theneeds_find_xml_value($slider, 'linktype');
					$btn_txt = theneeds_find_xml_value($slider, 'btn_txt');
					if(theneeds_get_width($size) == '5000'){
						$image_url = wp_get_attachment_image_src(theneeds_find_xml_value($slider, 'image'),'full');
					}else{
						$image_url = wp_get_attachment_image_src(theneeds_find_xml_value($slider, 'image'),$size);
					}
					$alt_text = get_post_meta(theneeds_find_xml_value($slider, 'image') , '_wp_attachment_image_alt', true);
					
						$slider_html = $slider_html  .'<li>';
						$slider_html = $slider_html  .'<img src="'. esc_url($image_url[0]).'" alt="'.esc_attr('img','theneeds').'"/>';
						$slider_html = $slider_html  .'<div class="slider_content">';
						$slider_html = $slider_html  .'<a href="'.esc_url($link).'"><h2">'. esc_attr($title).' </h2></a>';
						$slider_html = $slider_html  .'<span class="clear"></span>';
						$slider_html = $slider_html  .'<p class="b_green"> '.esc_attr($caption).'</p>';
						$slider_html = $slider_html  .'</div>';
						$slider_html = $slider_html  .'</li>';
				}
				
			$slider_html = $slider_html . '</ul>';
			$slider_html = $slider_html . '</section>';
		
		}
	return $slider_html;
	
	}
	
	function theneeds_print_post_slider_item($category_id='',$num_post=''){ 
		
		global $counter;
		
		//BX slider
		$slider_html = 'false';
		$slide_order_bx = '';
		$auto_play_bx = '';
		$pause_on_bx = '';
		$animation_speed_bx = '';
		$anchor_hr = '';
		$show_bullets = '';
		$show_arrow = '';
		
		$theneeds_slider_settings = get_option('slider_settings');
		if($theneeds_slider_settings <> ''){
			$theneeds_slider = new DOMDocument ();
			$theneeds_slider->loadXML ( $theneeds_slider_settings );
			//Bx Slider Values
			$slide_order_bx = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','slide_order_bx');
			$auto_play_bx = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','auto_play_bx');
			if($auto_play_bx == 'enable'){$auto_play_bx = 'true';}else{$auto_play_bx = 'false';}
			$pause_on_bx = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','pause_on_bx');
			if($pause_on_bx == 'enable'){$pause_on_bx = 'true';}else{$pause_on_bx = 'false';}
			$animation_speed_bx = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','animation_speed_bx');
			$show_bullets = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','show_bullets');
			$show_arrow = find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','show_arrow');
		}
		$mode_slide = '';
		if($slide_order_bx == 'slide'){}else{$mode_slide = "mode: 'fade',";}
		if($animation_speed_bx == ''){$animation_speed_bx = '2000';}
		if($show_bullets == 'enable'){$show_bullets = 'true';}else{$show_bullets = 'false';}
		if($show_arrow == 'enable'){$show_arrow = 'true';}else{$show_arrow = 'false';}
		$mode_slide = "mode: 'fade',";
		$counter = '1';
		$slider_html = '';
		$slider_html .= '<div class="border_slider cp-banner">';
		$slider_html = '<script type="text/javascript">jQuery(document).ready(function($){$("#recent-slider-'.esc_js($counter).'").bxSlider({'.esc_js($mode_slide).'minSlides: 1,maxSlides: 1,pager:'.esc_js($show_bullets).',controls:'.esc_js($show_arrow).',hideControlOnEnd: true,easing: "swing",auto: '.esc_js($auto_play_bx).',autoHover:'.esc_js($pause_on_bx).',speed:'.esc_js($animation_speed_bx).',pagerCustom: "#bx_slider_cap"});});</script>';
		$slider_html .= '<ul id="recent-slider-'.esc_attr($counter).'" class="banner_sliderr" >';
				
			if($category_id == 'all'){
				//Popular Post 
				query_posts(
					array( 
					'post_type' => 'post',
					'posts_per_page' => $num_post,
					'ignore_sticky_posts' 	=> false,
					//'ignore_sticky_posts' => true,
					'orderby' => 'title',
					'order' => 'ASC' )
				);
			}else{
				//Popular Post 
				query_posts(
					array( 
					'post_type' => 'post',
					'posts_per_page' => $num_post,					
					'ignore_sticky_posts'=> true,
					'tax_query' => array(
						array(
							'taxonomy' => 'category',
							'terms' => $category_id,
							'field' => 'term_id',
						)
					),
					'orderby' => 'title',
					'order' => 'ASC' )
				);
			}

				$counter_post = 0;
				while( have_posts() ){
					the_post();
					global $post, $post_id;
					
						$slider_html .= '<li>';
						$slider_html .= get_the_post_thumbnail($post->ID, 'full');
						
						$slider_html .= '
							<div class="caption-2">
								<div class="holder">
									<div class="inner">
										<h1><a href="'.esc_url(get_permalink()).'">'. esc_attr(get_the_title()).'</a></h1>
										<div class="banner-row">
											<a href="'.esc_url(get_permalink()).'"><i class="fa fa-user"></i>'.esc_attr(get_the_author()).'</a>
											<a href="'.esc_url(get_permalink()).'"><i class="fa fa-calendar"></i>'.esc_attr(get_the_date(get_option('date_format'))).'</a>
										</div>
										<p>'. esc_attr(strip_tags(substr(get_the_content(),0,150))).'</p>
										<a class="btn-read" href="'.esc_url(get_permalink()).'">'.esc_html__('Read Post','theneeds').'</a>
									</div>
								</div>
							</div>';
						
						$slider_html .= '</li>';
				}	
				
			$slider_html .= '</ul>';
			
			$slider_html .= '<div class="bx_pager_cp" id="bx_slider_cap">';
				$slider_pagi = 0;
				while( have_posts() ){
					the_post();
					global $post, $post_id;
					
					$slider_html .= '
					<a data-slide-index="'.esc_attr($slider_pagi).'" href="" class="rollIn animated">
						'.get_the_post_thumbnail($post->ID, array(80,80)).'
					</a>';		
					$slider_pagi++;
				}wp_reset_postdata();
			
			
			$slider_html .= '</div>
		</div>';
		wp_reset_query();
		
		return $slider_html;
	
	}