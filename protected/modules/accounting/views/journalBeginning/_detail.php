<table style="border: 1px solid">
    <thead>
        <tr style="background-color: skyblue">
            <th style="text-align: center; width: 10%">Kode Akun</th>
            <th style="text-align: center; width: 15%">Nama Akun</th>
            <th style="text-align: center; width: 15%">Saldo Sekarang</th>
            <th style="text-align: center; width: 15%">Saldo Penyesuaian</th>
            <th style="text-align: center; width: 15%">Saldo Selisih</th>
            <th style="text-align: center">Memo</th>
            <th style="text-align: center; width: 3%"></th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($journalBeginning->details as $i => $detail): ?>
            <tr style="background-color: azure">
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]coa_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'coa.code')); ?> - 
                    <?php echo CHtml::error($detail, 'coa_id'); ?>
                </td>

                <td><?php echo CHtml::encode(CHtml::value($detail, 'coa.name')); ?></td>

                <td style="text-align: right">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]current_balance"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'current_balance'))); ?>
                    <?php echo CHtml::error($detail, 'current_balance'); ?>
                </td>

                <td style="text-align: right">
                    <?php echo CHtml::activeTextField($detail, "[$i]adjustment_balance", array(
                        'size' => 10, 
                        'maxlength' => 18,
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonAdjustmentBalance', array('id' => $journalBeginning->header->id, 'index' => $i)),
                            'success' => 'function(data) {
                                $("#adjustment_balance_' . $i . '").html(data.adjustmentBalance);
                                $("#difference_balance_' . $i . '").html(data.differenceBalance);
                                $("#' . CHtml::activeId($detail, "[$i]difference_balance") . '").val(data.differenceBalanceRaw);
                            }',
                        )),
                    )); ?>
                    <div id="adjustment_balance_<?php echo $i; ?>" style="text-align: right; font-size: smaller">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'adjustment_balance'))); ?>
                    </div>
                    <?php echo CHtml::error($detail, 'adjustment_balance'); ?>
                </td>

                <td style="text-align: right">
                    <?php echo CHtml::activeTextField($detail, "[$i]difference_balance"); ?>
                    <div id="difference_balance_<?php echo $i; ?>" style="text-align: right;">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'difference_balance'))); ?>
                    </div>
                    <?php echo CHtml::error($detail, 'difference_balance'); ?>
                </td>

                <td style="text-align: center">
                    <?php echo CHtml::activeTextField($detail, "[$i]memo", array('size' => 30, 'maxlength' => 60)); ?>
                    <?php echo CHtml::error($detail, 'memo'); ?>
                </td>

                <td>
                    <?php echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveAccountDetail', array('id' => $journalBeginning->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>