<?php
/**
 * File Type: Events
 */
if( ! class_exists('TG_CoreBase') ) {
	
	class TG_CoreBase {
		
		protected static $instance = null;
		 
		public function __construct() {
			 add_action('save_post', array($this, 'tg_save_meta_data'));
		}
		
		
		/**
		 * Returns the *Singleton* instance of this class.
		 *
		 * @return Singleton The *Singleton* instance.
		 */
        public static function getInstance() {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }
		
		/**
		 * Save Meta options Slider
		 * @return 
		 */
        public function tg_save_meta_data($post_id='') {
            
			if (!is_admin()) { return;}
			
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return;}
			
			if ( get_post_type() == 'tg_slider' ) {
				if (!function_exists('fw_get_db_post_option')) { return;}
				$data_shortcode	= '[themographics_slider id="'.$post_id.'"]';
				if (isset($_POST['fw_options'])) {
					 update_post_meta($post_id, 'tg_shortcode', $data_shortcode); //exit;
				}
			}
			
			if ( get_post_type() == 'docdirectreviews' ) {
				if (!function_exists('fw_get_db_post_option')) { return;}
				if (isset($_POST['fw_options'])) {
					foreach( $_POST['fw_options'] as $key => $value ){
						update_post_meta($post_id, $key, $value); //exit;
					}
				}
			}
			
			//update specialities
			if ( get_post_type() == 'directory_type' ) {
				update_post_meta($post_id, 'attached_specialities', $_POST['fw_options']['specialities']); //exit;
			}
        }
		
		/**
		 * Sanitize
		 * @return 
		 */
        public static function tg_esc_specialchars($data='') {
			return $data;
		}
	}
	
  	new TG_CoreBase();	
}