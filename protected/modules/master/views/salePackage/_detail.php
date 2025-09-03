<table style="border: 1px solid">
    <thead>
        <tr style="background-color: skyblue">
            <th>Name</th>
            <th>Code</th>
            <th>Deskripsi</th>
            <th class="required" style="width: 5%">Quantity</th>
            <th class="required" style="width: 5%">Satuan</th>
            <th class="required" style="width: 5%">Harga</th>
            <th style="text-align: center; width: 5%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($salePackage->details as $i => $detail): ?>
            <?php if (empty($detail->product_id)): ?>
                <?php $service = Service::model()->findByPK($detail->service_id); ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]service_id"); ?>
                        <?php echo CHtml::encode(CHtml::value($service, 'name'));  ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($service, 'code')); ?></td>
                    <td>
                        <?php /*echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name'));*/ ?> 
                    </td>
                    <td><?php echo CHtml::activeTextField($detail,"[$i]quantity"); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($service, 'unit.name')); ?></td>
                    <td>
                        <?php echo CHtml::activeHiddenField($detail,"[$i]price"); ?>
                        <?php echo CHtml::encode(CHtml::value($detail, 'price')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $salePackage->header->id, 'index' => $i)),
                                'update' => '#detail_div',
                            )),
                        )); ?>
                    </td>
                </tr>
            <?php else: ?>
                <?php $product = Product::model()->findByPK($detail->product_id); ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                        <?php echo CHtml::encode(CHtml::value($product, 'name'));  ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?> 
                    </td>
                    <td><?php echo CHtml::activeTextField($detail,"[$i]quantity"); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?></td>
                    <td>
                        <?php echo CHtml::activeHiddenField($detail,"[$i]price"); ?>
                        <?php echo CHtml::encode(CHtml::value($detail, 'price')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $salePackage->header->id, 'index' => $i)),
                                'update' => '#detail_div',
                            )),
                        )); ?>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>