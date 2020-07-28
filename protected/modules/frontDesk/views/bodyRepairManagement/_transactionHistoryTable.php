<?php $this->widget('ext.groupgridview.GroupGridView', array(
    'id'=>'registration-transaction-grid',
    'dataProvider' => $historyDataProvider,
    'filter' => null,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns'=>array(
        array(
            'header'=>'Plate Number', 
            'value'=>'$data->vehicle->plate_number'
        ),
        array(
            'header'=>'Car Make', 
            'value'=>'$data->vehicle->carMake->name'
        ),
        array(
            'header'=>'Car Model', 
            'value'=>'$data->vehicle->carModel->name'
        ),
        array(
            'header'=>'WO #', 
            'value'=>'$data->work_order_number'
        ),
        array(
            'name'=>'WO Date', 
            'filter' => false,
            'value'=>'$data->work_order_date',
        ),
        array(
            'header' => 'Duration (mnt)',
            'value' => '$data->total_time',
        ),
        array(
            'header'=>'Status',
            'value'=>'$data->service_status',
            'type'=>'raw',
            'filter'=> false,
        ),
        array(
            'header'=>'Branch', 
            'value'=>'!empty($data->branch_id) ? $data->branch->name : "" '
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{vw}',
            'buttons'=>array(
                'vw' => array(
                    'label'=>'Show',
                    'url'=>'Yii::app()->createUrl("frontDesk/bodyRepairManagement/assignMechanic", array("registrationId"=>$data->id))',
                    'options'=>array('target' => '_blank'),
                ),
            ),
        ),
    ),
)); ?>