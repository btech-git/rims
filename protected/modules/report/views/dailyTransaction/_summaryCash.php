<fieldset>
    <legend>Cash In</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">Transaksi #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Akun</th>
                <th class="width1-4">Status</th>
                <th class="width1-5">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cashTransactionInData as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->transaction_number), array("/transaction/cashTransaction/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->transaction_date))); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'coa.name')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td class="width1-5" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'credit_amount'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>

<hr />

<fieldset>
    <legend>Cash Out</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th class="width1-1">Transaksi #</th>
                <th class="width1-2">Tanggal</th>
                <th class="width1-3">Akun</th>
                <th class="width1-4">Status</th>
                <th class="width1-5">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cashTransactionOutData as $header): ?>
                <tr class="items1">
                    <td class="width1-1">
                        <?php echo CHtml::link(CHtml::encode($header->transaction_number), array("/transaction/cashTransaction/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td class="width1-2">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->transaction_date))); ?>
                    </td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'coa.name')); ?></td>
                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td class="width1-5" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'debit_amount'))); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>