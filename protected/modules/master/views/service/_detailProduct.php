<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Code</th>
        <th style="text-align: center">Name</th>
        <th style="text-align: center;">Category</th>
        <th style="text-align: center;">Brand</th>
        <th style="text-align: center;">Qty Std</th>
        <th style="text-align: center;">Unit</th>
        <th></th>
    </tr>
    <?php foreach ($service->productDetails as $i => $detail): ?>	
        <tr style="background-color: azure;">
            <td style="text-align:center;">
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')); ?>
            </td>
            <td style="text-align:center;">
                <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?>
            </td>
            <td style="text-align:center;">
                <?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name')); ?> -
                <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrand.name')); ?> - 
                <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrandSeries.name')); ?>
            </td>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($detail, 'product.productMasterCategory.name')); ?> -
                <?php echo CHtml::encode(CHtml::value($detail, 'product.productSubMasterCategory.name')); ?> -
                <?php echo CHtml::encode(CHtml::value($detail, 'product.productSubCategory.name')); ?>
            </td>
            <td style="text-align:center;">
                <?php echo CHtml::activeTextField($detail, "[$i]quantity"); ?>
            </td>
            <td style="text-align:center;">
                <?php echo CHtml::activeHiddenField($detail, "[$i]unit_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?>
            </td>
            <td>
                <?php echo CHtml::activeDropDownList($detail, 'status', array (
                    'Active' => 'Active',
                    'Inactive' => 'Inactive',
                )); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>