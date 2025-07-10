<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 5% }
    .width1-3 { width: 15% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 5% }
    .width1-7 { width: 5% }
    .width1-8 { width: 10% }
    .width1-9 { width: 5% }
    .width1-10 { width: 5% }
    .width1-11 { width: 3% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($model->branch_id); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Follow Up Customer</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-11"></th>
            <th class="width1-1">Customer</th>
            <th class="width1-2">Plat #</th>
            <th class="width1-3">Kendaraan</th>
            <th class="width1-4">Last RG #</th>
            <th class="width1-5">Invoice #</th>
            <th class="width1-6">Invoice Last Date</th>
            <th class="width1-7">Warrant (3 Days)</th>
            <th class="width1-8">Follow Up (3 Months)</th>
            <th class="width1-9">Last Service (Days)</th>
            <th class="width1-10">Feedback</th>
        </tr>
        <tr id="header2">
            <td colspan="10">&nbsp;</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataProvider->data as $i => $header): ?>
            <tr class="items1">
                <td><?php echo CHtml::encode($i+1); ?></td>
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                <td class="width1-3">
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                </td>
                <td class="width1-4">
                    <?php echo CHtml::link($header->registrationTransaction->transaction_number, array($header->registrationTransaction->repair_type == "GR" ? "/frontDesk/generalRepairRegistration/view" : "/frontDesk/bodyRepairRegistration/view", "id"=>$header->registration_transaction_id), array("target" => "blank")); ?>
                </td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'invoice_number')); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->warrantyFollowUpDate))); ?></td>
                <td class="width1-8"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->serviceFollowUpDate))); ?></td>
                <td class="width1-9"><?php echo CHtml::encode(CHtml::value($header, 'lastInvoiceDaysNumber')); ?></td>
                <td class="width1-10">
                    <?php if (empty($header->registrationTransaction->feedback)): ?>
                        <?php echo CHtml::link('Feedback', Yii::app()->createUrl("frontDesk/followUp/updateFeedback", array("id"=>$header->registration_transaction_id))); ?>
                    <?php else: ?>
                        <?php echo CHtml::encode(CHtml::value($header, 'lastInvoiceDaysNumber')); ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>