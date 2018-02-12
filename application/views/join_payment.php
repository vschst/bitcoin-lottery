<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

			<main role="main">
				<div class="jumbotron p-4">
					<div class="container">
						<h2 class="text-left mb-4"><?php echo lang('main_caption');?></h2>
						<h5><?php echo lang('invoice_details');?></h5>
						<div class="container mb-4">
							<div class="row">
								<div class="col-md-8">
									<form>
										<div class="form-group row my-0">
											<label for="btc-address" class="col-sm-4 col-form-label"><?php echo lang('btc_address');?></label>
											<div class="col-sm-6 pt-2">
												<p class="form-control-static h6"><?php echo $invoice_btc_address;?></p>
											</div>
										</div>
										<div class="form-group row my-0">
											<label for="email" class="col-sm-4 col-form-label"><?php echo lang('email');?></label>
											<div class="col-sm-6 pt-2">
												<p class="form-control-static h6"><?php echo $invoice_email;?></p>
											</div>
										</div>
									</form>
								</div>
								<div class="col-md-4<?php if ($payment_stage != 0):?>d-none<?php endif;?>" id="cancel-payment">
									<a class="btn btn-danger btn-lg mt-2" href="/join/payment/cancel" role="button" onclick="return confirm('<?php echo lang('cancel_payment_confirm');?>')"><?php echo lang('cancel_payment_btn');?></a>
								</div>
							</div>
						</div>
						<p><?php echo str_replace('{payment_amount}', $payment_amount, lang('send_btc_text'))?></p>
						<div class="container">
							<div class="row mb-4">
								<div class="col-lg-10">
									<div class="input-group">
										<input type="text" class="form-control" style="font-weight: bold; background-color: #F4F6F6;" id="destination-btc-address" value="<?php echo $destination_btc_address;?>" readonly>
										<span class="input-group-btn">
											<script type="text/javascript">
												var copy_tooltip_title = {
													copy: "<?php echo lang('copy_btn_tooltip');?>",
													copied: "<?php echo lang('copy_btn_copied');?>"
												}
											</script>
											<button type="button" class="btn btn-secondary" id="destination-btc-address-copy-btn" data-toggle="tooltip" data-placement="top" title="<?php echo lang('copy_btn_tooltip');?>"><?php echo lang('copy_btn');?></button>
										</span>
										<span class="input-group-btn">
											<button class="btn btn-info" type="button" data-toggle="modal" data-target="#destination-address-qr-code-modal"><?php echo lang('qr_code_btn');?></button>
										</span>
									</div>
									<small class="text-muted"><?php echo lang('destination_btc_address_help');?></small>
								</div>
							</div>
							<div class="modal fade" id="destination-address-qr-code-modal" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title"><?php echo lang('destination_btc_address_qr_code_btn');?></h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<p class="text-center">
													<img src="<?php echo $blockchain_root;?>qr?data=<?php echo $destination_btc_address;?>&size=512" class="img-fluid">
												</p>
											</div>
										</div>
									</div>
							</div>
							<div <?php if ($payment_stage != 0):?>class="d-none"<?php endif;?>id="stage-ready">
								<div class="d-flex flex-row">
									<div class="p-2"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>
									<div class="p-2"><h5><?php echo lang('payment_not_received');?></h5></div>
								</div>
							</div>
							<div <?php if ($payment_stage != 1):?>class="d-none"<?php endif;?>id="stage-pending">
								<div class="d-flex flex-row">
									<div class="p-2"><i class="fas fa-cog fa-spin fa-2x"></i></div>
									<div class="p-2"><h5><?php echo $stage_pending_text?></h5></div>
								</div>
							</div>
							<div <?php if ($payment_stage != 2):?>class="d-none"<?php endif;?>id="stage-paid">
								<div class="d-flex flex-row">
									<div class="p-2"><i class="fas fa-check fa-2x"></i></div>
									<div class="p-2"><?php echo lang('payment_received');?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
