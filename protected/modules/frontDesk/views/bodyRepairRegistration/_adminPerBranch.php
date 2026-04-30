<div class="reportDisplay">
    <?php $dataCount = count($dataProvider->data); ?>
    <?php if ($dataCount > 0): ?>
        <?php echo "Displaying 1-{$dataCount} of {$dataCount} result(s)."; ?>
    <?php endif; ?>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr>
                <th>No</th>
                <th>RG #</th>
                <th>Tanggal RG</th>
                <th>Plat #</th>
                <th>Kendaraan</th>
                <th>Customer</th>
                <th>Asuransi</th>
                <th>SPK Customer #</th>
                <th>WO #</th>
                <th>Tanggal WO</th>
                <th>Status WO</th>
                <th>Service Status</th>
                <th>Invoice #</th>
                <th>Payment Status</th>
                <th>Vehicle Status</th>
                <th>Problem</th>
            </tr>
        </thead>
        
        <tbody>
            <?php $runningNumber = 1; ?>
            <?php foreach ($dataProvider->data as $activeRegistrationItem): ?>
                <tr style="background-color: <?php echo $activeRegistrationItem->status == 'Finished' ? 'greenyellow' : 'salmon'; ?>">
                    <td><?php echo CHtml::encode($runningNumber); ?></td>
                    <td>
                        <?php echo CHtml::link($activeRegistrationItem->transaction_number, Yii::app()->createUrl("frontDesk/bodyRepairRegistration/view", array(
                            "id" => $activeRegistrationItem->id
                        )), array('target' => '_blank', 'style' => 'color:blue; text-decoration:underline')); ?>
                    </td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", strtotime(CHtml::value($activeRegistrationItem, 'transaction_date')))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'vehicle.plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'vehicle.carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'vehicle.carSubModel.name')); ?> -
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'insuranceCompany.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'customer_work_order_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'work_order_number')); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", strtotime(CHtml::value($activeRegistrationItem, 'work_order_date')))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'status')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'service_status')); ?></td>
                    <td><?php echo CHtml::encode($activeRegistrationItem->getInvoice($activeRegistrationItem)); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'payment_status')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'vehicle.status_location')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($activeRegistrationItem, 'problem')); ?></td>
                </tr>
                <?php $runningNumber++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>