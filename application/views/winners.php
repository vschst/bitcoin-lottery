<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

			<main role="main">
				<div class="jumbotron">
					<h1><?=lang('statistics_caption')?></h1>
					<div class="container display-5 mb-5">
						<div class="row mb-2">
							<div class="col-sm-6"><?=lang('participants_count')?></div>
							<div class="col-sm-6"><b><?=echo $participants_count?></b></div>
						</div>
						<div class="row mb-2">
							<div class="col-sm-6"><?=lang('entrance_fees')?></div>
							<div class="col-sm-6"><span class="badge badge-primary"><?=str_replace('{btc_amount}', $entrance_fees_amount, lang('btc_amount_text'))?></span></div>
						</div>
						<div class="row mb-2">
							<div class="col-sm-6"><?php echo lang('organizational_fee')?></div>
							<div class="col-sm-6"><span class="badge badge-secondary"><?=str_replace('{btc_amount}', $organizational_fee_amount, lang('btc_amount_text'))?></span></div>
						</div>
						<div class="row">
							<div class="col-sm-6"><?php echo lang('prize_fund')?></div>
							<div class="col-sm-6"><span class="badge badge-success"><?=str_replace('{btc_amount}', $prize_fund_amount, lang('btc_amount_text'))?></span></div>
						</div>
					</div>
					<h1><?=lang('winners_caption')?></h1>
					<div class="container">
						<div class="table-responsive">
							<table class="table table-striped table-bordered">
								<thead class="bg-secondary text-white">
									<tr>
										<th>#</th>
										<th><?=lang('btc_address')?></th>
										<th><?=lang('transaction_hash')?></th>
										<th><?=lang('transaction_value')?></th>
									</tr>
								</thead>
								<tbody>
<?php foreach ($lottery_winners as $key=>$row): ?>
									<tr>
										<td><?=($key + 1)?></td>
										<td><b><?=$row['btc_address']?></b></td>
										<td><a href="<?=$blockchain_root?>tx/<?=$row['transaction_hash']?>"><?=$row['transaction_hash']?></td>
										<td><?=str_replace('{btc_amount}', $row['value'], lang('btc_amount_text_bordered'))?></td>
									</tr>
<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</main>