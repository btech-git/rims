<fieldset>
	<legend>Approval Historis</legend>
	<table>
	 	<thead>
	 		<tr>
	 			<td>Approval type</td>
	 			<td>Revision</td>
	 			<td>date</td>
	 			<td>note</td>
	 			<td>supervisor</td>
	 		</tr>
	 	</thead>
	 	<tbody>
	 	<?php foreach ($historis as $key => $history): ?>
	 		
	 	
	 		<tr>
	 			<td><?php echo $history->approval_type; ?></td>
	 			<td><?php echo $history->revision; ?></td>
	 			<td><?php echo $history->date; ?></td>
	 			<td><?php echo $history->note; ?></td>
	 			<td><?php echo $history->supervisor_id; ?></td>
	 		</tr>
	 	<?php endforeach ?>
	 	</tbody>
	</table>
</fieldset>

		

