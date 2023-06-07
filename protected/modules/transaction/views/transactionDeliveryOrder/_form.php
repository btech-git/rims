<?php
/* @var $this TransactionReceiveItemController */
/* @var $model TransactionReceiveItem */
/* @var $form CActiveForm */
?>

<style>
    .hidden {
        display:none;
    }
</style>

<div class="clearfix page-action">
    <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Delivery Order', Yii::app()->baseUrl . '/transaction/transactionDeliveryOrder/admin', array('class' => 'button cbutton right', 'visible' => Yii::app()->user->checkAccess("transaction.transactionDeliveryOrder.admin"))) ?>
    <h1>
        <?php if ($deliveryOrder->header->id == "") {
            echo "New Transaction Delivery Order";
        } else {
            echo "Update Transaction Delivery Order";
        } ?>
    </h1>
    <!-- begin FORM -->
    <div class="form">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'transaction-receive-item-form',
            'enableAjaxValidation' => false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php echo $form->errorSummary($deliveryOrder->header); ?>
        <?php echo $form->errorSummary($deliveryOrder->details); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($deliveryOrder->header, 'posting_date', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $deliveryOrder->header,
                                'attribute' => "posting_date",
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'value' => $deliveryOrder->header->isNewRecord ? date('Y-m-d') : $deliveryOrder->header->posting_date,
                                ),
                            )); ?>
                            <?php //echo $form->textField($deliveryOrder->header, 'posting_date', array('readonly' => true,)); ?>
                            <?php echo $form->error($deliveryOrder->header, 'posting_date'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($deliveryOrder->header, 'delivery_date', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $deliveryOrder->header,
                                'attribute' => "delivery_date",
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                ),
                            )); ?>
                            <?php echo $form->error($deliveryOrder->header, 'delivery_date'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($deliveryOrder->header, 'sender_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($deliveryOrder->header, 'sender_id', array('value' => $deliveryOrder->header->isNewRecord ? Yii::app()->user->getId() : $deliveryOrder->header->sender_id, 'readonly' => true)); ?>
                            <?php echo $form->textField($deliveryOrder->header, 'user_name', array('size' => 30, 'maxlength' => 30, 'value' => $deliveryOrder->header->isNewRecord ? Yii::app()->user->getName() : $deliveryOrder->header->user->username, 'readonly' => true)); ?>
                            <?php echo $form->error($deliveryOrder->header, 'sender_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($deliveryOrder->header, 'sender_branch_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($deliveryOrder->header, 'sender_branch_id', array('value' => $deliveryOrder->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $deliveryOrder->header->sender_branch_id)); ?>
                            <?php echo $form->textField($deliveryOrder->header, 'branch_name', array('size' => 30, 'maxlength' => 30, 'value' => $deliveryOrder->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->name : $deliveryOrder->header->senderBranch->name, 'readonly' => true)); ?>
                            <?php echo $form->error($deliveryOrder->header, 'sender_branch_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($deliveryOrder->header, 'request_type', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($deliveryOrder->header, 'request_type', array(
                                'value' => $deliveryOrder->header->request_type,
                                'readOnly' => true,
                            )); ?>
                            <?php echo $form->error($deliveryOrder->header, 'request_type'); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="small-12 medium-6 columns">	
                <div id="purchase">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($deliveryOrder->header, 'sales_order_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($deliveryOrder->header, 'sales_order_id'); ?>
                                <?php echo $form->textField($deliveryOrder->header, 'sales_order_no', array(
                                    'value' => $deliveryOrder->header->sales_order_id != Null ? $deliveryOrder->header->salesOrder->sale_order_no : '',
                                    'readOnly' => true,
                                )); ?>
                                <?php echo $form->error($deliveryOrder->header, 'sales_order_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="consignment">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($deliveryOrder->header, 'consignment_out_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($deliveryOrder->header, 'consignment_out_id'); ?>
                                <?php echo $form->textField($deliveryOrder->header, 'consignment_out_no', array(
                                    'value' => $deliveryOrder->header->consignment_out_id != Null ? $deliveryOrder->header->consignmentOut->consignment_out_no : '',
                                    'readOnly' => true,
                                )); ?>
                                <?php echo $form->error($deliveryOrder->header, 'consignment_out_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="customer">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($deliveryOrder->header, 'customer_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->HiddenField($deliveryOrder->header, 'customer_id', array('readonly' => 'true')); ?>
                                <?php echo $form->TextField($deliveryOrder->header, 'customer_name', array('readonly' => 'true', 'value' => $deliveryOrder->header->customer_id != "" ? $deliveryOrder->header->customer->name : '')); ?>
                                <?php echo $form->error($deliveryOrder->header, 'customer_id'); ?>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="transfer">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($deliveryOrder->header, 'transfer_request_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($deliveryOrder->header, 'transfer_request_id'); ?>
                                <?php echo $form->textField($deliveryOrder->header, 'transfer_request_no', array(
                                    'value' => $deliveryOrder->header->transfer_request_id != Null ? $deliveryOrder->header->transferRequest->transfer_request_no : '',
                                    'readOnly' => true,
                                )); ?>
                                <?php echo $form->error($deliveryOrder->header, 'transfer_request_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="sent">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($deliveryOrder->header, 'sent_request_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($deliveryOrder->header, 'sent_request_id'); ?>
                                <?php echo $form->textField($deliveryOrder->header, 'sent_request_no', array(
                                    'value' => $deliveryOrder->header->sent_request_id != Null ? $deliveryOrder->header->sentRequest->sent_request_no : '',
                                    'readOnly' => true,
                                )); ?>
                                <?php echo $form->error($deliveryOrder->header, 'sent_request_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>	

                <div id="destination">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($deliveryOrder->header, 'destination_branch', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($deliveryOrder->header, 'destination_branch'); ?>
                                <?php $branch = Branch::model()->findByPk($deliveryOrder->header->destination_branch); ?>
                                <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
                                <?php echo $form->error($deliveryOrder->header, 'destination_branch'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="requestDetail">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($deliveryOrder->header, 'request_date', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($deliveryOrder->header, 'request_date', array('readonly' => 'true')); ?>
                                <?php echo $form->error($deliveryOrder->header, 'request_date'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($deliveryOrder->header, 'estimate_arrival_date', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php //echo $form->textField($deliveryOrder->header, 'estimate_arrival_date', array('readonly' => 'true')); ?>
                                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'model' => $deliveryOrder->header,
                                    'attribute' => "estimate_arrival_date",
                                    // additional javascript options for the date picker plugin
                                    'options' => array(
                                        'dateFormat' => 'yy-mm-dd',
                                        'changeMonth' => true,
                                        'changeYear' => true,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                    ),
                                )); ?>
                                <?php echo $form->error($deliveryOrder->header, 'estimate_arrival_date'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr />
        
        <div class="detail">
            <?php $this->renderPartial('_detail', array('deliveryOrder' => $deliveryOrder)); ?>
        </div>

        <div class="row">
            <div class="small-12 medium-6 columns">			 
                <div class="field buttons text-center">
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                    <?php echo CHtml::submitButton($deliveryOrder->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'id' => 'save', 'confirm' => 'Are you sure you want to save?')); ?>
                </div>
            </div>
        </div>
    <?php echo IdempotentManager::generate(); ?>
    <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->

<script>
    function ClearFields() {

        $('#purchase').find('input:text').val('');
        $('#sent').find('input:text').val('');
        $('#customer').find('input:text').val('');
        $('#destination').find('input:text').val('');
        $('#consignment').find('input:text').val('');
        $('#requestDetail').find('input:text').val('');

    }
</script>

<?php Yii::app()->clientScript->registerScript('myjquery', '
    // Yii::app()->controller->action->id
    if ($("#TransactionDeliveryOrder_request_type").val() == "Sales Order") {
        $("#purchase").show();
        $("#customer").show();
        $("#consignment").hide();
        $("#sent").hide();
        $("#destination").hide();
        $("#transfer").hide();
    } else if ($("#TransactionDeliveryOrder_request_type").val() == "Sent Request") {
        $("#sent").show();
        $("#destination").show();
        $("#purchase").hide();
        $("#customer").hide();
        $("#consignment").hide();
        $("#transfer").hide();
    } else if ($("#TransactionDeliveryOrder_request_type").val() == "Consignment Out") {
        $("#sent").hide();
        $("#purchase").hide();
        $("#customer").show();
        $("#consignment").show();
        $("#destination").hide();
        $("#transfer").hide();
    } else if ($("#TransactionDeliveryOrder_request_type").val() == "Transfer Request") {
        $("#sent").hide();
        $("#purchase").hide();
        $("#customer").hide();
        $("#consignment").hide();
        $("#transfer").show();
        $("#destination").show();
    } else {
        $("#sent").hide();
        $("#purchase").hide();
        $("#customer").hide();
        $("#consignment").hide();
        $("#destination").hide();
        $("#transfer").hide();
    }
    
    $("#TransactionDeliveryOrder_request_type").change(function() {
        ClearFields();
        $.ajax({
            type: "POST",
            //dataType: "JSON",
            url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id' => $deliveryOrder->header->id)) . '",
            data: $("form").serialize(),
            success: function(html) {
                $(".detail").html(html);
            },
        });
        
        if ($("#TransactionDeliveryOrder_request_type").val() == "Sales Order") {
            $("#purchase").show();
            $("#customer").show();
            $("#consignment").hide();
            $("#sent").hide();
            $("#destination").hide();
            $("#transfer").hide();
        } else if ($("#TransactionDeliveryOrder_request_type").val() == "Sent Request") {
            $("#sent").show();
            $("#destination").show();
            $("#purchase").hide();
            $("#customer").hide();
            $("#consignment").hide();
            $("#transfer").hide();
        } else if($("#TransactionDeliveryOrder_request_type").val() == "Consignment Out") {
            $("#sent").hide();
            $("#purchase").hide();
            $("#customer").show();
            $("#consignment").show();
            $("#destination").hide();
            $("#transfer").hide();
        } else if($("#TransactionDeliveryOrder_request_type").val() == "Transfer Request") {
            $("#sent").hide();
            $("#purchase").hide();
            $("#customer").hide();
            $("#consignment").hide();
            $("#transfer").show();
            $("#destination").show();
        } else {
            $("#sent").hide();
            $("#purchase").hide();
            $("#customer").hide();
            $("#consignment").hide();
            $("#destination").hide();
            $("#transfer").hide();
        }
    });
'); ?>