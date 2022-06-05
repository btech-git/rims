<table style="border: 1px solid">
    <thead>
        <tr style="background-color: skyblue">
            <th style="text-align: center; width: 3%">No.</th>
            <th style="text-align: center">Description</th>
            <th style="text-align: center">Memo</th>
            <th style="text-align: center; width: 15%">Amount</th>
            <th style="width: 5%"></th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($workOrderExpense->details as $i => $detail): ?>
            <tr style="background-color: azure">
                <td style="text-align: center"><?php echo $i + 1; ?></td>
                <td>
                    <?php echo CHtml::activeTextField($detail, "[$i]description"); ?>
                    <?php echo CHtml::error($detail, 'description'); ?>
                </td>
                
                <td style="text-align: right">
                    <?php echo CHtml::activeTextField($detail, "[$i]memo", array('size'=>20, 'maxlength'=>60)); ?>
                    <?php echo CHtml::error($detail, 'memo'); ?>
                </td>
                
                <td style="text-align: right">
                    <?php echo CHtml::activeTextField($detail, "[$i]amount", array(
                        'size' => 5, 
                        'maxLength' => 10,
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonTotal', array('id' => $workOrderExpense->header->id, 'index' => $i)),
                            'success' => 'function(data) {
                                $("#grand_total").html(data.grandTotal);
                            }',
                        )),
                    )); ?>
                    <?php echo CHtml::error($detail, 'amount'); ?>
                </td>

                <td>
                    <?php echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $workOrderExpense->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                </td>
            </tr>
	<?php endforeach; ?>
    </tbody>
    
    <tfoot>
	<tr style="background-color: aquamarine">
            <td colspan="3" style="text-align: right; font-weight: bold">Total:</td>
            <td style="text-align: right; font-weight: bold">
                <span id="grand_total">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($workOrderExpense, 'totalDetail'))); ?>
                    </span>
            </td>
            <td></td>
	</tr>
    </tfoot>
</table>
