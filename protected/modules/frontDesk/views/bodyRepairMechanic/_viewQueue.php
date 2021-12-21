<div style="text-align: center">
    <legend><h3>Bongkar</h3></legend>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold">Plate #</th>
                <th style="text-align: center; font-weight: bold">Car Make</th>
                <th style="text-align: center; font-weight: bold">Car Model</th>
                <th style="text-align: center; font-weight: bold">WO #</th>
                <th style="text-align: center; font-weight: bold">WO Date</th>
                <th style="text-align: center; font-weight: bold">WO Time</th>
                <th style="text-align: center; font-weight: bold">Duration</th>
                <th style="text-align: center; font-weight: bold">Mechanic</th>
                <th style="text-align: center; font-weight: bold">Note</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($queueBongkarDataProvider->data as $model): ?>
                <tr>
                    <?php $registrationTransaction = $model->registrationTransaction; $vehicle = $registrationTransaction->vehicle; ?>
                    <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td><?php echo CHtml::link($registrationTransaction->work_order_number, array("/frontDesk/bodyRepairMechanic/viewDetailWorkOrder", "registrationId"=>$model->id), array('target' => 'blank')); ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $registrationTransaction->work_order_date); ?></td>
                    <td><?php echo date("H:i:s", strtotime($registrationTransaction->transaction_date)); ?></td>
                    <td><?php echo $registrationTransaction->total_time; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'mechanicAssigned.name')); ?></td>
                    <td><?php echo $registrationTransaction->note; ?></td>
                    <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>Assign Myself', Yii::app()->createUrl("frontDesk/bodyRepairMechanic/proceedToAssignedMechanic", array("id"=>$model->id)), array('class' => 'button warning')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<br />

<div style="text-align: center">
    <legend><h3>Spare Part</h3></legend>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold">Plate #</th>
                <th style="text-align: center; font-weight: bold">Car Make</th>
                <th style="text-align: center; font-weight: bold">Car Model</th>
                <th style="text-align: center; font-weight: bold">WO #</th>
                <th style="text-align: center; font-weight: bold">WO Date</th>
                <th style="text-align: center; font-weight: bold">WO Time</th>
                <th style="text-align: center; font-weight: bold">Duration</th>
                <th style="text-align: center; font-weight: bold">Mechanic</th>
                <th style="text-align: center; font-weight: bold">Note</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($queueSparePartDataProvider->data as $model): ?>
                <tr>
                    <?php $registrationTransaction = $model->registrationTransaction; $vehicle = $registrationTransaction->vehicle; ?>
                    <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td><?php echo CHtml::link($registrationTransaction->work_order_number, array("/frontDesk/bodyRepairMechanic/viewDetailWorkOrder", "registrationId"=>$model->id), array('target' => 'blank')); ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $registrationTransaction->work_order_date); ?></td>
                    <td><?php echo date("H:i:s", strtotime($registrationTransaction->transaction_date)); ?></td>
                    <td><?php echo $registrationTransaction->total_time; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'mechanicAssigned.name')); ?></td>
                    <td><?php echo $registrationTransaction->note; ?></td>
                    <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>Assign Myself', Yii::app()->createUrl("frontDesk/bodyRepairMechanic/proceedToAssignedMechanic", array("id"=>$model->id)), array('class' => 'button warning')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<br />

<div style="text-align: center">
    <legend><h3>Ketok / Las</h3></legend>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold">Plate #</th>
                <th style="text-align: center; font-weight: bold">Car Make</th>
                <th style="text-align: center; font-weight: bold">Car Model</th>
                <th style="text-align: center; font-weight: bold">WO #</th>
                <th style="text-align: center; font-weight: bold">WO Date</th>
                <th style="text-align: center; font-weight: bold">WO Time</th>
                <th style="text-align: center; font-weight: bold">Duration</th>
                <th style="text-align: center; font-weight: bold">Mechanic</th>
                <th style="text-align: center; font-weight: bold">Note</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($queueKetokDataProvider->data as $model): ?>
                <tr>
                    <?php $registrationTransaction = $model->registrationTransaction; $vehicle = $registrationTransaction->vehicle; ?>
                    <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td><?php echo CHtml::link($registrationTransaction->work_order_number, array("/frontDesk/bodyRepairMechanic/viewDetailWorkOrder", "registrationId"=>$model->id), array('target' => 'blank')); ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $registrationTransaction->work_order_date); ?></td>
                    <td><?php echo date("H:i:s", strtotime($registrationTransaction->transaction_date)); ?></td>
                    <td><?php echo $registrationTransaction->total_time; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'mechanicAssigned.name')); ?></td>
                    <td><?php echo $registrationTransaction->note; ?></td>
                    <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>Assign Myself', Yii::app()->createUrl("frontDesk/bodyRepairMechanic/proceedToAssignedMechanic", array("id"=>$model->id)), array('class' => 'button warning')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<br />

<div style="text-align: center">
    <legend><h3>Dempul</h3></legend>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold">Plate #</th>
                <th style="text-align: center; font-weight: bold">Car Make</th>
                <th style="text-align: center; font-weight: bold">Car Model</th>
                <th style="text-align: center; font-weight: bold">WO #</th>
                <th style="text-align: center; font-weight: bold">WO Date</th>
                <th style="text-align: center; font-weight: bold">WO Time</th>
                <th style="text-align: center; font-weight: bold">Duration</th>
                <th style="text-align: center; font-weight: bold">Mechanic</th>
                <th style="text-align: center; font-weight: bold">Note</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($queueDempulDataProvider->data as $model): ?>
                <tr>
                    <?php $registrationTransaction = $model->registrationTransaction; $vehicle = $registrationTransaction->vehicle; ?>
                    <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td><?php echo CHtml::link($registrationTransaction->work_order_number, array("/frontDesk/bodyRepairMechanic/viewDetailWorkOrder", "registrationId"=>$registrationTransaction->id), array('target' => 'blank')); ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $registrationTransaction->work_order_date); ?></td>
                    <td><?php echo date("H:i:s", strtotime($registrationTransaction->transaction_date)); ?></td>
                    <td><?php echo $registrationTransaction->total_time; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'mechanicAssigned.name')); ?></td>
                    <td><?php echo $registrationTransaction->note; ?></td>
                    <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>Assign Myself', Yii::app()->createUrl("frontDesk/bodyRepairMechanic/proceedToAssignedMechanic", array("id"=>$model->id)), array('class' => 'button warning')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<br />

<div style="text-align: center">
    <legend><h3>Epoxy</h3></legend>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold">Plate #</th>
                <th style="text-align: center; font-weight: bold">Car Make</th>
                <th style="text-align: center; font-weight: bold">Car Model</th>
                <th style="text-align: center; font-weight: bold">WO #</th>
                <th style="text-align: center; font-weight: bold">WO Date</th>
                <th style="text-align: center; font-weight: bold">WO Time</th>
                <th style="text-align: center; font-weight: bold">Duration</th>
                <th style="text-align: center; font-weight: bold">Mechanic</th>
                <th style="text-align: center; font-weight: bold">Note</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($queueEpoxyDataProvider->data as $model): ?>
                <tr>
                    <?php $registrationTransaction = $model->registrationTransaction; $vehicle = $registrationTransaction->vehicle; ?>
                    <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td><?php echo CHtml::link($registrationTransaction->work_order_number, array("/frontDesk/bodyRepairMechanic/viewDetailWorkOrder", "registrationId"=>$registrationTransaction->id), array('target' => 'blank')); ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $registrationTransaction->work_order_date); ?></td>
                    <td><?php echo date("H:i:s", strtotime($registrationTransaction->transaction_date)); ?></td>
                    <td><?php echo $registrationTransaction->total_time; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'mechanicAssigned.name')); ?></td>
                    <td><?php echo $registrationTransaction->note; ?></td>
                    <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>Assign Myself', Yii::app()->createUrl("frontDesk/bodyRepairMechanic/proceedToAssignedMechanic", array("id"=>$model->id)), array('class' => 'button warning')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<br />

<div style="text-align: center">
    <legend><h3>Cat</h3></legend>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold">Plate #</th>
                <th style="text-align: center; font-weight: bold">Car Make</th>
                <th style="text-align: center; font-weight: bold">Car Model</th>
                <th style="text-align: center; font-weight: bold">WO #</th>
                <th style="text-align: center; font-weight: bold">WO Date</th>
                <th style="text-align: center; font-weight: bold">WO Time</th>
                <th style="text-align: center; font-weight: bold">Duration</th>
                <th style="text-align: center; font-weight: bold">Mechanic</th>
                <th style="text-align: center; font-weight: bold">Note</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($queueCatDataProvider->data as $model): ?>
                <tr>
                    <?php $registrationTransaction = $model->registrationTransaction; $vehicle = $registrationTransaction->vehicle; ?>
                    <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td><?php echo CHtml::link($registrationTransaction->work_order_number, array("/frontDesk/bodyRepairMechanic/viewDetailWorkOrder", "registrationId"=>$registrationTransaction->id), array('target' => 'blank')); ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $registrationTransaction->work_order_date); ?></td>
                    <td><?php echo date("H:i:s", strtotime($registrationTransaction->transaction_date)); ?></td>
                    <td><?php echo $registrationTransaction->total_time; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'mechanicAssigned.name')); ?></td>
                    <td><?php echo $registrationTransaction->note; ?></td>
                    <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>Assign Myself', Yii::app()->createUrl("frontDesk/bodyRepairMechanic/proceedToAssignedMechanic", array("id"=>$model->id)), array('class' => 'button warning')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<br />

<div style="text-align: center">
    <legend><h3>Pasang</h3></legend>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold">Plate #</th>
                <th style="text-align: center; font-weight: bold">Car Make</th>
                <th style="text-align: center; font-weight: bold">Car Model</th>
                <th style="text-align: center; font-weight: bold">WO #</th>
                <th style="text-align: center; font-weight: bold">WO Date</th>
                <th style="text-align: center; font-weight: bold">WO Time</th>
                <th style="text-align: center; font-weight: bold">Duration</th>
                <th style="text-align: center; font-weight: bold">Mechanic</th>
                <th style="text-align: center; font-weight: bold">Note</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($queuePasangDataProvider->data as $model): ?>
                <tr>
                    <?php $registrationTransaction = $model->registrationTransaction; $vehicle = $registrationTransaction->vehicle; ?>
                    <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td><?php echo CHtml::link($registrationTransaction->work_order_number, array("/frontDesk/bodyRepairMechanic/viewDetailWorkOrder", "registrationId"=>$registrationTransaction->id), array('target' => 'blank')); ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $registrationTransaction->work_order_date); ?></td>
                    <td><?php echo date("H:i:s", strtotime($registrationTransaction->transaction_date)); ?></td>
                    <td><?php echo $registrationTransaction->total_time; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'mechanicAssigned.name')); ?></td>
                    <td><?php echo $registrationTransaction->note; ?></td>
                    <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>Assign Myself', Yii::app()->createUrl("frontDesk/bodyRepairMechanic/proceedToAssignedMechanic", array("id"=>$model->id)), array('class' => 'button warning')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<br />

<div style="text-align: center">
    <legend><h3>Cuci</h3></legend>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold">Plate #</th>
                <th style="text-align: center; font-weight: bold">Car Make</th>
                <th style="text-align: center; font-weight: bold">Car Model</th>
                <th style="text-align: center; font-weight: bold">WO #</th>
                <th style="text-align: center; font-weight: bold">WO Date</th>
                <th style="text-align: center; font-weight: bold">WO Time</th>
                <th style="text-align: center; font-weight: bold">Duration</th>
                <th style="text-align: center; font-weight: bold">Mechanic</th>
                <th style="text-align: center; font-weight: bold">Note</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($queueCuciDataProvider->data as $model): ?>
                <tr>
                    <?php $registrationTransaction = $model->registrationTransaction; $vehicle = $registrationTransaction->vehicle; ?>
                    <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td><?php echo CHtml::link($registrationTransaction->work_order_number, array("/frontDesk/bodyRepairMechanic/viewDetailWorkOrder", "registrationId"=>$registrationTransaction->id), array('target' => 'blank')); ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $registrationTransaction->work_order_date); ?></td>
                    <td><?php echo date("H:i:s", strtotime($registrationTransaction->transaction_date)); ?></td>
                    <td><?php echo $registrationTransaction->total_time; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'mechanicAssigned.name')); ?></td>
                    <td><?php echo $registrationTransaction->note; ?></td>
                    <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>Assign Myself', Yii::app()->createUrl("frontDesk/bodyRepairMechanic/proceedToAssignedMechanic", array("id"=>$model->id)), array('class' => 'button warning')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<br />

<div style="text-align: center">
    <legend><h3>Poles</h3></legend>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold">Plate #</th>
                <th style="text-align: center; font-weight: bold">Car Make</th>
                <th style="text-align: center; font-weight: bold">Car Model</th>
                <th style="text-align: center; font-weight: bold">WO #</th>
                <th style="text-align: center; font-weight: bold">WO Date</th>
                <th style="text-align: center; font-weight: bold">WO Time</th>
                <th style="text-align: center; font-weight: bold">Duration</th>
                <th style="text-align: center; font-weight: bold">Mechanic</th>
                <th style="text-align: center; font-weight: bold">Note</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($queuePolesDataProvider->data as $model): ?>
                <tr>
                    <?php $registrationTransaction = $model->registrationTransaction; $vehicle = $registrationTransaction->vehicle; ?>
                    <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td><?php echo CHtml::link($registrationTransaction->work_order_number, array("/frontDesk/bodyRepairMechanic/viewDetailWorkOrder", "registrationId"=>$registrationTransaction->id), array('target' => 'blank')); ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $registrationTransaction->work_order_date); ?></td>
                    <td><?php echo date("H:i:s", strtotime($registrationTransaction->transaction_date)); ?></td>
                    <td><?php echo $registrationTransaction->total_time; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'mechanicAssigned.name')); ?></td>
                    <td><?php echo $registrationTransaction->note; ?></td>
                    <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>Assign Myself', Yii::app()->createUrl("frontDesk/bodyRepairMechanic/proceedToAssignedMechanic", array("id"=>$model->id)), array('class' => 'button warning')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>