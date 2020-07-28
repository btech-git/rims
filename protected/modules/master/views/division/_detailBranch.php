<table class="items saved_branch">
    <thead>
        <tr>
            <th colspan="2">Branch</th>
            <!-- <th><a href="#" class="sort-link">Level</a></th>
            <th><a href="#" class="sort-link"></a></th> -->
        </tr>
    </thead>
    <tbody >
        <?php foreach ($division->branchDetails as $i => $branchDetail): ?>
            <tr class="added" >
                <td><?php echo CHtml::activeHiddenField($branchDetail,"[$i]branch_id"); ?>
                <?php $branch = Branch::model()->findByPK($branchDetail->branch_id); ?>
                <?php echo CHtml::activeTextField($branchDetail,"[$i]branch_name",array('value'=>$branchDetail->branch_id!= '' ? $branch->name : '','readonly'=>true )); ?></td>
                <td>
                    <?php echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveBranchDetail', array('id' => $division->header->id, 'index' => $i,'branch_name'=>$branch->name)),
                            'update' => '#branch',
                            //'complete' => 'function(){$("#branch-grid").find("tr").children("td").html('.$branch->name.').removeClass("added");};',  
                        )),
                    )); ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>