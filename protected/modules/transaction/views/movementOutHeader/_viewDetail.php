<fieldset>
    <legend>Details</legend>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Code</th>
                <th>Kategori</th>
                <th>Brand</th>
                <th>Sub Brand</th>
                <th>Sub Brand Series</th>
                <th>Warehouse</th>
                <th>Quantity Transaction</th>
                <th>Quantity</th>
                <th>Quantity On warehouse</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($details as $key => $detail): ?>
                <?php $product = $detail->product; ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'id')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?></td>
                    <td><?php echo $detail->warehouse == "" ? "" : $detail->warehouse->name ?></td>
                    <td><?php echo $detail->quantity_transaction; ?></td>
                    <td><?php echo $detail->quantity; ?></td>
                    <?php $stockInventory = Inventory::model()->findByAttributes(array('product_id' => $detail->product_id, 'warehouse_id' => $detail->warehouse_id)); ?>
                    <td><?php echo !empty($stockInventory) ? $stockInventory->total_stock : ''; ?></td>
                    <td><?php echo empty($stockInventory) ? 'N/A' : $stockInventory->total_stock > $detail->quantity ? 'V' : 'X'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>	