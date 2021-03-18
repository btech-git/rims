<?php
/* @var $this MovementOutHeaderController */
/* @var $movementOut->header MovementOutHeader */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
    <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Movement Out', Yii::app()->baseUrl . '/transaction/movementOutHeader/admin', array('class' => 'button cbutton right', 'visible' => Yii::app()->user->checkAccess("transaction.movementOutHeader.admin"))) ?>
    <h1><?php if ($movementOut->header->id == "") {
        echo "New Movement Out Header ";
    } else {
        echo "Update Movement Out Header ";
    } ?></h1>

    <div class="form">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'movement-out-header-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($movementOut->header); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
<!--                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php //echo $form->labelEx($movementOut->header, 'movement_out_no', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php //echo CHtml::encode(CHtml::value($movementOut->header, 'movement_out_no')); ?>
                            <?php //echo $form->textField($movementOut->header, 'movement_out_no', array('size' => 30, 'maxlength' => 30, 'readonly' => true)); ?>
                            <?php //echo $form->error($movementOut->header, 'movement_out_no'); ?>
                        </div>
                    </div>
                </div>-->

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementOut->header, 'date_posting', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($movementOut->header, 'date_posting', array('value' => date('Y-m-d'), 'readonly' => true,)); ?>
                            <?php /* $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                              'model' => $movementOut->header,
                              'attribute' => "date_posting",
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
                            <?php echo $form->error($movementOut->header, 'date_posting'); ?>
                        </div>
                    </div>
                </div>	

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementOut->header, 'movement_type', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($movementOut->header, 'movement_type', array(
                                '1' => 'Delivery Order', 
                                '2' => 'Return Order', 
                                '3' => 'Retail Sales',
                                '4' => 'Material Request',
                            ), array(
                                'prompt' => '[--Select Movement Type--]', 
                                'onchange' => '$.ajax({
                                    type: "POST",
                                    //dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxHtmlRemoveDetailAll', array('id' => $movementOut->header->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(html) {
                                        $("#mmtype").html(html);
                                    },
                                });
                                $("#MovementOutHeader_delivery_order_id").val("");
                                $("#MovementOutHeader_delivery_order_number").val("");
                                $("#MovementOutHeader_reference_type").val("");
                                $("#MovementOutHeader_reference_number").val("");
                                $("#MovementOutHeader_return_order_id").val("");
                                $("#MovementOutHeader_return_order_number").val("");
                                $("#MovementOutHeader_material_request_header_id").val("");
                                $("#MovementOutHeader_material_request_header_number").val("");'
                            )); ?>
                            <?php echo $form->error($movementOut->header, 'movement_type'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementOut->header, 'branch_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownlist($movementOut->header, 'branch_id', CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')), 'id', 'name'), array('prompt' => '[--Select Branch--]', 'onchange' => '
                                //$("#delivery-order-grid .filters input[name=\"TransactionDeliveryOrder[branch_name]\"]").prop("readOnly","readOnly");
                                $.updateGridView("delivery-order-grid", "TransactionDeliveryOrder[branch_name]", $("#MovementOutHeader_branch_id option:selected").text());
                                $.updateGridView("return-order-grid", "TransactionReturnOrder[branch_name]", $("#MovementOutHeader_branch_id option:selected").text());
                                $.updateGridView("registration-transaction-grid", "RegistrationTransaction[branch_name]", $("#MovementOutHeader_branch_id option:selected").text());
                                $.ajax({
                                    type: "POST",
                                    //dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxHtmlRemoveDetailAll', array('id' => $movementOut->header->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(html) {
                                        $("#mmtype").html(html);	
                                    },
                                });
                            ')); ?>
                            <?php echo $form->error($movementOut->header, 'branch_id'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="small-12 medium-6 columns">
                <div id="deliveryOrder">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($movementOut->header, 'delivery_order_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($movementOut->header, 'delivery_order_id'); ?>
                                <?php echo $form->textField($movementOut->header, 'delivery_order_number', array(
                                    'value' => $movementOut->header->delivery_order_id == "" ? "" : TransactionDeliveryOrder::model()->findByPk($movementOut->header->delivery_order_id)->delivery_order_no,
                                    'readonly' => true,
                                    'onclick' => '
                                        var branch = $("#MovementOutHeader_branch_id").val();
                                        var branch_val = $("#MovementOutHeader_branch_id option:selected").text();
                                        // alert(branch + branch_val);
                                        if(branch == ""){
                                            alert("Please Choose Branch to Proceed!");
                                        }else{
                                            $("[name=\"TransactionDeliveryOrder[branch_name]\"]").val(branch_val);
                                            $("[name=\"TransactionDeliveryOrder[branch_name]\"]").attr("readonly", "readonly");
                                            $("#delivery-order-dialog").dialog("open"); return false;
                                        }

                                ')); ?>
                                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                    'id' => 'delivery-order-dialog',
                                    // additional javascript options for the dialog plugin
                                    'options' => array(
                                        'title' => 'Delivery Order',
                                        'autoOpen' => false,
                                        'width' => 'auto',
                                        'modal' => true,
                                    ),
                                )); ?>

                                <?php $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'delivery-order-grid',
                                    'dataProvider' => $deliveryOrderDataProvider,
                                    'filter' => $deliveryOrder,
                                    'pager'=>array(
                                       'cssFile'=>false,
                                       'header'=>'',
                                    ),
                                    'selectionChanged' => 'js:function(id){
                                        $("#MovementOutHeader_delivery_order_id").val($.fn.yiiGridView.getSelection(id));
                                        $("#delivery-order-dialog").dialog("close");
                                        $.ajax({
                                            type: "POST",
                                            dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxDelivery', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                                            data: $("form").serialize(),
                                            success: function(data) {
                                                $("#MovementOutHeader_delivery_order_number").val(data.number);
                                                $("#MovementOutHeader_reference_type").val(data.type);
                                                $("#MovementOutHeader_reference_number").val(data.requestNumber);
                                                 $.updateGridView("delivery-order-detail-grid", "TransactionDeliveryOrderDetail[delivery_order_no]", data.number);
                                                 $.ajax({
                                                    type: "POST",
                                                    //dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxHtmlRemoveDetailAll', array('id' => $movementOut->header->id)) . '",
                                                    data: $("form").serialize(),
                                                    success: function(html) {
                                                        $("#mmtype").attr("data-mmtype","mmtype_delivey"); 
                                                        $("#mmtype").html(html);
                                                    },
                                                });
                                            },
                                        });

                                        $("#delivery-order-grid").find("tr.selected").each(function(){
                                           $(this).removeClass( "selected" );
                                        });
                                    }',
                                    'columns' => array(
                                        'delivery_order_no',
                                        'delivery_date',
                                        array('name' => 'branch_name', 'value' => '$data->senderBranch->name',)
                                    )
                                )); ?>
                                <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                                <?php echo $form->error($movementOut->header, 'delivery_order_id'); ?>
                            </div>
                        </div>
                    </div>			

                    <?php
                    $type = $requestNumber = "";
                    $delivery = TransactionDeliveryOrder::model()->findByPk($movementOut->header->delivery_order_id);
                    if (!empty($delivery)) {
                        if ($delivery->request_type == "Sales Order") {
                            $type = "Sales Order";
                            $requestNumber = $delivery->salesOrder->sale_order_no;
                        } elseif ($delivery->request_type == "Sent Request") {
                            $type = "Sent Request";
                            $requestNumber = $delivery->sentRequest->sent_request_no;
                        } elseif ($delivery->request_type == "Consignment Out") {
                            $type = "Consignment out";
                            $requestNumber = $delivery->consignmentOut->consignment_out_no;
                        } elseif ($delivery->request_type == "Transfer Request") {
                            $type = "Transfer Request";
                            $requestNumber = $delivery->transferRequest->transfer_request_no;
                        }
                    }
                    ?>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label>Reference Type</label>
                            </div>
                            <div class="small-8 columns">
                                <input id="MovementOutHeader_reference_type" readonly="readonly" name="MovementOutHeader[reference_type]" type="text" value="<?php echo $movementOut->header->delivery_order_id == "" ? "" : $type; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label>Reference #</label>
                            </div>
                            <div class="small-8 columns">
                                <input id="MovementOutHeader_reference_number" readonly="readonly" name="MovementOutHeader[reference_number]" type="text" value="<?php echo $movementOut->header->delivery_order_id == "" ? "" : $requestNumber; ?>">
                            </div>
                        </div>
                    </div>
                </div> <!-- End div Delivery Order -->

                <div id="returnOrder">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($movementOut->header, 'return_order_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($movementOut->header, 'return_order_id'); ?>
                                <?php echo $form->textField($movementOut->header, 'return_order_number', array(
                                    'value' => $movementOut->header->return_order_id == "" ? "" : TransactionReturnOrder::model()->findByPk($movementOut->header->return_order_id)->return_order_no,
                                    'readonly' => true,
                                    'onclick' => '
                                        var branch = $("#MovementOutHeader_branch_id").val();
                                        var branch_val = $("#MovementOutHeader_branch_id option:selected").text();
                                        // alert(branch + branch_val);
                                        if(branch == ""){
                                            alert("Please Choose Branch to Proceed!");
                                        }else{
                                            $("[name=\"TransactionReturnOrder[branch_name]\"]").val(branch_val);
                                            $("[name=\"TransactionReturnOrder[branch_name]\"]").attr("readonly", "readonly");
                                            $("#return-order-dialog").dialog("open"); return false;
                                        }
                                    '
                                ));
                                ?>
                                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                    'id' => 'return-order-dialog',
                                    // additional javascript options for the dialog plugin
                                    'options' => array(
                                        'title' => 'Return Order',
                                        'autoOpen' => false,
                                        'width' => 'auto',
                                        'modal' => true,
                                    ),
                                )); ?>

                                <?php $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'return-order-grid',
                                    'dataProvider' => $returnOrderDataProvider,
                                    'filter' => $returnOrder,
                                    'pager'=>array(
                                       'cssFile'=>false,
                                       'header'=>'',
                                    ),
                                    'selectionChanged' => 'js:function(id){
                                        $("#MovementOutHeader_return_order_id").val($.fn.yiiGridView.getSelection(id));
                                        $("#return-order-dialog").dialog("close");
                                        $.ajax({
                                            type: "POST",
                                            dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxReturn', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                                            data: $("form").serialize(),
                                            success: function(data) {
                                                $("#MovementOutHeader_return_order_number").val(data.number);
                                                 $.updateGridView("return-order-detail-grid", "TransactionReturnOrderDetail[return_order_no]", data.number);
                                                 $.ajax({
                                                    type: "POST",
                                                    //dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxHtmlRemoveDetailAll', array('id' => $movementOut->header->id)) . '",
                                                    data: $("form").serialize(),
                                                    success: function(html) {
                                                        $("#mmtype").attr("data-mmtype","mmtype_return"); 
                                                        $("#mmtype").html(html);
                                                    },
                                                });
                                            },
                                        });

                                        $("#return-order-grid").find("tr.selected").each(function(){
                                           $(this).removeClass( "selected" );
                                        });
                                    }',
                                    'columns' => array(
                                        'return_order_no',
                                        array(
                                            'name' => 'branch_name', 
                                            'value' => '$data->recipientBranch->name',
                                        ),
                                    ),
                                )); ?>
                                <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                                <?php echo $form->error($movementOut->header, 'return_order_id'); ?>
                            </div>
                        </div>
                    </div>
                </div> <!-- end of DIV ReturnOrder -->

                <div id="retailSales">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($movementOut->header, 'registration_transaction_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($movementOut->header, 'registration_transaction_id'); ?>
                                <?php echo $form->textField($movementOut->header, 'transaction_number', array(
                                    'value' => $movementOut->header->registration_transaction_id == "" ? "" : RegistrationTransaction::model()->findByPk($movementOut->header->registration_transaction_id)->transaction_number,
                                    'readonly' => true,
                                    'onclick' => '
                                        var branch = $("#MovementOutHeader_branch_id").val();
                                        var branch_val = $("#MovementOutHeader_branch_id option:selected").text();
                                        // alert(branch + branch_val);
                                        if(branch == ""){
                                            alert("Please Choose Branch to Proceed!");
                                        }else{
                                            $("[name=\"RegistrationTransaction[branch_name]\"]").val(branch_val);
                                            $("[name=\"RegistrationTransaction[branch_name]\"]").attr("readonly", "readonly");
                                            $("#registration-transaction-dialog").dialog("open"); return false;
                                        }

                                    '
                                )); ?>
                                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                    'id' => 'registration-transaction-dialog',
                                    // additional javascript options for the dialog plugin
                                    'options' => array(
                                        'title' => 'Registration Transaction',
                                        'autoOpen' => false,
                                        'width' => 'auto',
                                        'modal' => true,
                                    ),
                                )); ?>

                                <?php $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'registration-transaction-grid',
                                    'dataProvider' => $registrationTransactionDataProvider,
                                    'filter' => $registrationTransaction,
                                    'pager'=>array(
                                       'cssFile'=>false,
                                       'header'=>'',
                                    ),
                                    'selectionChanged' => 'js:function(id){
                                        $("#MovementOutHeader_registration_transaction_id").val($.fn.yiiGridView.getSelection(id));
                                        $("#registration-transaction-dialog").dialog("close");
                                        $.ajax({
                                            type: "POST",
                                            dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxRetail', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                                            data: $("form").serialize(),
                                            success: function(data) {
                                                $("#MovementOutHeader_transaction_number").val(data.number);
                                                 $.updateGridView("registration-transaction-detail-grid", "RegistrationProduct[transaction_number]", data.number);
                                                 $.ajax({
                                                    type: "POST",
                                                    //dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxHtmlRemoveDetailAll', array('id' => $movementOut->header->id)) . '",
                                                    data: $("form").serialize(),
                                                    success: function(html) {
                                                        $("#mmtype").attr("data-mmtype","mmtype_registration"); 
                                                        $("#mmtype").html(html);
                                                    },
                                                });
                                            },
                                        });

                                        $("#registration-transaction-grid").find("tr.selected").each(function(){
                                           $(this).removeClass( "selected" );
                                        });

                                    }',
                                        'columns' => array(
                                            'transaction_number',
                                            array('name' => 'branch_name', 'value' => '$data->branch->name',)
                                        ),
                                    )); ?>

                                <?php Yii::app()->clientScript->registerScript('updateGridView', '
                                    $.updateGridView = function(gridID, name, value) {
                                        $("#"+gridID+" input[name=\""+name+"\"], #"+gridID+" select[name=\""+name+"\"]").val(value);
                                        $.fn.yiiGridView.update(gridID, {data: $.param(
                                            $("#"+gridID+" .filters input, #"+gridID+" .filters select")
                                        )});
                                    }
                                ', CClientScript::POS_READY); ?>
                                <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                                <?php echo $form->error($movementOut->header, 'registration_transaction_id'); ?>
                            </div>
                        </div>
                    </div>
                </div> <!-- end of Div RetailSales -->

                <div id="materialRequest">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($movementOut->header, 'material_request_header_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($movementOut->header, 'material_request_header_id'); ?>
                                <?php echo $form->textField($movementOut->header, 'material_request_number', array(
                                    'value' => $movementOut->header->material_request_header_id == "" ? "" : MaterialRequestHeader::model()->findByPk($movementOut->header->material_request_header_id)->transaction_number,
                                    'readonly' => true,
                                    'onclick' => '
                                        var branch = $("#MovementOutHeader_branch_id").val();
                                        var branch_val = $("#MovementOutHeader_branch_id option:selected").text();
                                        if (branch == "") {
                                            alert("Please Choose Branch to Proceed!");
                                        } else {
                                            $("[name=\"RegistrationTransaction[branch_name]\"]").val(branch_val);
                                            $("[name=\"RegistrationTransaction[branch_name]\"]").attr("readonly", "readonly");
                                            $("#material-request-dialog").dialog("open"); return false;
                                        }
                                    '
                                )); ?>
                                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                    'id' => 'material-request-dialog',
                                    // additional javascript options for the dialog plugin
                                    'options' => array(
                                        'title' => 'Material Request',
                                        'autoOpen' => false,
                                        'width' => 'auto',
                                        'modal' => true,
                                    ),
                                )); ?>

                                <?php $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'material-request-grid',
                                    'dataProvider' => $materialRequestHeaderDataProvider,
                                    'filter' => $materialRequestHeader,
                                    'pager'=>array(
                                       'cssFile'=>false,
                                       'header'=>'',
                                    ),
                                    'selectionChanged' => 'js:function(id){
                                        $("#MovementOutHeader_material_request_header_id").val($.fn.yiiGridView.getSelection(id));
                                        $("#material-request-dialog").dialog("close");
                                        $.ajax({
                                            type: "POST",
                                            dataType: "JSON",
                                            url: "' . CController::createUrl('ajaxMaterialRequest', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                                            data: $("form").serialize(),
                                            success: function(data) {
                                                $("#MovementOutHeader_material_request_number").val(data.number);
                                                $.updateGridView("material-request-detail-grid", "MaterialRequestDetail[material_request_header_id]", data.id);
                                                $.ajax({
                                                    type: "POST",
                                                    //dataType: "JSON",
                                                    url: "' . CController::createUrl('ajaxHtmlRemoveDetailAll', array('id' => $movementOut->header->id)) . '",
                                                    data: $("form").serialize(),
                                                    success: function(html) {
                                                        $("#mmtype").attr("data-mmtype","mmtype_material_request"); 
                                                        $("#mmtype").html(html);
                                                    },
                                                });
                                            },
                                        });

                                        $("#material-request-grid").find("tr.selected").each(function(){
                                            $(this).removeClass( "selected" );
                                        });
                                    }',
                                    'columns' => array(
                                        'transaction_number',
                                        'transaction_date',
                                        array(
                                            'header' => 'Branch', 
                                            'value' => '$data->branch->name',
                                        ),
                                        'note',
                                    ),
                                )); ?>

                                <?php Yii::app()->clientScript->registerScript('updateGridView', '
                                    $.updateGridView = function(gridID, name, value) {
                                        $("#"+gridID+" input[name=\""+name+"\"], #"+gridID+" select[name=\""+name+"\"]").val(value);
                                        $.fn.yiiGridView.update(gridID, {data: $.param(
                                            $("#"+gridID+" .filters input, #"+gridID+" .filters select")
                                        )});
                                    }
                                ', CClientScript::POS_READY); ?>
                                <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                                <?php echo $form->error($movementOut->header, 'material_request_header_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementOut->header, 'user_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php //echo $form->textField($movementOut->header,'user_id');  ?>
                            <?php echo $form->hiddenField($movementOut->header, 'user_id', array('readonly' => true, 'value' => $movementOut->header->isNewRecord ? Yii::app()->user->getId() : $movementOut->header->user_id)); ?>
                            <?php echo $movementOut->header->isNewRecord ? CHtml::encode(Yii::app()->user->getName()) : $movementOut->header->user->username; ?>
                            <?php echo $form->error($movementOut->header, 'user_id'); ?>
                        </div>
                    </div>
                </div>		

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementOut->header, 'status', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($movementOut->header, 'status', array('value' => $movementOut->header->isNewRecord ? 'Draft' : $movementOut->header->status, 'readonly' => true)); ?>
                            <?php echo $form->error($movementOut->header, 'status'); ?>
                        </div>
                    </div>
                </div>		

            </div>
        </div>
        <fieldset>
            <legend>Detail</legend>
            <div class="row">
                <div class="large-5 columns">
                    <div class="small-6 columns">
                        <?php echo CHtml::button('Add Details', array(
                            'id' => 'detail-button',
                            'name' => 'Detail',
                            'style' => 'width:100%',
                            'onclick' => '
                                var movement = $("#MovementOutHeader_movement_type").val();
                                var branch = $("#MovementOutHeader_branch_id").val();
                                var delivery = $("#MovementOutHeader_delivery_order_id").val();
                                var delivery_val = $("#MovementOutHeader_delivery_order_number").val();
                                var returnOrder = $("#MovementOutHeader_return_order_id").val();
                                var return_val = $("#MovementOutHeader_return_order_number").val();
                                var retail = $("#MovementOutHeader_registration_transaction_id").val();
                                var retail_val = $("#MovementOutHeader_transaction_number").val();
//                                var materialRequest = $("#MovementOutHeader_material_request_header_id").val();
                                var material_request_val = $("#MovementOutHeader_material_request_header_id").val();
                                if (movement == 1) {
                                    if (branch === "" || delivery === "") {
                                        alert("Please Choose Branch and Delivery Order no to Proceed!");
                                    } else {
                                        $("[name=\"TransactionDeliveryOrderDetail[delivery_order_no]\"]").val(delivery_val);
                                        $("[name=\"TransactionDeliveryOrderDetail[delivery_order_no]\"]").attr("readonly", "readonly");
                                        $("#delivery-order-detail-dialog").dialog("open"); return false;

                                    }
                                } else if (movement == 2) {
                                    if (branch === "" || returnOrder === "") {
                                        alert("Please Choose Branch and Return Order no to Proceed!");
                                    } else {
                                        $("[name=\"TransactionReturnOrderDetail[return_order_no]\"]").val(return_val);
                                        $("[name=\"TransactionReturnOrderDetail[return_order_no]\"]").attr("readonly", "readonly");
                                        $("#return-order-detail-dialog").dialog("open"); return false;
                                    }
                                } else if (movement == 3) {
                                    if (branch === "" || retail === "") {
                                        alert("Please Choose Branch and Registration no to Proceed!");
                                    } else {
                                        $("[name=\"RegistrationProduct[transaction_number]\"]").val(retail_val);
                                        //$("[name=\"RegistrationProduct[transaction_number]\"]").attr("readonly", "readonly");
                                        $("#registration-transaction-detail-dialog").dialog("open"); return false;
                                    }
                                } else if (movement == 4) {
                                    if (branch === "" || materialRequest === "") {
                                        alert("Please Choose Branch and Material Request to Proceed!");
                                    } else {
                                        $("[name=\"MaterialRequestDetail[material_request_header_id]\"]").val(material_request_val);
                                        $("#material-request-detail-dialog").dialog("open"); return false;
                                    }
                                }
                                console.log(movement);
                            ',
                        )); ?>
                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id' => 'delivery-order-detail-dialog',
                            // additional javascript options for the dialog plugin
                            'options' => array(
                                'title' => 'Delivery Order',
                                'autoOpen' => false,
                                'width' => 'auto',
                                'modal' => true,
                            ),
                        )); ?>

                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'delivery-order-detail-grid',
                            'dataProvider' => $deliveryOrderDetailDataProvider,
                            'filter' => $deliveryOrderDetail,
                            'pager'=>array(
                               'cssFile'=>false,
                               'header'=>'',
                            ),
                            'selectionChanged' => 'js:function(id){
                                $("#delivery-order-detail-dialog").dialog("close");
                                $.ajax({
                                    type: "POST",
                                    url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $movementOut->header->id, 'detailId' => '')) . '"  + $.fn.yiiGridView.getSelection(id)+"&type="+1,
                                    data: $("form").serialize(),
                                    success: function(html) {
                                        $("#mmtype").attr("data-mmtype","mmtype_delivey"); 
                                        $("#mmtype").html(html);
                                    },
                                });

                                $("#delivery-order-detail-grid").find("tr.selected").each(function(){
                                   $(this).removeClass( "selected" );
                                });
                            }',
                            'columns' => array(
                                array(
                                    'name' => 'delivery_order_no', 
                                    'value' => '$data->deliveryOrder->delivery_order_no'
                                ),
                                array(
                                    'header' => 'Name',
                                    'value' => '$data->product->name'
                                ),
                                array(
                                    'header' => 'Code',
                                    'value' => '$data->product->manufacturer_code'
                                ),
                                array(
                                    'header' => 'Sub Category',
                                    'value' => '$data->product->masterSubCategoryCode'
                                ),
                                array(
                                    'header' => 'Brand',
                                    'value' => '$data->product->brand->name'
                                ),
                                array(
                                    'header' => 'Sub Brand',
                                    'value' => '$data->product->subBrand->name'
                                ),
                                array(
                                    'header' => 'Sub Brand Series',
                                    'value' => '$data->product->subBrandSeries->name'
                                ),
                                array(
                                    'header' => 'Quantity',
                                    'value' => '$data->quantity_delivery.CHTML::hiddenField("qtysum_mmtype_delivey".$data->product_id,\'0\',array(\'width\'=>20,\'maxlength\'=>3)).CHTML::hiddenField("qtyleft_mmtype_delivey".$data->product_id,$data->quantity_delivery,array(\'width\'=>20,\'maxlength\'=>3))',
                                    'type' => 'raw',
                                    'filter' => false
                                ),
                                array(
                                    'header' => 'Unit',
                                    'value' => '$data->product->unit->name'
                                ),
                            ),
                        )); ?>

                        <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                        <!--Return Order Detail -->
                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id' => 'return-order-detail-dialog',
                            // additional javascript options for the dialog plugin
                            'options' => array(
                                'title' => 'Return Order',
                                'autoOpen' => false,
                                'width' => 'auto',
                                'modal' => true,
                            ),
                        )); ?>

                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'return-order-detail-grid',
                            'dataProvider' => $returnOrderDetailDataProvider,
                            'filter' => $returnOrderDetail,
                            'pager'=>array(
                               'cssFile'=>false,
                               'header'=>'',
                            ),
                            'selectionChanged' => 'js:function(id){
                                $("#return-order-detail-dialog").dialog("close");

                                $.ajax({
                                    type: "POST",
                                    url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $movementOut->header->id, 'detailId' => '')) . '"  + $.fn.yiiGridView.getSelection(id)+"&type="+2,
                                    data: $("form").serialize(),
                                    success: function(html) {
                                        $("#mmtype").attr("data-mmtype","mmtype_return"); 
                                        $("#mmtype").html(html);
                                    },
                                });

                                $("#return-order-detail-grid").find("tr.selected").each(function(){
                                   $(this).removeClass( "selected" );
                                });
                            }',
                            'columns' => array(
                                array('name' => 'return_order_no', 'value' => '$data->returnOrder->return_order_no'),
                                array('header' => 'Product', 'value' => '$data->product->name'),
                                array(
                                    'header' => 'Quantity',
                                    // 'value'=>'$data->qty_reject',
                                    'value' => '$data->qty_reject.CHTML::hiddenField("qtysum_mmtype_return".$data->product_id,\'0\',array(\'width\'=>20,\'maxlength\'=>3)).CHTML::hiddenField("qtyleft_mmtype_return".$data->product_id,$data->qty_reject,array(\'width\'=>20,\'maxlength\'=>3))',
                                    'type' => 'raw',
                                    'filter' => false),
                            ),
                        )); ?>
                        <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

                        <!--Registration Product Detail -->
                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id' => 'registration-transaction-detail-dialog',
                            // additional javascript options for the dialog plugin
                            'options' => array(
                                'title' => 'Registration Transaction',
                                'autoOpen' => false,
                                'width' => 'auto',
                                'modal' => true,
                            ),
                        )); ?>

                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'registration-transaction-detail-grid',
                            'dataProvider' => $registrationProductDataProvider,
                            'filter' => $registrationProduct,
                            'pager'=>array(
                               'cssFile'=>false,
                               'header'=>'',
                            ),
                            'selectionChanged' => 'js:function(id){
                                $("#registration-transaction-detail-dialog").dialog("close");

                                $.ajax({
                                    type: "POST",
                                    url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $movementOut->header->id, 'detailId' => '')) . '"  + $.fn.yiiGridView.getSelection(id)+"&type="+3,
                                    data: $("form").serialize(),
                                    success: function(html) {
                                        $("#mmtype").html(html);
                                    },
                                });

                                $("#registration-transaction-detail-grid").find("tr.selected").each(function(){
                                   $(this).removeClass( "selected" );
                                });	
                            }',
                            'columns' => array(
                                array('name' => 'transaction_number', 'value' => '$data->registrationTransaction->transaction_number'),
                                array('header' => 'Product', 'value' => '$data->product->name'),
                                array(
                                    'header' => 'Quantity',
                                    // 'value'=>'$data->quantity',
                                    'value' => '$data->quantity.CHTML::hiddenField("qtysum_mmtype_registration".$data->product_id,\'0\',array(\'width\'=>20,\'maxlength\'=>3)).CHTML::hiddenField("qtyleft_mmtype_registration".$data->product_id,$data->quantity,array(\'width\'=>20,\'maxlength\'=>3))',
                                    'type' => 'raw',
                                    'filter' => false
                                ),
                            ),
                        )); ?>

                        <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                        <!-- Refresh grid with value from kode kelompok persediaan-->
                        
                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id' => 'material-request-detail-dialog',
                            // additional javascript options for the dialog plugin
                            'options' => array(
                                'title' => 'Product Request',
                                'autoOpen' => false,
                                'width' => 'auto',
                                'modal' => true,
                            ),
                        )); ?>

                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'material-request-detail-grid',
                            'dataProvider' => $materialRequestDetailDataProvider,
                            'filter' => $materialRequestDetail,
                            'pager'=>array(
                               'cssFile'=>false,
                               'header'=>'',
                            ),
                            'selectionChanged' => 'js:function(id){
                                $("#material-request-detail-dialog").dialog("close");

                                $.ajax({
                                    type: "POST",
                                    url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $movementOut->header->id, 'detailId' => '')) . '"  + $.fn.yiiGridView.getSelection(id)+"&type="+4,
                                    data: $("form").serialize(),
                                    success: function(html) {
                                        $("#mmtype").html(html);
                                    },
                                });

                                $("#material-request-detail-grid").find("tr.selected").each(function(){
                                   $(this).removeClass( "selected" );
                                });	
                            }',
                            'columns' => array(
                                array(
                                    'header' => 'Request #',
                                    'name' => 'material_request_header_id',
                                    'value' => '$data->materialRequestHeader->transaction_number',
                                ),
                                array(
                                    'header' => 'Name',
                                    'value' => '$data->product->name'
                                ),
                                array(
                                    'header' => 'Code',
                                    'value' => '$data->product->manufacturer_code'
                                ),
                                array(
                                    'header' => 'Sub Category',
                                    'value' => '$data->product->masterSubCategoryCode'
                                ),
                                array(
                                    'header' => 'Brand',
                                    'value' => '$data->product->brand->name'
                                ),
                                array(
                                    'header' => 'Sub Brand',
                                    'value' => '$data->product->subBrand->name'
                                ),
                                array(
                                    'header' => 'Sub Brand Series',
                                    'value' => '$data->product->subBrandSeries->name'
                                ),
                                array(
                                    'header' => 'Quantity Req',
                                    'value' => '$data->quantity',
                                    'type' => 'raw',
                                    'filter' => false,
                                ),
                                array(
                                    'header' => 'Quantity Remaining',
                                    'value' => '$data->quantity_remaining',
                                    'type' => 'raw',
                                    'filter' => false,
                                ),
                                array(
                                    'header' => 'Unit',
                                    'value' => '$data->product->unit->name'
                                ),
                            ),
                        )); ?>

                        <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

                    </div>
                    <!-- <div class="small-4 columns">
                        
                        <?php
                        // echo CHtml::button('Add New Product', array(
                        // 	'id' => 'detail-button',
                        // 	'name' => 'Detail',
                        // 	'style' =>'width:100%',
                        // 	//'target'=>'_blank',
                        // 	'onclick' => ' 
                        // 		window.location.href = "'.Yii::app()->baseUrl.'/master/product/create/"',
                        //  )); 
                        ?>
                    </div> -->
                    <div class="small-6 columns">

                        <?php
                        // echo CHtml::button('Count Total', array(
                        // 	'id' => 'total-button',
                        // 	'name' => 'Total',
                        // 	'style' =>'width:100%',
                        // 	'onclick' => '
                        // 	$.ajax({
                        //                type: "POST",
                        //                url: "' . CController::createUrl('ajaxGetTotal', array('id' => $consignmentOut->header->id,)) . '",
                        //                data: $("form").serialize(),
                        //                dataType: "json",
                        //                success: function(data) {
                        //                    //console.log(data.total);
                        //                	//console.log(data.requestType);
                        //                    $("#ConsignmentOutHeader_total_price").val(data.total);
                        //                    $("#ConsignmentOutHeader_total_quantity").val(data.total_items);
                        //                },
                        //              });',)); 
                        ?>

                    </div>
                </div>
            </div>

            <br />
            <div class="row">
                <div class="large-12 columns">
                    <div class="detail" id="mmtype">
                        <?php $this->renderPartial('_detail', array('movementOut' => $movementOut)); ?>
                    </div>
                </div>	
            </div>
        </fieldset>
        <div class="field buttons text-center">
            <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
            <?php echo CHtml::submitButton($movementOut->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
        </div>

<?php $this->endWidget(); ?>

    </div><!-- form -->
</div>
<script type="text/javascript">
    $(document).on("change", ".qtyleft_input", function() {
    var sum = 0;
    var thisted = $(this).attr('rel');
    var mmtype =  $("#mmtype").attr('data-mmtype');
    $(".productID_"+thisted).each(function(){
    sum += +$(this).val();
    });
    // $(".qtyleft_"+thisted).val(sum);
    $("#qtysum_"+mmtype+thisted).val(sum);
    var nilaiawal = $("#qtyleft_"+mmtype+thisted).val();


    if (sum > nilaiawal) {
    // console.log(sum + ">=" + nilaiawal);
    alert("Quantity yang anda input melebihi quantity stock.");
    $('.productID_'+thisted).focus().select();
    }
    // else{
    // 	// console.log(sum + "<=" + nilaiawal);
    // }
    // if ()
    // console.log(sum + ' ' + thisted);
    });
    if ($("#MovementOutHeader_movement_type").val() == "1") {
        $("#deliveryOrder").show();
        $("#returnOrder").hide();
        $("#retailSales").hide();
        $("#materialRequest").hide();
    } else if ($("#MovementOutHeader_movement_type").val() == "2") {
        $("#deliveryOrder").hide();
        $("#returnOrder").show();
        $("#retailSales").hide();
        $("#materialRequest").hide();
    } else if ($("#MovementOutHeader_movement_type").val() == "3") {
        $("#deliveryOrder").hide();
        $("#returnOrder").hide();
        $("#retailSales").show();
        $("#materialRequest").hide();
    } else if ($("#MovementOutHeader_movement_type").val() == "4") {
        $("#deliveryOrder").hide();
        $("#returnOrder").hide();
        $("#retailSales").hide();
        $("#materialRequest").show();
    } else {
        $("#deliveryOrder").hide();
        $("#returnOrder").hide();
        $("#retailSales").hide();
        $("#materialRequest").hide();
    }
    $("#MovementOutHeader_movement_type").change(function() {
    //ClearFields();
        $("#MovementOutHeader_delivery_order_id").val("");
        $("#MovementOutHeader_delivery_order_number").val("");
        $("#MovementOutHeader_reference_type").val("");
        $("#MovementOutHeader_reference_number").val("");
        $("#MovementOutHeader_return_order_id").val("");
        $("#MovementOutHeader_return_order_number").val("");
        $("#MovementOutHeader_registration_transaction_id").val("");
        $("#MovementOutHeader_transaction_number").val("");
        $("#MovementOutHeader_material_request_id").val("");
        
        if ($("#MovementOutHeader_movement_type").val() == "1") {
            $("#deliveryOrder").show();
            $("#returnOrder").hide();
            $("#retailSales").hide();
            $("#materialRequest").hide();
        } else if ($("#MovementOutHeader_movement_type").val() == "2") {
            $("#deliveryOrder").hide();
            $("#returnOrder").show();
            $("#retailSales").hide();
            $("#materialRequest").hide();
        } else if ($("#MovementOutHeader_movement_type").val() == "3") {
            $("#deliveryOrder").hide();
            $("#returnOrder").hide();
            $("#retailSales").show();
            $("#materialRequest").hide();
        } else if ($("#MovementOutHeader_movement_type").val() == "4") {
            $("#deliveryOrder").hide();
            $("#returnOrder").hide();
            $("#retailSales").hide();
            $("#materialRequest").show();
        } else {
            $("#deliveryOrder").hide();
            $("#returnOrder").hide();
            $("#retailSales").hide();
            $("#materialRequest").hide();
        }
    });
</script>