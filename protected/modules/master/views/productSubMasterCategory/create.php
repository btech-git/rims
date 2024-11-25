<?php
/* @var $this ProductSubMasterCategoryController */
/* @var $model ProductSubMasterCategory */

$this->breadcrumbs = array(
    'Product' => Yii::app()->baseUrl . '/master/product/admin',
    'Product Sub Master Categories' => array('admin'),
    'Create',
);

$this->menu = array(
    array('label' => 'List ProductSubMasterCategory', 'url' => array('index')),
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