<?php
/* @var $this TransaksiOrderPembelianController */
/* @var $model TransaksiORderPembelian */
/* @var $form CActiveForm */
?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'sent-request-order-form',
        'enableAjaxValidation' => false,
    )); ?>

        <!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->
    <div class="row">
        <div class="large-12 columns">
            <div class="field">
                <div class="row collapse">
                    <h2>Sent Request</h2>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Sent Request No</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($sentRequest, 'sent_request_no', array('value' => $sentRequest->sent_request_no, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Date Posting</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($sentRequest, 'sent_request_date', array('value' => $sentRequest->sent_request_date, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Status Document</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($sentRequest, 'status_document', array('value' => $sentRequest->status_document, 'readonly' => true)); ?>
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
                <?php $details = TransactionSentRequestDetail::model()->findAllByAttributes(array('sent_request_id' => $sentRequest->id)); ?>
                <table>
                    <thead>
                        <tr>
                            <td>Product</td>
                            <td>Quantity</td>
                            <td>Unit Price (HPP)</td>
                            <td>Unit</td>
                            <td>Amount</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($details as $key => $sentDetail): ?>
                            <tr>
                                <td><?php echo $sentDetail->product_id != "" ? $sentDetail->product->name : '-'; ?></td>
                                <td><?php echo $sentDetail->quantity; ?></td>
                                <td><?php echo $sentDetail->unit_price; ?></td>
                                <td><?php echo $sentDetail->unit_id; ?></td>
                                <td><?php echo $sentDetail->amount; ?></td>
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
                                            <td><?php echo $history->approval_type; ?></td>
                                            <td><?php echo $history->revision; ?></td>
                                            <td><?php echo $history->date; ?></td>
                                            <td><?php echo $history->note; ?></td>
                                            <td><?php echo $history->supervisor_id; ?></td>
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
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($model, 'approval_type'); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->hiddenField($model, 'sent_request_id', array('value' => $sentRequest->id)); ?>		
                        <?php echo $form->dropDownList($model, 'approval_type', array('Revised' => 'Revised', 'Rejected' => 'Rejected', 'Approved' => 'Approved'), array('prompt' => '[--Select Approval Status--]')); ?>
                        <?php echo $form->error($model, 'approval_type'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($model, 'revision'); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php $revisions = TransactionSentRequestApproval::model()->findAllByAttributes(array('sent_request_id' => $sentRequest->id)); ?>
                        <?php echo $form->textField($model, 'revision', array('value' => count($revisions) != 0 ? count($revisions) : 0, 'readonly' => true)); ?>		
                        <?php echo $form->error($model, 'revision'); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($model, 'date'); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'date', array('readonly' => true)); ?>
                        <?php echo $form->error($model, 'date'); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($model, 'note'); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textArea($model, 'note', array('rows' => 15, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'note'); ?>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'supervisor_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'supervisor_id', array('readonly' => true, 'value' => Yii::app()->user->getId())); ?>
                            <?php echo $form->error($model, 'supervisor_id'); ?>
                        </div>
                    </div>
                    <hr />
                    <div class="field buttons text-center">
                        <?php echo CHtml::submitButton('Save', array('class' => 'button cbutton')); ?>
                    </div>
                </div>	
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>