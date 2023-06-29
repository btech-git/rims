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
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>User</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterUserCreate]", CHtml::resolveValue($model, "roles[masterUserCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUserCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterUserEdit]", CHtml::resolveValue($model, "roles[masterUserEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUserEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterUserApproval]", CHtml::resolveValue($model, "roles[masterUserApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUserApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Company</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCompanyCreate]", CHtml::resolveValue($model, "roles[masterCompanyCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCompanyCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCompanyEdit]", CHtml::resolveValue($model, "roles[masterCompanyEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCompanyEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCompanyApproval]", CHtml::resolveValue($model, "roles[masterCompanyApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCompanyApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Insurance Company</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterInsuranceCreate]", CHtml::resolveValue($model, "roles[masterInsuranceCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInsuranceCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterInsuranceEdit]", CHtml::resolveValue($model, "roles[masterInsuranceEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInsuranceEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterInsuranceApproval]", CHtml::resolveValue($model, "roles[masterInsuranceApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInsuranceApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Branch</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterBranchCreate]", CHtml::resolveValue($model, "roles[masterBranchCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBranchCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterBranchEdit]", CHtml::resolveValue($model, "roles[masterBranchEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBranchEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterBranchApproval]", CHtml::resolveValue($model, "roles[masterBranchApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBranchApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Supplier</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterSupplierCreate]", CHtml::resolveValue($model, "roles[masterSupplierCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSupplierCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterSupplierEdit]", CHtml::resolveValue($model, "roles[masterSupplierEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSupplierEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterSupplierApproval]", CHtml::resolveValue($model, "roles[masterSupplierApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSupplierApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Employee</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterEmployeeCreate]", CHtml::resolveValue($model, "roles[masterEmployeeCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEmployeeCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterEmployeeEdit]", CHtml::resolveValue($model, "roles[masterEmployeeEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEmployeeEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterEmployeeApproval]", CHtml::resolveValue($model, "roles[masterEmployeeApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEmployeeApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Deduction</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterDeductionCreate]", CHtml::resolveValue($model, "roles[masterDeductionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDeductionCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterDeductionEdit]", CHtml::resolveValue($model, "roles[masterDeductionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDeductionEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterDeductionApproval]", CHtml::resolveValue($model, "roles[masterDeductionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDeductionApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Incentive</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterIncentiveCreate]", CHtml::resolveValue($model, "roles[masterIncentiveCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterIncentiveCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterIncentiveEdit]", CHtml::resolveValue($model, "roles[masterIncentiveEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterIncentiveEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterIncentiveApproval]", CHtml::resolveValue($model, "roles[masterIncentiveApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterIncentiveApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Position</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterPositionCreate]", CHtml::resolveValue($model, "roles[masterPositionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPositionCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterPositionEdit]", CHtml::resolveValue($model, "roles[masterPositionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPositionEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterPositionApproval]", CHtml::resolveValue($model, "roles[masterPositionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPositionApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Division</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterDivisionCreate]", CHtml::resolveValue($model, "roles[masterDivisionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDivisionCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterDivisionEdit]", CHtml::resolveValue($model, "roles[masterDivisionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDivisionEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterDivisionApproval]", CHtml::resolveValue($model, "roles[masterDivisionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDivisionApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Level</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterLevelCreate]", CHtml::resolveValue($model, "roles[masterLevelCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterLevelCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterLevelEdit]", CHtml::resolveValue($model, "roles[masterLevelEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterLevelEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterLevelApproval]", CHtml::resolveValue($model, "roles[masterLevelApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterLevelApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Unit</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterUnitCreate]", CHtml::resolveValue($model, "roles[masterUnitCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUnitCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterUnitEdit]", CHtml::resolveValue($model, "roles[masterUnitEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUnitEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterUnitApproval]", CHtml::resolveValue($model, "roles[masterUnitApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUnitApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Unit Conversion</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterConversionCreate]", CHtml::resolveValue($model, "roles[masterConversionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterConversionCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterConversionEdit]", CHtml::resolveValue($model, "roles[masterConversionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterConversionEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterConversionApproval]", CHtml::resolveValue($model, "roles[masterConversionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterConversionApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Public Holiday</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterHolidayCreate]", CHtml::resolveValue($model, "roles[masterHolidayCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterHolidayCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterHolidayEdit]", CHtml::resolveValue($model, "roles[masterHolidayEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterHolidayEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterHolidayApproval]", CHtml::resolveValue($model, "roles[masterHolidayApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterHolidayApproval')); ?>
            </td>
        </tr>
    </tbody>
</table>