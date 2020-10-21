<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Code</th>
        <th style="text-align: center">Name</th>
        <th style="text-align: center;">COA Interbranch</th>
    </tr>
    <?php foreach ($branchTos as $i => $detail): ?>	
        <tr style="background-color: azure;">
            <td style="text-align:center;">
                <?php echo CHtml::hiddenField("[$i]BranchIdTo", $detail->id); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'code')); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, 'name')); ?>
            </td>
            <td style="text-align:center;">
                <?php echo CHtml::dropDownList("[$i]CoaId", $coaId, CHtml::listData(Coa::model()->findAll(array('order'=>'code', 'condition' => "coa_id IS NOT NULL AND coa_sub_category_id = 7")), 'id', 'name'), array('empty' => '-- Select COA Interbranch --',)); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>