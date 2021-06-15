<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'sent-grid',
    'dataProvider'=>$carMakeDataProvider,
    'filter'=>$carMake,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    //'summaryText'=>'',
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
    ),
)); ?>