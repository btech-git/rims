<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][masterAccounting]", CHtml::resolveValue($model, "roles[masterAccounting]"), array('id' => 'User_roles_' . $counter, 'value' => 'masterAccounting')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Bank</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterBankCreate]", CHtml::resolveValue($model, "roles[masterBankCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBankCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterBankEdit]", CHtml::resolveValue($model, "roles[masterBankEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBankEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterBankApproval]", CHtml::resolveValue($model, "roles[masterBankApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBankApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>COA</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterCoaCreate]", CHtml::resolveValue($model, "roles[masterCoaCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterCoaEdit]", CHtml::resolveValue($model, "roles[masterCoaEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterCoaApproval]", CHtml::resolveValue($model, "roles[masterCoaApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>COA Category</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterCoaCategoryCreate]", CHtml::resolveValue($model, "roles[masterCoaCategoryCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaCategoryCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterCoaCategoryEdit]", CHtml::resolveValue($model, "roles[masterCoaCategoryEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaCategoryEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterCoaCategoryApproval]", CHtml::resolveValue($model, "roles[masterCoaCategoryApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaCategoryApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>COA Sub Category</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterCoaSubCategoryCreate]", CHtml::resolveValue($model, "roles[masterCoaSubCategoryCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaSubCategoryCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterCoaSubCategoryEdit]", CHtml::resolveValue($model, "roles[masterCoaSubCategoryEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaSubCategoryEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterCoaSubCategoryApproval]", CHtml::resolveValue($model, "roles[masterCoaSubCategoryApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaSubCategoryApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Payment Type</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPaymentTypeCreate]", CHtml::resolveValue($model, "roles[masterPaymentTypeCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPaymentTypeCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPaymentTypeEdit]", CHtml::resolveValue($model, "roles[masterPaymentTypeEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPaymentTypeEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPaymentTypeApproval]", CHtml::resolveValue($model, "roles[masterPaymentTypeApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPaymentTypeApproval')); ?>
            </td>
        </tr>
    </tbody>
</table>