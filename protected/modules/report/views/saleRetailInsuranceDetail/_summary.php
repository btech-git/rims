<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
    .width1-2 { width: 10% }
    .width1-3 { width: 7% }
    .width1-4 { width: 15% }
    .width1-5 { width: 5% }
    .width1-6 { width: 8% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name'));?></div>
    <div style="font-size: larger">Rincian Penjualan per Asuransi</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Asuransi</th>
            <th class="width1-2">Penjualan #</th>
            <th class="width1-3">Tanggal</th>
            <th class="width1-4">Customer</th>
            <th class="width1-5">Type</th>
            <th class="width1-6">Plat #</th>
            <th class="width1-7">WO #</th>
            <th class="width1-8">Sales</th>
            <th class="width1-9">Mechanic</th>
            <th class="width1-10">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $totalSale = '0.00'; ?>
        <?php foreach ($insuranceSaleReport as $i => $dataItem): ?>
            <?php $params = array(
                ':insurance_company_id' => $dataItem['insurance_company_id'],
                ':start_date' => $startDate,
                ':end_date' => $endDate,
            ); ?>
        
            <?php $branchConditionSql = ''; ?>
            <?php if (!empty($branchId)): ?>
                <?php $branchConditionSql = ' AND branch_id = :branch_id'; ?>
                <?php $params[':branch_id'] = $branchId; ?>
            <?php endif; ?>

            <?php $saleReportData = InvoiceHeader::model()->findAll(array(
                'condition' => "insurance_company_id = :insurance_company_id AND invoice_date BETWEEN :start_date AND :end_date" . $branchConditionSql, 
                'params' => $params,
            )); ?>
        
            <?php if (!empty($saleReportData)): ?>
                <?php foreach ($saleReportData as $saleReportRow): ?>
                    <?php $grandTotal = CHtml::value($saleReportRow, 'total_price'); ?>
                    <tr class="items1">
                        <td><?php echo CHtml::encode($dataItem['insurance_name']); ?></td>
                        <td>
                            <?php echo CHtml::link(CHtml::encode(CHtml::value($saleReportRow, 'invoice_number')), Yii::app()->createUrl("transaction/invoiceHeader/view", array("id" => CHtml::encode(CHtml::value($saleReportRow, 'id')))), array('target' => '_blank')); ?>
                        </td>
                        <td>
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($saleReportRow, 'invoice_date')))); ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($saleReportRow, 'customer.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($saleReportRow, 'customer.customer_type')); ?></td>
                        <td>
                            <?php echo CHtml::link(CHtml::encode(CHtml::value($saleReportRow, 'vehicle.plate_number')), Yii::app()->createUrl("master/vehicle/view", array("id" => $saleReportRow->vehicle_id)), array('target' => '_blank')); ?>
                        </td>
                        <td>
                            <?php echo CHtml::link(CHtml::encode(CHtml::value($saleReportRow, 'registrationTransaction.work_order_number')), Yii::app()->createUrl("frontDesk/registrationTransaction/view", array("id" => CHtml::value($saleReportRow, 'registration_transaction_id'))), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(CHtml::value($saleReportRow, 'registrationTransaction.employeeIdSalesPerson.name')); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(CHtml::value($saleReportRow, 'registrationTransaction.employeeIdAssignMechanic.name')); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?>
                        </td>
                    </tr>
                    <?php $totalSale += $grandTotal; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="9">Total</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
        </tr>        
    </tfoot>
</table>