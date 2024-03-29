<div class="row collapse">
    <div class="small-12 columns">
        <table class="detail">
            <?php foreach ($employee->bankDetails as $i => $bankDetail): ?>
                <tr>
                    <td><?php echo CHtml::activeHiddenField($bankDetail, "[$i]bank_id"); ?></td>
                    <td><?php echo CHtml::activeTextField($bankDetail, "[$i]bank_name", array('size' => 35, 'value' => $bankDetail->bank_id != "" ? $bankDetail->bank->name : '')); ?></td>		
                    <td>
                        <?php echo CHtml::activeTextField($bankDetail, "[$i]account_name", array(
                            'value' => $bankDetail->id == "" ? '' : $bankDetail->account_name,
                            'placeholder' => 'Account Name',
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($bankDetail, "[$i]account_no", array(
                            'placeholder' => 'Account Number',
                        )); ?>
                    </td>

                    <td>
                        <?php echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveBankDetail', array('id' => $employee->header->id, 'index' => $i)),
                                'update' => '#bank',
                            )),
                        )); ?>
                    </td> 
                </tr>
            <?php endforeach; ?>
        </table>
    </div>		
</div>