<?php
/* @var $this UnitController */
/* @var $model Unit */

$this->breadcrumbs = array(
    'Company',
    'Units' => array('admin'),
    //$model->name=>array('view','id'=>$model->id),
    'Update Unit',
);

?>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'model' => $model,
    )); ?>
</div>