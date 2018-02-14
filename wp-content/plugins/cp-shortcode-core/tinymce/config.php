<?php
/*-----------------------------------------------------------------------------------*/
/*	Default Options
/*-----------------------------------------------------------------------------------*/

// Number of posts array
function theneeds_shortcodes_range ( $range, $all = true, $default = false, $range_start = 1 ) {
	if($all) {
		$number_of_posts['-1'] = 'All';
	}

	if($default) {
		$number_of_posts[''] = 'Default';
	}

	foreach(range($range_start, $range) as $number) {
		$number_of_posts[$number] = $number;
	}

	return $number_of_posts;
}

// Taxonomies
function theneeds_shortcodes_categories ( $taxonomy, $empty_choice = false ) {
	if($empty_choice == true) {
		$post_categories[''] = 'Default';
	}

	$get_categories = get_categories('hide_empty=0&taxonomy=' . $taxonomy);

	if( ! array_key_exists('errors', $get_categories) ) {
		if( $get_categories && is_array($get_categories) ) {
			foreach ( $get_categories as $cat ) {
				$post_categories[$cat->slug] = $cat->name;
			}
		}

		if(isset($post_categories)) {
			return $post_categories;
		}
	}
}

// return the title list of each post_type
function get_title_list_index( $post_type ){
	
	$posts_title = array();
	$posts = get_posts(array('post_type' => $post_type, 'numberposts'=>100));
	
	foreach ($posts as $post) {
		$posts_title[$post->ID] = $post->post_title;
	}
	
	return $posts_title;

}

//Fetch Categories
function get_category_list_index( $category_name, $parent='' ){
	
	if( empty($parent) ){ 
		$category_list = array();
		$get_category = get_categories( array( 'taxonomy' => $category_name	));
		if($get_category <> ''){
			foreach( $get_category as $category ){
				if(isset($category)){
					$category_list[$category->term_id] = $category->name;
				}
			}
		}
			
		return $category_list;
		
	}else{
		//$category_list = array( '0' =>'All');
		$parent_id = get_term_by('name', $parent, $category_name);
		$get_category = get_categories( array( 'taxonomy' => $category_name, 'child_of' => $parent_id->term_id	));
		$category_list = array( '0' => $parent );
		if($get_category <> ''){
			foreach( $get_category as $category ){
				if(isset($category)){
					$category_list[$category->term_id] = $category->name;
				}
			}
		}
			
		return $category_list;		
	
	}
}

$choices = array('yes' => 'Yes', 'no' => 'No');
$reverse_choices = array('no' => 'No', 'yes' => 'Yes');
$dec_numbers = array('0.1' => '0.1', '0.2' => '0.2', '0.3' => '0.3', '0.4' => '0.4', '0.5' => '0.5', '0.6' => '0.6', '0.7' => '0.7', '0.8' => '0.8', '0.9' => '0.9', '1' => '1' );



//Default wordpress post category
$category = get_category_list_index('category');
//WooCommerce taxonomy
if(class_exists('Woocommerce')){
	$product_cat = get_category_list_index('product_cat');
}else{
	$product_cat = array();
}
//Check Main Function is exist
if(class_exists('function_library')){
	$team_category = get_category_list_index('team-category');
	$testimonial_category = get_category_list_index('testimonial-category');
	$members_category = get_category_list_index('members-category');
	//$portfolio_category = get_category_list_index('portfolio-category');
}else{
	$team_category = array();
	$testimonial_category = array();
	$portfolio_category = array();
	$members_category = array();
}
if(class_exists('EM_Events')){
	$event_name = get_title_list_index('event');
}else{
	$event_name = array();
}

// Fontawesome icons list
$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
$fontawesome_path = theneeds_TINYMCE_DIR . '/css/font-awesome.css';
if( file_exists( $fontawesome_path ) ) {
	@$subject = file_get_contents($fontawesome_path);
}

preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

$icons = array();

foreach($matches as $match){
	$icons[$match[1]] = $match[2];
}

$checklist_icons = array ( 'icon-check' => '\f00c', 'icon-star' => '\f006', 'icon-angle-right' => '\f105', 'icon-asterisk' => '\f069', 'icon-remove' => '\f00d', 'icon-plus' => '\f067' );

/*-----------------------------------------------------------------------------------*/
/*	Shortcode Selection Config
/*-----------------------------------------------------------------------------------*/

$theneeds_shortcodes['shortcode-generator'] = array(
	'no_preview' => true,
	'params' => array(),
	'shortcode' => '',
	'popup_title' => ''
);

/*-----------------------------------------------------------------------------------*/
/*	Alert
/*-----------------------------------------------------------------------------------*/

$theneeds_shortcodes['alert'] = array(
	'no_preview' => true,
	'params' => array(

		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'the_arcade'),
			'desc' => __('Click an icon to select, click again to deselect', 'the_arcade'),
			'options' => $icons
		),
		
		'color_light' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Select Gradient Color', 'the_arcade'),
			'desc' => 'Set color tune of alert background! Gradient Alert Light Color'
		),
		
		'color_dark' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Select Gradient Color', 'the_arcade'),
			'desc' => 'Set color tune of alert background! Gradient Alert Dark Color'
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Alert Content', 'the_arcade' ),
			'desc' => __( 'Insert the alert\'s content', 'the_arcade' ),
		),
	),
	'shortcode'=>'[alert icon="{{icon}}" color_light="{{color_light}}" color_dark="{{color_dark}}" ]{{content}}[/alert]',
	'popup_title' => __( 'Alert Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Banner Tabs
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['banner_tabs'] = array(
	'no_preview' => true,
	'params' => array(

	),
	
	'shortcode'=>'[banner_tab]{{child_shortcode}}[/banner_tab]',
	'popup_title' => __( 'Tabs Shortcode', 'begood' ),
	
	/* child shortcode is clonable & sortable */
	'child_shortcode' => array(
		'params' => array(
		
			'link' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add URL', 'begood'),
				'desc' => __('Add url for image.', 'begood')
			),
			
			'title' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Set Title', 'begood'),
				'desc' => __('Item Title', 'begood')
			),
			
			'url' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add URL', 'begood'),
				'desc' => __('Add url for page.', 'begood')
			),
			
			'content' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'Your Item Content Here', 'begood' ),
				'desc' => __( 'Item Content', 'begood' ),
			),
		),

		'shortcode'=> '[banner_tab_item title="{{title}}" link="{{link}}" url="{{url}}"]{{content}}[/banner_tab_item]',
		'clone_button' => __('Add Another Tab', 'begood')
	)
);


/*-----------------------------------------------------------------------------------*/
/*	Parallex Icon Box
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['parallex_box_icons'] = array(
	'no_preview' => true,
	'params' => array(
	
		'heading' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Set Heading', 'begood'),
				'desc' => __('Heading Will Appear At Top', 'begood')
		),
		
		'support_link' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add URL', 'begood'),
				'desc' => __('Add URL For Support Link.', 'begood')
		),
		
		'btn_style' => array(
			'type' => 'select',
			'label' => __( 'Button Style', 'begood' ),
			'desc' => __( 'Select Style of Button', 'begood' ),
			'options' => array(
				'btn-1' => 'Charity',
				'btn-2' => 'Politics',
			)
		),
		
		'btn_text' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add Button Text', 'begood'),
				'desc' => __('Added Text Will Appear On Button.', 'begood')
		),
		

	),
	
	'shortcode'=>'[parallex_box_icons heading="{{heading}}" support_link="{{support_link}}" btn_style="{{btn_style}}" btn_text="{{btn_text}}"]{{child_shortcode}}[/parallex_box_icons]',
	'popup_title' => __( 'Parallex Box Icons Shortcode', 'begood' ),
	
	/* child shortcode is clonable & sortable */
	'child_shortcode' => array(
		'params' => array(
		
			'icon' => array(
				'type' => 'iconpicker',
				'label' => __('Select Icon', 'begood'),
				'desc' => __('Click an icon to select, click again to deselect', 'begood'),
				'options' => $icons
			),
			
			'title' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Set Title', 'begood'),
				'desc' => __('Item Title', 'begood')
			),
			
			'url' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add URL', 'begood'),
				'desc' => __('Add url for page.', 'begood')
			),
			
			'content' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'Your Item Content Here', 'begood' ),
				'desc' => __( 'Item Content', 'begood' ),
			),
		),

		'shortcode'=> '[parallex_box_item title="{{title}}" icon="{{icon}}" url="{{url}}"]{{content}}[/parallex_box_item]',
		'clone_button' => __('Add Another Icon', 'begood')
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Parallex Icon Box Church
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['parallex_box_icons_church'] = array(
	'no_preview' => true,
	'params' => array(
	
		'heading' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Set Heading', 'begood'),
				'desc' => __('Heading Will Appear At Top', 'begood')
		),
		
		'support_link' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add URL', 'begood'),
				'desc' => __('Add URL For Support Link.', 'begood')
		),
		

	),
	
	'shortcode'=>'[parallex_box_icons_church heading="{{heading}}" support_link="{{support_link}}"]{{child_shortcode}}[/parallex_box_icons_church]',
	'popup_title' => __( 'Parallex Box Icons Shortcode', 'begood' ),
	
	/* child shortcode is clonable & sortable */
	'child_shortcode' => array(
		'params' => array(
		
			'icon' => array(
				'type' => 'iconpicker',
				'label' => __('Select Icon', 'begood'),
				'desc' => __('Click an icon to select, click again to deselect', 'begood'),
				'options' => $icons
			),
			
			'title' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Set Title', 'begood'),
				'desc' => __('Item Title', 'begood')
			),
			
			'url' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add URL', 'begood'),
				'desc' => __('Add url for page.', 'begood')
			),
			
			'content' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'Your Item Content Here', 'begood' ),
				'desc' => __( 'Item Content', 'begood' ),
			),
		),

		'shortcode'=> '[parallex_box_item_church title="{{title}}" icon="{{icon}}" url="{{url}}"]{{content}}[/parallex_box_item_church]',
		'clone_button' => __('Add Another Icon', 'begood')
	)
);




/*-----------------------------------------------------------------------------------*/
/*	Latest Products
/*-----------------------------------------------------------------------------------*/
$theneeds_shortcodes['latest-pro'] = array(
	'no_preview' => true,
	'params' => array(

		'title' => array(
			'std' => 'Title',
			'type' => 'text',
			'label' => __('Title', 'the_arcade'),
			'desc' => __('Title of the ShortCode.', 'the_arcade')
		),
		
		'cat_id' => array(
			'type' => 'select',
			'label' => __( 'Select Category', 'the_arcade' ),
			'desc' => __( 'Select name of category you want to fetch products', 'the_arcade' ),
			'options' => $product_cat,
		),
	
		'number_of_products' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Number Of Products', 'the_arcade'),
			'desc' => __('Add Number of Products You wanna Display', 'the_arcade')
		),
			
		
	),
	'shortcode'=>'[latest-pro title="{{title}}" cat_id="{{cat_id}}" number_of_products="{{number_of_products}}"][/latest-pro]',
	'popup_title' => __( 'Latest Products Shortcode', 'the_arcade' )
);


/*-----------------------------------------------------------------------------------*/
/*	Top Scorers ingenio
/*-----------------------------------------------------------------------------------*/
$theneeds_shortcodes['top-score'] = array(
	'no_preview' => true,
	'params' => array(

		'title' => array(
			'std' => 'Title',
			'type' => 'text',
			'label' => __('Title', 'the_arcade'),
			'desc' => __('Title of the ShortCode.', 'the_arcade')
		),
		
		'cat_id' => array(
			'type' => 'select',
			'label' => __( 'Select Category', 'the_arcade' ),
			'desc' => __( 'Select name of category you want to fetch players', 'the_arcade' ),
			'options' => $members_category,
		),
	
		'number_of_players' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Number Of Players', 'the_arcade'),
			'desc' => __('Add Number of Players You wanna Display', 'the_arcade')
		),
			
		
	),
	'shortcode'=>'[top-score title="{{title}}" cat_id="{{cat_id}}" number_of_players="{{number_of_players}}"][/top-score]',
	'popup_title' => __( 'Top Scores Shortcode', 'the_arcade' )
);



/*-----------------------------------------------------------------------------------*/
/*	Legal News
/*-----------------------------------------------------------------------------------*/
$theneeds_shortcodes['news'] = array(
	'no_preview' => true,
	'params' => array(

		// 'number_posts' => array(
			// 'type' => 'select',
			// 'label' => __( 'Number of News', 'the_arcade' ),
			// 'desc' => __( 'Select number of News per page', 'the_arcade' ),
			//'options' => theneeds_shortcodes_range( 25, true, true )
		// ),
		
		'cat_id' => array(
			'type' => 'select',
			'label' => __( 'Select Category', 'the_arcade' ),
			'desc' => __( 'Select name of category you want to fetch news from', 'the_arcade' ),
			'options' => $category,
		),
		
		'title' => array(
			'std' => 'News Shortcode Title',
			'type' => 'text',
			'label' => __('News Title', 'the_arcade'),
			'desc' => __('Header or News Title of the List', 'the_arcade')
		),
		
		'num_posts' => array(
			'std' => 'Number of News',
			'type' => 'text',
			'label' => __('Number of News', 'the_arcade'),
			'desc' => __('Number of News To Display', 'the_arcade')
		),
		
		// 'thumbnail' => array(
			// 'type' => 'select',
			// 'label' => __( 'Thumbnail', 'the_arcade' ),
			// 'desc' => __( 'Yes or No', 'the_arcade' ),
			// 'options' => array(
				// 'yes' => 'yes',
				// 'no' => 'no',
			
			// )
		// ),
				
		'excerpt_words' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Excerpt Length', 'the_arcade'),
			'desc' => __('50words to 250words', 'the_arcade')
		),
			
		// 'paging' => array(
			// 'type' => 'select',
			// 'label' => __( 'Pagination', 'the_arcade' ),
			// 'desc' => __( 'Yes or No', 'the_arcade' ),
			// 'options' => array(
				// 'yes' => 'yes',
				// 'no' => 'no',
			
			// )
		
		// ),
	),
	'shortcode'=>'[news cat_id="{{cat_id}}" num_posts = "{{num_posts}}" title="{{title}}"  excerpt_words="{{excerpt_words}}"][/news]',
	'popup_title' => __( 'Legal News Shortcode', 'the_arcade' )
);



/*-----------------------------------------------------------------------------------*/
/*	Blog
/*-----------------------------------------------------------------------------------*/
$theneeds_shortcodes['blog'] = array(
	'no_preview' => true,
	'params' => array(

		'number_posts' => array(
			'type' => 'select',
			'label' => __( 'Number of Posts', 'the_arcade' ),
			'desc' => __( 'Select number of posts per page', 'the_arcade' ),
			'options' => theneeds_shortcodes_range( 25, true, true )
		),
		
		'cat_id' => array(
			'type' => 'select',
			'label' => __( 'Select Category', 'the_arcade' ),
			'desc' => __( 'Select name of category you want to fetch, and in shortcode it will paste id of selected category', 'the_arcade' ),
			'options' => $category,
		),
		
		'title' => array(
			'std' => 'Blog Title',
			'type' => 'text',
			'label' => __('Blog Title', 'the_arcade'),
			'desc' => __('Header or Blog Title of the listing.', 'the_arcade')
		),
		
		'thumbnail' => array(
			'type' => 'select',
			'label' => __( 'Thumbnail', 'the_arcade' ),
			'desc' => __( 'Yes or No', 'the_arcade' ),
			'options' => array(
				'yes' => 'yes',
				'no' => 'no',
			
			)
		),
				
		'excerpt_words' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Number of excerpt words', 'the_arcade'),
			'desc' => __('50words to 250words', 'the_arcade')
		),
			
		'paging' => array(
			'type' => 'select',
			'label' => __( 'Pagination', 'the_arcade' ),
			'desc' => __( 'Yes or No', 'the_arcade' ),
			'options' => array(
				'yes' => 'yes',
				'no' => 'no',
			
			)
		
		),
	),
	'shortcode'=>'[blog number_posts="{{number_posts}}" cat_id="{{cat_id}}" title="{{title}}" thumbnail="{{thumbnail}}" excerpt_words="{{excerpt_words}}" paging="{{paging}}"][/blog]',
	'popup_title' => __( 'Blog Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Headline
/*-----------------------------------------------------------------------------------*/
$theneeds_shortcodes['heading'] = array(
	'no_preview' => true,
	'params' => array(
		
		'align' => array(
			'type' => 'select',
			'label' => __( 'Alignment', 'begood' ),
			'desc' => __( 'Left, Right, Center', 'begood' ),
			'options' => array(
				'left' => 'Left',
				'right' => 'Right',
				'center' => 'Center',
			)
		),
		
		'title' => array(
			'std' => 'Title',
			'type' => 'text',
			'label' => __('Add Title', 'begood'),
			'desc' => __('Add title for element here.', 'begood')
		),
		
		'title_color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Title Color', 'begood'),
			'desc' => 'Leave blank for default'
		),
		
		'style' => array(
			'type' => 'select',
			'label' => __( 'Heading Style', 'begood' ),
			'desc' => __( 'Select Heading Style', 'begood' ),
			'options' => array(
				'simple-heading' => 'Simple Style',
				'eco-heading' => 'Eco Style',
				'islamic-heading' => 'Islamic Style',
				'church-heading' => 'Church Style',
				'politics-heading' => 'Political Style',
				'store-heading' => 'Store Style',
			)
		),
		
		'tag' => array(
			'type' => 'select',
			'label' => __( 'Heading Tag', 'begood' ),
			'desc' => __( 'Select Heading Tag', 'begood' ),
			'options' => array(
				'h1' => 'h1',
				'h2' => 'h2',
			)
		),
		
		'desc_color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Description Color', 'begood'),
			'desc' => 'Leave blank for default'
		),
		
		'description' => array(
			'std' => 'Caption Or Sub Text',
			'type' => 'text',
			'label' => __('Sub Heading or Caption', 'begood'),
			'desc' => __('Add short sub heading or caption under heading.', 'begood')
		),
		
	),
	'shortcode'=>'[heading align="{{align}}" tag= "{{tag}}" title="{{title}}"  title_color="{{title_color}}"  style="{{style}}" desc_color="{{desc_color}}" description="{{description}}"][/heading]',
	'popup_title' => __( 'Element Header and Sub Text', 'begood' )
);

/*-----------------------------------------------------------------------------------*/
/*	Project Facts Shortcode
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['project_slider'] = array(
	'no_preview' => true,
	'params' => array(
	

		'cat_id' => array(
			'type' => 'select',
			'label' => __( 'Select the Project Category', 'begood' ),
			'desc' =>  __( 'Choose to Project Category', 'begood' ),
			'options' => $project_category
		),
		
		'num_fetch' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Number Of Posts', 'begood'),
			'desc' => __('Number Of Posts To Display On The Slider', 'begood')
		),
		
		'order' => array(
			'type' => 'select',
			'label' => __( 'Select the layout Type', 'begood' ),
			'desc' => __( 'Select the type of alert message', 'begood' ),
			'options' => array(
				'asc' => 'Ascending Order',
				'desc' => 'Descending Order'
			)
		),
		
	),
	'shortcode'=>'[project_slider cat_id="{{cat_id}}" num_fetch = "{{num_fetch}}" order="{{order}}"][/project_slider]',
	'popup_title' => __( 'Crowd Funding Projects Slider', 'begood' )
);

/*-----------------------------------------------------------------------------------*/
/*	Text
/*-----------------------------------------------------------------------------------*/

$theneeds_shortcodes['text'] = array(
	'no_preview' => true,
	'params' => array(
	
		'align' => array(
			'type' => 'select',
			'label' => __( 'Test Align', 'begood' ),
			'desc' => __( 'left , right , center , justify', 'begood' ),
			'options' => array(
				'left' => 'left',
				'right' => 'right',
				'center' => 'center',
				'justify' => 'justify',
			
			)
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'begood' ),
			'desc' => __( 'Insert the content', 'begood' ),
		),
	),
	'shortcode'=>'[text align="{{align}}"]{{content}}[/text]',
	'popup_title' => __( 'Text Shortcode', 'begood' )
);

/*-----------------------------------------------------------------------------------*/
/*	Title
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['title'] = array(
	'no_preview' => true,
	'params' => array(

		'size' => array(
			'type' => 'select',
			'label' => __( 'Heading Size', 'begood' ),
			'desc' => __( 'Select the Heading', 'begood' ),
			'options' => array(
				'h1' => 'h1',
				'h2' => 'h2',
				'h3' => 'h3',
				'h4' => 'h4',
				'h5' => 'h5',
				'h6' => 'h6',
			)
		),
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'begood' ),
			'desc' => __( 'Insert the content', 'begood' ),
		),
	),
	'shortcode'=>'[title size="{{size}}"]{{content}}[/title]',
	'popup_title' => __( 'Title Shortcode', 'begood' )
);

/*-----------------------------------------------------------------------------------*/
/*	Event Counter Box
/*-----------------------------------------------------------------------------------*/

$theneeds_shortcodes['event_counter_box'] = array(
	'no_preview' => true,
	'params' => array(

		'event_id' => array(
			'type' => 'select',
			'label' => __( 'Event Name', 'begood' ),
			'desc' =>  __( 'Select event name to fetch its id.', 'begood' ),
			'options' => $event_name
		),
		
	),
	'shortcode'=>'[event_counter_box event_id="{{event_id}}"][/event_counter_box]',
	'popup_title' => __( 'Event Counter box Shortcode', 'begood' )
);


/*-----------------------------------------------------------------------------------*/
/*	Newsletter Shortcodes
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['newsletter_section'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __( 'Select layout', 'begood' ),
			'desc' => __( 'select newsletter layout', 'begood' ),
			'options' => array(
				'newsletter-layout1' => 'Newsletter 1',
				'newsletter-layout2' => 'Newsletter 2',
				'newsletter-layout3' => 'Newsletter 3',
				'newsletter-layout4' => 'Newsletter 4',
				'newsletter-layout5' => 'Newsletter 5',
			)
		),
	
		'email' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Email ID', 'begood'),
			'desc' => __('Please write your email address, where you want to recieve email.', 'begood')
		),

	),
	'shortcode'=>'[newsletter_section type="{{type}}" email="{{email}}" ]',
	'popup_title' => __( 'Newsletter  Shortcode', 'begood' )
);

/*-----------------------------------------------------------------------------------*/
/*	Project Facts Shortcode
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['project_facts'] = array(
	'no_preview' => true,
	'params' => array(
	
		'layout' => array(
			'type' => 'select',
			'label' => __( 'Select Style', 'begood' ),
			'desc' => __( 'Select Project Facts Style', 'begood' ),
			'options' => array(
				'normal' => 'Normal Style',
				'islamic' => 'Islamic Style',
			)
		),

		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'begood'),
			'desc' => __('Click an icon to select, click again to deselect', 'begood'),
			'options' => $icons
		),
		
		'count' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title Facts Count', 'begood'),
			'desc' => __('Add the Count', 'begood')
		),
		'text' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title Text', 'begood'),
			'desc' => __('Write The Title Text For Fact', 'begood')
		),
		
	
	),
	'shortcode'=>'[project_facts layout="{{layout}}" icon="{{icon}}" count="{{count}}" text="{{text}}"][/project_facts]',
	'popup_title' => __( 'Project_Facts', 'begood' )
);


/*-----------------------------------------------------------------------------------*/
/*	Checklist
/*-----------------------------------------------------------------------------------*/

$theneeds_shortcodes['checklist'] = array(
	'no_preview' => true,
	'params' => array(

		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select CheckList Icon', 'the_arcade'),
			'desc' => __('Click an icon to select, click again to deselect', 'the_arcade'),
			'options' => $icons
		),
		
		'iconcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Icon Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
	),	
	'shortcode'=>'[checklist icon="{{icon}}" iconcolor="{{iconcolor}}"]&lt;ul&gt;{{child_shortcode}}&lt;/ul&gt;[/checklist]',
	'popup_title' => __( 'Checklist Shortcode', 'the_arcade' ),
	
	'child_shortcode' => array(
		'params' => array(		
			'content' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'Content', 'the_arcade' ),
				'desc' => __( '', 'the_arcade' ),
			),
		),
		'shortcode' => '&lt;li&gt;&lt;a&gt;{{content}}&lt;/a&gt;&lt;/li&gt;',
		'clone_button' => __('Add List Item', 'the_arcade')
	),
);

/*-----------------------------------------------------------------------------------*/
/*	Button
/*-----------------------------------------------------------------------------------*/

$theneeds_shortcodes['buttons'] = array(
	'no_preview' => true,
	'params' => array(

		
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'the_arcade'),
			'desc' => __('Click an icon to select, click again to deselect', 'the_arcade'),
			'options' => $icons
		),
		
		'size' => array(
			'type' => 'select',
			'label' => __( 'Size', 'the_arcade' ),
			'desc' => __( 'Select button size', 'the_arcade' ),
			'options' => array(
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large',
			),
		),
		
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		
		'target' => array(
			'type' => 'select',
			'label' => __( 'target', 'the_arcade' ),
			'desc' => __( '_self, _blank', 'the_arcade' ),
			'options' => array(
				'_self' => '_self',
				'_blank' => '_blank',
			
			),
		),
			
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button URL', 'the_arcade'),
			'desc' => __('Add the button\'s url ex: http://example.com', 'the_arcade')
		),
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Alert Content', 'the_arcade' ),
			'desc' => __( 'Insert the alert\'s content', 'the_arcade' ),
		),
	),
	'shortcode'=>'[button icon="{{icon}}" size="{{size}}" backgroundcolor="{{backgroundcolor}}" color="{{color}}" target="{{target}}" link="{{link}}"]{{content}}[/button]',
	'popup_title' => __( 'Button Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Text
/*-----------------------------------------------------------------------------------*/

$theneeds_shortcodes['text'] = array(
	'no_preview' => true,
	'params' => array(
	
		'align' => array(
			'type' => 'select',
			'label' => __( 'Test Align', 'the_arcade' ),
			'desc' => __( 'left , right , center , justify', 'the_arcade' ),
			'options' => array(
				'left' => 'left',
				'right' => 'right',
				'center' => 'center',
				'justify' => 'justify',
			
			)
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'the_arcade' ),
			'desc' => __( 'Insert the content', 'the_arcade' ),
		),
	),
	'shortcode'=>'[text align="{{align}}"]{{content}}[/text]',
	'popup_title' => __( 'Text Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	IconSet -> skipped
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Event Circle Counter
/*-----------------------------------------------------------------------------------*/
$theneeds_shortcodes['event_circle_counter'] = array(
	'no_preview' => true,
	'params' => array(
	
		'event_id' => array(
			'type' => 'select',
			'label' => __( 'Event Name', 'the_arcade' ),
			'desc' =>  __( 'Select event name to fetch its id.', 'the_arcade' ),
			'options' => $event_name
		),
		
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Color', 'the_arcade'),
			'desc' => 'Selcet Text Color'
		),
		'unfilled_color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Unfilled Color', 'the_arcade'),
			'desc' => 'Select The Unfilled Color In Event Circle'
		),
		
		'filled_color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Filled Color', 'the_arcade'),
			'desc' => 'Select The Filled Color In Event Circle'
		),
		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Width in Number', 'the_arcade'),
			'desc' => __('e.g 500', 'the_arcade')
		),
		'height' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Height in Number', 'the_arcade'),
			'desc' => __('e.g 350', 'the_arcade')
		),
		
		'circle_width_filled' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Circle Width of Filled Event Circle', 'the_arcade'),
			'desc' => __('e.g 1.2 ', 'the_arcade')
		),
		
		'circle_width_unfilled' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Circle Width of UnFilled Event Circle', 'the_arcade'),
			'desc' => __('e.g 0.01 to 0.1 ', 'the_arcade')
		),
		
	
	),
	'shortcode'=>'[event_counter event_id="{{event_id}}" color="{{color}}" unfilled_color="{{unfilled_color}}" filled_color="{{filled_color}}" circle_width_filled="{{circle_width_filled}}" circle_width_unfilled="{{circle_width_unfilled}}" width="{{width}}" height="{{height}}"][/event_counter]',
	'popup_title' => __( 'Event Counter Shortcode', 'the_arcade' )
);


/*-----------------------------------------------------------------------------------*/
/*	Event Counter Box
/*-----------------------------------------------------------------------------------*/

$theneeds_shortcodes['event_counter_box'] = array(
	'no_preview' => true,
	'params' => array(

		'event_id' => array(
			'type' => 'select',
			'label' => __( 'Event Name', 'the_arcade' ),
			'desc' =>  __( 'Select event name to fetch its id.', 'the_arcade' ),
			'options' => $event_name
		),
		
	),
	'shortcode'=>'[event_counter_box event_id="{{event_id}}"][/event_counter_box]',
	'popup_title' => __( 'Event Counter box Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Content Box
/*-----------------------------------------------------------------------------------*/

$theneeds_shortcodes['content_box'] = array(
	'no_preview' => true,
	'params' => array(

		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title', 'the_arcade'),
		),
		
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'the_arcade'),
			'desc' => __('Click an icon to select, click again to deselect', 'the_arcade'),
			'options' => $icons
		),
		
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Color for text', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'the_arcade' ),
			'desc' => __( 'Content Box Content', 'the_arcade' ),
		),
		
		
	),
	'shortcode'=>'[content_box title="{{title}}" icon="{{icon}}" backgroundcolor="{{backgroundcolor}}" color="{{color}}"]{{content}}[/content_box]',
	'popup_title' => __( 'Content Box Shortcode', 'the_arcade' )
);
/*-----------------------------------------------------------------------------------*/
/*	Counters Circle
/*-----------------------------------------------------------------------------------*/

$theneeds_shortcodes['columns'] = array(
	'no_preview' => true,
	'params' => array(
		'col' => array(
			'type' => 'select',
			'label' => __( 'Column', 'the_arcade' ),
			'desc' =>  __( 'Choose column width from dropdown.', 'the_arcade' ),
			'options' => array(
				'1/1' => 'Full Column',
				'1/2' => 'Half Column',
				'1/3' => 'One Third Column',
				'1/4' => 'One Forth Column',
				'2/3' => 'Two Third Column',
				'3/4' => 'Three Forth Column',
			)
		),
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'the_arcade' ),
			'desc' => __( '', 'the_arcade' ),
		),
		
	),
	
	'shortcode'=>'[column col="{{col}}"]{{content}}[/column]',
	'popup_title' => __( 'Counters Circle Shortcode', 'the_arcade' ),
);


/*-----------------------------------------------------------------------------------*/
/*	Counters Circle
/*-----------------------------------------------------------------------------------*/

$theneeds_shortcodes['counters_circle'] = array(
	'no_preview' => true,
	'params' => array(
		/*
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'the_arcade' ),
			'desc' => __( '', 'the_arcade' ),
		),*/
	),
	
	
	'shortcode'=>'[counters_circle]{{child_shortcode}}[/counters_circle]',
	'popup_title' => __( 'Counters Circle Shortcode', 'the_arcade' ),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
		'filledcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Filled Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
			),
		'unfilledcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('UnFilled Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
			),
		'percent' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Percent in Number', 'the_arcade'),
			'desc' => __('0 To 100', 'the_arcade')
			),
			
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'the_arcade' ),
			'desc' => __( '', 'the_arcade' ),
			),
		),

		'shortcode'=>'[counter_circle filledcolor="{{filledcolor}}" unfilledcolor="{{unfilledcolor}}" percent="{{percent}}"]{{content}}[/counter_circle]',
		'clone_button' => __('Add Counter Circle', 'the_arcade')
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Donation
/*-----------------------------------------------------------------------------------*/

$theneeds_shortcodes['theneeds_donation'] = array(
	'no_preview' => true,
	'params' => array(

	),
	'shortcode'=>'[theneeds_donation][/theneeds_donation]',
	'popup_title' => __( 'Alert Shortcode', 'begood' )
);

/*-----------------------------------------------------------------------------------*/
/*	NewsPost Slider Shortcode
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['newspost_slider'] = array(
	'no_preview' => true,
	'params' => array(

		'cat_id' => array(
			'type' => 'select',
			'label' => __( 'Select the Post Category', 'begood' ),
			'desc' =>  __( 'Choose to Project Category', 'begood' ),
			'options' => $category
		),
		
		'num_fetch' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Number Of Posts', 'begood'),
			'desc' => __('Number Of Posts To Display On The Slider', 'begood')
		),
		
		'order' => array(
			'type' => 'select',
			'label' => __( 'Select the layout Type', 'begood' ),
			'desc' => __( 'Select the type of alert message', 'begood' ),
			'options' => array(
				'asc' => 'Ascending Order',
				'desc' => 'Descending Order'
			)
		),
		
	),
	'shortcode'=>'[newspost_slider cat_id="{{cat_id}}" num_fetch = "{{num_fetch}}" order="{{order}}"][/newspost_slider]',
	'popup_title' => __( 'News Post Slider', 'begood' )
);


/*-----------------------------------------------------------------------------------*/
/*	DropCap
/*-----------------------------------------------------------------------------------*/

$theneeds_shortcodes['dropcap'] = array(
	'no_preview' => true,
	'params' => array(

		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Filled Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
			),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'the_arcade' ),
			'desc' => __( 'Word to DropCap', 'the_arcade' ),
		),
	),
	'shortcode'=>'[dropcap color="{{color}}"]{{content}}[/dropcap]',
	'popup_title' => __( 'DropCap Shortcode', 'the_arcade' )
);
	
/*-----------------------------------------------------------------------------------*/
/*	Full Width
/*-----------------------------------------------------------------------------------*/

$theneeds_shortcodes['full_width'] = array(
	'no_preview' => true,
	'params' => array(

		'textalign' => array(
			'type' => 'select',
			'label' => __( 'Test Align', 'the_arcade' ),
			'desc' => __( 'left , right , center , justify', 'the_arcade' ),
			'options' => array(
				'left' => 'left',
				'right' => 'right',
				'center' => 'center',
				'justify' => 'justify',
			
			)
		),
		
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Color of text', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
			
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),

		'backgroundimage' => array(
				'type' => 'uploader',
				'label' => __('Background Image', 'the_arcade'),
				'desc' => __('Upload the Background image', 'the_arcade'),
			),
		
		'backgroundrepeat' => array(
			'type' => 'select',
			'label' => __( 'Background Repeat', 'the_arcade' ),
			'desc' => __( 'no-repeat, repeat', 'the_arcade' ),
			'options' => array(
				'repeat' => 'repeat',
				'no-repeat' => 'no-repeat',
			)
		),
		
		'backgroundposition' => array(
			'type' => 'select',
			'label' => __( 'Background Position', 'the_arcade' ),
			'desc' => __( 'left , right , top , bottom', 'the_arcade' ),
			'options' => array(
				'left' => 'left',
				'right' => 'right',
				'top' => 'top',
				'bottom' => 'bottom',
			
			)
		),
		'backgroundattachment' => array(
			'type' => 'select',
			'label' => __( 'Background Attachment', 'the_arcade' ),
			'desc' => __( 'scroll, fixed', 'the_arcade' ),
			'options' => array(
				'scroll' => 'scroll',
				'fixed' => 'fixed',
			)
		),

		'bordersize' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Size of Border', 'the_arcade'),
			'desc' => __('From 1px to 10px', 'the_arcade')
		),
		
		'bordercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Border Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		
		'paddingtop' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Padding Top in pixels', 'the_arcade'),
			'desc' => __('from 1px to 100px', 'the_arcade')
		),
		
		'paddingbottom' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Padding Bottom in pixels', 'the_arcade'),
			'desc' => __('from 1px to 100px', 'the_arcade')
		),
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'the_arcade' ),
			'desc' => __( 'Insert content', 'the_arcade' ),
		),
	),
	
	'shortcode'=>'[fullwidth textalign="{{textalign}}" color="{{color}}" backgroundcolor="{{backgroundcolor}}" backgroundimage="{{backgroundimage}}" backgroundrepeat="{{backgroundrepeat}}" backgroundposition="{{backgroundposition}}" backgroundattachment="{{backgroundattachment}}" bordersize="{{bordersize}}" bordercolor="{{bordercolor}}" paddingtop="{{paddingtop}}" paddingbottom="{{paddingbottom}}"]{{content}}[/fullwidth]',
	'popup_title' => __( 'Full_width Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Flex Slider
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['flexslider'] = array(
	'no_preview' => true,
	'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => __( 'Select Layout', 'the_arcade' ),
			'desc' => __( 'Select the type of Layout', 'the_arcade' ),
			'options' => array(
				'posts' => 'posts',
				'posts-with-excerpt' => 'posts-with-excerpt',
				'attachments' => 'attachments',
			)
		),
		'excerpt' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Excerpt Length', 'the_arcade'),
			'desc' => __('From 250 to Onwards', 'the_arcade')
		),
		
		'category' => array(
			'type' => 'select',
			'label' => __( 'Category', 'the_arcade' ),
			'desc' => __( 'Select the Category For FlexSlider', 'the_arcade' ),
			'options' => array(
				'cat-1' => 'Category',
				'cat-2' => 'Category',
				'cat-3' => 'Category',
			)
		),
		
		'limit' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Select the Limit', 'the_arcade'),
			'desc' => __('3 to onwards', 'the_arcade')
		),
		
		'id' => array(
			'type' => 'select',
			'label' => __( 'ID', 'the_arcade' ),
			'desc' => __( 'Select the ID', 'the_arcade' ),
			'options' => array(
				'id-1' => 'id',
				'id-2' => 'id',
				'id-3' => 'id',
			)
		),
		
		'lightbox' => array(
			'type' => 'select',
			'label' => __( 'Light Box', 'the_arcade' ),
			'desc' => __( 'Lightbox Yes, or No(only works with attachments layout)', 'the_arcade' ),
			'options' => array(
				'yes' => 'yes',
				'no' => 'no',
			)
		),
		
		
	),
	'shortcode'=>'[flexslider layout="{{layout}}" excerpt="{{excerpt}}" category="{{category}}" limit="{{limit}}" id="{{id}}" lightbox="{{lightbox}}"][/flexslider]',
	'popup_title' => __( 'FlexSlider Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Font Awesome
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['fontawesome'] = array(
	'no_preview' => true,
	'params' => array(
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'the_arcade'),
			'desc' => __('Click an icon to select, click again to deselect', 'the_arcade'),
			'options' => $icons
		),
		
		'circle' => array(
			'type' => 'select',
			'label' => __( 'Circle', 'the_arcade' ),
			'desc' => __( 'Font required in circle', 'the_arcade' ),
			'options' => array(
				'yes' => 'yes',
				'no' => 'no',
			)
		),
		
		'size' => array(
			'type' => 'select',
			'label' => __( 'Select The Size', 'the_arcade' ),
			'desc' => __( 'Select the size of the icon', 'the_arcade' ),
			'options' => array(
				'large' => 'large',
				'medium' => 'medium',
				'small' => 'small'
			)
		),
		'iconcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Select Icon Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		
		'circlecolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Select Circle Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		
		'circlebordercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Select Circle Border Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
	),
	'shortcode'=>'[fontawesome icon="{{icon}}" circle="{{circle}}" size="{{size}}" iconcolor="{{iconcolor}}" circlecolor="{{circlecolor}}" circlebordercolor="{{circlebordercolor}}"]',
	'popup_title' => __( 'FontAwesome Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Google Map
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['google_map'] = array(
	'no_preview' => true,
	'params' => array(
		'latitude' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Latitude of your desired location', 'the_arcade'),
			'desc' => __('Add the Latitude example : eiffel tower latitude  (48.8582)', 'the_arcade')
		),
		
		'longitude' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Longitude of your desired location', 'the_arcade'),
			'desc' => __('Add the Latitude example : eiffel tower longitude (2.2945)', 'the_arcade')
		),
		
		'maptype' => array(
			'type' => 'select',
			'label' => __( 'Select type of the map', 'the_arcade' ),
			'desc' => __( 'Select Type of the map to display', 'the_arcade' ),
			'options' => array(
				'ROADMAP' => 'Roadmap',
				'SATELLITE' => 'Satellite',
				'HYBRID' => 'Hybrid',
				'TERRAIN'=> 'Terrain',
			)
		),
		
		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Width of the map', 'the_arcade'),
			'desc' => __('Width of the map in pixel or percentage e.g 500px, 100% ', 'the_arcade')
		),
		
		'height' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Height of the map', 'the_arcade'),
			'desc' => __('Height of the map in pixel or percentage e.g 500px, 100% ', 'the_arcade')
		),
		'zoom' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Zoom of the map', 'the_arcade'),
			'desc' => __('set zoom level of the map e.g 14 ', 'the_arcade')
		),

	),
	'shortcode'=>'[map latitude="{{latitude}}" longitude="{{longitude}}" maptype="{{maptype}}" width="{{width}}" height="{{height}}" zoom="{{zoom}}"][/map]',
	'popup_title' => __( 'Google_Map Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Highlight
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['highlight'] = array(
	'no_preview' => true,
	'params' => array(
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content to be highlighted', 'the_arcade' ),
			'desc' => __( 'Insert content to highlight', 'the_arcade' ),
		),
	),
	'shortcode'=>'[highlight color="{{color}}"]{{content}}[/highlight]',
	'popup_title' => __( 'Highlight Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Sidebar
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['sidebar'] = array(
	'no_preview' => true,
	'params' => array(
		
		'name' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('select Name', 'the_arcade'),
			'desc' => __('Select the name of the sidebar e.g Footer ', 'the_arcade')
		),
		
	),
	'shortcode'=>'[sidebar name="{{name}}"]',
	'popup_title' => __( 'Sidebar Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Image Frame
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['image_frame'] = array(
	'no_preview' => true,
	'params' => array(
	
		'style' => array(
			'type' => 'select',
			'label' => __( 'Select Style', 'the_arcade' ),
			'desc' => __( 'Select Style of the image frame', 'the_arcade' ),
			'options' => array(
				'border' => 'border',
				'glow' => 'glow',
				'border' => 'border',
				'dropshadow' => 'dropshadow',
				'bottomshadow'=> 'bordershadow'
			)
		),
		
		'bordercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Border Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		'bordersize' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Select Border Size', 'the_arcade'),
			'desc' => __('Select size of the border e.g 1px to 10px ', 'the_arcade')
		),
		'stylecolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Style Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		'align' => array(
			'type' => 'select',
			'label' => __( 'Select Alignment', 'the_arcade' ),
			'desc' => __( 'left , right , top , bottom', 'the_arcade' ),
			'options' => array(
				'left' => 'left',
				'right' => 'right',
				'top' => 'top',
				'bottom' => 'bottom',
			
			)
		),
		'content' => array(
				'type' => 'uploader',
				'label' => __('Select Image', 'the_arcade'),
				'desc' => __('Upload the image', 'the_arcade'),
				'alt' => __('Image Description', 'the_arcade'),
			),	
	),
	'shortcode'=>'[imageframe style="{{style}}" bordercolor="{{bordercolor}}" bordersize="{{bordersize}}" stylecolor="{{stylecolor}}" align="{{align}}"]{{content}}[/imageframe]',
	'popup_title' => __( 'Image_frame Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Images Carousel
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['image_carousel'] = array(
	'no_preview' => true,
	'params' => array(
	
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Enter title name', 'the_arcade'),
			'desc' => __('Please enter title you want', 'the_arcade')
		),
		
		'lightbox' => array(
			'type' => 'select',
			'label' => __( 'Lightbox', 'the_arcade' ),
			'desc' => __( 'Yes or No', 'the_arcade' ),
			'options' => array(
				'yes' => 'yes',
				'no' => 'no',
			
			)
		),
		'gallery_id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Select Gallery Id', 'the_arcade'),
			'desc' => __('Select the id of the gallery ', 'the_arcade')
		),
		
	),
	'shortcode'=>'[images title="{{title}}" lightbox="{{lightbox}}" gallery_id="{{gallery_id}}"][/images]',
	'popup_title' => __( 'Client logos Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Lightbox
/*-----------------------------------------------------------------------------------*/	

$theneeds_shortcodes['lightbox'] = array(
	'no_preview' => true,
	'params' => array(
	
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Select Title', 'the_arcade'),
			'desc' => __('Select the title of the Lightbox ', 'the_arcade')
		),
		
		'href' => array(
			'type' => 'uploader',
			'label' => __('Select Full Image', 'the_arcade'),
			'desc' => __('Upload large image this image will shown in lightbox.', 'the_arcade'),
		),
		
		'src' => array(
			'type' => 'uploader',
			'label' => __('Small Thumbnail', 'the_arcade'),
			'desc' => __('Upload small thumbnail that will appear as small image.', 'the_arcade'),
		),
		
		'margin' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Margin', 'the_arcade'),
			'desc' => __('Give Margin e.g 1px to 25px', 'the_arcade')
		),
		'align' => array(
			'type' => 'select',
			'label' => __( 'Select Alignment', 'the_arcade' ),
			'desc' => __( 'left , right , center, none', 'the_arcade' ),
			'options' => array(
				'left' => 'left',
				'right' => 'right',
				'center' => 'center',
				'none' => 'none',			
			)
		)
	),
	'shortcode'=>'[lightbox title="{{title}}" href="{{href}}" src="{{src}}" margin="{{margin}}" align="{{align}}"][/lightbox]',
	'popup_title' => __( 'Lightbox Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Progress Circle
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['progress_circle'] = array(
	'no_preview' => true,
	'params' => array(

		'value' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Value', 'the_arcade'),
			'desc' => __('Give value from 0 to 100', 'the_arcade')
		),
		
		'filledcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Select Filled Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		'unfilledcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Select UnFilled Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'the_arcade' ),
			'desc' => __( 'Insert the content', 'the_arcade' ),
		),
	),
	'shortcode'=>'[counter_circle value="{{value}}" filledcolor="{{filledcolor}}" unfilledcolor="{{unfilledcolor}}"]{{content}}[/counter_circle]',
	'popup_title' => __( 'Progress Circle Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Progress Bar
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['progress_bar'] = array(
	'no_preview' => true,
	'params' => array(

		'percentage' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Percentage', 'the_arcade'),
			'desc' => __('Give percentage from 0 to 100', 'the_arcade')
		),
	
		'type' => array(
			'type' => 'select',
			'label' => __( 'Select Type', 'the_arcade' ),
			'desc' => __( 'Select the type of Progress Bar', 'the_arcade' ),
			'options' => array(
				'progress-info' => 'progress-info',
				'progress-success' => 'progress-success',
				'progress-warning' => 'progress-warning',
				'progress-danger' => 'progress-danger',
			)
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'the_arcade' ),
			'desc' => __( 'Insert the content', 'the_arcade' ),
		),	
	),
	'shortcode'=>'[progress_bar percentage="{{percentage}}" type="{{type}}"]{{content}}[/progress_bar]',
	'popup_title' => __( 'Progress Bar Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Person
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['person'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __( 'Select Type', 'the_arcade' ),
			'desc' => __( 'Select the type of Person', 'the_arcade' ),
			'options' => array(
				'team-boxed' => 'team-boxed',
				'team-circle' => 'team-circle',
			)
		),
		'name' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Name of the Person', 'the_arcade'),
			'desc' => __('e.g John Doe', 'the_arcade')
		),
		'picture' => array(
				'type' => 'uploader',
				'label' => __('Image of the person', 'the_arcade'),
				'desc' => __('Upload the Person image', 'the_arcade'),
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Designation', 'the_arcade'),
			'desc' => __('e.g Developer', 'the_arcade')
		),
		'facebook' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Facebook URL', 'the_arcade'),
			'desc' => __('Add the facebook address ex: http://facebook.com', 'the_arcade')
		),
		'twitter' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Twitter URL', 'the_arcade'),
			'desc' => __('Add the twitter address ex: http://twitter.com', 'the_arcade')
		),
		'linkedin' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('LinkedIn URL', 'the_arcade'),
			'desc' => __('Add the LinkedIn address ex: http://linkedin.com', 'the_arcade')
		),
		'dribbble' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Dribbble URL', 'the_arcade'),
			'desc' => __('Add the Dribbble address ex: http://dribbble.com', 'the_arcade')
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('URL', 'the_arcade'),
			'desc' => __('Add the url ex: http://example.com', 'the_arcade')
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'the_arcade' ),
			'desc' => __( 'Insert the content', 'the_arcade' ),
		),	

	),
	'shortcode'=>'[person type="{{type}}" name="{{name}}" picture="{{picture}}" title="{{title}}" facebook="{{facebook}}" twitter="{{twitter}}" linkedin="{{linkedin}}" dribbble="{{dribbble}}" link="{{link}}"]{{content}}[/person]',
	'popup_title' => __( 'Person  Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	3D Button
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['3D_button'] = array(
	'no_preview' => true,
	'params' => array(
		
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'the_arcade'),
			'desc' => __('Click an icon to select, click again to deselect', 'the_arcade'),
			'options' => $icons
		),
		'size' => array(
			'type' => 'select',
			'label' => __( 'Size', 'the_arcade' ),
			'desc' => __( 'Select button size', 'the_arcade' ),
			'options' => array(
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large',
			),
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('URL Here', 'the_arcade'),
			'desc' => __('Add the url ex: http://example.com', 'the_arcade')
		),
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		'textcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Text Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		'target' => array(
			'type' => 'select',
			'label' => __( 'Select Target', 'the_arcade' ),
			'desc' => __( '_blank or _self', 'the_arcade' ),
			'options' => array(
				'_blank' => '_blank',
				'_self' => '_self',
				
			)
		),
		'content' => array(
			'std' => 'Your Button Text Goes Here',
			'type' => 'textarea',
			'label' => __( 'Button Text', 'the_arcade' ),
			'desc' => __( 'Insert the Button Text', 'the_arcade' ),
		),	
		
	),
	'shortcode'=>'[3dbutton icon="{{icon}}" size="{{size}}" link="{{link}}" backgroundcolor="{{backgroundcolor}}" target="{{target}}" textcolor="{{textcolor}}"]{{content}}[/3dbutton]',
	'popup_title' => __( '3D Button  Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Metro Button
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['metro_button'] = array(
	'no_preview' => true,
	'params' => array(
	
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'the_arcade'),
			'desc' => __('Click an icon to select, click again to deselect', 'the_arcade'),
			'options' => $icons
		),
		'size' => array(
			'type' => 'select',
			'label' => __( 'Size', 'the_arcade' ),
			'desc' => __( 'Select button size', 'the_arcade' ),
			'options' => array(
				'small' => 'Small',
				'medium' => 'Medium',
				'large' => 'Large',
			),
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('URL Here', 'the_arcade'),
			'desc' => __('Add the url ex: http://example.com', 'the_arcade')
		),
		'target' => array(
			'type' => 'select',
			'label' => __( 'Select Target', 'the_arcade' ),
			'desc' => __( '_blank or _self', 'the_arcade' ),
			'options' => array(
				'_blank' => '_blank',
				'_self' => '_self',
			
			)
		),
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		'textcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Text Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		'content' => array(
			'std' => 'Your Button Text Goes Here',
			'type' => 'textarea',
			'label' => __( 'Button Text', 'the_arcade' ),
			'desc' => __( 'Insert the Button Text', 'the_arcade' ),
		),	
		
	),
	'shortcode'=>'[metro_button icon="{{icon}}" size="{{size}}" link="{{link}}" target="{{target}}" backgroundcolor="{{backgroundcolor}}" textcolor="{{textcolor}}"]{{content}}[/metro_button]',
	'popup_title' => __( 'Metro_Button  Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Membership Button
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['membership_button'] = array(
	'no_preview' => true,
	'params' => array(
	
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'the_arcade'),
			'desc' => __('Click an icon to select, click again to deselect', 'the_arcade'),
			'options' => $icons
		),
	
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('URL Here', 'the_arcade'),
			'desc' => __('Add the url ex: http://example.com', 'the_arcade')
		),
		
		'icon_bg_color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Icon Background Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		'text_bg_color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Text Background Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		
		'border_color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Bottom Border Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
	
		
		'textcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Text Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		'content' => array(
			'std' => 'Your Button Text Goes Here',
			'type' => 'textarea',
			'label' => __( 'Button Text', 'the_arcade' ),
			'desc' => __( 'Insert the Button Text', 'the_arcade' ),
		),	
		
	),
	'shortcode'=>'[membership_button icon="{{icon}}" link="{{link}}" border_color="{{border_color}}" icon_bg_color="{{icon_bg_color}}" text_bg_color="{{text_bg_color}}" textcolor="{{textcolor}}"]{{content}}[/membership_button]',
	'popup_title' => __( 'Membership Button  Shortcode', 'the_arcade' )
);
/*-----------------------------------------------------------------------------------*/
/*	Pricing Table
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['pricing_table'] = array(
	'no_preview' => true,
	'params' => array(

		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		'bordercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Border Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		'dividercolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Divider Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		'columns' => array(
			'type' => 'select_col',
			'label' => __('Number of Columns', 'the_arcade'),
			'desc' => 'Select how many columns to display',
			'options' => array(
				'&lt;br /&gt;[column col=&quot;1/1&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;' => '1 Column',				
				'&lt;br /&gt;[column col=&quot;1/2&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;&lt;br /&gt;[column col=&quot;1/2&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;' => '2 Column',
				'&lt;br /&gt;[column col=&quot;1/3&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;&lt;br /&gt;[column col=&quot;1/3&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;&lt;br /&gt;[column col=&quot;1/3&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;' => '3 Column',
				'&lt;br /&gt;[column col=&quot;1/4&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;&lt;br /&gt;[column col=&quot;1/4&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;&lt;br /&gt;[column col=&quot;1/4&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;&lt;br /&gt;[column col=&quot;1/4&quot;][pricing_header title=&quot;Standard&quot;][pricing_price currency=&quot;$&quot; price=&quot;15.55&quot; time=&quot;monthly&quot;][/pricing_price][/pricing_header]&lt;br /&gt;[pricing_column]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 1[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 2[/pricing_row]&lt;br /&gt;[pricing_row link=&quot;#&quot;]Feature 3[/pricing_row]&lt;br /&gt;[/pricing_column]&lt;br /&gt;[pricing_footer link=&quot;#&quot;]Signup[/pricing_footer][/column]&lt;br /&gt;' => '4 Column',
			)
		)
	),
	'shortcode' => '[pricing_table backgroundcolor="{{backgroundcolor}}" bordercolor="{{bordercolor}}" dividercolor="{{dividercolor}}"]{{columns}}[/pricing_table]',
	'popup_title' => __( 'Pricing Table Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Recent Projects
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['recent_projects'] = array(
	'no_preview' => true,
	'params' => array(

		'layout' => array(
			'type' => 'select',
			'label' => __( 'Alert Type', 'the_arcade' ),
			'desc' => __( 'Select the type of alert message', 'the_arcade' ),
			'options' => array(
				'carousel' => 'carousel',
				'grid-with-filters' => 'grid-with-filters',
				'grid' => 'grid',
			)
		),
		
		'cat_id' => array(
			'type' => 'select',
			'label' => __( 'Select The Category ID', 'the_arcade' ),
			'desc' =>  __( 'Choose the category ID', 'the_arcade' ),
			'options' => $choices
		),
		'number_posts' => array(
			'type' => 'select',
			'label' => __( 'Number of Posts', 'the_arcade' ),
			'desc' => __( 'Select number of posts per page', 'the_arcade' ),
			'options' => theneeds_shortcodes_range( 25, true, true )
		),
		
		'excerpt_words' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Excerpt Words', 'the_arcade'),
			'desc' => __('Select the number of excerpt words', 'the_arcade')
		),
		
	),
	'shortcode'=>'[recent_projects layout="{{layout}}" cat_id="{{cat_id}}" number_posts="{{number_posts}}" excerpt_words="{{excerpt_words}}"][/recent_projects]',
	'popup_title' => __( 'Recent Projects  Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Project Facts Shortcode
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['project_facts'] = array(
	'no_preview' => true,
	'params' => array(

		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'the_arcade'),
			'desc' => __('Click an icon to select, click again to deselect', 'the_arcade'),
			'options' => $icons
		),
		
		'image_url' => array(
				'type' => 'uploader',
				'label' => __('Upload Image', 'the_arcade'),
				'desc' => __('Upload the Icon Image, Leave if Icon Selected Above', 'the_arcade'),
		),
		
		'count' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title Facts Count', 'the_arcade'),
			'desc' => __('Add the Count', 'the_arcade')
		),
		
		'text' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title Text', 'the_arcade'),
			'desc' => __('Write The Title Text For Fact', 'the_arcade')
		),
		
		'border_right' => array(
			'type' => 'select',
			'label' => __( 'Add Right Border', 'begood' ),
			'desc' => __( 'Add or Remove Right Border', 'begood' ),
			'options' => array(
				'add' => 'Add Border',
				'remove' => 'Remove Border',
			)
		),
		
		'border_bottom' => array(
			'type' => 'select',
			'label' => __( 'Add Bottom Border', 'begood' ),
			'desc' => __( 'Add or Remove Bottom Border', 'begood' ),
			'options' => array(
				'add' => 'Add Border',
				'remove' => 'Remove Border',
			)
		),
		
	),
	'shortcode'=>'[project_facts icon="{{icon}}" count="{{count}}" image_url="{{image_url}}" text="{{text}}" border_right="{{border_right}}" border_bottom="{{border_bottom}}"][/project_facts]',
	'popup_title' => __( 'Project_Facts', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Facts 2 Shortcode
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['facts_count'] = array(
	'no_preview' => true,
	'params' => array(

		
		'image_url' => array(
				'type' => 'uploader',
				'label' => __('Upload Image', 'the_arcade'),
				'desc' => __('Upload the Icon Image, Leave if Icon Selected Above', 'the_arcade'),
		),
		
		'count' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title Facts Count', 'the_arcade'),
			'desc' => __('Add the Count', 'the_arcade')
		),
		
		'text' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title Text', 'the_arcade'),
			'desc' => __('Write The Title Text For Fact', 'the_arcade')
		),
			
		
	),
	'shortcode'=>'[facts_count count="{{count}}" image_url="{{image_url}}" text="{{text}}"][/facts_count]',
	'popup_title' => __( 'Facts_count', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Services
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['services'] = array(
	'no_preview' => true,
	'params' => array(
	
		'layout' => array(
			'type' => 'select',
			'label' => __( 'Select the layout Type', 'begood' ),
			'desc' => __( 'Select the type of alert message', 'begood' ),
			'options' => array(
				'circle-icon-top' => 'Circle Icon Top',
				'circle-icon-left' => 'Circle Icon Left',
				'circle-icon-right' => 'Circle Icon Right',
				'box-icon-top' => 'Box Icon Top',
				'box-icon-right' => 'Box Icon Right',
				'icon-right' => 'Icon Right',
				'top-icon-box-outside' => 'Top Icon Box Outside',
				'icon-top-simple' => 'Simple Icon Top',
			)
		),
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', 'begood'),
			'desc' => __('Click an icon to select, click again to deselect', 'begood'),
			'options' => $icons
		),
		
		'service_class' => array(
			'type' => 'select',
			'label' => __( 'Select the Style', 'begood' ),
			'desc' => __( 'Select the Style For Cicle Icon Left Only', 'begood' ),
			'options' => array(
				'service1' => 'Style 1',
				'service2' => 'Style 2',
			)
		),
		
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title Text', 'begood'),
			'desc' => __('Add the title', 'begood')
		),
		'excerpt_words' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Excerpt Words', 'begood'),
			'desc' => __('Select the number of excerpt words', 'begood')
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Link', 'begood'),
			'desc' => __('Add the url ex: http://example.com', 'begood')
		),
		'linktext' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Link Text Words', 'begood'),
			'desc' => __('Read More Text', 'begood')
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'begood' ),
			'desc' => __( 'Insert the content', 'begood' ),
		),
	),
	'shortcode'=>'[services layout="{{layout}}" service_class = "{{service_class}}" icon="{{icon}}" title="{{title}}" excerpt_words="{{excerpt_words}}" link="{{link}}" linktext="{{linktext}}"]{{content}}[/services]',
	'popup_title' => __( 'Services Shortcode', 'begood' )
);


/*-----------------------------------------------------------------------------------*/
/*	Recent Posts
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['recent_posts'] = array(
	'no_preview' => true,
	'params' => array(

		'layout' => array(
			'type' => 'select',
			'label' => __( 'Select Layout', 'the_arcade' ),
			'desc' => __( 'Select the layout option', 'the_arcade' ),
			'options' => array(
				'default' => 'Default',
				'thumbnails-on-side' => 'Thumbnails-on-side',
			)
		),
		'columns' => array(
			'type' => 'select',
			'label' => __( 'Select Column', 'the_arcade' ),
			'desc' => __( 'Select the column option', 'the_arcade' ),
			'options' => array(
				'1-1' => '1-1',
				'1-4' => '1-4',
			)
		),
		
		'number_posts' => array(
			'type' => 'select',
			'label' => __( 'Number of Posts', 'the_arcade' ),
			'desc' => __( 'Select number of posts', 'the_arcade' ),
			'options' => theneeds_shortcodes_range( 25, true, true )
		),
		
		'cat_id' => array(
			'type' => 'select',
			'label' => __( 'Categories', 'the_arcade' ),
			'desc' => __( 'Select a category or leave blank for all', 'the_arcade' ),
			'options' => $category
		),
		
		'thumbnail' => array(
			'type' => 'select',
			'label' => __( 'Thumbnail', 'the_arcade' ),
			'desc' => __( 'Yes or No', 'the_arcade' ),
			'options' => array(
				'yes' => 'Yes',
				'no' => 'No',
			
			)
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title Text', 'the_arcade'),
			'desc' => __('Add Title Here', 'the_arcade')
		),
		'post_meta' => array(
			'type' => 'select',
			'label' => __( 'Post Meta', 'the_arcade' ),
			'desc' => __( 'Yes or No (Author, comments, date etc.)', 'the_arcade' ),
			'options' => array(
				'yes' => 'Yes',
				'no' => 'No',
			
			)
		),
		'excerpt' => array(
			'type' => 'select',
			'label' => __( 'Show Excerpt', 'the_arcade' ),
			'desc' => __( 'Yes or No', 'the_arcade' ),
			'options' => array(
				'yes' => 'Yes',
				'no' => 'No',
			
			)
		),
		'excerpt_words' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Number of Characters', 'the_arcade'),
			'desc' => __('Add number of characters eg. 100 to 400', 'the_arcade')
		),
		
	),
	'shortcode'=>'[recent_posts layout="{{layout}}" columns="{{columns}}" number_posts="{{number_posts}}" cat_id="{{cat_id}}" thumbnail="{{thumbnail}}" title="{{title}}" post_meta="{{post_meta}}" excerpt="{{excerpt}}" excerpt_words="{{excerpt_words}}"][/recent_posts]',
	'popup_title' => __( 'Recent Posts Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	SoundCloud
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['sound-cloud'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __( 'Type of Embed', 'the_arcade' ),
			'desc' => __( 'Select the type of Embed', 'the_arcade' ),
			'options' => array(
				'visual-embed' => 'Visual Embed',
				'classic-embed' => 'Classic Embed',
			)
		),
		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('URL of Sound Cloud', 'the_arcade'),
			'desc' => __('Add the url example: https://api.soundcloud.com/tracks/142314548', 'the_arcade')
		),
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		'auto_play' => array(
			'type' => 'select',
			'label' => __( 'AutoPlay', 'the_arcade' ),
			'desc' => __( 'True or False', 'the_arcade' ),
			'options' => array(
				'true' => 'true',
				'false' => 'false',
			
			)
		),
		'hide_related' => array(
			'type' => 'select',
			'label' => __( 'Hide Related', 'the_arcade' ),
			'desc' => __( 'True or False', 'the_arcade' ),
			'options' => array(
				'true' => 'true',
				'false' => 'false',
			
			)
		),
		'show_artwork_or_visual' => array(
			'type' => 'select',
			'label' => __( 'Show Artwork or Visual', 'the_arcade' ),
			'desc' => __( 'True or False', 'the_arcade' ),
			'options' => array(
				'true' => 'true',
				'false' => 'false',
			
			)
		),
		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Set Width', 'the_arcade'),
			'desc' => __('Set The Width in percent e.g 100%', 'the_arcade')
		),
		
		'height' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Set Height', 'the_arcade'),
			'desc' => __('Set The Height e.g 150px', 'the_arcade')
		),
		
		'iframe' => array(
			'type' => 'select',
			'label' => __( 'Use Iframe', 'the_arcade' ),
			'desc' => __( 'True or False', 'the_arcade' ),
			'options' => array(
				'true' => 'true',
				'false' => 'false',
			
			)
		),

	),
	'shortcode'=>'[soundcloud type="{{type}}" url="{{url}}" color="{{color}}" auto_play="{{auto_play}}" hide_related="{{hide_related}}" show_artwork_or_visual="{{show_artwork_or_visual}}" width="{{width}}" height="{{height}}" iframe="{{iframe}}" /]',
	'popup_title' => __( 'SoundCloud Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Slider
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['slider'] = array(
	'no_preview' => true,
	'params' => array(

		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Set Width', 'the_arcade'),
			'desc' => __('Set The Width in percent e.g 100%', 'the_arcade')
		),
		
		'height' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Set Height', 'the_arcade'),
			'desc' => __('Set The Height e.g 150px', 'the_arcade')
		),

	),
	'shortcode'=>'[slider width="{{width}}" height="{{height}}"]{{child_shortcode}}[/slider]',
	'popup_title' => __( 'Slider Shortcode', 'the_arcade' ),
	'child_shortcode' => array(
		'params' => array(
		
			'slider_type' => array(
				'type' => 'select',
				'label' => __( 'Select Type', 'the_arcade' ),
				'desc' => __( 'Select the type of slider eg. image, video(Selecting Video link options as well as light box will be deactivate)', 'the_arcade' ),
				'options' => array(
					'image' => 'Image',
					'video' => 'Video',
				)
			),
			
			'image_url' => array(
				'type' => 'uploader',
				'label' => __('Upload Image', 'the_arcade'),
				'desc' => __('Upload the slider image', 'the_arcade'),
			),
			
			'image_target' => array(
				'type' => 'select',
				'label' => __( 'Select Target', 'the_arcade' ),
				'desc' => __( '_blank or _self (work only with image!)', 'the_arcade' ),
				'options' => array(
					'_blank' => '_blank',
					'_self' => '_self',
				
				)
			),
			'image_lightbox' => array(
				'type' => 'select',
				'label' => __( 'Select Link Type', 'the_arcade' ),
				'desc' => __( 'Select the type of image to open in lightbox or link to anyother target (work only with image!)', 'the_arcade' ),
				'options' => array(
					'yes' => 'Yes',
					'no' => 'No',
				)
			),
			
			'image_content' => array(
				'type' => 'uploader',
				'label' => __('Upload Image', 'the_arcade'),
				'desc' => __('Upload the slider image', 'the_arcade'),
			),
						
			'video_content' => array(
				'std' => 'Your Shortcode Goes Here',
				'type' => 'textarea',
				'label' => __( 'Add Shortcode Here', 'the_arcade' ),
				'desc' => __( 'Add Video here', 'the_arcade' ),
			),
		),

		'shortcode'=> '[slide type="{{type}}" link="{{image_url}}" target="{{image_target}}" lightbox="{{image_lightbox}}"]{{content}}[/slide]',
		'clone_button' => __('Add Another Slide', 'the_arcade')
	)
		
);

/*-----------------------------------------------------------------------------------*/
/*	Separator
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['separator'] = array(
	'no_preview' => true,
	'params' => array(

		'margin_top_bottom' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Margin From Top and Bottom', 'the_arcade'),
			'desc' => __('Give number from 20px to 50px', 'the_arcade')
		),
		
		'size' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add size of separator', 'the_arcade'),
			'desc' => __('Give number from 1px to 10px', 'the_arcade')
		),
		
		'style' => array(
			'type' => 'select',
			'label' => __( 'Select The Style', 'the_arcade' ),
			'desc' => __( 'Select the style of seperator', 'the_arcade' ),
			'options' => array(
				'none' => 'none',
				'solid' => 'solid',
				'double' => 'double',
				'dashed' => 'dashed',
				'dotted' => 'dotted',
				'ridge' => 'ridge',
			)
		),
		
		'color' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
	),
	'shortcode'=>'[separator margin_top_bottom="{{margin_top_bottom}}" size ="{{size}}" style="{{style}}" color="{{color}}"]',
	'popup_title' => __( 'Separator Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Tabs
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['tabs'] = array(
	'no_preview' => true,
	'params' => array(

	),
	//'shortcode'=>'[tab]<br>[tab_item title="ITEM_TITLE"]ADD_CONTENT_HERE[/tab_item]<br>[tab_item title="ITEM_TITLE"]ADD_CONTENT_HERE[/tab_item]<br>[tab_item title="ITEM_TITLE"]ADD_CONTENT_HERE[/tab_item]<br>[/tab]<br /> <br />',
	'shortcode'=>'[tab]{{child_shortcode}}[/tab]',
	'popup_title' => __( 'Tabs Shortcode', 'the_arcade' ),
	
	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
		
			'title' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Set Title', 'the_arcade'),
				'desc' => __('Item Title', 'the_arcade')
			),
			
			'content' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'Your Item Content Here', 'the_arcade' ),
				'desc' => __( 'Item Content', 'the_arcade' ),
			),
		),

		'shortcode'=> '[tab_item title="{{title}}"]{{content}}[/tab_item]',
		'clone_button' => __('Add Another Tab', 'the_arcade')
	)
);


/*-----------------------------------------------------------------------------------*/
/*	Accordion
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['accordion'] = array(
	'no_preview' => true,
	'params' => array(
		
	),
	
	'shortcode'=> '[accordion]{{child_shortcode}}[/accordion]',
	'popup_title' => __( 'accordion Shortcode', 'the_arcade' ),
	
	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'std' => 'Item 1',
				'type' => 'text',
				'label' => __('Set Title', 'the_arcade'),
				'desc' => __('Item Title', 'the_arcade')
			),
			
			'content' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'Your Item Content Here', 'the_arcade' ),
				'desc' => __( 'Item Content', 'the_arcade' ),
			),
		),
		'shortcode'=>'[acc_item title="{{title}}"]{{content}}[/acc_item]',
		'clone_button' => __('Add Another Accordian Tab', 'the_arcade')
			
	),
	
);


/*-----------------------------------------------------------------------------------*/
/*	Top Scorers ingenio
/*-----------------------------------------------------------------------------------*/	
// $theneeds_shortcodes['top_score'] = array(
	// 'no_preview' => true,
	// 'params' => array(
		
	// ),
	
	// 'shortcode'=> '[top_score]{{child_shortcode}}[/top_score]',
	// 'popup_title' => __( 'Top Scorers Shortcode', 'the_arcade' ),
	
	//child shortcode is clonable & sortable
	// 'child_shortcode' => array(
		// 'params' => array(
			// 'title' => array(
				// 'std' => 'Item 1',
				// 'type' => 'text',
				// 'label' => __('Set Position', 'the_arcade'),
				// 'desc' => __('Item Positon', 'the_arcade')
			// ),
			
			// 'team' => array(
				// 'std' => 'Item 2',
				// 'type' => 'text',
				// 'label' => __('Set Team', 'the_arcade'),
				// 'desc' => __('Add Team', 'the_arcade')
			// ),
			
			// 'played' => array(
				// 'std' => 'Item 3',
				// 'type' => 'text',
				// 'label' => __('Played Matches', 'the_arcade'),
				// 'desc' => __('Number Of Played Matches', 'the_arcade')
			// ),
			
			// 'points' => array(
				// 'std' => 'Item 4',
				// 'type' => 'text',
				// 'label' => __('Player Points ', 'the_arcade'),
				// 'desc' => __('Player Earned Points', 'the_arcade')
			// ),
			
			// 'total' => array(
				// 'std' => 'Item 5',
				// 'type' => 'text',
				// 'label' => __('Player Total ', 'the_arcade'),
				// 'desc' => __('Player Total Points', 'the_arcade')
			// ),
			
			// 'content' => array(
				// 'std' => 'Your Content Goes Here',
				// 'type' => 'textarea',
				// 'label' => __( 'Your Item Content Here', 'the_arcade' ),
				// 'desc' => __( 'Item Content', 'the_arcade' ),
			// ),
		// ),
		// 'shortcode'=>'[acc_item title="{{title}} team="{{team}} played="{{played}} points="{{points}} total="{{total}}"]{{content}}[/acc_item]',
		// 'clone_button' => __('Add Another Accordian Tab', 'the_arcade')
			
	// ),
	
// );

/*-----------------------------------------------------------------------------------*/
/*	Testimonials
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['testimonials'] = array(
	'no_preview' => true,
	'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => __( 'Select Type', 'the_arcade' ),
			'desc' => __( 'Select testimonial type from dropdown.', 'the_arcade' ),
			'options' => array(
				'slider' => 'Testimonial Slider',
				'grid' => 'Testimonial Grid',
			
				)
		),
	),
	//'shortcode'=>'[testimonials]<br />[testimonial name="John Doe" picture="image path" company="My Company" link="" target=""]"Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consec tetur, adipisci velit, sed quia non numquam eius modi tempora incidunt utis labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minimas veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur slores amet untras vel illum qui."[/testimonial]<br />[testimonial name="John Doe" picture="image path" company="My Company" link="" target=""]"Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consec tetur, adipisci velit, sed quia non numquam eius modi tempora incidunt utis labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minimas veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur slores amet untras vel illum qui."[/testimonial]<br />[/testimonials]',
	
	'shortcode'=>'[testimonials type="{{type}}"]{{child_shortcode}}[/testimonials]',
	'popup_title' => __( 'Testimonials Shortcode', 'the_arcade' ),
	
	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'name' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add Name of person', 'the_arcade'),
				'desc' => __('Add Name', 'the_arcade')
			),
			'picture' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add Image Path', 'the_arcade'),
				'desc' => __('Add Image Path  ex: http://example.com', 'the_arcade')
			),
			'company' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add Company Name', 'the_arcade'),
				'desc' => __('Add Company Name Here', 'the_arcade')
			),
			'link' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add Image link', 'the_arcade'),
				'desc' => __('Add Image link here  ex: http://example.com', 'the_arcade')
			),
			
			'target' => array(
				'type' => 'select',
				'label' => __( 'Select Target', 'the_arcade' ),
				'desc' => __( '_blank or _self', 'the_arcade' ),
				'options' => array(
					'_blank' => '_blank',
					'_self' => '_self',
				
				)
			),
			
			'content' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'Content', 'the_arcade' ),
				'desc' => __( 'Insert the content', 'the_arcade' ),
			),
		),

		'shortcode'=> '[testimonial name="{{name}}" picture="{{picture}}" company="{{company}}" link="{{link}}" target="{{target}}"]{{content}}[/testimonial]',
		'clone_button' => __('Add Testimonial', 'the_arcade')
	),
);

/*-----------------------------------------------------------------------------------*/
/*	Testimonial
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['testimonial'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __( 'Select the type', 'the_arcade' ),
			'desc' => __( 'Select the type of alert message', 'the_arcade' ),
			'options' => array(
				'default' => 'default',
				'custom-style' => 'custom-style',
			)
		),
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', 'the_arcade'),
			'desc' => 'Leave blank for default'
		),
		'name' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Add Name of person', 'the_arcade'),
				'desc' => __('Add Name', 'the_arcade')
		),
		'picture' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add Image Path', 'the_arcade'),
			'desc' => __('Add Image Path  ex: http://example.com', 'the_arcade')
		),
		'company' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add Company Name', 'the_arcade'),
			'desc' => __('Add Company Name Here', 'the_arcade')
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add Image link', 'the_arcade'),
			'desc' => __('Add Image link here  ex: http://example.com', 'the_arcade')
		),
		'target' => array(
			'type' => 'select',
			'label' => __( 'Select Target', 'the_arcade' ),
			'desc' => __( '_blank or _self', 'the_arcade' ),
			'options' => array(
				'_blank' => '_blank',
				'_self' => '_self',
			
			)
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'the_arcade' ),
			'desc' => __( 'Insert the content', 'the_arcade' ),
		),
		
	),
	
	'shortcode'=>'[testimonial type="{{type}}" backgroundcolor="{{backgroundcolor}}" name="{{name}}" picture="{{picture}}" company="{{company}}" link="{{link}}" target="{{target}}"]{{content}}[/testimonial]',
	'popup_title' => __( 'Testimonial Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Title
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['title'] = array(
	'no_preview' => true,
	'params' => array(

		'size' => array(
			'type' => 'select',
			'label' => __( 'Heading Size', 'the_arcade' ),
			'desc' => __( 'Select the Heading', 'the_arcade' ),
			'options' => array(
				'h1' => 'h1',
				'h2' => 'h2',
				'h3' => 'h3',
				'h4' => 'h4',
				'h5' => 'h5',
				'h6' => 'h6',
			)
		),
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'the_arcade' ),
			'desc' => __( 'Insert the content', 'the_arcade' ),
		),
	),
	'shortcode'=>'[title size="{{size}}"]{{content}}[/title]',
	'popup_title' => __( 'Title Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	About Product ingenio
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['about'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __( 'Select About Product Type.', 'the_arcade' ),
			'desc' => __( 'Select the Heading', 'the_arcade' ),
			'options' => array(
				'title_above_img' => 'title_above_img',
				'title_below_img' => 'title_below_img',
			)
		),
		
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title Of Product', 'the_arcade'),
			'desc' => __('Text to appear as Product Name', 'the_arcade')
		),
		
		
		'subscript' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Subscript Text', 'the_arcade'),
			'desc' => __('Text to appear as Subscript', 'the_arcade')
		),
		
		'image_url' => array(
				'type' => 'uploader',
				'label' => __('Upload Product Image', 'the_arcade'),
				'desc' => __('Upload the Product Image', 'the_arcade'),
		),

		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'the_arcade' ),
			'desc' => __( 'Insert the content', 'the_arcade' ),
		),
	),
	'shortcode'=>'[about type="{{type}}" title="{{title}}" subscript="{{subscript}}" image_url="{{image_url}}"]{{content}}[/about]',
	'popup_title' => __( 'About Product Shortcode', 'the_arcade' )
);


/*-----------------------------------------------------------------------------------*/
/*	Tooltip
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['tooltip'] = array(
	'no_preview' => true,
	'params' => array(

		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Text for Tooltip', 'the_arcade'),
			'desc' => __('Text to appear as tooltip', 'the_arcade')
		),
		
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', 'the_arcade' ),
			'desc' => __( 'Insert the content', 'the_arcade' ),
		),
	),
	'shortcode'=>'[tooltip title="{{title}}"]{{content}}[/tooltip]',
	'popup_title' => __( 'Tooltip Shortcode', 'the_arcade' )
);


/*-----------------------------------------------------------------------------------*/
/*	Table
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['table'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __('Type', 'the_arcade'),
			'desc' => __('Select the table style', 'the_arcade'),
			'options' => array(
				'1' => 'Style 1',
				'2' => 'Style 2',
			)
		),
		'columns' => array(
			'type' => 'select',
			'label' => __('Number of Columns', 'the_arcade'),
			'desc' => 'Select how many columns to display',
			'options' => array(
				'1' => '1 Column',
				'2' => '2 Columns',
				'3' => '3 Columns',
				'4' => '4 Columns'
			)
		)
	),
	'shortcode' => '',
	'popup_title' => __( 'Table Shortcode', 'the_arcade' )
);
/*-----------------------------------------------------------------------------------*/
/*	Vimeo
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['vimeo'] = array(
	'no_preview' => true,
	'params' => array(

		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add Width Here', 'the_arcade'),
			'desc' => __('Add the Width for your video ex: 600px', 'the_arcade')
		),
		'height' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add height Here', 'the_arcade'),
			'desc' => __('Add the height for your video ex: 350px', 'the_arcade')
		),
		'content' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Video URL', 'the_arcade'),
			'desc' => __('Add the Video url ex: http://vimeo.com/93120068', 'the_arcade')
		),
		
	),
	'shortcode'=>'[vimeo width="{{width}}" height="{{height}}"]{{content}}[/vimeo]',
	'popup_title' => __( 'Vimeo Shortcode', 'the_arcade' )
);


/*-----------------------------------------------------------------------------------*/
/*	Woo Products
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['woo_products'] = array(
	'no_preview' => true,
	'params' => array(

		'cat_id' => array(
			'type' => 'select',
			'label' => __( 'Select the ID', 'the_arcade' ),
			'desc' =>  __( 'Choose to Category ID', 'the_arcade' ),
			'options' => $product_cat
		),
		
		'number_posts' => array(
			'type' => 'select',
			'label' => __( 'Number of posts to show', 'the_arcade' ),
			'desc' => __( 'Select number of posts', 'the_arcade' ),
			'options' => theneeds_shortcodes_range( 25, true, true )
		),
		
		'show_price' => array(
			'type' => 'select',
			'label' => __( 'Show Price', 'the_arcade' ),
			'desc' => __( 'Yes or No', 'the_arcade' ),
			'options' => array(
				'yes' => 'yes',
				'no' => 'no',
			)
		),
		'show_buttons' => array(
			'type' => 'select',
			'label' => __( 'Show Buttons', 'the_arcade' ),
			'desc' => __( 'Yes or No', 'the_arcade' ),
			'options' => array(
				'yes' => 'yes',
				'no' => 'no',
			)
		),
	),
	'shortcode'=>'[products_slider cat_id="{{cat_id}}" number_posts="{{number_posts}}" show_price="{{show_price}}" show_buttons="{{show_buttons}}"]',
	'popup_title' => __( 'Woo_Products Shortcode', 'the_arcade' )
);

/*-----------------------------------------------------------------------------------*/
/*	Youtube
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['youtube'] = array(
	'no_preview' => true,
	'params' => array(

		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add width of the video', 'the_arcade'),
			'desc' => __('Add the width example : 600px', 'the_arcade')
		),
		
		'height' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Add height of the video', 'the_arcade'),
			'desc' => __('Add the height example : 350px', 'the_arcade')
		),
		
		'content' => array(
			'std' => 'Enter URL here',
			'type' => 'text',
			'label' => __( 'Youtube URL', 'the_arcade' ),
			'desc' => __( 'Insert the url', 'the_arcade' ),
		),
	),
	'shortcode'=>'[youtube width="{{width}}" height="{{height}}"]{{content}}[/youtube]',
	'popup_title' => __( 'youtube Shortcode', 'the_arcade' )
);
/*-----------------------------------------------------------------------------------*/
/*	Login Shortcode
/*-----------------------------------------------------------------------------------*/	
$theneeds_shortcodes['login'] = array(
	'no_preview' => true,
	'params' => array(

		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Please enter title', 'the_arcade'),
			'desc' => __('Add the title for example :Login Form', 'the_arcade')
		),
	
	),
	
	'shortcode'=>'[login title="{{title}}"][/login]',
	'popup_title' => __( 'Login Shortcode', 'the_arcade')
);



