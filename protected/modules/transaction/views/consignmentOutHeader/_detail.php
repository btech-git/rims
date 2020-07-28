<?php if (count($consignmentOut->details)): ?>
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
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($consignmentOut->details as $i => $detail): ?>
				<tr>
					<td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]product_id", array('size'=>20,'maxlength'=>20)); ?>
                        <?php echo CHtml::activeTextField($detail,"[$i]product_name", array(
                            'size'=>15,
                            'maxlength'=>10,
                            //'onclick' => '$("#product'.$i.'-dialog").dialog("open"); return false;',
                            'value' => $detail->product_id == "" ? '': Product::model()->findByPk($detail->product_id)->name
                        )); ?>
					</td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product.masterSubCategoryCode'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product.subBrand.name'));  ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product.subBrandSeries.name'));  ?></td>
					<td><?php echo CHtml::activeTextField($detail,"[$i]quantity");?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product.unit.name'));  ?></td>
					<td><?php echo CHtml::activeTextField($detail,"[$i]sale_price");?></td>
					<td>
                        <?php echo CHtml::button('Count', array(
							'id' => 'count_'.$i,
							'style'=>'display:none;',
							'onclick' =>'
								var qty = +$("#ConsignmentOutDetail_'.$i.'_quantity").val();
								var price = +$("#ConsignmentOutDetail_'.$i.'_sale_price").val();

								var total = qty * price;
								$("#ConsignmentOutDetail_'.$i.'_total_price").val(total);
								console.log(total);
							')); ?>
						<?php echo CHtml::activeTextField($detail,"[$i]total_price");?>
                    </td>
					<td>
						<?php echo CHtml::button('X', array(
						'onclick' => CHtml::ajax(array(
							'type' => 'POST',
							'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $consignmentOut->header->id, 'index' => $i)),
							'update' => '#product',
							)),
						)); ?>
					</td>
				</tr>	

				<?php
				Yii::app()->clientScript->registerScript('myjqueryCount'.$i,'
					$("#ConsignmentOutDetail_'.$i.'_sale_price, #ConsignmentOutDetail_'.$i.'_quantity").keyup(function(event){
						$("#count_'.$i.'").click();
						$("#total-button").click();
					});
				');
				?>
			<?php endforeach ?>
		</tbody>
	</table>
<?php endif ?>
