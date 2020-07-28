<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Registration Transactions'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('index')),
	array('label'=>'Create RegistrationTransaction', 'url'=>array('create')),
	array('label'=>'Update RegistrationTransaction', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RegistrationTransaction', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RegistrationTransaction', 'url'=>array('admin')),
);
?>
	<div class="small-12 columns">
		<div id="maincontent">
			<div class="clearfix page-action">
					<?php $ccontroller = Yii::app()->controller->id; ?>
					<?php $ccaction = Yii::app()->controller->action->id; ?>
					<?php $invoices = InvoiceHeader::model()->findAllByAttributes(array('registration_transaction_id'=>$model->id)); ?>
					<div class="row">
						<div class="large-12 columns">
							<?php echo CHtml::link('<span class="fa fa-list"></span>Manage Registration', Yii::app()->baseUrl.'/frontDesk/registrationTransaction/admin', array('class'=>'button cbutton left','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("frontDesk.registrationTransaction.admin"))) ?>
								
								<?php if ($model->status != 'Finished' ): ?>
									
									<?php if (count($invoices)== 0): ?>
										<?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl.'/frontDesk/registrationTransaction/update?id=' . $model->id, array('class'=>'button cbutton left','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("frontDesk.registrationTransaction.update"))) ?>
									<?php endif ?>
									
				
									<?php if (Yii::app()->user->checkAccess("transaction.registrationTrasaction.generateSalesOrder")): ?>
										<?php echo CHtml::button('Generate Sales Order', array(
											'id' => 'detail-button',
											'name' => 'Detail',
											'class'=>'button cbutton left',
											'style'=>'margin-right:10px',
											'disabled'=>$model->sales_order_number == null ? false : true,
											'onclick' => ' 
												$.ajax({
												type: "POST",
												//dataType: "JSON",
												url: "' . CController::createUrl('generateSalesOrder', array('id'=> $model->id)) . '",
												data: $("form").serialize(),
												success: function(html) {
													
													alert("Sales Order Succesfully Generated");
													location.reload();
												},})
											'
											)); ?>
									<?php endif ?>
									
								
								<?php 
									$servicesReg = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$model->id,'is_body_repair'=>0));
                                    $quickServicesReg = RegistrationQuickService::model()->findByAttributes(array('registration_transaction_id'=>$model->id)); 
                                ?>
									<?php if (empty($servicesReg) && empty($quickServicesReg) && empty($model->sales_order_number)) : ?>
									
										<?php echo CHtml::button('Generate Work Order', array(
												'id' => 'detail-button',
												'name' => 'Detail',
												'class'=>'button cbutton left',
												'style'=>'margin-right:10px',
												'disabled'=>true,
												'onclick' => ' 
													
												'
												)); ?>
									<?php else : ?>
										<?php if (Yii::app()->user->checkAccess("transaction.registrationTrasaction.generateWorkOrder")): ?>
										<?php echo CHtml::button('Generate Work Order', array(
												'id' => 'detail-button',
												'name' => 'Detail',
												'class'=>'button cbutton left',
												'style'=>'margin-right:10px',
												'disabled'=>$model->work_order_number == null ? false : true,
												'onclick' => ' 
													$.ajax({
													type: "POST",
													//dataType: "JSON",
													url: "' . CController::createUrl('generateWorkOrder', array('id'=> $model->id)) . '",
													data: $("form").serialize(),
													success: function(html) {
														
														alert("Work Order Succesfully Generated");
														location.reload();
													},})
												'
												)); ?>
										<?php endif ?>
									<?php endif ?>		
								
								

								
							<?php endif ?>
							<?php if (Yii::app()->user->checkAccess("transaction.registrationTrasaction.showRealization")): ?>
								<?php echo CHtml::button('Show Realization', array(
								'id' => 'real-button',
								'name' => 'Real',
								'class'=>'button cbutton left',
								'onclick' => ' 
									window.location.href = "showRealization?id='.$model->id .'";'
								)); ?>
							<?php endif ?>
							<?php if (Yii::app()->user->checkAccess("transaction.registrationTrasaction.generateInvoice")): ?>
								
								<?php if (count($invoices)== 0): ?>
									<?php echo CHtml::button('Generate Invoice', array(
									'id' => 'invoice-button',
									'name' => 'Invoice',
									'class'=>'button cbutton left',
									'style'=>'margin-left:10px',
									//'disabled'=>$model->sales_order_number == "" ? true : false,
									'onclick' => ' 
										$.ajax({
										type: "POST",
										//dataType: "JSON",
										url: "' . CController::createUrl('generateInvoice', array('id'=> $model->id)) . '",
										data: $("form").serialize(),
										success: function(html) {
											
											alert("Invoice Succesfully Generated");
											location.reload();
										},})
									'
									)); ?>
								<?php /*else: ?>
									<?php echo CHtml::button('Generate Invoice', array(
									'id' => 'invoice-button',
									'name' => 'Invoice',
									'class'=>'button cbutton left',
									'style'=>'margin-left:10px',
									//'disabled'=>$model->sales_order_number == "" ? true : false,
									'onclick' => ' 
										if(confirm("Invoice for this registration has been created. are you sure to reGENERATE it?")){
											$.ajax({
											type: "POST",
											//dataType: "JSON",
											url: "' . CController::createUrl('generateInvoice', array('id'=> $model->id)) . '",
											data: $("form").serialize(),
											success: function(html) {
												
												alert("Invoice Succesfully Generated");
												location.reload();
											},})
										}
										else{
											alert("No new invoice generated.");
										}
										
									'
									));*/ ?>
								<?php endif ?>
								
							<?php endif ?>
							
								
						</div>
						
					</div>
					
					
				
				
					
					<h1>View RegistrationTransaction #<?php echo $model->transaction_number; ?></h1>

					<?php 
					// $this->widget('zii.widgets.CDetailView', array(
					// 	'data'=>$model,
					// 	'attributes'=>array(
					// 		//'id',
					// 		'transaction_number',
					// 		'transaction_date',
					// 		'sales_order_number',
					// 		'work_order_number',
					// 		'repair_type',
					// 		'problem',
					// 		'status',
					// 		array('name'=>'customer_name','value'=>$model->customer->name),
					// 		array('name'=>'pic_name','value'=>$model->pic != null ?$model->pic->name : '-'),
					// 		array('name'=>'plate_number','value'=>$model->vehicle != null ?$model->vehicle->plate_number : '-'),
					// 		//'customer_id',
					// 		//'pic_id',
					// 		//'vehicle_id',
					// 		'branch_id',
					// 		'user_id',
					// 		'total_quickservice',
					// 		array('name'=>'total_quickservice_price','value'=>$model->total_quickservice_price,'type'=>'number'),
					// 		//'total_quickservice_price',
					// 		'total_service',
					// 		array('name'=>'subtotal_service','value'=>$model->subtotal_service,'type'=>'number'),
					// 		array('name'=>'discount_service','value'=>$model->discount_service,'type'=>'number'),
					// 		array('name'=>'total_service_price','value'=>$model->total_service_price,'type'=>'number'),
					// 		//number_format('subtotal_service',2,'','.'),
					// 		// 'subtotal_service',
					// 		// 'discount_service',
					// 		// 'total_service_price',
					// 		'total_product',
					// 		array('name'=>'subtotal_product','value'=>$model->subtotal_product,'type'=>'number'),
					// 		array('name'=>'discount_product','value'=>$model->discount_product,'type'=>'number'),
					// 		array('name'=>'total_product_price','value'=>$model->total_product_price,'type'=>'number'),

					// 		// 'subtotal_product',
					// 		// 'discount_product',
					// 		// 'total_product_price',
					// 	),
					// )); 
					?>
					<fieldset>
						<legend>Transaction</legend>
						<div class="row">
							<div class="large-12 columns">
								
									<div class="large-6 columns">

										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<span class="prefix">Transaction #</span>
												</div>
												<div class="small-8 columns">
													<input type="text" readonly="true" value="<?php echo $model->transaction_number; ?>"> 
												</div>
											</div>
										</div>

										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<span class="prefix">Transaction Date</span>
												</div>
												<div class="small-8 columns">
													<input type="text" readonly="true" value="<?php echo $model->transaction_date; ?>"> 
												</div>
											</div>
										</div>

										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<span class="prefix">Repair Type</span>
												</div>
												<div class="small-8 columns">
													<input type="text" readonly="true" value="<?php echo $model->repair_type; ?>"> 
												</div>
											</div>
										</div>
	
										
										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<span class="prefix">Status</span>
												</div>
												<div class="small-8 columns">
													<input type="text" readonly="true" value="<?php echo $model->status; ?>"> 
												</div>
											</div>
										</div>
										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<span class="prefix">Problem</span>
												</div>
												<div class="small-8 columns">
													<textarea name="" id="" cols="30" rows="5" readonly="true"><?php echo $model->problem; ?></textarea>
												</div>
											</div>
										</div>

										<?php if ($model->is_insurance == 1): ?>
											<div class="field">
												<div class="row collapse">
													<div class="small-4 columns">
														<span class="prefix">Insurance Company</span>
													</div>
													<div class="small-8 columns">
														<input type="text" readonly="true" value="<?php echo $model->insuranceCompany->name; ?>"> 
													</div>
												</div>
											</div>
											
										<?php endif ?>

									</div> <!-- end div large -->
								
								
									<div class="large-6 columns">

										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<span class="prefix">Sales Order #</span>
												</div>
												<div class="small-8 columns">
													<input type="text" readonly="true" value="<?php echo $model->sales_order_number; ?>"> 
												</div>
											</div>
										</div>

										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<span class="prefix">Sales Order Date</span>
												</div>
												<div class="small-8 columns">
													<input type="text" readonly="true" value="<?php echo $model->sales_order_date; ?>"> 
												</div>
											</div>
										</div>
	
										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<span class="prefix">Work Order #</span>
												</div>
												<div class="small-8 columns">
													<input type="text" readonly="true" value="<?php echo $model->work_order_number; ?>"> 
												</div>
											</div>
										</div>

										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<span class="prefix">Work Order date</span>
												</div>
												<div class="small-8 columns">
													<input type="text" readonly="true" value="<?php echo $model->work_order_date; ?>"> 
												</div>
											</div>
										</div>

										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<span class="prefix">Invoice #</span>
												</div>
												<div class="small-8 columns">
													<?php $invoiceCriteria = new CDbCriteria;
												        	$invoiceCriteria->addCondition("status != 'CANCELLED'");
												        	$invoiceCriteria->addCondition("registration_transaction_id = ".$model->id);
												         ?>
												          <?php $invoice = InvoiceHeader::model()->find($invoiceCriteria) ?>
												          <input type="text" readonly="true" value="<?php echo count($invoice) >0 ? $invoice->invoice_number: ''; ?>"> 
												        
												</div>
											</div>
										</div>
										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<span class="prefix">User ID</span>
												</div>
												<div class="small-8 columns">
													<input type="text" readonly="true" value="<?php echo $model->user!= null ? $model->user->username : ''; ?>"> 
												</div>
											</div>
										</div>
										<div class="field">
											<div class="row collapse">
												<div class="small-4 columns">
													<span class="prefix">Branch</span>
												</div>
												<div class="small-8 columns">
													<input type="text" readonly="true" value="<?php echo $model->branch!= null ? $model->branch->name : ''; ?>">
												</div>
											</div>
										</div>
									</div><!-- end div large -->
								
							</div>
						</div>
					</fieldset>
				</div>
		</div>
		<div>
			<fieldset>
				<legend>Billing Estimation</legend>
				<div class="row">
					<div class="large-12 columns">
						
						<div class="large-6 columns">

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<span class="prefix">Total Quick Service</span>
									</div>
									<div class="small-8 columns">
										<input type="text" readonly="true" value="<?php echo $model->total_quickservice; ?>"> 
									</div>
								</div>
							</div>

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<span class="prefix">Total Quick Service Price</span>
									</div>
									<div class="small-8 columns">
										<input type="text" readonly="true" value="<?php echo number_format($model->total_quickservice_price,2); ?>"> 
									</div>
								</div>
							</div>

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<span class="prefix">Total Service</span>
									</div>
									<div class="small-8 columns">
										<input type="text" readonly="true" value="<?php echo $model->total_service; ?>"> 
									</div>
								</div>
							</div>
							
							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<span class="prefix">Service Discount</span>
									</div>
									<div class="small-8 columns">
										<input type="text" readonly="true" value="<?php echo number_format($model->discount_service,2); ?>"> 
									</div>
								</div>
							</div>

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<span class="prefix">Total Service Price</span>
									</div>
									<div class="small-8 columns">
										<input type="text" readonly="true" value="<?php echo number_format($model->total_service_price,2); ?>"> 
									</div>
								</div>
							</div>

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<span class="prefix">Total Product</span>
									</div>
									<div class="small-8 columns">
										<input type="text" readonly="true" value="<?php echo $model->total_product; ?>"> 
									</div>
								</div>
							</div>

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<span class="prefix">Discount Product</span>
									</div>
									<div class="small-8 columns">
										<input type="text" readonly="true" value="<?php echo number_format($model->discount_product,2); ?>"> 
									</div>
								</div>
							</div>

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<span class="prefix">Total Product Price</span>
									</div>
									<div class="small-8 columns">
										<input type="text" readonly="true" value="<?php echo number_format($model->total_product_price,2); ?>"> 
									</div>
								</div>
							</div>

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<span class="prefix">PPN Price</span>
									</div>
									<div class="small-8 columns">
										<input type="text" readonly="true" value="<?php echo number_format($model->ppn_price,2); ?>"> 
									</div>
								</div>
							</div>

							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<span class="prefix">PPH Price</span>
									</div>
									<div class="small-8 columns">
										<input type="text" readonly="true" value="<?php echo number_format($model->pph_price,2); ?>"> 
									</div>
								</div>
							</div>
							<hr style="border:solid 2px; margin-top:0px; color:black">
							<div class="field">
								<div class="row collapse">
									<div class="small-4 columns">
										<span class="prefix">Grand Total</span>
									</div>
									<div class="small-8 columns">
										<input type="text" readonly="true" value="<?php echo number_format($model->grand_total,2); ?>"> 
									</div>
								</div>
							</div>
						</div> <!-- end div large -->
						
					
						
						
					</div>
				</div>
			</fieldset>
		</div>
		
		<div>
			<fieldset>
				<legend>Customer</legend>
				<div class="row">
					<div class="large-12 columns">
						
							<div class="large-6 columns">

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Name</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->customer->name; ?>"> 
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Type</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->customer->customer_type; ?>"> 
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Address</span>
										</div>
										<div class="small-8 columns">
											<textarea name="" id="" cols="30" rows="5" readonly="true"><?php echo $model->customer->address. '&#13;&#10;'. $model->customer->province->name . '&#13;&#10;'. $model->customer->city->name.'&#13;&#10;'.$model->customer->zipcode; ?></textarea>
										</div>
									</div>
								</div>

								


							</div> <!-- end div large -->
						
						
							<div class="large-6 columns">

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Phone</span>
										</div>
										<div class="small-8 columns">
											<?php $phones = CustomerPhone::model()->findAllByAttributes(array('customer_id'=>$model->customer_id,'status'=>'Active')); ?>
											<?php if (count($phones) > 0): ?>
												<?php foreach ($phones as $key => $phone): ?>
													<input type="text" readonly="true" value="<?php echo $phone->phone_no; ?>"> 
												<?php endforeach ?>
											<?php else: ?>
												<input type="text" readonly="true" value="<?php echo 'No Phone Registered to this Customer'; ?>">
											<?php endif ?>
											
											
										</div>
									</div>
								</div>
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Mobile</span>
										</div>
										<div class="small-8 columns">
											<?php $mobiles = CustomerMobile::model()->findAllByAttributes(array('customer_id'=>$model->customer_id,'status'=>'Active')); ?>
											<?php if (count($mobiles) > 0): ?>
												
												<?php foreach ($mobiles as $key => $mobile): ?>
													<input type="text" readonly="true" value="<?php echo $mobile->mobile_no; ?>">
													
												<?php endforeach ?>
												
											<?php else: ?>
												<input type="text" readonly="true" value="<?php echo 'No Mobile Phone Registered to this Customer'; ?>">
											<?php endif ?>
											
											
										</div>
									</div>
								</div>
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Email</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->customer->email; ?>"> 
										</div>
									</div>
								</div>
							</div><!-- end div large -->
						
					</div>
				</div>
			</fieldset>
		</div>
		<div>
		<?php if ($model->pic != null): ?>
			<fieldset>
				<legend>PIC</legend>
				<div class="row">
					<div class="large-12 columns">
						
							<div class="large-6 columns">

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Name</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->pic->name; ?>"> 
										</div>
									</div>
								</div>


								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Address</span>
										</div>
										<div class="small-8 columns">
											<textarea name="" id="" cols="30" rows="5" readonly="true"><?php echo $model->pic->address. '&#13;&#10;'. $model->pic->province->name . '&#13;&#10;'. $model->pic->city->name.'&#13;&#10;'.$model->pic->zipcode; ?></textarea>
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Email</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->customer->email; ?>"> 
										</div>
									</div>
								</div>


							</div> <!-- end div large -->
						
						
							
						
					</div>
				</div>
			</fieldset>
		<?php endif ?>
			
		</div>
		<div>
			<fieldset>
				<legend>Vehicle</legend>
				<div class="row">
					<div class="large-12 columns">
						
							<div class="large-6 columns">

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Plate Number</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->vehicle->plate_number; ?>"> 
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Machine Number</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->vehicle->machine_number; ?>"> 
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Frame Number</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->vehicle->frame_number; ?>"> 
										</div>
									</div>
								</div>
	
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Chasis Code</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->vehicle->chasis_code; ?>"> 
											
											
										</div>
									</div>
								</div>
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Power CC</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->vehicle->power; ?>"> 
											
											
										</div>
									</div>
								</div>


							</div> <!-- end div large -->
						
						
							<div class="large-6 columns">

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Car Make</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->vehicle->carMake != NULL ? $model->vehicle->carMake->name :''; ?>"> 
											
											
										</div>
									</div>
								</div>
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Car Model</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->vehicle->carModel != NULL ? $model->vehicle->carModel->name :''; ?>"> 
											
											
										</div>
									</div>
								</div>
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Car Sub Model</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->vehicle->carSubModel != NULL ? $model->vehicle->carSubModel->name :''; ?>"> 
											
											
										</div>
									</div>
								</div>

								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Color</span>
										</div>
										<div class="small-8 columns">
                                            <?php $color = Colors::model()->findByPK($model->vehicle->color_id); ?>
											<input type="text" readonly="true" value="<?php echo $color->name; ?>"> 
										</div>
									</div>
								</div>
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<span class="prefix">Mileage (KM)</span>
										</div>
										<div class="small-8 columns">
											<input type="text" readonly="true" value="<?php echo $model->vehicle_mileage; ?>"> 
										</div>
									</div>
								</div>
							</div><!-- end div large -->
						
					</div>
				</div>
			</fieldset>
		</div>
		
	<div class="detail">
	<fieldset>
		<legend>Details</legend>
		<?php $tabsArray = array(); 
					$tabsArray['Quick Service'] = array('id'=>'quickService','content'=>$this->renderPartial(
                                        '_viewQuickService',
                                        array('quickServices'=>$quickServices,'ccontroller'=>$ccontroller,'model'=>$model),TRUE));
					$tabsArray['Service'] =array('id'=>'service','content'=>$this->renderPartial(
                                        '_viewServices',
                                        array('services'=>$services),TRUE));
					$tabsArray['Product'] = array('id'=>'product','content'=>$this->renderPartial(
                                        '_viewProducts',
                                        array('products'=>$products,'model'=>$model),TRUE));
					$tabsArray['History']=  array('id'=>'history','content'=>$this->renderPartial(
                                        '_viewHistory',
                                        array('model'=>$model),TRUE));
					$tabsArray['Inspection']=  array('id'=>'inspection','content'=>$this->renderPartial(
                                        '_viewInspection',
                                        array('model'=>$model),TRUE));
					
				if ($model->repair_type == 'BR'){
					$tabsArray['Damage'] =array('id'=>'damage','content'=>$this->renderPartial(
                                        '_viewDamages',
                                        array('damages'=>$damages,'model'=>$model),TRUE));
					$tabsArray['Insurance Data'] = array('id'=>'insuranceData','content'=>$this->renderPartial(
                                        '_viewInsurances',
                                        array('insurances'=>$insurances,'model'=>$model),TRUE));
				}

		?>
		<?php 
				$this->widget('zii.widgets.jui.CJuiTabs', array(
			    'tabs' => $tabsArray,
			    // additional javascript options for the tabs plugin
			    'options' => array(
			        'collapsible' => true,
			    ),
			    // set id for this widgets
			    // 'id'=>'view_tab',
			));
	?>
	</fieldset>
		
	</div>
	</div>
