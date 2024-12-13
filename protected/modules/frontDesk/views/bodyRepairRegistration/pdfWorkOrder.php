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
        <h4>WORK ORDER</h4>
    </div>

    <div style="text-align: right; font-size: 10px;">
        No WO: <?php echo CHtml::encode(CHtml::value($generalRepairRegistration, 'work_order_number')); ?>
        &nbsp;&nbsp;
        No Nota: <?php echo CHtml::encode(CHtml::value($generalRepairRegistration, 'sales_order_number')); ?>
    </div>

    <div class="supplier">
        <div class="left">
            <table>
                <tr>
                    <td>TANGGAL MASUK</td>
                    <td>:</td>
                    <td><?php echo tanggal($generalRepairRegistration->transaction_date); ?></td>
                </tr>
                <tr>
                    <td>JAM MASUK</td>
                    <td>:</td>
                    <td><?php echo Yii::app()->dateFormatter->formatDateTime($generalRepairRegistration->transaction_date, '', 'short'); ?></td>
                </tr>
                <tr>
                    <td>NAMA CUSTOMER</td>
                    <td>:</td>
                    <td><?php echo $generalRepairRegistration->customer->name; ?></td>
                </tr>
                <tr>
                    <td>ALAMAT</td>
                    <td>:</td>
                    <td><?php echo $generalRepairRegistration->customer->address; ?></td>
                </tr>
                <tr>
                    <td>TELP / HP</td>
                    <td>:</td>
                    <td><?php echo $generalRepairRegistration->customer->phone; ?></td>
                </tr>
            </table>
        </div>
        <div class="right">
            <table>
                <tr>
                    <td>TANGGAL SELESAI</td>
                    <td>:</td>
                    <td><?php //echo $customer->name; ?></td>
                </tr>
                <tr>
                    <td>JAM SELESAI</td>
                    <td>:</td>
                    <td><?php //echo $customer->name; ?></td>
                </tr>
                <tr>
                    <td>TIPE KENDARAAN</td>
                    <td>:</td>
                    <td><?php echo $generalRepairRegistration->vehicle->carModel->name; ?></td>
                </tr>
                <tr>
                    <td>NO. POLISI</td>
                    <td>:</td>
                    <td><?php echo $generalRepairRegistration->vehicle->plateNumberCombination; ?></td>
                </tr>
                <tr>
                    <td>KILOMETER</td>
                    <td>:</td>
                    <td><?php echo $generalRepairRegistration->vehicle_mileage; ?></td>
                </tr>
            </table>
        </div>
    </div>
    
    <div>
        <table style="border: 1px solid; width: 100%; font-size: 0.5em">
            <tr>
                <td>Tahun</td>
                <td style="width: 10px">:</td>
                <td style="border-right: 1px solid"><?php echo $generalRepairRegistration->vehicle->year; ?></td>
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
                <td><?php echo CHtml::image(Yii::app()->baseUrl . '/images/icons/checkbox.png', 'checkbox', array('style' => 'width: 10px')); ?> Cuci</td>
                <td style="border-bottom: 1px solid black;">&nbsp;</td>
            </tr>
        </table>
    </div>
    
    <div class="supplier">
        <div class="left">
            <table style="font-size: 0.5em">
                <tr>
                    <td colspan="9" style="text-decoration: underline">Keterangan Pengerjaan yang Dilakukan</td>
                </tr>
                <tr>
                    <td>A = Ganti (Change)</td>
                    <td>E = Stel (Adjust)</td>
                    <td>H = Bersihkan</td>
                </tr>
                <tr>
                    <td>B = Check</td>
                    <td>F = Charge</td>
                    <td>R = Reparasi</td>
                </tr>
                <tr>
                    <td>C = Isi (Top Up)</td>
                    <td>G = Kencangkan</td>
                    <td>OH = Overhaul</td>
                </tr>
            </table>
        </div>
        <div class="right">
            <table style="font-size: 0.5em">
                <tr>
                    <td>Pelanggan memberikan kuasa untuk melaksanakan pekerjaan yang telah dituliskan dan setujui pada Work Order ini.</td>
                </tr>
                <tr>
                    <td>Pelanggan juga mengijinkan untuk menguji coba kendaraan tersebut diluar wilayah Raperind Motor.</td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="work-order">
        <?php if (count($generalRepairRegistration->registrationServices) > 0): ?>
            <table style="font-size: 10px; border: 1px solid; width: 100%">
                <tr>
                    <th colspan="2" style="border-right: 1px solid; border-bottom: 1px solid">Keterangan / Nama Service / Nama Barang</th>
                    <th class="item" style="border-right: 1px solid; border-bottom: 1px solid">Kode Barang</th>
                    <th class="note" style="border-right: 1px solid; border-bottom: 1px solid">Qty</th>
                    <th class="note" style="border-right: 1px solid; border-bottom: 1px solid">Harga</th>
                    <th class="note" style="border-bottom: 1px solid">Total</th>
                </tr>
                <?php
                $no = 1;
                foreach ($generalRepairRegistration->registrationServices as $i => $service) {
                ?>
                    <tr style="font-size: 10px">
                        <td style="width: 3%; border-right: 1px solid; text-align: center"><?php echo $no; ?></td>
                        <td style="border-right: 1px solid"><?php echo CHtml::encode(CHtml::value($service, 'service.name')); ?></td>
                        <td style="width: 15%; border-right: 1px solid"><?php echo CHtml::encode(CHtml::value($service, 'service.code')); ?></td>
                        <td style="width: 10%; border-right: 1px solid; text-align: center">1</td>
                        <td style="width: 15%; border-right: 1px solid; text-align: right"><?php echo CHtml::encode(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'price')))); ?></td>
                        <td style="width: 15%; text-align: right"><?php echo CHtml::encode(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'total_price')))); ?></td>
                    </tr>
                <?php $no++;
                } ?>
                <?php for ($j = 15, $i = $i % $j + 1; $j > $i; $j--): ?>
                    <tr class="titems">
                        <td style="border-right: 1px solid">&nbsp;</td>
                        <td style="border-right: 1px solid">&nbsp;</td>
                        <td style="border-right: 1px solid">&nbsp;</td>
                        <td style="border-right: 1px solid">&nbsp;</td>
                        <td style="border-right: 1px solid">&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                <?php endfor; ?>
            </table>
        <?php endif; ?>
            
        <br />
            
        <div style="width: 100%">
            <table style="border: 1px solid; font-size: 10px; width: 100%; float: center">
                <tr>
                    <td colspan="3" style="border-bottom: 1px solid; text-align: center">Tanda Tangan</td>
                </tr>
                <tr>
                    <td style="height: 70px; border-right: 1px solid; width: 30%">&nbsp;</td>
                    <td style="border-right: 1px solid; width: 30%">&nbsp;</td>
                    <td style="width: 30%">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align: center; border-right: 1px solid;">(Pemilik Kendaraan)</td>
                    <td style="text-align: center; border-right: 1px solid;">(Front Office)</td>
                    <td style="text-align: center">(Mekanik)</td>
                </tr>
            </table>
        </div>
        
        <br />
        
        <p style="font-size: 10px; text-align: center">1. Raperind Motor tidak bertanggung jawab atas kendaraan yang tidak diambil dalam waktu 30 hari setelah kendaraan selesai</p>
        <p style="font-size: 10px; text-align: center">2. Raperind Motor bertanggung jawab atas keamanan kendaraan yang ditinggal di workshop dengan penggantian sebesar 10x Jasa, kecuali atas kejadian Force Majeure (Pencurian Kendaraan, Kebakaran, dll)</p>
        
    </div>
</div>