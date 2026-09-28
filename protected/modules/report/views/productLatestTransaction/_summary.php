<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Penjualan Parts & Components Bulanan</div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr>
                <th style="width: 10px">No.</th>
                <th style="width: 300px">Code</th>
                <th style="width: 300px">Product</th>
                <th style="width: 300px">Brand</th>
                <th style="width: 300px">Kategori</th>
                <th style="width: 300px">Satuan</th>
                <th style="text-align: center">Movement Out</th>
                <th style="text-align: center">Movement In</th>
                <th style="text-align: center">Penjualan</th>
                <th style="text-align: center">Pembelian</th>
            </tr>
        </thead>
        <tbody>
            <?php $ordinal = 0; ?>
            <?php foreach ($productDataProvider->data as $product): ?>
                <tr>
                    <td style="text-align: center"><?php echo ++$ordinal; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'brand.name')) . ' - ' . CHtml::encode(CHtml::value($product, 'subBrand.name')) . ' - ' . CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'productMasterCategory.name')) . ' - ' . CHtml::encode(CHtml::value($product, 'productSubMasterCategory.name')) . ' - ' . CHtml::encode(CHtml::value($product, 'productSubCategory.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?></td>
                    <td>
                        <?php if (isset($movementOutProductLatestTransactionReportData[$product->id])): ?>
                            <?php echo CHtml::encode('Transaction #: ' . $movementOutProductLatestTransactionReportData[$product->id]['movement_out_no']); ?>
                            <br />
                            <?php echo CHtml::encode('Date: ' . $movementOutProductLatestTransactionReportData[$product->id]['date_posting']); ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (isset($movementInProductLatestTransactionReportData[$product->id])): ?>
                            <?php echo CHtml::encode('Transaction #: ' . $movementInProductLatestTransactionReportData[$product->id]['movement_in_number']); ?>
                            <br />
                            <?php echo CHtml::encode('Date: ' . $movementInProductLatestTransactionReportData[$product->id]['date_posting']); ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (isset($saleProductLatestTransactionReportData[$product->id])): ?>
                            <?php echo CHtml::encode('Transaction #: ' . $saleProductLatestTransactionReportData[$product->id]['invoice_number']); ?>
                            <br />
                            <?php echo CHtml::encode('Date: ' . $saleProductLatestTransactionReportData[$product->id]['invoice_date']); ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (isset($purchaseProductLatestTransactionReportData[$product->id])): ?>
                            <?php echo CHtml::encode('Transaction #: ' . $purchaseProductLatestTransactionReportData[$product->id]['purchase_order_no']); ?>
                            <br />
                            <?php echo CHtml::encode('Date: ' . $purchaseProductLatestTransactionReportData[$product->id]['purchase_order_date']); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>