<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
      'Registration Transaction'=>array('admin'),
      'Update Images',
);

$this->menu=array(
      array('label'=>'List RegistrationTransaction', 'url'=>array('index')),
      array('label'=>'Manage RegistrationTransaction', 'url'=>array('admin')),
);
?>
<div id="maincontent">
      <?php echo $this->renderPartial('_update-images', array(
            'model'=>$model,
            'insuranceImages'=>$insuranceImages,
            'allowedImages'=>$allowedImages,
            // 'requestOrder'=>$requestOrder,
            // 'requestOrderDetail'=>$requestOrderDetail,
            // 'historis'=>$historis
            //'jenisPersediaan'=>$jenisPersediaan,
            //'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
            )); ?>
</div>