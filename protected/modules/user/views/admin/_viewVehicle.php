<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterVehicleInventory]", CHtml::resolveValue($model, "roles[masterVehicleInventory]"), array('id' => 'User_roles_' . $counter, 'value' => 'masterVehicleInventory')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Vehicle</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterVehicleCreate]", CHtml::resolveValue($model, "roles[masterVehicleCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterVehicleCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterVehicleEdit]", CHtml::resolveValue($model, "roles[masterVehicleEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterVehicleEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterVehicleApproval]", CHtml::resolveValue($model, "roles[masterVehicleApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterVehicleApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Customer</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCustomerCreate]", CHtml::resolveValue($model, "roles[masterCustomerCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCustomerCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCustomerEdit]", CHtml::resolveValue($model, "roles[masterCustomerEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCustomerEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCustomerApproval]", CHtml::resolveValue($model, "roles[masterCustomerApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCustomerApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Insurance Company</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterInsuranceCreate]", CHtml::resolveValue($model, "roles[masterCustomerCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCustomerCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterInsuranceEdit]", CHtml::resolveValue($model, "roles[masterCustomerEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCustomerEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterInsuranceApproval]", CHtml::resolveValue($model, "roles[masterCustomerApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCustomerApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Car Make</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCarMakeCreate]", CHtml::resolveValue($model, "roles[masterCarMakeCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarMakeCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCarMakeEdit]", CHtml::resolveValue($model, "roles[masterCarMakeEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarMakeEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCarMakeApproval]", CHtml::resolveValue($model, "roles[masterCarMakeApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarMakeApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Car Model</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCarModelCreate]", CHtml::resolveValue($model, "roles[masterCarModelCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarModelCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCarModelEdit]", CHtml::resolveValue($model, "roles[masterCarModelEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarModelEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCarModelApproval]", CHtml::resolveValue($model, "roles[masterCarModelApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarModelApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Car Sub Model</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCarSubModelCreate]", CHtml::resolveValue($model, "roles[masterCarSubModelCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarSubModelCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCarSubModelEdit]", CHtml::resolveValue($model, "roles[masterCarSubModelEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarSubModelEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCarSubModelApproval]", CHtml::resolveValue($model, "roles[masterCarSubModelApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarSubModelApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Car Sub Model Detail</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCarSubModelDetailCreate]", CHtml::resolveValue($model, "roles[masterCarSubModelDetailCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarSubModelDetailCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCarSubModelDetailEdit]", CHtml::resolveValue($model, "roles[masterCarSubModelDetailEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarSubModelDetailEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterCarSubModelDetailApproval]", CHtml::resolveValue($model, "roles[masterCarSubModelDetailApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarSubModelDetailApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Color</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterColorCreate]", CHtml::resolveValue($model, "roles[masterColorCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterColorCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterColorEdit]", CHtml::resolveValue($model, "roles[masterColorEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterColorEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterColorApproval]", CHtml::resolveValue($model, "roles[masterColorApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterColorApproval')); ?>
            </td>
        </tr>
    </tbody>
</table>