<?php
/* @var $this TransactionPurchaseOrderController */
/* @var $purchaseOrder  TransactionPurchaseOrder */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
    <div class="form">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'transaction-purchase-order-form',
            'enableAjaxValidation' => false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($purchaseOrder); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($purchaseOrder,
                                    'purchase_order_no'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($purchaseOrder, 'purchase_order_no',
                                array('size' => 30, 'maxlength' => 30, 'readonly' => true)); ?>
                            <?php echo $form->error($purchaseOrder, 'purchase_order_no'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix">
                                <?php echo $form->labelEx($purchaseOrder, 'purchase_order_date'); ?>
                            </label>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'model' => $purchaseOrder,
                                    'attribute' => "estimate_payment_date",
                                    // additional javascript options for the date picker plugin
                                    'options' => array(
                                        'dateFormat' => 'yy-mm-dd',
                                        'changeMonth' => true,
                                        'changeYear' => true,
                                        'yearRange' => '1900:2020'
                                    ),
                                    'htmlOptions' => array(
                                        'value' => $purchaseOrder->isNewRecord ? date('Y-m-d') : $purchaseOrder->estimate_payment_date,
                                    ),
                                )
                            ); ?>
                            <?php echo $form->error($purchaseOrder, 'estimate_payment_date'); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="clearfix"></div>

        </div>
    </div>

    <div class="field buttons text-center">
        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
        <?php echo CHtml::submitButton($purchaseOrder->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->