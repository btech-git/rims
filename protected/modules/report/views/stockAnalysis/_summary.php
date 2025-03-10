<div id="maincontent">
    <div class="clearfix page-action">
        <div class="row">
            <span style="text-align: center">
                <?php $branch = Branch::model()->findByPk($branchId); ?>
                <h3>Fast Moving Items <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></h3>
            </span>
            
            <table>
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Code</td>
                        <td>Product Name</td>
                        <td>Category</td>
                        <td>Brand</td>
                        <td>Sub Brand</td>
                        <td>Sub Brand Series</td>
                        <td>Qty Sales</td>
                        <!--<td>Total</td>-->
                    </tr>
                </thead>

                <tbody>
                    <?php $fastMovingItems = $inventoryDetail->getFastMovingItems($startDate, $endDate, $brandId, $subBrandId, $subBrandSeriesId, $productMasterCategoryId, $productSubMasterCategoryId, $productSubCategoryId, $branchId, $productId, $productCode, $productName); ?>
                    <?php foreach ($fastMovingItems as $fastMovingItem): ?>
                        <tr>
                            <td><?php echo CHtml::encode($fastMovingItem['id']); ?></td>
                            <td><?php echo CHtml::encode($fastMovingItem['code']); ?></td>
                            <td><?php echo CHtml::encode($fastMovingItem['product_name']); ?></td>
                            <td><?php echo CHtml::encode($fastMovingItem['category']); ?></td>
                            <td><?php echo CHtml::encode($fastMovingItem['brand']); ?></td>
                            <td><?php echo CHtml::encode($fastMovingItem['sub_brand']); ?></td>
                            <td><?php echo CHtml::encode($fastMovingItem['sub_brand_series']); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $fastMovingItem['total_sale'])); ?></td>
                            <!--<td style="text-align: right"><?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $fastMovingItem['sale_price'])); ?></td>-->
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
                        <td>ID</td>
                        <td>Code</td>
                        <td>Product Name</td>
                        <td>Category</td>
                        <td>Brand</td>
                        <td>Sub Brand</td>
                        <td>Sub Brand Series</td>
                        <td>Qty Sales</td>
                        <!--<td>Total</td>-->
                    </tr>
                </thead>

                <tbody>
                    <?php $slowMovingItems = $inventoryDetail->getSlowMovingItems($startDate, $endDate, $brandId, $subBrandId, $subBrandSeriesId, $productMasterCategoryId, $productSubMasterCategoryId, $productSubCategoryId, $productId, $productCode, $productName); ?>
                    <?php foreach ($slowMovingItems as $slowMovingItem): ?>
                        <tr>
                            <td><?php echo CHtml::encode($slowMovingItem['id']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['code']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['product_name']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['category']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['brand']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['sub_brand']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['sub_brand_series']); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $slowMovingItem['total_sale'])); ?></td>
                            <!--<td style="text-align: right"><?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $slowMovingItem['sale_price'])); ?></td>-->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>