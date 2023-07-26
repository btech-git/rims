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
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <h2>Employee DayOff Approval</h2>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Employee Name</label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textField($dayOff, 'employee_name', array('value' => $dayOff->employee->name, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Day</label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textField($dayOff, 'day', array('value' => $dayOff->day, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Date From - to</label>
                    </div>
                    
                    <div class="small-4 columns">
                        <?php echo $form->textField($dayOff, 'date_from', array('value' => $dayOff->date_from, 'readonly' => true)); ?>
                    </div>

                    <div class="small-4 columns">
                        <?php echo $form->textField($dayOff, 'date_to', array('value' => $dayOff->date_to, 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix">Status</label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textField($dayOff, 'status', array('value' => $dayOff->status, 'readonly' => true)); ?>
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
                        <?php echo $form->hiddenField($model, 'employee_dayoff_id', array('value' => $dayOff->id)); ?>		
                        <?php echo $form->dropDownList($model, 'approval_type', array(
                            'Revised' => 'Revised', 
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
                        <?php $revisions = EmployeeDayoffApproval::model()->findAllByAttributes(array('employee_dayoff_id' => $dayOff->id)); ?>
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
                        <?php echo $form->textField($model, 'date', array('readonly' => true, 'value' => date('Y-m-d'))); ?>
                        <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => "date",
                            // additional javascript options for the date picker plugin
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                                'changeYear' => true,
                                'yearRange' => '1900:2020'
                            ),
                            'htmlOptions' => array(
                                'value' => date('Y-m-d'),
                            ),
                        ));*/ ?>
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
                            <?php echo $form->hiddenField($model, 'supervisor_id', array('readonly' => true, 'value' => Yii::app()->user->getId())); ?>
                            <?php echo $form->textField($model, 'supervisor_name', array('readonly' => true, 'value' => Yii::app()->user->getName())); ?>
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