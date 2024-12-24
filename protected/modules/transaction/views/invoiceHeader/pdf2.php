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
<style>
    .container{
  font-family: calibri
}
.header{
  width: 100%;
  overflow: hidden;
  border-bottom:1px solid gray;
  padding-bottom: 10px;
  font-size: 10px;
}
.header .left{
  width: 50%;
  float: left
}
.header .right{
  width: 35%;
  float: right
}
.header .right h3{
  border-bottom:2px solid black;
  text-align: center;
  padding-bottom: 5px;
}
.body-memo{
  width: 100%;
  overflow: hidden;
}
.body-memo table{
  border-collapse: collapse;
  width: 100%;
  font-size: 10px;
}
.raperind{
  font-size: 12px;
}
.rapad{
  font-size: 10px;
}
.rap{
  padding-top:15px
}

.supplier{
  width: 100%;
  overflow: hidden;
  padding-top: 20px;
}
.supplier .left{
  width: 50%;
  float: left;
}
.supplier .right{
  width: 48.2%;
  float: right
}
.supplier table{
  border-collapse: collapse;
  width: 100%;
}
.supplier table tr td{
  padding: 5px;
  font-size: 10px;
}
.purchase-order{
  width: 100%;
  margin:5px 0;
}
.purchase-order table{
  border-collapse: collapse;
  width: 100%;
}
.purchase-order table tr th{
  border:1px solid black;
  padding: 10px;
  font-size: 12px;
}
.purchase-order table tr td{
  border:1px solid black;
  padding: 5px;
  font-size: 10px;
}
.purchase-order table tr .no{
  width: 5%;
}
.purchase-order table tr .item{
  width: 30%;
}
.purchase-order table tr .price{
  width: 20%;
}
.purchase-order table tr .qty{
  width: 10%;
}
.purchase-order table tr .discount{
  width: 15%;
}
.purchase-order table tr .subtotal{
  width: 20%;
}
.purchase-order table tr .noo{
  text-align: center
}
.purchase-order table tr .result{
  background: #ddd;
  padding: 4px 15px;
  font-style:italic
}
.authorized{
  text-align:right;
  margin-top:150px;
  padding: 15px 50px;
  border-top:1px solid black;
  /*width: 16%;*/
  width: 150px;
  float: right
}
.isi td{
  font-size:10px;
  padding: 4px 8px
}
.r td{
  font-size: 10px
}

div.garisbawah {
    text-align:center;
    border-bottom: 1px solid black;
    color: #FFFFFF;
    /*width: 350px;*/
}
td.tengah {
    text-align: center;
}
td.h250 {
    height: 200px;
}
    .page {
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        print-color-adjust: exact;
    }
    .container {
        background-color: rgba(255, 255, 255, 0.8);
    }
</style>
<?php $numberOfPages = 3; ?>
<?php for ($i = 0; $i < $numberOfPages; $i++): ?>
    <div class="page" <?php if ($i > 0): ?>style="page-break-before: always; background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/copy-text.jpg')"<?php else: ?>style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/rap-logo.png')"<?php endif; ?>>
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
                        Jl. Celebration Boulevard Blok AA 9/35 - 8261594<br />
                        Email info@raperind.com
                    </div>
                </div>
            </div>

            <div style="text-align: center">
                <h4>INVOICE</h4>
            </div>

            <div class="body-memo">
                <table>
                    <tr>
                        <td>INVOICE #</td>
                        <td>:</td>
                        <td><?php echo $invoiceHeader->invoice_number; ?></td>
                        <td>TGL INVOICE</td>
                        <td>:</td>
                        <td><?php echo tanggal($invoiceHeader->invoice_date); ?></td>
                    </tr>
                    <tr>
                        <td>NAMA</td>
                        <td>:</td>
                        <td><?php echo $customer->name; ?></td>
                        <td>NO. POLISI</td>
                        <td>:</td>
                        <td><?php echo $invoiceHeader->vehicle->plate_number; ?></td>
                    </tr>
                    <tr>
                        <td>PHONE</td>
                        <td>:</td>
                        <td><?php echo $customer->mobile_phone; ?></td>
                        <td>KENDARAAN</td>
                        <td>:</td>
                        <td>
                            <?php echo $invoiceHeader->vehicle->carMake->name; ?> -
                            <?php echo $invoiceHeader->vehicle->carModel->name; ?> -
                            <?php echo $invoiceHeader->vehicle->carSubModel->name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>KM</td>
                        <td>:</td>
                        <td>
                            <?php echo $invoiceHeader->registrationTransaction->vehicle_mileage; ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="purchase-order">
                <table>
                    <tr>
                        <th colspan="10" style="text-align: left">SUKU CADANG - SPAREPARTS</th>
                    </tr>
                    <tr>
                        <th style="width: 1%">No</th>
                        <th>Code</th>
                        <th>Item Name</th>
                        <th>Brand Name</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th style="width: 10%">Price</th>
                        <th style="width: 10%">Disc</th>
                        <th style="width: 10%">After Disc</th>
                        <th style="width: 10%">Sub Total</th>
                    </tr>
                    <?php $no = 1; ?>
                    <?php foreach ($invoiceHeader->invoiceDetails as $detail): ?>
                        <?php if (!empty($detail->product_id)): ?>
                            <tr class="isi">
                                <td class="noo"><?php echo $no; ?></td>
                                <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')); ?></td>
                                <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                                <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name')); ?></td>
                                <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?></td>
                                <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'product.unit.name')); ?></td>
                                <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($detail->unit_price, 2, ',', '.'); ?></td>
                                <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($detail->discount, 2, ',', '.'); ?></td>
                                <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($detail->unit_price, 2, ',', '.'); ?></td>
                                <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($detail->total_price, 2, ',', '.'); ?></td>
                            </tr>
                        <?php $no++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="9" style="text-align: right;">Total Parts</td>
                        <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($invoiceHeader->product_price, 2, ',', '.'); ?></td>
                    </tr>
                </table>
            </div>

            <div class="purchase-order">
                <table>
                    <tr>
                        <th colspan="5" style="text-align: left">JASA PERBAIKAN - SERVICE</th>
                    </tr>
                    <tr>
                        <th style="width: 1%">No</th>
                        <th>Service</th>
                        <th style="width: 10%">Price</th>
                        <th style="width: 10%">Disc</th>
                        <th style="width: 10%">Sub Total</th>
                    </tr>
                    <?php $no = 1;?>
                    <?php foreach ($invoiceHeader->invoiceDetails as $detail): ?>
                        <?php if (!empty($detail->quick_service_id)): ?>
                        <tr class="isi">
                            <td class="noo"><?php echo $no; ?></td>
                            <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'quickService.name')); ?></td>
                            <td style="text-align: right">&nbsp;  Rp. <?php echo number_format($detail->total_price, 2, ',', '.') ?></td>
                        </tr>
                        <?php $no++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php foreach ($invoiceHeader->invoiceDetails as $detail): ?>
                        <?php if (!empty($detail->service_id)): ?>
                        <tr class="isi">
                            <td class="noo"><?php echo $no; ?></td>
                            <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'service.name')); ?></td>
                            <td style="text-align: right">&nbsp; Rp. <?php echo number_format($detail->unit_price, 2, ',', '.') ?></td>
                            <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($detail->discount, 2, ',', '.'); ?></td>
                            <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($detail->total_price, 2, ',', '.'); ?></td>
                        </tr>
                        <?php $no++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" style="text-align: right;">Total Jasa</td>
                        <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($invoiceHeader->service_price, 2, ',', '.'); ?></td>
                    </tr>
                </table>
            </div>

            <div>
                <table style="width: 100%">
                    <tr>
                        <td style="font-size: 11px">Printed by : <?php echo Yii::app()->user->getName(); ?></td>
                        <td style="text-align:right; width: 20%; font-size: 11px">TOTAL PRODUCT & SERVICE</td>
                        <td style="text-align:right; width: 20%; font-size: 11px">Rp. <?php echo number_format($invoiceHeader->subTotal, 2, ',', '.') ?> &nbsp; </td>
                    </tr>

                    <?php if ($invoiceHeader->ppn_total > 0): ?>
                        <tr>
                            <td style="font-size: 11px">Note : <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'note')); ?></td>
                            <td style="text-align:right; font-size: 11px">PPN - <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'tax_percentage')); ?>%</td>
                            <td style="text-align:right; font-size: 11px">Rp. <?php echo number_format($invoiceHeader->ppn_total, 2, ',', '.') ?> &nbsp; </td>
                        </tr>
                    <?php endif; ?>

                    <?php if ($invoiceHeader->pph_total > 0): ?>
                        <tr>
                            <td></td>
                            <td style="text-align:right; font-size: 11px">PPH 23</td>
                            <td style="text-align:right; font-size: 11px">Rp. <?php echo number_format($invoiceHeader->pph_total, 2, ',', '.') ?> &nbsp; </td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <td></td>
                        <td style="font-weight: bold; text-align:right; font-size: 11px">GRAND TOTAL</td>
                        <td style="font-weight: bold; text-align:right; font-size: 11px">Rp. <?php echo number_format($invoiceHeader->total_price, 2, ',', '.') ?> &nbsp; </td>
                    </tr>
                </table>
            </div>

            <div style="font-size: 10px; text-align: left">1. Raperind Motor tidak bertanggung jawab atas kendaraan yang tidak diambil dalam waktu 30 hari setelah kendaraan selesai</div>
            <div style="font-size: 10px; text-align: left">2. Raperind Motor bertanggung jawab atas keamanan kendaraan yang ditinggal di workshop dengan penggantian sebesar 10x Jasa, kecuali atas kejadian Force Majeure (Pencurian Kendaraan, Kebakaran, dll)</div>
        </div>
    </div>
<?php endfor; ?>