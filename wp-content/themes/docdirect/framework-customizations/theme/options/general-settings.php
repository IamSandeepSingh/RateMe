<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'general' => array(
		'title'   => esc_html__( 'General', 'docdirect' ),
		'type'    => 'tab',
		'options' => array(
			'general-box' => array(
				'title'   => esc_html__( 'General Settings. All4Share.net', 'docdirect' ),
				'type'    => 'box',
				'options' => array(
					'preloader' => array(
                        'type'  => 'switch',
                        'value' => 'disable',
                        'label' => esc_html__('Enable Preloader', 'docdirect'),
                        'left-choice' => array(
                            'value' => 'enable',
                            'label' => esc_html__('Enable', 'docdirect'),
                        ),
                        'right-choice' => array(
                            'value' => 'disable',
                            'label' => esc_html__('Disable', 'docdirect'),
                        ),
                    ),
					'favicon' => array(
						'label' => esc_html__( 'Favicon', 'docdirect' ),
						'desc'  => esc_html__( 'Upload a favicon image', 'docdirect' ),
						'type'  => 'upload'
					),
					'404_image' => array(
						'label' => esc_html__( '404 Page Image', 'docdirect' ),
						'desc'  => esc_html__( '', 'docdirect' ),
						'type'  => 'upload'
					),
                    '404_title' => array(
                        'type'  => 'text',
                        'value' => 'we are sorry!',
                        'label' => esc_html__('404 Title', 'docdirect'),
                    ),
					'404_message' => array(
                        'type'  => 'textarea',
                        'value' => 'THE PAGE YOU REQUESTED CANNOT BE FOUND.',
                        'label' => esc_html__('404 Sub Title', 'docdirect'),
                    ),
					'404_description' => array(
                        'type'  => 'textarea',
                        'value' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                        'label' => esc_html__('404 Description', 'docdirect'),
                    ),
					'search_text' => array(
                        'type'  => 'textarea',
                        'value' => 'Perhaps searching can help.',
                        'label' => esc_html__('Search Message', 'docdirect'),
                    ),
                    'custom_css' => array(
                        'type'  => 'textarea',
                        'label' => esc_html__('Custom CSS', 'docdirect'),
                        'desc'  => esc_html__('Add your custom css code here if you want to target specifically on different elements.', 'docdirect'),
                    ),
				)
			),
		)
	)
);