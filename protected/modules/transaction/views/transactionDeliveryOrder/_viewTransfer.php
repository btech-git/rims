<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'transfer-grid',
    'dataProvider'=>$transferDataProvider,
    'filter'=>$transfer,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    'columns'=>array(
        array(
            'name'=>'transfer_request_no', 
            'value'=>'CHTml::link($data->transfer_request_no, array("/transaction/transferRequest/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        'transfer_request_date',
        'status_document',
        array(
            'header'=>'Deliveries',
            'value'=> function($data){
                if (count($data->transactionDeliveryOrders) >0) {
                    foreach ($data->transactionDeliveryOrders as $key => $delivery) {
                        echo $delivery->delivery_order_no. "<br>";
                    }
                }
            }
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "transactionId"=>$data->id, "movementType"=>"4"))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>