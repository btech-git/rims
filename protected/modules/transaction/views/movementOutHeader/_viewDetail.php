<fieldset>
    <legend>Details</legend>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Code</th>
                <th>Tahun</th>
                <th>Warehouse</th>
                <th>Quantity Stock</th>
                <th>Satuan Stock</th>
                <th>Quantity Transaction</th>
                <th>Quantity</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($details as $key => $detail): ?>
                <?php $product = $detail->product; ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'id')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'production_year')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'warehouse.code')); ?></td>
                    <td><?php echo $detail->quantity_stock; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?></td>
                    <td><?php echo $detail->quantity_transaction; ?></td>
                    <td><?php echo $detail->quantity; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?></td>
                </tr>
                <tr>
                    <td colspan="10">
                        <?php echo CHtml::encode(CHtml::value($product, 'productMasterCategory.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'productSubMasterCategory.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'productSubCategory.name')); ?> || 
                        <?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?>
                    </td>
                        
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>	