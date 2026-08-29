<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Rincian Penerimaan Penjualan</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th>Payment #</th>
                <th>Tanggal Payment</th>
                <th>Customer</th>
                <th>Plat #</th>
                <th>Asuransi</th>
                <th>Payment Type</th>
                <th>Bank</th>
                <th>Jumlah</th>
                <th>PPh 21</th>
                <th>Diskon</th>
                <th>Biaya Bank</th>
                <th>Biaya Merimen</th>
                <th>DP</th>
                <th>OR</th>
                <th>Total Payment</th>
                <th>Invoice #</th>
                <th>Tanggal Invoice</th>
                <th>Total Invoice</th>
                <th>Sisa Invoice</th>
            </tr>
        </thead>
        <tbody>
            <?php $paymentAmount = '0.00'; ?>
            <?php $invoiceAmount = '0.00'; ?>
            <?php $remainingAmount = '0.00'; ?>
            
            <?php foreach ($paymentInSummary->dataProvider->data as $header): ?>
                <?php foreach ($header->paymentInDetails as $detail): ?>
                    <?php $totalAmount = CHtml::value($detail, 'totalAmount'); ?>
                    <?php $totalInvoice = CHtml::value($detail, 'total_invoice'); ?>
                    <?php $totalRemaining = $totalInvoice - $totalAmount; ?>
            
                    <tr class="items1">
                        <td>
                            <?php echo CHtml::link(CHtml::encode($header->payment_number), array(
                                "/transaction/paymentIn/view", 
                                "id" => $header->id,
                            ), array("target" => "_blank")); ?>
                        </td>
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->payment_date))); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'registrationTransaction.vehicle.plate_number')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'insuranceCompany.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'paymentType.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'companyBank.account_name')); ?></td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'tax_service_amount'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_amount'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'bank_administration_fee'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'merimen_fee'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'downpayment_amount'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'own_risk_amount'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalAmount)); ?>
                        </td>
                        <?php if ($detail->invoice_header_id !== null): ?>
                            <td>
                                <?php echo CHtml::link(CHtml::encode(CHtml::value($detail, 'invoiceHeader.invoice_number')), array(
                                    "/transaction/invoiceHeader/show", 
                                    "id" => $detail->invoice_header_id
                                ), array("target" => "_blank")); ?>
                            </td>
                            <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->invoiceHeader->invoice_date))); ?></td>
                        <?php elseif ($detail->sale_invoice_insurance_own_risk_id !== null): ?>
                            <td>
                                <?php echo CHtml::link(CHtml::encode(CHtml::value($detail, 'saleInvoiceInsuranceOwnRisk.transaction_number')), array(
                                    "/accounting/saleInvoiceInsuranceOwnRisk/show", 
                                    "id" => $detail->sale_invoice_insurance_own_risk_id
                                ), array("target" => "_blank")); ?>
                            </td>
                            <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->saleInvoiceInsuranceOwnRisk->transaction_date))); ?></td>
                        <?php else: ?>
                            <td>
                                <?php echo CHtml::link(CHtml::encode(CHtml::value($detail, 'registrationTransaction.downpayment_transaction_number')), array(
                                    "/frontDesk/registrationTransaction/show", 
                                    "id" => $detail->registration_transaction_id
                                ), array("target" => "_blank")); ?>
                            </td>
                            <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->registrationTransaction->downpayment_transaction_date))); ?></td>
                        <?php endif; ?>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalInvoice)); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalRemaining)); ?>
                        </td>
                    </tr>
                    
                    <?php $paymentAmount += $totalAmount; ?>
                    <?php $invoiceAmount += $totalInvoice; ?>
                    <?php $remainingAmount += $totalRemaining; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="14" style="text-align: right; font-weight: bold">TOTAL: </td>
                <td style="text-align: right; font-weight: bold">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentAmount)); ?>
                </td>
                <td style="text-align: right; font-weight: bold" colspan="3">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $invoiceAmount)); ?>
                </td>
                <td style="text-align: right; font-weight: bold" colspan="3">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $remainingAmount)); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>