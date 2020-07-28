<?php
/* @var $this JurnalUmumController */
/* @var $model JurnalUmum */

$this->breadcrumbs=array(
	'Jurnal Umums'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List JurnalUmum', 'url'=>array('index')),
	array('label'=>'Create JurnalUmum', 'url'=>array('create')),
	array('label'=>'View JurnalUmum', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage JurnalUmum', 'url'=>array('admin')),
);
?>

<h1>Update JurnalUmum <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>