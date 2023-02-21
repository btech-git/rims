<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 10% }

    .width2-1 { width: 40% }
    .width2-2 { width: 5% }
    .width2-3 { width: 15% }
    .width2-4 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Laporan Payment In</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead>
        <tr id="header1">
            <th class="width1-1">Payment #</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Amount</th>
            <th class="width1-4">Note</th>
            <th class="width1-5">Customer</th>
            <th class="width1-6">Vehicle</th>
            <th class="width1-7">Status</th>
            <th class="width1-8">Payment Type</th>
            <th class="width1-9">Admin</th>
            <th class="width1-10">Branch</th>
        </tr>
    </thead>
    <tbody>
        <?php $totalPayment = 0.00; ?>
        <?php foreach ($paymentInSummary->dataProvider->data as $header): ?>
            <?php $paymentAmount = CHtml::value($header, 'payment_amount'); ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::link(CHtml::encode($header->payment_number), array("/transaction/paymentIn/view", "id"=>$header->id), array("target" => "_blank")); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->payment_date))); ?></td>
                <td class="width1-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentAmount)); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'notes')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                <td class="width1-7"><?php echo CHtml::encode($header->status); ?></td>
                <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'paymentType.name')); ?></td>
                <td class="width1-9"><?php echo CHtml::encode(CHtml::value($header, 'user.username')); ?></td>
                <td class="width1-10"><?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?></td>
            </tr>
            <?php $totalPayment += $paymentAmount; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="2">Total</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPayment)); ?></td>
            <td colspan="7">&nbsp;</td>
        </tr>
    </tfoot>
</table>