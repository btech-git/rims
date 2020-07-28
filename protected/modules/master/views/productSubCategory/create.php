<?php
/* @var $this ProductSubCategoryController */
/* @var $model ProductSubCategory */

$this->breadcrumbs=array(
	'Product'=>Yii::app()->baseUrl.'/master/product/admin',
	'Product Sub Categories'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductSubCategory', 'url'=>array('index')),
	array('label'=>'Manage ProductSubCategory', 'url'=>array('admin')),
);
?>



		<div id="maincontent">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
