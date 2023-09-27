<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][financeHead]", CHtml::resolveValue($model, "roles[financeHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'financeHead')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Analisa Keuangan</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][financialAnalysisReport]", CHtml::resolveValue($model, "roles[financialAnalysisReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'financialAnalysisReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Kertas Kerja</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][kertasKerjaReport]", CHtml::resolveValue($model, "roles[kertasKerjaReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'kertasKerjaReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Laporan Kas Harian</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][cashDailyReport]", CHtml::resolveValue($model, "roles[cashDailyReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashDailyReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Aset Management</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][assetManagement]", CHtml::resolveValue($model, "roles[assetManagement]"), array('id' => 'User_roles_' . $counter++, 'value' => 'assetManagement')); ?>
            </td>
        </tr>
        <tr>
            <td>Financial Forecast</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][financialSummary]", CHtml::resolveValue($model, "roles[financialSummary]"), array('id' => 'User_roles_' . $counter++, 'value' => 'financialSummary')); ?>
            </td>
        </tr>
    </tbody>
</table>