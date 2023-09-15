<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'body-repair-grid',
    'dataProvider'=>$bodyRepairDataProvider,
    'filter'=>$registrationTransaction,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
        ),
    //'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'transaction_number', 
            'value'=>'$data->transaction_number', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'transaction_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->transaction_date)'
        ),
        'problem',
        array('name'=>'customer_id','value'=>'$data->customer->name'),
        array('name'=>'vehicle_id','value'=>'$data->vehicle->plate_number'),
        'status',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{views}',
            'buttons'=>array(
                'views' => array(
                    'label'=>'view',
                    'url'=>'Yii::app()->createUrl("frontDesk/bodyRepairRegistration/view", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>