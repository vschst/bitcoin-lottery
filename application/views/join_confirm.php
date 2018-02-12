<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

			<main role="main">
				<div class="jumbotron p-4">
					<div class="container">
						<h2 class="text-left"><?php echo lang('main_caption');?></h2>
						<p><?php echo lang('confirmation_description');?></p>
					
						<div class="container">
							<div class="alert alert-danger<?php if (empty($error_alert)):?> collapse<?php endif;?>" id="error-alert" role="alert"><?php if (!empty($error_alert)) echo $error_alert;?></div>
							<form>
								<div class="form-group row">
									<label for="btc-address" class="col-sm-2 col-form-label"><?php echo lang('btc_address');?></label>
									<div class="col-sm-6">
										<p class="form-control-plaintext"><b><?php echo $btc_address;?></b></p>
									</div>
								</div>
								<div class="form-group row">
									<label for="email" class="col-sm-2 col-form-label"><?php echo lang('email');?></label>
									<div class="col-sm-6">
										<p class="form-control-plaintext"><b><?php echo $email;?></b></p>
									</div>
								</div>
								<div class="form-group row">
									<label for="email" class="col-sm-2 col-form-label"><?php echo lang('payment_amount');?></label>
									<div class="col-sm-6">
										<p class="form-control-plaintext"><b><?php echo str_replace('{btc_amount}', $fee_amount, lang('btc_amount_text_light'));?></b></p>
									</div>
								</div>

								<div class="form-group row">
									<div class="offset-sm-2 col-sm-10">
										<a href="/join/confirm/back" class="btn btn-primary" role="button"><?php echo lang('back_btn');?></a>
										<a href="/join/invoice" class="btn btn-success" role="button"><?php echo lang('continue_btn');?></a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</main>