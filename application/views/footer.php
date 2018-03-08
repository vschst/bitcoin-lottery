<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

			<footer class="footer">
				<div class="d-flex justify-content-between flex-wrap">
					<div>
						&copy; <?=lang('footer_title')?>
					</div>
					<div>
						<?=$btc_stock_price_title?>
					</div>
				</div>
			</footer>
		</div>

		<!-- Optional JavaScript -->
		<!-- Import JS libraries (jQuery, Popper.js, Bootstrap JS) -->
		<script src="<?=$base_url?>assets/js/bundle.js"></script>
		
		<!-- Custom JS for this page -->
<?php if ($controller_name == "index"): ?>
		<script type="text/javascript" src="<?=$base_url?>assets/js/index.js"></script>
<?php elseif (($controller_name == "join") AND ($function_name == "index")): ?>
		<script type="text/javascript" src="<?=$base_url?>assets/js/join_index.js"></script>
<?php elseif (($controller_name == "join") AND ($function_name == "payment")): ?>
		<script type="text/javascript" src="<?=$base_url?>assets/js/join_payment.js"></script>
<?php elseif (($controller_name == "profile") AND ($function_name == "login")): ?>
		<script type="text/javascript" src="<?=$base_url?>assets/js/profile_login.js"></script>
<?php endif; ?>
	</body>
</html>