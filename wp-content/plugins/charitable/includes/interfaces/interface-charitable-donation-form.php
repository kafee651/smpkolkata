<?php
/**
 * Donation form interface.
 *
 * This defines a strict interface that donation forms must implement.
 *
 * @version   1.0.0
 * @package   Charitable/Interfaces/Charitable_Donation_Form_Interface
 * @author    Eric Daams
 * @copyright Copyright (c) 2017, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! interface_exists( 'Charitable_Donation_Form_Interface' ) ) :

	/**
	 * Charitable_Donation_Form_Interface interface.
	 *
	 * @since 1.0.0
	 */
	interface Charitable_Donation_Form_Interface {

		/**
		 * Render the donation form.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		public function render();

		/**
		 * Validate the submitted values.
		 *
		 * @since  1.0.0
		 *
		 * @return boolean
		 */
		public function validate_submission();

		/**
		 * Return the donation values.
		 *
		 * @since  1.0.0
		 *
		 * @return array
		 */
		public function get_donation_values();	
	}

endif; // End interface_exists check.