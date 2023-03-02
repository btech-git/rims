<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 18% }
    .width1-4 { width: 15% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 15% }
');
?>

<div class="relative">
    <div style="font-weight: bold; text-align: center">
        <div style="font-size: larger">RAPERIND MOTOR</div>
        <div style="font-size: larger">Penyelesaian Pesanan per Kendaraan</div>
        <div>
            <?php echo ' Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?>
        </div>
    </div>

    <br />

    <table style="width: 80%; margin: 0 auto; border-spacing: 0pt">
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Transaksi #</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Tanggal</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Jenis</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Problem</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Status</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Mekanik</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Payment</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Harga</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($workOrderVehicleSummary->dataProvider->data as $header): ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode(CHtml::value($header, 'plate_number')); ?></td>
                    <td colspan="2"><?php echo CHtml::encode(CHtml::value($header, 'carMake.name')); ?></td>
                    <td colspan="3"><?php echo CHtml::encode(CHtml::value($header, 'carModel.name')); ?></td>
                    <td colspan="2"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                </tr>
                
                <?php foreach ($header->registrationTransactions as $registrationTransaction): ?>
                    <tr class="items2">
                        <td><?php echo CHtml::encode($registrationTransaction->transaction_number); ?></td>
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($registrationTransaction->transaction_date))); ?></td>
                        <td><?php echo CHtml::encode($registrationTransaction->repair_type); ?></td>
                        <td><?php echo CHtml::encode($registrationTransaction->problem); ?></td>
                        <td><?php echo CHtml::encode($registrationTransaction->service_status); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'employeeIdAssignMechanic.name')); ?></td>
                        <td><?php echo CHtml::encode($registrationTransaction->payment_status); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->total_service_price)); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>