<?php
Yii::app()->clientScript->registerScript('report', '
    $("#Month").val("' . $month . '");
    $("#Year").val("' . $year . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm">
                <?php echo CHtml::beginForm(array(''), 'get'); ?>
                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Bulan</span>
                                </div>
                                <div class="small-4 columns">
                                    <?php echo CHtml::dropDownList('Month', $month, $monthList); ?>
                                </div>

                                <div class="small-4 columns">
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
                                    <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllbyAttributes(array('status' => 'Active')), 'id', 'name'), array('empty' => '-- All Branch --')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="medium-12 columns">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Brand</td>
                                    <td>
                                        <?php echo CHtml::dropDownList('BrandId', $brandId, CHtml::listData(Brand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
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
                                    </td>

                                    <td>Sub Brand Series</td>
                                    <td>
                                        <div id="product_sub_brand_series">
                                            <?php echo CHtml::dropDownList('SubBrandSeriesId', $subBrandSeriesId, CHtml::listData(SubBrandSeries::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- All --')); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Master Kategori</td>
                                    <td>
                                        <?php echo CHtml::dropDownList('MasterCategoryId', $masterCategoryId, CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
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
                                            <?php echo CHtml::dropDownList('SubMasterCategoryId', $subMasterCategoryId, CHtml::listData(ProductSubMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
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
                                            <?php echo CHtml::dropDownList('SubCategoryId', $subCategoryId, CHtml::listData(ProductSubCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- All --')); ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="clear"></div>

                <div class="row buttons">
                    <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                    <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                    <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                </div>

                <?php echo CHtml::endForm(); ?>
                <div class="clear"></div>

            </div>

            <hr />

            <div style="font-weight: bold; text-align: center">
                <?php $branch = Branch::model()->findByPk($branchId); ?>
                <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
                <div style="font-size: larger">Laporan Penjualan Parts Monthly</div>
                <div><?php echo $monthList[$month] . ' ' . $year; ?></div>
            </div>

            <br />

            <div class="relative">
                <?php $this->renderPartial('_summary', array(
                    'branchId' => $branchId,
                    'month' => $month,
                    'year' => $year,
                    'numberOfDays' => $numberOfDays,
                    'salePriceReportData' => $salePriceReportData,
                    'saleQuantityReportData' => $saleQuantityReportData,
                    'monthList' => $monthList,
                    'productList' => $productList,
                    'saleReportSummaryData' => $saleReportSummaryData,
                )); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>