<h2>Receive Item</h2>
<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'receive-item-grid',
        'dataProvider'=>$receiveItem->search(),
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
                'header'=>'Movements',
                'value'=> function($data){
                    foreach ($data->movementInHeaders as $key => $movementDetail) {
                        echo $movementDetail->movement_in_number. "<br>";
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