<?php echo CHtml::beginForm(); ?>
    <div class="row">
        <h2>Data Kendaraan</h2>
        <div class="col">
            <div class="my-2 row">
                <label class="col col-form-label">No Polisi</label>
                <div class="col">
                    <?php echo CHtml::activeTextField($vehicle, 'plate_number', array(
                        'class' => 'form-select',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateVehicleDataTable'),
                            'update' => '#vehicle_data_container',
                        )),
                    )); ?>
                </div>
                <label class="col col-form-label">Merk</label>
                <div class="col">
                    <?php echo CHtml::activeDropDownList($vehicle, 'car_make_id', CHtml::listData(VehicleCarMake::model()->findAll(), 'id', 'name'), array(
                        'empty' => '-- All --',
                        'class' => 'form-select',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateCarModelSelect'),
                            'update' => '#car_model',
                        )) . 
                        CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateVehicleDataTable'),
                            'update' => '#vehicle_data_container',
                        )),
                    )); ?>
                </div>
            </div>
            <div class="my-2 row">
                <label class="col col-form-label">Model</label>
                <div class="col">
                    <div id="car_model">
                        <?php echo CHtml::activeDropDownList($vehicle, 'car_model_id', CHtml::listData(VehicleCarModel::model()->findAll(), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'class' => 'form-select',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateCarSubModelSelect'),
                                'update' => '#car_sub_model',
                            )) . 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateVehicleDataTable'),
                                'update' => '#vehicle_data_container',
                            )),
                        )); ?>
                    </div>
                </div>
                <label class="col col-form-label">Sub Model</label>
                <div class="col">
                    <div id="car_sub_model">
                        <?php echo CHtml::activeDropDownList($vehicle, 'car_sub_model_id', CHtml::listData(VehicleCarSubModel::model()->findAll(), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'class' => 'form-select',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateVehicleDataTable'),
                                'update' => '#vehicle_data_container',
                            )),
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter', 'class' => 'btn btn-danger'));  ?>
    </div>

    <hr />

    <div id="vehicle_data_container">
        <?php $this->renderPartial('_vehicleDataTable', array(
            'vehicleDataProvider' => $vehicleDataProvider,
        )); ?>
    </div>
<?php echo CHtml::endForm(); ?>