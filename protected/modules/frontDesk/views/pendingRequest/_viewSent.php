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
            'value' => '$data->sent_request_no', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'sent_request_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->sent_request_date)'
        ),
        'status_document',
        array('name'=>'requester_branch_id','value'=>'$data->requesterBranch->name'),
        array('name'=>'destination_branch_id','value'=>'$data->destinationBranch->name'),
        array('name'=>'requester_id','value'=> '$data->user->username'),
        array(
            'name'=>'destination_approval_status',
            'value'=> '$data->approvalStatus', 
            'header' => 'Approval Status'
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{views}',
            'buttons'=>array(
                'views' => array(
                    'label'=>'approval',
                    'url'=>'Yii::app()->createUrl("transaction/transactionSentRequest/updateApproval", array("headerId"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>