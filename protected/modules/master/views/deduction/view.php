<?php
/* @var $this IncentiveController */
/* @var $model Incentive */

$this->breadcrumbs=array(
	'Company',	
	'Deductions'=>array('admin'),
	'View Deduction '.$model->name,
);

$this->menu=array(
	array('label'=>'List Incentive', 'url'=>array('index')),
	array('label'=>'Create Incentive', 'url'=>array('create')),
	array('label'=>'Update Incentive', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Incentive', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Incentive', 'url'=>array('admin')),
);
?>
	

	
			<div id="maincontent">
				<?php $ccontroller = Yii::app()->controller->id; ?>
					<?php $ccaction = Yii::app()->controller->action->id; ?>
				<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/deduction/admin';?>"><span class="fa fa-th-list"></span>Manage Deductions</a>
				<?php if (Yii::app()->user->checkAccess("master.deduction.update")) { ?>
				<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>	
				<?php } ?>
					<div class="clearfix page-action">

					<h1>View Deduction <?php echo $model->name; ?></h1>

					<?php $this->widget('zii.widgets.CDetailView', array(
						'data'=>$model,
						'attributes'=>array(
							//'id',
							'name',
							'description',
							//'amount',
						),
					)); ?>

					</div>
				</div>
