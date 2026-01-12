<table>
    <thead>
        <tr>
            <th>Invoice #</th>
            <th>Asuransi</th>
            <th>Plat #</th>
            <th>Memo</th>
            <th colspan="2">PPh</th>
            <th>Disc</th>
            <th>Biaya Bank</th>
            <th>Biaya Merimen</th>
            <th>DP</th>
            <th>Amount</th>
            <th>Total Payment</th>
            <th>Total Invoice</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($paymentIn->details as $i => $detail): ?>
            <tr>
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]invoice_header_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.invoice_number")); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.insuranceCompany.name")); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.vehicle.plate_number")); ?></td>
                <td><?php echo CHtml::activeTextField($detail, "[$i]memo"); ?></td>
                <td>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_tax_service", array(
                        '3' => 'Include Pph',
                        '1' => 'Add Pph', 
                        '2' => 'Non Pph',
                    ), array(
                        'empty' => '-- Pilih Pph --',
                        'onchange' => '$.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $paymentIn->header->id, 'index'=>$i)) . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#tax_service_amount_' . $i . '").html(data.taxServiceAmount);
                                $("#total_payment_detail_' . $i . '").html(data.totalDetailAmount);
                                $("#total_tax_service_amount").html(data.totalTaxServiceAmount);
                                $("#total_invoice").html(data.totalInvoice);
                                $("#total_detail_amount").html(data.totalPayment);
                            },
                        });',
                        'class' => "form-control is-valid",
                    )); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::activeTextField($detail, "[$i]tax_service_amount", array(
                        'onchange' => '$.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $paymentIn->header->id, 'index'=>$i)) . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#tax_service_amount_' . $i . '").html(data.taxServiceAmount);
                                $("#total_payment_detail_' . $i . '").html(data.totalDetailAmount);
                                $("#total_tax_service_amount").html(data.totalTaxServiceAmount);
                                $("#total_invoice").html(data.totalInvoice);
                                $("#total_detail_amount").html(data.totalPayment);
                            },
                        });',                        
                    )); ?>
                    <span id="tax_service_amount_<?php echo $i; ?>"></span>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::activeTextField($detail, "[$i]discount_amount", array(
                        'onchange' => '$.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $paymentIn->header->id, 'index'=>$i)) . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#discount_amount_' . $i . '").html(data.discountAmount);
                                $("#total_payment_detail_' . $i . '").html(data.totalDetailAmount);
                                $("#total_discount").html(data.totalDiscountAmount);
                                $("#total_invoice").html(data.totalInvoice);
                                $("#total_detail_amount").html(data.totalPayment);
                            },
                        });',                        
                    )); ?>
                    <span id="discount_amount_<?php echo $i; ?>"></span>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::activeTextField($detail, "[$i]bank_administration_fee", array(
                        'onchange' => '$.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $paymentIn->header->id, 'index'=>$i)) . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#bank_admin_fee_amount_' . $i . '").html(data.bankAdminFeeAmount);
                                $("#total_payment_detail_' . $i . '").html(data.totalDetailAmount);
                                $("#total_bank_admin_fee").html(data.totalBankAdminFeeAmount);
                                $("#total_invoice").html(data.totalInvoice);
                                $("#total_detail_amount").html(data.totalPayment);
                            },
                        });',                        
                    )); ?>
                    <span id="bank_admin_fee_amount_<?php echo $i; ?>"></span>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::activeTextField($detail, "[$i]merimen_fee", array(
                        'onchange' => '$.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $paymentIn->header->id, 'index'=>$i)) . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#merimen_fee_amount_' . $i . '").html(data.merimenFeeAmount);
                                $("#total_payment_detail_' . $i . '").html(data.totalDetailAmount);
                                $("#total_merimen_fee").html(data.totalMerimenFeeAmount);
                                $("#total_invoice").html(data.totalInvoice);
                                $("#total_payment").html(data.totalPayment);
                            },
                        });',                        
                    )); ?>
                    <span id="merimen_fee_amount_<?php echo $i; ?>"></span>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::activeTextField($detail, "[$i]downpayment_amount", array(
                        'onchange' => '$.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $paymentIn->header->id, 'index'=>$i)) . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#downpayment_amount_' . $i . '").html(data.downpaymentAmount);
                                $("#total_payment_detail_' . $i . '").html(data.totalDetailAmount);
                                $("#total_downpayment_amount").html(data.totalDownpaymentAmount);
                                $("#total_invoice").html(data.totalInvoice);
                                $("#total_payment").html(data.totalPayment);
                            },
                        });',                        
                    )); ?>
                    <span id="downpayment_amount_<?php echo $i; ?>"></span>
                </td>
                <td>
                    <?php echo CHtml::activeTextField($detail, "[$i]amount", array(
                        'onchange' => '$.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $paymentIn->header->id, 'index'=>$i)) . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#payment_amount_' . $i . '").html(data.paymentAmount);
                                $("#total_payment_detail_' . $i . '").html(data.totalDetailAmount);
                                $("#total_payment_amount").html(data.totalAmount);
                                $("#total_invoice").html(data.totalInvoice);
                                $("#total_payment").html(data.totalPayment);
                            },
                        });',                        
                    )); ?>
                    <span id="payment_amount_<?php echo $i; ?>"></span>
                </td>
                <td style="text-align: right">
                    <span id="total_payment_detail_<?php echo $i; ?>">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'totalAmount'))); ?>
                    </span>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]total_invoice"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, "total_invoice"))); ?>
                </td>
                <td>
                    <?php echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $paymentIn->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align: right">Total</td>
            <td style="text-align: right">
                <span id="total_tax_service_amount">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn->header, 'tax_service_amount'))); ?>
                </span>
            </td>
            <td style="text-align: right">
                <span id="total_discount">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn->header, 'discount_product_amount'))); ?>
                </span>
            </td>
            <td style="text-align: right">
                <span id="total_bank_admin_fee">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn->header, 'bank_administration_fee'))); ?>
                </span>
            </td>
            <td style="text-align: right">
                <span id="total_merimen_fee">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn->header, 'merimen_fee'))); ?>
                </span>
            </td>
            <td style="text-align: right">
                <span id="total_downpayment_amount">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn->header, 'downpayment_amount'))); ?>
                </span>
            </td>
            <td style="text-align: right">
                <span id="total_payment_amount">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn->header, 'payment_amount'))); ?>
                </span>
            </td>
            <td style="text-align: right">
                <span id="total_detail_amount">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'totalPayment'))); ?>
                </span>
            </td>
            <td style="text-align: right">
                <span id="total_invoice">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'totalInvoice'))); ?>
                </span>
            </td>
            <td></td>
        </tr>
    </tfoot>
</table>
