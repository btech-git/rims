<?php $this->widget('ext.groupgridview.GroupGridView', array(
    'id'=>'registration-transaction-grid',
    'dataProvider'=>$registrationHistoryDataProvider,
    'filter'=>null,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns'=>array(
        array(
            'header'=>'Plate Number', 
            'value'=>'$data->registrationTransaction->vehicle->plate_number'
        ),
        array(
            'header'=>'Car Make', 
            'value'=>'$data->registrationTransaction->vehicle->carMake->name'
        ),
        array(
            'header'=>'Car Model', 
            'value'=>'$data->registrationTransaction->vehicle->carModel->name'
        ),
        array(
            'header'=>'WO #', 
            'value'=>'$data->registrationTransaction->work_order_number'
        ),
        array(
            'name'=>'WO Date', 
            'filter' => false,
            'value'=>'$data->registrationTransaction->work_order_date',
        ),
        array(
            'header' => 'Duration (mnt)',
            'value' => '$data->total_time',
        ),
        array(
            'header'=>'Status',
            'value'=>'$data->registrationTransaction->service_status',
            'type'=>'raw',
            'filter'=> false,
        ),
        array(
            'header'=>'Branch', 
            'value'=>'!empty($data->registrationTransaction->branch_id) ? $data->registrationTransaction->branch->name : "" '
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{vw}',
            'buttons'=>array(
                'vw' => array(
                    'label'=>'detail',
                    'url'=>'Yii::app()->createUrl("frontDesk/bodyRepairMechanic/viewDetailWorkOrder", array("registrationId"=>$data->id))',
                    'options'=>array('target' => '_blank'),
                ),
            ),
        ),
    ),
)); ?>