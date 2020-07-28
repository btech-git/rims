<div style="text-align: right">
    <?php echo ReportHelper::summaryText($progressCuciDataProvider); ?>
</div>

<table>
    <thead>
        <tr>
            <th style="text-align: center; font-weight: bold">Plate #</th>
            <th style="text-align: center; font-weight: bold">Car Make</th>
            <th style="text-align: center; font-weight: bold">Car Model</th>
            <th style="text-align: center; font-weight: bold">WO #</th>
            <th style="text-align: center; font-weight: bold">WO Date</th>
            <th style="text-align: center; font-weight: bold">Duration</th>
            <th style="text-align: center; font-weight: bold">Branch</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($progressCuciDataProvider->data as $model): ?>
            <tr>
                <?php $vehicle = $model->vehicle; ?>
                <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                <td><?php echo $model->work_order_number; ?></td>
                <td><?php echo $model->work_order_date; ?></td>
                <td><?php echo $model->total_time; ?></td>
                <td><?php echo $model->branch_id != null ? $model->branch->name : '-'; ?></td>
                <td><?php echo CHtml::link('<span class="fa fa-wrench"></span>View', Yii::app()->createUrl("frontDesk/bodyRepairManagement/checkQuality", array("registrationId"=>$model->id)), array('class' => 'button warning', 'target' => '_blank')); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>