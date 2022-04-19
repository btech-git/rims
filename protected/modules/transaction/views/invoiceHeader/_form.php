<?php
/* @var $this InvoiceHeaderController */
/* @var $invoice->header InvoiceHeader */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'invoice-header-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($invoice->header); ?>

    <div class="row">
        <div class="small-12 medium-6 columns">
            <?php
            $invoiceAll = InvoiceHeader::model()->findAll();
            $count = count($invoiceAll) + 1;
            ?>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($invoice->header, 'invoice_number', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($invoice->header, 'invoice_number', array('value' => $invoice->header->isNewRecord ? 'INV_' . $count : $invoice->header->invoice_number, 'readonly' => true)); ?>
                        <?php echo $form->error($invoice->header, 'invoice_number'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($invoice->header, 'invoice_date', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($invoice->header, 'invoice_date', array('value' => $invoice->header->isNewRecord ? date('Y-m-d') : $invoice->header->invoice_date, 'readonly' => true)); ?>
                        <?php echo $form->error($invoice->header, 'invoice_date'); ?>
                    </div>
                </div>
            </div>		



            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($invoice->header, 'reference_type', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->hiddenField($invoice->header, 'reference_type', array('size' => 50, 'maxlength' => 50)); ?>
                        <?php echo $form->textField($invoice->header, 'reference_type_number', array('size' => 50, 'maxlength' => 50, 'value' => $invoice->header->reference_type == 1 ? 'Sales Order' : 'Retail Sales', 'readonly' => true)); ?>
                        <?php echo $form->error($invoice->header, 'reference_type'); ?>
                    </div>
                </div>
            </div>		

            <div id="salesOrder">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($invoice->header, 'sales_order_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($invoice->header, 'sales_order_id'); ?>
                            <?php echo $form->textField($invoice->header, 'sales_order_no', array('value' => $invoice->header->sales_order_id != Null ? $invoice->header->salesOrder->sale_order_no : '', 'readonly' => true)); ?>
                            <?php echo $form->error($invoice->header, 'sales_order_id'); ?>
                        </div>
                    </div>
                </div>	
            </div>

            <div id="retailSales">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($invoice->header, 'registration_transaction_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($invoice->header, 'registration_transaction_id', array('readonly' => true)); ?>
                            <?php echo $form->textField($invoice->header, 'registration_transaction_no', array('value' => $invoice->header->registration_transaction_id != Null ? $invoice->header->registrationTransaction->transaction_number : '', 'readonly' => true)); ?>
                            <?php echo $form->error($invoice->header, 'registration_transaction_id'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div id="customerData">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($invoice->header, 'customer_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($invoice->header, 'customer_id'); ?>
                            <?php echo $form->textField($invoice->header, 'customer_no', array('value' => $invoice->header->customer_id != Null ? $invoice->header->customer->name : '', 'readonly' => true)); ?>
                            <?php echo $form->error($invoice->header, 'customer_id'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div id="vehicleData">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($invoice->header, 'vehicle_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($invoice->header, 'vehicle_id'); ?>
                            <?php echo $form->textField($invoice->header, 'plate_number', array('value' => $invoice->header->vehicle_id != Null ? $invoice->header->vehicle->plate_number : '', 'readonly' => true)); ?>
                            <?php echo $form->error($invoice->header, 'vehicle_id'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($invoice->header, 'due_date', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($invoice->header, 'due_date', array('readonly' => true)); ?>
                        <?php echo $form->error($invoice->header, 'due_date'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($invoice->header, 'branch_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->hiddenField($invoice->header, 'branch_id', array('readonly' => true)); ?>
                        <?php echo CHtml::encode(CHtml::value($invoice->header, 'branch.name')); ?>
                        <?php echo $form->error($invoice->header, 'branch_id'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($invoice->header, 'user_id', array('class' => 'prefix')); ?>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textField($invoice->header, 'user_id', array('value' => Yii::app()->user->getName(), 'readonly' => true)); ?>
                        <?php echo $form->error($invoice->header, 'user_id'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($invoice->header, 'status', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($invoice->header, 'status', array('size' => 30, 'maxlength' => 30, 'value' => $invoice->header->isNewRecord ? 'NOT PAID' : $invoice->header->status, 'readonly' => true)); ?>
                        <?php echo $form->error($invoice->header, 'status'); ?>
                    </div>
                </div>
            </div>		
        </div> <!-- close for <div class="small-12 medium-6 columns"> -->
    </div><!-- close for <div class="row"> -->

    <div class="row">
        <div class="large-12 columns">
            <fieldset>
                <legend>Details</legend>

                <div class="row">
                    <div class="large-12 columns">
                        <div class="detail" id="detail">
                            <?php $this->renderPartial('_detail', array('invoice' => $invoice)); ?>
                        </div>
                    </div>	
                </div>
            </fieldset>
        </div>
    </div>

    <div class="row">
        <div class="small-12 medium-6 columns">

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($invoice->header, 'service_price', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->hiddenField($invoice->header, 'total_service', array('size' => 18, 'maxlength' => 18, 'readonly' => true)); ?>
                        <?php echo $form->textField($invoice->header, 'service_price', array('size' => 18, 'maxlength' => 18, 'readonly' => true, 'class' => 'numbers')); ?>
                        <?php echo $form->error($invoice->header, 'service_price'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($invoice->header, 'product_price', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->hiddenField($invoice->header, 'total_product', array('size' => 18, 'maxlength' => 18, 'readonly' => true)); ?>
                        <?php echo $form->textField($invoice->header, 'product_price', array('size' => 18, 'maxlength' => 18, 'readonly' => true, 'class' => 'numbers')); ?>
                        <?php echo $form->error($invoice->header, 'product_price'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($invoice->header, 'quick_service_price', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->hiddenField($invoice->header, 'total_quick_service', array('size' => 18, 'maxlength' => 18, 'readonly' => true)); ?>
                        <?php echo $form->textField($invoice->header, 'quick_service_price', array('size' => 18, 'maxlength' => 18, 'readonly' => true, 'class' => 'numbers')); ?>
                        <?php echo $form->error($invoice->header, 'quick_service_price'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label for="" class="prefix">PPN <?php echo CHtml::encode(CHtml::value($invoice->header, 'tax_percentage')); ?>%</label>
                        <?php //echo $form->labelEx($invoice->header,'ppn_total',array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-1 columns">
                        <?php echo CHtml::activeCheckBox($invoice->header, 'ppn', array(
                            1 => 1, 
                            'rel' => 0, 
                            'onchange' => '
                                var service = +$("#InvoiceHeader_service_price").val();
                                var product = +$("#InvoiceHeader_product_price").val();
                                var quickService = +$("#InvoiceHeader_quick_service_price").val();
                                var pph = +$("#InvoiceHeader_pph_total").val();
                                var newTotal = service + product + quickService;
                                if ($("#InvoiceHeader_ppn").is(":checked"))
                                {
                                    //$("#InvoiceHeader_total_price").attr("rel",$("#InvoiceHeader_total_price").val());

                                    var totalwithppn = newTotal * 0.10;
                                    if ($("#InvoiceHeader_pph").is(":checked")){
                                        var total = newTotal + pph;
                                        var grand = total + totalwithppn;
                                    } else {
                                        var grand = newTotal + totalwithppn;
                                    }

                                    $("#InvoiceHeader_ppn").attr("rel",totalwithppn);
                                    $("#InvoiceHeader_ppn_total").val(totalwithppn);
                                    $("#InvoiceHeader_total_price").attr("ppn",grand);
                                    $("#InvoiceHeader_total_price").val(grand);
                                    //console.log(totalwithppn);
                                } else {
                                    $("#InvoiceHeader_ppn").attr("rel","");
                                    $("#InvoiceHeader_ppn_total").val("");

                                    if ($("#InvoiceHeader_pph").is(":checked")){
                                        //var newTotalValue = +$("#InvoiceHeader_total_price").attr("rel");
                                        var countTotal = newTotal + pph;
                                        $("#InvoiceHeader_total_price").val(countTotal);
                                    } else {
                                        $("#InvoiceHeader_total_price").val(newTotal);
                                    }
                                    //$("#InvoiceHeader_total_price").val($("#InvoiceHeader_total_price").attr("rel"));
                                }
                            '
                        )); ?>
                    </div>
                    <div class="small-7 columns">
                        <?php echo $form->textField($invoice->header, 'ppn_total', array('size' => 18, 'maxlength' => 18, 'readonly' => true, 'class' => 'numbers')); ?>
                        <?php echo $form->error($invoice->header, 'ppn_total'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label for="" class="prefix">PPH (2%)</label>
                        <?php //echo $form->labelEx($invoice->header,'pph_total',array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-1 columns">
                        <?php echo CHtml::activeCheckBox($invoice->header, 'pph', array(
                            1 => 1, 
                            'onchange' => '
                                var service = +$("#InvoiceHeader_service_price").val();
                                var product = +$("#InvoiceHeader_product_price").val();
                                var quickService = +$("#InvoiceHeader_quick_service_price").val();
                                var ppn = +$("#InvoiceHeader_ppn_total").val();
                                var newTotal = service + product + quickService;
                                if ($("#InvoiceHeader_pph").is(":checked")) {
                                    //var total = +$("#InvoiceHeader_total_price").attr("rel");
                                    var totalwithpph = newTotal * 0.02;

                                    if ($("#InvoiceHeader_ppn").is(":checked")) {
                                        var total = newTotal + ppn;
                                        var grand = total + totalwithpph;
                                    } else {
                                        var grand = newTotal + totalwithpph;
                                    }
                                    $("#InvoiceHeader_pph_total").val(totalwithpph);

                                    $("#InvoiceHeader_total_price").val(grand);
                                    //console.log(totalwithpph);

                                } else {
                                    $("#InvoiceHeader_pph").attr("rel","");
                                    $("#InvoiceHeader_pph_total").val("");
                                    if ($("#InvoiceHeader_ppn").is(":checked")) {
                                        var countTotal = newTotal + ppn;
                                        $("#InvoiceHeader_total_price").val(countTotal);
                                    } else {
                                        $("#InvoiceHeader_total_price").val(newTotal);
                                    }
                                }
                            '
                        )); ?>
                    </div>
                    <div class="small-7 columns">
                        <?php echo $form->textField($invoice->header, 'pph_total', array('class' => 'numbers', 'size' => 18, 'maxlength' => 18, 'readonly' => true)); ?>
                        <?php echo $form->error($invoice->header, 'pph_total'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($invoice->header, 'total_price', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($invoice->header, 'total_price', array('class' => 'numbers', 'size' => 18, 'maxlength' => 18, 'readonly' => true, 'rel' => $invoice->header->total_price)); ?>
                        <?php echo $form->error($invoice->header, 'total_price'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($invoice->header, 'in_words', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textArea($invoice->header, 'in_words', array('rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($invoice->header, 'in_words'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($invoice->header, 'note', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textArea($invoice->header, 'note', array('rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($invoice->header, 'note'); ?>
                    </div>
                </div>
            </div>		

            <div class="field buttons text-center">
                <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                <?php echo CHtml::submitButton($invoice->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
            </div>
        </div> <!-- close for <div class="small-12 medium-6 columns"> after detail -->
    </div> <!-- close for <div class="row"> after detail -->

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
    var totalService = $("#InvoiceHeader_total_service").val();
    var totalQuickService = $("#InvoiceHeader_total_quick_service").val();
    if (totalService == 0 && totalQuickService == 0) {
        $("#InvoiceHeader_pph").prop("disabled", true);
    }
    if ($("#InvoiceHeader_reference_type").val() == "1") {
        $("#salesOrder").show();
        $("#retailSales").hide();
        $("#customerData").show();
        $("#vehicleData").hide();
    } else if ($("#InvoiceHeader_reference_type").val() == "2") {
        $("#salesOrder").hide();
        $("#retailSales").show();
        $("#customerData").hide();
        $("#vehicleData").show();
    } else {
        $("#salesOrder").hide();
        $("#retailSales").hide();
        $("#customerData").hide();
        $("#vehicleData").hide();
    }
    $("#InvoiceHeader_reference_type").change(function () {
        //ClearFields();

        if ($("#InvoiceHeader_reference_type").val() == "1") {
            $("#salesOrder").show();
            $("#retailSales").hide();
            $("#customerData").show();
            $("#vehicleData").hide();
        } else if ($("#InvoiceHeader_reference_type").val() == "2") {
            $("#salesOrder").hide();
            $("#retailSales").show();
            $("#customerData").hide();
            $("#vehicleData").show();
        } else {
            $("#salesOrder").hide();
            $("#retailSales").hide();
            $("#customerData").hide();
            $("#vehicleData").hide();
        }
    });
</script>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('myjavascript', '
		$(".numbers").number( true,2, ".", ",");
    ', CClientScript::POS_END);
?>