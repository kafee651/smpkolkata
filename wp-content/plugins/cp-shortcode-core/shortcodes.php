<?php
/*	
*	CrunchPress Shortcodes
*	---------------------------------------------------------------------
* 	@version	1.0
*   @ Package   Shortcode
* 	@author		CrunchPress
* 	@link		http://crunchpress.com
* 	@copyright	Copyright (c) CrunchPress
*	---------------------------------------------------------------------
*	This file manage to embed the shortcodes to each page
*	based on the content of that page.
*	---------------------------------------------------------------------
*/
	
	/* Call Script only at Frontend*/
	if(!is_admin()){
		add_action('wp_enqueue_scripts','register_short_code');
	}
	
	function register_short_code(){
		/* Calling the Css File for Shortcodes */
		//wp_enqueue_style('theneeds_shortcode',theneeds_PATH_URL.'/frontend/shortcodes/css/shortcode.css');
	}
	

	/* 1. */ add_shortcode('tab', 'theneeds_tab_shortcode');
	
	/* 2. */ add_shortcode('tab_item', 'theneeds_tab_item_shortcode');
	
	/* 3. */ add_shortcode('heading', 'theneeds_heading_shortcode'); 		
	
	/* 4. */ add_shortcode('column', 'theneeds_column_shortcode');
	
	/* 5. */ add_shortcode('acc_item', 'theneeds_acc_item_shortcode');
	
	/* 6. */ add_shortcode('accordion', 'theneeds_accordion_shortcode');

	/* 7. */ add_shortcode('youtube', 'theneeds_youtube_shortcode');
	
	/* 8. */ add_shortcode('vimeo', 'theneeds_vimeo_shortcode');
	
	/* 9. */ add_shortcode('map', 'theneeds_map_shortcode');
	
	/* 10. */ add_shortcode('person', 'theneeds_person_shortcode');
	
	/* 11. */ add_shortcode('testimonials', 'theneeds_testimonials_shortcode');

	/* 12. */ add_shortcode('progress_bar', 'theneeds_progress_bar_shortcode');			

	/* 13. */ add_shortcode('theneeds_donation', 'theneeds_donation_shortcode');

	/* 14. */ add_shortcode('lightbox', 'theneeds_lightbox_shortcode');
	
	/* 15. */ add_shortcode('soundcloud', 'theneeds_soundcloud_shortcode');		
	
	/* 16. */ add_shortcode('pricing_table', 'theneeds_pricing_table_shortcode');
	
	/* 17. */ add_shortcode('pricing_header', 'theneeds_pricing_header_shortcode');
	
	/* 18. */ add_shortcode('pricing_price', 'theneeds_pricing_price_shortcode');
	
	/* 19. */ add_shortcode('pricing_column', 'theneeds_pricing_column_shortcode');
	
	/* 20. */ add_shortcode('pricing_row', 'theneeds_pricing_row_shortcode');
	
	/* 21. */ add_shortcode('pricing_footer', 'theneeds_pricing_footer_shortcode');
	
	/* 22. */ add_shortcode('button', 'theneeds_buttons_shortcode');

	/* 23. */ add_shortcode('metro_button', 'theneeds_metro_shortcode');

	/* 24. */ add_shortcode('services', 'theneeds_services_shortcode');
	
	/* 25. */ add_shortcode('separator', 'theneeds_separator_shortcode');

	/* 26. */ add_shortcode('project_facts', 'theneeds_project_facts_shortcode');
	
	/* 27. */ add_shortcode('toggle_box', 'theneeds_toggle_box_shortcode');
	
	/* 27. 1 */ add_shortcode('toggle_item', 'theneeds_toggle_item_shortcode');
	
	/* 28 */ add_shortcode('donation_bar', 'theneeds_donation_bar_shortcode');
	
	/* 29 */ add_shortcode('banner_tab', 'theneeds_banner_tab_shortcode');
	
	/* 29. 1 */ add_shortcode('banner_tab_item', 'theneeds_banner_tab_item_shortcode');
	
	/* 30 */ add_shortcode('parallex_box_icons', 'theneeds_parallex_box_icons_shortcode');
	
	/* 30.1 */ add_shortcode('parallex_box_item', 'theneeds_parallex_box_item_shortcode');
	
	/* 31 */ add_shortcode('parallex_box_icons_church', 'theneeds_parallex_box_icons_church_shortcode');
	
	/* 31.1 */ add_shortcode('parallex_box_item_church', 'theneeds_parallex_box_item_church_shortcode');
	
	/* 32 */ add_shortcode('newsletter_section', 'theneeds_newsletter_section');
	
	/* 33 */ add_shortcode('project_slider', 'theneeds_project_slider');
	
	/* 34 */ add_shortcode('event_counter', 'theneeds_event_counter_shortcode');
	
	/* 35 */ add_shortcode('title', 'theneeds_title_shortcode');
	
	/* 36 */ add_shortcode('text', 'theneeds_text_shortcode');
	
	/* 37 */ add_shortcode('checklist', 'theneeds_checklist_shortcode');
	
	/* 38 */ add_shortcode('counter_circle', 'theneeds_progress_shortcode');
	
	/* 39 */ add_shortcode('newspost_slider', 'theneeds_newspost_slider');
	
	/* 40 */ add_shortcode('login', 'theneeds_login');
	
	/* 41 */ add_shortcode('register', 'theneeds_register');
	
	/* 42 */ add_shortcode('comingsoon1', 'theneeds_coming_soon_1');
	
	/* 43 */ add_shortcode('comingsoon2', 'theneeds_coming_soon_2');
	
	/* 44. */ add_shortcode('facts_count', 'theneeds_facts_count_shortcode');
	
	
	/* Custom Shortcode For VC */
	/****/ add_shortcode('get_progress_post', 'theneeds_get_progress_post');
	
	/**************************************************************************************************/
	
	
	add_filter('the_content', 'fix_shortcodes');
	
	function fix_shortcodes($content){   
		$array = array (
			'<p>[' => '[', 
			']</p>' => ']', 
			']<br />' => ']'
		);
		
		$content = strtr($content, $array);
		return $content;
	}
	
	
	/**************************************************************************************************/
	
	/********* 01. Project Facts ShortCode Start ***********/
	function theneeds_tab_shortcode($atts, $content = null)
	{
		global $theneeds_tab_array,$counter;
		$theneeds_tab_array = array();
		do_shortcode($content);
		$num = sizeOf($theneeds_tab_array);
		
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('cp-tabs-script', theneeds_PATH_URL.'/frontend/shortcodes/js/tabs_script.js', false, '1.0', true);
		
		$tab = "<div id='horizontal-tabss' class='tabs tabs-widget tabs-box'><ul class='cp-divider nav nav-tabs'>";
		for ($i = 0; $i < $num; $i++) {

			$active = ($i == 0) ? 'active' : '';
			$tab_id = str_replace(' ', '-', $theneeds_tab_array[$i]["title"]);
			$tab    = $tab . '<li class = "">';
			$tab    = $tab . '<a href="#' . $tab_id.$i . '" >'.$theneeds_tab_array[$i]["title"] . '</a></li>';
		}
		$tab = $tab . "</ul>";
	
		$tab = $tab . "<div class='tab-content'>";
		for ($i = 0; $i < $num; $i++) {
			$active = ($i == 0) ? 'active' : '';
			$tab_id = str_replace(' ', '-', $theneeds_tab_array[$i]["title"]);
			$tab    = $tab . '<div id="' . $tab_id.$i . '" class="tab-pane tabscontent">';
			$tab    = $tab . $theneeds_tab_array[$i]["content"] . '</div>';
		}
		$tab = $tab . "</div></div>";
		return $tab;
	}
	
	/********* 02. Tab Item ShortCode Start ***********/
	function theneeds_tab_item_shortcode($atts, $content = null)
	{

		extract(shortcode_atts(array(
			"title" => ''
		), $atts));
		global $theneeds_tab_array;
			$theneeds_tab_array[] = array(
			"title" => $title,
			"content" => do_shortcode($content)
		);
	}
	
	/********* 03. Heading ShortCode Start ***********/
	function theneeds_heading_shortcode($atts,$content = null){
		extract(shortcode_atts(array(
			'align' => '',
			'title' => '',
			'title_color' => '',
			'style' => '',
			'desc_color' => '',
			'description' => '',						
			'tag' => 'h2',
			
		), $atts));
		
		$heading_html = '';
		if($title_color == 'theme'){
			$color_scheme = theneeds_get_themeoption_value('color_scheme','general_settings');
			$title_color = $color_scheme;
		}
		if($desc_color == 'theme'){
			$color_scheme = theneeds_get_themeoption_value('color_scheme','general_settings');
			$desc_color = $color_scheme;
		}
		
		if($style == 'simple-heading'){
			$heading_html = '
			<div class="cp-heading-container" style="text-align:'.$align.'">
				<div class="heading-style-1">
				   <'.$tag.' style="color:'.$title_color.'">'.do_shortcode(html_entity_decode($title)).'</'.$tag.'>
				</div>
				<p style="color:'.$desc_color.'">'.$description.'</p>
			</div>';
		}else if($style == 'eco-heading'){
		$heading_html = '
			<div class="cp-heading-container" style="text-align:'.$align.'">
				<div class="heading-style-5"> 
				  <h2 style="color:'.$title_color.'">'.do_shortcode(html_entity_decode($title)).'</h2>
				</div>
				<p style="color:'.$desc_color.'">'.$description.'</p>
			</div>';
		}else if($style == 'islamic-heading'){
		$heading_html = '
			<div class="cp-heading-container" style="text-align:'.$align.'">
				<div class="heading-style-4">
				 <h2 style="color:'.$title_color.'">'.do_shortcode(html_entity_decode($title)).'</h2>
				</div>
				<p style="color:'.$desc_color.'">'.$description.'</p>
			</div>';
		}else if($style == 'church-heading'){
			$heading_html = '
			<div class="cp-heading-container" style="text-align:'.$align.'">
			<div class="heading-style-3" style="text-align:'.$align.'">
			  <h2 style="color:'.$title_color.'">'.do_shortcode(html_entity_decode($title)).'</h2>
			  <ul>
				<li class="bullet-1"></li>
				<li class="bullet-2"></li>
				<li class="bullet-3"></li>
				<li class="bullet-2"></li>
				<li class="bullet-1"></li>
			  </ul>
			</div>
			<p style="color:'.$desc_color.'">'.$description.'</p>
			</div>
			';
		}else if($style == 'politics-heading'){
		$heading_html = '
			<div class="cp-heading-container" style="text-align:'.$align.'">
				<div class="heading-style-2">
				  <h2 style="color:'.$title_color.'">'.do_shortcode(html_entity_decode($title)).'</h2>
				</div>
				<p style="color:'.$desc_color.'">'.$description.'</p>
			</div>	';
		}else if($style == 'store-heading'){
			$heading_html = '
			<div class="cp-heading-container" style="text-align:'.$align.'">
				<div class="heading-style-7">
				  <h2 style="color:'.$title_color.'">'.do_shortcode(html_entity_decode($title)).'</h2>
				</div>';
				if(!empty($description)){
					$heading_html .= '<p style="color:'.$desc_color.'">'.$description.'</p>';
				}
			$heading_html .= '</div>';
		}else{
		
		}
		
		return $heading_html;
	
	}
	
	/********* 04. Project Facts ShortCode Start ***********/
	function theneeds_column_shortcode($atts, $content = null)
	{
			
		extract(shortcode_atts(array(
			"col" => '1/1'
		), $atts));
		
		switch ($col) {
			case '1/4':
				return '<div class="shortcode1-4">' . do_shortcode($content) . '</div>';
			case '1/3':
				return '<div class="shortcode1-3">' . do_shortcode($content) . '</div>';
			case '1/2':
				return '<div class="shortcode1-2">' . do_shortcode($content) . '</div>';
			case '2/3':
				return '<div class="shortcode2-3">' . do_shortcode($content) . '</div>';
			case '3/4':
				return '<div class="shortcode3-4">' . do_shortcode($content) . '</div>';
			default:
			case '1/1':
				return '<div class="shortcode1">' . do_shortcode($content) . '</div>';
		}
	}
	
	/********* 05. Accordion Item ShortCode Start ***********/
	function theneeds_acc_item_shortcode($atts, $content = null)
	{
		
		extract(shortcode_atts(array(
			"title" => ''
		), $atts));
		static $acc_count = 0;
		
		$acc_count++;
		
		
		$acc_item='';
		$acc_item .= '<div class="cp_aaccordion-row">';
		$acc_item .= '<div id="section-'.$acc_count.'" class="accordion_cp">'.$title.'<span><i class="fa fa-minus"></i></span> </div>';
		$acc_item .= '<div class="contain_cp_accor">
							<div class="content_cp_accor">
								<p>' . do_shortcode($content) . "</p>
							</div>
					 </div>
					</div>";
		
		$acc_count++;
		return $acc_item;
	}
	
	/********* 06. Accordion ShortCode Start ***********/
	function theneeds_accordion_shortcode($atts, $content = null)
	{
		
		wp_enqueue_script('cp-accordion', theneeds_PATH_URL.'/frontend/shortcodes/js/jquery.accordion.js', false, '1.0', true);
				
		$accordion = '';
		static $counter_accordion =0;
		$counter_accordion++;
		
		$accordion .= '
		
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$.fn.slideFadeToggle = function(speed, easing, callback) {
						return this.animate({
							opacity: "toggle",
							height: "toggle"
						}, speed, easing, callback);
					};

					if ($(".accordion_cp").length) {
						$(".accordion_cp").accordion({
							defaultOpen: "section-1",
							cookieName: "nav",
							speed: "slow",
							animateOpen: function(elem, opts) { //replace the standard slideUp with custom function
								elem.next().stop(true, true).slideFadeToggle(opts.speed);
							},
							animateClose: function(elem, opts) { //replace the standard slideDown with custom function
								elem.next().stop(true, true).slideFadeToggle(opts.speed);
							}
						});
					}
				});
			</script>';

		$accordion .= "<div class='cp-accordions'>";
		$accordion .= do_shortcode($content);
		$accordion .= "</div>";
		
		return $accordion;
	}
	
	
	

	
	/********* 07. Youtube ShortCode Start ***********/
	function theneeds_youtube_shortcode($atts, $content = null)
	{
		
		extract(shortcode_atts(array(
			"height" => '',
			"width" => ''
		), $atts));
		
		preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $content, $id);
		
		$youtube = '<div style="max-width:' . $width .'" >';
		$youtube = $youtube . '<iframe src="http://www.youtube.com/embed/' . $id[1] . '?wmode=transparent" width="' . $width . '" height="' . $height . '" ></iframe>';
		$youtube = $youtube . '</div>';
		return $youtube;
	}
	
	/********* 08. Vimeo ShortCode Start ***********/
	function theneeds_vimeo_shortcode($atts, $content = null)
	{
		
		extract(shortcode_atts(array(
			"height" => '',
			"width" => ''
		), $atts));
		$id = array('1'=>'55');
		
		preg_match('/http:\/\/vimeo.com\/(\d+)$/', $content, $id);
		
		$vimeo = '<div style="max-width:' . $width . '" >';
		$vimeo = $vimeo . '<iframe src="http://player.vimeo.com/video/' . $id[1] . '?title=0&amp;byline=0&amp;portrait=0" width="' . $width . '" height="' . $height . '" ></iframe>';
		$vimeo = $vimeo . '</div>';
		return $vimeo;
	}
	
	
	/********* 09. Map ShortCode Start ***********/
	function theneeds_map_shortcode($atts){
			
		static $counter_map = 1;
		$counter_map++;
		
		extract(shortcode_atts(array(
			'latitude' => '',
			'longitude' => '',
			'maptype' => 'terrain',
			'width' => '100%',
			'height' => '400px',
			'zoom' => '14',

		), $atts));
		
			
		$theneeds_select_layout_cp = '';
		$theneeds_primary_color = '';
		$theneeds_general_settings = get_option('general_settings');
		if($theneeds_general_settings <> ''){
			$theneeds_logo = new DOMDocument ();
			$theneeds_logo->loadXML ( $theneeds_general_settings );
			$theneeds_select_layout_cp = theneeds_find_xml_value($theneeds_logo->documentElement,'theneeds_select_layout_cp');
			$theneeds_primary_color = theneeds_find_xml_value($theneeds_logo->documentElement,'theneeds_primary_color');
		}
		
		$html = '<div class="cp-map-containter"><script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false"></script>';
		$html .= "<script type='text/javascript'>
		jQuery(document).ready(function($) {			
			var map;
			var myLatLng = new google.maps.LatLng(".$latitude.",".$longitude.")
			//Initialize MAP
			var myOptions = {
				zoom: ".$zoom.",
				center: myLatLng,
				disableDefaultUI: true,
				zoomControl: true,
				styles:[
					{
						stylers: [
							{ hue: '". $theneeds_primary_color."' },
							{ saturation: -10 },
						]
					}
				],
				scrollwheel: false,
				navigationControl: false,
				mapTypeControl: true,
				scaleControl: false,
				draggable: true,
				mapTypeId: google.maps.MapTypeId.".$maptype."
			};
			map = new google.maps.Map(document.getElementById('map_canvas-".$counter_map."'),myOptions);
			//End Initialize MAP
			//Set Marker
			var marker = new google.maps.Marker({
			  position: map.getCenter(),
			  map: map
			});
			marker.getPosition();
			//End marker
			
			//Set info window
			var infowindow = new google.maps.InfoWindow({
				content: '',
				position: myLatLng
			});
			//infowindow.open(map);
		});
		</script>";
		
		$html .= '<div style="width:'.$width.';height:'.$height.';" id="map_canvas-'.$counter_map.'" class="map_canvas"></div></div>';
		
		return $html;
	}
	
	/********* 10. Person ShortCode Start ***********/
	function theneeds_person_shortcode($atts,$content = null){
		
		extract(shortcode_atts(array(
			'type' => 'default',
			'name' => '',
			'picture' => '',
			'title' => '',
			'facebook' => '',
			'twitter' => '',
			'linkedin' => '',
			'dribbble' => '',
			'link' => '',
			
		), $atts));
		
		$html_team = '';
		
		$facebook = '<li><a href="'.$facebook.'"><i class="fa fa-facebook"></i></a></li>';
		$twitter = '<li><a href="'.$twitter.'"><i class="fa fa-twitter"></i></a></li>';
		$linkedin = '<li><a href="'.$linkedin.'"><i class="fa fa-google-plus"></i></a></li>';
		$dribbble = '<li><a href="'.$dribbble.'"><i class="fa fa-dribbble"></i></a></li>';

		if($type == 'team-boxed'){
		/* Team Boxed */
			$html_team = '
			<div class="about-me-left">
				<div class="frame">
					<a href="'.$link.'"><img alt="'.$title.'" src="'.$picture.'"></a>
				</div>	
				<div class="text">
					<ul>
						<li><h3>'.$name.'</h3></li>
						<li><strong class="title">'.$title.'</strong></li>
						<li>
							<div class="about-me-socila"><strong class="title">'.$content.'</strong>
								<ul>
									'.$facebook.$twitter.$linkedin.$dribbble.'
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</div>';
		}
		else{
		/* Team Circled */
			$html_team =  '
			<div class="'.$type.'">
				<div class="cp-thumb">
					<a href="'.$link.'">
						<img alt="'.$title.'" src="'.$picture.'">
					</a>
				</div>
				<div class="cp-social-icons">
					<ul>
						'.$facebook.$twitter.$linkedin.$dribbble.'
					</ul>
				</div>
				<div class="cp-text">
						<h4>'.$name.'</h4>
						<p>'.$title.'</p>
						<p>'.$content.'</p>
				</div>
			</div>';
		}
		
		return $html_team;
	}
	
	/********* 11. Testimonials ShortCode Start ***********/
	function theneeds_testimonials_shortcode($atts,$content = null){
		
		static $counter_testimonial = 1;
		$counter_testimonial++;
		$html_testimonial = '';
		
		wp_enqueue_script('cp-bx-slider', theneeds_PATH_URL.'/frontend/shortcodes/js/bxslider.min.js', false, '1.0', true);
		wp_enqueue_style('cp-bx-slider',theneeds_PATH_URL.'/frontend/shortcodes/css/bxslider.css');
		
		$html_testimonial .= '<script type="text/javascript">jQuery(document).ready(function($){$("#testimonials'.$counter_testimonial.'").bxSlider({mode: "fade",hideControlOnEnd: true,easing: "swing", controls: true, auto: true});});</script>';
		$html_testimonial .= '<div class="testi-bg">
			<ul id="testimonials'.$counter_testimonial.'" class="testi-slider">
				'.do_shortcode($content).'
			</ul>
		</div>';
		
		return $html_testimonial;
	
	}
	
	/********* 12. Progress Bar ShortCode Start ***********/
	function theneeds_progress_bar_shortcode($atts,$content = null){
		
		extract(shortcode_atts(array(
			'percentage' => '',
			'type' => 'progress-info',			
			
		), $atts));
		
			$html_bar = '
				
				<li> <strong class="title">'.$content.'</strong>
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="'.$percentage.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percentage.'%;"> <span class="sr-only">'.$percentage.'%</span> </div>
                  </div>
                </li>';
	
		return $html_bar;
	
	}
	
	/********* 13. Donation ShortCode Start ***********/
	function theneeds_donation_shortcode($atts,$content = null){
		
		$donation_button = theneeds_get_themeoption_value('donation_button','general_settings');
		$donate_btn_text = theneeds_get_themeoption_value('donate_btn_text','general_settings');
		$donation_page_id = theneeds_get_themeoption_value('donation_page_id','general_settings');
		$donate_email_id = theneeds_get_themeoption_value('donate_email_id','general_settings');
		$donate_title = theneeds_get_themeoption_value('donate_title','general_settings');
		$donation_currency = theneeds_get_themeoption_value('donation_currency','general_settings');
	
		
		$html_shortcode = '';
		
		$html_shortcode .= '
		<section class="donate-page">
			<div class="donate-form">
			  <form action="https://www.paypal.com/cgi-bin/webscr" class="donate-form-area">
					<input type="hidden" name="cmd" value="_donations" />
					<input type="hidden" name="business" value="'.$donate_email_id.'" />
					<input type="hidden" name="item_name" value="'.$donate_title.'" />
					<input type="hidden" name="return" value="' .get_permalink($donation_page_id). '" />
					<input type="hidden" name="bn" value="Subscribe" />
									
				<h4>'.__("Select Amount","crunchpress").'</h4>        
				<ul>
					
					<li>
						<input type="radio" class="radio" name="amount" id="radio_1" value="5" />
						<label for="radio_1">					
							<span class="show">5</span>
							<span class="show-hover">5</span>
						</label>
					</li>
					<li>
						<input type="radio" class="radio" name="amount" id="radio_2" value="10" />
						<label for="radio_2">					
							<span class="show">10</span>
							<span class="show-hover">10</span>
						</label>
					</li>
					<li>
						<input type="radio" class="radio" name="amount" id="radio_3" value="15" />
						<label for="radio_3">					
							<span class="show">15</span>
							<span class="show-hover">15</span>
						</label>
					</li>
					<li>
						<input type="radio" class="radio" name="amount" id="radio_4" value="18" />
						<label for="radio_4">					
							<span class="show">18</span>
							<span class="show-hover">18</span>
						</label>
					</li>
					<li>
						<input type="radio" class="radio" name="amount" id="radio_5" value="20" />
						<label for="radio_5">					
							<span class="show">20</span>
							<span class="show-hover">20</span>
						</label>
					</li>
					<li>
						<input type="radio" class="radio" name="amount" id="radio_6" value="25" />
						<label for="radio_6">					
							<span class="show">25</span>
							<span class="show-hover">25</span>
						</label>
					</li>
					<li>
						<input type="radio" class="radio" name="amount" id="radio_7" value="30" />
						<label for="radio_7">					
							<span class="show">30</span>
							<span class="show-hover">30</span>
						</label>
					</li>
					<li>
						<input type="radio" class="radio" name="amount" id="radio_8" value="35" />
						<label for="radio_8">					
							<span class="show">35</span>
							<span class="show-hover">35</span>
						</label>
					</li>
				</ul>
				<h3>'.__("OR","crunchpress").'</h3>
				<ul>
					<li>
						<label>'.__("Other Amount","crunchpress").'</label>
						<input name="amount" type="text" class="donate-input" placeholder="Enter Amount">
					</li>
					<li>
						<div>
						  <label for="currency">'.__("Change Currency Type","crunchpress").'</label>
						  <select id="currency" name="currency_code">';
								$options = array(
									'AUD' => 'Australian Dollars (A $)',
									'BRL' => 'Brazilian Real',
									'CAD' => 'Canadian Dollars (C $)',
									'CZK' => 'Czech Koruna',
									'DKK' => 'Danish Krone',
									'EUR' => 'Euros (&euro;)',
									'HKD' => 'Hong Kong Dollar ($)',
									'HUF' => 'Hungarian Forint',
									'JPY' => 'Yen (&yen;)',
									'MYR' => 'Malaysian Ringgit',
									'MXN' => 'Mexican Peso',
									'NOK' => 'Norwegian Krone',
									'NZD' => 'New Zealand Dollar ($)',
									'PHP' => 'Philippine Peso',
									'PLN' => 'Polish Zloty',
									'GBP' => 'Pounds Sterling (&pound;)',
									'RUB' => 'Russian Ruble',
									'SGD' => 'Singapore Dollar ($)',
									'SEK' => 'Swedish Krona',
									'CHF' => 'Swiss Franc',
									'TWD' => 'Taiwan New Dollar',
									'THB' => 'Thai Baht',
									'TRY' => 'Turkish Lira',
									'USD' => 'U.S. Dollars ($)',
								);
							foreach($options as $k=>$val){
								$condition = ($k == $donation_currency)? 'selected' : '';
								$html_shortcode .= '<option '.$condition.' value="'.$k.'">'.$val.'</option>';
							}
						$html_shortcode .= '</select>
						</div>
					</li>
				</ul>
				<input name="submit" type="image" value="'.__("continue","crunchpress").'" class="donate-btn-submit">
			</form>
		</div>
	</section>';
	return $html_shortcode;
	}
	
	/********* 14. Lightbox ShortCode Start ***********/
	function theneeds_lightbox_shortcode($atts,$content = null){
		
		extract(shortcode_atts(array(
			'title' => '',
			'href' => '#',			
			'src' => '',
			'align' => '',
			'margin' => '',
			
			
		), $atts));

		/* Calling the Required Files */
		wp_enqueue_script('cp-prettyPhoto', theneeds_PATH_URL.'/frontend/shortcodes/js/jquery.prettyphoto.min.js', false, '1.0', true);
		wp_enqueue_script('cp-pscript', theneeds_PATH_URL.'/frontend/shortcodes/js/pretty_script.js', false, '1.0', true);
		
		return $html = '<a style="margin:'.$margin.';float:'.$align.'" title="'.$title.'" href="'.$href.'" data-rel="prettyPhoto"><img src="'.$src.'" alt="'.$title.'" /></a>';
	
	}
	
	/********* 15. SoundCloud ShortCode Start ***********/
	function theneeds_soundcloud_shortcode($atts,$content = null){
		
		extract(shortcode_atts(array(
			'type' => '',
			'width' => '',
			'height' => '',
			'url' => '',			
			'color' => '',
			'auto_play' => '',
			'hide_related' =>'',
			'show_artwork_or_visual' => '',
			
		), $atts));
		
		/* Classic Embed HTML Markup */
		if($type == "classic-embed"){
		
			return '<iframe width="'.$width.'" height="'.$height.'" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.urlencode($url).'&amp;color='.$color.'&amp;auto_play='.$auto_play.'&amp;hide_related='.$hide_related.'&amp;show_artwork='.$show_artwork_or_visual.'"></iframe>';
		
		}else{
		
		/* Visual Embed HTML Markup */
			return '<iframe width="'.$width.'" height="'.$height.'" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.urlencode($url).'&amp;auto_play='.$auto_play.'&amp;hide_related='.$hide_related.'&amp;visual='.$show_artwork_or_visual.'"></iframe>';
		}	
	}
	
	/********* 16. Pricing Table ShortCode Start ***********/
	function theneeds_pricing_table_shortcode($atts,$content = null){
		
		extract(shortcode_atts(array(			
			'backgroundcolor' => '',
			'bordercolor' => '',
			'dividercolor' => '',
			
		), $atts));	
		static $counter_price = 1;
		$counter_price++;
		
		return '<style>#pricing-'.$counter_price.' .price-table{background-color:'.$backgroundcolor.'}#pricing-'.$counter_price.' .price-table .table-body ul li a{border-color:'.$dividercolor.'}#pricing-'.$counter_price.' .price-table .theneeds_price_table{border:1px solid '.$bordercolor.'}</style><div class="pricing"><div id="price-table" class="price-table">'.do_shortcode($content).'</div></div>';
	
	}
	
	/********* 17. Pricing Header ShortCode Start ***********/
	function theneeds_pricing_header_shortcode($atts,$content = null){
		
		extract(shortcode_atts(array(
			'title' => '',	
		
		), $atts));
		
		return '<div class="theneeds_price_table"><div class="table-header">
			<div class="pt-head">
				<h3>'.$title.'</h3>
			</div>'.do_shortcode($content).'</div>';
	}
	
	/********* 18. Pricing Price ShortCode Start ***********/
	function theneeds_pricing_price_shortcode($atts,$content = null){
		
		extract(shortcode_atts(array(
			'currency' => '',
			'price' => '',
			'time' => '',			
		), $atts));
		
		return '<div class="pt-price">
				<h2>'.$currency.$price.'<span>/'.$time.'</span></h2>
			</div>';
	}
	
	/********* 19. Pricing Column ShortCode Start ***********/
	function theneeds_pricing_column_shortcode($atts,$content = null){
		
		return '<div class="table-body"><ul>'.do_shortcode($content).'</ul></div></div>';
	
	}
	
	/********* 20. Pricing Row ShortCode Start ***********/
	function theneeds_pricing_row_shortcode($atts,$content = null){
		
		extract(shortcode_atts(array(
			'link' => '',			
		), $atts));
		return '<li class="cp-table-row"><a href="'.$link.'">'.do_shortcode($content).'</a></li>';
	}
	
	/********* 21. Pricing Footer ShortCode Start ***********/
	function theneeds_pricing_footer_shortcode($atts,$content = null){
		
		extract(shortcode_atts(array(
			'link' => '',
		), $atts));
		
		return '<a class="btn-style" href="'.$link.'">'.do_shortcode($content).'</a>';
	}
	
	/********* 22. Buttons ShortCode Start ***********/
	function theneeds_buttons_shortcode($atts,$content = null){
		
		static $counter_brn = 1;
		$counter_brn++;
		
		extract(shortcode_atts(array(
			'icon' => '',
			'size' => '',
			'backgroundcolor' => '',
			'color' => '',			
			'link' => '',

		), $atts));
		
		return '
		<div class="btn-container">
		<style>.cp-color-'.$counter_brn.'{background-color:'.$backgroundcolor.';color:'.$color.';}</style>
		<a href="'.$link.'" class="cp-btn-normal '.$size.' cp-color-'.$counter_brn.'"><i class="fa '.$icon.'"></i>'.do_shortcode($content).'</a></div>';
	
	}
	
	/********* 23. Metro ShortCode Start ***********/
	function theneeds_metro_shortcode($atts,$content = null){
		
		
		static $counter_metro = 1;
		$counter_metro++;
		$html = '';
		
		extract(shortcode_atts(array(
			'icon' => '',
			'size' => '',
			'backgroundcolor' => '',
			'textcolor' => '',
			'link' => '',
			
		), $atts));
		
		$html = '
		<div class="btn-container cp-metro-style">
		<style>.cp-color-metro-'.$counter_metro.'{background-color:'.$backgroundcolor.';color:'.$textcolor.';}</style>
		<a href="'.$link.'" class="cp-btn-metro '.$size.' cp-color-metro-'.$counter_metro.'"><i class="fa '.$icon.'"></i>'.$content.'</a></div>';
		
		return $html;
	
	}
	
	/********* 24. Services ShortCode Start ***********/
	function theneeds_services_shortcode($atts,$content = null){
		/* Fetch Parameters */
		extract(shortcode_atts(array(
			'layout' => '',
			'icon' => '',
			'title' => '',
			'excerpt_words' => '',			
			'link' => '',
			'linktext' => '',
			'service_class' => '',
			
		), $atts));
		
		$html = '';
		
		$excerpt_words = '100';
		

		if ($layout == 'circle-icon-top'){
			$html = '<div class="our-services services-style-2">
			<div class="services-box circle-icon-top '.$layout.'">
				<div class="fa-icon-box"><i class="fa '.$icon.'"></i></div>
				<div class="text-box">
					<h3><a href="'.$link.'">'.$title.'</a></h3>
					<p>'.substr($content , 0 , $excerpt_words).'</p>
					<a class="btn-8" href="'.$link.'">'.$linktext.'</a>
				</div>
			</div>
			</div>
			';

		}else if($layout == 'circle-icon-left'){
			
			if($service_class == 'service1'){
				
				$custom_service_class = "service_1";
				$custom_service_class_2 = '';
				
			}else{
				
				$custom_service_class = "service_2";
				$custom_service_class_2 = 'typo_service_2';
			}
			
			$html = '<div class="more-services">
			<div class="">
				<div class="round-box '.$custom_service_class.'"><i class="fa '.$icon.'"></i></div>
				<div class="text-box pull-left '.$custom_service_class_2.'">
					<h3><a href="'.$link.'">'.$title.'</a></h3>
					<p>'.$content.'</p>
				</div>
			</div>
			</div>
			';
		}else if($layout == 'circle-icon-right'){
			$html = '
			<div class="more-services">
				<div class="service-icon-right '.$layout.'">
					<div class="icon-box"><i class="fa '.$icon.'"></i></div>
					<div class="text-box">
						<h3><a href="'.$link.'">'.$title.'</a></h3>
						<p>'.$content.'</p>
					</div>
				</div>
			</div>';
		}else if($layout == 'box-icon-top'){
			
			if($service_class == 'service1'){
				
				$custom_service_class = "service_1";
				$custom_service_class_2 = 'features-section-3';
				$custom_service_btn_class = 'btn-more';
				
			}else{
				
				$custom_service_class = "service_2";
				$custom_service_class_2 = 'typo_service_2';
				$custom_service_btn_class = 'btn-8';
				
			}
		
			$html .= '
			<div class = "services_wrap '.$custom_service_class_2.'">
				<div class="features-2-box">
					<div class="icon-box">
						<a href="'.$link.'"><i class="fa '.$icon.'"></i></a>
					</div>
					<h3><a href="'.$link.'">'.$title.'</a></h3>
					<p>'.$content.'</p>
					<a class="'.$custom_service_btn_class.'" href="'.$link.'">'.$linktext.'</a>
				</div>
			</div>';
				
		}else if($layout == 'box-icon-right'){
			$html = '			
			<div class="service-icon-right '.$layout.'">
				<div class="icon-box"><i class="fa '.$icon.'"></i></div>
				<div class="text-area">
					<h3>'.$title.'</h3>
					<p>'.$content.'</p>
				</div>
			</div>			
			';
		}else if($layout == 'icon-right'){
			$html = '
			<div class="features-box">
				<div class="icon-box"><i class="fa '.$icon.'"></i></div>
				<div class="text-box">
					<h2>'.$title.'</h2>
					<p>'.$content.'</p>
				</div>
			</div>';
		}else if($layout == 'top-icon-box-outside'){
			$html = '
			<div class="features-2-box">
				<div class="icon-box">
					<a href="'.$link.'"><i class="fa '.$icon.'"></i></a>
				</div>
				<h3><a href="'.$link.'">'.$title.'</a></h3>
				<p>'.$content.'</p>
				<a class="btn-more" href="'.$link.'">'.$linktext.'</a>
			</div>';
		}else if($layout == 'top-icon-box-outside'){
		$html = '<div class="eco-features-box">
			<div class="frame">
				<a href="'.$link.'"><img alt="img" src="images/features/eco-features-img-2.jpg"></a>
				<div class="eco-icon"><a href="'.$link.'"><i class="fa fa-recycle"></i></a></div>
			</div>
			<div class="text-box">
				<h3><a href="'.$link.'">'.$title.'</a></h3>
				<p>'.$content.'</p>
				<a class="btn-5" href="'.$link.'">'.$linktext.'<i class="fa fa-arrow-right"></i></a>
			</div>
		</div>';
		}else{
			$html = '
				<div class ="features-section">
					<div class="inner-box">
						<div class="icon-box"><a href="'.$link.'"><i class="fa '.$icon.'"></i></a></div>
						<h3>'.$title.'</h3>
						<p>'.$content.'</p>
						<a class="btn-8" href="'.$link.'">'.$linktext.'<i class="fa fa-arrow-right"></i></a>
					</div>
				</div>
				';
		}
		return $html;
	
	}
	
	
	/********* 25. Seperator ShortCode Start ***********/
	function theneeds_separator_shortcode($atts,$content = null){
		extract(shortcode_atts(array(
			'style' => '',
			'size' => '1px',
			'margin_top_bottom' => '',
			'color' => '',
			
		), $atts));
		return '<div class="cp-separator" style="clear:both;width:100%;display:inline-block;margin:'.$margin_top_bottom.' 0px;border:'.$size.' '.$style.' '.$color.'"></div>';
	}
	
	
	/********* 26. Project Facts ShortCode Start ***********/
	function theneeds_project_facts_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			'icon' => '',
			'count' => '795',
			'text' => '',
			'image_url' => '',
			'border_right' => 'add',		
			'border_bottom' => 'remove',					
		
		), $atts));
		
		$counter = rand();
		
		?>
		<script>
		jQuery(document).ready(function($) {
			"use strict";
				if ($('.counter-<?php echo esc_js($counter); ?>').length) {
						$('.counter-<?php echo esc_js($counter); ?>').counterUp({
						delay: 10,
						time: 1000
					});
				}
		});
		
		</script>		
		<?php				
		/* HTML Markup */
		
		if($border_right == 'add' && $border_bottom == 'add'){
		
			$btm_class = 'border-btm-none';
			$right_class = 'border-none';
	
		}elseif($border_right == 'add' && $border_bottom == 'remove'){
		
			$btm_class = '';
			$right_class = 'border-none';
			
		}elseif($border_right == 'remove' && $border_bottom == 'add'){
		
			$btm_class = 'border-btm-none';
			$right_class = '';
		
		}else{
		
			$btm_class = '';
			$right_class = '';
		
		}
	
		
		$html =  '
				
				<div class="count-box '.$right_class . ' ' . $btm_class. '">';
				
				if(!empty($image_url)){
					$html .=  '<img src="'.esc_url($image_url).'" alt="'.esc_html__('image','theneeds').'"> ';
				}else{
					$html .=  '<i class="fa '.$icon.'"></i> ';
				}
				
				$html .=  '
					<strong class="number counter">'.$count.'</strong> 
					<span>'.$text.'</span>
				</div>';
 

		return $html;
	
	}
	
	/********* 44. Facts 2 ShortCode Start ***********/
	function theneeds_facts_count_shortcode($atts,$content = null){
		//Fetch Parameters
		extract(shortcode_atts(array(
			
			'count' => '795',
			'text' => '',
			'image_url' => '',
		
		), $atts));
		
		$counter = rand();
		
		?>
		<script>
		jQuery(document).ready(function($) {
			"use strict";
				if ($('.counter-<?php echo esc_js($counter); ?>').length) {
						$('.counter-<?php echo esc_js($counter); ?>').counterUp({
						delay: 10,
						time: 1000
					});
				}
		});
		
		</script>		
		<?php				
		/* HTML Markup */

		$html =  '
		
			<li> 
				<span class="icon"><img src="'.esc_url($image_url).'" alt="'.esc_html__('image','theneeds').'"></span>
				<div class="text-col"> <strong class="number counter">'.$count.'</strong> <span>'.$text.'</span> </div>
			</li>';
				
		return $html;
	
	}
	
	
	/********* 27. Toggle Box ShortCode Start ***********/
	
	function theneeds_toggle_box_shortcode($atts, $content = null)
	{
		
		wp_register_script('cp-accordian-script', theneeds_PATH_URL.'/frontend/shortcodes/js/accordian_script.js', false, '1.0', true);
		wp_enqueue_script('cp-accordian-script');
		$toggle_box = "<div class='accordion'>";
		$toggle_box = $toggle_box . do_shortcode($content);
		$toggle_box = $toggle_box . "</div>";
		return $toggle_box;
	}
	
	/********* 27.1 Toggle Box Item ShortCode Start ***********/
	
	function theneeds_toggle_item_shortcode($atts, $content = null)
	{
		extract(shortcode_atts(array(
			"title" => '',
			"active" => 'false'
		), $atts));
		$active      = ($active == "true") ? " " : '';
		$toggle_item = "<li class='cp-divider'>";
		$toggle_item = $toggle_item . "<h3 class='accordion-heading'><a href=''>";
		$toggle_item = $toggle_item . "<span class='toggle-box-head-image" . $active . "'></span>";
		$toggle_item = $toggle_item . $title . "</a></h3>";
		$toggle_item = $toggle_item . "<p class='toggle-box-content" . $active . "'>" . do_shortcode($content) . "</p>";
		$toggle_item = $toggle_item . "</li>";
		return $toggle_item;
	}
	
	/********* 28 Donation Bar ShortCode Start ***********/
	function theneeds_donation_bar_shortcode($atts,$content = null){
		/* Fetch Parameters */
		extract(shortcode_atts(array(
			'tag_line' => '',
			'title' => '',
			'progress_bar' => '40',
			'pledged_text' => '',			
			'link' => '',
			
		), $atts));
		
		$html = '';

		$html = '<section class="donation-section">
				  <div class="container">
					<div class="holder"> <strong class="title">'.$tag_line.'</strong>
					  <h2>'.$title.'</h2>
					  <div class="progress-bar-box">
						<div class="progress progress-striped active">
						  <div class="bar" style="width:'.$progress_bar.'%;"></div>
						</div>
					  </div>
					  <strong class="amount">'.$pledged_text.'</strong> <a href="'.$link.'" class="btn-3">Donate Now</a> </div>
				  </div>
				</section>';
		
		return $html;

	}
		
	
	/********* 29 Banner Tab ShortCode Start ***********/
	function theneeds_banner_tab_shortcode($atts, $content = null)
	{
		global $theneeds_tab_array,$counter;
		
		$theneeds_tab_array = array();
		
		do_shortcode($content);
		
		$num = sizeOf($theneeds_tab_array);

		/* Banner Tab Parent Div */
		$banner_tab = "<div class='banner-tab'><div class='container-fluid'><div class='row'>";

		for ($i = 0; $i < $num; $i++) {

			$banner_tab    = $banner_tab . '
								<div class="col-md-3 col-sm-3">
										<div class="box">
											<img src="'.$theneeds_tab_array[$i]["link"].'" alt="img">
											<h2><a href="'.$theneeds_tab_array[$i]["url"].'">'.$theneeds_tab_array[$i]["title"].'</a></h2>
											<p>'.$theneeds_tab_array[$i]["content"].'</p>
										</div>
								</div>';
		}

		$banner_tab = $banner_tab . '</div></div></div>';

		return $banner_tab;
	}
	
	/********* 29.1 Banner Tab ShortCode Start ***********/
	function theneeds_banner_tab_item_shortcode($atts, $content = null)
	{
		/* Fetch Parameters */
		extract(shortcode_atts(array(
			"link" => '',
			"title" => '',
			"url" => '',
			"caption" => '',
			
		), $atts));
		
		global $theneeds_tab_array;
			$theneeds_tab_array[] = array(
			"title" => $title,
			"link" => $link,
			"url" => $url,
			"content" => do_shortcode($content)
		);
	}
	
	/********* 30 Parallex Box Parent ShortCode Start ***********/
	function theneeds_parallex_box_icons_shortcode($atts, $content = null)
	{
	
		/* Fetch Parameters */
		extract(shortcode_atts(array(
			"heading" => '',
			"support_link" => '',
			"btn_style" => '',
			"btn_text" => '',
			
		), $atts));
		
		global $theneeds_tab_array,$counter;
		
		$theneeds_tab_array = array();
		
		do_shortcode($content);
		
		$num = sizeOf($theneeds_tab_array);
		
		

		/* Banner Tab Parent Div */
		$banner_tab = "<div class='parallax-box'><div class='text-box'><h2>".$heading."</h2><ul>";

		for ($i = 0; $i < $num; $i++) {

			$banner_tab    = $banner_tab . '
								<li>
									<div class="icon-box">
										<i class="fa '.$theneeds_tab_array[$i]["icon"].'"></i>
									</div>
									<div class="text-area">
										<h3>'.$theneeds_tab_array[$i]["title"].'</h3>
										<p>'.$theneeds_tab_array[$i]["content"].'</p>
									</div>
								</li>';
		}

		$banner_tab = $banner_tab . '</ul><a class="'.$btn_style.'" href="'.$support_link.'">'.$btn_text.'</a></div></div>';

		return $banner_tab;
	}
	
	/********* 30.1 Parallex Box Child ShortCode Start ***********/
	function theneeds_parallex_box_item_shortcode($atts, $content = null)
	{
		/* Fetch Parameters */
		extract(shortcode_atts(array(
			"icon" => '',
			"title" => '',
			"url" => '',
			"caption" => '',
			
		), $atts));
		
		global $theneeds_tab_array;
			$theneeds_tab_array[] = array(
			"title" => $title,
			"icon" => $icon,
			"url" => $url,
			"content" => do_shortcode($content)
		);
	}
	
	/********* 31 Parallex Box Church ShortCode Start ***********/
	function theneeds_parallex_box_icons_church_shortcode($atts, $content = null)
	{
	
		/* Fetch Parameters */
		extract(shortcode_atts(array(
			"heading" => '',
			"support_link" => '',
			
		), $atts));
		
		global $theneeds_tab_array,$counter;
		
		$theneeds_tab_array = array();
		
		do_shortcode($content);
		
		$num = sizeOf($theneeds_tab_array);
		
		

		/* Banner Tab Parent Div */
		$banner_tab = "<div class='parallax-area'><div class='text-box'><h2>".$heading."</h2><ul>";

		for ($i = 0; $i < $num; $i++) {

			$banner_tab    = $banner_tab . '
								<li>
									<i class="fa '.$theneeds_tab_array[$i]["icon"].'"></i>
									<strong>'.$theneeds_tab_array[$i]["title"].'</strong>
									<p>'.$theneeds_tab_array[$i]["content"].'</p>
								</li>';
		}

		$banner_tab = $banner_tab . '</ul></div></div>';

		return $banner_tab;
	}
	
	/********* 31.1 Parallex Box Church Child ShortCode Start ***********/
	function theneeds_parallex_box_item_church_shortcode($atts, $content = null)
	{
		/* Fetch Parameters */
		extract(shortcode_atts(array(
			"icon" => '',
			"title" => '',
			"url" => '',
			"caption" => '',
			
		), $atts));
		
		global $theneeds_tab_array;
			$theneeds_tab_array[] = array(
			"title" => $title,
			"icon" => $icon,
			"url" => $url,
			"content" => do_shortcode($content)
		);
	}
	
	/********* 32 Newsletter ShortCode Start ***********/
	function theneeds_newsletter_section($atts ,$content = null){
	/* Fetch Parameters */
		extract(shortcode_atts(array(
			'type' => '',
			'email' => ''
		), $atts));
		$html = '';
		/* NewsLetter 1 */
		if($type == 'newsletter-layout1'){
			$html = '
				<div class="newsletter-section">
					<form class="newsletter-form get-touch-form" id="frm_newsletter" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open(&#34;http://feedburner.google.com/fb/a/mailverify?uri='.$email.'&#34;, &#34;popupwindow&#34;, &#34;scrollbars=yes,width=600,height=550&#34;)">
						<input type="text" class="input-newsletter feedemail-input" name="email" onblur="this.value=this.value==&#34;&#34;?&#34;Enter your email&#34;:this.value;" onfocus="this.value=this.value==&#34;Enter your email&#34;?&#34;&#34;:this.value" value="Enter your email" />
						<input type="hidden" value="'.esc_attr($email).'" name="uri"/>
						<input type="hidden" name="loc" value="en_US"/>
						<input type="submit" value="'.esc_attr__('Subscribe','begood').'" />
					</form>
				</div>';
		/* NewsLetter 2 */
		}else if($type == 'newsletter-layout2'){
			$html = '
			<div class="newsletter-section newsletter-section-2">
				<form class="newsletter-form get-touch-form" id="frm_newsletter" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open(&#34;http://feedburner.google.com/fb/a/mailverify?uri='.$email.'&#34;, &#34;popupwindow&#34;, &#34;scrollbars=yes,width=600,height=550&#34;)">
					<input type="text" class="input-newsletter feedemail-input" name="email" onblur="this.value=this.value==&#34;&#34;?&#34;Enter your email for subscription...&#34;:this.value;" onfocus="this.value=this.value==&#34;Enter your email for subscription...&#34;?&#34;&#34;:this.value" value="Enter your email for subscription..." />
					<input type="hidden" value="'.esc_attr($email).'" name="uri"/>
					<input type="hidden" name="loc" value="en_US"/>
					<input type="submit" value="'.esc_attr__('Subscribe Now','begood').'" />
				</form>
			</div>';
		/* NewsLetter 3 */
		}else if($type == 'newsletter-layout3'){
			$html = '<div class="newsletter-form newsletter-2">
						<div class="cp-heading-container" style="text-align: center;">
						<div class="heading-style-3" style="text-align: center">
						  <h2 style="color:#fff;">SUBSCRIBE FOR NEWSLETTER</h2>
						  <ul>
							<li class="bullet-1"></li>
							<li class="bullet-2"></li>
							<li class="bullet-3"></li>
							<li class="bullet-2"></li>
							<li class="bullet-1"></li>
						  </ul>
						</div>
						<p style="color:#fff">Class aptent taciti sociosqu ad litora torquent per conubia nostra</p>
						</div>
					<form class="newsletter-form get-touch-form" id="frm_newsletter" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open(&#34;http://feedburner.google.com/fb/a/mailverify?uri='.$email.'&#34;, &#34;popupwindow&#34;, &#34;scrollbars=yes,width=600,height=550&#34;)">
						<input type="text" class="input-newsletter feedemail-input" name="email" onblur="this.value=this.value==&#34;&#34;?&#34;Enter your email for subscription...&#34;:this.value;" onfocus="this.value=this.value==&#34;Enter your email for subscription...&#34;?&#34;&#34;:this.value" value="Enter your email for subscription..." />
						<input type="hidden" value="'.esc_attr($email).'" name="uri"/>
						<input type="hidden" name="loc" value="en_US"/>
						<div class = "button-box-2">
							<input type="submit" value="'.esc_attr__('Subscribe Now','begood').'" />
						</div>
					</form>
				</div>';
		/* NewsLetter 4 */
		}else if($type == 'newsletter-layout4'){
			$html = '
			<div class="newsletter-section newsletter-section-3">
				<form class="newsletter-form get-touch-form" id="frm_newsletter" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open(&#34;http://feedburner.google.com/fb/a/mailverify?uri='.$email.'&#34;, &#34;popupwindow&#34;, &#34;scrollbars=yes,width=600,height=550&#34;)">
					<div class="row">
						<div class="col-md-4">
						<input type="text" placeholder="Enter Your Topic" required="" name="newsletter_topic_field">
						</div>
						<div class="col-md-4">
						<input type="text" placeholder="Write Your Question" required="" name="newsletter_question_field">
						</div>
						<div class="col-md-4">
						<input type="text" placeholder="Enter Your Email to Get Answer" required="" name="email">
						<input type="hidden" value="'.esc_attr($email).'" name="uri"/>
						<input type="hidden" name="loc" value="en_US"/>
						</div>
					</div>
					<div class="button-box">
						<input type="submit" value="'.esc_attr__('Submit Now','begood').'" />
					</div>
				</form>
			</div>';
		/* NewsLetter 5 */
		}else if($type == 'newsletter-layout5'){
			$html = '
			<div class="newsletter-section newsletter-2 eco-newsletter-wrap">
				<form class="newsletter-form get-touch-form" id="frm_newsletter" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open(&#34;http://feedburner.google.com/fb/a/mailverify?uri='.$email.'&#34;, &#34;popupwindow&#34;, &#34;scrollbars=yes,width=600,height=550&#34;)">
					<i class="fa fa-envelope"></i>
					<strong class="title">'.esc_attr__('Subscribe For Newsletter','begood').'</strong>
					<input type="text" placeholder="Enter your email for subscription..." required="" name="email">
					<input type="hidden" value="'.esc_attr($email).'" name="uri"/>
					<input type="hidden" name="loc" value="en_US"/>
					<input type="submit" value="'.esc_attr__('Submit Now','begood').'" />
				</form>
			</div>';
		}else{

		
		}	

	return $html;
	
	}
	
	/********* 33. Project Slider ShortCode Start ***********/
	function theneeds_project_slider($atts,$content = null){
		/* Fetch Parameters */
		extract(shortcode_atts(array(			
			'cat_id' => '0',
			'order' => 'desc',						
			'num_fetch' => '3',
		), $atts));
		
		static $counter_fund_id = 1;
		$counter_fund_id++;
		

		query_posts(array(
			'post_type' => 'ignition_product',
			'posts_per_page' => $num_fetch,
			'tax_query' => array(
				array(
					'taxonomy' => 'project_category',
					'terms' => $cat_id,
					'field' => 'term_id',
				)
			), 
			'post_status'       => 'publish',
			'orderby' 			=> 'date',
			'order' 			=> 'DESC'
		));
		
		if(have_posts()){
			
			
		/* Only For Islamic Version */
		$bg_value_slide = theneeds_get_themeoption_value('slide_bg_islamic','general_settings');
		
		if ($bg_value_slide == 'enable'){
			$slider_bg_islamic_version_slide = 'islamic-banner';
		}else {
			$slider_bg_islamic_version_slide = '';
		}
		
		echo '	
				<div class = "islamic-banner">';
					  /* Required Files */
						wp_register_script('cp-bx-slider', theneeds_PATH_URL.'/frontend/shortcodes/js/bxslider.min.js', false, '1.0', true);
						wp_enqueue_script('cp-bx-slider');	
						wp_register_script('cp-fitvids-slider', theneeds_PATH_URL.'/frontend/shortcodes/js/jquery.fitvids.js', false, '1.0', true);
						wp_enqueue_script('cp-fitvids-slider');	
						
						wp_enqueue_style('cp-bx-slider',theneeds_PATH_URL.'/frontend/shortcodes/css/bxslider.css');
						echo '<script type="text/javascript">jQuery(document).ready(function ($) { $("#home-banner").bxSlider({adaptiveHeight:true});});</script>
						<ul id="home-banner">';
						while( have_posts() ){
							the_post();	
							global $counter,$post;
							$ignition_date = get_post_meta($post->ID, 'ign_fund_end', true);
							$ignition_datee = date('d-m-Y h:i:s',strtotime($ignition_date));
							
							$ign_project_id = get_post_meta($post->ID, 'ign_project_id', true);
							
							$ign_fund_goal = get_post_meta($post->ID, 'ign_fund_goal', true);
							
							$ign_product_image1 = get_post_meta($post->ID, 'ign_product_image1', true);
							
							$thumbnail_id = get_post_thumbnail_id( $post->ID, 'ign_project_id', true );
			
							
							
							$getPledge_cp = theneeds_getPledge_cp($ign_project_id);
							$current_date = date('d-m-Y h:i:s');
							$project_date = new DateTime($ignition_datee);
							$current = new DateTime($current_date);
							$days = round(($project_date->format('U') - $current->format('U')) / (60*60*24));
							$thumbnail = wp_get_attachment_image_src( $thumbnail_id , array(1800,550) );
							$ign_project_description = get_post_meta( $post->ID, "ign_project_description", true );		

							echo '
							<li> <img src="'.esc_url($thumbnail[0]).'" alt="img">
								<div class="caption">
								  <div class="container">
									<div class="banner-caption">
									  <div class="banner-heading"><strong>'.esc_attr__('Featured Causes','begood').'</strong></div>
									  <strong class="title">'.esc_attr(substr(get_the_title(),0,25)).'</strong>
									  <p>'.substr(get_the_content(),0,159).'... <a href="'.esc_url(get_permalink()).'">[+]</a></p>
									  <ul>
										<li>Goals: $'.esc_attr($ign_fund_goal).'</li>
										<li>Raised: $'.esc_attr(theneeds_getPercentRaised_cp($ign_project_id)).'</li>
										<li>Donors: '.esc_attr($getPledge_cp[0]->p_number).'</li>
									  </ul>
									  <a href="'.esc_url(get_permalink()).'" class="donate">'.esc_attr__('Donate','begood').'</a> </div>
								  </div>
								</div>
							</li>';
						} wp_reset_postdata();
						echo '
					  </ul>
				</div>
			  <!--Banner End-->';
		} /* End of Condition Check */ 
		wp_reset_query();
	}
	
	
	/********* 34. Event Counter ShortCode Start ***********/
	function theneeds_event_counter_shortcode($atts,$content = null){
		
		$event_html = '';
		static $event_counter = 1;
		$event_counter++;
		extract(shortcode_atts(array(
			'title' => '',
			'event_id' => '',			
			'animation' => 'ticks',
			'color' => '#ffffff',
			'unfilled_color' => '#FFFFFF',
			'filled_color' => '#99CCFF',
			'width' => '500px',
			'height' => '150px',
			'circle_width_filled' => '1.2px',
			'circle_width_unfilled' => '0.1px',
			
		), $atts));
		
			
		$EM_Event = em_get_event($event_id,'post_id');

			wp_enqueue_script('cp-kinetic', theneeds_PATH_URL.'/frontend/js/kinetic.js', false, '1.0', true);
			
			wp_enqueue_script('cp-final-countdown', theneeds_PATH_URL.'/frontend/js/jquery.final-countdown.js', false, '1.0', true);
			
			wp_enqueue_script('cp-jquery-countdown', theneeds_PATH_URL.'/frontend/js/jquery_countdown.js', false, '1.0', true);

			
			
			
			$event_html .= '<div class="event-timer">
					  <div class="countdown countdown-container "
						 data-start="'.esc_attr(strtotime($EM_Event->event_start_date)).'"
						 data-end="'.esc_attr(strtotime($EM_Event->event_end_date)).'"
						 data-now="'.get_the_time('U').'"
						 data-border-color="rgba(255, 255, 255,1)">
						<div class="clock">
						  <div class="clock-item clock-days countdown-time-value">
							<div class="wrap">
							  <div class="inner">
								<div id="canvas-days" class="clock-canvas"></div>
								<div class="text">
								  <p class="val">0</p>
								  <p class="type-days type-time">DAYS</p>
								</div>
							  </div>
							</div>
							<span class="colun-1">:</span> </div>
						  <div class="clock-item clock-hours countdown-time-value">
							<div class="wrap">
							  <div class="inner">
								<div id="canvas-hours" class="clock-canvas"></div>
								<div class="text">
								  <p class="val">0</p>
								  <p class="type-hours type-time">HRS</p>
								</div>
							  </div>
							</div>
							<span class="colun-2">:</span> </div>
						  <div class="clock-item clock-minutes countdown-time-value">
							<div class="wrap">
							  <div class="inner">
								<div id="canvas-minutes" class="clock-canvas"></div>
								<div class="text">
								  <p class="val">0</p>
								  <p class="type-minutes type-time">MNTS</p>
								</div>
							  </div>
							</div>
							<span class="colun-3">:</span> </div>
						  <div class="clock-item clock-seconds countdown-time-value">
							<div class="wrap">
							  <div class="inner">
								<div id="canvas-seconds" class="clock-canvas"></div>
								<div class="text">
								  <p class="val">0</p>
								  <p class="type-seconds type-time">SECS</p>
								</div>
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					</div>';
		
		
		return $event_html;
	
	}
	
	/********* 35. Title ShortCode Start ***********/
	function theneeds_title_shortcode($atts,$content = null){
		/* Fetch Parameters */
		extract(shortcode_atts(array(
			'size' => '',
			
		), $atts));
		
		return '<'.$size.' class="cp-heading-full">'.do_shortcode($content).'</'.$size.'>';
	
	}
	
	/********* 36. Text ShortCode Start ***********/
	function theneeds_text_shortcode($atts,$content = null){
		/* Fetch Parameters */
		extract(shortcode_atts(array(
			'align' => '',
		), $atts));
			/* HTML Markup */
			$html = '';
			$html .= '<p class="cp-paragraph" style="text-align:'.$align.'">';
			$html .= do_shortcode($content);
			$html .= '</p>';
		
		return $html;
	
	}	
	
	/********* 37. Checklist ShortCode Start ***********/
	function theneeds_checklist_shortcode($atts,$content = null){
		/* Fetch Parameters */
		extract(shortcode_atts(array(
			'icon' => 'check',
			'iconcolor' => '',		
		), $atts));
				
		$icon_aw = get_fontawesome_code($icon);
		if($iconcolor == 'theme'){
			$color_scheme = theneeds_get_themeoption_value('color_scheme','general_settings');
			$iconcolor = $color_scheme;
		}
		/* Counter For Checklist */
		static $counter_checklist = 1;
		$counter_checklist++;		
		
		/* HTML Markup */
		return '<div class="list-cp-fw"><style scoped>.list-style-cp-'.$counter_checklist.' li:before{color:'.$iconcolor.'; content:"'.$icon_aw.'"}</style><div class="list-style-cp-'.$counter_checklist.' list-style cp-list-style">
		'.$content.'
		</div></div>';
	
	}
	
	/********* 38. Counter Circle ShortCode Start ***********/
	function theneeds_progress_shortcode($atts,$content = null){
		/* Fetch Parameters */
		extract(shortcode_atts(array(
			'filledcolor' => '#000000',
			'unfilledcolor' => '#ffffff',
			'percent' => '10',
			
		), $atts));
			
			static $counter_progress = 1;
			$counter_progress++;
			
			wp_register_script('cp-easy-chart', theneeds_PATH_URL.'/frontend/shortcodes/js/easy-pie-chart.js', false, '1.0', true);
			wp_enqueue_script('cp-easy-chart');			
			wp_register_script('cp-excanvas', theneeds_PATH_URL.'/frontend/shortcodes/js/excanvas.js', false, '1.0', true);
			wp_enqueue_script('cp-excanvas');			
			
			
		/* HTML Markup For Progress circle */
		$html_pro = " <div class='skill-inner'>
			<script type='text/javascript'>
				jQuery(document).ready(function($) {
					if($('#progress_bar-".$counter_progress."').length){
						var trackcolor = $('#progress_bar-".$counter_progress."').attr('data-trackcolor');
						var barcolor = $('#progress_bar-".$counter_progress."').attr('data-barcolor');
						if(!trackcolor.length){var trackcolor = '';}
						if(!barcolor.length){var barcolor = '';}
						$('#progress_bar-".$counter_progress."').easyPieChart({
							animate: 1000,
							barColor: barcolor,														lineWidth: 5,														size: 150,														animate: true,
							trackColor: trackcolor,
							onStep: function() {
								
							}
						});
					};
				});
			</script>
		<div class='chart'>
			<div id='progress_bar-".$counter_progress."' data-trackcolor='".$unfilledcolor."' data-barcolor='".$filledcolor."' class='percentage' data-percent='".$percent."'><span>".$percent."</span>%</div>
			<div class='label'>".do_shortcode($content)."</div>
		</div></div>";
	
		return $html_pro;
		
	}
	
	/********* 39. Newspost Slider ShortCode Start ***********/
	function theneeds_newspost_slider($atts,$content = null){
		/* Fetch Parameters */
		extract(shortcode_atts(array(			
			'cat_id' => '0',
			'num_fetch' => '3',
			'order' => 'desc',						
			
		), $atts));
		
		global $counter;
		
		query_posts(array(
			'post_type' => 'post',
			'posts_per_page' => $num_fetch,
			'post_status'       => 'publish',
			'orderby' 			=> 'date',
			'order' 			=> 'DESC'
		));

		
		if(have_posts()){
			echo '	
			<section class="blog-detail news-page">			
				<div class="news-frame">';

					 /* Required Scripts */
						wp_register_script('cp-bx-slider', theneeds_PATH_URL.'/frontend/shortcodes/js/bxslider.min.js', false, '1.0', true);
						wp_enqueue_script('cp-bx-slider');	
						wp_register_script('cp-fitvids-slider', theneeds_PATH_URL.'/frontend/shortcodes/js/jquery.fitvids.js', false, '1.0', true);
						wp_enqueue_script('cp-fitvids-slider');	
						wp_enqueue_style('cp-bx-slider',theneeds_PATH_URL.'/frontend/shortcodes/css/bxslider.css');
						
						echo '<script type="text/javascript">jQuery(document).ready(function ($) { $("#news-slider-'.$counter.'").bxSlider({auto: true, controls:true, pager:false});});</script>
					
						<ul id="news-slider-'.$counter.'">';
						
						while( have_posts() ){
							the_post();	
							global $counter,$post;
							$comment_count = wp_count_comments($post->ID);
							echo '<li> '.get_the_post_thumbnail($post->ID, array(1600,900)).'
									  <div class="caption">
										<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>
										<div class="detail-row">
										  <ul>
											<li><a href="'.get_the_permalink().'"><i class="fa fa-calendar"></i>'.get_the_date().'</a></li>
											<li><a href="'.get_the_permalink().'"><i class="fa fa-comments-o"></i>'.$comment_count->total_comments.'</a></li>
											<li><a href="'.get_the_permalink().'"><i class="fa fa-heart-o"></i>'.get_post_meta($post->ID,'popular_post_views_count',true).'</a></li>
										  </ul>
										</div>
									  </div>
									</li>';
						} wp_reset_postdata();
						echo '
					</ul>
				</div>
			</section> ';
		} /* End of Check */
		wp_reset_query();
	}
	
	/********* 40. Login Shortcode ***********/
	function theneeds_login(){
	
		wp_enqueue_script('cp-yasirkaform', theneeds_PATH_URL.'/frontend/js/form.js', false, '1.0', true);
		
		$login_html =
		
		'<section class="cp-login padding-tb-60">
		  <div class="container">
			<div class="holder">
				<div class="row">
				  <div class="col-md-12">';
					
						if(isset($_GET['login']) && $_GET['login'] == 'failed'){
							
							$login_html .= '
							
							<div id="login-error">
								<p>'.esc_html__('Login failed: You have entered an incorrect Username or password, please try again.','theneeds').'</p>
							</div>';
							
						}
						
						if(!is_user_logged_in()) { 
						
							$login_html .= '
							
							<section class="signup">
							  <div class="container">
								<div class="holder">';
								
									/* Set up some defaults. */
									$args = array(
										'echo' => false,
										'redirect' => home_url('/'),
										'form_id' => 'loginform',
										'label_username' => __( '' ),
										'label_password' => __( '' ),
										'label_remember' => __( 'Keep Me Logged In' ),
										'label_log_in' => __( 'Account Login' ),
										'id_username' => 'user_login',
										'id_password' => 'user_pass',
										'id_remember' => 'rememberme',
										'id_submit' => 'wp-submit',
										'remember' => true,
										'value_username' => NULL,
										'value_remember' => false 
									);
									
					
									$theneeds_signup_url = theneeds_get_themeoption_value('sign_up','general_settings');
								
									/* Merge the user input arguments with the defaults. */
									$login_html .= wp_login_form($args);
									
									if(shortcode_exists('miniorange_social_login')){
									
										$login_html .= '<div class = "login-social-box">'.do_shortcode('[miniorange_social_login]').'</div>';
									}
									
									if(!empty($theneeds_signup_url)){
									
										$login_html .= '<strong>'.esc_html__('Do Not have an Account?','theneeds').'<a href="'.esc_url($theneeds_signup_url).'">'.esc_html__('SIGNUP NOW','theneeds').'</a></strong>';
									
									}
									
									$login_html .= '<a class = "lost_password_an" href="'.esc_url( wp_lostpassword_url() ).'" title="'.esc_attr__( 'Password Lost and Found', 'theneeds' ).'">'.esc_html__( 'Lost your password?', 'theneeds' ).'</a>';
								
									$login_html .= '
								</div>
							  </div>
							</section>';
						
							
						
						} else {
							
							$login_html .= esc_url(wp_loginout( home_url('/')));
						}
						
					$login_html .= '
				 </div>
				</div>
			</div>
		  </div>
		</section>';
		
		return $login_html;
	}
	
	/********* 41. Register Shortcode ***********/
	function theneeds_register(){ 
		
		wp_enqueue_script('cp-yasirkaform', theneeds_PATH_URL.'/frontend/js/form.js', false, '1.0', true);?>
	
	
		<div id="main-content" class="main-content register-section">
		  <div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">
			  <?php if (!is_user_logged_in()) {
					global $post;
			  ?>
				<div class="container">
					<div class = "holder">
						<div class="step1">
						  <div>
							<?php 
								if(defined('REGISTRATION_ERROR')){
									foreach(unserialize(REGISTRATION_ERROR) as $error){
									  echo '<p class="order_error">'.$error.'</p><br>';
									}
								}?>
						  </div>
						</div>
						<section class="signup">
						  <div class="container">
							<div class="holder">
							<form id="my-registration-form" method="post" action="<?php echo add_query_arg('do', 'register', get_permalink( $post->ID )); ?>" class="form_comment">
								
								<div class="input-box">
									<input value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name'];?>" name="first_name" id="first_name" placeholder="<?php esc_html_e('First Name','theneeds');?>"  required="" type="text">
								</div>
								
								<div class="input-box">
									<input value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name'];?>" name="last_name" id="last_name" placeholder="<?php esc_html_e('Last Name','theneeds');?>"  required="" type="text">
								</div>
								
								<div class="input-box">
									<input value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>" name="email" id="email" placeholder="<?php esc_html_e('Email','theneeds');?>"  required="" type="text">
								</div>
								
								<div class="input-box">
									<input value="<?php if(isset($_POST['user'])) echo $_POST['user'];?>" name="user" id="username" placeholder="<?php esc_html_e('User Name','theneeds');?>"  required="" type="text">
								</div>
								
								<div class="input-box">
									<input value="" name="pass" id="password" placeholder="<?php esc_html_e('Password','theneeds');?>"  required="" type="Password">
								</div>
								
								<div class="input-box">
									<input value="" name="cpass" id="cpassword" placeholder="<?php esc_html_e('Confirm Password','theneeds');?>"  required="" type="Password">
								</div>
								
								<div class="input-box">
									<input value="<?php if(isset($_POST['phone'])) echo $_POST['phone'];?>" name="phone" id="phone" placeholder="<?php esc_html_e('Contact Number','theneeds');?>"  required="" type="text">
								</div>
								
								<div class="check-box">
									<input id="id4" type="checkbox" checked="checked" />
									<label for="id4"><?php esc_html_e('I have Read Terms &amp; Conditions','theneeds');?></label>
								</div>
								
								<div class="btn-row">
									<input name="submit" type="submit" class="btn-ser" value="<?php esc_html_e('Signup Now','theneeds');?>">
								</div>
								<?php
									
									$theneeds_sign_in = theneeds_get_themeoption_value('sign_in','general_settings');
									
									if(!empty($theneeds_sign_in)){
									
										echo '<strong>'.esc_html__('Already have an Account?','theneeds').'<a href="'.esc_url($theneeds_sign_in).'">'.esc_html__('LOGIN NOW','theneeds').'</a></strong>';
									
									}
								?>
							</form>
						  </div>
						</div>
						</section>
					</div>
				</div>
		  <?php }else{
					
					
					echo '<div class = "log_out_btn"><p class = "logout_message">'. esc_html__('You are already Logged In User! Do You want to ','theneeds').' </p>';
					echo esc_url(wp_loginout( home_url('/')));
					echo '</div>';
				} 
			?>
			</div>
		  </div>
		</div>
	<?php 	
	}
	
	/********* 42. Coming Soon Style 1 ***********/
	function theneeds_coming_soon_1($atts,$content = null){
	
		$theneeds_maintenance_mode_swtich = theneeds_get_themeoption_value('theneeds_maintenance_mode_swtich','general_settings');
		$theneeds_maintenace_title = theneeds_get_themeoption_value('theneeds_maintenace_title','general_settings');
		$theneeds_countdown_time = theneeds_get_themeoption_value('theneeds_countdown_time','general_settings');
		$theneeds_email_maintenance = theneeds_get_themeoption_value('theneeds_email_maintenance','general_settings');
		$theneeds_mainte_description = theneeds_get_themeoption_value('theneeds_mainte_description','general_settings');
		$theneeds_social_icons_maintenance = theneeds_get_themeoption_value('theneeds_social_icons_maintenance','general_settings');
		
		/* Get Date in Parts */
		$theneeds_event_year = date('Y',strtotime($theneeds_countdown_time));
		$theneeds_event_month = date('m',strtotime($theneeds_countdown_time));
		$theneeds_event_month_alpha = date('M',strtotime($theneeds_countdown_time));
		$theneeds_event_day = date('d',strtotime($theneeds_countdown_time));

		/* Change time format */
		$theneeds_event_start_time_count = date("G,i,s", strtotime($theneeds_countdown_time));
		
		/* Apply default Header logo */
		$header_logo = theneeds_get_themeoption_value('header_logo','general_settings');
		
		$image_src = '';
		
		if(!empty($header_logo)){ 
			$image_src = wp_get_attachment_image_src( $header_logo, 'full' );
			$image_src = (empty($image_src))? '': esc_url($image_src[0]);			
		}
		
		if($image_src == ''){
		
			$logo_url = 'comingsoon-logo.png';
			
			$image_src = esc_url(theneeds_PATH_URL.'/images/'.esc_attr($logo_url).'');
			
		}
		
		/* Countdown Scripts */
		wp_enqueue_script('cp-plugin', theneeds_PATH_URL.'/frontend/js/jquery.plugin.min.js', false, '1.0', true);
		wp_enqueue_script('cp-countdown', theneeds_PATH_URL.'/frontend/js/jquery.countdown.js', false, '1.0', true);
		
		echo '
		
		<section class="coming-soon">
		  <div class="container">
			<div class="inner">
			  <h1>'.($theneeds_maintenace_title).'</h1>
			  '.wpautop($theneeds_mainte_description).'
			  <div class="defaultCountdown"></div>
			  <h3>'.esc_html__('Subscribe To Our Newsletter','theneeds').'</h3>';
			  if(shortcode_exists('wysija_form')){
				echo do_shortcode('[wysija_form id="'.$theneeds_social_icons_maintenance.'"]');
			  }
			  echo '
			  <div class="btn-row"> <a href="'.esc_url(home_url('/')).'" class="btn-style-1">'.esc_html__('Back to Home','theneeds').'</a> </div>
			</div>
		  </div>
		</section>';

		?>
									
		<script>
			jQuery(document).ready(function($) {
			  "use strict";
				if ($('.defaultCountdown').length) {
					var austDay = new Date();
					austDay = new Date(<?php echo esc_html(intval($theneeds_event_year));?>, <?php echo esc_html(intval($theneeds_event_month));?>-1, <?php echo esc_html(intval($theneeds_event_day));?>);
					$('.defaultCountdown').countdown({
						until: austDay
					});
					$('#year').text(austDay.getFullYear());
				}
			});
		</script>
		<?php
	}
	
	/********* 43. Coming Soon Style 2 ***********/
	function theneeds_coming_soon_2($atts,$content = null){
	
		$theneeds_maintenance_mode_swtich = theneeds_get_themeoption_value('theneeds_maintenance_mode_swtich','general_settings');
		$theneeds_maintenace_title = theneeds_get_themeoption_value('theneeds_maintenace_title','general_settings');
		$theneeds_countdown_time = theneeds_get_themeoption_value('theneeds_countdown_time','general_settings');
		$theneeds_email_maintenance = theneeds_get_themeoption_value('theneeds_email_maintenance','general_settings');
		$theneeds_mainte_description = theneeds_get_themeoption_value('theneeds_mainte_description','general_settings');
		$theneeds_social_icons_maintenance = theneeds_get_themeoption_value('theneeds_social_icons_maintenance','general_settings');
		
		/* Get Date in Parts */
		$theneeds_event_year = date('Y',strtotime($theneeds_countdown_time));
		$theneeds_event_month = date('m',strtotime($theneeds_countdown_time));
		$theneeds_event_month_alpha = date('M',strtotime($theneeds_countdown_time));
		$theneeds_event_day = date('d',strtotime($theneeds_countdown_time));
		
		$current_time = time();
		$end_time = strtotime($theneeds_countdown_time);
		

		/* Change time format */
		$theneeds_event_start_time_count = date("G,i,s", strtotime($theneeds_countdown_time));
		
		/* Apply default Header logo */
		$header_logo = theneeds_get_themeoption_value('header_logo','general_settings');
		
		$image_src = '';
		
		if(!empty($header_logo)){ 
			$image_src = wp_get_attachment_image_src( $header_logo, 'full' );
			$image_src = (empty($image_src))? '': esc_url($image_src[0]);			
		}
		
		if($image_src == ''){
		
			$logo_url = 'comingsoon-logo-1.png';
			
			$image_src = esc_url(theneeds_PATH_URL.'/images/'.esc_attr($logo_url).'');
			
		}
		
		/* Countdown Scripts */
		wp_enqueue_script('cp-kinetic', theneeds_PATH_URL.'/frontend/js/kinetic.min.js', false, '1.0', true);
		wp_enqueue_script('cp-final-countdown', theneeds_PATH_URL.'/frontend/js/jquery.final.countdown.min.js', false, '1.0', true);
		
		echo '
		
		<body class="theme-style-1">
			<div id="wrapper">
				<div id="main"> 
					<section class="coming-soon-1 coming-soon-2">
					  <div class="container">
						<div class="holder"> <strong class="coming-soon-logo"><a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($image_src).'" alt="'.esc_html__('Logo','theneeds').'"></a></strong>
						  <h1>'.theneeds_split_title($theneeds_maintenace_title).'</h1>
						  <div class="countdown countdown-container">
							<div class="clock row">
								<div class="clock-item clock-days countdown-time-value col-sm-6 col-md-3">
									<div class="wrap">
										<div class="inner">
											<div id="canvas-days" class="clock-canvas"></div>

											<div class="text">
												<p class="val">0</p>
												<p class="type-days type-time">DAYS</p>
											</div><!-- /.text -->
										</div><!-- /.inner -->
									</div><!-- /.wrap -->
								</div><!-- /.clock-item -->

								<div class="clock-item clock-hours countdown-time-value col-sm-6 col-md-3">
									<div class="wrap">
										<div class="inner">
											<div id="canvas-hours" class="clock-canvas"></div>

											<div class="text">
												<p class="val">0</p>
												<p class="type-hours type-time">HOURS</p>
											</div><!-- /.text -->
										</div><!-- /.inner -->
									</div><!-- /.wrap -->
								</div><!-- /.clock-item -->

								<div class="clock-item clock-minutes countdown-time-value col-sm-6 col-md-3">
									<div class="wrap">
										<div class="inner">
											<div id="canvas-minutes" class="clock-canvas"></div>

											<div class="text">
												<p class="val">0</p>
												<p class="type-minutes type-time">MINUTES</p>
											</div><!-- /.text -->
										</div><!-- /.inner -->
									</div><!-- /.wrap -->
								</div><!-- /.clock-item -->

								<div class="clock-item clock-seconds countdown-time-value col-sm-6 col-md-3">
									<div class="wrap">
										<div class="inner">
											<div id="canvas-seconds" class="clock-canvas"></div>

											<div class="text">
												<p class="val">0</p>
												<p class="type-seconds type-time">SECONDS</p>
											</div><!-- /.text -->
										</div><!-- /.inner -->
									</div><!-- /.wrap -->
								</div><!-- /.clock-item -->
							</div><!-- /.clock -->
						  </div>
						</div>
					  </div>
					</section>
				</div>
			</div>
		</body>';
		?>
		<script type="text/javascript">
			jQuery(document).ready(function ($) {
				$('.countdown').final_countdown({
					'start': <?php echo $current_time ; ?>,
					'end': <?php echo $end_time ; ?>,
					'now': <?php echo $current_time ; ?>      
				});
			});
		</script>
									
	
		<?php
	}

	/********* Get Progress Post Custom VC Shortcode ***********/
	function theneeds_get_progress_post($atts,$content = null){
		/* Fetch Parameters */
		extract(shortcode_atts(array(			
		
			'post_id' => '',
			'element_title' => '',
			
		), $atts));
		
		global $counter;
		
		$progress_post_data = get_post($post_id);
		
		$theneeds_project_caption  = '';
				
			/* Get Post Meta Elements detail */
			$theneeds_progress_detail_xml = get_post_meta($progress_post_data->ID, 'progress_detail_xml', true);
			
			if($theneeds_progress_detail_xml <> ''){
			
				$theneeds_project_caption_xml = new DOMDocument ();

				$theneeds_project_caption_xml->loadXML ( $theneeds_progress_detail_xml );
				
				$progress_caption = theneeds_find_xml_value($theneeds_project_caption_xml->documentElement,'progress_caption');
				
				$selected_slider = theneeds_find_xml_value($theneeds_project_caption_xml->documentElement,'select_slider');
				
				$counter = rand(0,100);
				
					if ( !empty($selected_slider)){
						/* Print Slider */			
						$theneeds_slider_xml = get_post_meta( intval($selected_slider), 'cp-slider-xml', true); 				
						
						if($theneeds_slider_xml <> ''){
							$theneeds_slider_xml_dom = new DOMDocument();
							$theneeds_slider_xml_dom->loadXML($theneeds_slider_xml);
							$theneeds_img_html = '<div class = "tab-slider">';					
							$theneeds_img_html =  $theneeds_img_html .'<div class="frame"><div id="tab-slider'.$counter.'" class="owl-carousel owl-theme owl-work">';
							$theneeds_img_html = $theneeds_img_html . theneeds_work_progress_owl_slider($theneeds_slider_xml_dom->documentElement, '5000' ,'work-progress');
							$theneeds_img_html = $theneeds_img_html . '</div></div></div>';
						}
					}
				
			}

		$html = '
			
			<div class="tab-content-box">
                <div class="heading-style-1">
                  <h2>'.$element_title.'</h2>
                </div>
                <h3>'.$progress_caption.'</h3>
                '.wpautop($progress_post_data->post_content).'
                <a href="'.esc_url($progress_post_data->guid).'" class="btn-style-1">'.esc_html__('Learn More','theneeds').'</a> 
			</div>';
				/* If slider is not set */
				if(empty($selected_slider)){
						$html .= '<div class="tab-slider"><div class="frame">'.get_the_post_thumbnail($progress_post_data->ID, 'full').'</div></div>';
				}else{ 
					/* Slider */
					$html .= $selected_slider. $theneeds_img_html;
				}
			//$html .= '</div>';
			
								
		return $html;
		
		wp_reset_query();
		wp_reset_postdata();
	}
	
	
	
	/* Function For Checklist Shortcode */
	function get_fontawesome_code($icon_code = ''){
		/* Fontawesome icons list */
		$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
		$fontawesome_path = theneeds_TINYMCE_DIR . '/css/font-awesome.css';
		if( file_exists( $fontawesome_path ) ) {
			@$subject = file_get_contents($fontawesome_path);
		}

		preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

		foreach($matches as $match){
			
			if($match[1] == $icon_code){
				$icon_code = $match[2];
			}
		}
		return $icon_code;
	}