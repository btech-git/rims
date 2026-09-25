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
                        <?php if (isset($productLatestTransactionReportData[$product->id])): ?>
                            <?php echo CHtml::encode('Date Posting: ' . $productLatestTransactionReportData[$product->id]['date_posting']); ?>
                            <br />
                            <?php echo CHtml::encode('Movement Out No: ' . $productLatestTransactionReportData[$product->id]['movement_out_no']); ?>
                        <?php endif; ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>