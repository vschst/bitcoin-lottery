<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

			<main role="main">
				<div class="jumbotron p-4">
					<div class="container">
						<h2 class="text-left"><?php echo lang('main_caption');?></h2>
<?php if ($join_available):?>
						<p><?php echo str_replace('{fee_amount}', $fee_amount, lang('payment_of_fee_text'));?>
						<div class="container">
							<div class="alert alert-danger<?php if (empty($error_alert)):?> collapse<?php endif;?>" id="error-alert" role="alert"><?php if (!empty($error_alert)) echo $error_alert;?></div>
							<script text="text/javascript">
								var error_alerts = {};
<?php foreach (lang('error_alerts') as $key=>$value):?>
								error_alerts['<?php echo $key;?>'] = '<?php echo $value;?>';
<?php endforeach;?>
							</script>
							<form>
								<script text="text/javascript">
									var csrf = {name: '<?=$csrf['name'];?>', hash: '<?=$csrf['hash'];?>'};
								</script>
								<div class="form-group row">
									<label for="btc-address" class="col-sm-2 col-form-label"><?php echo lang('btc_address');?></label>
									<div class="col-sm-6">
										<input type="email" class="form-control" id="btc-address" placeholder="1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN2" value="<?php echo $btc_address;?>">
										<small class="form-text text-muted"><?php echo lang('btc_address_help');?></small>
									</div>
								</div>
								<div class="form-group row">
									<label for="email" class="col-sm-2 col-form-label"><?php echo lang('email');?></label>
									<div class="col-sm-6">
										<input type="email" class="form-control" id="email" placeholder="you@example.com" value="<?php echo $email;?>">
										<small class="form-text text-muted"><?php echo lang('email_help');?></small>
									</div>
								</div>
								<div class="form-group row">
									<div class="offset-sm-2 col-sm-10">
										<div class="form-check">
											<label class="form-check-label">
												<input class="form-check-input" type="checkbox" id="confirmation-of-terms"> <?php echo lang('confirmation_of_terms');?>
											</label>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="offset-sm-2 col-sm-10">
										<a href="#/" class="btn btn-primary" role="button" id="check-participant-data-btn"><i class="fas fa-circle-notch fa-spin d-none"></i> <?php echo lang('next_btn');?></a>
									</div>
								</div>
							</form>
						</div>
<?php else:?>
					<p><?php echo lang('join_is_not_available');?></p>
<?php endif;?>
					</div>
				</div>
			</main>