<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

			<main role="main">
				<div class="jumbotron p-4">
					<div class="container">
						<h2 class="text-left"><?=lang('main_caption')?></h2>
						<p><?=lang('confirmation_description')?></p>
					
						<div class="container">
							<div class="alert alert-danger<?php if (empty($error_alert)): ?> collapse<?php endif; ?>" id="error-alert" role="alert"><?php if (!empty($error_alert)) echo $error_alert;?></div>
							<dl class="row">
								<dd class="col-sm-3"><?=lang('btc_address')?></dd>
								<dt class="col-sm-9"><?=$btc_address?></dt>
							</dl>
							<dl class="row">
								<dd class="col-sm-3"><?=lang('email')?></dd>
								<dt class="col-sm-9"><?=$email?></dt>
							</dl>
							<dl class="row">
								<dd class="col-sm-3"><?=lang('payment_amount')?></dd>
								<dt class="col-sm-9"><?=str_replace('{btc_amount}', $fee_amount, lang('btc_amount_text_light'))?></dt>
							</dl>

							<div class="row">
								<div class="offset-sm-3 col-sm-9">
									<a href="<?=$base_url?>join/confirm/back" class="btn btn-primary" role="button"><?=lang('back_btn')?></a>
									<a href="<?=$base_url?>join/invoice" class="btn btn-success" role="button"><?=lang('continue_btn')?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>