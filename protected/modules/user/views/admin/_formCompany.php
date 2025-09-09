<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCompany]", CHtml::resolveValue($model, "roles[masterCompany]"), array('id' => 'User_roles_' . $counter, 'value' => 'masterCompany')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">View</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>User</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterUserCreate]", CHtml::resolveValue($model, "roles[masterUserCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUserCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterUserEdit]", CHtml::resolveValue($model, "roles[masterUserEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUserEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterUserView]", CHtml::resolveValue($model, "roles[masterUserView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUserView')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterUserApproval]", CHtml::resolveValue($model, "roles[masterUserApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUserApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Company</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterCompanyCreate]", CHtml::resolveValue($model, "roles[masterCompanyCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCompanyCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterCompanyEdit]", CHtml::resolveValue($model, "roles[masterCompanyEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCompanyEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterCompanyView]", CHtml::resolveValue($model, "roles[masterCompanyView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCompanyView')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterCompanyApproval]", CHtml::resolveValue($model, "roles[masterCompanyApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCompanyApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Branch</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterBranchCreate]", CHtml::resolveValue($model, "roles[masterBranchCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBranchCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterBranchEdit]", CHtml::resolveValue($model, "roles[masterBranchEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBranchEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterBranchView]", CHtml::resolveValue($model, "roles[masterBranchView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBranchView')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterBranchApproval]", CHtml::resolveValue($model, "roles[masterBranchApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBranchApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Supplier</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterSupplierCreate]", CHtml::resolveValue($model, "roles[masterSupplierCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSupplierCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterSupplierEdit]", CHtml::resolveValue($model, "roles[masterSupplierEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSupplierEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterSupplierView]", CHtml::resolveValue($model, "roles[masterSupplierView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSupplierView')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterSupplierApproval]", CHtml::resolveValue($model, "roles[masterSupplierApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSupplierApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Deduction</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterDeductionCreate]", CHtml::resolveValue($model, "roles[masterDeductionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDeductionCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterDeductionEdit]", CHtml::resolveValue($model, "roles[masterDeductionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDeductionEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterDeductionView]", CHtml::resolveValue($model, "roles[masterDeductionView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDeductionView')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterDeductionApproval]", CHtml::resolveValue($model, "roles[masterDeductionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDeductionApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Incentive</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterIncentiveCreate]", CHtml::resolveValue($model, "roles[masterIncentiveCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterIncentiveCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterIncentiveEdit]", CHtml::resolveValue($model, "roles[masterIncentiveEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterIncentiveEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterIncentiveView]", CHtml::resolveValue($model, "roles[masterIncentiveView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterIncentiveView')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterIncentiveApproval]", CHtml::resolveValue($model, "roles[masterIncentiveApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterIncentiveApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Position</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPositionCreate]", CHtml::resolveValue($model, "roles[masterPositionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPositionCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPositionEdit]", CHtml::resolveValue($model, "roles[masterPositionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPositionEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPositionView]", CHtml::resolveValue($model, "roles[masterPositionView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPositionView')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPositionApproval]", CHtml::resolveValue($model, "roles[masterPositionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPositionApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Division</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterDivisionCreate]", CHtml::resolveValue($model, "roles[masterDivisionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDivisionCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterDivisionEdit]", CHtml::resolveValue($model, "roles[masterDivisionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDivisionEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterDivisionView]", CHtml::resolveValue($model, "roles[masterDivisionView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDivisionView')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterDivisionApproval]", CHtml::resolveValue($model, "roles[masterDivisionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDivisionApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Level</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterLevelCreate]", CHtml::resolveValue($model, "roles[masterLevelCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterLevelCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterLevelEdit]", CHtml::resolveValue($model, "roles[masterLevelEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterLevelEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterLevelView]", CHtml::resolveValue($model, "roles[masterLevelView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterLevelView')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterLevelApproval]", CHtml::resolveValue($model, "roles[masterLevelApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterLevelApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Unit</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterUnitCreate]", CHtml::resolveValue($model, "roles[masterUnitCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUnitCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterUnitEdit]", CHtml::resolveValue($model, "roles[masterUnitEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUnitEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterUnitView]", CHtml::resolveValue($model, "roles[masterUnitView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUnitView')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterUnitApproval]", CHtml::resolveValue($model, "roles[masterUnitApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUnitApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Unit Conversion</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterConversionCreate]", CHtml::resolveValue($model, "roles[masterConversionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterConversionCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterConversionEdit]", CHtml::resolveValue($model, "roles[masterConversionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterConversionEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterConversionView]", CHtml::resolveValue($model, "roles[masterConversionView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterConversionView')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterConversionApproval]", CHtml::resolveValue($model, "roles[masterConversionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterConversionApproval')); ?>
            </td>
        </tr>
    </tbody>
</table>