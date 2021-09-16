<?php
/*
Plugin Name: Sebastian Custom Shipping plugin
Plugin URI: https://shopforsebastian.com
Description: Sebastian Custom Shipping is strictly shipping class dependent shipping method for WooCommerce
Version: 0.0.1
Author: Jukka Isokoski
Author URI: https://jukkaisokoski.fi
License: GPL v2 or later
Text Domain: seb-custom-shipping
*/

/**
 * Check if WooCommerce is active
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	function seb_shipping_method_init() {
		if ( ! class_exists( 'SEB_Custom_Shipping' ) ) {
			class SEB_Custom_Shipping extends WC_Shipping_Method {
				/**
				 * Constructor for your shipping class
				 *
				 * @access public
				 * @return void
				 */
				public function __construct() {
					$this->id                 = 'seb_custom_shipping'; // Id for your shipping method. Should be uunique.
					$this->method_title       = __( 'Sebastian Custom Shipping' );  // Title shown in admin
					$this->method_description = __( 'Shipping method that is strictly dependent on shipping classes' ); // Description shown in admin

					$this->enabled            = "yes"; // This can be added as an setting but for this example its forced enabled
					$this->title              = "Sebastian Custom Shipping"; // This can be added as an setting but for this example its forced.

					$this->init();
				}

				/**
				 * Init your settings
				 *
				 * @access public
				 * @return void
				 */
				function init() {
					// Load the settings API
					$this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
					$this->init_settings(); // This is part of the settings API. Loads settings you previously init.

					// Save settings in admin if you have any defined
					add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
				}

				/**
				 * calculate_shipping function.
				 *
				 * @access public
				 * @param mixed $package
				 * @return void
				 */
				public function calculate_shipping( $package = array() ) {
					$rate = array(
						'label' => $this->title,
						'cost' => '10.99',
						'calc_tax' => 'per_item'
					);

					// Register the rate
					$this->add_rate( $rate );
				}
			}
		}
	}

	add_action( 'woocommerce_shipping_init', 'seb_shipping_method_init' );

	function add_seb_custom_shipping( $methods ) {
		$methods['seb_custom_shipping'] = 'SEB_Custom_Shipping';
		return $methods;
	}

	add_filter( 'woocommerce_shipping_methods', 'add_seb_custom_shipping' );
}