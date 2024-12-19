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
        <h4>FORM PERMINTAAN SERVICE - CONTRACT SERVICE</h4>
    </div>

    <div class="body-memo">
        <table>
            <tr>
                <td>WO #</td>
                <td>:</td>
                <td><?php echo $generalRepairRegistration->work_order_number; ?></td>
                <td>TANGGAL</td>
                <td>:</td>
                <td><?php echo tanggal($generalRepairRegistration->transaction_date); ?></td>
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
                <td><?php echo CHtml::encode(CHtml::value($generalRepairRegistration, 'problem')); ?></td>
                <td>KM</td>
                <td>:</td>
                <td><?php echo $generalRepairRegistration->vehicle_mileage; ?></td>
            </tr>
        </table>
    </div>
    
    <div style="text-align: center">
        <h4>List Permohonan Service</h4>
    </div>

    <div class="purchase-order">
        <table>
            <tr style="background-color: skyblue">
                <th style="width: 1%; text-align: center">NO</th>
                <th>JENIS PEKERJAAN</th>
            </tr>
            <?php $no = 1;?>
            <?php if (count($generalRepairRegistration->registrationQuickServices) > 0): ?>
                <?php foreach ($generalRepairRegistration->registrationQuickServices as $quickService): ?>
                    <tr class="isi">
                        <td class="noo"><?php echo $no; ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($quickService, 'quickService.name')); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (count($generalRepairRegistration->registrationServices) > 0): ?>
                <?php foreach ($generalRepairRegistration->registrationServices as $service): ?>
                    <tr class="isi">
                        <td class="noo"><?php echo $no ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($service, 'service.name')); ?></td>
                    </tr>
                    <?php $no++; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
    
    <div style="text-align:right; font-size: 10px;">
        <h4>Jakarta, <?php echo tanggal(date('Y-m-d')); ?></h4>
        Yang Menyerahkan,
        <p class="authorized"></p>
    </div>

</div>