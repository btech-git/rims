<?php
/* @var $this TransaksiOrderPembelianController */
/* @var $model TransaksiORderPembelian */
/* @var $form CActiveForm */
?>
<script>
	
</script>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transaction-request-order-form',
	'enableAjaxValidation'=>false,
)); ?>

	<!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->
	<div class="row">
		<div class="small-12 medium-6 columns">
		<div class="field">
			<div class="row collapse">
				<h2>Return Order</h2>
			</div>
		</div>
		<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Return Order No</label>
				  </div>
					<div class="small-8 columns">
					<?php echo $form->textField($returnOrder, 'return_order_no', array('value'=>$returnOrder->return_order_no,'readonly'=>true)); ?>
						
					</div>
				</div>
		 	</div>
		 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Date Posting</label>
				  </div>
					<div class="small-8 columns">
						<?php echo $form->textField($returnOrder, 'return_order_date', array('value'=>$returnOrder->return_order_date,'readonly'=>true)); ?>
						
					</div>
				</div>
		 	</div>

		 
		 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Status</label>
				  </div>
					<div class="small-8 columns">
						<?php echo $form->textField($returnOrder, 'status', array('value'=>$returnOrder->status,'readonly'=>true)); ?>
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
					 			<th>Approval type</th>
					 			<th>Revision</th>
					 			<th>date</th>
					 			<th>note</th>
					 			<th>supervisor</th>
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
					<?php echo $form->hiddenField($model, 'return_order_id',array('value'=>$returnOrder->id)); ?>		
						<?php echo $form->dropDownList($model, 'approval_type', array('Revised' => 'Need Revision','Rejected'=>'Rejected','Approved'=>'Approved'),array('prompt'=>'[--Select Approval Status--]')); ?>
							
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
						<?php $revisions = TransactionReturnOrderApproval::model()->findAllByAttributes(array('return_order_id'=>$returnOrder->id)); ?>
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
						<?php echo $form->textField($model, 'date',array('readonly'=>true)); ?>	
						<?php /*$this->widget('zii.widgets.jui.CJuiDatePicker',array(
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
                         ));*/ ?>
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
								<?php echo $form->textField($model, 'supervisor_id',array('readonly'=>true,'value'=> Yii::app()->user->getId()));
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