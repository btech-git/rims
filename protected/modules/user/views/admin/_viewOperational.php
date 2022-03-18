<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][operationHead]", CHtml::resolveValue($model, "roles[operationHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'operationHead')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Permintaan Transfer</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][transferRequestCreate]", CHtml::resolveValue($model, "roles[transferRequestCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'transferRequestCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][transferRequestEdit]", CHtml::resolveValue($model, "roles[transferRequestEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'transferRequestEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][transferRequestApproval]", CHtml::resolveValue($model, "roles[transferRequestApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'transferRequestApproval')); ?></td>
        </tr>
        <tr>
            <td>Permintaan Kirim</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][sentRequestCreate]", CHtml::resolveValue($model, "roles[sentRequestCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'sentRequestCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][sentRequestEdit]", CHtml::resolveValue($model, "roles[sentRequestEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'sentRequestEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][sentRequestApproval]", CHtml::resolveValue($model, "roles[sentRequestApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'sentRequestApproval')); ?></td>
        </tr>
        <tr>
            <td>Retur Beli</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][purchaseReturnCreate]", CHtml::resolveValue($model, "roles[purchaseReturnCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseReturnCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][purchaseReturnEdit]", CHtml::resolveValue($model, "roles[purchaseReturnEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseReturnEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][purchaseReturnApproval]", CHtml::resolveValue($model, "roles[purchaseReturnApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseReturnApproval')); ?></td>
        </tr>
        <tr>
            <td>Retur Jual</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleReturnCreate]", CHtml::resolveValue($model, "roles[saleReturnCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleReturnCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleReturnEdit]", CHtml::resolveValue($model, "roles[saleReturnEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleReturnEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleReturnApproval]", CHtml::resolveValue($model, "roles[saleReturnApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleReturnApproval')); ?></td>
        </tr>
        <tr>
            <td>Pengiriman Barang</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][deliveryCreate]", CHtml::resolveValue($model, "roles[deliveryCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'deliveryCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][deliveryEdit]", CHtml::resolveValue($model, "roles[deliveryEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'deliveryEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][deliveryApproval]", CHtml::resolveValue($model, "roles[deliveryApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'deliveryApproval')); ?></td>
        </tr>
        <tr>
            <td>Penerimaan Barang</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][receiveItemCreate]", CHtml::resolveValue($model, "roles[receiveItemCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'receiveItemCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][receiveItemEdit]", CHtml::resolveValue($model, "roles[receiveItemEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'receiveItemEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][receiveItemApproval]", CHtml::resolveValue($model, "roles[receiveItemApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'receiveItemApproval')); ?></td>
        </tr>
        <tr>
            <td>Penerimaan Konsinyasi</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentInCreate]", CHtml::resolveValue($model, "roles[consignmentInCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentInCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentInEdit]", CHtml::resolveValue($model, "roles[consignmentInEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentInEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentInApproval]", CHtml::resolveValue($model, "roles[consignmentInApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentInApproval')); ?></td>
        </tr>
        <tr>
            <td>Pengeluaran Konsinyasi</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentOutCreate]", CHtml::resolveValue($model, "roles[consignmentOutCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentOutCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentOutEdit]", CHtml::resolveValue($model, "roles[consignmentOutEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentOutEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentOutApproval]", CHtml::resolveValue($model, "roles[consignmentOutApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentOutApproval')); ?></td>
        </tr>
    </tbody>
</table>