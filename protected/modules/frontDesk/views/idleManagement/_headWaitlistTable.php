<div style="text-align: right">
    <?php echo ReportHelper::summaryText($modelDataProvider); ?>
</div>

<table>
    <thead>
        <tr>
            <th style="text-align: center; font-weight: bold">Plate #</th>
            <th style="text-align: center; font-weight: bold">Car Make</th>
            <th style="text-align: center; font-weight: bold">Car Model</th>
            <th style="text-align: center; font-weight: bold">WO #</th>
            <th style="text-align: center; font-weight: bold">WO Date</th>
            <th style="text-align: center; font-weight: bold">Services</th>
            <th style="text-align: center; font-weight: bold">Duration</th>
            <th style="text-align: center; font-weight: bold">WO Status</th>
            <th style="text-align: center; font-weight: bold">Branch</th>
            <th style="text-align: center; font-weight: bold">Priority</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($modelDataProvider->data as $model): ?>
            <tr>
                <?php if ($model->repair_type == 'GR') {
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
                } ?>
                <?php $vehicle = $model->vehicle; ?>
                <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                <td><?php echo $model->work_order_number; ?></td>
                <td><?php echo $model->work_order_date; ?></td>
                <td><?php echo $model->getServices(); ?></td>
                <td><?php echo $duration; ?></td>
                <td><?php echo $model->status != null ? $model->status : '-'; ?></td>
                <td><?php echo $model->branch_id != null ? $model->branch->name : '-'; ?></td>
                <td><?php echo $model->getPriorityLiteral($model->priority_level); ?></td>
                <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>View', Yii::app()->createUrl("frontDesk/idleManagement/viewHeadWorkOrder", array("registrationId"=>$model->id)), array('class' => 'button warning')); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>