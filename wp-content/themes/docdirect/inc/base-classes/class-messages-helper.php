<?php
/**
* @ Notification Helper
* @ return String
* @ 
*/

if( !class_exists( 'DoctorDirectory_NotificationsHelper' ) ) {
	class DoctorDirectory_NotificationsHelper{
		
		public $message;
		
		public function __construct() {
			// Do Something here..
		}
		
		/**
		 * @Doctor Directory
		 * $return {HTML}
		 */
		public static function success( $message = 'No recored found' ) {
			global $post;
			
			$output	 = '';
			$output	.= '<div class="col-md-12 theme-notification message-success alert alert-success" role="alert"><p>';
			$output	.= $message;
			$output	.= '</p></div>';
			
			echo force_balance_tags ( $output ); 		
		}
		
		/**
		 * @Errors
		 * $return {HTML}
		 */
		public static function error( $message='No recored found' ) {
		   global $post;
		   $output	 = '';
		   $output	.= '<div class="col-md-12 theme-notification message-warning alert alert-danger"><p>'.$message.'</p></div>';
		  
		   echo force_balance_tags ( $output ); 	
		
		}
	  
	  	/**
		 * @Warnings
		 * $return {HTML}
		 */
		public static function warning( $message='No recored found' ) {
		  global $post;	
			
		  $output	 = '';
		  $output	.= '<div class="col-md-12 theme-notification message-warning alert alert-warning" role="alert"><p>';
		  $output	.= $message;
		  $output	.= '</p></div>';
		 
		 echo force_balance_tags ( $output ); 
		}
		
		/**
		 * @Infomation
		 * $return {HTML}
		 */
		public static function informations($message='No recored found') { 
		  global $post;
		 
		  $output	 = '';
		  $output	.= '<div class="col-md-12 theme-notification message-informations alert alert-info"  role="alert"><p>';
		  $output	.= $message;
		  $output	.= '</p></div>';
		 
		 echo force_balance_tags ( $output ); 
		
		}
	}
	new DoctorDirectory_NotificationsHelper();
}
?>