var $ = jQuery;

$("#check-participant-data").submit(
	function(event) {
		event.preventDefault();

		//Client-side check
		var participant_data_to_check = {
			[csrf.name]: csrf.hash,
			btc_address: $(this).find('#btc-address').val(),
			email: $(this).find('#email').val()
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
			$(this).find('#submit-btn').find('[data-fa-i2svg]').removeClass("d-none");

			setTimeout(
				function(form_url, participant_data_to_check) {
					$.ajax({
						url: form_url,
						method: "POST",
						data: participant_data_to_check
					})
					.done(
						function (data) {
							var data_obj = $.parseJSON(data);
							
							if (data_obj && data_obj.hasOwnProperty('csrf') && data_obj.hasOwnProperty('check_status')) {
								csrf = data_obj.csrf;
								
								$('#check-participant-data').find('#submit-btn').find('[data-fa-i2svg]').addClass("d-none");
								
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
										location.reload();
								}
							}
						}
					);
				},
			1000, $(this).attr('action'), participant_data_to_check);
		}
	}
);

function show_error_alert(element_id, message) {
	$("#error-alert").text(message).fadeIn();

	if (element_id != undefined) {
		$('#check-participant-data').find('#' + element_id).addClass('is-invalid');
	}
}

$('#check-participant-data').find('#btc-address, #email, #confirmation-of-terms').on('focus',
	function() {
		$("#error-alert").fadeOut();
		$(this).removeClass('is-invalid');
	}
);