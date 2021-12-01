<?php $this->widget('ext.groupgridview.GroupGridView', array(
    'id'=>'registration-transaction-grid',
    'dataProvider'=>$registrationServiceHistoryDataProvider,
    'filter'=>null,
    'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
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
            'value'=>'CHtml::value($data, "registrationTransaction.vehicle.carMake.name")'
        ),
        array(
            'header'=>'Car Model', 
            'value'=>'CHtml::value($data, "registrationTransaction.vehicle.carModel.name")'
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
            'header'=>'WO Time', 
            'filter' => false,
            'value'=>'date("H:i:s", strtotime($data->registrationTransaction->transaction_date))',
        ),
        array(
            'header'=>'Service', 
            'value'=>'$data->service->name',
        ),
        array(
            'header'=>'Mechanic', 
            'value'=>'empty($data->finish_mechanic_id) ? "" : $data->finishMechanic->name',
        ),
        array(
            'header'=>'Repair Time', 
            'value'=>'$data->total_time',
        ),            
//        array(
//            'header'=>'Services',
//            'name'=>'search_service',
//            'type'=>'html',
//            'filter' => false,
//            'value'=>'$data->registrationTransaction->getServices()',
//        ),
//            array(
//                'header'=>'Duration',
//                'type'=>'html',
//                'value'=> function($data) {
//                    $duration = 0;
//                    $registrationServiceBodyRepairs = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$data->registration_transaction_id));
//                    foreach ($registrationServiceBodyRepairs as $rs) {
//                        $duration += $rs->hour;
//                    }
//                    return $duration . ' hr';
//                }
//            ),
        array(
            'header'=>'WO Status',
            'value'=>'$data->registrationTransaction->status',
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
                    'url'=>'Yii::app()->createUrl("frontDesk/generalRepairMechanic/viewDetailWorkOrder", array("registrationId"=>$data->registration_transaction_id))',
                    'options'=>array('target' => '_blank'),
                ),
            ),
        ),
    ),
)); ?>