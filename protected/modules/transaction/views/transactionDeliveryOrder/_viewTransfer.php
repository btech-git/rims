<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'transfer-grid',
    'dataProvider'=>$transferDataProvider,
    'filter'=>$transfer,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    'columns'=>array(
        array(
            'name'=>'transfer_request_no', 
                'header' => 'Transaction #',
            'value'=>'CHTml::link($data->transfer_request_no, array("/transaction/transferRequest/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        array(
            'name' => 'transfer_request_date',
            'header' => 'Tanggal',
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->transfer_request_date)',
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
            'header'=>'Deliveries',
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
            'value' => 'CHtml::link("Create", array("create", "transactionId"=>$data->id, "movementType"=>"4"))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>