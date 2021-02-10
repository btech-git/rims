<?php
/* @var $this RegistrationServiceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Registration Services',
);

$this->menu=array(
	array('label'=>'Create RegistrationService', 'url'=>array('create')),
	array('label'=>'Manage RegistrationService', 'url'=>array('admin')),
);
?>

<h1>Registration Services</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
