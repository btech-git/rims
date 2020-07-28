<?php
/* @var $this LevelController */
/* @var $model Level */

$this->breadcrumbs=array(
	'Company',
	'Levels'=>array('admin'),
	'View Level '.$model->name,
);

$this->menu=array(
	array('label'=>'List Level', 'url'=>array('index')),
	array('label'=>'Create Level', 'url'=>array('create')),
	array('label'=>'Update Level', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Level', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Level', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/level/admin';?>"><span class="fa fa-th-list"></span>Manage Levels</a>
				<?php if (Yii::app()->user->checkAccess("master.level.update")) { ?>
		<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>	
				<?php } ?>
			<h1>View Level <?php echo $model->name; ?></h1>

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
