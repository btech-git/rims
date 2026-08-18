<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'sales-grid',
    'dataProvider'=>$salesDataProvider,
    'filter'=>$sales,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns'=>array(
        array(
            'name'=>'sale_order_no', 
            'value'=>'CHtml::link($data->sale_order_no, array("/transaction/transactionSalesOrder/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        array(
            'name' => 'sale_order_date',
            'header' => 'Tanggal',
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->sale_order_date)',
        ),
        array(
            'name' => 'estimate_arrival_date',
            'header' => 'ETA',
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->estimate_arrival_date)',
        ),
        array(
            'header' => 'Umur (hari)', 
            'value' => '$data->outstandingDays',
            'htmlOptions' => array('style' => 'text-align: center'),
        ),
        array(
            'name' => 'customer_id',
            'header' => 'Customer',
            'value' => '$data->customer->name',
        ),
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
            'value' => 'CHtml::link("Create", array("create", "transactionId"=>$data->id, "movementType"=>"1"))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>