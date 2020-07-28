<?php
/* @var $this EquipmentController */
/* @var $model Equipment */

$this->breadcrumbs=array(
	'Service'=>Yii::app()->baseUrl.'/master/service/admin',
	'Equipment'=>array('admin'),
	'Create Equipment ',
);

// $this->menu=array(
// 	array('label'=>'List Equipment', 'url'=>array('index')),
// 	array('label'=>'Manage Equipment', 'url'=>array('admin')),
// );
?>



		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>