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
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementOut->header, 'date_posting', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $movementOut->header,
                                'attribute' => "date_posting",
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'yearRange' => '1900:2050'
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
//                                    'value' => date('Y-m-d'),
                                ),
                            )); ?>
                            <?php //echo $form->textField($movementOut->header, 'date_posting', array('value' => date('Y-m-d H:i:s'), 'readonly' => true,)); ?>
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
                            <?php echo CHtml::encode($movementOut->header->getMovementType($movementOut->header->movement_type)); ?>
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
                            <?php echo CHtml::encode(CHtml::value($movementOut->header, 'branch.name')); ?>
                            <?php echo $form->error($movementOut->header, 'branch_id'); ?>
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
            
            <div class="small-12 medium-6 columns">
                <?php if ((int) $movementOut->header->movement_type == 1 || !empty($movementOut->header->delivery_order_id)): ?>
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
                                    )); ?>
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
                <?php elseif ((int) $movementOut->header->movement_type == 2 || !empty($movementOut->header->return_order_id)): ?>
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
                                    )); ?>
                                    <?php echo $form->error($movementOut->header, 'return_order_id'); ?>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end of DIV ReturnOrder -->
                <?php elseif ((int) $movementOut->header->movement_type == 3 || !empty($movementOut->header->registration_transaction_id)): ?>
                    <div id="retailSales">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <?php echo $form->labelEx($movementOut->header, 'Retail Sales #', array('class' => 'prefix')); ?>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo $form->hiddenField($movementOut->header, 'registration_transaction_id'); ?>
                                    <?php echo $form->textField($movementOut->header, 'transaction_number', array(
                                        'value' => $movementOut->header->registration_transaction_id == "" ? "" : RegistrationTransaction::model()->findByPk($movementOut->header->registration_transaction_id)->transaction_number,
                                        'readonly' => true,
                                    )); ?>
                                    <?php echo $form->error($movementOut->header, 'registration_transaction_id'); ?>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end of Div RetailSales -->
                <?php elseif ((int) $movementOut->header->movement_type == 4 || !empty($movementOut->header->material_request_header_id)): ?>
                    <div id="materialRequest">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <?php echo $form->labelEx($movementOut->header, 'material_request_header_id', array('class' => 'prefix')); ?>
                                </div>
                                <div class="small-8 columns">
                                    <?php $materialRequest = MaterialRequestHeader::model()->findByPk($movementOut->header->material_request_header_id); ?>
                                    <?php echo $form->hiddenField($movementOut->header, 'material_request_header_id'); ?>
                                    <?php echo $form->textField($movementOut->header, 'transaction_number', array(
                                        'value' => $materialRequest->transaction_number,
                                        'readonly' => true,
                                    )); ?>
                                    <?php echo $form->error($movementOut->header, 'material_request_header_id'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div>NO DATA AVAILABLE</div>
                <?php endif; ?>
                    
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementOut->header, 'user_id', array('class' => 'prefix')); ?>
                        </div>
                        
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($movementOut->header, 'user_id', array('readonly' => true, 'value' => $movementOut->header->isNewRecord ? Yii::app()->user->getId() : $movementOut->header->user_id)); ?>
                            <?php echo $movementOut->header->isNewRecord ? CHtml::encode(Yii::app()->user->getName()) : $movementOut->header->user->username; ?>
                            <?php echo $form->error($movementOut->header, 'user_id'); ?>
                        </div>
                    </div>
                </div>		
            </div>
        </div>
        
        <fieldset>
            <legend>Detail</legend>

            <br />
            
            <div class="row">
                <div class="large-12 columns">
                    <div class="detail" id="detail_div">
                        <?php $this->renderPartial('_detail', array(
                            'movementOut' => $movementOut,
                            'warehouses' => $warehouses,
                        )); ?>
                    </div>
                </div>	
            </div>
        </fieldset>
        
        <div class="field buttons text-center">
            <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
            <?php echo CHtml::submitButton($movementOut->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'id' => 'save', 'confirm' => 'Are you sure you want to save?')); ?>
        </div>
        <?php echo IdempotentManager::generate(); ?>

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
//    if ($("#MovementOutHeader_movement_type").val() == "1") {
//        $("#deliveryOrder").show();
//        $("#returnOrder").hide();
//        $("#retailSales").hide();
//        $("#materialRequest").hide();
//    } else if ($("#MovementOutHeader_movement_type").val() == "2") {
//        $("#deliveryOrder").hide();
//        $("#returnOrder").show();
//        $("#retailSales").hide();
//        $("#materialRequest").hide();
//    } else if ($("#MovementOutHeader_movement_type").val() == "3") {
//        $("#deliveryOrder").hide();
//        $("#returnOrder").hide();
//        $("#retailSales").show();
//        $("#materialRequest").hide();
//    } else if ($("#MovementOutHeader_movement_type").val() == "4") {
//        $("#deliveryOrder").hide();
//        $("#returnOrder").hide();
//        $("#retailSales").hide();
//        $("#materialRequest").show();
//    } else {
//        $("#deliveryOrder").hide();
//        $("#returnOrder").hide();
//        $("#retailSales").hide();
//        $("#materialRequest").hide();
//    }
//    $("#MovementOutHeader_movement_type").change(function() {
//    //ClearFields();
//        $("#MovementOutHeader_delivery_order_id").val("");
//        $("#MovementOutHeader_delivery_order_number").val("");
//        $("#MovementOutHeader_reference_type").val("");
//        $("#MovementOutHeader_reference_number").val("");
//        $("#MovementOutHeader_return_order_id").val("");
//        $("#MovementOutHeader_return_order_number").val("");
//        $("#MovementOutHeader_registration_transaction_id").val("");
//        $("#MovementOutHeader_transaction_number").val("");
//        $("#MovementOutHeader_material_request_id").val("");
//        
//        if ($("#MovementOutHeader_movement_type").val() == "1") {
//            $("#deliveryOrder").show();
//            $("#returnOrder").hide();
//            $("#retailSales").hide();
//            $("#materialRequest").hide();
//        } else if ($("#MovementOutHeader_movement_type").val() == "2") {
//            $("#deliveryOrder").hide();
//            $("#returnOrder").show();
//            $("#retailSales").hide();
//            $("#materialRequest").hide();
//        } else if ($("#MovementOutHeader_movement_type").val() == "3") {
//            $("#deliveryOrder").hide();
//            $("#returnOrder").hide();
//            $("#retailSales").show();
//            $("#materialRequest").hide();
//        } else if ($("#MovementOutHeader_movement_type").val() == "4") {
//            $("#deliveryOrder").hide();
//            $("#returnOrder").hide();
//            $("#retailSales").hide();
//            $("#materialRequest").show();
//        } else {
//            $("#deliveryOrder").hide();
//            $("#returnOrder").hide();
//            $("#retailSales").hide();
//            $("#materialRequest").hide();
//        }
//    });
</script>