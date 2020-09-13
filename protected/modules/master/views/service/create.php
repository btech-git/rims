<?php
/* @var $this ServiceController */
/* @var $model Service */
$this->breadcrumbs=array(
	'Service'=>Yii::app()->baseUrl.'/master/service/admin',
	'Service'=>array('admin'),
	'Create Service ',
);

// $this->menu=array(
// 	array('label'=>'List Service', 'url'=>array('index')),
// 	array('label'=>'Manage Service', 'url'=>array('admin')),
// );
?>
<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'service'=>$service,
        'equipment'=>$equipment,
        'equipmentDataProvider'=>$equipmentDataProvider,
        'complement'=>$complement,
        'complementDataProvider'=>$complementDataProvider,
        'material'=>$material,
        'materialDataProvider'=>$materialDataProvider,
    )); ?>
</div>