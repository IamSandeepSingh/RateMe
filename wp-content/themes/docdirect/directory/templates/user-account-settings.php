<?php
/**
 * User Profile Main
 * return html
 */

global $current_user, $wp_roles,$userdata,$post;

$user_identity  = $current_user->ID;
$current_date   = date('Y-m-d H:i:s');
$db_schedules   = array();
$tagline   		= get_user_meta( $user_identity, 'tagline', true);
$featured_date  = get_user_meta( $user_identity, 'user_featured', true);
$db_schedules   = get_user_meta( $user_identity, 'schedules', false);
$db_languages   = get_user_meta( $user_identity, 'languages', true);
$db_latitude    = get_user_meta( $user_identity, 'latitude', true);
$db_longitude   = get_user_meta( $user_identity, 'longitude', true);
$db_location	= get_user_meta( $user_identity, 'location', true); 
$video_url	  = get_user_meta( $user_identity, 'video_url', true);
$contact_form	  = get_user_meta( $user_identity, 'contact_form', true);
$db_address	    = get_user_meta( $user_identity, 'address', true);
$db_directory_type	 = get_user_meta( $user_identity, 'directory_type', true);
$professional_statements	 = get_user_meta( $user_identity, 'professional_statements', true);
$db_insurance	= get_user_meta( $user_identity, 'insurance', true);
$db_zip	= get_user_meta( $user_identity, 'zip', true);


$featured_string   = $featured_date;
$current_string	= strtotime( $current_date );
			
if (function_exists('fw_get_db_settings_option')) {
	$dir_longitude = fw_get_db_settings_option('dir_longitude');
	$dir_latitude = fw_get_db_settings_option('dir_latitude');
	$dir_datasize = fw_get_db_settings_option('dir_datasize');
	$dir_longitude	= !empty( $dir_longitude ) ? $dir_longitude : '-0.1262362';
	$dir_latitude	= !empty( $dir_latitude ) ? $dir_latitude : '51.5001524';
} else{
	$dir_longitude = '-0.1262362';
	$dir_latitude = '51.5001524';
	$dir_datasize = '5242880'; // 5 MB
}

$db_longitude	= !empty( $db_longitude ) ? $db_longitude : $dir_longitude;
$db_latitude	= !empty( $db_latitude ) ? $db_latitude : $dir_latitude;

$dblatitude	 = isset( $db_latitude ) && !empty( $db_latitude ) ? $db_latitude : $dir_latitude;
$dblongitude	= isset( $db_longitude ) && !empty( $db_longitude ) ? $db_longitude : $dir_longitude;

$avatar 		= apply_filters(
					'docdirect_get_user_avatar_filter',
					 docdirect_get_user_avatar(array('width'=>270,'height'=>270), $user_identity) ,
					 array('width'=>270,'height'=>270) //size width,height=
				);

$banner 		= apply_filters(
					'docdirect_get_user_avatar_filter',
					 docdirect_get_user_banner(array('width'=>270,'height'=>270), $user_identity) ,
					 array('width'=>270,'height'=>270) //size width,height=
				);
				
$is_banner	= docdirect_get_user_banner(0, $user_identity,'userprofile_banner');
$is_avatar	= docdirect_get_user_avatar(0, $user_identity,'userprofile_media');
$languages_array	= docdirect_prepare_languages();//Get Language Array

docdirect_init_dir_map();//init Map
docdirect_enque_map_library();//init Map

$section_column	= 'col-md-12 col-sm-12 col-xs-12';
if( apply_filters('docdirect_do_check_user_type',$user_identity ) === true ){
	$section_column	= 'col-md-12 col-sm-12 col-xs-12';
}

$user_url	= '';
if( isset( $db_directory_type ) && !empty( $db_directory_type ) ) {
	$attached_specialities = get_post_meta( $db_directory_type, 'attached_specialities', true );
	$education_switch  	  = fw_get_db_post_option( $db_directory_type, 'education', true );
	$insurance_switch  	  = fw_get_db_post_option( $db_directory_type, 'insurance', true );
	$experience_switch  	  = fw_get_db_post_option( $db_directory_type, 'experience', true );
	$specialities_list	 = docdirect_prepare_taxonomies('directory_type','specialities',0,'array');
	$current_userdata	   = get_userdata($user_identity);
	$user_url	= $current_userdata->data->user_url;
}

if( empty( $attached_specialities )){
	$attached_specialities	= array();
} 
?>
<form class="tg-formeditprofile tg-haslayout do-account-setitngs">
    <div class="tg-editprofile tg-haslayout">
        <div class="<?php echo esc_attr( $section_column );?> tg-findheatlhwidth">
            <div class="row">
                <div class="tg-editimg">
                    <div class="tg-editimg-avatar">
                        <div class="tg-heading-border tg-small">
                            <h3><?php esc_html_e('upload photo','docdirect');?></h3>
                        </div>
                        <div class="tg-haslayout">
                            <figure class="tg-docimg"> 
                                <span class="user-avatar"><img src="<?php echo esc_url( $avatar );?>" alt="<?php esc_html_e('Avatar','docdirect');?>"  /></span>
                                <?php if( isset( $is_avatar ) && !empty( $is_avatar ) ) {?>
                                    <a href="javascript:;" class="tg-deleteimg del-avatar"><i class="fa fa-plus"></i></a>
                                <?php }?>
                                <a href="javascript:;" id="upload-profile-avatar" class="tg-uploadimg upload-avatar"><i class="fa fa-upload"></i></a> 
                                <div id="plupload-container"></div>
                            </figure>
                            <div class="tg-uploadtips">
                                <h4><?php esc_html_e('tips for uploading','docdirect');?></h4>
                                <ul class="tg-instructions">
                                    <li><?php esc_html_e('Max Upload Size: ','docdirect');?><?php docdirect_format_size_units($dir_datasize,'print');?></li>
                                    <li><?php esc_html_e('Dimensions: 370x377','docdirect');?></li>
                                    <li><?php esc_html_e('Extensions: JPG,JPEG,PNG,GIF','docdirect');?></li>
                                </ul>
                            </div>
                        </div>
                        <div id="errors-log"></div>
                    </div>
                    <?php if( apply_filters('docdirect_do_check_user_type',$user_identity ) === true ){?>
                    <div class="tg-editimg-banner">
                        <div class="tg-heading-border tg-small">
                            <h3><?php esc_html_e('Upload Banner','docdirect');?></h3>
                        </div>
                        <div class="tg-haslayout">
                            <figure class="tg-docimg"> 
                                <span class="user-banner"><img src="<?php echo esc_url( $banner );?>" alt="<?php esc_html_e('Avatar','docdirect');?>"  /></span>
                                <?php if( isset( $is_banner ) && !empty( $is_banner ) ) {?>
                                    <a href="javascript:;" class="tg-deleteimg del-banner"><i class="fa fa-plus"></i></a>
                                <?php }?>
                                <a href="javascript:;" id="upload-profile-banner" class="tg-uploadimg upload-banner"><i class="fa fa-upload"></i></a> 
                                <div id="plupload-container"></div>
                            </figure>
                            <div class="tg-uploadtips">
                                <h4><?php esc_html_e('tips for uploading','docdirect');?></h4>
                                <ul class="tg-instructions">
                                    <li><?php esc_html_e('Max Upload Size: ','docdirect');?><?php docdirect_format_size_units($dir_datasize,'print');?></li>
                                    <li><?php esc_html_e('Dimensions: 1920x450','docdirect');?></li>
                                    <li><?php esc_html_e('Extensions: JPG,JPEG,PNG,GIF','docdirect');?></li>
                                </ul>
                            </div>
                        </div>
                        <div id="errors-log"></div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    
    <?php if( apply_filters('docdirect_do_check_user_type',$user_identity ) === true ){?>
        <div class="tg-editprofile tg-haslayout">
            <div class="col-md-12 col-sm-12 col-xs-12 tg-expectwidth">
                <div class="row">
                    <div class="tg-otherphotos">
                        <div class="tg-heading-border tg-small">
                            <h3><a href="javascript:;"><?php esc_html_e('Other Photos','docdirect');?></a></h3>
                            <div id="plupload-container"></div>
                        </div>
                        <div class="gallery-button">
                            <button type="button" id="attach-gallery" class="tg-btn tg-btn-lg"><?php esc_html_e('Choose Photos','docdirect');?></button>
                        </div>
                        <div id="tg-photoscroll" class="tg-photoscroll">
                            <div class="form-group">
                                <ul class="tg-otherimg doc-user-gallery" id="gallery-sortable-container">
                                    <?php 
                                    $user_gallery	 = get_user_meta( $user_identity, 'user_gallery', true);
                                    $counter	= 0;
                                    if( isset( $user_gallery ) && !empty( $user_gallery ) ) {
                                        foreach( $user_gallery as $key	=> $value ){
                                    ?>
                                    <li class="gallery-item gallery-thumb-item">
                                        <figure> 
                                            <a href="javascript:;"><img width="100" height="100" src="<?php echo esc_attr( $value['url'] );?>" alt="<?php esc_attr_e('Gallery','docdirect');?>"></a>
                                            <div class="tg-img-hover"><a href="javascript:;" data-attachment="<?php echo esc_attr( $value['id'] );?>"><i class="fa fa-plus"></i><i class='fa fa-refresh fa-spin'></i></a></div>
                                            
                                        </figure>
                                        <input type="hidden" value="<?php echo esc_attr( $value['id'] );?>" name="user_gallery[<?php echo esc_attr( $value['id'] );?>][attachment_id]">
                                        <input type="hidden" value="<?php echo esc_attr( $value['url'] );?>" name="user_gallery[<?php echo esc_attr( $value['id'] );?>][url]">
                                    </li>
                                    <?php }}?>
                                    
                                </ul>
                                
                            </div>
                        </div>
                        <div id="errors-log-gallery"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php }?>
   
    <?php if( apply_filters('docdirect_do_check_user_type',$user_identity ) === true ){?>
    <div class="tg-bordertop tg-haslayout">
        <div class="tg-formsection">
            <div class="tg-heading-border tg-small">
                <h3><?php esc_attr_e('Specialities','docdirect');?></h3>
            </div>
            <div class="row">
                <div class="specialities-list">
                    <ul>
                        <?php 
                        if( isset( $specialities_list ) && !empty( $specialities_list ) ){
                            foreach( $specialities_list as $key => $speciality ){
                                $db_speciality	= get_user_meta( $user_identity, $speciality->slug, true);
                                $checked	= '';
                                if( isset( $db_speciality ) && !empty( $db_speciality ) && $db_speciality === $speciality->slug ){
                                    $checked	= 'checked';
                                }
                                
                                if( in_array( $speciality->term_id , $attached_specialities ) ) {
                            ?>
                            <li>
                                <div class="tg-checkbox user-selection">
                                    <div class="tg-packages active-user-type specialities-type">
                                        <input type="checkbox" <?php echo esc_attr( $checked );?> name="specialities[<?php echo esc_attr( $speciality->term_id );?>]" value="<?php echo esc_attr( $speciality->slug );?>" id="<?php echo esc_attr( $speciality->slug );?>">
                                        <label for="<?php echo esc_attr( $speciality->slug );?>"><?php echo esc_attr( $speciality->name );?></label>
                                    </div>
                                </div>
                                
                            </li>
                        <?php }}}?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
    <div class="tg-bordertop tg-haslayout">
        <div class="tg-formsection">
            <div class="tg-heading-border tg-small">
                <h3><?php esc_attr_e('Basic Information','docdirect');?></h3>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="basics[nickname]" value="<?php echo get_user_meta($user_identity,'nickname',true); ?>" type="text" placeholder="<?php esc_attr_e('Nick Name','docdirect');?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="basics[first_name]" value="<?php echo get_user_meta($user_identity,'first_name',true); ?>" type="text" placeholder="<?php esc_attr_e('First Name','docdirect');?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="basics[last_name]" value="<?php echo get_user_meta($user_identity,'last_name',true); ?>" type="text" placeholder="<?php esc_attr_e('Last Name','docdirect');?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="basics[phone_number]" value="<?php echo get_user_meta($user_identity,'phone_number',true); ?>" type="text" placeholder="<?php esc_attr_e('Phone','docdirect');?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="basics[fax]" value="<?php echo get_user_meta($user_identity,'fax',true); ?>" type="text" placeholder="<?php esc_attr_e('Fax','docdirect');?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="basics[address]" value="<?php echo get_user_meta($user_identity,'address',true); ?>" type="text" placeholder="<?php esc_attr_e('Address','docdirect');?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="basics[user_url]" value="<?php echo esc_attr( $user_url ); ?>" type="url" placeholder="<?php esc_attr_e('URL','docdirect');?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="basics[tagline]" value="<?php echo get_user_meta($user_identity,'tagline',true); ?>" type="text" placeholder="<?php esc_attr_e('Tagline','docdirect');?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="basics[zip]" value="<?php echo get_user_meta($user_identity,'zip',true); ?>" type="text" placeholder="<?php esc_attr_e('Zip/Postal Code','docdirect');?>">
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <textarea class="form-control" name="basics[description]" placeholder="<?php esc_attr_e('Short description','docdirect');?>"><?php echo get_user_meta($user_identity,'description',true); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if( apply_filters('docdirect_do_check_user_type',$user_identity ) === true ){?>
    <div class="tg-bordertop tg-haslayout">
        <div class="tg-formsection">
            <div class="tg-heading-border tg-small">
                <h3><?php esc_html_e('Professional Statements','docdirect');?></h3>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="email-params">
                        <p><strong><?php esc_html_e('It will be shown in user detail page below user short description.','docdirect');?></strong></p>
                    </div>
                    <div class="form-group">
                        <?php 
                            $professional_statements = !empty($professional_statements) ? $professional_statements : '';
                            $settings = array( 
                                'editor_class' => 'professional_statements', 
                                'teeny' => true, 
                                'media_buttons' => false, 
                                'textarea_rows' => 10,
                                'quicktags' => true,
                                'editor_height' => 300,
                            );
                            
                            wp_editor( $professional_statements, 'professional_statements', $settings );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
    <div class="tg-bordertop tg-haslayout">
        <div class="tg-formsection">
            <div class="tg-heading-border tg-small">
                <h3><?php esc_html_e('Social Settings','docdirect');?></h3>
            </div>
            <p><strong><?php esc_html_e('Note: Leave them empty to hide social icons at detail page.','docdirect');?></strong></p>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="socials[facebook]" value="<?php echo get_user_meta($user_identity,'twitter',true); ?>" type="text" placeholder="<?php esc_attr_e('Facebook','docdirect');?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="socials[twitter]" value="<?php echo get_user_meta($user_identity,'twitter',true); ?>" type="text" placeholder="<?php esc_attr_e('Twitter','docdirect');?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="socials[linkedin]" value="<?php echo get_user_meta($user_identity,'linkedin',true); ?>" type="text" placeholder="<?php esc_attr_e('Linkedin','docdirect');?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="socials[pinterest]" value="<?php echo get_user_meta($user_identity,'pinterest',true); ?>" type="text" placeholder="<?php esc_attr_e('Pinterest','docdirect');?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="socials[google_plus]" value="<?php echo get_user_meta($user_identity,'google_plus',true); ?>" type="text" placeholder="<?php esc_attr_e('Google Plus','docdirect');?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="socials[instagram]" value="<?php echo get_user_meta($user_identity,'instagram',true); ?>" type="text" placeholder="<?php esc_attr_e('Instagram','docdirect');?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="socials[tumblr]"  value="<?php echo get_user_meta($user_identity,'tumblr',true); ?>"type="text" placeholder="<?php esc_attr_e('Tumblr','docdirect');?>">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="socials[skype]"  value="<?php echo get_user_meta($user_identity,'skype',true); ?>"type="text" placeholder="<?php esc_attr_e('Skype','docdirect');?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if( apply_filters('docdirect_do_check_user_type',$user_identity ) === true ){?>
    <div class="tg-bordertop tg-haslayout">
      <div class="tg-formsection tg-honor-awards">
        <div class="tg-heading-border tg-small">
          <h3><?php esc_html_e('Honors & Awards','docdirect');?></h3>
        </div>
        <div class="tg-education-detail tg-haslayout">
          <table class="table-striped awards_wrap">
            <thead class="cf">
              <tr>
                <th><?php esc_html_e('Title','docdirect');?></th>
                <th><?php esc_html_e('Year','docdirect');?></th>
              </tr>
            </thead>
            <?php 
            $awards_list	= get_the_author_meta('awards',$user_identity);
            $counter	= 0;
            if( isset( $awards_list ) && !empty( $awards_list ) ) {
                foreach( $awards_list as $key	=> $value ){
                ?>
                <tbody class="awards_item">
                  <tr>
                    <td data-title="Code"><?php echo esc_attr( $value['name'] );?>
                      <div class="tg-table-hover award-action"> 
                        <a href="javascript:;" class="delete-me"><i class="tg-delete fa fa-close"></i></a>
                        <a href="javascript:;" class="edit-me"><i class="tg-edit fa fa-pencil"></i></a> 
                       </div>
                    </td>
                    <td data-title="Company"><?php echo esc_attr( date('F m, Y',strtotime( $value['date'] ) ) );?></td>
                  </tr>
                  <tr>
                    <td class="award-data edit-me-row"colspan="2">
                        <div class="tg-education-form tg-haslayout">
                            <div class="award-data">
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input class="form-control" value="<?php echo esc_attr( $value['name'] );?>" name="awards[<?php echo intval( $counter );?>][name]" type="text" placeholder="<?php esc_attr_e('Award Name','docdirect');?>">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input class="form-control award_datepicker" id="award_datepicker" value="<?php echo esc_attr( $value['date'] );?>" name="awards[<?php echo intval( $counter );?>][date]" type="text" placeholder="<?php esc_attr_e('Award Date','docdirect');?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <textarea class="form-control" name="awards[<?php echo intval( $counter );?>][description]" placeholder="<?php esc_attr_e('Award Description','docdirect');?>"><?php echo esc_attr( $value['description'] );?></textarea>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </td>
                  </tr>
                </tbody>
                <?php
                    $counter++;
                    }
                }
            ?>
          </table>
          </div>
        <div class="col-sm-12">
           <div class="tg-addfield add-new-awards">
              <button type="button">
                  <i class="fa fa-plus"></i>
                  <span><?php esc_html_e('Add Awards','docdirect');?></span>
              </button>
           </div>
        </div>
      </div>
    </div>
    <?php if( isset( $education_switch ) && $education_switch === 'enable' ) {?>
    <!--Education-->
    <div class="tg-bordertop tg-haslayout">
        <div class="tg-formsection tg-education">
            <div class="tg-heading-border tg-small">
                <h3><?php esc_html_e('Education','docdirect');?></h3>
            </div>
            <div class="tg-education-detail tg-haslayout">
              <table class="table-striped educations_wrap" id="table-striped">
                <thead class="cf">
                  <tr>
                    <th><?php esc_html_e('Degree / Education Title','docdirect');?></th>
                    <th><?php esc_html_e('Institute','docdirect');?></th>
                    <th class="numeric"><?php esc_html_e('Year','docdirect');?></th>
                  </tr>
                </thead>
                <?php 
                $education_list	= get_the_author_meta('education',$user_identity);
                $counter	= 0;
                if( isset( $education_list ) && !empty( $education_list ) ) {
                    foreach( $education_list as $key	=> $value ){
                        if( !empty( $value['end_date'] ) ) {
                            $end_date	= date('M,Y',strtotime( $value['end_date']));
                        } else{
                            $end_date	= esc_html__('Current','docdirect');
                        }
                    
                    $flag	= rand(1,9999);
                    ?>
                    <tbody class="educations_item">
                      <tr>
                        <td data-title="Code"><?php echo esc_attr( $value['title'] );?>
                          <div class="tg-table-hover education-action"> 
                              <a href="javascript:;" class="delete-me"><i class="tg-delete fa fa-close"></i></a> 
                              <a href="javascript:;" class="edit-me"><i class="tg-edit fa fa-pencil"></i></a> 
                          </div>
                        </td>
                        <td data-title="Company"><?php echo esc_attr( $value['institute'] );?></td>
                        <td data-title="Price" class="numeric"><?php echo esc_attr( date('M,Y',strtotime( $value['start_date'] ) ) );?>&nbsp;-&nbsp;<?php echo esc_attr( $end_date );?></td>
                      </tr>
                      <tr>
                       <td class="education-data edit-me-row" colspan="3">
                         <div class="education-data-wrap">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <input class="form-control" value="<?php echo esc_attr( $value['title'] );?>" name="education[<?php echo intval( $counter );?>][title]" type="text" placeholder="<?php esc_attr_e('Title','docdirect');?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <input class="form-control" value="<?php echo esc_attr( $value['institute'] );?>" name="education[<?php echo intval( $counter );?>][institute]" type="text" placeholder="<?php esc_attr_e('Institute','docdirect');?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <input class="form-control edu_start_date_<?php echo esc_attr( $flag );?>" id="edu_start_date" value="<?php echo esc_attr( $value['start_date'] );?>" name="education[<?php echo intval( $counter );?>][start_date]" type="text" placeholder="<?php esc_attr_e('Start Date','docdirect');?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <input class="form-control edu_end_date_<?php echo esc_attr( $flag );?>" id="edu_end_date" value="<?php echo esc_attr( $value['end_date'] );?>" name="education[<?php echo intval( $counter );?>][end_date]" type="text" placeholder="<?php esc_attr_e('End Date','docdirect');?>">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <textarea class="form-control" name="education[<?php echo intval( $counter );?>][description]" placeholder="<?php esc_attr_e('Education Description','docdirect');?>"><?php echo esc_attr( $value['description'] );?></textarea>
                                </div>
                            </div>
                            <script>
                               jQuery(document).ready(function(e) {
                                jQuery('.edu_start_date_<?php echo esc_js( $flag );?>').datetimepicker({
                                   format:'Y-m-d',
                                  onShow:function( ct ){
                                   this.setOptions({
                                    maxDate:jQuery('.edu_end_date_<?php echo esc_js( $flag );?>').val()?jQuery('.edu_end_date_<?php echo esc_js( $flag );?>').val():false
                                   })
                                  },
                                  timepicker:false
                                 });
                                jQuery('.edu_end_date_<?php echo esc_js( $flag );?>').datetimepicker({
                                   format:'Y-m-d',
                                  onShow:function( ct ){
                                   this.setOptions({
                                    minDate:jQuery('.edu_start_date_<?php echo esc_js( $flag );?>').val()?jQuery('.edu_start_date_<?php echo esc_js( $flag );?>').val():false
                                   })
                                  },
                                  timepicker:false
                                 });
                               }); 
                            </script>
                           </div>
                       </td>
                      </tr>
                     </tbody>
                   <?php
                        $counter++;
                        }
                    }
                ?>
              </table>
            </div>
            <div class="col-sm-12">
                <div class="tg-addfield add-new-educations">
                    <button type="button">
                        <i class="fa fa-plus"></i>
                        <span><?php esc_html_e('Add Education','docdirect');?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
    
    <?php if( isset( $experience_switch ) && $experience_switch === 'enable' ) {?>
    <!--Experience-->
    <div class="tg-bordertop tg-haslayout">
        <div class="tg-formsection tg-experience">
            <div class="tg-heading-border tg-small">
                <h3><?php esc_html_e('Experience','docdirect');?></h3>
            </div>
            <div class="tg-education-detail tg-haslayout">
              <table class="table-striped experiences_wrap" id="table-striped">
                <thead class="cf">
                  <tr>
                    <th><?php esc_html_e('Experience Title','docdirect');?></th>
                    <th><?php esc_html_e('Company/Organization','docdirect');?></th>
                    <th class="numeric"><?php esc_html_e('Year','docdirect');?></th>
                  </tr>
                </thead>
                <?php 
                $experience_list	= get_the_author_meta('experience',$user_identity);
                $counter	= 0;
                if( isset( $experience_list ) && !empty( $experience_list ) ) {
                    foreach( $experience_list as $key	=> $value ){
                    $flag	= rand(1,9999);
                    
                    if( !empty( $value['end_date'] ) ) {
                        $end_date	= date('M,Y',strtotime( $value['end_date']));
                    } else{
                        $end_date	= esc_html__('Current','docdirect');
                    }
                    ?>
                    <tbody class="experiences_item">
                      <tr>
                        <td data-title="Code"><?php echo esc_attr( $value['title'] );?>
                          <div class="tg-table-hover experience-action"> 
                              <a href="javascript:;" class="delete-me"><i class="tg-delete fa fa-close"></i></a> 
                              <a href="javascript:;" class="edit-me"><i class="tg-edit fa fa-pencil"></i></a> 
                          </div>
                        </td>
                        <td data-title="Company"><?php echo esc_attr( $value['company'] );?></td>
                        <td data-title="Price" class="numeric"><?php echo esc_attr( date('M,Y',strtotime( $value['start_date'] ) ) );?>&nbsp;-&nbsp;<?php echo esc_attr( $end_date );?></td>
                      </tr>
                      <tr>
                       <td class="experience-data edit-me-row" colspan="3">
                         <div class="experience-data-wrap">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <input class="form-control" value="<?php echo esc_attr( $value['title'] );?>" name="experience[<?php echo intval( $counter );?>][title]" type="text" placeholder="<?php esc_attr_e('Title','docdirect');?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <input class="form-control" value="<?php echo esc_attr( $value['company'] );?>" name="experience[<?php echo intval( $counter );?>][company]" type="text" placeholder="<?php esc_attr_e('Company/Organization','docdirect');?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <input class="form-control exp_start_date_<?php echo esc_attr( $flag );?>" id="exp_start_date" value="<?php echo esc_attr( $value['start_date'] );?>" name="experience[<?php echo intval( $counter );?>][start_date]" type="text" placeholder="<?php esc_attr_e('Start Date','docdirect');?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <input class="form-control exp_end_date_<?php echo esc_attr( $flag );?>" id="exp_end_date" value="<?php echo esc_attr( $value['end_date'] );?>" name="experience[<?php echo intval( $counter );?>][end_date]" type="text" placeholder="<?php esc_attr_e('End Date','docdirect');?>">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <textarea class="form-control" name="experience[<?php echo intval( $counter );?>][description]" placeholder="<?php esc_attr_e('Experience Description','docdirect');?>"><?php echo esc_attr( $value['description'] );?></textarea>
                                </div>
                            </div>
                            <script>
                               jQuery(document).ready(function(e) {
                                jQuery('.exp_start_date_<?php echo esc_js( $flag );?>').datetimepicker({
                                   format:'Y-m-d',
                                  onShow:function( ct ){
                                   this.setOptions({
                                    maxDate:jQuery('.exp_end_date_<?php echo esc_js( $flag );?>').val()?jQuery('.exp_end_date_<?php echo esc_js( $flag );?>').val():false
                                   })
                                  },
                                  timepicker:false
                                 });
                                jQuery('.exp_end_date_<?php echo esc_js( $flag );?>').datetimepicker({
                                   format:'Y-m-d',
                                  onShow:function( ct ){
                                   this.setOptions({
                                    minDate:jQuery('.exp_start_date_<?php echo esc_js( $flag );?>').val()?jQuery('.exp_start_date_<?php echo esc_js( $flag );?>').val():false
                                   })
                                  },
                                  timepicker:false
                                 });
                               }); 
                            </script>
                           </div>
                       </td>
                      </tr>
                     </tbody>
                   <?php
                        $counter++;
                        }
                    }
                ?>
              </table>
            </div>
            <div class="col-sm-12">
                <div class="tg-addfield add-new-experiences">
                    <button type="button">
                        <i class="fa fa-plus"></i>
                        <span><?php esc_html_e('Add Experience','docdirect');?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php }}?>
    <!--Language-->
    <?php if( apply_filters('docdirect_do_check_user_type',$user_identity ) === true ){?>
    <div class="tg-bordertop tg-haslayout">
        <div class="tg-formsection">
            <div class="tg-heading-border tg-small">
                <h3><?php esc_html_e('Language','docdirect');?></h3>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <select name="language[]" class="chosen-select" multiple>
                            <option value=""><?php esc_attr_e('Select Languages','docdirect');?></option>
                            <?php 
                            if( isset( $languages_array ) && !empty( $languages_array ) ){
                                
                                foreach( $languages_array as $key=>$value ){
                                    $selected	= '';
                                    if( isset( $db_languages[$key] ) ){
                                        $selected	= 'selected';
                                    }
                                    ?>
                                <option <?php echo esc_attr( $selected );?> value="<?php echo esc_attr( $key );?>"><?php echo esc_attr( $value );?></option>
                            <?php }}?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
    
    <?php if( isset( $insurance_switch ) && $insurance_switch === 'enable' ) {?>
        <?php if( apply_filters('docdirect_do_check_user_type',$user_identity ) === true ){?>
        <div class="tg-bordertop tg-haslayout">
            <div class="tg-formsection">
                <div class="tg-heading-border tg-small">
                    <h3><?php esc_html_e('Insurance Plans','docdirect');?></h3>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <select name="insurance[]" class="chosen-select" multiple>
                                <option value=""><?php esc_attr_e('Select insurance','docdirect');?></option>
                                <?php docdirect_get_term_options($db_insurance,'insurance');?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
    <?php }?>
    <?php if( apply_filters('docdirect_do_check_user_type',$user_identity ) === true ){?>
    <div class="tg-bordertop tg-haslayout">
        <div class="tg-formsection tg-videoprofile">
            <div class="tg-heading-border tg-small">
                <h3><?php esc_html_e('video link','docdirect');?></h3>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <input class="form-control" name="video_url" value="<?php echo esc_url( $video_url );?>" type="url" placeholder="<?php esc_attr_e('Enter Url','docdirect');?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
    <!--Locations-->
    <?php if( apply_filters('docdirect_do_check_user_type',$user_identity ) === true ){?>
    <div class="tg-bordertop tg-haslayout">
        <div class="tg-formsection">
            <div class="tg-heading-border tg-small">
                <h3><?php esc_html_e('Locations','docdirect');?></h3>
            </div>
            <div class="row map-container">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <span class="doc-select">
                            <select name="basics[location]" class="locations-select">
                                <option value=""><?php esc_attr_e('Select Location','docdirect');?></option>
                                <?php docdirect_get_term_options($db_location,'locations');?>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group locate-me-wrap">
                        <input type="text" value="<?php echo esc_attr( $db_address );?>" name="basics[address]" class="form-control" id="location-address" />
                        <a href="javascript:;" class="geolocate"><img src="<?php echo get_template_directory_uri();?>/images/geoicon.svg" width="16" height="16" class="geo-locate-me" alt="<?php esc_html_e('Locate me!','docdirect');?>"></a>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <div id="location-pickr-map"></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 elm-display-none">
                    <div class="form-group">
                        <input type="text" readonly value="<?php echo esc_attr( $db_longitude );?>" name="basics[longitude]" class="form-control" id="location-longitude" />
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12  elm-display-none">
                    <div class="form-group">
                        <input type="text" readonly value="<?php echo esc_attr( $db_latitude );?>" name="basics[latitude]" class="form-control" id="location-latitude" />
                    </div>
                </div>
                <script>
                    jQuery(document).ready(function(e) {
                        //init
                        jQuery.docdirect_init_map(<?php echo esc_js( $db_latitude );?>,<?php echo esc_js( $db_longitude );?>);
                    });
                </script>
            </div>
        </div>
    </div>
    <?php }?>
    <?php if( apply_filters('docdirect_do_check_user_type',$user_identity ) === true ){?>
        <input type="hidden" class="txt-professional" value="txt-professional">
    <?php }else{?>
        <input type="hidden" class="txt-visitor" value="txt-visitor">
    <?php }?>
    <button type="submit" class="tg-btn process-account-settings"><?php esc_attr_e('update','docdirect');?></button>
</form>
<?php

