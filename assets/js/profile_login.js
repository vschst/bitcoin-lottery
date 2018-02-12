$("#login-btn").on('click',
	function() {
		//Client-side check
		var auth_data_to_check = {
			btc_address: $('#btc-address').val(),
			email: $('#email').val()
		};

		if (auth_data_to_check.btc_address == '') {
			show_error_alert('btc-address', error_alerts.empty_btc_address);
		}
		else if (auth_data_to_check.email == '') {
			show_error_alert('email', error_alerts.empty_email);
		}
		else {
			$(this).find('i').removeClass("d-none");
			
			setTimeout(
				function(auth_data_to_check) {
					$.ajax({
						url: "/profile/ajax_check_auth_data",
						method: "POST",
						data: auth_data_to_check
					})
					.done(
						function (data) {
							var data_obj = $.parseJSON(data);
							
							if (data_obj.hasOwnProperty('check_status')) {
								$("#login-btn").find('i').addClass("d-none");
								
								//Server-side check
								switch(data_obj.check_status) {
									case (-1):
										show_error_alert('btc-address', error_alerts.incorrect_btc_address);
										break;
									case (-2):
										show_error_alert('email', error_alerts.incorrect_email);
										break;
									case (-3):
										show_error_alert(null, error_alerts.invalid_login_data);
										break;
									default:
										$(location).attr('href', '/profile');
								}
							}
						}
					);
				},
			1000, auth_data_to_check);
		}
	}
);

//	utils
function show_error_alert(element_id, message) {
	$("#error-alert").text(message).fadeIn();
	
	if (element_id != undefined) {
		$('#' + element_id).addClass('is-invalid');
	}
}

$('#btc-address, #email').on('focus',
	function() {
		$("#error-alert").fadeOut();
		$(this).removeClass('is-invalid');
	}
);