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
<style>
    .page {
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
    }
    .container {
        background-color: rgba(255, 255, 255, 0.8);
    }
</style>

<div class="container">
    <div class="header">
        <div style="float: left; width: 20%; text-align: center">
            <img src="<?php echo Yii::app()->baseUrl; ?>/images/rap-logo.png" style="width: 75px; height: 64px" />
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
                Jl. Celebration Boulevard Blok AA 9/35 - 82615945<br />
                Email info@raperind.com
            </div>
        </div>
    </div>

    <div style="text-align: center">
        <h4>REKAP INVOICE</h4>
    </div>

    <div class="body-memo">
        <table>
            <tr>
                <td>TT #</td>
                <td>:</td>
                <td><?php echo $saleReceiptHeader->transaction_number; ?></td>
                <td>TANGGAL</td>
                <td>:</td>
                <td><?php echo tanggal($saleReceiptHeader->transaction_date); ?></td>
            </tr>
            <tr>
                <td>CUSTOMER</td>
                <td>:</td>
                <td><?php echo $customer->name; ?></td>
                <td>JATUH TEMPO</td>
                <td>:</td>
                <td><?php echo tanggal($saleReceiptHeader->due_date); ?></td>
            </tr>
            <tr>
                <td>CATATAN</td>
                <td>:</td>
                <td colspan="4"><?php echo $saleReceiptHeader->note; ?></td>
            </tr>
        </table>
    </div>

    <div class="purchase-order">
        <table>
            <thead>
                <tr>
                    <th style="width: 2%">No</th>
                    <th style="font-size: 10px">Invoice #</th>
                    <th style="font-size: 10px">Tanggal</th>
                    <th style="font-size: 10px">Plat #</th>
                    <th style="font-size: 10px">Memo</th>
                    <th style="font-size: 10px">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($saleReceiptHeader->saleReceiptDetails as $i => $detail): ?>
                    <tr class="isi">
                        <td class="noo"><?php echo $i+1; ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.invoice_number')); ?></td>
                        <td>&nbsp; <?php echo tanggal(CHtml::encode(CHtml::value($detail, 'invoiceHeader.invoice_date'))); ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.vehicle.plate_number')); ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                        <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($detail->invoice_amount, 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right; font-weight: bold">Total</td>
                    <td style="text-align: right; font-weight: bold">&nbsp;  Rp. <?php echo number_format($saleReceiptHeader->total_invoice_amount, 2, ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>