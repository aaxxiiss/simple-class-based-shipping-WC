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

	define('SEB_ID', 'seb_custom_shipping');

	function seb_shipping_method_init() {
		if ( ! class_exists( 'SEB_Custom_Shipping' ) ) {
			class SEB_Custom_Shipping extends WC_Shipping_Method {
				/**
				 * Constructor for your shipping class
				 *
				 * @access public
				 * @return void
				 */
				public function __construct( $instance_id = 0 ) {
					$this->id                 = SEB_ID; // Id for your shipping method. Should be uunique.
                    $this->instance_id           = absint( $instance_id ); // Unique instance ID of the method (zones can contain multiple instances of a single shipping method)
					$this->method_title       = __( 'Sebastian Custom Shipping' );  // Title shown in admin
					$this->method_description = __( 'Shipping method that is strictly dependent on shipping classes' ); // Description shown in admin
                    $this->supports              = array(
                        'shipping-zones',
                        'instance-settings',
                        'instance-settings-modal'
                    );
                    $this->instance_form_fields = include( 'seb-settings.php' );
					$this->enabled            = $this->get_option( 'enabled' );
					$this->title              = $this->get_option( 'title' );

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
					// $this->init_form_fields(); 
					// $this->init_settings(); // This is part of the settings API. Loads settings you previously init.

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
                        'id'    => $this->id . $this->instance_id,
						'label' => $this->title,
						'cost' => $this->get_option('fixed_rate'),
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

	// add filtering to exclude shipping method,
	// if cart indludes items that are not meeting the criteria of restricted shipping class
	include( 'seb-filter-shipping-methods.php' );

}