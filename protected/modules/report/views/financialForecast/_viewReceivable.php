<div class="grid-view">
    <p><h2>Piutang Customer</h2></p>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'receivable-grid',
        'dataProvider' => $receivableTransactionDataProvider,
        'filter' => $receivableTransaction,
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
                'name' => 'customer_id', 
                'header' => 'Customer',
                'value' => '$data->customer->name', 
            ),
            array(
                'name' => 'vehicle_id', 
                'header' => 'Plate #',
                'value' => '$data->vehicle->plate_number', 
            ),
            array(
                'name' => 'total_price', 
                'header' => 'Amount',
                'value' => 'Yii::app()->numberFormatter->format("#,##0", $data->total_price)', 
                'htmlOptions' => array('style'=>'text-align: right;'),
            ),
            array(
                'name' => 'invoice_date', 
                'header' => 'Tanggal',
                'value' => 'CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", $data->invoice_date))', 
            ),
            array(
                'name' => 'due_date', 
                'header' => 'Jatuh Tempo',
                'value' => 'CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", $data->due_date))', 
            ),
            array(
                'header' => 'Hari',
                'value' => 'CHtml::encode(date("l", strtotime(CHtml::value($data, "due_date"))))', 
            ),
            array(
                'name' => 'user_id', 
                'header' => 'User Input',
                'value' => '$data->user->username', 
            ),
            array(
                'name' => 'created_datetime', 
                'header' => 'Tanggal Input',
                'value' => 'CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", $data->created_datetime))', 
            ),
        ),
    )); ?>
</div>