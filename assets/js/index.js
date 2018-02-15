var interval_to_lottery_timer;

$(document).ready(
	function() {
		interval_to_lottery_timer = setInterval(refresh_interval_to_lottery, 1000);
		
		setTimeout(refresh_last_participants, 30000);
	}
);

function refresh_interval_to_lottery() {
	interval_to_lottery_timestamp--;

	if (interval_to_lottery_timestamp <= 0) {
		clearInterval(interval_to_lottery_timer);
					
		$(location).attr('href', '/winners');
	}
	else {
		refresh_interval_to_lottery_elements();
	}
}

function refresh_interval_to_lottery_elements() {
	var seconds = Math.floor(interval_to_lottery_timestamp);
    var minutes = Math.floor(seconds / 60);
    var hours = Math.floor(minutes / 60);
    var days = Math.floor(hours / 24);

    hours %= 24;
    minutes %= 60;
    seconds %= 60;

    $("#interval-days").text(days);
    $("#interval-hours").text(hours);
    $("#interval-minutes").text(minutes);
    $("#interval-seconds").text(seconds);
}

function refresh_last_participants() {
	$.ajax({
		url: "/index/ajax_get_last_participants",
		method: "GET"
	})
	.done(
		function(data) {
			var data_obj = $.parseJSON(data);
		
			if (data_obj && data_obj.hasOwnProperty('participants_count') &&  data_obj.hasOwnProperty('last_participants') && Array.isArray(data_obj.last_participants)) {
				if (data_obj.participants_count > 0) {
					$('#no-participants').addClass('d-none');
				
					$('#last-participants').find('tbody').fadeOut(
						function() {
							$(this).empty();

							for (var i = 0; i < data_obj.last_participants.length; i++) {
								$(this).append(get_last_participants_row(data_obj.participants_count - i, data_obj.last_participants[i])).fadeIn();
							}
						}
					);
				}
			}

			setTimeout(refresh_last_participants, 30000);
		}
	);
}

function get_last_participants_row(row_num, row_data) {
	var row_element = $('<tr>');
	
	row_element.append($('<td>').text(row_num))
	row_element.append($('<td>').text(row_data.btc_address));
	row_element.append($('<td>').text(row_data.rdate));
	
	return row_element;
}

$("#btc-address-to-check").on('focus',
	function() {
		$('#btc-address-not-participate,#btc-address-participate').addClass("d-none");
	}
);

$("#check-btc-address-btn").on('click',
	function() {
		var btc_address_to_check = $.trim($("#btc-address-to-check").val());

		if (btc_address_to_check.length > 0) {
			$(this).find('i').removeClass("d-none");

			setTimeout(
				function(btc_address_to_check) {
					$.ajax({
						url: "/index/ajax_check_btc_address",
						method: "POST",
						data: {
							[csrf.name]: csrf.hash,
							'btc_address': btc_address_to_check
						}
					})
					.done(
						function(data) {
							var data_obj = $.parseJSON(data);
							
							if (data_obj && data_obj.hasOwnProperty('csrf') && data_obj.hasOwnProperty('check_status')) {
								csrf = data_obj.csrf;

								$("#check-btc-address-btn").find('i').addClass("d-none");
						
								if (data_obj.check_status) {
									$('#btc-address-participate').removeClass("d-none");
								}
								else {
									$('#btc-address-not-participate').removeClass("d-none");
								}
							}
						}
					);
				},
			1000, btc_address_to_check);
		}
	}
);