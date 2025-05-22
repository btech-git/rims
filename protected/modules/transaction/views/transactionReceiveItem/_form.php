<?php
/* @var $this TransactionReceiveItemController */
/* @var $model TransactionReceiveItem */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
    <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Receive Item', Yii::app()->baseUrl . '/transaction/transactionReceiveItem/admin', array('class' => 'button cbutton right', 'visible' => Yii::app()->user->checkAccess("transaction.transactionReceiveItem.admin"))) ?>
    <h1>
        <?php if ($receiveItem->header->id == "") {
            echo "New Transaction Receive Item";
        } else {
            echo "Update Transaction Receive Item";
        } ?>
    </h1>
    <!-- begin FORM -->
    <div class="form">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'transaction-receive-item-form',
            'enableAjaxValidation' => false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <?php echo $form->errorSummary($receiveItem->header); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem->header, 'Tanggal Doc Penerimaan', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $receiveItem->header,
                                'attribute' => "receive_item_date",
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'minDate' => '-1W',
                                    'maxDate' => '+6M',
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
//                                    'value' => date('Y-m-d'),
                                ),
                            )); ?>
                            <?php echo $form->error($receiveItem->header, 'receive_item_date'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem->header, 'Tanggal Penerimaan Barang', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($receiveItem->header, 'arrival_date', array('readonly' => true)); ?>
                            <?php echo $form->error($receiveItem->header, 'arrival_date'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem->header, 'Penerima', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($receiveItem->header, 'recipient_id', array('value' => $receiveItem->header->isNewRecord ? Yii::app()->user->getId() : $receiveItem->header->recipient_id, 'readonly' => true)); ?>
                            <?php echo $receiveItem->header->isNewRecord ? Yii::app()->user->getName() : CHtml::encode(CHtml::value($receiveItem->header, 'user.username')); ?>
                            <?php echo $form->error($receiveItem->header, 'recipient_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem->header, 'Cabang Penerima', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($receiveItem->header, 'recipientBranch.name')); ?>
                            <?php echo $form->error($receiveItem->header, 'recipient_branch_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem->header, 'request_type', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($receiveItem->header, 'request_type', array(
                                'value' => $receiveItem->header->request_type,
                                'readonly' => true,
                            )); ?>
                            <?php echo $form->error($receiveItem->header, 'request_type'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem->header, 'supplier_delivery_number', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($receiveItem->header, 'supplier_delivery_number'); ?>
                            <?php echo $form->error($receiveItem->header, 'supplier_delivery_number'); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="small-12 medium-6 columns">		
                <div id="purchase" >
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($receiveItem->header, 'purchase_order_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($receiveItem->header, 'purchase_order_id'); ?>
                                <?php echo $form->textField($receiveItem->header, 'purchase_order_no', array(
                                    'value' => $receiveItem->header->purchase_order_id != Null ? $receiveItem->header->purchaseOrder->purchase_order_no : '',
                                    'readonly' => true,
                                )); ?>
                                <?php echo $form->error($receiveItem->header, 'purchase_order_id'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($receiveItem->header, 'payment_type', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($receiveItem->header, 'payment_type', array('readonly' => 'true', 'value' => $receiveItem->header->purchase_order_id == "" ? '' : $receiveItem->header->purchaseOrder->payment_type)); ?>
                                <?php echo $form->error($receiveItem->header, 'payment_type'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                    <?php echo $form->labelEx($receiveItem->header, 'Catatan P O', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <span id="note">
                                    <?php echo CHtml::encode(CHtml::value($receiveItem->header, 'purchaseOrder.purchaseOrderApprovals[0].note')); ?>                            
                                </span>
                            </div>
                        </div>
                    </div>			
                </div>
                
                <div id="consignmentIn">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($receiveItem->header, 'consignment_in_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($receiveItem->header, 'consignment_in_id'); ?>
                                <?php echo $form->textField($receiveItem->header, 'consignment_in_no', array(
                                    'value' => $receiveItem->header->consignment_in_id != Null ? $receiveItem->header->consignmentIn->consignment_in_number : '',
                                    'readonly' => true,
                                )); ?>
                                <?php echo $form->error($receiveItem->header, 'consignment_in_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="supplier">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($receiveItem->header, 'supplier_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($receiveItem->header, 'supplier_id', array('readonly' => 'true')); ?>
                                <?php $supplier = Supplier::model()->findByPk($receiveItem->header->supplier_id); ?>
                                <?php echo $form->textField($receiveItem->header, 'supplier_name', array('readonly' => 'true', 'value' => $receiveItem->header->supplier_id == "" ? '' : $supplier->name)); ?>
                                <?php echo $form->error($receiveItem->header, 'supplier_id'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($receiveItem->header, 'coa_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($receiveItem->header, 'coa_id', array('readonly' => 'true', 'value' => $receiveItem->header->supplier_id == "" ? '' : $receiveItem->header->supplier->coa->id)); ?>
                                <?php echo $form->textField($receiveItem->header, 'coa_name', array('readonly' => 'true', 'value' => $receiveItem->header->supplier_id == "" ? '' : $receiveItem->header->supplier->coa->name)); ?>
                                <?php echo $form->error($receiveItem->header, 'coa_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="movementOut">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($receiveItem->header, 'movement_out_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($receiveItem->header, 'movement_out_id'); ?>
                                <?php echo $form->textField($receiveItem->header, 'movement_out_id', array(
                                    'value' => $receiveItem->header->movement_out_id != Null ? $receiveItem->header->movementOut->movement_out_no : '',
                                    'readonly' => true,
                                )); ?>
                                <?php echo $form->error($receiveItem->header, 'movement_out_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="delivery">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($receiveItem->header, 'delivery_order_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($receiveItem->header, 'delivery_order_id'); ?>
                                <?php echo $form->textField($receiveItem->header, 'delivery_order_no', array(
                                    'value' => $receiveItem->header->delivery_order_id != Null ? $receiveItem->header->deliveryOrder->delivery_order_no : '',
                                    'readonly' => true,
                                )); ?>
                                <?php echo $form->error($receiveItem->header, 'delivery_order_id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($receiveItem->header, 'destination_branch', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($receiveItem->header, 'destination_branch', array('readonly' => 'true')); ?>
                                <?php echo $form->textField($receiveItem->header, 'destination_branch_name', array('readonly' => 'true', 'value' => $receiveItem->header->destination_branch != "" ? $receiveItem->header->destinationBranch->name : "")); ?>
                                <?php echo $form->error($receiveItem->header, 'destination_branch'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="requestDetail">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($receiveItem->header, 'request_date', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($receiveItem->header, 'request_date', array('readonly' => 'true')); ?>
                                <?php echo $form->error($receiveItem->header, 'request_date'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($receiveItem->header, 'estimate_arrival_date', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($receiveItem->header, 'estimate_arrival_date', array('readonly' => 'true')); ?>
                                <?php echo $form->error($receiveItem->header, 'estimate_arrival_date'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="detail">
            <?php $this->renderPartial('_detail', array(
                'receiveItem' => $receiveItem,
                'branches' => $branches,
            )); ?>
        </div>
        
        <div class="row">
            <div class="small-12 medium-6 columns">			 
                <div class="field buttons text-center">
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                    <?php echo CHtml::submitButton($receiveItem->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'id' => 'save', 'confirm' => 'Are you sure you want to save?')); ?>
                </div>
            </div>
        </div>
        <?php echo IdempotentManager::generate(); ?>
        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>
    
<script>
    function ClearFields() {

    $('#purchase').find('input:text').val('');
    $('#delivery').find('input:text').val('');
    $('#supplier').find('input:text').val('');
    $('#consignmentIn').find('input:text').val('');
    $('#requestDetail').find('input:text').val('');

    }
</script>

<?php Yii::app()->clientScript->registerScript('myjquery', '
    // Yii::app()->controller->action->id
    if ($("#TransactionReceiveItem_request_type").val() == "Purchase Order") {
        $("#consignmentIn").hide();
        $("#supplier").show();
        $("#purchase").show();
        $("#delivery").hide();
        $("#movementOut").hide();
    } else if ($("#TransactionReceiveItem_request_type").val() == "Internal Delivery Order") {
        $("#supplier").hide();
        $("#consignmentIn").hide();
        $("#delivery").show();
        $("#purchase").hide();
        $("#movementOut").hide();
    } else if($("#TransactionReceiveItem_request_type").val() == "Consignment In") {
    	$("#consignmentIn").show();
        $("#supplier").show();
    	$("#delivery").hide();
        $("#purchase").hide();
        $("#movementOut").hide();
    } else if($("#TransactionReceiveItem_request_type").val() == "Movement Out") {
    	$("#consignmentIn").hide();
        $("#supplier").hide();
    	$("#delivery").hide();
        $("#purchase").hide();
        $("#movementOut").show();
    } else {
    	$("#consignmentIn").hide();
        $("#supplier").hide();
    	$("#delivery").hide();
        $("#purchase").hide();
        $("#movementOut").hide();
    }

    $("#TransactionReceiveItem_request_type").change(function(){
        ClearFields();
        $.ajax({
            type: "POST",
            //dataType: "JSON",
            url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id' => $receiveItem->header->id)) . '",
            data: $("form").serialize(),
            success: function(html) {
                $(".detail").html(html);
            },
        });
        
        if ($("#TransactionReceiveItem_request_type").val() == "Purchase Order") {
            $("#consignmentIn").hide();
            $("#purchase").show();
            $("#supplier").show();
            $("#delivery").hide();
        } else if($("#TransactionReceiveItem_request_type").val() == "Internal Delivery Order") {
            $("#consignmentIn").hide();
            $("#delivery").show();
            $("#supplier").hide();
            $("#purchase").hide();
        } 
        else if($("#TransactionReceiveItem_request_type").val() == "Consignment In") {
            $("#consignmentIn").show();
            $("#supplier").show();
            $("#delivery").hide();
            $("#purchase").hide();
        }else{
            $("#delivery").hide();
            $("#consignmentIn").hide();
            $("#supplier").hide();
            $("#purchase").hide();
        }
    });
'); ?>