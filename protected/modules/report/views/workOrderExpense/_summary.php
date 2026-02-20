<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 12% }
    .width1-2 { width: 10% }
    .width1-3 { width: 12% }
    .width1-4 { width: 25% }
    .width1-5 { width: 16% }
    .width1-6 { width: 25% }

    .width2-1 { width: 40% }
    .width2-2 { width: 20% }
    .width2-3 { width: 40% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Sub Pekerjaan Luar</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Sub Pekerjaan #</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">RG #</th>
        <th class="width1-4">Supplier</th>
        <th class="width1-5">Pembuat</th>
        <th class="width1-6">Note</th>
    </tr>
    <tr id="header2">
        <td colspan="6">
            <table>
                <tr>
                    <th class="width2-1">Deskripsi</th>
                    <th class="width2-3">Memo</th> 
                    <th class="width2-2">Amount</th>
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
            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'user.username')); ?></td>
            <td class="width1-6"><?php echo CHtml::encode(($header->note)); ?></td>
        </tr>
        
        <tr class="items2">
            <td colspan="7">
                <table>
                    <?php $amountSum = 0; ?>
                    <?php foreach ($header->workOrderExpenseDetails as $detail): ?>
                        <?php $amount = CHtml::value($detail, 'amount'); ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'description')); ?></td>
                            <td class="width2-3"><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                            <td class="width2-2" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amount)); ?>
                            </td>
                        </tr>
                        <?php $amountSum += $amount; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td style="text-align: right; font-weight: bold" colspan="2">TOTAL: </td>
                        <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amountSum)); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>