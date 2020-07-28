<?php
/* @var $this CoaCategoryController */
/* @var $model CoaCategory */

$this->breadcrumbs=array(
	'Coa Categories'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CoaCategory', 'url'=>array('index')),
	array('label'=>'Create CoaCategory', 'url'=>array('create')),
	array('label'=>'Update CoaCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CoaCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CoaCategory', 'url'=>array('admin')),
);
?>

<!--<h1>View CoaCategory #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->baseUrl.'/master/coaCategory/admin';?>"><span class="fa fa-th-list"></span>Manage CoaCategory</a>
		<?php if (Yii::app()->user->checkAccess("master.coaCategory.update")) { ?>
		<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
		<?php } ?>
		<h1>View CoaCategory #<?php echo $model->id; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
				'name',
				'code',
				'coa_category_id',
			),
		)); ?>
	</div>
</div>