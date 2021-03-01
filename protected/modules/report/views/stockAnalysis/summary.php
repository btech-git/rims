<?php
/* @var $this RegistrationServiceController */
/* @var $model RegistrationService */

$this->breadcrumbs=array(
	'Stock Analysis',
	'Create',
);

?>

<h1>Stock Analysis</h1>

<?php echo $this->renderPartial('_summary', array(
    'inventoryDetail' => $inventoryDetail,
    'inventoryDetailDataProvider' => $inventoryDetailDataProvider,
)); ?>