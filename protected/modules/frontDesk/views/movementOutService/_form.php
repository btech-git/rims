<?php
/* @var $this RegistrationServiceController */
/* @var $model RegistrationService */
/* @var $form CActiveForm */
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'registration-transaction-form',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'enableAjaxValidation'=>false,
            )); ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($movementOut->header); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <?php /*$this->widget('zii.widgets.jui.CJuiTabs', array(
                            'tabs' => array(
                                'Customer Info' => array(
                                    'id' => 'info1',
                                    'content' => $this->renderPartial('_infoCustomer', array(
                                        'generalRepairRegistration' => $movementOut, 
                                        'customer' => $customer,
                                    ), true)
                                ),
                                'Vehicle Info' => array(
                                    'id' => 'info2',
                                    'content' => $this->renderPartial('_infoVehicle', array(
                                        'generalRepairRegistration' => $movementOut,
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
                        ));*/ ?>  
                    </div>
                    <!-- END ROW -->
                    <br />

                    <div class="row">
                        <div class="medium-12 columns">
                            <h2>Movement Out</h2>
                            
                            <hr />

                            <div class="row">
                                <div class="medium-6 columns">
<!--                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php //echo $form->labelEx($movementOut->header, 'movement_out_no'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php //echo CHtml::encode(CHtml::value($movementOut->header, 'movement_out_no')); ?>
                                                <?php //echo $form->textField($movementOut->header,'movement_out_no',array('size'=>30,'maxlength'=>30, 'readonly' => true)); ?>
                                                <?php //echo $form->error($movementOut->header,'movement_out_no'); ?>
                                            </div>
                                        </div>
                                    </div>-->

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($movementOut->header,'date_posting'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($movementOut->header,'date_posting',array('readonly'=>true)); ?>
                                                <?php echo $form->error($movementOut->header,'date_posting'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo 'Repair Type'; ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($movementOut->header, 'registrationService.repair_type')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo 'WO #'; ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($movementOut->header, 'registrationService.work_order_number')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo 'Tanggal Registration'; ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($movementOut->header, 'registrationService.transaction_date')); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                
                                <!-- END COLUMN 6-->
                                <div class="medium-6 columns">
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($movementOut->header,'branch_id'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->textField($movementOut->header,'branch_name',array('value'=>$movementOut->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->name : $movementOut->header->branch->name,'readonly'=>true)); ?>
                                                <?php echo $form->error($movementOut->header,'branch_id'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo 'Registration Transaction #'; ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($movementOut->header, 'registrationService.transaction_number')); ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo $form->labelEx($movementOut->header,'user_id'); ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo $form->hiddenField($movementOut->header,'user_id'); ?>
                                                <?php echo CHtml::encode($movementOut->header->user->username); ?>
                                                <?php echo $form->error($movementOut->header,'user_id'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="field">
                                        <div class="row collapse">
                                            <div class="small-4 columns">
                                                <label class="prefix"><?php echo 'Service Type'; ?></label>
                                            </div>
                                            <div class="small-8 columns">
                                                <?php echo CHtml::encode(CHtml::value($movementOut->header, 'registrationService.service_type')); ?>
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
                            <div id="detail_div">
                                <?php $this->renderPartial('_detail', array('movementOut' => $movementOut,)); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="medium-12 columns">
                            <div class="field buttons text-center">
                                <?php echo CHtml::hiddenField('_FormSubmit_', ''); ?>
                                <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                                <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'button cbutton', 'onclick' => '$("#_FormSubmit_").val($(this).attr("name")); this.disabled = true')); ?>
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