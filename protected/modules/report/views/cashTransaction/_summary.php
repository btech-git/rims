<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 12% }
    .width1-2 { width: 8% }
    .width1-3 { width: 5% }
    .width1-4 { width: 15% }
    .width1-5 { width: 8% }
    .width1-6 { width: 8% }
    .width1-7 { width: 5% }
    .width1-8 { width: 10% }
    .width1-9 { width: 8% }
    .width1-10 { width: 20% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Transaksi Kas</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Transaction #</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Tipe</th>
            <th class="width1-4">COA Asal</th>
            <th class="width1-5">Debit</th>
            <th class="width1-6">Credit</th>
            <th class="width1-7">Status</th>
            <th class="width1-8">COA Tujuan</th>
            <th class="width1-9">Amount</th>
            <th class="width1-10">Note</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cashTransactionSummary->dataProvider->data as $header): ?>
            <?php foreach ($header->cashTransactionDetails as $detail): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->transaction_number), array(
                            "/transaction/cashTransaction/view", 
                            "id"=>$header->id
                        ), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->transaction_date))); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'transaction_type')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'coa.name')); ?></td>
                    <td class="width1-5" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'debit_amount'))); ?>
                    </td>
                    <td class="width1-6" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'credit_amount'))); ?>
                    </td>
                    <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td class="width1-8"><?php echo CHtml::encode(CHtml::value($detail, 'coa.name')); ?></td>
                    <td class="width1-9" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'amount'))); ?>
                    </td>
                    <td class="width1-10"><?php echo CHtml::encode(CHtml::value($detail, 'notes')); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>