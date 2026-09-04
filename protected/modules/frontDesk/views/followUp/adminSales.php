<?php
Yii::app()->clientScript->registerScript('report', '

    $("#InvoiceStartDate").val("' . $invoiceStartDate . '");
    $("#InvoiceEndDate").val("' . $invoiceEndDate . '");
    $("#WarrantyStartDate").val("' . $warrantyStartDate . '");
    $("#WarrantyEndDate").val("' . $warrantyEndDate . '");
    $("#FollowUpStartDate").val("' . $followUpStartDate . '");
    $("#FollowUpEndDate").val("' . $followUpEndDate . '");
    $("#PageSize").val("' . $dataProvider->pagination->pageSize . '");
    $("#CurrentPage").val("' . ($dataProvider->pagination->getCurrentPage(false) + 1) . '");
');

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
");

Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div class="tab reportTab">
    <div class="tabBody">
        <div id="detail_div">
            <div class="search-bar">
                <div class="clearfix button-bar">
                    <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
                    <div class="clearfix"></div>
                    <div class="search-form" style="display:none">
                        <?php $this->renderPartial('_search', array(
                            'model' => $model,
                            'plateNumber' => $plateNumber,
                            'carMake' => $carMake,
                            'carModel' => $carModel,
                            'carSubModel' => $carSubModel,
                            'customerName' => $customerName,
                            'invoiceStartDate' => $invoiceStartDate,
                            'invoiceEndDate' => $invoiceEndDate,
                            'warrantyStartDate' => $warrantyStartDate,
                            'warrantyEndDate' => $warrantyEndDate,
                            'followUpStartDate' => $followUpStartDate,
                            'followUpEndDate' => $followUpEndDate,
                            'startMileage' => $startMileage,
                            'customerType' => $customerType,
                            'employeeSaleId' => $employeeSaleId,
                            'currentPage' => $currentPage,
                        )); ?>
                    </div><!-- search-form -->
                </div>
            </div>

            <hr />

            <div class="relative">
                <div class="reportDisplay">
                    <?php echo ReportHelper::summaryText($dataProvider); ?>
                </div>

                <?php $this->renderPartial('_adminSales', array(
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                    'invoiceStartDate' => $invoiceStartDate,
                    'invoiceEndDate' => $invoiceEndDate,
                )); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

<div class="right">
    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
        'itemCount' => $dataProvider->pagination->itemCount,
        'pageSize' => $dataProvider->pagination->pageSize,
        'currentPage' => $dataProvider->pagination->getCurrentPage(false),
    )); ?>
</div>