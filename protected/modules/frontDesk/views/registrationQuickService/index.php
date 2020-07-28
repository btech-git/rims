<?php
/* @var $this RegistrationQuickServiceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Registration Quick Services',
);

$this->menu=array(
	array('label'=>'Create RegistrationQuickService', 'url'=>array('create')),
	array('label'=>'Manage RegistrationQuickService', 'url'=>array('admin')),
);
?>

<h1>Registration Quick Services</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
