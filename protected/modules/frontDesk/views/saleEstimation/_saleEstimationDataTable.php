<div style="text-align: right">
    <?php echo ReportHelper::summaryText($dataProvider); ?>
</div>

<div class="table-responsive">
    <?php echo CHtml::beginForm(); ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="table-primary">
                <th style="min-width: 200px">
                    Estimasi #
                </th>
                <th style="min-width: 150px">
                    Tanggal
                </th>
                <th style="min-width: 250px">
                    Customer
                </th>
                <th style="min-width: 150px" >
                    Plat #
                </th>
                <th style="min-width: 150px">
                    Mobil Tipe
                </th>
                <th style="min-width: 150px">
                    Mileage (km)
                </th>
                <th style="min-width: 150px">
                    Sales
                </th>
                <th style="min-width: 100px">
                    Status
                </th>
                <th style="min-width: 90px"></th>
            </tr>
            <tr class="table-light">
                <th>
                    <?php echo CHtml::activeTextField($model, 'transaction_number', array(
                        'class' => 'form-control',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlUpdateSaleEstimationTable'),
                            'update' => '#sale_estimation_data_container',
                        )),
                    )); ?>
                </th>
                <th></th>
                <th>
                    <?php echo CHtml::textField('CustomerName', $customerName, array(
                        'class' => 'form-control',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlUpdateSaleEstimationTable'),
                            'update' => '#sale_estimation_data_container',
                        )),
                    )); ?>
                </th>
                <th>
                    <?php echo CHtml::textField('PlateNumber', $plateNumber, array(
                        'class' => 'form-control',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlUpdateSaleEstimationTable'),
                            'update' => '#sale_estimation_data_container',
                        )),
                    )); ?>
                </th>
                <th></th>
                <th></th>
                <th>
                    <?php echo CHtml::activeDropDownlist($model, 'employee_id_sale_person', CHtml::listData(Employee::model()->findAllByAttributes(array(
                        "position_id" => 2,
                    )), "id", "name"), array(
                        'class' => 'form-control',
                        "empty" => "--Salesman--"
                    )); ?>
                </th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataProvider->data as $data): ?>
                <tr id="sale_estimation_data_container">
                    <td><?php echo CHtml::encode(CHtml::value($data, 'transaction_number')); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($data, 'transaction_date'))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'vehicle.plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($data, 'vehicle.carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($data, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($data, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td class="text-end"><?php echo CHtml::encode(CHtml::value($data, 'vehicle_mileage')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'employeeIdSalesPerson.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'status')); ?></td>
                    <td>
                        <?php echo CHtml::link('view', array("view", "id" => $data->id), array('class' => 'btn btn-info btn-sm')); ?>
                        <?php if (!empty($data->vehicle_id)): ?>
                            <?php echo CHtml::link('update', array("update", "id" => $data->id, "vehicleId" => $data->vehicle_id), array('class' => 'btn btn-warning btn-sm')); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo CHtml::endForm(); ?>
</div>

<div class="text-end">
    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
        'pages' => $dataProvider->pagination,
    )); ?>
</div>