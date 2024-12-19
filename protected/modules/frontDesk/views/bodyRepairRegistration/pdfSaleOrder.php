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
        <h4>FORM PERSETUJUAN PARTS</h4>
    </div>

    <div class="body-memo">
        <table>
            <tr>
                <td>RG #</td>
                <td>:</td>
                <td><?php echo $bodyRepairRegistration->transaction_number; ?></td>
                <td>TANGGAL</td>
                <td>:</td>
                <td><?php echo tanggal($bodyRepairRegistration->transaction_date); ?></td>
            </tr>
            <tr>
                <td>WO #</td>
                <td>:</td>
                <td><?php echo $bodyRepairRegistration->work_order_number; ?></td>
                <td>NAMA</td>
                <td>:</td>
                <td><?php echo $customer->name; ?></td>
            </tr>
            <tr>
                <td>JENIS KENDARAAN</td>
                <td>:</td>
                <td>
                    <?php echo $bodyRepairRegistration->vehicle->carMake->name; ?> -
                    <?php echo $bodyRepairRegistration->vehicle->carModel->name; ?> -
                    <?php echo $bodyRepairRegistration->vehicle->carSubModel->name; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
                <td>PHONE</td>
                <td>:</td>
                <td><?php echo $customer->mobile_phone; ?></td>
            </tr>
            <tr>
                <td>NO. POLISI</td>
                <td>:</td>
                <td><?php echo $bodyRepairRegistration->vehicle->plate_number; ?></td>
                <td>ALAMAT</td>
                <td>:</td>
                <td><?php echo nl2br($customer->address); ?></td>
            </tr>
            <tr>
                <td>NO. RANGKA</td>
                <td>:</td>
                <td><?php echo $bodyRepairRegistration->vehicle->frame_number; ?></td>
                <td>KM</td>
                <td>:</td>
                <td><?php echo $bodyRepairRegistration->vehicle_mileage; ?></td>
            </tr>
            <tr>
                <td>PROBLEM</td>
                <td>:</td>
                <td colspan="4"><?php echo CHtml::encode(CHtml::value($bodyRepairRegistration, 'problem')); ?></td>
            </tr>
        </table>
    </div>
    
    <div style="text-align: center">
        <h4>List Parts</h4>
    </div>

    <div class="purchase-order">
        <table>
            <tr style="background-color: skyblue">
                <th style="width: 1%; text-align: center">NO</th>
                <th style="width: 15%">Code</th>
                <th>Item Name</th>
                <th style="width: 15%">Brand Name</th>
                <th style="width: 5%">Qty</th>
                <th style="width: 5%">Unit</th>
            </tr>
            <?php $no = 1;?>
            <?php foreach ($bodyRepairRegistration->registrationProducts as $registrationProduct): ?>
                <tr class="isi">
                    <td class="noo"><?php echo $no; ?></td>
                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($registrationProduct, 'product.manufacturer_code')); ?></td>
                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($registrationProduct, 'product.name')); ?></td>
                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($registrationProduct, 'product.brand.name')); ?></td>
                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($registrationProduct, 'quantity')); ?></td>
                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($registrationProduct, 'product.unit.name')); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    
    <div style="text-align:right; font-size: 10px;">
        <h4>Jakarta, <?php echo tanggal(date('Y-m-d')); ?></h4>
        Yang Menyerahkan,
        <p class="authorized"></p>
    </div>

</div>