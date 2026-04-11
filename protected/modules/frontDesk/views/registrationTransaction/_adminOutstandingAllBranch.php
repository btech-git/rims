<div class="reportDisplay">
    <?php $dataCount = count($outstandingAllBranchRegistrationData); ?>
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
                <th>Customer SPK #</th>
                <th>Services</th>
                <th>Repair Type</th>
                <th>Problem</th>
                <th>User</th>
                <th>WO Status</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach (array_reverse($outstandingAllBranchRegistrationData) as $outstandingRegistrationItem): ?>
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
                        <?php echo CHtml::link(CHtml::encode($outstandingRegistrationItem['customer_work_order_number']), Yii::app()->createUrl("frontDesk/registrationTransaction/view", array(
                            "id" => $outstandingRegistrationItem['id']
                        )), array('target' => '_blank')); ?>
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