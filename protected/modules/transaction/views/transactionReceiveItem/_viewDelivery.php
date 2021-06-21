<h2>Internal Delivery Order</h2>
					
<div class="grid-view">
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
            array(
                'name'=>'delivery_order_no', 
                'value'=>'CHTml::link($data->delivery_order_no, array("/transaction/transactionDeliveryOrder/view", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            'delivery_date',
            array(
                'header'=>'Receives',
                'value'=> function($data){
                    if (count($data->transactionReceiveItems) >0) {
                        foreach ($data->transactionReceiveItems as $key => $receive) {
                            echo $receive->receive_item_no. "<br>";
                        }
                    }
                }
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("Create", array("create", "transactionId"=>$data->id, "movementType"=>"2"))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
        ),
    )); ?>
</div>