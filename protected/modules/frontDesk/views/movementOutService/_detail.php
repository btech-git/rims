<table style="border: 1px solid">
    <thead>
        <tr style="background-color: skyblue">
            <th>Service</th>
            <th>Product</th>
            <th>Code</th>
            <th>Kategori</th>
            <th>Brand</th>
            <th>Sub Brand</th>
            <th>Sub Brand Series</th>
            <th class="required">Warehouse</th>
            <th>Std Qty</th>
            <th class="required" style="width: 5%">Quantity</th>
            <th style="text-align: center; width: 5%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($movementOut->details as $i => $detail): ?>
            <?php 
            $branchId = isset($_POST['MovementOutHeader']['branch_id'])? $_POST['MovementOutHeader']['branch_id'] : $movementOut->header->branch_id; 
            $warehouses = Warehouse::model()->findAllByAttributes(array('branch_id'=>$branchId));
            $list = CHtml::listData($warehouses, 'id', 'name');
            $product = Product::model()->findByPK($detail->product_id);
            $serviceProduct = ServiceProduct::model()->findByAttributes(array('service_id' => $detail->registrationService->service_id, 'product_id' => $detail->product_id))
            ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'registrationService.service.name'));  ?></td>
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]registration_service_id"); ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($product, 'name'));  ?>
                    <?php //echo CHtml::activeTextField($detail, "[$i]product_name", array('size'=>20,'maxlength'=>20,'readonly'=>true,'value'=>$detail->product_id != "" ? $detail->product->name : '')); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code'));  ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode'));  ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'brand.name'));  ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand.name'));  ?></td>
                <td><?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name'));  ?></td>
                <td>
                    <?php echo CHtml::activeDropDownList($detail,"[$i]warehouse_id", $list, array('prompt' => '[--Select Warehouse--]')); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($serviceProduct, 'quantity', array('size' => 3, 'maxLength' => 10)));  ?></td>
                <td><?php echo CHtml::activeTextField($detail,"[$i]quantity", array('class'=>'qtyleft_input productID_'.$detail->product_id, 'rel'=>$detail->product_id));?></td>
                <td>
                    <?php echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $movementOut->header->id, 'index' => $i)),
                            'update' => '#delivery',
                        )),
                    )); ?>
                </td>
            </tr>	
        <?php endforeach; ?>
    </tbody>
</table>