<?php if (count($consignmentIn->details)): ?>
	<table>
		<thead>
			<tr>
				<th>Product</th>
				<th>Code</th>
				<th>Kategori</th>
				<th>Brand</th>
				<th>Sub Brand</th>
				<th>Sub Brand Series</th>
				<th>Quantity</th>
                <th>Unit</th>
				<th>Price</th>
				<th>Total Price</th>
				<th>Note</th>
				<th>Barcode Product</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($consignmentIn->details as $i => $detail): ?>
				<tr>
					<td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]product_id", array('size'=>20,'maxlength'=>20)); ?>
                        <?php echo CHtml::activeTextField($detail,"[$i]product_name", array(
                            'size'=>15,
                            'maxlength'=>10,
                            //'onclick' => '$("#product'.$i.'-dialog").dialog("open"); return false;',
                            'value' => $detail->product_id == "" ? '': Product::model()->findByPk($detail->product_id)->name
                        )); ?>
                        <?php echo CHtml::error($detail, 'product_id'); ?>
					</td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product.masterSubCategoryCode'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product.subBrand.name'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product.subBrandSeries.name'));  ?></td>
					<td>
                        <?php echo CHtml::activeTextField($detail,"[$i]quantity", array('size' => 3,
                            'onchange' => '
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $consignmentIn->header->id, 'index' => $i)) . '",
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#total_' . $i . '").html(data.total);
                                        $("#total_quantity").html(data.totalQuantity);
                                    },
                                });	
                            ',
                        ));?>
                        <?php echo CHtml::error($detail, 'quantity'); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product.unit.name'));  ?></td>
					<td>
                        <?php echo CHtml::activeTextField($detail,"[$i]price", array('size' => 3,
                            'onchange' => '
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $consignmentIn->header->id, 'index' => $i)) . '",
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#total_' . $i . '").html(data.total);
                                        $("#total_price").html(data.totalPrice);
                                    },
                                });	
                            ',
                        ));?>
                        <?php echo CHtml::error($detail, 'price'); ?>
                    </td>
					<td style="text-align: right">
						<?php echo CHtml::activeHiddenField($detail,"[$i]total_price");?>
                        <span id="total_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total_price')));  ?>
                        </span>
                        <?php echo CHtml::error($detail, 'total_price'); ?>
                    </td>
					<td>
                        <?php echo CHtml::activeTextField($detail,"[$i]note");?>
                        <?php echo CHtml::error($detail, 'note'); ?>
                    </td>
					<td>
                        <?php echo CHtml::activeTextField($detail,"[$i]barcode_product");?>
                        <?php echo CHtml::error($detail, 'barcode_product'); ?>
                    </td>
					<td>
						<?php echo CHtml::button('X', array(
						'onclick' => CHtml::ajax(array(
							'type' => 'POST',
							'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $consignmentIn->header->id, 'index' => $i)),
							'update' => '#product',
							)),
						)); ?>
					</td>
				</tr>	

				<?php Yii::app()->clientScript->registerScript('myjqueryCount'.$i,'
					$("#ConsignmentInDetail_'.$i.'_price,#ConsignmentInDetail_'.$i.'_quantity").keyup(function(event){
						$("#count_'.$i.'").click();
						$("#total-button").click();
					});
				'); ?>
			<?php endforeach ?>
		</tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="text-align: right">Total</td>
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($consignmentIn->header, 'total_quantity', array('readonly' => true)); ?>
                    <span id="total_quantity">
                        <?php echo CHtml::encode(CHtml::value($consignmentIn->header, 'total_quantity'));  ?>
                    </span>
                    <?php echo CHtml::error($consignmentIn->header, 'total_quantity'); ?>
                </td>
                <td colspan="3" style="text-align: right">
                    <?php echo CHtml::activeHiddenField($consignmentIn->header, 'total_price', array('id' => 'consignment_in_total_price_view', 'name' => 'view', 'readonly' => true, 'value' => $this->format_money($consignmentIn->header->total_price))); ?>
                    <span id="total_price">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($consignmentIn->header, 'total_price')));  ?>
                    </span>
                    <?php echo CHtml::error($consignmentIn->header, 'total_price'); ?>
                </td>
                <td colspan="3">&nbsp;</td>
            </tr>
        </tfoot>
	</table>
<?php endif ?>

