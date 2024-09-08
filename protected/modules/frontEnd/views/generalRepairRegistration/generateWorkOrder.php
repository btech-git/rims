<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'General Repair Registration'=>array('admin'),
	'Generate WO',
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <h1><?php echo "Work Order Form"; ?></h1>
        <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'registration-transaction-form',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'enableAjaxValidation'=>false,
            )); ?>

            <?php echo $form->errorSummary($generalRepairRegistration->header); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                            'tabs' => array(
                                'Customer Info' => array(
                                    'id' => 'info1',
                                    'content' => $this->renderPartial('_infoCustomer', array(
                                        'generalRepairRegistration' => $generalRepairRegistration, 
                                        'customer' => $customer,
                                    ), true)
                                ),
                                'Vehicle Info' => array(
                                    'id' => 'info2',
                                    'content' => $this->renderPartial('_infoVehicle', array(
                                        'generalRepairRegistration' => $generalRepairRegistration,
                                        'vehicle' => $vehicle,
                                    ), true)
                                ),
                                'Service Exception Rate' => array(
                                    'id' => 'info3',
                                    'content' => $this->renderPartial('_serviceException', array(
                                        'generalRepairRegistration' => $generalRepairRegistration,
                                        'customer' => $customer,
                                    ), true)
                                ),
                                'History' => array(
                                    'id' => 'info4',
                                    'content' => $this->renderPartial('_historyTransaction', array(
                                        'generalRepairRegistration' => $generalRepairRegistration,
                                        'vehicle' => $vehicle,
                                    ), true)
                                ),
                            ),
                            // additional javascript options for the tabs plugin
                            'options' => array(
                                'collapsible' => true,
                            ),
                            // set id for this widgets
                            'id' => 'view_tab',
                        )); ?>  
                    </div>
                    <!-- END ROW -->
                    <br />

                    <div class="row">
                        <div class="medium-12 columns">
                            <h2>Transaction</h2>
                            
                            <hr />

                            <div class="row">
                                <div class="medium-6 columns">
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($generalRepairRegistration->header,'transaction_number'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'transaction_number')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($generalRepairRegistration->header,'transaction_date'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'transaction_date')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($generalRepairRegistration->header,'work_order_number'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'work_order_number')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($generalRepairRegistration->header,'work_order_date'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                    'model' => $generalRepairRegistration->header,
                                                    'attribute' => "work_order_date",
                                                    'options' => array(
                                                        'dateFormat' => 'yy-mm-dd',
                                                        'changeMonth' => true,
                                                        'changeYear' => true,
                                                    ),
                                                    'htmlOptions' => array(
                                                        'readonly' => true,
                                                    ),
                                                )); ?>
                                                <?php echo $form->error($generalRepairRegistration->header,'work_order_date'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($generalRepairRegistration->header,'status'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'status')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($customer->customer_type === 'Company'): ?>
                                        <div class="field">
                                            <div class="row collapse">
                                                <div class="small-4 columns">
                                                    <label class="prefix"><?php echo $form->labelEx($generalRepairRegistration->header, 'customer_work_order_number'); ?></label>
                                                </div>
                                                <div class="small-8 columns">
                                                    <?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'customer_work_order_number')); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div> 
                                <!-- END COLUMN 6-->
                                <div class="medium-6 columns">
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($generalRepairRegistration->header,'branch_id'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'branch.name')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($generalRepairRegistration->header,'user_id'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'user.username')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix">Car Mileage (KM)</label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'vehicle_mileage')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($generalRepairRegistration->header,'repair_type'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'repair_type')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($generalRepairRegistration->header,'employee_id_assign_mechanic'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'employeeIdAssignMechanic.username')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <div class="row">
                        <div class="medium-12 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-2 columns">
                                        <label class="prefix"><?php echo $form->labelEx($generalRepairRegistration->header,'problem'); ?></label>
                                    </div>
                                    <div class="small-10 columns">
                                        <?php echo CHtml::encode(CHtml::value($generalRepairRegistration->header, 'problem')); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <hr />
                            
                            <div class="field buttons text-center">
                                <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                                <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'button cbutton')); ?> 
                            </div>
                            <?php echo IdempotentManager::generate(); ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
</div>