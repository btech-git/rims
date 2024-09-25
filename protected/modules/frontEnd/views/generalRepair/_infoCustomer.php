<table>
    <thead>
        <tr>
            <td>Name</td>
            <td>Type</td>
            <td>Address</td>
            <td>Email</td>
            <td>Rate</td>
            <td>Birth Date</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php echo CHtml::activeHiddenField($generalRepair->header, 'customer_id'); ?>
                <?php echo CHtml::encode(CHtml::value($customer, 'name')); ?>
                <?php echo CHtml::error($generalRepair->header,'customer_id'); ?>
            </td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'customer_type')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'address')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'email')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'flat_rate')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($customer, 'birthdate')); ?></td>
        </tr>
    </tbody>
</table>