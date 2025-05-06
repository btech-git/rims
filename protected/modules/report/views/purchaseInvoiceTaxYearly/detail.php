<div class="table_wrapper">
    <table class="responsive">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th></th>
                <th class="width1-1">PO #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Supplier</th>
                <th class="width1-4">Invoice #</th>
                <th class="width1-5">Tanggal Invoice</th>
                <th class="width1-6">Tanggal SJ</th>
                <th class="width1-7">SJ #</th>
                <th class="width1-8">Faktur Pajak #</th>
                <th class="width1-9">PPn/Non</th>
                <th class="width1-10">DPP (Rp)</th>
                <th class="width1-11">Disc (Rp)</th>
                <th class="width1-12">Sub Total (Rp)</th>
                <th class="width1-13">PPn (Rp)</th>
                <th class="width1-14">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $sumTotalRetailPrice = '0.00'; ?>
            <?php $sumPurchaseDiscount = '0.00'; ?>
            <?php $sumSubTotal = '0.00'; ?>
            <?php $sumTaxNominal = '0.00'; ?>
            <?php $sumGrandTotal = '0.00'; ?>
            <?php foreach ($purchaseInvoiceSummary->data as $i => $header): ?>
                <?php $totalRetailPrice = CHtml::value($header, 'totalRetailPrice'); ?>
                <?php $purchaseDiscount = CHtml::value($header, 'totalPurchaseDiscount'); ?>
                <?php $subTotal = CHtml::value($header, 'subTotal'); ?>
                <?php $taxNominal = CHtml::value($header, 'taxNominal'); ?>
                <?php $grandTotal = CHtml::value($header, 'grandTotal'); ?>
                <tr class="items1">
                    <td><?php echo $i + 1; ?></td>
                    <td class="width1-1">
                        <?php echo CHtml::link($header->purchaseOrder->purchase_order_no, array("/transaction/transactionPurchaseOrder/view", "id"=>$header->purchase_order_id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy hh:mm:ss', strtotime($header->purchaseOrder->purchase_order_date))); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'invoice_number')); ?></td>
                    <td class="width1-5">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->invoice_date))); ?>
                        <?php echo substr(CHtml::encode($header->created_datetime), -8); ?>
                    </td>
                    <td class="width1-6">
                        <?php echo empty($header) ? '' : CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->receive_item_date))); ?>
                    </td>
                    <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'supplier_delivery_number')); ?></td>
                    <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'invoice_tax_number')); ?></td>
                    <td class="width1-9"><?php echo CHtml::encode(CHtml::value($header, 'taxStatus')); ?></td>
                    <td class="width1-10" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalRetailPrice)); ?>
                    </td>
                    <td class="width1-11" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseDiscount)); ?>
                    </td>
                    <td class="width1-12" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $subTotal)); ?>
                    </td>
                    <td class="width1-13" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $taxNominal)); ?>
                    </td>
                    <td class="width1-14" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotal)); ?>
                    </td>
                </tr>
                <?php $sumTotalRetailPrice += $totalRetailPrice; ?>
                <?php $sumPurchaseDiscount += $purchaseDiscount; ?>
                <?php $sumSubTotal += $subTotal; ?>
                <?php $sumTaxNominal += $taxNominal; ?>
                <?php $sumGrandTotal += $grandTotal; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr id="header1">
                <td colspan="10" style="text-align: right; font-weight: bold">TOTAL</td>
                <td class="width1-3" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($sumTotalRetailPrice))); ?>
                </td>
                <td class="width1-4" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($sumPurchaseDiscount))); ?>
                </td>
                <td class="width1-5" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($sumSubTotal))); ?>
                </td>
                <td class="width1-6" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($sumTaxNominal))); ?>
                </td>
                <td class="width1-7" style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ($sumGrandTotal))); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>