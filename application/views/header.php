<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">
	<head>
		<title><?=$page_title?></title>
	
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="description" content="<?=$description?>">
		<meta name="keywords" content="<?=$keywords?>">
		<meta name="author" content="<?=$author?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<link rel="shortcut icon" href="<?=$base_url?>assets/icons/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?=$base_url?>assets/icons/favicon.ico" type="image/x-icon">

		<!-- Custom CSS (Bootstrap and etc.) -->
		<link href="<?=$base_url?>assets/css/custom.css" rel="stylesheet">
	
		<!-- Font Awesome -->
		<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	
		<!-- Custom styles for this page -->
		<link href="<?=$base_url?>assets/css/common.css" rel="stylesheet">
<?php if ($controller_name == "index") : ?>
		<link href="<?=$base_url?>assets/css/index.css" rel="stylesheet">
<?php endif;?>
	</head>
	<body>
		<div class="container">
			<header class="navbar navbar-expand-lg navbar-light bg-light rounded">
				<a class="navbar-brand" href="<?=$base_url?>">
					<i class="fab fa-btc fa-2x"></i>
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item<?php if ($controller_name == "index"): ?> active<?php endif; ?>">
							<a class="nav-link" href="<?=$base_url?>index"><?=lang('home_link')?></a>
						</li>
						<li class="nav-item<?php if ($controller_name == "join"): ?> active<?php endif; ?>">
							<a class="nav-link" href="<?=$base_url?>join"><?=lang('join_link')?></a>
						</li>
						<li class="nav-item<?php if ($controller_name == "profile"): ?> active<?php endif; ?>">
							<a class="nav-link" href="<?=$base_url?>profile"><?=lang('profile_link')?></a>
						</li>
						<li class="nav-item<?php if ($controller_name == "terms"): ?> active<?php endif; ?>">
							<a class="nav-link" href="<?=$base_url?>terms"><?=lang('terms_link')?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="mailto:support@bitcoinlottery2018.com"><?=lang('contacts_link');?></a>
						</li>
					</ul>
					<ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
						<li class="nav-item dropdown p-2">
							<a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="language-select" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=lang('language_select')?></a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="language-select">
								<a class="dropdown-item<?php if ($lang_uri == "en"): ?> active<?php endif; ?>" href="<?=$base_url . $lang_uri . $page_uri?>">English</a>
							</div>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="http://twitter.com/btclottery2018" aria-label="Twitter" target="_blank"><i class="fab fa-twitter-square fa-2x"></i></a>
						</li>
					</ul>
				</div>
			</header>