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
            <th class="required" style="width: 5%">Satuan</th>
            <th style="text-align: center; width: 5%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($movementOut->details as $i => $detail): ?>
            <?php $product = Product::model()->findByPK($detail->product_id); ?>
            <tr>
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($product, 'name'));  ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code'));  ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode'));  ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'brand.name'));  ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand.name'));  ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name'));  ?></td>
                <td><?php echo CHtml::activeDropDownList($detail,"[$i]warehouse_id", CHtml::listData(Warehouse::model()->findAll(), 'id', 'code'), array('prompt' => '[--Select--]')); ?></td>
                <td><?php echo CHtml::activeTextField($detail,"[$i]quantity");?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name'));  ?></td>
                <td>
                    <?php echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $movementOut->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                </td>
            </tr>	
        <?php endforeach; ?>
    </tbody>
</table>