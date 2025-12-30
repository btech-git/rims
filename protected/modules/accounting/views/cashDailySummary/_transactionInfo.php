<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 5% }
    .width1-3 { width: 5% }
    .width1-4 { width: 15% }
    .width1-5 { width: 5% }
    .width1-6 { width: 15% }
    .width1-7 { width: 5% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Laporan Transaksi Penjualan</div>
    <div style="font-size: larger"><?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($transactionDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">No</th>
            <th class="width1-2">Invoice #</th>
            <th class="width1-4">Customer</th>
            <th class="width1-5">Plat #</th>
            <th class="width1-6">Kendaraan</th>
            <th class="width1-7">WO #</th>
            <th class="width1-8">Salesman</th>
            <th class="width1-9">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $grandTotal = '0.00'; ?>
        <?php foreach ($dataProvider->data as $i => $header): ?>
            <?php $totalPrice = CHtml::value($header, 'total_price'); ?>
            <tr class="items1">
                <td><?php echo $i + 1; ?></td>
                <td>
                    <?php echo CHtml::link(CHtml::value($header, 'invoice_number'), array(
                        '/transaction/invoiceHeader/view',
                        'id' => $header->id, 
                    ), array('target' => '_blank')); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                </td>
                <td>
                    <?php echo CHtml::link(CHtml::value($header, 'registrationTransaction.work_order_number'), array(
                        '/frontDesk/registrationTransaction/view',
                        'id' => $header->registration_transaction_id, 
                    ), array('target' => '_blank')); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.employeeIdSalesPerson.name')); ?></td>
                <td style="text-align:right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPrice)); ?></td>
            </tr>
            <?php $grandTotal += $totalPrice; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7" style="font-weight: bold; text-align: right">TOTAL</td>
            <td style="font-weight: bold; text-align:right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></td>
        </tr>
    </tfoot>
</table>