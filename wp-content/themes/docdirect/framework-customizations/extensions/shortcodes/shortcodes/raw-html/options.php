<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
    'textblock_description'  => array(
        'type'  => 'wp-editor',
        'value' => 'default value',
        'attr'  => array(),
        'label' => esc_html__('Add HTML', 'docdirect'),
        'desc'  => esc_html__('Please add raw html code in text editor', 'docdirect'),
        'help'  => esc_html__('', 'docdirect'),
        'tinymce' => true,
        'media_buttons' => true,
        'teeny' => true,
        'wpautop' => false,
        'editor_css' => '',
        'reinit' => true,
        'size' => 'small', // small | large
        'editor_type' => 'tinymce',
        'editor_height' => 400
    ),
);