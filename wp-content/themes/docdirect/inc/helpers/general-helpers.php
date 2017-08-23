<?php
/**
 * Theme Helper Functions
 *
 * @package Doctor Directory
 */
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
 
if (!isset($content_width)) {
    $content_width = 640; /* pixels */
}

remove_filter( 'the_content', 'wpautop' );
/**
 * @Theme Editor Style
 * 
 */
if (!function_exists('docdirect_add_editor_styles')) {
	function docdirect_add_editor_styles() {
		$theme_version = wp_get_theme();
		add_editor_style(  get_template_directory_uri() . '/core/css/docdirect-editor-style.css', array(), $theme_version->get( 'Version' ) );
	}
	add_action( 'admin_init', 'docdirect_add_editor_styles' );
}

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
if (!function_exists('docdirect_widgets_init')) {

    function docdirect_widgets_init() {

        register_sidebar(array(
            'name' => esc_attr('Sidebar', 'docdirect'),
            'id' => 'sidebar-1',
            'description' => '',
            'before_widget' => '<div id="%1$s" class="tg-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
        ));
		
       register_sidebar(array(
            'name' => esc_html__('Footer Column 1', 'docdirect'),
            'id' => 'footer-column-1',
            'description' => '',
            'before_widget' => '<div id="%1$s" class="%2$s tg-widget">',
            'after_widget' => '</div>',
            'before_title' => '<div class="tg-heading-border tg-small"><h4>',
            'after_title' => '</h4></div>',
        ));
		register_sidebar(array(
            'name' => esc_html__('Footer Column 2', 'docdirect'),
            'id' => 'footer-column-2',
            'description' => '',
            'before_widget' => '<div id="%1$s" class="%2$s tg-widget">',
            'after_widget' => '</div>',
            'before_title' => '<div class="tg-heading-border tg-small"><h4>',
            'after_title' => '</h4></div>',
        ));
		register_sidebar(array(
            'name' => esc_html__('Footer Column 3', 'docdirect'),
            'id' => 'footer-column-3',
            'description' => '',
            'before_widget' => '<div id="%1$s" class="%2$s tg-widget">',
            'after_widget' => '</div>',
            'before_title' => '<div class="tg-heading-border tg-small"><h4>',
            'after_title' => '</h4></div>',
        ));
    }

    add_action('widgets_init', 'docdirect_widgets_init');
}

/**
 * Enqueue scripts and styles.
 */
if (!function_exists('docdirect_scripts')) {

    function docdirect_scripts() {
        $theme_version = wp_get_theme();
		
		//Theme general styles
        wp_enqueue_style('bootstrap.min', get_template_directory_uri() . '/css/bootstrap.min.css', array(), $theme_version->get( 'Version' ));
		wp_enqueue_style('fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), $theme_version->get( 'Version' ));
		wp_enqueue_style('docdirect_normalize', get_template_directory_uri() . '/css/normalize.css', array(), $theme_version->get( 'Version' ));
		wp_enqueue_style('icomoon', get_template_directory_uri() . '/css/icomoon.css', array(), $theme_version->get( 'Version' ));
		wp_enqueue_style('owl.carousel', get_template_directory_uri() . '/css/owl.carousel.css', array(), $theme_version->get( 'Version' ));
		wp_enqueue_style('owl.theme', get_template_directory_uri() . '/css/owl.theme.css', array(), $theme_version->get( 'Version' ));
		wp_enqueue_style('prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css', array(), $theme_version->get( 'Version' ));
		wp_enqueue_style('docdirect_theme_style', get_template_directory_uri() . '/style.css', array(), $theme_version->get( 'Version' ));
		wp_enqueue_style('docdirect_theme_style_v2', get_template_directory_uri() . '/css/version-2.css', array(), $theme_version->get( 'Version' ));
		
		wp_enqueue_style('docdirect_typo_style', get_template_directory_uri() . '/css/typo.css', array(), $theme_version->get( 'Version' ));
		
		wp_enqueue_style('docdirect_transitions', get_template_directory_uri() . '/css/transitions.css', array(), $theme_version->get( 'Version' ));
		wp_enqueue_style('docdirect_responsive_style', get_template_directory_uri() . '/css/responsive.css', array(), $theme_version->get( 'Version' ));
		wp_enqueue_style('jquery-ui', get_template_directory_uri() . '/css/jquery-ui.css', array(), $theme_version->get( 'Version' ));
		wp_enqueue_style('docdirect_theme_colors', get_template_directory_uri() . '/css/color.css', array(), $theme_version->get( 'Version' ));
		
		if( is_rtl() ){
			wp_enqueue_style('docdirect_rtl', get_template_directory_uri() . '/css/rtl.css', array(), $theme_version->get( 'Version' ));
		}
		
		//Theme Scripts
       
		wp_enqueue_script('bootstrap.min', get_template_directory_uri() . '/js/vendor/bootstrap.min.js', array(), $theme_version->get( 'Version' ), true);
		wp_enqueue_script('docdirect_functions', get_template_directory_uri() . '/js/docdirect_functions.js', array('jquery','jquery-ui-core','jquery-ui-sortable','plupload','jquery-ui-slider','wp-util'), $theme_version->get( 'Version' ), true);
		wp_enqueue_script('docdirect_user_profile', get_template_directory_uri() . '/js/user_profile.js', array(), $theme_version->get( 'Version' ), true);
		wp_enqueue_script('moment', get_template_directory_uri() . '/js/moment.js', array(), $theme_version->get( 'Version' ), true);
		wp_enqueue_script('docdirect_bookings', get_template_directory_uri() . '/js/bookings.js', array(), $theme_version->get( 'Version' ), true);
		wp_enqueue_script('countdown', get_template_directory_uri() . '/js/countdown.js', array(), $theme_version->get( 'Version' ), false);
		wp_enqueue_script('parallax', get_template_directory_uri() . '/js/parallax.js', array(), $theme_version->get( 'Version' ), true);
		wp_enqueue_script('owl.carousel', get_template_directory_uri() . '/js/owl.carousel.js', array(), $theme_version->get( 'Version' ), true);
		wp_enqueue_script('prettyPhoto', get_template_directory_uri() . '/js/prettyPhoto.js', array(), $theme_version->get( 'Version' ), true);

		if(function_exists('fw_get_db_settings_option')){
			$language_code = fw_get_db_settings_option('language_code');
			$captcha_settings = fw_get_db_settings_option('captcha_settings');
			$language_code	= empty( $language_code ) ? 'en' : $language_code;
		} else {
			$language_code = 'en';
			$captcha_settings = '';
		}
	
		//Date Time Picker
		wp_enqueue_style('jquery.datetimepicker', get_template_directory_uri() . '/css/datetimepicker.css', array(), $theme_version->get( 'Version' ));
		wp_enqueue_script('jquery.datetimepicker', get_template_directory_uri() . '/js/datetimepicker.js', array(), $theme_version->get( 'Version' ), true);
		wp_enqueue_script('appear', get_template_directory_uri() . '/js/appear.js', array(), $theme_version->get( 'Version' ), true);
		wp_enqueue_script('countTo', get_template_directory_uri() . '/js/countTo.js', array(), $theme_version->get( 'Version' ), true);
		wp_enqueue_script('appear', get_template_directory_uri() . '/js/appear.js', array(), $theme_version->get( 'Version' ), true);
		wp_enqueue_script('sticky_message', get_template_directory_uri() . '/js/sticky_message.js', array(), $theme_version->get( 'Version' ), true);
		wp_enqueue_script('docdirect_modernizr', get_template_directory_uri() . '/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js', array(), $theme_version->get( 'Version' ), true);
		
		if( isset( $captcha_settings ) && $captcha_settings === 'enable' ) {
			wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js?onload=DocDirectCaptchaCallback&render=explicit&hl='.$language_code, array(), $theme_version->get( 'Version' ), true);
		}
       

		//Choosen
		wp_enqueue_style('choosen', get_template_directory_uri() . '/css/chosen.css', array(), $theme_version->get( 'Version' ));
		wp_enqueue_script('choosen', get_template_directory_uri() . '/js/chosen.jquery.js', array(), $theme_version->get( 'Version' ), true);
			
		//Conditional Scripts
		if ( is_page_template( 'directory/user-profile.php' ) ) {
			//Charts
			wp_enqueue_script('chart', get_template_directory_uri() . '/js/chart.js', array(), $theme_version->get( 'Version' ), true);
		}
		
		//Register TelInput
		wp_register_script('intlTelInput', get_template_directory_uri() . '/js/booking/js/intlTelInput.js', array(), $theme_version->get('Version')); 
		wp_register_style('intlTelInput', get_template_directory_uri() . '/css/booking/css/intlTelInput.css', array(), $theme_version->get( 'Version' ));
		
	    wp_localize_script('docdirect_functions', 'scripts_vars', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
        ));

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        if (function_exists('fw_get_framework_directory_uri')) :
            if (!is_admin()) {
                wp_enqueue_script(
                        'fw-form-helpers', fw_get_framework_directory_uri('/static/js/fw-form-helpers.js')
                );
            }
        endif;
    }

    add_action('wp_enqueue_scripts', 'docdirect_scripts');
}


/**
 * @Init Sharing Script
 * @return 
 */
if (!function_exists('docdirect_init_stripe_script')) {
    function docdirect_init_stripe_script() {
        $theme_version = wp_get_theme();
		wp_register_script('theme-stripeaddon', 'https://checkout.stripe.com/checkout.js', array('jquery'), $theme_version->get('Version')); 
        wp_enqueue_script('theme-stripeaddon'); 
    }
}

/**
 * Enqueue scripts and styles.
 */
if (!function_exists('docdirect_admin_scripts')) {

    function docdirect_admin_scripts() {
        $theme_version = wp_get_theme();
		wp_enqueue_media();
		wp_enqueue_script( 'wp-util' );
		wp_enqueue_style('fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), $theme_version->get( 'Version' ));
        wp_enqueue_script('docdirect_admin_functions', get_template_directory_uri() . '/core/js/docdirect_admin_functions.js', array('jquery'), $theme_version->get( 'Version' ) , true);
		
		wp_enqueue_script('locationpicker', get_template_directory_uri() . '/js/docdir_maps.js', '', '', true);
		//Date Time Picker
		wp_enqueue_style('jquery.datetimepicker', get_template_directory_uri() . '/css/datetimepicker.css', array(), $theme_version->get( 'Version' ));
		wp_enqueue_script('jquery.datetimepicker', get_template_directory_uri() . '/js/datetimepicker.js', array(), $theme_version->get( 'Version' ), false);
		
		//Choosen
		wp_enqueue_style('choosen', get_template_directory_uri() . '/css/chosen.css', array(), $theme_version->get( 'Version' ));
		wp_enqueue_script('choosen', get_template_directory_uri() . '/js/chosen.jquery.js', array(), $theme_version->get( 'Version' ), false);
		
		//Styles
		wp_enqueue_style('docdirect_admin_styles', get_template_directory_uri() . '/core/css/admin_styles.css', array(), $theme_version->get( 'Version' ));
    }

    add_action('admin_enqueue_scripts', 'docdirect_admin_scripts');
}
/**
 * @Init Sharing Script
 * @return 
 */
if (!function_exists('docdirect_init_share_script')) {
    function docdirect_init_share_script() {
        wp_enqueue_script('docdirect_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e4412d954dccc64', '', '', true);
    }
}

/**
 * @Init date picker Script
 * @return 
 */
if (!function_exists('docdirect_init_datepicker_script')) {
    function docdirect_init_datepicker_script() {
       $theme_version = wp_get_theme();
	   wp_enqueue_script('datepicker', get_template_directory_uri() . '/js/datepicker.js', array(), $theme_version->get( 'Version' ), true);
	   wp_enqueue_style('datepicker', get_template_directory_uri() . '/css/datepicker.css', array(), $theme_version->get( 'Version' ));
    }
}

/**
 * @Init pophover Script
 * @return 
 */
if (!function_exists('docdirect_init_popover_script')) {
    function docdirect_init_popover_script() {
       $theme_version = wp_get_theme();
	   wp_enqueue_script('popover', get_template_directory_uri() . '/js/popover.js', array(), $theme_version->get( 'Version' ), true);
    }
}

/**
 * @Init Sticky Script
 * @return 
 */
if (!function_exists('docdirect_init_dir_map')) {
    function docdirect_init_dir_map() {
         $theme_version = wp_get_theme();
		 
		 $protolcol = is_ssl() ? "https" : "http";
		
		 if (function_exists('fw_get_db_settings_option')) {
			$google_key = fw_get_db_settings_option('google_key');
		 } else {
			$google_key = 'AIzaSyB-v7mDZ8e1GDluhDZrhF_T44GxlJprqr0'; //Juts for demo, create your own API : https://developers.google.com/maps/documentation/javascript/get-api-key
		 }
		
		 if( empty( $google_key ) ){
			$google_key = 'AIzaSyB-v7mDZ8e1GDluhDZrhF_T44GxlJprqr0'; //Juts for demo, create your own API : https://developers.google.com/maps/documentation/javascript/get-api-key
		 }
		
         wp_enqueue_script('jquery-goolge-places', $protolcol.'://maps.googleapis.com/maps/api/js?key='.esc_attr($google_key).'&libraries=places', '', $theme_version->get( 'Version' ), true);
		
		
		 wp_enqueue_script('markerclusterer', get_template_directory_uri() . '/js/map/markerclusterer.min.js', array(), $theme_version->get( 'Version' ), true);
		 wp_enqueue_script('docdirect_infobox', get_template_directory_uri() . '/js/map/infobox.js', array(), $theme_version->get( 'Version' ), true);
		 wp_enqueue_script('docdirect_maps', get_template_directory_uri() . '/js/map/map.js', array(), $theme_version->get( 'Version' ), false);
		 //wp_enqueue_script('docdirect_spiderfy', get_template_directory_uri() . '/js/map/oms.min.js', array(), $theme_version->get( 'Version' ), false);
		 wp_enqueue_script('locationpicker', get_template_directory_uri() . '/js/docdir_maps.js', '', '', true);
    }
}

/**
 * @Init Sticky Script
 * @return 
 */
if (!function_exists('docdirect_init_sticky_script')) {
    function docdirect_init_sticky_script() {
         $theme_version = wp_get_theme();
		 wp_enqueue_script('docdirect_sticky', get_template_directory_uri() . '/js/sticky-em.js', array(), $theme_version->get( 'Version' ), true);
    }
}

/**
 * @Init OWL Script
 * @return 
 */
if (!function_exists('docdirect_init_owl_script')) {
    function docdirect_init_owl_script() {
        $theme_version = wp_get_theme();
		wp_enqueue_style('docdirect_owl_carousel', get_template_directory_uri() . '/css/owl.carousel.css', array(), $theme_version->get( 'Version' ));
		wp_enqueue_script('docdirect_owl_carousel', get_template_directory_uri() . '/js/owl.carousel.js', array(), $theme_version->get( 'Version' ), true);
    }
}

/**
 * @Init prettyphoto
 * @return 
 */
if (!function_exists('docdirect_prettyphoto_script')) {
    function docdirect_prettyphoto_script() {
        $theme_version = wp_get_theme();
		wp_enqueue_style('docdirect_prettyPhoto_style', get_template_directory_uri() . '/css/prettyPhoto.css', array(), $theme_version->get( 'Version' ));
		
    }
}

/**
 * @Init gmp3
 * @return 
 */
if (!function_exists('docdirect_enque_map_library')) {

    function docdirect_enque_map_library() {
        $protolcol = is_ssl() ? "https" : "http";
		
		if (function_exists('fw_get_db_settings_option')) {
			$google_key = fw_get_db_settings_option('google_key');
		} else {
			$google_key = 'AIzaSyB-v7mDZ8e1GDluhDZrhF_T44GxlJprqr0'; //Juts for demo, create your own API : https://developers.google.com/maps/documentation/javascript/get-api-key
		}
		
		if( empty( $google_key ) ){
			$google_key = 'AIzaSyB-v7mDZ8e1GDluhDZrhF_T44GxlJprqr0'; //Juts for demo, create your own API : https://developers.google.com/maps/documentation/javascript/get-api-key
		}
		
        wp_enqueue_script('jquery-goolge-places', $protolcol.'://maps.googleapis.com/maps/api/js?key='.esc_attr($google_key).'&libraries=places', '', '', true);
		
        wp_enqueue_script('gmap3', get_template_directory_uri() . '/js/gmap3.min.js', array('jquery-ui-autocomplete'), '', true);
    }

}

/**
 * @Init location picker
 * @return 
 */
if (!function_exists('docdirect_enque_locationpicker_library')) {
    function docdirect_enque_locationpicker_library() {
        //wp_enqueue_script('locationpicker', get_template_directory_uri() . '/js/docdir_maps.js', '', '', true);
    }
}

/**
 * @Init Ratings
 * @return 
 */
if (!function_exists('docdirect_enque_rating_library')) {
    function docdirect_enque_rating_library() {
        wp_enqueue_script('jRate', get_template_directory_uri() . '/js/jRate.js', '', '', true);
    }
}

/**
 * Load Dynamic Styles for Theme
 */
if (!function_exists('docdirect_print_css')) {

    function docdirect_print_css() {
        require_once (get_template_directory() . '/inc/theme-styling/dynamic-styles.php');
    }

    add_action('wp_head', 'docdirect_print_css');
}

/* Custom Fonts Icons */

/* Pagination Code Start */
if (!function_exists('docdirect_prepare_pagination')) {

    function docdirect_prepare_pagination($pages = '', $range = 4) {
        global $paged;
        $showitems = ($range * 2) + 1;

        if (empty($paged)) {
            $current_page = 1;
        }

        $current_page = $paged;

        if ($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }
        } else {
            $pages = ceil($pages / $range);
        }

        if (1 != $pages) {
            echo '<nav class="doc-pagination"><ul>';
            if ($current_page > 2 && $current_page > $range + 1 && $showitems < $pages) {
               // echo "<li><a href='" . get_pagenum_link(1) . "'>&laquo; First</a></li>";
            }

            if ($current_page > 1) {
                echo "<li class='tg-previous'><a class='' href='" . get_pagenum_link($current_page - 1) . "'><i class=\"fa fa-angle-left\"></i></a></li>";
            }

            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!($i >= $current_page + $range + 1 || $i <= $current_page - $range - 1) || $pages <= $showitems )) {
                  echo ($paged == $i) ? "<li><a  class='active' href='javascript:;'>" . $i . "</a></li>" : "<li><a href='" . get_pagenum_link($i) . "' class=\"inactive\">" . $i . "</a></li>";
                }
            }

            if ($current_page < $pages) {
                echo "<li class='tg-next'><a  class='' href=\"" . get_pagenum_link($current_page + 1) . "\"><i class=\"fa fa-angle-right\"></i></a></li>";
            }

            if ($current_page < $pages - 1 && $current_page + $range - 1 < $pages && $showitems < $pages) {
              // echo "<li><a href='" . get_pagenum_link($pages) . "'>Last &raquo;</a></li>";
            }
            echo "</ul></nav>";
        }
    }

}


/**
 * @get post thumbnail
 * @return thumbnail url
 */
if (!function_exists('docdirect_prepare_thumbnail')) {

    function docdirect_prepare_thumbnail($post_id, $width = '300', $height = '300') {
        global $post;

        if (has_post_thumbnail()) {
			get_the_post_thumbnail();
            $thumb_id = get_post_thumbnail_id($post_id);
            $thumb_url = wp_get_attachment_image_src($thumb_id, array($width, $height), true);

            if ($thumb_url[1] == $width and $thumb_url[2] == $height) {
                return $thumb_url[0];
            } else {
                $thumb_url = wp_get_attachment_image_src($thumb_id, "full", true);
                return $thumb_url[0];
            }
        }
    }

}

/**
* Get Image Src
* @return 
*/
if (!function_exists('docdirect_get_image_source')) {
	function docdirect_get_image_source($thumb_id='',$width=300,$height=300) {
		$thumb_url = wp_get_attachment_image_src($thumb_id, array( $width, $height ), true);
		if ($thumb_url[1] == $width and $thumb_url[2] == $height) {
			return $thumb_url[0];
		} else {
			$thumb_url = wp_get_attachment_image_src($thumb_id, "full", true);
			return $thumb_url[0];
		}
	}
}

/**
 * @Hook Favicon
 * @return favicon
 */
if (!function_exists('docdirect_get_favicon')) {

    function docdirect_get_favicon() {

        if (!function_exists('has_site_icon') || !has_site_icon()) {
            if (!function_exists('fw_get_db_settings_option')) {
                return;
            } else {
                $docdirect_favicaon = fw_get_db_settings_option('favicon');
                if (isset($docdirect_favicaon['url'])) {
                    echo '<link rel="shortcut icon" href="' . esc_url($docdirect_favicaon['url']) . '">';
                }
            }
        } else {
            docdirect_wp_favicon();
        }
    }

}

/**
 * @get Categories
 * @return categories
 */
if (!function_exists('docdirect_prepare_categories')) {

    function docdirect_prepare_categories($docdirect_post_cat) {
        global $post, $wpdb;

        if (isset($docdirect_post_cat) && $docdirect_post_cat != '' && $docdirect_post_cat != '0') {
            $docdirect_current_category = $wpdb->get_row($wpdb->prepare("SELECT * from $wpdb->terms WHERE slug = %s", $docdirect_post_cat));
            echo '<span class="tg-cats"><i class="fa fa-folder-open"></i><a href="' . esc_url( site_url('/') ) . '?cat=' . $docdirect_current_category->term_id . '">' . $docdirect_current_category->name . '</a></span>';
        } else {
            $before_cat = '<span class="tg-cats"><i class="fa fa-folder-open"></i>';
            $after_cat = '</span>';
            echo get_the_term_list(get_the_id(), 'category', $before_cat, ', ', $after_cat);
        }
    }

}

/**
 * @prepare Custom taxonomies array
 * @return array
 */
if (!function_exists('docdirect_prepare_taxonomies')) {
	function docdirect_prepare_taxonomies( $post_type='post',$taxonomy='category',$hide_empty=1 ,$dataType='',$number='') {
		$args = array(
			'type'                     => $post_type,
			'child_of'                 => 0,
			'parent'                   => '',
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => $hide_empty,
			'hierarchical'             => 1,
			'exclude'                  => '',
			'include'                  => '',
			'number'                   => $number,
			'taxonomy'                 => $taxonomy,
			'pad_counts'               => false 
		
		); 
		
		$categories = get_categories( $args );
		
		if( $dataType == 'array' ){
			return $categories;
		}
			
		$custom_cats	 = array();	
		
		if( isset( $categories ) && !empty( $categories ) ) {
			foreach( $categories as $key => $value ) {
				$custom_cats[$value->term_id]	= $value->name;
			}
		}
		return $custom_cats;
	}
}

/**
 * @Favicon Fallback
 * @return favicon
 */
if (!function_exists('docdirect_wp_favicon')) {

    function docdirect_wp_favicon() {

        if (!has_site_icon() && !is_customize_preview()) {
            return;
        }

        $meta_tags = array(
            sprintf('<link rel="icon" href="%s" sizes="32x32" />', esc_url(get_site_icon_url(32))),
            sprintf('<link rel="icon" href="%s" sizes="192x192" />', esc_url(get_site_icon_url(192))),
            sprintf('<link rel="apple-touch-icon-precomposed" href="%s">', esc_url(get_site_icon_url(180))),
            sprintf('<meta name="msapplication-TileImage" content="%s">', esc_url(get_site_icon_url(270))),
        );

        /**
         * Filter the site icon meta tags, so Plugins can add their own.
         *
         * @since 4.3.0
         *
         * @param array $meta_tags Site Icon meta elements.
         */
        $meta_tags = apply_filters('site_icon_meta_tags', $meta_tags);
        $meta_tags = array_filter($meta_tags);

        foreach ($meta_tags as $meta_tag) {
            echo "$meta_tag\n";
        }
    }

}

/**
 * @get next post
 * @return link
 */
if (!function_exists('docdirect_next_post')) {

    function docdirect_next_post($format) {
        $format = str_replace('href=', 'class="next-post" href=', $format);
        return $format;
    }

    add_filter('next_post_link', 'docdirect_next_post');
}

/**
 * @get next post
 * @return link
 */
if (!function_exists('docdirect_previous_post')) {

    function docdirect_previous_post($format) {
        $format = str_replace('href=', 'class="prev-postt" href=', $format);
        return $format;
    }

    add_filter('previous_post_link', 'docdirect_previous_post');
}


/**
 * @get previous post
 * @return link
 */
if (!function_exists('docdirect_prepare_rev_slider')) {

    function docdirect_prepare_rev_slider() {
        $revsliders[] = esc_html__('Select Slider', 'docdirect');
        if (class_exists('RevSlider')) {
            $slider = new RevSlider();
            $arrSliders = $slider->getArrSliders();
            $revsliders = array();
            if ($arrSliders) {
                foreach ($arrSliders as $key => $slider) {
                    $revsliders[$slider->getId()] = $slider->getAlias();
                }
            }
        }

        return $revsliders;
    }
}

/**
 * @get sliders
 * @return {}
 */
if (!function_exists('docdirect_prepare_sliders')) {

    function docdirect_prepare_sliders() {
        global $post, $product;
        $args = array('posts_per_page' => '-1', 
			'post_type' => 'tg_slider', 
			'orderby' => 'ID', 
			'post_status' => 'publish'
		);
        $cust_query = get_posts($args);

        $sliders[0] = esc_html__('Select Slider', 'docdirect');

        if (isset($cust_query) && is_array($cust_query) && !empty($cust_query)) {
            foreach ($cust_query as $key => $slider) {
                $sliders[$slider->ID] = get_the_title($slider->ID);
            }
        }
        return $sliders;
    }

}

/**
 * @get custom Excerpt
 * @return link
 */
if (!function_exists('docdirect_prepare_custom_excerpt')) {

    function docdirect_prepare_custom_excerpt($more = '...') {
        return '....';
    }

    add_filter('excerpt_more', 'docdirect_prepare_custom_excerpt');
}

/**
 * @get Excerpt
 * @return link
 */
if (!function_exists('docdirect_prepare_excerpt')) {

    function docdirect_prepare_excerpt($charlength = '255', $more = 'true', $text = 'Read More') {
        global $post;
        $excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_content()));
        if (strlen($excerpt) > $charlength) {
            if ($charlength > 0) {
                $excerpt = substr($excerpt, 0, $charlength);
            } else {
                $excerpt = $excerpt;
            }
            if ($more == 'true') {
                $link = '<a href="' . esc_url(get_permalink()) . '" class="tg-more">' . esc_attr($text) . '</a>';
            } else {
                $link = '...';
            }
            echo force_balance_tags($excerpt . $link);
        } else {
            echo force_balance_tags($excerpt);
        }
    }

}

/**
 * @get Excerpt
 * @return link
 */
if (!function_exists('docdirect_prepare_address')) {
	function docdirect_prepare_address($charlength = '255',$excerpt='') {
		if (strlen($excerpt) > $charlength) {
            if ($charlength > 0) {
                $excerpt = substr($excerpt, 0, $charlength).'...';
            } else {
                $excerpt = $excerpt;
            }
			
            return $excerpt;
        }
		
		return $excerpt;
	}
}

/**
 * @Esc Data
 * @return categories
 */
if (!function_exists('docdirect_esc_specialchars')) {

    function docdirect_esc_specialchars($data = '') {
        return $data;
    }

}
/**
 * @Prepare social sharing links
 * @return sizes
 */
if (!function_exists('docdirect_prepare_social_sharing')) {

    function docdirect_prepare_social_sharing($default_icon = 'false', $title = false,$heading = 'Share') {
        docdirect_init_share_script();
        $facebook = esc_html__('Facebook', 'docdirect');
        $twitter = esc_html__('Twitter', 'docdirect');
        $email = esc_html__('E-mail', 'docdirect');
        $tumblr2 = esc_html__('Tumblr', 'docdirect');
        $dribbble2 = esc_html__('Dribbble', 'docdirect');
        $instagram = esc_html__('Instagram', 'docdirect');
        $youtube = esc_html__('Youtube', 'docdirect');


        if (function_exists('fw_get_db_post_option')) {
            $social_facebook = fw_get_db_settings_option('social_facebook');
            $social_twitter = fw_get_db_settings_option('social_twitter');
            $social_email = fw_get_db_settings_option('social_email');
            $social_tumbler = fw_get_db_settings_option('social_tumbler');
            $social_dribble = fw_get_db_settings_option('social_dribble');
            $social_instagram = fw_get_db_settings_option('social_instagram');
            $social_youtube = fw_get_db_settings_option('social_youtube');
        } else {
            $social_facebook = 'enable';
            $social_twitter  = 'enable';
            $social_email 	 = 'enable';
            $social_tumbler  = '';
            $social_dribble  = '';
            $social_instagram = '';
            $social_youtube   = '';
        }

        $output = '';
        if( $title ==  true ) {
			$output .='<strong>'.$heading.'</strong>';
		}
		$output .='<ul class="tg-socialicon">';
        if (isset($social_facebook) && $social_facebook == 'enable') {
            $output .='<li class="facebook"><a class="addthis_button_facebook" data-original-title="' . $facebook . '"><i class="fa fa-facebook"></i></a></li>';
        }
        if (isset($social_twitter) && $social_twitter == 'enable') {
            $output .='<li class="twitter"><a class="addthis_button_twitter" data-original-title="' . $twitter . '"><i class="fa fa-twitter"></i></a></li>';
        }
        if (isset($social_email) && $social_email == 'enable') {
            $output .='<li class="google"><a class="addthis_button_google" data-original-title="' . $email . '"><i class="fa fa-google-plus"></i></a></li>';
        }
        if (isset($social_tumbler) && $social_tumbler == 'enable') {
            $output .='<li class="tumblr"><a class="addthis_button_tumblr" data-original-title="' . $tumblr2 . '"><i class="fa fa-tumblr"></i></a></li>';
        }
        if (isset($social_dribble) && $social_dribble == 'enable') {
            $output .='<li class="dribbble" ><a class="addthis_button_dribbble" data-original-title="' . $dribbble2 . '"><i class="fa fa-dribbble"></i></a></li>';
        }
        if (isset($social_instagram) && $social_instagram == 'enable') {
            $output .='<li class="instagram"><a class="addthis_button_instagram" data-original-title="' . $instagram . '"><i class="fa fa-instagram"></i></a></li>';
        }
        if (isset($social_youtube) && $social_youtube == 'enable') {
            $output .='<li class="youtube"><a class="addthis_button_youtube" data-original-title="' . $youtube . '"><i class="fa fa-youtube"></i></a></li>';
        }
        $output .='</ul>';
        echo balanceTags($output, true);
    }

}

/**
 * @Custom post types
 * @return {}
 */
if (!function_exists('docdirect_prepare_custom_posts')) {

    function docdirect_prepare_custom_posts($post_type = 'post') {
        $posts_array = array();
		
		
		$args = array('posts_per_page' => "-1", 
			'post_type' => $post_type, 
			'order' => 'DESC', 
			'orderby' => 'ID', 
			'post_status' => 'publish', 
			'ignore_sticky_posts' => 1,
			'suppress_filters' => false
		);

        $posts_query = get_posts($args);
		
		$posts_array	=  array();
		$posts_array['all'] = esc_html__('All','docdirect');
        
		foreach ($posts_query as $value) :
            $posts_array[$value->ID] = $value->post_title;
        endforeach;

		return $posts_array;
        
    }

}


/**
 * @SSL Verify
 * @return {}
 */
if (!function_exists('docdirect_get_page_by_slug')) {

    function docdirect_get_page_by_slug($slug='',$post_type='post',$return='id') {
        $args	= array(
			'name'           => $slug,
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => 1
		);
		
		$post_data = get_posts( $args );
		
		if( !empty( $post_data ) ) {
			return (int)$post_data[0]->ID;
		}
		
		return false;
    }

}

/**
 * @SSL Verify
 * @return {}
 */
if (!function_exists('docdirect_no_ssl_http_request_args')) {
    add_action('http_request_args', 'docdirect_no_ssl_http_request_args', 10, 2);

    function docdirect_no_ssl_http_request_args($args, $url) {
        $args['sslverify'] = false;
        return $args;
    }

}

/**
 * @Set Post Views
 * @return {}
 */
if(!function_exists('docdirect_post_views')){
	function docdirect_post_views( $post_id='' ) {
		if ( !isset($_COOKIE["set_blog_view".$post_id]) ){
			setcookie("set_blog_view".$post_id, 'post_view_count', time()+3600);
			$view_key = 'set_blog_view';
			
			$count = get_post_meta($post_id, $view_key, true);
			
			if($count==''){
				$count = 0;
				delete_post_meta($post_id, $view_key);
				add_post_meta($post_id, $view_key, '0');
			}else{
				$count++;
				update_post_meta($post_id, $view_key, $count);
			}
		}
	}
}

/**
 * @Get Post Views
 * @return {}
 */
if(!function_exists('docdirect_get_post_views')){
	function docdirect_get_post_views($post_id){
		$view_key = 'set_blog_view';
		$count = get_post_meta($post_id, $view_key, true);
		if( $count=='' ){
			delete_post_meta($post_id, $view_key);
			add_post_meta($post_id, $view_key, '0');
			return "0 ";
		}
	 return number_format($count);
	}
}

/**
 * @Get Post Views
 * @return {}
 */
if(!function_exists('docdirect_get_users')){
	function docdirect_get_users(){
		$users['']	= 'Select Organizer';
		$site_users = get_users('orderby=nicename');
		foreach ($site_users as $user) {
			$users[$user->ID]	= $user->display_name;
		}
		return $users;
	}
}

/**
 * @User Public Profile Save
 * @return {}
 */
if (!function_exists('docdirect_get_post_name')) {
    function docdirect_get_post_name( $returnClass	= 'false' ) {
		global $post;
		$post_name	= '';
		if(isset($post)){ $post_name = $post->post_name;  }else{ $post_name = ''; }

		return $post_name;
		
    }
}

/**
 * @User Public Profile Save
 * @return {}
 */
if (!function_exists('docdirect_comingsoon_background')) {
    function docdirect_comingsoon_background() {
		$background_comingsoon	= '';
		if (function_exists('fw_get_db_post_option')) {
			$background = fw_get_db_settings_option('background');
			if( isset( $background['url'] ) && !empty( $background['url'] ) ){
				//Do Nothing
			} else{
				$background['url']	= get_template_directory_uri().'/images/bg-commingsoon.jpg';
			}
			
		} else {
			$background['url'] = get_template_directory_uri().'/images/bg-commingsoon.jpg';
		}

		if( isset( $background['url'] ) && !empty( $background['url'] ) ) {
			$background_comingsoon	= $background['url'];;
		}
		
		return $background_comingsoon;
    }
}

/**
 * @Language Handler
 * @return {sub menu class}
 */
add_action( 'fw_ext_translation_change_render_language_switcher', function ( $html, $frontend_urls ) {
    $html = '';
	//fw_print($frontend_urls);
    foreach ( $frontend_urls as $lang_code => $url ) {
		$html .= '<li><a href="' . esc_attr($url) . '"><img src="'.fw_ext_translation_get_flag( $lang_code ).'" alt="'.esc_attr__('Language','docdirect').'"><span>' . $lang_code . '</span></a></li>';
    }
    return $html;
}, 10, 2 );


/**
 * @Naigation Filter
 * @return {sub menu class}
 */
if (!function_exists('docdirect_submenu_class')) {
    function docdirect_submenu_class($menu) {
		$menu = preg_replace('/ class="sub-menu"/', ' class=""', $menu);
        return $menu;
    }
    add_filter('wp_nav_menu', 'docdirect_submenu_class');
}

/**
 *@ Uniqueue ID
 *@ return {}
 */
if (!function_exists('docdirect_unique_increment')) {
	function docdirect_unique_increment($length = 5) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
}
/**
 * Get Featured Products
 */
if (!function_exists('docdirect_prepare_featured_products')) {

    function docdirect_prepare_featured_products() {
        $featured_posts = array();
        if (class_exists('woocommerce')) {
            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => -1,
                'meta_query' => array(
                    // get only products marked as featured
                    array(
                        'key' => '_featured',
                        'value' => 'yes'
                    )
                )
            );
            $fetaured_query = get_posts($args);
            if (isset($fetaured_query) && !empty($fetaured_query)) {
                foreach ($fetaured_query as $featured_products) {
                    $featured_posts[$featured_products->ID] = $featured_products->post_title;
                }
            }
        }
        return $featured_posts;
    }

}

/**
 * @Custom Title Linking
 * @return {}
 */
if (!function_exists('docdirect_get_registered_sidebars')) {
    function docdirect_get_registered_sidebars() {
		global $wp_registered_sidebars;
		$sidebars	= array();
		foreach( $wp_registered_sidebars as $key => $sidebar ){
			$sidebars[$key]	= $sidebar['name'];
		}
		return $sidebars;
	}
}

/**
 * @Logout
 * @return sizes
 */
if (!function_exists('docdirect_destroy_custom_session')) {
	function docdirect_destroy_custom_session() {
		//session_destroy();
	}
	add_action('wp_logout', 'docdirect_destroy_custom_session');
}


/**
 * @Add Images Sizes
 * @return sizes
 */
add_image_size('docdirect_user_banner', 1920, 450, true);
add_image_size('docdirect_blog_detail', 1170, 400, true);
add_image_size('docdirect_blog_list', 470, 305, true);
add_image_size('docdirect_blog_grid', 375, 305, true);
add_image_size('docdirect_user_profile_grid', 370, 200, true);
add_image_size('docdirect_profile_detail', 365, 365, true);
add_image_size('docdirect_user_featured', 275, 191, true);
add_image_size('docdirect_user_profile', 270, 270, true);
add_image_size('docdirect_review_user', 140, 89, true);