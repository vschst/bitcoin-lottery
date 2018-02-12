<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

			<main role="main">
				<div class="jumbotron p-4">
					<div class="container">
						<h2 class="text-center"><?php echo lang('main_caption');?></h2>
						<div class="container">
							<ul class="nav justify-content-center bg-white my-4">
								<li class="nav-item">
									<a class="nav-link" href="#<?php echo lang('definitions')['id']?>"><?php echo lang('definitions')['title']?></a>
								</li>
<?php foreach (lang('sections') as $item):?>
								<li class="nav-item">
									<a class="nav-link" href="#<?php echo $item['id'];?>"><?php echo $item['title']?></a>
								</li>
<?php endforeach;?>
							</ul>
<?php foreach (lang('introduction_paragraphs') as $item):?>
							<p><?php echo $item;?></p>
<?php endforeach;?>
							
							<h4><a href="#<?php echo lang('definitions')['id']?>"><?php echo lang('definitions')['title']?></a></h4>
							<div class="container mb-5" id="<?php echo lang('definitions')['id']?>">
<?php foreach (lang('definitions')['content'] as $item):?>
								<p><em>«<?php echo $item['name'];?>»</em></p>
								<p><?php echo $item['text'];?></p>
<?php endforeach;?>
							</div>
<?php foreach (lang('sections') as $key=>$item):?>
							<h3><a href="#<?php echo $item['id'];?>"><?php echo ($key + 1) . ". " . $item['title']?></a></h3>
							<div class="container mb-5" id="<?php echo $item['id'];?>">
<?php foreach ($item['content'] as $kkey=>$iitem):?>
								<p><b><?php echo ($key + 1) . "." . ($kkey + 1);?></b> <?php if (is_array($iitem)): echo $iitem['beginning'];?></p>
									<ul>
<?php foreach ($iitem['content'] as $kkkey=>$iiitem):?>
										<li><p><?php echo lang('list_item_words')[$kkkey];?>) <?php echo $iiitem;?></p></li>
<?php endforeach;?>
									</ul>
<?php else: echo $iitem;?></p>
<?php endif;?>
<?php endforeach;?>
							</div>
<?php endforeach;?>
							<p><?php echo lang('last_updated');?></p>
						</div>
					</div>
				</div>
			</main>