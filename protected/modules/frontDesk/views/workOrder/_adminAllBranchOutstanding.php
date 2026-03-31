<div class="reportDisplay">
    <?php $dataCount = count($outstandingAllBranchWorkOrderData); ?>
    <?php if ($dataCount > 0): ?>
        <?php echo "Displaying 1-{$dataCount} of {$dataCount} result(s)."; ?>
    <?php endif; ?>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr>
                <th>Vehicle ID</th>
                <th>Plat #</th>
                <th>Tanggal RG</th>
                <th>Kendaraan</th>
                <th>Warna</th>
                <th>RG #</th>
                <th>SL #</th>
                <th>WO #</th>
                <th>Tanggal WO</th>
                <th>Movement Out #</th>
                <th>Invoice #</th>
                <th>Services</th>
                <th>Repair Type</th>
                <th>Problem</th>
                <th>User</th>
                <th>WO Status</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach (array_reverse($outstandingAllBranchWorkOrderData) as $outstandingWorkOrderItem): ?>
                <?php $registrationTransaction = RegistrationTransaction::model()->findByPk($outstandingWorkOrderItem['id']); ?>
                <tr>
                    <td><?php echo CHtml::encode($outstandingWorkOrderItem['vehicle_id']); ?></td>
                    <td><?php echo CHtml::encode($outstandingWorkOrderItem['plate_number']); ?></td>
                    <td><?php echo CHtml::encode($outstandingWorkOrderItem['transaction_date']); ?></td>
                    <td>
                        <?php echo CHtml::encode($outstandingWorkOrderItem['car_make']); ?> -
                        <?php echo CHtml::encode($outstandingWorkOrderItem['car_model']); ?> -
                        <?php echo CHtml::encode($outstandingWorkOrderItem['car_sub_model']); ?>
                    </td>
                    <td><?php echo CHtml::encode($outstandingWorkOrderItem['color']); ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($outstandingWorkOrderItem['transaction_number']), Yii::app()->createUrl("frontDesk/registrationTransaction/view", array(
                            "id" => $outstandingWorkOrderItem['id']
                        )), array('target' => '_blank')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($outstandingWorkOrderItem['sales_order_number']), Yii::app()->createUrl("frontDesk/registrationTransaction/view", array(
                            "id" => $outstandingWorkOrderItem['id']
                        )), array('target' => '_blank')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($outstandingWorkOrderItem['work_order_number']), Yii::app()->createUrl("frontDesk/registrationTransaction/view", array(
                            "id" => $outstandingWorkOrderItem['id']
                        )), array('target' => '_blank')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode($outstandingWorkOrderItem['work_order_date']); ?> 
                        <?php echo CHtml::encode($outstandingWorkOrderItem['work_order_time']); ?>
                    </td>
                    <td><?php echo CHtml::encode($registrationTransaction->getMovementOuts()); ?></td>
                    <td>
                        <?php $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $outstandingWorkOrderItem['id'])); ?>
                        <?php if ($invoiceHeader !== null): ?>
                            <?php echo CHtml::link(CHtml::encode(CHtml::value($invoiceHeader, 'invoice_number')), Yii::app()->createUrl("transaction/invoiceHeader/show", array(
                                "id" => $invoiceHeader->id
                            )), array('target' => '_blank')); ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo CHtml::encode($registrationTransaction->getServices()); ?></td>
                    <td><?php echo CHtml::encode($outstandingWorkOrderItem['repair_type']); ?></td>
                    <td><?php echo CHtml::encode($outstandingWorkOrderItem['problem']); ?></td>
                    <td><?php echo CHtml::encode($outstandingWorkOrderItem['username']); ?></td>
                    <td><?php echo CHtml::encode($outstandingWorkOrderItem['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>