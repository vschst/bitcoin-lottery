<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

			<main role="main">
				<div class="jumbotron p-4">
					<div class="container">
						<h2 class="text-left mb-4"><?php echo lang('main_caption');?></h2>
						<h5><?php echo lang('participant_data');?></h5>
						<div class="container mb-4">
							<div class="row">
								<div class="col-md-8">
									<form>
										<div class="form-group row my-0">
											<label class="col-sm-4 col-form-label"><?php echo lang('btc_address');?></label>
											<div class="col-sm-6 pt-2">
												<p class="form-control-static h6"><?php echo $btc_address;?></p>
											</div>
										</div>
										<div class="form-group row my-0">
											<label class="col-sm-4 col-form-label"><?php echo lang('registration_date');?></label>
											<div class="col-sm-6 pt-2">
												<p class="form-control-static h6"><?php echo $registration_date;?></p>
											</div>
										</div>
									</form>
								</div>
								<div class="col-md-4">
									<a class="btn btn-danger btn-lg mt-2" href="/profile/logout" role="button"><?php echo lang('logout_btn');?></a>
								</div>
							</div>
						</div>
						<h5><?php echo lang('invoice_payments');?></h5>
						<div class="container mb-4">
							<div class="table-responsive">
								<table class="table table-striped table-bordered">
									<thead class="bg-secondary text-white">
										<tr>
											<th>#</th>
											<th><?php echo lang('transaction_hash');?></th>
											<th><?php echo lang('transaction_value');?></th>
											<th><?php echo lang('transaction_date');?></th>
										</tr>
									</thead>
									<tbody>
<?php foreach ($invoice_payments as $key=>$row) : ?>
										<tr>
											<td><?php echo ($key + 1);?></td>
											<td><a href="<?php echo $blockchain_root;?>tx/<?php echo $row['transaction_hash'];?>"><?php echo $row['transaction_hash'];?></a></td>
											<td><?php echo str_replace('{btc_amount}', $row['value'], lang('btc_amount_text_bordered'));?></td>
											<td><?php echo $row['tdate'];?></td>
										</tr>
<?php endforeach;?>
									</tbody>
								</table>
							</div>
						</div>
<?php if (!empty($participant_winnings)):?>
						<h5><?php echo lang('participant_winnings');?></h5>
						<div class="container">
							<div class="table-responsive">
								<table class="table table-striped table-bordered">
									<thead class="bg-success text-white">
										<tr>
											<th>#</th>
											<th><?php echo lang('transaction_hash');?></th>
											<th><?php echo lang('transaction_value');?></th>
											<th><?php echo lang('lottery_date');?></th>
										</tr>
									</thead>
									<tbody>
<?php foreach ($participant_winnings as $key=>$row) : ?>
										<tr>
											<td><?php echo ($key + 1);?></td>
											<td><a href="<?php echo $blockchain_root;?>tx/<?php echo $row['transaction_hash'];?>"><?php echo $row['transaction_hash'];?></a></td>
											<td><?php echo str_replace('{btc_amount}', $row['value'], lang('btc_amount_text_bordered'));?></td>
											<td><?php echo $row['finish_date'];?></td>
										</tr>
<?php endforeach;?>
									</tbody>
								</table>
							</div>
						</div>
<?php endif;?>
					</div>
				</div>
			</main>