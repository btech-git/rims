<table>
    <thead>
        <tr>
            <th style="text-align: center; font-weight: bold">No.</th>
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
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php $numbering = 1; ?>
        <?php foreach ($registrationServiceDataProvider->data as $model): ?>
            <?php if ($model->service->service_type_id === $serviceType->id): ?>
                <tr>
                    <?php /*if ($model->repair_type == 'GR') {
                        $regServices = RegistrationService::model()->findAllByAttributes(array(
                            'registration_transaction_id' => $model->id,
                            'is_body_repair' => 0
                        ));
                    } else {
                        $regServices = RegistrationService::model()->findAllByAttributes(array(
                            'registration_transaction_id' => $model->id,
                            'is_body_repair' => 1
                        ));
                    }
                    $duration = 0;
                    foreach ($regServices as $key => $regService) {
                        $duration += $regService->service->flat_rate_hour;
                    }*/ ?>
                    <?php 
                    $registrationTransaction = $model->registrationTransaction;
                    $vehicle = $registrationTransaction->vehicle; 
                    ?>
                    <td><?php echo $numbering; ?></td>
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
                    <td><?php echo CHtml::link('<span class="fa fa-angle-right"></span>Process to Planning', Yii::app()->createUrl("frontDesk/idleManagement/proceedToPlanning", array("id"=>$model->id)), array('class' => 'button secondary')); ?></td>
                </tr>
                <?php $numbering++; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>