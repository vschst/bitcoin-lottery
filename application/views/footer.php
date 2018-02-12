<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

			<footer class="footer">
				<div class="d-flex justify-content-between flex-wrap">
					<div>
						&copy; <?php echo lang('footer_title');?>
					</div>
					<div>
						<?php echo $btc_stock_price_title;?>
					</div>
				</div>
			</footer>
		</div>

		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="<?php echo $base_url;?>assets/js/jquery-3.2.1.min.js"></script>
		<script src="<?php echo $base_url;?>assets/popper.js-1.12.9/dist/umd/popper.min.js"></script>
		<script src="<?php echo $base_url;?>assets/bootstrap-4.0.0-beta.2-dist/js/bootstrap.min.js"></script>
		
		<!-- Custom JS for this page -->
<?php if ($controller_name == "index"): ?>
		<script type="text/javascript" src="<?php echo $base_url;?>assets/js/index.js"></script>
<?php elseif (($controller_name == "join") AND ($function_name == "index")):?>
		<script type="text/javascript" src="<?php echo $base_url;?>assets/js/join_index.js"></script>
<?php elseif (($controller_name == "join") AND ($function_name == "payment")):?>
		<script type="text/javascript" src="<?php echo $base_url;?>assets/js/join_payment.js"></script>
<?php elseif (($controller_name == "profile") AND ($function_name == "login")):?>
		<script type="text/javascript" src="<?php echo $base_url;?>assets/js/profile_login.js"></script>
<?php endif;?>
	</body>
</html>