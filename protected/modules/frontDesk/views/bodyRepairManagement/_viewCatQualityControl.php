<div style="text-align: center">
    <legend><h3>Ready to QC</h3></legend>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold">Customer</th>
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
            <?php foreach ($qualityControlCatDataProvider->data as $model): ?>
                <tr>
                    <?php $registrationTransaction = $model->registrationTransaction; $vehicle = $registrationTransaction->vehicle; ?>
                    <td><?php echo $registrationTransaction->customer->name; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td><?php echo CHtml::link($registrationTransaction->work_order_number, array("/frontDesk/bodyRepairManagement/viewDetailWorkOrder", "registrationId"=>$registrationTransaction->id), array('target' => 'blank')); ?></td>
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