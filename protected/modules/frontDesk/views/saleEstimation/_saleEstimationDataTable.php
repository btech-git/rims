<div style="text-align: right">
    <?php echo ReportHelper::summaryText($dataProvider); ?>
</div>

<div class="table-responsive">
    <?php echo CHtml::beginForm(); ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="table-primary">
                <th style="min-width: 150px">
                    Estimasi #
                </th>
                <th style="min-width: 100px">
                    Tanggal
                </th>
                <th style="min-width: 250px">
                    Customer
                </th>
                <th style="min-width: 50px" >
                    Plat #
                </th>
                <th style="min-width: 200px">
                    Mobil Tipe
                </th>
                <th style="min-width: 100px">
                    Mileage (km)
                </th>
                <th style="min-width: 150px">
                    RG #
                </th>
                <th style="min-width: 150px">
                    Salesman
                </th>
                <th style="min-width: 80px">
                    Status
                </th>
                <th style="min-width: 50px"></th>
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
                <?php $registrationTransaction = RegistrationTransaction::model()->findByAttributes(array('sale_estimation_header_id' => $data->id)); ?>
                <tr id="sale_estimation_data_container">
                    <td><?php echo CHtml::link($data->transaction_number, array("view", "id"=>$data->id), array("target" => "_blank")); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($data, 'transaction_date'))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'vehicle.plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($data, 'vehicle.carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($data, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($data, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td style="text-align: right"><?php echo number_format(CHtml::encode(CHtml::value($data, 'vehicle_mileage')), 0); ?></td>
                    <td><?php echo CHtml::link(CHtml::value($registrationTransaction, 'transaction_number'), array("/frontDesk/registrationTransaction/view", "id"=>$data->id), array("target" => "_blank")); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'employeeIdSalePerson.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($data, 'status')); ?></td>
                    <td>
                        <?php //echo CHtml::link('view', array("view", "id" => $data->id), array('class' => 'btn btn-info btn-sm')); ?>
                        <?php echo CHtml::link('update', array("update", "id" => $data->id), array('class' => 'btn btn-warning btn-sm')); ?>
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