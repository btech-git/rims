<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 10% }
    .width1-3 { width: 5% }
    .width1-4 { width: 10% }
    .width1-5 { width: 5% }

    .width2-1 { width: 15% }
    .width2-2 { width: 5% }
    .width2-3 { width: 10% }
    .width2-4 { width: 5% }
    .width2-5 { width: 10% }
    .width2-6 { width: 10% }
    .width2-7 { width: 10% }
    .width2-8 { width: 10% }
    .width2-9 { width: 10% }
    .width2-10 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Mechanic Performance</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead>
        <tr id="header1">
            <th class="width1-1">Name</th>
            <th class="width1-2">ID Card #</th>
            <th class="width1-3">Divisi</th>
            <th class="width1-4">Position</th>
            <th class="width1-5">Level</th>
        </tr>
        <tr id="header2">
            <td colspan="5">
                <table>
                    <tr>
                        <th class="width2-1">WO #</th>
                        <th class="width2-2">Branch</th>
                        <th class="width2-3">Service Price</th>
                        <th class="width2-4">Product Qty</th>
                        <th class="width2-5">Product Price</th>
                        <th class="width2-6">Total</th>
                        <th class="width2-7">Mulai</th>
                        <th class="width2-8">Selesai</th>
                        <th class="width2-9">Service Status</th>
                        <th class="width2-10">Transaction Status</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mechanicPerformanceSummary->dataProvider->data as $header): ?>
            <?php $employeeBranchDivisionPositionLevel = EmployeeBranchDivisionPositionLevel::model()->findByAttributes(array('employee_id' => $header->id)); ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'id_card')); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($employeeBranchDivisionPositionLevel, 'division.name')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($employeeBranchDivisionPositionLevel, 'position.name')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($employeeBranchDivisionPositionLevel, 'level.name')); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="5">
                    <table>
                        <?php $totalSale = 0.00; ?>
                        <?php $registrationTransactions = RegistrationTransaction::model()->findAll(array(
                            'condition' => 'employee_id_assign_mechanic = :employee_id_assign_mechanic AND transaction_date BETWEEN :start_date AND :end_date', 
                            'params' => array(
                                ':employee_id_assign_mechanic' => $header->id,
                                ':start_date' => $startDate,
                                ':end_date' => $endDate,
                            )
                        )); ?>
                        <?php if (!empty($registrationTransactions)): ?>
                            <?php foreach ($registrationTransactions as $detail): ?>
                                <?php $grandTotal = CHtml::value($detail, 'grand_total'); ?>
                                <tr>
                                    <td class="width2-1"><?php echo CHtml::link(CHtml::encode($detail->work_order_number), array("/frontDesk/registrationTransaction/view", "id"=>$detail->id), array("target" => "_blank")); ?></td>
                                    <td class="width2-2"><?php echo CHtml::encode(CHtml::value($detail, 'branch.code')); ?></td>
                                    <td class="width2-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'subtotal_service'))); ?></td>
                                    <td class="width2-4"><?php echo CHtml::encode(CHtml::value($detail, 'total_product')); ?></td>
                                    <td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'subtotal_product'))); ?></td>
                                    <td class="width2-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></td>
                                    <td class="width2-7"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->work_order_date))) . ' ' . CHtml::encode(Yii::app()->dateFormatter->format('H:i:s', strtotime($detail->work_order_time))); ?></td>
                                    <td class="width2-8"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->transaction_date_out))) . ' ' . CHtml::encode(Yii::app()->dateFormatter->format('H:i:s', strtotime($detail->transaction_time_out))); ?></td>
                                    <td class="width2-9"><?php echo CHtml::encode(CHtml::value($detail, 'service_status')); ?></td>
                                    <td class="width2-10"><?php echo CHtml::encode(CHtml::value($detail, 'status')); ?></td>
                                </tr>
                                <?php $totalSale += $grandTotal; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td style="text-align: right" colspan="5">Total</td>
                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>