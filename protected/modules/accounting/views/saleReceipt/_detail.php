<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Invoice #</th>
            <th>Tanggal</th>
            <th>Jatuh Tempo</th>
            <th>Plat #</th>
            <th>Kendaraan</th>
            <th>SPK #</th>
            <th>Jasa</th>
            <th>Parts</th>
            <th>Total</th>
            <th style="width: 3%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($saleReceipt->details as $i => $detail): ?>
            <tr>
                <td><?php echo CHtml::encode($i + 1); ?></td>
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]invoice_header_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.invoice_number")); ?>
                </td>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", strtotime(CHtml::value($detail, "invoiceHeader.invoice_date")))); ?></td>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", strtotime(CHtml::value($detail, "invoiceHeader.due_date")))); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.vehicle.plate_number")); ?></td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.vehicle.carMake.name")); ?> -
                    <?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.vehicle.carModel.name")); ?> -
                    <?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.vehicle.carSubModel.name")); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.registrationTransaction.customer_work_order_number")); ?></td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, "invoiceHeader.service_price"))); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]downpayment_amount"); ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]insurance_own_risk_amount"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, "invoiceHeader.product_price"))); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]receivable_amount"); ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]invoice_amount"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, "invoice_amount"))); ?>
                </td>
                <td>
                    <?php echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $saleReceipt->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7" style="text-align: right; font-weight: bold">Sub Total</td>
            <td style="text-align: right; font-weight: bold">
                    <?php echo CHtml::activeHiddenField($saleReceipt->header, "total_downpayment_amount"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleReceipt, 'totalServiceAmount'))); ?>
            </td>
            <td style="text-align: right; font-weight: bold">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleReceipt, 'totalPartsAmount'))); ?>
            </td>
            <td style="text-align: right">
                <span style="font-weight: bold">
                    <?php echo CHtml::activeHiddenField($saleReceipt->header, "total_invoice_amount"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleReceipt->header, 'total_invoice_amount'))); ?>
                </span>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: right; font-weight: bold">
                <?php echo CHtml::activeHiddenField($saleReceipt->header, "tax_item_percentage"); ?>
                PPn <?php echo CHtml::encode(CHtml::value($saleReceipt->header, "tax_item_percentage")); ?>%
            </td>
            <td style="text-align: right; font-weight: bold">
                <?php echo CHtml::activeHiddenField($saleReceipt->header, "tax_item_amount"); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleReceipt->header, "tax_item_amount"))); ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: right; font-weight: bold">
                PPh 23 <?php echo CHtml::encode(CHtml::value($saleReceipt->header, "tax_service_percentage")); ?>%
            </td>
            <td>
                <?php echo CHtml::activeTextField($saleReceipt->header, "tax_service_amount", array(
                    'onchange' => '$.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $saleReceipt->header->id)) . '",
                        data: $("form").serialize(),
                        success: function(data) {
                            $("#' . CHtml::activeId($saleReceipt->header, "total_receivable_amount") . '").val(data.totalReceivableAmount);
                            $("#grand_total_receivable").html(data.totalReceivable);
                        },
                    });',                        
                )); ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: right; font-weight: bold">Grand Total</td>
            <td style="text-align: right; font-weight: bold">
                <?php echo CHtml::activeHiddenField($saleReceipt->header, "total_receivable_amount"); ?>
                <span id="grand_total_receivable">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleReceipt->header, "total_receivable_amount"))); ?>
                </span>
            </td>
            <td></td>
        </tr>
    </tfoot>
</table>
