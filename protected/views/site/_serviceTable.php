<div class="reportDisplay">
    <?php echo ReportHelper::summaryText($serviceDataProvider); ?>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr>
                <th style="text-align: center">ID</th>
                <th style="text-align: center">Code</th>
                <th style="text-align: center">Name</th>
                <th style="text-align: center">Category</th>
                <th style="text-align: center">Type</th>
                <th style="text-align: center">Sell Price</th>
                <th style="text-align: center">Frekuensi Jual</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($serviceDataProvider->data as $service): ?>
                <tr>
                    <td><?php echo CHtml::link(CHtml::value($service, 'id'), array('showService', 'id' => $service->id), array('target' => 'blank')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($service, 'code')); ?></td>
                    <td><?php echo CHtml::link(CHtml::value($service, 'name'), array('showService', 'id' => $service->id), array('target' => 'blank')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($service, 'serviceCategory.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($service, 'serviceType.name')); ?></td>
                    <td style="text-align: right">
                        <?php $registrationService = RegistrationService::model()->findByAttributes(array('service_id' => $service->id), array('order' => 't.id DESC')); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($registrationService, 'total_price'))); ?>
                    </td>
                    <td style="text-align: right">
                        <?php $averageQuantity = InvoiceDetail::getAverageQuantityServiceYearly($service->id); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $averageQuantity)); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'pages' => $serviceDataProvider->pagination,
        )); ?>
    </div>
    <br />
    <br />
</div>