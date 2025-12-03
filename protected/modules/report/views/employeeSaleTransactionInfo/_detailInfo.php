<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 15% }
    .width1-4 { width: 5% }
    .width1-5 { width: 10% }
    .width1-6 { width: 15% }
    .width1-7 { width: 10% }
    .width1-8 { width: 5% }
    .width1-9 { width: 5% }
    .width1-10 { width: 10% }
    .width1-11 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Transaksi Penjualan</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Invoice #</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Customer</th>
            <th class="width1-4">ID</th>
            <th class="width1-5">Code</th>
            <th class="width1-6">Parts</th>
            <th class="width1-7">Category</th>
            <th class="width1-8">Quantity</th>
            <th class="width1-9">Satuan</th>
            <th class="width1-10">Unit Price</th>
            <th class="width1-11">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $quantitySum = 0; ?>
        <?php $totalPriceSum = '0.00'; ?>
        <?php foreach ($dataProvider->data as $detail): ?>
            <?php $quantity = CHtml::value($detail, 'quantity'); ?>
            <?php $totalPrice = CHtml::value($detail, 'total_price'); ?>
            <tr class="items1">
                <td><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.invoice_number')); ?></td>
                <td>
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->invoiceHeader->invoice_date))); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.customer.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'product_id')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'product.productSubCategory.name')); ?></td>
                <td style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantity)); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'product.unit.name')); ?></td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'unit_price'))); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPrice)); ?>
                </td>
                <?php $quantitySum += $quantity; ?>
                <?php $totalPriceSum += $totalPrice; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7" style="text-align: right; font-weight: bold">TOTAL</td>
            <td style="text-align: center; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantitySum)); ?></td>
            <td colspan="2"></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPriceSum)); ?></td>
        </tr>
    </tfoot>
</table>