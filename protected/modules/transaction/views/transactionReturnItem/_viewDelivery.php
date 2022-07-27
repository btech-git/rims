<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'delivery-grid',
    'dataProvider'=>$deliveryDataProvider,
    'filter'=>$delivery,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    'columns'=>array(
        'delivery_order_no',
        'delivery_date',
        'customer.name: Customer',
        'request_type',
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "transactionId"=>$data->id, "returnType"=>"1"))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>