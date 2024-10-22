<div style="text-align: right">
    <?php echo ReportHelper::summaryText($saleEstimationHeaderDataProvider); ?>
</div>

<div class="table-responsive" id="sale-estimation-data-grid">
    <table class="table table-sm table-bordered table-hover" id="sale-estimation-data-table">
        <thead>
            <tr class="table-primary">
                <th>Estimasi #</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Plat #</th>
                <th>Kendaraan</th>
                <th>Mileage (km)</th>
                <th>Problem</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($saleEstimationHeaderDataProvider->data as $saleEstimationHeader): ?>
                <tr data-sale-estimation-id="<?php echo CHtml::value($saleEstimationHeader, 'id'); ?>">
                    <td><?php echo CHtml::encode(CHtml::value($saleEstimationHeader, 'transaction_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($saleEstimationHeader, 'transaction_date')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($saleEstimationHeader, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($saleEstimationHeader, 'vehicle.plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($saleEstimationHeader, 'vehicle.carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($saleEstimationHeader, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($saleEstimationHeader, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($saleEstimationHeader, 'vehicle_mileage')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($saleEstimationHeader, 'problem')); ?></td>
                    <td><?php echo CHtml::link('<i class="bi-plus"></i> Add', array("create", "estimationId" => $saleEstimationHeader->id), array('class' => 'btn btn-primary btn-sm')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-end">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'pages' => $saleEstimationHeaderDataProvider->pagination,
        )); ?>
    </div>
</div>