<?php
date_default_timezone_set('Asia/Jakarta');

function tanggal($date) {
    $bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'July', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $tahun = substr($date, 0, 4);
    $bulan2 = substr($date, 5, 2);
    $tanggal = substr($date, 8, 2);

    return $tanggal . ' ' . $bulan[(int) $bulan2 - 1] . ' ' . $tahun;
}
?>
<?php $numberOfPages = 3; ?>
<?php for ($i = 0; $i < $numberOfPages; $i++): ?>
    <div <?php if ($i > 0): ?>style=" page-break-before: always"<?php endif; ?>>
        <div class="container">
            <div class="header">
                <div style="float: left; width: 20%; text-align: center">
                    <img src="<?php echo Yii::app()->baseUrl . '/images/rap-logo.png' ?>" style="width: 75px; height: 64px" />
                </div>
                <div style="float: right; width: 40%">
                    <div>
                        Jl. Raya Jati Asih/Jati Kramat - 84993984/77 Fax. 84993989 <br />
                        Jl. Raya Kalimalang No. 8, Kp. Dua - 8843656 Fax. 88966753<br />
                        Jl. Raya Kalimalang Q/2D - 8643594/95 Fax. 8645008
                    </div>
                </div>
                <div style="float: right; width: 40%">
                    <div>
                        Jl. Raya Radin Inten II No. 9 - 8629545/46 Fax. 8627313<br />
                        Jl. Celebration Boulevard Blok AA 9/35 - 8261594<br />
                        Email info@raperind.com
                    </div>
                </div>
            </div>

            <div style="text-align: center">
                <h4>
                    TRANSAKSI KAS <?php echo CHtml::encode(CHtml::value($model, 'transaction_type')); ?>
                    <?php if ($i > 0): ?><span style="color: red"> - COPY</span><?php endif; ?>
                </h4>
            </div>

            <div class="body-memo">
                <table style="font-size: 10px">
                    <tr>
                        <td>Kas #</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo CHtml::encode(CHtml::value($model, 'transaction_number')); ?></td>
                        <td>Tanggal</td>
                        <td style="width: 5%">:</td>
                        <td>
                            <?php echo tanggal(CHtml::encode(CHtml::value($model, 'transaction_date'))); ?>
                            <?php echo CHtml::encode(CHtml::value($model, 'transaction_time')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Payment</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo CHtml::encode(CHtml::value($model, 'paymentType.name')); ?></td>
                        <td>Note</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo CHtml::encode(CHtml::value($model, 'note')); ?></td>
                    </tr>
                </table>
            </div>

            <hr />

            <div class="purchase-order">
                <div class="detail">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 1%">No</th>
                                <th width="10%">Code</th>
                                <th>Name</th>
                                <th width="35%">Deskripsi</th>
                                <th width="15%">Jumlah</th>
                            </tr>
                        </thead>
                        <?php $no = 1; ?>
                        <tbody style="height: 100px;">
                            <?php $totalAmount = '0.00'; ?>
                            <?php foreach ($model->cashTransactionDetails as $key => $detail): ?>
                                <?php $amount = CHtml::value($detail, 'amount'); ?>
                                <tr>
                                    <td class="noo"><?php echo $no; ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($detail, 'coa.code')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($detail, 'coa.name')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($detail, 'notes')); ?></td>
                                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00',$amount)); ?></td>
                                </tr>
                                <?php $no++; ?>
                                <?php $totalAmount += $amount; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="text-align: right; font-weight: bold">TOTAL</td>
                                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00',$totalAmount)); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="detail-notes">
                <table width="100%">
                    <tr>
                        <td class="tengah">Accounting / Finance</td>
                        <td class="tengah">Supervisor</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="tengah h250"><div class="garisbawah">Accounting / Finance</div></td>
                        <td class="tengah h250"><div class="garisbawah">Supervisor</div></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php endfor; ?>