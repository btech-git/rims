<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'sales-grid',
    'dataProvider'=>$salesDataProvider,
    'filter'=>$sales,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        //'id',
        //'code',
        array(
            'name'=>'sale_order_no', 
            'value'=>'CHTml::link($data->sale_order_no, array("/transaction/transactionSalesOrder/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        // 'purchase_order_no',
        array(
            'header' => 'Tanggal',
            'name' => 'sale_order_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->sale_order_date)'
        ),
        'status_document',
        array('name'=>'requester_branch_id','value'=>'$data->requesterBranch->name'),
        array('name'=>'requester_id','value'=> '$data->user->employee->name'),
        array(
            'header' => 'Status',
            'value' => '$data->totalRemainingQuantityDelivered',
        ),
    ),
)); ?>