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
        <div style="float: left; width: 50%; text-align: center">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/rap-logo.png" alt="" width="35%"/>
        </div>
        <div style="float: right; width: 45%">
            <p>
                Jl. Raya Jati Asih/Jati Kramat - 84993984/77 Fax. 84993989 <br />
                Jl. Raya Kalimalang No. 8, Kp. Dua - 8843656 Fax. 88966753<br />
                Jl. Raya Kalimalang Q/2D - 8643594/95 Fax. 8645008<br />
                Jl. Raya Radin Inten II No. 9 - 8629545/46 Fax. 8627313<br />
                Jl. Celebration Boulevard Blok AA 9/35 - 8261594<br />
                Email info@raperind.com
            </p>
        </div>
    </div>
    
    <div style="text-align: center">
        <h4>SURAT JALAN</h4>
    </div>

    <div class="body-memo">
        <table style="font-size: 10px">
            <tr>
                <td colspan="3">Kepada Yth,</td>
            </tr>
            <tr>
                <td>Customer</td>
                <td>:</td>
                <td><?php echo CHtml::encode(CHtml::value($do, 'customer.name')); ?></td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>:</td>
                <td><?php echo $phonenumber; ?></td>
            </tr>
            <tr>
                <td>Address</td>
                <td>:</td>
                <td><?php echo !empty($do->customer->address)?$do->customer->address.", ": ""; ?><?php echo $do->customer->city->name; ?>  <?php echo $do->customer->province->name; ?> <?php echo $do->customer->zipcode; ?></td>
            </tr>
        </table>
    </div>
    
    <hr />
    
    <div class="purchase-order">
        <div class="detail">
            <?php if (count($do->transactionDeliveryOrderDetails) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th width="30%">Product Name</th>
                            <th width="10%">Quantity</th>
                            <th width="60%">Notes</th>
                        </tr>
                    </thead>
                    <tbody style="height: 100px;">
                        <?php foreach ($do->transactionDeliveryOrderDetails as $key => $deliveryDetail): ?>
                            <tr>
                                <td><?php echo $deliveryDetail->product->name == ''?'-':$deliveryDetail->product->name; ?></td>
                                <td><?php echo $deliveryDetail->quantity_request == ''?'-':$deliveryDetail->quantity_request; ?></td>
                                <td><?php echo $deliveryDetail->note== ''?'-':$deliveryDetail->note; ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>    
            <?php else: ?>
                <?php echo 'No Details Available'; ?>
            <?php endif; ?>
            <table>
                <tr>
                    <td width="30%" style="font-size: 10px">Notes :</td>
                    <td width="70%" style="font-size: 10px">
                        <ol>
                            <li>surat jalan ini merupakan bukti resmi penerimaan barang</li>
                            <li>surat jalan ini bukan bukti penjualan</li>
                            <li>surat jalan ini akan dilenkapi sebagai bukti penjualan</li>
                        </ol>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="detail-notes">
        <table width="100%">
            <tr>
                <td class="tengah">Penerima/Customer</td>
                <td class="tengah">Bagian Pengiriman</td>
                <td class="tengah">Petugas Gudang</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="tengah h250"><div class="garisbawah">Penerima/Customer</div></td>
                <td class="tengah h250"><div class="garisbawah">Bagian Pengiriman</div></td>
                <td class="tengah h250"><div class="garisbawah">Petugas Gudang</div></td>
            </tr>
        </table>
    </div>
</div>