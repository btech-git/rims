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
                    <h2>Transfer Request</h2>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Maintenance Request No</label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textField($maintenanceRequest, 'transaction_number', array('value' => $maintenanceRequest->transaction_number, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Date Posting</label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textField($maintenanceRequest, 'transaction_date', array('value' => $maintenanceRequest->transaction_date, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Status Document</label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textField($maintenanceRequest, 'status', array('value' => $maintenanceRequest->status, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            
            <hr />
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-12 columns">
                        <h2>Maintenance Detail</h2>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <?php $details = MaintenanceRequestDetail::model()->findAllByAttributes(array('maintenance_request_header_id' => $maintenanceRequest->id)); ?>
                <table>
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Code</td>
                            <td>Quantity</td>
                            <td>Memo</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($details as $key => $maintenanceDetail): ?>
                            <tr>
                                <td><?php echo $maintenanceDetail->item_name; ?></td>
                                <td><?php echo $maintenanceDetail->item_code; ?></td>
                                <td><?php echo $maintenanceDetail->quantity; ?></td>
                                <td><?php echo $maintenanceDetail->memo; ?></td>
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
                        <?php echo $form->hiddenField($model, 'maintenance_request_id', array('value' => $maintenanceRequest->id)); ?>		
                        <?php echo $form->dropDownList($model, 'approval_type', array(
                            'Revised' => 'Need Revision', 
                            'Rejected' => 'Rejected', 
                            'Approved' => 'Approved'
                        ), array('prompt' => '[--Select Approval Status--]')); ?>
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
                        <?php $revisions = MaintenanceRequestApproval::model()->findAllByAttributes(array('maintenance_request_header_id' => $maintenanceRequest->id)); ?>
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
                            <?php echo $form->textField($model, 'supervisor_id', array('readonly' => true, 'value' => Yii::app()->user->getName())); ?>
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