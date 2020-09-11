<?php Yii::app()->clientScript->registerCss('_report', '
	.price {text-align: right;}
'); ?>
<?php //echo(CJSON::encode($orderPenjualanPendingSummary->dataProvider->data));  ?>


<?php if ($jurnals != NULL) { ?>
    <div class="reportHeader">
        <div>PT RATU PERDANA INDAH JAYA</div>
        <div>JURNAL UMUM</div>
        <div>Periode: <?php echo $tanggal_mulai . ' s/d ' . $tanggal_sampai; ?></div>

        <span></span><br />
        <div>Tanggal Cetak: <?php echo date('d/m/Y'); ?></div>
    </div>
    <p></p>
    <table>
        <thead>
            <th>NO</th>
            <th>TANGGAL</th>
            <th>KODE TRANSAKSI</th>
            <th>KODE</th>
            <th>NAMA</th>
            <th>DEBET</th>
            <th>KREDIT</th>
        </thead>
        <tbody>
            <?php $lastkode = ""; ?>
            <?php $totalDebet = $totalkredit = 0; ?>
            <?php $number = 1; ?>

            <?php foreach ($jurnals as $key => $jurnal): ?>
                <?php if ($jurnal->is_coa_category == 0): ?>
                    <?php if ($lastkode != $jurnal->kode_transaksi): ?>
                        <tr>
                            <td><?php echo $number; ?></td>
                            <td>
                                <?php echo $lastkode == $jurnal->kode_transaksi ? "" : $jurnal->tanggal_posting; ?>
                            </td>
                            <td>
                                <?php echo $lastkode == $jurnal->kode_transaksi ? "" : CHtml::link($jurnal->kode_transaksi, Yii::app()->createUrl("accounting/JurnalUmum/redirectTransaction", array("codeNumber" => $jurnal->kode_transaksi)), array('target' => '_blank')); ?>
                            </td>
                            <td colspan="2" style="font-weight: bold; text-align: center"><?php echo $lastkode == $jurnal->kode_transaksi ? "" : $jurnal->transaction_subject; ?></td>
                            <td style="font-weight: bold; text-align: center"><?php echo number_format($jurnal->getSubTotalDebit($jurnal->kode_transaksi), 2) ?></td>
                            <td style="font-weight: bold; text-align: center"><?php echo number_format($jurnal->getSubTotalKredit($jurnal->kode_transaksi), 2) ?></td>
                        </tr>
                        <?php $number += 1; ?>
                    <?php endif; ?>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                        <td><?php echo empty($jurnal->coa) ? "" : $jurnal->branchAccountCode; ?></td>
                        <td><?php echo empty($jurnal->coa) ? "" : $jurnal->branchAccountName ?></td>
                        <td><?php echo $jurnal->debet_kredit == 'D' ? number_format($jurnal->total, 2) : '' ?></td>
                        <td><?php echo $jurnal->debet_kredit == 'K' ? number_format($jurnal->total, 2) : '' ?></td>
                        <?php
                        if ($jurnal->debet_kredit == 'D') {
                            $totalDebet += $jurnal->total;
                        }
                        ?>
                        <?php
                        if ($jurnal->debet_kredit == 'K') {
                            $totalkredit += $jurnal->total;
                        }
                        ?>
                    </tr>
                <?php $lastkode = $jurnal->kode_transaksi; ?>
            <?php endif; ?>
        <?php endforeach; ?>
            <tr>
                <td colspan="5" style="font-weight: bold">Total</td>
                <td style="font-weight: bold"><b><?php echo number_format($totalDebet, 2); ?></b></td>
                <td style="font-weight: bold"><b><?php echo number_format($totalkredit, 2); ?></b></td>
            </tr>
        </tbody>
    </table>
<?php } ?>
	
