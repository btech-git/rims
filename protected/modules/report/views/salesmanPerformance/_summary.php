<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 25% }
    .width1-2 { width: 15% }
    .width1-3 { width: 15% }
    .width1-3 { width: 15% }
    .width1-4 { width: 15% }
    .width1-5 { width: 15% }

    .width2-1 { width: 10% }
    .width2-2 { width: 10% }
    .width2-3 { width: 5% }
    .width2-4 { width: 25% }
    .width2-5 { width: 10% }
    .width2-6 { width: 10% }
    .width2-7 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Salesman Performance</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
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
                        <th class="width2-1">SO #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Type</th>
                        <th class="width2-4">Customer</th>
                        <th class="width2-5">Vehicle</th>
                        <th class="width2-6">Total</th>
                        <th class="width2-7">Status</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($salesmanPerformanceSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'id_card')); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'division.name')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'position.name')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'level.name')); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="5">
                    <table>
                        <?php $totalSale = 0.00; ?>
                        <?php $registrationTransactions = RegistrationTransaction::model()->findAll(array(
                            'condition' => 'employee_id_sales_person = :employee_id_sales_person AND transaction_date BETWEEN :start_date AND :end_date AND t.status = "Finished"', 
                            'params' => array(
                                ':employee_id_sales_person' => $header->id,
                                ':start_date' => $startDate,
                                ':end_date' => $endDate,
                            )
                        )); ?>
                        <?php if (!empty($registrationTransactions)): ?>
                            <?php foreach ($registrationTransactions as $detail): ?>
                                <?php $grandTotal = CHtml::value($detail, 'grand_total'); ?>
                                <tr>
                                    <td class="width2-1"><?php echo CHtml::encode($detail->id); ?><?php echo CHtml::link(CHtml::encode($detail->sales_order_number), array("/frontDesk/registrationTransaction/view", "id"=>$detail->id), array("target" => "_blank")); ?></td>
                                    <td class="width2-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->sales_order_date))); ?></td>
                                    <td class="width2-3"><?php echo CHtml::encode(CHtml::value($detail, 'repair_type')); ?></td>
                                    <td class="width2-4"><?php echo CHtml::encode(CHtml::value($detail, 'customer.name')); ?></td>
                                    <td class="width2-5"><?php echo CHtml::encode(CHtml::value($detail, 'vehicle.plate_number')); ?></td>
                                    <td class="width2-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></td>
                                    <td class="width2-7"><?php echo CHtml::encode(CHtml::value($detail, 'status')); ?></td>
                                </tr>
                                <?php $totalSale += $grandTotal; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td style="text-align: right; font-weight: bold" colspan="5">Total</td>
                                <td style="text-align: right; font-weight: bold">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>