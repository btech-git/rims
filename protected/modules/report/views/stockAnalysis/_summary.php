<div id="maincontent">
    <div class="clearfix page-action">
        <div class="row">
            <span style="text-align: center">
                <h3>Fast Moving Items</h3>
            </span>
            
            <table>
                <thead>
                    <tr>
                        <td>Code</td>
                        <td>Product Name</td>
                        <td>Category</td>
                        <td>Brand</td>
                        <td>Sub Brand</td>
                        <td>Sub Brand Series</td>
                        <td>Total Sales</td>
                    </tr>
                </thead>

                <tbody>
                    <?php $fastMovingItems = $inventoryDetail->getFastMovingItems($startDate, $endDate, $brandId, $subBrandId, $subBrandSeriesId, $productMasterCategoryId, $productSubMasterCategoryId, $productSubCategoryId); ?>
                    <?php foreach ($fastMovingItems as $fastMovingItem): ?>
                        <tr>
                            <td><?php echo CHtml::encode($fastMovingItem['code']); ?></td>
                            <td><?php echo CHtml::encode($fastMovingItem['product_name']); ?></td>
                            <td><?php echo CHtml::encode($fastMovingItem['category']); ?></td>
                            <td><?php echo CHtml::encode($fastMovingItem['brand']); ?></td>
                            <td><?php echo CHtml::encode($fastMovingItem['sub_brand']); ?></td>
                            <td><?php echo CHtml::encode($fastMovingItem['sub_brand_series']); ?></td>
                            <td><?php echo CHtml::encode($fastMovingItem['total_sale']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <hr />
        
        <div class="row">
            <span style="text-align: center">
                <h3>Slow Moving Items</h3>
            </span>
            
            <table>
                <thead>
                    <tr>
                        <td>Code</td>
                        <td>Product Name</td>
                        <td>Category</td>
                        <td>Brand</td>
                        <td>Sub Brand</td>
                        <td>Sub Brand Series</td>
                        <td>Total Sales</td>
                    </tr>
                </thead>

                <tbody>
                    <?php $slowMovingItems = $inventoryDetail->getSlowMovingItems($startDate, $endDate, $brandId, $subBrandId, $subBrandSeriesId, $productMasterCategoryId, $productSubMasterCategoryId, $productSubCategoryId); ?>
                    <?php foreach ($slowMovingItems as $slowMovingItem): ?>
                        <tr>
                            <td><?php echo CHtml::encode($slowMovingItem['code']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['product_name']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['category']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['brand']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['sub_brand']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['sub_brand_series']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['total_sale']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>