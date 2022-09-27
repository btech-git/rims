<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'request-grid',
    'dataProvider'=>$requestDataProvider,
    'filter'=>$request,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    //'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'request_order_no', 
            'value'=>'CHTml::link($data->request_order_no, array("/transaction/transactionRequestOrder/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'request_order_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->request_order_date)'
        ),
        'status_document',
        array(
            'name'=>'main_branch_id',
            'value'=>'$data->mainBranch->name'
        ),
        array(
            'name'=>'requester_branch_id',
            'value'=>'$data->requesterBranch->name'
        ),
        array(
            'name'=>'requester_id',
            'value'=> '$data->user->username'
        ),
        array(
            'header' => 'Input',
            'name' => 'created_datetime',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
        ),
    ),
)); ?>
