<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][productHead]", CHtml::resolveValue($model, "roles[productHead]"), array(
                    'id' => 'User_roles_' . $counter, 
                    'value' => 'productHead'
                )); ?>
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
            <td>Product</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterProductCreate]", CHtml::resolveValue($model, "roles[masterProductCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterProductCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterProductEdit]", CHtml::resolveValue($model, "roles[masterProductEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterProductEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterProductView]", CHtml::resolveValue($model, "roles[masterProductView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterProductView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterProductApproval]", CHtml::resolveValue($model, "roles[masterProductApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterProductApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Product Category</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterProductCategoryCreate]", CHtml::resolveValue($model, "roles[masterProductCategoryCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterProductCategoryCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterProductCategoryEdit]", CHtml::resolveValue($model, "roles[masterProductCategoryEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterProductCategoryEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterProductCategoryView]", CHtml::resolveValue($model, "roles[masterProductCategoryView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterProductCategoryView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterProductCategoryApproval]", CHtml::resolveValue($model, "roles[masterProductCategoryApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterProductCategoryApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Product Sub Master Category</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterProductSubMasterCategoryCreate]", CHtml::resolveValue($model, "roles[masterProductSubMasterCategoryCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterProductSubMasterCategoryCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterProductSubMasterCategoryEdit]", CHtml::resolveValue($model, "roles[masterProductSubMasterCategoryEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterProductSubMasterCategoryEdit'
                    )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterProductSubMasterCategoryView]", CHtml::resolveValue($model, "roles[masterProductSubMasterCategoryView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterProductSubMasterCategoryView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterProductSubMasterCategoryApproval]", CHtml::resolveValue($model, "roles[masterProductSubMasterCategoryApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterProductSubMasterCategoryApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Product Sub Category</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterProductSubCategoryCreate]", CHtml::resolveValue($model, "roles[masterProductSubCategoryCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterProductSubCategoryCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterProductSubCategoryEdit]", CHtml::resolveValue($model, "roles[masterProductSubCategoryEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterProductSubCategoryEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterProductSubCategoryView]", CHtml::resolveValue($model, "roles[masterProductSubCategoryView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterProductSubCategoryView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterProductSubCategoryApproval]", CHtml::resolveValue($model, "roles[masterProductSubCategoryApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterProductSubCategoryApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Brand</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterBrandCreate]", CHtml::resolveValue($model, "roles[masterBrandCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterBrandCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterBrandEdit]", CHtml::resolveValue($model, "roles[masterBrandEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterBrandEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterBrandView]", CHtml::resolveValue($model, "roles[masterBrandView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterBrandView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterBrandApproval]", CHtml::resolveValue($model, "roles[masterBrandApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterBrandApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Sub Brand</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterSubBrandCreate]", CHtml::resolveValue($model, "roles[masterSubBrandCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterSubBrandCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterSubBrandEdit]", CHtml::resolveValue($model, "roles[masterSubBrandEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterSubBrandEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterSubBrandView]", CHtml::resolveValue($model, "roles[masterSubBrandView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterSubBrandView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterSubBrandApproval]", CHtml::resolveValue($model, "roles[masterSubBrandApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterSubBrandApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Sub Brand Series</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterSubBrandSeriesCreate]", CHtml::resolveValue($model, "roles[masterSubBrandSeriesCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterSubBrandSeriesCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterSubBrandSeriesEdit]", CHtml::resolveValue($model, "roles[masterSubBrandSeriesEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterSubBrandSeriesEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterSubBrandSeriesView]", CHtml::resolveValue($model, "roles[masterSubBrandSeriesView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterSubBrandSeriesView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterSubBrandSeriesApproval]", CHtml::resolveValue($model, "roles[masterSubBrandSeriesApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterSubBrandSeriesApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Satuan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterUnitCreate]", CHtml::resolveValue($model, "roles[masterUnitCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterUnitCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterUnitEdit]", CHtml::resolveValue($model, "roles[masterUnitEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterUnitEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterUnitView]", CHtml::resolveValue($model, "roles[masterUnitView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterUnitView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterUnitApproval]", CHtml::resolveValue($model, "roles[masterUnitApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterUnitApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Konversi Satuan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterConversionCreate]", CHtml::resolveValue($model, "roles[masterConversionCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterConversionCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterConversionEdit]", CHtml::resolveValue($model, "roles[masterConversionEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterConversionEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterConversionView]", CHtml::resolveValue($model, "roles[masterConversionView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterConversionView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterConversionApproval]", CHtml::resolveValue($model, "roles[masterConversionApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterConversionApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Ukuran Ban</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterTireSizeCreate]", CHtml::resolveValue($model, "roles[masterTireSizeCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterTireSizeCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterTireSizeEdit]", CHtml::resolveValue($model, "roles[masterTireSizeEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterTireSizeEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterTireSizeView]", CHtml::resolveValue($model, "roles[masterTireSizeView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterTireSizeView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterTireSizeApproval]", CHtml::resolveValue($model, "roles[masterUnitApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterUnitApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>Spesifikasi Oli (SAE)</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterOilSpecificationCreate]", CHtml::resolveValue($model, "roles[masterOilSpecificationCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterOilSpecificationCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterOilSpecificationEdit]", CHtml::resolveValue($model, "roles[masterOilSpecificationEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterOilSpecificationEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterOilspecificationView]", CHtml::resolveValue($model, "roles[masterOilspecificationView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterOilspecificationView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][masterOilSpecificationApproval]", CHtml::resolveValue($model, "roles[masterOilSpecificationApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterOilSpecificationApproval'
                )); ?>
            </td>
        </tr>
    </tbody>
</table>