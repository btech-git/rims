<table>
    <thead>
        <tr>
            <th></th>
            <th>Jan</th>
            <th>Feb</th>
            <th>Mar</th>
            <th>Apr</th>
            <th>May</th>
            <th>Jun</th>
            <th>Jul</th>
            <th>Aug</th>
            <th>Sep</th>
            <th>Oct</th>
            <th>Nov</th>
            <th>Dec</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($balanceSheetInfo as $balanceSheetRow): ?>
            <tr>
                <td><?php echo $balanceSheetRow['code'] . ' - ' . $balanceSheetRow['name']; ?></td>
                <?php foreach (range(1, 12) as $monthNumber): ?>
                    <?php $month = str_pad($monthNumber, 2, '0', STR_PAD_LEFT); ?>
                    <?php $balance = isset($balanceSheetRow[$month]['total']) ? $balanceSheetRow[$month]['total'] : ''; ?>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $balance)); ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    
