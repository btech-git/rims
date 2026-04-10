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

            <?php echo $form->errorSummary($receiveParts->header); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

            <div class="row">
                <div class="medium-12 columns">
                    <h2>Penerimaan Parts Supply</h2>
                    <p class="note">Fields with <span class="required">*</span> are required.</p>

                    <hr />

                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo $form->labelEx($receiveParts->header,'transaction_date'); ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'model' => $receiveParts->header,
                                            'attribute' => "transaction_date",
                                            'options' => array(
                                                'minDate' => '-1W',
                                                'maxDate' => '+6M',
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth' => true,
                                                'changeYear' => true,
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
//                                                'value' => date('Y-m-d'),
                                            ),
                                        )); ?>
                                        <?php echo $form->error($receiveParts->header,'date_posting'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Supply Type'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeDropDownList($receiveParts->header, 'transaction_type', array(
                                            'Asuransi' => 'Asuransi',
                                            'Internal' => 'Internal',
                                        )); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'SJ Supplier #'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextField($receiveParts->header, 'supplier_delivery_number'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo $form->labelEx($receiveParts->header, 'insurance_company_id'); ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo $form->dropDownlist($receiveParts->header, 'insurance_company_id', CHtml::listData(InsuranceCompany::model()->findAllByAttributes(array('is_deleted' => 0), array('order' => 't.name ASC')), 'id', 'name'),array(
                                            'prompt'=>'-- Tanpa Asuransi --',
                                        )); ?>
                                        <?php echo $form->error($receiveParts->header, 'insurance_company_id'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo $form->labelEx($receiveParts->header, 'note'); ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo $form->textArea($receiveParts->header, 'note'); ?>
                                        <?php echo $form->error($receiveParts->header, 'note'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- END COLUMN 6-->
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo $form->labelEx($receiveParts->header,'branch_id'); ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo $form->hiddenField($receiveParts->header, 'branch_id'); ?>
                                        <?php echo CHtml::encode(CHtml::value($receiveParts->header, 'branch.name')); ?>
                                        <?php echo $form->error($receiveParts->header,'branch_id'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Registration Transaction #'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($receiveParts->header, 'registrationTransaction.transaction_number')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Customer'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($receiveParts->header, 'registrationTransaction.customer.name')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Plat #'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($receiveParts->header, 'registrationTransaction.vehicle.plate_number')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Kendaraan'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($receiveParts->header, 'registrationTransaction.vehicle.carMakeModelSubCombination')); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo $form->labelEx($receiveParts->header,'user_id_created'); ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo $form->hiddenField($receiveParts->header,'user_id_created'); ?>
                                        <?php echo CHtml::encode($receiveParts->header->userIdCreated->username); ?>
                                        <?php echo $form->error($receiveParts->header,'user_id_created'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    
                    <hr />
                    
                    <div class="row">
                        <div class="medium-12 columns">
                            <div id="detail_div">
                                <?php $this->renderPartial('_detail', array('receiveParts' => $receiveParts,)); ?>
                            </div>
                        </div>
                    </div>

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