<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 30% }
    .width1-2 { width: 10% }
    .width1-3 { width: 30% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Piutang Customer Summary</div>
    <div><?php echo 'Per tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Name</th>
            <th class="width1-2">Type</th>
            <th class="width1-3">Akun</th>
            <th class="width1-4">Invoice</th>
            <th class="width1-5">Payment</th>
            <th class="width1-6">Remaining</th>
        </tr>
    </thead>
    <tbody>
        <?php $totalReceivableIndividual = Customer::getTotalReceivableIndividual($endDate, $branchId); ?>
        <?php $totalPaymentIndividual = Customer::getTotalPaymentIndividual($endDate, $branchId); ?>
        <?php $totalRemainingIndividual = Customer::getTotalRemainingIndividual($endDate, $branchId); ?>
        <tr>
            <td colspan="3" style="text-align: center">Individual</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalReceivableIndividual)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPaymentIndividual)); ?></td>
            <td style="text-align: right">
                <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $totalRemainingIndividual), array(
                    '/report/receivableCustomer/transactionRetailInfo', 
                    'endDate' => $endDate,
                    'branchId' => $branchId,
                ), array('target' => '_blank')); ?>
            </td>
        </tr>
        <?php $totalInvoiceSum = '0.00'; ?>
        <?php $totalPaymentSum = '0.00'; ?>
        <?php $totalRemainingSum = '0.00'; ?>
        
        <?php foreach ($receivableSummary->dataProvider->data as $customer): ?>
            <?php $totalRevenue = '0.00'; ?>
            <?php $totalPayment = '0.00'; ?>
            <?php $totalReceivable = '0.00'; ?>
            <?php foreach ($receivableReportData[$customer->id] as $receivableReportItem): ?>
                <?php $revenue = $receivableReportItem['total_price']; ?>
                <?php $paymentAmount = isset($receivablePaymentReportData[$receivableReportItem['id']]) ? $receivablePaymentReportData[$receivableReportItem['id']] : '0.00'; ?>
                <?php $paymentLeft = $revenue - $paymentAmount; ?>
                <?php $totalRevenue += $revenue; ?>
                <?php $totalPayment += $paymentAmount; ?>
                <?php $totalReceivable += $paymentLeft; ?>
            <?php endforeach; ?>
            <tr class="items1">
                <td><?php echo CHtml::encode(CHtml::value($customer, 'name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($customer, 'customer_type')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($customer, 'coa.name')); ?></td>
                <td style="text-align: right;"> 
                    <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0.00', $totalRevenue), array(
                        '/report/receivableCustomer/transactionInfo', 
                        'customerId' => $customer->id,
                        'branchId' => $branchId,
                        'endDate' => $endDate,
                    ), array('target' => '_blank')); ?>
                </td>
                <td style="text-align: right;"> 
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPayment)); ?>
                </td>
                <td style="text-align: right;"> 
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalReceivable)); ?>
                </td>
            </tr>

            <?php $totalInvoiceSum += $totalRevenue; ?>
            <?php $totalPaymentSum += $totalPayment; ?>
            <?php $totalRemainingSum += $totalReceivable; ?>
        <?php endforeach; ?>  
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" style="text-align: right;  font-weight: bold;">TOTAL</td>
            <td style="text-align: right;  font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalInvoiceSum)); ?></td>
            <td style="text-align: right;  font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPaymentSum)); ?></td>
            <td style="text-align: right;  font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalRemainingSum)); ?></td>
        </tr>
    </tfoot>
</table>