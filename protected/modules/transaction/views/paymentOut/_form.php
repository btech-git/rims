<?php
/* @var $this PaymentOutController */
/* @var $model PaymentOut */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'payment-out-form',
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
                        <?php echo $form->labelEx($model, 'payment_number'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'payment_number', array('size' => 50, 'maxlength' => 50, 'readonly' => true)); ?>
                        <?php echo $form->error($model, 'payment_number'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'payment_date'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'payment_date', array('value' => date('Y-m-d'), 'readonly' => true,)); ?>
                        <?php /* $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                          'model' => $model,
                          'attribute' => "payment_date",
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
                        <?php echo $form->error($model, 'payment_date'); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'payment_type'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownlist($model, 'payment_type_id', CHtml::listData(PaymentType::model()->findAll(), 'id', 'name'), array(
                            'prompt' => '[--Select Payment Type--]',
                            'onchange' => '
                                if ($(this).val() == 1) {
                                    $(".giro").hide();
                                    $(".bank").hide();
                                } else {
                                    $(".bank").show();
                                    $(".giro").show();
                                }
                            '
                        )); ?>
                        <?php echo $form->error($model, 'payment_type_id'); ?>
                    </div>
                </div>
            </div>

            <div class="giro">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'nomor_giro'); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'nomor_giro', array('maxlength' => 20, 'size' => 20)); ?>
                            <?php echo $form->error($model, 'nomor_giro'); ?>
                        </div>
                    </div>
                </div>
            </div>

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
                            ), array('prompt' => '[--Select Cash Payment Type--]',
                                'onchange' => '
                                $("#PaymentOut_bank_id").val("");
                                if($(this).val() == "1") {
                                    $(".bank").hide();
                                }
                                else{
                                    $(".bank").show();
                                }

                            ')); ?>
                            <?php echo $form->error($model, 'cash_payment_type'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bank">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'bank_id'); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownlist($model, 'bank_id', CHtml::listData(Bank::model()->findAll(), 'id', 'name'), array('prompt' => '[--Select Bank--]')); ?>
                            <?php echo $form->error($model, 'bank_id'); ?>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'status'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'status', array('value' => $model->isNewRecord ? 'Draft' : $model->status, 'readonly' => true)); ?>
                        <?php echo $form->error($model, 'status'); ?>
                    </div>
                </div>
            </div>	
        </div>
        
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'user_id'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->hiddenField($model, 'user_id', array('value' => $model->isNewRecord ? Yii::app()->user->getId() : $model->user_id, 'readonly' => true)); ?>
                        <?php echo $form->textField($model, 'user_name', array('size' => 30, 'maxlength' => 30, 'value' => Yii::app()->user->getName(), 'readonly' => true)); ?>
                        <?php echo $form->error($model, 'user_id'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'branch_id'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php //echo $form->textField($model,'branch_id',array('size'=>50,'maxlength'=>50)); ?>
                        <?php echo $form->dropDownlist($model, 'branch_id', CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')), 'id', 'name'), array('prompt' => '[--Select Branch--]',
                            'onchange' => 'jQuery.ajax({
                                type: "POST",
                                url: "' . CController::createUrl('ajaxGetCompanyBank') . '",
                                data: jQuery("form").serialize(),
                                success: function(data){
                                    console.log(data);
                                    jQuery("#PaymentOut_company_bank_id").html(data);
                                },
                            });'
                        )); ?>
                        <?php echo $form->error($model, 'branch_id'); ?>
                    </div>
                </div>
            </div>


            <div class="field" >
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
                        <?php echo $form->labelEx($model, 'purchase_order_id'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->hiddenField($model, 'purchase_order_id'); ?>
                        <?php echo $form->textField($model, 'purchase_order_number', array('readonly' => true, 'onclick' => 'jQuery("#purchase-order-dialog").dialog("open"); return false;', 'value' => $model->purchase_order_id != "" ? TransactionPurchaseOrder::model()->findByPk($model->purchase_order_id)->purchase_order_no : '')) ?>
                        <?php echo $form->error($model, 'purchase_order_id'); ?>
                    </div>
                </div>
            </div>	
        </div>
    </div>

    <div class="row">
        <div class="large-12 columns">
            <div class="detail">
                <fieldset>
                    <h1>Purchase Order Detail</h1>
                    <div id="purchase-order-detail">
                        <fieldset>
                            <legend>Purchase Order</legend>
                            <div class="large-6 columns">
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Purchase Date</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" id="Purchase_purchase_order_date" value="<?php echo $model->purchase_order_id != "" ? $model->purchaseOrder->purchase_order_date : '' ?>" > 
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Status</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" id="Purchase_status_document" value="<?php echo $model->purchase_order_id != "" ? $model->purchaseOrder->status_document : '' ?>"> 
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="large-6 columns">
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Total Price</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" id="Purchase_total_price" value="<?php echo $model->purchase_order_id != "" ? $model->purchaseOrder->total_price : '' ?>"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Payment Amount</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" id="Purchase_payment_amount" value="<?php echo $model->purchase_order_id != "" ? $model->purchaseOrder->payment_amount : '0,00' ?>"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Payment Left</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" id="Purchase_payment_left" value="<?php echo $model->purchase_order_id != "" ? $model->purchaseOrder->payment_left : '0,00' ?>"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div id="supplier">
                        <fieldset>
                            <legend>Supplier</legend>
                            <table>
                                <thead>
                                    <tr>
                                        <td>Company</td>
                                        <td>Nama</td>
                                        <td>Email</td>
                                        <td>Email Company</td>
                                        <td>Company Attribute</td>
                                        <td>Alamat</td>
                                        <td>Phone</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <?php echo $form->hiddenField($model, 'supplier_id', array('readonly' => true)); ?>
                                            <input type="text" readonly="true" id="Supplier_company" value="<?php echo $model->purchase_order_id != "" ? $model->purchaseOrder->supplier->company : '' ?>"> 
                                        </td>
                                        <td>
                                            <input type="text" readonly="true" id="Supplier_supplier_name" value="<?php echo $model->purchase_order_id != "" ? $model->purchaseOrder->supplier->name : '' ?>"> 
                                        </td>
                                        <td><input type="text" readonly="true" id="Supplier_email_personal" value="<?php echo $model->supplier_id != "" ? $model->supplier->email_personal : ''; ?>"></td>
                                        <td><input type="text" readonly="true" id="Supplier_email_company" value="<?php echo $model->purchase_order_id != "" ? $model->purchaseOrder->supplier->email_company : '' ?>"></td>
                                        <td><input type="text" readonly="true" id="Supplier_company_attribute" value="<?php echo $model->supplier_id != "" ? $model->supplier->company_attribute : '' ?>"></td>
                                        <td><textarea name="" id="Supplier_supplier_address" cols="10" rows="3" readonly="true"><?php echo $model->supplier_id != "" ? $model->supplier->address . '&#13;&#10;' . $model->supplier->province->name . '&#13;&#10;' . $model->supplier->city->name . '&#13;&#10;' . $model->supplier->zipcode : ''; ?></textarea></td>
                                        <td>
                                            <?php $getPhone = ""; ?>
                                            <?php if ($model->supplier_id != ""): ?>
                                                <?php $phones = SupplierPhone::model()->findAllByAttributes(array('supplier_id' => $model->supplier_id, 'status' => 'Active')); ?>
                                                <?php if (count($phones) > 0): ?>
                                                    <?php foreach ($phones as $key => $phone): ?>
                                                         <input type="text" readonly="true" value="<?php //?>">  
                                                    <?php endforeach; ?>
<!--                                                    </textarea>-->
                                                <?php endif; ?>
                                            <?php endif ?>
                                            <textarea name="" id="Supplier_phones" cols="10" rows="3" readonly="true"><?php echo $getPhone; ?></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </fieldset>
                    </div>
                    <div id="product">
                        <fieldset>
                            <legend>Product</legend>
                            <table>
                                <thead>
                                    <tr>
                                        <td>Manufacture Code</td>
                                        <td>Name</td>
                                        <td>Qty</td>
                                        <td>Unit</td>
                                        <td>Unit Price</td>
                                        <td>Total</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($model->purchase_order_id)): ?>
                                        <?php $purchaseOrderHeader = TransactionPurchaseOrder::model()->findByPk($model->purchase_order_id); ?>
                                        <?php foreach ($purchaseOrderHeader->transactionPurchaseOrderDetails as $purchaseOrderDetail): ?>
                                            <tr>
                                                <?php $product = Product::model()->findByPK($purchaseOrderDetail->product_id); ?>
                                                <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                                                <td><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                                                <td><?php echo CHtml::encode(CHtml::value($purchaseOrderDetail, 'quantity')); ?></td>
                                                <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?></td>
                                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchaseOrderDetail, 'unit_price'))); ?></td>
                                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchaseOrderDetail, 'total_price'))); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
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
                        <?php
                        echo $form->textField($model, 'payment_amount', array('size' => 18, 'maxlength' => 18, 'readonly' => $model->isNewRecord ? false : true,
                            'onchange' => '
                            var relCount = $("#PaymentOut_purchase_order_id").attr("rel");
                            var count = 0;
                            var paymentAmount = $("#PaymentOut_payment_amount").val();
                            var purchaseAmount = $("#Purchase_total_price").val();
                            var purchaseLeft = $("#Purchase_payment_left").val();
                            console.log(paymentAmount);
                            console.log(purchaseAmount);
                            console.log(purchaseLeft);
                            if (relCount == 1)
                                count = purchaseAmount - paymentAmount;
                            else
                                count = purchaseLeft - paymentAmount;
                            console.log(count);
                            if (count < 0) {
                                alert("Payment Amount could not be higher than Invoice Amount");
                                $("#PaymentOut_payment_amount").val("");
                            }

                            '
                        ));
                        ?>
                        <?php echo $form->error($model, 'payment_amount'); ?>
                    </div>
                </div>
            </div>		

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
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'images'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php if ($model->isNewRecord): ?>
                            <?php //echo $form->labelEx($model, 'images', array('class' => 'label')); ?>
                            <?php
                            $this->widget('CMultiFileUpload', array(
                                'model' => $model,
                                'attribute' => 'images',
                                'accept' => 'jpg|jpeg|png|gif',
                                'denied' => 'Only jpg, jpeg, png and gif are allowed',
                                'max' => 10,
                                'remove' => 'x',
                                    //'duplicate' => 'Already Selected',
                            ));
                            ?>
                        <?php else:
                            if ($allowedImages != 0): ?>
                                <?php //echo $form->labelEx($model, 'images', array('class' => 'label')); ?>
                                <?php $this->widget('CMultiFileUpload', array(
                                    'model' => $model,
                                    'attribute' => 'images',
                                    'accept' => 'jpg|jpeg|png|gif',
                                    'denied' => 'Only jpg, jpeg, png and gif are allowed',
                                    'max' => 10,
                                    'remove' => 'x',
                                )); ?>
                            <?php endif;

                            if ($postImages !== null): ?>
                                <?php
                                foreach ($postImages as $postImage):
                                    $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentIn/' . $model->id . '/' . $postImage->filename;
                                    $src = Yii::app()->baseUrl . '/images/uploads/paymentIn/' . $model->id . '/' . $postImage->filename;
                                    ?>
                                    <div class="row">
                                        <div class="small-3 columns">
                                            <div style="margin-bottom:.5rem">
                                                <?php echo CHtml::image($src, $model->payment_number . "Image"); ?>
                                            </div>
                                        </div>
                                        <div class="small-8 columns">
                                            <div style="padding:.375rem .5rem; border:1px solid #ccc; background:#fff; font-size:.8125rem; line-height:1.4; margin-bottom:.5rem;">
                                                <?php echo (Yii::app()->baseUrl . '/images/uploads/paymentIn/' . $model->id . '/' . $postImage->filename); ?>
                                            </div>
                                        </div>
                                        <div class="small-1 columns">
                                            <?php echo CHtml::link('x', array('deleteImage', 'id' => $postImage->id, 'payment_in_id' => $model->id), array('class' => 'deleteImg right', 'confirm' => 'Are you sure you want to delete this image?')); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif;
                        endif; ?>
                        <?php echo $form->error($model, 'images'); ?>
                    </div>
                </div>
            </div>	

            <div class="field buttons text-center">
                <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
            </div>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'purchase-order-dialog',
    'options' => array(
        'title' => 'Purchase Order',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'purchase-order-grid',
    'dataProvider' => $purchaseOrderDataProvider,
    'filter' => $purchaseOrder,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'selectionChanged' => 'js:function(id){
        jQuery("#PaymentOut_purchase_order_id").val(jQuery.fn.yiiGridView.getSelection(id));
        jQuery("#purchase-order-dialog").dialog("close");
        jQuery.ajax({
            type: "POST",
            dataType: "JSON",
            url: "' . CController::createUrl('ajaxPurchase', array('id' => '')) . '" + jQuery.fn.yiiGridView.getSelection(id),
            data: $("form").serialize(),
            success: function(data) {
                $("#PaymentOut_purchase_order_id").attr("rel",data.count);
                jQuery("#PaymentOut_purchase_order_number").val(data.po_number);
                jQuery("#PaymentOut_supplier_id").val(data.supplier_id);
                jQuery("#Supplier_company_attribute").val(data.supplier_name);
                jQuery("#Supplier_email_personal").val(data.email_personal);
                jQuery("#Supplier_supplier_address").text(data.address+"\n"+data.province+"\n"+data.city );
                console.log(data.address+"\n"+data.province+"\n"+data.city+"\n"+data.zipcode);
                $("#Purchase_purchase_order_date").val(data.po_date);
                $("#Purchase_status_document").val(data.status);
                $("#Purchase_total_price").val(data.total_price);
                $("#Purchase_payment_amount").val(data.payment_amount);
                $("#Purchase_payment_left").val(data.payment_left);
                $("#Supplier_supplier_name").val(data.supplier_name);
                $("#Supplier_company").val(data.supplier_name);

                var phones = data.phones;
                jQuery("#Supplier_phones").text("");
                jQuery("#Supplier_mobiles").text("");
                for (i=0; i < phones.length; i++) { 
                    console.log(phones[i]);
                    var obj = phones[i];

                    for (var prop in obj) {
                        if (obj.hasOwnProperty(prop)) {
                            if (prop == "phone_no") {
                                console.log(prop + " = " + obj[prop]);
                                jQuery("#Supplier_phones").text(jQuery("#Supplier_phones").val()+"\n"+obj[prop]);
                            }

                        }
                    }
                }
                var mobiles = data.mobiles;
                for (i=0; i < mobiles.length; i++) { 
                    console.log(mobiles[i]);
                    var obj = mobiles[i];
                    for (var prop in obj) {
                        if (obj.hasOwnProperty(prop)) {
                            if (prop == "mobile_no") {
                                console.log(prop + " = " + obj[prop]);
                                jQuery("#Supplier_mobiles").text(jQuery("#Supplier_mobiles").val()+"\n"+obj[prop]);
                            }
                        }
                    }
                }
                
                if ($("#PaymentOut_supplier_id").val() != "") {
                    $(".detail").show();
                    $("#purchase-order-detail").show();
                    $("#supplier").show();
                }
            },
        });

        jQuery("#purchase-order-grid").find("tr.selected").each(function(){
            $(this).removeClass( "selected" );
        });
    }',
    'columns' => array(
        'purchase_order_no',
        'purchase_order_date',
        'status_document',
        array('name' => 'supplier_name', 'value' => '$data->supplier->name'),
        array(
            'name' => 'total_price',
            'value' => 'number_format($data->total_price, 2)',
        )
    ),
)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<script>
    if (jQuery("#PaymentOut_purchase_order_id").val()== "") {
    $(".detail").hide();
    // $("#invoice-Detail").hide();
    // $("#customer").hide();
    // $("#vehicle").hide();
    }
    if($("#PaymentOut_supplier_id").val() != ""){
    $(".detail").show();
    $("#purchase-order-detail").show();
    $("#supplier").show();

    }
    if ($("#PaymentOut_payment_type_id").val()== "6") {
    $(".giro").show();
    $(".cash").hide();
    //$(".bank").hide();
    if ($("#PaymentOut_cash_payment_type").val()== "Cash") {
    $(".bank").hide();
    }
    else
    $(".bank").show();

    }
    else if($("#PaymentOut_payment_type_id").val()== 1){
    $(".giro").hide();
    $(".cash").show();
    //$(".bank").hide();
    if ($("#PaymentOut_cash_payment_type").val()== "Cash") {
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
    $("#PaymentOut_cash_payment_type").val("");
    $("#PaymentOut_nomor_giro").val("");
    $("#PaymentOut_bank_id").val("");
    }

</script>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('myjavascript', '$(".numbers").number( true,2, ".", ","); ', CClientScript::POS_END);
?>