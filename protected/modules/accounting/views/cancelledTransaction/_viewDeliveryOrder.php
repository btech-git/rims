<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'delivery-order-grid',
    'dataProvider'=>$deliveryOrderDataProvider,
    'filter'=>$deliveryOrder,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'delivery_order_no', 
            'value'=>'$data->delivery_order_no', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'delivery_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->delivery_date)'
        ),
        'request_type',
        array('name'=>'customer_id','value'=>'empty($data->customer_id) ? "" :$data->customer->name'),
        array(
            'header' => 'Cancelled by',
            'name' => 'user_id_cancelled',
            'filter' => false,
            'value' => 'empty($data->user_id_cancelled) ? "" : $data->userIdCancelled->username',
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{views}',
            'buttons'=>array(
                'views' => array(
                    'label'=>'view',
                    'url'=>'Yii::app()->createUrl("transaction/transactionDeliveryOrder/view", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>