<table style="border: 1px solid">
    <tbody>
        <?php foreach ($purchaseOrder->detailBranches as $i => $detail): ?>
            <tr style="background-color: azure">
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]branch_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'branch.code')); ?>
                    <?php echo CHtml::error($detail, 'branch_id'); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'branch.name')); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
