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
                            <?php echo $form->labelEx($receiveItem->header, 'receive_item_no', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($receiveItem->header, 'receive_item_no', array('size' => 30, 'maxlength' => 30, 'readonly' => true)); ?>
                            <?php echo $form->error($receiveItem->header, 'receive_item_no'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem->header, 'receive_item_date', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($receiveItem->header, 'receive_item_date', array('readonly' => true)); ?>
                            <?php /* $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                              'model' => $receiveItem->header,
                              'attribute' => "receive_item_date",
                              // additional javascript options for the date picker plugin
                              'options'=>array(
                              'dateFormat' => 'yy-mm-dd',
                              'changeMonth'=>true,
                              'changeYear'=>true,
                              'yearRange'=>'1900:2020'
                              ),
                              'htmlOptions'=>array(
                              'value'=>date('Y-m-d'),
                              //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                              ),
                              )); */ ?>
                            <?php echo $form->error($receiveItem->header, 'receive_item_date'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem->header, 'arrival_date', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($receiveItem->header, 'arrival_date', array('readonly' => true)); ?>
                            <?php /* $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                              'model' => $receiveItem->header,
                              'attribute' => "arrival_date",
                              // additional javascript options for the date picker plugin
                              'options'=>array(
                              'dateFormat' => 'yy-mm-dd',
                              'changeMonth'=>true,
                              'changeYear'=>true,
                              'yearRange'=>'1900:2020'
                              ),
                              'htmlOptions'=>array(
                              'value'=>date('Y-m-d'),
                              //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                              ),
                              )); */ ?>
                            <?php echo $form->error($receiveItem->header, 'arrival_date'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem->header, 'recipient_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($receiveItem->header, 'recipient_id', array('value' => $receiveItem->header->isNewRecord ? Yii::app()->user->getId() : $receiveItem->header->recipient_id, 'readonly' => true)); ?>
                            <?php echo $receiveItem->header->isNewRecord ? Yii::app()->user->getName() : CHtml::encode(CHtml::value($receiveItem->header, 'user.name')); ?>
                            <?php echo $form->error($receiveItem->header, 'recipient_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem->header, 'recipient_branch_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownlist($receiveItem->header, 'recipient_branch_id', CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')), 'id', 'name'), array('prompt' => '[--Select Branch--]')); ?>
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
                            <?php echo $form->dropDownlist($receiveItem->header, 'request_type', array('Purchase Order' => 'Purchase Order',
                                'Internal Delivery Order' => 'Internal Delivery Order', 'Consignment In' => 'Consignment In'), array('prompt' => '[--Select Request Type--]',
                                    //	'onchange' =>'//alert($(this).val());
                                    //   var selection = $(this).val();
                                    //   if(selection == "Purchase Order"){
                                    //   	js:$("#purchase").removeClass("hidden");
                                    //   	js:$("#transfer").addClass("hidden");
                                    //   	ClearFields();
                                    //   		$.ajax({
                                    // 			type: "POST",
                                    // 			//dataType: "JSON",
                                    // 			url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id'=> $receiveItem->header->id)).'",
                                    // 			data: $("form").serialize(),
                                    // 			success: function(html) {
                                    // 				$(".detail").html(html);	
                                    // 			},
                                    // 		});
                                    //   }
                                    //   else if(selection == "Transfer Request")
                                    //   {
                                    //   	js:$("#transfer").removeClass("hidden");
                                    //   	js:$("#purchase").addClass("hidden");
                                    //   	ClearFields();
                                    // 		$.ajax({
                                    // 			type: "POST",
                                    // 			//dataType: "JSON",
                                    // 			url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id'=> $receiveItem->header->id)).'",
                                    // 			data: $("form").serialize(),
                                    // 			success: function(html) {
                                    // 				$(".detail").html(html);	
                                    // 			},
                                    // 		});
                                    //   }
                                    // else{
                                    // 	js:$("#transfer").addClass("hidden");
                                    //   	js:$("#purchase").addClass("hidden");
                                    //   	ClearFields();
                                    //   		$.ajax({
                                    // 			type: "POST",
                                    // 			//dataType: "JSON",
                                    // 			url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id'=> $receiveItem->header->id)).'",
                                    // 			data: $("form").serialize(),
                                    // 			success: function(html) {
                                    // 				$(".detail").html(html);	
                                    // 			},
                                    // 		});
                                    // }
                                    //   '
                            ));
                            //  echo $form->radioButtonList($receiveItem->header, 'request_type',
                            //                     array(  'Purchase Order' => 'Purchase Order',
                            //                             'Transfer Request' => 'Transfer Request',
                            //                             ),
                            //                    array(
                            //     'labelOptions'=>array('style'=>'display:inline'), // add this code
                            //     'separator'=>'  ',
                            //     'onchange' =>'//alert($(this).val());
                            //     var selection = $(this).val();
                            //     if(selection == "Purchase Order"){
                            //     	js:$("#purchase").removeClass("hidden");
                            //     	js:$("#transfer").addClass("hidden");
                            //     	ClearFields();
                            //     }
                            //     else if(selection == "Transfer Request")
                            //     {
                            //     	js:$("#transfer").removeClass("hidden");
                            //     	js:$("#purchase").addClass("hidden");
                            //     	ClearFields();
                            //     }
                            //     '
                            // ) );
                            ?>
                            <?php echo $form->error($receiveItem->header, 'request_type'); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($receiveItem->header, 'Supplier S J #', array('class' => 'prefix')); ?>
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
                                    'onclick' => 'jQuery("#purchase-dialog").dialog("open"); return false;',
                                    'value' => $receiveItem->header->purchase_order_id != Null ? $receiveItem->header->purchaseOrder->purchase_order_no : '',
                                    'readonly' => true,
                                )); ?>

                                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                    'id' => 'purchase-dialog',
                                    // additional javascript options for the dialog plugin
                                    'options' => array(
                                        'title' => 'Purchase Order',
                                        'autoOpen' => false,
                                        'width' => 'auto',
                                        'modal' => true,
                                    ),
                                )); ?>

                                <?php $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'purchase-grid',
                                    'dataProvider' => $purchaseDataProvider,
                                    'filter' => $purchase,
                                    'summaryText' => '',
                                    'pager' => array(
                                        'cssFile' => false,
                                        'header' => '',
                                    ),
                                    'selectionChanged' => 'js:function(id){
                                        $("#TransactionReceiveItem_purchase_order_id").val($.fn.yiiGridView.getSelection(id));
                                        $("#purchase-dialog").dialog("close");
                                        $.ajax({
                                            type: "POST",
                                            //dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id' => $receiveItem->header->id)) . '",
                                            data: $("form").serialize(),
                                            success: function(html) {
                                                $(".detail").html(html);	
                                            },
                                        });
                                        $.ajax({
                                            type: "POST",
                                            dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxPurchase', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                                            data: $("form").serialize(),	
                                            success: function(data) {
                                                $("#TransactionReceiveItem_purchase_order_no").val(data.no);
                                                $("#TransactionReceiveItem_request_date").val(data.date);
                                                $("#TransactionReceiveItem_estimate_arrival_date").val(data.eta);
                                                $("#TransactionReceiveItem_supplier_id").val(data.supplier);
                                                $("#TransactionReceiveItem_supplier_name").val(data.supplier_name);
                                                $("#TransactionReceiveItem_coa_id").val(data.coa);
                                                $("#TransactionReceiveItem_coa_name").val(data.coa_name);
                                                $("#TransactionReceiveItem_payment_type").val(data.payment_type);
                                                $("#note").html(data.note);
										
                                                //alert($("#TransactionReceiveItem_request_type").val());
                                                var type = $("#TransactionReceiveItem_request_type").val();
                                                var request = 0;

                                                if (type == "Purchase Order") {
                                                    request = 1;
                                                    if(($("#TransactionReceiveItem_payment_type").val() == "Credit") && ($("#TransactionReceiveItem_coa_id").val() == "")){
                                                            alert("COA could not be empty for payment type Credit!");
                                                            $("#save").attr("disabled","disabled");
                                                    }
                                                    else{
                                                            $("#save").removeAttr("disabled");
                                                    }
                                                }
                                                else if (type== "Transfer Request") {
                                                    request = 2;
                                                }
                                                $.ajax({
                                                    type: "POST",
                                                    //dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $receiveItem->header->id)) . '&requestType="+1+"&requestId="+ $("#TransactionReceiveItem_purchase_order_id").val(),
                                                    data: $("form").serialize(),
                                                    success: function(html) {
                                                        $(".detail").html(html);	
                                                    },
                                                });
                                            } 
                                        });

                                        $("#purchase-grid").find("tr.selected").each(function(){
                                            $(this).removeClass( "selected" );
                                        });

                                    }',
                                    'columns' => array(
                                        'purchase_order_no',
                                        'purchase_order_date',
                                        'supplier.company',
                                    ),
                                )); ?>

                                <?php $this->endWidget(); ?>
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
                                    'onclick' => 'jQuery("#consignment-dialog").dialog("open"); return false;',
                                    'value' => $receiveItem->header->consignment_in_id != Null ? $receiveItem->header->consignmentIn->consignment_in_number : '',
                                    'readonly' => true,
                                )); ?>

                                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                    'id' => 'consignment-dialog',
                                    // additional javascript options for the dialog plugin
                                    'options' => array(
                                        'title' => 'Consignment In',
                                        'autoOpen' => false,
                                        'width' => 'auto',
                                        'modal' => true,
                                    ),
                                )); ?>

                                <?php $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'consignment-grid',
                                    'dataProvider' => $consignmentDataProvider,
                                    'filter' => $consignment,
                                    'summaryText' => '',
                                    'pager' => array(
                                        'cssFile' => false,
                                        'header' => '',
                                    ),
                                    'selectionChanged' => 'js:function(id){
                                        $("#TransactionReceiveItem_consignment_in_id").val($.fn.yiiGridView.getSelection(id));
                                        $("#consignment-dialog").dialog("close");
                                        $.ajax({
                                            type: "POST",
                                            //dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id' => $receiveItem->header->id)) . '",
                                            data: $("form").serialize(),
                                            success: function(html) {
                                                $(".detail").html(html);	
                                            },
                                        });
                                        $.ajax({
                                            type: "POST",
                                            dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxConsignment', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                                            data: $("form").serialize(),	
                                            success: function(data) {
                                                $("#TransactionReceiveItem_consignment_in_no").val(data.no);
                                                $("#TransactionReceiveItem_request_date").val(data.date);
                                                $("#TransactionReceiveItem_estimate_arrival_date").val(data.eta);
                                                $("#TransactionReceiveItem_supplier_id").val(data.supplier);
                                                $("#TransactionReceiveItem_supplier_name").val(data.supplier_name);

                                                //alert($("#TransactionReceiveItem_request_type").val());
                                                var type = $("#TransactionReceiveItem_request_type").val();
                                                var request = 0;

                                                $.ajax({
                                                    type: "POST",
                                                    //dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $receiveItem->header->id)) . '&requestType="+3+"&requestId="+ $("#TransactionReceiveItem_consignment_in_id").val(),
                                                    data: $("form").serialize(),
                                                    success: function(html) {
                                                        $(".detail").html(html);	
                                                    },
                                                });
                                            } 
                                        });

                                        $("#consignment-grid").find("tr.selected").each(function(){
                                            $(this).removeClass( "selected" );
                                        });

                                    }',
                                    'columns' => array(
                                        //'id',
                                        //'code',
                                        'consignment_in_number',
                                        'date_posting',
                                        'supplier.company',
                                    ),
                                )); ?>

                                <?php $this->endWidget(); ?>
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
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($receiveItem->header, 'invoice_number', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($receiveItem->header, 'invoice_number', array('maxlength' => 50, 'size' => 50)); ?>
                                <?php echo $form->error($receiveItem->header, 'invoice_number'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($receiveItem->header, 'invoice_date', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                    'model' => $receiveItem->header,
                                    'attribute' => "invoice_date",
                                    // additional javascript options for the date picker plugin
                                    'options' => array(
                                        'dateFormat' => 'yy-mm-dd',
                                        'changeMonth' => true,
                                        'changeYear' => true,
                                        'yearRange' => '1900:2020'
                                    ),
                                    'htmlOptions' => array(
                                    //'value'=>date('Y-m-d'),
                                    //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                                    ),
                                )); ?>
                                <?php echo $form->error($receiveItem->header, 'supplier_id'); ?>
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
                                    'onclick' => 'jQuery("#delivery-dialog").dialog("open"); return false;',
                                    'value' => $receiveItem->header->delivery_order_id != Null ? $receiveItem->header->deliveryOrder->delivery_order_no : '',
                                    'readonly' => true,
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
                                    'summaryText' => '',
                                    'pager' => array(
                                        'cssFile' => false,
                                        'header' => '',
                                    ),
                                    'selectionChanged' => 'js:function(id) {
                                        $("#TransactionReceiveItem_delivery_order_id").val($.fn.yiiGridView.getSelection(id));
                                        $("#delivery-dialog").dialog("close");
                                        $.ajax({
                                            type: "POST",
                                            //dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxHtmlRemoveDetailRequest', array('id' => $receiveItem->header->id)) . '",
                                            data: $("form").serialize(),
                                            success: function(html) {
                                                    $(".detail").html(html);	

                                            },
                                        });
                                        $.ajax({
                                            type: "POST",
                                            dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxDelivery', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                                            data: $("form").serialize(),
                                            success: function(data) {
                                                $("#TransactionReceiveItem_delivery_order_no").val(data.no);
                                                $("#TransactionReceiveItem_request_date").val(data.date);
                                                $("#TransactionReceiveItem_estimate_arrival_date").val(data.eta);
                                                $("#TransactionReceiveItem_destination_branch").val(data.branch);
                                                $("#TransactionReceiveItem_destination_branch_name").val(data.branch_name);
                                                $.ajax({
                                                    type: "POST",
                                                    //dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $receiveItem->header->id)) . '&requestType="+2+"&requestId="+ $("#TransactionReceiveItem_delivery_order_id").val(),
                                                    data: $("form").serialize(),
                                                    success: function(html) {
                                                        $(".detail").html(html);	
                                                    },
                                                });
                                            } 
                                        });

                                        $("#delivery-grid").find("tr.selected").each(function(){
                                            $(this).removeClass( "selected" );
                                        });

                                    }',
                                    'columns' => array(
                                        'delivery_order_no',
                                        'delivery_date',
                                        'request_type',
                                        array(
                                            'name' => 'sender_branch_id',
                                            'filter' => CHtml::activeDropDownList($delivery, 'sender_branch_id', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                                            'value' => '$data->senderBranch->name'
                                        ),
                                        array(
                                            'name' => 'destination_branch',
                                            'filter' => CHtml::activeDropDownList($delivery, 'destination_branch', CHtml::listData(Branch::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                                            'value' => '$data->destinationBranch->name'
                                        ),
                                    ),
                                )); ?>

                                <?php $this->endWidget(); ?>
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
            <?php $this->renderPartial('_detail', array('receiveItem' => $receiveItem)); ?>
        </div>
        <div class="row">
            <div class="small-12 medium-6 columns">			 
                <div class="field buttons text-center">
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                    <?php echo CHtml::submitButton($receiveItem->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'id' => 'save', 'confirm' => 'Are you sure you want to save?')); ?>
                </div>
            </div>
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
    <?php $this->endWidget(); ?>

    </div><!-- form -->
    <?php Yii::app()->clientScript->registerScript('myjquery', '
	// Yii::app()->controller->action->id
        if($("#TransactionReceiveItem_request_type").val() == "Purchase Order") {
		$("#consignmentIn").hide();
		$("#supplier").show();
		$("#purchase").show();
		$("#delivery").hide();
        } else if ($("#TransactionReceiveItem_request_type").val() == "Internal Delivery Order") {
		$("#supplier").hide();
		$("#consignmentIn").hide();
    	$("#delivery").show();
		$("#purchase").hide();
    }else if($("#TransactionReceiveItem_request_type").val() == "Consignment In") {
    	$("#consignmentIn").show();
		$("#supplier").show();
    	$("#delivery").hide();
		$("#purchase").hide();
    }else {
    	$("#consignmentIn").hide();
		$("#supplier").hide();
    	$("#delivery").hide();
		$("#purchase").hide();
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
        if($("#TransactionReceiveItem_request_type").val() == "Purchase Order") {
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