<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'general-repair-grid',
    'dataProvider'=>$generalRepairDataProvider,
    'filter'=>false,
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
        array('name'=>'branch_id','value'=> '$data->branch->name'),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{views}',
            'buttons'=>array(
                'views' => array(
                    'label'=>'view',
                    'url'=>'Yii::app()->createUrl("frontDesk/generalRepairRegistration/view", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>