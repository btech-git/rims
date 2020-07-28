<?php
/* @var $this TransactionReturnOrderController */
/* @var $returnOrder->header TransactionReturnOrder */
/* @var $form CActiveForm */
?>

<style>
	.hidden {
		display:none;
	}
</style>

<div class="clearfix page-action">
<?php echo CHtml::link('<span class="fa fa-list"></span>Manage Return Order', Yii::app()->baseUrl.'/transaction/transactionReturnOrder/admin', array('class'=>'button cbutton right', 'visible'=>Yii::app()->user->checkAccess("transaction.transactionReturnOrder.admin"))) ?>
<h1><?php if($returnOrder->header->isNewRecord){ echo "New Transaction Return Order"; }else{ echo "Update Transaction Return Order";}?></h1>
<!-- begin FORM -->
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transaction-return-order-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($returnOrder->header); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">			 

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->labelEx($returnOrder->header,'return_order_no', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($returnOrder->header,'return_order_no',array('size'=>30,'maxlength'=>30, 'readonly' => true)); ?>
						<?php echo $form->error($returnOrder->header,'return_order_no'); ?>
					</div>
				</div>
		 	</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->labelEx($returnOrder->header,'return_order_date', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'model' => $returnOrder->header,
                     'attribute' => "return_order_date",
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
                 ));
            ?>
						<?php echo $form->error($returnOrder->header,'return_order_date'); ?>
					</div>
				</div>
		 	</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->labelEx($returnOrder->header,'receive_item_id', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						
						<?php echo $form->hiddenField($returnOrder->header,'receive_item_id'); ?>
							<?php echo $form->textField($returnOrder->header,'receive_item_no',array(
							'onclick' => 'jQuery("#receive-dialog").dialog("open"); return false;',
							'value' => $returnOrder->header->receive_item_id != Null ? $returnOrder->header->receiveItem->receive_item_no : '',
                            'readOnly' => true,
						)); ?>
						<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
							'id' => 'receive-dialog',
							// additional javascript options for the dialog plugin
							'options' => array(
								'title' => 'Receive Item',
								'autoOpen' => false,
								'width' => 'auto',
								'modal' => true,
							),));
						?>

						<?php $this->widget('zii.widgets.grid.CGridView', array(
							'id'=>'receive-grid',
							'dataProvider'=>$receiveDataProvider,
							'filter'=>$receive,
							// 'summaryText'=>'',
							'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
							'pager'=>array(
							   'cssFile'=>false,
							   'header'=>'',
							),
							'selectionChanged'=>'js:function(id){
								
								$("#TransactionReturnOrder_receive_item_id").val($.fn.yiiGridView.getSelection(id));
								
								$("#receive-dialog").dialog("close");
								$.ajax({
									type: "POST",
									dataType: "JSON",
									url: "' . CController::createUrl('ajaxReceive', array('id'=> '')) . '" + $.fn.yiiGridView.getSelection(id),
									data: $("form").serialize(),	
									success: function(data) {
										var request = "";
										ClearFields();
								    	$.ajax({
											type: "POST",
											//dataType: "JSON",
											url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id'=> $returnOrder->header->id)).'",
											data: $("form").serialize(),
											success: function(html) {
												$(".detail").html(html);	
												
											},
										});
	
										if(data.type == "Purchase Order"){
												request = 1;
												$("#purchase").show();
												$("#supplier").show();
												$("#transfer").hide();
												$("#consignment").hide();
												$.ajax({
												type: "POST",
												dataType: "JSON",
												url: "' . CController::createUrl('ajaxPurchase', array('id'=> '')) . '" + data.purchase,
												data: $("form").serialize(),	
												success: function(data) {
													console.log(data.no);
													$("#TransactionReturnOrder_purchase_order_id").val(data.id);
													$("#TransactionReturnOrder_purchase_order_no").val(data.no);
													$("#TransactionReturnOrder_request_date").val(data.date);
													$("#TransactionReturnOrder_estimate_arrival_date").val(data.eta);
													$("#TransactionReturnOrder_supplier_id").val(data.supplier);
													$("#TransactionReturnOrder_supplier_name").val(data.supplier_name);
												} });
											
												$.ajax({
												type: "POST",
												//dataType: "JSON",
												url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id'=> $returnOrder->header->id)).'&requestType="+request+"&requestId="+ data.purchase,
												data: $("form").serialize(),
												success: function(html) {
													$(".detail").html(html);	
													
												},
											});

										}//end if purchase
										else if(data.type == "Internal Delivery Order"){
											request = 2;
											$("#transfer").show();
											$("#purchase").hide();
											$("#supplier").hide();
											$("#consignment").hide();

							    		$.ajax({
											type: "POST",
											dataType: "JSON",
											url: "' . CController::createUrl('ajaxTransfer', array('id'=> '')) . '" + data.transfer,
											data: $("form").serialize(),
											success: function(data) {
												$("#TransactionReturnOrder_delivery_order_id").val(data.id);
												$("#TransactionReturnOrder_delivery_order_no").val(data.no);
												$("#TransactionReturnOrder_request_date").val(data.date);
												$("#TransactionReturnOrder_estimate_arrival_date").val(data.eta);
												$("#TransactionReturnOrder_branch_destination_id").val(data.branch);
												$("#TransactionReturnOrder_branch_destination_name").val(data.branch_name);
											} });
				
											$.ajax({
												type: "POST",
												//dataType: "JSON",
												url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id'=> $returnOrder->header->id)).'&requestType="+request+"&requestId="+ data.transfer,
												data: $("form").serialize(),
												success: function(html) {
													$(".detail").html(html);	
													
												},
											});

										}//end else if
										else if(data.type == "Consignment In"){
											request = 3;
											
											$("#consignment").show();
											$("#supplier").show();
											$("#transfer").hide();
											$("#purchase").hide();
							    		$.ajax({
											type: "POST",
											dataType: "JSON",
											url: "' . CController::createUrl('ajaxConsignment', array('id'=> '')) . '" + data.consignment,
											data: $("form").serialize(),
											success: function(data) {
												$("#TransactionReturnOrder_consignment_in_id").val(data.id);
												$("#TransactionReturnOrder_consignment_in_number").val(data.no);
												$("#TransactionReturnOrder_request_date").val(data.date);
												$("#TransactionReturnOrder_estimate_arrival_date").val(data.eta);
												$("#TransactionReturnOrder_supplier_id").val(data.supplier);
												$("#TransactionReturnOrder_supplier_name").val(data.supplier_name);
												
											} });
				
											$.ajax({
												type: "POST",
												//dataType: "JSON",
												url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id'=> $returnOrder->header->id)).'&requestType="+request+"&requestId="+ data.consignment,
												data: $("form").serialize(),
												success: function(html) {
													$(".detail").html(html);	
													
												},
											});

										}//end else if
										else{
											$("#consignment").hide();
											$("#supplier").hide();
											$("#transfer").hide();
											$("#purchase").hide();
										}
										$("#TransactionReturnOrder_receive_item_no").val(data.no);
										$("#TransactionReturnOrder_request_type").val(data.type);
										

										
								} });
								$("#delivery-grid").find("tr.selected").each(function(){
				                   	$(this).removeClass( "selected" );
                });

							}',
							'columns'=>array(
								//'id',
								//'code',
								'receive_item_no',
								'receive_item_date',
								array('name'=>'supplier_name','value'=>'$data->supplier != null ? $data->supplier->name : ""'),
								
								
							),
						));?>

				<?php $this->endWidget(); ?>
						<?php echo $form->error($returnOrder->header,'receive_item_id'); ?>
					</div>
				</div>
		 	</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->labelEx($returnOrder->header,'recipient_id', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->hiddenField($returnOrder->header,'recipient_id',array('value'=>$returnOrder->header->isNewRecord ? Yii::app()->user->getId() : $returnOrder->header->recipient_id,'readonly'=>true)); ?>
                        <?php echo $returnOrder->header->isNewRecord ? CHtml::encode(Yii::app()->user->getName()) : $returnOrder->header->user->username; ?>
						<?php echo $form->error($returnOrder->header,'recipient_id'); ?>
					</div>
				</div>
		 	</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->labelEx($returnOrder->header,'recipient_branch_id', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownlist($returnOrder->header,'recipient_branch_id',CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')),'id','name'),array('prompt'=>'[--Select Branch--]')); ?>
						<?php echo $form->error($returnOrder->header,'recipient_branch_id'); ?>
					</div>
				</div>
		 	</div>

		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
						<?php echo $form->labelEx($returnOrder->header,'request_type', array('class'=>'prefix')); ?>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($returnOrder->header,'request_type',array('readonly'=>'true')); ?>
						<?php echo $form->error($returnOrder->header,'request_type'); ?>
					</div>
				</div>
		 	</div>

		 	<div id="purchase" class="hidden">

		 		<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->labelEx($returnOrder->header,'purchase_order_id', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->hiddenField($returnOrder->header,'purchase_order_id'); ?>
							<?php echo $form->textField($returnOrder->header,'purchase_order_no',array('readonly'=>'true',
							'value' => $returnOrder->header->purchase_order_id != Null ? $returnOrder->header->purchaseOrder->purchase_order_no : '')); ?>
							<?php echo $form->error($returnOrder->header,'purchase_order_id'); ?>
						</div>
					</div>
			 	</div>

			 	
		 	</div> <!-- endDIV Purchase -->
		 	<div id="consignment" class="hidden">
		 		<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->labelEx($returnOrder->header,'consignment_in_id', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->hiddenField($returnOrder->header,'consignment_in_id'); ?>
							<?php echo $form->textField($returnOrder->header,'consignment_in_number',array('readonly'=>'true',
							'value' => $returnOrder->header->consignment_in_id != Null ? $returnOrder->header->consignmentIn->consignment_in_number : '')); ?>
							<?php echo $form->error($returnOrder->header,'purchase_order_id'); ?>
						</div>
					</div>
			 	</div>
		 	</div>
		 	<div id="supplier" class="hidden">
		 		<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->labelEx($returnOrder->header,'supplier_id', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->hiddenField($returnOrder->header,'supplier_id'); ?>
							<?php echo $form->textField($returnOrder->header,'supplier_name',array('readonly'=>'true',
							'value' => $returnOrder->header->supplier_id != Null ? $returnOrder->header->supplier->name : '')); ?>
							<?php echo $form->error($returnOrder->header,'supplier_id'); ?>
						</div>
					</div>
			 	</div>

		 	</div> <!-- end Div Supplier -->

		 	<div id="transfer" class="hidden">

		 		<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->labelEx($returnOrder->header,'delivery_order_id', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->hiddenField($returnOrder->header,'delivery_order_id'); ?>
							<?php echo $form->textField($returnOrder->header,'delivery_order_no',array('readonly'=>'true',
							'value' => $returnOrder->header->delivery_order_id != Null ? $returnOrder->header->deliveryOrder->delivery_order_no : '')); ?>
							<?php echo $form->error($returnOrder->header,'delivery_order_id'); ?>
						</div>
					</div>
			 	</div>

			 	<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->labelEx($returnOrder->header,'branch_destination_id', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->hiddenField($returnOrder->header,'branch_destination_id'); ?>
							<?php echo $form->textField($returnOrder->header,'branch_destination_name',array('readonly'=>'true',
								'value' => $returnOrder->header->branch_destination_id != Null ? $returnOrder->header->branchDestination->name : ''
							)); ?>
							<?php echo $form->error($returnOrder->header,'branch_destination_id'); ?>
						</div>
					</div>
			 	</div>

		 	</div> <!-- endDIV Transfer -->
			
			<div id="requestDetail">
		 	<div class="field">

					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->labelEx($returnOrder->header,'request_date', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($returnOrder->header,'request_date',array('readonly'=>'true')); ?>
							<?php echo $form->error($returnOrder->header,'request_date'); ?>
						</div>
					</div>
			 	</div>

			 	<div class="field">
					<div class="row collapse">
						<div class="small-4 columns">
							<?php echo $form->labelEx($returnOrder->header,'estimate_arrival_date', array('class'=>'prefix')); ?>
						</div>
						<div class="small-8 columns">
							<?php echo $form->textField($returnOrder->header,'estimate_arrival_date',array('readonly'=>'true')); ?>
							<?php echo $form->error($returnOrder->header,'estimate_arrival_date'); ?>
						</div>
					</div>
			 	</div>

			</div> <!-- end Div Request Detail -->
		</div>
	</div> <!-- End Div ROw -->

	<div class="detail">
		<?php $this->renderPartial('_detail', array('returnOrder'=>$returnOrder));?>
	</div>

	<div class="row">
		<div class="small-12 medium-6 columns">	
			<div class="field buttons text-center">
                <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                <?php echo CHtml::submitButton($returnOrder->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
			</div>
		</div>
	</div>

<script>
	function ClearFields() {

    $('#purchase').find('input:text').val('');
    $('#transfer').find('input:text').val('');
    $('#requestDetail').find('input:text').val('');
    $('#supplier').find('input:text').val('');
    $('#consignment').find('input:text').val('');
     
	}
	if($("#TransactionReturnOrder_request_type").val() == "Purchase Order") {
		$("#purchase").show();
		$("#supplier").show();
		$("#transfer").hide();
		$("#consignment").hide();
    } else if($("#TransactionReturnOrder_request_type").val() == "Internal Delivery Order") {
		$("#transfer").show();
		$("#purchase").hide();
		$("#supplier").hide();
		$("#consignment").hide();
    } 
    else if($("#TransactionReturnOrder_request_type").val() == "Consignment In") {
		$("#consignment").show();
		$("#supplier").show();
		$("#transfer").hide();
		$("#purchase").hide();
    }
    else{
    	$("#consignment").hide();
		$("#supplier").hide();
		$("#transfer").hide();
		$("#purchase").hide();
    }
   

</script>
<?php $this->endWidget(); ?>

</div><!-- form -->
