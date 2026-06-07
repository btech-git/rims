<div class="table_wrapper">
    <fieldset>
        <legend>Transaksi Bank Masuk</legend>
        <table class="responsive">
            <thead>
                <tr>
                    <?php foreach ($selectedCoas as $coa): ?>
                        <th style="text-align: center; width: 10%"><?php echo CHtml::encode(CHtml::value($coa, 'name')); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>

            <tbody>
                <tr style="vertical-align: top">
                    <?php foreach ($selectedCoas as $coa): ?>
                        <td>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Transaction #</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $paymentDailyTotal = '0.00'; ?>
                                    <?php $dataProvider = $transactionInDataProviders[$coa->id]; ?>
                                    <?php foreach ($dataProvider->data as $detail): ?>
                                        <tr>
                                            <td>
                                                <?php echo CHtml::link(CHtml::encode(CHtml::value($detail, 'kode_transaksi')), Yii::app()->createUrl("report/bankingLedgerMonthly/redirectTransaction", array("codeNumber" => $detail->kode_transaksi)), array('target' => '_blank')); ?>
                                            </td>
                                            <td>
                                                <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($detail, 'tanggal_transaksi')))); ?>
                                            </td>
                                            <td style="text-align: right">
                                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total'))); ?>
                                            </td>
                                        </tr>
                                        <?php $paymentDailyTotal += CHtml::value($detail, 'total'); ?>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" style="text-align: right; font-weight: bold">Total</td>
                                        <td style="text-align: right; font-weight: bold">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentDailyTotal)); ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </fieldset>
</div>