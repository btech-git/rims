<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div>
                <div class="myForm">
                    <?php echo CHtml::beginForm(array(''), 'get'); ?>
                    
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Tahun </span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownList('Year', $year, $yearList); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Branch </span>
                                    </div>
                                     <div class="small-8 columns">
                                          <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array('empty'=>'-- All Branch --')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
<!--                    <div class="row">
                        <div class="medium-12 columns">
                            <div class="field">
                                <table>
                                    <thead>
                                        <tr>
                                            <td>Brand</td>
                                            <td>Sub Brand</td>
                                            <td>Sub Brand Series</td>
                                            <td>Master Kategori</td>
                                            <td>Sub Master Kategori</td>
                                            <td>Sub Kategori</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <?php /*echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                                    'empty' => '-- All --',
                                                    'order' => 'name',
                                                    'onchange' => CHtml::ajax(array(
                                                        'type' => 'GET',
                                                        'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSelect'),
                                                        'update' => '#product_sub_brand',
                                                    )) . 
                                                    CHtml::ajax(array(
                                                        'type' => 'GET',
                                                        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                                        'update' => '#product_stock_table',
                                                    )),
                                                )); ?>
                                            </td>

                                            <td>
                                                <div id="product_sub_brand">
                                                    <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                                        'empty' => '-- All --',
                                                        'order' => 'name',
                                                        'onchange' => CHtml::ajax(array(
                                                            'type' => 'GET',
                                                            'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSeriesSelect'),
                                                            'update' => '#product_sub_brand_series',
                                                        )) . 
                                                        CHtml::ajax(array(
                                                            'type' => 'GET',
                                                            'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                                            'update' => '#product_stock_table',
                                                        )),
                                                    )); ?>
                                                </div>
                                            </td>

                                            <td>
                                                <div id="product_sub_brand_series">
                                                    <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                                        'empty' => '-- All --',
                                                        'order' => 'name',
                                                        'onchange' => CHtml::ajax(array(
                                                            'type' => 'GET',
                                                            'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                                            'update' => '#product_stock_table',
                                                        )),
                                                    )); ?>
                                                </div>
                                            </td>

                                            <td>
                                                <?php echo CHtml::activeDropDownList($product, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                                    'empty' => '-- All --',
                                                        'order' => 'name',
                                                    'onchange' => CHtml::ajax(array(
                                                        'type' => 'GET',
                                                        'url' => CController::createUrl('ajaxHtmlUpdateProductSubMasterCategorySelect'),
                                                        'update' => '#product_sub_master_category',
                                                    )) .
                                                    CHtml::ajax(array(
                                                        'type' => 'GET',
                                                        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                                        'update' => '#product_stock_table',
                                                    )),
                                                )); ?>
                                            </td>

                                            <td>
                                                <div id="product_sub_master_category">
                                                    <?php echo CHtml::activeDropDownList($product, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                                        'empty' => '-- All --',
                                                        'order' => 'name',
                                                        'onchange' => CHtml::ajax(array(
                                                            'type' => 'GET',
                                                            'url' => CController::createUrl('ajaxHtmlUpdateProductSubCategorySelect'),
                                                            'update' => '#product_sub_category',
                                                        )) .
                                                        CHtml::ajax(array(
                                                            'type' => 'GET',
                                                            'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                                            'update' => '#product_stock_table',
                                                        )),
                                                    )); ?>
                                                </div>
                                            </td>

                                            <td>
                                                <div id="product_sub_category">
                                                    <?php echo CHtml::activeDropDownList($product, 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                                        'empty' => '-- All --',
                                                        'order' => 'name',
                                                        'onchange' => CHtml::ajax(array(
                                                            'type' => 'GET',
                                                            'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                                            'update' => '#product_stock_table',
                                                        )),
                                                    ));*/ ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>-->

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

                <?php $monthList = array(
                    1 => 'Jan',
                    2 => 'Feb',
                    3 => 'Mar',
                    4 => 'Apr',
                    5 => 'May',
                    6 => 'Jun',
                    7 => 'Jul',
                    8 => 'Aug',
                    9 => 'Sep',
                    10 => 'Oct',
                    11 => 'Nov',
                    12 => 'Dec',
                ); ?>

                <div class="relative">
                    <?php $this->renderPartial('_summary', array(
                        'invoiceTireInfo' => $invoiceTireInfo,
                        'year' => $year,
                        'monthList' => $monthList,
                        'branchId' => $branchId,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
