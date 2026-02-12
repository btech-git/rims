<div class="reportDisplay">
    <?php $dataCount = count($activeWorkOrderData); ?>
    <?php if ($dataCount > 0): ?>
        <?php echo "Displaying 1-{$dataCount} of {$dataCount} result(s)."; ?>
    <?php endif; ?>
</div>

<br />

<div>
    <table>
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
            <?php foreach (array_reverse($activeWorkOrderData) as $activeWorkOrderItem): ?>
                <?php $registrationTransaction = RegistrationTransaction::model()->findByPk($activeWorkOrderItem['id']); ?>
                <tr>
                    <td><?php echo CHtml::encode($activeWorkOrderItem['vehicle_id']); ?></td>
                    <td><?php echo CHtml::encode($activeWorkOrderItem['plate_number']); ?></td>
                    <td><?php echo CHtml::encode($activeWorkOrderItem['transaction_date']); ?></td>
                    <td>
                        <?php echo CHtml::encode($activeWorkOrderItem['car_make']); ?> -
                        <?php echo CHtml::encode($activeWorkOrderItem['car_model']); ?> -
                        <?php echo CHtml::encode($activeWorkOrderItem['car_sub_model']); ?>
                    </td>
                    <td><?php echo CHtml::encode($activeWorkOrderItem['color']); ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($activeWorkOrderItem['transaction_number']), Yii::app()->createUrl("frontDesk/registrationTransaction/view", array(
                            "id" => $activeWorkOrderItem['id']
                        )), array('target' => '_blank')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($activeWorkOrderItem['sales_order_number']), Yii::app()->createUrl("frontDesk/registrationTransaction/view", array(
                            "id" => $activeWorkOrderItem['id']
                        )), array('target' => '_blank')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($activeWorkOrderItem['work_order_number']), Yii::app()->createUrl("frontDesk/registrationTransaction/view", array(
                            "id" => $activeWorkOrderItem['id']
                        )), array('target' => '_blank')); ?>
                    </td>
                    <td><?php echo CHtml::encode($activeWorkOrderItem['work_order_date']); ?></td>
                    <td><?php echo CHtml::encode($registrationTransaction->getMovementOuts()); ?></td>
                    <td>
                        <?php $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $activeWorkOrderItem['id'])); ?>
                        <?php if ($invoiceHeader !== null): ?>
                            <?php echo CHtml::link(CHtml::encode(CHtml::value($invoiceHeader, 'invoice_number')), Yii::app()->createUrl("transaction/invoiceHeader/show", array(
                                "id" => $invoiceHeader->id
                            )), array('target' => '_blank')); ?>
                        <?php endif; ?>
                    </td>
                    <td><?php echo CHtml::encode($registrationTransaction->getServices()); ?></td>
                    <td><?php echo CHtml::encode($activeWorkOrderItem['repair_type']); ?></td>
                    <td><?php echo CHtml::encode($activeWorkOrderItem['problem']); ?></td>
                    <td><?php echo CHtml::encode($activeWorkOrderItem['username']); ?></td>
                    <td><?php echo CHtml::encode($activeWorkOrderItem['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>