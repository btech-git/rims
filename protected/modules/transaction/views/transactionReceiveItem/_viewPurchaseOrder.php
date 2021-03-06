<h2>Purchase Order</h2>

<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'purchase-grid',
        'dataProvider'=>$purchaseDataProvider,
        'filter'=>$purchase,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
            'cssFile'=>false,
            'header'=>'',
        ),
        'columns'=>array(
            array(
                'name'=>'purchase_order_no', 
                'value'=>'CHTml::link($data->purchase_order_no, array("/transaction/transactionPurchaseOrder/view", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            'purchase_order_date',
            array(
                'name'=>'supplier_name',
                'value'=>'$data->supplier->name'
            ),
            'status_document',
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
                'header' => 'Status',
                'value' => '$data->totalRemainingQuantityReceived'
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