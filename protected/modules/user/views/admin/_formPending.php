<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][pendingHead]", CHtml::resolveValue($model, "roles[pendingHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'pendingHead')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Daftar Transaksi Pending</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][pendingTransactionView]", CHtml::resolveValue($model, "roles[pendingTransactionView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'pendingTransactionView')); ?>
            </td>
        </tr>
        <tr>
            <td>Order Outstanding</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][orderOutstandingView]", CHtml::resolveValue($model, "roles[orderOutstandingView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'orderOutstandingView')); ?>
            </td>
        </tr>
        <tr>
            <td>Approval Permintaan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][requestApprovalView]", CHtml::resolveValue($model, "roles[requestApprovalView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'requestApprovalView')); ?>
            </td>
        </tr>
        <tr>
            <td>Approval Data Master</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterApprovalView]", CHtml::resolveValue($model, "roles[masterApprovalView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterApprovalView')); ?>
            </td>
        </tr>
        <tr>
            <td>Pending Jurnal</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][pendingJournalView]", CHtml::resolveValue($model, "roles[pendingJournalView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'pendingJournalView')); ?>
            </td>
        </tr>
    </tbody>
</table>