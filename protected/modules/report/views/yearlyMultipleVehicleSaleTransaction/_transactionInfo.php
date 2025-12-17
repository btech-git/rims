<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 5% }
    .width1-3 { width: 5% }
    .width1-4 { width: 15% }
    .width1-5 { width: 5% }
    .width1-6 { width: 5% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <?php $vehicle = Vehicle::model()->findByPk($vehicleId); ?>
    <div style="font-size: larger">Laporan Transaksi Penjualan <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div style="font-size: larger">
        <?php echo CHtml::encode(CHtml::value($vehicle, 'plate_number')); ?> - 
        <?php echo CHtml::encode(CHtml::value($vehicle, 'carMake.name')); ?> - 
        <?php echo CHtml::encode(CHtml::value($vehicle, 'carModel.name')); ?> - 
        <?php echo CHtml::encode(CHtml::value($vehicle, 'carSubModel.name')); ?>
    </div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">No</th>
            <th class="width1-2">KM</th>
            <th class="width1-3">WO #</th>
            <th class="width1-4">Invoice #</th>
            <th class="width1-5">Salesman</th>
            <th class="width1-6">Mechanic</th>
            <th class="width1-7">Total Invoice</th>
            <th class="width1-8">Total Jasa</th>
            <th class="width1-9">Total Parts</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataProvider->data as $i => $header): ?>
            <tr class="items1">
                <td><?php echo $i + 1; ?></td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'registrationTransaction.vehicle_mileage'))); ?>
                </td>
                <td>
                    <?php echo CHtml::link(CHtml::value($header, 'registrationTransaction.work_order_number'), array(
                        '/frontDesk/registrationTransaction/view',
                        'id' => $header->registration_transaction_id, 
                    ), array('target' => '_blank')); ?>
                </td>
                <td>
                    <?php echo CHtml::link(CHtml::value($header, 'invoice_number'), array(
                        '/transaction/invoiceHeader/view',
                        'id' => $header->id, 
                    ), array('target' => '_blank')); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.employeeIdAssignMechanic.name')); ?></td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'total_price'))); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'service_price'))); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'product_price'))); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>