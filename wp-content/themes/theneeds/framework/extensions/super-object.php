<?php 
/*	
*	CrunchPress Super Object File
*	---------------------------------------------------------------------
* 	@version	1.0
* 	@author		CrunchPress
* 	@link		http://crunchpress.com
* 	@copyright	Copyright (c) CrunchPress
*	---------------------------------------------------------------------
*	This file Contain all the custom Built in function 
*	Developer Note: do not update this file.
*	---------------------------------------------------------------------
*/


	/* Remove LayerSlider Scripts */
	if(class_exists('LS_Sliders')){
		remove_action('wp_enqueue_scripts', 'layerslider_enqueue_content_res');
	}

	/* get extended classes name */
	function theneeds_get_extends_name($base){
		$myclass = array();
		foreach(get_declared_classes() as $class){
			 if(is_subclass_of($class,$base)){ 
				$myclass[] = $class;
			 }
		}
		   return $myclass; 
	}
	
	/* get number of extended Classes */
	function theneeds_get_extends_number($base){
		$rt=0;
		foreach(get_declared_classes() as $class){
			if(is_subclass_of($class,$base)){ 
				$rt++;
			}
		}
		return $rt;
	}
	
	/* create Page Option Meta */
	function theneeds_class_function_layout(){	
		for($i =0;$i <= theneeds_get_extends_number('theneeds_function_library');$i++){
			$new_class = theneeds_get_extends_name('theneeds_function_library');
		}
		return $new_class;
	}
	
	/* Find the XML value from XML Object */
	function theneeds_find_xml_value($xml, $field){
	
		if(!empty($xml)){
		
			foreach($xml->childNodes as $xmlChild){
			
				if($xmlChild->nodeName == $field){
					if( is_admin() ){
						return $xmlChild->nodeValue;
					}else{
						return $xmlChild->nodeValue;
					}
				}
				
			}
			
		}
		
		return '';
		
	}
	
	/* Checking Google Font	 */
	function theneeds_verify_font($font_google){
	
	$fonts_array = theneeds_get_font_array();
		foreach($fonts_array as $keys=>$values){
			if($values == 'Google Font'){
				if($keys == $font_google){
					return 'Google Font';
				}
			}
		}
	}
	
	function theneeds_verify_google_f($font_google){
		$font_array = theneeds_get_font_array();
		$google_array_find = array_keys($font_array);
		if($font_google == 'Default'){return 'no_font';}else{
			if(in_array($font_google,$google_array_find)){
				return 'google_font';
			}else{
				return 'type_kit';
			}
		}
	}
	
	
	function theneeds_verify_google_para($font_heading){
		$font_array = theneeds_get_font_array();
		$google_array_find = array_keys($font_array);
		if($font_heading == 'Default'){return 'no_font';}else{
			if(in_array($font_heading,$google_array_find)){
				return 'google_font';
			}else{
				return 'type_kit';
			}
		}
	}
	
	function theneeds_verify_google_menu($font_menu){
		$font_array = theneeds_get_font_array();
		$google_array_find = array_keys($font_array);
		if($font_menu == 'Default'){return 'no_font';}else{
			if(in_array($font_menu,$google_array_find)){
				return 'google_font';
			}else{
				return 'type_kit';
			}
		}
	}
	
	function find_xml_child_nodes($xml_data,$tag_name,$child_node){
		if(!empty($xml_data)){
			$theneeds_slider = new DOMDocument ();
			$theneeds_slider->loadXML ( $xml_data );
			$element_tag_name = $theneeds_slider->getElementsByTagName($tag_name);
			foreach($element_tag_name as $element_tag){
				foreach($element_tag->childNodes as $i){
					if($i->tagName == $child_node){
							return $i->nodeValue;
					}
				}
			}
		}
		return '';
	}
	
	/* Array Values NodeValue */
	function return_xml_array($children_des){
		$array_data = array();
		$counter = 0;
		foreach($children_des as $values){
			$array_data[] = $values->nodeValue;
		}
		return $array_data;
	}

	/* Find the XML node from XML Object */
	function theneeds_find_xml_node($xml, $node){
	
		if(!empty($xml)){
		
			foreach($xml->childNodes as $xmlChild){
			
				if($xmlChild->nodeName == $node){
				
					return $xmlChild;
					
				}
				
			}
			
		}
		
		return '';
		
	}
	
	/* Create tag string from nodename and value */
	function theneeds_create_xml_tag($node, $value){
	
		return '<' . $node . '>' . $value . '</' . $node . '>';
		
	}
	
	/* Get array of sidebar name */
	function get_sidebar_name(){
	
		global $theneeds_sidebar;
		$sidebar = array();
		
		if(!empty($theneeds_sidebar)){
		
			$xml = new DOMDocument();
			$xml->loadXML($theneeds_sidebar);
			
			foreach( $xml->documentElement->childNodes as $sidebar_name ){
			
				$sidebar[] = $sidebar_name->nodeValue;
				
			}
			
		}
		
		return $sidebar;
		
	}
	theneeds_get_google_font();
	
	function theneeds_get_google_font(){
	
	get_template_part( 'framework/extensions/google', 'font' );
	  
		global $all_font;
		$google_fonts = update_google_font_array();
		
		foreach($google_fonts as $google_font){
		
			$all_font[$google_font['family']] = array('subsets' => $google_font['subsets'],'type'=>'Google Font','variants' => $google_font['variants']);
		
		}
		
	}
	
	/* return a link to get the google font */
	function theneeds_get_google_font_url( $font_family ){
		$google_font_list = theneeds_get_font_array();
		if( !empty($font_family) && !empty($google_font_list[$font_family]) ){
			$google_font = $google_font_list[$font_family];
			$temp_font_name  = str_replace(' ', '+' , $font_family) . ':';

			return esc_attr(HTTP . 'fonts.googleapis.com/css?family=' . $temp_font_name);
		} 
		return '';
	}
	
	function theneeds_get_font_array( $type = '' ){
		global $all_font;
		
		$theneeds_typekit_settings = get_option('typokit_settings');
		if($theneeds_typekit_settings <> ''){
			$typekit_xml = new DOMDocument();
			$typekit_xml->loadXML($theneeds_typekit_settings);
			foreach( $typekit_xml->documentElement->childNodes as $typekit_font ){
					$all_font[$typekit_font->nodeValue] = array('status'=>'enabled','type'=>'Used font','is-used'=>false,);
			}
		}
		foreach($all_font as $font_name => $font_value){
		
			if(isset($font_value['type']) || $font_value['type'] == 'Google Font'){
				$fonts[$font_name] = $font_value; 
			}
			
		}
			
		return $fonts;
		
	}
	
	function theneeds_get_font_type( $font_family='' ){
		$font_found = '';
		global $fonts,$all_font;
		if($font_family == 'Default'){ }else{
			$all_font[$font_family]['type'] = 'Google Font';
			if($all_font[$font_family]['type'] == 'Google Font'){
				$font_found = 'Google_Font';
			}
		}		
		
		return $font_found;	
		
	}
	
	/* get width and height from string WIDTHxHEIGHT */
	function theneeds_get_width( $size ){
		$size_array = $size;
		return $size_array[0];
	}
	function theneeds_get_height( $size ){
		$size_array = $size;
		return $size_array[1];
	}
	
	/* use ajax to print all of media image */
	add_action('wp_ajax_theneeds_get_media_image','theneeds_get_media_image');
	function theneeds_get_media_image(){
	
		$image_width = 60;
		$image_height = 60;
		
		$paged = (isset($_POST['page']))? $_POST['page'] : 1; 	
		if($paged == ''){ $paged = 1; }
		
		$statement = array('post_type' => 'attachment',
			'post_mime_type' =>'image',
			'post_status' => 'inherit', 
			'posts_per_page' => 12,
			'paged' => $paged);
		$media_query = new WP_Query($statement);
	
		?>
		
		<div class="media-title">
			<label><?php esc_html_e('Insert Gallery Items','theneeds'); ?></label>
		</div>
		
		<?php
		
		echo '<div class="media-gallery-nav" id="media-gallery-nav">';
		echo '<ul>';
		echo '<a><li class="nav-first" rel="1" ></li></a>';
		
		for( $i=1 ; $i<=$media_query->max_num_pages; $i++){
		
			if($i == $paged){
				echo '<li rel="' . $i . '">' . $i . '</li>';
			}else if( ($i <= $paged+2 && $i >= $paged-2) || $i%10 == 0){
				echo '<a><li rel="' . $i . '">' . $i . '</li></a>';		
			}
			
		}
		echo '<a><li class="nav-last" rel="' . esc_attr($media_query->max_num_pages) . '"></li></a>';
		echo '</ul>';
		echo '</div>';
	
		echo '<ul>';
		
		foreach( $media_query->posts as $image ){ 
		
			$thumb_src = wp_get_attachment_image_src( $image->ID, array(60,60));
			$thumb_src_preview = wp_get_attachment_image_src( $image->ID, array(60,60));
			echo '<li><img src="' . esc_url($thumb_src[0]) .'" title="' . esc_attr($image->post_title) . '" attid="' . esc_attr($image->ID) . '" rel="' . esc_url($thumb_src_preview[0]) . '"/></li>';
		
		}
		
		echo '</ul>';
		
		if(isset($_POST['page'])){ die(''); }
	}
	
	
	/* Adding Ajax Url for Dummy Data */
	add_action('wp_head','theneeds_ajax_ajaxurl');
	function theneeds_ajax_ajaxurl() {?>
		<script type="text/JavaScript">
		var ajaxurl = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
		var directory_url = '<?php echo esc_url(get_template_directory_uri()); ?>';
		</script>
	<?php
	}

	/*  return the slider option array to use with javascript file */
	function get_theneeds_slider_option_array($slider_option){
	
		$slider_setting = array();
	
		foreach($slider_option as $value){
			
			$set_value = get_option($value['name']);
			
			if(isset($value['oldname']) && $set_value){
			
				$slider_setting[$value['oldname']] = $set_value;
			
			}
		}
		
		return $slider_setting;
	}

	/* return the array of category */
	function theneeds_get_category_list( $category_name, $parent='' ){
		
		if( empty($parent) ){ 
			
			$get_category = get_categories( array( 'taxonomy' => $category_name	));
			$category_list = array( '0' =>'All');
			
			foreach( $get_category as $category ){
				$category_list[] = $category->cat_name;
			}
				
			return $category_list;
			
		}else{
			
			$parent_id = get_term_by('name', $parent, $category_name);
			$get_category = get_categories( array( 'taxonomy' => $category_name, 'child_of' => $parent_id->term_id	));
			$category_list = array( '0' => $parent );
			
			foreach( $get_category as $category ){
				$category_list[] = $category->cat_name;
			}
				
			return $category_list;		
		
		}
	}
	
	/* return the array of category */
	function theneeds_get_category_list_array( $category_name, $parent='' ){
		
		if( empty($parent) ){ 
			$category_list = array();
			$get_category = get_categories( array( 'taxonomy' => $category_name	));
			if($get_category <> ''){
				foreach( $get_category as $category ){
					$category_list[] = $category;
				}
			}
				
			return $category_list;
			
		}else{
			
			$parent_id = get_term_by('name', $parent, $category_name);
			$get_category = get_categories( array( 'taxonomy' => $category_name, 'child_of' => $parent_id->term_id	));
			$category_list = array( '0' => $parent );
			if($get_category <> ''){
				foreach( $get_category as $category ){
					$category_list[] = $category;
				}
			}
				
			return $category_list;		
		
		}
	}
	
	
	
	
		
	
	/* return the title list of each post_type */
	function theneeds_get_title_list( $post_type ){
		
		$posts_title = array();
		$posts = get_posts(array('post_type' => $post_type, 'numberposts'=>100));
		
		foreach ($posts as $post) {
			$posts_title[] = $post->post_title;
		}
		
		return $posts_title;
	
	}
	
	function theneeds_get_title_list_slug( $post_type ){
		
		$posts_title = array();
		$posts = get_posts(array('post_type' => $post_type, 'numberposts'=>100));
		
		foreach ($posts as $post) {
			$posts_title[] = $post->post_name;
		}
		
		return $posts_title;
	
	}
	
	/* return the title list of each post_type */
	function theneeds_get_title_list_array( $post_type ){
		
		$posts_title = array();
		$posts = get_posts(array('post_type' => $post_type, 'numberposts'=>100));
		
		foreach ($posts as $post) {
			$posts_title[] = $post;
		}
		
		return $posts_title;
	
	}

	
	
	/* return the title list of each post_type */
	function theneeds_get_slug_list( $post_type ){
		
		$posts_title = array();
		$posts = get_posts(array('post_type' => $post_type, 'numberposts'=>100));
		
		foreach ($posts as $post) {
			$posts_title[] = $post->post_name;
		}
		
		return $posts_title;
	
	}		

	 
	
	function theneeds_show_sidebar($sidebar_name, $right_sidebar,$left_sidebar,$value_right,$value_left){?>
			
			<ul class="panel-body recipe_class row-fluid">
				
				<li class="panel-radioimage span12">
					<div class="panel-title ">
						<h3><?php esc_html_e('Select Sidebar', 'theneeds'); ?></h3>
					</div>
					<div class="clear"></div>
					<?php 
						$options = array(
							'1'=>array('value'=>'right-sidebar','image'=>'/framework/images/right-sidebar.png'),
							'2'=>array('value'=>'left-sidebar','image'=>'/framework/images/left-sidebar.png'),
							'3'=>array('value'=>'both-sidebar','image'=>'/framework/images/both-sidebar.png','default'=>'selected'),
							'4'=>array('value'=>'both-sidebar-left','image'=>'/framework/images/both-sidebar-left.png'),
							'5'=>array('value'=>'both-sidebar-right','image'=>'/framework/images/both-sidebar-right.png'),
							'3'=>array('value'=>'no-sidebar','image'=>'/framework/images/no-sidebar.png')
						);
					foreach( $options as $option ){ ?>
						<div class='radio-image-wrapper'>
							<span class="head-sec-sidebar"><?php echo str_replace('-',' ',$option['value']); ?></span>
							<label for="<?php echo esc_attr($option['value']); ?>">
								<img src=<?php echo theneeds_PATH_URL.$option['image']?> class="<?php echo esc_attr($sidebar_name);?>" alt="<?php echo esc_attr($sidebar_name);?>">
								<div id="check-list" <?php 
									if($sidebar_name == $option['value']){
										echo 'class="check-list"';
									}
								?>>
							</div>                                
							</label>
							<input type="radio" name="sidebars" value="<?php echo esc_attr($option['value']); ?>" <?php 
									if($sidebar_name == $option['value']){
										echo 'checked';
									}
							?> id="<?php echo esc_attr($option['value']); ?>" class="<?php echo esc_attr($sidebar_name);?>"
							>                            
						</div>
					<?php } ?>
				</li>
			</ul>
			<div class="row-fluid">
				<ul class="theneeds_right_sidebar recipe_class span6">
					
					<li class="panel-input">	
						<div class="panel-title">
							<h3><?php esc_html_e('Right Sidebar', 'theneeds'); ?></h3>
						</div>
						<div class="combobox">
							<select name="<?php echo esc_attr($right_sidebar);?>" id="theneeds_sidebar_dropdown">								
								<?php
								$theneeds_sidebar_settings = get_option('sidebar_settings');
								if($theneeds_sidebar_settings <> ''){
									$sidebars_xml = new DOMDocument();
									$sidebars_xml->loadXML($theneeds_sidebar_settings);
									foreach( $sidebars_xml->documentElement->childNodes as $sidebar_name ){?>
										<option <?php if($value_right == $sidebar_name->nodeValue){ echo 'selected';}?> value="<?php echo esc_attr($sidebar_name->nodeValue); ?>"><?php echo esc_attr($sidebar_name->nodeValue); ?></option>
								<?php }
								} ?>	
							</select>
						</div>
						<p><?php esc_html_e('Select Slide from dropdown to use in main slider.', 'theneeds'); ?></p>
					</li>
					
				</ul>
				<ul class="theneeds_left_sidebar recipe_class span6">
					
					<li class="panel-input">	
						<div class="panel-title">
							<h3><?php esc_html_e('Left Sidebar', 'theneeds'); ?></h3>
						</div>
						<div class="combobox">
							<select name="<?php echo esc_attr($left_sidebar);?>" id="theneeds_sidebar_dropdown_left">								
								<?php
								if($theneeds_sidebar_settings <> ''){
									$sidebars_xml = new DOMDocument();
									$sidebars_xml->loadXML($theneeds_sidebar_settings);
									foreach( $sidebars_xml->documentElement->childNodes as $sidebar_name ){?>
										<option <?php if($value_left == $sidebar_name->nodeValue){ echo 'selected';}?> value="<?php echo esc_attr($sidebar_name->nodeValue); ?>"><?php echo esc_attr($sidebar_name->nodeValue); ?></option>
								<?php }
								} ?>	
							</select>
						</div>
						<p><?php esc_html_e('Select Slide from dropdown to use in main slider.', 'theneeds'); ?></p>
					</li>
					
				</ul>
			</div>
			<div class="clear"></div>
<?php } 
	
	/* Top Navigation Heading */
	function theneeds_top_navigation_html(){		
		if($_GET['page']=="theneeds_general_options"){ ?>
			<h2 class="main-title"><?php esc_html_e('General Settings','theneeds');?></h2>
		<?php 
		}else if($_GET['page']=="theneeds_typography_settings"){ ?>
			<h2 class="main-title"><?php esc_html_e('Typography Settings','theneeds');?></h2>
		<?php
		
		}else if($_GET['page']=="theneeds_slider_settings"){ ?>
			<h2 class="main-title"><?php esc_html_e('Slider Settings','theneeds');?></h2>
		<?php
		
		}else if($_GET['page']=="theneeds_sidebar_settings"){ ?>
			<h2 class="main-title"><?php esc_html_e('Sidebar Settings','theneeds');?></h2>
		<?php
		
		}else if($_GET['page']=="theneeds_default_pages_settings"){ ?>
			<h2 class="main-title"><?php esc_html_e('Default Settings','theneeds');?></h2>
		<?php
		
		}else if($_GET['page']=="theneeds_social_settings"){ ?>
			<h2 class="main-title"><?php esc_html_e('Social Settings','theneeds');?></h2>
		<?php
		
		}else if($_GET['page']=="theneeds_dummydata_import"){ ?>
			<h2 class="main-title"><?php esc_html_e('Dummy Content Settings','theneeds');?></h2>
		<?php
		}			
	}
	
	/* Top Navigation Heading */
	function theneeds_top_navigation_html_tooltip(){	?>
		<ul class="tooltip-right">
			<li class="small-icon-tab icon gen_set<?php if($_GET['page']=="theneeds_general_options"){echo " active";} ?>"><a href="?page=theneeds_general_options" data-toggle="tooltip" title="" data-original-title="General Settings"> <i class="fa fa-home"></i></a> </li>
			<li class="small-icon-tab icon typo_set<?php if($_GET['page']=="theneeds_typography_settings"){echo " active";} ?>"> <a href="?page=theneeds_typography_settings" data-toggle="tooltip" title="" data-original-title="Typography" class=""><i class="fa fa-font"></i></a> </li>
			<li class="small-icon-tab icon slid_set<?php if($_GET['page']=="theneeds_slider_settings"){echo " active";} ?>"> <a href="?page=theneeds_slider_settings" class="" data-toggle="tooltip" title="" data-original-title="Slider"><i class="fa fa-picture-o"></i></a> </li>
			<li class="small-icon-tab icon side_set<?php if($_GET['page']=="theneeds_sidebar_settings"){echo " active";} ?>"> <a href="?page=theneeds_sidebar_settings" class="" data-toggle="tooltip" title="" data-original-title="Sidebar"><i class="fa fa-columns"></i></a> </li>
			<li class="small-icon-tab icon default_set<?php if($_GET['page']=="theneeds_default_pages_settings"){echo " active";} ?>"> <a href="?page=theneeds_default_pages_settings" class="" data-toggle="tooltip" title="" data-original-title="Default Pages"><i class="fa fa-file-text"></i></a> </li>
			<li class="small-icon-tab icon social_set<?php if($_GET['page']=="theneeds_social_settings"){echo " active";} ?>"> <a href="?page=theneeds_social_settings" class="" data-toggle="tooltip" title="" data-original-title="Social"><i class="fa fa-share"></i></a> </li>
			
			<li class="small-icon-tab icon import_ex<?php if($_GET['page']=="theneeds_dummydata_import"){echo " active";} ?>"> <a href="?page=theneeds_dummydata_import" class="" data-toggle="tooltip" title="" data-original-title="Import Content"> <i class="fa fa-globe"></i></a></li>
			<?php $mystring = $_SERVER['REQUEST_URI'];
			$findme = 'seo_settings';
			$seo_settings = strpos($mystring, $findme);
			?>
			
		</ul>
	<?php
	}
	
	
	
	/* Slider Id for Page Options Array */
	function theneeds_get_slider_id($slider_name){
		
		if(!empty($slider_name)){
		$layer_slider_id = get_post_meta( $slider_name, 'cp-slider-xml', true);
			if($layer_slider_id <> ''){
				$slider_xml_dom = new DOMDocument ();
				$slider_xml_dom->loadXML ( $layer_slider_id );
				return $slider_xml_dom->documentElement;
			}
		}
	}
	
	/* Get Popular posts */
	function theneeds_popular_set_post_views($postID) {
		$count_key = 'popular_post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}
	
	function theneeds_popular_track_post_views ($post_id) {
		if ( !is_single() ) return;
		if ( empty ( $post_id) ) {
			global $post;
			$post_id = $post->ID;    
		}
		theneeds_popular_set_post_views($post_id);
	}
	add_action( 'wp_head', 'theneeds_popular_track_post_views');


	function theneeds_wpb_get_post_views($postID){
		$count_key = 'popular_post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return "0 View";
		}
		return $count.' Views';
	}
	
	/* Page Slider */
	function theneeds_page_slider(){
	
	global $post;
		
		$theneeds_slider_off = '';
		$theneeds_slider_type = '';
		$theneeds_slider_slide = '';
		$theneeds_slider_height = '';
		$theneeds_owlslider_style = '';
		$theneeds_slider_off = get_post_meta ( $post->ID, "page-option-top-slider-on", true );
		
		if($theneeds_slider_off == 'Yes'){
			
			//Get Page Main Slider Values
			$theneeds_slider_type = get_post_meta ( $post->ID, "page-option-top-slider-types", true );
			
			$theneeds_owlslider_style = '';
			//$theneeds_owlslider_style = get_post_meta ( $post->ID, "page-option-owl-slider-style", true );
			
			$theneeds_slider_layer_id = get_post_meta ( $post->ID, "page-option-top-slider-layer", true );
			$theneeds_slider_shortcode = get_post_meta ( $post->ID, "page-option-top-slider-shortcode", true );
			
			if($theneeds_slider_type != 'Revolution-Slider'){
				$theneeds_slider_slide = get_post_meta ( $post->ID, "page-option-top-slider-images", true );
				$theneeds_slider_height = get_post_meta ( $post->ID, "page-option-top-slider-height", true );
				$theneeds_size_new = '';
				
				if(!empty($theneeds_slider_slide)){
					$theneeds_slider_input_xml = get_post_meta( $theneeds_slider_slide, 'cp-slider-xml', true);
					if($theneeds_slider_input_xml <> ''){
					$theneeds_slider_xml_dom = new DOMDocument ();
					$theneeds_slider_xml_dom->loadXML ( $theneeds_slider_input_xml );
					
	
						if($theneeds_slider_type == 'Bx-Slider'){

								echo theneeds_print_bx_slider($theneeds_slider_xml_dom->documentElement,array(5000,1400),'abc123');

						}elseif($theneeds_slider_type == 'Owl-Slider'){
								
								 echo theneeds_inner_owl_slider($theneeds_slider_xml_dom->documentElement,array(5000,1400), '');
						
						
						}elseif($theneeds_slider_type == 'Search Map'){
								
									theneeds_search_map_banner();
						}else{
						
							/* Yet To Be Implemented */
						
						}
					}
				}
			}
			
			if($theneeds_slider_type == 'Revolution-Slider'){
				echo '<div class="tp-banner-container">';
				theneeds_print_revolution_slider();
				echo '</div>';
			}
			
			/* Layer SLider */
			if($theneeds_slider_type == 'Layer-Slider'){
				if(class_exists('LS_Sliders')){
					echo do_shortcode('[layerslider id="' . $theneeds_slider_layer_id . '"]');
				}else{
					echo '<h2>Please install the LayerSlider plugin.</h2>';
				}	
			}else if($theneeds_slider_type == 'Add-Shortcode'){
				echo do_shortcode($theneeds_slider_shortcode);
			}
		}
	}
	
	
	/* Function Only For Theme Inner Page BX */
	function theneeds_inner_cp_page_slider(){
		
		global $post;
		
		$theneeds_slider_off = '';
		$theneeds_slider_type = '';
		$theneeds_slider_slide = '';
		$theneeds_slider_height = '';
		$theneeds_slider_off = get_post_meta ( $post->ID, "page-option-top-slider-on", true );
		
		if($theneeds_slider_off == 'Yes'){
			
			/* Slider Values From Page */
			$theneeds_slider_type = get_post_meta ( $post->ID, "page-option-top-slider-types", true );
			$theneeds_slider_layer_id = get_post_meta ( $post->ID, "page-option-top-slider-layer", true );
			$theneeds_slider_shortcode = get_post_meta ( $post->ID, "page-option-top-slider-shortcode", true );
			$theneeds_slider_slide = get_post_meta ( $post->ID, "page-option-top-slider-images", true );
			
			if(!empty($theneeds_slider_slide)){
				$theneeds_slider_input_xml = get_post_meta( $theneeds_slider_slide, 'cp-slider-xml', true);
				if($theneeds_slider_input_xml <> ''){
				$theneeds_slider_xml_dom = new DOMDocument ();
				$theneeds_slider_xml_dom->loadXML ( $theneeds_slider_input_xml );
					
					if($theneeds_slider_type == 'Bx-Slider'){
						echo '<div class="banner_slider">';
							echo theneeds_print_bx_slider($theneeds_slider_xml_dom->documentElement,array(5000,1400),'abc123');
						echo '</div>';
					}elseif($theneeds_slider_type == 'Owl-Slider'){
						echo '<div class="banner_slider">';
							echo theneeds_inner_owl_slider($theneeds_slider_xml_dom->documentElement,array(5000,1400),'abc123');
						echo '</div>';
					}
				}
			}
			

			/* Layer Slider */
			if($theneeds_slider_type == 'Layer-Slider'){
				if(class_exists('LS_Sliders')){
					echo do_shortcode('[layerslider id="' . $theneeds_slider_layer_id . '"]');
				}else{
					echo '<h2>Please install the LayerSlider plugin.</h2>';
				}	
			}else if($theneeds_slider_type == 'Add-Shortcode'){
				echo do_shortcode($theneeds_slider_shortcode);
			}
		}
	}
	
	function theneeds_latest_post_slider(){
		global $post;
		
		$latest_post_slider_off = get_post_meta ( $post->ID, "page-option-top-latest-post", true );
		if($latest_post_slider_off == 'Yes'){
			theneeds_print_latest_post();
		}
	}	

	
	/* Sidebar function */
	function theneeds_sidebar_func($sidebarr){
		if ($sidebarr == "left-sidebar" || $sidebarr == "right-sidebar") {
            $sidebar_class[] = 'col-md-3 col-sm-4 content_sidebar sidebar';
			$sidebar_class[1] = 'col-md-9 col-sm-8';
        }else if ($sidebarr == "both-sidebar") {
            $sidebar_class[] = "col-md-3 content_sidebar sidebar";
			$sidebar_class[1] = 'col-md-6';
        }else if($sidebarr == "both-sidebar-left") {
		    $sidebar_class[] = "col-md-3 content_sidebar sidebar";
			$sidebar_class[1] = 'col-md-6';
		}else if($sidebarr == "both-sidebar-right") {
		    $sidebar_class[] = "col-md-3 content_sidebar sidebar";
			$sidebar_class[1] = 'col-md-6';
		}else{
			$sidebar_class[1] = 'col-md-12';
		}
		return $sidebar_class;
	}

	
	
	function theneeds_booking_table_type(){
		global $allowedposttags,$EM_Event;
		$EM_Tickets = $EM_Event->get_bookings()->get_tickets(); //already instantiated, so should be a quick retrieval.
		/*
		 * This variable can be overriden, by hooking into the em_booking_form_tickets_cols filter and adding your collumns into this array.
		 * Then, you should create a em_booking_form_tickets_col_arraykey action for your collumn data, which will pass a ticket and event object.
		 */
		$collumns = $EM_Tickets->get_ticket_collumns(); //array of collumn type => title
		?>
		<table class="em-tickets" cellspacing="0" cellpadding="0">
			<tr>
				<?php foreach($collumns as $type => $name): ?>
				<th class="em-bookings-ticket-table-<?php echo esc_attr($type); ?>"><?php echo esc_attr($name); ?></th>
				<?php endforeach; ?>
			</tr>
			<?php foreach( $EM_Tickets->tickets as $EM_Ticket ): /* @var $EM_Ticket EM_Ticket */ ?>
				<?php if( $EM_Ticket->is_displayable() ): ?>
					<?php do_action('em_booking_form_tickets_loop_header', $EM_Ticket); //do not delete ?>
					<tr class="em-ticket" id="em-ticket-<?php echo esc_attr($EM_Ticket->ticket_id); ?>">
						<?php foreach( $collumns as $type => $name ): ?>
							<?php
							//output collumn by type, or call a custom action 
							switch($type){
								case 'type':
									?>
									<td class="em-bookings-ticket-table-type"><?php echo wp_kses_data($EM_Ticket->ticket_name); ?><?php if(!empty($EM_Ticket->ticket_description)) :?><br><span class="ticket-desc"><?php echo wp_kses($EM_Ticket->ticket_description,$allowedposttags); ?></span><?php endif; ?></td>
									<?php
									break;
								case 'price':
									?>
									<td class="em-bookings-ticket-table-price"><?php echo esc_attr($EM_Ticket->get_price(true)); ?></td>
									<?php
									break;
								case 'spaces':
									?>
									<td class="em-bookings-ticket-table-spaces">
										<?php 
											$default = !empty($_REQUEST['em_tickets'][$EM_Ticket->ticket_id]['spaces']) ? $_REQUEST['em_tickets'][$EM_Ticket->ticket_id]['spaces']:0;
											$spaces_options = $EM_Ticket->get_spaces_options(true,$default);
											echo ( $spaces_options ) ? $spaces_options:"<strong>".esc_html__('N/A','theneeds')."</strong>";
										?>
									</td>
									<?php
									break;
								default:
									do_action('em_booking_form_tickets_col_'.$type, $EM_Ticket, $EM_Event);
									break;
							}
							?>
						<?php endforeach; ?>
					</tr>		
					<?php do_action('em_booking_form_tickets_loop_footer', $EM_Ticket); //do not delete ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</table>
		<?php
	}
	
	function theneeds_booking_form_event_manager() {

		global $EM_Notices,$EM_Event;
		//count tickets and available tickets
		$tickets_count = count($EM_Event->get_bookings()->get_tickets()->tickets);
		$available_tickets_count = count($EM_Event->get_bookings()->get_available_tickets());
		//decide whether user can book, event is open for bookings etc.
		$can_book = is_user_logged_in() || (get_option('dbem_bookings_anonymous') && !is_user_logged_in());
		$is_open = $EM_Event->get_bookings()->is_open(); //whether there are any available tickets right now
		$show_tickets = true;
		//if user is logged out, check for member tickets that might be available, since we should ask them to log in instead of saying 'bookings closed'
		if( !$is_open && !is_user_logged_in() && $EM_Event->get_bookings()->is_open(true) ){
			$is_open = true;
			$can_book = false;
			$show_tickets = false;
		}
		?>
		<div id="em-booking" class="em-booking <?php if( get_option('dbem_css_rsvp') ) echo 'css-booking'; ?>">
			<?php 
				// We are firstly checking if the user has already booked a ticket at this event, if so offer a link to view their bookings.
				$EM_Booking = $EM_Event->get_bookings()->has_booking();
			?>
			<?php 
			if(!empty($EM_Event->bookings)){
				if( is_object($EM_Booking) && !get_option('dbem_bookings_double') ): //Double bookings not allowed ?>
					<p>
						<?php echo get_option('dbem_bookings_form_msg_attending'); ?>
						<a href="<?php echo esc_url(em_get_my_bookings_url()); ?>"><?php echo get_option('dbem_bookings_form_msg_bookings_link'); ?></a>
					</p>
				<?php elseif( !$EM_Event->event_rsvp ): //bookings not enabled ?>
					<p><?php echo get_option('dbem_bookings_form_msg_disabled'); ?></p>
				<?php elseif( $EM_Event->get_bookings()->get_available_spaces() <= 0 ): ?>
					<p><?php echo get_option('dbem_bookings_form_msg_full'); ?></p>
				<?php elseif( !$is_open ): //event has started ?>
					<p><?php echo get_option('dbem_bookings_form_msg_closed');  ?></p>
				<?php else: ?>
					<?php echo html_entity_decode($EM_Notices); ?>
					<?php if( $tickets_count > 0) : ?>
						<?php //Tickets exist, so we show a booking form. ?>
						<form class="em-booking-form" name='booking-form' method='post' action='<?php echo apply_filters('em_booking_form_action_url',''); ?>#em-booking'>
							<input type='hidden' name='action' value='booking_add'/>
							<input type='hidden' name='event_id' value='<?php echo esc_attr($EM_Event->event_id); ?>'/>
							<input type='hidden' name='_wpnonce' value='<?php echo wp_create_nonce('booking_add'); ?>'/>
							<?php 
								// Tickets Form
								if( $show_tickets && ($can_book || get_option('dbem_bookings_tickets_show_loggedout')) && ($tickets_count > 1 || get_option('dbem_bookings_tickets_single_form')) ){ //show if more than 1 ticket, or if in forced ticket list view mode
									do_action('em_booking_form_before_tickets', $EM_Event); //do not delete
									//Show multiple tickets form to user, or single ticket list if settings enable this
									//If logged out, can be allowed to see this in settings witout the register form 
									em_locate_template('forms/bookingform/tickets-list.php',true, array('EM_Event'=>$EM_Event));
									do_action('em_booking_form_after_tickets', $EM_Event); //do not delete
									$show_tickets = false;
								}
							?>
							<?php if( $can_book ): ?>
								<div class='em-booking-form-details'>
									<?php 
										if( $show_tickets && $available_tickets_count == 1 && !get_option('dbem_bookings_tickets_single_form') ){
											do_action('em_booking_form_before_tickets', $EM_Event); //do not delete
											//show single ticket form, only necessary to show to users able to book (or guests if enabled)
											$EM_Ticket = $EM_Event->get_bookings()->get_available_tickets()->get_first();
											em_locate_template('forms/bookingform/ticket-single.php',true, array('EM_Event'=>$EM_Event, 'EM_Ticket'=>$EM_Ticket));
											do_action('em_booking_form_after_tickets', $EM_Event); //do not delete
										} 
									?>
									<?php
										do_action('em_booking_form_before_user_details', $EM_Event);
										if( has_action('em_booking_form_custom') ){ 
											//Pro Custom Booking Form. You can create your own custom form by hooking into this action and setting the option above to true
											do_action('em_booking_form_custom', $EM_Event); //do not delete
										}else{
											//If you just want to modify booking form fields, you could do so here
											em_locate_template('forms/bookingform/booking-fields.php',true, array('EM_Event'=>$EM_Event));
										}
										do_action('em_booking_form_after_user_details', $EM_Event);
									?>
									<?php do_action('em_booking_form_footer', $EM_Event); //do not delete ?>
									<div class="em-booking-buttons">
										<?php if( preg_match('/https?:\/\//',get_option('dbem_bookings_submit_button')) ): //Settings have an image url (we assume). Use it here as the button.?>
										<input type="image" src="<?php echo get_option('dbem_bookings_submit_button'); ?>" class="em-booking-submit" id="em-booking-submit" />
										<?php else: //Display normal submit button ?>
										<input type="submit" class="em-booking-submit" id="em-booking-submit" value="<?php echo esc_attr(get_option('dbem_bookings_submit_button')); ?>" />
										<?php endif; ?>
									</div>
									<?php do_action('em_booking_form_footer_after_buttons', $EM_Event); //do not delete ?>
								</div>
							<?php else: ?>
								<p class="em-booking-form-details"><?php echo get_option('dbem_booking_feedback_log_in'); ?></p>
							<?php endif; ?>
						</form>	
						<div class = "event_login_form">
							<?php 
							if( !is_user_logged_in() && get_option('dbem_bookings_login_form') ){
								//User is not logged in, show login form (enabled on settings page)
								em_locate_template('forms/bookingform/login.php',true, array('EM_Event'=>$EM_Event));
							}
							?>
						</div>
						<br class="clear" />  
					<?php endif; ?>
				<?php endif;
			}
			?>
		</div>
	<?php }
	
	/* Get Posts By Category */
	function theneeds_get_posts_by_category($term_id='', $taxonomy=''){
		
		$post_ids = array();
		query_posts(array(
			'posts_per_page'=> -1,
			'post_type'   => 'services',
			'tax_query' => array(
				array(
					'taxonomy' => $taxonomy,
					'field' => 'term_id',
					'terms' => $term_id
				)
			),
			'post_status'      	=> 'publish',
			'order'				=> 'DESC'
		));	
		/*If posts available */
		if(have_posts()){
			while( have_posts() ){ the_post(); global $post;

				$post_ids[] = $post->ID;
			
			} /* endwhile */ wp_reset_query();
		
		} /* end if */ wp_reset_postdata();
		
		return $post_ids;
	}
	
	
	/* Get Posts By Meta */
	function theneeds_get_post_by_meta($term_id='', $taxonomy='',$orderby=''){
		
		$post_ids = array();
		$theneeds_tags = theneeds_get_tags_chunk($term_id,'yes');
		
		query_posts(array(
			'posts_per_page'=> -1,
			'post_type'   => 'services',
			'meta_key'   => 'current_price',
			'orderby'    => 'meta_value_num',
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => $taxonomy,
					'field' => 'term_id',
					'terms' => $term_id
				),
				array(
					'taxonomy' => 'services-tag',
					'field' => 'term_id',
					'terms' => array($theneeds_tags)
				)
			),
			'post_status'      	=> 'publish',
			'order'				=> $orderby,
		));	
		
		/* If posts available */
		if(have_posts()){
			
			while( have_posts() ){ the_post(); global $post;
			
				$post_ids[] = $post->ID;
			} /* endwhile */ wp_reset_query();
			
		} /* end if */ wp_reset_postdata();
		
		return $post_ids;	
	}
	
	function theneeds_get_tags_chunk($theneeds_term_id='',$onlyid=""){
		
		$theneeds_posts = theneeds_get_posts_by_category($theneeds_term_id,'services-category');
		$custom_tag = array();
		$custom_name = array();
		foreach($theneeds_posts as $theneeds_post){
			$terms = get_the_terms( $theneeds_post, 'services-tag' );
			if(!empty($terms)){
				foreach($terms as $term){
					if($onlyid == 'yes'){
						$custom_tag[] = $term->term_id;
					}else{
						$custom_tag[$term->term_id] = $term->name;
					}
				}
			}
		}
		return $custom_tag;	
	}
	
	
	/**
	* Adds classes to the array of body classes.
	*
	* @uses body_class() filter
	*/
	function theneeds_body_parent_class( $classes ) {
		global $post,$post_id;
		$facebook_class = '';
		if($post <> ''){
			$facebook_class = get_post_meta ( $post->ID, "page-option-item-facebook-selection", true );
		}
		if($facebook_class == 'Yes'){$facebook_class = 'facebook_fan';}
		$select_layout_cp = '';	
		$inner_page = '';
		if(!is_front_page()){ $inner_page = 'inner_page_cp'; }else{$inner_page = ' ';}
		$select_layout_cp = theneeds_get_themeoption_value('select_layout_cp','general_settings');
		if($select_layout_cp == 'boxed_layout'){
			$select_layout_cp = 'theneeds_boxed '.$inner_page.' '.$facebook_class;
		}else{
			$select_layout_cp = 'theneeds_full_width '.$inner_page.' '.$facebook_class;
		}

		$classes[] = $select_layout_cp ;	
		
		return $classes;
	}
	add_filter( 'body_class', 'theneeds_body_parent_class' );
	
	
	
	/* update the option if new value is exists and not equal to old one  */
	function save_option($name, $old_value, $new_value){
	
		if(empty($new_value) && !empty($old_value)){
		
			if(!delete_option($name)){
			
				return false;
				
			}
			
		}else if($old_value != $new_value){
		
			if(!update_option($name, $new_value)){
			
				return false;
				
			}
			
		}
		
		return true;
		
	}
	
	
	/* Get Post Views */
	function theneeds_getPostViews($postID){
		$count_key = 'post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return "0 View";
		}
		return $count.' Views';
	}
	
	/* Set Post Views */
	function theneeds_setPostViews($postID) {
		$count_key = 'post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}	 

	/*  Adding custom Post Type in Search Results */
	function search_filter($query) {
	 
		if ( !is_admin() && $query->is_main_query() ) {
			
			if ($query->is_search) {
			 
			 $query->set('post_type', array( 'post', 'award', 'gallery', 'team', 'features', 'projects' , 'progress', 'careers') );
			
			}
		  
		}
	
	}

	add_action('pre_get_posts','search_filter');
		

		/* Get Attachment Meta For Visual Composer Gallery */
		function wp_get_attachment( $attachment_id ) {

			$attachment = get_post( $attachment_id );
			
			return array(
				'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
				'caption' => $attachment->post_excerpt,
				'description' => $attachment->post_content,
				'href' => get_permalink( $attachment->ID ),
				'src' => $attachment->guid,
				'title' => $attachment->post_title,
				'date' => $attachment->post_date_gmt
			);
		}
		
		/* Media Uploader */
		function load_wp_media_files() {
			wp_enqueue_media();
		}
		
		add_action( 'admin_enqueue_scripts', 'load_wp_media_files' );
		add_filter('deprecated_constructor_trigger_error', '__return_false');
		
		/** Inner Banner Title Function */
		function theneeds_split_title($title){
			
			$array = explode(' ', $title, 2);
			/* Light Weight Text */
			$return_title =  esc_attr($array[0]);
			
			if(isset($array[1])){
				/* Bold Weight Text */
				$return_title .= '<span>'.' '.esc_attr($array[1]).'</span>';
			}
			
			return $return_title;
		}
		
		/* Move Comment To Above */
		function theneeds_move_comment_field_to_bottom( $fields ) {
			
			$comment_field = $fields['comment'];
			
			unset( $fields['comment'] );
			
			$fields['comment'] = $comment_field;
			
			return $fields;
		}
		
		add_filter( 'comment_form_fields', 'theneeds_move_comment_field_to_bottom' );
		
		/* Get Awards Posts*/
		function theneeds_get_awards_posts($awards_cat){
		
			global $wpdb,$post;

			if(intval($awards_cat)){
			
				$args = array( 
					'post_type' => 'award',
					'posts_per_page' => 3,
					'tax_query' => array(
						array(
							'taxonomy' => 'award-category',
							'terms' => $awards_cat,
							'field' => 'term_id',
						)
					), 
					'post_status'       => 'publish',
					'orderby' 			=> 'date',
					'order' 			=> 'ASC'
				);
					
			}else{
			
				$args = array( 
					'post_type' 		=> 'award',
					'post_status'       => 'publish',
					'posts_per_page' 	=> 3,
					'orderby'		 	=> 'date',
					'order' 			=> 'ASC'
				);
			
			}

			query_posts($args);
			
			$awards_html = '';
			
			/* Loop Begins */
			if ( have_posts() ) {
				 
				while ( have_posts() ) { the_post();
					
					echo '
					<div class="col-md-4 col-sm-4">
						<div class="award-box">
						  <div class="text-col"> <i> <em>'.get_the_post_thumbnail($post->ID,array(115,115)).'</em> <b>'.get_the_post_thumbnail($post->ID,array(115,115)).'</b></i>
							<div class="holder"> <a href="'.esc_url(get_the_permalink()).'" class="title">'.esc_attr(get_the_title()).'</a>
							  <p>'.mb_substr(get_the_content(), 0 , 112).'</p>
							</div>
						  </div>
						</div>
					</div>';
					
				} /* endwhile */ wp_reset_query();	

			} 
		}
		
			add_action('template_redirect', 'theneeds_register_user');
			 
			function theneeds_register_user(){
			  if(isset($_GET['do']) && $_GET['do'] == 'register'):
				$errors = array();
				if(empty($_POST['user'])) 
				   $errors[] = esc_html__('Please enter a fullname','theneeds');
				if(empty($_POST['email'])) 
				   $errors[] = 'Please enter a email.<br>';
				if(empty($_POST['pass'])) 
				   $errors[] = 'Please enter a password.<br>';
				if(empty($_POST['cpass'])) 
				   $errors[] = 'Please enter a confirm password.<br>';
				if((!empty($_POST['cpass']) && !empty($_POST['pass'])) && ($_POST['pass'] != $_POST['cpass'])) 
				   $errors[] = 'Entered password did not match.';
				$user_login = esc_attr($_POST['user']);
				$user_email = esc_attr($_POST['email']);
				$user_pass = esc_attr($_POST['pass']);
				$user_confirm_pass = esc_attr($_POST['cpass']);
				$user_phone = esc_attr($_POST['phone']);
				$sanitized_user_login = sanitize_user($user_login);
				$user_email = apply_filters('user_registration_email', $user_email);
			  
				if(!is_email($user_email)) 
				   $errors[] = 'Invalid e-mail.<br>';
				elseif(email_exists($user_email)) 
				   $errors[] = 'This email is already registered.<br>';
			  
				if(empty($sanitized_user_login) || !validate_username($user_login)) 
				   $errors[] = 'Invalid user name.<br>';
				elseif(username_exists($sanitized_user_login)) 
				   $errors[] = 'User name already exists.<br>';
			  
				if(empty($errors)):
				  $user_id = wp_create_user($sanitized_user_login, $user_pass, $user_email);
			  
				if(!$user_id):
				  $errors[] = 'Registration failed';
				else:
				  update_user_option($user_id, 'default_password_nag', true, true);
				  wp_new_user_notification($user_id, $user_pass);
				  update_user_meta ($user_id, 'user_phone', $user_phone);
				  wp_cache_delete ($user_id, 'users');
				  wp_cache_delete ($user_login, 'userlogins');
				  do_action ('user_register', $user_id);
				  $user_data = get_userdata ($user_id);
				  if ($user_data !== false) {
					 wp_clear_auth_cookie();
					 wp_set_auth_cookie ($user_data->ID, true);
					 do_action ('wp_login', $user_data->user_login, $user_data);

					 exit();
				   }
				  endif;
				endif;
			  
				if(!empty($errors)) 
				  define('REGISTRATION_ERROR', serialize($errors));
			  endif;
			}
			
			/* Remove Query Strings Speed Insights */
			function theneeds_remove_script_version( $src ){
				$parts = explode( '?ver', $src );
					return $parts[0];
			}
			add_filter( 'script_loader_src', 'theneeds_remove_script_version', 15, 1 );
			add_filter( 'style_loader_src', 'theneeds_remove_script_version', 15, 1 );
			
			
			/* Default Font */
			function theneeds_default_load_fonts() {
				
				wp_enqueue_style('def-googleFonts', 'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700');
				wp_enqueue_style('def-googleFonts-sig', 'https://fonts.googleapis.com/css?family=Montserrat:400,700');
				
			}
	
			add_action('wp_print_styles', 'theneeds_default_load_fonts');
			
			/*** IgnitionDeck Integration Functions ***/
			
			function theneeds_getTotalProductFund_cp($theneeds_productid) {
		
			global $wpdb;		
			
			$sql = "Select SUM(prod_price) AS prod_price from ".$wpdb->prefix . "ign_pay_info where product_id='".esc_attr($theneeds_productid)."'";
			
			$theneeds_result = $wpdb->get_row($sql);
			
			if ($theneeds_result->prod_price != NULL || $theneeds_result->prod_price != 0)
				return $theneeds_result->prod_price;
			else
				return 0;
		}

		function theneeds_getProjectGoal_cp($theneeds_project_id) {
			
			global $wpdb;
			
			$theneeds_goal_return = array('');
			$theneeds_goal_query = $wpdb->prepare('SELECT goal FROM '.$wpdb->prefix.'ign_products WHERE id=%d', $theneeds_project_id);
			$theneeds_goal_return = $wpdb->get_row($theneeds_goal_query);
			
			if($theneeds_goal_return <> ''){
				return $theneeds_goal_return->goal;
			}
		}
		
		function theneeds_getPledge_cp($theneeds_project_id) {
			
			global $wpdb;

			$theneeds_p_query = "SELECT count(*) as p_number FROM ".$wpdb->prefix . "ign_pay_info where product_id='".esc_attr($theneeds_project_id)."'";
			
			$theneeds_p_counts = $wpdb->get_results($theneeds_p_query);
			
			return $theneeds_p_counts;
		}


		function theneeds_getPercentRaised_cp($theneeds_project_id) {
			
			global $wpdb;
			
			$theneeds_total = theneeds_getTotalProductFund_cp($theneeds_project_id);
			$theneeds_goal = theneeds_getProjectGoal_cp($theneeds_project_id);
			$theneeds_percent = 0;
			if ($theneeds_total > 0) {
				$theneeds_percent = number_format($theneeds_total/$theneeds_goal*100, 2, '.', '');
			}
			return $theneeds_percent;
		}
		
		function theneeds_getPurchaseURLfromType($project_id, $page="") {
			$slug = apply_filters('idcf_archive_slug', esc_html__('projects', 'theneeds'));
			global $wpdb;
			$purchase_url = '';
			/* Set default purchase url in the event we don't have one set */
			$purchase_default = get_option('id_purchase_default');
			if (!empty($purchase_default)) {
				if (!empty($purchase_default['option'])) {
					$option = $purchase_default['option'];
					if ($option == 'page_or_post') {
						if (!empty($purchase_default['value'])) {
							$purchase_url = get_permalink($purchase_default['value']);
						}
					}
					else {
						if (isset($purchase_default['value'])) {
							$purchase_url = $purchase_default['value'];
						}
					}
				}
			}
			$project_id = absint($project_id);
			$page = urlencode($page);
			if ($project_id > 0) {
				$post = getPostDetailbyProductID($project_id);
				if (isset($post->ID)) {
					$post_page = get_post_meta($post->ID, 'ign_option_purchase_url', true);
					if (!empty($post_page)) {
						$permalink_structure = get_option('permalink_structure');
						if ($post_page !== 'default') {
							$meta_url = get_post_meta($post->ID, 'purchase_project_URL', true);
							if ($permalink_structure == "") {
								/* we no longer set defaults here since they are set above */
								if ($post_page == "current_page") {	/* If Project URL is the normal Project Page */
									if ($page == "purchaseform") {
										$purchase_url = esc_url(home_url('/'))."/?ignition_product=".$post->post_name."&purchaseform=1&prodid=".$project_id;
									}
								} 
								else if ($post_page == "page_or_post") { /* If Project URL is another post or Project page */
									$post_name = html_entity_decode(get_post_meta($post->ID, 'ign_purchase_post_name', true));
									$sql_purchase_post = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."posts WHERE post_name = %s AND post_type != 'ignition_product' LIMIT 1", $post_name);
									$purchase_post = $wpdb->get_row($sql_purchase_post);
									if (!empty($purchase_post)) {
										if ($page == "purchaseform") {
											$purchase_url = $purchase_post->guid."&purchaseform=1&prodid=".$project_id;
										}
									}	
								} 
								else if ($post_page == "external_url") { /* If some external URL is set as Project page */
									if ($page == "purchaseform" && !empty($meta_url)) {
										$purchase_url = $meta_url."&purchaseform=1&prodid=".$project_id;
									}	
								}
							} 
							else {
								if ($post_page == "current_page") {	/* If Project URL is the normal Project Page */
									if ($page == "purchaseform") {
										$purchase_url = esc_url(home_url('/'))."/".$slug."/".$post->post_name."/?purchaseform=1&prodid=".$project_id;
									}	
								} 
								else if ($post_page == "page_or_post") { /* If Project URL is another post or Project page */

									$post_name = html_entity_decode(get_post_meta($post->ID, 'ign_purchase_post_name', true));

									$sql_purchase_post = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."posts WHERE post_name = %s AND post_type != 'ignition_product' LIMIT 1", $post_name);
									$purchase_post = $wpdb->get_row($sql_purchase_post);
									if (!empty($purchase_post)) {
										if ($page == "purchaseform") {
											$purchase_url = get_permalink($purchase_post->ID)."?purchaseform=1&prodid=".$project_id;
										}
									}
								} 
								else if ($post_page == "external_url") {	/* If some external URL is set as Project page */
									if ($page == "purchaseform" && !empty($meta_url)) {
										$purchase_url = $meta_url."?purchaseform=1&prodid=".$project_id;
									}	
								}
							}
						}
						else {
							if (empty($purchase_url)) {
								$purchase_url = get_permalink($post->ID);
							}
							if ($permalink_structure == "") {
								$purchase_url = $purchase_url.'&purchaseform=1&prodid='.$project_id;
							}
							else {
								$purchase_url = $purchase_url.'?purchaseform=1&prodid='.$project_id;
							}
						}
					}
				}
			}
			
			return $purchase_url;
		}
	
		/***** Required Functions For Ignition Deck Post Type *****/

		add_action( 'add_meta_boxes', 'theneeds_meta_box_add_ignition');	

		add_action( 'save_post', 'save_ignition_option_meta'  );	

			
		function theneeds_meta_box_add_ignition(){
		
				
				add_meta_box( 'event_options', esc_html__('Ignition Project Options','theneeds'), 'theneeds_meta_box_ignition', 'ignition_product', 'normal', 'high' );
			
		}
		
		function theneeds_meta_box_ignition(){
		
				$ignition_value = '';
				
				$sidebar_ignition = '';
			
				$right_sidebar_ignition = '';
			
				$left_sidebar_ignition = '';
				
				$ignition_detail_xml = '';
				
				$projects_address = '';
				
				$ignition_post_caption = '';
				
				
				foreach($_REQUEST as $keys=>$values){
					
					$$keys = $values;
				}
			
				global $post;
				
				$ignition_detail_xml = get_post_meta($post->ID, 'ignition_detail_xml', true);

				if($ignition_detail_xml <> ''){
					
					$theneeds_ignition_xml = new DOMDocument ();
				
					$theneeds_ignition_xml->loadXML ( $ignition_detail_xml );			

					$ignition_value = theneeds_find_xml_value($theneeds_ignition_xml->documentElement,'ignition_value');
				
					$sidebar_ignition = theneeds_find_xml_value($theneeds_ignition_xml->documentElement,'sidebar_ignition');
					
					$left_sidebar_ignition = theneeds_find_xml_value($theneeds_ignition_xml->documentElement,'left_sidebar_ignition');
					
					$right_sidebar_ignition = theneeds_find_xml_value($theneeds_ignition_xml->documentElement,'right_sidebar_ignition');
					
					$projects_address = theneeds_find_xml_value($theneeds_ignition_xml->documentElement,'projects_address');
					
					$ignition_post_caption = theneeds_find_xml_value($theneeds_ignition_xml->documentElement,'ignition_post_caption');
				
				}
			?>

			<div class="event_options">
				<div class="op-gap">
					<?php echo theneeds_show_sidebar($sidebar_ignition,'right_sidebar_ignition','left_sidebar_ignition',$right_sidebar_ignition,$left_sidebar_ignition);?>
					<div class="row-fluid">
						<div class="span6">
							<ul class="panel-body recipe_class">
								<li class="panel-input">
									<span class="panel-title">
										<h3 for="projects_address" > <?php esc_html_e('Add Project Address', 'theneeds'); ?> </h3>
									</span>
									<input type="text" name="projects_address" id="projects_address" value="<?php if($projects_address <> ''){echo esc_attr($projects_address);};?>" />
									<p><?php esc_html_e('Add Project Address Here.', 'theneeds'); ?></p>
								</li>
							</ul>
						</div>
						<div class="span6">
							<ul class="panel-body recipe_class">
								<li class="panel-input">
									<span class="panel-title">
										<h3 for="ignition_post_caption" > <?php esc_html_e('Add Project Caption', 'theneeds'); ?> </h3>
									</span>
									<input type="text" name="ignition_post_caption" id="ignition_post_caption" value="<?php if($ignition_post_caption <> ''){echo esc_attr($ignition_post_caption);};?>" />
									<p><?php esc_html_e('Add Project Caption Here.', 'theneeds'); ?></p>
								</li>
							</ul>
						</div>
					</div>
					<input type="hidden" name="ignition_submit" value="ignition"/>	
				</div>
			</div>		
		<?php }
		
		function save_ignition_option_meta($post_id){
				
				$ignition_value = '';
				$sidebars = '';
				$right_sidebar_ignition = '';
				$left_sidebar_ignition = '';
				$projects_address = '';
				$ignition_post_caption = '';
				

				foreach($_REQUEST as $keys=>$values){
					$$keys = $values;
				}
				
			
				if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;
			
					if(isset($ignition_submit) AND $ignition_submit == 'ignition'){
						$new_data = '<ignition_detail>';
						$new_data = $new_data . theneeds_create_xml_tag('ignition_value',$ignition_value);
						$new_data = $new_data . theneeds_create_xml_tag('sidebar_ignition',$sidebars);
						$new_data = $new_data . theneeds_create_xml_tag('right_sidebar_ignition',$right_sidebar_ignition);
						$new_data = $new_data . theneeds_create_xml_tag('left_sidebar_ignition',$left_sidebar_ignition);
						$new_data = $new_data . theneeds_create_xml_tag('projects_address',$projects_address);
						$new_data = $new_data . theneeds_create_xml_tag('ignition_post_caption',$ignition_post_caption);
	
						$new_data = $new_data . '</ignition_detail>';
						/* Saving Sidebar and Social Sharing Settings as XML */
						$old_data = get_post_meta($post_id, 'ignition_detail_xml',true);
						theneeds_save_meta_data($post_id, $new_data, $old_data, 'ignition_detail_xml');
						
					}
		}
		
		/***** Required Functions For Campaign Post Type *****/

		add_action( 'add_meta_boxes', 'theneeds_meta_box_add_campaign');	

		add_action( 'save_post', 'save_campaign_option_meta'  );	

			
		function theneeds_meta_box_add_campaign(){
		
				
				add_meta_box( 'event_options', esc_html__('Campaign Options','theneeds'), 'theneeds_meta_box_campaign', 'campaign', 'normal', 'high' );
			
		}
		
		function theneeds_meta_box_campaign(){
				
				$sidebar_campaign = '';
			
				$right_sidebar_campaign = '';
			
				$left_sidebar_campaign = '';
				
				$campaigndetail_xml = '';
				
				$campaign_post_caption = '';

				foreach($_REQUEST as $keys=>$values){
					
					$$keys = $values;
				}
			
				global $post;
				
				$campaigndetail_xml = get_post_meta($post->ID, 'campaigndetail_xml', true);

				if($campaigndetail_xml <> ''){
					
					$theneeds_campaignxml = new DOMDocument ();
				
					$theneeds_campaignxml->loadXML ( $campaigndetail_xml );			
				
					$sidebar_campaign = theneeds_find_xml_value($theneeds_campaignxml->documentElement,'sidebar_campaign');
					
					$left_sidebar_campaign = theneeds_find_xml_value($theneeds_campaignxml->documentElement,'left_sidebar_campaign');
					
					$right_sidebar_campaign = theneeds_find_xml_value($theneeds_campaignxml->documentElement,'right_sidebar_campaign');
					
					$campaign_post_caption = theneeds_find_xml_value($theneeds_campaignxml->documentElement,'campaign_post_caption');
					
				
				}
			?>

			<div class="event_options">
				<div class="op-gap">
					<?php echo theneeds_show_sidebar($sidebar_campaign,'right_sidebar_campaign','left_sidebar_campaign',$right_sidebar_campaign,$left_sidebar_campaign);?>
					<div class="row-fluid">
						<div class="span6">
							<ul class="panel-body recipe_class">
								<li class="panel-input">
									<span class="panel-title">
										<h3 for="campaign_post_caption" > <?php esc_html_e('Add Campaign Caption', 'theneeds'); ?> </h3>
									</span>
									<input type="text" name="campaign_post_caption" id="campaign_post_caption" value="<?php if($campaign_post_caption <> ''){echo esc_attr($campaign_post_caption);};?>" />
									<p><?php esc_html_e('Add Campaign Caption Here.', 'theneeds'); ?></p>
								</li>
							</ul>
						</div>
					</div>
					<input type="hidden" name="campaignsubmit" value="campaign"/>	
				</div>
			</div>		
		<?php }
		
		function save_campaign_option_meta($post_id){
				
				$campaignvalue = '';
				$sidebars = '';
				$right_sidebar_campaign = '';
				$left_sidebar_campaign = '';
				$campaign_post_caption = '';
				
				foreach($_REQUEST as $keys=>$values){
					$$keys = $values;
				}
				
			
				if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;
			
					if(isset($campaignsubmit) AND $campaignsubmit == 'campaign'){
						$new_data = '<campaigndetail>';
						$new_data = $new_data . theneeds_create_xml_tag('campaignvalue',$campaignvalue);
						$new_data = $new_data . theneeds_create_xml_tag('sidebar_campaign',$sidebars);
						$new_data = $new_data . theneeds_create_xml_tag('right_sidebar_campaign',$right_sidebar_campaign);
						$new_data = $new_data . theneeds_create_xml_tag('left_sidebar_campaign',$left_sidebar_campaign);
						$new_data = $new_data . theneeds_create_xml_tag('campaign_post_caption',$campaign_post_caption);
						
						$new_data = $new_data . '</campaigndetail>';
						/* Saving Sidebar and Social Sharing Settings as XML */
						$old_data = get_post_meta($post_id, 'campaigndetail_xml',true);
						theneeds_save_meta_data($post_id, $new_data, $old_data, 'campaigndetail_xml');
						
					}
		}