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

            <?php echo $form->errorSummary($registrationTransaction->header); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <table>
                            <thead>
                                <tr>
                                    <td>Plate #</td>
                                    <td>Vehicle</td>
                                    <td>Color</td>
                                    <td>Machine #</td>
                                    <td>Frame #</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php echo CHtml::activehiddenField($registrationTransaction->header, 'vehicle_id'); ?>
                                        <?php echo CHtml::encode(CHtml::value($vehicle, 'plate_number')); ?>
                                        <?php echo CHtml::error($registrationTransaction->header,'vehicle_id'); ?>
                                    </td>
                                    <td>
                                        <?php echo CHtml::encode(CHtml::value($vehicle, 'carMake.name')); ?>
                                        <?php echo CHtml::encode(CHtml::value($vehicle, 'carModel.name')); ?>
                                        <?php echo CHtml::encode(CHtml::value($vehicle, 'carSubModel.name')); ?>
                                    </td>
                                    <td>
                                        <?php $color = Colors::model()->findByPk($vehicle->color_id); ?>
                                        <?php echo CHtml::encode(CHtml::value($color, 'name')); ?>
                                    </td>
                                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'machine_number')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'frame_number')); ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <hr />

                        <table>
                            <thead>
                                <tr>
                                    <td>Customer</td>
                                    <td>Type</td>
                                    <td>Address</td>
                                    <td>Phone</td>
                                    <td>Email</td>
                                    <td>Birth Date</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php echo CHtml::activeHiddenField($registrationTransaction->header, 'customer_id'); ?>
                                        <?php echo CHtml::encode(CHtml::value($customer, 'name')); ?>
                                        <?php echo CHtml::error($registrationTransaction->header,'customer_id'); ?>
                                    </td>
                                    <td><?php echo CHtml::encode(CHtml::value($customer, 'customer_type')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($customer, 'address')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($customer, 'mobile_phone')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($customer, 'email')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($customer, 'birthdate')); ?></td>
                                </tr>
                            </tbody>
                        </table>
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
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'transaction_number'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($registrationTransaction->header, 'transaction_number')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'transaction_date'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($registrationTransaction->header, 'transaction_date')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'work_order_number'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($registrationTransaction->header, 'work_order_number')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'work_order_date'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                    'model' => $registrationTransaction->header,
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
                                                <?php echo $form->error($registrationTransaction->header,'work_order_date'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'status'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($registrationTransaction->header, 'status')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($customer->customer_type === 'Company'): ?>
                                        <div class="field">
                                            <div class="row collapse">
                                                <div class="small-4 columns">
                                                    <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header, 'customer_work_order_number'); ?></label>
                                                </div>
                                                <div class="small-8 columns">
                                                    <?php echo CHtml::encode(CHtml::value($registrationTransaction->header, 'customer_work_order_number')); ?>
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
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'branch_id'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($registrationTransaction->header, 'branch.name')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'user_id'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($registrationTransaction->header, 'user.username')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix">Car Mileage (KM)</label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($registrationTransaction->header, 'vehicle_mileage')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'repair_type'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($registrationTransaction->header, 'repair_type')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'employee_id_assign_mechanic'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($registrationTransaction->header, 'employeeIdAssignMechanic.username')); ?>
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
                                        <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'problem'); ?></label>
                                    </div>
                                    <div class="small-10 columns">
                                        <?php echo CHtml::encode(CHtml::value($registrationTransaction->header, 'problem')); ?>
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