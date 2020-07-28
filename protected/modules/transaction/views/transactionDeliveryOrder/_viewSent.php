<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'sent-grid',
    'dataProvider'=>$sentDataProvider,
    'filter'=>$sent,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        //'id',
        //'code',
        array('name'=>'sent_request_no', 'value'=>'CHTml::link($data->sent_request_no, array("/transaction/transactionSentRequest/view", "id"=>$data->id))', 'type'=>'raw'),
        // 'purchase_order_no',
        'sent_request_date',
        'status_document',
        array('header'=>'Receives','value'=> function($data){
            if(count($data->transactionDeliveryOrders) >0) {
                foreach ($data->transactionDeliveryOrders as $key => $delivery) {
                    echo $delivery->delivery_order_no. "<br>";

                }
            }
        }
    )),
)); ?>