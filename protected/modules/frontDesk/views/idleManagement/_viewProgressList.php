<table>
    <thead>
        <tr>
            <th style="text-align: center; font-weight: bold">Plate #</th>
            <th style="text-align: center; font-weight: bold">Car Make</th>
            <th style="text-align: center; font-weight: bold">Car Model</th>
            <th style="text-align: center; font-weight: bold">WO #</th>
            <th style="text-align: center; font-weight: bold">WO Date</th>
            <th style="text-align: center; font-weight: bold">Service</th>
            <th style="text-align: center; font-weight: bold">Service Category</th>
            <th style="text-align: center; font-weight: bold">Service Type</th>
            <th style="text-align: center; font-weight: bold">Duration</th>
            <th style="text-align: center; font-weight: bold">Mechanic</th>
            <th style="text-align: center; font-weight: bold">Note</th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($registrationServiceProgressDataProvider->data as $model): ?>
                <tr>
                    <?php 
                    $registrationTransaction = $model->registrationTransaction;
                    $vehicle = $registrationTransaction->vehicle; 
                    ?>
                    <td><?php echo $vehicle != null ? $vehicle->plate_number : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carMake->name : ' '; ?></td>
                    <td><?php echo $vehicle != null ? $vehicle->carModel->name : ' '; ?></td>
                    <td><?php echo $registrationTransaction->work_order_number; ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", $registrationTransaction->work_order_date); ?></td>
                    <td><?php echo $model->service->name; ?></td>
                    <td><?php echo $model->service->serviceCategory->name; ?></td>
                    <td><?php echo $model->service->serviceType->name; ?></td>
                    <td><?php echo $model->service->flat_rate_hour; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'startMechanic.name')); ?></td>
                    <td><?php echo $model->note; ?></td>
                    <td><?php echo CHtml::link('<span class="fa fa-clipboard"></span>Add to QC', Yii::app()->createUrl("frontDesk/idleManagement/processQualityControl", array("id"=>$model->id)), array('class' => 'button warning')); ?></td>
                </tr>
        <?php endforeach; ?>
    </tbody>
</table>