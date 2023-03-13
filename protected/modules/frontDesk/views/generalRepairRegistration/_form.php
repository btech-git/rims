<?php
/* @var $this RegistrationTransactionController */
/* @var $generalRepairRegistration->header RegistrationTransaction */
/* @var $form CActiveForm */
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/frontDesk/generalRepairRegistration/admin';?>"><span class="fa fa-th-list"></span>Manage General Repair Registration</a>
        <h1><?php if($generalRepairRegistration->header->isNewRecord){ echo "New General Repair Registration"; }else{ echo "Update General Repair Registration";}?></h1>
        <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'registration-transaction-form',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'enableAjaxValidation'=>false,
            )); ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

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
                                                <label class="prefix"><?php echo $form->labelEx($generalRepairRegistration->header,'transaction_date'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($generalRepairRegistration->header,'transaction_date',array('readonly'=>true)); ?>
                                                <?php echo $form->error($generalRepairRegistration->header,'transaction_date'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($generalRepairRegistration->header,'repair_type'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($generalRepairRegistration->header, 'repair_type', array('value'=>'GR','readonly'=>true)); ?>
                                                <?php echo $form->error($generalRepairRegistration->header,'repair_type'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($generalRepairRegistration->header,'employee_id_assign_mechanic'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::activeDropDownlist($generalRepairRegistration->header, 'employee_id_assign_mechanic', CHtml::listData(EmployeeBranchDivisionPositionLevel::model()->findAllByAttributes(array(
                                                    "branch_id" => $generalRepairRegistration->header->branch_id,
                                                    "division_id" => array(1, 3, 5),
                                                    "position_id" => 1,
                                                    "level_id" => array(1, 2, 3, 4),
                                                )), "employee_id", "employee.name"), array("empty" => "--Assign Mechanic--")); ?>
                                                <?php echo $form->error($generalRepairRegistration->header,'employee_id_assign_mechanic'); ?>
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
                                                    <?php echo $form->textField($generalRepairRegistration->header, 'customer_work_order_number'); ?>
                                                    <?php echo $form->error($generalRepairRegistration->header,'customer_work_order_number'); ?>
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
                                                <?php echo $form->textField($generalRepairRegistration->header,'branch_name',array('value'=>$generalRepairRegistration->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->name : $generalRepairRegistration->header->branch->name,'readonly'=>true)); ?>
                                                <?php echo $form->error($generalRepairRegistration->header,'branch_id'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($generalRepairRegistration->header,'user_id'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->hiddenField($generalRepairRegistration->header,'user_id'); ?>
                                                <?php echo CHtml::encode($generalRepairRegistration->header->user->username); ?>
                                                <?php echo $form->error($generalRepairRegistration->header,'user_id'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix">Car Mileage (KM)</label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($generalRepairRegistration->header, 'vehicle_mileage'); ?>
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
                                        <?php echo $form->textArea($generalRepairRegistration->header,'problem',array('rows'=>5, 'cols'=>50)); ?>
                                        <?php echo $form->error($generalRepairRegistration->header,'problem'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <hr />
                            
                            <div class="field buttons text-center">
                                <?php //echo CHtml::hiddenField('_FormSubmit_', ''); ?>
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

<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScript('myjavascript', '
		$(".numbers").number( true,2, ".", ",");
    ', CClientScript::POS_END);
?>