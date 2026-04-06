<div class="reportDisplay">
    <?php $dataCount = count($outstandingRegistrationData); ?>
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
            <?php foreach (array_reverse($outstandingRegistrationData) as $outstandingRegistrationItem): ?>
                <?php $registrationTransaction = RegistrationTransaction::model()->findByPk($outstandingRegistrationItem['id']); ?>
                <tr>
                    <td><?php echo CHtml::encode($outstandingRegistrationItem['vehicle_id']); ?></td>
                    <td><?php echo CHtml::encode($outstandingRegistrationItem['plate_number']); ?></td>
                    <td><?php echo CHtml::encode($outstandingRegistrationItem['transaction_date']); ?></td>
                    <td>
                        <?php echo CHtml::encode($outstandingRegistrationItem['car_make']); ?> -
                        <?php echo CHtml::encode($outstandingRegistrationItem['car_model']); ?> -
                        <?php echo CHtml::encode($outstandingRegistrationItem['car_sub_model']); ?>
                    </td>
                    <td><?php echo CHtml::encode($outstandingRegistrationItem['color']); ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($outstandingRegistrationItem['transaction_number']), Yii::app()->createUrl("frontDesk/registrationTransaction/view", array(
                            "id" => $outstandingRegistrationItem['id']
                        )), array('target' => '_blank')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($outstandingRegistrationItem['sales_order_number']), Yii::app()->createUrl("frontDesk/registrationTransaction/view", array(
                            "id" => $outstandingRegistrationItem['id']
                        )), array('target' => '_blank')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($outstandingRegistrationItem['work_order_number']), Yii::app()->createUrl("frontDesk/registrationTransaction/view", array(
                            "id" => $outstandingRegistrationItem['id']
                        )), array('target' => '_blank')); ?>
                    </td>
                    <td><?php echo CHtml::encode($registrationTransaction->getMovementOuts()); ?></td>
                    <td>
                        <?php $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $outstandingRegistrationItem['id'])); ?>
                        <?php if ($invoiceHeader !== null): ?>
                            <?php echo CHtml::link(CHtml::encode(CHtml::value($invoiceHeader, 'invoice_number')), Yii::app()->createUrl("transaction/invoiceHeader/show", array(
                                "id" => $invoiceHeader->id
                            )), array('target' => '_blank')); ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo CHtml::encode($registrationTransaction->getServices()); ?></td>
                    <td><?php echo CHtml::encode($outstandingRegistrationItem['repair_type']); ?></td>
                    <td><?php echo CHtml::encode($outstandingRegistrationItem['problem']); ?></td>
                    <td><?php echo CHtml::encode($outstandingRegistrationItem['username']); ?></td>
                    <td><?php echo CHtml::encode($outstandingRegistrationItem['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>