<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 8% }
    .width1-3 { width: 15% }
    .width1-4 { width: 5% }
    .width1-5 { width: 5% }
    .width1-6 { width: 9% }
    .width1-7 { width: 8% }
    .width1-8 { width: 15% }
    .width1-9 { width:9% }
    .width1-10 { width: 15% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Kinerja Front Office</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))); ?> - <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th></th>
            <th class="width1-1">Nama</th>
            <th class="width1-2">Level</th>
            <th class="width1-3">Customer</th>
            <th class="width1-4">New/Repeat</th>
            <th class="width1-5">Plat #</th>
            <th class="width1-6">Vehicle</th>
            <th class="width1-7">Grand Total</th>
            <th class="width1-8">Service List</th>
            <th class="width1-9">Service Total</th>
            <th class="width1-10">Parts List</th>
            <th class="width1-9">Parts Total</th>
        </tr>
        <tr id="header2">
            <td colspan="11">&nbsp;</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($saleInvoiceSummary->dataProvider->data as $i => $header): ?>
            <tr class="items1">
                <td><?php echo $i + 1; ?></td>
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.name')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.level.name')); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                <td class="width1-4"><?php echo $header->is_new_customer == 0 ? 'Repeat' : 'New'; ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                <td class="width1-6">
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                </td>
                <td class="width1-7" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->total_price))); ?>
                </td>
                <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'serviceLists')); ?></td>
                <td class="width1-9" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->service_price))); ?>
                </td>
                <td class="width1-10"><?php echo CHtml::encode(CHtml::value($header, 'productLists')); ?></td>
                <td class="width1-9" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($header->product_price))); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>