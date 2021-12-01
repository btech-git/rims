<table>
    <thead>
        <tr>
            <th style="text-align: center; font-weight: bold">Plate #</th>
            <th style="text-align: center; font-weight: bold">Car Make</th>
            <th style="text-align: center; font-weight: bold">Car Model</th>
            <th style="text-align: center; font-weight: bold">WO #</th>
            <th style="text-align: center; font-weight: bold">WO Date</th>
            <th style="text-align: center; font-weight: bold">WO Time</th>
            <th style="text-align: center; font-weight: bold">Service</th>
            <th style="text-align: center; font-weight: bold">Duration</th>
            <th style="text-align: center; font-weight: bold">WO Status</th>
            <th style="text-align: center; font-weight: bold">Branch</th>
            <th style="text-align: center; font-weight: bold">Priority</th>
            <!--<th></th>-->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($registrationServiceDataProvider->data as $model): ?>
            <?php if ($model->service->service_type_id === $serviceType->id): ?>
                <tr>
                    <?php /*
                    $duration = 0;
                    foreach ($regServices as $key => $regService) {
                        $duration += $model->service->flat_rate_hour;
                    }*/ ?>
                    <?php 
                    $registrationTransaction = $model->registrationTransaction;
                    $vehicle = $registrationTransaction->vehicle; 
                    ?>
                    <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td><?php echo CHtml::link($registrationTransaction->work_order_number, array("/frontDesk/registrationTransaction/view", "id"=>$registrationTransaction->id), array('target' => 'blank')); ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $registrationTransaction->work_order_date); ?></td>
                    <td><?php echo date("H:i:s", strtotime($registrationTransaction->transaction_date)); ?></td>
                    <td><?php echo $model->service->name; ?></td>
                    <td><?php echo $model->service->flat_rate_hour; ?></td>
                    <td><?php echo $registrationTransaction->status != null ? $registrationTransaction->status : '-'; ?></td>
                    <td><?php echo $registrationTransaction->branch_id != null ? $registrationTransaction->branch->code : '-'; ?></td>
                    <td><?php echo $registrationTransaction->getPriorityLiteral($registrationTransaction->priority_level); ?></td>
                    <!--<td><?php // echo CHtml::link('<span class="fa fa-wrench"></span>Detail', Yii::app()->createUrl("frontDesk/generalRepairMechanic/viewDetailWorkOrder", array("registrationId"=>$registrationTransaction->id)), array('class' => 'button warning', 'target' => '_blank')); ?></td>-->
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>