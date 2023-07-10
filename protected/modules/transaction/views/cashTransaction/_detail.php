<?php if (count($cashTransaction->details)): ?>
    <table>
        <thead>
            <tr>
                <th>COA</th>
                <th>Normal Balance</th>
                <th>Debit Amount</th>
                <th>Credit Amount</th>
                <th>Amount</th>
                <th>Notes</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cashTransaction->details as $i => $detail): ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]coa_id", array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo CHtml::encode(CHtml::value($cashTransaction, 'branch.code')); ?>
                        <?php echo CHtml::activeTextField($detail, "[$i]coa_name", array(
                            'size' => 15,
                            'maxlength' => 10,
                            'readonly' => true,
                            'value' => $detail->coa_id == "" ? '' : Coa::model()->findByPk($detail->coa_id)->name
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($detail, "[$i]coa_normal_balance", array(
                            'size' => 15,
                            'maxlength' => 10,
                            'readonly' => true,
                            'value' => $detail->coa_id == "" ? '' : Coa::model()->findByPk($detail->coa_id)->normal_balance
                        )); ?>
                    </td>
                    <td style="text-align: right">
                        <span id="amount_debit_<?php echo $i; ?>">
                            <?php echo CHtml::encode(CHtml::value($detail, 'coa_debit')); ?>
                            <?php /*echo CHtml::activeTextField($detail, "[$i]coa_debit", array(
                                'size' => 15,
                                'maxlength' => 10,
                                'readonly' => true,
                            ));*/ ?>
                        </span>
                    </td>
                    <td style="text-align: right">
                        <span id="amount_credit_<?php echo $i; ?>">
                            <?php echo CHtml::encode(CHtml::value($detail, 'coa_credit')); ?>
                            <?php /*echo CHtml::activeTextField($detail, "[$i]coa_credit", array(
                                'size' => 15,
                                'maxlength' => 10,
                                'readonly' => true,
                            ));*/ ?>
                        </span>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($detail, "[$i]amount", array(
                            'size' => 7, 
                            'maxLength' => 20,
                            'onchange' => '
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxJsonTotal', array(
                                        'id' => $cashTransaction->header->id, 
                                        'index' => $i, 
                                        'type' => $cashTransaction->header->transaction_type, 
                                    )) . '", 
                                    data: $("form").serialize(), 
                                    success: function(data) {
                                        $("#amount_debit_' . $i . '").html(data.amountDebit);
                                        $("#amount_credit_' . $i . '").html(data.amountCredit);
                                        $("#debit_amount").html(data.totalDebitFormatted);
                                        $("#credit_amount").html(data.totalCreditFormatted);
                                        $("#' . CHtml::activeId($cashTransaction->header, "debit_amount") . '").val(data.totalDebit);
                                        $("#' . CHtml::activeId($cashTransaction->header, "credit_amount") . '").val(data.totalCredit);
                                    },
                                });	
                            ',
                        )); ?>
                        <?php /*echo CHtml::button('Count', array(
                            'id' => 'count_' . $i,
                            'style' => 'display:none',
                            'onclick' => '
                            $.ajax({
                              type: "POST",
                              url: "' . CController::createUrl('ajaxGetCount', array(
                                  'coaId' => $detail->coa_id, 
                                  'type' => $cashTransaction->header->transaction_type, 
                                  'amount' => ''
                              )) . '"+$("#CashTransactionDetail_' . $i . '_amount").val(),
                              data: $("form").serialize(),
                              dataType: "json",
                              success: function(data) {
                                console.log(data.total);

                                if ($("#CashTransaction_transaction_type").val() == "In")
                                    $("#CashTransactionDetail_' . $i . '_coa_credit").val(data.total);
                                else
                                    $("#CashTransactionDetail_' . $i . '_coa_debit").val(data.total);
                              },
                            });',
                        ));*/ ?>
                    </td>
                    <td><?php echo CHtml::activeTextArea($detail, "[$i]notes"); ?></td>
                    <td>
                        <?php echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveDetail', array(
                                    'id' => $cashTransaction->header->id, 
                                    'index' => $i
                                )),
                                'update' => '.detail',
                            )),
                        )); ?>
                    </td>
                </tr>
                <?php Yii::app()->clientScript->registerScript('myjqueryCount' . $i, '
                    $("#CashTransactionDetail_' . $i . '_amount").keyup(function(event){
                        $("#total-button").click();
                        $("#count_' . $i . '").click();
                    });
                '); ?>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td style="text-align: right">
                    <span id="debit_amount">
                        <?php echo CHtml::encode(CHtml::value($cashTransaction->header, 'debit_amount')); ?>
                        <?php echo CHtml::activeHiddenField($cashTransaction->header, 'debit_amount', array(
                            'size' => 18, 
                            'maxlength' => 18, 
                            'readonly' => true
                        )); ?>
                    </span>
                    <?php echo CHtml::error($cashTransaction->header, 'debit_amount'); ?>
                </td>
                <td style="text-align: right">
                    <span id="credit_amount">
                        <?php echo CHtml::encode(CHtml::value($cashTransaction->header, 'credit_amount')); ?>
                        <?php echo CHtml::activeHiddenField($cashTransaction->header, 'credit_amount', array(
                            'size' => 18, 
                            'maxlength' => 18, 
                            'readonly' => true
                        )); ?>
                    </span>
                    <?php echo CHtml::error($cashTransaction->header, 'credit_amount'); ?>
                </td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>
<?php endif ?>

