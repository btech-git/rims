<div class="grid-view">
    <p><h2>Hutang Supplier</h2></p>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'payable-grid',
        'dataProvider' => $payableTransactionDataProvider,
        'filter' => $payableTransaction,
        'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'columns' => array(
            array(
                'name' => 'invoice_number', 
                'header' => 'Invoice #',
                'value' => '$data->invoice_number', 
            ),
            array(
                'name' => 'supplier_id', 
                'header' => 'Supplier',
                'value' => 'empty($data->supplier_id) ? "" : $data->supplier->name', 
            ),
            array(
                'name' => 'invoice_grand_total', 
                'header' => 'Amount',
                'value' => 'Yii::app()->numberFormatter->format("#,##0", $data->invoice_grand_total)', 
                'htmlOptions' => array('style'=>'text-align: right;'),
            ),
            array(
                'name' => 'invoice_date', 
                'header' => 'Tanggal',
                'value' => 'CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", $data->invoice_date))', 
            ),
            array(
                'name' => 'invoice_due_date', 
                'header' => 'Jatuh Tempo',
                'value' => 'CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", $data->invoice_due_date))', 
            ),
            array(
                'header' => 'Hari',
                'value' => 'CHtml::encode(date("l", strtotime(CHtml::value($data, "invoice_due_date"))))', 
            ),
            array(
                'name' => 'user_id_invoice', 
                'header' => 'User Input',
                'value' => 'empty($data->user_id_invoice) ? "" : $data->userIdInvoice->username', 
            ),
            array(
                'name' => 'invoice_date_created', 
                'header' => 'Tanggal Input',
                'value' => 'CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", $data->invoice_date_created))', 
            ),
        ),
    )); ?>
</div>