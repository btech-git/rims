<table class="items">
	<thead>
		<tr>
			<th colspan="2">Product Complement</th>
			<!-- <th><a href="#" class="sort-link">Level</a></th>
			<th><a href="#" class="sort-link"></a></th> -->
		</tr>
	</thead>
	<tbody >
		<?php foreach ($product->productComplementDetails as $i => $productComplementDetail): ?>
			<tr>
				<td><?php echo CHtml::activeHiddenField($productComplementDetail,"[$i]product_complement_id"); ?>
				<?php $product = Product::model()->findByPK($productComplementDetail->product_complement_id); ?>
				<?php echo CHtml::activeTextField($productComplementDetail,"[$i]product_complement_name",array('value'=>$productComplementDetail->product_complement_id!= '' ? $product->name : '','readonly'=>true )); ?></td>
			</tr>
		<?php endforeach ?>
		
	</tbody>
</table>