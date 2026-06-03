<div class="reportDisplay">
    <?php echo ReportHelper::summaryText($dataProvider); ?>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr>
                <th>Registration #</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Plat #</th>
                <th>Kendaraan</th>
                <th>Problem</th>
                <th>SPK Customer #</th>
                <th>WO #</th>
                <th>Invoice #</th>
                <th>Transaction Status</th>
                <th>Payment Status</th>
                <th>Vehicle Status</th>
                <th>Tanggal Keluar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($dataProvider->data as $registrationTransaction): ?>
                <tr>
                    <td>
                        <?php echo CHtml::link(CHtml::value($registrationTransaction, 'transaction_number'), array("/frontDesk/registrationTransaction/view", "id"=>$registrationTransaction->id), array(
                            "class" => "page-link", 
                            "data-record-id" => $registrationTransaction->id, 
                            'target' => '_blank', 
                            'style' => 'color:blue; text-decoration:underline'
                        )); ?>
                    </td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", strtotime(CHtml::value($registrationTransaction, 'transaction_date')))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'vehicle.plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'vehicle.carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($registrationTransaction, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'problem')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'customer_work_order_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'work_order_number')); ?></td>
                    <td>
                        <?php $invoiceHeader = InvoiceHeader::model()->findByAttributes(array(
                            'registration_transaction_id' => $registrationTransaction->id, 
                            'user_id_cancelled' => null,
                        )); ?>
                        <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'invoice_number')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'status')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'payment_status')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'vehicle.status_location')); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", strtotime(CHtml::value($registrationTransaction, 'estimate_discharge_date')))); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'pages' => $dataProvider->pagination,
        )); ?>
    </div>
    <br />
    <br />
</div>