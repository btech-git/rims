<div class="form">
    <?php echo CHtml::beginForm(array(), 'POST'); ?>
    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Tanggal Payment', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'name' => 'PaymentDate',
                            'value' => $paymentIn->header->payment_date,
                            'options'=>array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth'=>true,
                                'changeYear'=>true,
                            ),
                            'htmlOptions'=>array(
                                'value'=>date('Y-m-d'),
                                'readonly' => true,
                            ),
                        )); ?>
                        <?php echo CHtml::error($paymentIn->header, 'payment_date'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Customer', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($customer, 'name')); ?>
                    </div>
                </div>
            </div>
            
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
                        <?php echo CHtml::label('Branch', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php if ($paymentIn->header->isNewRecord): ?>
                            <?php echo CHtml::dropDownList('BranchId', $paymentIn->header->branch_id, CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array(
                                'empty' => '-- Select Branch --'
                            )); ?>
                            <?php echo CHtml::error($paymentIn->header, 'branch_id'); ?>
                        <?php else: ?>
                            <?php echo CHtml::encode(CHtml::value($paymentIn->header, 'branch.name'));?>
                        <?php endif; ?>
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
                            $userBranch = UserBranch::model()->findByAttributes(array('users_id' => Yii::app()->user->getId()));
                            $companyBranch = CompanyBranch::model()->findByAttributes(array('branch_id' => $userBranch->branch_id));
                        ?>
                        <?php echo CHtml::dropDownList('CompanyBankId', $paymentIn->header->company_bank_id, CHtml::listData(CompanyBank::model()->findAllByAttributes(array('company_id' => $companyBranch->company_id), array('order' => 'account_name')), 'id', 'accountNameAndNumber'), array(
                            'empty' => '-- Select Company Bank --'
                        )); ?>
                        <?php echo CHtml::error($paymentIn->header, 'company_bank_id'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Payment Type', false); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::dropDownList('PaymentTypeId', $paymentIn->header->payment_type_id, CHtml::listData(PaymentType::model()->findAll(), 'id', 'name'), array(
                            'empty' => '-- Select Payment Type --',
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
                        <?php echo CHtml::error($paymentIn->header, 'payment_type_id'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Tambah Invoice', array('name' => 'Search', 'onclick' => '$("#invoice-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#invoice-dialog").dialog("open"); return false; }')); ?>
        <?php echo CHtml::hiddenField('PurchaseInvoiceId'); ?>
    </div>

    <br />
    
    <div id="detail_div">
        <?php $this->renderPartial('_detail', array(
            'paymentIn' => $paymentIn,
        )); ?>
    </div>
	
    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

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
            'total_price',
            'payment_amount',
            'payment_left',
        ),
    )); ?>

    <?php echo CHtml::ajaxSubmitButton('Add Invoice', CController::createUrl('ajaxHtmlAddInvoices'), array(
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