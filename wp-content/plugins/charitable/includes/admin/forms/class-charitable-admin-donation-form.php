<?php
/**
 * Admin donation form model class.
 *
 * @package   Charitable/Classes/Charitable_Admin_Donation_Form
 * @author    Eric Daams
 * @copyright Copyright (c) 2017, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.5.0
 * @version   1.5.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'Charitable_Admin_Donation_Form' ) ) :

	/**
	 * Charitable_Admin_Donation_Form
	 *
	 * @since 1.5.0
	 */
	class Charitable_Admin_Donation_Form extends Charitable_Admin_Form {

		/**
		 * Current Charitable_Donation object, or false if it's a new donation.
		 *
		 * @since 1.5.0
		 *
		 * @var   Charitable_Donation|false
		 */
		protected $donation;

		/**
		 * Form action.
		 *
		 * @since 1.5.0
		 *
		 * @var   string
		 */
		protected $form_action;

		/**
		 * Create a donation form object.
		 *
		 * @since 1.5.0
		 *
		 * @param Charitable_Donation|false $donation For existing donations, the `Charitable_Donation` instance.
		 *                                            False for new donations.
		 */
		public function __construct( $donation ) {
			$this->id          = uniqid();
			$this->donation    = $donation;
			$this->form_action = $this->has_donation() ? 'update_donation' : 'add_donation';
		}

		/**
		 * Return the current Charitable_Donation instance, or false if this is a new donation.
		 *
		 * @since  1.5.0
		 *
		 * @return Charitable_Donation|false
		 */
		public function get_donation() {
			return $this->donation;
		}

		/**
		 * Whether there is a current active donation we are editing.
		 *
		 * @since  1.5.0
		 *
		 * @return boolean
		 */
		public function has_donation() {
			return $this->donation && 'auto-draft' != $this->donation->get_status();
		}

		/**
		 * Return the donation form fields.
		 *
		 * @since  1.5.0
		 *
		 * @return array[]
		 */
		public function get_fields() {
			$fields = array(
				'donation_fields' => array(
					'type'     => 'fieldset',
					'fields'   => $this->get_donation_fields(),
					'priority' => 21,
					'tabindex' => 1,
				),
				'donor_header' => array(
					'type'     => 'heading',
					'level'    => 'h3',
					'title'    => __( 'Donor', 'charitable' ),
					'priority' => 40,					
				),				
				'user_fields' => array(
					'type'     => 'fieldset',
					'fields'   => $this->get_section_fields( 'user' ),
					'priority' => 50,
					'tabindex' => 100,
				),
				'meta_fields' => array(
					'type'     => 'fieldset',
					'fields'   => $this->get_section_fields( 'meta' ),
					'priority' => 60,
					'tabindex' => 200,
				),
			);

			if ( $this->has_donation() ) {
				if ( 'manual' != $this->get_donation()->get_gateway() ) {
					$fields['meta_fields']['fields']['date']['type'] = 'hidden';
				}

				$fields['meta_fields']['fields']['time'] = array(
					'type'     => 'hidden',
					'priority' => 2,
					'value'    => date( 'H:i:s', strtotime( $this->get_donation()->post_date_gmt ) ),
				);
			} else {
				$fields['donor_id'] = array(
					'type'     => 'select',
					'options'  => $this->get_all_donors(),
					'priority' => 41,
					'value'    => '',
				);

				$fields['user_fields']['attrs'] = array(
					'data-trigger-key'   => '#donor-id',
					'data-trigger-value' => 'new',
				);
			}

			/**
			 * Filter the admin donation form fields.
			 *
			 * Note that the recommended way to add fields to the form is
			 * with the Donation Fields API. This filter provides the ability
			 * to re-organize the sections within the form and change fields
			 * in the form that do not come from the Donation Fields API
			 * (headers, campaign/amount field, resend receipt).
			 *
			 * @since 1.5.0
			 *
			 * @var   array                          $fields Array of fields.
			 * @var   Charitable_Admin_Donation_Form $form   This instance of `Charitable_Admin_Donation_Form`.
			 */
			$fields = apply_filters( 'charitable_admin_donation_form_fields', $fields, $this );

			uasort( $fields, 'charitable_priority_sort' );

			return $fields;
		}

		/**
		 * Get donation fields.
		 *
		 * @since  1.5.0
		 *
		 * @return array
		 */
		public function get_donation_fields() {			
			if ( ! $this->donation ) {
				$value = array();
			} else {
				$value = (array) $this->donation->get_campaign_donations();
			}

			return array(
				'campaign_donations' => array(
					'type'  => 'campaign-donations',
					'value' => $value,
				),
			);
		}

		/**
		 * Return all the fields in a particular section.
		 *
		 * @since  1.5.0
		 *
		 * @param  string $section The section we're fetching fields for.
		 * @return array
		 */
		public function get_section_fields( $section ) {
			$fields = charitable()->donation_fields()->get_admin_form_fields( $section );			
			$keys   = array_keys( $fields );
			$fields = array_combine(
				$keys,
				array_map( array( $this, 'maybe_set_field_value' ), wp_list_pluck( $fields, 'admin_form' ), $keys )
			);

			if ( 'meta' == $section ) {
				$fields['log_note'] = array(
					'label'    => __( 'Donation Note', 'charitable' ),
					'type'     => 'textarea',
					'priority' => 12,
					'required' => false,
				);

				if ( ! $this->has_donation() ) {
					$fields['send_donation_receipt'] = array(
						'type'     => 'checkbox',
						'label'    => __( 'Send an email receipt to the donor.', 'charitable' ),
						'value'    => 1,
						'default'  => 1,
						'priority' => 16,
					);
				}
			}

			uasort( $fields, 'charitable_priority_sort' );

			return $fields;		
		}

		/**
		 * Return the merged fields.
		 *
		 * @since  1.5.0
		 *
		 * @return array
		 */
		public function get_merged_fields() {
			$fields = array();

			foreach ( $this->get_fields() as $section_id => $section ) {
				if ( array_key_exists( 'fields', $section ) ) {
					$fields = array_merge( $fields, $section['fields'] );
				} else {
					$fields[ $section_id ] = $section;
				}
			}

			return $fields;
		}

		/**
		 * Get the value submitted for a particular field.
		 *
		 * @since  1.5.0
		 *
		 * @param  string $field   The field.
		 * @param  mixed  $default The default value to return if the value was not submitted.
		 * @return mixed
		 */
		public function get_submitted_value( $field, $default = false ) {
			return array_key_exists( $field, $_POST ) ? $_POST[ $field ] : $default;
		}

		/**
		 * Filter a campaign donation array, making sure both a campaign
		 * and amount are provided.
		 *
		 * @since  1.5.0
		 *
		 * @return boolean
		 */
		public function filter_campaign_donation( $campaign_donation ) {
			return array_key_exists( 'campaign_id', $campaign_donation )
				&& array_key_exists( 'amount', $campaign_donation )
				&& ! empty( $campaign_donation['campaign_id'] )
				&& ! empty( $campaign_donation['amount'] );
		}

		/**
		 * Validate the form submission.
		 *
		 * @since  1.5.0
		 *
		 * @return boolean
		 */
		public function validate_submission() {
			/* If we have already validated the submission, return the value. */
			if ( isset( $this->validated ) ) {
				return $this->valid;
			}
			
			$this->valid = $this->check_required_fields( $this->get_merged_fields() );

			$campaign_donations          = array_key_exists( 'campaign_donations', $_POST ) ? $_POST['campaign_donations'] : array();
			$_POST['campaign_donations'] = array_filter( $campaign_donations, array( $this, 'filter_campaign_donation' ) );

			if ( empty( $_POST['campaign_donations'] ) ) {
				charitable_get_notices()->add_error( __( 'You must provide both a campaign and amount.', 'charitable' ) );

				$this->valid = false;
			}

			if ( ! $this->get_submitted_value( 'donor_id' ) && ! $this->get_submitted_value( 'email' ) ) {
				charitable_get_notices()->add_error( __( 'Please choose an existing donor or provide an email address for a new donor.', 'charitable' ) );

				$this->valid = false;
			}

			/**
			 * Filter whether the admin donation form passes validation.
			 *
			 * @since 1.5.0
			 *
			 * @param boolean                        $valid Whether the form submission is valid.
			 * @param Charitable_Admin_Donation_Form $form  This instance of `Charitable_Admin_Donation_Form`.
			 */
			$this->valid     = apply_filters( 'charitable_validate_admin_donation_form_submission', $this->valid, $this );
			$this->validated = true;

			return $this->valid;
		}

		/**
		 * Return the donation values.
		 *
		 * @since  1.5.0
		 *
		 * @return array
		 */
		public function get_donation_values() {
			$values   = array(
				'ID'        => $this->get_submitted_value( 'ID' ),
				'donor_id'  => abs( $this->get_submitted_value( 'donor_id' ) ),				
				'status'    => $this->get_submitted_value( 'status' ),
				'log_note'  => $this->get_submitted_value( 'log_note' ),
				'user_id'   => 0,
			);

			if ( 'add_donation' == $this->get_submitted_value( 'charitable_action' ) ) {
				$values['donation_gateway'] = __( 'Manual', 'charitable' );
			}

			$values = $this->sanitize_submitted_campaign_donation( $values );
			$values = $this->sanitize_submitted_date( $values );
			$values = $this->sanitize_submitted_log_note( $values );
			$values = $this->sanitize_submitted_donor( $values );

			foreach ( $this->get_merged_fields() as $key => $field ) {
				if ( array_key_exists( 'data_type', $field ) && 'core' != $field['data_type'] ) {
					if ( array_key_exists( 'type', $field ) ) {
						$data_type  = $field['data_type'];
						$field_type = $field['type'];
						$default    = 'checkbox' == $field_type ? false : '';
						$submitted  = $this->get_submitted_value( $key );

						if ( ! isset( $values[ $data_type ][ $key ] ) || false != $submitted ) {
							$values[ $data_type ][ $key ] = $submitted ? $submitted : $default;
						}
					}
				}
			}

			/**
			 * Filter the submitted values.
			 *
			 * @since 1.5.0
			 *
			 * @param array                          $values The submitted values.
			 * @param Charitable_Admin_Donation_Form $form   This instance of `Charitable_Admin_Donation_Form`.
			 */
			return apply_filters( 'charitable_admin_donation_form_submission_values', $values, $this );
		}

		/**
		 * Return donor values.
		 *
		 * @since  1.5.0
		 *
		 * @param  array $values The submitted values.
		 * @return array
		 */
		protected function sanitize_submitted_donor( $values ) {
			/* If we did not receive a donor id, return without doing anything. */
			if ( ! $values[ 'donor_id' ] ) {
				return $values;
			}

			$donor = charitable_get_table( 'donors' )->get( $values['donor_id'] );

			if ( ! $donor ) {
				return $values;
			}

			/* Populate the 'user' and 'user_id' args with this donor's stored details. */
			$values['user'] = array(
				'email'      => $donor->email,
				'first_name' => $donor->first_name,
				'last_name'  => $donor->last_name,
			);

			$values['user_id'] = $donor->user_id;

			return $values;
		}

		/**
		 * Sanitize the log note, or add one if none was included.
		 *
		 * @since  1.5.0
		 *
		 * @param  array $values The submitted values.
		 * @return array
		 */
		protected function sanitize_submitted_log_note( $values ) {
			if ( ! $values['log_note'] ) {
				$values['log_note'] = sprintf( __( 'Donation updated manually by <a href="%s">%s</a>.', 'charitable' ),
					admin_url( 'user-edit.php?user_id=' . wp_get_current_user()->ID ),
					wp_get_current_user()->display_name
				);
			} else {
				$values['log_note'] .= sprintf( ' - <a href="%s">%s</a>',
					admin_url( 'user-edit.php?user_id=' . wp_get_current_user()->ID ),
					wp_get_current_user()->display_name
				);
			}

			return $values;
		}

		/**
		 * Sanitize the campaign donation submitted.
		 *
		 * @since  1.5.0
		 *
		 * @param  array $values The submitted values.
		 * @return array
		 */
		protected function sanitize_submitted_campaign_donation( $values ) {
			$campaigns = array();

			foreach ( $this->get_submitted_value( 'campaign_donations' ) as $key => $campaign_donation ) {
				$campaign_donation['amount'] = charitable_get_currency_helper()->sanitize_monetary_amount( $campaign_donation['amount'] );
				$campaigns[ $key ]           = $campaign_donation;
			}

			$values['campaigns'] = $campaigns;

			return $values;
		}

		/**
		 * Sanitize the date.
		 *
		 * @since  1.5.0
		 *
		 * @param  array $values The submitted values.
		 * @return array
		 */
		protected function sanitize_submitted_date( $values ) {
			$donation           = charitable_get_donation( $this->get_submitted_value( 'ID' ) );
			$is_new             = false === $donation || 'Auto Draft' === $donation->post_title;
			$date               = $this->get_submitted_value( 'date' );
			$time               = $this->get_submitted_value( 'time', '00:00:00' );
			$values['date_gmt'] = charitable_sanitize_date( $date, 'Y-m-d ' . $time );

			/* If the date matches today's date and it's a new donation, save the time too. */
			if ( date( 'Y-m-d 00:00:00' ) == $values['date_gmt'] && $is_new ) {
				$values['date_gmt'] = date( 'Y-m-d H:i:s' );
			}

			/* If the donation date has been changed, the time is always set to 00:00:00 */
			if ( $values['date_gmt'] !== $donation->post_date_gmt && ! $is_new ) {
				$values['date_gmt'] = charitable_sanitize_date( $date, 'Y-m-d 00:00:00' );
			}

			return $values;
		}

		/**
		 * Get a key=>value array of all existing donors.
		 *
		 * @since  1.5.0
		 *
		 * @return array
		 */
		protected function get_all_donors() {
			$donors = new Charitable_Donor_Query( array(
				'number'  => -1,
				'orderby' => 'name',
				'order'   => 'ASC',
				'output'  => 'raw',
				'status'  => false, // Return any.
			) );

			$donor_list = array();

			foreach ( $donors as $donor ) {
				$donor_list[ $donor->donor_id ] = trim( sprintf( '%s %s', $donor->first_name, $donor->last_name ) ) . ' - ' . $donor->email;
			}

			$list = array(
				''         => __( 'Select a Donor', 'charitable' ),
				'new'      => __( 'Add a New Donor', 'charitable' ),
				'existing' => array(
					'label'   => __( 'Existing Donors', 'charitable' ),
					'options' => $donor_list,
				),
			);

			return $list;
		}

		/**
		 * Set a field's initial value.
		 *
		 * @since  1.5.0
		 *
		 * @param  array  $field Field definition.
		 * @param  string $key   The key of the field.
		 * @return array
		 */
		protected function maybe_set_field_value( $field, $key ) {
			if ( array_key_exists( $key, $_POST ) ) {
				$field['value'] = $_POST[ $key ];
				return $field;
			}

			/* Checkboxes don't need a value set. */
			if ( 'checkbox' != $field['type'] ) {
				$field['value'] = array_key_exists( 'default', $field ) ? $field['default'] : '';
			}

			if ( ! $this->has_donation() ) {
				return $field;
			}

			if ( array_key_exists( 'value_callback', $field ) ) {
				$value = call_user_func( $field['value_callback'], $this->get_donation(), $key );
			} else {
				$value = $this->donation->get( $key );
			}

			if ( $value ) {
				$field['value'] = $value;
			}

			return $field;
		}
	}

endif;
