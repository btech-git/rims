<h2>Purchase Order</h2>

<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'purchase-grid',
        'dataProvider'=>$purchaseDataProvider,
        'filter'=>$purchase,
        //'summaryText'=>'',
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
            'cssFile'=>false,
            'header'=>'',
                    ),
        'columns'=>array(
            //'id',
            //'code',
            array(
                'name'=>'purchase_order_no', 
                'value'=>'CHTml::link($data->purchase_order_no, array("/transaction/transactionPurchaseOrder/view", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            // 'purchase_order_no',
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
        ),
    )); ?>
</div>