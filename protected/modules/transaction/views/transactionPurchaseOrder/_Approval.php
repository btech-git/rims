<?php
/* @var $this TransaksiOrderPembelianController */
/* @var $model TransaksiORderPembelian */
/* @var $form CActiveForm */
?>

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
				<h2>Purchase Order</h2>
			</div>
		</div>
		<div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <label class="prefix">Purchase Order No</label>
              </div>
                <div class="small-8 columns">
                <?php echo $form->textField($purchaseOrder, 'purchase_order_no', array('value'=>$purchaseOrder->purchase_order_no,'readonly'=>true)); ?>

                </div>
            </div>
        </div>
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <label class="prefix">Date Posting</label>
              </div>
                <div class="small-8 columns">
                    <?php echo $form->textField($purchaseOrder, 'purchase_order_date', array('value'=>$purchaseOrder->purchase_order_date,'readonly'=>true)); ?>

                </div>
            </div>
        </div>
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                  <label class="prefix">Status Document</label>
              </div>
                <div class="small-8 columns">
                    <?php echo $form->textField($purchaseOrder, 'status_document', array('value'=>$purchaseOrder->status_document,'readonly'=>true)); ?>
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
<!--					<tr>
						<?php /*$detailRequests = TransactionPurchaseOrderDetailRequest::model()->findAllByAttributes(array('purchase_order_detail_id'=>$purchaseOrderDetail->id)); ?>
						<td colspan="8">
							<table>
								<tr>
									<td style="font-weight: bold; text-align: center">Purchase Request no</td>
									<td style="font-weight: bold; text-align: center">PR Quantity</td>
									<td style="font-weight: bold; text-align: center">ETA</td>
									<td style="font-weight: bold; text-align: center">Branch</td>
									<td style="font-weight: bold; text-align: center">PO Quantity</td>
									<td style="font-weight: bold; text-align: center">Notes</td>

								</tr>
								<?php foreach ($detailRequests as $key => $detailRequest): ?>
									<?php $requestOrder = TransactionRequestOrder::model()->findByPK($detailRequest->purchase_request_id);  ?>
									<?php $requestOrderDetail = TransactionRequestOrderDetail::model()->findByPK($detailRequest->purchase_request_detail_id);  ?>
									<?php $branch = Branch::model()->findByPK($detailRequest->purchase_request_branch_id);  ?>
									<tr>
										<td><?php echo $requestOrder->request_order_no; ?></td>
										<td><?php echo $detailRequest->purchase_request_quantity; ?></td>
										<td><?php echo $detailRequest->estimate_date_arrival; ?></td>
										<td><?php echo $branch->name; ?></td>
										<td><?php echo $detailRequest->purchase_order_quantity; ?></td>
										<td><?php echo $detailRequest->notes; ?></td>
									</tr>
								<?php endforeach; */ ?>
								
							</table>
						</td>
					</tr>-->
        <div class="field">
            <table>
                <tr>
                    <td style="font-weight: bold; text-align: center">Product</td>
                    <td style="font-weight: bold; text-align: center">Quantity</td>
                    <td style="font-weight: bold; text-align: center">Unit</td>
                    <td style="font-weight: bold; text-align: center">Discount step</td>
                    <td style="font-weight: bold; text-align: center">Discounts </td>
                    <td style="font-weight: bold; text-align: center">Retail Price</td>
                    <td style="font-weight: bold; text-align: center">Unit Price</td>
                    <td style="font-weight: bold; text-align: center">Total Price</td>
                </tr>
                <?php $purchaseOrderDetails = TransactionPurchaseOrderDetail::model()->findAllByAttributes(array('purchase_order_id'=>$purchaseOrder->id)) ?>
                <?php foreach ($purchaseOrderDetails as $key => $purchaseOrderDetail): ?>
                    <tr>
                        <?php $product = Product::model()->findByPK($purchaseOrderDetail->product_id); ?>
						<td><?php echo $purchaseOrderDetail->product->name; ?></td>
						<td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchaseOrderDetail, 'quantity'))); ?></td>
						<td><?php echo $purchaseOrderDetail->product->unit->name; ?></td>
						<td><?php echo $purchaseOrderDetail->discount_step; ?></td>
                        <td>
                            <?php if ($purchaseOrderDetail->discount_step == 1): ?>
                                <?php echo $purchaseOrderDetail->discount1_nominal . ' (' . $purchaseOrderDetail->discountType1Literal . ')'; ?>
                            <?php elseif($purchaseOrderDetail->discount_step == 2): ?>
                                <?php echo $purchaseOrderDetail->discount1_nominal . ' (' . $purchaseOrderDetail->discountType1Literal . ') || '; ?>
                                <?php echo $purchaseOrderDetail->discount2_nominal . ' (' . $purchaseOrderDetail->discountType2Literal . ')'; ?>
                            <?php elseif($purchaseOrderDetail->discount_step == 3): ?>
                                <?php echo $purchaseOrderDetail->discount1_nominal . ' (' . $purchaseOrderDetail->discountType1Literal . ') || '; ?>
                                <?php echo $purchaseOrderDetail->discount2_nominal . ' (' . $purchaseOrderDetail->discountType2Literal . ') || '; ?>
                                <?php echo $purchaseOrderDetail->discount3_nominal . ' (' . $purchaseOrderDetail->discountType3Literal . ')'; ?>
                            <?php elseif($purchaseOrderDetail->discount_step == 4): ?>
                                <?php echo $purchaseOrderDetail->discount1_nominal . ' (' . $purchaseOrderDetail->discountType1Literal . ') || '; ?>
                                <?php echo $purchaseOrderDetail->discount2_nominal . ' (' . $purchaseOrderDetail->discountType2Literal . ') || '; ?>
                                <?php echo $purchaseOrderDetail->discount3_nominal . ' (' . $purchaseOrderDetail->discountType3Literal . ') || '; ?>
                                <?php echo $purchaseOrderDetail->discount4_nominal . ' (' . $purchaseOrderDetail->discountType4Literal . ')'; ?>
                            <?php elseif($purchaseOrderDetail->discount_step == 5): ?>
                                <?php echo $purchaseOrderDetail->discount1_nominal . ' (' . $purchaseOrderDetail->discountType1Literal . ') || '; ?>
                                <?php echo $purchaseOrderDetail->discount2_nominal . ' (' . $purchaseOrderDetail->discountType2Literal . ') || '; ?>
                                <?php echo $purchaseOrderDetail->discount3_nominal . ' (' . $purchaseOrderDetail->discountType3Literal . ') || '; ?>
                                <?php echo $purchaseOrderDetail->discount4_nominal . ' (' . $purchaseOrderDetail->discountType4Literal . ') || '; ?>
                                <?php echo $purchaseOrderDetail->discount5_nominal . ' (' . $purchaseOrderDetail->discountType5Literal . ')'; ?>
                            <?php else: ?>
                                <?php echo "0"; ?>
                            <?php endif ?>
                        </td>
						<td><span class="numbers"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchaseOrderDetail, 'retail_price'))); ?></span></td>
						<td><span class="numbers"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchaseOrderDetail, 'unit_price'))); ?></span></td>
						<td><span class="numbers"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchaseOrderDetail, 'total_price'))); ?></span></td>
					</tr>
                    <tr>
                        <td colspan="6">
                            <?php $unit = Unit::model()->findByPk($purchaseOrderDetail->unit_id); ?>
                            Manufacture Code: <?php echo CHtml::Encode(CHtml::value($purchaseOrderDetail, 'product.manufacturer_code')); ?> ||
                            Category: <?php echo CHtml::Encode(CHtml::value($purchaseOrderDetail, 'product.masterSubCategoryCode')); ?> ||
                            Brand: <?php echo CHtml::Encode(CHtml::value($purchaseOrderDetail, 'product.brand.name')); ?> ||
                            Sub Brand: <?php echo CHtml::Encode(CHtml::value($purchaseOrderDetail, 'product.subBrand.name')); ?> ||
                            Brand Series: <?php echo CHtml::Encode(CHtml::value($purchaseOrderDetail, 'product.subBrandSeries.name')); ?> ||
                            Unit: <?php echo CHtml::encode(CHtml::value($unit, 'name')); ?>
                        </td>
                        <td style="text-align: right">Total Qty</td>
                        <td style="text-align: center"><?php echo $purchaseOrderDetail->total_quantity; ?></td>
                    </tr>
                <?php endforeach; ?>
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
					 			<td><?php echo $history->supervisor != null ? $history->supervisor->username : " "; ?></td>
					 		</tr>
					 	<?php endforeach ?>
					 	</tbody>
					 </table>
					<?php else: 
						echo "No Revision History";
					?>		
					<?php endif; ?>			 
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
                        <td style="font-weight: bold; text-align: center">Approval Type</td>
                        <td style="font-weight: bold; text-align: center">Revision</td>
                        <td style="font-weight: bold; text-align: center">Date</td>
                        <td style="font-weight: bold; text-align: center">Note</td>
                        <td style="font-weight: bold; text-align: center">Supervisor</td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->hiddenField($model, 'purchase_order_id',array('value'=>$purchaseOrder->id)); ?>		
                            <?php echo $form->dropDownList($model, 'approval_type', array('Revised' => 'Need Revision','Rejected'=>'Rejected','Approved'=>'Approved'),array('prompt'=>'[--Select Approval Status--]')); ?>
							<?php echo $form->error($model,'approval_type'); ?>
                        </td>
                        <td>
                            <?php $revisions = TransactionPurchaseOrderApproval::model()->findAllByAttributes(array('purchase_order_id'=>$purchaseOrder->id)); ?>
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
                <?php echo CHtml::submitButton('Save', array('class'=>'button cbutton')); ?>
            </div>
        </div>	
    </div>
</div>
			
<!--			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php /*echo $form->labelEx($model,'approval_type'); ?></label>
				  </div>
					<div class="small-8 columns">
					<?php echo $form->hiddenField($model, 'purchase_order_id',array('value'=>$purchaseOrder->id)); ?>		
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
						<?php $revisions = TransactionPurchaseOrderApproval::model()->findAllByAttributes(array('purchase_order_id'=>$purchaseOrder->id)); ?>
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
                         )); ?>
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
						<?php echo $form->hiddenField($model, 'supervisor_id',array('readonly'=>true,'value'=> Yii::app()->user->getId()));?>
						<?php echo $form->textField($model, 'supervisor_name',array('readonly'=>true,'value'=> Yii::app()->user->getName()));?>
						<?php echo $form->error($model,'supervisor_id');*/ ?>
					</div>
				</div>-->

    <?php $this->endWidget(); ?>
</div><!-- form -->