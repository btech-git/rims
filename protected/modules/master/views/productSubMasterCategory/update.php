<?php
/* @var $this ProductSubMasterCategoryController */
/* @var $model ProductSubMasterCategory */

$this->breadcrumbs = array(
    'Product' => Yii::app()->baseUrl . '/master/product/admin',
    'Product Sub Master Categories' => array('admin'),
    //$model->name=>array('view','id'=>$model->id),
    'Update Product Sub Master Category',
);

$this->menu = array(
    array('label' => 'List ProductSubMasterCategory', 'url' => array('index')),
    array('label' => 'Create ProductSubMasterCategory', 'url' => array('create')),
    array('label' => 'View ProductSubMasterCategory', 'url' => array('view', 'id' => $model->id)),
    array('label' => 'Manage ProductSubMasterCategory', 'url' => array('admin')),
);
?>


<div id="maincontent">

    <?php
    $this->renderPartial('_form', array(
        'model' => $model,
    ));
    ?>
</div>