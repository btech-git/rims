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
        <div style="float: left; width: 30%; text-align: left">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/rap-logo.png" alt="" style="width: 64px; height: 64px"/>
        </div>
        <div style="float: right; width: 30%">
            <div>
                Jl. Raya Jati Asih/Jati Kramat - 84993984/77 Fax. 84993989 <br />
                Jl. Raya Kalimalang No. 8, Kp. Dua - 8843656 Fax. 88966753<br />
                Jl. Raya Kalimalang Q/2D - 8643594/95 Fax. 8645008
            </div>
        </div>
        <div style="float: right; width: 30%">
            <div>
                Jl. Raya Radin Inten II No. 9 - 8629545/46 Fax. 8627313<br />
                Jl. Celebration Boulevard Blok AA 9/35 - 8261594<br />
                Email info@raperind.com
            </div>
        </div>
    </div>
    
    <div style="text-align: center">
        <h4>SURAT JALAN</h4>
    </div>

    <div class="body-memo">
        <table style="font-size: 10px">
            <tr>
                <td>SJ #</td>
                <td style="width: 5%">:</td>
                <td><?php echo CHtml::encode(CHtml::value($do, 'delivery_order_no')); ?></td>
                <?php if (!empty($do->sent_request_id)): ?>
                    <td>Sent Request #</td>
                    <td style="width: 5%">:</td>
                    <td><?php echo CHtml::encode(CHtml::value($do, 'sentRequest.sent_request_no')); ?></td>
                <?php elseif (!empty($do->transfer_request_id)): ?>
                    <td>Transfer Request #</td>
                    <td style="width: 5%">:</td>
                    <td><?php echo CHtml::encode(CHtml::value($do, 'transferRequest.transfer_request_no')); ?></td>
                <?php endif; ?>
            </tr>
            <tr>
                <td>Tanggal Kirim</td>
                <td style="width: 5%">:</td>
                <td><?php echo tanggal(CHtml::encode(CHtml::value($do, 'delivery_date'))); ?></td>
                <?php if (!empty($do->sent_request_id)): ?>
                    <td>Tanggal Request</td>
                    <td style="width: 5%">:</td>
                    <td><?php echo tanggal(CHtml::encode(CHtml::value($do, 'sentRequest.sent_request_date'))); ?></td>
                <?php elseif (!empty($do->transfer_request_id)): ?>
                    <td>Tanggal Request</td>
                    <td style="width: 5%">:</td>
                    <td><?php echo tanggal(CHtml::encode(CHtml::value($do, 'transferRequest.transfer_request_date'))); ?></td>
                <?php endif; ?>
            </tr>
            <tr>
                <td>Tujuan</td>
                <td style="width: 5%">:</td>
                <td><?php echo CHtml::encode(CHtml::value($do, 'destinationBranch.code')); ?></td>
                <td>ETA</td>
                <td style="width: 5%">:</td>
                <td><?php echo tanggal(CHtml::encode(CHtml::value($do, 'estimate_arrival_date'))); ?></td>
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
                            <th style="width: 1%">No</th>
                            <th width="10%">Code</th>
                            <th>Item Name</th>
                            <th width="15%">Brand Name</th>
                            <th width="8%">Qty</th>
                            <th width="6%">Unit</th>
                            <th width="30%">Notes</th>
                        </tr>
                    </thead>
                    <?php $no = 1; ?>
                    <tbody style="height: 100px;">
                        <?php foreach ($do->transactionDeliveryOrderDetails as $key => $deliveryDetail): ?>
                            <tr>
                                <td class="noo"><?php echo $no; ?></td>
                                <td>&nbsp; <?php echo CHtml::encode(CHtml::value($deliveryDetail, 'product.manufacturer_code')); ?></td>
                                <td>&nbsp; <?php echo CHtml::encode(CHtml::value($deliveryDetail, 'product.name')); ?></td>
                                <td>&nbsp; <?php echo CHtml::encode(CHtml::value($deliveryDetail, 'product.brand.name')); ?></td>
                                <td>&nbsp; <?php echo CHtml::encode(CHtml::value($deliveryDetail, 'quantity_request')); ?></td>
                                <td>&nbsp; <?php echo CHtml::encode(CHtml::value($deliveryDetail, 'product.unit.name')); ?></td>
                                <td><?php echo $deliveryDetail->note== ''?'-':$deliveryDetail->note; ?></td>
                            </tr>
                            <?php $no++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>    
            <?php else: ?>
                <?php echo 'No Details Available'; ?>
            <?php endif; ?>
            <table>
                <tr>
                    <td width="50%" style="font-size: 10px">Notes :</td>
                    <td width="50%" style="font-size: 10px">
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