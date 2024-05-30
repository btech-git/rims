<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'purchase-order-grid',
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
        'total_price',
        array('name'=>'supplier_id','value'=>'$data->supplier->company'),
        'note',
        'status_document',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{views}',
            'buttons'=>array(
                'views' => array(
                    'label'=>'view',
                    'url'=>'Yii::app()->createUrl("transaction/transactionPurchaseOrder/view", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>