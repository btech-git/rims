<?php
/* @var $this TransaksiOrderPembelianController */
/* @var $modelApproval TransaksiORderPembelian */
/* @var $form CActiveForm */
?>
	<h2>Revision History</h2>

		 	<div class="field">
				<div class="row collapse">
					<div class="small-12 columns">
					<?php if ($listApproval!=null): ?>
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
					 	<?php foreach ($listApproval as $key => $history): ?>
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
					
					<?php else: 
						echo "No Revision History";
					?>		
					<?php endif ?>			 
					</div>
				</div>
		 	</div>