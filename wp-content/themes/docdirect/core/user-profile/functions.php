<?php
/**
 * User Admin Profile
 * return html
 */


/**
 * @User Public Profile
 * @return {}
 */
if (!function_exists('docdirect_edit_user_profile_edit')) {

    function docdirect_edit_user_profile_edit($user_identity) {
        $display_img_url = '';
        $display = $display_image = 'block';
        
		$display_img_url = docdirect_get_user_avatar(0, $user_identity->ID,'userprofile_media');
		$thumb_id	= get_user_meta($user_identity->ID, 'userprofile_media', true);
        
		if ( empty( $display_img_url )) {
            $display_image = 'elm-display-none';
        }
		
		//Banner
		$display_banner_url = '';
        $display_banner = 'block';
        
		$display_banner_url = docdirect_get_user_banner(0, $user_identity->ID,'userprofile_banner');
		$banner_thumb_id	= get_user_meta($user_identity->ID, 'userprofile_banner', true);
        
		if ( empty( $display_banner_url )) {
            $display_banner = 'elm-display-none';
        }
		
        ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th> <?php esc_html_e('Display Photo', 'docdirect'); ?></th>
                    <td>
                        <input type="hidden" name="userprofile_media" class="media-image" id="userprofile_media"  value="<?php echo intval( $thumb_id ); ?>" />
                        <input type="button" id="upload-user-avatar" class="button button-secondary" value="<?php esc_html_e('Uplaod Public Avatar','docdirect');?>" />
                    </td>
                </tr>
                <tr id="avatar-wrap" class="<?php echo esc_attr($display_image); ?>">
                    <td class="backgroud-image">
                        <a href="javascript:;" class="delete-auhtor-media"><i class="fa fa-times"></i></a>
						<img class="avatar-src-style" height="100px" src="<?php echo esc_url($display_img_url); ?>" id="avatar-src" />
						
                    </td>
                </tr>
            </tbody>
        </table>
        <?php if( apply_filters('docdirect_do_check_user_type',$user_identity->ID ) === true ){?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th> <?php esc_html_e('Profile banner', 'docdirect'); ?></th>
                    <td>
                        <input type="hidden" name="userprofile_banner" class="media-image" id="userprofile_banner"  value="<?php echo intval( $banner_thumb_id ); ?>" />
                        <input type="button" id="upload-user-banner" class="button button-secondary" value="<?php esc_html_e('Profile banner','docdirect');?>" />
                    </td>
                </tr>
                <tr id="banner-wrap" class="<?php echo esc_attr($display_banner); ?>">
                    <td class="backgroud-image">
                        <a href="javascript:;" class="delete-auhtor-banner"><i class="fa fa-times"></i></a>
						<img class="banner-src-style" height="100px" src="<?php echo esc_url($display_banner_url); ?>" id="banner-src" />
						
                    </td>
                </tr>
            </tbody>
        </table>
        <?php }?>
        <?php
		if( apply_filters('docdirect_do_check_user_type',$user_identity->ID ) === true ){
			get_template_part('core/user-profile/user','schedules');
			get_template_part('core/user-profile/user','account-settings');
		}
    }

}

/**
 * @User Public Profile Save
 * @return {}
 */
if (!function_exists('docdirect_personal_options_save')) {

    function docdirect_personal_options_save($user_identity) {
        $current_date	= date('Y-m-d H:i:s');
		$userprofile_media = (isset($_POST['userprofile_media']) && $_POST['userprofile_media'] <> '') ? $_POST['userprofile_media'] : '';
        update_user_meta($user_identity, 'userprofile_media', $userprofile_media);
		
		//Banner
		$userprofile_banner = (isset($_POST['userprofile_banner']) && $_POST['userprofile_banner'] <> '') ? $_POST['userprofile_banner'] : '';
        update_user_meta($user_identity, 'userprofile_banner', $userprofile_banner);
		
		//Featured
		update_user_meta( $user_identity, 'user_featured', $_POST['feature_time_stamp'] );
		
		if( !empty( $_POST['featured_days'] )  ){
			$user_featured_date    = get_user_meta( $user_identity, 'user_featured', true);
			$duration	    	  = $_POST['featured_days'];

			if( !empty( $user_featured_date ) && $user_featured_date > strtotime($current_date) ){
				$featured_date	= strtotime("+".$duration." days", $user_featured_date);
				$featured_date	= date('Y-m-d H:i:s',$featured_date);
			} else{
				$current_date	= date('Y-m-d H:i:s');
				$duration	    = $_POST['featured_days'];
				$featured_date		 = strtotime("+".$duration." days", strtotime($current_date));
				$featured_date	     = date('Y-m-d H:i:s',$featured_date);
			}
						
			update_user_meta($user_identity,'user_featured',strtotime( $featured_date )); //Update Expiry
		} else if( !empty( $_POST['featured_exclude'] ) ){
			$user_featured_date    = get_user_meta( $user_identity, 'user_featured', true);
			$duration	    	  = $_POST['featured_exclude'];
			
			if( isset( $user_featured_date ) && !empty( $user_featured_date ) ){
				$featured_date	= strtotime("-".$duration." days", $user_featured_date);
				$featured_date	= date('Y-m-d H:i:s',$featured_date);
			} 
			
			update_user_meta($user_identity,'user_featured',strtotime( $featured_date )); //Update Expiry
		}
		
		//Update Schedules
		update_user_meta( $user_identity, 'schedules', $_POST['schedules'] );
		
		//Update Schedules
		if( !empty( $_POST['professional_statements'] ) ) {
			update_user_meta( $user_identity, 'professional_statements', $_POST['professional_statements'] );
		}
		//Update Genral settings
		if( isset( $_POST['contact_form'] ) && !empty( $_POST['contact_form'] ) ) {
			update_user_meta( $user_identity, 'contact_form', esc_attr( $_POST['contact_form'] ) );
		}else{
			update_user_meta( $user_identity, 'contact_form', 'off' );
		}

		
		update_user_meta( $user_identity, 'video_url', esc_attr( $_POST['video_url'] ) );
		update_user_meta( $user_identity, 'directory_type', esc_attr( $_POST['directory_type'] ) );
		
		//Update General settings
		if( isset( $_POST['basics'] ) && !empty( $_POST['basics'] ) ){
			foreach( $_POST['basics'] as $key=>$value ){
				update_user_meta( $user_identity, $key, esc_attr( $value ) );
			}
		}
		
		if( isset( $_POST['privacy'] ) && !empty( $_POST['privacy'] ) ){
			update_user_meta( $user_identity, 'privacy', $_POST['privacy'] );
		}
		
		//Awawrds
		$awards	= array();
		if( isset( $_POST['awards'] ) && !empty( $_POST['awards'] ) ){
			
			$counter	= 0;
			foreach( $_POST['awards'] as $key=>$value ){
				$awards[$counter]['name']	= 	esc_attr( $value['name'] ); 
				$awards[$counter]['date']	= 	esc_attr( $value['date'] );
				$awards[$counter]['date_formated']	= 	date('d M, Y',strtotime($value['date']));  
				$awards[$counter]['description']	= 	esc_attr( $value['description'] ); 
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
				$user_gallery[$value['attachment_id']]['url']	= 	esc_url( $value['url'] ); 
				$user_gallery[$value['attachment_id']]['id']	= 	esc_attr( $value['attachment_id']); 
				$counter++;
			}	
		}
		update_user_meta( $user_identity, 'user_gallery', $user_gallery );
		
		//Education
		$educations	= array();
		if( isset( $_POST['education'] ) && !empty( $_POST['education'] ) ){
			$counter	= 0;
			foreach( $_POST['education'] as $key=>$value ){
				$educations[$counter]['title']		 = esc_attr( $value['title'] ); 
				$educations[$counter]['institute']	 = esc_attr( $value['institute'] ); 
				$educations[$counter]['start_date']	= esc_attr( $value['start_date'] ); 
				$educations[$counter]['end_date']	  = esc_attr( $value['end_date'] ); 
				$educations[$counter]['start_date_formated']	= date('M,Y',strtotime($value['start_date'])); 
				$educations[$counter]['end_date_formated']	  = date('M,Y',strtotime($value['end_date'])); 
				$educations[$counter]['description']			= esc_attr( $value['description'] ); 
				$counter++;
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
    }

}


/**
 * @Get User Avatar
 * @return {}
 */
if (!function_exists('docdirect_get_user_avatar')) {
    function docdirect_get_user_avatar($sizes = array(), $user_identity = '') {
        extract(shortcode_atts(array(
			"width" => '300',
			"height" => '300',
			),
		$sizes));
		
		if ($user_identity != '') {
            $thumb_id	= get_user_meta($user_identity, 'userprofile_media', true);
			if( isset( $thumb_id ) && !empty( $thumb_id ) ) {
				$thumb_url = wp_get_attachment_image_src($thumb_id, array($width, $height), true);
				if ($thumb_url[1] == $width and $thumb_url[2] == $height) {
					return $thumb_url[0];
				} else {
					$thumb_url = wp_get_attachment_image_src($thumb_id, "full", true);
					return $thumb_url[0];
				}
			}
			return false;
        }
		return false;
    }
}

/**
 * @Get User Avatar
 * @return {}
 */
if (!function_exists('docdirect_get_user_banner')) {
    function docdirect_get_user_banner($sizes = array(), $user_identity = '') {
        extract(shortcode_atts(array(
			"width" => '300',
			"height" => '300',
			),
		$sizes));
		
		if ($user_identity != '') {
            $thumb_id	= get_user_meta($user_identity, 'userprofile_banner', true);
			if( isset( $thumb_id ) && !empty( $thumb_id ) ) {
				$thumb_url = wp_get_attachment_image_src($thumb_id, array($width, $height), true);
				if ($thumb_url[1] == $width and $thumb_url[2] == $height) {
					return $thumb_url[0];
				} else {
					$thumb_url = wp_get_attachment_image_src($thumb_id, "full", true);
					return $thumb_url[0];
				}
			}
			return false;
        }
		return false;
    }
}

/**
 * @Get Single image
 * @return {}
 */
if (!function_exists('docdirect_get_single_image')) {
    function docdirect_get_single_image($sizes = array(), $user_identity = '') {
        extract(shortcode_atts(array(
				"width" => '300',
				"height" => '300',
			),
		$sizes));
		
		if ($user_identity != '') {
            $thumb_id	= get_user_meta($user_identity, 'email_media', true);
			if( isset( $thumb_id ) && !empty( $thumb_id ) ) {
				$thumb_url = wp_get_attachment_image_src($thumb_id, array($width, $height), true);
				if ($thumb_url[1] == $width and $thumb_url[2] == $height) {
					return $thumb_url[0];
				} else {
					$thumb_url = wp_get_attachment_image_src($thumb_id, "full", true);
					return $thumb_url[0];
				}
			}
			return false;
        }
		return false;
    }
}

/**
 * @Import Users
 * @return {}
 */
if (!function_exists('docdirect_import_users')) {
	function  docdirect_import_users(){
		?>
        <h3 class="theme-name"><?php esc_html_e('Import Directory Users','docdirect');?></h3>
        <div id="import-users" class="import-users">
            <div class="theme-screenshot">
                <img alt="<?php esc_attr_e('Import Users','docdirect');?>" src="<?php echo get_template_directory_uri();?>/core/images/users.jpg">
            </div>
			<h3 class="theme-name"><?php esc_html_e('Import Users','docdirect');?></h3>
            <div class="user-actions">
                <a href="javascript:;" class="button button-primary doc-import-users"><?php esc_html_e('Import','docdirect');?></a>
            </div>
		</div>
        <?php
	}
}

/**
 * @Add New Users meta
 * @return {}
 */
if (!function_exists('docdirect_save_custom_user_profile_fields')) {
	function docdirect_save_custom_user_profile_fields($user_id){
		# again do this only if you can
		if(!current_user_can('manage_options'))
			return false;
	
		# save my custom field
		update_user_meta($user_id, 'verify_user', 'off');
		update_user_meta( $user_id, 'show_admin_bar_front', false );
	}
	add_action('user_register', 'docdirect_save_custom_user_profile_fields');
}
