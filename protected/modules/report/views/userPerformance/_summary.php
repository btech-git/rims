<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 5% }
    .width1-3 { width: 5% }
    .width1-4 { width: 5% }
    .width1-5 { width: 5% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan User Performance</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<fieldset>
    <legend>Create Transactions</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Name</th>
                <th class="width1-2">Username</th>
                <th class="width1-3">Registration</th>
                <th class="width1-4">WO</th>
                <th class="width1-5">Move Out</th>
                <th class="width1-6">Invoice</th>
                <th class="width1-7">Pay In</th>
                <th class="width1-8">Purchase</th>
                <th class="width1-9">Receive</th>
                <th class="width1-10">Move In</th>
                <th class="width1-11">Delivery</th>
                <th class="width1-12">Transfer Req</th>
                <th class="width1-13">Sent Req</th>
                <th class="width1-14">Kas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userPerformanceSummary->dataProvider->data as $header): ?>
                <tr class="items1">
                    <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'employee.name')); ?></td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'username')); ?></td>
                    <td class="width1-3" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedRegistrationCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-4" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedWorkOrderCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedMovementOutCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedInvoiceCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedPaymentInCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedPurchaseCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedReceiveCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedMovementInCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedDeliveryCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedTransferRequestCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedSentRequestCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedCashTransactionCount($startDate, $endDate))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<br />

<fieldset>
    <legend>Edit Transactions</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Name</th>
                <th class="width1-2">Username</th>
                <th class="width1-3">Registration</th>
                <th class="width1-4">WO</th>
                <th class="width1-5">Move Out</th>
                <th class="width1-6">Invoice</th>
                <th class="width1-7">Pay In</th>
                <th class="width1-8">Purchase</th>
                <th class="width1-9">Receive</th>
                <th class="width1-10">Move In</th>
                <th class="width1-11">Delivery</th>
                <th class="width1-12">Transfer Req</th>
                <th class="width1-13">Sent Req</th>
                <th class="width1-14">Kas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userPerformanceSummary->dataProvider->data as $header): ?>
                <tr class="items1">
                    <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'employee.name')); ?></td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'username')); ?></td>
                    <td class="width1-3" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserUpdatedRegistrationCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-4" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserUpdatedWorkOrderCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserUpdatedMovementOutCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserUpdatedInvoiceCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserUpdatedPaymentInCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserUpdatedPurchaseCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserUpdatedReceiveCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserUpdatedMovementInCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserUpdatedDeliveryCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserUpdatedTransferRequestCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserUpdatedSentRequestCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserUpdatedCashTransactionCount($startDate, $endDate))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<br />

<fieldset>
    <legend>Cancel Transactions</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Name</th>
                <th class="width1-2">Username</th>
                <th class="width1-3">Registration</th>
                <th class="width1-4">WO</th>
                <th class="width1-5">Move Out</th>
                <th class="width1-6">Invoice</th>
                <th class="width1-7">Pay In</th>
                <th class="width1-8">Purchase</th>
                <th class="width1-9">Receive</th>
                <th class="width1-10">Move In</th>
                <th class="width1-11">Delivery</th>
                <th class="width1-12">Transfer Req</th>
                <th class="width1-13">Sent Req</th>
                <th class="width1-14">Kas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userPerformanceSummary->dataProvider->data as $header): ?>
                <tr class="items1">
                    <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'employee.name')); ?></td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'username')); ?></td>
                    <td class="width1-3" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedRegistrationCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-4" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedWorkOrderCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedMovementOutCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedInvoiceCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedPaymentInCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedPurchaseCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedReceiveCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedMovementInCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedDeliveryCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedTransferRequestCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedSentRequestCount($startDate, $endDate))); ?>
                    </td>
                    <td class="width1-5" style="text-align: center">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getUserCreatedCashTransactionCount($startDate, $endDate))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>