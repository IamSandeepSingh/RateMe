<?php
/**
 * Email Helper For Theme
 * Long Description.
 * @since    1.0.0
 */
if( ! class_exists( 'DocDirectProcessEmail' ) ) {
	class DocDirectProcessEmail{
		
		public function __construct(){
			add_filter( 'wp_mail_content_type', array(&$this,'docdirect_set_content_type') );
			//add_filter( 'wp_mail_from', array(&$this,'docdirect_wp_mail_from') );
			add_filter( 'wp_mail_from_name', array(&$this,'docdirect_wp_mail_from_name') );
			add_filter('retrieve_password_message', array(&$this,'docdirect_reset_password_message'), null, 2);
		}
		
		/**
		 * Email Headers From
		 *
		 *
		 * @since    1.0.0
		 */
		public function docdirect_wp_mail_from($email) {
		  return 'info@no-reply.com';
		}
		
		/**
		 * Email Headers From name
		 *
		 *
		 * @since    1.0.0
		 */
		public function docdirect_wp_mail_from_name($name) {
		  $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
		  return $blogname;
		}

		/**
		 * Email Content type
		 *
		 *
		 * @since    1.0.0
		 */
		public function docdirect_set_content_type(){
			return "text/html";
		}
		
		/**
		 * Get Email Header
		 *
		 * Return email header html
		 *
		 * @since    1.0.0
		 */
		 public function prepare_email_headers( $name = '' ) {
			global $current_user;
			ob_start();
			?>
            <table class="body-wrap" bgcolor="#f6f6f6" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 20px;">
              <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
                <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;"></td>
                <td class="container" bgcolor="#FFFFFF" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; clear: both !important; display: block !important; max-width: 800px !important; Margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;"><!-- content -->
                  
                  <div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; display: block; max-width: 800px; margin: 0 auto; padding: 0;">
                    <table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 0;">
                      <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
                        <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
            <?php
			return ob_get_clean();	
		 }
	
		/**
		 * Get Email Footer
		 *
		 * Return email footer html
		 *
		 * @since    1.0.0
		 */
		 public function prepare_email_footers( $params ='' ) {
			global $current_user;
			ob_start();
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			?>
            
          <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;"><?php esc_html_e('Thanks, have a lovely day.','docdirect');?></p>
          <p style="border-top:1px dotted rgba(158, 158, 158, 0.73);font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 10px 0 0 0;">&copy;<?php echo date('Y');?><?php esc_html_e(' | All Rights Reserved','docdirect');?> <a href="<?php echo esc_url(home_url('/')); ?>" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; color: #348eda; margin: 0; padding: 0;"><?php echo esc_attr( $blogname );?></a></p></td>
                  </tr>
                </table>
              </div>
          
              <!-- /content --></td>
              <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;"></td>
              </tr>
            </table>
            <!-- /body --><!-- footer -->
            <table class="footer-wrap" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; clear: both !important; width: 100%; margin: 0; padding: 0;">
              <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
                <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;"></td>
                <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;"></td>
              </tr>
            </table>

            <?php
			return ob_get_clean();
		 }
		 
		
		
		/**
		 * @Registration
		 *
		 * @since 1.0.0
		 */
		 public function process_get_logo( $params = '' ) {
			 //Get Logo
			if (function_exists('fw_get_db_settings_option')) {
				$main_logo = fw_get_db_settings_option('main_logo');
            }
			
			if (isset($main_logo['url']) && !empty($main_logo['url'])) {
				$logo = $main_logo['url'];
			} else {
				$logo = get_template_directory_uri() . '/images/logo.png';
			}
			
			return '<img width="100" src="'.esc_url( $logo ).'" alt="'.esc_html__('email-header','docdirect').'" />';
		 }
		 
		 
		 /**
		 * @Forgot Password
		 *
		 * @since 1.0.0
		 */
		 public function docdirect_reset_password_message( $message, $key ) {
			
			$content_default = 'Hey %name%!<br/>
										%message%<br/><br/>
										Sincerely,<br/>
										%logo%';
									
			if ( strpos($_POST['user_login'], '@') ) {
				$user_data = get_user_by('email', trim($_POST['user_login']));
			} else {
				$login = trim($_POST['user_login']);
				$user_data = get_user_by('login', $login);
			}
		
			$user_login = $user_data->user_login;
			$forgot_content = esc_html__('The password for the following account has been requested to be reset:','docdirect'). "\r\n\r\n";
			$forgot_content .= network_site_url() . "\r\n\r\n";
			$forgot_content .= sprintf(__('Username: %s','docdirect'), $user_login) . "\r\n\r\n";
			$forgot_content .= esc_html__('If this message was sent in error, please ignore this email.','docdirect') . "\r\n\r\n";
			$forgot_content .= esc_html__('To reset your password, visit the following address:','docdirect');
			$forgot_content .= '(' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ")\r\n";
		
			
			$logo		   = $this->process_get_logo();
			$content_default = str_replace("%name%", nl2br($user_login), $content_default); //Replace Name
			$content_default = str_replace("%message%", nl2br($forgot_content), $content_default); //Replace content
			$content_default = str_replace("%logo%", nl2br($logo), $content_default); //Replace logo
			
			$body			 = '';
			$body			.= $this->prepare_email_headers($user_login);
			
			
			$body			.= ' <p style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;">'.$content_default.'</p>';
			$body			.= '<table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: auto !important; Margin: 0 0 10px; padding: 0;"><tr style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: \'Helvetica Neue\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 14px; line-height: 1.6em; border-radius: 25px; text-align: center; vertical-align: top; background: #348eda; margin: 0; padding: 0;" align="center" bgcolor="#348eda" valign="top">
                
                </td>
              </tr></table>';

			$body 			.= $this->prepare_email_footers();
			
			return $body;
		
		}

		
		/**
		 * @Registration
		 *
		 * @since 1.0.0
		 */
		 public function process_registeration_email( $params = '' ) {
			global $current_user;
			
			extract( $params );
			
			$name	= $first_name.' '.$last_name;
			
			$subject = 'Thank you for registering!';
			$register_content_default = 'Hey %name%!<br/>

									Thanks for registering at DocDirect. You can now login to manage your account using the following credentials:
									<br/>
									Username: %username%<br/>
									Password: %password%<br/>
									
									Sincerely,<br/>
									%logo%';
				
			if (function_exists('fw_get_db_post_option')) {
				$subject = fw_get_db_settings_option('register_subject');
				$register_content = fw_get_db_settings_option('register_content');
			}
			
			//set defalt contents
			if( empty( $register_content ) ){
				$register_content = $register_content_default;
			}
			
			$logo		   = $this->process_get_logo();

			$register_content = str_replace("%name%", nl2br($name), $register_content); //Replace Name
			$register_content = str_replace("%username%", nl2br($username), $register_content); //Replace username
			$register_content = str_replace("%password%", nl2br($password), $register_content); //Replace password
			$register_content = str_replace("%email%", nl2br($email), $register_content); //Replace email
			$register_content = str_replace("%logo%", nl2br($logo), $register_content); //Replace Logo
			
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			$admin_email	= get_option( 'admin_email' ,'info@themographics.com' );
			
			$email_headers = "From: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "Reply-To: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "MIME-Version: 1.0\r\n";
			$email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			$attachments	  = '';
			$body			 = '';
			$body			.= $this->prepare_email_headers($name);
			
			
			$body			.= ' <p style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;">'.$register_content.'</p>';
			$body			.= '<table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: auto !important; Margin: 0 0 10px; padding: 0;"><tr style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: \'Helvetica Neue\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 14px; line-height: 1.6em; border-radius: 25px; text-align: center; vertical-align: top; background: #348eda; margin: 0; padding: 0;" align="center" bgcolor="#348eda" valign="top">
                
                </td>
              </tr></table>';

			$body 			.= $this->prepare_email_footers();
			wp_mail($email, $subject, $body);
			
			return true;
		 }
		 
		 /**
		 * @Registration admin email
		 *
		 * @since 1.0.0
		 */
		 public function process_registeration_admin_email( $params = '' ) {
			global $current_user;
			
			extract( $params );
			
			$name	= $first_name.' '.$last_name;
			$user_link	= get_author_posts_url( $user_identity );
			
			$subject = 'New Registration!';
			$register_content_default = 'Hey<br/>

									A new user "%username%" with email address "%email%" has registered on your website. Please login to check user detail.
									<br/>
									You can check user detail at: %link%<br/>
									
									Sincerely,<br/>
									%logo%';
			
			$admin_email = '';	
			if (function_exists('fw_get_db_post_option')) {
				$subject = fw_get_db_settings_option('admin_register_subject');
				$admin_email = fw_get_db_settings_option('admin_email');
				$register_content = fw_get_db_settings_option('admin_register_content');
			}
			
			//set defalt contents
			if( empty( $register_content ) ){
				$register_content = $register_content_default;
			}
			
			$logo		   = $this->process_get_logo();

			$register_content = str_replace("%username%", nl2br($name), $register_content); //Replace username
			$register_content = str_replace("%email%", nl2br($email), $register_content); //Replace email
			$register_content = str_replace("%link%", ($user_link), $register_content); //Replace email
			$register_content = str_replace("%logo%", nl2br($logo), $register_content); //Replace Logo
			
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			
			if( !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $admin_email) ) { 
				$admin_email	= get_option( 'admin_email' ,'info@themographics.com' );
			}
			
			$email_headers = "From: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "Reply-To: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "MIME-Version: 1.0\r\n";
			$email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			$attachments	  = '';
			$body			 = '';
			$body			.= $this->prepare_email_headers($name);
			
			
			$body			.= ' <p style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;">'.$register_content.'</p>';
			$body			.= '<table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: auto !important; Margin: 0 0 10px; padding: 0;"><tr style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: \'Helvetica Neue\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 14px; line-height: 1.6em; border-radius: 25px; text-align: center; vertical-align: top; background: #348eda; margin: 0; padding: 0;" align="center" bgcolor="#348eda" valign="top">
                
                </td>
              </tr></table>';;
			$body 			.= $this->prepare_email_footers();
			wp_mail($admin_email, $subject, $body);
			
			//return true;
		 }
		 
		 /**
		 * @Rating
		 *
		 * @since 1.0.0
		 */
		 public function process_rating_email( $params = '' ) {
			global $current_user;
			
			extract( $params );

			$subject = 'New rating received!';
			$rating_content_default = 'Hey %name%!<br/>

									A new rating has been received, Detail for rating is given below:
									<br/>
									Rating: %rating%<br/>
									Rating From: %rating_from%<br/>
									Reason: %reason%<br/>
									Comment: <br/>
									---------------------------------------<br/>
									You can view this at %link%
									
									Sincerely,<br/>
									%logo%';
				
			
			if (function_exists('fw_get_db_post_option')) {
				$subject = fw_get_db_settings_option('rating_subject');
				$rating_content = fw_get_db_settings_option('rating_content');
			}
			
			//set defalt contents
			if( empty( $rating_content ) ){
				$rating_content = $rating_content_default;
			}
			
			$rating_from	= '<a href="'.$link_from.'"  alt="'.esc_html__('Rating from','docdirect').'">'.$username_from.'</a>';
			$link		   = '<a href="'.$link_to.'" alt="'.esc_html__('User link','docdirect').'">'.$link_to.'</a>';
			$logo		   = $this->process_get_logo();
			
			$rating_content = str_replace("%rating%", nl2br($rating), $rating_content); //Replace rating
			$rating_content = str_replace("%reason%", nl2br($reason), $rating_content); //Replace reason
			$rating_content = str_replace("%name%", nl2br($username_to), $rating_content); //Replace name
			
			$rating_content = str_replace("%rating_from%", nl2br($rating_from), $rating_content); //Replace email
			$rating_content = str_replace("%link%", nl2br($link), $rating_content); //Replace email
			$rating_content = str_replace("%logo%", nl2br($logo), $rating_content); //Replace logo
			
			
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			$admin_email	= get_option( 'admin_email' ,'info@themographics.com' );
			
			$email_headers = "From: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "Reply-To: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "MIME-Version: 1.0\r\n";
			$email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			$attachments	  = '';
			$body			 = '';
			$body			.= $this->prepare_email_headers($name);

			$body			.= ' <p style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;">'.$rating_content.'</p>';
			$body			.= '<table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: auto !important; Margin: 0 0 10px; padding: 0;"><tr style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: \'Helvetica Neue\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 14px; line-height: 1.6em; border-radius: 25px; text-align: center; vertical-align: top; background: #348eda; margin: 0; padding: 0;" align="center" bgcolor="#348eda" valign="top">
                
                </td>
              </tr></table>';

			$body 			.= $this->prepare_email_footers();
			wp_mail($email_to, $subject, $body);
			
			return true;
		 }
		 
		 /**
		 * @Invoice
		 *
		 * @since 1.0.0
		 */
		 public function process_invoice_email( $params = '' ) {
			global $current_user;
			extract( $params );
			
			$subject = 'Thank you for purchasing package!';
			$payment_content_default = 'Hey %name%!<br/>

									Thanks for purchasing the package. Your payment has been received and your invoice detail is given below:
									<br/>
									Invoice ID: %invoice%<br/>
									Package Name: %package_name%<br/>
									Payment Amount: %amount%<br/>
									Payment Status: %status%<br/>
									Payment Method: %method%<br/>
									Purchase Date: %date%<br/>
									Expiry Date: %expiry%<br/>
									Address: %address%<br/>
									
									Sincerely,<br/>
									%logo%';
				
			if (function_exists('fw_get_db_post_option')) {
				$subject = fw_get_db_settings_option('invoice_subject');
				$payment_content = fw_get_db_settings_option('payment_content');
			}
			
			//set defalt contents
			if( empty( $payment_content ) ){
				$payment_content = $payment_content_default;
			}
			
			$logo		   = $this->process_get_logo();
			
			$payment_content = str_replace("%name%", nl2br($name), $payment_content); //Replace Name
			$payment_content = str_replace("%invoice%", nl2br($invoice), $payment_content); //Replace invoice id
			$payment_content = str_replace("%amount%", nl2br($amount), $payment_content); //Replace amount
			$payment_content = str_replace("%package_name%", nl2br($package_name), $payment_content); //Replace amount
			$payment_content = str_replace("%status%", nl2br($status), $payment_content); //Replace status
			$payment_content = str_replace("%method%", nl2br($method), $payment_content); //Replace payment method
			$payment_content = str_replace("%date%", nl2br($date), $payment_content); //Replace expiry date
			$payment_content = str_replace("%expiry%", nl2br($expiry), $payment_content); //Replace password
			$payment_content = str_replace("%address%", nl2br($address), $payment_content); //Replace email
			$payment_content = str_replace("%logo%", nl2br($logo), $payment_content); //Replace logo
			
			
			
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			$admin_email	= get_option( 'admin_email' ,'info@themographics.com' );
			
			$email_headers = "From: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "Reply-To: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "MIME-Version: 1.0\r\n";
			$email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			
			
			$attachments	  = '';
			$body			 = '';
			$body			.= $this->prepare_email_headers($name);
			
			
			$body			.= ' <p style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;">'.$payment_content.'</p>';
			$body			.= '<table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: auto !important; Margin: 0 0 10px; padding: 0;"><tr style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: \'Helvetica Neue\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 14px; line-height: 1.6em; border-radius: 25px; text-align: center; vertical-align: top; background: #348eda; margin: 0; padding: 0;" align="center" bgcolor="#348eda" valign="top">
                
                </td>
              </tr></table>';

			$body 			.= $this->prepare_email_footers();
			wp_mail($mail_to, $subject, $body);
			
			return true;
		 }
		 
		/**
		 * @Appointment Confirmation
		 *
		 * @since 1.0.0
		 */
		 public function process_appointment_confirmation_email( $params = '' ) {
			global $current_user;
			extract( $params );
			
			$date_format = get_option('date_format');
			$time_format = get_option('time_format');
		
			$user_from	= get_post_meta($post_id, 'bk_user_from', true);
			$user_to	  = get_post_meta($post_id, 'bk_user_to', true);
			
			$customer_name	= get_post_meta($post_id, 'bk_username', true);
			$email_to		 = get_post_meta($post_id, 'bk_useremail', true);
			$bk_booking_date	= get_post_meta($post_id, 'bk_booking_date', true);
			$bk_slottime		= get_post_meta($post_id, 'bk_slottime', true);
			$bk_service		 = get_post_meta($post_id, 'bk_service', true);
			$bk_category		= get_post_meta($post_id, 'bk_category', true);
			
			$user_from_data	= get_userdata($user_from);
			$user_to_data	  = get_userdata($user_to);
			$booking_services	= get_user_meta($user_to , 'booking_services' , true);
			$address			 = get_user_meta($user_to , 'address' , true);
			$service	= $booking_services[$bk_service]['title'];
			
			$time = explode('-',$bk_slottime);
			$appointment_date	= date_i18n($date_format,strtotime($bk_booking_date) );
			$appointment_time	= date_i18n($time_format,strtotime('2016-01-01 '.$time[0]) );
			
			
			$subject_default = 'Your Appointment Confirmation';
			$booking_confirmed_default = 'Hey %customer_name%!<br/>

						This is confirmation that you have booked "%service%"<br/>
						We will let your know regarding your booking soon.<br/><br/>
						
						Thank you for choosing our company.<br/><br/>
						
						Sincerely,<br/>
						%logo%';

			$subject = get_user_meta($user_to , 'confirmation_title' , true);
			$booking_approved = get_user_meta($user_to , 'booking_confirmed' , true);

			
			//set defalt subject
			if( empty( $subject ) ){
				$subject = $subject_default;
			}
			
			//set defalt contents
			if( empty( $booking_confirmed ) ){
				$booking_confirmed = $booking_confirmed_default;
			}
			
			$logo		   = $this->process_get_logo();
			$booking_confirmed = str_replace("%customer_name%", nl2br($customer_name), $booking_confirmed); //Replace Name
			$booking_confirmed = str_replace("%service%", nl2br($service), $booking_confirmed); //Replace service
			$booking_confirmed = str_replace("%logo%", nl2br($logo), $booking_confirmed); //Replace logo
			
			
			
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			$admin_email	= get_option( 'admin_email' ,'info@themographics.com' );
			
			$email_headers = "From: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "Reply-To: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "MIME-Version: 1.0\r\n";
			$email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			
			
			$attachments	  = '';
			$body			 = '';
			$body			.= $this->prepare_email_headers($customer_name);
			
			
			$body			.= ' <p style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;">'.$booking_confirmed.'</p>';
			$body			.= '<table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: auto !important; Margin: 0 0 10px; padding: 0;"><tr style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: \'Helvetica Neue\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 14px; line-height: 1.6em; border-radius: 25px; text-align: center; vertical-align: top; background: #348eda; margin: 0; padding: 0;" align="center" bgcolor="#348eda" valign="top">
                
                </td>
              </tr></table>';

			$body 			.= $this->prepare_email_footers();
			wp_mail($email_to, $subject, $body);
			
			return true;
		 }
		 
		 /**
		 * @Appointment Email To Professional User
		 *
		 * @since 1.0.0
		 */
		 public function process_appointment_confirmation_admin_email( $params = '' ) {
			global $current_user;
			extract( $params );
			
			$date_format = get_option('date_format');
			$time_format = get_option('time_format');
		
			$user_from	= get_post_meta($post_id, 'bk_user_from', true);
			$user_to	  = get_post_meta($post_id, 'bk_user_to', true);
			
			$customer_name	= get_post_meta($post_id, 'bk_username', true);
			$email_to		 = get_post_meta($post_id, 'bk_useremail', true);
			$bk_booking_date	= get_post_meta($post_id, 'bk_booking_date', true);
			$bk_slottime		= get_post_meta($post_id, 'bk_slottime', true);
			$bk_service		 = get_post_meta($post_id, 'bk_service', true);
			$bk_category		= get_post_meta($post_id, 'bk_category', true);
			
			$user_from_data	= get_userdata($user_from);
			$user_to_data	  = get_userdata($user_to);

			$booking_services	= get_user_meta($user_to , 'booking_services' , true);
			$address			 = get_user_meta($user_to , 'address' , true);
			$service			 = $booking_services[$bk_service]['title'];
			
			$time = explode('-',$bk_slottime);
			$appointment_date	= date_i18n($date_format,strtotime($bk_booking_date) );
			$appointment_time	= date_i18n($time_format,strtotime('2016-01-01 '.$time[0]) );
			
			
			$subject_default = 'A new Appointment has received!';
			$booking_confirmed_default = 'Hello<br/>

						This is confirmation that you have received an appoinment.<br/>
						To view detail please login to your dashboard and check it<br/><br/>
						
						Thank you<br/><br/>
						
						Sincerely,<br/>';

			//set defalt subject
			$subject = $subject_default;
			
			//set defalt contents
			$booking_confirmed = $booking_confirmed_default;
			$logo		   = $this->process_get_logo();
			
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			$admin_email	= get_option( 'admin_email' ,'info@themographics.com' );
			
			$email_to	= !empty( $user_to_data->user_email ) ? $user_to_data->user_email : $admin_email; 
			
			$email_headers = "From: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "Reply-To: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "MIME-Version: 1.0\r\n";
			$email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			
			
			$attachments	  = '';
			$body			 = '';
			$body			.= $this->prepare_email_headers('');
			
			
			$body			.= ' <p style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;">'.$booking_confirmed.'</p>';
			$body			.= '<table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: auto !important; Margin: 0 0 10px; padding: 0;"><tr style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: \'Helvetica Neue\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 14px; line-height: 1.6em; border-radius: 25px; text-align: center; vertical-align: top; background: #348eda; margin: 0; padding: 0;" align="center" bgcolor="#348eda" valign="top">
                
                </td>
              </tr></table>';

			$body 			.= $this->prepare_email_footers();
			wp_mail($email_to, $subject, $body);
			
			return true;
		 }
		 
		/**
		 * @Appointment Approved
		 *
		 * @since 1.0.0
		 */
		 public function process_appointment_approved_email( $params = '' ) {
			global $current_user;
			extract( $params );
			
			$date_format = get_option('date_format');
			$time_format = get_option('time_format');
		
			$user_from	= get_post_meta($post_id, 'bk_user_from', true);
			$user_to	  = get_post_meta($post_id, 'bk_user_to', true);
			
			$customer_name	= get_post_meta($post_id, 'bk_username', true);
			$email_to		 = get_post_meta($post_id, 'bk_useremail', true);
			$bk_booking_date	= get_post_meta($post_id, 'bk_booking_date', true);
			$bk_slottime		= get_post_meta($post_id, 'bk_slottime', true);
			$bk_service		 = get_post_meta($post_id, 'bk_service', true);
			$bk_category		= get_post_meta($post_id, 'bk_category', true);
			
			$user_from_data	= get_userdata($user_from);
			$user_to_data	  = get_userdata($user_to);
			$booking_services	= get_user_meta($user_to , 'booking_services' , true);
			$address			 = get_user_meta($user_to , 'address' , true);
			$service	= $booking_services[$bk_service]['title'];
			
			$time = explode('-',$bk_slottime);
			$appointment_date	= date_i18n($date_format,strtotime($bk_booking_date) );
			$appointment_time	= date_i18n($time_format,strtotime('2016-01-01 '.$time[0]) );
			
			$subject_default = 'Your Appointment Approved';
			$booking_approved_default = 'Hey %customer_name%!<br/>

						This is confirmation that your booking regarding "%service%" has approved.<br/>
						
						We are waiting you at "%address%" on %appointment_date% at %appointment_time%.<br/><br/><br/>
						
						Sincerely,<br/>
						%logo%';
				
			if (function_exists('fw_get_db_post_option')) {
				$subject = get_user_meta($user_to , 'approved_title' , true);
				$booking_approved = get_user_meta($user_to , 'booking_approved' , true);
			}
			
			//set defalt contents
			if( empty( $subject ) ){
				$subject = $subject_default;
			}
			
			//set defalt title
			if( empty( $booking_approved ) ){
				$booking_approved = $booking_approved_default;
			}
			
			$logo		   = $this->process_get_logo();
			
			$booking_approved = str_replace("%customer_name%", nl2br($customer_name), $booking_approved); //Replace Name
			$booking_approved = str_replace("%service%", nl2br($service), $booking_approved); //Replace service
			$booking_approved = str_replace("%address%", nl2br($address), $booking_approved); //Replace address
			$booking_approved = str_replace("%appointment_date%", nl2br($appointment_date), $booking_approved); //Replace date
			$booking_approved = str_replace("%appointment_time%", nl2br($appointment_time), $booking_approved); //Replace time
			$booking_approved = str_replace("%logo%", nl2br($logo), $booking_approved); //Replace logo
			
			
			
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			$admin_email	= get_option( 'admin_email' ,'info@themographics.com' );
			
			$email_headers = "From: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "Reply-To: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "MIME-Version: 1.0\r\n";
			$email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			$attachments	  = '';
			$body			 = '';
			$body			.= $this->prepare_email_headers($customer_name);
			
			
			$body			.= ' <p style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;">'.$booking_approved.'</p>';
			$body			.= '<table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: auto !important; Margin: 0 0 10px; padding: 0;"><tr style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: \'Helvetica Neue\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 14px; line-height: 1.6em; border-radius: 25px; text-align: center; vertical-align: top; background: #348eda; margin: 0; padding: 0;" align="center" bgcolor="#348eda" valign="top">
                
                </td>
              </tr></table>';

			$body	.= $this->prepare_email_footers();
			wp_mail($email_to, $subject, $body);
			
			return true;
		 }
		 
		/**
		 * @Appointment Cancelled
		 *
		 * @since 1.0.0
		 */
		 public function process_appointment_cancelled_email( $params = '' ) {
			global $current_user;
			extract( $params );
			
			$date_format = get_option('date_format');
			$time_format = get_option('time_format');
		
			$user_from	= get_post_meta($post_id, 'bk_user_from', true);
			$user_to	  = get_post_meta($post_id, 'bk_user_to', true);
			
			$customer_name	= get_post_meta($post_id, 'bk_username', true);
			$email_to		 = get_post_meta($post_id, 'bk_useremail', true);
			$bk_booking_date	= get_post_meta($post_id, 'bk_booking_date', true);
			$bk_slottime		= get_post_meta($post_id, 'bk_slottime', true);
			$bk_service		 = get_post_meta($post_id, 'bk_service', true);
			$bk_category		= get_post_meta($post_id, 'bk_category', true);
			
			$user_from_data	= get_userdata($user_from);
			$user_to_data	  = get_userdata($user_to);
			$booking_services	= get_user_meta($user_to , 'booking_services' , true);
			$address			 = get_user_meta($user_to , 'address' , true);
			$service	= $booking_services[$bk_service]['title'];
			
			$time = explode('-',$bk_slottime);
			$appointment_date	= date_i18n($date_format,strtotime($bk_booking_date) );
			$appointment_time	= date_i18n($time_format,strtotime('2016-01-01 '.$time[0]) );
			
			$subject_default = 'Your Appointment Cancelled';
			$booking_cancelled_default = 'Hey %customer_name%!<br/>

						 This is confirmation that your booking regarding "%service%" has cancelled.<br/>
						
						 We are very sorry to process your booking right now.<br/><br/>
						
						 Sincerely,<br/>
						 %logo%';
				
			if (function_exists('fw_get_db_post_option')) {
				$subject = get_user_meta($user_to , 'cancelled_title' , true);
				$booking_cancelled = get_user_meta($user_to , 'booking_cancelled' , true);
			}
			
			//set defalt contents
			if( empty( $subject ) ){
				$subject = $subject_default;
			}
			
			//set defalt title
			if( empty( $booking_cancelled ) ){
				$booking_cancelled = $booking_cancelled_default;
			}
			
			$logo		   = $this->process_get_logo();
			
			$booking_cancelled = str_replace("%customer_name%", nl2br($customer_name), $booking_cancelled); //Replace Name
			$booking_cancelled = str_replace("%service%", nl2br($service), $booking_cancelled); //Replace Service
			$booking_cancelled = str_replace("%logo%", nl2br($logo), $booking_cancelled); //Replace logo
			
			
			
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			$admin_email	= get_option( 'admin_email' ,'info@themographics.com' );
			
			$email_headers = "From: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "Reply-To: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "MIME-Version: 1.0\r\n";
			$email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			$attachments	  = '';
			$body			 = '';
			$body			.= $this->prepare_email_headers($customer_name);
			
			
			$body			.= ' <p style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;">'.$booking_cancelled.'</p>';
			$body			.= '<table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: auto !important; Margin: 0 0 10px; padding: 0;"><tr style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: \'Helvetica Neue\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 14px; line-height: 1.6em; border-radius: 25px; text-align: center; vertical-align: top; background: #348eda; margin: 0; padding: 0;" align="center" bgcolor="#348eda" valign="top">
                
                </td>
              </tr></table>';

			$body 			.= $this->prepare_email_footers();
			wp_mail($email_to, $subject, $body);
			
			return true;
		 }
		 
		 
		 /**
		 * @User Contact Form 
		 *
		 * @since 1.0.0
		 */
		 public function process_contact_user_email( $params = '' ) {
			global $current_user;
			extract( $params );
			
			$email_subject = !empty( $email_subject ) ? $email_subject : "(" . $bloginfo . ")".esc_html__('Contact Form Received','docdirect');
			$contact_default = 'Hello,<br/>

						A person has contact you, description of message is given below.<br/><br/>
						Subject : %subject%<br/>
						Name : %name%<br/>
						Email : %email%<br/>
						Phone Number : %phone%<br/>
						Message : %message%<br/><br/><br/>
						
						Sincerely,<br/>';
			
			
			$contact_default = str_replace("%subject%", nl2br($subject), $contact_default); //Replace Subject
			$contact_default = str_replace("%name%", nl2br($name), $contact_default); //Replace Name
			$contact_default = str_replace("%email%", nl2br($email), $contact_default); //Replace email
			$contact_default = str_replace("%phone%", nl2br($phone), $contact_default); //Replace phone
			$contact_default = str_replace("%message%", nl2br($message), $contact_default); //Replace message
		
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			$admin_email	= get_option( 'admin_email' ,'info@themographics.com' );
			
			$email_headers = "From: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "Reply-To: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "MIME-Version: 1.0\r\n";
			$email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			$attachments	  = '';
			$body			 = '';
			$body			.= $this->prepare_email_headers($name);
			
			
			$body			.= ' <p style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;">'.$contact_default.'</p>';
			$body			.= '<table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: auto !important; Margin: 0 0 10px; padding: 0;"><tr style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: \'Helvetica Neue\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 14px; line-height: 1.6em; border-radius: 25px; text-align: center; vertical-align: top; background: #348eda; margin: 0; padding: 0;" align="center" bgcolor="#348eda" valign="top">
                
                </td>
              </tr></table>';

			$body	.= $this->prepare_email_footers();
			wp_mail($email_to, $email_subject, $body);
			
			return true;
		 }
		 
		/**
		 * @Site Contact Form 
		 *
		 * @since 1.0.0
		 */
		 public function process_contact_form( $params = '' ) {
			global $current_user;
			extract( $params );
			
			$email_subject = !empty( $email_subject ) ? $email_subject : "(" . $bloginfo . ")".esc_html__('Contact Form Received','docdirect');
			$contact_default = 'Hello,<br/>

						A person has contact you, description of message is given below.<br/><br/>
						Subject : %subject%<br/>
						Name : %name%<br/>
						Email : %email%<br/>
						Phone Number : %phone%<br/>
						Message : %message%<br/><br/><br/>
						
						Sincerely,<br/>';
			
			
			$contact_default = str_replace("%subject%", nl2br($subject), $contact_default); //Replace Subject
			$contact_default = str_replace("%name%", nl2br($name), $contact_default); //Replace Name
			$contact_default = str_replace("%email%", nl2br($email), $contact_default); //Replace email
			$contact_default = str_replace("%phone%", nl2br($phone), $contact_default); //Replace phone
			$contact_default = str_replace("%message%", nl2br($message), $contact_default); //Replace message
		
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			$admin_email	= get_option( 'admin_email' ,'info@themographics.com' );
			
			$email_headers = "From: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "Reply-To: no-reply <info@no-reply.com>\r\n";
			$email_headers .= "MIME-Version: 1.0\r\n";
			$email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

			$attachments	  = '';
			$body			 = '';
			$body			.= $this->prepare_email_headers($name);
			
			
			$body			.= ' <p style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;">'.$contact_default.'</p>';
			$body			.= '<table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: auto !important; Margin: 0 0 10px; padding: 0;"><tr style="font-family: \'Helvetica Neue\', \'Helvetica\', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: \'Helvetica Neue\', Helvetica, Arial, \'Lucida Grande\', sans-serif; font-size: 14px; line-height: 1.6em; border-radius: 25px; text-align: center; vertical-align: top; background: #348eda; margin: 0; padding: 0;" align="center" bgcolor="#348eda" valign="top">
                
                </td>
              </tr></table>';

			$body	.= $this->prepare_email_footers();
			wp_mail($email_to, $email_subject, $body);
			
			return true;
		 }
		 
 
	}
	new DocDirectProcessEmail();
}