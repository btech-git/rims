<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name'));?></div>
    <div style="font-size: larger">Rincian Penjualan per Customer</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th>Customer</th>
                <th>Type</th>
                <th>Penjualan #</th>
                <th>Tanggal</th>
                <th>Asuransi</th>
                <th>Plat #</th>
                <th>SPK Customer #</th>
                <th>WO #</th>
                <th>Sales</th>
                <th>Mechanic</th>
                <th>Total</th>
                <th>Pembayaran</th>
                <th>Sisa</th>
            </tr>
        </thead>
        <tbody>
            <?php $totalSale = '0.00'; ?>
            <?php $totalPayment = '0.00'; ?>
            <?php $totalRemaining = '0.00'; ?>
            
            <?php foreach ($customerSaleReport as $i => $dataItem): ?>
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
                        <?php $totalPrice = CHtml::value($saleReportRow, 'total_price'); ?>
                        <?php $paymentAmount = CHtml::value($saleReportRow, 'payment_amount'); ?>
                        <?php $paymentLeft = CHtml::value($saleReportRow, 'payment_left'); ?>
            
                        <tr class="items1">
                            <td><?php echo CHtml::encode($dataItem['customer_name']); ?></td>
                            <td><?php echo CHtml::encode($dataItem['customer_type']); ?></td>
                            <td>
                                <?php echo CHtml::link(CHtml::encode(CHtml::value($saleReportRow, 'invoice_number')), Yii::app()->createUrl("transaction/invoiceHeader/view", array("id" => CHtml::encode(CHtml::value($saleReportRow, 'id')))), array('target' => '_blank')); ?>
                            </td>
                            <td>
                                <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($saleReportRow, 'invoice_date')))); ?>
                            </td>
                            <td><?php echo CHtml::encode(CHtml::value($saleReportRow, 'insuranceCompany.name')); ?></td>
                            <td>
                                <?php echo CHtml::link(CHtml::encode(CHtml::value($saleReportRow, 'vehicle.plate_number')), Yii::app()->createUrl("master/vehicle/view", array("id" => $saleReportRow->vehicle_id)), array('target' => '_blank')); ?>
                            </td>
                            <td><?php echo CHtml::encode(CHtml::value($saleReportRow, 'registrationTransaction.customer_work_order_number')); ?></td>
                            <td>
                                <?php echo CHtml::link(CHtml::encode(CHtml::value($saleReportRow, 'registrationTransaction.work_order_number')), Yii::app()->createUrl("frontDesk/registrationTransaction/view", array("id" => CHtml::value($saleReportRow, 'registration_transaction_id'))), array('target' => '_blank')); ?>
                            </td>
                            <td>
                                <?php echo CHtml::encode(CHtml::value($saleReportRow, 'registrationTransaction.employeeIdSalesPerson.name')); ?>
                            </td>
                            <td>
                                <?php echo CHtml::encode(CHtml::value($saleReportRow, 'registrationTransaction.employeeIdAssignMechanic.name')); ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentAmount)); ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentLeft)); ?>
                            </td>
                        </tr>
                        
                        <?php $totalSale += $totalPrice; ?>
                        <?php $totalPayment += $paymentAmount; ?>
                        <?php $totalRemaining += $paymentLeft; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td style="text-align: right" colspan="10">Total</td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalSale)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPayment)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalRemaining)); ?></td>
            </tr>        
        </tfoot>
    </table>
</div>