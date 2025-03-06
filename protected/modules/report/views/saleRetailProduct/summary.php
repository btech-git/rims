<?php
Yii::app()->clientScript->registerScript('report', '
    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
    $("#PageSize").val("' . $saleRetailProductSummary->dataProvider->pagination->pageSize . '");
    $("#CurrentPage").val("' . ($saleRetailProductSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
    $("#CurrentSort").val("' . $currentSort . '");
');
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
    });
");
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
                    <div class="search-bar">
                        <div class="clearfix button-bar">
                            <a href="#" class="search-button right button cbutton secondary" id="menushow">Advanced Search</a>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="search-form" style="display:none">
                        <?php $this->renderPartial('_search',array(
                            'endDate' => $endDate,
                            'product'=>$product,
                            'branchId' => $branchId,
                            'customerType' => $customerType,
                        )); ?>
                    </div><!-- search-form -->
                    
                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div class="right"><?php echo ReportHelper::summaryText($saleRetailProductSummary->dataProvider); ?></div>
                <br />
                <div class="right"><?php echo ReportHelper::sortText($saleRetailProductSummary->dataProvider->sort, array('Name')); ?></div>
                <div class="clear"></div>

                <br />
        
                <div class="relative">
                    <?php $this->renderPartial('_summary', array(
                        'saleRetailProductSummary' => $saleRetailProductSummary,
                        'product' => $product,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'branchId' => $branchId,
                        'customerType' => $customerType,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
            
<br/>

<div class="right">
    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
        'itemCount' => $saleRetailProductSummary->dataProvider->pagination->itemCount,
        'pageSize' => $saleRetailProductSummary->dataProvider->pagination->pageSize,
        'currentPage' => $saleRetailProductSummary->dataProvider->pagination->getCurrentPage(false),
    )); ?>
</div>
<div class="clear"></div>