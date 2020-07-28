<?php
/* @var $this EquipmentTypeController */
/* @var $model EquipmentType */

$this->breadcrumbs=array(
	'Equipment Types'=>array('admin'),
	$model->name,
);

$this->breadcrumbs=array(
 	'Product',
	'Equipment Types'=>array('admin'),
 	'View Equipment Type '.$model->name,
 );

/*$this->menu=array(
	array('label'=>'List EquipmentType', 'url'=>array('index')),
	array('label'=>'Create EquipmentType', 'url'=>array('create')),
	array('label'=>'Update EquipmentType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EquipmentType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EquipmentType', 'url'=>array('admin')),
);*/
?>




		<div id="maincontent">
			<div class="clearfix page-action">
					<?php $ccontroller = Yii::app()->controller->id; ?>
				<?php $ccaction = Yii::app()->controller->action->id; ?>
					<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/equipmentType/admin';?>"><span class="fa fa-th-list"></span>Manage Equipment Type</a>
				<?php if (Yii::app()->user->checkAccess("master.equipmentType.update")) { ?>
					<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
				<?php } ?>
					<h1>View <?php echo $model->name ?></h1>

						<?php $this->widget('zii.widgets.CDetailView', array(
							'data'=>$model,
							'attributes'=>array(
								//'id',
								'name',
								'description',
								'status',
							),
						)); ?>

			</div>
	</div>
