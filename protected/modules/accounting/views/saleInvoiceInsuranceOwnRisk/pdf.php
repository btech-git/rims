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

<?php $numberOfCopies = 3; ?>

<?php for ($i = 0; $i < $numberOfCopies; $i++): ?>
        <div class="page" style="<?php if ($i > 0 || $j > 0): ?>page-break-before: always;<?php endif; ?><?php if ($i > 0): ?>background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/copy-text.jpg')<?php else: ?>background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/rap-logo.png')<?php endif; ?>">
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
                    <h4>INVOICE OWN RISK (OR)</h4>
                </div>

                <div class="body-memo">
                    <table>
                        <tr>
                            <td>INVOICE #</td>
                            <td>:</td>
                            <td><?php echo $saleInvoice->transaction_number; ?></td>
                            <td>CUSTOMER</td>
                            <td>:</td>
                            <td><?php echo $customer->name; ?></td>
                        </tr>
                        <tr>
                            <td>TGL INVOICE</td>
                            <td>:</td>
                            <td><?php echo tanggal($saleInvoice->transaction_date); ?></td>
                            <td>NO. POLISI</td>
                            <td>:</td>
                            <td><?php echo $vehicle->plate_number; ?></td>
                        </tr>
                        <tr>
                            <td>ASURANSI</td>
                            <td>:</td>
                            <td><?php echo $saleInvoice->insuranceCompany->name; ?></td>
                            <td>KENDARAAN</td>
                            <td>:</td>
                            <td>
                                <?php echo $vehicle->carMake->name; ?> -
                                <?php echo $vehicle->carModel->name; ?> -
                                <?php echo $vehicle->carSubModel->name; ?>
                            </td>
                        </tr>
                    </table>
                </div>

                <br />
                
                <div class="purchase-order">
                    <table>
                        <tr>
                            <th colspan="7" style="background-color: skyblue;">SUKU CADANG - SPAREPARTS</th>
                        </tr>
                        <tr>
                            <th style="width: 2%">No</th>
                            <th style="font-size: 10px">Code</th>
                            <th style="font-size: 10px">Item Name</th>
                            <th style="font-size: 10px">Brand</th>
                            <th style="font-size: 10px">Category</th>
                            <th style="font-size: 10px">Qty</th>
                            <th style="font-size: 10px">Unit</th>
                        </tr>
                        <?php foreach ($saleInvoice->registrationTransaction->registrationProducts as $i => $detail): ?>
                            <tr class="isi">
                                <td class="noo"><?php echo ++$i; ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                                <td>
                                    <?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name')); ?> -
                                    <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrand.name')); ?> -
                                    <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrandSeries.name')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::encode(CHtml::value($detail, 'product.productMasterCategory.name')); ?> -
                                    <?php echo CHtml::encode(CHtml::value($detail, 'product.productSubMasterCategory.name')); ?> -
                                    <?php echo CHtml::encode(CHtml::value($detail, 'product.productSubCategory.name')); ?>
                                </td>
                                <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'product.unit.name')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

                <br />
                
                <div class="purchase-order">
                    <table>
                        <tr>
                            <th colspan="5" style="background-color: skyblue;">JASA PERBAIKAN - SERVICE</th>
                        </tr>
                        <tr>
                            <th style="width: 2%">No</th>
                            <th style="width: 15%; font-size: 10px">Code</th>
                            <th style="font-size: 10px">Service</th>
                            <th style="font-size: 10px">Type</th>
                            <th style="font-size: 10px">Category</th>
                        </tr>
                        <?php foreach ($saleInvoice->registrationTransaction->registrationServices as $i => $detail): ?>
                            <tr class="isi">
                                <td class="noo"><?php echo ++$i; ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'service.code')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'service.name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'service.serviceType.name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'service.serviceCategory.name')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

                <div>
                    <table style="width: 100%">
                        <tr>
                            <td style="font-size: 11px">Printed by : <?php echo Yii::app()->user->getName(); ?></td>
                            <td style="text-align:right; width: 20%; font-size: 14px; font-weight: bold;">Jumlah Invoice</td>
                            <td style="text-align:right; width: 20%; font-size: 14px; font-weight: bold;">
                                Rp. <?php echo number_format($saleInvoice->amount_invoice, 2, ',', '.') ?>
                            </td>
                        </tr>
                    </table>

                    <div style="font-size: 10px; text-align: left">
                        1. Raperind Motor tidak bertanggung jawab atas kendaraan yang tidak diambil dalam waktu 30 hari setelah kendaraan selesai
                    </div>
                    <div style="font-size: 10px; text-align: left">
                        2. Raperind Motor bertanggung jawab atas keamanan kendaraan yang ditinggal di workshop dengan penggantian sebesar 10x Jasa, 
                        kecuali atas kejadian Force Majeure (Pencurian Kendaraan, Kebakaran, dll)
                    </div>
                    <div style="font-size: 10px; text-align: left">
                        3. Barang yang telah dibeli tidak dapat ditukar atau dikembalikan.
                    </div>
                    <div style="font-size: 10px; text-align: left">
                        4. Jaminan perbaikan satu minggu (300 km) setelah kendaraan diserahkan.
                    </div>
                    <div style="font-size: 10px; text-align: left">
                        5. Kami tidak bertanggung jawab atas barang-barang bekasi yang tidak diambil pada saat penyerahan kendaraan.
                    </div>
                    <div style="font-size: 10px; text-align: left">
                        6. Kami tidak berhubungan dengan pihak ketiga.
                    </div>
                </div>
            </div>
        </div>
<?php endfor; ?>