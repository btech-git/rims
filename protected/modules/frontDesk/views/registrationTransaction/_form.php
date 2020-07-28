<?php
/* @var $this RegistrationTransactionController */
/* @var $registrationTransaction->header RegistrationTransaction */
/* @var $form CActiveForm */
?>
<?php /*
	<script>
		function numberWithCommas(x) {
		    return x.toString().replace(/\B(?=(?:\d{3})+(?!\d))/g, ",");
		}
		$( document ).ready(function() {
				$(".numbers").each(function(){
					//alert($(this).val());
					var v_pound = $(this).val();
				    v_pound = numberWithCommas(v_pound);
				    // $(this).val(Number(v_pound).toLocaleString('en'));
				    // console.log($(this).val().toLocaleString("en"));
				    $(this).val(v_pound);
				    //console.log($(this).val(v_pound));
				});

			   
			});
		function removeCommas(x){
			return x.toString().replace(",","");
		}
		function noCommas(){
			$(".numbers").each(function(){
					
					var v_pound = $(this).val();
				    v_pound = removeCommas(v_pound);
				    
				    $(this).val(v_pound);
				    //console.log($(this).val(v_pound));
				});
		}
	</script>
	*/?>
<div class="clearfix page-action">
	<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/frontDesk/registrationTransaction/admin';?>"><span class="fa fa-th-list"></span>Manage Registration Transaction</a>
	<h1><?php if($registrationTransaction->header->isNewRecord){ echo "New Registration Transaction"; }else{ echo "Update Registration Transaction";}?></h1>
	<div class="form">
		<?php 
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'registration-transaction-form',
			'htmlOptions' => array('enctype' => 'multipart/form-data'),
			'enableAjaxValidation'=>false,
			)
		); 
		?>

		<p class="note">Fields with <span class="required">*</span> are required.</p>

		<?php echo $form->errorSummary($registrationTransaction->header); ?>
		<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
		<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
		<?php //Yii::app()->clientScript->registerCoreScript('jquery.yiigridview'); ?>

		<?php if($type == 1){
		    	//$data =  
		} ?>
		<div class="row">
			<div class="medium-12 columns">
				<div class="row">
					<!-- CUSTOMER COLUMN -->
					<div class="medium-6 columns">
						<h2>Customer</h2>
						<hr />			
						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'customer_id'); ?></label>
								</div>
								<div class="small-8 columns">
									<div class="row">
										<div class="small-8 columns">
											<?php echo $form->hiddenField($registrationTransaction->header, 'customer_id',array('value'=>$type == 1?$data->id:$data->customer_id)); ?>
											<?php echo $form->textField($registrationTransaction->header, 'customer_name',array('value'=>$type==1?$data->name:$data->customer->name,'readonly'=>true)); ?>

											<?php echo $form->error($registrationTransaction->header,'customer_id'); ?>
										</div>
										<div class="small-2 columns">
											<a class="button expand" href="<?php echo Yii::app()->baseUrl.'/master/customer/create';?>"><span class="fa fa-plus"></span>Add</a>
										</div>
										<div class="small-2 columns">
											<a class="button expand" href="<?php echo Yii::app()->createUrl('/master/customer/update',array('id'=>$type == 1?$data->id:$data->customer_id));?>"><span class="fa fa-pencil"></span>Edit</a>
										</div>
									</div>
								</div>
							</div>
						</div>			

						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<label class="prefix">Type</label>
								</div>
								<div class="small-8 columns">
									<input id="Customer_customer_type" type="text" maxlength="30" name="Customer[customer_type]" readonly="readonly" value="<?php echo $type==1?$data->customer_type:$data->customer->customer_type; ?>">

								</div>
							</div>
						</div>

						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<label class="prefix">Address</label>
								</div>
								<div class="small-8 columns">
									<textarea id="Customer_address" name="Customer[address]" cols="50" rows="6" readonly="readonly"><?php echo $type==1?$data->address:$data->customer->address; ?></textarea>
								</div>
							</div>
						</div>

						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<label class="prefix">Province</label>
								</div>
								<div class="small-8 columns">
									<input id="Customer_province_id" type="text" maxlength="30" name="Customer[province_id]" readonly="readonly" value="<?php echo $type==1?$data->province->name:$data->customer->province->name; ?>">

								</div>
							</div>
						</div>

						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<label class="prefix">City</label>
								</div>
								<div class="small-8 columns">
									<input id="Customer_city_id" type="text" maxlength="30" name="Customer[city_id]" readonly="readonly" value="<?php echo $type==1?$data->city->name:$data->customer->city->name; ?>">

								</div>
							</div>
						</div>

						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<label class="prefix">Zipcode</label>
								</div>
								<div class="small-8 columns">
									<input id="Customer_zipcode" type="text" maxlength="30" name="Customer[zipcode]" readonly="readonly" value="<?php echo$type==1?$data->zipcode:$data->customer->zipcode; ?>">

								</div>
							</div>
						</div>

						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<label class="prefix">Email</label>
								</div>
								<div class="small-8 columns">
									<input id="Customer_email" type="text" maxlength="30" name="Customer[email]" readonly="readonly" value="<?php echo $type==1?$data->email:$data->customer->email; ?>">

								</div>
							</div>
						</div>

						<div class="field">
							<div class="row collapse">
								<div class="small-4 columns">
									<label class="prefix">Rate</label>
								</div>
								<div class="small-8 columns">
									<input id="Customer_flat_rate" type="text" maxlength="30" name="Customer[flat_rate]" readonly="readonly" value="<?php echo $type==1?$data->flat_rate:$data->customer->flat_rate; ?>">
								</div>
							</div>
						</div>
					</div>
					<!-- END CUSTOMER COLUMN -->

					<!-- PIC CUSTOMER COLUMN -->
					<div class="medium-6 columns">
						<div id="pic">
							<h2>PIC</h2><hr />

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'pic_id'); ?></label>
									</div>
									<div class="small-8 columns">
										<div class="row">
											<div class="small-8 columns">
												<?php echo $form->dropDownList($registrationTransaction->header,'pic_id',CHtml::listData(CustomerPic::model()->findAllByAttributes(array('customer_id'=>$type==1?$data->id:$data->customer->id),array('order'=>'name')),'id','name'),  array('prompt' => '[--Select PIC--]',
													'onchange'=> '$.ajax({
														type: "POST",
														dataType: "JSON",
														url: "' . CController::createUrl('ajaxPic', array('id'=> '')) . '" + $(this).val(),
														data: $("form").serialize(),
														success: function(data) {

															$("#CustomerPic_address").val(data.address);
															$("#CustomerPic_province_id").val(data.province_name);
															$("#CustomerPic_city_id").val(data.city_name);
															$("#CustomerPic_zipcode").val(data.zipcode);
															$("#CustomerPic_email").val(data.email);
														},});
													$("a.pic").each(function() {
										               var $this = $(this);       
										               var text = $this.attr("href"); 
										               var urlMatch = text.match(/&picId\=([^\&]+)/g);
										              
										                var oldUrl = text.replace(urlMatch,"");
										                
										                var newId = "&picId=" + $("#RegistrationTransaction_pic_id").val();
										                
										               $this.attr("href", oldUrl + newId);
										               //console.log(newId);
										        	});
												'
                                                )); ?>
												<?php echo $form->error($registrationTransaction->header,'pic_id'); ?>
												<?php $picId = $registrationTransaction->header->pic_id == "" ? 0 : $registrationTransaction->header->pic_id; ?>
											</div>
											<div class="small-2 columns">
												
											<a class="button expand" href="<?php echo Yii::app()->createUrl('/master/customer/update',array('id'=>$type == 1?$data->id:$data->customer_id));?>"><span class="fa fa-pencil"></span>Add</a>
										
											</div>
											<div class="small-2 columns">
												
											<a class="button expand pic" href="<?php echo Yii::app()->createUrl('/master/customer/updatePic',array('custId'=>$type == 1?$data->id:$data->customer_id,'picId'=>$picId));?>"><span class="fa fa-pencil"></span>Edit</a>
										
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<label class="prefix">Address</label>
									</div>
									<div class="small-8 columns">
										<textarea id="CustomerPic_address" name="CustomerPic[address]" cols="50" rows="6" readonly="readonly" ><?php echo $registrationTransaction->header->pic_id != NULL ? $registrationTransaction->header->pic->address : ''; ?></textarea>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<label class="prefix">Province</label>
									</div>
									<div class="small-8 columns">
										<input id="CustomerPic_province_id" type="text" maxlength="30" name="CustomerPic[province_id]" readonly="readonly" value="<?php echo $registrationTransaction->header->pic_id != NULL ? $registrationTransaction->header->pic->province->name : ''; ?>"> 

									</div>
								</div>
							</div>
							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<label class="prefix">City</label>
									</div>
									<div class="small-8 columns">
										<input id="CustomerPic_city_id" type="text" maxlength="30" name="CustomerPic[city_id]" readonly="readonly" value="<?php echo $registrationTransaction->header->pic_id != NULL ? $registrationTransaction->header->pic->city->name : ''; ?>">

									</div>
								</div>
							</div>
							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<label class="prefix">Zipcode</label>
									</div>
									<div class="small-8 columns">
										<input id="CustomerPic_zipcode" type="text" maxlength="30" name="CustomerPic[zipcode]" readonly="readonly" value="<?php echo $registrationTransaction->header->pic_id != NULL ? $registrationTransaction->header->pic->zipcode : ''; ?>">

									</div>
								</div>
							</div>
							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<label class="prefix">Email</label>
									</div>
									<div class="small-8 columns">
										<input id="CustomerPic_email" type="text" maxlength="30" name="CustomerPic[email]" readonly="readonly" value="<?php echo $registrationTransaction->header->pic_id != NULL ? $registrationTransaction->header->pic->email : ''; ?>">

									</div>
								</div>
							</div>
						</div> <!-- end PIc -->
					</div>
					<!-- END PIC CUSTOMER COLUMN -->
				</div>
				<!-- END ROW -->
				<br />
				<div class="row">
					<div class="medium-6 columns">
						<div id="vehicle">
							<h2>Vehicle</h2>
							<hr />

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'vehicle_id'); ?></label>
									</div>
									<div class="small-8 columns">
										<div class="row">
											<div class="small-8 columns">
												<?php $vId =0; ?>
												<?php if($type == 1){ ?>
												<?php echo $form->dropDownList($registrationTransaction->header,'vehicle_id',CHtml::listData(Vehicle::model()->findAllByAttributes(array('customer_id'=>$data->id)),'id','plate_number'),  array('prompt' => '[--Select Vehicle--]',
													'onchange'=> '$.ajax({
														type: "POST",
														dataType: "JSON",
														url: "' . CController::createUrl('ajaxVehicle', array('id'=> '')) . '" + $(this).val(),
														data: $("form").serialize(),
														success: function(data) {
															$("#Vehicle_machine_number").val(data.machine);
															$("#Vehicle_frame_number").val(data.frame);
															$("#Vehicle_car_make_id").val(data.carMakeName);
															$("#Vehicle_car_model_id").val(data.carModelName);
															$("#Vehicle_car_sub_model_id").val(data.carSubModelName);
															$("#Vehicle_color_id").val(data.colorName);
															$("#Vehicle_chasis_code").val(data.chasis);
															$("#Vehicle_power").val(data.power);

														},});
												$("a.export").each(function() {
										               var $this = $(this);       
										               var text = $this.attr("href"); 
										               var urlMatch = text.match(/id\=([^\&]+)/g);
										              
										                var oldUrl = text.replace(urlMatch,"");
										                
										                var newId = "id=" + $("#RegistrationTransaction_vehicle_id").val();
										                
										               $this.attr("href", oldUrl + newId);
										               //console.log(newId);
										        });
												

												'
														)
												); 
													//$vId = $_GET["RegistrationTransaction"]["vehicle_id"];
												?>
												<?php } else if($type == 2) { ?>
												<?php echo $form->hiddenField($registrationTransaction->header, 'vehicle_id',array('value'=>$data->id,'readonly'=>true)); ?>

												<?php echo $form->textField($registrationTransaction->header, 'plate_number',array('value'=>$data->plate_number,'readonly'=>true)); ?>
												<?php $vId = $data->id; ?>
												<?php }else{ ?>
												<?php echo $form->hiddenField($registrationTransaction->header, 'vehicle_id',array('value'=> $registrationTransaction->header->vehicle_id,'readonly'=>true)); ?>

												<?php echo $form->textField($registrationTransaction->header, 'plate_number',array('value'=> $registrationTransaction->header->vehicle->plate_number,'readonly'=>true)); ?>
												<?php $vId = $registrationTransaction->header->vehicle_id; ?>
												<?php } ?>
												<?php echo $form->error($registrationTransaction->header,'vehicle_id'); ?>
											</div>
											<div class="small-2 columns">
												<a class="button expand" href="<?php echo Yii::app()->baseUrl.'/master/vehicle/create';?>"><span class="fa fa-plus"></span>Add</a>
											</div>
											<div class="small-2 columns">
												<a class="button expand export" href="<?php echo Yii::app()->createUrl('/master/vehicle/update',array('id'=>$vId));?>"><span class="fa fa-pencil"></span>Edit</a>
											</div>
										</div>
									</div>
								</div>
							</div>

							<?php 
							$machine = $frame = $carMake = $carModel = $carSubModel = $color = $chasis = $power = "";

							if ($type ==2 ){
								$machine = $data->machine_number;
								$frame = $data->frame_number;
								$carMake = $data->carMake->name;
								$carModel = $data->carModel->name;
								$carSubModel = $data->carSubModel->name;
								$colorId = $data->color_id;
								$color = Colors::model()->findByPk($colorId)->name;
								$power = $data->power;
								$chasis = $data->chasis_code;
							}
							elseif($type == ""){
								if($registrationTransaction->header->vehicle_id != ""){
									$machine = $registrationTransaction->header->vehicle->machine_number;
									$frame = $registrationTransaction->header->vehicle->frame_number;
									$carMake = $registrationTransaction->header->vehicle->carMake->name;
									$carModel = $registrationTransaction->header->vehicle->carModel->name;
									$carSubModel = $registrationTransaction->header->vehicle->carSubModel->name;
									$colorId = $registrationTransaction->header->vehicle->color_id;
									$color = Colors::model()->findByPk($colorId)->name;
									$power = $registrationTransaction->header->vehicle->power;
									$chasis = $registrationTransaction->header->vehicle->chasis_code;

								} 
							}?>

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<label class="prefix">Machine Number</label>
									</div>
									<div class="small-8 columns">
										<input id="Vehicle_machine_number" type="text" maxlength="30" name="Vehicle[machine_number]" readonly="readonly" value="<?php echo $machine; ?>">
									</div>
								</div>
							</div>
							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<label class="prefix">Frame Number</label>
									</div>
									<div class="small-8 columns">
										<input id="Vehicle_frame_number" type="text" maxlength="30" name="Vehicle[frame_number]" readonly="readonly" value="<?php echo $frame; ?>">

									</div>
								</div>
							</div>
							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<label class="prefix">Car Make</label>
									</div>
									<div class="small-8 columns">
										<input id="Vehicle_car_make_id" type="text" maxlength="30" name="Vehicle[car_make_id]" readonly="readonly" value="<?php echo $carMake; ?>">

									</div>
								</div>
							</div>
							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<label class="prefix">Car Model</label>
									</div>
									<div class="small-8 columns">
										<input id="Vehicle_car_model_id" type="text" maxlength="30" name="Vehicle[car_model_id]" readonly="readonly" value="<?php echo $carModel; ?>">

									</div>
								</div>
							</div>
							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<label class="prefix">Car Sub Model</label>
									</div>
									<div class="small-8 columns">
										<input id="Vehicle_car_sub_model_id" type="text" maxlength="30" name="Vehicle[car_sub_model_id]" readonly="readonly" value="<?php echo $carSubModel; ?>">

									</div>
								</div>
							</div>

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<label class="prefix">Color</label>
									</div>
									<div class="small-8 columns">
										<input id="Vehicle_color_id" type="text" maxlength="30" name="Vehicle[color_id]" readonly="readonly" value="<?php echo $color; ?>">

									</div>
								</div>
							</div>

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<label class="prefix">Chasis Code</label>
									</div>
									<div class="small-8 columns">
										<input id="Vehicle_chasis_code" type="text" maxlength="30" name="Vehicle[chasis_code]" readonly="readonly" value="<?php echo $chasis; ?>">

									</div>
								</div>
							</div>

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<label class="prefix">Power CC</label>
									</div>
									<div class="small-8 columns">
										<input id="Vehicle_power" type="text" maxlength="30" name="Vehicle[power]" readonly="readonly" value="<?php echo $power; ?>">
                                        <?php echo $form->textField($registrationTransaction->header, 'plate_number',array('value'=>$data->plate_number,'readonly'=>true)); ?>
									</div>
								</div>
							</div>

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<label class="prefix">Car Mileage (KM)</label>
									</div>
									<div class="small-8 columns">
                                        <?php echo $form->textField($registrationTransaction->header, 'vehicle_mileage'); ?>
									</div>
								</div>
							</div>
						</div> <!-- end vehicle -->
					</div>
				</div>

				<div class="row">
					<div class="medium-12 columns">
						<h2>Service Exception Rate</h2>
						<hr />
						<div id="serviceException">
							<?php if ($type == 1): ?>
								<?php $this->renderPartial('_serviceException', array('customer'=>$data->id)); ?>
							<?php elseif ($type == 2) : ?>
								<?php $this->renderPartial('_serviceException', array('customer'=>$data->customer->id)); ?>
							<?php else : ?>
								<?php $this->renderPartial('_serviceException', array('customer'=>$registrationTransaction->header->customer_id)); ?>
							<?php endif ?>

						</div> <!-- end service -->

						<h2>History</h2>
						<hr />
						<div id="history">
							<?php if ($type == 1): ?>
								<?php $this->renderPartial('_historyTransaction', array('customer'=>$data->id)); ?>
							<?php elseif ($type == 2) : ?>
								<?php $this->renderPartial('_historyTransaction', array('customer'=>$data->customer->id)); ?>
							<?php else : ?>
								<?php $this->renderPartial('_historyTransaction', array('customer'=>$registrationTransaction->header->customer_id)); ?>
							<?php endif ?>

						</div>
					</div>
				</div>

				<div class="row">
					<div class="medium-12 columns">
						<h2>Transaction</h2>
						<hr />

						<div class="row">
							<div class="medium-6 columns">
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'transaction_number'); ?></label>
										</div>
										<div class="small-8 columns">
											<?php echo $form->textField($registrationTransaction->header,'transaction_number',array('size'=>30,'maxlength'=>30, 'readonly' => true)); ?>
											<?php echo $form->error($registrationTransaction->header,'transaction_number'); ?>
										</div>
									</div>
								</div>

								<?php if(!$registrationTransaction->header->isNewRecord): ?>
									<?php if($registrationTransaction->header->work_order_number != ""): ?>
										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'work_order_number'); ?></label>
												</div>
												<div class="small-8 columns">

													<?php echo $form->textField($registrationTransaction->header,'work_order_number'); ?>
													<?php echo $form->error($registrationTransaction->header,'work_order_number'); ?>
												</div>
											</div>
										</div>
									<?php endif ?>
								<?php endif ?>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'transaction_date'); ?></label>
										</div>
										<div class="small-8 columns">
											<?php echo $form->textField($registrationTransaction->header,'transaction_date',array('value'=>date('Y-m-d'),'readonly'=>true)); ?>
											<?php //$this->widget('zii.widgets.jui.CJuiDatePicker',array(
											//               'model' => $registrationTransaction->header,
											//                'attribute' => "transaction_date",
											//                // additional javascript options for the date picker plugin
											//                'options'=>array(
											//                    'dateFormat' => 'yy-mm-dd',
											//                    'changeMonth'=>true,
											//   								 'changeYear'=>true,
											//   					S			 'yearRange'=>'1900:2020'
											//                ),
											//                 'htmlOptions'=>array(
											//                 	'value'=>date('Y-m-d'),
											//                   //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
											//                   ),
											//            ));
											?>
											<?php echo $form->error($registrationTransaction->header,'transaction_date'); ?>
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'repair_type'); ?></label>
										</div>
										<div class="small-8 columns">
											<?php 
											echo  $form->dropDownList($registrationTransaction->header, 'repair_type', array('GR' => 'General Repair',
												'BR' => 'Body Repair'),array('prompt'=>'[-- Select Repair Type--]','onchange'=>'
												if($(this).val() == "GR")
												{
													$("#RegistrationTransaction_is_quick_service").prop("disabled",false);
													$("#RegistrationTransaction_is_insurance").prop("disabled",true);
													$("#damage-data-button").prop("disabled",true);
													$("#RegistrationTransaction_is_insurance").attr("checked", false);
													$("#RegistrationTransaction_insurance_company_id").val("");
													$("#RegistrationTransaction_insurance_company_id").prop("disabled",true);

												}
												else if($(this).val() == "BR")
												{
													$("#RegistrationTransaction_is_quick_service").prop("disabled",true);
													$("#RegistrationTransaction_is_insurance").prop("disabled",false);
													$("#damage-data-button").prop("disabled",false);
													$("#RegistrationTransaction_is_quick_service").attr("checked", false);
												}
												else
												{
													$("#RegistrationTransaction_is_quick_service").prop("disabled",true);
													$("#RegistrationTransaction_is_insurance").prop("disabled",true);
													$("#damage-data-button").prop("disabled",true);
												}

												$.ajax({
													type: "POST",
													//dataType: "JSON",
													url: "' . CController::createUrl('ajaxHtmlRemoveInsuranceDetailAll', array('id'=> $registrationTransaction->header->id)).'",
													data: $("form").serialize(),
													success: function(html) {
														$("#insurance").html(html);	

													},
												});
												$.ajax({
													type: "POST",
													//dataType: "JSON",
													url: "' . CController::createUrl('ajaxHtmlRemoveDamageDetailAll', array('id'=> $registrationTransaction->header->id)).'",
													data: $("form").serialize(),
													success: function(html) {
														$("#damage").html(html);	

													},
												});
												$.ajax({
													type: "POST",
													//dataType: "JSON",
													url: "' . CController::createUrl('ajaxHtmlRemoveQuickServiceDetailAll', array('id'=> $registrationTransaction->header->id)).'",
													data: $("form").serialize(),
													success: function(html) {
														$("#quickService").html(html);	

													},
												});
												$.ajax({
													type: "POST",
													//dataType: "JSON",
													url: "' . CController::createUrl('ajaxHtmlRemoveServiceDetailAll', array('id'=> $registrationTransaction->header->id)).'",
													data: $("form").serialize(),
													success: function(html) {
														$("#service").html(html);	

													},
												});
												')); ?>
											<?php 
											//
											?>
											<?php echo $form->error($registrationTransaction->header,'repair_type'); ?>
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'problem'); ?></label>
										</div>
										<div class="small-8 columns">
											<?php echo $form->textArea($registrationTransaction->header,'problem',array('rows'=>6, 'cols'=>50)); ?>
											<?php echo $form->error($registrationTransaction->header,'problem'); ?>
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'branch_id'); ?></label>
										</div>
										<div class="small-8 columns">
										<?php //echo $form->hiddenField($registrationTransaction->header,'branch_id',array('value'=>$registrationTransaction->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $registrationTransaction->header->branch_id,'readonly'=>true)); ?>
										<?php echo $form->textField($registrationTransaction->header,'branch_name',array('value'=>$registrationTransaction->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->name : $registrationTransaction->header->branch->name,'readonly'=>true)); ?>
											<?php //echo $form->dropDownlist($registrationTransaction->header,'branch_id',CHtml::listData(Branch::model()->findAll(),'id','name'),array('prompt'=>'[--Select Branch--]')); ?>
											<?php echo $form->error($registrationTransaction->header,'branch_id'); ?>
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'user_id'); ?></label>
										</div>
										<div class="small-8 columns">
											<?php echo $form->hiddenField($registrationTransaction->header,'user_id', array('value'=>Yii::app()->user->getId(),'readonly'=>true)); ?>
                                            <?php echo $form->labelEx($registrationTransaction->header,'user_id', array('value'=>Yii::app()->user->getName())); ?>
											<?php echo $form->error($registrationTransaction->header,'user_id'); ?>
										</div>
									</div>
								</div>
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<label class="prefix">Tax</label>
										</div>
										<div class="small-8 columns">
											<?php echo CHtml::activeCheckBox($registrationTransaction->header,'ppn', array(
                                                'onchange' => CHtml::ajax(array(
                                                    'type' => 'POST',
                                                    'dataType' => 'JSON',
                                                    'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $registrationTransaction->header->id)),
                                                    'success' => 'function(data) {
                                                        $("#grand_total_transaction").html(data.grandTotal);
                                                        $("#tax_item_amount").html(data.taxItemAmount);
                                                    }',
                                                )),
                                            )); ?>
											<label for="ppn">PPN</label>
											<?php echo CHtml::activeCheckBox($registrationTransaction->header,'pph', array(
                                                'onchange' => CHtml::ajax(array(
                                                    'type' => 'POST',
                                                    'dataType' => 'JSON',
                                                    'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $registrationTransaction->header->id)),
                                                    'success' => 'function(data) {
                                                        $("#grand_total_transaction").html(data.grandTotal);
                                                        $("#tax_service_amount").html(data.taxServiceAmount);
                                                        $("#total_quick_service_quantity").html(data.totalQuickServiceQuantity);
                                                        $("#sub_total_quick_service").html(data.subTotalQuickService);
                                                    }',
                                                )),
                                            )); ?>
											<label for="pph">PPH</label>
										</div>
									</div>
								</div>

							</div> 
							<!-- END COLUMN 6-->
						</div>

						<div class="row">
							<div class="medium-6 columns">
								<div id="detailQs">
									<div class="field">
										<div class="row collapse">
											<div class="small-4 columns">
												<?php echo CHtml::activeCheckBox($registrationTransaction->header,'is_quick_service',array(1=>1,'disabled'=>$registrationTransaction->header->is_quick_service == 1 ? false : true,'onchange'=>'
													if($("#RegistrationTransaction_is_quick_service").is(":checked"))
													{
														$("#detail-button").prop("disabled",false);
													}
													else{
														$("#detail-button").prop("disabled",true);
														$.ajax({
															type: "POST",
													//dataType: "JSON",
															url: "' . CController::createUrl('ajaxHtmlRemoveQuickServiceDetailAll', array('id'=> $registrationTransaction->header->id)).'",
															data: $("form").serialize(),
															success: function(html) {
																$("#quickService").html(html);	

															},
														});
													}

													')
												); 
												?>
												<label for="is_quick_service">Quick Service</label>
											</div>
											<div class="small-8 columns">
												<?php echo CHtml::button('add Quick Service', array(
													'id' => 'detail-button',
													'name' => 'Detail',
													// 'class'=>'button extra left',
													'disabled'=>$registrationTransaction->header->is_quick_service == 1 ? false : true,
													'onclick' => '
													jQuery("#qs-dialog").dialog("open"); return false;'
													)
												); 
												?>
												<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
													'id' => 'qs-dialog',
													'options' => array(
														'title' => 'Quick Service',
														'autoOpen' => false,
														'width' => 'auto',
														'modal' => true,
														),)
												);
												?>
												<?php $this->widget('zii.widgets.grid.CGridView', array(
													'id'=>'qs-grid',
													'dataProvider'=>$qsDataProvider,
													'filter'=>$qs,
													'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
													'pager'=>array(
														'cssFile'=>false,
														'header'=>'',
														),
													'selectionChanged'=>'js:function(id){
														$("#qs-dialog").dialog("close");
														$.ajax({
															type: "POST",
															url: "' . CController::createUrl('ajaxHtmlAddQuickServiceDetail', array('id'=>$registrationTransaction->header->id,'quickServiceId'=>'')). '" + $.fn.yiiGridView.getSelection(id),
															data: $("form").serialize(),
															success: function(html) {
																$("#quickService").html(html);
                                                                $.ajax({
                                                                    type: "POST",
                                                                    dataType: "JSON",
                                                                    url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $registrationTransaction->header->id)). '",
                                                                    data: $("form").serialize(),
                                                                    success: function(data) {
                                                                        $("#grand_total_transaction").html(data.grandTotal);
                                                                        $("#total_quick_service_quantity").html(data.totalQuickServiceQuantity);
                                                                        $("#sub_total_quick_service").html(data.subTotalQuickService);
                                                                    },
                                                                });

															},
														});
														$("#qs-grid").find("tr.selected").each(function(){
															$(this).removeClass( "selected" );
														});
													}',
													'columns'=>array(
														//'id',
														'code',
														'name',
														'rate',
                                                        array(
                                                            'name'=>'rate',
                                                            'value'=>'Yii::app()->numberFormatter->format("#,##0.00", $data->rate)',
                                                        ),

														),
													)
												);
												?>
												<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
											</div>
										</div>
									</div>
								</div> 
								<!-- end of DetailQs -->
							</div>
							<!-- END COLUMN 6 DETAIL Quick Service-->

							<div class="medium-6 columns">
								<div id="detailInsurance">
									<div class="field">
										<div class="row collapse">
											<div class="small-4 columns">
												<?php echo CHtml::activeCheckBox($registrationTransaction->header,'is_insurance',array(1=>1,'disabled'=>$registrationTransaction->header->repair_type == "BR" ? false : true,'onchange'=>'
													if($("#RegistrationTransaction_is_insurance").is(":checked"))
													{

														$("#RegistrationTransaction_insurance_company_id").prop("disabled",false);
													}
													else{

														$("#RegistrationTransaction_insurance_company_id").prop("disabled",true);
														$.ajax({
															type: "POST",
													//dataType: "JSON",
															url: "' . CController::createUrl('ajaxHtmlRemoveInsuranceDetailAll', array('id'=> $registrationTransaction->header->id)).'",
															data: $("form").serialize(),
															success: function(html) {
																$("#insurance").html(html);	

															},
														});
														$("#RegistrationTransaction_insurance_company_id").val("");
													}
													$.ajax({
														type: "POST",
														//dataType: "JSON",
														url: "' . CController::createUrl('ajaxHtmlRemoveDamageDetailAll', array('id'=> $registrationTransaction->header->id)).'",
														data: $("form").serialize(),
														success: function(html) {
															$("#damage").html(html);	

														},
													});
													$.ajax({
														type: "POST",
														//dataType: "JSON",
														url: "' . CController::createUrl('ajaxHtmlRemoveServiceDetailAll', array('id'=> $registrationTransaction->header->id)).'",
														data: $("form").serialize(),
														success: function(html) {
															$("#service").html(html);	

														},
													});

													')
												); 
												?>

												<label for="is_insurance">Insurance Company</label>
											</div>
											<div class="small-8 columns">
												<?php echo $form->dropDownlist($registrationTransaction->header,'insurance_company_id',CHtml::listData(InsuranceCompany::model()->findAll(),'id','name'),array('prompt'=>'[--Select Insurance Company--]','disabled'=>$registrationTransaction->header->is_insurance == 1 ? false : true,
													'onchange'=>'
													if ($(this).val() != "")
													{
														$("#insurance-data-button").prop("disabled",false);
													}
													else
													{
														$("#insurance-data-button").prop("disabled",true);
													}
													')
												); 
												?>
											</div>
										</div>
									</div>

									<div class="field">
										<div class="row collapse">
											<div class="small-12 columns">
												<?php echo CHtml::button('add Insurance Data', array(
													'id' => 'insurance-data-button',
													'name' => 'Detail Insurance',
													'class'=>'button extra left',
													'disabled'=>$registrationTransaction->header->is_insurance == 1 ? false : true,
													'onclick' => '
													$.ajax({
														type: "POST",
														//dataType: "JSON",
														url: "' . CController::createUrl('ajaxHtmlAddInsuranceDetail', array('id'=> $registrationTransaction->header->id,'insuranceCompany'=>'')).'" + $("#RegistrationTransaction_insurance_company_id").val(),
														data:$("form").serialize(),
														success: function(html) {
															$("#insurance").html(html);

														},
													});'
													)
												); 
												?>
												<?php echo CHtml::button('add Damage', array(
													'id' => 'damage-data-button',
													'name' => 'Detail Damage',
													'class'=>'button extra center',
													'disabled'=>$registrationTransaction->header->is_insurance == 1 ? false : true,
													'onclick' => '
													// $.ajax({
													// 	type: "POST",
													// //dataType: "JSON",
													// 	url: "' . CController::createUrl('ajaxHtmlAddDamageDetail', array('id'=> $registrationTransaction->header->id,'repair'=>'')).'" + $("#RegistrationTransaction_repair_type").val(),
													// 	data:$("form").serialize(),
													// 	success: function(html) {
													// 		$("#damage").html(html);

													// 	},
													// });
														jQuery("#damage-dialog").dialog("open"); return false;
													'
													)
												); 
												?>
											</div>
										</div>
									</div>
								</div>
								<!-- end of DetailInsurance -->
							</div>
							<!-- END COLUMN 6 INSURANCE-->
							<hr />

							<!-- DETAIL QUICK SERVICE -->
							<div class="medium-12 columns">
								<div class="detail">
									<div class="field" id="quickService">
										<div class="row collapse">
											<div class="small-12 columns">
												<?php $this->renderPartial('_detailQuickService', array('registrationTransaction'=>$registrationTransaction)); ?>
											</div>
										</div>
									</div>
								</div>								
							</div>
							<!-- END QUICK SERVICE -->

							<!-- DETAIL INSURANCE -->
							<div class="medium-12 columns">
								<div class="detail">
									<div class="field" id="insurance">
										<div class="row collapse">
											<div class="small-12 columns">
												<?php $this->renderPartial('_detailInsurance', array('registrationTransaction'=>$registrationTransaction)); ?>
											</div>
										</div>
									</div>
								</div>

								<div class="detail">
									<div class="field" id="damage">
										<div class="row collapse">
											<div class="small-12 columns">
												<?php $this->renderPartial('_detailDamage', array('registrationTransaction'=>$registrationTransaction,'service'=>$service,'serviceDataProvider'=>$serviceDataProvider,'product'=>$product,'productDataProvider'=>$productDataProvider)); ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- END DETAIL INSURANCE -->
						</div>

						<div class="row">
							<div class="medium-12 columns">

								<div class="field">
									<div class="row collapse">

										<div class="small-4 columns">
											<label class="prefix">Service</label>
										</div>
										<div class="small-8 columns">
											<?php echo CHtml::button('add Service', array(
												'id' => 'service-detail-button',
												'name' => 'service-detail',
												// 'class'=>'button extra left',
												//'disabled'=>'false',
												'onclick' => '
												jQuery("#service-dialog").dialog("open"); return false;'
												)
											); 
											?>
										</div>
									</div>
								</div>

								<div class="detail">
									<div class="field" id="service">
										<div class="row collapse">
											<div class="small-12 columns">
												<?php $this->renderPartial('_detailService', array('registrationTransaction'=>$registrationTransaction)); ?>
											</div>
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<label class="prefix">Product</label>
										</div>
										<div class="small-8 columns">
											<?php echo CHtml::button('add Product', array(
												'id' => 'product-detail-button',
												'name' => 'product-detail',
												// 'class'=>'button extra left',
												//'disabled'=>'false',
												'onclick' => '
												jQuery("#product-dialog").dialog("open"); return false;'
												)
											); 
											?>
											<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
												'id' => 'product-dialog',
												'options' => array(
													'title' => 'Product',
													'autoOpen' => false,
													'width' => 'auto',
													'modal' => true,
													),)
											);
											?>

											<?php $this->widget('zii.widgets.grid.CGridView', array(
												'id'=>'product-grid',
												'dataProvider'=>$productDataProvider,
												'filter'=>$product,
												'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
												'pager'=>array(
													'cssFile'=>false,
													'header'=>'',
													),
												'selectionChanged'=>'js:function(id){
													$("#product-dialog").dialog("close");
													$.ajax({
														type: "POST",
														//dataType: "JSON",
														url: "' . CController::createUrl('ajaxHtmlAddProductDetail', array('id'=>$registrationTransaction->header->id,'productId'=>'')). '" + $.fn.yiiGridView.getSelection(id),
														data:$("form").serialize(),
														success: function(html) {
															$("#product").html(html);

														},
													});
													$("#product-grid").find("tr.selected").each(function(){
														$(this).removeClass( "selected" );
													});
												}',
												'columns'=>array(
                                                    'id',
													'manufacturer_code',
													'name',
													//'product_master_category_id',
//													array('name'=>'product_master_category_name', 'value'=>'$data->productMasterCategory->name'),
													//'product_sub_master_category_id',
//													array('name'=>'product_sub_master_category_name', 'value'=>'$data->productSubMasterCategory->name'),
													//'product_sub_category_id',
//													array('name'=>'product_sub_category_name', 'value'=>'$data->productSubCategory->name'),
													array('name'=>'product_brand_name', 'value'=>'$data->brand->name'),
                                                    'product_sub_brand_name: Sub Brand',
                                                    'product_sub_brand_series_name: Sub Brand Series',
                                                    'masterSubCategoryCode',
                                                    array('name'=>'unit_id', 'value'=>'$data->unit->name'),
//													'production_year',
                                                    array(
                                                        'name'=>'retail_price',
                                                        'header' => 'Price',
                                                        'value'=>'Yii::app()->numberFormatter->format("#,##0.00", $data->retail_price)',
                                                    ),
                                                    'vehicleCarMake.name: Car',
													),
												)
											);
											?>
											<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
										</div>
									</div>
								</div>

								<div class="detail">
									<div class="field" id="product">
										<div class="row collapse">
											<div class="small-12 columns">
												<?php $this->renderPartial('_detailProduct', array('registrationTransaction'=>$registrationTransaction)); ?>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>


						<hr />
                        
    <div class="row">
        <div class="field">
            <table>
                <tr>
                    <td><?php echo $form->labelEx($registrationTransaction->header,'total_quickservice'); ?></td>
                    <td style="text-align: right">
                        <?php echo $form->hiddenField($registrationTransaction->header,'total_quickservice',array('readonly'=>true)); ?>
                        <span id="total_quick_service_quantity">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'total_quickservice'))); ?>                                                
                        </span>
                        <?php echo $form->error($registrationTransaction->header,'total_quickservice'); ?>
                    </td>
                    <td colspan="4">&nbsp;</td>
                    <td><?php echo $form->labelEx($registrationTransaction->header,'total_quickservice_price'); ?></td>
                    <td style="text-align: right">
                        <?php echo $form->hiddenField($registrationTransaction->header,'total_quickservice_price',array('size'=>18,'maxlength'=>18,'readonly'=>true, )); ?>
                        <span id="sub_total_quick_service">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'total_quickservice_price'))); ?>
                        </span>
                        <?php echo $form->error($registrationTransaction->header,'total_quickservice_price'); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($registrationTransaction->header,'total_service'); ?></td>
                    <td style="text-align: right">
                        <?php echo $form->hiddenField($registrationTransaction->header,'total_service', array('readonly'=>true)); ?>
                        <span id="total_quantity_service">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'total_service'))); ?>
                        </span>
                        <?php echo $form->error($registrationTransaction->header,'total_service'); ?>
                    </td>
                    <td><?php echo $form->labelEx($registrationTransaction->header,'subtotal_service'); ?></td>
                    <td style="text-align: right">
                        <?php echo $form->hiddenField($registrationTransaction->header,'subtotal_service',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                        <span id="sub_total_service">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'subtotal_service'))); ?>
                        </span>
                        <?php echo $form->error($registrationTransaction->header,'subtotal_service'); ?>
                    </td>
                    <td><?php echo $form->labelEx($registrationTransaction->header,'discount_service'); ?></td>
                    <td style="text-align: right">
                        <?php echo $form->hiddenField($registrationTransaction->header,'discount_service',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                        <span id="total_discount_service">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'discount_service'))); ?>
                        </span>
                        <?php echo $form->error($registrationTransaction->header,'discount_service'); ?>
                    </td>
                    <td><?php echo $form->labelEx($registrationTransaction->header,'total_service_price'); ?></td>
                    <td style="text-align: right">
                        <?php echo $form->hiddenField($registrationTransaction->header,'total_service_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                        <span id="grand_total_service">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'total_service_price'))); ?>
                        </span>
                        <?php echo $form->error($registrationTransaction->header,'total_service_price'); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($registrationTransaction->header,'total_product'); ?></td>
                    <td style="text-align: right">
                        <?php echo $form->hiddenField($registrationTransaction->header,'total_product',array('size'=>10,'maxlength'=>10,'readonly'=>true)); ?>
                        <span id="total_quantity_product">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'total_product'))); ?>
                        </span>
                        <?php echo $form->error($registrationTransaction->header,'total_product'); ?>
                    </td>
                    <td><?php echo $form->labelEx($registrationTransaction->header,'subtotal_product'); ?></td>
                    <td style="text-align: right">
                        <?php echo $form->hiddenField($registrationTransaction->header,'subtotal_product',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                        <span id="sub_total_product">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'subtotal_product'))); ?>
                        </span>
                        <?php echo $form->error($registrationTransaction->header,'subtotal_product'); ?>
                    </td>
                    <td><?php echo $form->labelEx($registrationTransaction->header,'discount_product'); ?></td>
                    <td style="text-align: right">
                        <?php echo $form->hiddenField($registrationTransaction->header,'discount_product',array('size'=>18,'maxlength'=>18,'readonly'=>true,'class'=>'numbers')); ?>
                        <span id="total_discount_product">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'discount_product'))); ?>
                        </span>
                        <?php echo $form->error($registrationTransaction->header,'discount_product'); ?>
                    </td>
                    <td><?php echo $form->labelEx($registrationTransaction->header,'total_product_price'); ?></td>
                    <td style="text-align: right">
                        <?php echo $form->hiddenField($registrationTransaction->header,'total_product_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                        <span id="grand_total_product">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'total_product_price'))); ?>
                        </span>
                        <?php echo $form->error($registrationTransaction->header,'total_product_price'); ?>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold"><?php echo $form->labelEx($registrationTransaction->header,'subtotal'); ?></td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo $form->hiddenField($registrationTransaction->header,'subtotal',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                        <span id="sub_total_transaction">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'subtotal'))); ?>
                        </span>
                        <?php echo $form->error($registrationTransaction->header,'subtotal'); ?>
                    </td>
                    <td style="font-weight: bold"><?php echo $form->labelEx($registrationTransaction->header,'ppn_price'); ?></td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo $form->hiddenField($registrationTransaction->header,'ppn_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                        <span id="tax_item_amount">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'ppn_price'))); ?>
                        </span>
                        <?php echo $form->error($registrationTransaction->header,'ppn_price'); ?>
                    </td>
                    <td style="font-weight: bold"><?php echo $form->labelEx($registrationTransaction->header,'pph_price'); ?></td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo $form->hiddenField($registrationTransaction->header,'pph_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                        <span id="tax_service_amount">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'pph_price'))); ?>
                        </span>
                        <?php echo $form->error($registrationTransaction->header,'pph_price'); ?>
                    </td>
                    <td style="font-weight: bold"><?php echo $form->labelEx($registrationTransaction->header,'grand_total'); ?></td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo $form->hiddenField($registrationTransaction->header,'grand_total',array('size'=>18,'maxlength'=>18,'readonly'=>true)); ?>
                        <span id="grand_total_transaction">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'grand_total'))); ?>
                        </span>
                        <?php echo $form->error($registrationTransaction->header,'grand_total'); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
<!--						<div class="row">
							<div class="medium-6 columns">

								<div class="field">
									<div class="row collapse">
										<div class="small-12 columns">
											<?php /*echo CHtml::button('Estimate Billing', array(
												'id' => 'total-button',
												'name' => 'total',
												'onclick' => '
												// noCommas();
												$.ajax({
													type: "POST",
													url: "' . CController::createUrl('ajaxEstimateBilling', array('id' => $registrationTransaction->header->id,)) . '",
													data: $("form").serialize(),
													dataType: "json",
													success: function(data) {
								                      //console.log(data.total);
														console.log(data.totalQs);
														console.log(data.subtotal);
														console.log(data.ppn);
														console.log(data.pph);
														console.log(data.grandTotal);

														$("#RegistrationTransaction_total_quickservice").val(data.totalQs);
														$("#RegistrationTransaction_total_quickservice_price").val(data.totalQsPrice);
														$("#RegistrationTransaction_total_service").val(data.totalService);
														$("#RegistrationTransaction_subtotal_service").val(data.subtotalService);
														$("#RegistrationTransaction_discount_service").val(data.discountService);
														$("#RegistrationTransaction_total_service_price").val(data.totalServicePrice);
														$("#RegistrationTransaction_total_product").val(data.totalProduct);
														$("#RegistrationTransaction_subtotal_product").val(data.subtotalProduct);
														$("#RegistrationTransaction_discount_product").val(data.discountProduct);
														$("#RegistrationTransaction_total_product_price").val(data.totalProductPrice);
														$("#RegistrationTransaction_grand_total").val(data.grandTotal);
														$("#RegistrationTransaction_subtotal").val(data.subtotal);
														$("#RegistrationTransaction_ppn_price").val(data.ppn);
														$("#RegistrationTransaction_pph_price").val(data.pph);
														$("#total_quickservice").html(data.totalQsFormatted);
														$("#total_quickservice_price").html(data.totalQsPriceFormatted);
														$("#total_service").html(data.totalServiceFormatted);
														$("#subtotal_service").html(data.subtotalServiceFormatted);
														$("#discount_service").html(data.discountServiceFormatted);
														$("#total_service_price").html(data.totalServicePriceFormatted);
														$("#total_product").html(data.totalProductFormatted);
														$("#subtotal_product").html(data.subtotalProductFormatted);
														$("#discount_product").html(data.discountProductFormatted);
														$("#total_product_price").html(data.totalProductPriceFormatted);
														$("#grand_total").html(data.grandTotalFormatted);
														$("#subtotal").html(data.subtotalFormatted);
														$("#ppn_price").html(data.ppnFormatted);
														$("#pph_price").html(data.pphFormatted);
													},
												});',)
											); 
											?>
										</div>
									</div>
								</div>
								<br />

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'total_quickservice'); ?></label>
										</div>
										<div class="small-8 columns">
											<?php echo $form->hiddenField($registrationTransaction->header,'total_quickservice',array('readonly'=>true)); ?>
                                            <span id="total_quick_service_quantity">
                                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'total_quickservice'))); ?>                                                
                                            </span>
											<?php echo $form->error($registrationTransaction->header,'total_quickservice'); ?>
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'total_quickservice_price'); ?></label>
										</div>
										<div class="small-8 columns">
											<?php echo $form->hiddenField($registrationTransaction->header,'total_quickservice_price',array('size'=>18,'maxlength'=>18,'readonly'=>true, )); ?>
                                            <span id="sub_total_quick_service">
                                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'total_quickservice_price'))); ?>
                                            </span>
											<?php echo $form->error($registrationTransaction->header,'total_quickservice_price'); ?>
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'total_service'); ?></label>
										</div>
										<div class="small-8 columns">
											<?php echo $form->hiddenField($registrationTransaction->header,'total_service', array('readonly'=>true)); ?>
                                            <span id="total_quantity_service">
                                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'total_service'))); ?>
                                            </span>
											<?php echo $form->error($registrationTransaction->header,'total_service'); ?>
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'subtotal_service'); ?></label>
										</div>
										<div class="small-8 columns">
											<?php echo $form->hiddenField($registrationTransaction->header,'subtotal_service',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                            <span id="sub_total_service">
                                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'subtotal_service'))); ?>
                                            </span>
											<?php echo $form->error($registrationTransaction->header,'subtotal_service'); ?>
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'discount_service'); ?></label>
										</div>
										<div class="small-8 columns">
											<?php echo $form->hiddenField($registrationTransaction->header,'discount_service',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                            <span id="total_discount_service">
                                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'discount_service'))); ?>
                                            </span>
											<?php echo $form->error($registrationTransaction->header,'discount_service'); ?>
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'total_service_price'); ?></label>
										</div>
										<div class="small-8 columns">
											<?php echo $form->hiddenField($registrationTransaction->header,'total_service_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                            <span id="grand_total_service">
                                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'total_service_price'))); ?>
                                            </span>
											<?php echo $form->error($registrationTransaction->header,'total_service_price'); ?>
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'total_product'); ?></label>
										</div>
										<div class="small-8 columns">
											<?php echo $form->hiddenField($registrationTransaction->header,'total_product',array('size'=>10,'maxlength'=>10,'readonly'=>true)); ?>
                                            <span id="total_quantity_product">
                                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'total_product'))); ?>
                                            </span>
											<?php echo $form->error($registrationTransaction->header,'total_product'); ?>
										</div>
									</div>
									<div class="field">
										<div class="row collapse">
											<div class="small-4 columns">
												<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'subtotal_product'); ?></label>
											</div>
											<div class="small-8 columns">
												<?php echo $form->hiddenField($registrationTransaction->header,'subtotal_product',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="sub_total_product">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'subtotal_product'))); ?>
                                                </span>
												<?php echo $form->error($registrationTransaction->header,'subtotal_product'); ?>
											</div>
										</div>
									</div>
									<div class="field">
										<div class="row collapse">
											<div class="small-4 columns">
												<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'discount_product'); ?></label>
											</div>
											<div class="small-8 columns">
												<?php echo $form->hiddenField($registrationTransaction->header,'discount_product',array('size'=>18,'maxlength'=>18,'readonly'=>true,'class'=>'numbers')); ?>
                                            <span id="total_discount_product">
                                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'discount_product'))); ?>
                                            </span>
												<?php echo $form->error($registrationTransaction->header,'discount_product'); ?>
											</div>
										</div>
									</div>
									<div class="field">
										<div class="row collapse">
											<div class="small-4 columns">
												<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'total_product_price'); ?></label>
											</div>
											<div class="small-8 columns">
												<?php echo $form->hiddenField($registrationTransaction->header,'total_product_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                            <span id="grand_total_product">
                                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'total_product_price'))); ?>
                                            </span>
												<?php echo $form->error($registrationTransaction->header,'total_product_price'); ?>
											</div>
										</div>
									</div>
									<div class="field">
										<div class="row collapse">
											<div class="small-4 columns">
												<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'subtotal'); ?></label>
											</div>
											<div class="small-8 columns">
												<?php echo $form->hiddenField($registrationTransaction->header,'subtotal',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="sub_total_transaction">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'subtotal'))); ?>
                                                </span>
												<?php echo $form->error($registrationTransaction->header,'subtotal'); ?>
											</div>
										</div>
									</div>
									<div class="field">
										<div class="row collapse">
											<div class="small-4 columns">
												<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'ppn_price'); ?></label>
											</div>
											<div class="small-8 columns">
												<?php echo $form->hiddenField($registrationTransaction->header,'ppn_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="tax_item_amount">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'ppn_price'))); ?>
                                                </span>
												<?php echo $form->error($registrationTransaction->header,'ppn_price'); ?>
											</div>
										</div>
									</div>
									<div class="field">
										<div class="row collapse">
											<div class="small-4 columns">
												<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'pph_price'); ?></label>
											</div>
											<div class="small-8 columns">
												<?php echo $form->hiddenField($registrationTransaction->header,'pph_price',array('size'=>18,'maxlength'=>18,'readonly'=>true,)); ?>
                                                <span id="tax_service_amount">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'pph_price'))); ?>
                                                </span>
												<?php echo $form->error($registrationTransaction->header,'pph_price'); ?>
											</div>
										</div>
									</div>
									<div class="field">
										<div class="row collapse">
											<div class="small-4 columns">
												<label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'grand_total'); ?></label>
											</div>
											<div class="small-8 columns">
												<?php echo $form->hiddenField($registrationTransaction->header,'grand_total',array('size'=>18,'maxlength'=>18,'readonly'=>true)); ?>
                                                <span id="grand_total_transaction">
                                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($registrationTransaction->header,'grand_total'))); ?>
                                                </span>
												<?php echo $form->error($registrationTransaction->header,'grand_total');*/ ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>-->

						<hr />
						<div class="row">
							<div class="medium-12 columns">
								<div class="field buttons text-center">
									<?php echo CHtml::submitButton($registrationTransaction->header->isNewRecord ? 'Create' : 'Save' , array('class'=>'button cbutton')); ?>
								</div>
							</div>
						</div>
					</div>
				</div> <!-- end row -->
			</div>
		</div>
		<?php $this->endWidget(); ?>

	</div><!-- form -->
</div>

	<!-- Service Dialog and Grid -->
	<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id' => 'service-dialog',
		'options' => array(
			'title' => 'Service',
			'autoOpen' => false,
			'width' => 'auto',
			'modal' => true,
			),)
	);
	?>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
	)); ?>
	<div class="row">
        <div class="medium-6 columns">
			<?php echo $form->textField($service,'findkeyword', array('placeholder'=>'Find By Keyword', "style"=>"margin-bottom:0px;")); ?>
		</div>
    </div>
		<?php $this->endWidget(); ?>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'service-grid',
		'dataProvider'=>$serviceDataProvider,
		'filter'=>$service,
		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
		'pager'=>array(
			'cssFile'=>false,
			'header'=>'',
			),
		'selectionChanged'=>'js:function(id){

			$("#service-dialog").dialog("close");
			var vehicle = +$("#RegistrationTransaction_vehicle_id").val();
			var repair = +$("#RegistrationTransaction_repair_type").val();
			if((vehicle != "") && repair !=""){
				$.ajax({
					type: "POST",
					url: "' . CController::createUrl('ajaxHtmlAddServiceDetail', array('id'=> $registrationTransaction->header->id)).'&serviceId="+$.fn.yiiGridView.getSelection(id)+"&customerId="+ $("#RegistrationTransaction_customer_id").val()+"&custType="+$("#Customer_customer_type").val()+"&vehicleId="+$("#RegistrationTransaction_vehicle_id").val()+"&repair="+$("#RegistrationTransaction_repair_type").val(),
					data: $("form").serialize(),
					success: function(html) {
						$("#service").html(html);
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $registrationTransaction->header->id)). '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#grand_total").html(data.grandTotal);
                                $("#total_quantity_service").html(data.totalQuantityService);
                                $("#sub_total_service").html(data.subTotalService);
                                $("#total_discount_service").html(data.totalDiscountService);
                                $("#grand_total_service").html(data.grandTotalService);
                                $("#sub_total_transaction").html(data.subTotalTransaction);
                                $("#tax_item_amount").html(data.taxItemAmount);
                                $("#tax_service_amount").html(data.taxServiceAmount);
                                $("#grand_total_transaction").html(data.grandTotal);
                            },
                        });
					},
				});
			}
			else{
				alert("Please Check if you had already choose Repair type and Vehicle.");
			}
			
			$("#service-grid").find("tr.selected").each(function(){
				$(this).removeClass( "selected" );
			});
		}',
		'columns'=>array(
			//'id',
			'code',
			'name',
			),
		)
	);
	?>
	<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

	<!-- Damage Dialog and Grid -->
	<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id' => 'damage-dialog',
		'options' => array(
			'title' => 'Service',
			'autoOpen' => false,
			'width' => 'auto',
			'modal' => true,
			),)
	);
	?>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
	)); ?>
	<div class="row">
        <div class="medium-6 columns">
			<input id="Damage_findkeyword" placeholder="Find By Keyword" style="margin-bottom:0px;" name="Service[findkeyword]" type="text">
			<?php //echo $form->textField(,'findkeyword', array('placeholder'=>'Find By Keyword', "style"=>"margin-bottom:0px;")); ?>
		</div>
    </div>
    <?php $this->endWidget(); ?>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'damage-grid',
		'dataProvider'=>$serviceDataProvider,
		'filter'=>$service,
		'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
		'pager'=>array(
			'cssFile'=>false,
			'header'=>'',
        ),
		'selectionChanged'=>'js:function(id){
            $("#damage-dialog").dialog("close");
            $.ajax({
                type: "POST",
                //dataType: "JSON",
                url: "' . CController::createUrl('ajaxHtmlAddDamageDetail', array('id'=> $registrationTransaction->header->id,'repair'=>'')).'" + $("#RegistrationTransaction_repair_type").val()+"&serviceId="+$.fn.yiiGridView.getSelection(id),
                data:$("form").serialize(),
                success: function(html) {
                    $("#damage").html(html);
                },
            });
					
			$("#damage-grid").find("tr.selected").each(function(){
				$(this).removeClass( "selected" );
			});
		}',
		'columns'=>array(
			//'id',
			'code',
			'name',
			),
		)
	);
	?>
	<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
	
<script>
	
	function ClearFields() {

		$('#pic').find('input:text').val('');
		$('#CustomerPic_address').val('');
	}
	    if($("#RegistrationTransaction_repair_type").val() == "GR")
    {
        $("#RegistrationTransaction_is_quick_service").prop("disabled",false);
        $("#RegistrationTransaction_is_insurance").prop("disabled",true);
        $("#damage-data-button").prop("disabled",true);
        $("#RegistrationTransaction_is_insurance").attr("checked", false);
        $("#RegistrationTransaction_insurance_company_id").val("");
        $("#RegistrationTransaction_insurance_company_id").prop("disabled",true);

    }
    else if($("#RegistrationTransaction_repair_type").val() == "BR")
    {
        $("#RegistrationTransaction_is_quick_service").prop("disabled",true);
        $("#RegistrationTransaction_is_insurance").prop("disabled",false);
        $("#damage-data-button").prop("disabled",false);
        $("#RegistrationTransaction_is_quick_service").attr("checked", false);
    }
    else
    {
        $("#RegistrationTransaction_is_quick_service").prop("disabled",true);
        $("#RegistrationTransaction_is_insurance").prop("disabled",true);
        $("#damage-data-button").prop("disabled",true);
    }

</script>
<?php 
	Yii::app()->clientScript->registerScript('search',"
	// 	$('form').submit(function(){
	// 	$('#service-grid').yiiGridView('update', {
	//              data: $(this).serialize()
	//     });
	//     return false;
	// });
    	$('#Service_findkeyword').keypress(function(e) {
				$.fn.yiiGridView.update('service-grid', {
					data: $(this).serialize()
				});
		    if(e.which == 13) {
		        return false;
		    }
		});
	$('#Damage_findkeyword').keypress(function(e) {
		    if(e.which == 13) {
				$.fn.yiiGridView.update('damage-grid', {
					data: $(this).serialize()
				});
		        return false;
		    }
		});

		
	
    ");
	
?>
	

<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScript('myjavascript', '
		$(".numbers").number( true,2, ".", ",");
    ', CClientScript::POS_END);
?>