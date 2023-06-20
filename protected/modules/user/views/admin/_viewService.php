<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][masterServiceList]", CHtml::resolveValue($model, "roles[masterServiceList]"), array('id' => 'User_roles_' . $counter, 'value' => 'masterServiceList')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Service</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceCreate]", CHtml::resolveValue($model, "roles[masterServiceCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceEdit]", CHtml::resolveValue($model, "roles[masterServiceEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceApproval]", CHtml::resolveValue($model, "roles[masterServiceApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Service Category</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceCategoryCreate]", CHtml::resolveValue($model, "roles[masterServiceCategoryCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceCategoryCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceCategoryEdit]", CHtml::resolveValue($model, "roles[masterServiceCategoryEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceCategoryEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceCategoryApproval]", CHtml::resolveValue($model, "roles[masterServiceCategoryApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceCategoryApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Service Type</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceTypeCreate]", CHtml::resolveValue($model, "roles[masterServiceTypeCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceTypeCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceTypeEdit]", CHtml::resolveValue($model, "roles[masterServiceTypeEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceTypeEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceTypeApproval]", CHtml::resolveValue($model, "roles[masterServiceTypeApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceTypeApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Price List Standard</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistStandardCreate]", CHtml::resolveValue($model, "roles[masterPricelistStandardCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistStandardCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistStandardEdit]", CHtml::resolveValue($model, "roles[masterPricelistStandardEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistStandardEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistStandardApproval]", CHtml::resolveValue($model, "roles[masterPricelistStandardApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistStandardApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Price List Group</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistGroupCreate]", CHtml::resolveValue($model, "roles[masterPricelistGroupCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistGroupCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistGroupEdit]", CHtml::resolveValue($model, "roles[masterPricelistGroupEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistGroupEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistGroupApproval]", CHtml::resolveValue($model, "roles[masterPricelistGroupApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistGroupApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Price List Set</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistSetCreate]", CHtml::resolveValue($model, "roles[masterPricelistSetCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistSetCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistSetEdit]", CHtml::resolveValue($model, "roles[masterPricelistSetEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistSetEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistSetApproval]", CHtml::resolveValue($model, "roles[masterPricelistSetApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistSetApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Standard Flat Rate</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterStandardFlatrateCreate]", CHtml::resolveValue($model, "roles[masterStandardFlatrateCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterStandardFlatrateCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterStandardFlatrateEdit]", CHtml::resolveValue($model, "roles[masterStandardFlatrateEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterStandardFlatrateEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterStandardFlatrateApproval]", CHtml::resolveValue($model, "roles[masterStandardFlatrateApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterStandardFlatrateApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Standard Value</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterStandardValueCreate]", CHtml::resolveValue($model, "roles[masterStandardValueCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterStandardValueCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterStandardValueEdit]", CHtml::resolveValue($model, "roles[masterStandardValueEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterStandardValueEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterStandardValueApproval]", CHtml::resolveValue($model, "roles[masterStandardValueApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterStandardValueApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Quick Service</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterQuickServiceCreate]", CHtml::resolveValue($model, "roles[masterQuickServiceCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterQuickServiceCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterQuickServiceEdit]", CHtml::resolveValue($model, "roles[masterQuickServiceEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterQuickServiceEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterQuickServiceApproval]", CHtml::resolveValue($model, "roles[masterQuickServiceApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterQuickServiceApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Inspection</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionCreate]", CHtml::resolveValue($model, "roles[masterInspectionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionEdit]", CHtml::resolveValue($model, "roles[masterInspectionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionApproval]", CHtml::resolveValue($model, "roles[masterInspectionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Inspection Section</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionSectionCreate]", CHtml::resolveValue($model, "roles[masterInspectionSectionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionSectionCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionSectionEdit]", CHtml::resolveValue($model, "roles[masterInspectionSectionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionSectionEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionSectionApproval]", CHtml::resolveValue($model, "roles[masterInspectionSectionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionSectionApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Inspection Module</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionModuleCreate]", CHtml::resolveValue($model, "roles[masterInspectionModuleCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionModuleCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionModuleEdit]", CHtml::resolveValue($model, "roles[masterInspectionModuleEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionModuleEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionModuleApproval]", CHtml::resolveValue($model, "roles[masterInspectionModuleApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionModuleApproval')); ?>
            </td>
        </tr>
    </tbody>
</table>