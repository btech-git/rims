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
    <?php echo CHtml::errorSummary($paymentIn->header); ?>
    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Tanggal Payment', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $paymentIn->header,
                            'attribute' => "payment_date",
                            'options'=>array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth'=>true,
                                'changeYear'=>true,
                            ),
                            'htmlOptions'=>array(
//                                'value'=>date('Y-m-d'),
                                'readonly' => true,
                            ),
                        )); ?>
                        <?php echo CHtml::error($paymentIn->header, 'payment_date'); ?>
                    </div>
                </div>
            </div>
            <?php if (empty($paymentIn->header->insurance_company_id)): ?>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo CHtml::label('Customer', ''); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php $customer = Customer::model()->findByPk($paymentIn->header->customer_id); ?>
                            <?php echo CHtml::encode(CHtml::value($customer, 'name')); ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo CHtml::label('Asuransi', ''); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php $insuranceCompany = InsuranceCompany::model()->findByPk($paymentIn->header->insurance_company_id); ?>
                            <?php echo CHtml::encode(CHtml::value($insuranceCompany, 'name')); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Status', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($paymentIn->header, 'status')); ?>
                    </div>
                </div>
            </div>		
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Branch', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($paymentIn->header, 'branch.name'));?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('User', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($paymentIn->header, 'user.username')); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Payment Type', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($paymentIn->header, 'payment_type_id', CHtml::listData(PaymentType::model()->findAll(), 'id', 'name'), array(
                            'empty' => '-- Select Payment Type --',
                            'onchange' => '
                                if ($(this).val() == 1) {
                                    $(".giro").hide();
                                    $(".bank").hide();
                                } else {
                                    $(".bank").show();
                                    $(".giro").show();
                                }
                            ' . '$.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $paymentIn->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#bank_fee_amount").html(data.bankFeeAmount);
                                    $("#total_invoice").html(data.totalInvoice);
                                    $("#total_payment").html(data.totalPayment);
                                },
                            });',
                        )); ?>
                        <?php echo CHtml::error($paymentIn->header, 'payment_type_id'); ?>
                    </div>
                </div>
            </div>		
            
            <div class="field" >
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Company Bank', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php
                            //$userBranch = UserBranch::model()->findByAttributes(array('users_id' => Yii::app()->user->getId()));
                            //$companyBranch = CompanyBranch::model()->findByAttributes(array('branch_id' => 7));
                        ?>
                        <?php echo CHtml::activeDropDownList($paymentIn->header, 'company_bank_id', CHtml::listData(CompanyBank::model()->findAllByAttributes(array('company_id' => 7), array('order' => 'account_name')), 'id', 'accountNameAndNumber'), array(
                            'empty' => '-- Select Company Bank --'
                        )); ?>
                        <?php echo CHtml::error($paymentIn->header, 'company_bank_id'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Note', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextArea($paymentIn->header, 'notes'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr />

    <?php if ($paymentIn->header->isNewRecord): ?>
        <div class="row">
            <?php echo CHtml::button('Tambah Invoice', array('name' => 'Search', 'onclick' => '$("#invoice-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#invoice-dialog").dialog("open"); return false; }')); ?>
            <?php echo CHtml::hiddenField('SaleInvoiceId'); ?>
        </div>
    <?php endif; ?>

    <br />
    
    <div id="detail_div">
        <?php $this->renderPartial('_detail', array(
            'paymentIn' => $paymentIn,
        )); ?>
    </div>
	
    <div class="field">
        <div class="row collapse">
            <div class="small-4 columns">
                <?php echo CHtml::label('Attach Images (Upload size max 2MB)', ''); ?>
            </div>
            <div class="small-8 columns">
                <?php $this->widget('CMultiFileUpload', array(
                    'model' => $paymentIn->header,
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

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
    <?php echo IdempotentManager::generate(); ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php if ($paymentIn->header->isNewRecord): ?>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'invoice-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Invoice',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php echo CHtml::beginForm('', 'post'); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'invoice-grid',
        'dataProvider' => $invoiceHeaderDataProvider,
        'filter' => $invoiceHeader,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'columns' => array(
            array(
                'id' => 'InvoiceIds',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => '50',
            ),
            array(
                'name' => 'invoice_number',
                'header' => 'Invoice #',
                'value' => '$data->invoice_number',
            ),
            array(
                'header' => 'Tanggal',
                'name' => 'invoice_date',
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->invoice_date)'
            ),
            array(
                'name' => 'vehicle_id',
                'header' => 'Plat #',
                'value' => 'empty($data->vehicle_id) ? "" : $data->vehicle->plate_number',
            ),
            array(
                'name' => 'customer_id',
                'header' => 'Customer',
                'value' => 'empty($data->customer_id) ? "" : $data->customer->name',
            ),
            array(
                'name' => 'insurance_company_id',
                'header' => 'Asuransi',
                'value' => 'empty($data->insurance_company_id) ? "" : $data->insuranceCompany->name',
            ),
            array(
                'name' => 'total_price',
                'value' => 'CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $data->total_price))',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'name' => 'payment_amount',
                'value' => 'CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $data->payment_amount))',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'name' => 'payment_left',
                'value' => 'CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $data->payment_left))',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
        ),
    )); ?>

    <?php echo CHtml::ajaxSubmitButton('Add Invoice', CController::createUrl('ajaxHtmlAddInvoices', array('id' => $paymentIn->header->id)), array(
        'type' => 'POST',
        'data' => 'js:$("form").serialize()',
        'success' => 'js:function(html) {
            $("#detail_div").html(html);
            $("#invoice-dialog").dialog("close");
        }'
    )); ?>

    <?php echo CHtml::endForm(); ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php endif; ?>