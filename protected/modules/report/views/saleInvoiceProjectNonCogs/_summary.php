<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Penjualan Customer Project</div>
    <div style="font-size: larger"><?php echo CHtml::encode(CHtml::value($customerData, 'name')); ?></div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th>Penjualan #</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Plat #</th>
                <th>WO #</th>
                <th>ODO</th>
                <th>Jasa</th>
                <th>Part</th>
                <th>Jasa (IDR)</th>
                <th>Part (IDR)</th>
                <th>Qty</th>
                <th>Total exc VAT (IDR)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($saleProjectReport as $i => $dataItem): ?>
                <?php $quantity = $dataItem['quantity']; ?>
                <?php $unitPrice = $dataItem['unit_price']; ?>
                <tr>
                    <td>
                        <?php echo CHtml::link($dataItem['invoice_number'], Yii::app()->createUrl("transaction/invoiceHeader/view", array("id" => $dataItem['id'])), array('target' => '_blank')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['invoice_date']))); ?>
                    </td>
                    <td><?php echo CHtml::encode($dataItem['customer_name']); ?></td>
                    <td><?php echo CHtml::encode($dataItem['plate_number']); ?></td>
                    <td>
                        <?php echo CHtml::link($dataItem['work_order_number'], Yii::app()->createUrl("frontDesk/registrationTransaction/view", array("id" => $dataItem['registration_transaction_id'])), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $dataItem['vehicle_mileage'])); ?></td>
                    <td><?php echo CHtml::encode($dataItem['service']); ?></td>
                    <td><?php echo CHtml::encode($dataItem['product']); ?></td>
                    <td style="text-align: right">
                        <?php if (empty($dataItem['product'])): ?>
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $unitPrice)); ?>
                        <?php else: ?>
                            <?php echo ''; ?>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: right">
                        <?php if (empty($dataItem['product'])): ?>
                            <?php echo ''; ?>
                        <?php else: ?>
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $unitPrice)); ?>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $quantity)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $dataItem['total_price'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>