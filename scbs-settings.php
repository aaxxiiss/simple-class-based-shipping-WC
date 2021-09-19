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
        'default'		=> __( 'Simple Class Based Shipping' ),
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
        'description'	=> __('Enabled only shipping class. Shipping option is available when all items on order belong to the selected shipping class.'),
        'options'		=> $shipping_class_names,
        'desc_tip'		=> true
    ),
    'max_item_amount' => array(
        'title' 		=> __( 'Max amount of items' ),
        'type' 			=> 'text',
        'description' 	=> __( 'Limit the amount of items that can be included. Shipping option is available when amount of items in an order is less than or equal to this value. Leave empty for unlimited amount.' ),
        'default'		=> __( '0' ),
        'desc_tip'		=> true
    ),
);

return $settings;