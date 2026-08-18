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
            array(
                'name' => 'purchase_order_date',
                'header' => 'Tanggal',
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->purchase_order_date)',
            ),
            array(
                'name' => 'estimate_date_arrival',
                'header' => 'ETA',
                'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->estimate_date_arrival)',
            ),
            array(
                'header' => 'Umur (hari)', 
                'value' => '$data->outstandingDays',
                'htmlOptions' => array('style' => 'text-align: center'),
            ),
            array(
                'name'=>'supplier_name',
                'value'=>'$data->supplier->name'
            ),
            
            array(
                'name'=>'purchase_type',
                'header' => 'Kategori Pembelian', 
                'value'=>'$data->getPurchaseStatus($data->purchase_type)',
            ),
            'note',
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