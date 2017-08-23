<?php
/**
 * Theme functions file
 */

/**
 * Enqueue parent theme styles first
 * Replaces previous method using @import
 * <http://codex.wordpress.org/Child_Themes>
 */

function docdirect_child_theme_enqueue_styles() {
    $parent_style = 'docdirect_theme_style';
  	wp_enqueue_style( 'docdirect_child_style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'docdirect_child_theme_enqueue_styles' );


// Hide Admin Bar for All Users Except Adminministrators
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}

