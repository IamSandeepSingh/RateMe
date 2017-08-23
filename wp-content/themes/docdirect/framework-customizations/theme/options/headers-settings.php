<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'headers' => array(
		'title'   => esc_html__( 'Headers', 'docdirect' ),
		'type'    => 'tab',
		'options' => array(
			'general-box' => array(
				'title'   => esc_html__( 'Header Settings', 'docdirect' ),
				'type'    => 'box',
				'options' => array(
					'header_type' => array(
                        'type' => 'multi-picker',
                        'label' => false,
                        'desc' => false,
                        'value' => array('gadget' => 'header_v1'),
                        'picker' => array(
                            'gadget' => array(
                                'label' => esc_html__('Header Type', 'docdirect'),
                                'type' => 'image-picker',
                                'choices' => array(
                                    'header_v1' => array(
                                        'label' => __('Header V1', 'docdirect'),
                                        'small' => array(
                                            'height' => 70,
                                            'src' => get_template_directory_uri() . '/images/headers/h_1.jpg'
                                        ),
                                        'large' => array(
                                            'height' => 214,
                                            'src' => get_template_directory_uri() . '/images/headers/h_1.jpg'
                                        ),
                                    ),
                                    'header_v2' => array(
                                        'label' => __('Header V2', 'docdirect'),
                                        'small' => array(
                                            'height' => 70,
                                            'src' => get_template_directory_uri() . '/images/headers/h_2.jpg'
                                        ),
                                        'large' => array(
                                            'height' => 214,
                                            'src' => get_template_directory_uri() . '/images/headers/h_2.jpg'
                                        ),
                                    ),
                                ),
                                'desc' => esc_html__('Select header type.', 'docdirect'),
                            )
                        ),
                        'choices' => array(
                            'header_v2' => array(
                                'contact_info' => array(
									'type'  => 'wp-editor',
									'value' => 'default value',
									'label' => esc_html__('Contact Info', 'docdirect'),
									'desc'  => esc_html__('Add contact info', 'docdirect'),
									'size' => 'small', // small, large
									'editor_height' => 400,
									'wpautop' => true,
									'editor_type' => false, // tinymce, html
								),
								'multilingual' => array(
									'type'  => 'switch',
									'value' => 'enable',
									'label' => esc_html__('Enable multilingual', 'docdirect'),
									'desc'  => esc_html__('Enable multilingual dropdown(WPML: Please install WPML plugin first to use this dropdown)', 'docdirect'),
									'left-choice' => array(
										'value' => 'enable',
										'label' => esc_html__('Enable', 'docdirect'),
									),
									'right-choice' => array(
										'value' => 'disable',
										'label' => esc_html__('Disable', 'docdirect'),
									),
								),
                            )
                        ),
                        'show_borders' => true,
                    ),
					'main_logo' => array(
                        'type'  => 'upload',
                        'label' => esc_html__('Main Logo', 'docdirect'),
						'hint' => esc_html__('It will display only  at home pages.', 'docdirect'),
                        'desc'  => esc_html__('Upload Your Logo Here the preferred size is 170 by 30.', 'docdirect'),
                        'images_only' => true,
                    ),
					'registration' => array(
						'type'  => 'switch',
						'value' => 'enable',
						'label' => esc_html__('Enable registration', 'docdirect'),
						'desc'  => esc_html__('Enable frontend Registration', 'docdirect'),
						'left-choice' => array(
							'value' => 'enable',
							'label' => esc_html__('Enable', 'docdirect'),
						),
						'right-choice' => array(
							'value' => 'disable',
							'label' => esc_html__('Disable', 'docdirect'),
						),
					),
					'terms_link' => array(
                        'type'  => 'text',
                        'label' => esc_html__('Terms and Conditions', 'docdirect'),
						'hint' => esc_html__('', 'docdirect'),
                        'desc'  => esc_html__('Add link for terms and conditions page. Please create a page first and then copy link and it it here.', 'docdirect'),
                        'images_only' => true,
                    ),
					'enable_login' => array(
						'type'  => 'switch',
						'value' => 'enable',
						'label' => esc_html__('Enable Login', 'docdirect'),
						'desc'  => esc_html__('Enable frontend Login', 'docdirect'),
						'left-choice' => array(
							'value' => 'enable',
							'label' => esc_html__('Enable', 'docdirect'),
						),
						'right-choice' => array(
							'value' => 'disable',
							'label' => esc_html__('Disable', 'docdirect'),
						),
					),
				),
			)
		)
	)
);