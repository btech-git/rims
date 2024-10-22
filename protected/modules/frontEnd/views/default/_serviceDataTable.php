<div style="text-align: right">
    <?php echo ReportHelper::summaryText($serviceDataProvider); ?>
</div>

<div class="table-responsive" id="vehicle-data-grid">
    <table class="table table-sm table-bordered table-hover" id="vehicle-data-table">
        <thead>
            <tr class="table-primary">
                <th style="text-align: center">ID</th>
                <th style="text-align: center">Kode</th>
                <th style="text-align: center">Jasa</th>
                <th style="text-align: center">Kategori</th>
                <th style="text-align: center">Tipe</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($serviceDataProvider->data as $service): ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($service, 'id')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($service, 'code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($service, 'name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($service, 'serviceCategory.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($service, 'serviceType.name')); ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-end">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'pages' => $serviceDataProvider->pagination,
        )); ?>
    </div>
</div>