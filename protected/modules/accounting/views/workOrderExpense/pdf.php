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
        <h4>SUB PEKERJAAN LUAR</h4>
    </div>

    <div class="body-memo">
        <table>
            <tr>
                <td>To</td>
                <td>:</td>
                <td><?php echo CHtml::encode(CHtml::value($workOrderExpense, 'supplier.name')); ?></td>
                <td>PO#</td>
                <td>:</td>
                <td><?php echo CHtml::encode(CHtml::value($workOrderExpense, 'transaction_number')); ?></td>
            </tr>
            <tr>
                <td>Address</td>
                <td>:</td>
                <td><?php echo CHtml::encode(CHtml::value($workOrderExpense, 'supplier.address')); ?></td>
                <td>Date</td>
                <td>:</td>
                <td><?php echo tanggal($workOrderExpense->transaction_date); ?></td>
            </tr>
            <tr>
                <td>TOP</td>
                <td>:</td>
                <td><?php echo CHtml::encode(CHtml::value($workOrderExpense, 'supplier.tenor')); ?> Hari</td>
                <td>From</td>
                <td>:</td>
                <td><?php echo CHtml::encode(CHtml::value($workOrderExpense, 'user.username')); ?></td>
            </tr>
            <tr>
                <td>WO #</td>
                <td>:</td>
                <td><?php echo CHtml::encode(CHtml::value($workOrderExpense, 'registrationTransaction.work_order_number')); ?></td>
                <td colspan="3"></td>
            </tr>
        </table>
    </div>

    <div class="purchase-order">
        <table style="margin-top: 0px; font-size: 10px">
            <thead>
                <tr>
                    <th class="no">No</th>
                    <th style="width:40%">Description</th>
                    <th style="width:40%">Memo</th>
                    <th style="width:15%">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($workOrderExpense->workOrderExpenseDetails as $i => $detail): ?>
                    <tr>
                        <td class="noo"><?php echo $i + 1; ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'description')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                        <td style="text-align:right">Rp. <?php echo number_format(CHtml::encode(CHtml::value($detail, 'amount')), 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="r">
                    <td colspan="3" style="text-align:right; font-size: 11px">Total</td>
                    <td style="text-align:right">Rp. <?php echo number_format(CHtml::value($workOrderExpense, 'totalDetail'), 2, ',', '.') ?> &nbsp; </td>
                </tr>
            </tfoot>
        </table>
        
        <div class="row result" style="font-size: 11px; background-color:lightgrey; margin-top: 10px">
            Catatan: <?php echo CHtml::encode(CHtml::value($workOrderExpense, 'note')); ?>
        </div>
    </div>

    <div class="purchase-order">
        <table style="width: 100%">
            <tr>
                <td style="width: 30%">Dibuat,</td>
                <td style="width: 30%">Menyetujui,</td>
                <td style="width: 30%">Mengetahui,</td>
            </tr>
            <tr>
                <td style="height: 80px">&nbsp;</td>
                <td style="height: 80px">&nbsp;</td>
                <td style="height: 80px">&nbsp;</td>
            </tr>
            <tr>
                <td>(<?php echo CHtml::encode(CHtml::value($workOrderExpense, 'user.username')); ?>)</td>
                <td>(<?php echo CHtml::encode(CHtml::value($approval, 'supervisor.username')); ?>)</td>
                <td>(Newira)</td>
            </tr>
        </table>
    </div>
</div>
