<?php
/* @var $this BrandController */
/* @var $model Brand */

$this->breadcrumbs=array(
 	'Product',
	'Brands'=>array('admin'),
 	'View Brand '.$model->name,
 );

/*$this->menu=array(
	array('label'=>'List Brand', 'url'=>array('index')),
	array('label'=>'Create Brand', 'url'=>array('create')),
	array('label'=>'Update Brand', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Brand', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Brand', 'url'=>array('admin')),
);*/
?>




		<div id="maincontent">
			<div class="clearfix page-action">
					<?php $ccontroller = Yii::app()->controller->id; ?>
				<?php $ccaction = Yii::app()->controller->action->id; ?>
					<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/brand/admin';?>"><span class="fa fa-th-list"></span>Manage Brand</a>
				<?php if (Yii::app()->user->checkAccess("master.brand.update")) { ?>
					<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
				<?php } ?>
					<h1>View <?php echo $model->name ?></h1>

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