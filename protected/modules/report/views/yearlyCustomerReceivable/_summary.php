<?php $dateNumList = range(1, 31); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Piutang Customer Tahunan</div>
    <div><?php echo 'Periode tahun: ' . CHtml::encode($year); ?></div>
</div>

<br />

<?php $startDate = $year . '-01-01'; ?>
<?php $endDate = $year . '-12-31'; ?>

<table style="width: 310%">
    <thead>
        <tr>
            <th colspan="2"></th>
            <?php for ($month = 1; $month <= 12; $month++): ?>
                <th colspan="3" style="text-align: center"><?php echo CHtml::encode($monthList[$month]); ?></th>
            <?php endfor; ?>
            <th></th>
        </tr>
        <tr>
            <th style="width: 10px">No.</th>
            <th style="width: 300px">Customer</th>
            <?php for ($month = 1; $month <= 12; $month++): ?>
                <th>Invoice Amount</th>
                <th>Outstanding</th>
                <th>Pelunasan</th>
            <?php endfor; ?>
            <th>Total OS</th>
        </tr>
    </thead>
    <tbody>
        <?php $ordinal = 0; ?>
        <?php $invoiceTotalSums = array(); ?>
        <?php $invoiceOutstandingSums = array(); ?>
        <?php $invoicePaymentSums = array(); ?>
        <?php foreach ($yearlyCustomerReceivableReportData as $customerId => $yearlyCustomerReceivableReportDataItem): ?>
            <tr>
                <td style="text-align: center"><?php echo ++$ordinal; ?></td>
                <td><?php echo $yearlyCustomerReceivableReportDataItem['customer_name']; ?></td>
                <?php $invoiceOutstandingSum = 0; ?>
                <?php for ($month = 1; $month <= 12; $month++): ?>
                    <?php $invoiceTotal = isset($yearlyCustomerReceivableReportDataItem[$month]['invoice_total']) ? $yearlyCustomerReceivableReportDataItem[$month]['invoice_total'] : ''; ?>
                    <?php $invoiceOutstanding = isset($yearlyCustomerReceivableReportDataItem[$month]['invoice_outstanding']) ? $yearlyCustomerReceivableReportDataItem[$month]['invoice_outstanding'] : ''; ?>
                    <?php $invoicePayment = isset($yearlyCustomerReceivableReportDataItem[$month]['invoice_payment']) ? $yearlyCustomerReceivableReportDataItem[$month]['invoice_payment'] : ''; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotal)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceOutstanding)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoicePayment)); ?></td>
                    <?php $invoiceOutstandingSum += $invoiceOutstanding; ?>
                    
                    <?php if (!isset($invoiceTotalSums[$month])): ?>
                        <?php $invoiceTotalSums[$month] = 0; ?>
                    <?php endif; ?>
                    <?php $invoiceTotalSums[$month] += $invoiceTotal; ?>
                    
                    <?php if (!isset($invoiceOutstandingSums[$month])): ?>
                        <?php $invoiceOutstandingSums[$month] = 0; ?>
                    <?php endif; ?>
                    <?php $invoiceOutstandingSums[$month] += $invoiceOutstanding; ?>
                    
                    <?php if (!isset($invoicePaymentSums[$month])): ?>
                        <?php $invoicePaymentSums[$month] = 0; ?>
                    <?php endif; ?>
                    <?php $invoicePaymentSums[$month] += $invoicePayment; ?>
                <?php endfor; ?>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceOutstandingSum)); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="2">Total</td>
            <?php $grandTotalOutstanding = 0; ?>
            <?php for ($month = 1; $month <= 12; $month++): ?>
            
                <?php if (!isset($invoiceTotalSums[$month])): ?>
                    <?php $invoiceTotalSums[$month] = 0; ?>
                <?php endif; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceTotalSums[$month])); ?></td>
                
                <?php if (!isset($invoiceOutstandingSums[$month])): ?>
                    <?php $invoiceOutstandingSums[$month] = 0; ?>
                <?php endif; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceOutstandingSums[$month])); ?></td>
                
                <?php if (!isset($invoicePaymentSums[$month])): ?>
                    <?php $invoicePaymentSums[$month] = 0; ?>
                <?php endif; ?>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoicePaymentSums[$month])); ?></td>
                
                <?php $grandTotalOutstanding += $invoiceOutstandingSums[$month]; ?>
            <?php endfor; ?>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotalOutstanding)); ?></td>
        </tr>
    </tfoot>
</table>
    
