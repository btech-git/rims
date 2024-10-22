<div style="text-align: right">
    <?php echo ReportHelper::summaryText($vehicleDataProvider); ?>
</div>

<div class="table-responsive" id="vehicle-data-grid">
    <table class="table table-sm table-bordered table-hover" id="vehicle-data-table">
        <thead>
            <tr class="table-primary">
                <th style="text-align: center">ID</th>
                <th style="text-align: center">Plat #</th>
                <th style="text-align: center">Customer</th>
                <th style="text-align: center">Phone</th>
                <th style="text-align: center">Merk</th>
                <th style="text-align: center">Model</th>
                <th style="text-align: center">Tipe</th>
                <th style="text-align: center">Warna</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($vehicleDataProvider->data as $vehicle): ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'id')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'plate_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'customer.mobilePhone')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'carMake.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'carModel.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'carSubModel.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'color.name')); ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-end">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'pages' => $vehicleDataProvider->pagination,
        )); ?>
    </div>
</div>