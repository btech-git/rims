<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'purchase-grid',
    'dataProvider'=>$purchaseDataProvider,
    'filter'=>$purchase,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'purchase_order_no', 
            'value'=>'CHTml::link($data->purchase_order_no, array("/transaction/transactionPurchaseOrder/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'purchase_order_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->purchase_order_date)'
        ),
        'status_document',
        array('name'=>'requester_id','value'=> '$data->user->username'),
        array(
            'name' =>'main_branch_id',
            'value'=> 'CHtml::encode(CHtml::value($data, "mainBranch.name"))'
        ),
        array(
            'header' => 'Status',
            'value' => '$data->totalRemainingQuantityReceived',
        ),
        array(
            'header' => 'Input',
            'name' => 'created_datetime',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
        ),
    ),
)); ?>
