<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 15% }
    .width1-3 { width: 10% }
    .width1-4 { width: 25% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }

    .width2-1 { width: 20% }
    .width2-2 { width: 10% }
    .width2-3 { width: 55% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Laporan Cash Transaction</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Transaction #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Tipe</th>
        <th class="width1-4">COA</th>
        <th class="width1-5">Debit</th>
        <th class="width1-6">Credit</th>
        <th class="width1-7">Status</th>
    </tr>
    <tr id="header2">
        <td colspan="7">
            <table>
                <tr>
                    <th class="width2-1">COA</th>
                    <th class="width2-2">Amount</th>
                    <th class="width2-3">Note</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($cashTransactionSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::link(CHtml::encode($header->transaction_number), array("/transaction/cashTransaction/view", "id"=>$header->id), array("target" => "_blank")); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->transaction_date))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'transaction_type')); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'coa.name')); ?></td>
            <td class="width1-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'debit_amount'))); ?></td>
            <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'credit_amount'))); ?></td>
            <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
        </tr>
        <tr class="items2">
            <td colspan="7">
                <table>
                    <?php foreach ($header->cashTransactionDetails as $detail): ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'coa.name')); ?></td>
                            <td class="width2-2" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'amount'))); ?></td>
                            <td class="width2-3"><?php echo CHtml::encode(CHtml::value($detail, 'notes')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>