var $ = jQuery;
var interval_to_lottery_timer;

$(document).ready(
	function() {
		interval_to_lottery_timer = setInterval(refresh_interval_to_lottery, 1000);
		
		setTimeout(refresh_last_participants, 30000, $('#last-participants').attr('data-url'));
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

function refresh_last_participants(ajax_url) {
	$.ajax({
		url: ajax_url,
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

			setTimeout(refresh_last_participants, 30000, ajax_url);
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

$('#check-btc-address').find("#btc-address").on('focus',
	function() {
		$(this).find('#btc-address-not-participate, #btc-address-participate').addClass("d-none");
	}
);

$("#check-btc-address").submit(
	function(event) {
		event.preventDefault();
	
		var btc_address = $.trim($(this).find("#btc-address").val());

		if (btc_address.length > 0) {
			$(this).find('#sumbit-btn').find('[data-fa-i2svg]').removeClass("d-none");

			setTimeout(
				function(form_url, btc_address) {
					$.ajax({
						url: form_url,
						method: "POST",
						data: {
							[csrf.name]: csrf.hash,
							'btc_address': btc_address
						}
					})
					.done(
						function(data) {
							var data_obj = $.parseJSON(data);
							
							if (data_obj && data_obj.hasOwnProperty('csrf') && data_obj.hasOwnProperty('check_status')) {
								csrf = data_obj.csrf;
								
								var form_element = $('#check-btc-address');
								form_element.find$('#submit-btn').find('[data-fa-i2svg]').addClass("d-none");
						
								if (data_obj.check_status) {
									form_element.find('#btc-address-participate').removeClass("d-none");
								}
								else {
									form_element.find('#btc-address-not-participate').removeClass("d-none");
								}
							}
						}
					);
				},
			1000, $(this).attr('action'), btc_address);
		}
	}
);