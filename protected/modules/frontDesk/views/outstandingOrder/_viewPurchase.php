<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'transfer-grid',
    'dataProvider'=>$purchaseOrderDataProvider,
    'filter'=>$purchaseOrder,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'purchase_order_no', 
            'value'=>'$data->purchase_order_no', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'purchase_order_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->purchase_order_date)'
        ),
        'status_document',
        array('name'=>'main_branch_id','value'=>'$data->mainBranch->name'),
        array('name'=>'requester_id','value'=> '$data->user->username'),
        array(
            'header' => 'Status',
            'value' => '$data->totalRemainingQuantityReceived',
        ),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{views}',
			'buttons'=>array
			(
				'views' => array
				(
					'label'=>'view',
					'url'=>'Yii::app()->createUrl("frontDesk/outstandingOrder/viewPurchase", array("id"=>$data->id))',
				),
			),
		),
    ),
)); ?>