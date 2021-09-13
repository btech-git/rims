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
        array(
            'name'=>'sent_request_no', 
            'value'=>'CHTml::link($data->sent_request_no, array("/transaction/transactionSentRequest/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'sent_request_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->sent_request_date)'
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