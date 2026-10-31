<div id="vehicle">
    <fieldset>
        <legend>Vehicle</legend>
        <?php
        $vehicleId = $plate = $machine = $frame = $chasis = $power = $carMake = $carModel = $carSubModel = $carColor = "";
        if ($model->vehicle_id != "") {
            $vehicle = Vehicle::model()->findByPk($model->vehicle_id);
            if (!empty($vehicle)) {
                $vehicleId = $vehicle->id;
                $plate = $vehicle->plate_number != "" ? $vehicle->plate_number : '';
                $machine = $vehicle->machine_number != "" ? $vehicle->machine_number : '';
                $frame = $vehicle->frame_number != "" ? $vehicle->frame_number : '';
                $chasis = $vehicle->chasis_code != "" ? $vehicle->chasis_code : '';
                $power = $vehicle->power != "" ? $vehicle->power : '';
                $carMake = $vehicle->car_make_id != "" ? $vehicle->carMake->name : '';
                $carModel = $vehicle->car_model_id != "" ? $vehicle->carModel->name : '';
                $carSubModel = $vehicle->car_sub_model_detail_id != "" ? $vehicle->carSubModel->name : '';
                $carColor = $vehicle->color_id != "" ? Colors:: model()->findByPk($vehicle->color_id)->name : '';
            }
        }
        ?>
        <table>
            <thead>
                <tr>
                    <td>No Pol</td>
                    <td>Mesin #</td>
                    <td>Frame #</td>
                    <td>Chassis</td>
                    <td>Power CC</td>
                    <td>Car Make</td>
                    <td>Model</td>
                    <td>Sub Model</td>
                    <td>Color</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo $form->hiddenField($model, 'vehicle_id', array('readonly' => true)); ?>
                        <input type="text" readonly="true" id="Vehicle_plate_number" value="<?php echo $plate != "" ? $plate : ''; ?>"> 
                    </td>
                    <td><input type="text" readonly="true" id="Vehicle_machine_number" value="<?php echo $machine != "" ? $machine : ''; ?>"></td>
                    <td><input type="text" readonly="true" id="Vehicle_frame_number" value="<?php echo $frame != "" ? $frame : ''; ?>"></td>
                    <td><input type="text" readonly="true" id="Vehicle_chasis_code" value="<?php echo $chasis != "" ? $chasis : ''; ?>"></td>
                    <td><input type="text" readonly="true" id="Vehicle_power" value="<?php echo $power != "" ? $power : ''; ?>"></td>
                    <td><input type="text" readonly="true" id="Vehicle_car_make_name" value="<?php echo $carMake != "" ? $carMake : ''; ?>"></td>
                    <td><input type="text" readonly="true" id="Vehicle_car_model_name" value="<?php echo $carModel != "" ? $carModel : ''; ?>"></td>
                    <td><input type="text" readonly="true" id="Vehicle_car_sub_model_name" value="<?php echo $carSubModel != "" ? $carSubModel : ''; ?>"></td>
                    <td><input type="text" readonly="true" id="Vehicle_car_color_name" value="<?php echo $carColor != "" ? $carColor : ''; ?>"></td>
                </tr>
            </tbody>
        </table>
    </fieldset>
</div>