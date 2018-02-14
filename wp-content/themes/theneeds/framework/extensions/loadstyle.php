<?php
	/* Ajax to include font infomation */

	add_action('wp_ajax_nopriv_theneeds_color_bg', 'theneeds_color_bg');

	add_action('wp_ajax_theneeds_color_bg','theneeds_color_bg');


	function theneeds_color_bg($recieve_color = '' , $bg_texture='',$navi_color='', $heading_color = '', $body_color = '',$select_layout_cp = '', $backend_on_off = ''){

		global $html_new;

		/*
		================================================

						Create StyleSheet

		================================================
		*/

		$html_new .= '<style id="stylesheet">';
		
		/*

		================================================

					TEXT SELECTION COLOR 

		================================================

		*/

		$html_new .= '::selection {

			background: '.esc_attr($recieve_color).'; /* Safari */

			color:#fff;

		}

		::-moz-selection {

			background: '.esc_attr($recieve_color).'; /* Firefox */

			color:#fff;

		}';

		/* Primary Color */

		$html_new .= '
		 
		{
			background-color:'.esc_attr($recieve_color).'; 

			color:#fff;

		}';
				
		$html_new .= '.top-bar .holder, .top-bar .holder:before, #nav li:hover > a, #nav li ul li a:hover, #nav li ul li:hover > a, .search-box, .top-bar .left-box .dropdown-menu li a:hover, .welcome-section .box:hover .icon-col:before, .donate-goal-box .progress-bar, .causes-style-1 .owl-theme .owl-dots .owl-dot.active span, .causes-style-1 .owl-theme .owl-dots .owl-dot:hover span, .event-style-1 .bx-wrapper .bx-pager.bx-default-pager a:hover, .event-style-1 .bx-wrapper .bx-pager.bx-default-pager a.active, .event-style-1 a.plus, .style-1 .text-box:before, .testimonial-style-1 .owl-theme .owl-dots .owl-dot.active span, .testimonial-style-1 .owl-theme .owl-dots .owl-dot:hover span, .team-social-box-1, .team-style-1 .box .text-box, .team-style-1 .box .team-social-box-1 ul li a:hover, .project-style-1 .owl-theme .owl-controls .owl-nav [class*="owl-"]:hover, .testimonial-style-2 .bx-wrapper .bx-pager.bx-default-pager a:hover, .testimonial-style-2 .bx-wrapper .bx-pager.bx-default-pager a.active, .shop-style-1 .box .text-box a.like:hover, .inner-header .top-bar, #filter li a:hover, #filter .current, #filter li a.selected, .pagination-box .pagination > li > a:hover, .pagination-box .pagination > li > span:hover, .pagination-box .pagination > li > a:focus, .pagination-box .pagination > li > span:focus, .pagination-box .pagination li.active a, .gallery-section .thumb .caption:before, .gallery-section .thumb .caption:after, .review-section .nav-tabs > li.active > a, .review-section .nav-tabs > li.active > a:hover, .review-section .nav-tabs > li.active > a:focus, .shop-slider .owl-theme .owl-dots .owl-dot.active span, .shop-slider .owl-theme .owl-dots .owl-dot:hover span, .team-style-2 .box, .coming-soon .countdown-amount:before, .coming-soon .inner a.btn-style-1:after, input.radio:checked + label > span.show-hover, .testimonial-style-3 .owl-theme .owl-dots .owl-dot.active span, .testimonial-style-3 .owl-theme .owl-dots .owl-dot:hover span, .style-1 .frame .sticky, .recent-news .owl-theme .owl-controls .owl-nav [class*="owl-"]:hover, .news-grid blockquote, .share-row ul li a:hover, .event-timer .countdown-section, .logo-row .navbar-toggle, .logo-row .navbar-inverse .navbar-toggle:hover, .logo-row .navbar-inverse .navbar-toggle:focus, a.btn-style-1, .logo-row a.btn-donate, .donate-goal-box a.btn-style-1:after, .event-style-1-box .right-box a.btn-detail:after, .event-style-1-box:hover a.btn-detail, .join-form input[type="submit"], .newsletter-box form button[type="submit"], .comment-box input[type="submit"], .coming-soon .inner form input[type="submit"], .form-row input[type="submit"], .sidebar-box .newsletter-box-2 form button[type="submit"], .contact-row form input[type="submit"], .contact-form form input[type="submit"],.top-bar .holder:after{
				
			background-color:'.esc_attr($recieve_color).'; 
		}';
			
				
		$html_new .= '.heading-style-1 span.title, .heading-style-1 em, .welcome-section .box .icon-col, .welcome-section .box .icon-col:before, .welcome-section .box:hover .text-col h4 a, .causes-style-1 .box .text-box a.link .fa, .causes-goal-box strong.amount, .pie-title-center b, .event-style-1-box a.link .fa, .event-style-1-box .left-box p a:hover, .event-style-1-box:hover strong.date, .style-1 a.link .fa, .style-1 a.btn-more, .style-1:hover, .team-style-1 .box:hover .team-social-box-1 ul li a, .team-style-1 .box:hover .text-box h4 a, .team-style-1 .box:hover .text-box em.disp, .event-widget strong.date, .event-widget ul li:hover span.time, .tweets-box p a, .tweets-box .fa, .tweets-box span.time, .copyrights-section strong.copy a:hover, .project-style-1 .box .outer .text-box strong.month, .project-style-1 .box:hover .text-box h3 a, .shop-style-1 .box .text-box span.price, .shop-style-1 .box .text-box a.like, .shop-style-1 .box:hover .text-box h3 a, .shop-style-1 .box:hover span.cut-price, .project-3-col .text-box strong.month, .error-section .inner h1, .error-section .inner strong.title, .error-section .inner form button[type="submit"], .gallery-section .thumb .inner a.link:hover, .rating li a, .team-social-box-2 ul li a:hover, .coming-soon .countdown-amount, .coming-soon .countdown-period, .coming-soon .inner a.btn-style-1, .style-1:hover .text-box h3 a, .link-post a.link-text, .sidebar-box form button[type="submit"], .recent-widget .text-col span.date .fa, .recent-news .owl-next:before, .recent-news .owl-prev:before, .upcoming-event-widget .date-box, .sidebar-box .box a, .sidebar-box .box .fa, .sidebar-box .box span, .upcoming-event-widget .text-col a:hover, .recent-widget .text-col a:hover, .address-box ul li .fa, .address-box ul li:hover p, .address-box ul li:hover p a, .heading-col h2 span, .address-col ul li .fa, .address-col ul li:hover p, .address-col ul li:hover p a,.tags a, .cp-categories a

		{

			color:'.esc_attr($recieve_color).'; 

		}';

		/* Border Colours */

		$html_new .= '.event-style-1-box:hover strong.date, .coming-soon .countdown-section:after, .logo-row .navbar-toggle, .logo-row .navbar-inverse .navbar-toggle:hover, .logo-row .navbar-inverse .navbar-toggle:focus,.tags a, .cp-categories a

		{

			border-color:'.esc_attr($recieve_color).'; 

		}';



		/* Header Background Image */

		$header_image = theneeds_get_themeoption_value('header_logo_bg','general_settings');

		$image_src = '';

			if(!empty($header_image)){ 

				$image_src = wp_get_attachment_image_src( $header_image, 'full' );

				$image_src = (empty($image_src))? '': $image_src[0];			

		}

		if($header_image <> ''){

			if($image_src <> ''){

				$html_new .= '#inner-banner {background: #000 url('.esc_url($image_src).') no-repeat left top/cover }';

			}

		}else{

			$path =  theneeds_PATH_URL;
			
			$html_new .=  '#inner-banner {background: #000 url('.esc_url($path).'/images/inner-banner.jpg) no-repeat left top/cover }';

		}

		$html_new .= '</style>';

		/* Color Picker Is Installed */

		if($backend_on_off <> 1){

			die(json_encode($html_new));

		}else{

			return $html_new;

		}

	}


	/* Add Style to Frontend */

	function add_font_code(){

		global $pagenow;


		echo '<style type="text/css">';

			

			/* Attach Background */

			$select_bg_pat = theneeds_get_themeoption_value('select_bg_pat','general_settings');

			$body_image = theneeds_get_themeoption_value('body_image','general_settings');

			$image_repeat_layout = theneeds_get_themeoption_value('image_repeat_layout','general_settings');

			$position_image_layout = theneeds_get_themeoption_value('position_image_layout','general_settings');

			$image_attachment_layout = theneeds_get_themeoption_value('image_attachment_layout','general_settings');


			 if($select_bg_pat == 'Background-Image'){

				$image_src_head = '';							

				if(!empty($body_image)){ 

					$image_src_head = wp_get_attachment_image_src( $body_image, 'full' );

					$image_src_head = (empty($image_src_head))? '': $image_src_head[0];

					$thumb_src_preview = wp_get_attachment_image_src( $body_image, 'full');

				}

				echo 'body{

				background-image:url('.esc_url($thumb_src_preview[0]).');

				background-repeat:'.esc_attr($image_repeat_layout).';

				background-position:'.esc_attr($position_image_layout).';

				background-attachment:'.esc_attr($image_attachment_layout).';

				background-size:cover; }';

			}else if($select_bg_pat == 'Background-Color'){ 

				$bg_scheme = theneeds_get_themeoption_value('bg_scheme','general_settings');

				echo 'body, .main-content{background:'.esc_attr($bg_scheme).';}';

			}else if($select_bg_pat == 'Background-Patren'){

				$body_patren = theneeds_get_themeoption_value('body_patren','general_settings');

				$color_patren = theneeds_get_themeoption_value('color_patren','general_settings');


				if(!empty($body_patren)){

					$image_src_head = wp_get_attachment_image_src( $body_patren, 'full' );

					$image_src_head = (empty($image_src_head))? '': $image_src_head[0];

					$thumb_src_preview = wp_get_attachment_image_src( $body_patren, array(60,60));


					if($thumb_src_preview[0] <> ''){ echo 'body{background:url('.esc_url($thumb_src_preview[0]).') repeat !important;}'; }

				}else{ 

					$bg_scheme = theneeds_get_themeoption_value('bg_scheme','general_settings');

					$color_patren = theneeds_get_themeoption_value('color_patren','general_settings');


					echo 

					'body{background:'.$bg_scheme.' url('.theneeds_PATH_URL.$color_patren.') repeat;} 

					.inner-pages h2 .txt-left{background:'.$bg_scheme.' url('.esc_url(theneeds_PATH_URL.$color_patren).') repeat;}'; 

				}

			}

			

			/* Heading Variables */

			$heading_h1 = theneeds_get_themeoption_value('heading_h1','typography_settings');

			$heading_h2 = theneeds_get_themeoption_value('heading_h2','typography_settings');

			$heading_h3 = theneeds_get_themeoption_value('heading_h3','typography_settings');

			$heading_h4 = theneeds_get_themeoption_value('heading_h4','typography_settings');

			$heading_h5 = theneeds_get_themeoption_value('heading_h5','typography_settings');

			$heading_h6 = theneeds_get_themeoption_value('heading_h6','typography_settings');

			

			/* Render Heading sizes */

			if($heading_h1 <> ''){ echo 'body h1{ font-size:'.esc_attr($heading_h1).'px !important; }'; }

			if($heading_h2 <> ''){ echo 'body h2{ font-size:'.esc_attr($heading_h2).'px !important; }'; }

			if($heading_h3 <> ''){ echo 'body h3{ font-size:'.esc_attr($heading_h3).'px !important; }'; }

			if($heading_h4 <> ''){ echo 'body h4{ font-size:'.esc_attr($heading_h4).'px !important; }'; }

			if($heading_h5 <> ''){ echo 'body h5{ font-size:'.esc_attr($heading_h5).'px !important; }'; }

			if($heading_h6 <> ''){ echo 'body h6{ font-size:'.esc_attr($heading_h6).'px !important; }'; }

			

			/* Body Font Size */

			$font_size_normal = theneeds_get_themeoption_value('font_size_normal','typography_settings');

			if($font_size_normal <> ''){ echo 'body p{font-size:'.esc_attr($font_size_normal).'px !important;}'; }

			

			/* Body Font Family */

			$font_google = theneeds_get_themeoption_value('font_google','typography_settings');

			if($font_google <> 'Default'){ echo 'body p { font-family:"'.esc_attr($font_google).'" !important;}'; }else{ 

			echo '';

			}

			

			/* Body Font Size */

			$boxed_scheme = theneeds_get_themeoption_value('boxed_scheme','general_settings');

			$select_layout_cp = theneeds_get_themeoption_value('select_layout_cp','general_settings');

			if($select_layout_cp == 'box_layout'){ echo '.boxed{background:'.esc_attr($boxed_scheme).';}'; }

			

			/* Heading Font Family */

			$font_google_heading = theneeds_get_themeoption_value('font_google_heading','typography_settings');

			if($font_google_heading <> 'Default'){ echo 'body h1, body h2, body h3, body h4, body h5, body h6{ font-family:"'.esc_attr($font_google_heading).'" !important;}'; }else{ echo 'h1, h2, h3, h4, h5, h6{}';}

			

			/* Menu Font Family */

			$menu_font_google = theneeds_get_themeoption_value('menu_font_google','typography_settings');

			if($menu_font_google <> 'Default'){ echo '{font-family:"'.esc_attr($menu_font_google).'" !important;}';}else{ echo '#nav{font-family:"Open Sans",sans-serif;}';}

			

		echo '</style>';


		$color_scheme = theneeds_get_themeoption_value('color_scheme','general_settings');	

		$body_color = theneeds_get_themeoption_value('body_color','general_settings');

		$heading_color = theneeds_get_themeoption_value('heading_color','general_settings');

		$select_layout_cp = theneeds_get_themeoption_value('select_layout_cp','general_settings');

		

		$recieve_color = '';

		$recieve_an_color = '';

		$html_new = '';

		$backend_on_off = 1;
		
		/* Theme Options Values  For Page IDs */
		$charity_page = theneeds_get_themeoption_value('charity_page','general_settings');
		$politics_page = theneeds_get_themeoption_value('politics_page','general_settings');	

		/* Theme Options Values  For Selected Color For Page */	
		
		global $post;
		
		$current_page = '';
		
		if(is_object($post)){
		
			$current_page = $post->ID;
		
		}else{
		
			$current_page = 0;
		}
		
		if($current_page == $charity_page){
			
			$selected_page = $charity_page;
			
			$charity_color = theneeds_get_themeoption_value('charity_color','general_settings');
		
			$color_scheme = $charity_color;
		
		}elseif($current_page == $politics_page){
		
			$selected_page = $politics_page;
			
			$politics_color = theneeds_get_themeoption_value('politics_color','general_settings');	
			
			$color_scheme = $politics_color;
		
		}else {
		
			$selected_page = '';
			
		}
		

		if($current_page == $selected_page){
		
			$color_scheme = $color_scheme;	

		}else{

			$color_scheme = theneeds_get_themeoption_value('color_scheme','general_settings');
		}

		/* Color Scheme */

		echo theneeds_color_bg($color_scheme,$bg_texture='',$navi_color='',$heading_color,$body_color,$select_layout_cp,$backend_on_off);

	}



	/* Add Style in Footer */

	global $pagenow;

	if( $GLOBALS['pagenow'] != 'wp-login.php' ){

		if(!is_admin()){

			add_action('wp_head', 'add_font_code');

		}

	}