<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'settings' => array(
        'title' => 'Review Detail',
        'type' => 'box',
        'options' => array(
			'user_rating' => array(
                'type' => 'slider',
                'value' => 1,
                'properties' => array(
                    'min' => 1,
                    'max' => 5,
                    'sep' => 1,
                ),
                'desc' => esc_html__('Add User Rating.', 'docdirect'),
                'label' => esc_html__('Rating', 'docdirect'),
            ),
			/*'user_name'     => array(
				'label' => esc_html__( 'User Name', 'docdirect' ),
				'type'  => 'text',
				'desc' => esc_html__('Name of user who rate.', 'docdirect'),
			),
			'user_email'     => array(
				'label' => esc_html__( 'User Email', 'docdirect' ),
				'type'  => 'text',
				'desc' => esc_html__('Email of user who rate.', 'docdirect'),
			),*/
			'user_from'     => array(
				'label' => esc_html__( 'User From', 'docdirect' ),
				'type'  => 'select',
				'desc' => esc_html__('Select user who rate.', 'docdirect'),
				'choices'	=> docdirect_prepare_user_list(),
			),
			'user_to'     => array(
				'label' => esc_html__( 'User To', 'docdirect' ),
				'type'  => 'select',
				'desc' => esc_html__('Select user who is beign rated.', 'docdirect'),
				'choices'	=> docdirect_prepare_user_list(),
			),
		)
    ),
);
