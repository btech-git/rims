<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][idleManagement]", CHtml::resolveValue($model, "roles[idleManagement]"), array(
                    'id' => 'User_roles_' . $counter, 
                    'value' => 'idleManagement'
                )); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>GR Mechanic POV</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][grMechanicCreate]", CHtml::resolveValue($model, "roles[grMechanicCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'grMechanicCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][grMechanicEdit]", CHtml::resolveValue($model, "roles[grMechanicEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'grMechanicEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][grMechanicView]", CHtml::resolveValue($model, "roles[grMechanicView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'grMechanicView'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>GR Head POV</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][grHeadCreate]", CHtml::resolveValue($model, "roles[grHeadCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'grHeadCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][grHeadEdit]", CHtml::resolveValue($model, "roles[grHeadEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'grHeadEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][grHeadView]", CHtml::resolveValue($model, "roles[grHeadView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'grHeadView'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>BR Mechanic POV</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][brMechanicCreate]", CHtml::resolveValue($model, "roles[brMechanicCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'brMechanicCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][brMechanicEdit]", CHtml::resolveValue($model, "roles[brMechanicEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'brMechanicEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][brMechanicView]", CHtml::resolveValue($model, "roles[brMechanicView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'brMechanicView'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>BR Head POV</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][brHeadCreate]", CHtml::resolveValue($model, "roles[brHeadCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'brHeadCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][brHeadEdit]", CHtml::resolveValue($model, "roles[brHeadEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'brHeadEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][brHeadView]", CHtml::resolveValue($model, "roles[brHeadView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'brHeadView'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Kendaraan Dalam Bengkel</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][vehicleInServiceView]", CHtml::resolveValue($model, "roles[vehicleInServiceView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'vehicleInServiceView'
                )); ?>
            </td>
        </tr>
    </tbody>
</table>