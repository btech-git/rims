<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php if (CHtml::resolveValue($model, "roles[financeHead]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </th>
            <th style="text-align: center">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Analisa Keuangan</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[financialAnalysisReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Kertas Kerja</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[kertasKerjaReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Laporan Kas Harian</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[cashDailyReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Aset Management</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[assetManagement]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Financial Forecast</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[financialSummary]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>