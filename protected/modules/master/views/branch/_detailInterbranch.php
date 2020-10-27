<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Code</th>
        <th style="text-align: center">Name</th>
        <th style="text-align: center;">COA Interbranch</th>
    </tr>
    <?php foreach ($branch->interbranchDetails as $i => $detail): ?>	
        <?php echo CHtml::errorSummary($detail); ?>
        <tr style="background-color: azure;">
            <td style="text-align:center;">
                <?php echo CHtml::activeHiddenField($detail, "[$i]branch_id_to"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'branchIdTo.code')); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, 'branchIdTo.name')); ?>
            </td>
            <td style="text-align:center;">
                <?php echo CHtml::activeDropDownList($detail, "[$i]coa_id", CHtml::listData(Coa::model()->findAll(array('order'=>'code', 'condition' => "coa_id IS NOT NULL AND coa_sub_category_id = 7")), 'id', 'name'), array('empty' => '-- Select COA Interbranch --',)); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>