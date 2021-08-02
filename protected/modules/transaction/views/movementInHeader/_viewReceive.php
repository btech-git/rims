<h2>Receive Item</h2>
<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'receive-item-grid',
        'dataProvider'=>$receiveItem->searchByMovementIn(),
        'filter'=>$receiveItem,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'columns'=>array(
            array(
                'name'=>'receive_item_no', 
                'value'=>'CHTml::link($data->receive_item_no, array("/transaction/transactionReceiveItem/view", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            'receive_item_date',
            array(
                'name'=>'supplier_id', 
                'filter' => CHtml::activeTextField($receiveItem, 'supplier_name'), 
                'value'=>'empty($data->supplier_id) ? "" : $data->supplier->name', 
                'type'=>'raw'
            ),
            array(
                'name' => 'request_type',
                'filter' => CHtml::activeDropDownList($receiveItem, 'request_type', array(
                    'Purchase Order' => 'Purchase Order',
                    'Internal Delivery Order' => 'Internal Delivery Order', 
                    'Consignment In' => 'Consignment In'
                ), array('empty' => '-- All --')),
                'value' => '$data->request_type'
            ),
            array(
                'header'=>'Movements',
                'value'=> function($data){
                    foreach ($data->movementInHeaders as $key => $movementDetail) {
                        echo CHtml::link($movementDetail->movement_in_number, array("/transaction/movementInHeader/view", "id"=>$movementDetail->id)). "<br>";
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