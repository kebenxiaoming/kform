(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	var time_obj;//js timeout object
	$(document).on('click', '#kform_form_btn', {},
		function () {
		    let btn_sub = $(this);
			let click_data = btn_sub.data('click');
			if(!click_data){
				return false;
			}
			if('undefined'!=time_obj){
				clearTimeout(time_obj);
			}
			$('.kform-alert').hide();
			btn_sub.data('click',0)//use in callback
			$.post(kform_ajax_obj.ajax_url, {      //POST request
					_ajax_nonce: kform_ajax_obj.nonce, //nonce
					action: kform_ajax_obj.action,//action
					title: $('#input-title').val(),//title
					email: $('#input-email').val(),//email
					phone: $('#input-phone').val(),//phone
					content: $('#input-content').val(),//content
				}, function (data) {//callback
					let data_obj = JSON.parse(data);
					if(data_obj.status == 0){
						$('#danger-alert').text(data_obj.msg);
						$('.alert-danger').show();
						time_obj=setTimeout(function(){$('.kform-alert').hide();}
							,2000)
					}else{
						$('#success-alert').text(data_obj.msg);
						$('.alert-success').show();
						time_obj=setTimeout(function(){$('.kform-alert').hide();}
							,2000)
					}
					btn_sub.data('click',1);
				}
			);
	});
})( jQuery );
