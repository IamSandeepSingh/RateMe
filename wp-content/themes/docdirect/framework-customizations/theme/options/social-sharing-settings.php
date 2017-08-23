<?php if ( ! defined( 'FW' ) ) {
    die( 'Forbidden' );
}
$options = array(
    'social_sharing' => array(
        'title'   => esc_html__( 'Social Sharing', 'docdirect' ),
        'type'    => 'tab',
        'options' => array(
			'social_facebook' => array(
                'label' => esc_html__( 'Faceobook', 'docdirect' ),
                'type'  => 'switch',
				'value' => 'enable',
                'desc'  => esc_html__( 'Sharing on/off', 'docdirect' ),
				'left-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('Enable', 'docdirect'),
				),
				'right-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'docdirect'),
				),
            ),
			'social_twitter' => array(
                'label' => esc_html__( 'Twitter', 'docdirect' ),
                'type'  => 'switch',
                'value' => 'enable',
                'desc'  => esc_html__( 'Sharing on/off', 'docdirect' ),
				'left-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('Enable', 'docdirect'),
				),
				'right-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'docdirect'),
				),
            ),
			'social_tumbler' => array(
                'label' => esc_html__( 'Tumbler', 'docdirect' ),
                'type'  => 'switch',
               'value' => 'enable',
                'desc'  => esc_html__( 'Sharing on/off', 'docdirect' ),
				'left-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('Enable', 'docdirect'),
				),
				'right-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'docdirect'),
				),
            ),
			'social_email' => array(
                'label' => esc_html__( 'E-mail', 'docdirect' ),
                'type'  => 'switch',
                'value' => 'enable',
                'desc'  => esc_html__( 'Sharing on/off', 'docdirect' ),
				'left-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('Enable', 'docdirect'),
				),
				'right-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'docdirect'),
				),
            ),
			'social_dribble' => array(
                'label' => esc_html__( 'Dribble', 'docdirect' ),
                'type'  => 'switch',
                'value' => 'disable',
                'desc'  => esc_html__( 'Sharing on/off', 'docdirect' ),
				'left-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('Enable', 'docdirect'),
				),
				'right-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'docdirect'),
				),
            ),
			'social_instagram' => array(
                'label' => esc_html__( 'Instagram', 'docdirect' ),
                'type'  => 'switch',
                'value' => 'disable',
                'desc'  => esc_html__( 'Sharing on/off', 'docdirect' ),
				'left-choice' => array(
					'value' => 'enable',
					'label' => esc_html__('Enable', 'docdirect'),
				),
				'right-choice' => array(
					'value' => 'disable',
					'label' => esc_html__('Disable', 'docdirect'),
				),
            ),
			'social_youtube' => array(
                'label' => esc_html__( 'Youtube', 'docdirect' ),
                'type'  => 'switch',
                'value' => 'disable',
                'desc'  => esc_html__( 'Sharing on/off', 'docdirect' ),
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
    ),
);
