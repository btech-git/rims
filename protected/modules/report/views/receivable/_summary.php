<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 30% }
    .width1-2 { width: 30% }
    
    .width2-1 { width: 12% }
    .width2-2 { width: 12% }
    .width2-3 { width: 15% }
    .width2-4 { width: 10% }
    .width2-5 { width: 12% }
    .width2-6 { width: 12% }
    .width2-7 { width: 12% }
    .width2-8 { width: 15% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Piutang Customer</div>
    <div><?php echo 'Per tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Name</th>
            <th class="width1-2">Type</th>
        </tr>
        <tr id="header2">
            <td colspan="2">
                <table>
                    <tr>
                        <th class="width2-1">Tanggal</th>
                        <th class="width2-2">Jatuh Tempo</th>
                        <th class="width2-3">Faktur #</th>
                        <th class="width2-4">Vehicle</th>
                        <th class="width2-5">Grand Total</th>
                        <th class="width2-6">Payment</th>
                        <th class="width2-7">Remaining</th>
                        <th class="width2-8">Insurance</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($receivableSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <th class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></th>
                <th class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'customer_type')); ?></th>
            </tr>
            <tr class="items2">
                <td colspan="2">
                    <table>
                        <?php $receivableData = $header->getReceivableReport($endDate, $branchId, $insuranceCompanyId); ?>
                        <?php $totalRevenue = 0.00; ?>
                        <?php $totalPayment = 0.00; ?>
                        <?php $totalReceivable = 0.00; ?>
                        <?php foreach ($receivableData as $receivableRow): ?>
                            <?php $revenue = $receivableRow['total_price']; ?>
                            <?php $paymentAmount = $receivableRow['payment_amount']; ?>
                            <?php $paymentLeft = $receivableRow['payment_left']; ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receivableRow['invoice_date']))); ?></td>
                                <td class="width2-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receivableRow['due_date']))); ?></td>
                                <td class="width2-3"><?php echo CHtml::link($receivableRow['invoice_number'], Yii::app()->createUrl("report/generalLedger/redirectTransaction", array("codeNumber" => $receivableRow['invoice_number'])), array('target' => '_blank'));?></td>
                                <td class="width2-4"><?php echo CHtml::encode($receivableRow['vehicle']); ?></td>
                                <td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $revenue)); ?></td>
                                <td class="width2-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentAmount)); ?></td>
                                <td class="width2-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentLeft)); ?></td>
                                <td class="width2-8"><?php echo CHtml::encode($receivableRow['insurance_name']); ?></td>
                            </tr>
                            <?php $totalRevenue += $revenue; ?>
                            <?php $totalPayment += $paymentAmount; ?>
                            <?php $totalReceivable += $paymentLeft; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4" style="text-align: right">TOTAL</td>
                            <td class="width2-5" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalRevenue)); ?></td>
                            <td class="width2-6" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPayment)); ?></td>
                            <td class="width2-7" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalReceivable)); ?></td>
                            <td class="width2-8"></td>
                        </tr>     
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>   
    </tbody>
</table>