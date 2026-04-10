<?php
$movementOuts = MovementOutHeader::model()->findAllByAttributes(array('material_request_header_id' => $receiveParts->id));
if (count($movementOuts) != 0) {
    foreach ($movementOuts as $key => $movementOut) :
        ?>
        <table>
            <tr>
                <td width="20%">Movement Out No</td>
                <td><?php echo CHTml::link($movementOut->movement_out_no, array("/transaction/movementOutHeader/show", "id" => $movementOut->id), array('target' => 'blank')); ?></td>
            </tr>
            <tr>
                <td  width="20%">Date</td>
                <td><?php echo $movementOut->date_posting; ?></td>
            </tr>
            <tr>
                <td  width="20%">Branch</td>
                <td><?php echo $movementOut->branch->name; ?></td>
            </tr>
            <tr>
                <td  width="20%">Status</td>
                <td><?php echo $movementOut->status; ?></td>
            </tr>
            <tr>
                <td colspan="3">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Code</th>
                                <th>Kategori</th>
                                <th>Brand</th>
                                <th>Warehouse</th>
                                <th>Quantity Transaction</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($movementOut->movementOutDetails as $detail) : ?>
                                <tr>
                                    <td><?php echo $detail->product->name; ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')); ?></td>
                                    <td>
                                        <?php echo CHtml::encode(CHtml::value($detail, 'product.productMasterCategory.name')); ?> - 
                                        <?php echo CHtml::encode(CHtml::value($detail, 'product.productMasterSubCategory.name')); ?> - 
                                        <?php echo CHtml::encode(CHtml::value($detail, 'product.productSubCategory.name')); ?>
                                    </td>
                                    <td>
                                        <?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name')); ?> - 
                                        <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrand.name')); ?> - 
                                        <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrandSeries.name')); ?>
                                    </td>
                                    <td><?php echo $detail->warehouse == "" ? "" : $detail->warehouse->name ?></td>
                                    <td><?php echo $detail->quantity_transaction; ?></td>
                                    <td><?php echo $detail->quantity; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    <?php endforeach; ?>

<?php
}
else {
    echo "NO HISTORY FOUND.";
}
?>