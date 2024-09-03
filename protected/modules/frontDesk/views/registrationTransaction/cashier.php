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
});*/
$('form').submit(function(){
    $('#registration-transaction-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
"); ?>

<?php echo CHtml::beginForm(); ?>
<div id="maincontent">
    <div class="clearfix page-action">

        <h1>Cashier</h1>
        <div class="search-bar">
            <div class="clearfix button-bar">
                <div class="row">
                    <table>
                        <tr>
                            <td style="text-align: center; font-weight: bold">Invoice #</td>
                            <td style="text-align: center; font-weight: bold" colspan="2">Date</td>
                            <td style="text-align: center; font-weight: bold">Plate #</td>
                            <td style="text-align: center; font-weight: bold">Customer Name</td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php echo CHtml::activeTextField($invoice, 'invoice_number', array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("registration-transaction-grid", {data: {InvoiceHeader: {
                                            invoice_number: $(this).val(),
                                            invoice_date: $("#' . CHtml::activeId($invoice, 'invoice_date') . '").val(),
                                            invoice_date_to: $("#' . CHtml::activeId($invoice, 'invoice_date_to') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($invoice, 'plate_number') . '").val(),
                                            status: $("#' . CHtml::activeId($invoice, 'status') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($invoice, 'branch_id') . '").val(),
                                            customer_name: $("#' . CHtml::activeId($invoice, 'customer_name') . '").val(),
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
                                        ),
                                        'htmlOptions'=>array(
                                            'style'=>'margin-bottom:0px;',
                                            'placeholder'=>'Transaction Date From',
                                            'onchange' => '
                                                $.fn.yiiGridView.update("registration-transaction-grid", {data: {InvoiceHeader: {
                                                    invoice_date: $(this).val(),
                                                    invoice_number: $("#' . CHtml::activeId($invoice, 'invoice_number') . '").val(),
                                                    plate_number: $("#' . CHtml::activeId($invoice, 'plate_number') . '").val(),
                                                    invoice_date_to: $("#' . CHtml::activeId($invoice, 'invoice_date_to') . '").val(),
                                                    status: $("#' . CHtml::activeId($invoice, 'status') . '").val(),
                                                    branch_id: $("#' . CHtml::activeId($invoice, 'branch_id') . '").val(),
                                                    customer_name: $("#' . CHtml::activeId($invoice, 'customer_name') . '").val(),
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
                                        ),
                                        'htmlOptions'=>array(
                                            'style'=>'margin-bottom:0px;',
                                            'placeholder'=>'Transaction Date To',
                                            'onchange' => '
                                                $.fn.yiiGridView.update("registration-transaction-grid", {data: {InvoiceHeader: {
                                                    invoice_date_to: $(this).val(),
                                                    invoice_number: $("#' . CHtml::activeId($invoice, 'invoice_number') . '").val(),
                                                    plate_number: $("#' . CHtml::activeId($invoice, 'plate_number') . '").val(),
                                                    invoice_date: $("#' . CHtml::activeId($invoice, 'invoice_date') . '").val(),
                                                    status: $("#' . CHtml::activeId($invoice, 'status') . '").val(),
                                                    branch_id: $("#' . CHtml::activeId($invoice, 'branch_id') . '").val(),
                                                    customer_name: $("#' . CHtml::activeId($invoice, 'customer_name') . '").val(),
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
                                        $.fn.yiiGridView.update("registration-transaction-grid", {data: {InvoiceHeader: {
                                            plate_number: $(this).val(),
                                            invoice_number: $("#' . CHtml::activeId($invoice, 'invoice_number') . '").val(),
                                            invoice_date: $("#' . CHtml::activeId($invoice, 'invoice_date') . '").val(),
                                            invoice_date_to: $("#' . CHtml::activeId($invoice, 'invoice_date_to') . '").val(),
                                            status: $("#' . CHtml::activeId($invoice, 'status') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($invoice, 'branch_id') . '").val(),
                                            customer_name: $("#' . CHtml::activeId($invoice, 'customer_name') . '").val(),
                                            insurance_company_id: $("#' . CHtml::activeId($invoice, 'insurance_company_id') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            
                            <td>
                                <?php echo CHtml::activeTextField($invoice, 'customer_name', array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("registration-transaction-grid", {data: {InvoiceHeader: {
                                            customer_name: $(this).val(),
                                            invoice_number: $("#' . CHtml::activeId($invoice, 'invoice_number') . '").val(),
                                            invoice_date: $("#' . CHtml::activeId($invoice, 'invoice_date') . '").val(),
                                            invoice_date_to: $("#' . CHtml::activeId($invoice, 'invoice_date_to') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($invoice, 'plate_number') . '").val(),
                                            status: $("#' . CHtml::activeId($invoice, 'status') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($invoice, 'branch_id') . '").val(),
                                            customer_type: $("#' . CHtml::activeId($invoice, 'customer_type') . '").val(),
                                            insurance_company_id: $("#' . CHtml::activeId($invoice, 'insurance_company_id') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="text-align: center; font-weight: bold">Insurance</td>
                            <td style="text-align: center; font-weight: bold">Customer Type</td>
                            <td style="text-align: center; font-weight: bold">Status</td>
                            <td style="text-align: center; font-weight: bold">Branch</td>
                        </tr>
                        
                        <tr>                            
                            <td>
                                <?php echo CHtml::activeDropDownList($invoice, 'insurance_company_id', CHtml::listData(InsuranceCompany::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                                    'empty' => '-- all --',
                                    'onchange' => '
                                        $.fn.yiiGridView.update("registration-transaction-grid", {data: {InvoiceHeader: {
                                            insurance_company_id: $(this).val(),
                                            invoice_number: $("#' . CHtml::activeId($invoice, 'invoice_number') . '").val(),
                                            invoice_date: $("#' . CHtml::activeId($invoice, 'invoice_date') . '").val(),
                                            invoice_date_to: $("#' . CHtml::activeId($invoice, 'invoice_date_to') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($invoice, 'plate_number') . '").val(),
                                            status: $("#' . CHtml::activeId($invoice, 'status') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($invoice, 'branch_id') . '").val(),
                                            customer_type: $("#' . CHtml::activeId($invoice, 'customer_type') . '").val(),
                                            customer_name: $("#' . CHtml::activeId($invoice, 'customer_name') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            
                            <td>
                                <?php echo CHtml::activeDropDownList($invoice, 'customer_type', array(
                                    '' => '-- All --',
                                    'Company' => 'Company',
                                    'Individual' => 'Individual',
                                ),  array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("registration-transaction-grid", {data: {InvoiceHeader: {
                                            customer_type: $(this).val(),
                                            invoice_number: $("#' . CHtml::activeId($invoice, 'invoice_number') . '").val(),
                                            invoice_date: $("#' . CHtml::activeId($invoice, 'invoice_date') . '").val(),
                                            invoice_date_to: $("#' . CHtml::activeId($invoice, 'invoice_date_to') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($invoice, 'plate_number') . '").val(),
                                            status: $("#' . CHtml::activeId($invoice, 'status') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($invoice, 'branch_id') . '").val(),
                                            customer_name: $("#' . CHtml::activeId($invoice, 'customer_name') . '").val(),
                                            insurance_company_id: $("#' . CHtml::activeId($invoice, 'insurance_company_id') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            
                            <td>
                                <?php echo CHtml::activeDropDownList($invoice, 'status', array(
                                    '' => '-- All --',
                                    'INVOICING' => 'INVOICING',
                                    'PARTIALLY PAID' => 'PARTIALLY PAID',
//                                    'NOT PAID' => 'NOT PAID',
                                    'PAID' => 'PAID',
                                ), array(
                                    'onchange' => '
                                        $.fn.yiiGridView.update("registration-transaction-grid", {data: {InvoiceHeader: {
                                            status: $(this).val(),
                                            invoice_date: $("#' . CHtml::activeId($invoice, 'invoice_date') . '").val(),
                                            invoice_date_to: $("#' . CHtml::activeId($invoice, 'invoice_date_to') . '").val(),
                                            invoice_number: $("#' . CHtml::activeId($invoice, 'invoice_number') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($invoice, 'plate_number') . '").val(),
                                            branch_id: $("#' . CHtml::activeId($invoice, 'branch_id') . '").val(),
                                            customer_name: $("#' . CHtml::activeId($invoice, 'customer_name') . '").val(),
                                            insurance_company_id: $("#' . CHtml::activeId($invoice, 'insurance_company_id') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                            
                            <td>
                                <?php echo CHtml::activeDropDownList($invoice, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'onchange' => '
                                        $.fn.yiiGridView.update("registration-transaction-grid", {data: {InvoiceHeader: {
                                            branch_id: $(this).val(),
                                            invoice_date: $("#' . CHtml::activeId($invoice, 'invoice_date') . '").val(),
                                            invoice_date_to: $("#' . CHtml::activeId($invoice, 'invoice_date_to') . '").val(),
                                            invoice_number: $("#' . CHtml::activeId($invoice, 'invoice_number') . '").val(),
                                            status: $("#' . CHtml::activeId($invoice, 'status') . '").val(),
                                            plate_number: $("#' . CHtml::activeId($invoice, 'plate_number') . '").val(),
                                            customer_name: $("#' . CHtml::activeId($invoice, 'customer_name') . '").val(),
                                            insurance_company_id: $("#' . CHtml::activeId($invoice, 'insurance_company_id') . '").val(),
                                        } } });
                                    ',
                                )); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'registration-transaction-grid',
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
                        'value' => 'CHtml::link($data->invoice_number, array("/transaction/invoiceHeader/view", "id"=>$data->id), array("target" => "blank"))', 
                        'type' => 'raw'
                    ),
                    array(
                        'name' => 'transaction_date',
                        'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->invoice_date)',
                    ),
                    array(
                        'header' => 'Registration #',
                        'value' => 'CHtml::link($data->registrationTransaction->transaction_number, array("/frontDesk/registrationTransaction/view", "id"=>$data->registration_transaction_id), array("target" => "blank"))', 
                        'type' => 'raw'
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
                                'url' => 'Yii::app()->createUrl("transaction/paymentIn/create",array("invoiceId"=>$data->id))',
                                'visible' => 'Yii::app()->user->checkAccess("paymentInCreate") && !empty($data->registration_transaction_id) && $data->payment_left > 0',
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
                                'url' => 'Yii::app()->createUrl("frontDesk/registrationTransaction/memo", array("id" => $data->registration_transaction_id))',
//                                'visible' => 'Yii::app()->user->checkAccess("generalRepairCreate") || Yii::app()->user->checkAccess("generalRepairEdit")'
                            ),
                        ),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>
<?php echo CHtml::endForm(); ?>


<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'customer-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Customer',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'customer-grid',
    'dataProvider' => $customerDataProvider,
    'filter' => $customer,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'selectionChanged' => 'js:function(id){
        jQuery("#RegistrationTransaction_customer_id").val(jQuery.fn.yiiGridView.getSelection(id));
        jQuery("#customer-dialog").dialog("close");
        jQuery.ajax({
            type: "POST",
            dataType: "JSON",
            url: "' . CController::createUrl('ajaxCustomer', array('id' => '')) . '" + jQuery.fn.yiiGridView.getSelection(id),
            data: $("form").serialize(),
            success: function(data) {
                jQuery("#RegistrationTransaction_customer_name").val(data.name);
                $.fn.yiiGridView.update("registration-transaction-grid", {
                    data: $("#search_heading-range").serialize()
                });
            },
        });

        jQuery("#customer-grid").find("tr.selected").each(function(){
                $(this).removeClass( "selected" );
        });
    }',
    'columns' => array(
        'name',
        array(
            'header' => 'Customer Type',
            'value' => '$data->customer_type',
            'type' => 'raw',
            'filter' => CHtml::dropDownList('Customer[customer_type]', $customer->customer_type, array(
                '' => 'All',
                'Individual' => 'Individual',
                'Company' => 'Company',
            )),
        ),
        'email',
    ),
)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
