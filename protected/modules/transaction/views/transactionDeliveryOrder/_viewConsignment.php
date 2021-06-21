<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'consignment-grid',
    'dataProvider'=>$consignmentDataProvider,
    'filter'=>$consignment,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    'columns'=>array(
        array(
            'name'=>'consignment_out_no', 
            'value'=>'CHTml::link($data->consignment_out_no, array("/transaction/consignmentOutHeader/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        'date_posting',
        'status',
        array(
            'header'=>'Receives',
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
            'value' => 'CHtml::link("Create", array("create", "transactionId"=>$data->id, "movementType"=>"3"))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>