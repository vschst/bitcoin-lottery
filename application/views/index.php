<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

			<main role="main">
				<div class="jumbotron">
					<h1 class="display-1"><?=lang('lottery_title')?></h1>
					<p class="lead display-5"><?=str_replace(array('{lottery_date}', '{prize_fund}'), array($lottery_date, $lottery_prize_fund), lang('lottery_description'));?></p>
					<div class="d-flex justify-content-center flex-wrap display-4">
						<div class="p-2">
							<span id="interval-days"><?=$interval_days?></span>
							<small class="text-muted"><?=lang('interval_days')?></small>
						</div>
						<div class="p-2">
							<span id="interval-hours"><?=$interval_hours?></span>
							<small class="text-muted"><?=lang('interval_hours')?></small>
						</div>
						<div class="p-2">
							<span id="interval-minutes"><?=$interval_minutes?></span>
							<small class="text-muted"><?=lang('interval_minutes')?></small>
						</div>
						<div class="p-2">
							<span id="interval-seconds"><?=$interval_seconds?></span>
							<small class="text-muted"><?=lang('interval_seconds')?></small>
						</div>
					</div>
					<p>
						<a href="<?=$base_url?>join" class="btn btn-lg btn-primary"><?=lang('join_now_btn')?></a>
					</p>
				</div>
				
				<h4><?=lang('new_participants')?></h4>
				<div class="table-responsive">
					<table class="table table-striped" id="last-participants" data-url="<?=$base_url?>index/ajax_get_last_participants">
						<thead>
							<tr>
								<th>#</th>
								<th><?=lang('btc_address')?></th>
								<th><?=lang('transaction_date')?></th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<td colspan="3" class="text-center bg-light<?php if ($participants_count > 0): ?> d-none<?php endif; ?>" id="no-participants"><?=lang('no_participants')?></td>
							</tr>
						</tfoot>
						<tbody>
<?php foreach ($last_participants as $key=>$row): ?>
							<tr>
								<td><?=($participants_count - $key)?></td>
								<td><?=$row['btc_address']?></td>
								<td><?=$row['rdate']?></td>
							</tr>
<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				
				<div class="container p-2 bg-light">
					<form id="check-btc-address" action="<?=$base_url?>index/ajax_check_btc_address">
						<?=$csrf;?>
						<div class="form-row">
							<div class="col-md-5">
								<input type="text" class="form-control" id="btc-address-to-check" placeholder="<?=lang('check_btc_address')?>">
							</div>
							<div class="col-md-1">
								<button class="btn btn-outline-success my-2 my-sm-0" type="submit" id="submit-btn"><i class="fas fa-circle-notch fa-spin d-none"></i> <?=lang('check_btc_address_btn')?></button>
							</div>
							<div class="col-md-auto p-2">
								<span class="d-none" id="btc-address-not-participate"><?=lang('btc_address_not_participate')?> <a href="<?=$base_url;?>join"><?=lang('join_btn')?></a></span>
								<span class="text-success d-none" id="btc-address-participate"><?=lang('btc_address_participate')?></span>
							</div>
						</div>
					</form>
				</div>
			</main>
			<script text="text/javascript">
				var interval_to_lottery_timestamp = <?=$interval_to_lottery_timestamp?>;
			</script>