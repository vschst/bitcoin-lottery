<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

			<main role="main">
				<div class="jumbotron p-4">
					<div class="container">
						<h2 class="text-left mb-4"><?=lang('main_caption')?></h2>
						<h5><?=lang('invoice_details')?></h5>
						<div class="container mb-4">
							<div class="row">
								<div class="col-md-8">
									<dl class="row">
										<dd class="col-sm-4"><?=lang('btc_address')?></dd>
										<dt class="col-sm-8 h6"><?=$invoice_btc_address?></dt>

										<dd class="col-sm-4"><?=lang('email')?></dd>
										<dt class="col-sm-8 h6"><?=$invoice_email?></dt>
									</dl>
								</div>
								<div class="col-md-4<?php if ($payment_stage != 0): ?>d-none<?php endif; ?>" id="cancel-payment">
									<a class="btn btn-danger btn-lg mt-2" href="<?=$base_url?>join/payment/cancel" role="button" onclick="return confirm('<?=lang('cancel_payment_confirm')?>')"><?=lang('cancel_payment_btn')?></a>
								</div>
							</div>
						</div>
						<p><?=str_replace('{payment_amount_text}', str_replace('{btc_amount}', $payment_amount, lang('btc_amount_text_light')), lang('send_btc_text'))?></p>
						<div class="container">
							<div class="row mb-4">
								<div class="col-lg-10">
									<div class="input-group">
										<input type="text" class="form-control" style="font-weight: bold; background-color: #F4F6F6;" id="destination-btc-address" value="<?=$destination_btc_address?>" readonly>
										<div class="input-group-append">
											<script type="text/javascript">
												var copy_tooltip_title = {
													copy: "<?=lang('copy_btn_tooltip')?>",
													copied: "<?=lang('copy_btn_copied')?>"
												}
											</script>
											<button class="btn btn-secondary" type="button" id="destination-btc-address-copy-btn" data-toggle="tooltip" data-placement="top" title="<?=lang('copy_btn_tooltip')?>"><?=lang('copy_btn')?></button>
											<button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#destination-address-qr-code-modal"><?=lang('qr_code_btn')?></button>
										</div>
									</div>
									<small class="text-muted"><?=lang('destination_btc_address_help')?></small>
								</div>
							</div>
							<div class="modal fade" id="destination-address-qr-code-modal" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title"><?=lang('qr_code_btn')?></h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<p class="text-center">
													<img src="<?=$blockchain_root?>qr?data=<?=$destination_btc_address?>&size=512" class="img-fluid">
												</p>
											</div>
										</div>
									</div>
							</div>
							<div id="payment-status" data-url="<?=$base_url?>join/ajax_get_payment_status">
							<div <?php if ($payment_stage != 0): ?>class="d-none"<?php endif; ?>id="stage-ready">
								<div class="d-flex flex-row">
									<div class="p-2"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>
									<div class="p-2"><h5><?=lang('payment_not_received')?></h5></div>
								</div>
							</div>
							<div <?php if ($payment_stage != 1): ?>class="d-none"<?php endif; ?>id="stage-pending">
								<div class="d-flex flex-row">
									<div class="p-2"><i class="fas fa-cog fa-spin fa-2x"></i></div>
									<div class="p-2"><h5><?=$stage_pending_text?></h5></div>
								</div>
							</div>
							<div <?php if ($payment_stage != 2): ?>class="d-none"<?php endif; ?>id="stage-paid">
								<div class="d-flex flex-row">
									<div class="p-2"><i class="fas fa-check fa-2x"></i></div>
									<div class="p-2"><?=str_replace('{profile_page_url}', $base_url . 'profile', lang('payment_received'))?></div>
								</div>
							</div>
							</div>
						</div>
					</div>
				</div>
			</main>
