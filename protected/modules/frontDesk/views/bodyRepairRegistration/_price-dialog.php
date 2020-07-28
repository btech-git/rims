<?php  
	// $customerId = $_GET["RegistrationTransaction"]["customer_id"];
	// $vehicleId = $_GET["RegistrationTransaction"]["vehicle_id"];
	// $insuranceId = $_GET["RegistrationTransaction"]["insurance_company_id"];
?>
<?php $serviceData = Service::model()->findByPk($service); ?>
<h3>Service : <?php echo $serviceData->name; ?></h3>
<table class="detail">
	<caption>Pricelist</caption>
	<thead>
		<th>Price Type</th>
		<th>Price</th>
		<th>Description</th>
		<th>Choose</th>
	</thead>
	<tbody>
		<tr>
			<?php $serviceValue = GeneralStandardValue::model()->findByPK(1);
					$standardRate = GeneralStandardFr::model()->findByPK(1);
					$price = $serviceValue->difficulty_value * $serviceValue->luxury_calc * $serviceValue->flat_rate_hour * $standardRate->flat_rate;
					
			  ?>
			<td><input id="standard_<?php echo $index;?>_type" type="text" readonly="true" value="Service Standard Rate"></td>
			<td><input id="standard_<?php echo $index;?>_price"type="text" readonly="true" value="<?php echo $serviceData->price != 0 ?$serviceData->price : $price; ?>"></td>
			<td><input id="standard_<?php echo $index;?>_description"type="text" readonly="true" value=""></td>
			<td><?php echo CHtml::button('choose', array(
								'id' => 'standard-add-'.$index.'-button',
								'name' => 'StandardAdd',
								'class'=>'button',
								'onclick' => '
										$("#RegistrationService_'.$index.'_price").val($("#standard_'.$index.'_price").val());
										$("#RegistrationService_'.$index.'_total_price").val($("#standard_'.$index.'_price").val());
										$("#RegistrationService_'.$index.'_price_type").val($("#standard_'.$index.'_type").val());
										$("#service_price'.$index.'-dialog").dialog("close");	
										'
								)
							); ?></td>
		</tr>
		<tr>
			
			<td><input id="common_<?php echo $index;?>_type" type="text" readonly="true" value="Common Price"></td>
			<td><input id="common_<?php echo $index;?>_price"type="text" readonly="true" value="<?php echo $serviceData->common_price; ?>"></td>
			<td><input id="common_<?php echo $index;?>_description"type="text" readonly="true" value=""></td>
			<td><?php echo CHtml::button('choose', array(
								'id' => 'standard-add-'.$index.'-button',
								'name' => 'StandardAdd',
								'class'=>'button',
								'onclick' => '
										$("#RegistrationService_'.$index.'_price").val($("#common_'.$index.'_price").val());
										$("#RegistrationService_'.$index.'_total_price").val($("#common_'.$index.'_price").val());
										$("#RegistrationService_'.$index.'_price_type").val($("#common_'.$index.'_type").val());
										$("#service_price'.$index.'-dialog").dialog("close");	
										'
								)
							); ?></td>
		</tr>
		<?php $customerException = CustomerServiceRate::model()->findByAttributes(array('service_id'=>$service,'customer_id'=>$customer)); ?>
		<?php if(count($customerException) != 0) : ?>
		<tr>
			<td><input id="customer_<?php echo $index;?>_type" type="text" readonly="true" value="Customer Exception Rate"></td>
			<td><input id="customer_<?php echo $index;?>_price"type="text" readonly="true" value="<?php echo $customerException->rate; ?>"></td>
			<td><input id="customer_<?php echo $index;?>_description"type="text" readonly="true" value=""></td>
			<td><?php echo CHtml::button('choose', array(
								'id' => 'standard-add-'.$index.'-button',
								'name' => 'StandardAdd',
								'class'=>'button',
								'onclick' => '
										$("#RegistrationService_'.$index.'_price").val($("#customer_'.$index.'_price").val());
										$("#RegistrationService_'.$index.'_total_price").val($("#customer_'.$index.'_price").val());
										$("#RegistrationService_'.$index.'_price_type").val($("#customer_'.$index.'_type").val());
										$("#service_price'.$index.'-dialog").dialog("close");	
										'
								)
							); ?></td>
		</tr>
		
			<?php endif ?>
		<?php $customerData = Customer::model()->findByPk($customer);?>
		<?php $general = GeneralStandardValue::model()->findByPk(1);?>
		<?php $count = $general->difficulty_value * $general->luxury_value * $general->flat_rate_hour * $customerData->flat_rate; ?>
		<?php if($count != 0) : ?>
		<tr>
			<td><input id="customer_flat_<?php echo $index;?>_type" type="text" readonly="true" value="Customer Flat Rate"></td>
			<td><input id="customer_flat_<?php echo $index;?>_price"type="text" readonly="true" value="<?php echo $count; ?>"></td>
			<td><input id="customer_flat_<?php echo $index;?>_description"type="text" readonly="true" value=""></td>
			<td>
			
					<?php echo CHtml::button('choose', array(
								'id' => 'standard-add-'.$index.'-button',
								'name' => 'StandardAdd',
								'class'=>'button',
								'onclick' => '
										$("#RegistrationService_'.$index.'_price").val($("#customer_flat_'.$index.'_price").val());
										$("#RegistrationService_'.$index.'_total_price").val($("#customer_flat_'.$index.'_price").val());
										$("#RegistrationService_'.$index.'_price_type").val($("#customer_flat_'.$index.'_type").val());
										$("#service_price'.$index.'-dialog").dialog("close");	
										'
								)
							); ?>
			
			</td>
			
		</tr>
		
			<?php endif ?>
			
			<?php $insurancePrice = InsuranceCompanyPricelist::model()->findByAttributes(array('insurance_company_id'=>$insurance)) ?>
			<?php if (count($insurancePrice) != 0) : ?>

					<tr>
						<td><input id="insurance_<?php echo $index;?>_type" type="text" readonly="true" value="Insurance Exception Rate"></td>
						<td><input id="insurance_<?php echo $index;?>_price"type="text" readonly="true" value="<?php echo $insurancePrice->price; ?>"></td>
						<td><input id="insurance_<?php echo $index;?>_description"type="text" readonly="true" value=""></td>
						<td>
						
								<?php echo CHtml::button('choose', array(
											'id' => 'standard-add-'.$index.'-button',
											'name' => 'StandardAdd',
											'class'=>'button',
											'onclick' => '
													$("#RegistrationService_'.$index.'_price").val($("#insurance_'.$index.'_price").val());
													$("#RegistrationService_'.$index.'_total_price").val($("#insurance_'.$index.'_price").val());
													$("#RegistrationService_'.$index.'_price_type").val($("#insurance_'.$index.'_type").val());
													$("#service_price'.$index.'-dialog").dialog("close");	
													'
											)
										); ?>
						
						</td>
					</tr>
			<?php endif ?>
		<?php $vehicleData = Vehicle::model()->findByPk($vehicle); ?>
		<?php $serviceVehicleCarMake = ServicePricelist::model()->findByAttributes(array('service_id'=>$service,'car_make_id'=>$vehicleData->car_make_id)); ?>
		<?php if(count($serviceVehicleCarMake)!=0) :?>
			<tr>
				<td><input id="vehicle_car_make_<?php echo $index;?>_type" type="text" readonly="true" value="Vehicle Car Make Exception Rate"></td>
				<td><input id="vehicle_car_make_<?php echo $index;?>_price"type="text" readonly="true" value="<?php echo $serviceVehicleCarMake->price; ?>"></td>
				<td><input id="vehicle_car_make_<?php echo $index;?>_description"type="text" readonly="true" value=""></td>
				<td>
				
						<?php echo CHtml::button('choose', array(
									'id' => 'standard-add-'.$index.'-button',
									'name' => 'StandardAdd',
									'class'=>'button',
									'onclick' => '
											$("#RegistrationService_'.$index.'_price").val($("#vehicle_car_make_'.$index.'_price").val());
											$("#RegistrationService_'.$index.'_total_price").val($("#vehicle_car_make_'.$index.'_price").val());
											$("#RegistrationService_'.$index.'_price_type").val($("#vehicle_car_make_'.$index.'_type").val());
											$("#service_price'.$index.'-dialog").dialog("close");	
											'
									)
								); ?>
				
				</td>
			</tr>
		<?php endif ?>
		<?php $serviceVehicleCarMakeModel = ServicePricelist::model()->findByAttributes(array('service_id'=>$service,'car_make_id'=>$vehicleData->car_make_id,'car_model_id'=>$vehicleData->car_model_id)); ?>
		<?php if(count($serviceVehicleCarMakeModel)!=0) :?>
			<tr>
				<td><input id="vehicle_car_make_model_<?php echo $index;?>_type" type="text" readonly="true" value="Vehicle Car Make - Car Model Exception Rate"></td>
				<td><input id="vehicle_car_make_model_<?php echo $index;?>_price"type="text" readonly="true" value="<?php echo $serviceVehicleCarMakeModel->price; ?>"></td>
				<td><input id="vehicle_car_make_model_<?php echo $index;?>_description"type="text" readonly="true" value=""></td>
				<td>
				
						<?php echo CHtml::button('choose', array(
									'id' => 'standard-add-'.$index.'-button',
									'name' => 'StandardAdd',
									'class'=>'button',
									'onclick' => '
											$("#RegistrationService_'.$index.'_price").val($("#vehicle_car_make_model_'.$index.'_price").val());
											$("#RegistrationService_'.$index.'_total_price").val($("#vehicle_car_make_model_'.$index.'_price").val());
											$("#RegistrationService_'.$index.'_price_type").val($("#vehicle_car_make_model_'.$index.'_type").val());
											$("#service_price'.$index.'-dialog").dialog("close");	
											'
									)
								); ?>
				
				</td>
			</tr>
		<?php endif ?>
		<?php $serviceVehicleCarMakeSubModel = ServicePricelist::model()->findByAttributes(array('service_id'=>$service,'car_make_id'=>$vehicleData->car_make_id,'car_model_id'=>$vehicleData->car_model_id,'car_sub_detail_id'=>$vehicleData->car_sub_model_id)); ?>
		<?php if(count($serviceVehicleCarMakeSubModel)!=0) : ?>
			<tr>
				<td><input id="vehicle_car_make_sub_model_<?php echo $index;?>_type" type="text" readonly="true" value="Vehicle Car Make - Car Model Exception Rate"></td>
				<td><input id="vehicle_car_make_sub_model_<?php echo $index;?>_price"type="text" readonly="true" value="<?php echo $serviceVehicleCarMakeSubModel->price; ?>"></td>
				<td><input id="vehicle_car_make_sub_model_<?php echo $index;?>_description"type="text" readonly="true" value=""></td>
				<td>
				
						<?php echo CHtml::button('choose', array(
									'id' => 'standard-add-'.$index.'-button',
									'name' => 'StandardAdd',
									'class'=>'button',
									'onclick' => '
											$("#RegistrationService_'.$index.'_price").val($("#vehicle_car_make_sub_model_'.$index.'_price").val());
											$("#RegistrationService_'.$index.'_total_price").val($("#vehicle_car_make_sub_model_'.$index.'_price").val());
											$("#RegistrationService_'.$index.'_price_type").val($("#vehicle_car_make_sub_model_'.$index.'_type").val());
											$("#service_price'.$index.'-dialog").dialog("close");	
											'
									)
								); ?>
				
				</td>
			</tr>
		<?php endif ?>
	</tbody>
</table>