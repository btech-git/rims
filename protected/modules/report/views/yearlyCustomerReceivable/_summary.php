<?php $dateNumList = range(1, 31); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Piutang Customer Tahunan</div>
    <div><?php echo 'Periode tahun: ' . CHtml::encode($year); ?></div>
</div>

<br />

<table style="width: 310%">
    <thead>
        <tr>
            <th colspan="3"></th>
            <?php for ($month = 1; $month <= 12; $month++): ?>
                <th colspan="3" style="text-align: center"><?php echo CHtml::encode($monthList[$month]); ?></th>
            <?php endfor; ?>
            <th colspan="2" style="text-align: center">Total</th>
        </tr>
        <tr>
            <th style="width: 10px">No.</th>
            <th style="width: 300px">Customer</th>
            <th style="width: 150px">Beginning Receivable</th>
            <?php for ($month = 1; $month <= 12; $month++): ?>
                <th>Invoice</th>
                <th>Payment</th>
                <th>Outstanding</th>
            <?php endfor; ?>
            <th>Invoice</th>
            <th>Payment</th>
        </tr>
    </thead>
    <tbody>
        <?php $ordinal = 0; ?>
        <?php $invoiceTotalSums = array(); ?>
        <?php $paymentTotalSums = array(); ?>
        <?php $outstandingSums = array(); ?>
        <?php foreach ($reportData as $reportDataItem): ?>
            <?php $customerId = $reportDataItem['customer_id']; ?>
            <tr>
                <?php $beginningInvoiceTotal = isset($reportDataItem['beginning_invoice_total']) ? $reportDataItem['beginning_invoice_total'] : ''; ?>
                <?php $beginningPaymentTotal = isset($reportDataItem['beginning_payment_total']) ? $reportDataItem['beginning_payment_total'] : ''; ?>
                <?php $beginningOutstanding = $beginningInvoiceTotal - $beginningPaymentTotal; ?>
                <td style="text-align: center"><?php echo ++$ordinal; ?></td>
                <td><?php echo $reportDataItem['customer_name']; ?></td>
                <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0.00', $beginningOutstanding); ?></td>
                <?php $invoiceTotalSum = 0; ?>
                <?php $paymentTotalSum = 0; ?>
                <?php $currentOutstanding = $beginningOutstanding; ?>
                <?php for ($month = 1; $month <= 12; $month++): ?>
                    <?php $invoiceTotal = isset($reportDataItem[$month]['invoice_total']) ? $reportDataItem[$month]['invoice_total'] : ''; ?>
                    <?php $paymentTotal = isset($reportDataItem[$month]['payment_total']) ? $reportDataItem[$month]['payment_total'] : ''; ?>
                    <td style="text-align: right">
                        <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotal)), array(
                            'transactionInfo', 
                            'customerId' => $customerId, 
                            'year' => $year, 
                            'month' => $month
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentTotal)), array(
                            'transactionInfo', 
                            'customerId' => $customerId, 
                            'year' => $year, 
                            'month' => $month
                        ), array('target' => '_blank')); ?></td>
                    <?php $currentOutstanding += $invoiceTotal - $paymentTotal; ?>
                    <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0.00', $currentOutstanding); ?></td>
                    
                    <?php $invoiceTotalSum += $invoiceTotal; ?>
                    <?php $paymentTotalSum += $paymentTotal; ?>
                    
                    <?php if (!isset($invoiceTotalSums[$month])): ?>
                        <?php $invoiceTotalSums[$month] = 0; ?>
                    <?php endif; ?>
                    <?php $invoiceTotalSums[$month] += $invoiceTotal; ?>
                    
                    <?php if (!isset($paymentTotalSums[$month])): ?>
                        <?php $paymentTotalSums[$month] = 0; ?>
                    <?php endif; ?>
                    <?php $paymentTotalSums[$month] += $paymentTotal; ?>
                    
                    <?php if (!isset($outstandingSums[$month])): ?>
                        <?php $outstandingSums[$month] = 0; ?>
                    <?php endif; ?>
                    <?php $outstandingSums[$month] += $currentOutstanding; ?>
                <?php endfor; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotalSum)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentTotalSum)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="3">Total</td>
            <?php $grandTotalInvoice = 0; ?>
            <?php $grandTotalPayment = 0; ?>
            <?php for ($month = 1; $month <= 12; $month++): ?>
            
                <?php if (!isset($invoiceTotalSums[$month])): ?>
                    <?php $invoiceTotalSums[$month] = 0; ?>
                <?php endif; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotalSums[$month])); ?></td>
                
                <?php if (!isset($paymentTotalSums[$month])): ?>
                    <?php $paymentTotalSums[$month] = 0; ?>
                <?php endif; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentTotalSums[$month])); ?></td>
                
                <?php if (!isset($outstandingSums[$month])): ?>
                    <?php $outstandingSums[$month] = 0; ?>
                <?php endif; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $outstandingSums[$month])); ?></td>
                
                <?php $grandTotalInvoice += $invoiceTotalSums[$month]; ?>
                <?php $grandTotalPayment += $paymentTotalSums[$month]; ?>
            <?php endfor; ?>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotalInvoice)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotalPayment)); ?></td>
        </tr>
    </tfoot>
</table>
    
