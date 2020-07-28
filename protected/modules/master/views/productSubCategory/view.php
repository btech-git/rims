<?php
/* @var $this ProductSubCategoryController */
/* @var $model ProductSubCategory */

$this->breadcrumbs=array(
	'Product'=>array('admin'),
	'Product Sub Categories'=>array('admin'),
	'View Product Sub Category '.$model->name,
);

$this->menu=array(
	array('label'=>'List ProductSubCategory', 'url'=>array('index')),
	array('label'=>'Create ProductSubCategory', 'url'=>array('create')),
	array('label'=>'Update ProductSubCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductSubCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductSubCategory', 'url'=>array('admin')),
);
?>
<!-- BEGIN maincontent -->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/productSubCategory/admin';?>"><span class="fa fa-list"></span>Manage Product Sub Category</a>
				<?php if (Yii::app()->user->checkAccess("master.productSubMasterCategory.update")) { ?>
		<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
				<?php } ?>
		<h1>View Product Sub Category <?php echo $model->id; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			'id',
			//'product_master_category',
			array('name'=>'product_master_category', 'value'=>$model->productMasterCategory->code),
			//'product_sub_master_category_id',
			array('name'=>'product_sub_master_category', 'value'=>$model->productSubMasterCategory->code),
			'code',
			'name',
			'description',
			'status',
		),
		)); ?>

	</div>
</div>
