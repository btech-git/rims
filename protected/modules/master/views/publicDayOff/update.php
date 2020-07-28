<?php
/* @var $this PublicDayOffController */
/* @var $model PublicDayOff */

$this->breadcrumbs=array(
	'Public Day Offs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List PublicDayOff', 'url'=>array('index')),
	array('label'=>'Create PublicDayOff', 'url'=>array('create')),
	array('label'=>'View PublicDayOff', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PublicDayOff', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update PublicDayOff <?php echo $model->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model,'offs'=>$offs)); ?></div>