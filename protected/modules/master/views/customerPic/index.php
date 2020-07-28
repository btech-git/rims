<?php
/* @var $this CustomerPicController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Customer Pics',
);

$this->menu=array(
	array('label'=>'Create CustomerPic', 'url'=>array('create')),
	array('label'=>'Manage CustomerPic', 'url'=>array('admin')),
);
?>

<h1>Customer Pics</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
