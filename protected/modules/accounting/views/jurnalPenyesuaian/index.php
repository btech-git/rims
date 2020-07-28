<?php
/* @var $this JurnalPenyesuaianController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Jurnal Penyesuaians',
);

$this->menu=array(
	array('label'=>'Create JurnalPenyesuaian', 'url'=>array('create')),
	array('label'=>'Manage JurnalPenyesuaian', 'url'=>array('admin')),
);
?>

<h1>Jurnal Penyesuaians</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
