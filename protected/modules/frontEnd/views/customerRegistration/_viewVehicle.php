<table style="border: 0px solid">
    <tr>
        <td style="border: 0px solid" colspan="2"><h1>List Vehicle</h1></td>
        <td style="border: 0px solid">
            <?php echo CHtml::link('<span class="fa fa-archive"></span>Manage GR', array('/frontDesk/generalRepairRegistration/admin'), array('class'=>'button success right')); ?>
        </td>
        <td style="border: 0px solid" colspan="2">
            <?php echo CHtml::link('<span class="fa fa-archive"></span>Manage BR', array('/frontDesk/bodyRepairRegistration/admin'), array('class'=>'button success left')); ?>
        </td>
    </tr>
    <tr>
        <td>No Polisi</td>
        <td>
            <?php echo CHtml::activeTextField($vehicle, 'plate_number', array(
                'onchange' => '
                    $.fn.yiiGridView.update("vehicle-grid", {data: {
                        Vehicle: {
                            plate_number: $(this).val(),
                            car_make_id: $("#' . CHtml::activeId($vehicle, 'car_make_id') . '").val(),
                            car_model_id: $("#' . CHtml::activeId($vehicle, 'car_model_id') . '").val(),
                            car_sub_model_id: $("#' . CHtml::activeId($vehicle, 'car_sub_model_id') . '").val(),
                        }
                    }});
                ',
            )); ?>
        </td>
        <td>Merk</td>
        <td>
            <?php echo CHtml::activeDropDownList($vehicle, 'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
                'onchange' => CHtml::ajax(array(
                        'type' => 'GET',
                        'url' => CController::createUrl('ajaxHtmlUpdateCarModelSelect'),
                        'update' => '#car_model',
                    )) . '
                    $.fn.yiiGridView.update("vehicle-grid", {data: {
                        Vehicle: {
                            plate_number: $("#' . CHtml::activeId($vehicle, 'plate_number') . '").val(),
                            car_make_id: $(this).val(),
                            car_model_id: $("#' . CHtml::activeId($vehicle, 'car_model_id') . '").val(),
                            car_sub_model_id: $("#' . CHtml::activeId($vehicle, 'car_sub_model_id') . '").val(),
                        }
                    }});
                ',
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Model</td>
        <td>
            <div id="car_model">
                <?php echo CHtml::activeDropDownList($vehicle, 'car_model_id', CHtml::listData(VehicleCarModel::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
                    'onchange' => CHtml::ajax(array(
                        'type' => 'GET',
                        'url' => CController::createUrl('ajaxHtmlUpdateCarSubModelSelect'),
                        'update' => '#car_sub_model',
                    )) . '
                    $.fn.yiiGridView.update("vehicle-grid", {data: {
                        Vehicle: {
                            plate_number: $("#' . CHtml::activeId($vehicle, 'plate_number') . '").val(),
                            car_make_id: $("#' . CHtml::activeId($vehicle, 'car_make_id') . '").val(),
                            car_model_id: $(this).val(),
                            car_sub_model_id: $("#' . CHtml::activeId($vehicle, 'car_sub_model_id') . '").val(),
                        }
                    }});
                    ',
                )); ?>
            </div>
        </td>
        <td>Sub Model</td>
        <td>
            <div id="car_sub_model">
                <?php echo CHtml::activeDropDownList($vehicle, 'car_sub_model_id', CHtml::listData(VehicleCarSubModel::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
                    'onchange' => '
                        $.fn.yiiGridView.update("vehicle-grid", {data: {
                            Vehicle: {
                                plate_number: $("#' . CHtml::activeId($vehicle, 'plate_number') . '").val(),
                                car_make_id: $("#' . CHtml::activeId($vehicle, 'car_make_id') . '").val(),
                                car_model_id: $("#' . CHtml::activeId($vehicle, 'car_model_id') . '").val(),
                                car_sub_model_id: $(this).val(),
                            }
                        }});
                    ',
                )); ?>
            </div>
        </td>
    </tr>
</table>

<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'vehicle-grid',
        'dataProvider' => $vehicleDataProvider,
        'filter' => null,
        'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'columns' => array(
            array(
                'header' => 'ID',
                'name' => 'customer_id',
                'value' => 'CHtml::value($data, "customer_id")',
            ),
            array(
                'header' => 'Plate #',
                'name' => 'plate_number',
                'value' => 'CHtml::link($data->plate_number, array("/master/vehicle/view", "id"=>$data->id), array("target" => "_blank"))',
                'type'=>'raw',
            ),
            array(
                'header' => 'Car Make',
                'name' => 'car_make_id',
                'filter' => CHtml::activeDropDownList($vehicle, 'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                    'empty' => ''
                )),
                'value' => 'CHtml::value($data, "carMake.name")',
            ),
            array(
                'header' => 'Car Model',
                'name' => 'car_model_id',
                'filter' => CHtml::activeDropDownList($vehicle, 'car_model_id', CHtml::listData(VehicleCarModel::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                    'empty' => ''
                )),
                'value' => 'CHtml::value($data, "carModel.name")',
            ),
            array(
                'header' => 'Color',
                'name' => 'color_id',
                'filter' => CHtml::activeDropDownList($vehicle, 'color_id', CHtml::listData(Colors::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                    'empty' => ''
                )),
                'value' => '$data->getColor($data, "color_id")',
            ),
            array(
                'header' => 'Customer',
                'value' => '$data->customer->name',
//                'value' => 'CHtml::link($data->customer->name, array("/master/customer/view", "id"=>$data->customer_id), array("target" => "_blank"))',
                'type'=>'raw',
            ),
            array(
                'header' => 'Type',
                'filter' => false,
                'value' => 'CHtml::value($data, "customer.customer_type")',
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("GR", array("/frontDesk/generalRepairRegistration/create", "vehicleId"=>$data->id))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("BR", array("/frontDesk/bodyRepairRegistration/create", "vehicleId"=>$data->id))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
        ),
    )); ?>
</div>