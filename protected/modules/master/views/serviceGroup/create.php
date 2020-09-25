<?php
/* @var $this ServiceGroupController */
/* @var $model ServiceGroup */

$this->breadcrumbs = array(
    'Service Groups' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Service Group', 'url' => array('index')),
    array('label' => 'Manage Service Group', 'url' => array('admin')),
);
?>

<h1>Create Service Group</h1>

<?php echo $this->renderPartial('_form', array(
    'serviceGroup' => $serviceGroup,
)); ?>