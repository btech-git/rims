<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 30% }
    .width1-3 { width: 30% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div style="font-size: larger">Hutang Supplier Summary</div>
    <div><?php echo 'Per Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">No</th>
            <th class="width1-2">Name</th>
            <th class="width1-3">Akun</th>
            <th class="width1-4">Invoice</th>
            <th class="width1-5">Payment</th>
            <th class="width1-6">Remaining</th>

        </tr>
    </thead>
    <tbody>
        <?php $totalInvoiceSum = '0.00'; ?>
        <?php $totalPaymentSum = '0.00'; ?>
        <?php $totalRemainingSum = '0.00'; ?>
        
        <?php foreach ($payableSummary->dataProvider->data as $i => $supplier): ?>
            <?php $totalRevenue = '0.00'; ?>
            <?php $totalPayment = '0.00'; ?>
            <?php $totalReceivable = '0.00'; ?>
        
            <?php foreach ($payableReportData[$supplier->id] as $payableReportItem): ?>
                <?php $revenue = $payableReportItem['invoice_grand_total']; ?>
                <?php $paymentAmount = isset($payablePaymentReportData[$payableReportItem['id']]) ? $payablePaymentReportData[$payableReportItem['id']] : '0.00'; ?>
                <?php $paymentLeft = $revenue - $paymentAmount; ?>
                <?php $totalRevenue += $revenue; ?>
                <?php $totalPayment += $paymentAmount; ?>
                <?php $totalReceivable += $paymentLeft; ?>
            <?php endforeach; ?>
        
            <tr class="items1">
                <td><?php echo ++$i; ?></td>
                <td><?php echo CHtml::encode(CHtml::value($supplier, 'name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($supplier, 'coa.name')); ?></td>
                <td style="text-align: right;"> 
                    <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0.00', $totalRevenue), array(
                        '/report/payableSupplier/transactionInfo', 
                        'supplierId' => $supplier->id,
                        'branchId' => $branchId,
                        'endDate' => $endDate,
                    ), array('target' => '_blank')); ?>
                </td>
                <td style="text-align: right;"> 
                    <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0.00', $totalPayment), array(
                        '/report/payableSupplier/transactionInfo', 
                        'supplierId' => $supplier->id,
                        'branchId' => $branchId,
                        'endDate' => $endDate,
                    ), array('target' => '_blank')); ?>
                </td>
                <td style="text-align: right;"> 
                    <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0.00', $totalReceivable), array(
                        '/report/payableSupplier/transactionInfo', 
                        'supplierId' => $supplier->id,
                        'branchId' => $branchId,
                        'endDate' => $endDate,
                    ), array('target' => '_blank')); ?>
                </td>
            </tr>

            <?php $totalInvoiceSum += $totalRevenue; ?>
            <?php $totalPaymentSum += $totalPayment; ?>
            <?php $totalRemainingSum += $totalReceivable; ?>
        <?php endforeach; ?> 
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" style="text-align: right; font-weight: bold">TOTAL</td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalInvoiceSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPaymentSum)); ?></td>
            <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalRemainingSum)); ?></td>
        </tr>
    </tfoot>
</table>