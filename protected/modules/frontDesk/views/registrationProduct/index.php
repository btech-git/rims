<?php
/* @var $this RegistrationProductController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Registration Products',
);

$this->menu=array(
	array('label'=>'Create RegistrationProduct', 'url'=>array('create')),
	array('label'=>'Manage RegistrationProduct', 'url'=>array('admin')),
);
?>

<h1>Registration Products</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
