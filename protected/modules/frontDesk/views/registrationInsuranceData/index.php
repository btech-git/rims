<?php
/* @var $this RegistrationInsuranceDataController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Registration Insurance Datas',
);

$this->menu=array(
	array('label'=>'Create RegistrationInsuranceData', 'url'=>array('create')),
	array('label'=>'Manage RegistrationInsuranceData', 'url'=>array('admin')),
);
?>

<h1>Registration Insurance Datas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
