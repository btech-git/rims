<?php
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
        )); ?>
    </div><!-- search-form -->
    <?php echo CHtml::endForm(); ?>
</div>

<div class="reportDisplay">
    <?php $dataCount = count($inventoryMaterialStockReportData); ?>
    <?php if ($dataCount > 0): ?>
        <?php echo "Displaying 1-{$dataCount} of {$dataCount} result(s)."; ?>
    <?php endif; ?>
</div>

<div id="product_stock_table">
    <?php $this->renderPartial('_productStockTable', array(
        'branches' => $branches,
        'inventoryMaterialStockReportData' => $inventoryMaterialStockReportData,
        'endDate' => $endDate,
    )); ?>
</div>
