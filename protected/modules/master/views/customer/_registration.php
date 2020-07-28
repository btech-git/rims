<?php
/* @var $this TransaksiOrderPembelianController */
/* @var $model TransaksiORderPembelian */
/* @var $form CActiveForm */
?>
<script>
	
</script>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customer-vehicle-registration-form',
	'enableAjaxValidation'=>false,
)); ?>

	<!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->
	<div class="row">
    <div class="large-6 columns">
      <div class="row collapse prefix-radius">
        <div class="small-3 columns">
          <span class="prefix">Name</span>
        </div>
        <div class="small-9 columns">
          <?php echo $form->textField($requestOrder, 'supervisor_id'); ?>
        </div>
      </div>
    </div>
    <div class="large-6 columns">
      <div class="row collapse postfix-radius">
      	<div class="small-3 columns">
          <span class="postfix">PIC</span>
        </div>
        <div class="small-9 columns">
          <input type="text" placeholder="Value">
        </div>
      </div>
    </div>
  </div> <!--end row class -->
		 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Date Posting</label>
				  </div>
					<div class="small-8 columns">
						<?php echo $form->textField($requestOrder, 'request_order_date', array('value'=>$requestOrder->request_order_date,'readonly'=>true)); ?>
						
					</div>
				</div>
		 	</div>
		 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Status Document</label>
				  </div>
					<div class="small-8 columns">
						<?php echo $form->textField($requestOrder, 'status_document', array('value'=>$requestOrder->status_document,'readonly'=>true)); ?>
					</div>
				</div>
		 	</div>
		 <hr />
			<div class="field">
				<div class="row collapse">
					<div class="small-12 columns">
						<h2>Product Detail</h2>
					</div>
				</div>
			</div>
		 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Product</label>
				  </div>
					<div class="small-8 columns">
						<?php echo $form->textField($requestOrderDetail, 'product_id', array('value'=>$requestOrderDetail->product_id,'readonly'=>true)); ?>
						
					</div>
				</div>
		 	</div>
		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Unit</label>
				  </div>
					<div class="small-8 columns">
						<?php echo $form->textField($requestOrderDetail, 'unit_id', array('value'=>$requestOrderDetail->unit_id,'readonly'=>true)); ?>
						
					</div>
				</div>
		 	</div>
		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Quantity</label>
				  </div>
					<div class="small-8 columns">
					<?php echo $form->textField($requestOrderDetail, 'quantity', array('value'=>$requestOrderDetail->quantity,'readonly'=>true)); ?>
						
					</div>
				</div>
		 	</div>
		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Retail Price</label>
				  </div>
					<div class="small-8 columns">
						<?php echo $form->textField($requestOrderDetail, 'retail_price', array('value'=>$requestOrderDetail->retail_price,'readonly'=>true)); ?>
						
					</div>
				</div>
		 	</div>
		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Last Buying Price</label>
				  </div>
					<div class="small-8 columns">
					<?php echo $form->textField($requestOrderDetail, 'last_buying_price', array('value'=>$requestOrderDetail->last_buying_price,'readonly'=>true)); ?>
					
					</div>
				</div>
		 	</div>
		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Discount Step</label>
				  </div>
					<div class="small-8 columns">
					<?php echo $form->textField($requestOrderDetail, 'discount_step', array('value'=>$requestOrderDetail->discount_step,'readonly'=>true)); ?>

					</div>
				</div>
		 	</div>
		 	<?php if ($requestOrderDetail->discount_step == 1): ?>
		 		<div class="field" id="step1">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Step 1</label>
				  </div>
					<div class="small-4 columns">
						<?php echo $form->dropDownList($requestOrderDetail, 'discount1_type', array('1' => 'Percent','2'=>'Amount','3'=>'Bonus'),array('disabled'=>true)); ?>
					</div>
					<div class="small-4 columns">	
						<?php echo $form->textField($requestOrderDetail, 'discount2_type', array('value'=> $requestOrderDetail->discount1_nominal,'readonly'=>true)); ?>
					</div>
				</div>
		 	</div>
		 	<?php endif ?>
		 	<?php if ($requestOrderDetail->discount_step == 2): ?>
		 		<div class="field" id="step1">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Step 1</label>
				  </div>
					
						<div class="small-4 columns">
						<?php echo $form->dropDownList($requestOrderDetail, 'discount1_type', array('1' => 'Percent','2'=>'Amount','3'=>'Bonus'),array('disabled'=>true)); ?>
					</div>
					<div class="small-4 columns">	
						<?php echo $form->textField($requestOrderDetail, 'discount1_nominal', array('value'=> $requestOrderDetail->discount1_nominal,'readonly'=>true)); ?>
					</div>
					
				</div>
		 	</div>
		 		<div class="field" id="step2">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Step 2</label>
				  </div>
					<div class="small-4 columns">
						<?php echo $form->dropDownList($requestOrderDetail, 'discount2_type', array('1' => 'Percent','2'=>'Amount','3'=>'Bonus'),array('disabled'=>true)); ?>
					</div>
					<div class="small-4 columns">	
						<?php echo $form->textField($requestOrderDetail, 'discount2_nominal', array('value'=> $requestOrderDetail->discount2_nominal,'readonly'=>true)); ?>
					</div>
				</div>
		 	</div>
		 	<?php endif ?>
		 	<?php if ($requestOrderDetail->discount_step == 3): ?>
		 		<div class="field" id="step1">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Step 1</label>
				  </div>
					<div class="small-8 columns">
						<div class="small-3 columns">
						<?php echo $form->dropDownList($requestOrderDetail, 'discount1_type', array('1' => 'Percent','2'=>'Amount','3'=>'Bonus'),array('prompt'=>'[--Select Approval Status--]')); ?>
					</div>
					<div class="small-3 columns">	
						<?php echo $form->textField($requestOrderDetail, 'discount1_nominal', array('value'=> $requestOrderDetail->discount1_nominal,'readonly'=>true)); ?>
					</div>
					</div>
				</div>
		 	</div>
		 		<div class="field" id="step2">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Step 2</label>
				  </div>
					<div class="small-8 columns">
						<div class="small-3 columns">
						<?php echo $form->dropDownList($requestOrderDetail, 'discount2_type', array('1' => 'Percent','2'=>'Amount','3'=>'Bonus'),array('prompt'=>'[--Select Approval Status--]')); ?>
					</div>
					<div class="small-3 columns">	
						<?php echo $form->textField($requestOrderDetail, 'discount2_nominal', array('value'=> $requestOrderDetail->discount2_nominal,'readonly'=>true)); ?>
					</div>
					</div>
				</div>
		 	</div>
		 		<div class="field" id="step3">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Step 3</label>
				  </div>
					
						<div class="small-4 columns">
						<?php echo $form->dropDownList($requestOrderDetail, 'discount3_type', array('1' => 'Percent','2'=>'Amount','3'=>'Bonus'),array('disabled'=>true)); ?>
					</div>
					<div class="small-4 columns">	
						<?php echo $form->textField($requestOrderDetail, 'discount3_nominal', array('value'=> $requestOrderDetail->discount3_nominal,'readonly'=>true)); ?>
					</div>
					
				</div>
		 	</div>
		 	<?php endif ?>
		 	<?php if ($requestOrderDetail->discount_step == 4): ?>
		 		<div class="field" id="step1">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Step 1</label>
				  </div>
					<div class="small-4 columns">
						<?php echo $form->dropDownList($requestOrderDetail, 'discount1_type', array('1' => 'Percent','2'=>'Amount','3'=>'Bonus'),array('disabled'=>true)); ?>
					</div>
					<div class="small-4 columns">	
						<?php echo $form->textField($requestOrderDetail, 'discount1_nominal', array('value'=> $requestOrderDetail->discount1_nominal,'readonly'=>true)); ?>
					</div>
				</div>
		 	</div>
		 		<div class="field" id="step2">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Step 2</label>
				  </div>
					<div class="small-4 columns">
						<?php echo $form->dropDownList($requestOrderDetail, 'discount2_type', array('1' => 'Percent','2'=>'Amount','3'=>'Bonus'),array('disabled'=>true)); ?>
					</div>
					<div class="small-4 columns">	
						<?php echo $form->textField($requestOrderDetail, 'discount2_nominal', array('value'=> $requestOrderDetail->discount2_nominal,'readonly'=>true)); ?>
					</div>
				</div>
		 	</div>
		 		<div class="field" id="step3">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Step 3</label>
				  </div>
					<div class="small-4 columns">
						<?php echo $form->dropDownList($requestOrderDetail, 'discount3_type', array('1' => 'Percent','2'=>'Amount','3'=>'Bonus'),array('disabled'=>true)); ?>
					</div>
					<div class="small-4 columns">	
						<?php echo $form->textField($requestOrderDetail, 'discount3_nominal', array('value'=> $requestOrderDetail->discount3_nominal,'readonly'=>true)); ?>
					</div>
				</div>
		 	</div>
		 		<div class="field" id="step4">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Step 4</label>
				  </div>
					<div class="small-4 columns">
						<?php echo $form->dropDownList($requestOrderDetail, 'discount4_type', array('1' => 'Percent','2'=>'Amount','3'=>'Bonus'),array('disabled'=>true)); ?>
					</div>
					<div class="small-4 columns">	
						<?php echo $form->textField($requestOrderDetail, 'discount4_nominal', array('value'=> $requestOrderDetail->discount4_nominal,'readonly'=>true)); ?>
					</div>
				</div>
		 	</div>
		 	<?php endif ?>
		 	<?php if ($requestOrderDetail->discount_step == 5): ?>
				<div class="field" id="step1">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Step 1</label>
				  </div>
					<div class="small-4 columns">
						<?php echo $form->dropDownList($requestOrderDetail, 'discount1_type', array('1' => 'Percent','2'=>'Amount','3'=>'Bonus'),array('disabled'=>true)); ?>
					</div>
					<div class="small-4 columns">	
						<?php echo $form->textField($requestOrderDetail, 'discount1_nominal', array('value'=> $requestOrderDetail->discount1_nominal,'readonly'=>true)); ?>
					</div>
				</div>
		 	</div>
		 		<div class="field" id="step2">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Step 2</label>
				  </div>
					<div class="small-4 columns">
						<?php echo $form->dropDownList($requestOrderDetail, 'discount2_type', array('1' => 'Percent','2'=>'Amount','3'=>'Bonus'),array('disabled'=>true)); ?>
					</div>
					<div class="small-4 columns">	
						<?php echo $form->textField($requestOrderDetail, 'discount2_nominal', array('value'=> $requestOrderDetail->discount2_nominal,'readonly'=>true)); ?>
					</div>
				</div>
		 	</div>
		 		<div class="field" id="step3">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Step 3</label>
				  </div>
					<div class="small-4 columns">
						<?php echo $form->dropDownList($requestOrderDetail, 'discount3_type', array('1' => 'Percent','2'=>'Amount','3'=>'Bonus'),array('disabled'=>true)); ?>
					</div>
					<div class="small-4 columns">	
						<?php echo $form->textField($requestOrderDetail, 'discount3_nominal', array('value'=> $requestOrderDetail->discount3_nominal,'readonly'=>true)); ?>
					</div>
				</div>
		 	</div>
		 		<div class="field" id="step4">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Step 4</label>
				  </div>
					<div class="small-4 columns">
						<?php echo $form->dropDownList($requestOrderDetail, 'discount4_type', array('1' => 'Percent','2'=>'Amount','3'=>'Bonus'),array('disabled'=>true)); ?>
					</div>
					<div class="small-4 columns">	
						<?php echo $form->textField($requestOrderDetail, 'discount4_nominal', array('value'=> $requestOrderDetail->discount4_nominal,'readonly'=>true)); ?>
					</div>
				</div>
		 	</div>

		 		<div class="field" id="step5">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Step 5</label>
				  </div>
					<div class="small-4 columns">
						<?php echo $form->dropDownList($requestOrderDetail, 'discount5_type', array('1' => 'Percent','2'=>'Amount','3'=>'Bonus'),array('disabled'=>true)); ?>
					</div>
					<div class="small-4 columns">	
						<?php echo $form->textField($requestOrderDetail, 'discount5_nominal', array('value'=> $requestOrderDetail->discount5_nominal,'readonly'=>true)); ?>
					</div>
				</div>
		 	</div>
		 		
		 	<?php endif ?>
		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Unit Price</label>
				  </div>
					<div class="small-8 columns">
						<?php echo $form->textField($requestOrderDetail, 'unit_price',array('value'=>$requestOrderDetail->unit_price,'readonly'=>true));  ?>
						
					</div>
				</div>
		 	</div>
		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Total Price</label>
				  </div>
					<div class="small-8 columns">
						<?php echo $form->textField($requestOrderDetail, 'total_price',array('value'=>$requestOrderDetail->total_price,'readonly'=>true));  ?>
						
					</div>
				</div>
		 	</div>
		 	
		 	<hr />
		 	<div class="field">
				<div class="row collapse">
					<div class="small-12 columns">
						<h2>Revision History</h2>
					</div>
				</div>
			</div>
			
		 	<div class="field">
				<div class="row collapse">
					<div class="small-12 columns">
					<?php if ($historis!=null): ?>
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
					
					<?php else: 
						echo "No Revision History";
					?>		
					<?php endif ?>			 
					</div>
				</div>
		 	</div>
			
			<hr />
			<div class="field">
				<div class="row collapse">
					<div class="small-12 columns">
						<h2>Approval</h2>
					</div>
				</div>
			</div>
			
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'approval_type'); ?></label>
				  </div>
					<div class="small-8 columns">
					<?php echo $form->hiddenField($model, 'request_order_detail_id',array('value'=>$requestOrderDetail->id)); ?>		
						<?php echo $form->dropDownList($model, 'approval_type', array('Revised' => 'Revised','Rejected'=>'Rejected','Approved'=>'Approved'),array('prompt'=>'[--Select Approval Status--]')); ?>
							
							<?php echo $form->error($model,'approval_type'); ?>
					</div>
				</div>
		 	</div>

			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'revision'); ?></label>
				  </div>
					<div class="small-8 columns">
						<?php $revisions = TransactionRequestOrderApproval::model()->findAllByAttributes(array('request_order_detail_id'=>$requestOrderDetail->id)); ?>
						<?php //echo count($revisions); ?>
						<?php echo $form->textField($model, 'revision',array('value'=>count($revisions)!=0? count($revisions): 0,'readonly'=>true)); ?>		
						<?php echo $form->error($model,'revision'); ?>
					</div>
				</div>
		 	</div>	

		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'date'); ?></label>
				  </div>
					<div class="small-8 columns">
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    'model' => $model,
                     'attribute' => "date",
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
						<?php echo $form->error($model,'date'); ?>
					</div>
				</div>
		 	</div>	

		 	<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'note'); ?></label>
				  </div>
					<div class="small-8 columns">
								<?php echo $form->textArea($model, 'note', array('rows'=>15, 'cols'=>50));
		?>
						<?php echo $form->error($model,'note'); ?>
					</div>
				</div>

				<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($model,'supervisor_id'); ?></label>
				  </div>
					<div class="small-8 columns">
								<?php echo $form->textField($model, 'supervisor_id');
		?>
						<?php echo $form->error($model,'supervisor_id'); ?>
					</div>
				</div>
				<hr />
				<div class="field buttons text-center">
				<?php echo CHtml::submitButton('Save', array('class'=>'button cbutton')); ?>
			</div>
		 	</div>	
		 			
		</div>

	</div>

	
	

<?php $this->endWidget(); ?>

</div><!-- form -->