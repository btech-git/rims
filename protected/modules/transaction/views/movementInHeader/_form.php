<?php
/* @var $this MovementInHeaderController */
/* @var $movementIn->header MovementInHeader */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
    <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Movement In', Yii::app()->baseUrl . '/transaction/movementInHeader/admin', array('class' => 'button cbutton right', 'visible' => Yii::app()->user->checkAccess("transaction.movementInHeader.admin"))) ?>
    <h1><?php if ($movementIn->header->id == "") {
        echo "New Movement In Header ";
    } else {
        echo "Update Movement In Header ";
    } ?></h1>

    <div class="form">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'movement-in-header-form',
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => false,
        )); ?>


        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($movementIn->header); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementIn->header, 'date_posting', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $movementIn->header,
                                'attribute' => "date_posting",
                                'options' => array(
                                    'minDate' => '-1W',
                                    'maxDate' => '+6M',
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
                            <?php echo $form->error($movementIn->header, 'date_posting'); ?>
                        </div>
                    </div>
                </div>		

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementIn->header, 'branch_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($movementIn->header, 'branch_id'); ?>
                            <?php echo CHtml::encode(CHtml::value($movementIn->header, 'branch.name')); ?>
                            <?php /*echo $form->dropDownlist($movementIn->header, 'branch_id', CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')), 'id', 'name'), array(
                                'prompt' => '[--Select Branch--]', 
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('ajaxHtmlUpdateAllWarehouse', array('id' => $movementIn->header->id)),
                                    'update' => '#detail_div',
                                )),
                            ));*/ ?>
                            <?php echo $form->error($movementIn->header, 'branch_id'); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementIn->header, 'user_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($movementIn->header, 'user_id', array('readonly' => true, 'value' => $movementIn->header->isNewRecord ? Yii::app()->user->getId() : $movementIn->header->user_id)); ?>
                            <?php echo $form->textField($movementIn->header, 'user_name', array('size' => 30, 'maxlength' => 30, 'value' => $movementIn->header->isNewRecord ? Yii::app()->user->getName() : $movementIn->header->user->username, 'readonly' => true)); ?>
                            <?php echo $form->error($movementIn->header, 'user_id'); ?> 
                        </div>
                    </div>
                </div>		

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementIn->header, 'status', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($movementIn->header, 'status', array('value' => $movementIn->header->isNewRecord ? 'Draft' : $movementIn->header->status, 'readonly' => true)); ?>
                            <?php echo $form->error($movementIn->header, 'status'); ?>
                        </div>
                    </div>
                </div>				
            </div>
            
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementIn->header, 'movement_type', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode($movementIn->header->getMovementType($movementIn->header->movement_type)); ?>
                            <?php echo $form->error($movementIn->header, 'movement_type'); ?>
                        </div>
                    </div>
                </div>

                <?php if (!empty($movementIn->header->receive_item_id)): ?>
                    <div id="receiveItem">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <?php echo $form->labelEx($movementIn->header, 'receive_item_id', array('class' => 'prefix')); ?>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo $form->hiddenField($movementIn->header, 'receive_item_id'); ?>
                                    <?php echo $form->textField($movementIn->header, 'receive_item_number', array('value' => $movementIn->header->receive_item_id == "" ? "" : TransactionReceiveItem::model()->findByPk($movementIn->header->receive_item_id)->receive_item_no, 'readonly' => true, )); ?>
                                    <?php echo $form->error($movementIn->header, 'receive_item_id'); ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $type = $requestNumber = "";
                        $receive = TransactionReceiveItem::model()->findByPk($movementIn->header->receive_item_id);
                        if (!empty($receive)) {
                            if ($receive->request_type == "Internal Delivery Order") {
                                $type = "Internal Delivery Order";
                                $requestNumber = $receive->deliveryOrder->delivery_order_no;
                            } elseif ($receive->request_type == "Purchase Order") {
                                $type = "Purchase Order";
                                $requestNumber = $receive->purchaseOrder->purchase_order_no;
                            } elseif ($receive->request_type == "Consignment In") {
                                $type = "Consignment In";
                                $requestNumber = $receive->consignmentIn->consignment_in_number;
                            }
                        }

                        ?>
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label>Reference Type</label>
                                </div>
                                <div class="small-8 columns">
                                    <input id="MovementInHeader_reference_type" readonly="readonly" name="MovementInHeader[reference_type]" type="text" value="<?php echo $movementIn->header->receive_item_id == "" ? "" : $type; ?>">
                                </div>
                            </div>
                        </div>


                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label>Reference #</label>
                                </div>
                                <div class="small-8 columns">
                                    <input id="MovementInHeader_reference_number" readonly="readonly" name="MovementInHeader[reference_number]" type="text" value="<?php echo $movementIn->header->receive_item_id == "" ? "" : $requestNumber; ?>">
                                </div>
                            </div>
                        </div>		
                    </div>
                <?php elseif (!empty($movementIn->header->return_item_id)): ?>
                    <div id="returnItem">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <?php echo $form->labelEx($movementIn->header, 'return_item_id', array('class' => 'prefix')); ?>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo $form->hiddenField($movementIn->header, 'return_item_id'); ?>
                                    <?php echo $form->textField($movementIn->header, 'return_item_number', array('value' => $movementIn->header->return_item_id == "" ? "" : TransactionReturnItem::model()->findByPk($movementIn->header->return_item_id)->return_item_no, 'readonly' => true,)); ?>
                                    <?php echo $form->error($movementIn->header, 'return_item_id'); ?>
                                </div>
                            </div>
                        </div>	
                    </div>
                <?php else: ?>
                    <div id="emptyItem">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">&nbsp;</div>
                                <div class="small-8 columns">&nbsp;</div>
                            </div>
                        </div>	
                    </div>
                <?php endif; ?>

            </div>
        </div>
        <fieldset>
            <legend>Detail</legend>

            <br />
            
            <div class="row">
                <div class="large-12 columns">
                    <div class="detail" id="detail_div">
                        <?php $this->renderPartial('_detail', array(
                            'movementIn' => $movementIn,
//                            'warehouses' => $warehouses,
                        )); ?>
                    </div>
                </div>	
            </div>
        </fieldset>
        
        <div class="field buttons text-center">
            <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
            <?php echo CHtml::submitButton($movementIn->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'id' => 'save', 'confirm' => 'Are you sure you want to save?')); ?>
        </div>
    <?php echo IdempotentManager::generate(); ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
    $(document).on("change", ".qtyleft_input", function() {
        var sum = 0;
        var thisted = $(this).attr('rel');
        var mmtype =  $("#mmtype").attr('data-mmtype'); //$(this).attr('data-mm');
        // console.log("ini mmtype: "+mmtype);
        // console.log("ini rel thisted: "+thisted);
        $(".productID_"+thisted).each(function(){
            sum += +$(this).val();
        });
        // $(".qtyleft_"+thisted).val(sum);
        $("#qtysum_"+mmtype+thisted).val(sum);
        var nilaiawal = $("#qtyleft_"+mmtype+thisted).val();
        // console.log("ini nilai awal: "+ nilaiawal);
        // console.log("ini sum: "+sum);
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
    
//    if ($("#MovementInHeader_movement_type").val() == "1") {
//        $("#receiveItem").show();
//        $("#returnItem").hide();
//    } else if ($("#MovementInHeader_movement_type").val() == "2") {
//        $("#returnItem").show();
//        $("#receiveItem").hide();
//    } else {
//        $("#receiveItem").hide();
//        $("#returnItem").hide();
//    }
//    
//    $("#MovementInHeader_movement_type").change(function(){
//        //ClearFields();
//        $("#MovementInHeader_receive_item_id").val("");
//        $("#MovementInHeader_receive_item_number").val("");
//        $("#MovementInHeader_reference_type").val("");
//        $("#MovementInHeader_reference_number").val("");
//        $("#MovementInHeader_return_item_id").val("");
//        $("#MovementInHeader_return_item_number").val("");
//        if ($("#MovementInHeader_movement_type").val() == "1") {
//            $("#receiveItem").show();
//            $("#returnItem").hide();
//        } else if ($("#MovementInHeader_movement_type").val() == "2") {
//            $("#returnItem").show();
//            $("#receiveItem").hide();
//        } else {
//            $("#receiveItem").hide();
//            $("#returnItem").hide();
//        }
//    });
</script>