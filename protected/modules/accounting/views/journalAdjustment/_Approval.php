<?php
/* @var $this TransaksiOrderPembelianController */
/* @var $model TransaksiORderPembelian */
/* @var $form CActiveForm */
?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'journal-adjustment-form',
        'enableAjaxValidation' => false,
    )); ?>
    <?php echo $form->errorSummary($model); ?>
    
    <div class="row">
        <div class="large-12 columns">
            <div class="field">
                <div class="row collapse">
                    <h2>Jurnal Penyesuaian</h2>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Jurnal No</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($journalVoucher, 'transaction_number', array('value' => $journalVoucher->transaction_number, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Date Posting</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($journalVoucher, 'date', array('value' => $journalVoucher->date, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Status</label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($journalVoucher, 'status', array('value' => $journalVoucher->status, 'readonly' => true)); ?>
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
                        <?php if ($historis != null): ?>
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
                                            <td><?php echo $history->supervisor->username; ?></td>
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
                            <?php echo $form->hiddenField($model, 'cash_transaction_id',array('value'=>$journalVoucher->id)); ?>		
                            <?php echo $form->dropDownList($model, 'approval_type', array(
                                'Revised' => 'Need Revision',
                                'Rejected'=>'Rejected',
                                'Approved'=>'Approved'
                            ),array('prompt'=>'[--Select Approval Status--]')); ?>
                            <?php echo $form->error($model,'approval_type'); ?>
                        </td>
                        <td>
                            <?php $revisions = JournalAdjustmentApproval::model()->findAllByAttributes(array('journal_adjustment_header_id' => $journalVoucher->id)); ?>
                            <?php echo $form->textField($model, 'revision',array('value' => count($revisions) != 0 ? count($revisions) : 0, 'readonly' => true)); ?>		
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
                <?php echo CHtml::submitButton('Save', array('class' => 'button cbutton')); ?>
            </div>
        </div>	
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->