<?php
/* @var $this ChasisCodeController */
/* @var $model ChasisCode */

$this->breadcrumbs=array(
	'Vehicle'=>Yii::app()->baseUrl.'/master/vehicle/admin',
	'Chassis Codes'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Update Chassis Code',
);
/*
$this->menu=array(
	array('label'=>'List ChasisCode', 'url'=>array('index')),
	array('label'=>'Create ChasisCode', 'url'=>array('create')),
	array('label'=>'View ChasisCode', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ChasisCode', 'url'=>array('admin')),
);
*/
?>
<!--<div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="<?php echo Yii::app()->baseUrl.'/site/index';?>">Home</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicle/admin';?>">Vehicle</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/chasisCode/admin';?>">Chassis Code</a>
			<span>Update Chassis Code</span>
		</div>
	</div>
</div>-->


		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>