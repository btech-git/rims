<h2>Delivery Orders</h2>
<hr>
<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'delivery-order-grid',
        'dataProvider'=>$deliveryOrder->search(),
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
                'header'=>'Movements',
                'value'=> function($data){
                    foreach ($data->movementOutHeaders as $key => $movementDetail) {
                        echo $movementDetail->movement_out_no. "<br>";
                    }
                }
            ),
        ),
    )); ?>
</div>