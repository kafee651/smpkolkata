<?php

	/*
	*	CrunchPress Blog Item File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		CrunchPress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) CrunchPress
	*	---------------------------------------------------------------------
	*	This file contains the function that can print each blog item in 
	*	different conditions.
	*	---------------------------------------------------------------------
	*/
	
	/* size is when no sidebar, side2 is use when 1 sidebar, side 3 is use when 3 sidebar */
	$theneeds_is_responsive = 'enable';
	
	if( $theneeds_is_responsive ){
		$theneeds_blog_div_listing_num_class = array( );
	}	
	
	/* Basic Print Blog Element Function */
	function theneeds_print_blog_item($item_xml){ 
	
		/* Removed Due To VC */
	
	}	
	
	
	/* Modern Blog Element Function */ 
	function print_blog_modern_item($item_xml){
		/* Removed Due To VC */
	}	
	
	/* Used Frequently */
	function theneeds_print_blog_thumbnail( $postid, $theneeds_item_size ){
		
		global $counter;
		$theneeds_new_counter = rand();
		
		/* Get Post Options */
		$theneeds_img_html = '';
		$theneeds_thumbnail_types = '';
		$theneeds_video_url_type = '';
		$theneeds_select_slider_type = '';
		$theneeds_post_detail_xml = get_post_meta($postid, 'post_detail_xml', true);
		if($theneeds_post_detail_xml <> ''){
			$theneeds_post_xml = new DOMDocument ();
			$theneeds_post_xml->loadXML ( $theneeds_post_detail_xml );
			$theneeds_thumbnail_types = theneeds_find_xml_value($theneeds_post_xml->documentElement,'post_thumbnail');
			$theneeds_audio_url_type = theneeds_find_xml_value($theneeds_post_xml->documentElement,'audio_url_type');
			$theneeds_video_url_type = theneeds_find_xml_value($theneeds_post_xml->documentElement,'video_url_type');
			$theneeds_select_slider_type = theneeds_find_xml_value($theneeds_post_xml->documentElement,'select_slider_type');			
			
			/* Featured Image */
			if( $theneeds_thumbnail_types == "Image"){
				if(get_the_post_thumbnail($postid, $theneeds_item_size) <> ''){
					$theneeds_img_html = '<div class="post_featured_image thumbnail_image">';
					$theneeds_img_html = $theneeds_img_html . get_the_post_thumbnail($postid, $theneeds_item_size);
					$theneeds_img_html = $theneeds_img_html . '</div>';
				}
				
			}else if( $theneeds_thumbnail_types == "Video" ){
				/* Video Thumbnail */
				if($theneeds_video_url_type <> ''){
					
					$vimeo_player = strpos($theneeds_video_url_type, 'player.vimeo.com');
				
					$theneeds_img_html = '<div class = "remove_hover">';				
					$theneeds_img_html = $theneeds_img_html .'<div class="post_featured_image thumbnail_image videopost">';
					$theneeds_img_html = $theneeds_img_html . '<div class="blog-thumbnail-video">';
					
					if(theneeds_get_width($theneeds_item_size) == '350'){	
					
						$theneeds_img_html = $theneeds_img_html . theneeds_get_video($theneeds_video_url_type, theneeds_get_width($theneeds_item_size), theneeds_get_height($theneeds_item_size));
					
					}elseif($vimeo_player){
					
						$video_width = theneeds_get_width($theneeds_item_size);
						$video_height = theneeds_get_height($theneeds_item_size);
						
					
						$theneeds_img_html = $theneeds_img_html . '<iframe src="'.esc_url($theneeds_video_url_type).'?color=00B084&title=0&byline=0&portrait=0" style="width:'.$video_width.'px; height:'.$video_height.'px; border:0;"></iframe>';
						
					}else{	

						$theneeds_img_html = $theneeds_img_html . theneeds_get_video($theneeds_video_url_type, theneeds_get_width($theneeds_item_size), theneeds_get_height($theneeds_item_size));	

					}
					$theneeds_img_html = $theneeds_img_html . '</div></div></div>';
				}
			}else if ( $theneeds_thumbnail_types == "Slider" ){
				
				/* Print Slider */			
				$theneeds_slider_xml = get_post_meta( intval($theneeds_select_slider_type), 'cp-slider-xml', true); 				
				if($theneeds_slider_xml <> ''){
					$theneeds_slider_xml_dom = new DOMDocument();
					$theneeds_slider_xml_dom->loadXML($theneeds_slider_xml);
					$theneeds_slider_name='bxslider'.$theneeds_new_counter.$postid;									
					
					$theneeds_audio_counter = $counter.$postid;
					/* Inline Styling For Slider Width */
					
					if(theneeds_get_width($theneeds_item_size) == '360'){											
						
						$theneeds_slider_name = 'cp-home-banner';												
						
						$theneeds_img_html = "<style>#'". $theneeds_slider_name."'{width:'".theneeds_get_width($theneeds_item_size)."'px;height:'".theneeds_get_height('250')."'px;float:left;}</style>";												
																
					
					}else{											
						$theneeds_img_html = "<style>#'". $theneeds_slider_name."'{width:100%;height:350px;float:left;}</style>";
					}										
					$theneeds_img_html = '<div class = "remove_hover">';					
					$theneeds_img_html =  $theneeds_img_html .'<div class="post_featured_image thumbnail_image sliderpost">';
					$theneeds_img_html = $theneeds_img_html . theneeds_print_owl_slider_for_post($theneeds_slider_xml_dom->documentElement, $theneeds_item_size ,$theneeds_slider_name);
					$theneeds_img_html = $theneeds_img_html . '</div></div>';
				}
			}else if($theneeds_thumbnail_types == "Audio"){ 
				if($theneeds_audio_url_type <> '' ){
					$theneeds_audio_counter = $counter.$postid;
						/* JPlayer Code */
						$theneeds_img_html =  '<div class = "remove_hover"><div class="audio_player song-list audiopost">';
						$theneeds_audio_html = '';
						if(strpos($theneeds_audio_url_type,'soundcloud')){
							$theneeds_img_html = $theneeds_img_html . theneeds_get_audio_track($theneeds_audio_url_type,$theneeds_audio_counter);
						}else{
							$theneeds_img_html = $theneeds_img_html . theneeds_get_audio_track($theneeds_audio_url_type,$theneeds_audio_counter) . get_the_post_thumbnail($postid, $theneeds_item_size);
						}
						$theneeds_img_html = $theneeds_img_html . '</div></div>';
				} 
			}else{				
				if(get_the_post_thumbnail($postid, $theneeds_item_size) <> ''){								
					$theneeds_img_html = '<div class="post_featured_image thumbnail_image">';
					$theneeds_img_html = $theneeds_img_html . get_the_post_thumbnail($postid, $theneeds_item_size);
					$theneeds_img_html = $theneeds_img_html . '</div>';
				}
			}
		}
		return $theneeds_img_html;
	}
	
	 
	/* News Element Function */
	function theneeds_print_news_item($item_xml){

		/* Removed Due To VC */
	
	}	
	
	
	/* Latest Show For DJ */
	function theneeds_print_latest_show_item($item_xml){
		
		/* Removed Due To VC */
		
	}
	
	
              
	
	/* Latest News For Site */
	function theneeds_print_featured_item($item_xml){
	
		/* Removed Due To VC */
		
	}
	
	
	/* Latest News Element */
	function theneeds_print_latest_news_item($item_xml){
		
		/* Removed Due To VC */
		
	}