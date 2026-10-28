<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Piutang Customer Bulanan</div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr id="header1">
                <th>RG #</th>
                <th>RG Date</th>
                <th>Movement Out</th>
                <th>Parts (Rp)</th>
                <th>Jasa (Rp)</th>
                <th>PPn</th>
                <th>Total</th>
                <th>Invoice</th>
                <th>Tanggal Invoice</th>
                <th>Jatuh Tempo</th>
                <th>Umur (hari)</th>
                <th>Outstanding</th>
                <th>Pelunasan</th>
                <th>Payment #</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($monthlyCustomerReceivableSummary->dataProvider->data as $i => $customer): ?>
                <tr class="items1">
                    <td colspan="13" style="font-weight: bold; text-align: center">
                        <?php echo CHtml::encode($i + 1); ?> - <?php echo CHtml::encode(CHtml::value($customer, 'name')); ?>
                    </td>
                </tr>
                <?php foreach ($monthlyCustomerReceivableReportData[$customer->id] as $dataItem): ?>
                    <?php $movementTransactionInfo = isset($monthlyCustomerMovementReportData[$dataItem['id']]) ? $monthlyCustomerMovementReportData[$dataItem['id']] : ''; ?>
                    <tr class="items1">
                        <td><?php echo CHtml::encode($dataItem['transaction_number']); ?></td>
                        <td>
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['transaction_date']))); ?>
                        </td>
                        <td><?php echo CHtml::encode($movementTransactionInfo); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['product_price'])); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['service_price'])); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['ppn_total'])); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['total_price'])); ?></td>
                        <td><?php echo CHtml::encode($dataItem['invoice_number']); ?></td>
                        <td>
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['invoice_date']))); ?>
                        </td>
                        <td>
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['due_date']))); ?>
                        </td>
                        <td>
                            <?php $outstandingDays = date_diff(date_create($dataItem['due_date']), date_create(date('Y-m-d'))); ?>
                            <?php echo CHtml::encode($outstandingDays->format("%a days")); ?>
                        </td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['payment_left'])); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['payment_amount'])); ?></td>
                        <td><?php echo CHtml::encode($dataItem['payment_number']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>