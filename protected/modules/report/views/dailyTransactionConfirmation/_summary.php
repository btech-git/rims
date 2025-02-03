<fieldset>
    <legend>Konfirmasi Transaksi Harian Summary</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1"></th>
                <?php foreach ($branches as $branch): ?>
                    <th class="width1-2"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 1; $i <= $numberOfDays; $i++): ?>
                <?php $date = $year . '-' . $month . '-' . str_pad($i, 2, '0', STR_PAD_LEFT); ?>
                <tr class="items1">
                    <td class="width1-1"><?php echo CHtml::encode($date); ?></td>
                    <?php foreach ($branches as $branch): ?>
                    <th class="width1-2" style="text-align: center; font-size: larger"><?php echo isset($confirmationListData[$date][$branch->id]) ? '&#10003' : ''; ?></th>
                    <?php endforeach; ?>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</fieldset>
