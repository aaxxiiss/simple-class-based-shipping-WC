<?php
/*
Plugin Name: Simple Class Based Shipping for WooCommerce
Plugin URI: https://github.com/aaxxiiss/simple-class-based-shipping-WC
Description: Simple Class Based Shipping is a WooCommerce shipping method, that enables custom shipping option for products in chosen shipping class
Version: 1.0.0
Author: Jukka Isokoski
Author URI: https://dev.jukkaisokoski.fi
License: GPL v2 or later
Text Domain: SCBS
*/

/**
 * Check if WooCommerce is active
 */


if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	// ID for custom shipping method
	define('SCBS_ID', 'scbs_custom_shipping');

	function scbs_shipping_method_init() {
		if ( ! class_exists( 'SCBS_Custom_Shipping' ) ) {
			class SCBS_Custom_Shipping extends WC_Shipping_Method {
				/**
				 * Constructor for your shipping class
				 *
				 * @access public
				 * @return void
				 */
				public function __construct( $instance_id = 0 ) {
					$this->id                 = SCBS_ID;
                    $this->instance_id           = absint( $instance_id ); // Unique instance ID of the method (zones can contain multiple instances of a single shipping method)
					$this->method_title       = __( 'Simple Class Based Shipping' );  // Title shown in admin
					$this->method_description = __( 'Simple Class Based Shipping enables custom shipping option for products in chosen shipping class' );
                    $this->supports              = array(
                        'shipping-zones',
                        'instance-settings',
                        'instance-settings-modal'
                    );
                    $this->instance_form_fields = include( 'scbs-settings.php' );
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

	add_action( 'woocommerce_shipping_init', 'scbs_shipping_method_init' );

	function add_scbs_custom_shipping( $methods ) {		
		$methods['scbs_custom_shipping'] = 'SCBS_Custom_Shipping';
		return $methods;
	}
	add_filter( 'woocommerce_shipping_methods', 'add_scbs_custom_shipping' );

	// add filtering to exclude shipping method,
	// if cart indludes items that are not meeting the criteria of restricted shipping class
	include( 'scbs-filter-shipping-methods.php' );

}