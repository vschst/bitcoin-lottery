$("#check-participant-data-btn").on('click',
	function() {
		//Client-side check
		var participant_data_to_check = {
			[csrf.name]: csrf.hash,
			btc_address: $('#btc-address').val(),
			email: $('#email').val()
		};

		if (participant_data_to_check.btc_address == '') {
			show_error_alert('btc-address', error_alerts.empty_btc_address);
		}
		else if (participant_data_to_check.email == '') {
			show_error_alert('email', error_alerts.empty_email);
		}
		else if (!$('#confirmation-of-terms').prop('checked')) {
			show_error_alert(null, error_alerts.confirmation_is_required);
		}
		else {
			$(this).find('i').removeClass("d-none");

			setTimeout(
				function(participant_data_to_check) {
					$.ajax({
						url: "/join/ajax_check_participant_data",
						method: "POST",
						data: participant_data_to_check
					})
					.done(
						function (data) {
							var data_obj = $.parseJSON(data);
							
							if (data_obj && data_obj.hasOwnProperty('csrf') && data_obj.hasOwnProperty('check_status')) {
								csrf = data_obj.csrf;
								
								$("#check-participant-data-btn").find('i').addClass("d-none");
								
								//Server-side check
								switch (data_obj.check_status) {
									case (-1):
										show_error_alert('btc-address', error_alerts.incorrect_btc_address);
										break;
									case (-2):
										show_error_alert('email', error_alerts.incorrect_email);
										break;
									case (-3):
										show_error_alert(null, error_alerts.already_lottery_participant);
										break;
									default:
										$(location).attr('href', '/join/confirm');
								}
							}
						}
					);
				},
			1000, participant_data_to_check);
		}
	}
);

function show_error_alert(element_id, message) {
	$("#error-alert").text(message).fadeIn();
	
	if (element_id != undefined) {
		$('#' + element_id).addClass('is-invalid');
	}
}

$('#btc-address, #email, #confirmation-of-terms').on('focus',
	function() {
		$("#error-alert").fadeOut();
		$(this).removeClass('is-invalid');
	}
);