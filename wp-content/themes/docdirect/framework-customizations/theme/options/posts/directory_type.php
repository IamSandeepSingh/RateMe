<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'settings' => array(
        'title' => 'Directory Settings',
        'type' => 'box',
        'options' => array(
			'dir_icon'     => array(
				'type'  => 'new-icon',
				'value' => 'fa-smile-o',
				'attr'  => array(),
				'label' => esc_html__('Choos Icon', 'docdirect'),
				'desc'  => esc_html__('Add Category icon.', 'docdirect'),
				'help'  => esc_html__('', 'docdirect'),
			),
			'category_image' => array(
				'type'       => 'upload',
				'label'      => esc_html__( 'Image?', 'docdirect' ),
				'desc'       => esc_html__( 'Add category image here. It will be shown in box as background in categories listing.','docdirect' ),
			),
			'dir_map_marker' => array(
				'type'  => 'upload',
				'label' => esc_html__('Add Marker', 'docdirect'),
				'hint' => esc_html__('Add map marker, it will be display at map.', 'docdirect'),
				'desc'  => esc_html__('', 'docdirect'),
				'images_only' => true,
			),
			'education' => array(
				'type'  => 'switch',
				'value' => 'enable',
				'label' => esc_html__('Enable Educations', 'docdirect'),
				'desc'  => esc_html__('Please enable if you want to give permession to the user to add his/her education from frond end', 'docdirect'),
				'help'  => esc_html__('', 'docdirect'),
				'left-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('enable', 'docdirect'),
				),
				'right-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'docdirect'),
				),
			),
			'experience' => array(
				'type'  => 'switch',
				'value' => 'disable',
				'label' => esc_html__('Enable Experience', 'docdirect'),
				'desc'  => esc_html__('Please enable if you want to give permession to the user to add his/her experience from frond end', 'docdirect'),
				'help'  => esc_html__('', 'docdirect'),
				'left-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('enable', 'docdirect'),
				),
				'right-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'docdirect'),
				),
			),
			'reviews' => array(
				'type'  => 'switch',
				'value' => 'enable',
				'label' => esc_html__('Enable Reviews', 'docdirect'),
				'desc'  => esc_html__('Please enable reviews for this directory type. User registered under this category will be able to get reviews.', 'docdirect'),
				'help'  => esc_html__('', 'docdirect'),
				'left-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('enable', 'docdirect'),
				),
				'right-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'docdirect'),
				),
			),
			'claims' => array(
				'type'  => 'switch',
				'value' => 'enable',
				'label' => esc_html__('Enable Claims/Reports', 'docdirect'),
				'desc'  => esc_html__('Enable or disable claims/reports for this directory type.', 'docdirect'),
				'help'  => esc_html__('', 'docdirect'),
				'left-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('enable', 'docdirect'),
				),
				'right-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'docdirect'),
				),
			),
			'bookings' => array(
				'type'  => 'switch',
				'value' => 'enable',
				'label' => esc_html__('Enable Bookings', 'docdirect'),
				'desc'  => esc_html__('Enable or disable bookings for this directory type.', 'docdirect'),
				'help'  => esc_html__('', 'docdirect'),
				'left-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('enable', 'docdirect'),
				),
				'right-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'docdirect'),
				),
			),
			'insurance' => array(
				'type'  => 'switch',
				'value' => 'enable',
				'label' => esc_html__('Enable Insurance', 'docdirect'),
				'desc'  => esc_html__('Enable or disable insurance plans for this directory type.', 'docdirect'),
				'help'  => esc_html__('', 'docdirect'),
				'left-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('enable', 'docdirect'),
				),
				'right-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'docdirect'),
				),
			),
			'specialities' => array(
				'type'       => 'custom-checkboxes',
				'label'      => esc_html__( 'Select Specialities', 'docdirect' ),
				'desc'       => esc_html__( 'Select Specialities for this directory type.','docdirect' ),
				'choices' => docdirect_prepare_specialities()
			),
		)
    ),
);
