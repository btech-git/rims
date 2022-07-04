<?php
/* @var $this ProductSubMasterCategoryController */
/* @var $model ProductSubMasterCategory */

$this->breadcrumbs = array(
    'Product' => Yii::app()->baseUrl . '/master/product/admin',
    'Product Sub Master Categories' => array('admin'),
    'Manage Product Sub Master Categories',
);

$this->menu = array(
        //array('label'=>'List ProductSubMasterCategory', 'url'=>array('index')),
        //array('label'=>'Create ProductSubMasterCategory', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).text('');
	}else {
		$(this).text('Advanced Search');
	}
	return false;
});

$('.search-form form').submit(function(){
	$('#product-sub-master-category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!-- BEGIN maincontent -->
<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("masterProductSubMasterCategoryCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/productSubMasterCategory/create'; ?>"><span class="fa fa-plus"></span>New Product Sub-Master Category</a>
        <?php } ?>
        <h1>Manage Product Sub-Master Category</h1>

        <!-- BEGIN aSearch -->
        <div class="search-bar">
            <div class="clearfix button-bar">
                <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>	
            </div>
            <div class="clearfix"></div>
            <div class="search-form" style="display:none">
                <?php
                $this->renderPartial('_search', array(
                    'model' => $model,
                ));
                ?>
            </div><!-- search-form -->
        </div>
        <!-- END aSearch -->		


        <!-- BEGIN gridview -->
        <div class="grid-view">
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'product-sub-master-category-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => '2',
                        'header' => 'Selected',
                        'value' => '$data->id',
                    ),
                    array('name' => 'product_master_category_code', 'value' => '$data->productMasterCategory->code', 'type' => 'raw'),
                    array('name' => 'product_master_category_name', 'value' => '$data->productMasterCategory->name', 'type' => 'raw'),
                    'code',
                    array('name' => 'name', 'value' => 'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type' => 'raw'),
                    array(
                        'header' => 'Status',
                        'name' => 'status',
                        'value' => '$data->status',
                        'type' => 'raw',
                        'filter' => CHtml::dropDownList('ProductSubMasterCategory[status]', $model->status, array(
                            '' => 'All',
                            'Active' => 'Active',
                            'Inactive' => 'Inactive',
                                )
                        ),
                    ),
                    array('name' => 'coa_persediaan_barang_dagang_name', 'value' => '$data->coaPersediaanBarangDagang!="" ? $data->coaPersediaanBarangDagang->name : ""'),
                    array('name' => 'coa_persediaan_barang_dagang_code', 'value' => '$data->coaPersediaanBarangDagang!="" ? $data->coaPersediaanBarangDagang->code : ""'),
                    array('name' => 'coa_hpp_name', 'value' => '$data->coaHpp != "" ? $data->coaHpp->name : ""'),
                    array('name' => 'coa_hpp_code', 'value' => '$data->coaHpp != "" ? $data->coaHpp->code :"" '),
                    array('name' => 'coa_penjualan_barang_dagang_name', 'value' => '$data->coaPenjualanBarangDagang != "" ? $data->coaPenjualanBarangDagang->name : ""'),
                    array('name' => 'coa_penjualan_barang_dagang_code', 'value' => '$data->coaPenjualanBarangDagang != "" ? $data->coaPenjualanBarangDagang->code :""'),
                    array('name' => 'coa_retur_penjualan_name', 'value' => '$data->coaReturPenjualan != "" ? $data->coaReturPenjualan->name : ""'),
                    array('name' => 'coa_retur_penjualan_code', 'value' => '$data->coaReturPenjualan != "" ? $data->coaReturPenjualan->code : ""'),
                    array('name' => 'coa_diskon_penjualan_name', 'value' => '$data->coaDiskonPenjualan != "" ? $data->coaDiskonPenjualan->name : ""'),
                    array('name' => 'coa_diskon_penjualan_code', 'value' => '$data->coaDiskonPenjualan != "" ? $data->coaDiskonPenjualan->code : ""'),
                    array('name' => 'coa_retur_pembelian_name', 'value' => '$data->coaReturPembelian != "" ? $data->coaReturPembelian->name : ""'),
                    array('name' => 'coa_retur_pembelian_code', 'value' => '$data->coaReturPembelian != "" ? $data->coaReturPembelian->code : ""'),
                    array('name' => 'coa_diskon_pembelian_name', 'value' => '$data->coaDiskonPembelian != "" ? $data->coaDiskonPembelian->name : ""'),
                    array('name' => 'coa_diskon_pembelian_code', 'value' => '$data->coaDiskonPembelian != "" ? $data->coaDiskonPembelian->code : ""'),
                    array('name' => 'coa_consignment_inventory_name', 'value' => '$data->coaConsignmentInventory != "" ? $data->coaConsignmentInventory->name : ""'),
                    array('name' => 'coa_consignment_inventory_name', 'value' => '$data->coaConsignmentInventory != "" ? $data->coaConsignmentInventory->code : ""'),
                    array('name' => 'coa_inventory_in_transit_name', 'value' => '$data->coaInventoryInTransit != "" ? $data->coaInventoryInTransit->name : ""'),
                    array('name' => 'coa_inventory_in_transit_code', 'value' => '$data->coaInventoryInTransit != "" ? $data->coaInventoryInTransit->code : ""'),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{edit}',
                        'buttons' => array
                            (
                            'edit' => array
                                (
                                'label' => 'edit',
                                'visible' => '(Yii::app()->user->checkAccess("masterProductSubMasterCategoryEdit"))',
                                'url' => 'Yii::app()->createUrl("master/productSubMasterCategory/update", array("id"=>$data->id))',
                            ),
                        ),
                    ),
                ),
            ));
            ?>

        </div>
        <!-- END gridview -->
    </div>
    <!-- END maincontent -->		
</div>