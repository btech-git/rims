<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'receive-item-grid',
    'dataProvider'=>$receiveItemDataProvider,
    'filter'=>$receiveItem,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'receive_item_no', 
            'value'=>'$data->receive_item_no', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'receive_item_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->receive_item_date)'
        ),
        'request_type',
        array('name'=>'supplier_id','value'=>'empty($data->supplier_id) ? "" :$data->supplier->company'),
        'note',
        array(
            'header' => 'Cancelled by',
            'name' => 'user_id_cancelled',
            'filter' => false,
            'value' => 'empty($data->user_id_cancelled) ? "" : $data->userIdCancelled->username',
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{views}',
            'buttons'=>array(
                'views' => array(
                    'label'=>'view',
                    'url'=>'Yii::app()->createUrl("transaction/transactionReceiveItem/view", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>