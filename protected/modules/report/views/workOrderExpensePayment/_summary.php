<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 7% }
    .width1-3 { width: 10% }
    .width1-4 { width: 20% }
    .width1-5 { width: 18% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }

    .width2-1 { width: 10% }
    .width2-2 { width: 10% }
    .width2-3 { width: 40% }
    .width2-4 { width: 10% }
    .width2-5 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Sub Pekerjaan Luar Pembayaran</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Sub Pekerjaan #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">RG #</th>
        <th class="width1-4">Supplier</th>
        <th class="width1-5">Note</th>
        <th class="width1-6">Total</th>
        <th class="width1-7">Payment</th>
        <th class="width1-8">Remaining</th>
    </tr>
    <tr id="header2">
        <td colspan="8">
            <table>
                <tr>
                    <th class="width2-1">Payment #</th>
                    <th class="width2-2">Tanggal</th> 
                    <th class="width2-3">Memo</th>
                    <th class="width2-4">Type</th>
                    <th class="width2-5">Amount</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($workOrderExpenseSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1">
                <?php echo CHtml::link(CHtml::encode($header->transaction_number), array("/accounting/workOrderExpense/view", "id"=>$header->id), array("target" => "_blank")); ?>
            </td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->transaction_date))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.transaction_number')); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
            <td class="width1-5"><?php echo CHtml::encode(($header->note)); ?></td>
            <td class="width1-6" style="text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'grand_total'))); ?>
            </td>
            <td class="width1-7" style="text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'total_payment'))); ?>
            </td>
            <td class="width1-8" style="text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'payment_remaining'))); ?>
            </td>
        </tr>
        
        <tr class="items2">
            <td colspan="8">
                <table>
                    <?php foreach ($header->payOutDetails as $detail): ?>
                        <tr>
                            <td class="width2-1">
                                <?php echo CHtml::link(CHtml::value($detail, 'paymentOut.payment_number'), array(
                                    "/accounting/paymentOut/show", 
                                    "id" => $detail->payment_out_id
                                ), array("target" => "_blank")); ?>
                            </td>
                            <td class="width2-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->paymentOut->payment_date))); ?></td>
                            <td class="width2-3"><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                            <td class="width2-4"><?php echo CHtml::encode(CHtml::value($detail, 'paymentOut.paymentType.name')); ?></td>
                            <td class="width2-5" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>