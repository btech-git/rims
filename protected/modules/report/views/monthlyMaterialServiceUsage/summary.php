<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
    });
");
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
                            'yearList' => $yearList,
                            'year' => $year,
                            'monthList' => $monthList,
                            'month' => $month,
                            'productId' => $productId,
                            'productCode' => $productCode,
                            'productName' => $productName,
                            'brandId' => $brandId,
                            'subBrandId' => $subBrandId,
                            'subBrandSeriesId' => $subBrandSeriesId,
                            'masterCategoryId' => $masterCategoryId,
                            'subCategoryId' => $subCategoryId,
                            'subMasterCategoryId' => $subMasterCategoryId,
                        )); ?>
                    </div><!-- search-form -->

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div class="relative">
                    <?php $this->renderPartial('_summary', array(
                        'monthlyMaterialServiceUsageReportData' => $monthlyMaterialServiceUsageReportData,
                        'inventoryAllBranchCurrentStockData' => $inventoryAllBranchCurrentStockData,
                        'year' => $year,
                        'month' => $month,
                        'monthList' => $monthList,
                        'branches' => $branches,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
