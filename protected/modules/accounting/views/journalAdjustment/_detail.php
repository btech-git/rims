<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Kode Akun</th>
        <th style="text-align: center">Nama Akun</th>
        <th style="text-align: center">Debit</th>
        <th style="text-align: center">Kredit</th>
        <th style="text-align: center">Memo</th>
        <th style="text-align: center"></th>
    </tr>
    
    <?php foreach ($journalVoucher->details as $i => $detail): ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]coa_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'coa.code')); ?>
                <?php echo CHtml::error($detail, 'coa_id'); ?>
            </td>
            
            <td><?php echo CHtml::encode(CHtml::value($detail, 'coa.name')); ?></td>
            
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]debit", array(
                    'size' => 10, 
                    'maxlength' => 18,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('AjaxJsonTotalDebit', array('id' => $journalVoucher->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#debit_' . $i . '").html(data.debit);
                            $("#total_debit").html(data.totalDebit);
                        }',
                    )),
                )); ?>
                <div id="debit_<?php echo $i; ?>" style="text-align: right; font-size: smaller">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'debit'))); ?>
                </div>
                <?php echo CHtml::error($detail, 'debit'); ?>
            </td>
            
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]credit", array(
                    'size' => 10, 
                    'maxlength' => 10,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('AjaxJsonTotalCredit', array('id' => $journalVoucher->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#credit_' . $i . '").html(data.credit);
                            $("#total_credit").html(data.totalCredit);
                        }',
                    )),
                )); ?>
                <div id="credit_<?php echo $i; ?>" style="text-align: right; font-size: smaller">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'credit'))); ?>
                </div>
                <?php echo CHtml::error($detail, 'credit'); ?>
            </td>
            
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]memo", array('size' => 30, 'maxlength' => 60)); ?>
                <?php echo CHtml::error($detail, 'memo'); ?>
            </td>
            
            <td>
                <?php echo CHtml::button('Delete', array(
                    'onclick' => CHtml::ajax(array(
                        'type' => 'POST',
                        'url' => CController::createUrl('AjaxHtmlRemoveDetail', array('id' => $journalVoucher->header->id, 'index' => $i)),
                        'update' => '#detail_div',
                    )),
                )); ?>
            </td>
        </tr>
    <?php endforeach; ?>
        
    <tr style="background-color: aquamarine">
        <td colspan="2" style="font-weight: bold; text-align: right">Total</td>
        <td style="font-weight: bold; text-align: center">
            <span id="total_debit">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $journalVoucher->totalDebit)); ?>
            </span>
        </td>
        <td style="font-weight: bold; text-align: center">
            <span id="total_credit">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $journalVoucher->totalCredit)); ?>
            </span>
        </td>
        <td colspan="2"></td>
    </tr>
</table>