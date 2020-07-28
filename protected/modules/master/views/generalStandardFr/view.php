<?php
/* @var $this GeneralStandardFrController */
/* @var $model GeneralStandardFr */

$this->breadcrumbs=array(
	'General Standard Frs'=>array('admin'),
	$model->id,
);

$this->menu=array(
	// array('label'=>'List GeneralStandardFr', 'url'=>array('index')),
	// array('label'=>'Create GeneralStandardFr', 'url'=>array('create')),
	// array('label'=>'Update GeneralStandardFr', 'url'=>array('update', 'id'=>$model->id)),
	// array('label'=>'Delete GeneralStandardFr', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	// array('label'=>'Manage GeneralStandardFr', 'url'=>array('admin')),
);
?>



		<div id="maincontent">
			<div class="clearfix page-action">
			<?php $ccontroller = Yii::app()->controller->id; ?>
				<?php $ccaction = Yii::app()->controller->action->id; ?>
			<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/generalStandardFr/admin';?>"><span class="fa fa-th-list"></span>Manage Standard Flat Rate</a>
				<?php if (Yii::app()->user->checkAccess("master.generalStandardFr.update")) { ?>
			<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>	
				<?php } ?>
			<h1>View Standard Flat Rate <?php echo $model->id; ?></h1>

				<?php $this->widget('zii.widgets.CDetailView', array(
					'data'=>$model,
					'attributes'=>array(
						//'id',
						'flat_rate',
					),
				)); ?>

				</div>
		</div>