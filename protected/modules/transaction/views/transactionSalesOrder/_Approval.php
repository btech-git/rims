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
		<div class="large-12 columns">
		<div class="field">
			<div class="row collapse">
				<h2>Sales Order</h2>
			</div>
		</div>
		<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Sales Order No</label>
				  </div>
					<div class="small-8 columns">
					<?php echo $form->textField($salesOrder, 'purchase_order_no', array('value'=>$salesOrder->sale_order_no,'readonly'=>true)); ?>
						
					</div>
				</div>
		 	</div>
		 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Date Posting</label>
				  </div>
					<div class="small-8 columns">
						<?php echo $form->textField($salesOrder, 'purchase_order_date', array('value'=>$salesOrder->sale_order_date,'readonly'=>true)); ?>
						
					</div>
				</div>
		 	</div>
		 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Status Document</label>
				  </div>
					<div class="small-8 columns">
						<?php echo $form->textField($salesOrder, 'status_document', array('value'=>$salesOrder->status_document,'readonly'=>true)); ?>
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
		 	<?php $details = TransactionSalesOrderDetail::model()->findAllByAttributes(array('sales_order_id'=>$salesOrder->id)); ?>
		 		<table>
					<thead>
						<tr>
							<th>Product</th>
							<th>Quantity</th>
							<th>Unit</th>
							<th>Discount Step</th>
							<th>Discounts</th>
							<th>Selling Price</th>
							<th>Unit Price</th>
							<th>Total Qty</th>
							<th>Total Price</th>
							
						</tr>
					</thead>
					<tr>
						<?php foreach ($details as $key => $detail): ?>
						<?php $product = Product::model()->findByPK($detail->product_id); ?>
						<td><?php echo $product->name; ?></td>
						
					
						<td><?php echo $detail->quantity; ?></td>
					
						<td><?php echo $product->unit->name; ?></td>
					
						<td><?php echo $detail->discount_step; ?></td>
					
						<td></td>
					
						<td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->retail_price)); ?></td>
					
						<td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->unit_price)); ?></td>
					
						<td><?php echo $detail->total_quantity; ?></td>
					
						<td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->total_price)); ?></td>
						<?php endforeach ?>
					</tr>
				</table>
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
					 			<td><?php echo $history->supervisor != null ? $history->supervisor->username : ''; ?></td>
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
                <table>
                    <tr>
                        <td style="font-weight: bold; text-align: center">Approval Type</td>
                        <td style="font-weight: bold; text-align: center">Revision</td>
                        <td style="font-weight: bold; text-align: center">Date</td>
                        <td style="font-weight: bold; text-align: center">Note</td>
                        <td style="font-weight: bold; text-align: center">Supervisor</td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->hiddenField($model, 'sales_order_id',array('value'=>$salesOrder->id)); ?>		
                            <?php echo $form->dropDownList($model, 'approval_type', array('Revised' => 'Need Revision','Rejected'=>'Rejected','Approved'=>'Approved'),array('prompt'=>'[--Select Approval Status--]')); ?>
							<?php echo $form->error($model,'approval_type'); ?>
                        </td>
                        <td>
                            <?php $revisions = TransactionSalesOrderApproval::model()->findAllByAttributes(array('sales_order_id'=>$salesOrder->id)); ?>
                            <?php echo $form->textField($model, 'revision',array('value'=>count($revisions)!=0? count($revisions): 0,'readonly'=>true)); ?>		
                            <?php echo $form->error($model,'revision'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'date',array('readonly'=>true)); ?>
                            <?php echo $form->error($model,'date'); ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($model, 'note', array('rows'=>5, 'cols'=>30)); ?>
                            <?php echo $form->error($model,'note'); ?>
                        </td>
                        <td>
                            <?php echo $form->hiddenField($model, 'supervisor_id',array('readonly'=>true,'value'=> Yii::app()->user->getId()));?>
                            <?php echo $form->textField($model, 'supervisor_name',array('readonly'=>true,'value'=> Yii::app()->user->getName()));?>
                            <?php echo $form->error($model,'supervisor_id'); ?>
                        </td>
                    </tr>
                </table>
				<hr />
				<div class="field buttons text-center">
				<?php echo CHtml::submitButton('Save', array('class'=>'button cbutton')); ?>
			</div>
		 	</div>	
		 			
		</div>

	</div>

	
	

<?php $this->endWidget(); ?>

</div><!-- form -->