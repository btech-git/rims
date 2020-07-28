<?php $this->widget('ext.groupgridview.GroupGridView', array(
    'id'=>'registration-service-assignment-grid',
    'dataProvider'=>$registrationServiceAssignmentDataProvider,
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
            'header'=>'Services',
            'name'=>'search_service',
            'type'=>'html',
            'filter' => false,
            'value'=>'$data->registrationTransaction->getServices()',
        ),
        array(
            'header'=>'Duration',
            'type'=>'html',
            'value'=> function($data) {
                $duration = 0;
                $registrationServiceBodyRepairs = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$data->registration_transaction_id));
                foreach ($registrationServiceBodyRepairs as $rs) {
                    $duration += $rs->hour;
                }
                return $duration . ' hr';
            }
        ),
        array(
            'header'=>'WO Status',
            'value'=>'$data->registrationTransaction->status',
            'type'=>'raw',
            'filter'=> false,
        ),
        array(
            'header'=>'branch', 
            'value'=>'!empty($data->registrationTransaction->branch_id) ? $data->registrationTransaction->branch->name : "" '
        ),
    ),
)); ?>