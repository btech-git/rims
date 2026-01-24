<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 35% }
    .width1-2 { width: 15% }
    .width1-3 { width: 50% }
    
    .width2-1 { width: 15% }
    .width2-2 { width: 15% }
    .width2-3 { width: 15% }
    .width2-4 { width: 15% }
    .width2-5 { width: 15% }
    .width2-6 { width: 15% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Faktur Belum Lunas Customer</div>
    <div><?php echo 'Per tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Name</th>
            <th class="width1-2">Type</th>
            <th class="width1-3">Note</th>
        </tr>
        <tr id="header2">
            <td colspan="3">
                <table>
                    <tr>
                        <th class="width2-1">Tanggal</th>
                        <th class="width2-2">Jatuh Tempo</th>
                        <th class="width2-3">Faktur #</th>
                        <th class="width2-4">Vehicle</th>
                        <th class="width2-5">Grand Total</th>
                        <th class="width2-6">Payment</th>
                        <th class="width2-7">Remaining</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($receivableSummary->dataProvider->data as $customer): ?>
            <tr class="items1">
                <th class="width1-1"><?php echo CHtml::encode(CHtml::value($customer, 'name')); ?></th>
                <th class="width1-2"><?php echo CHtml::encode(CHtml::value($customer, 'customer_type')); ?></th>
                <th class="width1-3"><?php echo CHtml::encode(CHtml::value($customer, 'note')); ?></th>
            </tr>
            <tr class="items2">
                <td colspan="3">
                    <table>
                        <?php $totalRevenue = '0.00'; ?>
                        <?php $totalPayment = '0.00'; ?>
                        <?php $totalReceivable = '0.00'; ?>
                        <?php foreach ($receivableReportData[$customer->id] as $receivableReportItem): ?>
                            <?php $revenue = $receivableReportItem['total_price']; ?>
                            <?php $paymentAmount = isset($receivablePaymentReportData[$receivableReportItem['id']]) ? $receivablePaymentReportData[$receivableReportItem['id']] : '0.00'; ?>
                            <?php $paymentLeft = $revenue - $paymentAmount; ?>
                            <tr>
                                <td class="width2-1">
                                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receivableReportItem['invoice_date']))); ?>
                                </td>
                                <td class="width2-2">
                                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receivableReportItem['due_date']))); ?>
                                </td>
                                <td class="width2-3">
                                    <?php echo CHtml::link($receivableReportItem['invoice_number'], Yii::app()->createUrl("report/generalLedger/redirectTransaction", array("codeNumber" => $receivableReportItem['invoice_number'])), array('target' => '_blank'));?>
                                </td>
                                <td class="width2-4"><?php echo CHtml::encode($receivableReportItem['plate_number']); ?></td>
                                <td class="width2-5" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $revenue)); ?>
                                </td>
                                <td class="width2-6" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentAmount)); ?>
                                </td>
                                <td class="width2-7" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentLeft)); ?>
                                </td>
                            </tr>
                            <?php $totalRevenue += $revenue; ?>
                            <?php $totalPayment += $paymentAmount; ?>
                            <?php $totalReceivable += $paymentLeft; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4" style="text-align: right">TOTAL</td>
                            <td class="width2-5" style="text-align: right"> 
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalRevenue)); ?>
                            </td>
                            <td class="width2-6" style="text-align: right"> 
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPayment)); ?>
                            </td>
                            <td class="width2-7" style="text-align: right"> 
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalReceivable)); ?>
                            </td>
                        </tr>     
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>   
    </tbody>
</table>