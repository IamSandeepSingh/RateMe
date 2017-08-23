<?php

if (!defined('FW')) {
    die('Forbidden');
}

$options = array(
    'blog_view' => array(
        'type' => 'select',
        'value' => 'grid',
        'label' => esc_html__('Select View', 'docdirect'),
        'choices' => array(
            'grid' => esc_html__('Grid', 'docdirect'),
            'list' => esc_html__('List', 'docdirect'),
			'large' => esc_html__('Large', 'docdirect'),
        ),
    ),
	'posts_category' => array(
        'type'       => 'multi-select',
        'label'      => esc_html__( 'Select Posts Categories', 'docdirect' ),
        'population' => 'taxonomy',
        'source'     => 'category',
        'desc'       => esc_html__( 'Show posts by category selection.','docdirect' ),
    ),
    'show_posts' => array(
        'type' => 'slider',
        'value' => 9,
        'properties' => array(
            'min' => 0,
            'max' => 20,
            'sep' => 1,
        ),
        'label' => esc_html__('Show No of Posts', 'docdirect'),
    ),
    'show_pagination' => array(
        'type' => 'select',
        'value' => 'yes',
        'label' => esc_html__('Show Pagination', 'docdirect'),
        'desc' => esc_html__('', 'docdirect'),
        'choices' => array(
            'yes' => esc_html__('Yes', 'docdirect'),
            'no' => esc_html__('No', 'docdirect'),
        ),
        'no-validate' => false,
    ),
    'show_description' => array(
        'type' => 'switch',
        'value' => 'show',
        'label' => esc_html__('Description', 'docdirect'),
        'desc' => esc_html__('', 'docdirect'),
        'left-choice' => array(
            'value' => 'show',
            'label' => esc_html__('Show Description', 'docdirect'),
        ),
        'right-choice' => array(
            'value' => 'hide',
            'label' => esc_html__('Hide Description', 'docdirect'),
        ),
    ),
    'excerpt_length' => array(
        'type' => 'slider',
        'value' => 123,
        'properties' => array(
            'min' => 0,
            'max' => 1000,
            'sep' => 1,
        ),
        'label' => esc_html__('Excerpt length', 'docdirect'),
    ),
);
