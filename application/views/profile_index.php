<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

			<main role="main">
				<div class="jumbotron p-4">
					<div class="container">
						<h2 class="text-left mb-4"><?=lang('main_caption')?></h2>
						<h5><?=lang('participant_data')?></h5>
						<div class="container mb-4">
							<div class="row">
								<div class="col-md-8">
									<dl class="row">
										<dd class="col-sm-4"><?=lang('btc_address')?></dd>
										<dt class="col-sm-8 h6"><?=$btc_address?></dt>
										
										<dd class="col-sm-4"><?=lang('registration_date')?></dd>
										<dt class="col-sm-8 h6"><?=$registration_date?></dt>
									</dl>
								</div>
								<div class="col-md-4">
									<a class="btn btn-danger btn-lg mt-2" href="<?=$base_url?>profile/logout" role="button"><?=lang('logout_btn')?></a>
								</div>
							</div>
						</div>
						<h5><?=lang('invoice_payments')?></h5>
						<div class="container mb-4">
							<div class="table-responsive">
								<table class="table table-striped table-bordered">
									<thead class="bg-secondary text-white">
										<tr>
											<th>#</th>
											<th><?=lang('transaction_hash')?></th>
											<th><?=lang('transaction_value')?></th>
											<th><?=lang('transaction_date')?></th>
										</tr>
									</thead>
									<tbody>
<?php foreach ($invoice_payments as $key=>$row) : ?>
										<tr>
											<td><?=($key + 1)?></td>
											<td><a href="<?=$blockchain_root?>tx/<?=$row['transaction_hash']?>"><?=$row['transaction_hash']?></a></td>
											<td><?=str_replace('{btc_amount}', $row['value'], lang('btc_amount_text_bordered'))?></td>
											<td><?=$row['tdate']?></td>
										</tr>
<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
<?php if (!empty($participant_winnings)): ?>
						<h5><?=lang('participant_winnings')?></h5>
						<div class="container">
							<div class="table-responsive">
								<table class="table table-striped table-bordered">
									<thead class="bg-success text-white">
										<tr>
											<th>#</th>
											<th><?=lang('transaction_hash')?></th>
											<th><?=lang('transaction_value')?></th>
											<th><?=lang('lottery_date')?></th>
										</tr>
									</thead>
									<tbody>
<?php foreach ($participant_winnings as $key=>$row) : ?>
										<tr>
											<td><?=($key + 1)?></td>
											<td><a href="<?=$blockchain_root?>tx/<?=$row['transaction_hash']?>"><?=$row['transaction_hash']?></a></td>
											<td><?=str_replace('{btc_amount}', $row['value'], lang('btc_amount_text_bordered'))?></td>
											<td><?=$row['finish_date']?></td>
										</tr>
<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
<?php endif; ?>
					</div>
				</div>
			</main>