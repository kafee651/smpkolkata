<?php

	/*	
	*	CrunchPress Portfolio Option File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		CrunchPress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) CrunchPress
	*	---------------------------------------------------------------------
	*	This file create and contains the post post_type meta elements
	*	---------------------------------------------------------------------
	*/
	add_action('add_meta_boxes', 'add_post_option');
	
	function add_post_option(){
			
		add_meta_box('post-option', esc_html__('Post Options','theneeds'), 'add_post_option_element',
			'post', 'normal', 'high');
		
	}
	
	function add_post_option_element(){
		
		/* init array */
		$post_social = '';
		$sidebars = '';
		$right_sidebar_post = '';
		$left_sidebar_post = '';
		$audio_url_type = '';
		$post_thumbnail = '';
		$video_url_type = '';
		$select_slider_type = '';
		$seperate_link = '';
		$feature_post = '';
		$post_caption_field = '';
		
	
	
		foreach($_REQUEST as $keys=>$values){
			$$keys = $values;
		}
	
		global $post,$post_id;
	
		$post_detail_xml = get_post_meta($post->ID, 'post_detail_xml', true);
	
		if($post_detail_xml <> ''){
			$theneeds_post_xml = new DOMDocument ();
			$theneeds_post_xml->loadXML ( $post_detail_xml );
			$post_social = theneeds_find_xml_value($theneeds_post_xml->documentElement,'post_social');
			$sidebars = theneeds_find_xml_value($theneeds_post_xml->documentElement,'sidebar_post');
			$right_sidebar_post = theneeds_find_xml_value($theneeds_post_xml->documentElement,'right_sidebar_post');
			$left_sidebar_post = theneeds_find_xml_value($theneeds_post_xml->documentElement,'left_sidebar_post');
			$audio_url_type = theneeds_find_xml_value($theneeds_post_xml->documentElement,'audio_url_type');
			$post_thumbnail = theneeds_find_xml_value($theneeds_post_xml->documentElement,'post_thumbnail');
			$video_url_type = theneeds_find_xml_value($theneeds_post_xml->documentElement,'video_url_type');
			$select_slider_type = theneeds_find_xml_value($theneeds_post_xml->documentElement,'select_slider_type');
			$seperate_link = theneeds_find_xml_value($theneeds_post_xml->documentElement,'seperate_link');
			$post_caption_field = theneeds_find_xml_value($theneeds_post_xml->documentElement,'post_caption_field');
			
			
		}
	
		$feature_post = get_post_meta( $post->ID, 'feature_post', true); /* If not true return array */ ?>

		<div class="event_options cp-wrapper">
			<div class="row-fluid">
				<ul class="event_social_class recipe_class span12">
					<li class="panel-input">
						<span class="panel-title">
							<h3 for="post_social" > <?php esc_html_e('Social Networking', 'theneeds'); ?> 
							</h3>
						</span>	
						<label for="post_social"><div class="checkbox-switch <?php
						
						echo ($post_social=='enable' || ($post_social=='' && empty($default)))? 'checkbox-switch-on': 'checkbox-switch-off'; 

					?>"></div></label>
					<input type="checkbox" name="post_social" class="checkbox-switch" value="disable" checked>
					<input type="checkbox" name="post_social" id="post_social" class="checkbox-switch" value="enable" <?php 
						
						echo ($post_social=='enable' || ($post_social=='' && empty($default)))? 'checked': ''; 
					
					?>>
					<p><?php esc_html_e('You can turn On/Off social sharing from post detail.', 'theneeds'); ?></p>
					</li>
				</ul>
			</div>
			<div class="clear"></div>
			<?php 
			/* Post Sidebar */
				echo theneeds_show_sidebar($sidebars,'right_sidebar_post','left_sidebar_post',$right_sidebar_post,$left_sidebar_post);
			?>
			<div class="clear"></div>
			<div class="row-fluid">
				<ul class="recipe_class span3">
					<li class="panel-input">	
						<span class="panel-title">
							<h3 for="post_thumbnail"><?php esc_html_e('Select Type', 'theneeds'); ?></h3>
						</span>
						<div class="combobox">
							<select name="post_thumbnail" id="event_thumbnail">
								<option class="Image" value="Image" <?php if( $post_thumbnail == 'Image' ){ echo 'selected'; }?>><?php echo esc_html__('Feature Image','theneeds'); ?></option>
								<option class="Audio" value="Audio" <?php if( $post_thumbnail == 'Audio' ){ echo 'selected'; }?>><?php echo esc_html__('Audio','theneeds'); ?></option>
								<option class="Video" value="Video" <?php if( $post_thumbnail == 'Video' ){ echo 'selected'; }?>><?php echo esc_html__('Video','theneeds'); ?></option>
								<option class="Slider" value="Slider" <?php if( $post_thumbnail == 'Slider' ){ echo 'selected'; }?>><?php echo esc_html__('Slider','theneeds'); ?></option>
								<option class="link" value="link" <?php if( $post_thumbnail == 'link' ){ echo 'selected'; }?>><?php echo esc_html__('Link','theneeds'); ?></option>
							</select>
						</div>
						<p><?php esc_html_e('Please select your post type of content.', 'theneeds'); ?></p></li>			
					</li>
				</ul>
				<ul class="video_class recipe_class span3">						
					<li class="panel-input">
						<span class="panel-title">
							<label for="video_url_type" > <?php esc_html_e('Video URL', 'theneeds'); ?> </label>
						</span>		
						<input type="text" name="video_url_type" id="video_url_type" value="<?php if($video_url_type <> ''){echo esc_url($video_url_type);};?>" />
						<p><?php esc_html_e('Please paste Youtube or Vimeo url.', 'theneeds'); ?></p>
					</li>
				</ul>
				<ul class="audio_class recipe_class span3">
					<li class="panel-input">
						<span class="panel-title">
							<h3> <?php esc_html_e('AUDIO MP3 URL', 'theneeds'); ?> </h3>
						</span>
						<input type="text" name="audio_url_type" id="audio_url_type" value="<?php if($audio_url_type <> ''){echo esc_url($audio_url_type);};?>" />
						<p><?php esc_html_e('Please paste mp3 audio url.', 'theneeds'); ?></p>
					</li>
				</ul>
				<ul class="select_slider_option recipe_class span3">				
					<li class="panel-input">	
						<span class="panel-title">
							<h3><?php esc_html_e('Select Images Slide', 'theneeds'); ?></h3>
						</span>
						<div class="combobox">
							<select name="select_slider_type" id="select_slider_type">
								<?php foreach( theneeds_get_title_list_array('theneeds_slider') as $values){?>
									<option value="<?php echo esc_attr($values->ID);?>" <?php if($select_slider_type == $values->ID){echo 'selected';}?>><?php echo esc_attr($values->post_title);?></option>
								<?php }?>
							</select>
						</div>
						<p><?php esc_html_e('Please select slide to show in post.', 'theneeds'); ?></p>
					</li>
				</ul>
			</div>
			<div class = "row-fluid">
				<ul class="theneeds_right_sidebar recipe_class span6">						
					<li class="panel-input">
						<span class="panel-title">
							<label for="seperate_link" > <?php esc_html_e('Link', 'theneeds'); ?> </label>
						</span>		
						<input type="text" name="seperate_link" id="seperate_link" value="<?php if($seperate_link <> ''){echo esc_url($seperate_link);};?>" />
						<p><?php esc_html_e('Add Seperate URL In the Field for Link Post Type.', 'theneeds'); ?></p>
					</li>
				</ul>
				<ul class="theneeds_right_sidebar recipe_class span6">						
					<li class="panel-input">
						<span class="panel-title">
							<label for="post_caption_field" > <?php esc_html_e('Post Caption', 'theneeds'); ?> </label>
						</span>		
						<input type="text" name="post_caption_field" id="post_caption_field" value="<?php if($post_caption_field <> ''){echo esc_attr($post_caption_field);};?>" />
						<p><?php esc_html_e('Please Add Post Caption Here.', 'theneeds'); ?></p>
					</li>
				</ul>
			</div>
			<div class="clear"></div>
			<input type="hidden" name="default_post" value="post">			
			<div class="clear"></div>
		</div>	
		<div class="clear"></div> <?php	
	}
	
	/* Save Post Data */
	add_action('save_post','save_default_post_option_meta');
	
	function save_default_post_option_meta($post_id){	
		
		global $post_id;
				
		$post_social = '';
		$sidebars = '';
		$right_sidebar_post = '';
		$left_sidebar_post = '';
		$audio_url_type = '';
		$post_thumbnail = '';
		$video_url_type = '';
		$select_slider_type = '';
		$feature_post = '';
		$post_caption_field = '';
		

		/* save */
		foreach($_REQUEST as $keys=>$values){
			$$keys = $values;
		}
	
		if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;
			
		if(isset($default_post) AND $default_post == 'post'){
			
			$new_data = '<post_detail>';
			$new_data = $new_data . theneeds_create_xml_tag('post_social',$post_social);
			$new_data = $new_data . theneeds_create_xml_tag('sidebar_post',$sidebars);
			$new_data = $new_data . theneeds_create_xml_tag('right_sidebar_post',$right_sidebar_post);
			$new_data = $new_data . theneeds_create_xml_tag('left_sidebar_post',$left_sidebar_post);
			$new_data = $new_data . theneeds_create_xml_tag('audio_url_type',$audio_url_type);
			$new_data = $new_data . theneeds_create_xml_tag('post_thumbnail',$post_thumbnail);
			$new_data = $new_data . theneeds_create_xml_tag('video_url_type',$video_url_type);				
			$new_data = $new_data . theneeds_create_xml_tag('select_slider_type',$select_slider_type);
			$new_data = $new_data . theneeds_create_xml_tag('seperate_link',$seperate_link);
			$new_data = $new_data . theneeds_create_xml_tag('post_caption_field',$post_caption_field);
			$new_data = $new_data . update_post_meta ( $post_id, 'feature_post', $feature_post );			
			$new_data = $new_data . '</post_detail>';
			/* Saving Sidebar and Social Sharing Settings as XML */
			$old_data = get_post_meta($post_id, 'post_detail_xml',true);
			theneeds_save_meta_data($post_id, $new_data, $old_data, 'post_detail_xml');		
		}
	}
?>