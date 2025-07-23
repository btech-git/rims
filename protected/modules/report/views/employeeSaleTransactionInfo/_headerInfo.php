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
            <th class="width1-4">Total</th>
        </tr>
        <?php if ($showDetails): ?>
            <tr id="header2">
                <td colspan="7">
                    <table>
                        <tr>
                            <th class="width2-1">Parts/Service</th>
                            <th class="width2-2">Quantity</th>
                            <th class="width2-3">Unit Price</th>
                            <th class="width2-3">Total</th>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php endif; ?>
    </thead>
    <tbody>
        <?php foreach ($dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'invoice_number')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                <td class="width1-4" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'total_price'))); ?>
                </td>
            </tr>
            <?php if ($showDetails): ?>
                <tr class="items2">
                    <td colspan="7">
                        <table>
                            <?php foreach ($header->invoiceDetails as $detail): ?>
                                <tr>
                                    <td class="width2-1">
                                        <?php echo $detail->product_id === null ? CHtml::encode(CHtml::value($detail, 'service.name')) : CHtml::encode(CHtml::value($detail, 'product.name')); ?>
                                    </td>
                                    <td class="width2-2" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
                                    </td>
                                    <td class="width2-2" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'unit_price'))); ?>
                                    </td>
                                    <td class="width2-2" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total_price'))); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>