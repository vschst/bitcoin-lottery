<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

			<main role="main">
				<div class="jumbotron p-4">
					<div class="container">
						<h2 class="text-left"><?=lang('main_caption')?></h2>
<?php if ($join_available):?>
						<p><?=str_replace('{fee_amount_text}', str_replace('{btc_amount}', $fee_amount, lang('btc_amount_text_light')), lang('payment_of_fee_text'))?>
						<div class="container">
							<div class="alert alert-danger<?php if (empty($error_alert)): ?> collapse<?php endif; ?>" id="error-alert" role="alert"><?php if (!empty($error_alert)) echo $error_alert;?></div>
							<script text="text/javascript">
								var error_alerts = {};
<?php foreach (lang('error_alerts') as $key=>$value): ?>
								error_alerts['<?=$key?>'] = '<?=$value?>';
<?php endforeach; ?>
							</script>
							<form id="check-participant-data" action="<?=$base_url?>join/ajax_check_participant_data">
								<?=$csrf;?>
								<div class="form-group row">
									<label for="btc-address" class="col-sm-2 col-form-label"><?=lang('btc_address')?></label>
									<div class="col-sm-6">
										<input type="text" class="form-control" id="btc-address" placeholder="1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN2" value="<?=$btc_address?>">
										<small class="form-text text-muted"><?=lang('btc_address_help')?></small>
									</div>
								</div>
								<div class="form-group row">
									<label for="email" class="col-sm-2 col-form-label"><?=lang('email')?></label>
									<div class="col-sm-6">
										<input type="email" class="form-control" id="email" placeholder="you@example.com" value="<?=$email?>">
										<small class="form-text text-muted"><?=lang('email_help')?></small>
									</div>
								</div>
								<div class="form-group row">
									<div class="offset-sm-2 col-sm-10">
										<div class="form-check">
											<label class="form-check-label">
												<input class="form-check-input" type="checkbox" id="confirmation-of-terms"> <?=lang('confirmation_of_terms')?>
											</label>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="offset-sm-2 col-sm-10">
										<button class="btn btn-primary" type="submit" id="submit-btn"><i class="fas fa-circle-notch fa-spin d-none"></i> <?=lang('next_btn')?></button>
									</div>
								</div>
							</form>
						</div>
<?php else: ?>
					<p><?=lang('join_is_not_available')?></p>
<?php endif; ?>
					</div>
				</div>
			</main>