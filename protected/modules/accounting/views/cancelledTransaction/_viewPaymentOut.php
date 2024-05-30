<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'payment-out-grid',
    'dataProvider'=>$paymentOutDataProvider,
    'filter'=>$paymentOut,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'payment_number', 
            'value'=>'$data->payment_number', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'payment_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->payment_date)'
        ),
        array('name'=>'purchase_order_id','value'=>'empty($data->purchase_order_id) ? "" : $data->purchaseOrder->purchase_order_no'),
        'paymentType.name',
        array('name'=>'supplier_id','value'=>'empty($data->supplier_id) ? "" : $data->supplier->company'),
        'status',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{views}',
            'buttons'=>array(
                'views' => array(
                    'label'=>'view',
                    'url'=>'Yii::app()->createUrl("transaction/paymentOut/view", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>