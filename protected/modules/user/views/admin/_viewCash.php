<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][cashierHead]", CHtml::resolveValue($model, "roles[cashierHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'cashierHead')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
            <th style="text-align: center">Supervisor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Transaksi Kas</td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][cashTransactionCreate]", CHtml::resolveValue($model, "roles[cashTransactionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionCreate')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][cashTransactionEdit]", CHtml::resolveValue($model, "roles[cashTransactionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionEdit')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][cashTransactionApproval]", CHtml::resolveValue($model, "roles[cashTransactionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionApproval')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][cashTransactionSupervisor]", CHtml::resolveValue($model, "roles[cashTransactionSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionSupervisor')); ?></td>
        </tr>
        <tr>
            <td>Transaksi Jurnal Umum</td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][adjustmentJournalCreate]", CHtml::resolveValue($model, "roles[adjustmentJournalCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'adjustmentJournalCreate')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][adjustmentJournalEdit]", CHtml::resolveValue($model, "roles[adjustmentJournalEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'adjustmentJournalEdit')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][adjustmentJournalApproval]", CHtml::resolveValue($model, "roles[adjustmentJournalApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'adjustmentJournalApproval')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][adjustmentJournalSupervisor]", CHtml::resolveValue($model, "roles[adjustmentJournalSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'adjustmentJournalSupervisor')); ?></td>
        </tr>
    </tbody>
</table>