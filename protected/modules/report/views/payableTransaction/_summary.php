<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 30% }
    .width1-2 { width: 30% }
    .width1-3 { width: 30% }
    
    .width2-1 { width: 15% }
    .width2-2 { width: 15% }
    .width2-3 { width: 15% }
    .width2-4 { width: 10% }
    .width2-5 { width: 15% }
    .width2-6 { width: 15% }
    .width2-7 { width: 15% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Kartu Hutang Supplier</div>
    <div><?php echo 'Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Code</th>
            <th class="width1-2">Company</th>
            <th class="width1-3">Name</th>

        </tr>
        <tr id="header2">
            <td colspan="3">
                <table>
                    <tr>
                        <th class="width2-1">Tanggal</th>
                        <th class="width2-2">PO #</th>
                        <th class="width2-3">Grand Total</th>
                        <th class="width2-4">Payment</th>
                        <th class="width2-5">Remaining</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($payableSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode($header->code); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'company')); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="3">
                    <table>
                        <?php $payableData = $header->getPayableTransactionReport($startDate, $endDate, $branchId); ?>
                        <?php $totalPurchase = 0.00; ?>
                        <?php $totalPayment = 0.00; ?>
                        <?php $totalPayable = 0.00; ?>
                        <?php foreach ($payableData as $payableRow): ?>
                            <?php $purchase = $payableRow['total_price']; ?>
                            <?php $paymentAmount = $payableRow['payment_amount']; ?>
                            <?php $paymentLeft = $payableRow['payment_left']; ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($payableRow['transaction_date']))); ?></td>
                                <td class="width2-2">
                                    <?php echo CHtml::link($payableRow['transaction_number'], Yii::app()->createUrl("report/payableTransaction/redirectTransaction", array(
                                        "codeNumber" => $payableRow['transaction_number']
                                    )), array('target' => '_blank'));?>
                                </td>
                                <td class="width2-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $purchase)); ?></td>
                                <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentAmount)); ?></td>
                                <td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentLeft)); ?></td>
                            </tr>
                            <?php $totalPurchase += $purchase; ?>
                            <?php $totalPayment += $paymentAmount; ?>
                            <?php $totalPayable += $paymentLeft; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="2" style="text-align: right">TOTAL</td>
                            <td class="width2-3" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPurchase)); ?></td>
                            <td class="width2-4" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPayment)); ?></td>
                            <td class="width2-5" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPayable)); ?></td>
                        </tr>     
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>