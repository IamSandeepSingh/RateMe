<?php if (!defined('FW')) die('Forbidden');
function _filter_theme_disable_default_shortcodes($to_disable) {
    $to_disable[] = 'accordion';
    $to_disable[] = 'button';
    $to_disable[] = 'calendar';
    //$to_disable[] = 'testimonials';
    $to_disable[] = 'divider';
    $to_disable[] = 'icon_box';
    $to_disable[] = 'map';
    $to_disable[] = 'notification';
    $to_disable[] = 'special_heading';
    $to_disable[] = 'table';
    $to_disable[] = 'widget_area';
    $to_disable[] = 'icon';
    $to_disable[] = 'media_video';
	$to_disable[] = 'media_image';
	$to_disable[] = 'team_member';
	$to_disable[] = 'tabs';
    return $to_disable;
}
add_filter('fw_ext_shortcodes_disable_shortcodes', '_filter_theme_disable_default_shortcodes');
