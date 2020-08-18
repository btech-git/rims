<?php if (count($cashTransaction->details)): ?>
    <table>
        <thead>
            <tr>
                <th>COA</th>
                <th>Normal Balance</th>
                <th>COA Debit Amount</th>
                <th>COA Credit Amount</th>
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
                            //'onclick' => '$("#product'.$i.'-dialog").dialog("open"); return false;',
                            'value' => $detail->coa_id == "" ? '' : Coa::model()->findByPk($detail->coa_id)->name
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($detail, "[$i]coa_normal_balance", array(
                            'size' => 15,
                            'maxlength' => 10,
                            'readonly' => true,
                            //'onclick' => '$("#product'.$i.'-dialog").dialog("open"); return false;',
                            'value' => $detail->coa_id == "" ? '' : Coa::model()->findByPk($detail->coa_id)->normal_balance
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($detail, "[$i]coa_debit", array(
                            'size' => 15,
                            'maxlength' => 10,
                            'readonly' => true,
                            //'onclick' => '$("#product'.$i.'-dialog").dialog("open"); return false;',
                            'value' => $detail->coa_id == "" ? '' : Coa::model()->findByPk($detail->coa_id)->debit
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($detail, "[$i]coa_credit", array(
                            'size' => 15,
                            'maxlength' => 10,
                            'readonly' => true,
                            //'onclick' => '$("#product'.$i.'-dialog").dialog("open"); return false;',
                            'value' => $detail->coa_id == "" ? '' : Coa::model()->findByPk($detail->coa_id)->credit
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($detail, "[$i]amount", array('onchange' =>
                            '
									
								'
                        )); ?>
                        <?php echo CHtml::button('Count', array(
                            'id' => 'count_' . $i,
                            'style' => 'display:none',
                            'onclick' => '
                            $.ajax({
                              type: "POST",
                              url: "' . CController::createUrl('ajaxGetCount', array('coaId' => $detail->coa_id, 'type' => $cashTransaction->header->transaction_type, 'amount' => '')) . '"+$("#CashTransactionDetail_' . $i . '_amount").val(),
                              data: $("form").serialize(),
                              dataType: "json",
                              success: function(data) {
                                  console.log(data.total);

                                if($("#CashTransaction_transaction_type").val() == "In")
                                    $("#CashTransactionDetail_' . $i . '_coa_credit").val(data.total);
                                else
                                    $("#CashTransactionDetail_' . $i . '_coa_debit").val(data.total);
                              },
                            });',
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextArea($detail, "[$i]notes"); ?>
                    </td>
                    <td>
                        <?php echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $cashTransaction->header->id, 'index' => $i)),
                                'update' => '.detail',
                            )),
                        )); ?>
                    </td>
                </tr>
                <?php Yii::app()->clientScript->registerScript('myjqueryCount' . $i, '
                        $("#CashTransactionDetail_' . $i . '_amount").keyup(function(event){
                                $("#total-button").click();
                                $("#count_' . $i . '").click();
                                //alert("test");
                        });
                '); ?>
            <?php endforeach ?>
        </tbody>
    </table>
<?php endif ?>

