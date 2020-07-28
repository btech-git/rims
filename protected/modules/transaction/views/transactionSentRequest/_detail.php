<?php if (count($sentRequest->details)): ?>
	<table>
		<thead>
			<tr>
				<th>Product</th>
				<td>Code</td>
				<td>Kategori</td>
				<td>Brand</td>
				<td>Sub Brand</td>
				<td>Sub Brand Series</td>
				<th>Quantity</th>
				<th>Unit</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($sentRequest->details as $i => $detail): ?>
				<tr>
					<td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]product_id", array('size'=>20,'maxlength'=>20)); ?>
                        <?php echo CHtml::activeTextField($detail,"[$i]product_name", array(
                            'size'=>15,
                            'maxlength'=>10,
                            'value' => $detail->product_id == "" ? '': Product::model()->findByPk($detail->product_id)->name
                        )); ?>
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
                                    url: "' . CController::createUrl('ajaxJsonTotal', array('id' => $sentRequest->header->id, 'index' => $i)) . '",
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#total_quantity").html(data.totalQuantity);
                                    },
                                });	
                            ',
                        ));?>
                    </td>
					<td>
                        <?php echo CHtml::activeHiddenField($detail,"[$i]unit_id");?>
                        <?php echo CHtml::encode(CHtml::value($detail, 'unit.name'));  ?>
                    </td>
					<td style="width: 5%">
						<?php echo CHtml::button('X', array(
						'onclick' => CHtml::ajax(array(
							'type' => 'POST',
							'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $sentRequest->header->id, 'index' => $i)),
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
                <td colspan="6" style="text-align: right">Total Quantity</td>
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($sentRequest->header, "total_quantity");?>
                    <span id="total_quantity">
                        <?php echo CHtml::encode(CHtml::value($sentRequest->header, 'total_quantity'));  ?>
                    </span>
                </td>
                <td colspan="2">&nbsp;</td>
            </tr>
        </tfoot>
	</table>
<?php endif ?>

