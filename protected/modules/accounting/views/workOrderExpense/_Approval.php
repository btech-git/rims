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
        <div class="field">
            <div class="row collapse">
                <h2>Approval Sub Pekerjaan Luar</h2>
            </div>
        </div>
        
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <label class="prefix">Sub Pekerjaan Luar #</label>
                </div>
                <div class="small-8 columns">
                    <?php echo $form->textField($workOrderExpense, 'transaction_number', array('value' => $workOrderExpense->transaction_number, 'readonly' => true)); ?>
                </div>
            </div>
        </div>
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <label class="prefix">Tanggal</label>
                </div>
                <div class="small-8 columns">
                    <?php echo $form->textField($workOrderExpense, 'transaction_date', array('value' => $workOrderExpense->transaction_date, 'readonly' => true)); ?>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <label class="prefix">Grand Total</label>
                </div>
                <div class="small-8 columns">
                    <?php echo $form->textField($workOrderExpense, 'grand_total', array('value' => $workOrderExpense->grand_total, 'readonly' => true)); ?>
                </div>
            </div>
        </div>
        
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <label class="prefix">Status</label>
                </div>
                <div class="small-8 columns">
                    <?php echo $form->textField($workOrderExpense, 'status', array('value' => $workOrderExpense->status, 'readonly' => true)); ?>
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

                    <?php
                    else:
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
                        <?php echo $form->hiddenField($model, 'work_order_expense_header_id', array('value' => $workOrderExpense->id)); ?>		
                        <?php echo $form->dropDownList($model, 'approval_type', array(
                            'Revised' => 'Need Revision', 
                            'Rejected' => 'Rejected', 
                            'Approved' => 'Approved'
                        ), array('prompt' => '[--Select Approval Status--]')); ?>
                        <?php echo $form->error($model, 'approval_type'); ?>
                    </td>
                    <td>
                        <?php $revisions = WorkOrderExpenseApproval::model()->findAllByAttributes(array('work_order_expense_header_id' => $workOrderExpense->id)); ?>
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
                        <?php echo $form->textField($model, 'supervisor_name', array('readonly' => true, 'value' => Yii::app()->user->getName())); ?>
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