<div class="clearfix page-action">
    <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'sale-invoice-own-risk-form',
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
            'enableAjaxValidation'=>false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($saleInvoice); ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($saleInvoice, 'transaction_date', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $saleInvoice,
                                'attribute' => "transaction_date",
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
                            <?php echo $form->error($saleInvoice, 'transaction_date'); ?>
                        </div>
                    </div>
                </div>		

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($saleInvoice, 'branch_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($saleInvoice, 'branch.name')); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($saleInvoice, 'customer_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($saleInvoice, 'customer.name')); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($saleInvoice, 'Plat #', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($saleInvoice, 'vehicle.plate_number')); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($saleInvoice, 'Kendaraan', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($saleInvoice, 'vehicle.carMakeModelSubCombination')); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($saleInvoice, 'Jatuh Tempo (hari)', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($saleInvoice, 'customer.tenor')); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($saleInvoice, 'registration_transaction_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($saleInvoice, 'registrationTransaction.transaction_number')); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($saleInvoice, 'insurance_company_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($saleInvoice, 'insuranceCompany.name')); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($saleInvoice, 'Jumlah', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeTextField($saleInvoice, 'amount_invoice'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="medium-4 columns">
                            <?php echo $form->labelEx($saleInvoice, 'note', array('class' => 'prefix')); ?>
                        </div>
                        <div class="medium-8 columns">
                            <?php echo $form->textArea($saleInvoice, 'note', array('rows' => 5, 'cols' => 50)); ?>
                            <?php echo $form->error($saleInvoice, 'note'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="large-12 columns">
                <div class="row">
                    <div class="large-12 columns">
                        <div class="detail" id="detail">
                            <?php $this->renderPartial('_detail', array(
                                'saleInvoice' => $saleInvoice, 
                                'registrationTransaction' => $registrationTransaction,
                            )); ?>
                        </div>
                    </div>	
                </div>
            </div>
        </div>

        <div class="field buttons text-center">
            <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
            <?php echo CHtml::submitButton($saleInvoice->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
        </div>
        <?php echo IdempotentManager::generate(); ?>
        
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div><!-- form -->

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('myjavascript', '
		$(".numbers").number( true,2, ".", ",");
    ', CClientScript::POS_END);
?>