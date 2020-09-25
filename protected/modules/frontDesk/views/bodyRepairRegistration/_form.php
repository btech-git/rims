<?php
/* @var $this RegistrationTransactionController */
/* @var $bodyRepairRegistration->header RegistrationTransaction */
/* @var $form CActiveForm */
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/frontDesk/bodyRepairRegistration/admin';?>"><span class="fa fa-th-list"></span>Manage Body Repair Registration</a>
        <h1><?php if($bodyRepairRegistration->header->isNewRecord){ echo "New Body Repair Registration"; }else{ echo "Update Body Repair Registration";}?></h1>
        <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'registration-transaction-form',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'enableAjaxValidation'=>false,
            )); ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($bodyRepairRegistration->header); ?>
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
                                        'bodyRepairRegistration' => $bodyRepairRegistration, 
                                        'customer' => $customer,
                                    ), true)
                                ),
                                'Vehicle Info' => array(
                                    'id' => 'info2',
                                    'content' => $this->renderPartial('_infoVehicle', array(
                                        'bodyRepairRegistration' => $bodyRepairRegistration,
                                        'vehicle' => $vehicle,
                                    ), true)
                                ),
                                'Service Exception Rate' => array(
                                    'id' => 'info3',
                                    'content' => $this->renderPartial('_serviceException', array(
                                        'bodyRepairRegistration' => $bodyRepairRegistration,
                                        'customer' => $customer,
                                    ), true)
                                ),
                                'History' => array(
                                    'id' => 'info4',
                                    'content' => $this->renderPartial('_historyTransaction', array(
                                        'bodyRepairRegistration' => $bodyRepairRegistration,
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
                                                <label class="prefix"><?php echo $form->labelEx($bodyRepairRegistration->header,'transaction_number'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($bodyRepairRegistration->header,'transaction_number',array('size'=>30,'maxlength'=>30, 'readonly' => true)); ?>
                                                <?php echo $form->error($bodyRepairRegistration->header,'transaction_number'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if(!$bodyRepairRegistration->header->isNewRecord): ?>
                                        <?php if($bodyRepairRegistration->header->work_order_number != ""): ?>
                                            <div class="field">
                                                <div class="row collapse">
                                                    <div class="small-4 columns">
                                                        <label class="prefix"><?php echo $form->labelEx($bodyRepairRegistration->header,'work_order_number'); ?></label>
                                                    </div>
                                                    <div class="small-8 columns">
                                                        <?php echo $form->textField($bodyRepairRegistration->header,'work_order_number'); ?>
                                                        <?php echo $form->error($bodyRepairRegistration->header,'work_order_number'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($bodyRepairRegistration->header,'transaction_date'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($bodyRepairRegistration->header,'transaction_date',array('readonly'=>true)); ?>
                                                <?php echo $form->error($bodyRepairRegistration->header,'transaction_date'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($bodyRepairRegistration->header,'repair_type'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($bodyRepairRegistration->header, 'repair_type', array('value'=>'GR','readonly'=>true)); ?>
                                                <?php echo $form->error($bodyRepairRegistration->header,'repair_type'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix">Car Mileage (KM)</label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($bodyRepairRegistration->header, 'vehicle_mileage'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <!-- END COLUMN 6-->
                                <div class="medium-6 columns">
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($bodyRepairRegistration->header,'branch_id'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($bodyRepairRegistration->header,'branch_name',array('value'=>$bodyRepairRegistration->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->name : $bodyRepairRegistration->header->branch->name,'readonly'=>true)); ?>
                                                <?php echo $form->error($bodyRepairRegistration->header,'branch_id'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($bodyRepairRegistration->header,'user_id'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->hiddenField($bodyRepairRegistration->header,'user_id', array('value'=>Yii::app()->user->getId(),'readonly'=>true)); ?>
                                                <?php echo $form->labelEx($bodyRepairRegistration->header,'user_id', array('value'=>Yii::app()->user->getName())); ?>
                                                <?php echo $form->error($bodyRepairRegistration->header,'user_id'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix">Insurance Company</label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->dropDownlist($bodyRepairRegistration->header,'insurance_company_id',CHtml::listData(InsuranceCompany::model()->findAll(),'id','name'),array(
                                                    'prompt'=>'-- Tanpa Asuransi --',
                                                )); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($customer->customer_type === 'Company'): ?>
                                        <div class="field">
                                            <div class="row collapse">
                                                <div class="small-4 columns">
                                                    <label class="prefix"><?php echo $form->labelEx($bodyRepairRegistration->header, 'customer_work_order_number'); ?></label>
                                                </div>
                                                <div class="small-8 columns">
                                                    <?php echo $form->textField($bodyRepairRegistration->header, 'customer_work_order_number'); ?>
                                                    <?php echo $form->error($bodyRepairRegistration->header,'customer_work_order_number'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <div class="row">
                        <div class="medium-12 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-2 columns">
                                        <label class="prefix"><?php echo $form->labelEx($bodyRepairRegistration->header,'problem'); ?></label>
                                    </div>
                                    <div class="small-10 columns">
                                        <?php echo $form->textArea($bodyRepairRegistration->header,'problem',array('rows'=>5, 'cols'=>50)); ?>
                                        <?php echo $form->error($bodyRepairRegistration->header,'problem'); ?>
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