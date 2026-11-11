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
                <td>TRANSAKSI #</td>
                <td>:</td>
                <td><?php echo $saleReceiptHeader->transaction_number; ?></td>
                <td>TANGGAL</td>
                <td>:</td>
                <td><?php echo tanggal($saleReceiptHeader->transaction_date); ?></td>
            </tr>
            <tr>
                <td><?php echo empty($saleReceiptHeader->customer_id) ? 'ASURANSI' : 'CUSTOMER'; ?></td>
                <td>:</td>
                <td><?php echo empty($saleReceiptHeader->customer_id) ? $saleReceiptHeader->insuranceCompany->name : $customer->name; ?></td>
                <td>ESTIMASI TANGGAL BAYAR</td>
                <td>:</td>
                <td><?php echo tanggal($saleReceiptHeader->due_date); ?></td>
            </tr>
        </table>
    </div>

    <div class="purchase-order">
        <table>
            <thead>
                <tr>
                    <th style="font-size: 10px; width: 2%">No</th>
                    <th style="font-size: 10px">Invoice #</th>
                    <th style="font-size: 10px">Tanggal</th>
                    <th style="font-size: 10px">Jatuh Tempo</th>
                    <th style="font-size: 10px">Plat #</th>
                    <th style="font-size: 10px">Kendaraan</th>
                    <th style="font-size: 10px">SPK #</th>
                    <th style="font-size: 10px">Jasa</th>
                    <th style="font-size: 10px">Parts</th>
                    <th style="font-size: 10px">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($saleReceiptHeader->saleReceiptDetails as $i => $detail): ?>
                    <tr class="isi">
                        <td class="noo"><?php echo ++$i; ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.invoice_number')); ?></td>
                        <td>
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", strtotime(CHtml::value($detail, 'invoiceHeader.invoice_date')))); ?>
                        </td>
                        <td>
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", strtotime(CHtml::value($detail, 'invoiceHeader.due_date')))); ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.vehicle.plate_number')); ?></td>
                        <td>
                            <?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.vehicle.carMake.name")); ?> -
                            <?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.vehicle.carModel.name")); ?> -
                            <?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.vehicle.carSubModel.name")); ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.registrationTransaction.customer_work_order_number')); ?></td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'invoiceHeader.service_price'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'invoiceHeader.product_price'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'invoice_amount'))); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align: right; font-weight: bold" colspan="7">Sub Total</td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleReceiptHeader, 'totalServiceAmount'))); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleReceiptHeader, 'totalPartsAmount'))); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleReceiptHeader, 'total_invoice_amount'))); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="9" style="text-align: right; font-weight: bold">
                        PPn <?php echo CHtml::encode(CHtml::value($saleReceiptHeader, "tax_item_percentage")); ?>%
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleReceiptHeader, 'tax_item_amount'))); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="9" style="text-align: right; font-weight: bold">
                        PPh 23 <?php echo CHtml::encode(CHtml::value($saleReceiptHeader, "tax_service_percentage")); ?>%
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleReceiptHeader, 'tax_service_amount'))); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="8" style="font-weight: bold">
                        Terbilang:
                        <?php echo CHtml::encode(NumberWord::numberName(floor(CHtml::value($saleReceiptHeader, 'total_receivable_amount')))); ?>
                        Rupiah
                    </td>
                    <td style="text-align: right; font-weight: bold">Grand Total</td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleReceiptHeader, "total_receivable_amount"))); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="detail-notes">
        <p>Catatan: <?php echo CHtml::encode(CHtml::value($saleReceiptHeader, "note")); ?></p>
    </div>
    
    <div class="detail-notes">
        <table width="100%">
            <tr>
                <td class="tengah" style="width: 30%">Dibuat oleh</td>
                <td rowspan="3" style="vertical-align: top">
                    <p>Pembayaran menggunakan cek / giro harap mencantumkan:</p>
                    <p>nama <span style="font-weight:bold">PT. Ratu Perdana Indah Jaya</span> atau transfer ke rekening berikut:</p>
                    <p style="font-weight:bold">Bank : <?php echo CHtml::encode(CHtml::value($saleReceiptHeader, 'companyBank.bank.name')); ?></p>
                    <p style="font-weight:bold">Atas Nama : <?php echo CHtml::encode(CHtml::value($saleReceiptHeader, 'companyBank.account_name')); ?></p>
                    <p style="font-weight:bold">No. Rekening : <?php echo CHtml::encode(CHtml::value($saleReceiptHeader, 'companyBank.account_no')); ?></p>
                    <p style="font-weight:bold">Info pembayaran harap email ke gracia.angelin4@gmail.com</p>
                </td>
            </tr>
            <tr>
                <td class="tengah h250"><?php echo CHtml::encode(CHtml::value($saleReceiptHeader, 'userIdCreated.username')); ?></td>
            </tr>
        </table>
    </div>
</div>