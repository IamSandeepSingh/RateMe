<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * Framework options
 *
 * @var array $options Fill this array with options to generate framework settings form in backend
 */

$options = array(
	fw()->theme->get_options( 'general-settings' ),
	fw()->theme->get_options( 'blog-settings' ),
	fw()->theme->get_options( 'colors-settings' ),
	fw()->theme->get_options( 'headers-settings' ),
	fw()->theme->get_options( 'subheaders-settings' ),
	fw()->theme->get_options( 'footer-settings' ),
    fw()->theme->get_options( 'typo-settings' ),
    fw()->theme->get_options( 'social-settings' ),
	fw()->theme->get_options( 'social-sharing-settings' ),
    fw()->theme->get_options( 'commingsoon-settings' ),
	fw()->theme->get_options( 'directory-settings' ),
	fw()->theme->get_options( 'payments-settings' ),
	fw()->theme->get_options( 'notification-settings' ),
	fw()->theme->get_options( 'api-settings' ),
	fw()->theme->get_options( 'captcha-settings' ),
);
