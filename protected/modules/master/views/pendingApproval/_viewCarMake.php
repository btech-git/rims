<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'sent-grid',
    'dataProvider'=>$carMakeDataProvider,
    'filter'=>$carMake,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns'=>array(
        array(
            'name'=>'name', 
            'value'=>'CHTml::link($data->name, array("/master/vehicleCarMake/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        'service_difficulty_rate',
        array(
            'header'=>'Status', 
            'name'=>'status',
            'value'=>'$data->status',
            'type'=>'raw',
            'filter'=>CHtml::dropDownList('VehicleCarMake[status]', 'vehicle_car_make_status', array(
                ''=>'Select',
                'Active' => 'Active',
                'Inactive' => 'Inactive',
            )),
        ),
        'user.username',
        array(
            'header' => 'Input', 
            'value' => '$data->created_datetime', 
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{approve} {reject}',
            'buttons'=>array (
                'approve' => array (
                    'label'=>'approve',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/makeApproval", array("makeId"=>$data->id))',
//                    'imageUrl'=> Yii::app()->baseUrl . '/images/icons/check_green.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Approve this car make?',
                    ),
                ),
                'reject' => array (
                    'label'=>'reject',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/makeReject", array("makeId"=>$data->id))',
                    'imageUrl'=> '/images/icons/cancel.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Reject this car make?',
                    ),
                ),
            ),
        ),
    ),
)); ?>