<table style="border: 0px solid">
    <tr>
        <td style="border: 0px solid" colspan="2"><h1>List Vehicle</h1></td>
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

<div class="clear"></div>

<div class="row buttons" style="text-align: center">
    <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
</div>

<hr />

<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'vehicle-grid',
        'dataProvider'=>$vehicleDataProvider,
        'filter'=>null,
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
                'value'=>'CHtml::link($data->customer->name, array("/master/customer/view", "id"=>$data->customer_id), array("target" => "blank"))',
                'type'=>'raw'
            ),
            array(
                'header' => 'Type',
                'filter' => false,
                'value'=>'CHtml::encode(CHtml::value($data, "customer.customer_type"))'
            ),
            array(
                'header' => 'Kendaraan',
                'value' => '$data->carMakeModelSubCombination',
            ),
            array(
                'name'=>'color_id',
                'header'=>'Color',
                'value'=>'empty($data->color_id) ? "" : $data->color->name'
            ),
            array(
                'header' => 'Status Location',
                'value'=>'CHtml::encode(CHtml::value($data, "status_location"))'
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{location}',
                'buttons' => array(
                    'location' => array(
                        'label' => 'location',
                        'url' => 'Yii::app()->createUrl("master/vehicle/updateLocation", array("id"=>$data->id))',
//                        'visible' => 'Yii::app()->user->checkAccess("movementInEdit")', 
                    ),
                ),
            ),
        ),
    )); ?>
</div>