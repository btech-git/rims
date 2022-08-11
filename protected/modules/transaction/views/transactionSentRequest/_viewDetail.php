<?php if (count($sentDetails) > 0): ?>
    <table>
        <thead>
            <tr>
                <td>Product</td>
                <td>Code</td>
                <td>Kategori</td>
                <td>Brand</td>
                <td>Sub Brand</td>
                <td>Sub Brand Series</td>
                <td>Quantity</td>
                <td>Unit</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sentDetails as $key => $sentDetail): ?>
                <?php $product = $sentDetail->product; ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?></td>
                    <td><?php echo $sentDetail->quantity; ?></td>
                    <td><?php echo $sentDetail->unit->name; ?></td>

                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

<?php else: ?>
    <?php echo "No Detail Available!"; ?>
    	<?php endif ?>