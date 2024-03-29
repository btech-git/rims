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
            'header'=>'Customer', 
            'value'=>'$data->customer->name'
        ),
        array(
            'header'=>'Plate #', 
            'value'=>'$data->vehicle->plate_number'
        ),
        array(
            'header'=>'Car Make', 
            'value'=>'CHtml::encode(CHtml::value($data, "vehicle.carMake.name"))'
        ),
        array(
            'header'=>'Car Model', 
            'value'=>'CHtml::encode(CHtml::value($data, "vehicle.carModel.name"))'
        ),
        array(
            'header'=>'WO #', 
            'value'=>'CHtml::link($data->work_order_number, array("/frontDesk/generalRepairManagement/viewDetailWorkOrder", "registrationId"=>$data->id), array("target" => "blank"))',
            'type'=>'raw',
        ),
        array(
            'header'=>'WO Date', 
            'filter' => false,
            'value'=>'$data->work_order_date',
        ),
        array(
            'header' => 'Duration (mnt)',
            'value' => '$data->total_time',
        ),
        array(
            'header'=>'Branch', 
            'value'=>'!empty($data->branch_id) ? $data->branch->code : "" '
        ),
    ),
)); ?>