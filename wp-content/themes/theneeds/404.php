<?php
/*
 * This file will generate 404 error page.
 */	
	get_header(); 


	/* Get Theme Options for Page Layout */
	$theneeds_select_layout_cp = '';
	$theneeds_general_settings = get_option('general_settings');
	if($theneeds_general_settings <> ''){
		$theneeds_logo = new DOMDocument ();
		$theneeds_logo->loadXML ( $theneeds_general_settings );
		$theneeds_select_layout_cp = theneeds_find_xml_value($theneeds_logo->documentElement,'select_layout_cp');
		$theneeds_breadcrumbs = theneeds_get_themeoption_value('breadcrumbs','general_settings');
	}
?>

	<div id="inner-banner">
		<div class="container">
		   <h1><?php esc_html_e('404 Error','theneeds');?></h1>
		  <em><?php esc_html_e('The Page You Are Looking For Does not Exists, Please Try Again','theneeds');?></em>
			<?php /* Breadcrumb Only */
			$theneeds_breadcrumbs = '';
			$theneeds_breadcrumbs = theneeds_get_themeoption_value('breadcrumbs','general_settings');
			
			if($theneeds_breadcrumbs == 'enable'){?>

				<?php echo theneeds_breadcrumbs(); 

			} /* breadcrumbs ends */ 
			?>
		</div>
	</div>
	
	<section class="error-section">
      <div class="container">
        <div class="inner">
          <h1><?php esc_html_e('404','theneeds');?></h1>
          <span><?php esc_html_e('oops!','theneeds');?></span> <strong class="title"><?php esc_html_e('Page Not Found!','theneeds');?></strong>
          <h3><?php esc_html_e('The Requested Page Cannt be Found','theneeds');?></h3>
			<form method="get" action="<?php  echo esc_url(home_url('/')); ?>">
				<input type="text" placeholder="<?php esc_html_e('Enter your words for search again','theneeds');?>" value="<?php the_search_query(); ?>" name="s"  autocomplete="off" />
				<button type="submit" value="Search"><i class="fa fa-search"></i></button>
			</form>
        </div>
      </div>
    </section>
	
	
<?php get_footer();?>