<?php
/* @var $this TransactionReceiveItemController */
/* @var $model TransactionReceiveItem */
/* @var $form CActiveForm */
?>

<style>
	.hidden {
		display:none;
	}
</style>

<div class="clearfix page-action">
<?php echo CHtml::link('<span class="fa fa-list"></span>Manage Delivery Order', Yii::app()->baseUrl.'/transaction/transactionDeliveryOrder/admin', array('class'=>'button cbutton right', 'visible'=>Yii::app()->user->checkAccess("transaction.transactionDeliveryOrder.admin"))) ?>
<h1><?php if($deliveryOrder->header->id==""){ echo "New Transaction Delivery Order"; }else{ echo "Update Transaction Delivery Order";}?></h1>
<!-- begin FORM -->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transaction-receive-item-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($deliveryOrder->header); ?>
	<?php echo $form->errorSummary($deliveryOrder->details); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">			 
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($deliveryOrder->header,'delivery_order_no', array('class'=>'prefix')); ?>
					  </div>
					<div class="small-8 columns">
						<?php echo $form->textField($deliveryOrder->header,'delivery_order_no',array('size'=>30,'maxlength'=>30, 'readonly' => true)); ?>
						<?php echo $form->error($deliveryOrder->header,'delivery_order_no'); ?>
					</div>
				</div>
		 	</div>
		
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($deliveryOrder->header,'posting_date', array('class'=>'prefix')); ?>
					  </div>
					<div class="small-8 columns">
                        <?php echo $form->textField($deliveryOrder->header,'posting_date',array('readonly' => true,)); ?>
						<?php /*$this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $deliveryOrder->header,
                             'attribute' => "posting_date",
                             // additional javascript options for the date picker plugin
                             'options'=>array(
                                 'dateFormat' => 'yy-mm-dd',
                                 'changeMonth'=>true,
                                                 'changeYear'=>true,
                                                 'yearRange'=>'1900:2020'
                             ),
                              'htmlOptions'=>array(
                                'value'=>date('Y-m-d'),
                                //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                                ),
                         ));*/ ?>
						<?php echo $form->error($deliveryOrder->header,'posting_date'); ?>
					</div>
				</div>
		 	</div>

		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($deliveryOrder->header,'delivery_date', array('class'=>'prefix')); ?>
					  </div>
					<div class="small-8 columns">
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'model' => $deliveryOrder->header,
                     'attribute' => "delivery_date",
                     // additional javascript options for the date picker plugin
                     'options'=>array(
                         'dateFormat' => 'yy-mm-dd',
                         'changeMonth'=>true,
                         'changeYear'=>true,
                         'yearRange'=>'1900:2020'
                     ),
                      'htmlOptions'=>array(
//                      	'value'=>date('Y-m-d'),
                        //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                        ),
                 ));
                ?>
						<?php echo $form->error($deliveryOrder->header,'delivery_date'); ?>
					</div>
				</div>
		 	</div>

		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($deliveryOrder->header,'sender_id', array('class'=>'prefix')); ?>
					  </div>
					<div class="small-8 columns">
						<?php echo $form->hiddenField($deliveryOrder->header,'sender_id',array('value'=>$deliveryOrder->header->isNewRecord ? Yii::app()->user->getId() : $deliveryOrder->header->sender_id,'readonly'=>true)); ?>
						<?php echo $form->textField($deliveryOrder->header,'user_name',array('size'=>30,'maxlength'=>30,'value'=>$deliveryOrder->header->isNewRecord ?Yii::app()->user->getName() : $deliveryOrder->header->user->username,'readonly'=>true)); ?>
						<?php echo $form->error($deliveryOrder->header,'sender_id'); ?>
					</div>
				</div>
		 	</div>

		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($deliveryOrder->header,'sender_branch_id', array('class'=>'prefix')); ?>
					  </div>
					<div class="small-8 columns">
						<?php echo $form->hiddenField($deliveryOrder->header, 'sender_branch_id', array('value'=>$deliveryOrder->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $deliveryOrder->header->sender_branch_id)); ?>
						<?php echo $form->textField($deliveryOrder->header, 'branch_name', array('size'=>30, 'maxlength'=>30, 'value'=>$deliveryOrder->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->name : $deliveryOrder->header->senderBranch->name, 'readonly'=>true)); ?>
						<?php //echo $form->dropDownlist($deliveryOrder->header,'sender_branch_id',CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')),'id','name'),array('prompt'=>'[--Select Branch--]')); ?>
						<?php echo $form->error($deliveryOrder->header,'sender_branch_id'); ?>
					</div>
				</div>
		 	</div>

		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($deliveryOrder->header,'request_type', array('class'=>'prefix')); ?>
					  </div>
					<div class="small-8 columns">
						<?php 
							echo $form->dropDownlist($deliveryOrder->header, 'request_type', array('Sales Order' => 'Sales Order',
									'Sent Request' => 'Sent Request','Consignment Out'=>'Consignment Out','Transfer Request'=>'Transfer Request'),array('prompt'=>'[--Select Request Type--]',
								/*	'onchange' =>'//alert($(this).val());
							    var selection = $(this).val();
							    if(selection == "Sales Order"){
							    	js:$("#purchase").removeClass("hidden");
							    	js:$("#transfer").addClass("hidden");
							    	ClearFields();
							    	$.ajax({
												type: "POST",
												//dataType: "JSON",
												url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id'=> $deliveryOrder->header->id)).'",
												data: $("form").serialize(),
												success: function(html) {
													$(".detail").html(html);	
													
												},
											});
							    
							    }
							    else if(selection == "Sent Request")
							    {
							    	js:$("#transfer").removeClass("hidden");
							    	js:$("#purchase").addClass("hidden");
							    	ClearFields();
										$.ajax({
												type: "POST",
												//dataType: "JSON",
												url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id'=> $deliveryOrder->header->id)).'",
												data: $("form").serialize(),
												success: function(html) {
													$(".detail").html(html);	
													
												},
											});
							    }
									else{
										js:$("#transfer").addClass("hidden");
							    	js:$("#purchase").addClass("hidden");
							    	ClearFields();
							    	$.ajax({
												type: "POST",
												//dataType: "JSON",
												url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id'=> $deliveryOrder->header->id)).'",
												data: $("form").serialize(),
												success: function(html) {
													$(".detail").html(html);	
													
												},
											});
									}
							    '*/
								));
							//  echo $form->radioButtonList($deliveryOrder->header, 'request_type',
							//                     array(  'Purchase Order' => 'Purchase Order',
							//                             'Transfer Request' => 'Transfer Request',
							//                             ),
							                  
							//                    array(
							//     'labelOptions'=>array('style'=>'display:inline'), // add this code
							//     'separator'=>'  ',
							//     'onchange' =>'//alert($(this).val());
							//     var selection = $(this).val();
							//     if(selection == "Purchase Order"){
							//     	js:$("#purchase").removeClass("hidden");
							//     	js:$("#transfer").addClass("hidden");
							//     	ClearFields();
							//     }
							//     else if(selection == "Transfer Request")
							//     {
							//     	js:$("#transfer").removeClass("hidden");
							//     	js:$("#purchase").addClass("hidden");
							//     	ClearFields();
										
							//     }

							//     '
							// ) );


							?>
						<?php echo $form->error($deliveryOrder->header,'request_type'); ?>
					</div>
				</div>
		 	</div>
        </div>
		<div class="small-12 medium-6 columns">	
		<div id="purchase">
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($deliveryOrder->header,'sales_order_id', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->hiddenField($deliveryOrder->header,'sales_order_id'); ?>
							<?php echo $form->textField($deliveryOrder->header,'sales_order_no',array(
							'onclick' => 'jQuery("#sales-dialog").dialog("open"); return false;',
							'value' => $deliveryOrder->header->sales_order_id != Null ? $deliveryOrder->header->salesOrder->sale_order_no : '',
                            'readOnly' => true,
						)); ?>

						<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
							'id' => 'sales-dialog',
							// additional javascript options for the dialog plugin
							'options' => array(
								'title' => 'Sales Order',
								'autoOpen' => false,
								'width' => 'auto',
								'modal' => true,
							),));
						?>

						<?php $this->widget('zii.widgets.grid.CGridView', array(
							'id'=>'sales-grid',
							'dataProvider'=>$salesDataProvider,
							'filter'=>$sales,
							'summaryText'=>'',
							'selectionChanged'=>'js:function(id){
								$("#TransactionDeliveryOrder_sales_order_id").val($.fn.yiiGridView.getSelection(id));
								$("#sales-dialog").dialog("close");
								$.ajax({
									type: "POST",
									//dataType: "JSON",
									url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id'=> $deliveryOrder->header->id)).'",
									data: $("form").serialize(),
									success: function(html) {
										$(".detail").html(html);	
									},
								});
								$.ajax({
									type: "POST",
									dataType: "JSON",
									url: "' . CController::createUrl('ajaxSales', array('id'=> '')) . '" + $.fn.yiiGridView.getSelection(id),
									data: $("form").serialize(),	
									success: function(data) {
										$("#TransactionDeliveryOrder_sales_order_no").val(data.no);
										$("#TransactionDeliveryOrder_request_date").val(data.date);
										$("#TransactionDeliveryOrder_estimate_arrival_date").val(data.eta);
										$("#TransactionDeliveryOrder_customer_id").val(data.customer);
										$("#TransactionDeliveryOrder_customer_name").val(data.customer_name);

										$.ajax({
										type: "POST",
										dataType: "JSON",
										url: "' . CController::createUrl('ajaxCustomer', array('id'=> '')) . '" + data.customer,
										data: $("form").serialize(),
										success: function(data) {
											//alert(data.name);
										} });
										//alert($("#TransactionDeliveryOrder_request_type").val());
										
										$.ajax({
												type: "POST",
												//dataType: "JSON",
												url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id'=> $deliveryOrder->header->id)).'&requestType="+1+"&requestId="+ $("#TransactionDeliveryOrder_sales_order_id").val(),
												data: $("form").serialize(),
												success: function(html) {
													$(".detail").html(html);	
													
												},
											});
										

									} });

								$("#sales-grid").find("tr.selected").each(function(){
				                   	$(this).removeClass( "selected" );
				                });

							}',
							'columns'=>array(
								//'id',
								//'code',
								'sale_order_no',
								'sale_order_date',
                                'customer.name: Customer',
								
							),
						));?>

				<?php $this->endWidget(); ?>
						<?php echo $form->error($deliveryOrder->header,'sales_order_id'); ?>
					</div>
				</div>
		 	</div>

		 	 	
		</div>
	
		<div id="consignment">
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($deliveryOrder->header,'consignment_out_id', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->hiddenField($deliveryOrder->header,'consignment_out_id'); ?>
						<?php echo $form->textField($deliveryOrder->header,'consignment_out_no',array(
							'onclick' => 'jQuery("#consignment-dialog").dialog("open"); return false;',
							'value' => $deliveryOrder->header->consignment_out_id != Null ? $deliveryOrder->header->consignmentOut->consignment_out_no : '',
                            'readOnly' => true,
						)); ?>

						<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
							'id' => 'consignment-dialog',
							// additional javascript options for the dialog plugin
							'options' => array(
								'title' => 'Consignment Out',
								'autoOpen' => false,
								'width' => 'auto',
								'modal' => true,
							),));
						?>

						<?php $this->widget('zii.widgets.grid.CGridView', array(
							'id'=>'consignment-grid',
							'dataProvider'=>$consignmentDataProvider,
							'filter'=>$consignment,
							'summaryText'=>'',
							'selectionChanged'=>'js:function(id){
								$("#TransactionDeliveryOrder_consignment_out_id").val($.fn.yiiGridView.getSelection(id));
								$("#consignment-dialog").dialog("close");
								$.ajax({
									type: "POST",
									//dataType: "JSON",
									url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id'=> $deliveryOrder->header->id)).'",
									data: $("form").serialize(),
									success: function(html) {
										$(".detail").html(html);	
										
									},
								});
								$.ajax({
									type: "POST",
									dataType: "JSON",
									url: "' . CController::createUrl('ajaxConsignment', array('id'=> '')) . '" + $.fn.yiiGridView.getSelection(id),
									data: $("form").serialize(),	
									success: function(data) {
										$("#TransactionDeliveryOrder_consignment_out_no").val(data.no);
										$("#TransactionDeliveryOrder_request_date").val(data.date);
										$("#TransactionDeliveryOrder_estimate_arrival_date").val(data.eta);
										$("#TransactionDeliveryOrder_customer_id").val(data.customer);
										$("#TransactionDeliveryOrder_customer_name").val(data.customer_name);

										
										//alert($("#TransactionDeliveryOrder_request_type").val());
										//var type = $("#TransactionDeliveryOrder_request_type").val();
										//var request = 0;

										
										$.ajax({
												type: "POST",
												//dataType: "JSON",
												url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id'=> $deliveryOrder->header->id)).'&requestType="+3+"&requestId="+ $("#TransactionDeliveryOrder_consignment_out_id").val(),
												data: $("form").serialize(),
												success: function(html) {
													$(".detail").html(html);	
													
												},
											});
										

									} });

								$("#consignment-grid").find("tr.selected").each(function(){
				                   	$(this).removeClass( "selected" );
				                });

							}',
							'columns'=>array(
								'consignment_out_no',
								'date_posting',
                                array(
                                    'name' => 'customer_id',
                                    'value' => '$data->customer ? $data->customer->name : ""'
                                ),
								'total_quantity',
							),
						));?>

						<?php $this->endWidget(); ?>
						<?php echo $form->error($deliveryOrder->header,'consignment_out_id'); ?>
					</div>
				</div>
		 	</div>
		</div>

		<div id="customer">
			<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
						  <?php echo $form->labelEx($deliveryOrder->header,'customer_id', array('class'=>'prefix')); ?>
						  </div>
						<div class="small-8 columns">
							<?php echo $form->HiddenField($deliveryOrder->header,'customer_id',array('readonly'=>'true')); ?>
							<?php echo $form->TextField($deliveryOrder->header,'customer_name',array('readonly'=>'true','value'=>$deliveryOrder->header->customer_id != "" ? $deliveryOrder->header->customer->name : '')); ?>
							<?php echo $form->error($deliveryOrder->header,'customer_id'); ?>
						</div>
					</div>
			 	</div>
			
		</div>

		<div id="transfer">
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($deliveryOrder->header,'transfer_request_id', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->hiddenField($deliveryOrder->header,'transfer_request_id'); ?>
						<?php echo $form->textField($deliveryOrder->header,'transfer_request_no',array(
							'onclick' => 'jQuery("#transfer-dialog").dialog("open"); return false;',
							'value' => $deliveryOrder->header->transfer_request_id != Null ? $deliveryOrder->header->transferRequest->transfer_request_no : '',
                            'readOnly' => true,
						)); ?>

						<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
							'id' => 'transfer-dialog',
							// additional javascript options for the dialog plugin
							'options' => array(
								'title' => 'Transfer Request',
								'autoOpen' => false,
								'width' => 'auto',
								'modal' => true,
							),));
						?>

						<?php $this->widget('zii.widgets.grid.CGridView', array(
							'id'=>'transfer-grid',
							'dataProvider'=>$transferDataProvider,
							'filter'=>$transfer,
							'summaryText'=>'',
							'selectionChanged'=>'js:function(id){
								$("#TransactionDeliveryOrder_transfer_request_id").val($.fn.yiiGridView.getSelection(id));
								$("#transfer-dialog").dialog("close");
								$.ajax({
									type: "POST",
									//dataType: "JSON",
									url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id'=> $deliveryOrder->header->id)).'",
									data: $("form").serialize(),
									success: function(html) {
										$(".detail").html(html);	
										
									},
								});
								$.ajax({
									type: "POST",
									dataType: "JSON",
									url: "' . CController::createUrl('ajaxTransfer', array('id'=> '')) . '" + $.fn.yiiGridView.getSelection(id),
									data: $("form").serialize(),
									success: function(data) {
										$("#TransactionDeliveryOrder_transfer_request_no").val(data.no);
										$("#TransactionDeliveryOrder_request_date").val(data.date);
										$("#TransactionDeliveryOrder_estimate_arrival_date").val(data.eta);
										$("#TransactionDeliveryOrder_destination_branch").val(data.branch);
										$("#TransactionDeliveryOrder_destination_branch_name").val(data.branch_name);

										$.ajax({
												type: "POST",
												//dataType: "JSON",
												url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id'=> $deliveryOrder->header->id)).'&requestType="+4+"&requestId="+ $("#TransactionDeliveryOrder_transfer_request_id").val(),
												data: $("form").serialize(),
												success: function(html) {
													$(".detail").html(html);	
													
												},
											});
									} });

								$("#transfer-grid").find("tr.selected").each(function(){
				                   	$(this).removeClass( "selected" );
				                });

							}',
							'columns'=>array(
								//'id',
								//'code',
								'transfer_request_no',
								'transfer_request_date',
                                array(
                                    'name' => 'requester_branch_id',
                                    'value' => '$data->requesterBranch ? $data->requesterBranch->name : ""'
                                ),
                                array(
                                    'name' => 'destination_branch_id',
                                    'value' => '$data->destinationBranch ? $data->destinationBranch->name : ""'
                                ),
							),
						));?>

							<?php $this->endWidget(); ?>
						<?php echo $form->error($deliveryOrder->header,'transfer_request_id'); ?>
					</div>
				</div>
		 	</div>

		</div>

		<div id="sent">
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <?php echo $form->labelEx($deliveryOrder->header,'sent_request_id', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->hiddenField($deliveryOrder->header,'sent_request_id'); ?>
						<?php echo $form->textField($deliveryOrder->header,'sent_request_no',array(
							'onclick' => 'jQuery("#sent-dialog").dialog("open"); return false;',
							'value' => $deliveryOrder->header->sent_request_id != Null ? $deliveryOrder->header->sentRequest->sent_request_no : '',
                            'readOnly' => true,
						)); ?>

						<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
							'id' => 'sent-dialog',
							// additional javascript options for the dialog plugin
							'options' => array(
								'title' => 'Sent Request',
								'autoOpen' => false,
								'width' => 'auto',
								'modal' => true,
							),));
						?>

						<?php $this->widget('zii.widgets.grid.CGridView', array(
							'id'=>'sent-grid',
							'dataProvider'=>$sentDataProvider,
							'filter'=>$sent,
							'summaryText'=>'',
							'selectionChanged'=>'js:function(id){
								$("#TransactionDeliveryOrder_sent_request_id").val($.fn.yiiGridView.getSelection(id));
								$("#sent-dialog").dialog("close");
								$.ajax({
									type: "POST",
									dataType: "JSON",
									url: "' . CController::createUrl('ajaxSent', array('id'=> '')) . '" + $.fn.yiiGridView.getSelection(id),
									data: $("form").serialize(),
									success: function(data) {
										$("#TransactionDeliveryOrder_sent_request_no").val(data.no);
										$("#TransactionDeliveryOrder_request_date").val(data.date);
										$("#TransactionDeliveryOrder_estimate_arrival_date").val(data.eta);
										$("#TransactionDeliveryOrder_destination_branch").val(data.branch);
										$("#TransactionDeliveryOrder_destination_branch_name").val(data.branch_name);
										console.log(data);
										
										$.ajax({
												type: "POST",
												//dataType: "JSON",
												url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id'=> $deliveryOrder->header->id)).'&requestType="+2+"&requestId="+ $("#TransactionDeliveryOrder_sent_request_id").val(),
												data: $("form").serialize(),
												success: function(html) {
													$(".detail").html(html);	
													
												},
											});
										


									} });

								$("#sent-grid").find("tr.selected").each(function(){
				                   	$(this).removeClass( "selected" );
				                });

							}',
							'columns'=>array(
								//'id',
								//'code',
								'sent_request_no',
								'sent_request_date',
                                array(
                                    'name' => 'requester_branch_id',
                                    'value' => '$data->requesterBranch ? $data->requesterBranch->name : ""'
                                ),
                                array(
                                    'name' => 'destination_branch_id',
                                    'value' => '$data->destinationBranch ? $data->destinationBranch->name : ""'
                                ),
							),
						));?>

				<?php $this->endWidget(); ?>
						<?php echo $form->error($deliveryOrder->header,'sent_request_id'); ?>
					</div>
				</div>
		 	</div>

		 		
		</div>	

		<div id="destination">
			<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
						  <?php echo $form->labelEx($deliveryOrder->header,'destination_branch', array('class'=>'prefix')); ?>
						  </div>
						<div class="small-8 columns">
							<?php echo $form->hiddenField($deliveryOrder->header,'destination_branch',array('readonly'=>'true')); ?>
							<input type="text" id="TransactionDeliveryOrder_destination_branch_name" readonly>
							<?php echo $form->error($deliveryOrder->header,'destination_branch'); ?>
						</div>
					</div>
			 	</div>
		</div>

        <div id="requestDetail">

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                      <?php echo $form->labelEx($deliveryOrder->header,'request_date', array('class'=>'prefix')); ?>
                      </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($deliveryOrder->header,'request_date',array('readonly'=>'true')); ?>
                        <?php echo $form->error($deliveryOrder->header,'request_date'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                      <?php echo $form->labelEx($deliveryOrder->header,'estimate_arrival_date', array('class'=>'prefix')); ?>
                      </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($deliveryOrder->header,'estimate_arrival_date',array('readonly'=>'true')); ?>
                        <?php echo $form->error($deliveryOrder->header,'estimate_arrival_date'); ?>
                    </div>
                </div>
            </div>
        </div>
        </div>

        </div>

        <div class="detail">
            <?php $this->renderPartial('_detail', array('deliveryOrder'=>$deliveryOrder)); ?>
        </div>
    
		<div class="row">
            <div class="small-12 medium-6 columns">			 
                <div class="field buttons text-center">
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                    <?php echo CHtml::submitButton($deliveryOrder->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton','id'=>'save', 'confirm' => 'Are you sure you want to save?')); ?>
                </div>
            </div>
		</div>
	<script>
	function ClearFields() {

    $('#purchase').find('input:text').val('');
    $('#sent').find('input:text').val('');
    $('#customer').find('input:text').val('');
    $('#destination').find('input:text').val('');
    $('#consignment').find('input:text').val('');
    $('#requestDetail').find('input:text').val('');
     
}
</script>
<?php $this->endWidget(); ?>

</div><!-- form -->
<?php
Yii::app()->clientScript->registerScript('myjquery', '
	// Yii::app()->controller->action->id
    if($("#TransactionDeliveryOrder_request_type").val() == "Sales Order") {
			$("#purchase").show();
			$("#customer").show();
			$("#consignment").hide();
			$("#sent").hide();
			$("#destination").hide();
			$("#transfer").hide();
	    }else if($("#TransactionDeliveryOrder_request_type").val() == "Sent Request") {
	    	$("#sent").show();
	    	$("#destination").show();
			$("#purchase").hide();
			$("#customer").hide();
			$("#consignment").hide();
			$("#transfer").hide();
		}else if($("#TransactionDeliveryOrder_request_type").val() == "Consignment Out") {
			$("#sent").hide();
			$("#purchase").hide();
			$("#customer").show();
			$("#consignment").show();
			$("#destination").hide();
			$("#transfer").hide();
	    }else if($("#TransactionDeliveryOrder_request_type").val() == "Transfer Request") {
			$("#sent").hide();
			$("#purchase").hide();
			$("#customer").hide();
			$("#consignment").hide();
			$("#transfer").show();
			$("#destination").show();
	    }else {
	    	$("#sent").hide();
			$("#purchase").hide();
			$("#customer").hide();
			$("#consignment").hide();
			$("#destination").hide();
			$("#transfer").hide();
	    }
	$("#TransactionDeliveryOrder_request_type").change(function(){
		ClearFields();
		$.ajax({
			type: "POST",
			//dataType: "JSON",
			url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id'=> $deliveryOrder->header->id)).'",
			data: $("form").serialize(),
			success: function(html) {
				$(".detail").html(html);	
				
			},
		});
        if($("#TransactionDeliveryOrder_request_type").val() == "Sales Order") {
			$("#purchase").show();
			$("#customer").show();
			$("#consignment").hide();
			$("#sent").hide();
			$("#destination").hide();
			$("#transfer").hide();
	    }else if($("#TransactionDeliveryOrder_request_type").val() == "Sent Request") {
	    	$("#sent").show();
	    	$("#destination").show();
			$("#purchase").hide();
			$("#customer").hide();
			$("#consignment").hide();
			$("#transfer").hide();
		}else if($("#TransactionDeliveryOrder_request_type").val() == "Consignment Out") {
			$("#sent").hide();
			$("#purchase").hide();
			$("#customer").show();
			$("#consignment").show();
			$("#destination").hide();
			$("#transfer").hide();
	    }else if($("#TransactionDeliveryOrder_request_type").val() == "Transfer Request") {
			$("#sent").hide();
			$("#purchase").hide();
			$("#customer").hide();
			$("#consignment").hide();
			$("#transfer").show();
			$("#destination").show();
	    }else {
	    	$("#sent").hide();
			$("#purchase").hide();
			$("#customer").hide();
			$("#consignment").hide();
			$("#destination").hide();
			$("#transfer").hide();
	    }
	    });
');?>