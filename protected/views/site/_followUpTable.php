<div class="reportDisplay">
    <?php echo ReportHelper::summaryText($followUpDataProvider); ?>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr>
                <th style="text-align: center">ID</th>
                <th style="text-align: center">Plat #</th>
                <th style="text-align: center">Customer</th>
                <th style="text-align: center">Type</th>
                <th style="text-align: center">Kendaraan</th>
                <th style="text-align: center">Warna</th>
                <th style="text-align: center">Transaksi Terakhir</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($followUpDataProvider->data as $followUp): ?>
                <tr>
                    <td><?php echo CHtml::link(CHtml::value($followUp, 'id'), array('showVehicle', 'id' => $followUp->id), array('target' => 'blank')); ?></td>
                    <td><?php echo CHtml::link(CHtml::value($followUp, 'plate_number'), array('showVehicle', 'id' => $followUp->id), array('target' => 'blank')); ?></td>
                    <td><?php echo CHtml::link(CHtml::value($followUp, 'customer.name'), array("showCustomer", "id"=>$followUp->customer_id), array("target" => "blank")); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($followUp, 'customer.customer_type')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($followUp, 'carMake.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($followUp, 'carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($followUp, 'carSubModel.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($followUp, 'color.name')); ?></td>
                    <td>
                        <?php $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('vehicle_id' => $followUp->id), array('order' => 't.id DESC')); ?>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", strtotime(CHtml::value($invoiceHeader, 'invoice_date')))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'pages' => $followUpDataProvider->pagination,
        )); ?>
    </div>
    <br />
    <br />
</div>