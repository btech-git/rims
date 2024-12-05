<?php
/* @var $this UnitController */
/* @var $model Unit */

$this->breadcrumbs = array(
    'Company',
    'Units' => array('admin'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Unit', 'url' => array('index')),
    array('label' => 'Manage Unit', 'url' => array('admin')),
);
?>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'model' => $model,
    )); ?>
</div>
