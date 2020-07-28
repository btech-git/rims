<table class="items">
			<thead>
			<tr>
				<th colspan="2">Product Substitute</th>
				<!-- <th><a href="#" class="sort-link">Level</a></th>
				<th><a href="#" class="sort-link"></a></th> -->
			</tr>
			</thead>
				<tbody >
					<?php foreach ($product->productSubstituteDetails as $i => $productSubstituteDetail): ?>
						<tr>
							<td><?php echo CHtml::activeHiddenField($productSubstituteDetail,"[$i]product_substitute_id"); ?>
							<?php $product = Product::model()->findByPK($productSubstituteDetail->product_substitute_id); ?>
							<?php echo CHtml::activeTextField($productSubstituteDetail,"[$i]product_substitute_name",array('value'=>$productSubstituteDetail->product_substitute_id!= '' ? $product->name : '','readonly'=>true )); ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>