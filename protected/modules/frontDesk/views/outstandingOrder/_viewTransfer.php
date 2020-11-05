<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'transfer-grid',
    'dataProvider' => $transferRequestDataProvider,
    'filter' => $transferRequest,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'columns' => array(
        array(
            'name' => 'transfer_request_no',
            'value' => '$data->transfer_request_no',
            'type' => 'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'transfer_request_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->transfer_request_date)'
        ),
        'status_document',
        array('name' => 'requester_branch_id', 'value' => '$data->requesterBranch->name'),
        array('name' => 'requester_id', 'value' => '$data->user->username'),
        array(
            'header' => 'Status',
            'value' => '$data->totalRemainingQuantityDelivered',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{views}',
            'buttons' => array(
                'views' => array(
                    'label' => 'view',
                    'url' => 'Yii::app()->createUrl("frontDesk/outstandingOrder/viewTransfer", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>