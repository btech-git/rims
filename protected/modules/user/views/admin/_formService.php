<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterServiceList]", CHtml::resolveValue($model, "roles[masterServiceList]"), array(
                    'id' => 'User_roles_' . $counter, 'value' => 'masterServiceList')); ?>
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
            <td>Service</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceCreate]", CHtml::resolveValue($model, "roles[masterServiceCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterServiceCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceEdit]", CHtml::resolveValue($model, "roles[masterServiceEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterServiceEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceView]", CHtml::resolveValue($model, "roles[masterServiceView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterServiceView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceApproval]", CHtml::resolveValue($model, "roles[masterServiceApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterServiceApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Service Category</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceCategoryCreate]", CHtml::resolveValue($model, "roles[masterServiceCategoryCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterServiceCategoryCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceCategoryEdit]", CHtml::resolveValue($model, "roles[masterServiceCategoryEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterServiceCategoryEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceCategoryView]", CHtml::resolveValue($model, "roles[masterServiceCategoryView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterServiceCategoryView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceCategoryApproval]", CHtml::resolveValue($model, "roles[masterServiceCategoryApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterServiceCategoryApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Service Type</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceTypeCreate]", CHtml::resolveValue($model, "roles[masterServiceTypeCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterServiceTypeCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceTypeEdit]", CHtml::resolveValue($model, "roles[masterServiceTypeEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterServiceTypeEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceTypeView]", CHtml::resolveValue($model, "roles[masterServiceTypeView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterServiceTypeView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterServiceTypeApproval]", CHtml::resolveValue($model, "roles[masterServiceTypeApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterServiceTypeApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Quick Service</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterQuickServiceCreate]", CHtml::resolveValue($model, "roles[masterQuickServiceCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterQuickServiceCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterQuickServiceEdit]", CHtml::resolveValue($model, "roles[masterQuickServiceEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterQuickServiceEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterQuickServiceView]", CHtml::resolveValue($model, "roles[masterQuickServiceView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterQuickServiceView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterQuickServiceApproval]", CHtml::resolveValue($model, "roles[masterQuickServiceApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterQuickServiceApproval'
                )); ?>
            </td>
        </tr>
    </tbody>
</table>