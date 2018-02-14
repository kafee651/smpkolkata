<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new class_shortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<div id="crunchp-popup">
	<div id="crunchp-shortcode-wrap">
		<div id="crunchp-sc-form-wrap">

			<?php			
				$select_shortcode = array(
					
					'1' => array('name' =>'Tabs','slug' => 'tabs','icon' => 'fa fa-list-ul'),
					'2' => array('name' =>'Headings','slug' => 'heading','icon' => 'fa fa-text'),
					'3' => array('name' =>'Columns','slug' => 'columns','icon' => 'fa fa-columns'),
					'4' => array('name' =>'Accordion','slug' => 'accordion','icon' => 'fa fa-align-justify'),
					'5' => array('name' =>'Youtube','slug' => 'youtube','icon' => 'fa fa-youtube'),
					'6' => array('name' =>'Vimeo','slug' => 'vimeo','icon' => 'fa fa-vimeo-square'),
					'7' => array('name' =>'Google Map','slug' => 'google_map','icon' => 'fa fa-map-marker'),
					'8' => array('name' =>'Our Team','slug' => 'person','icon' => 'fa fa-users'),
					'9' => array('name' =>'Testimonials','slug' => 'testimonials','icon' => 'fa fa-quote-left'),
					'10' => array('name' =>'Progress Bar','slug' => 'progress_bar','icon' => 'fa fa-refresh'),
					'11' => array('name' =>'Donation','slug' => 'theneeds_donation','icon' => 'fa fa-money'),
					'12' => array('name' =>'Lightbox','slug' => 'lightbox','icon' => 'fa fa-external-link-square'),
					'13' => array('name' =>'Sound Cloud','slug' => 'sound-cloud','icon' => 'fa fa-cloud'),
					'14' => array('name' =>'Price Table','slug' => 'pricing_table','icon' => 'fa fa-dollar'),
					'15' => array('name' =>'Buttons','slug' => 'buttons','icon' => 'fa fa-square'),
					'16' => array('name' =>'Metro Buttons','slug' => 'metro_button','icon' => 'fa fa-square-o'),
					'17' => array('name' =>'Services','slug' => 'services','icon' => 'fa fa-truck'),
					'18' => array('name' =>'Separator','slug' => 'separator','icon' => 'fa fa-minus'),
					'19' => array('name' =>'Facts','slug' => 'project_facts','icon' => 'fa fa-info-circle'),
					'20' => array('name' =>'Banner Tabs','slug' => 'banner_tabs','icon' => 'fa fa-cloud'),
					'21' => array('name' =>'Parallex Icons','slug' => 'parallex_box_icons','icon' => 'fa fa-cloud'),
					//'22' => array('name' =>'Parallex Church','slug' => 'parallex_box_icons_church','icon' => 'fa fa-cloud'),
					'23' => array('name' =>'Donation Bar','slug' => 'donation_bar','icon' => 'fa fa-cloud'),
					'24' => array('name' =>'Newsletter','slug' => 'newsletter_section','icon' => 'fa fa-envelope'),
					'25' => array('name' =>'Facts','slug' => 'project_facts','icon' => 'fa fa-info-circle'),
					//'26' => array('name' =>'CF Slider','slug' => 'project_slider','icon' => 'fa fa-info-circle'),
					'27' => array('name' =>'Event Counter','slug' => 'event_counter_box','icon' => 'fa fa-calendar'),
					'28' => array('name' =>'Title','slug' => 'title','icon' => 'fa fa-text-width'),
					'29' => array('name' =>'Text','slug' => 'text','icon' => 'fa fa-font'),
					'30' => array('name' =>'Checklist','slug' => 'checklist','icon' => 'fa fa-list-ol'),
					'31' => array('name' =>'Counter Circle','slug' => 'counters_circle','icon' => 'fa fa-circle-o'),
					'32' => array('name' =>'News Post Slider','slug' => 'newspost_slider','icon' => 'fa fa-cloud'),
					'33' => array('name' =>'Facts 2','slug' => 'facts_count','icon' => 'fa fa-info-circle'),
					
	
				);
			?>
			<table id="cp-sc-form-table" class="cp-shortcode-selector bootstrap_admin">
				<tbody>
					<tr class="form-row">
						<td class="field full-width">
							<div class="cp-form-select-field">
								<ul class="element_backend parent_width">
									<?php foreach($select_shortcode as $shortcode_value): ?>
									<?php if($shortcode_value['slug'] == $popup): $selected = 'selected="selected"'; else: $selected = ''; endif; ?>
									<li class="drag_able element_width "><a rel="<?php echo $shortcode_value['slug']; ?>" id="" class="theneeds_shortcode_icon"><span class="inside_fontAw"><i class="<?php echo $shortcode_value['icon']; ?>"></i></span><span class="text-bg"><?php echo $shortcode_value['name']; ?></span></a></li>
									<?php endforeach; ?>
								</ul>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<div id="go-back"><a rel="goback" class="goback-now" onclick="tinyMCE.execCommand('CPPopup');return false;">Back</a></div>
			<form method="post" id="cp-sc-form">

				<table id="cp-sc-form-table">

					<?php echo $shortcode->output; ?>

					<tbody class="cp-sc-form-button">
						<tr class="form-row">
							<td class="field"><a href="#" class="crunchp-insert">Insert Shortcode</a></td>
						</tr>
					</tbody>

				</table>
				<!-- /#cp-sc-form-table -->

			</form>
			<!-- /#crunchp-sc-form -->

		</div>
		<!-- /#crunchp-sc-form-wrap -->

		<div class="clear"></div>

	</div>
	<!-- /#crunchp-shortcode-wrap -->

</div>
<!-- /#crunchp-popup -->

</body>
</html>