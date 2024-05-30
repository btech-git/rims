<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'car-model-grid',
    'dataProvider'=>$carModelDataProvider,
    'filter'=>$carModel,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    //'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'name', 
            'value'=>'CHTml::link($data->name, array("/master/vehicleCarModel/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        'description',
        'carMake.name',
        array(
            'header'=>'Status', 
            'name'=>'status',
            'value'=>'$data->status',
            'type'=>'raw',
            'filter'=>CHtml::dropDownList('VehicleCarModel[status]', 'vehicle_car_model_status', array(
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
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/modelApproval", array("modelId"=>$data->id))',
//                    'imageUrl'=> Yii::app()->baseUrl . '/images/icons/check_green.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Approve this car model?',
                    ),
                ),
                'reject' => array (
                    'label'=>'reject',
                    'url'=>'Yii::app()->createUrl("master/pendingApproval/modelReject", array("modelId"=>$data->id))',
                    'imageUrl'=> '/images/icons/cancel.png',
                    'options' => array(
                        'confirm' => 'Are you sure to Reject this car model?',
                    ),
                ),
            ),
        ),
    ),
)); ?>