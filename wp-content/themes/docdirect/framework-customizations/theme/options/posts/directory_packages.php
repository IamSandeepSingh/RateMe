<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'settings' => array(
        'title' => 'Packages Settings',
        'type' => 'box',
        'options' => array(
			'featured' => array(
				'type' => 'checkbox',
				'label' => esc_html__('Make Featured?', 'docdirect'),
				'desc' => esc_html__('', 'docdirect'),
			),
			'pac_subtitle' => array(
				'type' => 'text',
				'attr' => array(),
				'label' => esc_html__('Package Sub Title', 'docdirect'),
				'desc' => esc_html__('Add Package Sub Title', 'docdirect'),
			),
			'price' => array(
				'type' => 'text',
				'attr' => array(),
				'label' => esc_html__('Price', 'docdirect'),
				'help' => esc_html__('Pleas add price for this package. for currency settings please go to Tools > Theme Settings > Payment Settings', 'docdirect'),
				'desc' => esc_html__('Add Price as : 75', 'docdirect'),
			),
			'duration' => array(
				'type' => 'text',
				'attr' => array(),
				'label' => esc_html__('Duration', 'docdirect'),
				'help' => esc_html__('Package Duation is in Days. Please add number of days for this package.', 'docdirect'),
				'desc' => esc_html__('Add Duration as : 30, please add only integer value', 'docdirect'),
			),
			'short_description' => array(
				'type' => 'textarea',
				'attr' => array(),
				'label' => esc_html__('Package Description', 'docdirect'),
				'desc' => esc_html__('Add Package short description.', 'docdirect'),
			),
			'features' => array(
				'type'  => 'addable-option',
				'value' => array(),
				'attr'  => array(),
				'label' => esc_html__('Features', 'docdirect'),
				'desc'  => esc_html__('Add Package Feature', 'docdirect'),
				'help'  => esc_html__('', 'docdirect'),
				'option' => array( 'type' => 'text' ),
				'add-button-text' => esc_html__('Add Feature', 'docdirect'),
				'sortable' => true,
			)
		)
    ),
);
