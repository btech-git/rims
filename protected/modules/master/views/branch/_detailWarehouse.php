<table class="items">
			<thead>
			<tr>
				<th colspan="2">Warehouse</th>
				<!-- <th><a href="#" class="sort-link">Level</a></th>
				<th><a href="#" class="sort-link"></a></th> -->
			</tr>
			</thead>
			<tbody >
			
			
				<?php foreach ($branch->warehouseDetails as $i => $warehouseDetail): ?>
					<tr>
						<td><?php echo CHtml::activeHiddenField($warehouseDetail,"[$i]warehouse_id"); ?>
						<?php $warehouse = Warehouse::model()->findByPK($warehouseDetail->warehouse_id); ?>
						<?php echo CHtml::activeTextField($warehouseDetail,"[$i]warehouse_name",array('value'=>$warehouseDetail->warehouse_id!= '' ? $warehouse->name : '','readonly'=>true )); ?></td>
						<td>
							<?php
						    echo CHtml::button('X', array(
						     	'onclick' => CHtml::ajax(array(
							       	'type' => 'POST',
							       	'url' => CController::createUrl('ajaxHtmlRemoveWarehouseDetail', array('id' => $branch->header->id, 'index' => $i)),
							       	'update' => '#warehouse',
					      		)),
					     	));
				     	?>
						</td>

					</tr>
				<?php endforeach ?>
				
			</tbody>
			</table>