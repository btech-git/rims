<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'body-repair-grid',
    'dataProvider'=>$paymentInDataProvider,
    'filter'=>$paymentIn,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'payment_number', 
            'value'=>'$data->payment_number', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'payment_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->payment_date)'
        ),
        array('name'=>'invoice_id','value'=>'empty($data->invoice_id) ? "" : $data->invoice->invoice_number'),
        'payment_type',
        array('name'=>'customer_id','value'=>'empty($data->customer_id) ? "" : $data->customer->name'),
        array('name'=>'vehicle_id','value'=>'empty($data->vehicle_id) ? "" : $data->vehicle->plate_number'),
        'status',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{views}',
            'buttons'=>array(
                'views' => array(
                    'label'=>'view',
                    'url'=>'Yii::app()->createUrl("transaction/paymentIn/view", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>