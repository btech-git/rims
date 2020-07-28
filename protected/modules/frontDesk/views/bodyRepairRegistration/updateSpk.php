<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
      'Registration Transaction'=>array('admin'),
      'Update SPK',
);

$this->menu=array(
      array('label'=>'List RegistrationTransaction', 'url'=>array('index')),
      array('label'=>'Manage RegistrationTransaction', 'url'=>array('admin')),
);
?>
<div id="maincontent">
      <?php echo $this->renderPartial('_update-spk', array(
            'model'=>$model,
            // 'requestOrder'=>$requestOrder,
            // 'requestOrderDetail'=>$requestOrderDetail,
            // 'historis'=>$historis
            //'jenisPersediaan'=>$jenisPersediaan,
            //'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
            )); ?>
</div>