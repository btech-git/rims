<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Body Repair Registration'=>array('admin'),
	'Create',
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/frontDesk/bodyRepairRegistration/admin';?>"><span class="fa fa-th-list"></span>Manage</a>
        <h1><?php echo "Update KM Kendaraan"; ?></h1>
        <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'registration-transaction-form',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'enableAjaxValidation'=>false,
            )); ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($registrationTransaction); ?>

            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <table>
                            <thead>
                                <tr>
                                    <td>Plate #</td>
                                    <td>Machine #</td>
                                    <td>Car Make</td>
                                    <td>Model</td>
                                    <td>Sub Model</td>
                                    <td>Color</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'plate_number')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'machine_number')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'carMake.name')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'carModel.name')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'carSubModel.name')); ?></td>
                                    <td>
                                        <?php $color = Colors::model()->findByPk($vehicle->color_id); ?>
                                        <?php echo CHtml::encode(CHtml::value($color, 'name')); ?>
                                    </td>
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
                                    <td><?php echo CHtml::encode(CHtml::value($customer, 'name')); ?></td>
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
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction, 'RG #'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'transaction_number')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction, 'transaction_date'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'transaction_date')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction,'branch_id'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'branch.name')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction,'repair_type'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'repair_type')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction,'employee_id_assign_mechanic'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'employeeIdAssignMechanic.name')); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction,'employee_id_sales_person'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'employeeIdSalesPerson.name')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <!-- END COLUMN 6-->
                                <div class="medium-6 columns">
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix">KM Sebelum</label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($registrationTransaction, 'previous_mileage'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix">KM Sekarang</label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($registrationTransaction, 'vehicle_mileage'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix">KM Rekomendasi Service Selanjutnya</label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($registrationTransaction, 'next_mileage'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction, 'problem'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'problem')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    
                    <hr />
                            
                    <div class="row">
                        <div class="medium-12 columns">
                            <div class="field buttons text-center">
                                <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                                <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'button cbutton')); ?> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
</div>