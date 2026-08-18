<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'sent-grid',
    'dataProvider'=>$sentDataProvider,
    'filter'=>$sent,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    'columns'=>array(
        array(
            'name'=>'sent_request_no', 
            'value'=>'CHTml::link($data->sent_request_no, array("/transaction/transactionSentRequest/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        array(
            'name' => 'sent_request_date',
            'header' => 'Tanggal',
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->sent_request_date)',
        ),
        array(
            'name' => 'estimate_arrival_date',
            'header' => 'ETA',
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->estimate_arrival_date)',
        ),
        array(
            'header' => 'Umur (hari)', 
            'value' => '$data->outstandingDays',
            'htmlOptions' => array('style' => 'text-align: center'),
        ),
        array(
            'name' => 'destination_branch_id',
            'header' => 'Cabang Tujuan',
            'value' => '$data->destinationBranch->code',
        ),
        'status_document',
        array(
            'header'=>'Receives',
            'value'=> function($data){
                if (count($data->transactionDeliveryOrders) >0) {
                    foreach ($data->transactionDeliveryOrders as $key => $delivery) {
                        echo $delivery->delivery_order_no. "<br>";
                    }
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