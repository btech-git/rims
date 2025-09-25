<?php if (count($transferDetails) > 0): ?>
    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Product</td>
                <td>Code</td>
                <td>Kategori</td>
                <td>Brand</td>
                <td>Quantity</td>
                <td>Satuan</td>
                <td>Posisi Stok</td>
                <td>Rata2 Penjualan</td>
                <td>Stok Min</td>
                <td>Memo</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transferDetails as $key => $transferDetail): ?>
                <tr>
                    <td><?php echo CHtml::link($transferDetail->product_id, array("/frontDesk/inventory/detail", "id"=>$transferDetail->product_id, 'endDate' => date('Y-m-d)')), array('target' => 'blank')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($transferDetail, 'product.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($transferDetail, 'product.manufacturer_code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($transferDetail, 'product.masterSubCategoryCode')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($transferDetail, 'product.brand.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($transferDetail, 'product.subBrand.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($transferDetail, 'product.subBrandSeries.name')); ?>
                    </td>
                    <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($transferDetail, 'quantity')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($transferDetail, 'unit.name')); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($transferDetail, 'stock_quantity')); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($transferDetail, 'average_sale_amount')); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($transferDetail, 'product.minimum_stock')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($transferDetail, 'memo')); ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align: right; font-weight: bold">Total</td>
                <td style="text-align: center; font-weight: bold"><?php echo $model->total_quantity; ?></td>
                <td colspan="5">&nbsp;</td>
            </tr>
        </tfoot>
    </table>
<?php else: ?>
    <?php echo "No Detail Available!"; ?>
<?php endif; ?>