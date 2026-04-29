<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">&nbsp;</th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">View</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center; background-color: greenyellow">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterEquipmentHead]", CHtml::resolveValue($model, "roles[masterEquipmentHead]"), array(
                    'id' => 'User_roles_' . $counter, 
                    'value' => 'masterEquipmentHead'
                )); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td colspan="5" style="text-align: center; font-weight: bold; background-color: greenyellow">Equipment</td>
        </tr>
        <tr>
            <td>Equipment</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEquipmentCreate]", CHtml::resolveValue($model, "roles[masterEquipmentCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEquipmentCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEquipmentEdit]", CHtml::resolveValue($model, "roles[masterEquipmentEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEquipmentEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEquipmentView]", CHtml::resolveValue($model, "roles[masterEquipmentView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEquipmentView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEquipmentApproval]", CHtml::resolveValue($model, "roles[masterEquipmentApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEquipmentApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Equipment Type</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEquipmentTypeCreate]", CHtml::resolveValue($model, "roles[masterEquipmentTypeCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEquipmentTypeCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEquipmentTypeEdit]", CHtml::resolveValue($model, "roles[masterEquipmentTypeEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEquipmentTypeEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEquipmentTypeView]", CHtml::resolveValue($model, "roles[masterEquipmentTypeView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEquipmentTypeView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEquipmentTypeApproval]", CHtml::resolveValue($model, "roles[masterEquipmentTypeApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEquipmentTypeApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Equipment Sub Type</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEquipmentSubTypeCreate]", CHtml::resolveValue($model, "roles[masterEquipmentSubTypeCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEquipmentSubTypeCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEquipmentSubTypeEdit]", CHtml::resolveValue($model, "roles[masterEquipmentSubTypeEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEquipmentSubTypeEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEquipmentSubTypeView]", CHtml::resolveValue($model, "roles[masterEquipmentSubTypeView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEquipmentSubTypeView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEquipmentSubTypeApproval]", CHtml::resolveValue($model, "roles[masterEquipmentSubTypeApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEquipmentSubTypeApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Permintaan Maintenance</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][maintenanceRequestCreate]", CHtml::resolveValue($model, "roles[maintenanceRequestCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'maintenanceRequestCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][maintenanceRequestEdit]", CHtml::resolveValue($model, "roles[maintenanceRequestEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'maintenanceRequestEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][maintenanceRequestView]", CHtml::resolveValue($model, "roles[maintenanceRequestView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'maintenanceRequestView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][maintenanceRequestApproval]", CHtml::resolveValue($model, "roles[maintenanceRequestApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'maintenanceRequestApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; background-color: greenyellow">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterPriceListHead]", CHtml::resolveValue($model, "roles[masterPriceListHead]"), array(
                    'id' => 'User_roles_' . $counter, 
                    'value' => 'masterPriceListHead'
                )); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td colspan="5" style="text-align: center; font-weight: bold; background-color: greenyellow">Price List</td>
        </tr>
        <tr>
            <td>Price List Standard</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistStandardCreate]", CHtml::resolveValue($model, "roles[masterPricelistStandardCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterPricelistStandardCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistStandardEdit]", CHtml::resolveValue($model, "roles[masterPricelistStandardEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterPricelistStandardEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistStandardView]", CHtml::resolveValue($model, "roles[masterPricelistStandardView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterPricelistStandardView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistStandardApproval]", CHtml::resolveValue($model, "roles[masterPricelistStandardApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterPricelistStandardApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Price List Group</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistGroupCreate]", CHtml::resolveValue($model, "roles[masterPricelistGroupCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterPricelistGroupCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistGroupEdit]", CHtml::resolveValue($model, "roles[masterPricelistGroupEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterPricelistGroupEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistGroupView]", CHtml::resolveValue($model, "roles[masterPricelistGroupView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterPricelistGroupView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistGroupApproval]", CHtml::resolveValue($model, "roles[masterPricelistGroupApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterPricelistGroupApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Price List Set</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistSetCreate]", CHtml::resolveValue($model, "roles[masterPricelistSetCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterPricelistSetCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistSetEdit]", CHtml::resolveValue($model, "roles[masterPricelistSetEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterPricelistSetEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistSetView]", CHtml::resolveValue($model, "roles[masterPricelistSetView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterPricelistSetView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterPricelistSetApproval]", CHtml::resolveValue($model, "roles[masterPricelistSetApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterPricelistSetApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Standard Flat Rate</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterStandardFlatrateCreate]", CHtml::resolveValue($model, "roles[masterStandardFlatrateCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterStandardFlatrateCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterStandardFlatrateEdit]", CHtml::resolveValue($model, "roles[masterStandardFlatrateEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterStandardFlatrateEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterStandardFlatrateView]", CHtml::resolveValue($model, "roles[masterStandardFlatrateView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterStandardFlatrateView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterStandardFlatrateApproval]", CHtml::resolveValue($model, "roles[masterStandardFlatrateApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterStandardFlatrateApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Standard Value</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterStandardValueCreate]", CHtml::resolveValue($model, "roles[masterStandardValueCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterStandardValueCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterStandardValueEdit]", CHtml::resolveValue($model, "roles[masterStandardValueEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterStandardValueEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterStandardValueView]", CHtml::resolveValue($model, "roles[masterStandardValueView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterStandardValueView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterStandardValueApproval]", CHtml::resolveValue($model, "roles[masterStandardValueApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterStandardValueApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; background-color: greenyellow">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterWarehouseHead]", CHtml::resolveValue($model, "roles[masterWarehouseHead]"), array(
                    'id' => 'User_roles_' . $counter, 
                    'value' => 'masterWarehouseHead'
                )); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td colspan="5" style="text-align: center; font-weight: bold; background-color: greenyellow">Warehouse</td>
        </tr>
        <tr>
            <td>Warehouse</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterWarehouseCreate]", CHtml::resolveValue($model, "roles[masterWarehouseCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterWarehouseCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterWarehouseEdit]", CHtml::resolveValue($model, "roles[masterWarehouseEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterWarehouseEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterWarehouseView]", CHtml::resolveValue($model, "roles[masterWarehouseView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterWarehouseView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterWarehouseApproval]", CHtml::resolveValue($model, "roles[masterWarehouseApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterWarehouseApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Kategori Aset</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterAssetCategoryCreate]", CHtml::resolveValue($model, "roles[masterAssetCategoryCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterAssetCategoryCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterAssetCategoryEdit]", CHtml::resolveValue($model, "roles[masterAssetCategoryEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterAssetCategoryEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterAssetCategoryView]", CHtml::resolveValue($model, "roles[masterAssetCategoryView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterAssetCategoryView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterAssetCategoryApproval]", CHtml::resolveValue($model, "roles[masterAssetCategoryApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterAssetCategoryApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; background-color: greenyellow">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterSystemCheckHead]", CHtml::resolveValue($model, "roles[masterSystemCheckHead]"), array(
                    'id' => 'User_roles_' . $counter, 
                    'value' => 'masterSystemCheckHead'
                )); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td colspan="5" style="text-align: center; font-weight: bold; background-color: greenyellow">Systems Check & Reports</td>
        </tr>
        <tr>
            <td>Inspection Reports Form</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionCreate]", CHtml::resolveValue($model, "roles[masterInspectionCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterInspectionCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionEdit]", CHtml::resolveValue($model, "roles[masterInspectionEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterInspectionEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionView]", CHtml::resolveValue($model, "roles[masterInspectionView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterInspectionView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionApproval]", CHtml::resolveValue($model, "roles[masterInspectionApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterInspectionApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>System(s) to Check</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionSectionCreate]", CHtml::resolveValue($model, "roles[masterInspectionSectionCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterInspectionSectionCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionSectionEdit]", CHtml::resolveValue($model, "roles[masterInspectionSectionEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterInspectionSectionEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionSectionView]", CHtml::resolveValue($model, "roles[masterInspectionSectionView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterInspectionSectionView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionSectionApproval]", CHtml::resolveValue($model, "roles[masterInspectionSectionApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterInspectionSectionApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Function & Components in System</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionModuleCreate]", CHtml::resolveValue($model, "roles[masterInspectionModuleCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterInspectionModuleCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionModuleEdit]", CHtml::resolveValue($model, "roles[masterInspectionModuleEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterInspectionModuleEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterInspectionModuleView]", CHtml::resolveValue($model, "roles[masterInspectionModuleView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterInspectionModuleView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterInspectionModuleApproval]", CHtml::resolveValue($model, "roles[masterInspectionModuleApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterInspectionModuleApproval'
                )); ?>
            </td>
        </tr>
    </tbody>
</table>