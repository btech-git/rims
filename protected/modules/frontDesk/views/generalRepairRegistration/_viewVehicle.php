<fieldset>
    <legend>Vehicle</legend>
    <div class="row">
        <div class="large-12 columns">
            <div class="large-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Plate Number</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->vehicle->plate_number; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Machine Number</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->vehicle->machine_number; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Frame Number</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->vehicle->frame_number; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Chasis Code</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->vehicle->chasis_code; ?>"> 


                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Power CC</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->vehicle->power; ?>"> 
                        </div>
                    </div>
                </div>
            </div> <!-- end div large -->

            <div class="large-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Car Make</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->vehicle->carMake != NULL ? $model->vehicle->carMake->name : ''; ?>"> 
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Car Model</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->vehicle->carModel != NULL ? $model->vehicle->carModel->name : ''; ?>"> 
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Car Sub Model</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->vehicle->carSubModel != NULL ? $model->vehicle->carSubModel->name : ''; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Color</span>
                        </div>
                        <div class="small-8 columns">
                            <?php $color = Colors::model()->findByPK($model->vehicle->color_id); ?>
                            <input type="text" readonly="true" value="<?php echo empty($color) ? '' : $color->name; ?>"> 
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Mileage (KM)</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->vehicle_mileage; ?>"> 
                        </div>
                    </div>
                </div>
            </div><!-- end div large -->
        </div>
    </div>
</fieldset>