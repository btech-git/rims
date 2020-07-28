<?php
/* @var $this ServiceCategoryController */
/* @var $model ServiceCategory */
$this->breadcrumbs=array(
	'Service'=>Yii::app()->baseUrl.'/master/service/admin',
	'Service Category'=>array('admin'),
	'Update',
);

$this->menu=array(
	array('label'=>'List ServiceCategory', 'url'=>array('index')),
	array('label'=>'Create ServiceCategory', 'url'=>array('create')),
	array('label'=>'View ServiceCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ServiceCategory', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array(
		'model'=>$model,
		'coa'=>$coa,
		'coaDataProvider'=>$coaDataProvider,
		'coaDiskon'=>$coaDiskon,
		'coaDiskonDataProvider'=>$coaDiskonDataProvider,
		)); ?>
</div>