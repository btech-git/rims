<?php
$this->breadcrumbs = array(
	'Units'=>array('admin'),
	$model->name=>array('view', 'id'=>$model->id),
	'Update',
);

$this->menu = array(
	array('label'=>'Create Unit', 'url'=>array('create')),
	array('label'=>'View Unit', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Unit', 'url'=>array('admin')),
);
?>

<h1>Update Unit <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>