<?php if(count($registrationTransactions) > 0): ?>
	<div class="detail">
		<table>
			<thead>
				<tr>
					<th>Transaction Number</th>
					<th>Work Order Number</th>
					<th>Work Order Date</th>
					<th>WO Status</th>
					<th>Detail</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($registrationTransactions as $i => $registrationTransaction): ?>
					<tr>
						<td><?php echo $registrationTransaction->transaction_number; ?></td>
						<td><?php echo $registrationTransaction->work_order_number; ?></td>
						<td><?php echo $registrationTransaction->work_order_date; ?></td>
						<td><?php echo $registrationTransaction->status; ?></td>
						<td>
						<?php echo CHtml::tag('button', array(
					        // 'name'=>'btnSubmit',
					        'type'=>'button',
					        'class' => 'hello button expand',
					        'onclick'=>'$("#detail-'.$i.'").toggle();'
					      ), '<span class="fa fa-caret-down"></span> Detail');?>
						</td>
					</tr>
					<tr>
						<td id="detail-<?php echo $i?>" class="hide" colspan=6>
								<table>
									<tr>
										<td>Services</td>
										<td>
											<?php
												$services = array();

					                    		if($registrationTransaction->repair_type == 'GR'){
					                    			foreach ($registrationTransaction->registrationServices as $registrationService) {
					                    			
					                        			$services[] = $registrationService->service->name . '<br>';
					                        		}
					                    		}
					                    		else{
					                    			foreach ($registrationTransaction->registrationServices as $registrationService) {
					                    				if($registrationService->is_body_repair == 1)
					                        				$services[] = $registrationService->service->name . '<br>';
					                        		}
					                    		}
					                    		echo implode('', $services);
											?>
										</td>
									</tr>
									
								</table>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
<?php else: ?>
	<?php echo "NO HISTORY"; ?>
<?php endif ?>