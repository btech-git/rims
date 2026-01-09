<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 5% }
    .width1-2 { width: 75% }
    .width1-3 { width: 20% }

    .width2-1 { width: 10% }
    .width2-2 { width: 10% }
    .width2-3 { width: 10% }
    .width2-4 { width: 10% }
    .width2-5 { width: 10% }
    .width2-6 { width: 15% }
    .width2-7 { width: 15% }
    .width2-8 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name'));?></div>
    <div style="font-size: larger">Rincian Penjualan per Customer</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">ID</th>
            <th class="width1-2">Customer</th>
            <th class="width1-3">Type</th>
        </tr>
        <tr id="header2">
            <td colspan="3">
                <table>
                    <tr>
                        <th class="width2-1">Penjualan #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Vehicle</th>
                        <th class="width2-4">WO #</th>
                        <th class="width2-5">Total</th>
                        <th class="width2-6">Sales</th>
                        <th class="width2-7">Mechanic</th>
                        <th class="width2-8">Note</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customerSaleReport as $i => $dataItem): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode($dataItem['customer_id']); ?></td>
                <td class="width1-2"><?php echo CHtml::encode($dataItem['customer_name']); ?></td>
                <td class="width1-3"><?php echo CHtml::encode($dataItem['customer_type']); ?></td>
            </tr>
            <tr class="items2">
                <td colspan="3">
                    <table>
                        <?php $totalSale = 0.00; ?>
                        <?php $params = array(
                            ':customer_id' => $dataItem['customer_id'],
                            ':start_date' => $startDate,
                            ':end_date' => $endDate,
                        ); ?>
                        <?php $branchConditionSql = ''; ?>
                        <?php if (!empty($branchId)): ?>
                            <?php $branchConditionSql = ' AND branch_id = :branch_id'; ?>
                            <?php $params[':branch_id'] = $branchId; ?>
                        <?php endif; ?>
        
                        <?php $saleReportData = InvoiceHeader::model()->findAll(array(
                            'condition' => "customer_id = :customer_id AND invoice_date BETWEEN :start_date AND :end_date" . $branchConditionSql, 
                            'params' => $params,
                        )); ?>
                        <?php if (!empty($saleReportData)): ?>
                            <?php foreach ($saleReportData as $saleReportRow): ?>
                                <?php $grandTotal = CHtml::value($saleReportRow, 'total_price'); ?>
                                <tr>
                                    <td class="width2-1">
                                        <?php echo CHtml::link(CHtml::encode(CHtml::value($saleReportRow, 'invoice_number')), Yii::app()->createUrl("transaction/invoiceHeader/view", array("id" => CHtml::encode(CHtml::value($saleReportRow, 'id')))), array('target' => '_blank')); ?>
                                    </td>
                                    <td class="width2-2">
                                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($saleReportRow, 'invoice_date')))); ?>
                                    </td>
                                    <td class="width2-3">
                                        <?php echo CHtml::encode(CHtml::value($saleReportRow, 'vehicle.plate_number')); ?>
                                    </td>
                                    <td class="width2-4">
                                        <?php echo CHtml::link(CHtml::encode(CHtml::value($saleReportRow, 'registrationTransaction.work_order_number')), Yii::app()->createUrl("frontDesk/registrationTransaction/view", array("id" => CHtml::value($saleReportRow, 'registration_transaction_id'))), array('target' => '_blank')); ?>
                                    </td>
                                    <td class="width2-5" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?>
                                    </td>
                                    <td class="width2-6" style="text-align: right">
                                        <?php echo CHtml::encode(CHtml::value($saleReportRow, 'registrationTransaction.employeeIdSalesPerson.name')); ?>
                                    </td>
                                    <td class="width2-7" style="text-align: right">
                                        <?php echo CHtml::encode(CHtml::value($saleReportRow, 'registrationTransaction.employeeIdAssignMechanic.name')); ?>
                                    </td>
                                    <td class="width2-8" style="text-align: right">
                                        <?php echo CHtml::encode(CHtml::value($saleReportRow, 'registrationTransaction.note')); ?>
                                    </td>
                                </tr>
                                <?php $totalSale += $grandTotal; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td style="text-align: right" colspan="4">Total</td>
                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
                                <td colspan="3"></td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>