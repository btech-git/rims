<?php
/* @var $this CustomerPicController */
/* @var $model CustomerPic */

$this->breadcrumbs=array(
	'Customer Pics'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CustomerPic', 'url'=>array('index')),
	array('label'=>'Manage CustomerPic', 'url'=>array('admin')),
);
?>
<div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="#">Home</a>
			<a href="#">Company</a>
			<a href="#">Customer Pic</a>
			<span>New Customer Pic</span>
		</div>
	</div>
</div>


		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
	</div>
</div>