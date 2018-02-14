<?php
/*
Plugin Name: CP Framework
Plugin URL: http://crunchpress.com/
Description: Base File for Custom Post type and for CrunchPress Page Builder.
Version: 1.0
Author: CrunchPress
Author URI: http://www.crunchpress.com/
*/

    
/* logical location for CP framework */
if(!defined( 'theneeds_PATH_URL' )){ define('theneeds_PATH_URL', get_template_directory_uri());}
/* Physical location for CP framework */
if(!defined( 'theneeds_PATH_SER' )){define('theneeds_PATH_SER', get_template_directory() );}            
/* Define URL path of framework directory */
if(!defined( 'theneeds_FW_URL' )){define( 'theneeds_FW_URL', theneeds_PATH_URL . '/framework' );}
/* Define server path of framework directory  */           
if(!defined( 'theneeds_FW' )){define( 'theneeds_FW', theneeds_PATH_SER . '/framework' );}
/* Define admin url */
if(!defined( 'AJAX_URL' )){define('AJAX_URL', admin_url( 'admin-ajax.php' ));}

/* Remove LayerSlider Scripts */
if(class_exists('LS_Sliders')){
	remove_action('wp_enqueue_scripts', 'layerslider_enqueue_content_res');
}
	
class theneeds_function_library{
	
	public function create_variable($name, $value) {
		return $this->{$name} = new $value;
	}

	/* function that save the meta to database if new data exists and is not equals to old one */
	public function theneeds_save_meta_data($post_id, $new_data, $old_data, $name){
		
		if($new_data == $old_data){
			add_post_meta($post_id, $name, $new_data, true);
		}else if(!$new_data){
			delete_post_meta($post_id, $name, $old_data);
		}else if($new_data != $old_data){
			update_post_meta($post_id, $name, $new_data, $old_data);
		}
	}
	
	/* Add Action and Remove action */
	public function __construct()
    {
		add_action( 'wp_head', array( $this, 'theneeds_ajax_ajaxurl' ) );
		remove_action( 'wp_head', array( $this, 'adjacent_posts_rel_link_wp_head' ) );
		$this->theneeds_get_google_font();
		
		//add_action('template_redirect', 'register_user');
		
		add_action( 'template_redirect', array( $this, 'theneeds_register_user' ) );
	
    }
	
	
	public function theneeds_register_user(){
		  if(isset($_GET['do']) && $_GET['do'] == 'register'):
			$errors = array();
			if(empty($_POST['user'])) 
			   $errors[] = 'Please enter a fullname.<br>';
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
				 // Redirect user.
				 wp_redirect (home_url());
				 exit();
			   }
			  endif;
			endif;
		  
			if(!empty($errors)) 
			  define('REGISTRATION_ERROR', serialize($errors));
		  endif;
	}
	
	/* Find the XML value from XML Object */
	public function theneeds_find_xml_value($xml, $field){
	
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
	public function theneeds_verify_font($font_google){
	
	$fonts_array = theneeds_get_font_array();
		foreach($fonts_array as $keys=>$values){
			if($values == 'Google Font'){
				if($keys == $font_google){
					return 'Google Font';
				}
			}
		}
	}
	
	public function verify_google_f($font_google){
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
	
	
	public function theneeds_verify_google_para($font_heading){
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
	
	public function theneeds_verify_google_menu($font_menu){
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
	
	public function find_xml_child_nodes($xml_data,$tag_name,$child_node){
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
	public function return_xml_array($children_des){
		$array_data = array();
		$counter = 0;
		foreach($children_des as $values){
			$array_data[] = $values->nodeValue;
		}
		return $array_data;
	}
	
	
	
	/* Find the XML node from XML Object */
	public function theneeds_find_xml_node($xml, $node){
	
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
	public function theneeds_create_xml_tag($node, $value){
	
		return '<' . $node . '>' . $value . '</' . $node . '>';
		
	}
	

	public function theneeds_get_google_font(){
	
	
	require_once dirname( __FILE__ ) .'/google-font.php';
	  
		global $all_font;
		
		$google_fonts = update_google_font_array_plugin();
		
		foreach($google_fonts as $google_font){
		
			$all_font[$google_font['family']] = array('status'=>'enabled','type'=>'Google Font','is-used'=>false);
		
		}
		
	}
	
	public function theneeds_get_font_array( $type = '' ){
		
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
		
			if( empty($type) || $type == $font_value['type'] ){
				$fonts[$font_name] = $font_value['type'];
			}
			
		}
			
		return $fonts;
		
	}
	

	// use ajax to print all of media image
	
	
	public function theneeds_get_media_image(){
	
		$image_width = 150;
		$image_height = 150;
		
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
		echo '<a><li class="nav-last" rel="' . $media_query->max_num_pages . '"></li></a>';
		echo '</ul>';
		echo '</div><br class=clear>';
	
		echo '<ul>';
		
		foreach( $media_query->posts as $image ){ 
		
			$thumb_src = wp_get_attachment_image_src( $image->ID, array(150,150));
			$thumb_src_preview = wp_get_attachment_image_src( $image->ID, array(150,150));
			echo '<li><img src="' . $thumb_src[0] .'" title="' . $image->post_title . '" attid="' . $image->ID . '" rel="' . $thumb_src_preview[0] . '"/></li>';
		
		}
		
		echo '</ul><br class=clear>';
		
		if(isset($_POST['page'])){ die(''); }
	}
	
	
	//Adding Ajax Url for Dummy Data
	
	public function theneeds_ajax_ajaxurl() {?>
		<script type="text/javascript">
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		</script>
	<?php
	}

	/* return the slider option array to use with javascript file */
	public function get_theneeds_slider_option_array($slider_option){
	
		$slider_setting = array();
	
		foreach($slider_option as $value){
			
			$set_value = get_option($value['name']);
			
			if(isset($value['oldname']) && $set_value){
			
				$slider_setting[$value['oldname']] = $set_value;
			
			}
		}
		
		return $slider_setting;
	}


	
	/* return the title list of each post_type */
	public function theneeds_get_title_list( $post_type ){
		
		$posts_title = array();
		$posts = get_posts(array('post_type' => $post_type, 'numberposts'=>100));
		
		foreach ($posts as $post) {
			$posts_title[] = $post->post_title;
		}
		
		return $posts_title;
	
	}
	
	
	// return the title list of each post_type
	public function theneeds_get_title_list_array( $post_type ){
		
		$posts_title = array();
		$posts = get_posts(array('post_type' => $post_type, 'numberposts'=>100));
		
		foreach ($posts as $post) {
			$posts_title[] = $post;
		}
		
		return $posts_title;
	
	}

	

	/* return the title list of each post_type */
	public function theneeds_layer_slider_title(){
		if(function_exists('layerslider_activation_scripts')){
			global $wpdb;
			$table_name = $wpdb->prefix . "layerslider";
				$sliders = $wpdb->get_results( "SELECT * FROM $table_name
					WHERE flag_hidden = '0' AND flag_deleted = '0'
					ORDER BY date_c ASC LIMIT 100" );
			if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$table_name."'"))==1) {
				foreach($sliders as $keys=>$values){
					$post_title[] = $values->name;
				}
				return $post_title;
			}
		}
	}
	
	/* return the title list of each post_type */
	public function theneeds_layer_slider_id(){
		
		global $wpdb,$post_id_slider;
		$post_id_slider = '';
		$table_name = $wpdb->prefix . "layerslider";
			$sliders = $wpdb->get_results( "SELECT * FROM $table_name
				WHERE flag_hidden = '0' AND flag_deleted = '0'
				ORDER BY date_c ASC LIMIT 100" );
		
			foreach($sliders as $keys=>$values){
				$post_id_slider[] = $values->id;
								
			}
			return $post_id_slider;
		
	
	}
	

	public function theneeds_show_sidebar($sidebar_name, $right_sidebar,$left_sidebar,$value_right,$value_left){ ?>
			<ul class="panel-body recipe_class row-fluid">
				
				<li class="panel-radioimage span12">
					<div class="panel-title ">
						<h3><?php _e('Select Sidebar', 'theneeds'); ?></h3>
					</div>
					<div class="clear"></div>
					<?php 
						$options = array(
							'1'=>array('value'=>'right-sidebar','image'=>'/framework/images/right-sidebar.png'),
							'2'=>array('value'=>'left-sidebar','image'=>'/framework/images/left-sidebar.png'),
							'3'=>array('value'=>'both-sidebar','image'=>'/framework/images/both-sidebar.png','default'=>'selected'),
							'4'=>array('value'=>'both-sidebar-left','image'=>'/framework/images/both-sidebar-left.png'),
							'5'=>array('value'=>'both-sidebar-right','image'=>'/framework/images/both-sidebar-right.png'),
							'6'=>array('value'=>'no-sidebar','image'=>'/framework/images/no-sidebar.png')
						);
					foreach( $options as $option ){ ?>
						<div class='radio-image-wrapper'>
							<span class="head-sec-sidebar"><?php echo str_replace('-',' ',$option['value']); ?></span>
							<label for="<?php echo $option['value']; ?>">
								<img src=<?php echo theneeds_PATH_URL.$option['image']?> class="<?php echo $sidebar_name;?>" alt="<?php echo $sidebar_name;?>">
								<div id="check-list" <?php 
									if($sidebar_name == $option['value']){
										echo 'class="check-list"';
									}
								?>>
							</div>                                
							</label>
							<input type="radio" name="sidebars" value="<?php echo $option['value']; ?>" <?php 
									if($sidebar_name == $option['value']){
										echo 'checked';
									}
							?> id="<?php echo $option['value']; ?>" class="<?php echo $sidebar_name;?>"
							>                            
						</div>
					<?php } ?>
				</li>
			</ul>
			<div class="row-fluid">
				<ul class="theneeds_right_sidebar recipe_class span6">
					
					<li class="panel-input">	
						<div class="panel-title">
							<h3><?php _e('Right Sidebar', 'theneeds'); ?></h3>
						</div>
						<div class="combobox">
							<select name="<?php echo $right_sidebar?>" id="theneeds_sidebar_dropdown">								
								<?php
								$theneeds_sidebar_settings = get_option('sidebar_settings');
								if($theneeds_sidebar_settings <> ''){
									$sidebars_xml = new DOMDocument();
									$sidebars_xml->loadXML($theneeds_sidebar_settings);
									foreach( $sidebars_xml->documentElement->childNodes as $sidebar_name ){?>
										<option <?php if($value_right == $sidebar_name->nodeValue){ echo 'selected';}?> value="<?php echo $sidebar_name->nodeValue; ?>"><?php echo $sidebar_name->nodeValue; ?></option>
								<?php }
								} ?>	
							</select>
						</div>
						<p><?php _e('Select Slide from dropdown to use in main slider.', 'theneeds'); ?></p>
					</li>
					
				</ul>
				<ul class="theneeds_left_sidebar recipe_class span6">
					
					<li class="panel-input">	
						<div class="panel-title">
							<h3><?php _e('Left Sidebar', 'theneeds'); ?></h3>
						</div>
						<div class="combobox">
							<select name="<?php echo $left_sidebar?>" id="theneeds_sidebar_dropdown_left">								
								<?php
								if($theneeds_sidebar_settings <> ''){
									$sidebars_xml = new DOMDocument();
									$sidebars_xml->loadXML($theneeds_sidebar_settings);
									foreach( $sidebars_xml->documentElement->childNodes as $sidebar_name ){?>
										<option <?php if($value_left == $sidebar_name->nodeValue){ echo 'selected';}?> value="<?php echo $sidebar_name->nodeValue; ?>"><?php echo $sidebar_name->nodeValue; ?></option>
								<?php }
								} ?>	
							</select>
						</div>
						<p><?php _e('Select Slide from dropdown to use in main slider.', 'theneeds'); ?></p>
					</li>
					
				</ul>
			</div>
			<div class="clear"></div>
<?php } 
	
	public function theneeds_get_slider_id($slider_name){
		
		if(!empty($slider_name)){
		$layer_slider_id = get_post_meta( $slider_name, 'cp-slider-xml', true);
			if($layer_slider_id <> ''){
				$slider_xml_dom = new DOMDocument ();
				$slider_xml_dom->loadXML ( $layer_slider_id );
				return $slider_xml_dom->documentElement;
			}
		}
	}
	
}

/* Custom Post type */
include_once('post-type-options/gallery/theneeds_gallery.php'); 	/* Manage Gallery  */
include_once('post-type-options/shortcodes/shortcodes.php'); 		/* Manage Shortcodes */
include_once('post-type-options/sliders/theneeds_slider.php'); 	/* Manage Slider */
include_once('post-type-options/testimonials/theneeds_testimonials.php'); /* Manage Testimonials */
include_once('post-type-options/teams/theneeds_team.php'); 		/* Manage Teams */
include_once('post-type-options/features/theneeds_features.php'); 	/* Manage features */
include_once('post-type-options/projects/theneeds_projects.php'); 	/* Manage projects */
include_once('post-type-options/events/theneeds_events.php'); 	/* Manage Events */
include_once('widgets/twitter_widget.php');  					/* Manage Twitter Widget */

add_action( 'muplugins_loaded', 'base_fun_override' );

function base_fun_override() {

	$theneeds_function_library = new theneeds_function_library;
}
?>