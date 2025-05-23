
<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php if (CHtml::resolveValue($model, "roles[idleManagement]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
                <?php //echo CHtml::label('IDLE MANAGEMENT', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>BR Mechanic POV</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[brMechanicCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?></td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[brMechanicEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[brMechanicApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>BR Head POV</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[brHeadCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?></td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[brHeadEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[brHeadApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>GR Mechanic POV</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[grMechanicCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[grMechanicEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[grMechanicApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>GR Head POV</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[grHeadCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[grHeadEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[grHeadApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>
