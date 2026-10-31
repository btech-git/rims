<?php
/* @var $this RegistrationTransactionController */
/* @var $invoice RegistrationTransaction */

$this->breadcrumbs = array(
    'Registration Transactions' => array('admin'),
    'Cashier',
);

$this->menu = array(
    array('label' => 'List Registration Transaction', 'url' => array('admin')),
    array('label' => 'Create Registration Transaction', 'url' => array('index')),
);

Yii::app()->clientScript->registerScript('search', "
/*$('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if ($(this).hasClass('active')){
            $(this).text('');
	} else {
            $(this).text('Customer Filter');
	}
	return false;
});
$('form').submit(function(){
    $('#sale-invoice-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});*/
"); ?>

<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Cashier</h1>
        
        <div class="search-bar">
            <?php echo CHtml::beginForm(array(''), 'get'); ?>
            <div class="clearfix button-bar">
                <div class="row">
                    <table>
                        <tr>
                            <td style="text-align: center; font-weight: bold">Invoice #</td>
                            <td style="text-align: center; font-weight: bold" colspan="2">Date</td>
                            <td style="text-align: center; font-weight: bold">Plate #</td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php echo CHtml::activeTextField($invoice, 'invoice_number', array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("sale-invoice-grid", {data: {InvoiceHeader: {
                                            invoice_number: $(this).val(),
                                            invoice_date: $("#' . CHtml::activeId($invoice, 'invoice_date') . '").val(),
                                            invoice_date_to: $("#' . CHtml::activeId($invoice, 'invoice_date_to') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($invoice, 'plate_number') . '").val(),
                                            status: $("#' . CHtml::activeId($invoice, 'status') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($invoice, 'branch_id') . '").val(),
                                            customer_id: $("#' . CHtml::activeId($invoice, 'customer_id') . '").val(),
                                            insurance_company_id: $("#' . CHtml::activeId($invoice, 'insurance_company_id') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            
                            <td>
                                <div>
                                    <?php $attribute = 'invoice_date'; ?>
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model'=>$invoice,
                                        'attribute'=>$attribute,
                                        'options'=>array(
                                            'dateFormat'=>'yy-mm-dd',
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                        ),
                                        'htmlOptions'=>array(
                                            'style'=>'margin-bottom:0px;',
                                            'placeholder'=>'Transaction Date From',
                                            'onchange' => '
                                                $.fn.yiiGridView.update("sale-invoice-grid", {data: {InvoiceHeader: {
                                                    invoice_date: $(this).val(),
                                                    invoice_number: $("#' . CHtml::activeId($invoice, 'invoice_number') . '").val(),
                                                    plate_number: $("#' . CHtml::activeId($invoice, 'plate_number') . '").val(),
                                                    invoice_date_to: $("#' . CHtml::activeId($invoice, 'invoice_date_to') . '").val(),
                                                    status: $("#' . CHtml::activeId($invoice, 'status') . '").val(),
                                                    branch_id: $("#' . CHtml::activeId($invoice, 'branch_id') . '").val(),
                                                    customer_id: $("#' . CHtml::activeId($invoice, 'customer_id') . '").val(),
                                                    insurance_company_id: $("#' . CHtml::activeId($invoice, 'insurance_company_id') . '").val(),
                                                } } });
                                            ',
                                        ),
                                    )); ?>
                                </div>
                            </td>
                            
                            <td>                                
                                <div>
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model'=>$invoice,
                                        'attribute'=>$attribute."_to",
                                        'options'=>array(
                                            'dateFormat'=>'yy-mm-dd',
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                        ),
                                        'htmlOptions'=>array(
                                            'style'=>'margin-bottom:0px;',
                                            'placeholder'=>'Transaction Date To',
                                            'onchange' => '
                                                $.fn.yiiGridView.update("sale-invoice-grid", {data: {InvoiceHeader: {
                                                    invoice_date_to: $(this).val(),
                                                    invoice_number: $("#' . CHtml::activeId($invoice, 'invoice_number') . '").val(),
                                                    plate_number: $("#' . CHtml::activeId($invoice, 'plate_number') . '").val(),
                                                    invoice_date: $("#' . CHtml::activeId($invoice, 'invoice_date') . '").val(),
                                                    status: $("#' . CHtml::activeId($invoice, 'status') . '").val(),
                                                    branch_id: $("#' . CHtml::activeId($invoice, 'branch_id') . '").val(),
                                                    customer_id: $("#' . CHtml::activeId($invoice, 'customer_id') . '").val(),
                                                    insurance_company_id: $("#' . CHtml::activeId($invoice, 'insurance_company_id') . '").val(),
                                                } } });
                                            ',
                                        ),
                                    )); ?>
                                </div>
                            </td>
                            
                            <td>
                                <?php echo CHtml::activeTextField($invoice, 'plate_number', array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("sale-invoice-grid", {data: {InvoiceHeader: {
                                            plate_number: $(this).val(),
                                            invoice_number: $("#' . CHtml::activeId($invoice, 'invoice_number') . '").val(),
                                            invoice_date: $("#' . CHtml::activeId($invoice, 'invoice_date') . '").val(),
                                            invoice_date_to: $("#' . CHtml::activeId($invoice, 'invoice_date_to') . '").val(),
                                            status: $("#' . CHtml::activeId($invoice, 'status') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($invoice, 'branch_id') . '").val(),
                                            customer_id: $("#' . CHtml::activeId($invoice, 'customer_id') . '").val(),
                                            insurance_company_id: $("#' . CHtml::activeId($invoice, 'insurance_company_id') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="text-align: center; font-weight: bold">Insurance</td>
                            <td style="text-align: center; font-weight: bold">Status</td>
                            <td style="text-align: center; font-weight: bold">Branch</td>
                            <td style="text-align: center; font-weight: bold">Customer</td>
                        </tr>
                        
                        <tr>                            
                            <td>
                                <?php echo CHtml::activeDropDownList($invoice, 'insurance_company_id', CHtml::listData(InsuranceCompany::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                                    'empty' => '-- all --',
                                    'onchange' => '
                                        $.fn.yiiGridView.update("sale-invoice-grid", {data: {InvoiceHeader: {
                                            insurance_company_id: $(this).val(),
                                            invoice_number: $("#' . CHtml::activeId($invoice, 'invoice_number') . '").val(),
                                            invoice_date: $("#' . CHtml::activeId($invoice, 'invoice_date') . '").val(),
                                            invoice_date_to: $("#' . CHtml::activeId($invoice, 'invoice_date_to') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($invoice, 'plate_number') . '").val(),
                                            status: $("#' . CHtml::activeId($invoice, 'status') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($invoice, 'branch_id') . '").val(),
                                            customer_id: $("#' . CHtml::activeId($invoice, 'customer_id') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            
                            <td>
                                <?php echo CHtml::activeDropDownList($invoice, 'status', array(
                                    '' => '-- All --',
                                    'Approved' => 'APPROVED',
                                    'PARTIALLY PAID' => 'PARTIALLY PAID',
                                    'PAID' => 'PAID',
                                    'CANCELLED!!!' => 'CANCEL',
                                ), array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("sale-invoice-grid", {data: {InvoiceHeader: {
                                            status: $(this).val(),
                                            invoice_date: $("#' . CHtml::activeId($invoice, 'invoice_date') . '").val(),
                                            invoice_date_to: $("#' . CHtml::activeId($invoice, 'invoice_date_to') . '").val(),
                                            invoice_number: $("#' . CHtml::activeId($invoice, 'invoice_number') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($invoice, 'plate_number') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($invoice, 'branch_id') . '").val(),
                                            customer_id: $("#' . CHtml::activeId($invoice, 'customer_id') . '").val(),
                                            insurance_company_id: $("#' . CHtml::activeId($invoice, 'insurance_company_id') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            
                            <td>
                                <?php echo CHtml::activeDropDownList($invoice, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'onchange' => '
                                        $.fn.yiiGridView.update("sale-invoice-grid", {data: {InvoiceHeader: {
                                            branch_id: $(this).val(),
                                            invoice_date: $("#' . CHtml::activeId($invoice, 'invoice_date') . '").val(),
                                            invoice_date_to: $("#' . CHtml::activeId($invoice, 'invoice_date_to') . '").val(),
                                            invoice_number: $("#' . CHtml::activeId($invoice, 'invoice_number') . '").val(),
                                            status: $("#' . CHtml::activeId($invoice, 'status') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($invoice, 'plate_number') . '").val(),
                                            customer_id: $("#' . CHtml::activeId($invoice, 'customer_id') . '").val(),
                                            insurance_company_id: $("#' . CHtml::activeId($invoice, 'insurance_company_id') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            
                            <td>
                                <?php echo CHtml::activeDropdownList($invoice, 'customer_id', CHtml::listData(Customer::model()->findAll(array(
                                    'condition' => 't.id IN (60849, 60926, 63482)',
                                    'order' => 't.name ASC'
                                )), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'onchange' => '
                                        $.fn.yiiGridView.update("sale-invoice-grid", {data: {InvoiceHeader: {
                                            insurance_company_id: $("#' . CHtml::activeId($invoice, 'insurance_company_id') . '").val(),
                                            invoice_number: $("#' . CHtml::activeId($invoice, 'invoice_number') . '").val(),
                                            invoice_date: $("#' . CHtml::activeId($invoice, 'invoice_date') . '").val(),
                                            invoice_date_to: $("#' . CHtml::activeId($invoice, 'invoice_date_to') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($invoice, 'plate_number') . '").val(),
                                            status: $("#' . CHtml::activeId($invoice, 'status') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($invoice, 'branch_id') . '").val(),
                                            customer_id: $(this).val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <div class="row"><?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?></div>
            </div>
            <?php echo CHtml::endForm(); ?>
        </div>
        
        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'sale-invoice-grid',
                'dataProvider' => $invoiceDataProvider,
                'filter' => null,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'header' => '#',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1', //  row is zero based
                    ),
                    array(
                        'name' => 'invoice_number',
                        'header' => 'Invoice',
                        'value' => 'CHtml::link($data->invoice_number, array("show", "id"=>$data->id), array("target" => "blank"))', 
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'transaction_date',
                        'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->invoice_date)',
                    ),
                    array(
                        'header' => 'Registration #',
                        'value' => 'CHtml::link($data->registrationTransaction->transaction_number, array(
                            "/vinfast/saleRegistration/show",
                            "id"=>$data->registration_transaction_id,
                        ), array("target" => "blank"))', 
                        'type' => 'raw',
                    ),
                    array(
                        'name' => 'plate_number', 
                        'value' => '$data->vehicle->plate_number',
                    ),
                    array(
                        'name' => 'customer_name', 
                        'value' => '$data->customer != null? $data->customer->name : "-"'
                    ),
                    array(
                        'header' => 'Insurance',
                        'value' => 'empty($data->insurance_company_id) ? "N/A" : $data->insuranceCompany->name',
                    ),
                    array(
                        'header' => 'SPK #', 
                        'value' => '$data->registrationTransaction->customer_work_order_number',
                    ),
                    array(
                        'name' => 'transaction_tax_number',
                        'header' => 'F. Pajak #', 
                        'value' => '$data->transaction_tax_number',
                    ),
                    'status',
                    array(
                        'name' => 'total_price', 
                        'header' => 'Total',
                        'value' => 'Yii::app()->numberFormatter->format("#,##0.00", $data->total_price)',
                        'htmlOptions' => array('style' => 'text-align: right'),
                    ),
                    array(
                        'name' => 'payment_amount', 
                        'header' => 'Payment',
                        'value' => 'Yii::app()->numberFormatter->format("#,##0.00", $data->payment_amount)',
                        'htmlOptions' => array('style' => 'text-align: right'),
                    ),
                    array(
                        'name' => 'payment_left', 
                        'header' => 'Remaining',
                        'value' => 'Yii::app()->numberFormatter->format("#,##0.00", $data->payment_left)',
                        'htmlOptions' => array('style' => 'text-align: right'),
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{views} {print}',
                        'buttons' => array(
                            'views' => array(
                                'label' => 'payment',
                                'url' => 'Yii::app()->createUrl("vinfast/salePayment/create",array("invoiceId"=>$data->id))',
                                'visible' => 'Yii::app()->user->checkAccess("paymentInCreate") && !empty($data->registration_transaction_id) && $data->payment_left > 0',
                            ),
                            'print' => array(
                                'label' => 'print',
                                'url' => '$data->status == "PAID" ? Yii::app()->createUrl("vinfast/saleRegistration/pdfPayment", array("id" => $data->id)) : Yii::app()->createUrl("vinfast/saleRegistration/pdf", array("id" => $data->id))',
                                'linkOptions' => 'target => _blank',
//                                'visible' => 'Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")'
                            ),
                        ),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>

<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Downpayment</h1>
        
        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'registration-transaction-grid',
                'dataProvider' => $registrationDataProvider,
                'filter' => $registrationTransaction,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'header' => '#',
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1', //  row is zero based
                    ),
                    array(
                        'name' => 'downpayment_transaction_number',
                        'header' => 'DP #',
                        'value' => 'CHtml::link($data->downpayment_transaction_number, array("/frontDesk/registrationTransaction/show", "id"=>$data->id), array("target" => "blank"))', 
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'downpayment_transaction_date',
                        'header' => 'Tanggal',
                        'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->downpayment_transaction_date)',
                    ),
                    array(
                        'header' => 'Registration #',
                        'name' => 'transaction_number',
                        'value' => 'CHtml::link($data->transaction_number, array("/vinfast/saleRegistration/show", "id"=>$data->id), array("target" => "_blank"))', 
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'plate_number', 
                        'value' => '$data->vehicle->plate_number',
                    ),
                    array(
                        'name' => 'customer_id', 
                        'filter' => CHtml::activeDropdownList($registrationTransaction, 'customer_id', CHtml::listData(Customer::model()->findAll(array(
                            'condition' => 't.id IN (60849, 60926, 63482)',
                            'order' => 't.name ASC'
                        )), 'id', 'name'), array('empty' => '-- All --')),
                        'value' => '$data->customer != null? $data->customer->name : "-"'
                    ),
                    array(
                        'header' => 'Asuransi',
                        'name' => 'insurance_company_id',
                        'filter' => CHtml::activeDropDownList($registrationTransaction, 'insurance_company_id', CHtml::listData(InsuranceCompany::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- all --',)),
                        'value' => 'empty($data->insurance_company_id) ? "N/A" : $data->insuranceCompany->name',
                    ),
                    array(
                        'header' => 'Status', 
                        'name' => 'downpayment_status',
                        'value' => '$data->downpayment_status',
                    ),
                    array(
                        'header' => 'Note', 
                        'name' => 'downpayment_note',
                        'value' => '$data->downpayment_note',
                    ),
                    array(
                        'header' => 'Total Invoice',
                        'name' => 'grand_total',
                        'value' => 'Yii::app()->numberFormatter->format("#,##0.00", $data->grand_total)',
                        'htmlOptions' => array('style' => 'text-align: right'),
                    ),
                    array(
                        'header' => 'DP Amount',
                        'name' => 'downpayment_amount',
                        'value' => 'Yii::app()->numberFormatter->format("#,##0.00", $data->downpayment_amount)',
                        'htmlOptions' => array('style' => 'text-align: right'),
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{views} {print}',
                        'buttons' => array(
                            'views' => array(
                                'label' => 'payment',
                                'url' => 'Yii::app()->createUrl("transaction/paymentIn/createDownpayment",array("registrationId"=>$data->id))',
                                'visible' => 'Yii::app()->user->checkAccess("paymentInCreate") && !empty($data->downpayment_transaction_number) && $data->is_downpayment_paid != 1',
                                'click' => "js:function(){
                                    var url = $(this).attr('href');
                                    newwindow=window.open(url,'name','height=600,width=1200,left=100');
                                    if (window.focus) {newwindow.focus()}
                                    newwindow.onbeforeunload = function(){  $.fn.yiiGridView.update('registration-transaction-grid')}
                                    newwindow.onunload = function(){  $.fn.yiiGridView.update('registration-transaction-grid')}
                                    return false;
                                }"
                            ),
                            'print' => array(
                                'label' => 'print',
                                'url' => '$data->is_downpayment_paid == 1 ? Yii::app()->createUrl("frontDesk/registrationTransaction/pdfPaymentDownpayment", array("id" => $data->id)) : Yii::app()->createUrl("frontDesk/registrationTransaction/pdfDownpayment", array("id" => $data->id))',
                                'linkOptions' => 'target => _blank',
//                                'visible' => 'Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")'
                            ),
                        ),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>