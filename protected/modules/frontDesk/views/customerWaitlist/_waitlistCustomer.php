<div style="text-align: right">
    <?php echo ReportHelper::summaryText($dataProvider); ?>
</div>

<table>
    <thead>
        <tr>
            <th style="text-align: center">Customer</th>
            <th style="text-align: center">Car</th>
            <th style="text-align: center">Plate #</th>
            <th style="text-align: center">WO #</th>
            <th style="text-align: center">Tanggal</th>
            <th style="text-align: center">Status</th>
            <th style="text-align: center">Duration</th>
            <th style="text-align: center">BR/GR</th>
            <th style="text-align: center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataProvider->data as $model): ?>
            <tr>
                <td>
                    <?php echo $model->customer_id != null ? CHtml::link($model->customer->name, array(
                        "/master/customer/view", 
                        "id"=>$model->customer_id
                    ), array('target' => '_blank')) : ' '; ?>
                </td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carMake.name')); ?>
                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carModel.name')); ?>
                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carSubModel.name')); ?>
                </td>
                <td>
                    <?php echo $model->vehicle != null ? CHtml::link($model->vehicle->plate_number, array(
                        "/master/vehicle/view", 
                        "id" => $model->vehicle_id
                    ), array('target' => '_blank')) : ' '; ?>
                </td>
                <td>
                    <?php echo $model->work_order_number != null ? CHtml::link($model->work_order_number, array(
                        "/frontDesk/registrationTransaction/view", 
                        "id" => $model->id
                    ), array('target' => '_blank')) : ' '; ?>
                </td>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy H:m:s", CHtml::value($model, 'transaction_date'))); ?></td>
                <td><?php echo $model->status != null ? $model->status : '-'; ?></td>
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
                }
                ?>
                <td><?php echo $duration; ?></td>
                <td><?php echo $model->repair_type; ?></td>
                <td><?php echo $model->service_status; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="text-end">
    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
        'pages' => $dataProvider->pagination,
    )); ?>
</div>