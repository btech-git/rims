<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 5% }
    .width1-3 { width: 10% }
    .width1-4 { width: 10% }
    .width1-5 { width: 15% }
    .width1-6 { width: 15% }
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
        <?php echo CHtml::encode(CHtml::value($vehicle, 'carSubModel.name')); ?> || 
        <?php echo CHtml::encode(CHtml::value($vehicle, 'customer.name')); ?> - 
        <?php echo CHtml::encode(CHtml::value($vehicle, 'customer.customer_type')); ?>
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
        <?php $totalInvoice = '0.00'; ?>
        <?php $totalService = '0.00'; ?>
        <?php $totalProduct = '0.00'; ?>
        <?php foreach ($dataProvider->data as $i => $header): ?>
            <?php $totalPrice = CHtml::value($header, 'total_price'); ?>
            <?php $servicePrice = CHtml::value($header, 'service_price'); ?>
            <?php $productPrice = CHtml::value($header, 'product_price'); ?>
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
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $servicePrice)); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $productPrice)); ?>
                </td>
            </tr>
            <?php $totalInvoice += $totalPrice; ?>
            <?php $totalService += $servicePrice; ?>
            <?php $totalProduct += $productPrice; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="font-weight: bold; text-align: right; border-top: 1px solid" colspan="6">TOTAL</td>
            <td style="font-weight: bold; text-align: right; border-top: 1px solid">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalInvoice)); ?>
            </td>
            <td style="font-weight: bold; text-align: right; border-top: 1px solid">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalService)); ?>
            </td>
            <td style="font-weight: bold; text-align: right; border-top: 1px solid">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalProduct)); ?>
            </td>
        </tr>
    </tfoot>
</table>