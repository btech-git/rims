<table style="border: 1px solid">
    <thead>
        <tr style="background-color: skyblue">
            <th>Product</th>
            <th>Code</th>
            <th>Kategori</th>
            <th>Brand</th>
            <th>Sub Brand</th>
            <th>Sub Brand Series</th>
            <th class="required">Warehouse</th>
            <th class="required" style="width: 5%">Quantity</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($movementOut->details as $i => $detail): ?>
            <?php $product = $detail->product; ?>
            <tr>
                <td>
                    <?php echo CHtml::encode(CHtml::value($product, 'name'));  ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code'));  ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode'));  ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'brand.name'));  ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand.name'));  ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name'));  ?></td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($detail, 'warehouse.name')); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'quantity'));  ?></td>
            </tr>	
        <?php endforeach; ?>
    </tbody>
</table>