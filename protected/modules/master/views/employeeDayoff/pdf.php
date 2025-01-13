<?php
date_default_timezone_set('Asia/Jakarta');

function tanggal($date) {
    $bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $tahun = substr($date, 0, 4);
    $bulan2 = substr($date, 5, 2);
    $tanggal = substr($date, 8, 2);

    return $tanggal . ' ' . $bulan[(int) $bulan2 - 1] . ' ' . $tahun;
}
?>
<?php $numberOfPages = 1; ?>
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
                <h4>PENGAJUAN CUTI KARYAWAN</h4>
                <h4><?php echo CHtml::encode(CHtml::value($dayoff, 'employee.name')); ?></h4>
            </div>

            <div class="body-memo">
                <table style="font-size: 10px">
                    <tr>
                        <td>Pengajuan #</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo CHtml::encode(CHtml::value($dayoff, 'transaction_number')); ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Mulai</td>
                        <td style="width: 5%">:</td>
                        <td>
                            <?php echo tanggal(CHtml::encode(CHtml::value($dayoff, 'date_from'))); ?> 
                        </td>
                    </tr>
                    <tr>
                        <td>Jenis Cuti</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo CHtml::encode(CHtml::value($dayoff, 'employeeOnleaveCategory.name')); ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Selesai</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo tanggal(CHtml::encode(CHtml::value($dayoff, 'date_to'))); ?></td>
                    </tr>
                    <tr>
                        <td>Paid / Unpaid</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo CHtml::encode(CHtml::value($dayoff, 'off_type')); ?></td>
                    </tr>
                    <tr>
                        <td>Jumlah Hari</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo CHtml::encode(CHtml::value($dayoff, 'day')); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php endfor; ?>