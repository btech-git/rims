<?php
/* @var $this MovementInHeaderController */
/* @var $model MovementInHeader */

$this->breadcrumbs = array(
    'Movement In' => array('admin'),
    'Create',
);

?>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'movementIn' => $movementIn,
    )); ?>
</div>