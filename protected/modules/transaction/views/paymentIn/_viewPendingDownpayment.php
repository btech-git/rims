<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'downpayment-grid',
        // 'dataProvider'=>$vehicleDataProvider,
        'dataProvider' => $downpaymentDataProvider,
        'filter' => $registrationTransaction,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'columns' => array(
            array(
                'name' => 'downpayment_transaction_number',
                'header' => 'DP #',
                'value' => '$data->downpayment_transaction_number',
                'type' => 'raw'
            ),
            array(
                'name' => 'downpayment_transaction_date',
                'header' => 'Tanggal',
                'value' => '$data->downpayment_transaction_date',
            ),
            array(
                'name' => 'customer_id',
                'value' => 'CHtml::encode(CHtml::value($data, "customer.name"))',
            ),
            array(
                'name' => 'vehicle_id',
                'value' => 'CHtml::encode(CHtml::value($data, "vehicle.carMakeModelSubCombination"))',
            ),
            'vehicle.plate_number',
            array(
                'name' => 'downpayment_note',
                'header' => 'Note',
                'value' => '$data->downpayment_note',
            ),
            array(
                'name' => 'downpayment_amount', 
                'header' => 'Amount',
                'value' => 'AppHelper::formatMoney($data->downpayment_amount)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("Create", array("createDownpayment", "registrationId"=>$data->id))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
        ),
    )); ?>
</div>