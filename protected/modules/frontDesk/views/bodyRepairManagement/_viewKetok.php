<div style="text-align: center">
    <legend><h3>Service Queue</h3></legend>
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
                    <td><?php echo $registrationTransaction->work_order_number; ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $registrationTransaction->work_order_date); ?></td>
                    <td><?php echo date("H:i:s", strtotime($registrationTransaction->transaction_date)); ?></td>
                    <td><?php echo $registrationTransaction->total_time; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'mechanicAssigned.name')); ?></td>
                    <td><?php echo $registrationTransaction->note; ?></td>
                    <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>Assign Mechanic', Yii::app()->createUrl("frontDesk/bodyRepairManagement/assignMechanic", array("id"=>$model->id)), array('class' => 'button warning', 'target' => '_blank')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<br />

<div style="text-align: center">
    <legend><h3>Assigned</h3></legend>
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
            <?php foreach ($assignKetokDataProvider->data as $model): ?>
                <tr>
                    <?php $registrationTransaction = $model->registrationTransaction; $vehicle = $registrationTransaction->vehicle; ?>
                    <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td><?php echo $registrationTransaction->work_order_number; ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $registrationTransaction->work_order_date); ?></td>
                    <td><?php echo date("H:i:s", strtotime($registrationTransaction->transaction_date)); ?></td>
                    <td><?php echo $registrationTransaction->total_time; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'mechanicAssigned.name')); ?></td>
                    <td><?php echo $registrationTransaction->note; ?></td>
                    <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>Processing', Yii::app()->createUrl("frontDesk/bodyRepairManagement/startProcessingKetok", array("id"=>$model->id)), array('class' => 'button success')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<br />

<div style="text-align: center">
    <legend><h3>On Progress</h3></legend>
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
            <?php foreach ($progressKetokDataProvider->data as $model): ?>
                <tr>
                    <?php $registrationTransaction = $model->registrationTransaction; $vehicle = $registrationTransaction->vehicle; ?>
                    <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td><?php echo $registrationTransaction->work_order_number; ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $registrationTransaction->work_order_date); ?></td>
                    <td><?php echo date("H:i:s", strtotime($registrationTransaction->transaction_date)); ?></td>
                    <td><?php echo $registrationTransaction->total_time; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'mechanicAssigned.name')); ?></td>
                    <td><?php echo $registrationTransaction->note; ?></td>
                    <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>QC', Yii::app()->createUrl("frontDesk/bodyRepairManagement/proceedToQualityControlKetok", array("id"=>$model->id)), array('class' => 'button success')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<br />

<div style="text-align: center">
    <legend><h3>Ready to QC</h3></legend>
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
            <?php foreach ($qualityControlKetokDataProvider->data as $model): ?>
                <tr>
                    <?php $registrationTransaction = $model->registrationTransaction; $vehicle = $registrationTransaction->vehicle; ?>
                    <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td><?php echo $registrationTransaction->work_order_number; ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $registrationTransaction->work_order_date); ?></td>
                    <td><?php echo date("H:i:s", strtotime($registrationTransaction->transaction_date)); ?></td>
                    <td><?php echo $registrationTransaction->total_time; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'mechanicAssigned.name')); ?></td>
                    <td><?php echo $registrationTransaction->note; ?></td>
                    <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>Pass/Fail', Yii::app()->createUrl("frontDesk/bodyRepairManagement/checkQuality", array("registrationId"=>$model->registration_transaction_id)), array('class' => 'button success')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<br />

<div style="text-align: center">
    <legend><h3>Finished</h3></legend>
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
            </tr>
        </thead>

        <tbody>
            <?php foreach ($finishedKetokDataProvider->data as $model): ?>
                <tr>
                    <?php $registrationTransaction = $model->registrationTransaction; $vehicle = $registrationTransaction->vehicle; ?>
                    <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td><?php echo $registrationTransaction->work_order_number; ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $registrationTransaction->work_order_date); ?></td>
                    <td><?php echo date("H:i:s", strtotime($registrationTransaction->transaction_date)); ?></td>
                    <td><?php echo $registrationTransaction->total_time; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'mechanicAssigned.name')); ?></td>
                    <td><?php echo $registrationTransaction->note; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>