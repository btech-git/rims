<?php
/* @var $this TireSizeController */
/* @var $model TireSize */

$this->breadcrumbs=array(
	'Tire Sizes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TireSize', 'url'=>array('index')),
	array('label'=>'Manage TireSize', 'url'=>array('admin')),
);
?>

<h1>Create Ukuran Ban</h1>

<?php $this->renderPartial('_form', array(
    'tireSize' => $tireSize,
    'carModel' => $carModel,
    'carModelDataProvider' => $carModelDataProvider,
    'subBrandSeries' => $subBrandSeries,
    'premiumOptionDataProvider' => $premiumOptionDataProvider,
    'standardOptionDataProvider' => $standardOptionDataProvider,
    'economicOptionDataProvider' => $economicOptionDataProvider,
    'brandId' => $brandId,
)); ?>