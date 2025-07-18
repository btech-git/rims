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
    <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Return Item', Yii::app()->baseUrl . '/transaction/transactionReturnItem/admin', array('class' => 'button cbutton right', 'visible' => Yii::app()->user->checkAccess("transaction.transactionReturnItem.admin"))) ?>
    <h1>
        <?php if ($returnItem->header->id == "") {
            echo "New Transaction Return Jual";
        } else {
            echo "Update Transaction Return Jual";
        } ?>
    </h1>
    <!-- begin FORM -->
    <div class="form">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'transaction-receive-item-form',
            'enableAjaxValidation' => false,
        )); ?>
        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php echo $form->errorSummary($returnItem->header); ?>

        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($returnItem->header, 'return_item_date', array('class' => 'prefix')); ?>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $returnItem->header,
                            'attribute' => "return_item_date",
                            // additional javascript options for the date picker plugin
                            'options' => array(
                                'minDate' => '-1M',
                                'maxDate' => '+6M',
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                                'changeYear' => true,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
//                                'value' => date('Y-m-d'),
                            ),
                        )); ?>
                        <?php echo $form->error($returnItem->header, 'return_item_date'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($returnItem->header, 'request_type', array('class' => 'prefix')); ?>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textField($returnItem->header, 'request_type', array('readonly' => 'true')); ?>
                        <?php echo $form->error($returnItem->header, 'request_type'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($returnItem->header, 'recipient_id', array('class' => 'prefix')); ?>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->hiddenField($returnItem->header, 'recipient_id', array('value' => $returnItem->header->isNewRecord ? Yii::app()->user->getId() : $returnItem->header->recipient_id, 'readonly' => true)); ?>
                        <?php echo $returnItem->header->isNewRecord ? CHtml::encode(Yii::app()->user->getName()) : $returnItem->header->user->username; ?>
                        <?php echo $form->error($returnItem->header, 'recipient_id'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($returnItem->header, 'recipient_branch_id', array('class' => 'prefix')); ?>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($returnItem->header, 'recipientBranch.name')); ?>
                        <?php echo $form->error($returnItem->header, 'recipient_branch_id'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="small-12 medium-6 columns">
            <div id="customer">	
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($returnItem->header, 'customer_id', array('class' => 'prefix')); ?>
                        </div>
                        
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($returnItem->header, 'customer_id', array('readonly' => 'true')); ?>
                            <?php echo CHtml::encode(CHtml::value($returnItem->header, 'customer.name')); ?>
                            <?php echo $form->error($returnItem->header, 'customer_id'); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if ($returnItem->header->request_type == 'Retail Sales'): ?>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($returnItem->header, 'Retail Sales #', array('class' => 'prefix')); ?>
                        </div>

                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($returnItem->header, 'registration_transaction_id'); ?>
                            <?php echo CHtml::encode(CHtml::value($returnItem->header, 'registrationTransaction.transaction_number')); ?>
                            <?php echo $form->error($returnItem->header, 'registration_transaction_id'); ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($returnItem->header, 'delivery_order_id', array('class' => 'prefix')); ?>
                        </div>

                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($returnItem->header, 'delivery_order_id'); ?>
                            <?php echo CHtml::encode(CHtml::value($returnItem->header, 'deliveryOrder.delivery_order_no')); ?>
                            <?php /*echo $form->textField($returnItem->header, 'delivery_order_no', array(
                                'onclick' => 'jQuery("#delivery-dialog").dialog("open"); return false;',
                                'value' => $returnItem->header->delivery_order_id != Null ? $returnItem->header->deliveryOrder->delivery_order_no : '',
                                'readOnly' => true,
                            )); ?>
                            <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                'id' => 'delivery-dialog',
                                // additional javascript options for the dialog plugin
                                'options' => array(
                                    'title' => 'Delivery Order',
                                    'autoOpen' => false,
                                    'width' => 'auto',
                                    'modal' => true,
                                ),
                            )); ?>

                            <?php $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'delivery-grid',
                                'dataProvider' => $deliveryDataProvider,
                                'filter' => $delivery,
                                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                'pager' => array(
                                    'cssFile' => false,
                                    'header' => '',
                                ),
                                'selectionChanged' => 'js:function(id){
                                    ClearFields();
                                    $.ajax({
                                        type: "POST",
                                        //dataType: "JSON",
                                        url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id' => $returnItem->header->id)) . '",
                                        data: $("form").serialize(),
                                        success: function(html) {
                                            $(".detail").html(html);	

                                        },
                                    });
                                    $("#TransactionReturnItem_delivery_order_id").val($.fn.yiiGridView.getSelection(id));

                                    $("#delivery-dialog").dialog("close");
                                    $.ajax({
                                        type: "POST",
                                        dataType: "JSON",
                                        url: "' . CController::createUrl('ajaxDelivery', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                                        data: $("form").serialize(),	
                                        success: function(data) {
                                            var request = "";
                                            if (data.type == "Sales Order") {
                                                request = 1;
                                                $("#purchase").show();
                                                $("#customer").show();	
                                                $("#branch").hide();	
                                                $("#consignment").hide();	
                                                $("#sent").hide();	
                                                $("#transfer").hide();	
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxSales', array('id' => '')) . '" + data.sales,
                                                    data: $("form").serialize(),	
                                                    success: function(data) {
                                                        console.log(data.no);
                                                        $("#TransactionReturnItem_sales_order_id").val(data.id);
                                                        $("#TransactionReturnItem_sales_order_no").val(data.no);
                                                        $("#TransactionReturnItem_request_date").val(data.date);
                                                        $("#TransactionReturnItem_estimate_arrival_date").val(data.eta);
                                                        $("#TransactionReturnItem_customer_id").val(data.customer);
                                                        $("#TransactionReturnItem_customer_name").val(data.customer_name);
                                                    } 
                                                });

                                                $.ajax({
                                                    type: "POST",
                                                    //dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $returnItem->header->id)) . '&requestType="+request+"&requestId="+ data.sales,
                                                    data: $("form").serialize(),
                                                    success: function(html) {
                                                        $(".detail").html(html);	
                                                    },
                                                });
                                            } else if(data.type == "Sent Request"){
                                                request = 2;
                                                $("#sent").show();
                                                $("#branch").show();	
                                                $("#customer").hide();	
                                                $("#consignment").hide();	
                                                $("#transfer").hide();	
                                                $("#purchase").hide();	

                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxSent', array('id' => '')) . '" + data.sent,
                                                    data: $("form").serialize(),
                                                    success: function(data) {
                                                        $("#TransactionReturnItem_sent_request_id").val(data.id);
                                                        $("#TransactionReturnItem_sent_request_no").val(data.no);
                                                        $("#TransactionReturnItem_request_date").val(data.date);
                                                        $("#TransactionReturnItem_estimate_arrival_date").val(data.eta);
                                                        $("#TransactionReturnItem_destination_branch").val(data.branch);
                                                    } 
                                                });

                                                $.ajax({
                                                    type: "POST",
                                                    //dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $returnItem->header->id)) . '&requestType="+request+"&requestId="+ data.sent,
                                                    data: $("form").serialize(),
                                                    success: function(html) {
                                                        $(".detail").html(html);	
                                                    },
                                                });
                                            } else if (data.type == "Transfer Request") {

                                                request = 3;
                                                $("#transfer").show();
                                                $("#branch").show();	
                                                $("#customer").hide();	
                                                $("#consignment").hide();	
                                                $("#sent").hide();	
                                                $("#purchase").hide();	

                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxTransfer', array('id' => '')) . '" + data.transfer,
                                                    data: $("form").serialize(),
                                                    success: function(data) {
                                                        $("#TransactionReturnItem_transfer_request_id").val(data.id);
                                                        $("#TransactionReturnItem_transfer_request_no").val(data.no);
                                                        $("#TransactionReturnItem_request_date").val(data.date);
                                                        $("#TransactionReturnItem_estimate_arrival_date").val(data.eta);
                                                        $("#TransactionReturnItem_destination_branch").val(data.branch);
                                                        $("#TransactionReturnItem_destination_branch_name").val(data.branch_name);
                                                    } 
                                                });

                                                $.ajax({
                                                    type: "POST",
                                                    //dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $returnItem->header->id)) . '&requestType="+request+"&requestId="+ data.transfer,
                                                    data: $("form").serialize(),
                                                    success: function(html) {
                                                        $(".detail").html(html);	
                                                    },
                                                });
                                            } else if (data.type == "Consignment Out") {
                                                request = 4;
                                                $("#consignment").show();
                                                $("#customer").show();	
                                                $("#branch").hide();	
                                                $("#purchase").hide();	
                                                $("#sent").hide();	
                                                $("#transfer").hide();	

                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxConsignment', array('id' => '')) . '" + data.consignment,
                                                    data: $("form").serialize(),
                                                    success: function(data) {
                                                        $("#TransactionReturnItem_consignment_out_id").val(data.id);
                                                        $("#TransactionReturnItem_consignment_out_no").val(data.no);
                                                        $("#TransactionReturnItem_request_date").val(data.date);
                                                        $("#TransactionReturnItem_estimate_arrival_date").val(data.eta);
                                                        $("#TransactionReturnItem_customer_id").val(data.customer);
                                                        $("#TransactionReturnItem_customer_name").val(data.customer_name);
                                                    } 
                                                });

                                                $.ajax({
                                                    type: "POST",
                                                    //dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $returnItem->header->id)) . '&requestType="+request+"&requestId="+ data.consignment,
                                                    data: $("form").serialize(),
                                                    success: function(html) {
                                                        $(".detail").html(html);
                                                    },
                                                });
                                            } else {
                                                $("#purchase").hide();
                                                $("#customer").hide();	
                                                $("#branch").hide();	
                                                $("#consignment").hide();	
                                                $("#sent").hide();	
                                                $("#transfer").hide();	
                                            }
                                            $("#TransactionReturnItem_delivery_order_no").val(data.no);
                                            $("#TransactionReturnItem_request_type").val(data.type);
                                        } 
                                    });
                                    $("#delivery-grid").find("tr.selected").each(function(){
                                        $(this).removeClass( "selected" );
                                    });
                                }',
                                'columns' => array(
                                    'delivery_order_no',
                                    'delivery_date',
                                    'customer.name: Customer',
                                    'request_type',
                                ),
                            )); ?>
                            <?php $this->endWidget();*/ ?>
                            <?php echo $form->error($returnItem->header, 'delivery_order_id'); ?>
                        </div>
                    </div>
                </div>

            <?php if (!empty($returnItem->header->sales_order_id)): ?>
                <div id="purchase" >
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($returnItem->header, 'sales_order_id', array('class' => 'prefix')); ?>
                            </div>

                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($returnItem->header, 'sales_order_id'); ?>
                                <?php echo $form->textField($returnItem->header, 'sales_order_no', array(
                                    'readonly' => true,
                                    'value' => $returnItem->header->sales_order_id != Null ? $returnItem->header->salesOrder->sale_order_no : '',
                                )); ?>
                                <?php echo $form->error($returnItem->header, 'sales_order_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($returnItem->header->consignment_out_id)): ?>
                <div id="consignment">	
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($returnItem->header, 'consignment_out_id', array('class' => 'prefix')); ?>
                            </div>

                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($returnItem->header, 'consignment_out_id'); ?>
                                <?php echo $form->textField($returnItem->header, 'consignment_out_no', array(
                                    'readonly' => true,
                                    'value' => $returnItem->header->consignment_out_id != Null ? $returnItem->header->consignmentOut->consignment_out_no : '',
                                )); ?>
                                <?php echo $form->error($returnItem->header, 'consignment_out_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($returnItem->header->transfer_request_id)): ?>
                <div id="transfer">	
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($returnItem->header, 'transfer_request_id', array('class' => 'prefix')); ?>
                            </div>

                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($returnItem->header, 'transfer_request_id'); ?>
                                <?php echo $form->textField($returnItem->header, 'transfer_request_no', array(
                                    'readonly' => true,
                                    'value' => $returnItem->header->transfer_request_id != Null ? $returnItem->header->transferRequest->transfer_request_no : '',
                                )); ?>
                                <?php echo $form->error($returnItem->header, 'transfer_request_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($returnItem->header->sent_request_id)): ?>
                <div id="sent">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($returnItem->header, 'sent_request_id', array('class' => 'prefix')); ?>
                            </div>

                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($returnItem->header, 'sent_request_id'); ?>
                                <?php echo $form->textField($returnItem->header, 'sent_request_no', array(
                                    'readonly' => true,
                                    'value' => $returnItem->header->sent_request_id != Null ? $returnItem->header->sentRequest->sent_request_no : '',
                                )); ?>
                                <?php echo $form->error($returnItem->header, 'sent_request_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

                <div id="branch">	
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($returnItem->header, 'destination_branch', array('class' => 'prefix')); ?>
                            </div>

                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($returnItem->header, 'destination_branch', array('readonly' => 'true')); ?>
                                <?php echo CHtml::encode(CHtml::value($returnItem->header, 'destinationBranch.name')); ?>
                                <?php echo $form->error($returnItem->header, 'destination_branch'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="requestDetail">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($returnItem->header, 'request_date', array('class' => 'prefix')); ?>
                            </div>

                            <div class="small-8 columns">
                                <?php echo $form->textField($returnItem->header, 'request_date', array('readonly' => 'true')); ?>
                                <?php echo $form->error($returnItem->header, 'request_date'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($returnItem->header, 'estimate_arrival_date', array('class' => 'prefix')); ?>
                            </div>

                            <div class="small-8 columns">
                                <?php echo $form->textField($returnItem->header, 'estimate_arrival_date', array('readonly' => 'true')); ?>
                                <?php echo $form->error($returnItem->header, 'estimate_arrival_date'); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="detail">
            <?php $this->renderPartial('_detail', array('returnItem' => $returnItem)); ?>
        </div>

        <div class="row">
            <div class="small-12 medium-6 columns">			 
                <div class="field buttons text-center">
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                    <?php echo CHtml::submitButton($returnItem->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo IdempotentManager::generate(); ?>
    <?php $this->endWidget(); ?>

</div><!-- form -->

<!--<script>
    function ClearFields() {

        $('#purchase').find('input:text').val('');
        $('#customer').find('input:text').val('');
        $('#branch').find('input:text').val('');
        $('#consignment').find('input:text').val('');
        $('#sent').find('input:text').val('');
        $('#transfer').find('input:text').val('');
        $('#requestDetail').find('input:text').val('');

    }
    if ($("#TransactionReturnItem_request_type") == "Purchase Order") {
        $("#purchase").show();
        $("#customer").show();
        $("#branch").hide();
        $("#consignment").hide();
        $("#sent").hide();
        $("#transfer").hide();

    } else if ($("#TransactionReturnItem_request_type") == "Sent Request") {
        $("#sent").show();
        $("#branch").show();
        $("#purchase").hide();
        $("#consignment").hide();
        $("#customer").hide();
        $("#transfer").hide();
    } else if ($("#TransactionReturnItem_request_type") == "Transfer Request") {
        $("#transfer").show();
        $("#branch").show();
        $("#purchase").hide();
        $("#consignment").hide();
        $("#sent").hide();
        $("#customer").hide();
    } else if ($("#TransactionReturnItem_request_type") == "Consignment Out") {
        $("#consignment").show();
        $("#customer").show();
        $("#branch").hide();
        $("#purchase").hide();
        $("#sent").hide();
        $("#transfer").hide();
    } else {
        $("#consignment").hide();
        $("#customer").hide();
        $("#branch").hide();
        $("#purchase").hide();
        $("#sent").hide();
        $("#transfer").hide();
    }
</script>-->