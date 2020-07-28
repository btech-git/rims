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
        array(
            'header' => 'Tanggal',
            'name' => 'transfer_request_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->transfer_request_date)'
        ),
        'status_document',
        array('name'=>'requester_branch_id','value'=>'$data->requesterBranch->name'),
        array('name'=>'requester_id','value'=> '$data->user->username'),
        array(
            'header' => 'Status',
            'value' => '$data->totalRemainingQuantityDelivered',
        ),
    ),
)); ?>