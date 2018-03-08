<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

			<main role="main">
				<div class="jumbotron p-4">
					<div class="container">
						<h2 class="text-left"><?=lang('main_caption')?></h2>
						<div class="container mt-4">
							<div class="alert alert-danger collapse" id="error-alert" role="alert"></div>
							<script text="text/javascript">
								var error_alerts = {};
<?php foreach (lang('error_alerts') as $key=>$value): ?>
								error_alerts['<?=$key?>'] = '<?=$value?>';
<?php endforeach; ?>
							</script>
							<form id="check-auth-data" action="<?=$base_url?>profile/ajax_check_auth_data">
								<?=$csrf;?>
								<div class="form-group row">
									<label for="btc-address" class="col-sm-2 col-form-label"><?=lang('btc_address')?></label>
									<div class="col-sm-6">
										<input type="text" class="form-control" id="btc-address" placeholder="1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN2">
									</div>
								</div>
								<div class="form-group row">
									<label for="email" class="col-sm-2 col-form-label"><?=lang('email')?></label>
									<div class="col-sm-6">
										<input type="email" class="form-control" id="email" placeholder="you@example.com">
									</div>
								</div>
								<div class="form-group row">
									<div class="offset-sm-2 col-sm-10">
										<button class="btn btn-primary" type="submit" id="submit-btn"><i class="fas fa-circle-notch fa-spin d-none"></i> <?=lang('login_btn')?></button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</main>