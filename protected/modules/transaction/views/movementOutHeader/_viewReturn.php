<h2>Return Orders</h2>
<hr>
<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'return-order-grid',
        'dataProvider'=>$returnOrder->search(),
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
        ),
    )); ?>
</div>