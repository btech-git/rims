<?php
Yii::app()->clientScript->registerScript('report', '
    $("#PageSize").val("' . $productSubCategoryDataProvider->pagination->pageSize . '");
    $("#CurrentPage").val("' . ($productSubCategoryDataProvider->pagination->getCurrentPage(false) + 1) . '");
    $("#EndDate").val("' . $endDate . '");
' );
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
                    
                    <div class="row"><?php echo CHtml::hiddenField('page', $currentPage, array('size' => 3, 'id' => 'CurrentPage')); ?></div>
                        <table>
                            <thead>
                                <tr>
                                    <td>Master Kategori</td>
                                    <td>Sub Master Kategori</td>
                                    <td>Sub Kategori</td>
                                    <td>Per Tanggal</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php echo CHtml::activeDropDownList($productSubCategory, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
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
                                            <?php echo CHtml::activeDropDownList($productSubCategory, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
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
                                            <?php echo CHtml::activeDropDownList($productSubCategory, 'id', CHtml::listData(ProductSubCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
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
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'EndDate',
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'placeholder' => 'Per Tanggal',
                                            ),
                                        )); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="clear"></div>
                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                        <?php echo CHtml::resetButton('Hapus');  ?>
                        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div class="relative">
                    <div class="reportDisplay" style="text-align: right">
                        <?php echo ReportHelper::summaryText($productSubCategoryDataProvider); ?>
                    </div>

                    <?php $this->renderPartial('_summary', array(
                        'productSubCategoryDataProvider' => $productSubCategoryDataProvider,
                        'branches' => $branches,
                        'endDate' => $endDate,
                    )); ?>
                </div>
                
                <div class="clear"></div>
                
                <div class="right">
                    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
                        'itemCount' => $productSubCategoryDataProvider->pagination->itemCount,
                        'pageSize' => $productSubCategoryDataProvider->pagination->pageSize,
                        'currentPage' => $productSubCategoryDataProvider->pagination->getCurrentPage(false),
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>