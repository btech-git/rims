<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th></th>
                <th class="width1-1">Faktur #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-2">Customer</th>
                <th class="width1-3">Amount</th>
                <th class="width1-4">Parts (Rp)</th>
                <th class="width1-5">Jasa (Rp)</th>
                <th class="width1-6">DPP Parts</th>
                <th class="width1-7">DPP Jasa</th>
                <th class="width1-8">Total DPP</th>
                <th class="width1-9">Ppn</th>
                <th class="width1-10">Pph</th>
                <th class="width1-11">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $sumTotalAfterTax = '0.00'; ?>
            <?php $sumProductPriceAfterTax = '0.00'; ?>
            <?php $sumServicePriceAfterTax = '0.00'; ?>
            <?php $sumProductPrice = '0.00'; ?>
            <?php $sumServicePrice = '0.00'; ?>
            <?php $sumSubTotal = '0.00'; ?>
            <?php $sumPpnTotal = '0.00'; ?>
            <?php $sumPphTotal = '0.00'; ?>
            <?php $sumTotalPrice = '0.00'; ?>
            <?php foreach ($saleInvoiceSummary->data as $i => $header): ?>
                <?php $totalAfterTax = $header->subTotalAfterTax; ?>
                <?php $productPriceAfterTax = $header->productPriceAfterTax; ?>
                <?php $servicePriceAfterTax = $header->servicePriceAfterTax; ?>
                <?php $productPrice = $header->product_price; ?>
                <?php $servicePrice = $header->service_price; ?>
                <?php $subTotal = $header->subTotal; ?>
                <?php $ppnTotal = $header->ppn_total; ?>
                <?php $pphTotal = $header->pph_total; ?>
                <?php $totalPrice = $header->total_price; ?>
                <tr class="items1">
                    <td><?php echo $i + 1; ?></td>
                    <td class="width1-1">
                        <?php echo CHtml::link($header->invoice_number, array("/transaction/invoiceHeader/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('hh:mm:ss', strtotime($header->created_datetime))); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(CHtml::value($header, 'registrationTransaction.customer.name')); ?>
                    </td>
                    <td class="width1-3" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($totalAfterTax))); ?>
                    </td>
                    <td class="width1-4" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($productPriceAfterTax))); ?>
                    </td>
                    <td class="width1-5" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($servicePriceAfterTax))); ?>
                    </td>
                    <td class="width1-6" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($productPrice))); ?>
                    </td>
                    <td class="width1-7" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($servicePrice))); ?>
                    </td>
                    <td class="width1-8" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($subTotal))); ?>
                    </td>
                    <td class="width1-9" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($ppnTotal))); ?>
                    </td>
                    <td class="width1-10" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($pphTotal))); ?>
                    </td>
                    <td class="width1-11" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($totalPrice))); ?>
                    </td>
                </tr>
                <?php $sumTotalAfterTax += $totalAfterTax; ?>
                <?php $sumProductPriceAfterTax += $productPriceAfterTax; ?>
                <?php $sumServicePriceAfterTax += $servicePriceAfterTax; ?>
                <?php $sumProductPrice += $productPrice; ?>
                <?php $sumServicePrice += $servicePrice; ?>
                <?php $sumSubTotal += $subTotal; ?>
                <?php $sumPpnTotal += $ppnTotal; ?>
                <?php $sumPphTotal += $pphTotal; ?>
                <?php $sumTotalPrice += $totalPrice; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr id="header1">
                <td colspan="4" style="text-align: right; font-weight: bold">TOTAL</td>
                <td class="width1-3" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($sumTotalAfterTax))); ?>
                </td>
                <td class="width1-4" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($sumProductPriceAfterTax))); ?>
                </td>
                <td class="width1-5" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($sumServicePriceAfterTax))); ?>
                </td>
                <td class="width1-6" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($sumProductPrice))); ?>
                </td>
                <td class="width1-7" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($sumServicePrice))); ?>
                </td>
                <td class="width1-8" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($sumSubTotal))); ?>
                </td>
                <td class="width1-9" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($sumPpnTotal))); ?>
                </td>
                <td class="width1-10" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($sumPphTotal))); ?>
                </td>
                <td class="width1-11" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($sumTotalPrice))); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>