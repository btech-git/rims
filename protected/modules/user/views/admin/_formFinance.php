<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][financeHead]", CHtml::resolveValue($model, "roles[financeHead]"), array(
                    'id' => 'User_roles_' . $counter, 
                    'value' => 'financeHead'
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
            <td>1. Hutang Jatuh Tempo</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][payableDueReport]", CHtml::resolveValue($model, "roles[payableDueReport]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'payableDueReport'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>2. Piutang Jatuh Tempo</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][receivableDueReport]", CHtml::resolveValue($model, "roles[receivableDueReport]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'receivableDueReport'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>3. Analisa Keuangan</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][financialAnalysisReport]", CHtml::resolveValue($model, "roles[financialAnalysisReport]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'financialAnalysisReport'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>4. Kertas Kerja</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][kertasKerjaReport]", CHtml::resolveValue($model, "roles[kertasKerjaReport]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'kertasKerjaReport'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>5. Laporan Kas Harian</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][cashDailyReport]", CHtml::resolveValue($model, "roles[cashDailyReport]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'cashDailyReport'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>6. Aset Management</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][assetManagementCreate]", CHtml::resolveValue($model, "roles[assetManagementCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'assetManagementCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][assetManagementEdit]", CHtml::resolveValue($model, "roles[assetManagementEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'assetManagementEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][assetManagementView]", CHtml::resolveValue($model, "roles[assetManagementView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'assetManagementView'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>7. Financial Forecast</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][financialSummary]", CHtml::resolveValue($model, "roles[financialSummary]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'financialSummary'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>8. Cancelled Transaction</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][cancelledTransactionView]", CHtml::resolveValue($model, "roles[cancelledTransactionView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'cancelledTransactionView'
                )); ?>
            </td>
        </tr>
    </tbody>
</table>