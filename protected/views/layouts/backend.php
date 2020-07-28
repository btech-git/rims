<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
	<div id="content">
	<div id="maincontent">
		<div class="row">
			<div class="small-2 columns">
				<?php include 'navsettings.php';?>
			</div>
			<div class="small-10 columns">	
				<?php echo $content;?>
			</div>
		</div>
	</div>
	</div>
<?php $this->endContent(); ?>