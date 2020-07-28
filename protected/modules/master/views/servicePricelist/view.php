<?php
/* @var $this ServicePricelistController */
/* @var $model ServicePricelist */

$this->breadcrumbs=array(
	'Service',
	'Service Pricelists'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ServicePricelist', 'url'=>array('index')),
	array('label'=>'Create ServicePricelist', 'url'=>array('create')),
	array('label'=>'Update ServicePricelist', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ServicePricelist', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ServicePricelist', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
	<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/servicePricelist/admin';?>"><span class="fa fa-th-list"></span>Manage ServicePricelist</a>
				<?php if (Yii::app()->user->checkAccess("master.servicePricelist.update")) { ?>
		<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>					
				<?php } ?>
	
		<h1>View ServicePricelist #<?php echo $model->id; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
				array('name'=>'service_id','value'=>$model->service->name),
				array('name'=>'car_make_id','value'=>$model->carMake->name),
				array('name'=>'car_model_id','value'=>$model->carModel != "" ? $model->carModel->name : '-'),
				array('name'=>'car_model_id','value'=>$model->carSubDetail != "" ? $model->carSubDetail->name : '-'),
				'difficulty',
				'difficulty_value',
				'regular',
				'luxury',
				'luxury_value',
				'luxury_calc',
				'standard_flat_rate_per_hour',
				'flat_rate_hour',
				'price',
			),
		)); ?>
	</div>
</div>