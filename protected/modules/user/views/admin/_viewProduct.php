<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][productHead]", CHtml::resolveValue($model, "roles[productHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'productHead')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Product</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterProductCreate]", CHtml::resolveValue($model, "roles[masterProductCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterProductEdit]", CHtml::resolveValue($model, "roles[masterProductEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterProductApproval]", CHtml::resolveValue($model, "roles[masterProductApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Product Category</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterProductCategoryCreate]", CHtml::resolveValue($model, "roles[masterProductCategoryCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductCategoryCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterProductCategoryEdit]", CHtml::resolveValue($model, "roles[masterProductCategoryEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductCategoryEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterProductCategoryApproval]", CHtml::resolveValue($model, "roles[masterProductCategoryApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductCategoryApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Product Sub Master Category</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterProductSubMasterCategoryCreate]", CHtml::resolveValue($model, "roles[masterProductSubMasterCategoryCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductSubMasterCategoryCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterProductSubMasterCategoryEdit]", CHtml::resolveValue($model, "roles[masterProductSubMasterCategoryEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductSubMasterCategoryEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterProductSubMasterCategoryApproval]", CHtml::resolveValue($model, "roles[masterProductSubMasterCategoryApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductSubMasterCategoryApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Product Sub Category</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterProductSubCategoryCreate]", CHtml::resolveValue($model, "roles[masterProductSubCategoryCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductSubCategoryCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterProductSubCategoryEdit]", CHtml::resolveValue($model, "roles[masterProductSubCategoryEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductSubCategoryEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterProductSubCategoryApproval]", CHtml::resolveValue($model, "roles[masterProductSubCategoryApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductSubCategoryApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Brand</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterBrandCreate]", CHtml::resolveValue($model, "roles[masterBrandCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBrandCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterBrandEdit]", CHtml::resolveValue($model, "roles[masterBrandEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBrandEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterBrandApproval]", CHtml::resolveValue($model, "roles[masterBrandApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBrandApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Sub Brand</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterSubBrandCreate]", CHtml::resolveValue($model, "roles[masterSubBrandCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSubBrandCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterSubBrandEdit]", CHtml::resolveValue($model, "roles[masterSubBrandEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSubBrandEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterSubBrandApproval]", CHtml::resolveValue($model, "roles[masterSubBrandApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSubBrandApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Sub Brand Series</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterSubBrandSeriesCreate]", CHtml::resolveValue($model, "roles[masterSubBrandSeriesCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSubBrandSeriesCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterSubBrandSeriesEdit]", CHtml::resolveValue($model, "roles[masterSubBrandSeriesEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSubBrandSeriesEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterSubBrandSeriesApproval]", CHtml::resolveValue($model, "roles[masterSubBrandSeriesApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSubBrandSeriesApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Equipment</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterEquipmentCreate]", CHtml::resolveValue($model, "roles[masterEquipmentCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterEquipmentEdit]", CHtml::resolveValue($model, "roles[masterEquipmentEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterEquipmentApproval]", CHtml::resolveValue($model, "roles[masterEquipmentApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Equipment Type</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterEquipmentTypeCreate]", CHtml::resolveValue($model, "roles[masterEquipmentTypeCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentTypeCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterEquipmentTypeEdit]", CHtml::resolveValue($model, "roles[masterEquipmentTypeEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentTypeEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterEquipmentTypeApproval]", CHtml::resolveValue($model, "roles[masterEquipmentTypeApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentTypeApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Equipment Sub Type</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterEquipmentSubTypeCreate]", CHtml::resolveValue($model, "roles[masterEquipmentSubTypeCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentSubTypeCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterEquipmentSubTypeEdit]", CHtml::resolveValue($model, "roles[masterEquipmentSubTypeEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentSubTypeEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterEquipmentSubTypeApproval]", CHtml::resolveValue($model, "roles[masterEquipmentSubTypeApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentSubTypeApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Permintaan Maintenance</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][maintenanceRequestCreate]", CHtml::resolveValue($model, "roles[maintenanceRequestCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'maintenanceRequestCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][maintenanceRequestEdit]", CHtml::resolveValue($model, "roles[maintenanceRequestEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'maintenanceRequestEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][maintenanceRequestApproval]", CHtml::resolveValue($model, "roles[maintenanceRequestApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'maintenanceRequestApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Warehouse</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterWarehouseCreate]", CHtml::resolveValue($model, "roles[masterWarehouseCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterWarehouseCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterWarehouseEdit]", CHtml::resolveValue($model, "roles[masterWarehouseEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterWarehouseEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterWarehouseApproval]", CHtml::resolveValue($model, "roles[masterWarehouseApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterWarehouseApproval')); ?>
            </td>
        </tr>
    </tbody>
</table>