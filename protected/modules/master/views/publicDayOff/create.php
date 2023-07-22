<?php
/* @var $this PublicDayOffController */
/* @var $model PublicDayOff */

$this->breadcrumbs=array(
	'Public Day Offs'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List PublicDayOff', 'url'=>array('index')),
	array('label'=>'Manage PublicDayOff', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create PublicDayOff</h1>-->

<div id="maincontent">
    <?php $this->renderPartial('_form', array('model'=>$model,'offs'=>$offs)); ?>
</div>