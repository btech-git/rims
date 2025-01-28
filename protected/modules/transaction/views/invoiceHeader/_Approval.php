<?php
/* @var $this TransaksiOrderPembelianController */
/* @var $model TransaksiORderPembelian */
/* @var $form CActiveForm */
?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'transaction-request-order-form',
        'enableAjaxValidation' => false,
    )); ?>

    <div class="row">
        <div class="large-12 columns">
            <div class="field">
                <div class="row collapse">
                    <h2>Invoice Approval</h2>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Invoice No</label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textField($invoiceHeader, 'invoice_number', array('value' => $invoiceHeader->invoice_number, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Date Posting</label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textField($invoiceHeader, 'invoice_date', array('value' => $invoiceHeader->invoice_date, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Status Document</label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textField($invoiceHeader, 'status', array('value' => $invoiceHeader->status, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            
            <hr />
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-12 columns">
                        <h2>Invoice Detail</h2>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <?php $details = InvoiceDetail::model()->findAllByAttributes(array('invoice_id' => $invoiceHeader->id)); ?>
                <table>
                    <thead>
                        <tr>
                            <td>Code</td>
                            <td>Parts / Jasa</td>
                            <td>Quantity</td>
                            <td>Satuan</td>
                            <td>Unit Price</td>
                            <td>Discount</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($details as $key => $detail): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($detail->product_id)): ?>
                                        <?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')); ?>
                                    <?php elseif (!empty($detail->service_id)): ?>
                                        <?php echo CHtml::encode(CHtml::value($detail, 'service.code')); ?>
                                    <?php else: ?>
                                        <?php echo ''; ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($detail->product_id)): ?>
                                        <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?>
                                    <?php elseif (!empty($detail->service_id)): ?>
                                        <?php echo CHtml::encode(CHtml::value($detail, 'service.name')); ?>
                                    <?php else: ?>
                                        <?php echo ''; ?>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'product.unit.name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'unit_price')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'discount')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'total_price')); ?></td>
                            </tr>
                        <?php endforeach; ?>
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
                        <?php if ($historis != null): ?>
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
                                            <td><?php echo CHtml::encode(CHtml::value($detail, 'approval_type')); ?></td>
                                            <td><?php echo CHtml::encode(CHtml::value($detail, 'revision')); ?></td>
                                            <td><?php echo CHtml::encode(CHtml::value($detail, 'date')); ?></td>
                                            <td><?php echo CHtml::encode(CHtml::value($detail, 'note')); ?></td>
                                            <td><?php echo CHtml::encode(CHtml::value($detail, 'supervisor.username')); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
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
                            <?php echo $form->hiddenField($model, 'invoice_header_id', array('value' => $invoiceHeader->id)); ?>		
                            <?php echo $form->dropDownList($model, 'approval_type', array(
                                'Revised' => 'Need Revision', 
                                'Rejected' => 'Rejected', 
                                'Approved' => 'Approved'
                            ), array('prompt' => '[--Select Approval Status--]')); ?>
                            <?php echo $form->error($model, 'approval_type'); ?>
                        </td>
                        <td>
                            <?php $revisions = InvoiceApproval::model()->findAllByAttributes(array('invoice_header_id' => $invoiceHeader->id)); ?>
                            <?php echo $form->textField($model, 'revision', array('value' => count($revisions) != 0 ? count($revisions) : 0, 'readonly' => true)); ?>		
                            <?php echo $form->error($model, 'revision'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'date', array('readonly' => true)); ?>
                            <?php echo $form->error($model, 'date'); ?>
                        </td>
                        <td>
                            <?php echo $form->textArea($model, 'note', array('rows' => 5, 'cols' => 30)); ?>
                            <?php echo $form->error($model, 'note'); ?>
                        </td>
                        <td>
                            <?php echo $form->hiddenField($model, 'supervisor_id', array('readonly' => true, 'value' => Yii::app()->user->getId())); ?>
                            <?php echo CHtml::textField('SupervisorName', '', array('readonly' => true, 'value' => Yii::app()->user->getName())); ?>
                            <?php echo $form->error($model, 'supervisor_id'); ?>
                        </td>
                    </tr>
                </table>
            </div>
            
            <hr />
            
            <div class="field buttons text-center">
                <?php echo CHtml::submitButton('Save', array('class' => 'button cbutton')); ?>
            </div>
        </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->