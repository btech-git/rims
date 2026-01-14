<?php
/* @var $this PaymentInController */
/* @var $model PaymentIn */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'payment-in-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>
    
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'payment_date'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php //echo $form->textField($model, 'payment_date', array('value' => date('Y-m-d'), 'readonly' => true,)); ?>
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $model,
                            'attribute' => "payment_date",
                            'options'=>array(
                                'minDate' => '-8W',
                                'maxDate' => '+6M',
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth'=>true,
                                'changeYear'=>true,
//                                'yearRange'=>'1900:2020'
                            ),
                            'htmlOptions'=>array(
                                'readonly' => true,
                            ),
                        )); ?>
                        <?php echo $form->error($model, 'payment_date'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'payment_type_id'); ?>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownlist($model, 'payment_type_id', CHtml::listData(PaymentType::model()->findAll(), 'id', 'name'), array(
                            'prompt' => '[--Select Payment Type--]',
                            'onchange' => '
                                if ($(this).val() == 6) {
                                    $("#' . CHtml::activeId($model, 'nomor_giro') . '").prop("readonly", false);
                                    $("#' . CHtml::activeId($model, 'bank_id') . '").prop("readonly", true);
                                } else {
                                    $("#' . CHtml::activeId($model, 'nomor_giro') . '").prop("readonly", true);
                                    $("#' . CHtml::activeId($model, 'bank_id') . '").prop("readonly", false);
                                }
                            '
                        )); ?>
                        <?php echo $form->error($model, 'payment_type_id'); ?>
                    </div>
                </div>
            </div>

<!--            <div class="giro">-->
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'nomor_giro'); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeTextField($model, 'nomor_giro', array('maxlength' => 20, 'size' => 20)); ?>
                            <?php echo $form->error($model, 'nomor_giro'); ?>
                        </div>
                    </div>
                </div>
<!--            </div>-->

            <div class="cash">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'cash_payment_type'); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownlist($model, 'cash_payment_type', array(
                                '1' => 'Cash', 
                                '2' => 'Debit', 
                                '3' => 'Credit Card'
                            ), array(
                                'prompt' => '[--Select Cash Payment Type--]',
                                'onchange' => '
                                    $("#PaymentIn_bank_id").val("");
                                    if($(this).val() == "1") {
                                        $(".bank").hide();
                                    }
                                    else{
                                        $(".bank").show();
                                    }
                                '
                            )); ?>
                            <?php echo $form->error($model, 'cash_payment_type'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'user_id'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->hiddenField($model, 'user_id', array('value' => $model->isNewRecord ? Yii::app()->user->getId() : $model->user_id, 'readonly' => true)); ?>
                        <?php echo $form->textField($model, 'user.username', array(
                            'size' => 30, 
                            'maxlength' => 30, 
                            'value' => $model->isNewRecord ? Yii::app()->user->getName() : $model->user->username, 
                            'readonly' => true,
                        )); ?>
                        <?php echo $form->error($model, 'user_id'); ?>
                    </div>
                </div>
            </div>		
        </div>
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'status'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'status', array(
                            'value' => $model->isNewRecord ? 'Draft' : $model->status, 
                            'readonly' => true
                        )); ?>
                        <?php echo $form->error($model, 'status'); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'company_bank_id'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php
                        $branchId = $model->isNewRecord ? User::model()->findByPk(Yii::app()->user->getId())->branch_id : $model->branch_id;
                        $branch = Branch::model()->findByPk($branchId);
                        $company = Company::model()->findByPk($branch->company_id);
                        ?>
                        <?php echo $form->dropDownlist($model, 'company_bank_id', $company == NULL ? array() : CHtml::listData(CompanyBank::model()->findAllByAttributes(array('company_id' => $company->id), array('order' => 'account_name')), 'id', 'accountNameAndNumber'), array('prompt' => '[--Select Company Bank--]')); ?>
                        <?php echo $form->error($model, 'company_bank_id'); ?>
                    </div>
                </div>
            </div>			

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'invoice_id'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->hiddenField($model, 'invoice_id'); ?>
                        <?php echo $form->textField($model, 'invoice_number', array('readonly' => true)); ?> <?php //, 'onclick' => 'jQuery("#invoice-dialog").dialog("open"); return false;', 'value' => $model->invoice_id != "" ? InvoiceHeader::model()->findByPk($model->invoice_id)->invoice_number : '')) ?>
                        <?php echo $form->error($model, 'invoice_id'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="large-12 columns">
            <div class="detail">
                <fieldset>
                    <h1>Invoice Detail</h1>
                    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                        'tabs' => array(
                            'Invoice'=>array(
                                'id'=>'test1',
                                'content'=>$this->renderPartial('_viewInvoice',  array(
                                    'model'=>$model,
                                    'invoice' => $invoice,
                                ),TRUE)
                            ),
                            'Customer'=>array(
                                'id'=>'test2',
                                'content'=>$this->renderPartial('_viewCustomer', array(
                                    'model'=>$model,
                                    'form' => $form,
                                ),TRUE)
                            ),
                            'Vehicle'=>array(
                                'id'=>'test3',
                                'content'=>$this->renderPartial('_viewVehicle', array(
                                    'model'=>$model,
                                    'form' => $form,
                                ),TRUE)
                            ),
                        ),                       

                        // additional javascript options for the tabs plugin
                        'options' => array('collapsible' => true),
                        // set id for this widgets
                        'id'=>'view_tab',
                    )); ?>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'payment_amount'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'payment_amount', array(
                            'size' => 18, 
                            'maxlength' => 18, 
//                            'readonly' => $model->isNewRecord ? false : true,
                            'onchange' => '
                                var relCount = $("#PaymentIn_invoice_id").attr("rel");
                                var count = 0;
                                var paymentAmount = $("#PaymentIn_payment_amount").val();
                                var invoiceAmount = $("#Invoice_total_price").val();
                                var invoiceLeft = $("#Invoice_payment_left").val();
                                console.log(paymentAmount);
                                console.log(invoiceAmount);
                                console.log(invoiceLeft);
                                if (relCount == 1) {
                                    count = invoiceAmount - paymentAmount;
                                } else {
                                    count = invoiceLeft - paymentAmount;
                                }
                                if (count < 0) {
                                    alert("Payment Amount could not be higher than Invoice Amount");
                                    $("#PaymentIn_payment_amount").val("");
                                }
                            ' . CHtml::ajax(array(
                                'type'=>'POST',
                                'dataType'=>'JSON',
                                'url'=>CController::createUrl('ajaxJsonAmount', array('id' => $model->id)),
                                'success'=>'function(data) {
                                    $("#amount").html(data.amount);
                                    $("#tax_service_amount").html(data.taxServiceAmountFormatted);
                                    $("#' . CHtml::activeId($model, 'tax_service_amount') . '").val(data.taxServiceAmount);
                                }',
                            )),
                        )); ?>
                        <div id="amount" style="text-align: left; font-size: smaller; margin-left: 15px;">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'payment_amount'))); ?>
                        </div>
                        <?php echo $form->error($model, 'payment_amount'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'is_tax_service'); ?>
                    </div>
                    <div class="small-2 columns">
                        <?php echo $form->dropDownList($model, 'is_tax_service', array(
                            '3' => 'Include Pph',
                            '1' => 'Add Pph', 
                            '2' => 'Non Pph',
                        ), array(
                            'empty' => '-- Pilih Pph --',
                            'onchange' => '$.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonAmount', array('id' => $model->id, 'invoiceId' => $invoice->id)) . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#tax_service_amount").html(data.taxServiceAmountFormatted);
                                    $("#' . CHtml::activeId($model, 'tax_service_amount') . '").val(data.taxServiceAmount);
                                },
                            });'
                        )); ?>
                        <?php /*echo $form->checkBox($model, 'is_tax_service', array(
                            'onchange' => '$.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonAmount', array('id' => $model->id, 'invoiceId' => $invoice->id)) . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#tax_service_amount").html(data.taxServiceAmountFormatted);
                                    $("#' . CHtml::activeId($model, 'tax_service_amount') . '").val(data.taxServiceAmount);
                                },
                            });'
                        ));*/ ?>
                        <?php echo $form->error($model, 'is_tax_service'); ?>
                    </div>
                    <div class="small-6 columns">
                        <?php echo $form->textField($model, 'tax_service_amount'); ?>
                        <span id="tax_service_amount">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($model, 'tax_service_amount'))); ?>
                        </span>
                        <?php echo $form->error($model, 'tax_service_amount'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Attach Images (Upload size max 2MB)', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('CMultiFileUpload', array(
                            'model' => $model,
                            'attribute' => 'images',
                            'accept' => 'jpg|jpeg|png|gif',
                            'denied' => 'Only jpg, jpeg, png and gif are allowed',
                            'max' => 10,
                            'remove' => '[x]',
                            'duplicate' => 'Already Selected',
                            'options' => array(
                                'afterFileSelect' => 'function(e ,v ,m){
                                    var fileSize = e.files[0].size;
                                    if (fileSize > 2*1024*1024) {
                                        alert("Exceeds file upload limit 2MB");
                                        $(".MultiFile-remove").click();
                                    }                      
                                    return true;
                                }',
                            ),
                        )); ?>
                    </div>
                </div>
            </div>

            <div class="field buttons text-center">
                <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
            </div>
            
        </div>
        <div class="small-12 medium-6 columns">

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'notes'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textArea($model, 'notes', array('rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'notes'); ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <?php echo IdempotentManager::generate(); ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<script>
    if (jQuery("#PaymentIn_invoice_id").val()== "") {
    $(".detail").hide();
    // $("#invoice-Detail").hide();
    // $("#customer").hide();
    // $("#vehicle").hide();
    }
    if($("#PaymentIn_customer_id").val() != ""){
    $(".detail").show();
    $("#invoice-Detail").show();
    $("#customer").show();
    $("#vehicle").hide();
    }
    if($("#PaymentIn_vehicle_id").val() != ""){
    $(".detail").show();
    $("#invoice-Detail").show();
    $("#customer").show();
    $("#vehicle").show();
    }

    if ($("#PaymentIn_payment_type").val()== "Giro") {
    $(".giro").show();
    $(".cash").hide();
    //$(".bank").hide();
    if ($("#PaymentIn_cash_payment_type").val()== "1") {
    $(".bank").hide();
    }
    else
    $(".bank").show();

    }
    else if($("#PaymentIn_payment_type").val()== "Cash"){
    $(".giro").hide();
    $(".cash").show();
    //$(".bank").hide();
    if ($("#PaymentIn_cash_payment_type").val()== "Cash") {
    $(".bank").hide();
    }
    else
    $(".bank").show();

    }
    else{
    $(".giro").hide();
    $(".cash").hide();
    $(".bank").hide();
    }
    function clearAll(){
    $("#PaymentIn_cash_payment_type").val("");
    $("#PaymentIn_nomor_giro").val("");
    $("#PaymentIn_bank_id").val("");
    }
</script>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('myjavascript', '
		$(".numbers").number( true,2, ".", ",");
    ', CClientScript::POS_END);
?>