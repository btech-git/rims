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
        <h4>WORK ORDER</h4>
    </div>

    <div class="body-memo">
        <table>
            <tr>
                <td>WO #</td>
                <td>:</td>
                <td><?php echo CHtml::encode(CHtml::value($generalRepairRegistration, 'work_order_number')); ?></td>
                <td>RG #</td>
                <td>:</td>
                <td><?php echo CHtml::encode(CHtml::value($generalRepairRegistration, 'transaction_number')); ?></td>
            </tr>
            <tr>
                <td>TANGGAL MASUK</td>
                <td>:</td>
                <td><?php echo tanggal($generalRepairRegistration->transaction_date) . ' ' . Yii::app()->dateFormatter->formatDateTime($generalRepairRegistration->transaction_date, '', 'short'); ?></td>
                <td>TANGGAL SELESAI</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td>NAMA CUSTOMER</td>
                <td>:</td>
                <td><?php echo $generalRepairRegistration->customer->name; ?></td>
                <td>TIPE KENDARAAN</td>
                <td>:</td>
                <td>
                    <?php echo $generalRepairRegistration->vehicle->carMake->name; ?> -
                    <?php echo $generalRepairRegistration->vehicle->carModel->name; ?> -
                    <?php echo $generalRepairRegistration->vehicle->carSubModel->name; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
            <tr>
                <td>ALAMAT</td>
                <td>:</td>
                <td><?php echo $generalRepairRegistration->customer->address; ?></td>
                <td>NO. POLISI</td>
                <td>:</td>
                <td><?php echo $generalRepairRegistration->vehicle->plateNumberCombination; ?></td>
            </tr>
            <tr>
                <td>TELP / HP</td>
                <td>:</td>
                <td><?php echo $generalRepairRegistration->customer->phone; ?></td>
                <td>KILOMETER</td>
                <td>:</td>
                <td><?php echo $generalRepairRegistration->vehicle_mileage; ?></td>
            </tr>
            <tr>
                <td>Problem</td>
                <td>:</td>
                <td colspan="4"><?php echo $generalRepairRegistration->problem; ?></td>
            </tr>
        </table>
    </div>
    
<!--    <div>
        <table style="border: 1px solid; width: 100%; font-size: 0.5em">
            <tr>
                <td>Tahun</td>
                <td style="width: 10px">:</td>
                <td style="border-right: 1px solid"><?php /*echo $generalRepairRegistration->vehicle->year; ?></td>
                <td><?php echo CHtml::image(Yii::app()->baseUrl . '/images/icons/checkbox.png', 'checkbox', array('style' => 'width: 10px')); ?> Oli Mesin</td>
                <td style="width: 80px; border-bottom: 1px solid black;">&nbsp;</td>
                <td><?php echo CHtml::image(Yii::app()->baseUrl . '/images/icons/checkbox.png', 'checkbox', array('style' => 'width: 10px')); ?> Balancing</td>
                <td style="width: 80px; border-bottom: 1px solid black;">&nbsp;</td>
                <td><?php echo CHtml::image(Yii::app()->baseUrl . '/images/icons/checkbox.png', 'checkbox', array('style' => 'width: 10px')); ?> AC</td>
                <td style="width: 80px; border-bottom: 1px solid black;">&nbsp;</td>
            </tr>
            <tr>
                <td>No. Mesin</td>
                <td>:</td>
                <td style="border-right: 1px solid"><?php echo $generalRepairRegistration->vehicle->machine_number; ?></td>
                <td><?php echo CHtml::image(Yii::app()->baseUrl . '/images/icons/checkbox.png', 'checkbox', array('style' => 'width: 10px')); ?> Oli Gardan</td>
                <td style="border-bottom: 1px solid black;">&nbsp;</td>
                <td><?php echo CHtml::image(Yii::app()->baseUrl . '/images/icons/checkbox.png', 'checkbox', array('style' => 'width: 10px')); ?> Spooring</td>
                <td style="border-bottom: 1px solid black;">&nbsp;</td>
                <td><?php echo CHtml::image(Yii::app()->baseUrl . '/images/icons/checkbox.png', 'checkbox', array('style' => 'width: 10px')); ?> Freon</td>
                <td style="border-bottom: 1px solid black;">&nbsp;</td>
            </tr>
            <tr>
                <td>No. Rangka</td>
                <td>:</td>
                <td style="border-right: 1px solid"><?php echo $generalRepairRegistration->vehicle->frame_number; ?></td>
                <td><?php echo CHtml::image(Yii::app()->baseUrl . '/images/icons/checkbox.png', 'checkbox', array('style' => 'width: 10px')); ?> Oli Transmisi</td>
                <td style="border-bottom: 1px solid black;">&nbsp;</td>
                <td><?php echo CHtml::image(Yii::app()->baseUrl . '/images/icons/checkbox.png', 'checkbox', array('style' => 'width: 10px')); ?> Tune Up</td>
                <td style="border-bottom: 1px solid black;">&nbsp;</td>
                <td><?php echo CHtml::image(Yii::app()->baseUrl . '/images/icons/checkbox.png', 'checkbox', array('style' => 'width: 10px')); ?> Checking</td>
                <td style="border-bottom: 1px solid black;">&nbsp;</td>
            </tr>
            <tr>
                <td>Warna</td>
                <td>:</td>
                <td style="border-right: 1px solid"><?php echo $generalRepairRegistration->vehicle->color->name; ?></td>
                <td><?php echo CHtml::image(Yii::app()->baseUrl . '/images/icons/checkbox.png', 'checkbox', array('style' => 'width: 10px')); ?> Minyak Rem</td>
                <td style="border-bottom: 1px solid black;">&nbsp;</td>
                <td><?php echo CHtml::image(Yii::app()->baseUrl . '/images/icons/checkbox.png', 'checkbox', array('style' => 'width: 10px')); ?> Carbon Clean</td>
                <td style="border-bottom: 1px solid black;">&nbsp;</td>
                <td><?php echo CHtml::image(Yii::app()->baseUrl . '/images/icons/checkbox.png', 'checkbox', array('style' => 'width: 10px'));*/ ?> Cuci</td>
                <td style="border-bottom: 1px solid black;">&nbsp;</td>
            </tr>
        </table>
    </div>
    
    <div class="body-memo">
        <table style="font-size: 0.5em">
            <tr>
                <td colspan="4" style="text-decoration: underline">Keterangan Pengerjaan yang Dilakukan</td>
            </tr>
            <tr>
                <td style="width: 15%">A = Ganti (Change)</td>
                <td style="width: 15%">E = Stel (Adjust)</td>
                <td style="width: 15%">H = Bersihkan</td>
                <td>Pelanggan memberikan kuasa untuk melaksanakan pekerjaan yang telah dituliskan dan setujui pada Work Order ini.</td>
            </tr>
            <tr>
                <td>B = Check</td>
                <td>F = Charge</td>
                <td>R = Reparasi</td>
                <td>Pelanggan juga mengijinkan untuk menguji coba kendaraan tersebut diluar wilayah Raperind Motor.</td>
            </tr>
            <tr>
                <td>C = Isi (Top Up)</td>
                <td>G = Kencangkan</td>
                <td>OH = Overhaul</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>-->
    
    <?php if (count($generalRepairRegistration->registrationProducts) > 0): ?>
        <div class="purchase-order">
            <table>
                <tr style="background-color: skyblue">
                    <th colspan="6">SUKU CADANG - SPAREPARTS</th>
                </tr>
                <tr>
                    <th style="width: 1%">No</th>
                    <th style="width: 15%">Code</th>
                    <th>Item Name</th>
                    <th style="width: 20%">Brand Name</th>
                    <th style="width: 5%">Qty</th>
                    <th style="width: 5%">Unit</th>
                </tr>
                <?php
                $no = 1;
                foreach ($generalRepairRegistration->registrationProducts as $product) {
                ?>
                    <tr class="isi">
                        <td class="noo"><?php echo $no; ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'product.manufacturer_code')); ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'product.name')); ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'product.brand.name')); ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'quantity')); ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'product.unit.name')); ?></td>
                    </tr>
                    <?php $no++;
                } ?>
            </table>
        </div>
    <?php endif; ?>
                
    <?php if (count($generalRepairRegistration->registrationQuickServices) > 0 || count($generalRepairRegistration->registrationServices) > 0): ?>
        <div class="purchase-order">
            <table>
                <tr style="background-color: skyblue">
                    <th colspan="2">JASA PERBAIKAN - SERVICE</th>
                </tr>
                <tr>
                    <th style="width: 1%">No</th>
                    <th>Service</th>
                </tr>
                <?php $no = 1;?>
                <?php foreach ($generalRepairRegistration->registrationQuickServices as $quickService): ?>
                    <tr class="isi">
                        <td class="noo"><?php echo $no; ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($quickService, 'quickService.name')); ?></td>
                    </tr>
                    <?php $no++; ?>
                <?php endforeach; ?>
                <?php foreach ($generalRepairRegistration->registrationServices as $service): ?>
                    <tr class="isi">
                        <td class="noo"><?php echo $no; ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($service, 'service.name')); ?></td>
                    </tr>
                    <?php $no++; ?>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>
            
    <br />

    <div style="width: 100%">
        <table style="border: 1px solid; font-size: 10px; width: 100%; float: center">
            <tr>
                <td colspan="2" style="border-bottom: 1px solid; text-align: center">Tanda Tangan</td>
            </tr>
            <tr>
                <td style="height: 70px; border-right: 1px solid; width: 30%">&nbsp;</td>
                <td style="width: 30%">&nbsp;</td>
            </tr>
            <tr>
                <td style="text-align: center; border-right: 1px solid;">(Front Office)</td>
                <td style="text-align: center">(Mekanik)</td>
            </tr>
        </table>
    </div>

    <br />

    <div style="font-size: 10px; text-align: left">1. Raperind Motor tidak bertanggung jawab atas kendaraan yang tidak diambil dalam waktu 30 hari setelah kendaraan selesai</div>
    <div style="font-size: 10px; text-align: left">2. Raperind Motor bertanggung jawab atas keamanan kendaraan yang ditinggal di workshop dengan penggantian sebesar 10x Jasa, kecuali atas kejadian Force Majeure (Pencurian Kendaraan, Kebakaran, dll)</div>
</div>