<?php
/* @var $this InspectionChecklistTypeController */
/* @var $model InspectionChecklistType */

$this->breadcrumbs=array(
	'Service',
	'Inspection Checklist Types'=>array('admin'),
	'View Inspection Checklist Type '. $model->name,$model->name,
);

/*$this->menu=array(
	array('label'=>'List InspectionChecklistType', 'url'=>array('index')),
	array('label'=>'Create InspectionChecklistType', 'url'=>array('create')),
	array('label'=>'Update InspectionChecklistType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete InspectionChecklistType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage InspectionChecklistType', 'url'=>array('admin')),
);*/
?>
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/inspectionChecklistType/admin';?>"><span class="fa fa-th-list"></span>Manage Inspection Checklist Type</a>
				<?php if (Yii::app()->user->checkAccess("master.inspectionChecklistType.update")) { ?>
		<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
				<?php } ?>
		<h1>View <?php echo $model->name ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				//'id',
				'code',
				'name',
			),
		)); ?>
	</div>
</div>