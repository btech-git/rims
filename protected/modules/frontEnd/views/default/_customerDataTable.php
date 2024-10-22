<div style="text-align: right">
    <?php echo ReportHelper::summaryText($customerDataProvider); ?>
</div>

<div class="table-responsive" id="vehicle-data-grid">
    <table class="table table-sm table-bordered table-hover" id="vehicle-data-table">
        <thead>
            <tr class="table-primary">
                <th style="text-align: center">ID</th>
                <th style="text-align: center">Customer</th>
                <th style="text-align: center">HP #</th>
                <th style="text-align: center">Email</th>
                <th style="text-align: center">Tipe</th>
                <th style="text-align: center">Status</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($customerDataProvider->data as $customer): ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($customer, 'id')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($customer, 'name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($customer, 'mobilePhone')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($customer, 'email')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($customer, 'customer_type')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($customer, 'status')); ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-end">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'pages' => $customerDataProvider->pagination,
        )); ?>
    </div>
</div>