<?php
/* @var $this OilSaeController */
/* @var $model OilSae */

$this->breadcrumbs = array(
    'Oil Saes' => array('index'),
    $model->sae,
);

$this->menu = array(
    array('label' => 'List OilSae', 'url' => array('index')),
    array('label' => 'Create OilSae', 'url' => array('create')),
    array('label' => 'Update OilSae', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete OilSae', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage OilSae', 'url' => array('admin')),
);
?>

<h1>View Oil Specifications #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'winter_grade',
        'hot_grade',
    ),
)); ?>
