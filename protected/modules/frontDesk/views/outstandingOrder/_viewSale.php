<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'sent-grid',
    'dataProvider'=>$saleOrderDataProvider,
    'filter'=>$saleOrder,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'sale_order_no', 
            'value' => '$data->sale_order_no', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'sale_order_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->sale_order_date)'
        ),
        'status_document',
        array('name'=>'requester_branch_id','value'=>'$data->requesterBranch->name'),
        array('name'=>'requester_id','value'=> '$data->user->username'),
        array(
            'header' => 'Status',
            'value' => '$data->totalRemainingQuantityDelivered',
        ),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{views}',
			'buttons'=>array
			(
				'views' => array
				(
					'label'=>'view',
					'url'=>'Yii::app()->createUrl("frontDesk/outstandingOrder/viewSale", array("id"=>$data->id))',
				),
			),
		),
    ),
)); ?>