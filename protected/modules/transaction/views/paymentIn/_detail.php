<table>
    <thead>
        <tr>
            <th>Invoice #</th>
            <th>Asuransi</th>
            <th>Total Invoice</th>
            <th colspan="2">PPh</th>
            <th class="required">Payment Amount</th>
            <th>Memo</th>
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
                <td>
                    <?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.insuranceCompany.name")); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]total_invoice"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, "total_invoice"))); ?>
                </td>
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
                            url: "' . CController::createUrl('ajaxJsonAmount', array('id' => $paymentIn->header->id, 'index'=>$i)) . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#tax_service_amount_' . $i . '").html(data.taxServiceAmountFormatted);
                                $("#bank_fee_amount").html(data.bankFeeAmount);
                                $("#total_invoice").html(data.totalInvoice);
                                $("#total_payment").html(data.totalPayment);
                            },
                        });',
                        'class' => "form-control is-valid",
                    )); ?>
                </td>
                <td style="text-align: right">
                    <!--<span id="tax_service_amount_<?php echo $i; ?>">-->
                    <?php echo CHtml::activeTextField($detail, "[$i]tax_service_amount", array(
                        'onchange' => '$.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonAmount', array('id' => $paymentIn->header->id, 'index'=>$i)) . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#payment_amount_' . $i . '").html(data.paymentAmount);
                                $("#bank_fee_amount").html(data.bankFeeAmount);
                                $("#total_invoice").html(data.totalInvoice);
                                $("#total_payment").html(data.totalPayment);
                            },
                        });',                        
                    )); ?>
                    <!--</span>-->
                </td>
                <td>
                    <?php echo CHtml::activeTextField($detail, "[$i]amount", array(
                        'onchange' => '$.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonAmount', array('id' => $paymentIn->header->id, 'index'=>$i)) . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#payment_amount_' . $i . '").html(data.paymentAmount);
                                $("#bank_fee_amount").html(data.bankFeeAmount);
                                $("#total_invoice").html(data.totalInvoice);
                                $("#total_payment").html(data.totalPayment);
                            },
                        });',                        
                    )); ?>
                    <span id="payment_amount_<?php echo $i; ?>"></span>
                </td>
                <td><?php echo CHtml::activeTextField($detail, "[$i]memo"); ?></td>
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
<!--        <tr>
            <td colspan="5" style="text-align: right">Downpayment</td>
            <td>
                <?php /*echo CHtml::activeTextField($paymentIn->header, 'downpayment_amount', array(
                    'onchange' => '$.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $paymentIn->header->id)) . '",
                        data: $("form").serialize(),
                        success: function(data) {
                            $("#bank_fee_amount").html(data.bankFeeAmount);
                            $("#total_invoice").html(data.totalInvoice);
                            $("#total_payment").html(data.totalPayment);
                        },
                    });',                        
                ));*/ ?>
            </td>
            <td colspan="2"></td>
        </tr>-->
        <tr>
            <td colspan="5" style="text-align: right">Diskon</td>
            <td>
                <?php echo CHtml::activeTextField($paymentIn->header, 'discount_product_amount', array(
                    'onchange' => '$.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $paymentIn->header->id)) . '",
                        data: $("form").serialize(),
                        success: function(data) {
                            $("#bank_fee_amount").html(data.bankFeeAmount);
                            $("#total_invoice").html(data.totalInvoice);
                            $("#total_payment").html(data.totalPayment);
                        },
                    });',                        
                )); ?>
            </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: right">Beban Administrasi Bank</td>
            <td>
                <?php echo CHtml::activeTextField($paymentIn->header, 'bank_administration_fee', array(
                    'onchange' => '$.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $paymentIn->header->id)) . '",
                        data: $("form").serialize(),
                        success: function(data) {
                            $("#bank_fee_amount").html(data.bankFeeAmount);
                            $("#total_invoice").html(data.totalInvoice);
                            $("#total_payment").html(data.totalPayment);
                        },
                    });',
                )); ?>
            </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: right">Beban Merimen</td>
            <td>
                <?php echo CHtml::activeTextField($paymentIn->header, 'merimen_fee', array(
                    'onchange' => '$.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "' . CController::createUrl('ajaxJsonGrandTotal', array('id' => $paymentIn->header->id)) . '",
                        data: $("form").serialize(),
                        success: function(data) {
                            $("#bank_fee_amount").html(data.bankFeeAmount);
                            $("#total_invoice").html(data.totalInvoice);
                            $("#total_payment").html(data.totalPayment);
                        },
                    });',                        
                )); ?>
            </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: right">Biaya Bank</td>
            <td style="text-align: right">
                <span id="bank_fee_amount">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn->header, 'bank_fee_amount'))); ?>
                </span>
            </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: right">Total Payment</td>
            <td style="text-align: right">
                <span id="total_payment">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn->header, 'totalPayment'))); ?>
                </span>
            </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: right">Total Invoice</td>
            <td style="text-align: right">
                <span id="total_invoice">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn->header, 'totalInvoice'))); ?>
                </span>
            </td>
            <td colspan="2"></td>
        </tr>
<!--        <tr>
            <td colspan="4">Total PPh</td>
            <td style="text-align: right">
                <span id="total_service_tax">
                    <?php //echo CHtml::encode(CHtml::value($paymentIn->header, 'totalServiceTax')); ?>
                </span>
            </td>
            <td colspan="2"></td>
        </tr>-->
    </tfoot>
</table>
