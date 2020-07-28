<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'transfer-grid',
    'dataProvider'=>$transferDataProvider,
    'filter'=>$transfer,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        //'id',
        //'code',
        array('name'=>'transfer_request_no', 'value'=>'CHTml::link($data->transfer_request_no, array("/transaction/transactionTransferRequest/view", "id"=>$data->id))', 'type'=>'raw'),
        // 'purchase_order_no',
        'transfer_request_date',
        'status_document',
        array('header'=>'Deliveries','value'=> function($data){
            if(count($data->transactionDeliveryOrders) >0) {
                foreach ($data->transactionDeliveryOrders as $key => $delivery) {
                    echo $delivery->delivery_order_no. "<br>";
                }
            }
        }
    )),
)); ?>