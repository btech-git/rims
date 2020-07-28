<?php
/* @var $this ColorsController */
/* @var $model Colors */

$this->breadcrumbs=array(
	'Vehicle'=>Yii::app()->baseUrl.'/master/vehicle/admin',
	'Colors'=>array('admin'),
	'View Color '.$model->name,
);

$this->menu=array(
	array('label'=>'List Colors', 'url'=>array('index')),
	array('label'=>'Create Colors', 'url'=>array('create')),
	array('label'=>'Update Colors', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Colors', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Colors', 'url'=>array('admin')),
);
?>
<!--<div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="<?php echo Yii::app()->baseUrl.'/site/index';?>">Home</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicle/admin';?>">Vehicle</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/colors/admin';?>">Colors</a>
			<span>View Color</span>
		</div>
	</div>
</div>-->


		<div id="maincontent">
			<div class="clearfix page-action">
			<?php $ccontroller = Yii::app()->controller->id; ?>
				<?php $ccaction = Yii::app()->controller->action->id; ?>
			<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/colors/admin';?>"><span class="fa fa-th-list"></span>Manage Colors</a>
				<?php if (Yii::app()->user->checkAccess("master.colors.update")) { ?>
			<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>		
				<?php } ?>
			<h1>View Color <?php echo $model->name; ?></h1>

			<?php $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
					//'id',
					'name',
					'status',
				),
			)); ?>
			</div>
		</div>