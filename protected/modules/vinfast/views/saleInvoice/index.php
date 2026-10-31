
<div id="maincontent">
    <div class="row">
        <h1>Invoice Belum Kirim ke Customers</h1>
        <?php echo CHtml::beginForm(); ?>
        <div>
                <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/transaction/invoiceHeader/admin'; ?>"><span class="fa fa-list"></span>Manage</a>
                
            <?php echo CHtml::submitButton('Terkirim ke Customer', array(
                'name' => 'SentToCustomer',
                'class' => 'button success'
            )); ?>
        </div>

        <div class="grid-view">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'invoice-header-grid',
                'dataProvider' => $dataProvider,
                'filter' => $model,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'rowCssClassExpression' => '(($data->status == "PAID")?"hijau":"merah")',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => 2,
                        'id' => 'SelectedIds',
                    ),
                    array(
                        'name' => 'invoice_number', 
                        'value' => 'CHtml::link($data->invoice_number, array("view", "id"=>$data->id))', 
                        'type' => 'raw'
                    ),
                    'invoice_date',
                    'due_date',
                    array(
                        'name' => 'reference_type', 
                        'value' => '$data->reference_type == 1 ? "Sales Order" : "Retail Sales"'
                    ),
                    array(
                        'header' => 'SO #', 
                        'value' => '$data->sales_order_id != null ? $data->salesOrder->sale_order_no : CHtml::link($data->registrationTransaction->sales_order_number, array("/frontDesk/registrationTransaction/view", "id"=>$data->registration_transaction_id))',
                        'type' => 'raw'
                    ),
                    array(
                        'header' => 'WO #', 
                        'value' => '$data->sales_order_id != null ? "" : $data->registrationTransaction->work_order_number'
                    ),
                    array(
                        'header' => 'SPK #', 
                        'value' => '$data->sales_order_id != null ? "" : $data->registrationTransaction->customer_work_order_number',
                    ),
                    array(
                        'name' => 'transaction_tax_number',
                        'header' => 'F. Pajak #', 
                        'value' => '$data->transaction_tax_number',
                    ),
                    array(
                        'name' => 'customer_name', 
                        'value' => '$data->customer_id != null ? $data->customer->name : ""'
                    ),
                    array(
                        'name' => 'customer_type', 
                        'value' => '$data->customer_id != null ? $data->customer->customer_type : ""'
                    ),
                    'status',
                ),
            )); ?>
        </div>  
        <?php echo CHtml::endForm(); ?>
    </div>  
</div>  