<?php
/* @var $this ProductController */
/* @var $model Product */
?>

<div class="row">

	<div class="small-10 columns">
		<div id="maincontent">
			<table >
				<thead>
					<tr>
						<td>Supplier Name</td>
						<td>Purchase Price</td>
					</tr>
				</thead>
			
				<?php foreach ($prices as $key => $price): ?>
					<tr>
						<td><?php echo $price->supplier->name; ?></td>
						<td><?php echo $price->purchase_price; ?></td>							
					</tr>
				<?php endforeach ?>
			</table>
		</div>
	</div>
</div>