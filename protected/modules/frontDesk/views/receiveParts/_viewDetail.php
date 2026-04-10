<?php if (count($receivePartsDetails) > 0): ?>
    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Product</td>
                <td>Code</td>
                <td>Kategori</td>
                <td>Brand</td>
                <td>Quantity</td>
                <td>Quantity Movement</td>
                <td>Quantity Movement Left</td>
                <td>Satuan</td>
                <td>Memo</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($receivePartsDetails as $key => $receivePartsDetail): ?>
                <?php $product = empty($receivePartsDetail->product_id) ? '' : $receivePartsDetail->product; ?>
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
                    <td style="text-align: center"><?php echo number_format($receivePartsDetail->quantity, 2); ?></td>
                    <td style="text-align: center"><?php echo number_format($receivePartsDetail->quantity_movement, 2); ?></td>
                    <td style="text-align: center"><?php echo number_format($receivePartsDetail->quantity_movement_left, 2); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($receivePartsDetail, 'product.unit.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($receivePartsDetail, 'memo')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <?php echo "No Detail Available!"; ?>
<?php endif; ?>