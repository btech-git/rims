<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'retail-grid',
    'dataProvider'=>$retailTransactionDataProvider,
    'filter'=>$retailTransaction,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns'=>array(
        'transaction_number',
        array(
            'name' => 'transaction_date',
            'value' => "Yii::app()->dateFormatter->formatDateTime(\$data->transaction_date, 'medium', 'short')",
            'filter' => false, // Set the filter to false when date range searching
        ),
        array('name' => 'plate_number', 'value' => '$data->vehicle->plate_number'),
        array(
            'header' => 'Car Make',
            'value' => 'empty($data->vehicle->carMake) ? "" : $data->vehicle->carMake->name'
        ),
        array(
            'header' => 'Car Model',
            'value' => '$data->vehicle->carModel->name'
        ),
        array(
            'header' => 'Customer Name',
            'value' => '$data->customer->name',
        ),
        'payment_status',
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "transactionId"=>$data->id, "returnType"=>"2"))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>