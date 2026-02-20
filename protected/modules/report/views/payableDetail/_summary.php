<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
');
?>

<div class="relative">
    <div style="font-weight: bold; text-align: center">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <div style="font-size: larger">RAPERIND MOTOR <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
        <div style="font-size: larger">Rincian Hutang Supplier</div>
        <div>
            <?php echo 'Per Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?>
        </div>
    </div>

    <br />

    <table style="width: 100%; margin: 0 auto; border-spacing: 0pt">
        <thead style="position: sticky; top: 0">
            <tr>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 10%">Tanggal</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 15%">PO #</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 15%">Invoice / SJ #</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 10%">Jatuh Tempo</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 10%">Total</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 10%">Pembayaran</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 10%">Sisa</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($payableDetailSummary->dataProvider->data as $header): ?>
                <tr class="items1">
                    <td colspan="8">
                        <?php echo CHtml::encode(CHtml::value($header, 'id')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'name')); ?>
                    </td>
                </tr>

                <?php $payablePurchaseData = $header->getPayableDetailPurchaseReport($endDate, $branchId); ?>
                <?php foreach ($payablePurchaseData as $payablePurchaseRow): ?>
                    <?php $transactionNumber = $payablePurchaseRow['purchase_order_no']; ?>
                    <tr class="items2">
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($payablePurchaseRow['invoice_date']))); ?></td>
                        <td><?php echo CHtml::link($transactionNumber, Yii::app()->createUrl("report/payableDetail/redirectTransaction", array("codeNumber" => $transactionNumber)), array('target' => '_blank')); ?></td>
                        <td><?php echo CHtml::encode($payablePurchaseRow['invoice_number']); ?></td>
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($payablePurchaseRow['invoice_due_date']))); ?></td>
                        <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $payablePurchaseRow['invoice_grand_total']); ?></td>
                        <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $payablePurchaseRow['payment_amount']); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $payablePurchaseRow['payment_left'])); ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php $payableWorkOrderData = $header->getPayableDetailWorkOrderReport($endDate, $branchId); ?>
                <?php foreach ($payableWorkOrderData as $payableWorkOrderRow): ?>
                    <?php $transactionNumber = $payableWorkOrderRow['transaction_number']; ?>
                    <tr class="items2">
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($payableWorkOrderRow['transaction_date']))); ?></td>
                        <td><?php echo CHtml::link($transactionNumber, Yii::app()->createUrl("report/payableDetail/redirectTransaction", array("codeNumber" => $transactionNumber)), array('target' => '_blank')); ?></td>
                        <td><?php echo CHtml::encode($payableWorkOrderRow['registration_number']); ?></td>
                        <td><?php //echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($payableWorkOrderRow['invoice_due_date']))); ?></td>
                        <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $payableWorkOrderRow['total_price']); ?></td>
                        <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $payableWorkOrderRow['payment_amount']); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $payableWorkOrderRow['payment_left'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>