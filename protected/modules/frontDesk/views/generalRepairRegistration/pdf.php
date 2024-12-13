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
        <h4>FORM ESTIMASI</h4>
    </div>

    <div class="body-memo">
        <table>
            <tr>
                <td>TGL PEMERIKSAAN</td>
                <td>:</td>
                <td><?php echo tanggal($generalRepairRegistration->transaction_date); ?></td>
                <td>KM</td>
                <td>:</td>
                <td><?php echo $generalRepairRegistration->vehicle_mileage; ?></td>
            </tr>
            <tr>
                <td>JENIS KENDARAAN</td>
                <td>:</td>
                <td>
                    <?php echo $generalRepairRegistration->vehicle->carMake->name; ?> -
                    <?php echo $generalRepairRegistration->vehicle->carModel->name; ?> -
                    <?php echo $generalRepairRegistration->vehicle->carSubModel->name; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
                <td>NAMA</td>
                <td>:</td>
                <td><?php echo $customer->name; ?></td>
            </tr>
            <tr>
                <td>NO. POLISI</td>
                <td>:</td>
                <td><?php echo $generalRepairRegistration->vehicle->plate_number; ?></td>
                <td>PHONE</td>
                <td>:</td>
                <td><?php echo $customer->mobile_phone; ?></td>
            </tr>
            <tr>
                <td>NO. RANGKA</td>
                <td>:</td>
                <td><?php echo $generalRepairRegistration->vehicle->frame_number; ?></td>
                <td>ALAMAT</td>
                <td>:</td>
                <td><?php echo nl2br($customer->address); ?></td>
            </tr>
            <tr>
                <td>PROBLEM</td>
                <td>:</td>
                <td colspan="4"><?php echo CHtml::encode(CHtml::value($generalRepairRegistration, 'problem')); ?></td>
            </tr>
        </table>
    </div>
    
    <hr />
    
    <?php if (count($generalRepairRegistration->registrationProducts) > 0): ?>
        <div class="purchase-order">
            <table>
                <tr style="background-color: skyblue; font-size: 12px;">
                    <th colspan="7">SUKU CADANG - SPAREPARTS</th>
                </tr>
                <tr style="font-size: 12px;">
                    <th class="no">NO</th>
                    <th class="item">DESKRIPSI</th>
                    <th class="no">Qty</th>
                    <th class="price">HARGA SATUAN</th>
                    <th class="price">JUMLAH</th>
                    <th class="no">PPN</th>
                    <th class="price">TOTAL</th>
                </tr>
                <?php
                $no = 1;
                foreach ($generalRepairRegistration->registrationProducts as $product) {
                ?>
                    <tr class="isi" style="font-size: 10px;">
                        <td class="noo"><?php echo $no; ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'product.name')); ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'quantity')); ?></td>
                        <td style="text-align: right">&nbsp;  Rp. <?php echo number_format($product->sale_price, 2, ',', '.'); ?></td>
                        <td style="text-align: right">&nbsp;  Rp. <?php echo number_format($product->total_price, 2, ',', '.'); ?></td>
                        <td style="text-align: center">&nbsp; <?php echo $generalRepairRegistration->ppnLiteral; ?></td>
                        <td style="text-align: right">&nbsp;  Rp. <?php echo number_format($product->totalPriceAfterTax, 2, ',', '.'); ?></td>
                    </tr>
                    <?php $no++;
                } ?>
                <tr style="font-size: 10px;">
                    <td colspan="5" style="font-weight: bold; text-align: right">TOTAL SUKU CADANG</td>
                    <td colspan="2" style="font-weight: bold; text-align: right">
                        &nbsp;  Rp. <?php echo number_format($generalRepairRegistration->subtotal_product, 2, ',', '.'); ?>
                    </td>
                </tr>
            </table>
        </div>
    <?php endif; ?>
    
    <?php if (count($generalRepairRegistration->registrationQuickServices) > 0 || count($generalRepairRegistration->registrationServices) > 0): ?>
        <div class="purchase-order">
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
                <?php foreach ($generalRepairRegistration->registrationQuickServices as $quickService): ?>
                    <tr class="isi">
                        <td class="noo"><?php echo $no; ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($quickService, 'quickService.name')); ?></td>
                        <td style="text-align: right">&nbsp;  Rp. <?php echo number_format($quickService->price, 2, ',', '.') ?></td>
                        <td style="text-align: center">&nbsp; <?php echo $generalRepairRegistration->ppnLiteral; ?></td>
                        <td style="text-align: right">&nbsp;  Rp. <?php echo number_format($quickService->total_price, 2, ',', '.') ?></td>
                    </tr>
                    <?php $no++; ?>
                <?php endforeach; ?>
                <?php foreach ($generalRepairRegistration->registrationServices as $service): ?>
                    <tr class="isi">
                        <td class="noo"><?php echo $no; ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($service, 'service.name')); ?></td>
                        <td style="text-align: right">&nbsp; Rp. <?php echo number_format($service->price, 2, ',', '.') ?></td>
                        <td style="text-align: center">&nbsp; <?php echo $generalRepairRegistration->ppnLiteral; ?></td>
                        <td style="text-align: right">&nbsp; Rp. <?php echo number_format($service->total_price, 2, ',', '.') ?></td>
                    </tr>
                    <?php $no++; ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" style="font-weight: bold; text-align: right">TOTAL JASA PERBAIKAN</td>
                    <td colspan="2" style="font-weight: bold; text-align: right">
                        &nbsp;  Rp. <?php echo number_format($generalRepairRegistration->subtotal_service, 2, ',', '.'); ?>
                    </td>
                </tr>
            </table>
        </div>
    <?php endif; ?>
    <div class="purchase-order">
        <table>
            <tr>
                <td style="width: 45%; text-align: center">Yang membuat,</td>
                <td>SUBTOTAL</td>
                <td style="text-align:right">Rp. <?php echo number_format($generalRepairRegistration->subtotal, 2, ',', '.') ?> &nbsp; </td>
            </tr>
            
            <tr>
                <?php //if ($generalRepairRegistration->ppn_price > 0.00): ?>
                    <td style="border-bottom: none">&nbsp;</td>
                    <td>PPN - <?php echo CHtml::encode(CHtml::value($generalRepairRegistration, 'tax_percentage')); ?>%</td>
                    <td style="text-align:right">Rp. <?php echo number_format($generalRepairRegistration->ppn_price, 2, ',', '.') ?> &nbsp; </td>
                <?php /*else: ?>
                    <td style="border-right: 1px solid; border-bottom: none">&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                <?php endif;*/ ?>
            </tr>
                
            <tr>
                <?php //if ($generalRepairRegistration->pph_price > 0.00): ?>
                    <td style="border-top: none">&nbsp;</td>
                    <td>PPH 23</td>
                    <td style="text-align:right">Rp. <?php echo number_format($generalRepairRegistration->pph_price, 2, ',', '.') ?> &nbsp; </td>
                <?php /*else: ?>
                    <td style="border-right: 1px solid">&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                <?php endif;*/ ?>
            </tr>
                
            <tr>
                <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($generalRepairRegistration, 'user.username')); ?></td>
                <td style="font-weight: bold">GRAND TOTAL</td>
                <td style="font-weight: bold; text-align:right">Rp. <?php echo number_format($generalRepairRegistration->grand_total, 2, ',', '.') ?> &nbsp; </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center">* Note: Jasa Perbaikan & Suku Cadang diluar Estimasi, akan diinformasikan lebih lanjut</td>
            </tr>
        </table>
    </div>
</div>