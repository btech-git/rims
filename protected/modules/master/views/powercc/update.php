<?php
/* @var $this PowerccController */
/* @var $model Powercc */

$this->breadcrumbs=array(
	'Powerccs'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Powercc', 'url'=>array('index')),
	array('label'=>'Create Powercc', 'url'=>array('create')),
	array('label'=>'View Powercc', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Powercc', 'url'=>array('admin')),
);
?>
<div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="<?php echo Yii::app()->baseUrl.'/site/index';?>">Home</a>
				<a href="<?php echo Yii::app()->baseUrl.'/master/vehicle/admin';?>">Vehicle</a>
				<a href="<?php echo Yii::app()->baseUrl.'/master/powercc/admin';?>">Powercc</a>
			<span>Update Power cc</span>
		</div>
	</div>
</div>


		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>