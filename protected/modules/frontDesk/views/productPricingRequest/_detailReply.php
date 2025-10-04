<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Nama</th>
        <th style="text-align: center">Brand</th>
        <th style="text-align: center">Category</th>
        <th style="text-align: center">Quantity</th>
        <th style="text-align: center">Recommended Price</th>
        <th style="text-align: center">Memo</th>
    </tr>
    <?php foreach ($productPricingRequest->details as $i => $detail): ?>
        <tr style="background-color: azure">
            <td><?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?></td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, 'brand.name')); ?> - 
                <?php echo CHtml::encode(CHtml::value($detail, 'subBrand.name')); ?> - 
                <?php echo CHtml::encode(CHtml::value($detail, 'subBrandSeries.name')); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, 'productMasterCategory.name')); ?> -
                <?php echo CHtml::encode(CHtml::value($detail, 'productSubMasterCategory.name')); ?> - 
                <?php echo CHtml::encode(CHtml::value($detail, 'productSubCategory.name')); ?>
            </td>
            <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?></td>
            <td style="width: 15%"><?php echo CHtml::activeTextField($detail, "[$i]recommended_price"); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
        </tr>
    <?php endforeach; ?>
</table>