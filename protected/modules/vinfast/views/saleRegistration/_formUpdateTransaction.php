<div id="maincontent">
    <div class="clearfix page-action">
        <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'registration-transaction-form',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'enableAjaxValidation'=>false,
            )); ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($registrationTransaction->header); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                            'tabs' => array(
                                'Vehicle Info' => array(
                                    'id' => 'info2',
                                    'content' => $this->renderPartial('_infoVehicle', array(
                                        'registrationTransaction' => $registrationTransaction,
                                        'vehicle' => $vehicle,
                                        'customer' => $customer,
                                    ), true)
                                ),
                                'History' => array(
                                    'id' => 'info4',
                                    'content' => $this->renderPartial('_historyTransaction', array(
                                        'registrationTransaction' => $registrationTransaction,
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
                                    <?php if(!$registrationTransaction->header->isNewRecord): ?>
                                        <?php if($registrationTransaction->header->work_order_number != ""): ?>
                                            <div class="field">
                                                <div class="row collapse">
                                                    <div class="small-4 columns">
                                                        <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'work_order_number'); ?></label>
                                                    </div>
                                                    <div class="small-8 columns">
                                                        <?php echo $form->textField($registrationTransaction->header,'work_order_number', array('readOnly' => true)); ?>
                                                        <?php echo $form->error($registrationTransaction->header,'work_order_number'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header, 'transaction_date'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                    'model' => $registrationTransaction->header,
                                                    'attribute' => 'transaction_date',
                                                    // additional javascript options for the date picker plugin
                                                    'options' => array(
                                                        'minDate' => '-7W',
                                                        'maxDate' => '+6M',
                                                        'dateFormat' => 'yy-mm-dd',
                                                        'changeMonth' => true,
                                                        'changeYear' => true,
                                                    ),
                                                    'htmlOptions' => array(
                                                        'readonly' => true,
                                                    ),
                                                )); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'repair_type'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($registrationTransaction->header, 'repair_type', array('value'=>'BR','readonly'=>true)); ?>
                                                <?php echo $form->error($registrationTransaction->header,'repair_type'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'employee_id_sales_person'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::activeDropDownlist($registrationTransaction->header, 'employee_id_sales_person', CHtml::listData(Employee::model()->findAllByAttributes(array(
//                                                    "branch_id" => User::model()->findByPk(Yii::app()->user->getId())->branch_id,
//                                                    "division_id" => array(2),
                                                    "position_id" => 2,
                                                    'status' => 'Active',
//                                                    "level_id" => array(1, 2, 3, 4),
                                                )), "id", "name"), array("empty" => "--Assign Sales--")); ?>
                                                <?php echo $form->error($registrationTransaction->header,'employee_id_sales_person'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix">Insurance Company</label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->dropDownlist($registrationTransaction->header,'insurance_company_id',CHtml::listData(InsuranceCompany::model()->findAllByAttributes(array('is_deleted' => 0)),'id','name'),array(
                                                    'prompt'=>'-- Tanpa Asuransi --',
                                                )); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <!-- END COLUMN 6-->
                                <div class="medium-6 columns">
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header, 'Estimasi Lama Pengerjaan (jam)'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($registrationTransaction->header, 'estimate_service_time'); ?>
                                                <?php echo $form->error($registrationTransaction->header,'estimate_service_time'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'employee_id_assign_mechanic'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::activeDropDownlist($registrationTransaction->header, 'employee_id_assign_mechanic', CHtml::listData(Employee::model()->findAllByAttributes(array(
//                                                    "branch_id" => User::model()->findByPk(Yii::app()->user->getId())->branch_id,
//                                                    "division_id" => array(2),
                                                    "position_id" => 1,
                                                    'status' => 'Active',
//                                                    "level_id" => array(1, 2, 3, 4),
                                                )), "id", "name"), array("empty" => "--Assign Mechanic--")); ?>
                                                <?php echo $form->error($registrationTransaction->header,'employee_id_assign_mechanic'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'employee_id_mechanic_helper_1'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::activeDropDownlist($registrationTransaction->header, 'employee_id_mechanic_helper_1', CHtml::listData(Employee::model()->findAllByAttributes(array(
//                                                    "branch_id" => User::model()->findByPk(Yii::app()->user->getId())->branch_id,
//                                                    "division_id" => array(1, 3, 5),
                                                    "position_id" => 1,
                                                    'status' => 'Active',
//                                                    "level_id" => array(1, 2, 3, 4),
                                                )), "id", "name"), array("empty" => "--Assign Helper 1--")); ?>
                                                <?php echo $form->error($registrationTransaction->header,'employee_id_mechanic_helper_1'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'employee_id_mechanic_helper_2'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::activeDropDownlist($registrationTransaction->header, 'employee_id_mechanic_helper_2', CHtml::listData(Employee::model()->findAllByAttributes(array(
//                                                    "branch_id" => User::model()->findByPk(Yii::app()->user->getId())->branch_id,
//                                                    "division_id" => array(1, 3, 5),
                                                    "position_id" => 1,
                                                    'status' => 'Active',
//                                                    "level_id" => array(1, 2, 3, 4),
                                                )), "id", "name"), array("empty" => "--Assign Helper 2--")); ?>
                                                <?php echo $form->error($registrationTransaction->header,'employee_id_mechanic_helper_2'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($registrationTransaction->header,'employee_id_mechanic_helper_3'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::activeDropDownlist($registrationTransaction->header, 'employee_id_mechanic_helper_3', CHtml::listData(Employee::model()->findAllByAttributes(array(
//                                                    "branch_id" => User::model()->findByPk(Yii::app()->user->getId())->branch_id,
//                                                    "division_id" => array(1, 3, 5),
                                                    "position_id" => 1,
                                                    'status' => 'Active',
//                                                    "level_id" => array(1, 2, 3, 4),
                                                )), "id", "name"), array("empty" => "--Assign Helper 3--")); ?>
                                                <?php echo $form->error($registrationTransaction->header,'employee_id_mechanic_helper_3'); ?>
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
                                <?php //echo CHtml::hiddenField('_FormSubmit_', ''); ?>
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

<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScript('myjavascript', '
            $(".numbers").number( true,2, ".", ",");
    ', CClientScript::POS_END);
?>