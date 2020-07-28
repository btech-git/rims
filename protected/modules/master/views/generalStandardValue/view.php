<?php
/* @var $this GeneralStandardValueController */
/* @var $model GeneralStandardValue */

$this->breadcrumbs=array(
	'General Standard Values'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GeneralStandardValue', 'url'=>array('index')),
	array('label'=>'Create GeneralStandardValue', 'url'=>array('create')),
	array('label'=>'Update GeneralStandardValue', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GeneralStandardValue', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GeneralStandardValue', 'url'=>array('admin')),
);
?>



		<div id="maincontent">
			<div class="clearfix page-action">
			<?php $ccontroller = Yii::app()->controller->id; ?>
				<?php $ccaction = Yii::app()->controller->action->id; ?>
			<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/generalStandardValue/admin';?>"><span class="fa fa-th-list"></span>Manage Standard Value</a>
				<?php if (Yii::app()->user->checkAccess("master.generalStandardValue.update")) { ?>
			<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>		
				<?php } ?>
			<h1>View Standard Value <?php echo $model->id; ?></h1>

			<?php $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
					//'id',
					'difficulty',
					'difficulty_value',
					'regular',
					'luxury',
					'luxury_value',
					'luxury_calc',
					'flat_rate_hour',
				),
			)); ?>
			</div>
		</div>
