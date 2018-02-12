<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

			<main role="main">
				<div class="jumbotron p-4">
					<div class="container">
						<h2 class="text-left"><?php echo lang('main_caption');?></h2>
						<div class="container mt-4">
							<div class="alert alert-danger collapse" id="error-alert" role="alert"></div>
							<script text="text/javascript">
								var error_alerts = {};
<?php foreach (lang('error_alerts') as $key=>$value):?>
								error_alerts['<?php echo $key;?>'] = '<?php echo $value;?>';
<?php endforeach;?>
							</script>
							<form>
								<div class="form-group row">
									<label for="btc-address" class="col-sm-2 col-form-label"><?php echo lang('btc_address');?></label>
									<div class="col-sm-6">
										<input type="email" class="form-control" id="btc-address" placeholder="1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN2">
									</div>
								</div>
								<div class="form-group row">
									<label for="email" class="col-sm-2 col-form-label"><?php echo lang('email');?></label>
									<div class="col-sm-6">
										<input type="email" class="form-control" id="email" placeholder="you@example.com">
									</div>
								</div>
								<div class="form-group row">
									<div class="offset-sm-2 col-sm-10">
										<a href="#/" class="btn btn-primary" role="button" id="login-btn"><i class="fas fa-circle-notch fa-spin d-none"></i> <?php echo lang('login_btn');?></a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</main>