<?php 
	/*	

	*	CrunchPress Page Option File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		CrunchPress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) CrunchPress
	*	---------------------------------------------------------------------
	*	This file create and contains the page post_type meta elements
	*	---------------------------------------------------------------------
	*/

	// a type that each element can be ( also set in page-dragging.js )

	
	$div_size = array(		
		
		/* Yet To Be Implemented */
		
	);


	$page_meta_boxes = array(
		
		"Top Content Header" => array( 'type'=>'header', 'name'=>'header_start','inner'=>'','title'=>'Page Options','class'=>'content', 'id'=>'cp-show-content-header'),
		
		"CP Div0 Open" => array( 'type'=>'open', 'name'=>'cp-open','class'=>'row-fluid', 'id'=>'cp-div-0'),
		
			"Header Style" => array(

				'title'=> esc_html__('Header Style', 'theneeds'),

				 'name'=>'page-option-top-header-style',

				 'options'=>array('1'=>'Style 1','2'=>'Style 2'),

				 'type'=>'combobox',
				
				 'default'=> 'Style 1',

				 'hr'=>'none',

				'description' => 'Select page header style from dropdown.'

			),	
			

			
			"Top Slider On" => array(

				'title'=> esc_html__('Main Slider', 'theneeds'),

				'name'=>'page-option-top-slider-on',

				'options'=>array('0'=>'Yes','1'=>'No'),

				'type'=>'combobox',
				
				'default'=> 'No',

				'hr'=>'none',

				'description' => 'Activate Or Deactivate Main Slider On Page. selecting no page title field will appear where you can add page title.'

			),

			
			"Top Slider Type" => array(

				'title'=> esc_html__('Top Slider Type', 'theneeds'),

				'name'=>'page-option-top-slider-types',

				'options'=>array('0'=>'Layer-Slider','1'=>'Owl-Slider'),
				
				'type'=>'combobox',
				
				'default' => 'no-slider',
				
				'class'=>'slider-default-selection-new',

				'hr'=>'none',

				'description' => 'Top slider is the slider under the main navigation menu and above the page template( so it will always be full width ).'

			),

			/* "Footer Style" => array(

				'title'=> esc_html__('Footer Style', 'theneeds'),

				'name'=>'page-option-bottom-footer-style',

				'options'=>array('1'=>'Style 1','2'=>'Style 2','3'=>'Style 3', '4'=>'Style 4' ),

				'type'=>'combobox',
				
				'default'=> esc_html__('Style 1', 'theneeds'),

				'hr'=>'none',

				'description' => esc_html__('Select page footer style from dropdown theme has multiple footer style that will help you to built custom layout.', 'theneeds'),

			), */

		"CP Div0 Close" => array( 'type'=>'close', 'name'=>'cp-close','class'=>'row-fluid', 'id'=>'cp-div-0'),
		
		"CP Div Open" => array( 'type'=>'open', 'name'=>'cp-close','class'=>'row-fluid', 'id'=>'cp-div-1'),
		
			'page_caption_bread'=>array(

						'title'=> 'Page Caption',

						'name'=> 'page-option-item-page-caption-below-bread',

						'type'=> 'inputtext',

						'hr'=> 'none',

						'description'=> "Please Add Page Caption Here, It will appear below the Title."),
		
			/*"Owl Slider Style" => array(

					'title'=> esc_html__('Owl Slider Style', 'theneeds'),

					'name'=>'page-option-owl-slider-style',

					'options'=>array('0'=>'Style 1','1'=>'Style 2','2'=>'Style 3' ),

					'type'=>'combobox',
					
					'class'=>'owl-slider-style',

					'hr'=>'none',

					'description' => 'Select Owl Slider Style From Dropdown'

			),*/
			
		
			"Top Slider Images" => array(

				'title'=> esc_html__('Top Slider Images', 'theneeds'),

				'name'=>'page-option-top-slider-images',

				'options'=>array(),

				'type'=>'combobox_post',
				
				'class'=>'slider-default-new',

				'hr'=>'none',

				'description' => 'Top slider comes top of the page select image slide for default sliders..'

			),
			
			"Top Slider Layer" => array(

					'title'=> esc_html__('Top LayerSlider ID', 'theneeds'),

					'name'=>'page-option-top-slider-layer',

					'options'=>array(),

					'type'=>'combobox',
					
					'class'=>'slider-layer',

					'hr'=>'none',

					'description' => 'Top Slider Layer shortcode for main slider.'

			),
		
		
		"CP Div Open" => array( 'type'=>'open', 'name'=>'cp-close','class'=>'row-fluid', 'id'=>'cp-div-2'),		
			
			
			
				
		
		"CP Div Close" => array( 'type'=>'close','name'=>'cp-close','id'=>'cp-div-2'),
		
		
		
		"Top Slider Type" => array(

				'title'=> esc_html__('Top Slider Type', 'theneeds'),

				'name'=>'page-option-top-slider-types',

				'options'=>array('0'=>'Layer-Slider','1'=>'Owl-Slider'),
				
				'type'=>'combobox',
				
				'default' => 'no-slider',
				
				'class'=>'slider-default-selection-new',

				'hr'=>'none',

				'description' => 'Top slider is the slider under the main navigation menu and above the page template( so it will always be full width ).'

			),
		
		"CP Div Close" => array( 'type'=>'close','name'=>'cp-close','id'=>'cp-div-1'),
		
		
		
		"Top Sidebar Header" => array( 'type'=>'header', 'name'=>'header-open','inner'=>'Yes','title'=>'Page Sidebar','class'=>'cp-div-5', 'id'=>'cp-show-sidebar-header'),
		
		"CP Div5 Open" => array( 'type'=>'open', 'name'=>'cp-open','class'=>'row-fluid full_class', 'id'=>'cp-div-5'),	
		
		"Page Sidebar Template" => array(

			'title'=> esc_html__('SELECT LAYOUT', 'theneeds'), 

			'name'=>'page-option-sidebar-template', 
			
			'id'=>'page-option-sidebar-template', 

			'type'=>'radioimage', 

			'default'=>'no-sidebar',

			'hr'=>'none',

			'options'=>array(

				'1'=>array('value'=>'right-sidebar','image'=>'/framework/images/right-sidebar.png'),

				'2'=>array('value'=>'left-sidebar','image'=>'/framework/images/left-sidebar.png'),

				'3'=>array('value'=>'both-sidebar','image'=>'/framework/images/both-sidebar.png'),
				
				'4'=>array('value'=>'both-sidebar-left','image'=>'/framework/images/both-sidebar-left.png'),
				
				'5'=>array('value'=>'both-sidebar-right','image'=>'/framework/images/both-sidebar-right.png'),

				'6'=>array('value'=>'no-sidebar','image'=>'/framework/images/no-sidebar.png','default'=>'selected')

			)

		),
		
		"CP Div5 Close" => array( 'type'=>'close','name'=>'cp-close','id'=>'cp-div-5'),
		
		"CP Div6 Open" => array( 'type'=>'open', 'name'=>'cp-open','class'=>'row-fluid half_class', 'id'=>'cp-div-6'),	

		"Choose Left Sidebar" => array(

			'title'=> esc_html__('CHOOSE LEFT SIDEBAR', 'theneeds'),

			'name'=>'page-option-choose-left-sidebar',

			'type'=>'combobox',
			
			'class'=> '',

			'hr'=>'none'

		),		

	
		"Choose Right Sidebar" => array(

			'title'=> esc_html__('CHOOSE RIGHT SIDEBAR', 'theneeds'),

			'name'=>'page-option-choose-right-sidebar',
			
			'class'=> '',

			'type'=>'combobox',

		),
		
		"CP Div6 Close" => array( 'type'=>'close','name'=>'cp-close','id'=>'cp-div-6'),
		
		
		"Top Content Close" => array( 'type'=>'close' ,'name'=>'cp-close','id'=>'cp-show-content-options'),
		
		"Page Item" => array(

			'item'=>'page-option-item-type' ,

			'size'=>'page-option-item-size', 

			'xml'=>'page-option-item-xml', 

			'type'=>'page-option-item',

			'name'=>array(
				
				'Content' => array(
					
					'image_icon' =>array(

						'type'=> 'image',

						'hr'=> 'none',
						
						'name'=> '',

						'description'=> "fa fa-file-text"),
				
					"top-bar-div1-open" => array( 'type'=>'open' ,'name'=>'div_start','class'=>'row-fluid','id'=>'cp-top-bar-div1'),
				
					'text'=>array(

						'title'=> 'Content Title / Description',

						'name'=> 'page-option-item-content-text-des',

						'type'=> 'description',

						'hr'=> 'none',

						'description'=> "Please Set your Content Options from bottom Content Title and Content Description."),
						
					'title'=>array(					

						'title'=> 'CONTENT TITLE',

						'name'=> 'cp-show-content-title',

						'type'=> 'combobox',

						'options'=>array('0'=>'Yes','1'=>'No'),
						
						'class'=> '',

						'description'=>'You can Turn On/Off Page Title /Content Title On This Page.'),
					
					'description'=>array(					

						'title'=> 'CONTENT DESCRIPTION',

						'name'=> 'cp-show-content-descrip',

						'type'=> 'combobox',

						'options'=>array('0'=>'Yes','1'=>'No'),
						
						'class'=> '',

						'description'=>'You can Turn On/Off Page Description /Content Description  On Page.'),		
					
					"top-bar-div1-close" => array( 'type'=>'close','name'=>'cp-close','id'=>'cp-top-bar-div1'),	
				),
				
				'Crowd-Funding' => array(

					/* Yet To Be Implemented */
					
				),
				
				
				'Feature-Projects' => array(

					/* Yet To Be Implemented */
					
				),
				

				'Blog'=>array(
				
					/* Yet To Be Implemented */
				
				),
				
				
				'Blog_Slider'=>array(
				
					/* Yet To Be Implemented */
	
				),
				
				
				'Latest-News'=>array(
				
					/* Yet To Be Implemented */
				
				),
				

				'News'=>array(
				
					/* Yet To Be Implemented */

				),				
				
				'Contact-Form'=>array(
				
					/* Yet To Be Implemented */

				),	
			),

		),

	);
	
	
	/* create Page Option Meta */

	add_action('add_meta_boxes', 'add_page_option');

	function add_page_option(){

		add_meta_box('page-option', esc_html__('CP Page Builder','theneeds'), 'add_page_option_element',

			'page', 'normal', 'high');

	}

	function add_page_option_element(){

		global $post, $page_meta_boxes;


		$page_meta_boxes['Choose Left Sidebar']['options'] = get_sidebar_name();

		$page_meta_boxes['Choose Right Sidebar']['options'] = get_sidebar_name();
		
		echo '<div id="cp-overlay-wrapper">';

		echo '<div class="bootstrap_admin" id="cp-overlay-content">';
		
		set_nonce();

		
		//Print Extra Plugins by Extended Classes
		if(count(theneeds_get_extends_name('theneeds_function_library')) <> 0){
			$theneeds_function_library =  new theneeds_function_library;
			foreach(theneeds_class_function_layout() as $keys=>$values){
				$$keys = 'dynamic'.$keys;
				$page_mera_variable = $theneeds_function_library->create_variable($keys, $values);
				$page_mera_variable->page_builder_element_class();
			}
		}

		
		global $post, $page_meta_boxes;
		
		if(!class_exists("Woocommerce")){
		
		}
		
		//ignitionDeck
		if(!class_exists("Deck")){
		
		}
		
		/* function_library */
		if(!class_exists("theneeds_function_library")){
			
			unset($page_meta_boxes['Top Slider On']);
			unset($page_meta_boxes['Top Slider Type']);
			unset($page_meta_boxes['Top Slider Images']);
			unset($page_meta_boxes['Top Slider Layer']);
			unset($page_meta_boxes['Top Slider Shortcode']);
		}
		
		
		/* get value */
		$counter_element = 0;
		
		foreach( $page_meta_boxes as $page_meta_box ){
		
			if( $page_meta_box['type'] == 'page-option-item' ){	

				$page_meta_box['value'] = get_post_meta($post->ID, $page_meta_box['xml'], true);
				
				print_page_default_elements($page_meta_box);
				
				print_page_selected_elements($page_meta_box);

			}

			elseif( $page_meta_box['type'] == 'sidebar' ){ echo 'ok'; die;

				$page_meta_box['value'] = get_post_meta($post->ID, $page_meta_box['xml'], true);
				
				print_page_default_elements($page_meta_box);
				
				print_page_selected_elements($page_meta_box);
				

				echo 'ok';

				

			}else if( $page_meta_box['type'] == 'imagepicker' ){

			

				$slider_xml_string = get_post_meta($post->ID, $page_meta_box['xml'], true);

				if(!empty($slider_xml_string)){

				

					$slider_xml_val = new DOMDocument();

					$slider_xml_val->loadXML( $slider_xml_string );

					$page_meta_box['value'] = $slider_xml_val->documentElement;

					

				}

				theneeds_print_meta( $page_meta_box );

			

			}else{
				

				
				if( empty( $page_meta_box['name'] ) ){ $page_meta_box['name'] = ''; }

				$page_meta_box['value'] = get_post_meta($post->ID, $page_meta_box['name'], true);
				
				theneeds_print_meta( $page_meta_box );   
				
				

			}
			


		}		

		
		
		echo '</div>';
		
		echo '</div>';

		

	}

	

	/* call when update page with save_post action  */

	function save_page_option_meta($post_id){
		
		
		if(count(theneeds_get_extends_name('theneeds_function_library')) <> 0){
			$theneeds_function_library =  new theneeds_function_library;
			foreach(theneeds_class_function_layout() as $keys=>$values){
				
				$$keys = 'dynamic'.$keys;
				$myvariable = $theneeds_function_library->create_variable($keys, $values);
				$myvariable->page_builder_element_class();
			}
		}
		
		global $page_meta_boxes;

		$edit_meta_boxes = $page_meta_boxes;
		
		foreach ($edit_meta_boxes as $edit_meta_box){
			
			if( $edit_meta_box['type'] == 'page-option-item' ){

				if(isset($_POST[$edit_meta_box['size']])){

					$num = sizeof($_POST[$edit_meta_box['size']]);

				}else{

					$num = 0;

				}

				

				$item_xml = '<item-tag>';

				$item_content_num = array();

				for($i=0; $i<$num; $i++){

				

					$item_type_new = $_POST[$edit_meta_box['item']][$i];

					
					$item_xml = $item_xml . '<' . $item_type_new . '>';

					$item_size_new = $_POST[$edit_meta_box['size']][$i];

					$item_xml = $item_xml . theneeds_create_xml_tag('size',$item_size_new);

					$item_content = $edit_meta_box['name'][$item_type_new];

					if(!isset($item_content_num[$item_type_new])){

						$item_content_num[$item_type_new] = 1 ;

						if($item_type_new == 'Slider'){

							$item_content_num['slider-item'] = 0;

						}else if($item_type_new == 'Accordion'){

							$item_content_num['accordion-item'] = 0;

						}else if($item_type_new == 'Tab'){

							$item_content_num['tab-item'] = 0;

						}else if($item_type_new == 'Toggle-Box'){

							$item_content_num['toggle-box-item'] = 0;

						}

					}

					

					foreach($item_content as $key => $value){					

						if($key == 'slider-item'){

					

							$item_xml = $item_xml . '<' . $key . '>';

							$slider_num = $_POST[$value['slider-num']][$item_content_num[$item_type_new]];

							for($j=0; $j<$slider_num; $j++){

								$item_xml = $item_xml . '<slider>';

								$temp = isset( $_POST[$value['image']][$item_content_num['slider-item']] )? $_POST[$value['image']][$item_content_num['slider-item']] : '';

								$item_xml = $item_xml . theneeds_create_xml_tag('image', $temp);

								$temp = isset( $_POST[$value['title']][$item_content_num['slider-item']] )? htmlspecialchars($_POST[$value['title']][$item_content_num['slider-item']]) : '';

								$item_xml = $item_xml . theneeds_create_xml_tag('title', $temp);

								$temp = isset( $_POST[$value['linktype']][$item_content_num['slider-item']] )? $_POST[$value['linktype']][$item_content_num['slider-item']] : '';

								$item_xml = $item_xml . theneeds_create_xml_tag('linktype', $temp);

								$temp = isset( $_POST[$value['link']][$item_content_num['slider-item']] )? htmlspecialchars($_POST[$value['link']][$item_content_num['slider-item']]) : '';

								$item_xml = $item_xml . theneeds_create_xml_tag('link', $temp);

								$temp = isset( $_POST[$value['caption']][$item_content_num['slider-item']] )? htmlspecialchars($_POST[$value['caption']][$item_content_num['slider-item']]) : '';

								$item_xml = $item_xml . theneeds_create_xml_tag('caption', $temp);

								$item_xml = $item_xml . '</slider>';

								$item_content_num['slider-item']++; 

								

							}

							

							$item_xml = $item_xml . '</' . $key . '>';

						}else if($key == "tab-item"){

							$item_xml = $item_xml . '<' . $key . '>';

							if($item_type_new == "Accordion"){

								$tab_type = 'accordion-item';

							}else if($item_type_new == "Toggle-Box"){

								$tab_type = 'toggle-box-item';

							}else{

								$tab_type = 'tab-item';

							}



							$tab_num = $_POST[$value['tab-num']][$item_content_num[$item_type_new]];

							

							for($j=0; $j<$tab_num; $j++){

								$item_xml = $item_xml . '<tab>';

								$temp = isset( $_POST[$value['title']][$item_content_num[$tab_type]] )? htmlspecialchars($_POST[$value['title']][$item_content_num[$tab_type]]) : '';

								$item_xml = $item_xml . theneeds_create_xml_tag('title', $temp);

								$temp = isset( $_POST[$value['caption']][$item_content_num[$tab_type]] )? htmlspecialchars($_POST[$value['caption']][$item_content_num[$tab_type]]) : '';

								$item_xml = $item_xml . theneeds_create_xml_tag('caption', $temp);

								$temp = isset( $_POST[$value['active']][$item_content_num[$tab_type]] )? $_POST[$value['active']][$item_content_num[$tab_type]] : '';

								$item_xml = $item_xml . theneeds_create_xml_tag('active', $temp);

								$item_xml = $item_xml . '</tab>';

								$item_content_num[$tab_type]++;

							}

							

							$item_xml = $item_xml . '</' . $key . '>';

							

						}else{

						

							if(isset($_POST[$value['name']][$item_content_num[$item_type_new]])){

							
							
								$item_value = htmlspecialchars($_POST[$value['name']][$item_content_num[$item_type_new]]);

								$item_xml = $item_xml .  theneeds_create_xml_tag($key, $item_value);

							}else{

								$item_xml = $item_xml .  theneeds_create_xml_tag($key, '');

							}

						}

					}

					

					$item_xml = $item_xml . '</' . $item_type_new . '>';

					$item_content_num[$item_type_new]++;

					

				}

				

				$item_xml = $item_xml . '</item-tag>';

				$item_xml_old = get_post_meta($post_id, $edit_meta_box['xml'], true);

				theneeds_save_meta_data($post_id, $item_xml, $item_xml_old, $edit_meta_box['xml']);

				

			}else if( $edit_meta_box['type'] == 'imagepicker' ){

				if(isset($_POST[$edit_meta_box['name']['image']])){

					$num = sizeof($_POST[$edit_meta_box['name']['image']]) - 1;

				}else{

					$num = -1;

				}

				

				$slider_xml_old = get_post_meta($post_id,$edit_meta_box['xml'],true);

				$slider_xml = "<slider-item>";

				

				for($i=0; $i<=$num; $i++){

					$slider_xml = $slider_xml. "<slider>";

					$image_new = stripslashes($_POST[$edit_meta_box['name']['image']][$i]);

					$slider_xml = $slider_xml. theneeds_create_xml_tag('image',$image_new);

					$title_new = stripslashes(htmlspecialchars($_POST[$edit_meta_box['name']['title']][$i]));

					$slider_xml = $slider_xml. theneeds_create_xml_tag('title',$title_new);

					$caption_new = stripslashes(htmlspecialchars($_POST[$edit_meta_box['name']['caption']][$i]));

					$slider_xml = $slider_xml. theneeds_create_xml_tag('caption',$caption_new);

					$linktype_new = stripslashes($_POST[$edit_meta_box['name']['linktype']][$i]);

					$slider_xml = $slider_xml. theneeds_create_xml_tag('linktype',$linktype_new);

					$link_new = stripslashes(htmlspecialchars($_POST[$edit_meta_box['name']['link']][$i]));

					$slider_xml = $slider_xml. theneeds_create_xml_tag('link',$link_new);

					$slider_xml = $slider_xml . "</slider>";

				}

				

				$slider_xml = $slider_xml . "</slider-item>";

				theneeds_save_meta_data($post_id, $slider_xml, $slider_xml_old, $edit_meta_box['xml']);

					

			}else if($edit_meta_box['type'] == 'open' || $edit_meta_box['type'] == 'close'){

			

			}else{
				
				
				if(isset($_POST[$edit_meta_box['name']])){

					$new_data = stripslashes($_POST[$edit_meta_box['name']]);

				}else{

					$new_data = '';

				}

				$old_data = get_post_meta($post_id, $edit_meta_box['name'],true);
				
				theneeds_save_meta_data($post_id, $new_data, $old_data, $edit_meta_box['name']); 				

			}
			

		}

	}
	
	

	/* print all elements that can be added to selected elements */

	function print_page_default_elements($args){ extract($args); ?>
	
		<div id="cp-options-common-class">
			<div id="page_builder" class="meta-body custom_page container-fluid">
				<!-- Select Item List -->
				<div class="meta-input bootstrap_admin">
					<div class="page-select-element-list-wrapper combobox box-one container">
						<ul class="element_backend parent_width">
								<?php foreach( $name as $key => $value ){ ?>
									<li class="drag_able element_width "><a class="dragable" id="" rel="<?php echo esc_attr($key);?>"><span class="inside_fontAw"><i class="<?php echo esc_attr($value['image_icon']['description']);?>"></i></span><span class="text-bg"><?php echo esc_attr($key);?></span></a></li>
						  <?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<!-- Default Item to Clone to-->
			<div class="page-element-lists" id="page-element-lists">
				<?php
					foreach( $name as $key => $value ){
						print_page_elements($args, '', $key);					
					}
				?>
			  <br class="clear">
			</div>
		</div>	
		<?php
	}

	

	/* chosen elements */
	function print_page_selected_elements($args){ extract($args);?>
	<?php
	}	    


	/* function that manage to print each elements from receiving arguments */

	function print_page_elements($args, $xml_val, $item_type){

		$element1_2 = '';

		extract($args);

		
		
		$head_type = $item_type;

		if(empty($xml_val)){

			$head_size = '';

			$head_name = array('item'=>$item,'size'=>$size,'itemname'=>'','sizename'=>'');

		}else{

			$head_size = theneeds_find_xml_value($xml_val, 'size');

			$head_name = array('item'=>$item,'size'=>$size,'itemname'=>$item.'[]','sizename'=>$size.'[]');

		}

		

		print_page_item_identical($head_name, $head_size, $head_type); ?>

		
		<div class="page-element-edit-box" id="page-element-edit-box">
		<?php

				foreach( $name[$item_type] as $input_key => $input_value ){

					if( $input_key == 'slider-item' ){

						$slider_value = theneeds_find_xml_node($xml_val, 'slider-item');

						theneeds_print_image_picker( array('name'=>$input_value, 'value'=>$slider_value ) );

					  }else if( $input_key == 'tab-item' ){

							   print_box_tab($input_value, theneeds_find_xml_node($xml_val, 'tab-item'));

				      }else if( $input_key == 'haji-item' ){

							   print_panel_sidebar('lol',$input_value);

				      }else{

					    $input_value['value'] = theneeds_find_xml_value($xml_val, $input_key);

						$input_value['name'] = $input_value['name'] . '[]';

						theneeds_print_meta( $input_value );

					}

					if( ( $input_key!= 'open' && $input_key != 'close') ){

						

					}

				}

			?>
		</div>
	<?php
	}

	
	function print_page_item_identical($item, $size, $text){
		global $div_size;
		/* Adding New Sizes */
		if(count(theneeds_get_extends_name('theneeds_function_library')) <> 0){
			$theneeds_function_library =  new theneeds_function_library;
			foreach(theneeds_class_function_layout() as $keys=>$values){
				$$keys = 'dynamic'.$keys;
				$size_variable = $theneeds_function_library->create_variable($keys, $values);
				$size_variable->page_builder_size_class();
			}
		}	
		global $div_size;
		
		if(empty( $size )) { 

			foreach( $div_size[$text] as $key => $val ){

				$size = $key; 

				break;

			}

		} ?>
		
		<div class="page-element <?php echo esc_attr($size); ?>" id="page-element" rel="<?php echo esc_attr($text); ?>">
			<div class="page-element-item" id="page-element-item" >
				<div class="item-bar-left">
				  <div class="change-element-size-temp">
					<div class="add-element-size" id="add-element-size" ></div>
					<div class="sub-element-size" id="sub-element-size" ></div>
				  </div>
				</div>
				<span class="page-element-item-text"> <?php echo esc_attr($text); ?> </span>
				<input type="hidden" id="<?php echo esc_attr($item['item']);?>" class="<?php echo esc_attr($item['item']);?>" value="<?php echo esc_attr($text); ?>" name="<?php echo esc_attr($item['itemname']);?>">
				<input type="hidden" id="<?php echo esc_attr($item['size']);?>" class="<?php echo esc_attr($item['size']);?>" value="<?php echo esc_attr($size); ?>" name="<?php echo esc_attr($item['sizename']);?>">
				<div class="item-bar-right">
				  <div class="element-size-text" id="element-size-text"><?php echo esc_attr($div_size[$text][$size]); ?></div>
					<div class="change-element-property"> 
						<a title="Edit">
							<div rel="cp-edit-box" id="page-element-edit-box" class="edit-element"></div>
						</a> 
						<a title="Delete">
							<div class="delete-element" id="delete-element"></div>
						</a> 
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	

	/* Print exceptional input element ( from meta-template ) */

	function print_box_tab($name, $values){ ?>

		<div class="meta-body">
			<div class="meta-title meta-tab"><?php esc_html_e('ADD MORE TABS','theneeds');?></div>
			<div id="page-tab-add-more" class="page-tab-add-more" />
		</div>
		<br class="clear">
		<div class="meta-input">
			<input type='hidden' class="tab-num" id="tab-num" name='<?php echo esc_attr($name['tab-num']); ?>[]' value=<?php 
					echo empty($values)? 0: $values->childNodes->length;
			?> />
		<div class="added-tab" id="added-tab">
		  <ul>
			<li id="page-item-tab" class="default">
			  <div class="meta-title meta-tab-title"><?php esc_html_e('TABS TITLE','theneeds');?></div>
			  <input type="text"  id='<?php echo esc_attr($name['title']); ?>' />
			  <br>
			  <div class="meta-title meta-tab-title"><?php esc_html_e('TABS TEXT','theneeds');?></div>
			  <textarea id='<?php echo esc_attr($name['caption']); ?>' ></textarea>
			  <br>
			  <?php if(!empty($name['active'])){ ?>
			  <div class="meta-title meta-tab-title"><?php esc_html_e('Tabs Active','theneeds');?></div>
			  <div class="combobox">
				<select id='<?php echo esc_attr($name['active']); ?>' >
				  <option><?php esc_html_e('Yes','theneeds');?></option>
				  <option selected><?php esc_html_e('No','theneeds');?></option>
				</select>
			  </div>
			  <?php } ?>
			  <div id="unpick-tab" class="unpick-tab"><i class="fa fa-remove-sign"></i></div>
			</li>
			<?php
				if(!empty($values)){
					foreach ($values->childNodes as $tab){ ?>
					<li id="page-item-tab" class="page-item-tab">
					  <div class="meta-title meta-tab-title"><?php esc_html_e('TABS TITLE','theneeds');?></div>
					  <input type="text" name='<?php echo esc_attr($name['title']); ?>[]' id='<?php echo esc_attr($name['title']); ?>' value="<?php echo theneeds_find_xml_value($tab, 'title'); ?>" />
					  <br>
					  <div class="meta-title meta-tab-title"><?php esc_html_e('TABS TEXT','theneeds');?></div>
					  <textarea name='<?php echo esc_attr($name['caption']); ?>[]' id='<?php echo esc_attr($name['caption']); ?>' ><?php echo theneeds_find_xml_value($tab, 'caption'); ?></textarea>
					  <br>
					  <div id="unpick-tab" class="unpick-tab"><i class="fa fa-remove-sign"></i></div>
					  <?php if(!empty($name['active'])){ ?>
					  <?php $is_active = theneeds_find_xml_value($tab, 'active'); ?>
					  <div class="meta-title meta-tab-title"><?php esc_html_e('Tabs Active','theneeds');?></div>
					  <div class="combobox">
						<select id='<?php echo esc_attr($name['active']); ?>' name='<?php echo esc_attr($name['active']); ?>[]' >
						  <option <?php if($is_active=='Yes'){ echo 'selected'; } ?>><?php esc_html_e('Yes','theneeds');?></option>
						  <option <?php if($is_active!='Yes'){ echo 'selected'; } ?>><?php esc_html_e('No','theneeds');?></option>
						</select>
					  </div>
					  <?php } ?>
					</li>
					<?php
					}
				} ?>				
		  </ul>
			<br class="clear">
		</div>
		</div>
		<br class="clear">
	</div>
	<?php 
	}

	function print_panel_sidebar($title, $values){ extract($values); ?>

		
	<div class="panel-body" id="panel-body">
		<div class="panel-body-gimmick"></div>
			<div class="panel-title">
				<label>
				  <?php echo esc_attr($title); ?>
				</label>
			</div>
			<div class="panel-input">
				<input type="text" id="add-more-sidebar" value="type title here" rel="type title here">
				<div id="add-more-sidebar" class="add-more-sidebar"></div>
			</div>
			<?php if(isset($description)){ ?>
				  <div class="panel-description">
					<?php echo esc_attr($description); ?>
				  </div>
			<?php } ?>
			<br class="clear">
			<div id="selected-sidebar" class="selected-sidebar">
				<div class="default-sidebar-item" id="sidebar-item">
				  <div class="panel-delete-sidebar"></div>
				  <div class="slider-item-text"></div>
				  <input type="hidden" id="<?php echo esc_attr($name); ?>">
				</div>
				<?php 
				if(!empty($value)){
				
					$xml = new DOMDocument();

					$xml->loadXML($value);

					foreach( $xml->documentElement->childNodes as $sidebar_name ){  ?>	

						<div class="sidebar-item" id="sidebar-item">
						  <div class="panel-delete-sidebar"></div>
						  <div class="slider-item-text"><?php echo esc_attr($sidebar_name->nodeValue); ?></div>
						  <input type="hidden" name="<?php echo esc_attr($name); ?>[]" id="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($sidebar_name->nodeValue); ?>">
						</div>
						<?php 
					} 
				} ?>	
			</div>
	</div>
<?php 
	}
