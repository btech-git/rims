<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 25% }
    .width1-2 { width: 50% }
    .width1-2 { width: 25% }
    
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
            <th class="width1-1">Code</th>
            <th class="width1-2">Name</th>
            <th class="width1-3">Saldo Awal</th>
        </tr>
        <tr id="header2">
            <td colspan="3">
                <table>
                    <tr>
                        <th class="width2-1">Faktur #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Memo</th>
                        <th class="width2-4">Debit</th>
                        <th class="width2-5">Credit</th>
                        <th class="width2-6">Balance</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($receivableSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <th class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'code')); ?></th>
                <th class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></th>
                <th class="width1-3" style="text-align: right">
                    <?php $beginningBalance = CHtml::value($header, 'beginningBalanceReceivableDetail'); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $beginningBalance)); ?>
                </th>
            </tr>
            <tr class="items2">
                <td colspan="3">
                    <table>
                        <?php $receivableData = $header->getReceivableInvoiceReport($endDate, $branchId); ?>
                        <?php $totalRevenue = 0.00; ?>
                        <?php $totalPayment = 0.00; ?>
                        <?php $totalReceivable = 0.00; ?>
                        <?php $currentBalance = $beginningBalance; ?>
                        <?php foreach ($receivableData as $receivableRow): ?>
                            <?php $debitAmount = $receivableRow['debit']; ?>
                            <?php $creditAmount = $receivableRow['credit']; ?>
                            <?php $currentBalance += $debitAmount - $creditAmount; ?>
                            <?php //$paymentLeft = $receivableRow['remaining']; ?>
                            <tr>
                                <td class="width2-1">
                                    <?php echo CHtml::link($receivableRow['kode_transaksi'], Yii::app()->createUrl("report/generalLedger/redirectTransaction", array("codeNumber" => $receivableRow['kode_transaksi'])), array('target' => '_blank'));?>
                                </td>
                                <td class="width2-2">
                                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receivableRow['tanggal_transaksi']))); ?>
                                </td>
                                <td class="width2-3">
                                    <?php echo CHtml::encode($receivableRow['remark']); ?>
                                </td>
                                <td class="width2-4" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $debitAmount)); ?>
                                </td>
                                <td class="width2-5" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $creditAmount)); ?>
                                </td>
                                <td class="width2-6" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $currentBalance)); ?>
                                </td>
                            </tr>
                            <?php $totalRevenue += $debitAmount; ?>
                            <?php $totalPayment += $creditAmount; ?>
                            <?php //$totalReceivable += $paymentLeft; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" style="text-align: right">TOTAL</td>
                            <td class="width2-5" style="text-align: right"> 
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalRevenue)); ?>
                            </td>
                            <td class="width2-6" style="text-align: right"> 
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPayment)); ?>
                            </td>
                            <td class="width2-7" style="text-align: right"> 
                                <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalReceivable)); ?>
                            </td>
                        </tr>     
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>   
    </tbody>
</table>