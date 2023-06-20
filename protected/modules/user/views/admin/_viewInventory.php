<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][inventoryHead]", CHtml::resolveValue($model, "roles[inventoryHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'inventoryHead')); ?>
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
            <td>Barang Masuk Gudang</td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][movementInCreate]", CHtml::resolveValue($model, "roles[movementInCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementInCreate')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][movementInEdit]", CHtml::resolveValue($model, "roles[movementInEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementInEdit')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][movementInApproval]", CHtml::resolveValue($model, "roles[movementInApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementInApproval')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][movementInSupervisor]", CHtml::resolveValue($model, "roles[movementInSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementInSupervisor')); ?></td>
        </tr>
        <tr>
            <td>Barang Keluar Gudang</td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][movementOutCreate]", CHtml::resolveValue($model, "roles[movementOutCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementOutCreate')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][movementOutEdit]", CHtml::resolveValue($model, "roles[movementOutEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementOutEdit')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][movementOutApproval]", CHtml::resolveValue($model, "roles[movementOutApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementOutApproval')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][movementOutSupervisor]", CHtml::resolveValue($model, "roles[movementOutSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementOutSupervisor')); ?></td>
        </tr>
        <tr>
            <td>Pengeluaran Bahan Pemakaian</td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][movementServiceCreate]", CHtml::resolveValue($model, "roles[movementServiceCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementServiceCreate')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][movementServiceEdit]", CHtml::resolveValue($model, "roles[movementServiceEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementServiceEdit')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][movementServiceApproval]", CHtml::resolveValue($model, "roles[movementServiceApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementServiceApproval')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][movementServiceSupervisor]", CHtml::resolveValue($model, "roles[movementServiceSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementServiceSupervisor')); ?></td>
        </tr>
        <tr>
            <td>Penyesuaian Stok</td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][stockAdjustmentCreate]", CHtml::resolveValue($model, "roles[stockAdjustmentCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockAdjustmentCreate')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][stockAdjustmentEdit]", CHtml::resolveValue($model, "roles[stockAdjustmentEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockAdjustmentEdit')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][stockAdjustmentApproval]", CHtml::resolveValue($model, "roles[stockAdjustmentApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockAdjustmentApproval')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][stockAdjustmentSupervisor]", CHtml::resolveValue($model, "roles[stockAdjustmentSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockAdjustmentSupervisor')); ?></td>
        </tr>
        <tr>
            <td>Permintaan Bahan</td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][materialRequestCreate]", CHtml::resolveValue($model, "roles[materialRequestCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'materialRequestCreate')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][materialRequestEdit]", CHtml::resolveValue($model, "roles[materialRequestEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'materialRequestEdit')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][materialRequestApproval]", CHtml::resolveValue($model, "roles[materialRequestApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'materialRequestApproval')); ?></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][materialRequestSupervisor]", CHtml::resolveValue($model, "roles[materialRequestSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'materialRequestSupervisor')); ?></td>
        </tr>
        <tr>
            <td>Stok Gudang</td>
            <td></td>
            <td></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][warehouseStockReport]", CHtml::resolveValue($model, "roles[warehouseStockReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'warehouseStockReport')); ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Analisa Stok Barang</td>
            <td></td>
            <td></td>
            <td style="text-align: center">
                <?php echo $counter; ?><?php echo CHtml::checkBox("User[roles][stockAnalysisReport]", CHtml::resolveValue($model, "roles[stockAnalysisReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockAnalysisReport')); ?></td>
            <td></td>
        </tr>
    </tbody>
</table>