<?php if($customer != ""): ?>
	<?php $serviceRates = CustomerServiceRate::model()->findAllByAttributes(array('customer_id'=>$customer)); ?>
	<?php if(count($serviceRates) > 0): ?>
				<table class="detail">
					<thead>
						<tr>
							<th>Service</th>
							<th>Vehicle</th>
							<th>Rate</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($serviceRates as $key => $serviceRate): ?>
							<tr>
								<td><?php echo $serviceRate->service->name; ?></td>
								<td>
									<?php if ($serviceRate->car_make_id): ?>
										<?php echo $serviceRate->carMake->name; ?>
									<?php endif ?>
									<?php if ($serviceRate->car_model_id): ?>
										<?php echo $serviceRate->carModel->name; ?>
									<?php endif ?>
									<?php if ($serviceRate->car_sub_model_id): ?>
										<?php echo $serviceRate->carSubModel->name; ?>
									<?php endif ?>
								<?php //echo $serviceRate->car_sub_model_id; ?></td>
								<td><?php echo number_format($serviceRate->rate,0); ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
	<?php else: ?>
		<?php echo "NO SERVICE EXCEPTION RATE"; ?>
	<?php endif ?>
	<?php endif ?>