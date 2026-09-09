<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></div>
    <div style="font-size: larger">Faktur Penjualan Summary</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th></th>
                <th>Faktur #</th>
                <th>Tanggal</th>
                <th>RG #</th>
                <th>Customer</th>
                <th>Plat #</th>
                <th>Kendaraan</th>
                <th>Asuransi</th>
                <th>Status</th>
                <th>Memo</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Remaining</th>
                <th>Payment in #</th>
                <th>Tanggal</th>
                <th>Jumlah Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php $totalInvoice = '0.00'; ?>
            <?php $totalPaymentAmount = '0.00'; ?>
            <?php $totalPaymentLeft = '0.00'; ?>
            <?php $totalPaymentSum = '0.00'; ?>

            <?php foreach ($saleInvoiceOwnRiskSummary->dataProvider->data as $i => $header): ?>
                <?php $paymentInDetail = PaymentInDetail::model()->findByAttributes(array('sale_invoice_insurance_own_risk_id' => $header->id)); ?>
                <?php $invoiceAmount = CHtml::value($header, 'amount_invoice'); ?>
                <?php $paymentAmount = CHtml::value($header, 'amount_payment'); ?>
                <?php $paymentLeft = CHtml::value($header, 'payment_remaining'); ?>
                <?php $amount = CHtml::value($paymentInDetail, 'own_risk_amount'); ?>
            
                <tr class="items1">
                    <td><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->transaction_number), array(
                            "/transaction/saleInvoiceInsuranceOwnRisk/show", 
                            "id" => $header->id
                        ), array("target" => "_blank")); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->transaction_date))); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.transaction_number')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'vehicle.plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'insuranceCompany.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceAmount)); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentAmount)); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentLeft)); ?>
                    </td>
                    <?php if ($paymentInDetail !== null): ?>
                        <td>
                            <?php echo CHtml::link(CHtml::value($paymentInDetail, 'paymentIn.payment_number'), array(
                                "/transaction/paymentIn/view", 
                                "id" => $paymentInDetail->payment_in_id
                            ), array("target" => "_blank")); ?>
                        </td>
                        <td>
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($paymentInDetail, 'paymentIn.payment_date')))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amount)); ?>
                        </td>
                    <?php else: ?>
                        <td colspan="3">&nbsp;</td>
                    <?php endif; ?>
                </tr>
                <?php $totalInvoice += $invoiceAmount; ?>
                <?php $totalPaymentAmount += $paymentAmount; ?>
                <?php $totalPaymentLeft += $paymentLeft; ?>
                <?php $totalPaymentSum += $amount; ?>

            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr id="header1">
                <td colspan="10" style="text-align: right; font-weight: bold">TOTAL</td>
                <td style="text-align: right; font-weight: bold"> 
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalInvoice)); ?>
                </td>
                <td style="text-align: right; font-weight: bold"> 
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPaymentAmount)); ?>
                </td>
                <td style="text-align: right; font-weight: bold"> 
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPaymentLeft)); ?>
                </td>
                <td colspan="3" style="text-align: right; font-weight: bold"> 
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPaymentSum)); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>