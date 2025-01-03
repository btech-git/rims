<?php
/* @var $this ProductSubMasterCategoryController */
/* @var $model ProductSubMasterCategory */

$this->breadcrumbs = array(
    'Product' => Yii::app()->baseUrl . '/master/product/admin',
    'Product Sub Master Categories' => array('admin'),
    'View Product Sub Master Category ' . $model->name,
);

/* $this->menu=array(
  array('label'=>'List ProductSubMasterCategory', 'url'=>array('index')),
  array('label'=>'Create ProductSubMasterCategory', 'url'=>array('create')),
  array('label'=>'Update ProductSubMasterCategory', 'url'=>array('update', 'id'=>$model->id)),
  array('label'=>'Delete ProductSubMasterCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
  array('label'=>'Manage ProductSubMasterCategory', 'url'=>array('admin')),
  ); */
?>
<div id="maincontent">
    <?php $ccontroller = Yii::app()->controller->id; ?>
    <?php $ccaction = Yii::app()->controller->action->id; ?>
    <a class="button cbutton right" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/admin'); ?>"><span class="fa fa-th-list"></span>Manage Vehicle Car SubModel Details</a>
    <?php if (Yii::app()->user->checkAccess("masterProductSubMasterCategoryEdit")) { ?>
        <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>
    <?php } ?>
    <div class="clearfix page-action">

        <h1>View Product Sub Master Category <?php echo $model->name; ?></h1>
        <div class="detail-view-long">
            <?php
            $this->widget('zii.widgets.CDetailView', array(
                'data' => $model,
                'attributes' => array(
                    //'id',
                    array('name' => 'product_master_category_id', 'value' => $model->productMasterCategory->name),
                    'code',
                    'name',
                    'status',
                    array('name' => 'coa_persediaan_barang_dagang_name', 'value' => $model->coaPersediaanBarangDagang != "" ? $model->coaPersediaanBarangDagang->name : ''),
                    array('name' => 'coa_persediaan_barang_dagang_code', 'value' => $model->coaPersediaanBarangDagang != "" ? $model->coaPersediaanBarangDagang->code : ''),
                    array('name' => 'coa_hpp_name', 'value' => $model->coaHpp != "" ? $model->coaHpp->name : ''),
                    array('name' => 'coa_hpp_code', 'value' => $model->coaHpp != "" ? $model->coaHpp->code : ''),
                    array('name' => 'coa_penjualan_barang_dagang_name', 'value' => $model->coaPenjualanBarangDagang != "" ? $model->coaPenjualanBarangDagang->name : ''),
                    array('name' => 'coa_penjualan_barang_dagang_code', 'value' => $model->coaPenjualanBarangDagang != "" ? $model->coaPenjualanBarangDagang->code : ''),
                    array('name' => 'coa_retur_penjualan_name', 'value' => $model->coaReturPenjualan != "" ? $model->coaReturPenjualan->name : ''),
                    array('name' => 'coa_retur_penjualan_code', 'value' => $model->coaReturPenjualan != "" ? $model->coaReturPenjualan->code : ''),
                    array('name' => 'coa_diskon_penjualan_name', 'value' => $model->coaDiskonPenjualan != "" ? $model->coaDiskonPenjualan->name : ''),
                    array('name' => 'coa_diskon_penjualan_code', 'value' => $model->coaDiskonPenjualan != "" ? $model->coaDiskonPenjualan->code : ''),
                    array('name' => 'coa_retur_pembelian_name', 'value' => $model->coaReturPembelian != "" ? $model->coaReturPembelian->name : ''),
                    array('name' => 'coa_retur_pembelian_code', 'value' => $model->coaReturPembelian != "" ? $model->coaReturPembelian->code : ''),
                    array('name' => 'coa_diskon_pembelian_name', 'value' => $model->coaDiskonPembelian != "" ? $model->coaDiskonPembelian->name : ''),
                    array('name' => 'coa_diskon_pembelian_code', 'value' => $model->coaDiskonPembelian != "" ? $model->coaDiskonPembelian->code : ''),
                    array('name' => 'coa_inventory_in_transit_name', 'value' => $model->coaInventoryInTransit != "" ? $model->coaInventoryInTransit->name : ''),
                    array('name' => 'coa_inventory_in_transit_code', 'value' => $model->coaInventoryInTransit != "" ? $model->coaInventoryInTransit->code : ''),
                    array('name' => 'coa_consignment_inventory_name', 'value' => $model->coaConsignmentInventory != "" ? $model->coaConsignmentInventory->name : ''),
                    array('name' => 'coa_consignment_inventory_code', 'value' => $model->coaConsignmentInventory != "" ? $model->coaConsignmentInventory->code : ''),
                    array('name' => 'coa_outstanding_part_name', 'value' => $model->coaOutstandingPart != "" ? $model->coaOutstandingPart->name : ''),
                    array('name' => 'coa_outstanding_part_code', 'value' => $model->coaOutstandingPart != "" ? $model->coaOutstandingPart->code : ''),
                    'date_posting',
                    array(
                        'label' => 'Created by',
                        'name' => 'user_id', 
                        'value' => $model->user->username
                    ),
                    array(
                        'name' => 'user_id_approval',
                        'value' => empty($model->user_id_approval) ? "N/A" : $model->userIdApproval->username,
                    ),
                    array(
                        'name' => 'date_approval',
                        'value' => empty($model->date_approval) ? "N/A" : $model->date_approval,
                    ),
                ),
            ));
            ?>
        </div>

    </div>
</div>

<br/>

<div>
    <?php if ((int) $model->is_approved === 0): ?>
        <div style="float: left; margin-left: 20px;">
            <?php echo CHtml::beginForm(); ?>
            <?php echo CHtml::submitButton('APPROVE', array('name' => 'Approve', 'class' => 'button success')); ?>
            <?php echo CHtml::submitButton('REJECT', array('name' => 'Reject', 'class' => 'button warning')); ?>
            <?php echo CHtml::endForm(); ?>
        </div>
    <?php endif; ?>
    <div class="clear"></div>
</div>
