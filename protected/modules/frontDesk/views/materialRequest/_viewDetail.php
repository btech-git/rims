<?php $materialRequestDetails = $model->materialRequestDetails; ?>
<?php if (count($materialRequestDetails) > 0): ?>
    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Product</td>
                <td>Code</td>
                <td>Kategori</td>
                <td>Brand</td>
                <td>Quantity</td>
                <td>Satuan Req</td>
                <td>Satuan Inv</td>
                <td>COA</td>
                <td>HPP</td>
                <td>Total</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materialRequestDetails as $key => $materialRequestDetail): ?>
                <?php $product = empty($materialRequestDetail->product_id) ? '' : $materialRequestDetail->product; ?>
                <tr>
                    <td><?php echo $product->id; ?></td>
                    <td><?php echo $product->name; ?></td>
                    <td><?php echo $product->manufacturer_code; ?></td>
                    <td><?php echo $product->masterSubCategoryCode; ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?>
                    </td>
                    <td style="text-align: center"><?php echo number_format($materialRequestDetail->quantity, 2); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($materialRequestDetail, 'unit.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($materialRequestDetail, 'product.unit.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'productSubMasterCategory.coaPersediaanBarangDagang.name')); ?></td>
                    <td style="text-align: right"><?php echo number_format($materialRequestDetail->product->hpp, 2); ?></td>
                    <td style="text-align: right"><?php echo number_format($materialRequestDetail->totalProductPrice, 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" style="text-align: right;">Total</td>
                <td style="text-align: center;"><?php echo number_format($model->totalQuantity, 2); ?></td>
                <td style="text-align: right;" colspan="5"><?php echo number_format($model->totalPrice, 2); ?></td>
            </tr>
        </tfoot>
    </table>
<?php else: ?>
    <?php echo "No Detail Available!"; ?>
<?php endif; ?>