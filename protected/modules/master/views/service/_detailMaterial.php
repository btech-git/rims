<table class="items">
	<thead>
	<tr>
		<th>Material</th>
		<th>Easy</th>
		<th>Medium</th>
		<th>Hard</th>
		<th></th>
		<!-- <th><a href="#" class="sort-link">Level</a></th>
		<th><a href="#" class="sort-link"></a></th> -->
	</tr>
	</thead>
	<tbody >
		<?php foreach ($service->materialDetails as $i => $materialDetail): ?>
			<tr>
				<td>
					<?php echo CHtml::activeHiddenField($materialDetail,"[$i]product_id"); ?>
					<?php $product = Product::model()->findByPK($materialDetail->product_id); ?>
					<?php echo CHtml::activeTextField($materialDetail,"[$i]material_name",array('value'=>$materialDetail->product_id!= '' ? $product->name : '','readonly'=>true )); ?>
				</td>
				<td>
					<?php echo CHtml::activeHiddenField($materialDetail, "[$i]easy"); ?>
					<?php echo CHtml::activeTextField($materialDetail,"[$i]easy"); ?>
					<?php //echo CHtml::activeTextField($priceDetail,"[$i]supplier_id"); ?>
				</td>
				<td>
					<?php echo CHtml::activeHiddenField($materialDetail, "[$i]medium"); ?>
					<?php echo CHtml::activeTextField($materialDetail,"[$i]medium"); ?>
					<?php //echo CHtml::activeTextField($priceDetail,"[$i]supplier_id"); ?>
				</td>
				<td>
					<?php echo CHtml::activeHiddenField($materialDetail, "[$i]hard"); ?>
					<?php echo CHtml::activeTextField($materialDetail,"[$i]hard"); ?>
					<?php //echo CHtml::activeTextField($priceDetail,"[$i]supplier_id"); ?>
				</td>
				<td>
					<?php
				    echo CHtml::button('X', array(
				     	'onclick' => CHtml::ajax(array(
					       	'type' => 'POST',
					       	'url' => CController::createUrl('ajaxHtmlRemoveMaterialDetail', array('id' => $service->header->id, 'index' => $i)),
					       	'update' => '#material',
			      		)),
			     	));
		     	?>
				</td>
			</tr>
		<?php endforeach ?>
		
	</tbody>
</table>