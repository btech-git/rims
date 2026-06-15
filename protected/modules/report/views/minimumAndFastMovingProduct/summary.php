<div id="product_stock_table">
    <?php $this->renderPartial('_summary', array(
        'startDate' => $startDate,
        'endDate' => $endDate,
        'minimumAndFastMovingProduct' => $minimumAndFastMovingProduct,
        'inventoryCurrentStocksData' => $inventoryCurrentStocksData,
        'fastMovingAverageProductQuantitiesData' => $fastMovingAverageProductQuantitiesData,
    )); ?>
</div>
