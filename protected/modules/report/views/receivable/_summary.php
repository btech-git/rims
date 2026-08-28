<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Faktur Belum Lunas Customer</div>
    <div><?php echo 'Per tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Name</th>
                <th class="width1-2">Type</th>
                <th class="width1-3">Akun</th>
            </tr>
            <tr id="header2">
                <td colspan="3">
                    <table>
                        <tr>
                            <th class="width2-1">Tanggal</th>
                            <th class="width2-2">Jatuh Tempo</th>
                            <th class="width2-3">Faktur #</th>
                            <th class="width2-4">Plat #</th>
                            <th class="width2-5">Kendaraan</th>
                            <th>Parts (Rp)</th>
                            <th>Jasa (Rp)</th>
                            <th>DPP Parts</th>
                            <th>DPP Jasa</th>
                            <th>Total DPP</th>
                            <th>Ppn</th>
                            <th>Pph</th>
                            <th class="width2-7">Grand Total</th>
                            <th class="width2-8">Payment</th>
                            <th class="width2-9">Remaining</th>
                        </tr>
                    </table>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($receivableSummary->dataProvider->data as $customer): ?>
                <tr class="items1">
                    <th class="width1-1"><?php echo CHtml::encode(CHtml::value($customer, 'name')); ?></th>
                    <th class="width1-2"><?php echo CHtml::encode(CHtml::value($customer, 'customer_type')); ?></th>
                    <th class="width1-3"><?php echo CHtml::encode(CHtml::value($customer, 'coa.name')); ?></th>
                </tr>
                <tr class="items2">
                    <td colspan="3">
                        <table>
                            <?php $totalRevenue = '0.00'; ?>
                            <?php $totalPayment = '0.00'; ?>
                            <?php $totalReceivable = '0.00'; ?>
                            <?php foreach ($receivableReportData[$customer->id] as $receivableReportItem): ?>
                                <?php $revenue = $receivableReportItem['total_price']; ?>
                                <?php $paymentAmount = isset($receivablePaymentReportData[$receivableReportItem['id']]) ? $receivablePaymentReportData[$receivableReportItem['id']] : '0.00'; ?>
                                <?php $paymentLeft = $revenue - $paymentAmount; ?>
                                <tr>
                                    <td class="width2-1">
                                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receivableReportItem['invoice_date']))); ?>
                                    </td>
                                    <td class="width2-2">
                                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receivableReportItem['due_date']))); ?>
                                    </td>
                                    <td class="width2-3">
                                        <?php echo CHtml::link($receivableReportItem['invoice_number'], array(
                                            '/report/receivable/transactionInfo', 
                                            'invoiceId' => $receivableReportItem['id'], 
                                            'endDate' => $endDate,
                                        ), array('target' => '_blank'));?>
                                    </td>
                                    <td class="width2-4"><?php echo CHtml::encode($receivableReportItem['plate_number']); ?></td>
                                    <td class="width2-5">
                                        <?php echo CHtml::encode($receivableReportItem['car_make']); ?> - 
                                        <?php echo CHtml::encode($receivableReportItem['car_model']); ?> - 
                                        <?php echo CHtml::encode($receivableReportItem['car_sub_model']); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $receivableReportItem['product_price_after_tax'])); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $receivableReportItem['service_price_after_tax'])); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $receivableReportItem['product_price'])); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $receivableReportItem['service_price'])); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $receivableReportItem['subtotal'])); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $receivableReportItem['ppn_total'])); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $receivableReportItem['pph_total'])); ?>
                                    </td>
                                    <td class="width2-7" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $revenue)); ?>
                                    </td>
                                    <td class="width2-8" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentAmount)); ?>
                                    </td>
                                    <td class="width2-9" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentLeft)); ?>
                                    </td>
                                </tr>
                                <?php $totalRevenue += $revenue; ?>
                                <?php $totalPayment += $paymentAmount; ?>
                                <?php $totalReceivable += $paymentLeft; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="12" style="text-align: right; font-weight: bold">TOTAL</td>
                                <td class="width2-7" style="text-align: right; font-weight: bold"> 
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalRevenue)); ?>
                                </td>
                                <td class="width2-8" style="text-align: right; font-weight: bold"> 
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPayment)); ?>
                                </td>
                                <td class="width2-9" style="text-align: right; font-weight: bold"> 
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalReceivable)); ?>
                                </td>
                            </tr>     
                        </table>
                    </td>
                </tr>
            <?php endforeach; ?>   
        </tbody>
    </table>
</div>