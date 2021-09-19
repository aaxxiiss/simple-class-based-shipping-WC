<?php

/**
 * Filter shipping methods when cart is updated and at checkout:
 * make sure that all products in package meet the criteria of restricted shipping class defined for shipping method.
 * If criteria is not met, remove shipping method from available shipping methods (rates)
 */

add_filter( 'woocommerce_package_rates', 'SEB_filter_shipping_methods', 10, 2 );

function SEB_filter_shipping_methods( $rates, $package ) {


	// Find SEB custom shipping methods
    
	foreach ( $rates as $rate_key => $rate ) {
        
		if ( is_object( $rate ) && method_exists( $rate, 'get_id' ) && ( $rate->get_method_id() === SEB_ID ) ) {
            
			// get current instance's setting for restricted shipping class
			$rate_id_number = str_replace( $rate->get_method_id(), '', $rate->get_id() );
			$method_key_id = $rate->get_method_id() . '_' . $rate_id_number;
			$option_name = 'woocommerce_' . $method_key_id . '_settings';
			$shipping_class_slug = get_option( $option_name, true )['shipping_class'];

			// Checking all in cart items and make sure they fit to restricted shipping class,
			// if not remove shipping method's current instance

			foreach( $package['contents'] as $item ){
				
				if( $item['data']->get_shipping_class() !== $shipping_class_slug ){
					unset( $rates[ $rate->get_id() ] );
					break;
				}
			}
        }

	}

	return $rates;
}