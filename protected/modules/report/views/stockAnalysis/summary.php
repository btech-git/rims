<?php
Yii::app()->clientScript->registerScript('report', '
	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
');
?>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <h1>Stock Analysis</h1>
            <div class="myForm">
                <?php echo CHtml::beginForm(array(''), 'get'); ?>

                <div class="row">
                    <div class="medium-4 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Brand</span>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::dropDownList('BrandId', $brandId, CHtml::listData(Brand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                        'empty' => '-- All --',
                                        'order' => 'name',
                                        'onchange' => CHtml::ajax(array(
                                            'type' => 'GET',
                                            'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSelect'),
                                            'update' => '#product_sub_brand',
                                        )),
                                    )); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Master Category</span>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::dropDownList('ProductMasterCategoryId', $productMasterCategoryId, CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                        'empty' => '-- All --',
                                            'order' => 'name',
                                        'onchange' => CHtml::ajax(array(
                                            'type' => 'GET',
                                            'url' => CController::createUrl('ajaxHtmlUpdateProductSubMasterCategorySelect'),
                                            'update' => '#product_sub_master_category',
                                        )),
                                    )); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">ID</span>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('ProductId', $productId); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="medium-4 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Sub Brand</span>
                                </div>

                                <div class="small-8 columns" id="product_sub_brand">
                                    <?php echo CHtml::dropDownList('SubBrandId', $subBrandId, CHtml::listData(SubBrand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                        'empty' => '-- All --',
                                        'order' => 'name',
                                        'onchange' => CHtml::ajax(array(
                                            'type' => 'GET',
                                            'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSeriesSelect'),
                                            'update' => '#product_sub_brand_series',
                                        )),
                                    )); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Sub Master Category</span>
                                </div>

                                <div class="small-8 columns" id="product_sub_master_category">
                                    <?php echo CHtml::dropDownList('ProductSubMasterCategoryId', $productSubMasterCategoryId, CHtml::listData(ProductSubMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                        'empty' => '-- All --',
                                        'order' => 'name',
                                        'onchange' => CHtml::ajax(array(
                                            'type' => 'GET',
                                            'url' => CController::createUrl('ajaxHtmlUpdateProductSubCategorySelect'),
                                            'update' => '#product_sub_category',
                                        )),
                                    )); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Code</span>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('ProductCode', $productCode); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="medium-4 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Sub Brand Series</span>
                                </div>

                                <div class="small-8 columns" id="product_sub_brand_series">
                                    <?php echo CHtml::dropDownList('SubBrandSeriesId', $subBrandSeriesId, CHtml::listData(SubBrandSeries::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                        'empty' => '-- All --',
                                        'order' => 'name',
                                    )); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Sub Category</span>
                                </div>

                                <div class="small-8 columns" id="product_sub_category">
                                    <?php echo CHtml::dropDownList('ProductSubCategoryId', $productSubCategoryId, CHtml::listData(ProductSubCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                        'empty' => '-- All --',
                                        'order' => 'name',
                                    )); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Name</span>
                                </div>

                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('ProductName', $productName); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-2 columns">
                                    <span class="prefix">Periode:</span>
                                </div>

                                <div class="small-5 columns">
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
                                </div>

                                <div class="small-5 columns">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Branch</span>
                                </div>

                                <div class="small-8 columns" id="product_sub_category">
                                    <?php echo CHtml::dropDownList('BranchId', $branchId, CHtml::listData(Branch::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                        'empty' => '-- All --',
                                        'order' => 'name',
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clear"></div>

                <div class="row buttons">
                    <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                    <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                </div>

                <?php echo CHtml::endForm(); ?>
                <div class="clear"></div>

            </div>

            <hr />

            <?php echo $this->renderPartial('_summary', array(
                'inventoryDetail' => $inventoryDetail,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'branchId' => $branchId,
                'brandId' => $brandId,
                'subBrandId' => $subBrandId,
                'subBrandSeriesId' => $subBrandSeriesId,
                'productMasterCategoryId' => $productMasterCategoryId,
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
                'productSubCategoryId' => $productSubCategoryId,
                'productId' => $productId,
                'productCode' => $productCode,
                'productName' => $productName,
            )); ?>
        </div>
    </div>
</div>