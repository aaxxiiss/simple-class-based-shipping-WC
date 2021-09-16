<?php 

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$settings =  array(
    'enabled' => array(
        'title' 		=> __( 'Enable/Disable' ),
        'type' 			=> 'checkbox',
        'label' 		=> __( 'Enable this shipping method' ),
        'default' 		=> 'yes',
    ),
    'title' => array(
        'title' 		=> __( 'Title' ),
        'type' 			=> 'text',
        'description' 	=> __( 'This controls the title which the user sees during checkout.' ),
        'default'		=> __( 'Sebastian Custom Shipping' ),
        'desc_tip'		=> true
    ),
    'fixed_rate' => array(
        'title' 		=> __( 'Fixed fee' ),
        'type' 			=> 'text',
        'description' 	=> __( 'This is the fixed shipping fee' ),
        'default'		=> __( '0' ),
        'desc_tip'		=> true
    ),
    'shipping_class' => array(
        'title'			=> __('Shipping class'),
        'type'			=> 'select',
        'description'	=> __('Restrict to shipping class. Shipping is available when all items on order belong to the selected shipping class.'),
        'options'		=> array(
                            'test'	=>		'Test shipping class',
                            'kaks'	=>		'Kakkonen',
                            ),
        'desc_tip'		=> true
    ),
);

return $settings;