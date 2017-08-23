<?php

if (!defined('FW')) {
    die('Forbidden');
}


$options = array(
    'notification_settings' => array(
        'type' => 'tab',
        'title' => esc_html__('Email Notification Settings', 'docdirect'),
        'options' => array(
			'register_user' => array(
                'title' => esc_html__('Email Content - Registration', 'docdirect'),
                'type' => 'box',
                'options' => array(
                    'register_subject' => array(
                        'type' => 'text',
                        'value' => 'Thank you for registering!',
                        'label' => esc_html__('Subject', 'docdirect'),
                        'desc' => esc_html__('Please add Subject for email', 'docdirect'),
                    ),
					'info' => array(
						'type'  => 'html',
						'value' => '',
						'attr'  => array(),
						'label' => esc_html__('Email Settings variables', 'docdirect'),
						'desc'  => esc_html__('', 'docdirect'),
						'help'  => esc_html__('', 'docdirect'),
						'html'  => '%name% — To display the person\'s name. <br/>
						%email% — To display the person\'s email address.<br/>
						%username% — To display the username for login.<br/>
						%password% — To display the password for login.<br/>
						%logo% — To display site logo.<br/>',
					),
					'register_content' => array(
						'type'  => 'wp-editor',
						'value' => 'Hey %name%!<br/>

									Thanks for registering at DocDirect. You can now login to manage your account using the following credentials:
									<br/>
									Username: %username%<br/>
									Password: %password%<br/>
									
									Sincerely,<br/>
									DocDirect Team<br/>
									%logo%
									',
						'attr'  => array(),
						'label' => esc_html__('Email Contents', 'docdirect'),
						'desc'  => esc_html__('', 'docdirect'),
						'help'  => esc_html__('', 'docdirect'),
						'size' => 'large', // small, large
						'editor_height' => 400,
					
						/**
						 * Also available
						 * https://github.com/WordPress/WordPress/blob/4.4.2/wp-includes/class-wp-editor.php#L80-L94
						 */
					)
                )
            ),
			'admin_email' => array(
                'title' => esc_html__('Admin Email Content - Registration', 'docdirect'),
                'type' => 'box',
                'options' => array(
                    'admin_email_section' => array(
						'type' => 'html',
						'html' => esc_html__('Admin Email', 'docdirect'),
						'label' => esc_html__('', 'docdirect'),
						'desc' => esc_html__('This email will be sent to admin when new user register on your site.', 'docdirect'),
						'help' => esc_html__('', 'docdirect'),
						'images_only' => true,
					),
					'admin_register_subject' => array(
                        'type' => 'text',
                        'value' => 'New Registration!',
                        'label' => esc_html__('Subject', 'docdirect'),
                        'desc' => esc_html__('Add email subject.', 'docdirect'),
                    ),
					'admin_email' => array(
                        'type' => 'text',
                        'value' => 'info@yourdomain.com',
                        'label' => esc_html__('Admin email address', 'docdirect'),
                        'desc' => esc_html__('Please add admin email address, leave it empty to get email address from WordPress Settings.', 'docdirect'),
                    ),
					'admin_info' => array(
						'type'  => 'html',
						'value' => '',
						'attr'  => array(),
						'label' => esc_html__('Email Settings variables', 'docdirect'),
						'desc'  => esc_html__('', 'docdirect'),
						'help'  => esc_html__('', 'docdirect'),
						'html'  => '%username% — To display new registered  username. <br/>
						%link% — To display the new registered user profile page at admin site.<br/>
						%email% — To display the username for login.<br/>
						%logo% — To display site logo.<br/>',
					),
					'admin_register_content' => array(
						'type'  => 'wp-editor',
						'value' => 'Hey<br/>

									A new user "%username%" with email address "%email%" has registered on your website. Please login to check user detail.
									<br/>
									You can check user detail at: %link%<br/><br/><br/>
									
									Sincerely,<br/>
									%logo%
									',
						'attr'  => array(),
						'label' => esc_html__('Email Contents', 'docdirect'),
						'desc'  => esc_html__('', 'docdirect'),
						'help'  => esc_html__('', 'docdirect'),
						'size' => 'large', // small, large
						'editor_height' => 400,
					
						/**
						 * Also available
						 * https://github.com/WordPress/WordPress/blob/4.4.2/wp-includes/class-wp-editor.php#L80-L94
						 */
					)
                )
            ),
			'package_payment' => array(
                'title' => esc_html__('Payments (Invoice Detail)', 'docdirect'),
                'type' => 'box',
                'options' => array(
					'invoice_subject' => array(
                        'type' => 'text',
                        'value' => 'Thank you for purchasing package!',
                        'label' => esc_html__('Subject', 'docdirect'),
                        'desc' => esc_html__('Please add Subject for email', 'docdirect'),
                    ),
					'info' => array(
						'type'  => 'html',
						'value' => '',
						'attr'  => array(),
						'label' => esc_html__('Email Settings variables', 'docdirect'),
						'desc'  => esc_html__('', 'docdirect'),
						'help'  => esc_html__('', 'docdirect'),
						'html'  => '%name% — To display the person\'s name. <br/>
						%email% — To display the person\'s email address.<br/>
						%invoice% — To display the invoice id for payment.<br/>
						%package_name% — To display the package name.<br/>
						%amount% — To display the payment amount.<br/>
						%status% — To display the payment status.<br/>
						%method% — To display payment mehtod.<br/>
						%date% — To display purchase date.<br/>
						%expiry% — To display package expiry date.<br/>
						%address% — To display payer address.<br/>
						%logo% — To display site logo.<br/>',
						
					),
					'payment_content' => array(
						'type'  => 'wp-editor',
						'value' => 'Hey %name%!<br/>

									Thanks for purchasing the package. Your payment has been received and your invoice detail is given below:
									<br/>
									Invoice ID: %invoice%<br/>
									Package Name: %package_name%<br/>
									Payment Amount: %amount%<br/>
									Payment status: %status%<br/>
									Payment Method: %method%<br/>
									Purchase Date: %date%<br/>
									Expiry Date: %expiry%<br/>
									Address: %address%<br/>
									
									Sincerely,<br/>
									DocDirect Team<br/>
									%logo%
									',
						'attr'  => array(),
						'label' => esc_html__('Email Contents', 'docdirect'),
						'desc'  => esc_html__('', 'docdirect'),
						'help'  => esc_html__('', 'docdirect'),
						'size' => 'large', // small, large
						'editor_height' => 400,
					
						/**
						 * Also available
						 * https://github.com/WordPress/WordPress/blob/4.4.2/wp-includes/class-wp-editor.php#L80-L94
						 */
					)
                )
            ),
			'rating' => array(
                'title' => esc_html__('Rating ( Received )', 'docdirect'),
                'type' => 'box',
                'options' => array(
					'rating_subject' => array(
                        'type' => 'text',
                        'value' => 'New rating received!',
                        'label' => esc_html__('Subject', 'docdirect'),
                        'desc' => esc_html__('Please add Subject for email', 'docdirect'),
                    ),
					'info' => array(
						'type'  => 'html',
						'value' => '',
						'attr'  => array(),
						'label' => esc_html__('Email Settings variables', 'docdirect'),
						'desc'  => esc_html__('', 'docdirect'),
						'help'  => esc_html__('', 'docdirect'),
						'html'  => '%name% — To display the person\'s name. <br/>
						%rating_from% — To display the person name who rate user.<br/>
						%reason% — To display the rating subject.<br/>
						%link% — To display the rating page link.<br/>
						%rating% — To display the rating.<br/>
						%logo% — To display site logo.<br/>',
						
					),
					'rating_content' => array(
						'type'  => 'wp-editor',
						'value' => 'Hey %name%!<br/>

									A new rating has been received, Detail for rating is given below:
									<br/>
									Rating: %rating%<br/>
									Rating From: %rating_from%<br/>
									Reason: %reason%<br/>
									Comment: <br/>
									---------------------------------------<br/>
									You can view this at %link%
									
									Sincerely,<br/>
									DocDirect Team<br/>
									%logo%
									',
						'attr'  => array(),
						'label' => esc_html__('Email Contents', 'docdirect'),
						'desc'  => esc_html__('', 'docdirect'),
						'help'  => esc_html__('', 'docdirect'),
						'size' => 'large', // small, large
						'editor_height' => 400,
					
						/**
						 * Also available
						 * https://github.com/WordPress/WordPress/blob/4.4.2/wp-includes/class-wp-editor.php#L80-L94
						 */
					)
                )
            ),
        )
    )
);


