<?php $product = Product::model()->findByPK($productId); ?>
<h1>Product : <?php echo $product->name; ?></h1>
<table>
	<tr>
		
		<?php foreach ($warehouses as $key => $warehouse): ?>
			<th><?php echo $warehouse->name; ?></th>
		<?php endforeach ?>
	</tr>
	<tr>
	<?php foreach ($warehouses as $key => $warehouse): ?>

		<?php $inventory = Inventory::model()->findByAttributes(array('product_id'=>$productId,'warehouse_id'=>$warehouse->id)) ?>
		
			<td><?php echo $inventory->total_stock; ?></td>
		
		<?php endforeach ?>
	</tr>
</table>