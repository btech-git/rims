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
            <p style="font-size: 10px">
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
        <h4>FORM ESTIMASI</h4>
    </div>

    <div class="supplier">
        <div class="left">
            <table>
                <tr>
                    <td>TGL PEMERIKSAAN</td>
                    <td>:</td>
                    <td><?php echo tanggal($bodyRepairRegistration->transaction_date); ?></td>
                </tr>
                <tr>
                    <td>JENIS KENDARAAN</td>
                    <td>:</td>
                    <td><?php echo $bodyRepairRegistration->vehicle->carMake->name; ?></td>
                </tr>
                <tr>
                    <td>NO. POLISI</td>
                    <td>:</td>
                    <td><?php echo $bodyRepairRegistration->vehicle->plate_number; ?></td>
                </tr>
                <tr>
                    <td>NO. RANGKA</td>
                    <td>:</td>
                    <td><?php echo $bodyRepairRegistration->vehicle->frame_number; ?></td>
                </tr>
            </table>
        </div>
        <div class="right">
            <table>
                <tr>
                    <td>KM</td>
                    <td>:</td>
                    <td><?php echo $bodyRepairRegistration->vehicle_mileage; ?></td>
                </tr>
                <tr>
                    <td>NAMA</td>
                    <td>:</td>
                    <td><?php echo $customer->name; ?></td>
                </tr>
                <tr>
                    <td>PHONE</td>
                    <td>:</td>
                    <td><?php echo $customer->mobile_phone; ?></td>
                </tr>
                <tr>
                    <td>ALAMAT</td>
                    <td>:</td>
                    <td><?php echo $customer->address; ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="center">PROBLEM: <?php echo CHtml::encode(CHtml::value($generalRepairRegistration, 'problem')); ?></div>

    <div class="purchase-order">
        <?php if (count($bodyRepairRegistration->registrationProducts) > 0): ?>
            <table>
                <tr style="background-color: skyblue">
                    <th colspan="7">SUKU CADANG - SPAREPARTS</th>
                </tr>
                <tr>
                    <th class="no">NO</th>
                    <th class="item">DESKRIPSI</th>
                    <th class="no">Qty</th>
                    <th class="price">HARGA SATUAN</th>
                    <th class="price">JUMLAH</th>
                    <th class="no">PPN</th>
                    <th class="price">Total</th>
                </tr>
                <?php
                $no = 1;
                foreach ($bodyRepairRegistration->registrationProducts as $product) {
                ?>
                    <tr class="isi">
                        <td class="noo"><?php echo $no ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'product.name')); ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'quantity')); ?></td>
                        <td>&nbsp;  Rp. <?php echo number_format($product->sale_price, 2, ',', '.'); ?></td>
                        <td>&nbsp;  Rp. <?php echo number_format($product->total_price, 2, ',', '.'); ?></td>
                        <td>&nbsp; <?php echo $bodyRepairRegistration->ppnLiteral; ?></td>
                        <td>&nbsp;  Rp. <?php echo number_format($product->totalPriceAfterTax, 2, ',', '.'); ?></td>
                    </tr>
                    <?php $no++;
                } ?>
                <tr>
                    <td colspan="5" style="font-weight: bold; text-align: right">TOTAL SUKU CADANG</td>
                    <td colspan="2" style="font-weight: bold; text-align: right">&nbsp;  Rp. <?php echo number_format($bodyRepairRegistration->subtotal_product, 2, ',', '.'); ?></td>
                </tr>
            </table>
            <br />
        <?php endif; ?>
        <?php if (count($bodyRepairRegistration->registrationQuickServices) > 0 || count($bodyRepairRegistration->registrationServices) > 0): ?>
            <table>
                <tr style="background-color: skyblue">
                    <th colspan="5">JASA PERBAIKAN - SERVICE</th>
                </tr>
                <tr>
                    <th class="no">NO</th>
                    <th class="item">DESKRIPSI</th>
                    <th class="price">JUMLAH</th>
                    <th class="no">PPN</th>
                    <th class="price">TOTAL</th>
                </tr>
                <?php $no = 1;?>
                <?php if (count($bodyRepairRegistration->registrationQuickServices) > 0): ?>
                    <?php foreach ($bodyRepairRegistration->registrationQuickServices as $quickService): ?>
                        <tr class="isi">
                            <td class="noo"><?php echo $no ?></td>
                            <td>&nbsp; <?php echo CHtml::encode(CHtml::value($quickService, 'quickService.name')); ?></td>
                            <td>&nbsp;  Rp. <?php echo number_format($quickService->price, 2, ',', '.') ?></td>
                            <td>&nbsp; <?php echo $bodyRepairRegistration->ppnLiteral; ?></td>
                            <td>&nbsp;  Rp. <?php echo number_format($quickService->total_price, 2, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if (count($bodyRepairRegistration->registrationServices) > 0): ?>
                    <?php foreach ($bodyRepairRegistration->registrationServices as $service): ?>
                        <tr class="isi">
                            <td class="noo"><?php echo $no ?></td>
                            <td>&nbsp; <?php echo CHtml::encode(CHtml::value($service, 'service.name')); ?></td>
                            <td>&nbsp; Rp. <?php echo number_format($service->price, 2, ',', '.') ?></td>
                            <td>&nbsp; <?php echo $bodyRepairRegistration->ppnLiteral; ?></td>
                            <td>&nbsp; Rp. <?php echo number_format($service->total_price, 2, ',', '.') ?></td>
                        </tr>
                        <?php $no++; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <tr>
                    <td colspan="4" style="font-weight: bold; text-align: right">TOTAL JASA PERBAIKAN</td>
                    <td style="font-weight: bold; text-align: right">&nbsp;  Rp. <?php echo number_format($bodyRepairRegistration->subtotal_service, 2, ',', '.'); ?></td>
                </tr>
            </table>
            <br />
        <?php endif; ?>
        <table>
            <tr>
                <td style="width: 45%; text-align: center">Yang membuat,</td>
                <td>SUBTOTAL</td>
                <td style="text-align:right">Rp. <?php echo number_format($bodyRepairRegistration->subtotal, 2, ',', '.') ?> &nbsp; </td>
            </tr>
            <tr>
                <td rowspan="2"></td>
                <td>PPN - 10%</td>
                <td style="text-align:right">Rp. <?php echo number_format($bodyRepairRegistration->ppn_price, 2, ',', '.') ?> &nbsp; </td>
            </tr>
            <tr>
                <td>PPH 23 - 2%</td>
                <td style="text-align:right">Rp. <?php echo number_format($bodyRepairRegistration->pph_price, 2, ',', '.') ?> &nbsp; </td>
            </tr>
            <tr>
                <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($bodyRepairRegistration, 'user.username')); ?></td>
                <td style="font-weight: bold">GRAND TOTAL</td>
                <td style="font-weight: bold; text-align:right">Rp. <?php echo number_format($bodyRepairRegistration->grand_total, 2, ',', '.') ?> &nbsp; </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center">* Note: Jasa Perbaikan & Suku Cadang diluar Estimasi, akan diinformasikan lebih lanjut</td>
            </tr>
        </table>
    </div>
</div>