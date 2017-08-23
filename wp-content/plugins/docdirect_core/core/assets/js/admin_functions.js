"use strict";
jQuery(document).ready(function (e) {

	/* -------------------------------------
     Upload Avatar
     -------------------------------------- */
	jQuery('#upload_dapartment_image').on('click', function () {
		"use strict";
		var $ = jQuery;
		var custom_uploader = wp.media({
			title: 'Select File',
			button: {
				text: 'Add File'
			},
			multiple: false
		})
				.on('select', function () {
					var attachment = custom_uploader.state().get('selection').first().toJSON();
					jQuery('#dapartment_image').val(attachment.url);
					jQuery('#department-src').attr('src', attachment.url);
					jQuery('#department-wrap').show();
				}).open();

	});
	
	/*---------------------------------------------------------------------
	  * Import Users
	  *---------------------------------------------------------------------*/
	 jQuery(document).on('click', '.doc-import-users', function() {
		 jQuery.confirm({
			'title': 'Import Users',
			'message': 'Are you sure, you want to import users?',
			'buttons': {
				'Yes': {
					'class': 'blue',
					'action': function () {
						var dataString = 'action=docdirect_do_import_users';
						var $this = jQuery(this);
						jQuery('#import-users').append('<div class="inportusers"><i class="fa fa-cog fa-3x fa-spin"></i></div>');
						jQuery.ajax({
							type: "POST",
							url: ajaxurl,
							dataType:"json",
							data: dataString,
							success: function(response) {
								jQuery('#import-users').find('.inportusers').remove();
								jQuery.sticky(response.message, {classList: 'success', speed: 200, autoclose: 5000});
							}
						});
				
						return false;
					}
				},
				'No': {
					'class': 'gray',
					'action': function () {
						return false;
					}	// Nothing to do in this case. You can as well omit the action property.
				}
			}
		});
    });
	
});