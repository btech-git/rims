<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'consignment-in-grid',
    'dataProvider'=>$invoiceDataProvider,
    'filter'=>$invoiceHeader,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns'=>array(
        array(
            'name'=>'invoice_number', 
            'value'=>'CHTml::link($data->invoice_number, array("/transaction/invoiceHeader/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'invoice_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->invoice_date)'
        ),
        'status',
        array('name'=>'customer_id','value'=> '$data->customer->name'),
        array(
            'header' => 'Registration #',
            'value' => '$data->registrationTransaction->transaction_number',
        ),
        array(
            'header' => 'Input',
            'name' => 'created_datetime',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
        ),
    ),
)); ?>