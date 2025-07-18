<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 15% }
    .width1-3 { width: 10% }
    .width1-4 { width: 25% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }

    .width2-1 { width: 20% }
    .width2-2 { width: 10% }
    .width2-3 { width: 55% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $productMasterCategory = ProductMasterCategory::model()->findByPk($productMasterCategoryId); ?>
    <div style="font-size: larger">Laporan Transaksi Penjualan <?php echo CHtml::encode(CHtml::value($productMasterCategory, 'name')); ?></div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Invoice #</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Customer</th>
            <th class="width1-3">Parts</th>
            <th class="width1-3">Quantity</th>
            <th class="width1-3">Unit Price</th>
            <th class="width1-4">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataProvider->data as $detail): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.invoice_number')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->invoiceHeader->invoice_date))); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.customer.name')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                <td class="width1-4" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                <td class="width1-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'unit_price'))); ?></td>
                <td class="width1-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total_price'))); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>