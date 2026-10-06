<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Piutang Asuransi Bulanan</div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr id="header1">
                <th>RG #</th>
                <th>RG Date</th>
                <th>RG Amount</th>
                <th>Movement Out</th>
                <th>Parts (Rp)</th>
                <th>Jasa (Rp)</th>
                <th>PPn</th>
                <th>Total</th>
                <th>Inv #</th>
                <th>Inv Date</th>
                <th>Umur (hari)</th>
                <th>F. Pajak</th>
                <th>Jatuh Tempo</th>
                <th>OS</th>
                <th>Pelunasan</th>
                <th>Payment #</th>
                <th>TGL Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($monthlyInsuranceReceivableSummary->dataProvider->data as $i => $insurance): ?>
                <tr class="items1">
                    <td colspan="16" style="font-weight: bold; text-align: center"><?php echo CHtml::encode($i + 1); ?> - <?php echo CHtml::encode(CHtml::value($insurance, 'name')); ?></td>
                </tr>
                <?php foreach ($monthlyInsuranceReceivableReportData[$insurance->id] as $dataItem): ?>
                    <?php $movementTransactionInfo = isset($monthlyInsuranceMovementReportData[$dataItem['id']]) ? $monthlyInsuranceMovementReportData[$dataItem['id']] : ''; ?>
                    <tr class="items1">
                        <td style="text-align: center"><?php echo CHtml::encode($dataItem['transaction_number']); ?></td>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['transaction_date']))); ?>
                        </td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['grand_total'])); ?></td>
                        <td style="text-align: center"><?php echo CHtml::encode($movementTransactionInfo); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['product_price'])); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['service_price'])); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['ppn_total'])); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['total_price'])); ?></td>
                        <td style="text-align: center"><?php echo CHtml::encode($dataItem['invoice_number']); ?></td>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['invoice_date']))); ?>
                        </td>
                        <td>
                            <?php $outstandingDays = date_diff(date_create($dataItem['invoice_date']), date_create(date('Y-m-d'))); ?>
                            <?php echo CHtml::encode($outstandingDays->format("%a days")); ?>
                        </td>
                        <td style="text-align: center"><?php echo CHtml::encode($dataItem['transaction_tax_number']); ?></td>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['due_date']))); ?>
                        </td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['payment_left'])); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['payment_amount'])); ?></td>
                        <td style="text-align: center"><?php echo CHtml::encode($dataItem['payment_number']); ?></td>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['payment_date']))); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>