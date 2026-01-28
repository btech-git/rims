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
    .width1-10 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <?php $insuranceCompany = InsuranceCompany::model()->findByPk($insuranceId); ?>
    <div style="font-size: larger">Laporan Transaksi Penjualan <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div style="font-size: larger"><?php echo CHtml::encode(CHtml::value($insuranceCompany, 'name')); ?></div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">No</th>
            <th class="width1-2">Date Last Invoice</th>
            <th class="width1-3">Plat #</th>
            <th class="width1-4">Kendaraan</th>
            <th class="width1-5">Warna</th>
            <th class="width1-6">KM</th>
            <th class="width1-7">WO #</th>
            <th class="width1-8">Invoice #</th>
            <th class="width1-9">VSC #</th>
            <th class="width1-10">Salesman</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataProvider->data as $i => $header): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo $i + 1; ?></td>
                <td class="width1-2"><?php //echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                <td class="width1-4">
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                </td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.color.name')); ?></td>
                <td class="width1-6" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'registrationTransaction.vehicle_mileage'))); ?>
                </td>
                <td class="width1-7">
                    <?php echo CHtml::link(CHtml::value($header, 'registrationTransaction.work_order_number'), array(
                        '/frontDesk/registrationTransaction/view',
                        'id' => $header->registration_transaction_id, 
                    ), array('target' => '_blank')); ?>
                </td>
                <td class="width1-8">
                    <?php echo CHtml::link(CHtml::value($header, 'invoice_number'), array(
                        '/transaction/invoiceHeader/view',
                        'id' => $header->id, 
                    ), array('target' => '_blank')); ?>
                </td>
                <td class="width1-9"><?php //echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                <td class="width1-10"><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.name')); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>