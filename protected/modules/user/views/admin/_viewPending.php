<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php if (CHtml::resolveValue($model, "roles[pendingHead]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
                <?php echo CHtml::label('PENDING TRANSACTION', 'User_roles_', array('style' => 'display: inline')); ?>

            </th>
            <th style="text-align: center">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Daftar Transaksi Pending</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[pendingTransactionView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Order Outstanding</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[orderOutstandingView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Approval Permintaan</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[requestApprovalView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Approval Data Master</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterApprovalView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Pending Jurnal</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[pendingJournalView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>