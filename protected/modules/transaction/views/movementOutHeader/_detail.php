<?php $detailIdsString = trim($movementOut->header->detailIdsToBeDeleted, ','); ?>
<?php $detailIdsToBeDeleted = empty($detailIdsString) ? array() : explode(',', $detailIdsString); ?>

<?php if (!empty($movementOut->details)): ?>
    <table>
        <thead>
            <tr>
                <th class="required">ID</th>
                <th class="required">Product</th>
                <th>Code</th>
                <th>Tahun</th>
                <th class="required">Warehouse</th>
                <th class="required">Qty Stock</th>
                <th class="required">Satuan Stock</th>
                <th class="required">Qty Req</th>
                <th class="required">Qty Out</th>
                <th class="required">Satuan Request</th>
                <th>Action</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($movementOut->details as $i => $detail): ?>
                <?php $product = Product::model()->findByPK($detail->product_id); ?>
                <tr style="<?php if (in_array($detail->id, $detailIdsToBeDeleted)): ?>display: none<?php endif; ?>">
                    <td><?php echo CHtml::encode(CHtml::value($detail, "product_id")); ?></td>
                    <td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]delivery_order_detail_id"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]return_order_detail_id"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]registration_product_id"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]material_request_detail_id"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                        <?php echo CHtml::activeTextField($detail, "[$i]product_name", array(
                            'size' => 20, 
                            'maxlength' => 20, 
                            'readonly' => true, 
                            'value' => $detail->product_id != "" ? $detail->product->name : ''
                        )); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                    <td>
                        <?php echo CHtml::activeDropdownList($detail, "[$i]production_year", $yearList, array(
                            'empty' => '-- Pilih Tahun --', 
                            'disabled' => $product->product_sub_master_category_id != 26,
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]warehouse_id"); ?>
                        <?php echo CHtml::encode(CHtml::value($detail, "warehouse.code")); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]quantity_stock"); ?>
                        <?php echo CHtml::encode(CHtml::value($detail, 'quantity_stock')); ?>
                        <?php echo CHtml::error($detail, 'quantity_stock'); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::encode(CHtml::value($detail, 'product.unit.name')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]quantity_transaction"); ?>
                        <?php echo CHtml::encode(CHtml::value($detail, 'quantity_transaction')); ?>
                    </td>
                    <td>
                        <?php if ($movementOut->header->isNewRecord): ?>
                            <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                                'class' => 'qtyleft_input productID_' . $detail->product_id, 
                                'rel' => $detail->product_id,
                                'onchange'=> '
                                    var qty = +jQuery("#MovementOutDetail_'.$i.'_quantity").val();
                                    var temp = +jQuery("#MovementOutDetail_'.$i.'_quantity_transaction").val();
                                    var count = temp - qty;

                                    if (count < 0) {
                                        alert("QTY Movement could not be less than QTY LEFT.");
                                        $( "#save" ).prop( "disabled", true );
                                    } else {
                                        $( "#save" ).prop( "disabled", false );
                                    }
                                ',
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::activeTextField($detail, "[$i]quantity"); ?> 
                        <?php endif; ?>
                        <?php echo CHtml::error($detail, 'quantity'); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::activeHiddenField($detail, "[$i]unit_id"); ?> 
                        <?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?>
                        <?php echo CHtml::error($detail, 'unit_id'); ?>
                    </td>
                    <td>
                        <?php echo CHtml::button('Delete', array(
                            'onclick' => (!empty($detail->id) ? '
                                var detailId = ' . $detail->id . ';
                                var idsInput = $("#' . CHtml::activeId($movementOut->header, 'detailIdsToBeDeleted') . '");
                                idsInput.val(idsInput.val() + "," + detailId);
                                var row = $(this).closest("tr");
                                row.hide();
                                row.next().hide();
                            ' : CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('AjaxHtmlRemoveDetail', array('id' => $movementOut->header->id, 'index' => $i)),
                                'update' => '#detail_div',
                            ))),
                        )); ?>
                    </td>
                </tr>	
                <tr style="<?php if (in_array($detail->id, $detailIdsToBeDeleted)): ?>display: none<?php endif; ?>">
                    <td colspan="12">
                        <?php echo CHtml::encode(CHtml::value($product, 'productMasterCategory.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'productSubMasterCategory.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'productSubCategory.name')); ?> || 
                        <?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>