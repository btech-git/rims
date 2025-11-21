<?php
Yii::app()->clientScript->registerCss('_report', '

    .width1-1 { width: 10% }
    .width1-2 { width: 5% }
    .width1-3 { width: 15% }
    .width1-4 { width: 5% }
    .width1-5 { width: 5% }
    .width1-6 { width: 5% }
    .width1-7 { width: 15% }
    .width1-8 { width: 5% }
    .width1-9 { width: 10% }
    .width1-10 { width: 10% }
    .width1-11 { width: 10% }
    .width1-12 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Penjualan Project <?php echo CHtml::encode(CHtml::value($customerData, 'name')); ?></div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Penjualan #</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Customer</th>
            <th class="width1-4">Vehicle</th>
            <th class="width1-5">Type</th>
            <th class="width1-6">ID</th>
            <th class="width1-7">Item</th>
            <th class="width1-8">Quantity</th>
            <th class="width1-9">Harga</th>
            <th class="width1-10">HPP</th>
            <th class="width1-11">COGS</th>
            <th class="width1-12">Total Sales</th>
        </tr>
    </thead>
    <tbody>
        <?php $totalSale = '0.00'; ?>
        <?php $grandTotalCogs = '0.00'; ?>
        <?php foreach ($saleProjectReport as $i => $dataItem): ?>
            <?php $quantity = CHtml::encode($dataItem['quantity']); ?>
            <?php $unitPrice = $dataItem['unit_price']; ?>
            <?php $cogs = $dataItem['hpp']; ?>
            <?php $totalCogs = $cogs * $quantity; ?>
            <?php $grandTotal = $dataItem['total_price']; ?>
            <tr>
                <td>
                    <?php echo CHtml::link($dataItem['invoice_number'], Yii::app()->createUrl("transaction/invoiceHeader/view", array("id" => $dataItem['id'])), array('target' => '_blank')); ?>
                </td>
                <td>
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['invoice_date']))); ?>
                </td>
                <td><?php echo CHtml::encode($dataItem['customer_name']); ?></td>
                <td><?php echo CHtml::encode($dataItem['plate_number']); ?></td>
                <td>
                    <?php if (empty($dataItem['product'])): ?>
                        <?php echo 'Jasa'; ?>
                    <?php else: ?>
                        <?php echo 'Parts'; ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (empty($dataItem['product'])): ?>
                        <?php echo CHtml::encode($dataItem['service_id']); ?>
                    <?php else: ?>
                        <?php echo CHtml::encode($dataItem['product_id']); ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (empty($dataItem['product'])): ?>
                        <?php echo CHtml::encode($dataItem['service']); ?>
                    <?php else: ?>
                        <?php echo CHtml::encode($dataItem['product']); ?>
                    <?php endif; ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantity)); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $unitPrice)); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $cogs)); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCogs)); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?>
                </td>
            </tr>
            <?php $totalSale += $grandTotal; ?>
            <?php $grandTotalCogs += $totalCogs; ?>
        <?php endforeach; ?>
        <tr>
            <td style="text-align: right; font-weight: bold" colspan="10">Total</td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalCogs)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
        </tr>
    </tbody>
</table>