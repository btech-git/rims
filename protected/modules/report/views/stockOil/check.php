<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

Yii::app()->clientScript->registerScript('report', '

    $("#EndDate").val("' . $endDate . '");
');

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
    });
");
?>

<div>
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
            'brandId' => $brandId,
            'subBrandId' => $subBrandId,
            'subBrandSeriesId' => $subBrandSeriesId,
            'productId' => $productId,
            'productCode' => $productCode,
            'productName' => $productName,
            'oilSaeId' => $oilSaeId,
            'convertToLitre' => $convertToLitre,
        )); ?>
    </div><!-- search-form -->
    <?php echo CHtml::endForm(); ?>
</div>

<div id="product_stock_table">
    <?php $this->renderPartial('_productStockTable', array(
        'branches' => $branches,
        'inventoryOilStockReportData' => $inventoryOilStockReportData,
        'endDate' => $endDate,
        'unitConversion' => $unitConversion,
        'convertToLitre' => $convertToLitre,
    )); ?>
</div>
