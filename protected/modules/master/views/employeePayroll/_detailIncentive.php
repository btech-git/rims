<div class="row collapse">
    <div class="small-12 columns">
        <table class="detail">
            <?php foreach ($employee->incentiveDetails as $i => $incentiveDetail): ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeHiddenField($incentiveDetail, "[$i]incentive_id"); ?>
                        <?php echo CHtml::activeTextField($incentiveDetail, "[$i]incentive_name", array(
                            'size' => 50,
                            'value' => $incentiveDetail->incentive_id != "" ? $incentiveDetail->incentive->name : ''
                        )); ?>
                    </td>		

                    <td>
                        <?php echo CHtml::activeTextField($incentiveDetail, "[$i]amount", array(
                            'placeholder' => 'Amount',
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveIncentiveDetail', array('id' => $employee->header->id, 'index' => $i)),
                                'update' => '#incentive',
                            )),
                        )); ?>
                    </td> 
                </tr>
            <?php endforeach; ?>
        </table>
    </div>		
</div>