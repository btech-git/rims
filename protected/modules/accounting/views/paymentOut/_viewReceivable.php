
<div>
    <h1>List Hutang Supplier</h1>

    <br />

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'receive-item-grid',
        'dataProvider' => $receiveItemDataProvider,
        'filter' => $receiveItem,
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'columns' => array(
            array(
                'name' => 'purchase_order_no',
                'header' => 'PO #',
                'value' => 'empty($data->purchase_order_id) ? "N/A" : CHtml::link($data->purchaseOrder->purchase_order_no, array("/transaction/transactionPurchaseOrder/view", "id"=>$data->purchase_order_id))',
                'type' => 'raw',
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
                'name' => 'supplier_name',
                'header' => 'Supplier',
                'value' => 'empty($data->supplier_id) ? "N/A" :$data->supplier->name',
            ),
            array(
                'name' => 'supplier_delivery_number',
                'header' => 'Supplier SJ #',
                'value' => '$data->supplier_delivery_number',
            ),
            array(
                'header' => 'Jatuh Tempo',
                'name' => 'invoice_due_date',
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->invoice_due_date)'
            ),
            array(
                'header' => 'Total',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "invoice_grand_total"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'header' => 'Payment',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "purchaseOrder.payment_amount"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'header' => 'Remaining',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "purchaseOrder.payment_left"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'name' => 'user_id_invoice',
                'filter' => false, //CHtml::activeDropDownList($receiveItem, 'user_id_invoice', CHtml::listData(Users::model()->findAll(array('order' => 'username')), 'id', 'username'), array('empty' => '-- all --')),
                'header' => 'Created By',
                'value' => 'empty($data->purchase_order_id) ? "N/A" : $data->purchaseOrder->user->username',
            ),
            array(
                'header' => 'Tanggal Input',
                'value' => '$data->dateTimeCreated',
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("Create", array("createSingle", "transactionId"=>$data->id, "movementType"=>"1"))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
        ),
    )); ?>
</div>