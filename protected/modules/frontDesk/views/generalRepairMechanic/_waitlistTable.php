<div style="text-align: right">
    <?php echo ReportHelper::summaryText($registrationServiceDataProvider); ?>
</div>

<table>
    <thead>
        <tr>
            <th style="text-align: center; font-weight: bold">Plate #</th>
            <th style="text-align: center; font-weight: bold">Car Make</th>
            <th style="text-align: center; font-weight: bold">Car Model</th>
            <th style="text-align: center; font-weight: bold">WO #</th>
            <th style="text-align: center; font-weight: bold">WO Date</th>
            <th style="text-align: center; font-weight: bold">Service</th>
            <th style="text-align: center; font-weight: bold">ServiceType</th>
            <th style="text-align: center; font-weight: bold">Duration</th>
            <th style="text-align: center; font-weight: bold">WO Status</th>
            <th style="text-align: center; font-weight: bold">Branch</th>
            <th style="text-align: center; font-weight: bold">Priority</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($registrationServiceDataProvider->data as $model): ?>
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
                <td><?php echo $registrationTransaction->work_order_number; ?></td>
                <td><?php echo $registrationTransaction->work_order_date; ?></td>
                <td><?php echo $model->service->name; ?></td>
                <td><?php echo $model->service->serviceType->name; ?></td>
                <td><?php echo $model->service->flat_rate_hour; ?></td>
                <td><?php echo $registrationTransaction->status != null ? $registrationTransaction->status : '-'; ?></td>
                <td><?php echo $registrationTransaction->branch_id != null ? $registrationTransaction->branch->name : '-'; ?></td>
                <td><?php echo $registrationTransaction->getPriorityLiteral($registrationTransaction->priority_level); ?></td>
                <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>Detail', Yii::app()->createUrl("frontDesk/generalRepairMechanic/viewDetailWorkOrder", array("registrationId"=>$registrationTransaction->id)), array('class' => 'button warning', 'target' => '_blank')); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>