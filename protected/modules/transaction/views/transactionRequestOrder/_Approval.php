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
				<h2>Request Order</h2>
			</div>
		</div>
		<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix">Request Order No</label>
				  </div>
					<div class="small-8 columns">
					<?php echo $form->textField($requestOrder, 'request_order_no', array('value'=>$requestOrder->request_order_no,'readonly'=>true)); ?>
						
					</div>
				</div>
		 	</div>
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
				<?php $details = TransactionRequestOrderDetail::model()->findAllByAttributes(array('request_order_id'=>$requestOrder->id)); ?>
				<table>
					<thead>
						<tr>
							<th>Product</th>
							<th>Quantity</th>
							<th>Unit</th>
							<th>Discount step</th>
							<th>Discounts</th>
							<th>Retail Price</th>
							<th>Price</th>
                            <th>Total</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($details as $key => $detail): ?>
							<tr>
								<td><?php echo $detail->product != null ? $detail->product->name : ''; ?></td>
								<td><?php echo $detail->quantity; ?></td>
								<td><?php echo $detail->product->unit->name; ?></td>
								<td><?php echo $detail->discount_step; ?></td>
                                <td>
                                    <?php if ($detail->discount_step == 1): ?>
                                        <?php echo $detail->discount1_nominal . ' (' . $detail->discountType1Literal . ')'; ?>
                                    <?php elseif($detail->discount_step == 2): ?>
                                        <?php echo $detail->discount1_nominal . ' (' . $detail->discountType1Literal . ') || '; ?>
                                        <?php echo $detail->discount2_nominal . ' (' . $detail->discountType2Literal . ')'; ?>
                                    <?php elseif($detail->discount_step == 3): ?>
                                        <?php echo $detail->discount1_nominal . ' (' . $detail->discountType1Literal . ') || '; ?>
                                        <?php echo $detail->discount2_nominal . ' (' . $detail->discountType2Literal . ') || '; ?>
                                        <?php echo $detail->discount3_nominal . ' (' . $detail->discountType3Literal . ')'; ?>
                                    <?php elseif($detail->discount_step == 4): ?>
                                        <?php echo $detail->discount1_nominal . ' (' . $detail->discountType1Literal . ') || '; ?>
                                        <?php echo $detail->discount2_nominal . ' (' . $detail->discountType2Literal . ') || '; ?>
                                        <?php echo $detail->discount3_nominal . ' (' . $detail->discountType3Literal . ') || '; ?>
                                        <?php echo $detail->discount4_nominal . ' (' . $detail->discountType4Literal . ')'; ?>
                                    <?php elseif($detail->discount_step == 5): ?>
                                        <?php echo $detail->discount1_nominal . ' (' . $detail->discountType1Literal . ') || '; ?>
                                        <?php echo $detail->discount2_nominal . ' (' . $detail->discountType2Literal . ') || '; ?>
                                        <?php echo $detail->discount3_nominal . ' (' . $detail->discountType3Literal . ') || '; ?>
                                        <?php echo $detail->discount4_nominal . ' (' . $detail->discountType4Literal . ') || '; ?>
                                        <?php echo $detail->discount5_nominal . ' (' . $detail->discountType5Literal . ')'; ?>
                                    <?php else: ?>
                                        <?php echo "0"; ?>
                                    <?php endif ?>
                                </td>
								<td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'retail_price'))); ?></td>
								<td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price'))); ?></td>
								<td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total_price'))); ?></td>
							</tr>
                            <tr>
                                <td colspan="6">
                                    <?php $unit = Unit::model()->findByPk($detail->unit_id); ?>
                                    Manufacture Code: <?php echo CHtml::Encode(CHtml::value($detail, 'product.manufacturer_code')); ?> ||
                                    Category: <?php echo CHtml::Encode(CHtml::value($detail, 'product.masterSubCategoryCode')); ?> ||
                                    Brand: <?php echo CHtml::Encode(CHtml::value($detail, 'product.brand.name')); ?> ||
                                    Sub Brand: <?php echo CHtml::Encode(CHtml::value($detail, 'product.subBrand.name')); ?> ||
                                    Brand Series: <?php echo CHtml::Encode(CHtml::value($detail, 'product.subBrandSeries.name')); ?> ||
                                    Unit: <?php echo CHtml::encode(CHtml::value($unit, 'name')); ?>
                                </td>
                                <td style="text-align: right">Total Qty</td>
                                <td style="text-align: center"><?php echo $detail->total_quantity; ?></td>
                            </tr>
						<?php endforeach ?>
					</tbody>
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
					 			<td><?php echo $history->supervisor != null ? $history->supervisor->username : ""; ?></td>
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
                <table>
                    <tr>
                        <td style="font-weight: bold; text-align: center"><?php echo $form->labelEx($model,'approval_type'); ?></td>
                        <td style="font-weight: bold; text-align: center"><?php echo $form->labelEx($model,'revision'); ?></td>
                        <td style="font-weight: bold; text-align: center"><?php echo $form->labelEx($model,'date'); ?></td>
                        <td style="font-weight: bold; text-align: center"><?php echo $form->labelEx($model,'note'); ?></td>
                        <td style="font-weight: bold; text-align: center"><?php echo $form->labelEx($model,'supervisor_id'); ?></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->hiddenField($model, 'request_order_id',array('value'=>$requestOrder->id)); ?>		
                            <?php echo $form->dropDownList($model, 'approval_type', array('Revised' => 'Need Revision','Rejected'=>'Rejected','Approved'=>'Approved'),array('prompt'=>'[--Select Approval Status--]')); ?>
							<?php echo $form->error($model,'approval_type'); ?>
                        </td>
                        <td>
                            <?php $revisions = TransactionRequestOrderApproval::model()->findAllByAttributes(array('request_order_id'=>$requestOrder->id)); ?>
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
            </div>
				<hr />
				<div class="field buttons text-center">
				<?php echo CHtml::submitButton('Save', array('class'=>'button cbutton', 'onclick' => 'this.disabled = true')); ?>
			</div>
		 	</div>	
		 			
		</div>

	</div>

	
	

<?php $this->endWidget(); ?>

</div><!-- form -->