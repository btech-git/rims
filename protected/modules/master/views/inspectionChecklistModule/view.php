<?php
/* @var $this InspectionChecklistModuleController */
/* @var $model InspectionChecklistModule */

$this->breadcrumbs=array(
	'Service',
	'Inspection Checklist Modules'=>array('admin'),
	'View Inspection Checklist Module '. $model->name,$model->name,
);

/*$this->menu=array(
	array('label'=>'List InspectionChecklistModule', 'url'=>array('index')),
	array('label'=>'Create InspectionChecklistModule', 'url'=>array('create')),
	array('label'=>'Update InspectionChecklistModule', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete InspectionChecklistModule', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage InspectionChecklistModule', 'url'=>array('admin')),
);*/
?>




		<div id="maincontent">
			<div class="clearfix page-action">
				<?php $ccontroller = Yii::app()->controller->id; ?>
				<?php $ccaction = Yii::app()->controller->action->id; ?>
				<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/inspectionChecklistModule/admin';?>"><span class="fa fa-th-list"></span>Manage Inspection Checklist Module</a>
				<?php if (Yii::app()->user->checkAccess("master.inspectionChecklistModule.update")) { ?>
				<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
				<?php } ?>
				<h1>View <?php echo $model->name ?></h1>

				<?php $this->widget('zii.widgets.CDetailView', array(
					'data'=>$model,
					'attributes'=>array(
						//'id',
						'code',
						'name',
						'type',
					),
				)); ?>
			</div>
		</div>