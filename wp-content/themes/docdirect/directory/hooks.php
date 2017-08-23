<?php
/**
 *  Hooks For user Profile
 */



/**
 * @Update Schedules
 * @return {}
 */
if ( ! function_exists( 'docdirect_update_schedules' ) ) {
	function docdirect_update_schedules(){ 
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;
		$json	= array();

		update_user_meta( $user_identity, 'schedules', $_POST['schedules'] );
		
		//Time Formate
		if( !empty( $_POST['time_format'] ) ){
			update_user_meta( $user_identity, 'time_format', esc_attr( $_POST['time_format'] ) );
		}
		
		$json['type']	= 'success';
		$json['message']	= esc_html__('Schedules Updated.','docdirect');
		echo json_encode($json);
		die;
	}
	add_action('wp_ajax_docdirect_update_schedules','docdirect_update_schedules');
	add_action( 'wp_ajax_nopriv_docdirect_update_schedules', 'docdirect_update_schedules' );
}

/**
 * @Validaet Email
 * @return {}
 */
if ( ! function_exists( 'docdirect_save_privacy_settings' ) ) {
	function docdirect_save_privacy_settings(){ 
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;
		$json	= array();

		update_user_meta( $user_identity, 'privacy', $_POST['privacy'] );
		
		//update privacy for search
		if( !empty( $_POST['privacy'] ) ) {
			foreach( $_POST['privacy'] as $key => $value ) {
				update_user_meta( $user_identity, $key, $value );
			}
		}
		
		$json['type']	= 'success';
		$json['message']	= esc_html__('Privacy Settings Updated.','docdirect');
		echo json_encode($json);
		die;
	}
	add_action('wp_ajax_docdirect_save_privacy_settings','docdirect_save_privacy_settings');
	add_action( 'wp_ajax_nopriv_docdirect_save_privacy_settings', 'docdirect_save_privacy_settings' );
}

/**
 * @Account Settings
 * @return {}
 */
if ( ! function_exists( 'docdirect_account_settings' ) ) {
	function docdirect_account_settings(){ 
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;
		
		//Update Socials
		if( isset( $_POST['socials'] ) && !empty( $_POST['socials'] ) ){
			foreach( $_POST['socials'] as $key=>$value ){
				update_user_meta( $user_identity, $key, esc_attr( $value ) );
			}
		}
		
		$first_name	= '';
		$last_name	= '';
		
		//Update Basics
		if( isset( $_POST['basics'] ) && !empty( $_POST['basics'] ) ){
			foreach( $_POST['basics'] as $key => $value ){
				if( $key === 'first_name' ){
					$first_name	= $value;
				} else if( $key === 'last_name' ){
					$last_name	= $value;
				}
				
				update_user_meta( $user_identity, $key, esc_attr( $value ) );
			}
		}

		//Professional Statements
		if( !empty( $_POST['professional_statements'] ) ){
			update_user_meta( $user_identity, 'professional_statements', $_POST['professional_statements']);
		}
		
		//update username
		$username	= trim( $first_name.' '.$last_name );
		update_user_meta( $user_identity, 'username', esc_attr( $username ) );
		
		//Update General settings
		
		update_user_meta( $user_identity, 'video_url', esc_attr( $_POST['video_url'] ) );
		wp_update_user( array( 'ID' => $user_identity, 'user_url' => esc_attr($_POST['basics']['user_url']) ) );
		
		//Awards
		$awards	= array();
		if( isset( $_POST['awards'] ) && !empty( $_POST['awards'] ) ){
			
			$counter	= 0;
			foreach( $_POST['awards'] as $key=>$value ){
				$awards[$counter]['name']	= esc_attr( $value['name'] ); 
				$awards[$counter]['date']	= esc_attr( $value['date'] );
				$awards[$counter]['date_formated']	= date('d M, Y',strtotime($value['date']));  
				$awards[$counter]['description']	  = esc_attr( $value['description'] ); 
				$counter++;
			}
			$json['awards']	= $awards;
		}
		update_user_meta( $user_identity, 'awards', $awards );
		
		//Gallery
		$user_gallery	= array();
		if( isset( $_POST['user_gallery'] ) && !empty( $_POST['user_gallery'] ) ){
			$counter	= 0;
			foreach( $_POST['user_gallery'] as $key=>$value ){
				$user_gallery[$value['attachment_id']]['url']	= esc_url( $value['url'] ); 
				$user_gallery[$value['attachment_id']]['id']	= esc_attr( $value['attachment_id']); 
				$counter++;
			}
		}
		update_user_meta( $user_identity, 'user_gallery', $user_gallery );
		
		//Specialities
		$db_directory_type	 = get_user_meta( $user_identity, 'directory_type', true);
		if( isset( $db_directory_type ) && !empty( $db_directory_type ) ) {
			$specialities_list	 = docdirect_prepare_taxonomies('directory_type','specialities',0,'array');
		}
		
		$specialities	= array();
		if( isset( $specialities_list ) && !empty( $specialities_list ) ){
			$counter	= 0;
			foreach( $specialities_list as $key => $speciality ){
				if( isset( $_POST['specialities'] ) && in_array( $speciality->slug, $_POST['specialities'] ) ){
					update_user_meta( $user_identity, $speciality->slug, $speciality->slug );
					$specialities[$speciality->slug]	= $speciality->name;
				}else{
					update_user_meta( $user_identity, $speciality->slug, '' );
				}
				
				$counter++;
			}
		}
		
		update_user_meta( $user_identity, 'user_profile_specialities', $specialities );
		
		//Education
		$educations	= array();
		if( isset( $_POST['education'] ) && !empty( $_POST['education'] ) ){
			$counter	= 0;
			foreach( $_POST['education'] as $key=>$value ){
				if( !empty( $value['title'] ) && !empty( $value['institute'] ) ) {
					$educations[$counter]['title']	= 	esc_attr( $value['title'] ); 
					$educations[$counter]['institute']	 = 	esc_attr( $value['institute'] ); 
					$educations[$counter]['start_date']	= 	esc_attr( $value['start_date'] ); 
					$educations[$counter]['end_date']	  = 	esc_attr( $value['end_date'] ); 
					$educations[$counter]['start_date_formated']  = date('M,Y',strtotime($value['start_date'])); 
					$educations[$counter]['end_date_formated']	= date('M,Y',strtotime($value['end_date'])); 
					$educations[$counter]['description']	= 	esc_attr( $value['description'] ); 
					$counter++;
				}
			}
			$json['education']	= $educations;
		}
		update_user_meta( $user_identity, 'education', $educations );
		
		//Experience
		$experiences	= array();
		if( !empty( $_POST['experience'] ) ){
			$counter	= 0;
			foreach( $_POST['experience'] as $key=>$value ){
				if( !empty( $value['title'] ) && !empty( $value['company'] ) ) {
					$experiences[$counter]['title']	= 	esc_attr( $value['title'] ); 
					$experiences[$counter]['company']	 = 	esc_attr( $value['company'] ); 
					$experiences[$counter]['start_date']	= 	esc_attr( $value['start_date'] ); 
					$experiences[$counter]['end_date']	  = 	esc_attr( $value['end_date'] ); 
					$experiences[$counter]['start_date_formated']  = date('M,Y',strtotime($value['start_date'])); 
					$experiences[$counter]['end_date_formated']	= date('M,Y',strtotime($value['end_date'])); 
					$experiences[$counter]['description']	= 	esc_attr( $value['description'] ); 
					$counter++;
				}
			}
			$json['experience']	= $experiences;
		}
		update_user_meta( $user_identity, 'experience', $experiences );
		
		//Languages
		$languages	= array();
		if( isset( $_POST['language'] ) && !empty( $_POST['language'] ) ){
			$counter	= 0;
			foreach( $_POST['language'] as $key=>$value ){
				$languages[$value]	= 	$value; 
				$counter++;
			}
		}
		update_user_meta( $user_identity, 'languages', $languages );
		
		
		//Insurance
		$insurance	= array();
		if( isset( $_POST['insurance'] ) && !empty( $_POST['insurance'] ) ){
			$counter	= 0;
			foreach( $_POST['insurance'] as $key=>$value ){
				$insurance[$value]	= 	$value; 
				$counter++;
			}
			
			$insurance	= array_filter($insurance);
		}
		
		update_user_meta( $user_identity, 'insurance', $insurance );
		
		$json['type']	= 'success';
		$json['message']	= esc_html__('Settings saved.','docdirect');
		echo json_encode($json);
		die;
	}
	add_action('wp_ajax_docdirect_account_settings','docdirect_account_settings');
	add_action( 'wp_ajax_nopriv_docdirect_account_settings', 'docdirect_account_settings' );
}

/**
 * @Delete Avatar
 * @return {}
 */
if ( ! function_exists( 'docdir_delete_avatar' ) ) {
	function docdir_delete_avatar() {
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;
		$json	=  array();
		
		$update_avatar = update_user_meta($user_identity, 'userprofile_media', '');
		if($update_avatar){
			$json['avatar'] = get_template_directory_uri().'/images/user270x270.jpg';
			$json['type']		=  'success';	
			$json['message']		= esc_html__('Avatar deleted.','docdirect');	
		} else {
			$json['type']		=  'error';	
			$json['message']		= esc_html__('Some error occur, please try again later.','docdirect');	
		}
		echo json_encode($json);
		exit;
	}
	add_action('wp_ajax_docdir_delete_avatar', 'docdir_delete_avatar');
	add_action('wp_ajax_nopriv_docdir_delete_avatar', 'docdir_delete_avatar');
}

/**
 * @Delete banner
 * @return {}
 */
if ( ! function_exists( 'docdir_delete_user_banner' ) ) {
	function docdir_delete_user_banner() {
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;
		$json	=  array();
		
		$update_avatar = update_user_meta($user_identity, 'userprofile_banner', '');
		if($update_avatar){
			$json['avatar'] = get_template_directory_uri().'/images/user270x270.jpg';
			$json['type']		=  'success';	
			$json['message']		= esc_html__('Banner deleted.','docdirect');	
		} else {
			$json['type']		=  'error';	
			$json['message']		= esc_html__('Some error occur, please try again later.','docdirect');	
		}
		echo json_encode($json);
		exit;
	}
	add_action('wp_ajax_docdir_delete_user_banner', 'docdir_delete_user_banner');
	add_action('wp_ajax_nopriv_docdir_delete_user_banner', 'docdir_delete_user_banner');
}

/**
 * @Delete Email Logo
 * @return {}
 */
if ( ! function_exists( 'docdir_delete_email_logo' ) ) {
	function docdir_delete_email_logo() {
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;
		$json	=  array();
		
		$update_avatar = update_user_meta($user_identity, 'email_media', '');
		
		if($update_avatar){
			$json['avatar'] = get_template_directory_uri().'/images/user150x150.jpg';
			$json['type']		=  'success';	
			$json['message']		= esc_html__('Logo deleted.','docdirect');	
		} else {
			$json['type']		=  'error';	
			$json['message']		= esc_html__('Some error occur, please try again later.','docdirect');	
		}
		
		echo json_encode($json);
		exit;
	}
	add_action('wp_ajax_docdir_delete_email_logo', 'docdir_delete_email_logo');
	add_action('wp_ajax_nopriv_docdir_delete_email_logo', 'docdir_delete_email_logo');
}

/**
 * @Delete Email Logo
 * @return {}
 */
if ( ! function_exists( 'docdir_update_booking_settings' ) ) {
	function docdir_update_booking_settings() {
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;
		
		update_user_meta( $user_identity, 'confirmation_title', $_POST['confirmation_title'] );
		update_user_meta( $user_identity, 'approved_title', $_POST['approved_title'] );
		update_user_meta( $user_identity, 'cancelled_title', $_POST['cancelled_title'] );
		
		update_user_meta( $user_identity, 'booking_cancelled', $_POST['booking_cancelled'] );
		update_user_meta( $user_identity, 'booking_confirmed', $_POST['booking_confirmed'] );
		update_user_meta( $user_identity, 'booking_approved', $_POST['booking_approved'] );
		update_user_meta( $user_identity, 'schedule_message', $_POST['schedule_message'] );
		update_user_meta( $user_identity, 'currency', $_POST['currency'] );
		update_user_meta( $user_identity, 'currency_symbol', $_POST['currency_symbol'] );
		update_user_meta( $user_identity, 'thank_you', $_POST['thank_you'] );
		
		update_user_meta( $user_identity, 'paypal_enable', $_POST['paypal_enable'] );
		update_user_meta( $user_identity, 'paypal_email_id', $_POST['paypal_email_id'] );
		update_user_meta( $user_identity, 'stripe_enable', $_POST['stripe_enable'] );
		update_user_meta( $user_identity, 'stripe_secret', $_POST['stripe_secret'] );
		update_user_meta( $user_identity, 'stripe_publishable', $_POST['stripe_publishable'] );
		update_user_meta( $user_identity, 'stripe_site', $_POST['stripe_site'] );
		update_user_meta( $user_identity, 'stripe_decimal', $_POST['stripe_decimal'] );
		
		$json['type']		=  'success';	
		$json['message']		= esc_html__('Booking settings updated.','docdirect');	

		echo json_encode($json);
		exit;
	}
	add_action('wp_ajax_docdir_update_booking_settings', 'docdir_update_booking_settings');
	add_action('wp_ajax_nopriv_docdir_update_booking_settings', 'docdir_update_booking_settings');
}

/**
 * @UPdate Avatar
 * @return {}
 */
if ( ! function_exists( 'docdirect_image_uploader' ) ) {
	function docdirect_image_uploader() {
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;
		
		$nonce = $_REQUEST[ 'nonce' ];
		$type = $_REQUEST[ 'type' ];
		
		if ( ! wp_verify_nonce( $nonce, 'docdirect_upload_nounce' ) ) {
			$ajax_response = array(
				'success' => false,
				'reason' => 'Security check failed!',
			);
			echo json_encode( $ajax_response );
			die;
		}
		
		$submitted_file = $_FILES[ 'docdirect_uploader' ];
		$uploaded_image = wp_handle_upload( $submitted_file, array( 'test_form' => false ) ); 

		if ( isset( $uploaded_image[ 'file' ] ) ) {
			$file_name = basename( $submitted_file[ 'name' ] );
			$file_type = wp_check_filetype( $uploaded_image[ 'file' ] );

			// Prepare an array of post data for the attachment.
			$attachment_details = array(
				'guid' => $uploaded_image[ 'url' ],
				'post_mime_type' => $file_type[ 'type' ],
				'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
				'post_content' => '',
				'post_status' => 'inherit'
			);

			$attach_id = wp_insert_attachment( $attachment_details, $uploaded_image[ 'file' ] ); 
			$attach_data = wp_generate_attachment_metadata( $attach_id, $uploaded_image[ 'file' ] ); 
			wp_update_attachment_metadata( $attach_id, $attach_data );                                    
			
			//Image Size
			$image_size	= 'thumbnail';
			if( isset( $type ) && $type === 'profile_image' ){
				$image_size	= 'docdirect_user_profile';
			} if( isset( $type ) && $type === 'profile_banner' ){
				$image_size	= 'docdirect_user_banner';
				docdirect_get_profile_image_url( $attach_data,$image_size ); //get image url
				$image_size	= 'docdirect_user_profile';
			} else if( isset( $type ) && $type === 'user_gallery' ){
				$image_size	= 'thumbnail';
			}
			
			
			$thumbnail_url = docdirect_get_profile_image_url( $attach_data,$image_size ); //get image url

			if( isset( $type ) && $type === 'profile_image' ){
				update_user_meta($user_identity, 'userprofile_media', $attach_id);
			} if( isset( $type ) && $type === 'profile_banner' ){
				update_user_meta($user_identity, 'userprofile_banner', $attach_id);
			} else if( isset( $type ) && $type === 'email_image' ){
				update_user_meta($user_identity, 'email_media', $attach_id);
			} else if( isset( $type ) && $type === 'user_gallery' ){
				//
			}
			
			$ajax_response = array(
				'success' => true,
				'url' => $thumbnail_url,
				'attachment_id' => $attach_id
			);

			echo json_encode( $ajax_response );
			die;

		} else {
			$ajax_response = array( 'success' => false, 'reason' => 'Image upload failed!' );
			echo json_encode( $ajax_response );
			die;
		}
	}
	add_action('wp_ajax_docdirect_image_uploader', 'docdirect_image_uploader');
	add_action('wp_ajax_nopriv_docdirect_image_uploader', 'docdirect_image_uploader');
}


if ( ! function_exists( 'docdirect_get_profile_image_url' ) ) {
	/**
	 * Get thumbnail url based on attachment data
	 *
	 * @param $attach_data
	 * @return string
	 */
	function docdirect_get_profile_image_url( $attach_data,$image_size='thumbnail' ) {
		$upload_dir = wp_upload_dir();
		$image_path_data = explode( '/', $attach_data[ 'file' ] );
		$image_path_array = array_slice( $image_path_data, 0, count( $image_path_data ) - 1 );
		$image_path = implode( '/', $image_path_array );
		$thumbnail_name = null;
		
		if ( isset( $attach_data[ 'sizes' ][ $image_size ] ) ) {
			$thumbnail_name = $attach_data[ 'sizes' ][ $image_size ][ 'file' ];
		} else {
			if( isset( $attach_data[ 'sizes' ][ 'thumbnail' ][ 'file' ] ) ) {
				$thumbnail_name = $attach_data[ 'sizes' ][ 'thumbnail' ][ 'file' ];//if size exist
			} else{
				$thumbnail_name = $image_path_data[2];//
			}
		}
		return $upload_dir[ 'baseurl' ] . '/' . $image_path . '/' . $thumbnail_name;
	}
}

/**
 * Delete Gallery Image
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'docdir_delete_gallery_image' ) ) {
	function docdir_delete_gallery_image() {
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;
		
		$id	= 
		$json	=  array();
		
		$gallery	= get_the_author_meta('user_gallery',$user_identity);
		if( isset( $_POST['id'] ) && isset( $gallery[$_POST['id']] ) ){
			unset($gallery[$_POST['id']]);
			
			update_user_meta( $user_identity, 'user_gallery', $gallery );
			
			$json['type']		=  'success';	
			$json['message']		= esc_html__('Image deleted.','docdirect');	
		} else {
			$json['type']		=  'error';	
			$json['message']		= esc_html__('Some error occur, please try again later.','docdirect');	
		}
		
		echo json_encode($json);
		exit;
	}
	add_action('wp_ajax_docdir_delete_gallery_image', 'docdir_delete_gallery_image');
	add_action('wp_ajax_nopriv_docdir_delete_gallery_image', 'docdir_delete_gallery_image');
}

/**
 * Update User Password
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'docdir_change_user_password' ) ) {
	function docdir_change_user_password() {
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;
		$json	=  array();
		
		$user = wp_get_current_user(); //trace($user);
    	$is_password = wp_check_password( $_POST['old_passowrd'], $user->user_pass, $user->data->ID );
		
		if( $is_password ){
		
			if ( empty($_POST['new_passowrd'] ) || empty( $_POST['confirm_password'] ) ) {
				$json['type']		=  'error';	
				$json['message']		= esc_html__('Please add your new password.','docdirect');	
				echo json_encode($json);
				exit;
			}
			
			if ( $_POST['new_passowrd'] == $_POST['confirm_password'] ) {
				wp_update_user( array( 'ID' => $user_identity, 'user_pass' => esc_attr( $_POST['new_passowrd'] ) ) );
				$json['type']		=  'success';	
				$json['message']		= esc_html__('Password Updated.','docdirect');	
			} else {
				$json['type']		=  'error';	
				$json['message']		= esc_html__('The passwords you entered do not match. Your password was not updated', 'docdirect');
			}
		} else{
			$json['type']		=  'error';	
			$json['message']		= esc_html__('Old Password doesn\'t match the existing password', 'docdirect');
		}
		
		echo json_encode($json);
		exit;
	}
	add_action('wp_ajax_docdir_change_user_password', 'docdir_change_user_password');
	add_action('wp_ajax_nopriv_docdir_change_user_password', 'docdir_change_user_password');
}

/**
 * @Check user existance
 * @return 
 */
if (!function_exists('docdirect_do_check_user_existance')) {
	function docdirect_do_check_user_existance($user){
		global $current_user, $wp_roles,$userdata,$post,$wpdb;
		$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE ID = %d", $user));

		if( $count == 1 ){
			$profile_status = get_user_meta($user , 'profile_status' , true);
			if( $profile_status == 'active'){
				return true; 
			} else if( $current_user->ID == $user ){
				return true; 
			} else{
				return false; 
			}
		}else{ 
			return false; 
		}
	}
	add_filter( 'docdirect_do_check_user_existance', 'docdirect_do_check_user_existance', 10, 3 );
}

/**
 * Profile hits
 *
 * @param numeric value
 * @return string
 */
if ( ! function_exists( 'docdirect_update_profile_hits' ) ) {
	function docdirect_update_profile_hits($user_identity='') {
		global $current_user, $wp_roles,$userdata,$post;
		if( apply_filters( 'docdirect_do_check_user_existance', $user_identity ) ){
			if(isset($user_identity) && $user_identity <> ''){
				$profile_hits = get_user_meta($user_identity , 'profile_hits' , true);
				
				$year	 = date('y');
				$month	= date('m');
				$profile_hits_year	= array();
				
				$months_array	= docdirect_get_month_array(); //Get Month  Array
				
				if( isset( $profile_hits[$year] ) ){
					$profile_hits = get_user_meta($user_identity , 'profile_hits' , true);
					if ( isset($_COOKIE["profile_hits_" . $user_identity]) ) { 
						//Cookie already set, nothing to do
					} else{
						setcookie("profile_hits_" . $user_identity , 'profile_hits' , time() + 3600);
						$profile_hits = get_user_meta($user_identity , 'profile_hits' , true);
						if( isset( $profile_hits[$year][$month] ) ){
							$profile_hits[$year][$month]++;
						} else{
							$profile_hits[$year][$month] = 1;
						}
						update_user_meta( $user_identity, 'profile_hits', $profile_hits );
						update_user_meta( $user_identity, 'profile_hits_count', $profile_hits );
					}
				} else{
					foreach( $months_array as $key => $value ){
						$profile_hits_year[$year][$key]	= 0;
					}
					
					if( isset( $profile_hits ) && !empty( $profile_hits ) ) {
						$profile_hits	= $profile_hits + $profile_hits_year;
					} else{
						$profile_hits	= $profile_hits_year;
					}
					
					if ( isset($_COOKIE["profile_hits_" . $user_identity]) ) {
						//Cookie already set
					} else{
						setcookie("profile_hits_" . $user_identity , 'profile_hits' , time() + 3600);
						$profile_hits = get_user_meta($user_identity , 'profile_hits' , true);

						if( isset( $profile_hits[$year][$month] ) ) {
							$profile_hits[$year][$month]++;
						}else{
							$profile_hits[$year][$month] = 1;
						}
					}
	
					update_user_meta( $user_identity, 'profile_hits', $profile_hits );
				}
			}
		}
	}
	add_action('docdirect_update_profile_hits','docdirect_update_profile_hits',5,2);
}

/**
 * Get Month Array
 *
 * @param numeric value
 * @return string
 */
if ( ! function_exists( 'docdirect_get_month_array' ) ) {
	function docdirect_get_month_array() {
		return array(
			'01'	=> esc_html__('January','docdirect'),
			'02'	=> esc_html__('February','docdirect'),
			'03'	=> esc_html__('March','docdirect'),
			'04'	=> esc_html__('April','docdirect'),
			'05'	=> esc_html__('May','docdirect'),
			'06'	=> esc_html__('June','docdirect'),
			'07'	=> esc_html__('July','docdirect'),
			'08'	=> esc_html__('August','docdirect'),
			'09'	=> esc_html__('September','docdirect'),
			'10'	=> esc_html__('October','docdirect'),
			'11'	=> esc_html__('November','docdirect'),
			'12'	=> esc_html__('December','docdirect'),
		);
	}
}

/**
 * Get Week Array
 *
 * @param numeric value
 * @return string
 */
if ( ! function_exists( 'docdirect_get_week_array' ) ) {
	function docdirect_get_week_array() {
		return array(
			'sun'	=> esc_html__('Sunday','docdirect'),
			'mon'	=> esc_html__('Monday','docdirect'),
			'tue'	=> esc_html__('Tuesday','docdirect'),
			'wed'	=> esc_html__('Wednesday','docdirect'),
			'thu'	=> esc_html__('Thursday','docdirect'),
			'fri'	=> esc_html__('Friday','docdirect'),
			'sat'	=> esc_html__('Saturday','docdirect'),
		);
	}
}

/**
 * Update User Password
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'docdirect_do_process_subscription' ) ) {
	function docdirect_do_process_subscription() {
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;
		$json	=  array();

		$user = wp_get_current_user(); //trace($user);
		
		$do_check = check_ajax_referer( 'docdirect_renew_nounce', 'renew-process', false );
		if( $do_check == false ){
			$json['type']	= 'error';
			$json['message']	= esc_html__('No kiddies please!','docdirect');	
			$json['payment_type']  = 'gateway';
			echo json_encode($json);
			die;
		}
		
		//Account de-activation			
		
		if ( empty( $_POST['packs'] ) ) {
			$json['type']		=  'error';	
			$json['message']		= esc_html__('Please select a plan to subscribe.','docdirect');	
			$json['payment_type']  = 'gateway';
			echo json_encode($json);
			exit;
		} else if ( empty( $_POST['gateway'] ) ) {
			$json['type']		=  'error';	
			$json['message']		= esc_html__('Please select a payment gateway to subscribe.','docdirect');	
			$json['payment_type']  = 'gateway';
			echo json_encode($json);
			exit;
		} else if ( empty( $_POST['packs'] ) ||  empty( $_POST['gateway'] ) ) { 
			$json['type']		=  'error';	
			$json['message']		= esc_html__('Some error occur, please try again later.','docdirect');
			$json['payment_type']  = 'gateway';	
			echo json_encode($json);
			exit;
		}
		
		
		
		$pack_title		  = get_the_title( $_POST['packs'] ); 
		$duration 			= fw_get_db_post_option($_POST['packs'], 'duration', true);
		$price 			   = fw_get_db_post_option($_POST['packs'], 'price', true);
		$pac_subtitle 		= fw_get_db_post_option($_POST['packs'], 'pac_subtitle', true);
		$currency_select 	 = fw_get_db_settings_option('currency_select');
		$currency_sign  	   = fw_get_db_settings_option('currency_sign');
		
			
		if( isset( $_POST['gateway'] ) && $_POST['gateway'] === 'paypal' ){			
			
			/*---------------------------------------------
			 * @Paypal Payment Gateway Process
			 * @Return HTML
			 ---------------------------------------------*/
			$sandbox_enable = fw_get_db_settings_option('paypal_enable_sandbox');
			$business_email = fw_get_db_settings_option('paypal_bussiness_email');
			$listner_url    = fw_get_db_settings_option('paypal_listner_url');
		
			$package_name	= $pack_title.' - '.$duration.esc_html__('Days','docdirect');
			
            if (isset($sandbox_enable) && $sandbox_enable == 'on') {
                $paypal_path = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
            } else {
                $paypal_path = 'https://www.paypal.com/cgi-bin/webscr';
            }

            if ($currency_select == '' || $business_email == '' || $listner_url == '') {
                $json['type'] = 'error';
                $json['message'] = esc_html__('Some error occur please contact to administrator.', 'docdirect');
                echo json_encode($json);
                die;
            }
			
			//prepare return url
			$dir_profile_page = '';
			if (function_exists('fw_get_db_settings_option')) {
                $dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
            }
			
			//Add New Order
			$order_no	= docdirect_add_new_order(
				array(
					'packs'		=> sanitize_text_field( $_POST['packs'] ),
					'gateway'	  => sanitize_text_field( $_POST['gateway'] ),
					'price'		=> number_format((float)$price, 2, '.', ''),
					'payment_type' => 'gateway',
					'mc_currency'  => $currency_select,
				)
			);
			
			$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
			
			$return_url	= DocDirect_Scripts::docdirect_profile_menu_link($profile_page, 'invoices', $user_identity,true);
			
			$output  = '';
            $output .= '<form name="paypal_subscription" id="paypal_subscribe_form" action="' . $paypal_path . '" method="post">  
							<input type="hidden" name="cmd" value="_xclick">  
							<input type="hidden" name="business" value="' . $business_email . '">
							<input type="hidden" name="amount" value="' . $price . '">
							<input type="hidden" name="item_name" value="'.sanitize_text_field($package_name).'"> 
							<input type="hidden" name="currency_code" value="' . $currency_select . '">
							<input type="hidden" name="item_number" value="'.sanitize_text_field($_POST['packs']).'">  
							<input name="cancel_return" value="'.$return_url.'" type="hidden">
							<input type="hidden" name="custom" value="'.$order_no.'|_|'.$_POST['packs'].'|_|'.$user_identity.'">    
							<input type="hidden" name="no_note" value="1">  
							<input type="hidden" name="notify_url" value="' . $listner_url . '">
							<input type="hidden" name="lc">
							<input type="hidden" name="rm" value="2">
							<input type="hidden" name="return" value="'.$return_url.'&subscription=done">  
					   </form>';

            $output .= '<script>
							jQuery("#paypal_subscribe_form").submit();
					  </script>';

            $json['form_data']  = $output;
            $json['type'] 		= 'success';
			$json['payment_type']  = 'gateway';
	
		}else if( isset( $_POST['gateway'] ) && $_POST['gateway'] === 'stripe' ){
				/*---------------------------------------------
				 * @Strip Payment Gateway Process
				 * @Return HTML
				 ---------------------------------------------*/
				 $currency_sign   = '';
				 $stripe_secret    = '';
				 $stripe_publishable = '';
				 $stripe_site     = '';
				 $stripe_decimal  = '';
					
				 if (function_exists('fw_get_db_settings_option')) {
					$currency_sign   = fw_get_db_settings_option('currency_select');
					$stripe_secret    = fw_get_db_settings_option('stripe_secret');
					$stripe_publishable = fw_get_db_settings_option('stripe_publishable');
					$stripe_site     = fw_get_db_settings_option('stripe_site');
					$stripe_decimal  = fw_get_db_settings_option('stripe_decimal');
				 }
				 
				 $total_amount	= $price;
				 
				 if( isset( $stripe_decimal ) && $stripe_decimal == 0 ){
					$package_amount	= $price;
				 } else{
					$package_amount	= $price.'00';	 
				 }
				  
				  
				//prepare return url
				$dir_profile_page = '';
				if (function_exists('fw_get_db_settings_option')) {
					$dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
				}
				
				//Add New Order
				$order_no	= docdirect_add_new_order(
					array(
						'packs'		=> sanitize_text_field( $_POST['packs'] ),
						'gateway'	  => sanitize_text_field( $_POST['gateway'] ),
						'price'		=> number_format((float)$price, 2, '.', ''),
						'payment_type' => 'gateway',
						'mc_currency'  => $currency_select,
					)
				);
				
				$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
				
				$return_url	= DocDirect_Scripts::docdirect_profile_menu_link($profile_page, 'invoices', $user_identity,true);
				
				$userdata	  = get_userdata( $user_identity );
				$user_email	= '';
				if( !empty( $userdata ) ) {
					$user_email	= $userdata->user_email;
				}
				
				$first_name	 = get_user_meta($user_identity,'first_name',true);
				$last_name	 = get_user_meta($user_identity,'last_name',true);
				$user_name	 = get_user_meta($user_identity,'first_name',true).' '.get_user_meta($user_identity,'last_name',true);
				$useraddress   = get_user_meta($user_identity,'address',true);

				
				$package_name	= $pack_title.' - '.$duration.esc_html__(' Days','docdirect');
				   
				echo json_encode( 
					array( 
						   'first_name' 	  => $first_name,
						   'last_name' 	   => $last_name,
						   'username' 	 	=> $user_name,
						   'email' 		   => $user_email,
						   'useraddress'     => $useraddress,
						   'order_no' 	    => $order_no,
						   'user_identity'   => $user_identity,
						   'package_id' 	  => $_POST['packs'],
						   'package_name'    => $package_name,
						   'gateway' 	  => 'stripe',
						   'type' 		 => 'success',
						   'payment_type' => 'stripe',
						   'process'=>true, 
						   'name'=> $stripe_site, 
						   'description'=> $package_name,
						   'amount' => $package_amount,
						   'total_amount' => $total_amount,
						   'key'=> $stripe_publishable,
						   'currency'=> $currency_sign
						  )
					);
				 
				 die;

		}else if( isset( $_POST['gateway'] ) && $_POST['gateway'] === 'authorize' ){			
			/*---------------------------------------------
			 * @Authorize.Net Payment Gateway Process
			 * @Return HTML
			 ---------------------------------------------*/
			
			$current_date   				 = date('Y-m-d H:i:s');
			$output					   = '';
			$authorize_login_id 		   = fw_get_db_settings_option('authorize_login_id');
			$authorize_transaction_key 	= fw_get_db_settings_option('authorize_transaction_key');
			$authorize_listner_url 		= fw_get_db_settings_option('authorize_listner_url');
			$authorize_enable_sandbox 	 = fw_get_db_settings_option('authorize_enable_sandbox');
			
			$timeStamp	= time();
			$sequence	 = rand(1, 1000);
			
			if( phpversion() >= '5.1.2' ) {
				{ $fingerprint = hash_hmac("md5", $authorize_login_id . "^" . $sequence . "^" . $timeStamp . "^" . $price . "^". $currency_select, $authorize_transaction_key); }
			} else {
				$fingerprint = bin2hex(mhash(MHASH_MD5, $authorize_login_id . "^" . $sequence . "^" . $timeStamp . "^" . $price . "^". $currency_select, $authorize_transaction_key));
			}
				
			$package_name	= $pack_title.' - '.$duration.esc_html__('Days','docdirect');
			

            if ($currency_select == '' || $authorize_login_id == '') {
                $json['type'] = 'error';
                $json['message'] = esc_html__('Some error occur please contact to administrator.', 'docdirect');
                echo json_encode($json);
                die;
            }
			
			if (isset($authorize_enable_sandbox) && $authorize_enable_sandbox == 'on') {
                $gateway_path = 'https://test.authorize.net/gateway/transact.dll';
            } else {
                $gateway_path = 'https://secure.authorize.net/gateway/transact.dll';
            }
			
			//Add New Order
			$order_no	= docdirect_add_new_order(
				array(
					'packs'		=> sanitize_text_field( $_POST['packs'] ),
					'gateway'	  => sanitize_text_field( $_POST['gateway'] ),
					'price'		=> $price,
					'payment_type' => 'gateway',
				)
			);
			
			//prepare return url
			$dir_profile_page = '';
			if (function_exists('fw_get_db_settings_option')) {
                $dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
            }

			$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
			
			$return_url	= DocDirect_Scripts::docdirect_profile_menu_link($profile_page, 'invoices', $user_identity,true);
			
			$output .= '<form name="AuthorizeForm" id="authorize-form" action="'.$gateway_path.'" method="post">  
							<input type="hidden" name="x_login" value="'.$authorize_login_id.'">
							<input type="hidden" name="x_type" value="AUTH_CAPTURE"/>
							<input type="hidden" name="x_amount" value="'.$price.'">
							<input type="hidden" name="x_fp_sequence" value="'.$sequence.'" />
							<input type="hidden" name="x_fp_timestamp" value="'.$timeStamp.'" />
							<input type="hidden" name="x_fp_hash" value="'.$fingerprint.'" />
							<input type="hidden" name="x_show_form" value="PAYMENT_FORM" />
							<input type="hidden" name="x_invoice_num" value="'.$package_name.'">
							<input type="hidden" name="x_po_num" value="'.$order_no.'|_|'.$_POST['packs'].'|_|'.$user_identity.'">
							<input type="hidden" name="x_cust_id" value="'.sanitize_text_field($order_no).'"/> 
							<input type="hidden" name="x_first_name" value="'.get_user_meta('first_name' ,$user_identity).'"> 
							<input type="hidden" name="x_last_name" value="'.get_user_meta('last_name' ,$user_identity).'"> 
							<input type="hidden" name="x_address" value="'.get_user_meta( 'address' ,$user_identity).'"> 
							<input type="hidden" name="x_fax" value="'.get_user_meta('fax' ,$user_identity).'"> 
							<input type="hidden" name="x_email" value="'.get_user_meta('email' ,$user_identity).'"> 
							<input type="hidden" name="x_description" value="'.$package_name.'">
							<input type="hidden" name="x_currency_code" value="'.$currency_select.'" />	 
							<input type="hidden" name="x_cancel_url" value="'.esc_url( $return_url ).'" />
							<input type="hidden" name="x_cancel_url_text" value="Cancel Order" />
							<input type="hidden" name="x_relay_response" value="TRUE" />
							<input type="hidden" name="x_relay_url" value="'.sanitize_text_field( $authorize_listner_url ).'"/> 
							<input type="hidden" name="x_test_request" value="false"/>
						</form>';					

            $output .= '<script>
							jQuery("#authorize-form").submit();
					  </script>';

            $json['form_data']  = $output;
            $json['type'] 		= 'success';
			$json['payment_type']  = 'gateway';
	
		} else if( isset( $_POST['gateway'] ) && $_POST['gateway'] === 'bank' ){			
			/*---------------------------------------------
			 * @Bank Transfer Gateway Process
			 * @Return HTML
			 ---------------------------------------------*/
			$bank_name = fw_get_db_settings_option('bank_name');
			$bank_account = fw_get_db_settings_option('bank_account');
			$other_information    = fw_get_db_settings_option('other_information');
			$package_name	= $pack_title.'-'.$duration.' '.esc_html__('Days','docdirect');
			$first_name	  = get_user_meta($user_identity,'first_name',true);
			$last_name	 = get_user_meta($user_identity,'last_name',true);
			$user_name	 = get_user_meta($user_identity,'first_name',true).' '.get_user_meta($user_identity,'last_name',true);
			$useraddress   = get_user_meta($user_identity,'address',true);
			$package_id	= $_POST['packs'];
			
			$payment_date = date('Y-m-d H:i:s');
			$user_featured_date	= get_the_author_meta('user_featured',$user_identity, true);
			$featured_date	= date('Y-m-d H:i:s');
			
			if( !empty( $user_featured_date ) ){
				$duration = fw_get_db_post_option($package_id, 'duration', true);
				if( $duration > 0 ){
					$featured_date	= strtotime("+".$duration." days", $user_featured_date);
					$featured_date	= date('Y-m-d H:i:s',$featured_date);
				}
			} else{
				$current_date	= date('Y-m-d H:i:s');
				$duration = fw_get_db_post_option($package_id, 'duration', true);
				if( $duration > 0 ){
					$featured_date		 = strtotime("+".$duration." days", strtotime($current_date));
					$featured_date	     = date('Y-m-d H:i:s',$featured_date);
				}
			}
			
			$userdata	  = get_userdata( $user_identity );
			$user_email	= '';
			if( !empty( $userdata ) ) {
				$user_email	= $userdata->user_email;
			}
				
		
			//Add New Order
			$order_no	= docdirect_add_new_order(
				array(
					'packs'		=> sanitize_text_field( $_POST['packs'] ),
					'gateway'	  => sanitize_text_field( $_POST['gateway'] ),
					'price'		=> $price,
					'mc_currency'  => $currency_select,
				)
			);
			
			$html	= '';
			$html	.= '<div class="membership-price-header">'.esc_html__('Order Summary','docdirect').'</div>';
			$html	.= '<div class="system-gateway">';
			
			$html	.= '<ul>';
				$html	.= '<li>';
					$html	.= '<label for="doc-payment-bank">'.esc_html__('General Information','docdirect').'</label>';
					$html	.= '<ul>';
						$html	.= '<li>';
						$html	.= '<span class="pull-left col-md-6 col-xs-12">'.esc_html__('Order No','docdirect').'</span>';
						$html	.= '<span class="pull-right col-md-6 col-xs-12">'.$order_no.'</span>';
						$html	.= '</li>';
						
						$html	.= '<li>';
						$html	.= '<span class="pull-left col-md-6 col-xs-12">'.esc_html__('Package Name','docdirect').'</span>';
						$html	.= '<span class="pull-right col-md-6 col-xs-12">'.get_the_title($_POST['packs']).'</span>';
						$html	.= '</li>';
					
						$html	.= '<li>';
						$html	.= '<span class="pull-left col-md-6 col-xs-12">'.esc_html__('Price','docdirect').'</span>';
						$html	.= '<span class="pull-right col-md-6 col-xs-12">'.$currency_sign.$price.'</span>';
						$html	.= '</li>';
						
						
					$html	.= '</ul>';
				$html	.= '</li>';
				$html	.= '<li>';
					$html	.= '<label for="doc-payment-bank">'.esc_html__('Bank Information','docdirect').'</label>';
					$html	.= '<ul>';
						if( !empty( $other_information ) ) {
							$html	.= '<li>';
							$html	.= '<span class="pull-left col-md-6 col-xs-12">'.esc_html__('Bank Name','docdirect').'</span>';
							$html	.= '<span class="pull-right col-md-6 col-xs-12">'.$bank_name.'</span>';
							$html	.= '</li>';
						}
						
						if( !empty( $other_information ) ) {
							$html	.= '<li>';
							$html	.= '<span class="pull-left col-md-6 col-xs-12">'.esc_html__('Bank Account No','docdirect').'</span>';
							$html	.= '<span class="pull-right col-md-6 col-xs-12">'.$bank_account.'</span>';
							$html	.= '</li>';
						}
						
						if( !empty( $other_information ) ) {
							$html	.= '<li>';
							$html	.= '<span class="pull-left col-md-6 col-xs-12">'.esc_html__('Other Information','docdirect').'</span>';
							$html	.= '<span class="pull-right col-md-6 col-xs-12">'.$other_information.'</span>';
							$html	.= '</li>';
						}
					$html	.= '</ul>';
				$html	.= '</li>';
			$html	.= '</ul>';
			
			
			//Send ean email 
			if( class_exists( 'DocDirectProcessEmail' ) ) {
				$email_helper	= new DocDirectProcessEmail();
				$emailData	   = array();
				$emailData['mail_to']	  	   = $user_email;
				$emailData['name']			  = $user_name;
				$emailData['invoice']	  	   = $order_no;
				$emailData['package_name']	  = $package_name;					
				$emailData['amount']			= $currency_sign.$price;
				$emailData['status']			= esc_html__('Pending','docdirect');
				$emailData['method']			= esc_html__('Bank Transfer','docdirect');
				$emailData['date']			  = date('Y-m-d H:i:s');
				$emailData['expiry']			= $featured_date;
				$emailData['address']		   = $useraddress;
				
				$email_helper->process_invoice_email( $emailData );
			}
			
            $json['form_data']  = $html;
			$json['payment_type']  = 'bank';
            $json['type'] 		= 'success';
	
		} else{
			$json['message'] = esc_html__('Some error occur please contact to administrator.', 'docdirect');
            $json['type'] 		= 'error';
			$json['payment_type']  = 'gateway';
		}
		
		echo json_encode($json);
		exit;
	}
	add_action('wp_ajax_docdirect_do_process_subscription', 'docdirect_do_process_subscription');
	add_action('wp_ajax_nopriv_docdirect_do_process_subscription', 'docdirect_do_process_subscription');
}


/**
 * @Stripe Payment
 *
 * @param json
 * @return string
 */
if ( !function_exists('docdirect_complete_stripe_payment') ) {
	function docdirect_complete_stripe_payment() {		
		$first_name   = $_POST['first_name'];
		$last_name	= $_POST['last_name'];
		$username	 = $_POST['username'];
		$user_identity	 = $_POST['user_identity'];
		$email  		= $_POST['email'];
		$order_no 	 = $_POST['order_no'];
		$package_id   = $_POST['package_id'];
		$package_name = $_POST['package_name'];
		$useraddress  = $_POST['useraddress'];
		$gateway 	  = $_POST['gateway'];
		$type		 = $_POST['type'];
		$token	    = $_POST['token'];
		$payment_type = $_POST['payment_type'];
		$process 	  = $_POST['process'];
		$name		 = $_POST['name'];
		$amount	   = $_POST['amount'];
		$total_amount = $_POST['total_amount'];
		$token	    = $_POST['token'];
		
		$currency_sign	= 'USD';
		
		 if (function_exists('fw_get_db_settings_option')) {
			$currency_sign   = fw_get_db_settings_option('currency_select');
			$stripe_secret    = fw_get_db_settings_option('stripe_secret');
			$stripe_publishable = fw_get_db_settings_option('stripe_publishable');
			$stripe_site     = fw_get_db_settings_option('stripe_site');
			$stripe_decimal  = fw_get_db_settings_option('stripe_decimal');
		 }
		 
		 
		 if( class_exists( 'DocDirectGlobalSettings' ) ) {		 
		 	require_once( DocDirectGlobalSettings::get_plugin_path().'/libraries/stripe/init.php');
		 } else{
			$json['type']     = 'error';
			$json['message']  = esc_html__('Stripe API not found.','docdirect');
			echo json_encode($json);
			die;
		 }
		 
		 $stripe = array(
			"secret_key"      => $stripe_secret,
			"publishable_key" => $stripe_publishable
		  );

		  \Stripe\Stripe::setApiKey($stripe['secret_key']);
		  
		  $charge = \Stripe\Charge::create(array(
			'amount'   => $amount,
			'currency' => ''.$currency_sign.'',
			'source'  => $token['id'],
			'description' => $package_name,
		  ));
		
		if ($charge->status == 'succeeded') {
			
			if( !empty( $charge->source->id ) ){
				$transaction_id	= $charge->source->id;
			} else{
				$transaction_id	= docdirect_unique_increment(10);
			}
			
			//Update Order
            $expiry_date	= docdirect_update_order_data(
				array(
					'order_id'		   => $order_no,
					'user_identity'	   => $user_identity,
					'package_id'	   => $package_id,
					'txn_id'		   => $transaction_id,
					'payment_gross'	   => $total_amount,
					'payment_method'   => 'stripe',
					'mc_currency'	   => $currency_sign,
				)
			);
			
			//Add Invoice
			docdirect_new_invoice(
				array(
					'user_identity'	 => $user_identity,
					'package_id'		=> $package_id,
					'txn_id'			=> $transaction_id,
					'payment_gross'	 => $total_amount,
					'item_name'		 => $package_name,
					'payer_email'	   => $email,
					'mc_currency'	   => $currency_sign,
					'address_name'	  => $useraddress,
					'ipn_track_id'	  => '',
					'transaction_status'=> 'approved',
					'payment_method'	=> 'stripe',
					'full_address'	  => $useraddress,
					'first_name'		=> $first_name,
					'last_name'		 => $last_name,
					'purchase_on'	   => date('Y-m-d H:i:s'),
				)
			);
			
			//Send ean email 
			if( class_exists( 'DocDirectProcessEmail' ) ) {
				$email_helper	= new DocDirectProcessEmail();
				$emailData	= array();
				$emailData['name']			  = $_POST['first_name'].' '.$_POST['last_name'];
				$emailData['mail_to']	  	   = $email;
				$emailData['invoice']	  	   = $transaction_id;
				$emailData['package_name']	  = $package_name;					
				$emailData['amount']			= $currency_sign.$total_amount;
				$emailData['status']			= esc_html__('Approved','docdirect');
				$emailData['method']			= esc_html__('Stripe( Credit Card )','docdirect');
				$emailData['date']			  = date('Y-m-d H:i:s');
				$emailData['expiry']			= $expiry_date;
				$emailData['address']		   = $useraddress;
				

				$email_helper->process_invoice_email($emailData);
			}
						
			
			$json['type']     = 'success';
			$json['message']  = esc_html__('Thank you! Your package has been updated.','docdirect');
			echo json_encode($json);
			die;
		}
		
		$json['type']     = 'error';
		$json['message']  = esc_html__('Some Error occur, please try again later.','docdirect');
		echo json_encode($json);
		die;
	}
	add_action('wp_ajax_docdirect_complete_stripe_payment', 'docdirect_complete_stripe_payment');
	add_action('wp_ajax_nopriv_docdirect_complete_stripe_payment', 'docdirect_complete_stripe_payment');
}
/**
 * Update User Password
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'docdirect_add_new_order' ) ) {
	function docdirect_add_new_order($order_meta=array()) {
		global $current_user, $wp_roles,$userdata,$post;
		extract($order_meta);
		
		$user_identity	= $current_user->ID;
		$json	=  array();
		
		
		$directory_prefix = fw_get_db_settings_option('directory_prefix');
		$directory_prefix	= isset( $directory_prefix ) && !empty( $directory_prefix ) ? $directory_prefix :'DD-';
		
		$order_no	= $directory_prefix.docdirect_unique_increment(10);
		$payment_date = date_i18n(date('Y-m-d H:i:s'));
		$order_post = array(
			'post_title' => $order_no,
			'post_status' => 'publish',
			'post_author' => $current_user->ID,
			'post_type' => 'docdirectorders',
			'post_date' => current_time('Y-m-d h')
		);
		
		$post_id = wp_insert_post($order_post);
		
		$order_meta = array(
			'transaction_id' 	=> docdirect_unique_increment(10),
			'order_status' 	  => 'pending',
			'payment_method' 	=> $gateway,
			'package' 		   => $packs,
			'price' 			 => $price,
			'payment_date' 	  => $payment_date,
			'expiry_date' 	   => $featured_date,
			'payment_user' 	  => $user_identity,
			'mc_currency' 	   => $mc_currency,
		);
		
		$new_values = $order_meta;
		if ( isset( $post_id ) && !empty( $post_id ) ) {
			fw_set_db_post_option($post_id, null, $new_values);
		}
		
		if( isset( $payment_type ) && $payment_type === 'gateway' ){
			return $post_id;
		} else{
			return $order_no;
		}
		
	}
}
/**
 * Update User Password
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'docdirect_process_acount' ) ) {
	function docdirect_process_acount() {
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;
		$json	=  array();
		$action	= $_POST['process'];
		$user = wp_get_current_user(); //trace($user);
		
		$do_check = check_ajax_referer( 'docdirect_deleteme_nounce', 'account-process', false );
		if( $do_check == false ){
			$json['type']	= 'error';
			$json['message']	= esc_html__('No kiddies please!','docdirect');	
			echo json_encode($json);
			die;
		}
		
		//Account Activation
		if( isset( $action ) && $action === 'activateme' ){
			update_user_meta( $user->data->ID, 'profile_status', 'active' );
			$json['type']		=  'success';	
			$json['message']		= esc_html__('Account activated..','docdirect');
			echo json_encode($json);
			die;
		} 
		
		//Account de-activation			
		
		if ( empty($_POST['message'] ) ) {
			$json['type']		=  'error';	
			$json['message']		= esc_html__('Please add some description','docdirect');	
			echo json_encode($json);
			exit;
		}
		
		if ( empty($_POST['old_password'] ) || empty( $_POST['confirm_password'] ) ) {
			$json['type']		=  'error';	
			$json['message']		= esc_html__('Please add your password and confirm password.','docdirect');	
			echo json_encode($json);
			exit;
		}
		
		
			
		
    	$is_password = wp_check_password( $_POST['old_password'], $user->user_pass, $user->data->ID );
		
		if( $is_password ){
			if ( $_POST['old_password'] == $_POST['confirm_password'] ) {
				if( isset( $action ) && $action === 'deleteme' ){
					wp_delete_user( $user->data->ID );
					
					docdirect_wp_user_delete_notification($user->data->ID,$_POST['message']); //email to admin
					
					$json['type']		=  'success';	
					$json['message']		= esc_html__('Account deleted.','docdirect');
				} elseif( isset( $action ) && $action === 'deactivateme' ){
					update_user_meta( $user->data->ID, 'profile_status', 'de-active' );
					update_user_meta( $user->data->ID, 'deactivate_reason', $_POST['message'] );
					
					$json['type']		=  'success';	
					$json['message']		= esc_html__('Account de-activated..','docdirect');
				} 
					
			} else {
				$json['type']		=  'error';	
				$json['message']		= esc_html__('The passwords you entered do not match.', 'docdirect');
			}
		} else{
			$json['type']		=  'error';	
			$json['message']		= esc_html__('Password doesn\'t match.', 'docdirect');
		}
		
		echo json_encode($json);
		exit;
	}
	add_action('wp_ajax_docdirect_process_acount', 'docdirect_process_acount');
	add_action('wp_ajax_nopriv_docdirect_process_acount', 'docdirect_process_acount');
}

/**
 * Update User Password
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'docdirect_add_user_roles' ) ) {
	function docdirect_add_user_roles() {
		
		$visitor = add_role('visitor', esc_html__('Visitor','docdirect'));
		$professional = add_role('professional', esc_html__('Professional','docdirect'));
	}
	add_action( 'admin_init', 'docdirect_add_user_roles' );
}

/**
 * Check if user is active user
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'docdirect_is_user_active' ) ) {
	function docdirect_is_user_active($user_id='') {
		
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;
		
		if( isset( $user_id ) && !empty( $user_id ) ) {
			$profile_status = get_user_meta($user_id , 'profile_status' , true);
			if( $user_identity == $user_id && $profile_status == 'de-active' ){
				add_action( 'wp_footer', 'docdirect_user_profile_status_message' );
			}
		}
	}
	add_action( 'docdirect_is_user_active', 'docdirect_is_user_active' );
}

/**
 * Check if user is verified user
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'docdirect_is_user_verified' ) ) {
	function docdirect_is_user_verified($user_id='') {
		global $current_user, $wp_roles,$userdata,$post;
		$user_identity	= $current_user->ID;
		if( isset( $user_id ) && !empty( $user_id ) ) {
			$verify_user = get_user_meta($user_id , 'verify_user' , true);
			$user_type   = get_user_meta($user_id , 'user_type' , true);
			
			if( $user_identity == $user_id
				&&
				$user_type === 'professional'  
				&& 
				( $verify_user == 'off' || empty( $verify_user ) )
				
			){
				add_action( 'wp_footer', 'docdirect_is_user_verified_message' );
			}
		}
	}
	add_action( 'docdirect_is_user_verified', 'docdirect_is_user_verified' );
}

/**
 * Check if user is active user
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'docdirect_user_profile_status_message' ) ) {
	function docdirect_user_profile_status_message() {
		?>
        <div class="sticky-queue bottom-right">
            <div class="sticky border-top-right important" id="s939311313">
                <span class="sticky-close"></span><p class="sticky-note"><?php printf( wp_kses_post( __( 'Your account is de-active, please activate your account.<br/>Note: Your account will not be shown publicly untill you activate your account. <br/> To activate please go to "Security Settings"', 'docdirect' ) ), 'docdirect' );?></p>
            </div>
        </div>
		<?php 
	}
}

/**
 * Check if user is verified user
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'docdirect_is_user_verified_message' ) ) {
	function docdirect_is_user_verified_message() {
		?>
        <div class="sticky-queue bottom-right">
            <div class="sticky border-top-right important" id="s939311313">
                <span class="sticky-close"></span><p class="sticky-note"><?php printf( wp_kses_post( __( 'You are not a verified user, Please contact to administrator to be verified.<br/>Note: Your account will not be shown publicly untill your account will get verified.', 'docdirect' ) ), 'docdirect' );?></p>
            </div>
        </div>
		<?php 
	}
}

/**
 * Check if user is active user
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'docdirect_get_term_options' ) ) {
	function docdirect_get_term_options($current='',$taxonomyName='locations') {
		//This gets top layer terms only.  This is done by setting parent to 0.  
		$parent_terms = get_terms( $taxonomyName, array( 'parent' => 0, 'orderby' => 'slug', 'hide_empty' => false ) ); 
		$options	= '';
		if( isset( $parent_terms ) && !empty( $parent_terms ) ) {
			foreach ( $parent_terms as $pterm ) {
				//Get the Child terms
				
				$terms = get_terms( $taxonomyName, array( 'parent' => $pterm->term_id, 'orderby' => 'slug', 'hide_empty' => false ) );
				if( isset( $terms ) && !empty( $terms ) ) {
					$options	.= '<optgroup  label="'.$pterm->name.'">';
					foreach ( $terms as $term ) {
						$selected	= '';
						
						if( !empty( $current ) 
							&& is_array($current)
							&& in_array($term->slug,$current)
						){
							$selected	= 'selected';
						} else if( !empty( $current ) 
							&& !is_array($current)
							&& $term->slug == $current
						){
							$selected	= 'selected';
						}
						
						$options	.= '<option '.$selected.' value="'.$term->slug.'">'.$term->name.'</option>';
					}
					$options	.= '</optgroup>';
				} else{
					$selected	= '';
					
					if( !empty( $current ) 
						&& is_array($current)
						&& in_array($pterm->slug,$current)
					){
						$selected	= 'selected';
					} else if( !empty( $current ) 
						&& !is_array($current)
						&& $pterm->slug == $current
					){
						
						$selected	= 'selected';
					}
					
					$options	.= '<option '.$selected.' value="'.$pterm->slug.'">'.$pterm->name.'</option>';
				}
			}
		}
		
		echo force_balance_tags( $options );
	}
}

/**
 * Check if user is active user
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'docdirect_format_size_units' ) ) {
	function docdirect_format_size_units($bytes,$returntype='print'){
		if ($bytes >= 1073741824) {
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		} elseif ($bytes >= 1048576){
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		} elseif ($bytes >= 1024) {
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		} elseif ($bytes > 1)  {
			$bytes = $bytes . ' bytes';
		} elseif ($bytes == 1) {
			$bytes = $bytes . ' byte';
		} else {
			$bytes = '0 bytes';
		}
		
		if( $returntype === 'print' ){
			echo esc_attr( $bytes );
		} else{
			return $bytes;
		}
	}
}

/**
 * Get All user those are active.
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'docdirect_prepare_user_list' ) ) {
	function docdirect_prepare_user_list(){
		$args = array(
			'orderby'      => 'nicename',
			'order'        => 'DESC',
		);
	
		$site_user = get_users($args);

		$user_list	= array();
		foreach ($site_user as $user) {
			$user_list[$user->data->ID]	= $user->data->display_name;
		}
		
		return $user_list;
	}
}

/**
 * Order_Status
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'docdirect_prepare_order_status' ) ) {
	function docdirect_prepare_order_status($type="array",$index='cancelled'){
		$status	= array(
					'approved'	=> esc_html__('Complete', 'docdirect'),
					'pending'	=> esc_html__('Pending', 'docdirect'),
					'cancelled'	=> esc_html__('Rejected', 'docdirect'),
				);
		
		if( $type === 'array' ){
			return $status;
		}else{
			if( isset( $status[$index] ) ){
				return  $status[$index];
			} else{
				return '';
			}
			
		}
	}
}

/**
 * Package Type
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'docdirect_prepare_payment_type' ) ) {
	function docdirect_prepare_payment_type($type="array",$index='bank'){
		$packages	= array(
					'bank'	=> esc_html__('Bank Transfer', 'docdirect'),
					'paypal'	=> esc_html__('Paypal', 'docdirect'),
					'stripe'	=> esc_html__('Credit Card (Stripe)', 'docdirect'),
					'authorize'	=> esc_html__('Authorize.Net', 'docdirect'),
					'local'	=> esc_html__('Payment On Arrival', 'docdirect'),
				);
		
		if( $type === 'array' ){
			return $packages;
		}else{
			if( isset( $packages[$index] ) ){
				return  $packages[$index];
			} else{
				return '';
			}
			
		}
	}
}


/**
 * @Check user role
 * @return 
 */
if (!function_exists('docdirect_do_check_user_type')) {
	function docdirect_do_check_user_type($user_identity){
		if( isset( $user_identity ) && !empty( $user_identity ) ) {
			$data	= get_userdata( $user_identity );
			if( isset( $data->roles[0] ) && !empty( $data->roles[0] ) && ( $data->roles[0] === 'professional' || $data->roles[0] === 'administrator' ) ){
				return true;
			} else {
				return false;
			}
		}
		
		return false;
	}
	add_filter( 'docdirect_do_check_user_type', 'docdirect_do_check_user_type', 10, 3 );
}

/**
 * @Check if booking is enabled
 * @return 
 */
if (!function_exists('docdirect_do_check_booking')) {
	function docdirect_do_check_booking($user_identity){
		if( isset( $user_identity ) && !empty( $user_identity ) ) {
			$data	= get_userdata( $user_identity );
			$directory_type	= $data->directory_type;
			$booking_switch    = '';
			if(function_exists('fw_get_db_settings_option')) {
				$booking_switch    = fw_get_db_post_option($directory_type, 'bookings', true);
			}

			if( $booking_switch === 'enable' ){
				return true;
			} else{
				return false;  
			}
		}
		
		return false;
	}
	add_filter( 'docdirect_do_check_booking', 'docdirect_do_check_booking', 10, 3 );
}

/**
 * @Remove Meta boxes
 * @return 
 */
if ( ! function_exists( 'tg_unwanted_remove_meta_box' ) ) {
	function tg_unwanted_remove_meta_box($post_type) {
		remove_meta_box('tagsdiv-insurance', 'directory_type', 'normal');
		remove_meta_box('locationsdiv', 'directory_type', 'normal');
		remove_meta_box('specialitiesdiv', 'directory_type', 'normal');
		remove_meta_box( 'submitdiv', 'docdirectinvoices','side');
		remove_meta_box( 'submitdiv', 'docappointments','side');
		remove_meta_box( 'slugdiv', 'docdirectinvoices','normal');
		remove_meta_box( 'mymetabox_revslider_0', 'docdirectinvoices', 'normal' );
	}
	add_action( 'admin_init', 'tg_unwanted_remove_meta_box', 10,1);
}

/**
 * @get all specialities
 * @return 
 */
if (!function_exists('docdirect_prepare_specialities')) {
	function docdirect_prepare_specialities(){
		global $post;
		$args = array(
			'type'                     => 'post',
			'child_of'                 => 0,
			'parent'                   => '',
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 0,
			'hierarchical'             => 1,
			'exclude'                  => '',
			'include'                  => '',
			'number'                   => '',
			'taxonomy'                 => 'specialities',
			'pad_counts'               => false 
		); 
		
		$specialities = get_categories($args); 
		//$specialities_attached	= docdirect_get_attached_specialities();
		$specialities_attached	= array();

		$speciality_array	= array();
		foreach ( $specialities as $speciality ) {
			if ( is_array($specialities_attached) && !in_array( $speciality->term_id,$specialities_attached) ) {
				$speciality_array[$speciality->term_id]	= $speciality->name;
			}
		}
		
		return $speciality_array;
	}
}

/**
 * @check attached all specialities
 * @return 
 */
if ( ! function_exists( 'docdirect_get_attached_specialities' ) ) {
	function docdirect_get_attached_specialities(){
		global $post;
		$post_id	= !empty( $post->ID ) ?  $post->ID : '';
		$specialities_array	= array();
		$args = array(
			'posts_per_page'	=> "-1",
			'post_type'         => 'directory_type',
			'suppress_filters'  => false,
			'post__not_in'	  => array($post_id),
			'post_status'       => array('publish','pending','draft'),
		);
		
        $cust_query = get_posts($args);

        if (isset($cust_query) && is_array($cust_query) && !empty($cust_query)) {
            foreach ($cust_query as $key => $val) {
				$attached = get_post_meta($val->ID, 'attached_specialities', false);
				if( isset( $attached  ) && !empty( $attached  ) ) {
					$specialities_array = array_merge($specialities_array,$attached[0]);
				}
            }
        }

	   return array_unique($specialities_array);
	   
	}
}

/**
 * @Search Directory
 * @return 
 */
if ( ! function_exists( 'docdirect_get_map_directory' ) ) {
	function docdirect_get_map_directory(){
		global $post;
		$json	= array();
		
	    $directories	= array();
		$directory_type = !empty( $_POST['directory_type'] ) ? $_POST['directory_type'] : '';
		$dir_subcat 	 = !empty( $_POST['dir_subcat'] ) ? $_POST['dir_subcat'] : '';
		$zip	 		= !empty( $_POST['zip'] ) ? $_POST['zip'] : '';
		$by_name	 		= !empty( $_POST['by_name'] ) ? $_POST['by_name'] : '';

		$query_args	= array(
							'role'  => 'professional',
							'order' => 'DESC',
						 );
		
		$meta_query_args = array();

		if( !empty( $by_name ) ){
			$s = sanitize_text_field( $by_name );
			//$query_args['search'] = $s;
			$search_args	= array(
									'search'         => '*'.esc_attr( $s ).'*',
									'search_columns' => array(
										'ID',
										'display_name',
										'user_login',
										'user_nicename',
										'user_email',
										'user_url',
										
									)
								);
			//$query_args	= array_merge( $query_args, $search_args );
			$meta_by_name = array('relation' => 'OR',);
			$meta_by_name[] = array(
									'key' 	   => 'first_name',
									'value' 	 => $s,
									'compare'   => 'LIKE',
								);
			
			$meta_by_name[] = array(
									'key' 	   => 'last_name',
									'value' 	 => $s,
									'compare'   => 'LIKE',
								);
			
			$meta_by_name[] = array(
									'key' 	   => 'nickname',
									'value' 	 => $s,
									'compare'   => 'LIKE',
								);
			
			$meta_by_name[] = array(
									'key' 	   => 'username',
									'value' 	 => $s,
									'compare'   => 'LIKE',
								);
			
			$meta_by_name[] = array(
									'key' 	   => 'description',
									'value' 	 => $s,
									'compare'   => 'LIKE',
								);
			
			if( !empty( $meta_by_name ) ) {
				$meta_query_args[]	= array_merge( $meta_by_name,$meta_query_args );
			}
		}
		
		//Directory Type Search
		if( isset( $directory_type ) && !empty( $directory_type ) ){
			$meta_query_args[] = array(
									'key' 	   => 'directory_type',
									'value' 	 => $directory_type,
									'compare'   => '=',
								);
		}
		
		//Zip Search
		if( isset( $zip ) && !empty( $zip ) ){
			$meta_query_args[] = array(
									'key'     => 'zip',
									'value'   => $zip,
									'compare' => '='
								);
		}
		
		//Speciality Search
		if( isset( $dir_subcat ) && !empty( $dir_subcat ) && $dir_subcat !== 'all' ){
			$meta_query_args[] = array(
									'key'     => $dir_subcat,
									'value'   => $dir_subcat,
									'compare' => '='
								);
		}
		
		//Verify user
		$meta_query_args[] = array(
						'key'     => 'verify_user',
						'value'   => 'on',
						'compare' => '='
					);
					
		//Merge Query
		if( !empty( $meta_query_args ) ) {
			$query_relation = array('relation' => 'AND',);
			$meta_query_args	= array_merge( $query_relation,$meta_query_args );
			$query_args['meta_query'] = $meta_query_args;
		}
				
		$user_query = new WP_User_Query($query_args);
			
			if ( ! empty( $user_query->results ) ) {
				$directories['status']	= 'found';
				foreach ( $user_query->results as $user ) {
					
					$latitude	= get_user_meta( $user->ID, 'latitude', true);
					$longitude	= get_user_meta( $user->ID, 'longitude', true);
					$directory_type	= get_user_meta( $user->ID, 'directory_type', true);
					$dir_map_marker    = fw_get_db_post_option($directory_type, 'dir_map_marker', true);
					$featured_date	 = get_user_meta($user->ID, 'user_featured', true);
					$current_date = date('Y-m-d H:i:s');
					
					$avatar = apply_filters(
							'docdirect_get_user_avatar_filter',
							 docdirect_get_user_avatar(array('width'=>270,'height'=>270), $user->ID),
							 array('width'=>270,'height'=>270) //size width,height
						);
					$privacy		= docdirect_get_privacy_settings($user->ID); //Privacy settings
					
					if( !empty( $latitude ) && !empty( $longitude ) ) {
						$directories_array['latitude']	 = $latitude;
						$directories_array['longitude']	= $longitude;
						$directories_array['title']		= $user->display_name;
						$directories_array['name']	 	 = $user->first_name.' '.$user->last_name;
						$directories_array['email']	 	= $user->user_email;
						$directories_array['phone_number'] = $user->phone_number;
						$directories_array['address']	  = $user->address;
						$directories_array['group']		= $slug;
						$featured_string   = $featured_date;
						$current_string	= strtotime( $current_date );
						$review_data	= docdirect_get_everage_rating ( $user->ID );

						if( isset( $dir_map_marker['url'] ) && !empty( $dir_map_marker['url'] ) ){
							$directories_array['icon']	 = $dir_map_marker['url'];
						} else{
							$directories_array['icon']	 = get_template_directory_uri().'/images/map-marker.png';
						}
						
						$infoBox	 = '<div class="tg-map-marker">';
						$infoBox	.= '<figure class="tg-docimg"><a class="userlink" href="'.get_author_posts_url($user->ID).'"><img src="'.esc_url( $avatar ).'" alt="'.esc_attr( $directories_array['title'] ).'"></a>';
						$infoBox	.= docdirect_get_wishlist_button($user->ID,false);
                
						if( isset( $featured_string ) && $featured_string > $current_string ){
							$infoBox	.= docdirect_get_featured_tag(false); 
						}
						$infoBox	.= docdirect_get_verified_tag(false,$user->ID);
						$infoBox	.= docdirect_get_rating_stars($review_data,'return');
						$infoBox	.= '</figure>';
						$infoBox	.= '<div class="tg-mapmarker-content">';
						$infoBox	.= '<div class="tg-heading-border tg-small">';
						$infoBox	.= '<h3><a class="userlink" href="'.get_author_posts_url($user->ID).'">'.$directories_array['name'].'</a></h3>';
						$infoBox	.= '</div>';
						$infoBox	.= '<ul class="tg-info">';
						if( !empty( $directories_array['email'] ) 
							&&
							  !empty( $privacy['email'] )
							&& 
							  $privacy['email'] == 'on'
						) {
							$infoBox	.= '<li> <i class="fa fa-envelope"></i> <em><a href="mailto:'.$directories_array['email'].'?Subject=hello"  target="_top">'.$directories_array['email'].'</a></em> </li>';
						}
						
						if( !empty( $directories_array['phone_number'] ) 
							&&
							  !empty( $privacy['phone'] )
							&& 
							  $privacy['phone'] == 'on'
						) {
							$infoBox	.= '<li> <i class="fa fa-phone"></i> <em><a href="javascript:;">'.$directories_array['phone_number'].'</a></em> </li>';
						}
						
						if( !empty( $directories_array['address'] ) ) {
							$infoBox	.= '<li> <i class="fa fa-map-marker"></i> <address>'.$directories_array['address'].'</address> </li>';
						}
						$infoBox	.= '</ul>';
						$infoBox	.= '</div>';
						$infoBox	.= '</div>';
						
						$directories_array['html']['content']	= $infoBox;
						$directories['users_list'][]	= $directories_array;
					}	
				}
			} else{
				$directories['status']	= 'empty';
			}
		
		echo json_encode($directories);
		die; 
	}
	
	add_action('wp_ajax_docdirect_get_map_directory', 'docdirect_get_map_directory');
	add_action('wp_ajax_nopriv_docdirect_get_map_directory', 'docdirect_get_map_directory');
}


/**
 * @Make Review
 * @return 
 */
if ( ! function_exists( 'docdirect_make_review' ) ) {
	function docdirect_make_review() {
		global $current_user, $wp_roles,$userdata,$post;

		$user_to	= isset( $_POST['user_to'] ) && !empty( $_POST['user_to'] ) ? $_POST['user_to'] : '';
		$dir_review_status	= 'pending';
		if (function_exists('fw_get_db_settings_option')) {
            $dir_review_status = fw_get_db_settings_option('dir_review_status', $default_value = null);
        }
			
		if( apply_filters('docdirect_is_user_logged_in','check_user') === false ){
			$json['type']	= 'error';
			$json['message']	= esc_html__('Please login first to add review.','docdirect');	
			echo json_encode($json);
			die;
		}

		
		$user_reviews = array(
			'posts_per_page'	=> "-1",
			'post_type'		 => 'docdirectreviews',
			'post_status'	   => 'any',
			'author' 			=> $current_user->ID,
			'meta_key'		  => 'user_to',
			'meta_value'		=> $user_to,
			'meta_compare'	  => "=",
			'orderby'		   => 'meta_value',
			'order'			 => 'ASC',
		);

		$reviews_query = new WP_Query($user_reviews);
		$reviews_count = $reviews_query->post_count;
		if( isset( $reviews_count ) && $reviews_count > 0 ){
			$json['type']		= 'error';
			$json['message']	= esc_html__('You have already submit a review.', 'docdirect');
			echo json_encode($json);
			die();
		}
		
		$db_directory_type	 = get_user_meta( $user_to, 'directory_type', true);
			
		if( $_POST['user_subject'] != '' 
			|| $_POST['user_description'] != '' 
			|| $_POST['user_rating'] != ''
			|| $_POST['user_to'] != ''
		) {
		
			$user_subject	  = sanitize_text_field( $_POST['user_subject'] );
			$user_description  = sanitize_text_field( $_POST['user_description'] );
			$user_rating	   = sanitize_text_field( $_POST['user_rating'] );
			$user_from	     = sanitize_text_field( $current_user->ID );
			$user_to	   	   = sanitize_text_field( $_POST['user_to'] );
			$directory_type	   	   = $db_directory_type;
			
			$review_post = array(
				'post_title'  => $user_subject,
				'post_status' => $dir_review_status,
				'post_content'=> $user_description,
				'post_author' => $user_from,
				'post_type'   => 'docdirectreviews',
				'post_date'   => current_time('Y-m-d H:i:s')
			);
			
			$post_id = wp_insert_post( $review_post );
	
			$review_meta = array(
				'user_rating' 	 => $user_rating,
				'user_from' 	   => $user_from,
				'user_to'   		 => $user_to,
				'directory_type'  => $directory_type,
				'review_date'   	 => current_time('Y-m-d H:i:s'),
			);
			
			//Update post meta
			foreach( $review_meta as $key => $value ){
				update_post_meta($post_id,$key,$value);
			}
			
			$new_values = $review_meta;
			
			if (isset($post_id) && !empty($post_id)) {
				fw_set_db_post_option($post_id, null, $new_values);
			}
			
			$json['type']	   = 'success';
			

			if( isset( $dir_review_status ) && $dir_review_status == 'publish' ) {
				$json['message']	= esc_html__('Your review published successfully.','docdirect');
				$json['html']	   = 'refresh';
			} else{
				$json['message']	= esc_html__('Your review submitted successfully, it will be publised after approval.','docdirect');
				$json['html']	   = '';
			}
			
			if( class_exists( 'DocDirectProcessEmail' ) ) {
				$user_from_data	= get_userdata($user_from);
				$user_to_data	  = get_userdata($user_to);
				$email_helper	  = new DocDirectProcessEmail();
				
				$emailData	= array();
				
				//User to data
				$emailData['email_to']	    = $user_to_data->user_email;
				$emailData['link_to']	= get_author_posts_url($user_to_data->ID);
				if( !empty( $user_to_data->display_name ) ) {
					$emailData['username_to']	   = $user_to_data->display_name;
				} elseif( !empty( $user_to_data->first_name ) || $user_to_data->last_name ) {
					$emailData['username_to']	   = $user_to_data->first_name.' '.$user_to_data->last_name;
				}
				
				//User from data
				if( !empty( $user_from_data->display_name ) ) {
					$emailData['username_from']	   = $user_from_data->display_name;
				} elseif( !empty( $user_from_data->first_name ) || $user_from_data->last_name ) {
					$emailData['username_from']	   = $user_from_data->first_name.' '.$user_from_data->last_name;
				}

				$emailData['link_from']	= get_author_posts_url($user_from_data->ID);
				
				//General
				$emailData['rating']	        = $user_rating;
				$emailData['reason']	        = $user_subject;
				
				$email_helper->process_rating_email($emailData);
			}
			
			echo json_encode($json);
			die;
			
		} else{
			$json['type']		= 'error';
			$json['message']	 = esc_html__('Please fill all the fields.','docdirect');	
			echo json_encode($json);
			die;
		}
		
	}
	add_action('wp_ajax_docdirect_make_review','docdirect_make_review');
	add_action( 'wp_ajax_nopriv_docdirect_make_review', 'docdirect_make_review' );
}

/**
 * @Authenticate user
 * @return 
 */
if (!function_exists('docdirect_is_user_logged_in')) {
	function docdirect_is_user_logged_in($check_user=''){
		global $current_user, $wp_roles,$userdata,$post,$wpdb;		
		if( is_user_logged_in() ){
			return true;
		} else{
			return false;
		}
	}
	add_filter( 'docdirect_is_user_logged_in', 'docdirect_is_user_logged_in' );
}

/**
 * @Authenticate user
 * @return 
 */
if (!function_exists('docdirect_get_everage_rating')) {
	function docdirect_get_everage_rating( $user_id='' ){
		
		$meta_query_args = array('relation' => 'AND',);
		$meta_query_args[] = array(
								'key' 	   => 'user_to',
								'value' 	 => $user_id,
								'compare'   => '=',
								'type'	  => 'NUMERIC'
							);
								
		$args 		= array('posts_per_page'   => -1, 
							'post_type'		 => 'docdirectreviews',
							'post_status'	   => 'publish',
							'orderby' 		   => 'meta_value_num',
							'meta_key' 	 => 'user_rating',
							'order' 		=> 'ASC',
						);
		
		$args['meta_query'] = $meta_query_args;
				
		$average_rating	= 0;
		$average_count	 = 0;
		$query 		= new WP_Query($args);
		
		$rate_1	= array('rating' => 0, 'total'=>0);
		$rate_2	= array('rating' => 0, 'total'=>0);
		$rate_3	= array('rating' => 0, 'total'=>0);
		$rate_4	= array('rating' => 0, 'total'=>0);
		$rate_5	= array('rating' => 0, 'total'=>0);
		
		//fw_print($query);
		while($query->have_posts()) : $query->the_post();
			global $post;
			$user_rating = fw_get_db_post_option($post->ID, 'user_rating', true);
			$user_from = fw_get_db_post_option($post->ID, 'user_from', true);
			$user_name = fw_get_db_post_option($post->ID, 'user_name', true);
			$review_date = fw_get_db_post_option($post->ID, 'review_date', true);
			$user_data 	  = get_user_by( 'id', intval( $user_from ) );
			
			if( $user_rating == 1 ){
				$rate_1['rating']   = $rate_1['rating']+$user_rating;   
				$rate_1['total']	= $rate_1['total']+ 1;   
			} else if( $user_rating == 2 ){
				$rate_2['rating']   = $rate_2['rating']+$user_rating;   
				$rate_2['total']	= $rate_2['total']+ 1;   
			} else if( $user_rating == 3 ){
				$rate_3['rating']   = $rate_3['rating']+$user_rating;   
				$rate_3['total']	= $rate_3['total']+ 1;   
			} else if( $user_rating == 4 ){
				$rate_4['rating']   = $rate_4['rating']+$user_rating;   
				$rate_4['total']	= $rate_4['total']+ 1;   
			} else if( $user_rating == 5 ){
				$rate_5['rating']   = $rate_5['rating']+$user_rating;   
				$rate_5['total']	= $rate_5['total'] + 1;   
			}

			$average_rating	= $average_rating + $user_rating;
			$average_count++;
		
		endwhile; wp_reset_postdata();

		$data['reviews']	= 0;
		$data['percentage']	= 0;
		if( isset( $average_rating ) && $average_rating > 0 ){
			$data['average_rating']	= $average_rating/$average_count;
			$data['reviews']	= $average_count;
			$data['percentage'] = ( $average_rating/ $average_count)*20;
			$data['by_ratings']	= array($rate_1,$rate_2,$rate_3,$rate_4,$rate_5);
		}
		
		return $data;
	}
	
}

/**
 * @Authenticate user
 * @return 
 */
if (!function_exists('docdirect_count_reviews')) {
	function docdirect_count_reviews( $user_id ='' ){
		$user_reviews = array(
			'posts_per_page'	=> "-1",
			'post_type'		 => 'docdirectreviews',
			'post_status'	   => 'publish',
			'meta_key'		  => 'user_to',
			'meta_value'		=> $user_id,
			'meta_compare'	  => "=",
			'orderby'		   => 'meta_value',
			'order'			 => 'ASC',
		);
		
		$reviews_query = new WP_Query($user_reviews);
		$reviews_count = $reviews_query->post_count;
		return intval( $reviews_count );
	}
	add_filter( 'docdirect_count_reviews', 'docdirect_count_reviews' );
}

/**
 * @Contact Doctor
 * @return 
 */
if (!function_exists('docdirect_submit_me')) {
	function docdirect_submit_me(){
		global $current_user;
		
		$json	= array();
		
		$do_check = check_ajax_referer( 'docdirect_contact_me', 'user_security', false );
		if( $do_check == false ){
			//Do something
		}
		
		$bloginfo 		   = get_bloginfo();
		$email_subject 	=  "(" . $bloginfo . ") Contact Form Received";
		$success_message 	= esc_html__('Message Sent.','docdirect');
		$failure_message 	= esc_html__('Message Fail.','docdirect');
		
		$recipient 	=  $_POST['email_to'];
		
		if( $_POST['email_to'] == '' ){
			$recipient = get_option( 'admin_email' ,'Aamirshahzad2009@live.com' );
		}
		
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the form fields and remove whitespace.
            
			if( $_POST['username'] == '' 
				|| $_POST['useremail'] == '' 
				|| $_POST['userphone'] == '' 
				|| $_POST['usersubject'] == '' 
				|| $_POST['user_description'] == ''
			){
				$json['type']	= 'error';
				$json['message']	= esc_html__('Please fill all fields.','docdirect');	
				echo json_encode($json);
				die;
			}
			
			if( ! docdirect_isValidEmail($_POST['useremail']) ){
				$json['type']	= 'error';
				$json['message']	= esc_html__('Email address is not valid.','docdirect');	
				echo json_encode($json);
				die;
			}
			
			$name	    = sanitize_text_field( $_POST['username'] );
			$email	  	= sanitize_text_field( $_POST['useremail'] );
			$subject	= sanitize_text_field( $_POST['usersubject'] );
			$phone	    = sanitize_text_field( $_POST['userphone'] );
			$message	= sanitize_text_field( $_POST['user_description'] );
			
            // Set the recipient email address.
            // FIXME: Update this to your desired email address.
            // Set the email subject.
            
			if( class_exists( 'DocDirectProcessEmail' ) ) {
				$email_helper	= new DocDirectProcessEmail();
				$emailData	   = array();
				$emailData['name']	  	       = $name;
				$emailData['email']			  = $email;
				$emailData['email_subject']	  = $email_subject;
				$emailData['subject']	  	    = $subject;
				$emailData['phone']	 		  = $phone;					
				$emailData['message']			= $message;
				$emailData['email_to']			= $recipient;
				
				$email_helper->process_contact_user_email( $emailData );
			}
			
            // Send the email.
            $json['type']    = "success";
			$json['message'] = esc_attr($success_message);
			echo json_encode( $json );
			die();
        } else {
            echo 
			$json['type']    = "error";
			$json['message'] = esc_attr($failure_message);
			echo json_encode( $json );
            die();
        }
		
	}
	
	add_action('wp_ajax_docdirect_submit_me','docdirect_submit_me');
	add_action( 'wp_ajax_nopriv_docdirect_submit_me', 'docdirect_submit_me' );
}

/**
 * @Submit Claim
 * @return 
 */
if (!function_exists('docdirect_submit_claim')) {
	function docdirect_submit_claim(){
		global $current_user;
		
		$json	= array();
		
		$do_check = check_ajax_referer( 'docdirect_claim', 'security', false);
		if( $do_check == false ){
			//Do something
		}
		
		$user_to	= isset( $_POST['user_to'] ) && !empty( $_POST['user_to'] ) ? $_POST['user_to'] : '';
		$user_from  = sanitize_text_field( $current_user->ID );
		
		$subject	= $_POST['subject'];
		$report	= $_POST['report'];
		
		if( empty( $subject ) 
			||
			empty( $report )  
			||
			empty( $user_to )  
			||
			empty( $user_from )  
		) {
			$json['type']	   = 'error';
			$json['message']	= esc_html__('Please fill all the fields.','docdirect');
			echo json_encode($json);
			die;
		}
		
		
		$claim_post = array(
			'post_title'  => $subject,
			'post_status' => 'publish',
			'post_content'=> $report,
			'post_author' => $user_from,
			'post_type'   => 'doc_claims',
			'post_date'   => current_time('Y-m-d H:i:s')
		);
		
		$post_id = wp_insert_post( $claim_post );

		$claim_meta = array(
			'subject' 	 => $user_rating,
			'user_from'   => $user_from,
			'user_to'   	 => $user_to,
			'report'  	  => $report,
		);
		
		//Update post meta
		foreach( $claim_meta as $key => $value ){
			update_post_meta($post_id,$key,$value);
		}
		
		$new_values = $claim_meta;
		
		if (isset($post_id) && !empty($post_id)) {
			fw_set_db_post_option($post_id, null, $new_values);
		}
		
		$json['type']	   = 'success';
		$json['message']	= esc_html__('Your report received successfully.','docdirect');
		echo json_encode($json);
		die;
	}
	
	add_action('wp_ajax_docdirect_submit_claim','docdirect_submit_claim');
	add_action( 'wp_ajax_nopriv_docdirect_submit_claim', 'docdirect_submit_claim' );
}


/**
 * @Locate Me Snipt
 * @return 
 */
if (!function_exists('docdirect_locateme_snipt')) {
	function docdirect_locateme_snipt(){
		if (function_exists('fw_get_db_settings_option')) {
			$dir_geo = fw_get_db_settings_option('dir_geo');
			$dir_radius = fw_get_db_settings_option('dir_radius');
			$dir_default_radius = fw_get_db_settings_option('dir_default_radius');
			$dir_max_radius = fw_get_db_settings_option('dir_max_radius');
		} else{
			$dir_geo = '';
			$dir_radius = '';
			$dir_default_radius = 50;
			$dir_max_radius = 300;
		}
		
		$dir_default_radius 	=  !empty($dir_default_radius) ?  $dir_default_radius : 50;
		$dir_max_radius 	=  !empty($dir_max_radius) ?  $dir_max_radius : 300;
		
		$location	= '';
		if( isset( $_GET['geo_location'] ) && !empty( $_GET['geo_location'] ) ){
			$location	= $_GET['geo_location'];
		}
		
		$distance	= $dir_default_radius;
		if( isset( $_GET['geo_distance'] ) && !empty( $_GET['geo_distance'] ) ){
			$distance	= $_GET['geo_distance'];
		}
		
		if (function_exists('fw_get_db_settings_option')) {
			$dir_distance_type = fw_get_db_settings_option('dir_distance_type');
		} else{
			$dir_distance_type = 'mi';
		}
		
		$distance_title = esc_html__('( Miles )','docdirect');
		if( $dir_distance_type === 'km' ) {
			$distance_title = esc_html__('( Kilometers )','docdirect');
		}
	?>
    	<div class="locate-me-wrap">
            <div id="location-pickr-map" class="elm-display-none"></div>
            <input type="text"  autocomplete="on" id="location-address" value="<?php echo esc_attr( $location );?>" name="geo_location" placeholder="<?php esc_html_e('Geo location','docdirect');?>" class="form-control">
            <?php if( isset( $dir_geo ) && $dir_geo === 'enable' ){?>
            <a href="javascript:;" class="geolocate"><img src="<?php echo get_template_directory_uri();?>/images/geoicon.svg" width="16" height="16" class="geo-locate-me" alt="<?php esc_html_e('Locate me!','docdirect');?>"></a>
            <?php }?>
            <?php if( isset( $dir_radius ) && $dir_radius === 'enable' ){?>
            <a href="javascript:;" class="geodistance"><i class="fa fa-angle-down" aria-hidden="true"></i></a>
            <div class="geodistance_range elm-display-none">
                <div class="distance-ml"><?php esc_html_e('Distance in','docdirect');?>&nbsp;<?php echo esc_attr( $distance_title );?><span><?php echo esc_js( $distance );?></span></div>
                <input type="hidden" name="geo_distance" value="<?php echo esc_js( $distance );?>" class="geo_distance" />
                <div class="geo_distance" id="geo_distance"></div>
            </div>
            <?php }?>
        </div>
        <?php if( isset( $dir_radius ) && $dir_radius === 'enable' ){?>
		<script>
			jQuery(document).ready(function(e) {
				jQuery( "#geo_distance" ).slider({
				   range: "min",
				   min:1,
				   max:<?php echo esc_js($dir_max_radius);?>,
				   value:<?php echo esc_js( $distance );?>,
				   animate:"slow",
				   orientation: "horizontal",
				   slide: function( event, ui ) {
					  jQuery( ".distance-ml span" ).html( ui.value );
					  jQuery( ".geo_distance" ).val( ui.value );
				   }	
				});
			});
		</script>
        <?php }?>
    <?php
	}
}

/*
 * @Fetch Data
 * @return 
 */
if (!function_exists('docdirect_map_controls')) {
	function docdirect_map_controls() {
		if (function_exists('fw_get_db_settings_option')) {
			$dir_map_scroll 	   = fw_get_db_settings_option('dir_map_scroll');
		} else{
			$dir_map_scroll = '';
		}

		$lock_icon	= 'fa fa-unlock';
		if( isset( $dir_map_scroll ) && $dir_map_scroll === 'false' ){
			$lock_icon	= 'fa fa-lock';
		}
		?>
        <div class="map-controls">
            <span id="doc-mapplus"><i class="fa fa-plus"></i></span>
            <span id="doc-mapminus"><i class="fa fa-minus"></i></span>
            <span id="doc-lock"><i class="<?php echo esc_attr( $lock_icon );?>"></i></span>
        </div>
        <?php
	}
	add_action( 'docdirect_map_controls', 'docdirect_map_controls');
}

/**
 * @Update add to favorites
 * @return 
 */
if (!function_exists('docdirect_update_wishlist')) {
	function docdirect_update_wishlist(){
		global $current_user;
		$wishlist	= array();
		$wishlist    = get_user_meta($current_user->ID,'wishlist', true);
		$wishlist    = !empty($wishlist) && is_array( $wishlist ) ? $wishlist : array();
		if( !empty( $_POST['wl_id'] ) ) {
			$wl_id		= $_POST['wl_id'];
			$wishlist[]	= $wl_id;
			$wishlist = array_unique($wishlist);
			update_user_meta($current_user->ID,'wishlist',$wishlist);
			
			$json	= array();
			$json['type']	= 'success';
			$json['message']	= esc_html__('Successfully! added to your wishlist','docdirect');
			echo json_encode($json);
			die();
		}
		
		$json	= array();
		$json['type']	= 'error';
		$json['message']	= esc_html__('Oops! something is going wrong.','docdirect');
		echo json_encode($json);
		die();
	}
	add_action('wp_ajax_docdirect_update_wishlist','docdirect_update_wishlist');
	add_action( 'wp_ajax_nopriv_docdirect_update_wishlist', 'docdirect_update_wishlist' );
	
}

/**
 * @Update add to favorites
 * @return 
 */
if (!function_exists('docdirect_remove_wishlist')) {
	function docdirect_remove_wishlist(){
		global $current_user;
		$wishlist	= array();
		$wishlist    = get_user_meta($current_user->ID,'wishlist', true);
		$wishlist    = !empty($wishlist) && is_array( $wishlist ) ? $wishlist : array();
		
		if( !empty( $_POST['wl_id'] ) ) {
			$wl_id	= array();
			$wl_id[]  = $_POST['wl_id'];
			$wishlist = array_diff( $wishlist , $wl_id );	
			update_user_meta($current_user->ID,'wishlist',$wishlist);
			
			$json	= array();
			$json['type']	= 'success';
			$json['message']	= esc_html__('Successfully! removed from your wishlist','docdirect');
			echo json_encode($json);
			die();
		}
		
		$json	= array();
		$json['type']	= 'error';
		$json['message']	= esc_html__('Oops! something is going wrong.','docdirect');
		echo json_encode($json);
		die();
	}
	add_action('wp_ajax_docdirect_remove_wishlist','docdirect_remove_wishlist');
	add_action( 'wp_ajax_nopriv_docdirect_remove_wishlist', 'docdirect_remove_wishlist' );
	
}

/**
 * @add to wishlist button
 * @return 
 */
if (!function_exists('docdirect_get_wishlist_button')) {
	function docdirect_get_wishlist_button($post_id='',$echo=false,$view='v1'){
		global $current_user;
		if( isset( $post_id ) && $post_id != $current_user->ID ){
			$wishlist	= array();
			$wishlist    = get_user_meta($current_user->ID,'wishlist', true);
			$wishlist    = !empty($wishlist) && is_array( $wishlist ) ? $wishlist : array();
			
			if( isset( $view ) && $view === 'v2' ) {
				if( !empty( $post_id )&&  in_array( $post_id , $wishlist ) ){
					$wishlist_button	= '<a data-view_type="v2" class="doc-favoriteicon" href="javascript:;"><i class="fa fa-heart"></i></a>';
				} else{
					$wishlist_button	= '<a data-view_type="v2" class="doc-favoriteicon doc-notfavorite add-to-fav" data-wl_id="'.$post_id.'" href="javascript:;"><i class="fa fa-heart"></i></a>';
					
				}
			} else{
				if( !empty( $post_id )&&  in_array( $post_id , $wishlist ) ){
					$wishlist_button	= '<a data-view_type="v1" class="tg-dislike" href="javascript:;"><i class="fa fa-heart"></i></a>';
				} else{
					$wishlist_button	= '<a data-view_type="v1" class="tg-like add-to-fav" data-wl_id="'.$post_id.'" href="javascript:;"><i class="fa fa-heart"></i></a>';
				}
			}
			
			if( $echo == true ){
				echo force_balance_tags( $wishlist_button );
			} else{
				return force_balance_tags( $wishlist_button );
			}
		}
		
		return false;
	}
}

/**
 * @Get featuired tag
 * @return 
 */
if (!function_exists('docdirect_get_featured_tag')) {
	function docdirect_get_featured_tag($echo=false,$view='v1'){
		global $current_user;
		ob_start();
		if( isset( $view ) && $view === 'v2' ){
			?>
			<a class="doc-featuredicon" href="javascript:;"><i class="fa fa-bolt"></i><?php esc_html_e('featured','docdirect');?></a>
			<?php
		} else{
			?>
			<span class="tg-featuredtags">
				<a class="tg-featured" href="javascript:;"><?php esc_html_e('featured','docdirect');?></a>
			</span>
			<?php
		}
		if( $echo == true ){
			echo ob_get_clean();
		} else{
			return ob_get_clean();
		}
	}
}

/**
 * @Get verified tag
 * @return 
 */
if (!function_exists('docdirect_get_verified_tag')) {
	function docdirect_get_verified_tag($echo=false, $user_id = '',$view_type='svg',$view='v1'){
		global $current_user;
		
		if( !empty( $user_id ) ) {
			$featured_date  = get_user_meta($user_id, 'verify_user', true);
			if( isset( $featured_date ) && $featured_date === 'on' ) {
				ob_start();
				if( isset( $view ) && $view === 'v2' ){
					?>
                    	<a class="doc-featuredicon doc-verfiedicon" href="javascript:;"><i class="fa fa-shield"></i><?php esc_html_e('Verified','docdirect');?></a>
                    <?php
				} else{
					if( isset( $view_type ) && $view_type === 'simple' ){
					?>
						<li class="tg-varified"><a href="javascript:;"><i class="fa fa-shield"></i><span><?php esc_html_e('Verified','docdirect');?></span></a></li>
					
					<?php
					} else{?>
						<span class="user-verified">
							<svg id="Icon" xmlns="http://www.w3.org/2000/svg" width="74.875" height="21" viewBox="0 0 74.875 21"> <defs>
							<style>.cls-1{fill:#10a64a}.cls-2{font-size:16px;text-anchor:middle;font-family:FontAwesome;text-transform:uppercase}.cls-2,.cls-3{fill:#fff}.cls-3{font-size:14.437px;font-family:Montserrat}</style></defs> 
							<rect id="BG" class="cls-1" width="74.875" height="21" rx="3" ry="3"/> <text id="_" data-name="" class="cls-2" transform="translate(14.829 14.99) scale(0.737 0.762)"></text> 
							<text id="Verified" class="cls-3" transform="translate(22.787 15.191) scale(0.737 0.762)"><?php esc_html_e('Verified','docdirect');?></text> </svg>
		
						</span>
					<?php }
				}
				
				if( $echo == true ){
					echo ob_get_clean();
				} else{
					return ob_get_clean();
				}
			}
		}
	}
}


/**
 * @Privacy Settings
 * @return {}
 */
if ( ! function_exists( 'docdirect_get_privacy_settings' ) ) {
	function docdirect_get_privacy_settings($user_identity) {
		global $current_user, $wp_roles,$userdata,$post;
		$docdirect_privacy	=  array();
		if(isset($user_identity) && $user_identity <> ''){
			$docdirect_privacy = get_user_meta($user_identity , 'privacy' , true);
		}
		return $docdirect_privacy;
	}
}

/**
 * @Get user rating stars
 * @return {}
 */
if ( ! function_exists( 'docdirect_get_rating_stars' ) ) {
	function docdirect_get_rating_stars($review_data='',$return_type='echo',$show_rating='show') {
		global $current_user;
		ob_start();
		?>
        <div class="feature-rating user-star-rating">
            <span class="tg-stars star-rating">
                <span style="width:<?php echo esc_attr( $review_data['percentage'] );?>%"></span>
            </span>
            
            <?php 
				if( isset( $show_rating ) && $show_rating === 'show' ){
					if( !empty( $review_data['average_rating'] ) ){?>
					<em><?php echo number_format((float)$review_data['average_rating'], 1, '.', '');?><sub>/5</sub></em>
			<?php }}?>
        </div>
        <?php
		if( $return_type === 'return' ){
			return ob_get_clean();
		} else{
			echo ob_get_clean();
		}
	}
}

/**
 * @Get user rating stars v2
 * @return {}
 */
if ( ! function_exists( 'docdirect_get_rating_stars_v2' ) ) {
	function docdirect_get_rating_stars_v2($review_data='',$return_type='echo',$show_rating='show') {
		global $current_user;
		ob_start();
		?>
        	<li><span class="doc-stars"><span style="width:<?php echo esc_attr( $review_data['percentage'] );?>%"></span></span></li>
        <?php
		if( $return_type === 'return' ){
			return ob_get_clean();
		} else{
			echo ob_get_clean();
		}
	}
}

/**
 * @Set User Views
 * @return {}
 */
if ( ! function_exists( 'docdirect_set_user_views' ) ) {
	function docdirect_set_user_views($userID) {
		$count_key = 'doc_user_views_count';
		$count = get_user_meta($userID , $count_key , true);
		
		if ( isset($_COOKIE["user_views_" . $userID]) ) { 
			//Cookie already set, nothing to do
		} else{
			setcookie("user_views_" . $userID , 'user_views' , time() + 3600);

			if( $count=='' ){
				$count = 0;
				update_user_meta( $userID, $count_key, $count );
			}else{
				$count++;
				update_user_meta( $userID, $count_key, $count );
			}
		}
					
		
	}
	
	//To keep the count accurate, lets get rid of prefetching
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
}

/**
 * @Set User Views
 * @return {}
 */
if ( ! function_exists( 'docdirect_get_user_views' ) ) {
	function docdirect_get_user_views($userID){
		$count_key = 'doc_user_views_count';
		$count = get_user_meta($userID , $count_key , true);
		if($count==''){
			$count = 0;
			update_user_meta( $userID, $count_key, $count );
			return $count;
		}
		return $count;
	}
}

/**
 * Check user type
 *
 * @param json
 * @return string
 */
if ( ! function_exists( 'docdirect_is_visitor' ) ) {
	function docdirect_is_visitor($user_id='') {
		global $current_user, $wp_roles,$userdata,$post;
		
		$user_identity	= $current_user->ID;	
		$user = get_userdata( $user_id );
    	
		if( !empty( $user->roles[0] ) && $user->roles[0] === 'visitor' ){
			return true;
		} else{
			return false;
		}
	}
	add_filter( 'docdirect_is_visitor', 'docdirect_is_visitor', 10, 3 );
}

/**
 * @Set User Views
 * @return {}
 */
if ( ! function_exists( 'docdirect_remove_parent_from_category' ) ) {
	add_action( 'admin_head-edit-tags.php', 'docdirect_remove_parent_from_category' );
	add_action( 'admin_head-term.php', 'docdirect_remove_parent_from_category' );
	function docdirect_remove_parent_from_category(){
		if ( 'locations' != $_GET['taxonomy']
			 && 'specialities' != $_GET['taxonomy']
			 && 'insurance' != $_GET['taxonomy']
		) {
			return;
		}
	
		$parent = 'parent()';
	
		if ( isset( $_GET['tag_ID'] ) && !empty( $_GET['tag_ID'] ) )
			$parent = 'parent().parent()';
	
		?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery('label[for=parent]').<?php echo ( $parent ); ?>.remove();       
				});
			</script>
		<?php
	}
}
/**
 * @Set User Views
 * @return {}
 */
if ( ! function_exists( 'docdirect_date_24midnight' ) ) {
	function docdirect_date_24midnight($format,$ts){
	   if( date("Hi",$ts) == "0000") {
		  $replace = array(
			"H" => "24",
			"G" => "24",
			"i" => "00",
		  );
	
		  return date(
			str_replace(
			  array_keys($replace),
			  $replace, 
			  $format
			),
			$ts-60 // take a full minute off, not just 1 second
		  );
	   } else {
		  return date($format,$ts);
	   }
	}
}

/**
 * @parse URL
 * @return {}
 */
if ( ! function_exists( 'docdirect_parse_url' ) ) {
	function docdirect_parse_url($url){
		$input = trim($url, '/');
		
		// If scheme not included, prepend it
		if (!preg_match('#^http(s)?://#', $input)) {
			$input = 'http://' . $input;
		}
		
		$urlParts = parse_url($input);
		
		// remove www
		//$domain = preg_replace('/^www\./', '', $urlParts['host']);
		
		return !empty( $urlParts['host'] ) ? $urlParts['host'] : $url;
	}
}

/**
 * @get author slugs
 * @return {}
 */
if ( ! function_exists( 'docdirect_get_users_base_slug' ) ) {
	function docdirect_get_users_base_slug(){
		$slug = 'user';
		if (function_exists('fw_get_db_settings_option')) {
			$slug = fw_get_db_settings_option('user_page_slug', $default_value = 'user');
		}
		
		$author_slug = $slug; // change slug name
		
		$author_levels	= array($author_slug);
		$args = array('posts_per_page' => '-1', 
					   'post_type' => 'directory_type', 
					   'post_status' => 'publish',
					   'suppress_filters' => false
				);
		
		$cust_query = get_posts($args);
		if( isset( $cust_query ) && !empty( $cust_query ) ) {
		  $author_levels	= array('');
		  $counter	= 0;
		  foreach ($cust_query as $key => $dir) {
			 $author_levels[]	= $dir->post_name;
		  }	
		}
		
		
		return $author_levels;
	}
}

/**
 * @prepare auhtor slugs
 * @return {}
 */
if ( ! function_exists( 'docdirect_prepare_users_base' ) ) {	
	add_action( 'init', 'docdirect_prepare_users_base' );
	function docdirect_prepare_users_base(){
		global $wp_rewrite;
		$author_levels = docdirect_get_users_base_slug();
		// Define the tag and use it in the rewrite rule
		add_rewrite_tag( '%author_level%', '(' . implode( '|', $author_levels ) . ')' );
		$wp_rewrite->author_base = '%author_level%';
		$wp_rewrite->flush_rules();
	}
}

/**
 * @refine author base if username and base matched eg : anything/anything
 * @return {}
 */
if ( ! function_exists( 'docdirect_prepare_users_base' ) ) {	
	add_filter( 'author_rewrite_rules', 'wpse17106_author_rewrite_rules' );
	function wpse17106_author_rewrite_rules( $author_rewrite_rules )
	{
		foreach ( $author_rewrite_rules as $pattern => $substitution ) {
			if ( FALSE === strpos( $substitution, 'author_name' ) ) {
				unset( $author_rewrite_rules[$pattern] );
			}
		}
		return $author_rewrite_rules;
	}
}

/**
 * @refine author base if username and base matched eg : anything/anything
 * @return {}
 */
if ( ! function_exists( 'docdirect_get_user_refined_link' ) ) {
	add_filter( 'author_link', 'docdirect_get_user_refined_link', 10, 2 );
	function docdirect_get_user_refined_link( $link, $author_id ){
		$author_level = 'user';
		if ( 1 == $author_id ) {
			//return nothing
		} else {
			$db_directory_type	 = get_user_meta( $author_id, 'directory_type', true);
			if( !empty( $db_directory_type ) ){
				$postdata = get_post($db_directory_type); 
				$slug 	 = $postdata->post_name;
				$author_level = $slug;
			} else{
				$slug = 'user';
				if (function_exists('fw_get_db_settings_option')) {
					$slug = fw_get_db_settings_option('user_page_slug', $default_value = 'user');
				}
				$author_slug = $slug; // change slug name
				$author_level = $author_slug;
			}
		}
		
		$link = str_replace( '%author_level%', $author_level, $link );
		return $link;
	}
}

/**
* @refine author base if username and base matched eg : anything/anything
* @return {}
*/
if ( ! function_exists( 'docdirect_get_username' ) ) {
	function docdirect_get_username($user_id=''){
		$first_name	  = get_user_meta( $user_id, 'first_name', true);
		$last_name	  = get_user_meta( $user_id, 'last_name', true);
		return $first_name.' '.$last_name;
	}
}


/**
 * @User manage columns 
 * @return 
 */
if ( !function_exists('docdirect_user_manage_user_columns') )  {
	add_filter('manage_users_columns', 'docdirect_user_manage_user_columns');
	
	function docdirect_user_manage_user_columns($column) {
		$column['type'] = esc_html__('User Type','docdirect');
		$column['status'] = esc_html__('Status','docdirect');
		return $column;
	}
}

/**
 * @User column data
 * @return 
 */
if ( !function_exists('docdirect_user_manage_user_column_row') )  {
	add_filter('manage_users_custom_column', 'docdirect_user_manage_user_column_row', 10, 3);
	
	function docdirect_user_manage_user_column_row($val, $column_name, $user_id) {
		$user = get_userdata($user_id);
	
		$user_type	= esc_html__('Visitor/Patient','docdirect');
		if( isset( $user->directory_type ) && !empty( $user->directory_type ) ){
			$user_type	= get_the_title( $user->directory_type );
		}
		
		switch ($column_name) {
			case 'status' :
				$status = get_user_meta($user_id, 'verify_user', true);
				$val = '<span style="color:red;">' . esc_html__('Not Verified', 'docdirect') . '</span>';
				if (isset( $status ) && $status === 'on') {
					$val = '<span style="color:green;">' . esc_html__('Verified', 'docdirect') . '</span>';
				}
				return $val;
				break;
			case 'type' :
					return $user_type;
					break;
			default:
		}
	}
}

/**
 * @User Row action
 * @return 
 */
if ( !function_exists('docdirect_user_user_table_action_links') )  {
	add_filter('user_row_actions', 'docdirect_user_user_table_action_links', 10, 2);
	
	function docdirect_user_user_table_action_links($actions, $user) {
		$is_approved = get_user_meta($user->ID, 'verify_user', true);
		
		$actions['docdirect_status'] = "<a style='color:" . ((isset( $is_approved ) && $is_approved === 'off') ? 'green' : 'red') . "' href='" . esc_url(admin_url("users.php?action=docdirect_change_status&users=" . $user->ID . "&nonce=" . wp_create_nonce('docdirect_change_status_' . $user->ID))) . "'>" . ((isset( $is_approved ) && $is_approved === 'off') ? esc_html__('Approve', 'docdirect') : esc_html__('Unapprove', 'docdirect')) . "</a>";
		return $actions;
	}
}

/**
 * @verify users status
 * @return 
 */
if ( !function_exists('docdirect_change_status') )  {
	add_action('admin_action_docdirect_change_status', 'docdirect_change_status');
	function docdirect_change_status() {
		
		if (isset($_REQUEST['users']) && isset($_REQUEST['nonce'])) {
			$nonce = $_REQUEST['nonce'];
			$users = $_REQUEST['users'];
			
			if (wp_verify_nonce($nonce, 'docdirect_change_status_' . $users)) {
				$is_approved = get_user_meta($users, 'verify_user', true);
				if ( isset( $is_approved ) && $is_approved === 'on' ) {
					 $new_status = 'off';
					 $message_param = 'unapproved';
				} else {
					$new_status = 'on';
					$message_param = 'approved';
				}
				update_user_meta($users, 'verify_user', $new_status);
				$redirect = admin_url('users.php?updated=' . $message_param);
			} else {
				$redirect = admin_url('users.php?updated=docdirect_false');
			}
		} else {
			$redirect = admin_url('users.php?updated=docdirect_false');
		}
		wp_redirect($redirect);
	}
}

/**
 * @Admmin notices
 * @return 
 */
if ( !function_exists('docdirect_user_change_status_notices') )  {
	add_action('admin_notices', 'docdirect_user_change_status_notices');
	function docdirect_user_change_status_notices() {
		global $pagenow;
		if ($pagenow == 'users.php') {
			if (isset($_REQUEST['updated'])) {
				$message = $_REQUEST['updated'];
				if ($message == 'docdirect_false') {
					print '<div class="updated notice error is-dismissible"><p>' . esc_html__('Something wrong. Please try again.', 'docdirect') . '</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">' . esc_html__('Dismiss this notice.', 'docdirect') . '</span></button></div>';
				}
				if ($message == 'approved') {
					print '<div class="updated notice is-dismissible"><p>' . esc_html__('User approved.', 'docdirect') . '</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">' . esc_html__('Dismiss this notice.', 'docdirect') . '</span></button></div>';
				}
				if ($message == 'unapproved') {
					print '<div class="updated notice is-dismissible"><p>' . esc_html__('User unapproved.', 'docdirect') . '</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">' . esc_html__('Dismiss this notice.', 'docdirect') . '</span></button></div>';
				}
			}
		}
	}
}


/**
 * @gete like and button button
 * @return 
 */
if (!function_exists('docdirect_get_likes_button')) {
	function docdirect_get_likes_button($user_id='',$echo=true){
		global $current_user;
		if( isset( $user_id ) && $user_id != $current_user->ID ){
			
			$likes	= array();
			$likes    = get_user_meta($current_user->ID,'user_likes', true);
			$likes    = !empty($likes) && is_array( $likes ) ? $likes : array();
			
			$count_key = 'doc_user_likes_count';
			$count     = get_user_meta($user_id , $count_key , true);
			
			$count	= !empty( $count ) ? $count : 0;
			
			if ( isset($_COOKIE["user_likes_" . $user_id]) ) { 
				$likes_button	= '<a href="javascript:;" class="user-liked"><i class="fa fa-thumbs-up"></i>'.$count.'</a>';
			} else{
				$likes_button	= '<a href="javascript:;" class="do-like-me" data-like_id="'.$user_id.'"><i class="fa fa-thumbs-up"></i>'.$count.'</a>';
			}
		

			if( $echo == true ){
				echo force_balance_tags( $likes_button );
			} else{
				return force_balance_tags( $likes_button );
			}
		}
		
		return false;
	}
}


/**
 * @Get likes
 * @return {}
 */
if ( ! function_exists( 'docdirect_set_likes' ) ) {
	function docdirect_set_likes(){
		$like_id	= !empty( $_POST['like_id'] ) ?  $_POST['like_id'] : 0;
		$json	= array();
		$data	= '';
		$count	= 0;
		$count_key = 'doc_user_likes_count';
		
		if( !empty( $like_id ) ) {
			$count     = get_user_meta($like_id , $count_key , true);
			$count	= !empty( $count ) ? $count : 0;
			
			if ( isset($_COOKIE["user_likes_" . $like_id]) ) { 
				//Cookie already set, nothing to do
			} else{
				setcookie("user_likes_" . $like_id , 'user_likes' , time()+31556926,'/');
				if( empty( $count ) ){
					$count = 1;
					update_user_meta( $like_id, $count_key, $count );
				}else{
					$count++;
					update_user_meta( $like_id, $count_key, $count );
				}
			}
			
			ob_start();
			
			echo '<a href="javascript:;" class="user-liked"><i class="fa fa-thumbs-up"></i>'.$count.'</a>';
			
			$data	= ob_get_clean();
			
			$type	= 'success';
		
		} else{
			$type	= 'error';
		}
		
		$json['html']	= $data;
		$json['type']	= $type;
		echo json_encode($json);
		die;
	}
	
	add_action('wp_ajax_docdirect_set_likes','docdirect_set_likes');
	add_action( 'wp_ajax_nopriv_docdirect_set_likes', 'docdirect_set_likes' );
}

/**
 * @get distance between two points
 * @return array
 */
if (!function_exists('docdirectGetDistanceBetweenPoints')) {
	function docdirectGetDistanceBetweenPoints($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Km') {
		 $theta = $longitude1 - $longitude2;
		 $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
		 $distance = acos($distance);
		 $distance = rad2deg($distance);
		 $distance = $distance * 60 * 1.1515; switch($unit) {
			  case 'Mi': break;
			  case 'Km' : $distance = $distance * 1.60934;
		 }
		 return (round($distance,2)).'&nbsp;'. strtolower( $unit );
	}
}

/**
 * @Sort by distance
 * @return array
 */
if (!function_exists('docdirect_search_by_distance_filter')) {
	add_action( 'pre_user_query', 'docdirect_search_by_distance_filter' );
	function docdirect_search_by_distance_filter( $user_query ) {
		global $wpdb;
	
		if( is_page_template('directory/user_search.php') ){
		
			if( !empty( $_GET['geo_location'] ) 
				&&
				isset( $_GET['sort_by'] )
				&& 
				$_GET['sort_by'] == 'distance'
			) {
				$args = array(
					'timeout'     => 15,
					'headers' => array('Accept-Encoding' => ''),
					'sslverify' => false
				);
				
				$address	 = sanitize_text_field($_GET['geo_location']);
				$prepAddr	 = str_replace(' ','+',$address);
		
				$url	 	= 'http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false';
				$response   = wp_remote_get( $url, $args );
				$geocode	= wp_remote_retrieve_body($response);
				$output	    = json_decode($geocode);
				
				if( isset( $output->results ) && !empty( $output->results ) ) {
					$Latitude	= $output->results[0]->geometry->location->lat;
					$Longitude  = $output->results[0]->geometry->location->lng;
				}
				
			   $geo_location	= $_GET['geo_location'];
			   
			   if( isset( $Latitude ) &&  $Latitude !=''
					&& 
				   isset( $Longitude ) &&  $Longitude !=''
			   ) {
				   $user_query->query_fields .= ", geo_search1.meta_value as lat, geo_search2.meta_value as lon, 
												( 3959 * acos( cos( radians( $Latitude ) ) 
												* cos( radians( geo_search1.meta_value ) ) 
												* cos( radians( geo_search2.meta_value ) 
												- radians( $Longitude ) ) 
												+ sin( radians( $Latitude ) ) 
												* sin( radians( geo_search1.meta_value ) ) ) ) * 1.60934 AS distance";  // additional fields 
												
				   $user_query->query_from .= " INNER JOIN ".$wpdb->prefix."usermeta AS geo_search1 ON ( ".$wpdb->prefix."users.ID = geo_search1.user_id ) AND geo_search1.meta_key = 'latitude' "; // additional joins here
				   $user_query->query_from .= " INNER JOIN ".$wpdb->prefix."usermeta AS geo_search2 ON ( ".$wpdb->prefix."users.ID = geo_search2.user_id ) AND geo_search2.meta_key = 'longitude' "; // additional joins here
				  
				   //$user_query->query_where .= ' distance '; // additional where clauses
				   $user_query->query_orderby  = ' ORDER BY distance ASC '; // additional sorting
				   //$user_query->query_limit .= ''; // if you need to adjust paging
			   }
			} else if( !empty( $_COOKIE['geo_location'] )
				&&
				isset( $_GET['sort_by'] )
				&& 
				$_GET['sort_by'] == 'distance'
			){
				$geo_location	= explode('|',$_COOKIE['geo_location']);
				
				$Latitude	= !empty( $geo_location[0] ) ? $geo_location[0] : '';
				$Longitude	= !empty( $geo_location[1] ) ? $geo_location[1] : '';
				
				if( isset( $Latitude ) &&  $Latitude !=''
					&& 
				   isset( $Longitude ) &&  $Longitude !=''
				) {
				   $user_query->query_fields .= ", geo_search1.meta_value as lat, geo_search2.meta_value as lon, 
												( 3959 * acos( cos( radians( $Latitude ) ) 
												* cos( radians( geo_search1.meta_value ) ) 
												* cos( radians( geo_search2.meta_value ) 
												- radians( $Longitude ) ) 
												+ sin( radians( $Latitude ) ) 
												* sin( radians( geo_search1.meta_value ) ) ) ) * 1.60934 AS distance";  // additional fields 
												
				   $user_query->query_from .= " INNER JOIN ".$wpdb->prefix."usermeta AS geo_search1 ON ( ".$wpdb->prefix."users.ID = geo_search1.user_id ) AND geo_search1.meta_key = 'latitude' "; // additional joins here
				   $user_query->query_from .= " INNER JOIN ".$wpdb->prefix."usermeta AS geo_search2 ON ( ".$wpdb->prefix."users.ID = geo_search2.user_id ) AND geo_search2.meta_key = 'longitude' "; // additional joins here
				  
				   //$user_query->query_where .= ' distance '; // additional where clauses
				   $user_query->query_orderby  = ' ORDER BY distance ASC '; // additional sorting
				   //$user_query->query_limit .= ''; // if you need to adjust paging
			   }
			}
		
		  }
	  return $user_query;
	}
}

/**
 * @Sort by distance
 * @return array
 */
if (!function_exists('docdirect_search_filters')) {
	add_action( 'docdirect_search_filters', 'docdirect_search_filters' );
	function docdirect_search_filters() {
	$zip_code	= isset( $_GET['zip'] ) ? $_GET['zip'] : '';
	$by_name	 = isset( $_GET['by_name'] ) ? $_GET['by_name'] : '';
	$args = array('posts_per_page' => '-1', 
				   'post_type' => 'directory_type', 
				   'post_status' => 'publish',
				   'suppress_filters' => false
			);
	
	$cust_query = get_posts($args);
	
	
	$dir_search_page 		= fw_get_db_settings_option('dir_search_page');
	$dir_search_pagination  = fw_get_db_settings_option('dir_search_pagination');
	$dir_longitude 			= fw_get_db_settings_option('dir_longitude');
	$dir_latitude 			= fw_get_db_settings_option('dir_latitude');
	$google_key 			= fw_get_db_settings_option('google_key');
	
	$dir_keywords 			= fw_get_db_settings_option('dir_keywords');
	$zip_code_search 		= fw_get_db_settings_option('zip_code_search');
	$dir_location 			= fw_get_db_settings_option('dir_location');
	$dir_radius 			= fw_get_db_settings_option('dir_radius');
	$language_search 		= fw_get_db_settings_option('language_search');
	$dir_search_cities 		= fw_get_db_settings_option('dir_search_cities');
	
	
	$dir_longitude			= !empty( $dir_longitude ) ? $dir_longitude : '-0.1262362';
	$dir_latitude		 	= !empty( $dir_latitude ) ? $dir_latitude : '51.5001524';
	
	$insurance  	   = !empty( $_GET['insurance'] ) ? $_GET['insurance'] : '';
	$photos  	   	   = !empty( $_GET['photos'] ) ? $_GET['photos'] : '';
	$appointments      = !empty( $_GET['appointments'] ) ? $_GET['appointments'] : '';
	$city      		   = !empty( $_GET['city'] ) ? $_GET['city'] : '';
	
	
	if( isset( $dir_search_page[0] ) && !empty( $dir_search_page[0] ) ) {
		$search_page 	 = get_permalink((int)$dir_search_page[0]);
	} else{
		$search_page 	 = '';
	}
	
	$languages_array	= docdirect_prepare_languages();//Get Language Array

	?>
	<div class="search-filters-wrap">
       <div class="doc-widget doc-widgetsearch">
          <div class="doc-widgetheading">
            <h2><?php esc_html_e('Narrow your search','docdirect');?></h2>
          </div>
          <div class="doc-widgetcontent">
              <fieldset>
                <?php if( isset( $dir_keywords ) && $dir_keywords === 'enable' ){?>
                  <div class="form-group">
                    <input type="text" class="form-control" value="<?php echo esc_attr( $by_name );?>" name="by_name" placeholder="<?php esc_html_e('Type Keyword...','docdirect');?>">
                  </div>
                <?php }?>
                <div class="form-group">
                  <div class="doc-select">
                    <select class="directory_type" name="directory_type">
                      <option value=""><?php esc_html_e('Category','docdirect');?></option>
                      <?php
                        $parent_categories['categories']	= array();
                        $json			= array();
                        $directories	 = '';
                        if( isset( $cust_query ) && !empty( $cust_query ) ) {
                          $counter	= 0;
                          
                          foreach ($cust_query as $key => $dir) {
                            $counter++;
                            $title = get_the_title($dir->ID);
                            $dir_icon = fw_get_db_post_option($dir->ID, 'dir_icon', true);
                            $dir_map_marker = fw_get_db_post_option($dir->ID, 'dir_map_marker', true);
        
                            if( isset( $dir->ID ) ){
                                $attached_specialities = get_post_meta( $dir->ID, 'attached_specialities', true );
                                $subarray	= array();
                                if( isset( $attached_specialities ) && !empty( $attached_specialities ) ){
                                    foreach( $attached_specialities as $key => $speciality ){
                                        if( !empty( $speciality ) ) {
                                            $term_data	= get_term_by( 'id', $speciality, 'specialities');
                                            if( !empty( $term_data ) ) {
                                                $subarray[$term_data->slug] = $term_data->name;
                                            }
                                        }
                                    }
                                }
                                
                                $json[$dir->ID]	= $subarray;
                            }
                            
                            
                            $parent_categories['categories']	= $json;
                            
                            $selected	= '';
                            
                            if( !empty( $_GET['directory_type'] ) ) {
                                $directory_check = docdirect_get_page_by_slug( $_GET['directory_type'], 'directory_type','id' );
                            } else{
                                $directory_check = '';
                            }
                        
                            if( isset( $directory_check ) && $directory_check == $dir->ID ){
                                $selected	= 'selected';
                            }
                            ?>
                            <option <?php echo esc_attr( $selected );?> data-dir_name="<?php echo esc_attr( $title );?>" id="<?php echo intval( $dir->ID );?>" value="<?php echo esc_attr( $dir->post_name );?>"><?php echo esc_attr( ucwords( $title ) );?></option>
                            <?php	
                          }
                        }
                     ?>	
                    </select>
                  </div>
                  <script>
				     
                    jQuery(document).ready(function() {
                        var Z_Editor = {};
                        Z_Editor.elements = {};
                        window.Z_Editor = Z_Editor;
                        Z_Editor.elements = jQuery.parseJSON( '<?php echo addslashes(json_encode(  $parent_categories['categories']));?>' );
						
						jQuery('select.directory_type').change(function(){
							var id		  = jQuery('option:selected', this).attr('id');		
							var dir_name	= jQuery(this).find(':selected').data('dir_name');

							if ( id === undefined || id === null) {
								jQuery( '.specialities-search-wrap' ).html('');
							}
					
							if( Z_Editor.elements[id] ) {
								var load_subcategories = wp.template( 'load-subcategories' );
								var data = [];
								data['childrens']	 = Z_Editor.elements[id];
								var _options		 = load_subcategories(data);
								jQuery( '.specialities-search-wrap' ).html(_options);
							}      
						});
						
						jQuery('select.directory_type').trigger('change');
                    });
                  </script> 
                  <script type="text/template" id="tmpl-load-subcategories">
                    <div class="doc-widget doc-widgetfilterspecialist">
                      <div class="doc-widgetheading">
                        <h2><?php esc_html_e('Filter By Specialities','docdirect'); ?></h2>
                      </div>
                      <div class="doc-widgetcontent">
                        <#
                            var _option	= '';
                            var browser_specialism = docdirectGetUrlParameter('speciality[]','yes');
                            if( !_.isEmpty(data['childrens']) ) {
                                _.each( data['childrens'] , function(element, index, attr) {
                                        var _checked	= '';
                                        if(jQuery.inArray(index,browser_specialism) !== -1){
                                            var _checked	= 'checked';
                                        }
                                     #>
                                     <div class="doc-checkbox">
                                        <input type="checkbox" name="speciality[]" {{_checked}} value="{{index}}" id="speciality-{{index}}">
                                        <label for="speciality-{{index}}">{{element}}</label>
                                     </div>
                                <#	
                                });
                            }
                        #>
                      </div>
                      <input type="submit" class="doc-btn" value="<?php esc_html_e('Refine Search','docdirect'); ?>">
                    </div>
                </script> 
                </div>
                <?php if( isset( $dir_search_insurance ) && $dir_search_insurance === 'enable' ){?>
                <div class="form-group">
                  <div class="doc-select">
                    <select name="insurance" class="chosen-select">
                        <option value=""><?php esc_attr_e('Select insurance','docdirect');?></option>
                        <?php docdirect_get_term_options($insurance,'insurance');?>
                    </select>
                  </div>
                </div>
                <?php }?>
                <?php if( isset( $dir_location ) && $dir_location === 'enable' ){?>
                  <div class="form-group">
                    <div class="tg-inputicon tg-geolocationicon tg-angledown">
                        <?php docdirect_locateme_snipt();?>
                        <script>
                            jQuery(document).ready(function(e) {
                                //init
                                jQuery.docdirect_init_map(<?php echo esc_js( $dir_latitude );?>,<?php echo esc_js( $dir_longitude );?>);
                            });
                        </script> 
                     </div>
                  </div>
                <?php }?>
                <?php if( !empty( $zip_code_search ) && $zip_code_search === 'enable' ){?>
                  <div class="form-group">
                    <input type="text" class="form-control" value="<?php echo esc_attr( $zip_code );?>" name="zip" placeholder="<?php esc_html_e('Search users by zip code','docdirect');?>">
                  </div>
                <?php }?>
                <?php if( !empty( $dir_search_cities ) && $dir_search_cities === 'enable' ){?>
                <div class="form-group">
                    <div class="doc-select">
                      <select name="city" class="chosen-select">
                        <option value=""><?php esc_attr_e('Select city','docdirect');?></option>
                        <?php docdirect_get_term_options($city,'locations');?>
                      </select>
                   </div>
                </div>
                <?php }?>
                <?php if( isset( $language_search ) && $language_search === 'enable' ){?>
                <?php  if( isset( $languages_array ) && !empty( $languages_array ) ){?>
                <div class="form-group">
                  <div class="doc-select">     
                     <select name="languages[]" class="chosen-select" data-placeholder="<?php esc_attr_e('Select languages','docdirect');?>" multiple>
                     <?php 
                        foreach( $languages_array as $key=>$value ){
                            $selected	= '';
                            if( !empty( $_GET['languages'] ) && in_array( $key , $_GET['languages']) ){
                                $selected	= 'selected';
                            }
                            ?>
                            <option <?php echo esc_attr( $selected );?> value="<?php echo esc_attr( $key );?>"><?php echo esc_attr( $value );?></option>
                     <?php }?>
                    </select>
                   </div>
                </div>
                <?php }?>
                <?php }?>
                <div class="doc-checkbox">
                  <input type="checkbox" name="photos" <?php echo isset( $photos ) && $photos === 'true' ? 'checked' : '';?> id="photos" value="true">
                  <label for="photos"><?php esc_html_e('All With Profile Photos','docdirect');?></label>
                </div>
                <div class="doc-checkbox">
                  <input type="checkbox" name="appointments" <?php echo isset( $appointments ) && $appointments === 'true' ? 'checked' : '';?> id="appointment" value="true">
                  <label for="appointment" ><?php esc_html_e('Online Appointment','docdirect');?></label>
                </div>
                <div class="doc-btnarea">
                  <button class="doc-btn" type="submit"><?php esc_html_e('Apply Filter','docdirect');?></button>
                  <button class="doc-btn" type="submit"><?php esc_html_e('Reset Filter','docdirect');?></button>
                  <input type="hidden" name="view" value="<?php echo !empty($_GET['view'] ) ? $_GET['view'] : '';?>" />
                </div>
              </fieldset>
          </div>
        </div>
		<div class="specialities-search-wrap"></div>
	</div>
    <?php
	}
}