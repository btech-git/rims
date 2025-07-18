<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm">
                <?php //echo CHtml::beginForm(array(''), 'get'); ?>

                <div class="clear"></div>
                <div class="row buttons">
                    <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                </div>

                <?php //echo CHtml::endForm(); ?>
                <div class="clear"></div>

            </div>

            <hr />

            <div class="relative">
                <div class="reportDisplay">
                    <?php echo ReportHelper::summaryText($dataProvider); ?>
                </div>

                <?php $this->renderPartial('_detailInfo', array(
                    'dataProvider' => $dataProvider,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'productMasterCategoryId' => $productMasterCategoryId,
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