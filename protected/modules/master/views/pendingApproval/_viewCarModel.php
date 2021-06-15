<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'sent-grid',
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
    ),
)); ?>