
<div>
    <h1>List Pembelian non stok</h1>

    <br />

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'receive-item-grid',
        'dataProvider' => $itemRequestDataProvider,
        'filter' => $itemRequest,
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'columns' => array(
            array(
                'name'=>'transaction_number', 
                'value'=>'CHtml::link($data->transaction_number, array("/frontDesk/itemRequest/view", "id"=>$data->id))', 
                'type'=>'raw',
            ),
            'transaction_date',
            array(
                'name' => 'supplier_id',
                'header' => 'Supplier',
                'value' => '$data->supplier->name',
            ),
            array(
                'header' => 'Status Document',
                'value' => '$data->status_document',
            ),
            array(
                'name' => 'total_price',
                'filter' => false,
                'value' => '$data->total_price',
            ),
            array(
                'name'=>'total_payment',
                'filter' => false,
                'value'=>'$data->total_payment',
            ),
            array(
                'name'=>'remaining_payment',
                'filter' => false,
                'value'=>'$data->remaining_payment',
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("Create", array("createSingle", "transactionId"=>$data->id, "movementType"=>"3"))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
        ),
    )); ?>
</div>