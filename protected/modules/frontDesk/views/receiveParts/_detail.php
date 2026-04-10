<table style="border: 1px solid">
    <thead>
        <tr style="background-color: skyblue">
            <th>Product</th>
            <th>Code</th>
            <th>Kategori</th>
            <th>Brand</th>
            <th style="width: 10%">Quantity WO</th>
            <th class="required" style="width: 10%">Quantity</th>
            <th style="width: 5%">Satuan</th>
            <th style="width: 20%">Memo</th>
            <th style="text-align: center; width: 5%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($receiveParts->details as $i => $detail): ?>
            <?php $product = Product::model()->findByPK($detail->product_id); ?>
            <tr>
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]registration_product_id"); ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($product, 'name'));  ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code'));  ?></td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($product, 'productMasterCategory.name'));  ?> -
                    <?php echo CHtml::encode(CHtml::value($product, 'productSubMasterCategory.name'));  ?> -
                    <?php echo CHtml::encode(CHtml::value($product, 'productSubCategory.name'));  ?>
                </td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($product, 'brand.name'));  ?> -
                    <?php echo CHtml::encode(CHtml::value($product, 'subBrand.name'));  ?> -
                    <?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name'));  ?>
                </td>
                <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'registrationProduct.quantity'));  ?></td>
                <td><?php echo CHtml::activeTextField($detail,"[$i]quantity");?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name'));  ?></td>
                <td><?php echo CHtml::activeTextField($detail,"[$i]memo");?></td>
                <td>
                    <?php echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $receiveParts->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                </td>
            </tr>	
        <?php endforeach; ?>
    </tbody>
</table>