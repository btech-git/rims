<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'invoice-grid',
    'dataProvider'=>$invoiceHeaderDataProvider,
    'filter'=>$invoiceHeader,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'invoice_number', 
            'value'=>'$data->invoice_number', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'invoice_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->invoice_date)'
        ),
        'total_price',
        array('name'=>'customer_id','value'=>'empty($data->customer_id) ? "" : $data->customer->name'),
        array('name'=>'vehicle_id','value'=>'empty($data->vehicle_id) ? "" : $data->vehicle->plate_number'),
        'status',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{views}',
            'buttons'=>array(
                'views' => array(
                    'label'=>'view',
                    'url'=>'Yii::app()->createUrl("transaction/invoiceHeader/view", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>