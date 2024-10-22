<?php
/* @var $this RegistrationTransactionController */
/* @var $data RegistrationTransaction */

$this->breadcrumbs = array(
'Registration Transactions' => array('admin'),
'Manage',
);
?>

<div class="row d-print-none">
    <div class="col d-flex justify-content-start">
        <h4>KASIR</h4>
    </div>
    <div class="col d-flex justify-content-end">
        <div class="d-gap">
            <?php echo CHtml::link('Manage', array("admin"), array('class' => 'btn btn-info btn-sm')); ?>
        </div>
    </div>
</div>

<hr />

<?php echo CHtml::beginForm(); ?>
<div class="row d-print-none">
    <div class="col">
        <div class="my-2 row">
            <label class="col col-form-label">Invoice #</label>
            <div class="col">
                <?php echo CHtml::activeTextField($invoice, 'invoice_number', array(
                    'class' => 'form-select',
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
            </div>
            <label class="col col-form-label">Tanggal</label>
            <div class="col">
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$invoice,
                    'attribute'=>'invoice_date',
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'class' => 'form-select',
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
                <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$invoice,
                    'attribute'=>'EndDate',
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
                ));*/ ?>
            </div>
            <label class="col col-form-label">Plat #</label>
            <div class="col">
                <?php echo CHtml::activeTextField($invoice, 'plate_number', array(
                    'class' => 'form-select',
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
            </div>
        </div>
        <div class="my-2 row">
            <label class="col col-form-label">Customer</label>
            <div class="col">
                <?php echo CHtml::activeTextField($invoice, 'customer_name', array(
                    'class' => 'form-select',
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
            </div>
            <label class="col col-form-label">Asuransi</label>
            <div class="col">
                <?php echo CHtml::activeDropDownList($invoice, 'insurance_company_id', CHtml::listData(InsuranceCompany::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                    'empty' => '-- all --',
                    'class' => 'form-select',
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
            </div>
            <label class="col col-form-label">Tipe</label>
            <div class="col">
                <?php echo CHtml::activeDropDownList($invoice, 'customer_type', array(
                    '' => '-- All --',
                    'Company' => 'Company',
                    'Individual' => 'Individual',
                ),  array(
                    'class' => 'form-select',
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
            </div>
        </div>
        <div class="my-2 row">
            <label class="col col-form-label">Status</label>
            <div class="col">
                <?php echo CHtml::activeDropDownList($invoice, 'status', array(
                    '' => '-- All --',
                    'INVOICING' => 'INVOICING',
                    'PARTIALLY PAID' => 'PARTIALLY PAID',
                    'PAID' => 'PAID',
                ), array(
                    'class' => 'form-select',
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
            </div>
            <label class="col col-form-label">Branch</label>
            <div class="col">
                <?php echo CHtml::activeDropDownList($invoice, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array(
                    'empty' => '-- All --',
                    'class' => 'form-select',
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
            </div>
        </div>
    </div>
</div>

    <div class="text-center">
        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter', 'class' => 'btn btn-danger'));  ?>
    </div>

    <hr />

    <div id="product_data_container">
        <?php $this->renderPartial('_invoiceDataTable', array(
            'invoiceDataProvider' => $invoiceDataProvider,
        )); ?>
    </div>
<?php echo CHtml::endForm(); ?>