<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php if (CHtml::resolveValue($model, "roles[masterCompany]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
                <?php //echo CHtml::label('SETTING COMPANY', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
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
                <?php if (CHtml::resolveValue($model, "roles[masterUserCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterUserEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterUserView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterUserApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?></td>
        </tr>
        <tr>
            <td>Company</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterCompanyCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterCompanyEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterCompanyView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterCompanyApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Branch</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterBranchCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterBranchEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterBranchView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterBranchApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Supplier</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterSupplierCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterSupplierEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterSupplierView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterSupplierApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Deduction</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterDeductionCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterDeductionEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterDeductionView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterDeductionApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Incentive</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterIncentiveCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterIncentiveEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterIncentiveView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterIncentiveApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Position</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterPositionCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterPositionEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterPositionView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterPositionApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Division</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterDivisionCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterDivisionEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterDivisionView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterDivisionApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Level</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterLevelCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterLevelEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterLevelView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterLevelApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Unit</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterUnitCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterUnitEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterUnitView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterUnitApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Unit Conversion</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterConversionCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterConversionEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterConversionView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterConversionApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>