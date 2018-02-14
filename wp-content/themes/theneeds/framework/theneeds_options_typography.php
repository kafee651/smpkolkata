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
	
	add_action('wp_ajax_typography_settings','theneeds_typography_settings');
	
	function theneeds_typography_settings(){

		foreach ($_REQUEST as $keys=>$values) {
			$$keys = trim($values);
		}
	
		$theneeds_return_data = array('success'=>'-1', 'alert'=>'Save option failed, please try contacting your host provider to increase the post_max_size and suhosin.post.max_vars varialble on the server.');

		if(isset($action) AND $action == 'typography_settings'){
			$typography_xml = '<typography_settings>';
			$typography_xml = $typography_xml . theneeds_create_xml_tag('font_google',esc_attr($font_google));
			$typography_xml = $typography_xml . theneeds_create_xml_tag('font_size_normal',esc_attr($font_size_normal));
			$typography_xml = $typography_xml . theneeds_create_xml_tag('font_google_heading',esc_attr($font_google_heading));
			$typography_xml = $typography_xml . theneeds_create_xml_tag('menu_font_google',esc_attr($menu_font_google));
			$typography_xml = $typography_xml . theneeds_create_xml_tag('heading_h1',esc_attr($heading_h1));
			$typography_xml = $typography_xml . theneeds_create_xml_tag('heading_h2',esc_attr($heading_h2));
			$typography_xml = $typography_xml . theneeds_create_xml_tag('heading_h3',esc_attr($heading_h3));
			$typography_xml = $typography_xml . theneeds_create_xml_tag('heading_h4',esc_attr($heading_h4));
			$typography_xml = $typography_xml . theneeds_create_xml_tag('heading_h5',esc_attr($heading_h5));
			$typography_xml = $typography_xml . theneeds_create_xml_tag('heading_h6',esc_attr($heading_h6));
			$typography_xml = $typography_xml . theneeds_create_xml_tag('embed_typekit_code',esc_attr($embed_typekit_code));
			$typography_xml = $typography_xml . '</typography_settings>';
			
				$font_setting_xml = '<typekit_font>';
				$sidebars = $_POST['typekit_font'];
				foreach($sidebars as $keys=>$values){
					$font_setting_xml = $font_setting_xml . theneeds_create_xml_tag('typekit_font',$values);
				}
				$font_setting_xml = $font_setting_xml . '</typekit_font>';
				theneeds_save_option('typokit_settings', get_option('typokit_settings'), $font_setting_xml);
				
				
				if(!theneeds_save_option('typography_settings', get_option('typography_settings'), $typography_xml)){
				
					die( json_encode($theneeds_return_data) );
					
				}
				
				die(json_encode( array('success'=>'0') ) );
				
		} /* endif */
		
		$font_google = '';
		$font_size_normal = '';
		$menu_font_google = '';
		$fonts_array = '';
		$font_google_heading = '';
		$heading_h1 = '';
		$heading_h2 = '';
		$heading_h3 = '';
		$heading_h4 = '';
		$heading_h5 = '';
		$heading_h6 = '';
		$embed_typekit_code = '';
		$theneeds_typography_settings = get_option('typography_settings');
		
		
		if($theneeds_typography_settings <> ''){
			$theneeds_typo = new DOMDocument ();
			$theneeds_typo->loadXML ( $theneeds_typography_settings );
			$font_google = esc_attr(theneeds_find_xml_value($theneeds_typo->documentElement,'font_google'));
			$font_size_normal = esc_html(theneeds_find_xml_value($theneeds_typo->documentElement,'font_size_normal'));
			$menu_font_google = esc_html(theneeds_find_xml_value($theneeds_typo->documentElement,'menu_font_google'));
			$font_google_heading = esc_html(theneeds_find_xml_value($theneeds_typo->documentElement,'font_google_heading'));
			$heading_h1 = esc_html(theneeds_find_xml_value($theneeds_typo->documentElement,'heading_h1'));
			$heading_h2 = esc_html(theneeds_find_xml_value($theneeds_typo->documentElement,'heading_h2'));
			$heading_h3 = esc_html(theneeds_find_xml_value($theneeds_typo->documentElement,'heading_h3'));
			$heading_h4 = esc_html(theneeds_find_xml_value($theneeds_typo->documentElement,'heading_h4'));
			$heading_h5 = esc_html(theneeds_find_xml_value($theneeds_typo->documentElement,'heading_h5'));
			$heading_h6 = esc_html(theneeds_find_xml_value($theneeds_typo->documentElement,'heading_h6'));
			$embed_typekit_code = esc_html(theneeds_find_xml_value($theneeds_typo->documentElement,'embed_typekit_code'));
			
		}?>		

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
						<li class="font_family" id="active_tab"><?php esc_html_e('Font Family', 'theneeds'); ?></li>
						<li class="font_size"><?php esc_html_e('Font Size', 'theneeds'); ?></li>
						<li class="type_kit_font"><?php esc_html_e('Type Kit Font', 'theneeds'); ?></li>
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
                </div>
              <div class="panel-element-save-arrow"></div>
            </div>
            <div class="panel-element"></div>
			<ul class="typography_class">
				<li id="font_family" class="active_tab">
						
						<?php $fonts_array = theneeds_get_font_array();?>
						<ul class="recipe_class row-fluid">
							
							<li class="panel-input span8">	
								<span class="panel-title">
									<h3 for="font_google"><?php esc_html_e('FONT FAMILY', 'theneeds'); ?></h3>
								</span>
								<div class="combobox">
									<select class="font_google" name="font_google" id="font_google">
										<option <?php if( esc_attr($font_google) == 'Default' ){ echo 'selected'; }?> value="Default"><h3> <?php esc_html_e('Theme Default','theneeds');?> </h3></option>
										<optgroup label="GOOGLE FONT">
										<?php 
										foreach($fonts_array as $font_key =>$font_value){ 
											if(esc_attr($font_value['type']) == 'Google Font'){ ?>
												<option <?php if( esc_attr($font_google) == esc_html($font_key) ){ echo 'selected'; }?>><?php echo esc_attr($font_key); ?></option>
											<?php
											}
										}	
										?>
										</optgroup>		
										<!--Typekit Font Start -->
										<optgroup label="Typekit font">
										<?php
										$fonts_arr = theneeds_get_font_array();
										foreach($fonts_arr as $keys=>$values){
											if(esc_attr($values['type']) == 'Used font'){ ?>
												<option <?php if( esc_attr($font_google) == esc_html($keys) ){ echo 'selected'; }?>><?php echo esc_attr($keys); ?></option>
												<?php
											}
										}?>
										</optgroup>							
									</select>
								</div>
								<span class="description "><?php esc_html_e('Please Select font family from dropdown for website body text.','theneeds');?></span>
							</li>
							<li class="sample_text span4"><p class="option-font-sample" id="option-font-sample"><?php esc_html_e('SAMPLE TEXT','theneeds');?></p></li>
						</ul>
					
						<ul class="recipe_class row-fluid">
							<li class="panel-input span8">							
								<span class="panel-title">
									<h3 for="font_google_heading"><?php esc_html_e('FONT FAMILY HEADINGS', 'theneeds'); ?></h3>
								</span>
								<div class="combobox">
									<select class="font_google" name="font_google_heading" id="font_google_heading">
										<option <?php if( esc_attr($font_google_heading) == 'Default' ){ echo 'selected'; }?> value="Default"><h3> <?php esc_html_e('Theme Default','theneeds');?> </h3></option>
										<optgroup label="GOOGLE FONT">
										<?php 
										foreach($fonts_array as $font_key =>$font_value){ 
												if(esc_attr($font_value['type']) == 'Google Font'){ ?>
												<option <?php if( esc_attr($font_google_heading) == esc_attr($font_key) ){ echo 'selected'; }?>><?php echo esc_html($font_key); ?></option>
											<?php
											}
										}	
										?>
										
										<!--Typekit Font Start -->
										<optgroup label="Typekit font">
										<?php
										$fonts_arr = theneeds_get_font_array();
										foreach($fonts_arr as $keys=>$values){
											if(esc_attr($values['type']) == 'Typekit font'){ ?>
												<option <?php if( esc_attr($font_google_heading) == esc_attr($keys) ){ echo 'selected'; }?>><?php echo esc_attr($keys); ?></option>
												<?php
											}
										}?>
										</optgroup>							
									</select>
								</div>
								<span class="description"><?php esc_html_e('Please select font family from dropdown for website Headings.','theneeds');?></span>
							</li>
							<li class="sample_text span4"><p class="option-font-sample" id="option-font-sample"><?php esc_html_e('SAMPLE TEXT','theneeds');?></p></li>
						</ul>
						<ul class="recipe_class row-fluid">							
							<li class="panel-input span8">	
								<span class="panel-title">
									<h3 for="menu_font_google"><?php esc_html_e('MENU FONT FAMILY', 'theneeds'); ?></h3>
								</span>
								<div class="combobox">
									<select class="font_google" name="menu_font_google" id="menu_font_google">
										<option <?php if( esc_attr($menu_font_google) == 'Default' ){ echo 'selected'; }?> value="Default"><h3> <?php esc_html_e('Theme Default','theneeds');?> </h3></option>
										
										<div class="clear"></div>
										<optgroup label="GOOGLE FONT">
										<?php 
										foreach($fonts_array as $font_key =>$font_value){ 
											if(esc_attr($font_value['type']) == 'Google Font'){ ?>
												<option <?php if( esc_attr($menu_font_google) == esc_attr($font_key) ){ echo 'selected'; }?>><?php echo esc_attr($font_key); ?></option>
											<?php
											}
										}	
										?>
										</optgroup>		
										<!--Typekit Font Start -->
										<optgroup label="Typekit font">
										<?php
										$fonts_arr = theneeds_get_font_array();
										foreach($fonts_arr as $keys=>$values){
											if(esc_attr($values['type']) == 'Typekit font'){ ?>
												<option <?php if( esc_attr($menu_font_google) == esc_html($keys) ){ echo 'selected'; }?>><?php echo esc_attr($keys); ?></option>
												<?php
											}
										}?>
										</optgroup>							
									</select>
								</div>
								<span class="description"><?php esc_html_e('Please Select font family from dropdown for website Menu.','theneeds');?></span>
							</li>
							<li class="sample_text span4"><p class="option-font-sample" id="option-font-sample"><?php esc_html_e('SAMPLE TEXT','theneeds');?></p></li>
						</ul>
												
				</li>
				<li id="font_size">
					<h3><?php esc_attr_e('Font Size Settings','theneeds');?></h3>
						<ul class="panel-body recipe_class row-fluid">
							<li class="panel-input span8">
								<span class="panel-title">
									<h3 for="heading_h1" > <?php esc_html_e('BODY TEXT FONT SIZE', 'theneeds'); ?> </h3>
								</span>
								<div id="font_size_normal" class="sliderbar" rel="sliderbar"></div>
								<input type="hidden" name="font_size_normal" value="<?php echo esc_attr($font_size_normal);?>">
								<span class="description"><?php esc_html_e('Please manage font body size for your website body text.','theneeds');?></span>
							</li>
							<li class="span4" id="slidertext"><p><?php echo esc_attr($font_size_normal);?><?php esc_html_e('px','theneeds');?></p></li>
						</ul>
					
						<ul class="panel-body recipe_class row-fluid">
							<li class="panel-input span8">
								<span class="panel-title">
									<h3 for="heading_h1" > <?php esc_html_e('HEADING H1 SIZE', 'theneeds'); ?> </h3>
								</span>	
								<div id="heading_h1" class="sliderbar" rel="sliderbar"></div>
								<input type="hidden" name="heading_h1" value="<?php echo esc_attr($heading_h1);?>">
								<span class="description"><?php esc_html_e('Please manage font size for website Heading - h1','theneeds');?></span>
							</li>
							<li class="span4" id="slidertext"><p><?php echo esc_attr($heading_h1);?><?php esc_html_e('px','theneeds');?></p></li>							
						</ul>
					
						<ul class="panel-body recipe_class row-fluid">
							
							<li class="panel-input span8">
								<span class="panel-title">
									<h3 for="heading_h2" > <?php esc_html_e('HEADING H2 SIZE', 'theneeds'); ?> </h3>
								</span>	
								<div id="heading_h2" class="sliderbar" rel="sliderbar"></div>
								<input type="hidden" name="heading_h2" value="<?php echo esc_attr($heading_h2);?>">
								<span class="description"><?php esc_html_e('Please manage font size for website Heading - h2','theneeds');?></span>
							</li>
							<li class="span4" id="slidertext"><p><?php echo esc_attr($heading_h2);?><?php esc_html_e('px','theneeds');?></p></li>
						</ul>
						
						<ul class="panel-body recipe_class row-fluid">
							<li class="panel-input span8">
								<span class="panel-title">
									<h3 for="heading_h3" > <?php esc_html_e('HEADING H3 SIZE', 'theneeds'); ?> </h3>
								</span>	
								<div id="heading_h3" class="sliderbar" rel="sliderbar"></div>
								<input type="hidden" name="heading_h3" value="<?php echo esc_attr($heading_h3);?>">
								<span class="description"><?php esc_html_e('Please manage font size for website Heading - h3','theneeds');?> </span>
							</li>
							<li class="span4" id="slidertext"><p><?php echo esc_attr($heading_h3);?><?php esc_html_e('px','theneeds');?></p></li>
						</ul>
				
						<ul class="panel-body recipe_class row-fluid">
							<li class="panel-input span8">
								<span class="panel-title">
									<h3 for="heading_h4" > <?php esc_html_e('HEADING H4 SIZE', 'theneeds'); ?> </h3>
								</span>	
								<div id="heading_h4" class="sliderbar" rel="sliderbar"></div>
								<input type="hidden" name="heading_h4" value="<?php echo esc_attr($heading_h4);?>">
								<span class="description"><?php esc_html_e('Please manage font size for website Heading - h4','theneeds');?></span>
							</li>
							<li class="span4" id="slidertext"><p><?php echo esc_attr($heading_h4);?><?php esc_html_e('px','theneeds');?></p></li>
						</ul>
						
						<ul class="panel-body recipe_class row-fluid">
							<li class="panel-input span8">
								<span class="panel-title">
									<h3 for="heading_h5" > <?php esc_html_e('HEADING H5 SIZE', 'theneeds'); ?> </h3>
								</span>
								<div id="heading_h5" class="sliderbar" rel="sliderbar"></div>
								<input type="hidden" name="heading_h5" value="<?php echo esc_attr($heading_h5);?>">
								<span class="description"><?php esc_html_e('Please manage font size for website Heading - h5','theneeds');?></span>
							</li>
							<li class="span4" id="slidertext"><p><?php echo esc_attr($heading_h5);?><?php esc_html_e('px','theneeds');?></p> </li>
						</ul>
					
						<ul class="panel-body recipe_class row-fluid">
							<li class="panel-input span8">
								<span class="panel-title">
									<h3 for="heading_h6" > <?php esc_html_e('HEADING H6 SIZE', 'theneeds'); ?> </h3>
								</span>	
								<div id="heading_h6" class="sliderbar" rel="sliderbar"></div>
								<input type="hidden" name="heading_h6" value="<?php echo esc_attr($heading_h6);?>">
								<span class="description"><?php esc_html_e('Please manage font size for website Heading - h6','theneeds');?></span>
							</li>
							<li class="span4" id="slidertext"><p><?php echo esc_attr($heading_h6);?><?php esc_html_e('px','theneeds');?></p></li>
						</ul>					
				</li>	
				<li id="type_kit_font">
					<div class="typekit_font_class">
						<h3> <?php esc_html_e('Typekit Font Upload Settings','theneeds');?> </h3>
						<div class="type_kit">
							<ul class="panel-body recipe_class row-fluid">
								<li class="panel-input span8">
								<span class="panel-title">
									<h3 for="embed_typekit_code" > <?php esc_html_e('TYPEKIT EMBED CODE', 'theneeds'); ?> </h3>
								</span>	
									<textarea name="embed_typekit_code" id="embed_typekit_code" ><?php echo (esc_attr($embed_typekit_code) == '')? esc_attr($embed_typekit_code): esc_attr($embed_typekit_code);?></textarea>
								</li>
								<li class="span4 right-box-sec"><p><?php esc_html_e('Please paste TypeKit Embeded Code JavaScript Here.','theneeds');?></p></li>
							</ul>
							
						</div>
					</div>
				</li>
			</ul>			
			            <div class="clear"></div>
            <div class="panel-element-tail">
              <div class="tail-save-changes">
                <div class="loading-save-changes"></div>
                <input type="submit" value="<?php echo esc_html_e('Save Changes','theneeds') ?>">
                <input type="hidden" name="action" value="typography_settings">
                
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