<?php
/* @var $this EquipmentController */
/* @var $model Equipment */

$this->breadcrumbs=array(
	'Service'=>Yii::app()->baseUrl.'/master/service/admin',
	'Equipment'=>array('admin'),
	'Update Equipment ',
);

// $this->menu=array(
// 	array('label'=>'List Equipment', 'url'=>array('index')),
// 	array('label'=>'Create Equipment', 'url'=>array('create')),
// 	array('label'=>'View Equipment', 'url'=>array('view', 'id'=>$model->id)),
// 	array('label'=>'Manage Equipment', 'url'=>array('admin')),
// );
?>


		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>