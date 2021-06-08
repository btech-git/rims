<h2>Return Orders</h2>
<hr>
<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'return-order-grid',
        'dataProvider'=>$returnOrder->searchByMovementOut(),
        'filter'=>$returnOrder,
        // 'summaryText'=>'',
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'columns'=>array(
            array(
                'name'=>'return_order_no', 
                'value'=>'CHTml::link($data->return_order_no, array("/transaction/transactionReturnOrder/view", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            'return_order_date',
            array(
                'header'=>'Movements',
                'value'=> function($data){
                    foreach ($data->movementOutHeaders as $key => $movementDetail) {
                        echo $movementDetail->movement_out_no. "<br>";
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