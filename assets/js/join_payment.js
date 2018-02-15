$('[data-toggle="tooltip"]').tooltip();

$('#destination-btc-address-copy-btn').on('click', function () {
	$('#destination-btc-address').select();
	
	document.execCommand("copy");

	$(this).attr('title', copy_tooltip_title.copied).tooltip("_fixTitle").tooltip('show').attr("title", copy_tooltip_title.copy).tooltip("_fixTitle");
})

function update_payment_status() {
	$.ajax({
		url: "/join/ajax_get_payment_status",
		method: "GET",
	})
	.done(
		function(data) {
			var data_obj = $.parseJSON(data);

			if (data_obj && data_obj.hasOwnProperty('stage') && data_obj.hasOwnProperty('amount_pending') && data_obj.hasOwnProperty('amount_paid')) {
				if (data_obj.stage != 0) {
					$('#cancel-payment').addClass('d-none');
				}
				
				if (data_obj.stage == 2) {
					$('#stage-ready,#stage-pending').addClass('d-none');
					$('#stage-paid').removeClass('d-none');
				}
				else {
					if (data_obj.stage == 1) {
						$('#stage-ready').addClass('d-none');
						$('#stage-pending').removeClass('d-none');
						
						$('#amount-pending').text(data_obj.amount_pending);
						$('#amount-paid').text(data_obj.amount_paid);
					}
					
					setTimeout(update_payment_status, 1000);
				}
			}
		}
	)
}

update_payment_status();