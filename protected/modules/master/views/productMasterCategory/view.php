<?php
/* @var $this ProductMasterCategoryController */
/* @var $model ProductMasterCategory */

$this->breadcrumbs = array(
    'Product' => Yii::app()->baseUrl . '/master/product/admin',
    'Product Master Categories' => array('admin'),
    'View Product Master Category' . $model->name,
);

$this->menu = array(
    array('label' => 'List ProductMasterCategory', 'url' => array('index')),
    array('label' => 'Create ProductMasterCategory', 'url' => array('create')),
    array('label' => 'Update ProductMasterCategory', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete ProductMasterCategory', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage ProductMasterCategory', 'url' => array('admin')),
);
?>


<!-- BEGIN maincontent -->
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/productMasterCategory/admin'; ?>"><span class="fa fa-list"></span>Manage Product Master Category</a>
        <?php if (Yii::app()->user->checkAccess("masterProductCategoryEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>
        <?php } ?>
        <h1>View Product Master Category <?php echo $model->name; ?></h1>

        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                //'id',
                'code',
                'name',
                'description',
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
            ),
        ));
        ?>

    </div>
</div>
