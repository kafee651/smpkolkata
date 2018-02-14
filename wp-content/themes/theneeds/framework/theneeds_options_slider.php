<?php

	/*	
	*	CrunchPress Options File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		CrunchPress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) CrunchPress
	*	---------------------------------------------------------------------
	*	This file contains the CrunchPress panel elements and create the 
	*	CrunchPress panel at the back-end of the framework
	*	---------------------------------------------------------------------
	*/
	
add_action('wp_ajax_slider_settings','theneeds_slider_settings');
function theneeds_slider_settings(){

	foreach ($_REQUEST as $keys=>$values) {
		$$keys = trim($values);
	}
	
					$theneeds_return_data = array('success'=>'-1', 'alert'=>'Save option failed, please try contacting your host provider to increase the post_max_size and suhosin.post.max_vars variable on the server.');
					
					
					?>		
<div class="cp-wrapper bootstrap_admin cp-margin-left"> 

    <!--content area start -->	  
	<div class="hbg top_navigation row-fluid">
		<div class="cp-logo span2">
			<img src="<?php echo esc_url(theneeds_PATH_URL.'/framework/images/logo.png');?>" class="logo" />
		</div>
		<div class="sidebar span10">
			<?php echo theneeds_top_navigation_html_tooltip();?>
		</div>
	
	</div>
	<div class="content-area-main row-fluid"> 
	
      <!--sidebar start -->
      <div class="sidebar-wraper span2">
        <div class="sidebar-sublinks">
		<ul id="wp_t_o_right_menu">
				<li class="slide_settings" id="active_tab"><?php esc_attr_e('Slider Settings', 'theneeds'); ?></li>
			</ul>
        </div>
      </div>
		  <!--sidebar end --> 
      <!--content start -->
      <div class="content-area span10">
	 
        <form id="options-panel-form" name="cp-panel-form">
          <div class="panel-elements" id="panel-elements">
            <div class="panel-element" id="panel-element-save-complete">
              <div class="panel-element-save-text">
                <?php esc_html_e('Save Options Complete', 'theneeds'); ?>
                .</div>
              <div class="panel-element-save-arrow"></div>
            </div>
            <div class="panel-element">
			<?php
			if(isset($action) AND $action == 'slider_settings'){
				$slider_settings_xml = '<slider_settings>';
				$slider_settings_xml = $slider_settings_xml . theneeds_create_xml_tag('select_slider',esc_attr($select_slider));
				$slider_settings_xml = $slider_settings_xml . '<bx_slider_settings>';
				$slider_settings_xml = $slider_settings_xml . theneeds_create_xml_tag('slide_order_bx',esc_attr($slide_order_bx));
				$slider_settings_xml = $slider_settings_xml . theneeds_create_xml_tag('auto_play_bx',esc_attr($auto_play_bx));
				$slider_settings_xml = $slider_settings_xml . theneeds_create_xml_tag('pause_on_bx',esc_attr($pause_on_bx));
				$slider_settings_xml = $slider_settings_xml . theneeds_create_xml_tag('animation_speed_bx',esc_attr($animation_speed_bx));
				$slider_settings_xml = $slider_settings_xml . theneeds_create_xml_tag('show_bullets',esc_attr($show_bullets));
				$slider_settings_xml = $slider_settings_xml . theneeds_create_xml_tag('show_arrow',esc_attr($show_arrow));
				//Video Banner
				$slider_settings_xml = $slider_settings_xml . theneeds_create_xml_tag('video_slider_on_off',esc_attr($video_slider_on_off));
				$slider_settings_xml = $slider_settings_xml . theneeds_create_xml_tag('video_banner_url',esc_attr($video_banner_url));
				$slider_settings_xml = $slider_settings_xml . theneeds_create_xml_tag('video_banner_caption',esc_attr($video_banner_caption));
				$slider_settings_xml = $slider_settings_xml . theneeds_create_xml_tag('video_banner_title',esc_attr($video_banner_title));
				
				$slider_settings_xml = $slider_settings_xml . theneeds_create_xml_tag('safari_banner',esc_attr($safari_banner));
				$slider_settings_xml = $slider_settings_xml . theneeds_create_xml_tag('safari_banner_link',esc_attr($safari_banner_link));
				$slider_settings_xml = $slider_settings_xml . theneeds_create_xml_tag('safari_banner_width',esc_attr($safari_banner_width));
				$slider_settings_xml = $slider_settings_xml . theneeds_create_xml_tag('safari_banner_height',esc_attr($safari_banner_height));
				
				
				$slider_settings_xml = $slider_settings_xml . '</bx_slider_settings>';
				$slider_settings_xml = $slider_settings_xml . '</slider_settings>';

				if(!theneeds_save_option('slider_settings', get_option('slider_settings'), $slider_settings_xml)){
				
					die( json_encode($theneeds_return_data) );
				}
				
				die( json_encode( array('success'=>'0') ) );
			}
			$select_slider = '';
			
			//Flex slider
			$animation_type_flex = '';
			$reverse_order_flex = '';
			$startat_flex_slider = '';
			$auto_play_flex = '';
			$animation_speed_flex = '';
			$pause_on_flex = '';
			$navigation_on_flex = '';
			$arrow_on_flex = '';
			
			//Anything slider
			$slide_mod_anything = '';
			$auto_play_anything = '';
			$pause_on_anything = '';
			$animation_speed_anything = '';
			
			//Video Banner
			$video_slider_on_off = '';
			$video_banner_url = '';
			$video_banner_title = '';
			$video_banner_caption = '';
			
			//BX slider
			$slide_order_bx = '';
			$auto_play_bx = '';
			$pause_on_bx = '';
			$animation_speed_bx = '';
			$show_bullets = '';
			$show_arrow = '';
			
			//safari banner
			$safari_banner_link = '';
			$safari_banner = '';
			$safari_banner_width = '';
			$safari_banner_height = '';
			
			$theneeds_slider_settings = get_option('slider_settings');
			
			if($theneeds_slider_settings <> ''){
				$theneeds_slider = new DOMDocument ();
				$theneeds_slider->preserveWhiteSpace = FALSE;
				$theneeds_slider->loadXML ( $theneeds_slider_settings );

				//Bx Slider Values
				$slide_order_bx = esc_attr(find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','slide_order_bx'));
				$auto_play_bx = esc_attr(find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','auto_play_bx'));
				$pause_on_bx = esc_attr(find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','pause_on_bx'));
				$animation_speed_bx = esc_attr(find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','animation_speed_bx'));
				$show_bullets = esc_attr(find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','show_bullets'));
				$show_arrow = esc_attr(find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','show_arrow'));
				//Video Banner
				$video_slider_on_off = esc_attr(find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','video_slider_on_off'));
				$video_banner_url = esc_attr(find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','video_banner_url'));
				$video_banner_caption = esc_attr(find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','video_banner_caption'));
				$video_banner_title = esc_attr(find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','video_banner_title'));
				
				$safari_banner = esc_attr(find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','safari_banner'));
				$safari_banner_link = esc_attr(find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','safari_banner_link'));
				$safari_banner_width = esc_attr(find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','safari_banner_width'));;
				$safari_banner_height = esc_attr(find_xml_child_nodes($theneeds_slider_settings,'bx_slider_settings','safari_banner_height'));
				
			} 
			?>
			</div>
					<ul class="slide_settings">
						<li id="slide_settings" class="slider_settings_class active_tab">
							<ul class="recipe_class row-fluid">
								<li class="panel-input span8">	
									<span class="panel-title">
										<h3 for="select_slider"><?php esc_attr_e('SELECT SLIDER', 'theneeds'); ?></h3>
									</span>
									<div class="combobox">
										<select name="select_slider" id="select_slider">
											<option value="default" selected class="default"> <?php esc_html_e('--No Slider--','theneeds');?> </option>
											<option value="bx_slider" class="bx_slider"> <?php esc_html_e('BX Slider','theneeds');?> </option>
											
										</select>
									</div>
								</li>
								<li class="span4 right-box-sec"><p> <?php esc_html_e('Select slider/Banner for configuration.','theneeds');?> </p></li>
							</ul>	
							<div class="clear"></div>
							<div class="bx_slider_box">
								<h4> <?php esc_html_e('BX Slider Configurations','theneeds');?> </h4>
								<div class="row-fluid">
									<ul class="recipe_class span3">
										<li class="panel-input full-width">
											<span class="panel-title">
												<h3 for="slide_order_bx"><?php esc_html_e('Slider Effect', 'theneeds'); ?></h3>
											</span>
											<div class="combobox">
												<select name="slide_order_bx" id="slide_order_bx">
													<option value="slide" <?php if( esc_attr($slide_order_bx) == 'false' ){ echo sanitize_text_field('selected'); }?>> <?php esc_html_e('Slide','theneeds');?> </option>
													<option value="fade" <?php if( esc_attr($slide_order_bx) == 'false' ){ echo sanitize_text_field('selected'); }?>> <?php esc_html_e('Fade','theneeds');?> </option>
												</select>
											</div>
											<p><?php esc_html_e('Please select slider image order.','theneeds');?></p>
										</li>
									</ul>
									<ul class="panel-body recipe_class span3">
										<li class="panel-input full-width">
											<span class="panel-title">
												<h3 for="auto_play_bx" > <?php esc_html_e('AUTO PLAY', 'theneeds'); ?> </h3>
											</span>	
											<label for="auto_play_bx">
												<div class="checkbox-switch <?php echo (esc_attr($auto_play_bx) =='enable' || (esc_attr($auto_play_bx) ==''))? 'checkbox-switch-on': 'checkbox-switch-off';?>"></div>
											</label>
											<input type="checkbox" name="auto_play_bx" class="checkbox-switch" value="disable" checked>
											<input type="checkbox" name="auto_play_bx" id="auto_play_bx" class="checkbox-switch" value="enable" <?php echo (esc_attr($auto_play_bx) =='enable' || (esc_attr($auto_play_bx) ==''))? 'checked': ''; ?>>
											<p> <?php esc_html_e('Please turn on/off Slider autoplay.','theneeds');?><p>
										</li>
									</ul>
									<ul class="panel-body recipe_class span3">
										<li class="panel-input full-width">
											<span class="panel-title">
												<h3 for="pause_on_bx"><?php esc_html_e('PAUSE ON HOVER', 'theneeds'); ?></h3>
											</span>	
											<label for="pause_on_bx">
												<div class="checkbox-switch <?php echo (esc_attr($pause_on_bx) =='enable' || (esc_attr($pause_on_bx) ==''))? 'checkbox-switch-on': 'checkbox-switch-off';?>"></div>
											</label>
											<input type="checkbox" name="pause_on_bx" class="checkbox-switch" value="disable" checked>
											<input type="checkbox" name="pause_on_bx" id="pause_on_bx" class="checkbox-switch" value="enable" <?php echo (esc_attr($pause_on_bx) =='enable' || (esc_attr($pause_on_bx) ==''))? 'checked': ''; ?>>
											<p> <?php esc_html_e('Please On/Off slider pause on hover.','theneeds');?> </p>
										</li>
									</ul>
									<ul class="panel-body recipe_class span3">
										<li class="panel-input full-width">
											<span class="panel-title">
												<h3 for="animation_speed_bx" > <?php esc_html_e('ANIMATION SPEED', 'theneeds'); ?> </h3>
											</span>	
											<input type="text" name="animation_speed_bx" id="animation_speed_bx" value="<?php if(esc_attr($animation_speed_bx) <> ''){echo esc_attr($animation_speed_bx);};?>" />
											<p> <?php esc_html_e('Please define animation speed for slider.','theneeds');?> </p>
										</li>									
									</ul>
								</div>
								<div class="row-fluid">
									<ul class="panel-body recipe_class span3">
										<li class="panel-input full-width">
											<span class="panel-title">
												<h3 for="show_bullets"><?php esc_html_e('SHOW BULLETS NAVIGATION', 'theneeds'); ?></h3>
											</span>	
											<label for="show_bullets">
												<div class="checkbox-switch <?php echo (esc_attr($show_bullets) =='enable' || (esc_attr($show_bullets) ==''))? 'checkbox-switch-on': 'checkbox-switch-off';?>"></div>
											</label>
											<input type="checkbox" name="show_bullets" class="checkbox-switch" value="disable" checked>
											<input type="checkbox" name="show_bullets" id="show_bullets" class="checkbox-switch" value="enable" <?php echo (esc_attr($show_bullets) =='enable' || (esc_attr($show_bullets=='')))? 'checked': ''; ?>>
											<p> <?php esc_html_e('Please On/Off slider pause on hover.','theneeds');?> </p>
										</li>
									</ul>
									<ul class="panel-body recipe_class span3">
										<li class="panel-input full-width">
											<span class="panel-title">
												<h3 for="show_arrow"><?php esc_html_e('SHOW ARROW NAVIGATION', 'theneeds'); ?></h3>
											</span>	
											<label for="show_arrow">
												<div class="checkbox-switch <?php echo (esc_attr($show_arrow=='enable') || (esc_attr($show_arrow=='')))? 'checkbox-switch-on': 'checkbox-switch-off';?>"></div>
											</label>
											<input type="checkbox" name="show_arrow" class="checkbox-switch" value="disable" checked>
											<input type="checkbox" name="show_arrow" id="show_arrow" class="checkbox-switch" value="enable" <?php echo (esc_attr($show_arrow) =='enable' || (esc_attr($show_arrow) ==''))? 'checked': ''; ?>>
											<p> <?php esc_html_e('Please On/Off slider pause on hover.','theneeds');?> </p>
										</li>
									</ul>
								</div>
							</div>
						</li>
					</ul>
					<div class="">
            <div class="panel-element-tail">
              <div class="tail-save-changes">
                <div class="loading-save-changes"></div>
                <input type="submit" value="<?php echo esc_attr__('Save Changes','theneeds') ?>">
                <input type="hidden" name="action" value="slider_settings">
              </div>
            </div>
          </div>
        </form>
      </div>
      <!--content End --> 
    </div>
    <!--content area end --> 
  </div>
	<?php
	
}	
?>
