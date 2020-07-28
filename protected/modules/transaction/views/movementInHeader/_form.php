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

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'movement-in-header-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => false,
                ));
        ?>


        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($movementIn->header); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementIn->header, 'movement_in_number', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($movementIn->header, 'movement_in_number', array('size' => 30, 'maxlength' => 30, 'readonly' => true)); ?>
                            <?php echo $form->error($movementIn->header, 'movement_in_number'); ?>
                        </div>
                    </div>
                </div>		

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementIn->header, 'date_posting', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($movementIn->header, 'date_posting', array('value' => date('Y-m-d'), 'readonly' => true,)); ?>
                            <?php /* $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                              'model' => $movementIn->header,
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
                            <?php echo $form->error($movementIn->header, 'date_posting'); ?>
                        </div>
                    </div>
                </div>		

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementIn->header, 'movement_type', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownList($movementIn->header, 'movement_type', array('1' => 'Receive Item', '2' => 'Return Item'), array('prompt' => '[--Select Movement Type--]', 'onchange' => '
                                $.ajax({
                                    type: "POST",
                                    //dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxHtmlRemoveDetailAll', array('id' => $movementIn->header->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(html) {
                                        $("#mmtype").html(html);	
                                    },
                                });
                            ')); ?>
                            <?php echo $form->error($movementIn->header, 'movement_type'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementIn->header, 'branch_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownlist($movementIn->header, 'branch_id', CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')), 'id', 'name'), array('prompt' => '[--Select Branch--]', 'onchange' => '
                                //$("#receive-item-grid .filters input[name=\"TransactionReceiveItem[branch_name]\"]").prop("readOnly","readOnly");
                                $.updateGridView("receive-item-grid", "TransactionReceiveItem[branch_name]", $("#MovementInHeader_branch_id option:selected").text());
                                $.updateGridView("return-item-grid", "TransactionReturnItem[branch_name]", $("#MovementInHeader_branch_id option:selected").text());
                                $.ajax({
                                    type: "POST",
                                    //dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxHtmlRemoveDetailAll', array('id' => $movementIn->header->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(html) {
                                        $("#mmtype").html(html);	
                                    },
                                });
                                $("#MovementInHeader_receive_item_id").val("");
                                $("#MovementInHeader_receive_item_number").val("");
                                $("#MovementInHeader_reference_type").val("");
                                $("#MovementInHeader_reference_number").val("");
                                $("#MovementInHeader_return_item_id").val("");
                                $("#MovementInHeader_return_item_number").val("");
                            ')); ?>
                            <?php echo $form->error($movementIn->header, 'branch_id'); ?>
                        </div>
                    </div>
                </div>		
            </div>
            <div class="small-12 medium-6 columns">
                <div id="receiveItem">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($movementIn->header, 'receive_item_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($movementIn->header, 'receive_item_id'); ?>
                                <?php echo $form->textField($movementIn->header, 'receive_item_number', array('value' => $movementIn->header->receive_item_id == "" ? "" : TransactionReceiveItem::model()->findByPk($movementIn->header->receive_item_id)->receive_item_no, 'readonly' => true, 'onclick' => '
                                    var branch = $("#MovementInHeader_branch_id").val();
                                    // var receive_item_number_val = $("#MovementInHeader_receive_item_number").val();
                                    // alert (receive_item_number_val);
                                    if(branch == ""){
                                        alert("Please Choose Branch to Proceed!");
                                    }else{
                                        $("[name=\"TransactionReceiveItem[branch_name]\"]").val($("#MovementInHeader_branch_id option:selected").text());
                                        $("[name=\"TransactionReceiveItem[branch_name]\"]").attr("readonly", "readonly");
                                        $("#receive-item-dialog").dialog("open"); return false;
                                    }
                                ')); ?>
                                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                    'id' => 'receive-item-dialog',
                                    // additional javascript options for the dialog plugin
                                    'options' => array(
                                        'title' => 'Receive Item',
                                        'autoOpen' => false,
                                        'width' => 'auto',
                                        'modal' => true,
                                    ),
                                )); ?>

                                <?php $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'receive-item-grid',
                                    'dataProvider' => $receiveItemDataProvider,
                                    'filter' => $receiveItem,
                                    'selectionChanged' => 'js:function(id){
                                    $("#MovementInHeader_receive_item_id").val($.fn.yiiGridView.getSelection(id));
                                    $("#receive-item-dialog").dialog("close");
                                    $.ajax({
                                        type: "POST",
                                        dataType: "JSON",
                                        url: "' . CController::createUrl('ajaxReceive', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                                        data: $("form").serialize(),
                                        success: function(data) {
                                            $("#MovementInHeader_receive_item_number").val(data.number);
                                            $("#MovementInHeader_reference_type").val(data.type);
                                            $("#MovementInHeader_reference_number").val(data.requestNumber);
                                             $.updateGridView("receive-item-detail-grid", "TransactionReceiveItemDetail[receive_item_no]", data.number);
                                             $.ajax({
                                                type: "POST",
                                                //dataType: "JSON",
                                                url: "' . CController::createUrl('ajaxHtmlRemoveDetailAll', array('id' => $movementIn->header->id)) . '",
                                                data: $("form").serialize(),
                                                success: function(html) {
                                                    $(".detail").html(html);	
                                                },
                                            });
                                        },
                                    });

                                    $("#receive-item-grid").find("tr.selected").each(function(){
                                       $(this).removeClass( "selected" );
                                    });

                                }',
                                'columns' => array(
                                    'receive_item_no',
                                    'receive_item_date',
                                    array('header' => 'Supplier', 'value' => 'empty($data->supplier) ? "" : $data->supplier->name',),
                                    array('name' => 'branch_name', 'value' => '$data->recipientBranch->name',)
                                )
                            )); ?>
                            <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
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

                    //var_dump($type);
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
                <div id="returnItem">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($movementIn->header, 'return_item_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->hiddenField($movementIn->header, 'return_item_id'); ?>
                                <?php echo $form->textField($movementIn->header, 'return_item_number', array('value' => $movementIn->header->return_item_id == "" ? "" : TransactionReturnItem::model()->findByPk($movementIn->header->return_item_id)->return_item_no, 'readonly' => true, 'onclick' => '
                        var branch = $("#MovementInHeader_branch_id").val();
                        // var receive_item_number_val = $("#MovementInHeader_receive_item_number").val();
                        // alert (receive_item_number_val);
                        if(branch == ""){
                            alert("Please Choose Branch to Proceed!");
                        }else{
                            $("[name=\"TransactionReturnItem[branch_name]\"]").val($("#MovementInHeader_branch_id option:selected").text());
                            $("[name=\"TransactionReturnItem[branch_name]\"]").attr("readonly", "readonly");
                            $("#return-item-dialog").dialog("open"); return false;
                        }
                    ')); ?>
                                <?php
                                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                    'id' => 'return-item-dialog',
                                    // additional javascript options for the dialog plugin
                                    'options' => array(
                                        'title' => 'Return Item',
                                        'autoOpen' => false,
                                        'width' => 'auto',
                                        'modal' => true,
                                    ),
                                ));
                                ?>

                                <?php
                                $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'return-item-grid',
                                    'dataProvider' => $returnItemDataProvider,
                                    'filter' => $returnItem,
                                    'selectionChanged' => 'js:function(id){
							               	$("#MovementInHeader_return_item_id").val($.fn.yiiGridView.getSelection(id));
							                $("#return-item-dialog").dialog("close");
											$.ajax({
							                    type: "POST",
							                    dataType: "JSON",
							                    url: "' . CController::createUrl('ajaxReturn', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
							                    data: $("form").serialize(),
							                    success: function(data) {
							                        $("#MovementInHeader_return_item_number").val(data.number);
							                        $("#MovementInHeader_reference_type").val("Return Item");
							                        $("#MovementInHeader_reference_number").val(data.number);
							                         $.updateGridView("return-item-detail-grid", "TransactionReturnItemDetail[return_item_no]", data.number);
							                         $.ajax({
														type: "POST",
														//dataType: "JSON",
														url: "' . CController::createUrl('ajaxHtmlRemoveDetailAll', array('id' => $movementIn->header->id)) . '",
														data: $("form").serialize(),
														success: function(html) {
															$(".detail").html(html);	
															
														},
													});
							                    },
							                });

							              

							                $("#return-item-grid").find("tr.selected").each(function(){
							                   $(this).removeClass( "selected" );
							                });
											
							            }',
                                    'columns' => array(
                                        'return_item_no',
                                        array('name' => 'branch_name', 'value' => '$data->recipientBranch->name',))));
                                ?>
                                <?php Yii::app()->clientScript->registerScript('updateGridView', '
                                    $.updateGridView = function(gridID, name, value) {
                                        $("#"+gridID+" input[name=\""+name+"\"], #"+gridID+" select[name=\""+name+"\"]").val(value);
                                        $.fn.yiiGridView.update(gridID, {data: $.param(
                                            $("#"+gridID+" .filters input, #"+gridID+" .filters select")
                                        )});
                                    }
                                ', CClientScript::POS_READY); ?>
                                <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                            <?php echo $form->error($movementIn->header, 'return_item_id'); ?>
                            </div>
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

                <!-- <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
<?php //echo $form->labelEx($movementIn->header,'supervisor_id');  ?>
                        </div>
                        <div class="small-8 columns">
<?php //echo $form->textField($movementIn->header,'supervisor_id');  ?>
                            <?php //echo $form->error($movementIn->header,'supervisor_id');  ?>
                        </div>
                    </div>
                </div>	 -->	

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($movementIn->header, 'status', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
<?php //echo $form->textField($movementIn->header,'status');  ?>
                            <?php echo $form->textField($movementIn->header, 'status', array('value' => $movementIn->header->isNewRecord ? 'Draft' : $movementIn->header->status, 'readonly' => true));
/* if($movementIn->header->isNewRecord){
  echo $form->textField($movementIn->header,'status',array('value'=>'Draft','readonly'=>true));
  }else{
  echo $form->dropDownList($movementIn->header, 'status', array('Draft'=>'Draft','Revised' => 'Revised','Rejected'=>'Rejected','Approved'=>'Approved','Done'=>'Done'),array('prompt'=>'[--Select status Document--]'));
  }
 */
?>
                            <?php echo $form->error($movementIn->header, 'status'); ?>
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
                                var movement = $("#MovementInHeader_movement_type").val();
                                var branch = $("#MovementInHeader_branch_id").val();
                                var receive = $("#MovementInHeader_receive_item_id").val();
                                var return_value = $("#MovementInHeader_return_item_id").val();
                                var receive_val = $("#MovementInHeader_receive_item_number").val();
                                var return_val = $("#MovementInHeader_return_item_number").val();
                                //console.log(branch == "" && receive == "");
                                if(movement == 1){
                                    if(branch === "" || receive === ""){
                                        alert("Please Choose Branch and Receive item no to Proceed!");
                                    }else{
                                        $("[name=\"TransactionReceiveItemDetail[receive_item_no]\"]").val(receive_val);
                                        $("[name=\"TransactionReceiveItemDetail[receive_item_no]\"]").attr("readonly", "readonly");
                                        $("#receive-item-detail-dialog").dialog("open"); return false;
                                    }
                                }
                                else{
                                    //alert(return_value);
                                    if(branch === "" || return_value === ""){
                                        alert("Please Choose Branch and Return item no to Proceed!");
                                    }else{
                                        $("[name=\"TransactionReturnItemDetail[return_item_no]\"]").val(return_val);
                                        $("[name=\"TransactionReturnItemDetail[return_item_no]\"]").attr("readonly", "readonly");
                                        $("#return-item-detail-dialog").dialog("open"); return false;
                                    }
                                }
                            ',
                        )); ?>
                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id' => 'receive-item-detail-dialog',
                            // additional javascript options for the dialog plugin
                            'options' => array(
                                'title' => 'Receive Item',
                                'autoOpen' => false,
                                'width' => 'auto',
                                'modal' => true,
                            ),
                        )); ?>

                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'receive-item-detail-grid',
                            'dataProvider' => $receiveItemDetailDataProvider,
                            'filter' => $receiveItemDetail,
                            'selectionChanged' => 'js:function(id){
                                $("#receive-item-detail-dialog").dialog("close");
                                $.ajax({
                                    type: "POST",
                                    url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $movementIn->header->id, 'detailId' => '')) . '"  + $.fn.yiiGridView.getSelection(id)+"&type="+1,
                                    data: $("form").serialize(),
                                    success: function(html) {
                                        $("#mmtype").attr("data-mmtype","mmtype_receive"); 
                                        $("#mmtype").html(html);

                                    },
                                });

                                $("#receive-item-detail-grid").find("tr.selected").each(function(){
                                   $(this).removeClass( "selected" );
                                });
                            }',
                            'rowCssClassExpression' => '"row_".$data->product_id',
                            'columns' => array(
                                //'jenis_persediaan_id',
                                array('name' => 'receive_item_no', 'value' => '$data->receiveItem->receive_item_no'),
                                array('header' => 'Product', 'value' => '$data->product->name'),
                                array(
                                    'header' => 'Quantity',
                                    'value' => '$data->qty_received.CHTML::hiddenField("qtysum_mmtype_receive".$data->product_id,\'0\',array(\'width\'=>20,\'maxlength\'=>3)).CHTML::hiddenField("qtyleft_mmtype_receive".$data->product_id,$data->qty_received,array(\'width\'=>20,\'maxlength\'=>3))',
                                    'type' => 'raw',
                                    'filter' => false
                                ),
                                'quantity_movement_left',
                            //'nama',
                            //'order_pembelian_id',
                            ),
                        )); ?>

                        <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

                        <!--Return Item Detail Dialog -->
                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id' => 'return-item-detail-dialog',
                            // additional javascript options for the dialog plugin
                            'options' => array(
                                'title' => 'Return Item',
                                'autoOpen' => false,
                                'width' => 'auto',
                                'modal' => true,
                            ),
                        )); ?>

                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'return-item-detail-grid',
                            'dataProvider' => $returnItemDetailDataProvider,
                            'filter' => $returnItemDetail,
                            'selectionChanged' => 'js:function(id){
                                $("#return-item-detail-dialog").dialog("close");
                                $.ajax({
                                    type: "POST",
                                    url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $movementIn->header->id, 'detailId' => '')) . '"  + $.fn.yiiGridView.getSelection(id)+"&type="+2,
                                    data: $("form").serialize(),
                                    success: function(html) {
                                        $("#mmtype").attr("data-mmtype","mmtype_return"); 
                                        $("#mmtype").html(html);
                                    },
                                });

                                $("#return-item-detail-grid").find("tr.selected").each(function(){
                                   $(this).removeClass( "selected" );
                                });
                            }',
                            'rowCssClassExpression' => '"row_".$data->product_id',
                            'columns' => array(
                                //'jenis_persediaan_id',
                                array('name' => 'return_item_no', 'value' => '$data->returnItem->return_item_no'),
                                array('header' => 'Product', 'value' => '$data->product->name'),
                                array(
                                    'header' => 'Quantity',
                                    'value' => '$data->quantity_delivery.CHTML::hiddenField("qtysum_mmtype_return".$data->product_id,\'0\',array(\'width\'=>20,\'maxlength\'=>3)).CHTML::hiddenField("qtyleft_mmtype_return".$data->product_id,$data->quantity_delivery,array(\'width\'=>20,\'maxlength\'=>3))',
                                    'type' => 'raw',
                                    'filter' => false
                                ),
                            ),
                        )); ?>

                        <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                        <!-- Refresh grid with value from kode kelompok persediaan-->

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
                        <?php $this->renderPartial('_detail', array('movementIn' => $movementIn)); ?>
                    </div>
                </div>	
            </div>
        </fieldset>
        
        <div class="field buttons text-center">
            <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
            <?php echo CHtml::submitButton($movementIn->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
        </div>

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
        if($("#MovementInHeader_movement_type").val() == "1") {
        $("#receiveItem").show();
        $("#returnItem").hide();
        } else if($("#MovementInHeader_movement_type").val() == "2") {
        $("#returnItem").show();
        $("#receiveItem").hide();
        } 
        else{
        $("#receiveItem").hide();
        $("#returnItem").hide();
        }
        $("#MovementInHeader_movement_type").change(function(){
        //ClearFields();
        $("#MovementInHeader_receive_item_id").val("");
        $("#MovementInHeader_receive_item_number").val("");
        $("#MovementInHeader_reference_type").val("");
        $("#MovementInHeader_reference_number").val("");
        $("#MovementInHeader_return_item_id").val("");
        $("#MovementInHeader_return_item_number").val("");
        if($("#MovementInHeader_movement_type").val() == "1") {
        $("#receiveItem").show();
        $("#returnItem").hide();
        } else if($("#MovementInHeader_movement_type").val() == "2") {
        $("#returnItem").show();
        $("#receiveItem").hide();
        } 
        else{
        $("#receiveItem").hide();
        $("#returnItem").hide();
        }
        });
    </script>