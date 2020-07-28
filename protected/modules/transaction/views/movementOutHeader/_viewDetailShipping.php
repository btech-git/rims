<fieldset>
	<legend>Shipping Historis</legend>
	<table>
	 	<thead>
	 		<tr>
	 			<th>Status</th>
	 			<th>date</th>
	 			<th>supervisor</th>
	 		</tr>
	 	</thead>
	 	<tbody>
	 	<?php foreach ($shippings as $key => $shipping): ?>
	 		<tr>
	 			<td><?php echo $shipping->status; ?></td>
	 			<td><?php echo $shipping->date; ?></td>
	 			<td><?php echo $shipping->supervisor->username; ?></td>
	 		</tr>
	 	<?php endforeach ?>
	 	</tbody>
	</table>
</fieldset>

		

