<fieldset>
    <legend>Cash In</legend>
    <table class="report">
        <thead>
            <tr id="header1">
                <th style="width: 3%">No.</th>
                <th style="width: 15%">Transaksi #</th>
                <th style="width: 45%">Akun</th>
                <th style="width: 10%">Status</th>
                <th style="width: 15%">Amount</th>
                <th style="width: 10%">Verified By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cashTransactionInData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link($header->transaction_number, array("/transaction/cashTransaction/view", "id"=>$header->id)); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'coa.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'credit_amount'))); ?>
                    </td>
                    <td>
                        <?php if ($header->is_verified == 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-check"></span>Verify', array(
                                "/report/dailyTransaction/verifyCashTransaction", 
                                "id" => $header->id, 
                                'branchId' => $branchId, 
                                'transactionDate' => $transactionDate
                            ), array(
                                'class' => 'button success center', 
                                'style' => 'margin-right:10px',
                                'confirm' => 'Are you sure you want to verify this transaction?'
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'userIdVerified.username')); ?>
                        <?php endif; ?>
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
                <th style="width: 3%">No.</th>
                <th style="width: 15%">Transaksi #</th>
                <th style="width: 45%">Akun</th>
                <th style="width: 10%">Status</th>
                <th style="width: 15%">Amount</th>
                <th style="width: 10%">Verified By</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cashTransactionOutData as $i => $header): ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($header->transaction_number), array("/transaction/cashTransaction/view", "id"=>$header->id), array("target" => "_blank")); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'coa.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'status')); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'debit_amount'))); ?>
                    </td>
                    <td>
                        <?php if ($header->is_verified == 0): ?>
                            <?php echo CHtml::link('<span class="fa fa-check"></span>Verify', array(
                                "/report/dailyTransaction/verifyCashTransaction", 
                                "id" => $header->id, 
                                'branchId' => $branchId, 
                                'transactionDate' => $transactionDate
                            ), array(
                                'class' => 'button success center', 
                                'style' => 'margin-right:10px', 
                                'confirm' => 'Are you sure you want to verify this transaction?',
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::encode(CHtml::value($header, 'userIdVerified.username')); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>