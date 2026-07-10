
<div>
    <h1>List Pembelian Asset</h1>

    <br />

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'asset-purchase-grid',
        'dataProvider' => $assetPurchaseDataProvider,
        'filter' => $assetPurchase,
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'columns' => array(
            array(
                'name'=>'transaction_number', 
                'value'=>'CHtml::link($data->transaction_number, array("/accounting/assetManagement/view", "id"=>$data->id), array("target" => "_blank"))', 
                'type'=>'raw',
            ),
            'transaction_date',
            'description',
            'note',
            array(
                'header' => 'Category',
                'value' => '$data->assetCategory->description',
            ),
            array(
                'header' => 'Status Document',
                'value' => '$data->status',
            ),
            array(
                'name' => 'purchase_value',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "purchase_value"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'name'=>'total_payment',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "total_payment"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'name'=>'payment_remaining',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "payment_remaining"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("Create", array("createSingle", "transactionId"=>$data->id, "movementType"=>"4"))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
        ),
    )); ?>
</div>