<h2>Delivery Orders</h2>
<hr>
<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'delivery-order-grid',
        'dataProvider'=>$deliveryOrder->searchByMovementOut(),
        'filter'=>$deliveryOrder,
        // 'summaryText'=>'',
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'columns'=>array(
            array(
                'name'=>'delivery_order_no', 
                'value'=>'CHTml::link($data->delivery_order_no, array("/transaction/transactionDeliveryOrder/view", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            'delivery_date',
            array(
                'name'=>'customer_id', 
                'filter' => CHtml::activeTextField($deliveryOrder, 'customer_name'), 
                'value'=>'empty($data->customer_id) ? "" : $data->customer->name', 
                'type'=>'raw'
            ),
            array(
                'name' => 'request_type',
                'filter' => CHtml::activeDropDownList($deliveryOrder, 'request_type', array(
                    'Sales Order' => 'Sales Order',
                    'Sent Request' => 'Sent Request', 
                    'Consignment Out' => 'Consignment Out', 
                    'Transfer Request' => 'Transfer Request',
                ), array('empty' => '-- All --')),
                'value' => '$data->request_type'
            ),
            array(
                'header'=>'Movements',
                'value'=> function($data){
                    foreach ($data->movementOutHeaders as $key => $movementDetail) {
                        echo CHtml::link($movementDetail->movement_out_no, array("/transaction/movementOutHeader/view", "id"=>$movementDetail->id)). "<br>";
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
</div>