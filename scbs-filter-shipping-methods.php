<?php

/**
 * Filter shipping methods when cart is updated and at the checkout:
 * make sure that all products in package meet the criteria of shipping class defined for shipping method.
 * If criteria is not met, remove instance of shipping method from available shipping methods (rates)
 */

add_filter( 'woocommerce_package_rates', 'SCBS_filter_shipping_methods', 10, 2 );

function SCBS_filter_shipping_methods( $rates, $package ) {


	// Find instances of SCBS methods
    
	foreach ( $rates as $rate_key => $rate ) {
        
		if ( is_object( $rate ) && method_exists( $rate, 'get_id' ) && ( $rate->get_method_id() === SCBS_ID ) ) {
            
			// get current instance's setting for restricted shipping class and max amount of items in a package
			$rate_id_number = str_replace( $rate->get_method_id(), '', $rate->get_id() );
			$method_key_id = $rate->get_method_id() . '_' . $rate_id_number;
			$option_name = 'woocommerce_' . $method_key_id . '_settings';

			$shipping_class_slug = get_option( $option_name, true )['shipping_class'];
			$max_item_amount = get_option( $option_name, true )['max_item_amount'];

			// Checking all in cart items and make sure they fit to SCBS instance's shipping class,
			// if not remove shipping method's current instance

			$item_counter = 0;

			foreach( $package['contents'] as $item ){
								
				if( $item['data']->get_shipping_class() !== $shipping_class_slug ){
					unset( $rates[ $rate->get_id() ] );
					break;
				}

				$item_counter++;
				if ($item_counter >= $max_item_amount) {
					unset( $rates[ $rate->get_id() ] );
					break;
				}
			}
        }

	}

	return $rates;
}

