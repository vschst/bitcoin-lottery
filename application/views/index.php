<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

			<main role="main">
				<div class="jumbotron">
					<h1 class="display-1"><?php echo lang('lottery_title');?></h1>
					<p class="lead display-5"><?php echo str_replace(array('{lottery_date}', '{prize_fund}'), array($lottery_date, $lottery_prize_fund), lang('lottery_description'));?></p>
					<div class="d-flex justify-content-center flex-wrap display-4">
						<div class="p-2">
							<span id="interval-days"><?php echo $interval_days;?></span>
							<small class="text-muted"><?php echo lang('interval_days');?></small>
						</div>
						<div class="p-2">
							<span id="interval-hours"><?php echo $interval_hours;?></span>
							<small class="text-muted"><?php echo lang('interval_hours');?></small>
						</div>
						<div class="p-2">
							<span id="interval-minutes"><?php echo $interval_minutes;?></span>
							<small class="text-muted"><?php echo lang('interval_minutes');?></small>
						</div>
						<div class="p-2">
							<span id="interval-seconds"><?php echo $interval_seconds;?></span>
							<small class="text-muted"><?php echo lang('interval_seconds');?></small>
						</div>
					</div>
					<p>
						<a href="/join" class="btn btn-lg btn-primary"><?php echo lang('join_now_btn');?></a>
					</p>
				</div>
				
				<h4><?php echo lang('new_participants');?></h4>
				<div class="table-responsive">
					<table class="table table-striped" id="last-participants">
						<thead>
							<tr>
								<th>#</th>
								<th><?php echo lang('btc_address');?></th>
								<th><?php echo lang('transaction_date');?></th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<td colspan="3" class="text-center bg-light<?php if ($participants_count > 0) : ?> d-none<?php endif;?>" id="no-participants"><?php echo lang('no_participants');?></td>
							</tr>
						</tfoot>
						<tbody>
<?php foreach ($last_participants as $key=>$row) : ?>
							<tr>
								<td><?php echo $participants_count - $key;?></td>
								<td><?php echo $row['btc_address'];?></td>
								<td><?php echo $row['rdate'];?></td>
							</tr>
<?php endforeach;?>
						</tbody>
					</table>
				</div>
				
				<div class="container p-2 bg-light">
					<form>
						<div class="form-row">
							<div class="col-md-5">
								<input type="email" class="form-control" id="btc-address-to-check" placeholder="<?php echo lang('check_btc_address');?>">
							</div>
							<div class="col-md-1">
								<a href="#/" class="btn btn-outline-success my-2 my-sm-0" role="button" id="check-btc-address-btn"><i class="fas fa-circle-notch fa-spin d-none"></i> <?php echo lang('check_btc_address_btn');?></a>
							</div>
							<div class="col-md-auto p-2">
								<span class="d-none" id="btc-address-not-participate"><?php echo lang('btc_address_not_participate');?> <a href="/join"><?php echo lang('join_btn');?></a></span>
								<span class="text-success d-none" id="btc-address-participate"><?php echo lang('btc_address_participate');?></span>
							</div>
						</div>
					</form>
				</div>
			</main>
			<script text="text/javascript">
				var interval_to_lottery_timestamp = <?php echo $interval_to_lottery_timestamp;?>;
			</script>