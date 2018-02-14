<?php

	/*	
	*	Crunchpress Portfolio Option File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		Crunchpress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) Crunchpress
	*	---------------------------------------------------------------------
	*	This file create and contains the portfolio post_type meta elements
	*	---------------------------------------------------------------------
	*/
	
	/* Frondend Recieve */
	$theneeds_wooproduct_class = array("Full-Image" => array("index"=>"1", "class"=>"sixteen ", "size"=>array(1170,350), "size2"=>array(614,614), "size3"=>array(350,350)));

	/* Print WooCommerce Item */
	function theneeds_print_wooproduct_item($item_xml){
		
		/* Yet To Be Implemented */
	}	

	function theneeds_get_cart() {
		return array_filter( (array) $this->cart_contents );
	}
	
	function theneeds_get_remove_url( $theneeds_cart_item_key ) {
		
		global $woocommerce;
		
		$theneeds_cart_page_id = woocommerce_get_page_id('cart');
			if ($theneeds_cart_page_id)
				return apply_filters( 'woocommerce_get_remove_url', wp_nonce_url( 'cart', add_query_arg( 'remove_item', $theneeds_cart_item_key, get_permalink($theneeds_cart_page_id) ) ) );
	}
	
	function theneeds_normal_grid($product='',$post=''){
		
		/* Yet To Be Implemented */
	}

	function theneeds_normal_grid_loop(){
		
		/* Yet To Be Implemented */
	}
	
	/* Fetch the Grid Selected by User */
	function theneeds_selected_grid($grid_layout='',$product='',$post=''){
		
		/* Yet To Be Implemented */
		
	}
	
	/* print Modern Grid Diagonal */
	function theneeds_modern_grid_diagonal($product='',$post=''){
		
		/* Yet To Be Implemented */
	}
	
	function theneeds_modern_grid_square($product='',$post=''){
		
		/* Yet To Be Implemented */
	}
	
	/* Print Simple WooCommerce Product Grid */
	function theneeds_simple_grid($product='',$post=''){
	
		/* Yet To Be Implemented */
	}