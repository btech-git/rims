<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php if (CHtml::resolveValue($model, "roles[inventoryHead]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
                <?php //echo CHtml::label('GUDANG', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">View</th>
            <th style="text-align: center">Approval</th>
            <th style="text-align: center">Supervisor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Barang Masuk Gudang</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[movementInCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?></td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[movementInEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[movementInView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[movementInApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[movementInSupervisor]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Barang Keluar Gudang</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[movementOutCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[movementOutEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[movementOutView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[movementOutApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[movementOutSupervisor]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Pengeluaran Bahan Pemakaian</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[movementServiceCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[movementServiceEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[movementServiceView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[movementServiceApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[movementServiceSupervisor]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Permintaan Bahan</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[materialRequestCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[materialRequestEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[materialRequestView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[materialRequestApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[materialRequestSupervisor]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Stok Gudang</td>
            <td style="text-align: center"></td>
            <td style="text-align: center"></td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[warehouseStockReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Analisa Stok Barang</td>
            <td style="text-align: center"></td>
            <td style="text-align: center"></td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[stockAnalysisReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Penyesuaian Stok</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[stockAdjustmentCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[stockAdjustmentView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[stockAdjustmentApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[stockAdjustmentSupervisor]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>