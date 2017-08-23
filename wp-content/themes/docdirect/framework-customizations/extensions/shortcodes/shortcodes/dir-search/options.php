<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'view' => array(
		'label' => esc_html__('Search View', 'docdirect'),
		'type' => 'select',
		'value' => '',
		'desc' => esc_html__('Please select search view.', 'docdirect'),
		'choices'	=> array(
			'view_1'	=> 'Verticle View',
			'view_2'	=> 'Horizontal View',
		)
	),
	'latitude' => array(
		'label' => esc_html__('Default Latitude', 'docdirect'),
		'type' => 'text',
		'value' => '51.5001524',
		'desc' => esc_html__('Add Default Latitude', 'docdirect'),
	),
	'longitude' => array(
		'label' => esc_html__('Default Longitude', 'docdirect'),
		'type' => 'text',
		'value' => '-0.1262362',
		'desc' => esc_html__('Add Default Longitude', 'docdirect'),
	),
	
	'btn_title' => array(
		'label' => esc_html__('Button Title', 'docdirect'),
		'type' => 'text',
		'value' => 'Search',
		'desc' => esc_html__('Add Button title', 'docdirect'),
	),
);
