<div id="maincontent">
    <div class="clearfix page-action">
        <?php $numberOfMonths = floor($numberOfDays / 30); ?>
        <?php $numberOfWeeks = floor($numberOfDays / 7); ?>
        <div class="row">
            <span style="text-align: center">
                <?php $branch = Branch::model()->findByPk($branchId); ?>
                <h2>Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></h2>
                <h3>Analisa Penjualan Barang</h3>
                <div><?php echo CHtml::encode($year); ?></div>
            </span>
            
            <hr />
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <?php for ($month = 1; $month <= 12; $month++): ?>
                            <th><?php echo CHtml::encode($monthList[$month]); ?></th>
                        <?php endfor; ?>
                        <th>Total Sales</th>
                        <th>Average / bulan</th>
                        <th>Average / minggu</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 0; ?>
                    <?php foreach ($fastMovingItemsData as $productId => $fastMovingItem): ?>
                        <tr>
                            <td><?php echo CHtml::encode(++$i); ?></td>
                            <td><?php echo CHtml::encode($productId); ?></td>
                            <td><?php echo CHtml::encode($fastMovingItem['code']); ?></td>
                            <td><?php echo CHtml::encode($fastMovingItem['product_name']); ?></td>
                            <td><?php echo CHtml::encode($fastMovingItem['category']); ?></td>
                            <td>
                                <?php echo CHtml::encode($fastMovingItem['brand']); ?> - 
                                <?php echo CHtml::encode($fastMovingItem['sub_brand']); ?> - 
                                <?php echo CHtml::encode($fastMovingItem['sub_brand_series']); ?>
                            </td>
                            <?php $totalSaleSum = '0.00'; ?>
                            <?php for ($month = 1; $month <= 12; $month++): ?>
                                <?php $totalSale = isset($fastMovingItem['total_sale'][$month]) ? $fastMovingItem['total_sale'][$month] : ''; ?>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?>
                                </td>
                                <?php $totalSaleSum += $totalSale; ?>
                            <?php endfor; ?>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalSaleSum)); ?>
                            </td>
                            <td style="text-align: right">
                                <?php $numberOfMonths = $numberOfMonths == 0 ? 1 : $numberOfMonths; ?>
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalSaleSum / $numberOfMonths)); ?>
                            </td>
                            <td style="text-align: right">
                                <?php $numberOfWeeks = $numberOfWeeks == 0 ? 1 : $numberOfWeeks; ?>
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalSaleSum / $numberOfWeeks)); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
<!--        <hr />
        
        <div class="row">
            <span style="text-align: center">
                <h3>Slow Moving Items</h3>
            </span>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Sub Brand</th>
                        <th>Sub Brand Series</th>
                        <th>Qty Sales</th>
                        <th>Average / bulan</th>
                        <th>Average / minggu</th>
                    </tr>
                </thead>

                <tbody>
                    <?php /*$slowMovingItems = $inventoryDetail->getSlowMovingItems($startDate, $endDate, $brandId, $subBrandId, $subBrandSeriesId, $productMasterCategoryId, $productSubMasterCategoryId, $productSubCategoryId, $branchId, $productId, $productCode, $productName); ?>
                    <?php foreach ($slowMovingItems as $i => $slowMovingItem): ?>
                        <tr>
                            <td><?php echo CHtml::encode($i + 1); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['id']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['code']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['product_name']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['category']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['brand']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['sub_brand']); ?></td>
                            <td><?php echo CHtml::encode($slowMovingItem['sub_brand_series']); ?></td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $slowMovingItem['total_sale'])); ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $slowMovingItem['total_sale'] / $numberOfMonths)); ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $slowMovingItem['total_sale'] / $numberOfWeeks)); ?>
                            </td>
                        </tr>
                    <?php endforeach;*/ ?>
                </tbody>
            </table>
        </div>-->
    </div>
</div>