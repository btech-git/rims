<?php
/* @var $this TireSizeController */
/* @var $model TireSize */

$this->breadcrumbs=array(
	'Tire Sizes'=>array('index'),
	'Update',
);

$this->menu=array(
	array('label'=>'List TireSize', 'url'=>array('index')),
	array('label'=>'Create TireSize', 'url'=>array('create')),
	array('label'=>'Manage TireSize', 'url'=>array('admin')),
);
?>

<h1>Update Ukuran Ban <?php echo $tireSize->header->id; ?></h1>

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