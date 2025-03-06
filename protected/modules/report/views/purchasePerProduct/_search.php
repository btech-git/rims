<div>
    <table>
        <tbody>
            <tr>
                <td>Jumlah per Halaman</td>
                <td><?php echo CHtml::textField('PageSize', '', array('size' => 3)); ?></td>
                <td>Halaman saat ini</td>
                <td><?php echo CHtml::textField('page', '', array('size' => 3, 'id' => 'CurrentPage')); ?></td>
                <td>Branch</td>
                <td>
                    <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array('empty'=>'-- All Branch --')); ?>
                </td>
            </tr>
            <tr>
                <td>Brand</td>
                <td>
                    <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                        'empty' => '-- All --',
                        'order' => 'name',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSelect'),
                            'update' => '#product_sub_brand',
                        )),
                    )); ?>
                </td>

                <td>Sub Brand</td>
                <td>
                    <div id="product_sub_brand">
                        <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'order' => 'name',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSeriesSelect'),
                                'update' => '#product_sub_brand_series',
                            )),
                        )); ?>
                    </div>
                </td>

                <td>Sub Brand Series</td>
                <td>
                    <div id="product_sub_brand_series">
                        <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- All --')); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Master Kategori</td>
                <td>
                    <?php echo CHtml::activeDropDownList($product, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                        'empty' => '-- All --',
                            'order' => 'name',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateProductSubMasterCategorySelect'),
                            'update' => '#product_sub_master_category',
                        )),
                    )); ?>
                </td>
                <td>Sub Master Kategori</td>
                <td>
                    <div id="product_sub_master_category">
                        <?php echo CHtml::activeDropDownList($product, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'order' => 'name',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateProductSubCategorySelect'),
                                'update' => '#product_sub_category',
                            )),
                        )); ?>
                    </div>
                </td>
                <td>Sub Kategori</td>
                <td>
                    <div id="product_sub_category">
                        <?php echo CHtml::activeDropDownList($product, 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- All --')); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>ID</td>
                <td><?php echo CHtml::activeTextField($product, 'id'); ?></td>
                <td>Code</td>
                <td><?php echo CHtml::activeTextField($product, 'manufacturer_code'); ?></td>
                <td>Name</td>
                <td><?php echo CHtml::activeTextField($product, 'name'); ?></td>
            </tr>
            <tr>
                <th colspan="2">Tanggal</td>
                <td colspan="2">
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 'StartDate',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth'=>true,
                            'changeYear'=>true,
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'placeholder' => 'Mulai',
                        ),
                    )); ?>
                </td>
                <td colspan="2">
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 'EndDate',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth'=>true,
                            'changeYear'=>true,
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'placeholder' => 'Sampai',
                        ),
                    )); ?>
                </td>
            </tr>
        </tbody>
    </table>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
    </div>

</div>