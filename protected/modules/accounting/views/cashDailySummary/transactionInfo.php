<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead">
        <?php echo CHtml::beginForm('', 'get'); ?>
            <div class="row buttons">
                <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcelDetail')); ?>
            </div>
        <?php echo CHtml::endForm(); ?>

    </div>
    
    <hr />

    <div class="tabBody">
        <div id="detail_div">

            <div class="relative">
                <div class="reportDisplay">
                    <?php echo ReportHelper::summaryText($dataProvider); ?>
                </div>

                <?php $this->renderPartial('_transactionInfo', array(
                    'dataProvider' => $dataProvider,
                    'transactionDate' => $transactionDate,
                    'branchId' => $branchId,
                )); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

<div>
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $dataProvider->pagination->itemCount,
            'pageSize' => $dataProvider->pagination->pageSize,
            'currentPage' => $dataProvider->pagination->getCurrentPage(false),
        )); ?>
    </div>
    <div class="clear"></div>
</div>