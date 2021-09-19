<?php 

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// get defined shipping classes and ad them to array with format: slug => name
$shipping_classes = WC()->shipping->get_shipping_classes();
$shipping_class_names = array();
foreach ( $shipping_classes as $shipping_class ) {
    $shipping_class_names[$shipping_class->slug] = $shipping_class->name;
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
        'options'		=> $shipping_class_names,
        'desc_tip'		=> true
    ),
);

return $settings;