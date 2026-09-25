<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
    });
");
?>

<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div>
                <div class="myForm">
                    <?php echo CHtml::beginForm(array(''), 'get'); ?>

                    <div class="search-bar">
                        <div class="clearfix button-bar">
                            <a href="#" class="search-button right button cbutton secondary" id="menushow">Advanced Search</a>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="search-form" style="display:none">
                        <?php $this->renderPartial('_search',array(
                            'product' => $product,
                        )); ?>
                    </div><!-- search-form -->

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div class="relative">
                    <div class="reportDisplay">
                        <?php echo ReportHelper::summaryText($productDataProvider); ?>
                    </div>

                    <?php $this->renderPartial('_summary', array(
                        'productDataProvider' => $productDataProvider,
                        'productLatestTransactionReportData' => $productLatestTransactionReportData,
                    )); ?>
                </div>
                
                <div class="right">
                    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
                        'itemCount' => $productDataProvider->pagination->itemCount,
                        'pageSize' => $productDataProvider->pagination->pageSize,
                        'currentPage' => $productDataProvider->pagination->getCurrentPage(false),
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
