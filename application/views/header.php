<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">
	<head>
		<title><?php echo $page_title ?></title>
	
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="description" content="<?php echo $description;?>">
		<meta name="keywords" content="<?php echo $keywords;?>">
		<meta name="author" content="<?php echo $author;?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<link rel="shortcut icon" href="<?php echo $base_url;?>assets/icons/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo $base_url;?>assets/icons/favicon.ico" type="image/x-icon">

		<!-- Bootstrap CSS -->
		<link href="<?php echo $base_url;?>assets/bootstrap-4.0.0-beta.2-dist/css/bootstrap.min.css" rel="stylesheet">
	
		<!-- Font Awesome CSS -->
		<link href="<?php echo $base_url;?>assets/fontawesome-free-5.0.0/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
	
		<!-- Custom styles for this page -->
		<link href="<?php echo $base_url;?>assets/css/common.css" rel="stylesheet">
<?php if ($controller_name == "index") : ?>
		<link href="<?php echo $base_url;?>assets/css/index.css" rel="stylesheet">
<?php endif;?>
	</head>
	<body>
		<div class="container">
			<header class="navbar navbar-expand-lg navbar-light bg-light rounded">
				<a class="navbar-brand" href="<?php echo $base_url;?>">
					<i class="fab fa-btc fa-2x"></i>
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item<?php if ($controller_name == "index") : ?> active<?php endif?>">
							<a class="nav-link" href="/index"><?php echo lang('home_link');?></a>
						</li>
						<li class="nav-item<?php if ($controller_name == "join") : ?> active<?php endif?>">
							<a class="nav-link" href="/join"><?php echo lang('join_link');?></a>
						</li>
						<li class="nav-item<?php if ($controller_name == "profile") : ?> active<?php endif?>">
							<a class="nav-link" href="/profile"><?php echo lang('profile_link');?></a>
						</li>
						<li class="nav-item<?php if ($controller_name == "terms") : ?> active<?php endif?>">
							<a class="nav-link" href="/terms"><?php echo lang('terms_link')?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="mailto:support@bitcoinlottery2018.com"><?php echo lang('contacts_link');?></a>
						</li>
					</ul>
					<ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
						<li class="nav-item dropdown p-2">
							<a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="language-select" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo lang('language_select');?></a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="language-select">
								<a class="dropdown-item<?php if ($lang_uri == "en") : ?> active<?php endif?>" href="/<?php echo $lang_uri . $page_uri;?>">English</a>
							</div>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="http://twitter.com/btclottery2018" aria-label="Twitter" target="_blank"><i class="fab fa-twitter-square fa-2x"></i></a>
						</li>
					</ul>
				</div>
			</header>