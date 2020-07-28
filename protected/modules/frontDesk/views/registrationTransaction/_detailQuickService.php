<?php if (count($registrationTransaction->quickServiceDetails)>0): ?>
	<table>
		<thead>
			<tr>
				<th>Quick Service</th>
				<th>Services</th>
				<th>Price</th>
				<th>Hour</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($registrationTransaction->quickServiceDetails as $i => $quickServiceDetail): ?>
				<tr>
					<td><?php echo CHtml::activeHiddenField($quickServiceDetail,"[$i]quick_service_id"); ?>
							<?php echo CHtml::activeTextField($quickServiceDetail,"[$i]quick_service_code",array('readonly'=>true,'value'=>$quickServiceDetail->quick_service_id != "" ? $quickServiceDetail->quickService->code : '')); ?>
					</td>
					<td>
						<?php $first = true;
									$rec = "";
									$qsDetails = QuickServiceDetail::model()->findAllByAttributes(array('quick_service_id'=>$quickServiceDetail->quick_service_id));
									foreach($qsDetails as $qssDetail)
									{
										$service = Service::model()->findByPk($qssDetail->service_id);
										if($first === true)
										{
											$first = false;
										}
										else
										{
											$rec .= ', ';
										}
										$rec .= $service->name;

									}
									echo $rec;
						 ?>
						<?php echo CHtml::button('add to Service', array(
								'id' => 'service-add-'.$i.'-button',
								'name' => 'ServiceDetailAdd',
								'class'=>'button',
								'onclick' => '
										var serviceId = $("#RegistrationDamage_'.$i.'_service_id").val();
										$.ajax({
												type: "POST",
												//dataType: "JSON",
												url: "' . CController::createUrl('ajaxHtmlAddQsServiceDetail', array('id'=>$registrationTransaction->header->id,'quickServiceId'=>'')). '" + $("#RegistrationQuickService_'.$i.'_quick_service_id").val(),
												data:$("form").serialize(),
												success: function(html) {
													$("#service").html(html);
											
										},
									});'
								)
							); ?>
						 

					</td>
					<td><?php echo CHtml::activeTextField($quickServiceDetail,"[$i]price",array('readonly'=>true)); ?></td>
					<td><?php echo CHtml::activeTextField($quickServiceDetail,"[$i]hour",array('readonly'=>true)); ?></td>
				
					<td><?php
					    echo CHtml::button('X', array(
					     	'onclick' => CHtml::ajax(array(
						       	'type' => 'POST',
						       	'url' => CController::createUrl('ajaxHtmlRemoveQuickServiceDetail', array('id' => $registrationTransaction->header->id, 'index' => $i)),
						       	'update' => '#quickService',
				      		)),
				     	));
			     	?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
<?php endif ?>
