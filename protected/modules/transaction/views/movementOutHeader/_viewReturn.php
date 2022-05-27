<h2>Return Pembelian</h2>
<hr>
<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'return-order-grid',
        'dataProvider'=>$returnOrderDataProvider,
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
                'header' => 'Retur Pembelian #',
                'value'=>'CHTml::link($data->return_order_no, array("/transaction/transactionReturnOrder/view", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            array(
                'name'=>'return_order_date', 
                'header' => 'Retur Tanggal',
                'value'=>'$data->return_order_date',
            ),
            array(
                'name'=>'supplier_id', 
                'filter' => CHtml::activeTextField($returnOrder, 'supplier_name'), 
                'value'=>'empty($data->supplier_id) ? "" : $data->supplier->name', 
                'type'=>'raw'
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
                'value' => 'CHtml::link("Create", array("create", "transactionId"=>$data->id, "movementType"=>"2"))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
        ),
    )); ?>
</div>