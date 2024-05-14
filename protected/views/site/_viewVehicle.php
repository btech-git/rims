<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'vehicle-grid',
        'dataProvider'=>$vehicleDataProvider,
        'filter'=>$vehicle,
        // 'summaryText' => '',
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'columns'=>array(
            'id',
            array(
                'name'=>'plate_number', 
                'value'=>'CHtml::link($data->plate_number, array("/master/vehicle/view", "id"=>$data->id), array("target" => "blank"))', 
                'type'=>'raw'
            ),
            array(
                'name'=>'customer_name',
                'header' => 'Customer',
                'filter' => CHtml::textField('CustomerName', $customerName),
                'value'=>'CHtml::link($data->customer->name, array("/master/customer/view", "id"=>$data->customer_id), array("target" => "blank"))',
                'type'=>'raw'
            ),
            array(
                'header' => 'Phone',
                'filter' => false,
                'value'=>'CHtml::encode(CHtml::value($data, "customer.mobilePhone"))'
            ),
            array(
                'name'=>'car_make_id',
                'header' => 'Car Make',
                'filter' => CHtml::activeDropDownList($vehicle, 'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                'value'=>'empty($data->car_make_id) ? "" : $data->carMake->name'
            ),
            array(
                'name'=>'car_model_id',
                'filter' => CHtml::activeDropDownList($vehicle, 'car_model_id', CHtml::listData(VehicleCarModel::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                'value'=>'empty($data->car_model_id) ? "" : $data->carModel->name'
            ),
            array(
                'name'=>'color_id',
                'header'=>'Color',
                'filter' => CHtml::activeDropDownList($vehicle, 'color_id', CHtml::listData(Colors::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                'value'=>'empty($data->color_id) ? "" : $data->color->name'
            ),
        ),
    )); ?>
</div>