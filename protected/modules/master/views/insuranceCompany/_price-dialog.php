<?php
/* @var $this ProductController */
/* @var $model Product */
?>

<div class="row">

	<div class="small-10 columns">
		<div id="maincontent">
			<table class="detail" >
				<thead>
					<tr>
						<th>Service </th>
						<th>Damage Type</th>
						<th>Vehicle Type</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($prices as $key => $price): ?>
					<tr>
						<td><?php echo $price->service->name; ?></td>
						<td><?php echo $price->damage_type; ?></td>
						<td><?php echo $price->vehicle_type; ?></td>
						<td><?php echo $price->price; ?></td>
					</tr>
				<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>