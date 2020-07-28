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
        <div style="float: left; width: 45%">
            <img src="/images/logo.png" alt="">
            <table>
                <tr>
                    <td>
                        <p class="rapad">
                            JL. Kalimalang, No. 8, Kampung Dua,<br />
                            Bekasi City, West Java. <br />
                            Tlp. (021) 8843656
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <div style="float: right; width: 45%">
            <h3>WORK ORDER</h3>
            <table>
                <tr>
                    <td>Date</td>
                    <td>:</td>
                    <td><?php echo tanggal($generalRepairRegistration->transaction_date); ?></td>
                </tr>
                <tr>
                    <td>Work Order #</td>
                    <td>:</td>
                    <td><?php echo $generalRepairRegistration->work_order_number; ?></td>
                </tr>
                <tr>
                    <td>Repair Type</td>
                    <td>:</td>
                    <td><?php echo $generalRepairRegistration->repair_type; ?></td>
                </tr>
                <tr>
                    <td>Branch</td>
                    <td>:</td>
                    <td><?php echo $generalRepairRegistration->branch->name; ?></td>
                </tr>
                <tr>
                    <td>Mileage (KM)</td>
                    <td>:</td>
                    <td><?php echo $generalRepairRegistration->vehicle_mileage; ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="supplier">
        <div class="left">
            <table>
                <tr>
                    <td>Customer</td>
                    <td>:</td>
                    <td><?php echo $customer->name; ?></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td><?php echo $customer->address; ?></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td><?php echo $customer->customer_type; ?></td>
                </tr>
            </table>
        </div>
        <div class="right">
            <table>
                <tr>
                    <td>Vehicle</td>
                    <td>:</td>
                    <td><?php echo $vehicle->plate_number; ?></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td><?php echo $vehicle->machine_number; ?></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>
                        <?php echo $vehicle->carMake->name; ?> -
                        <?php echo $vehicle->carModel->name; ?> - 
                        <?php echo $vehicle->carSubModel->name; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="purchase-order">
        <?php if (count($generalRepairRegistration->registrationQuickServices) > 0): ?>
            <table>
                <tr>
                    <th class="no">No</th>
                    <th style="width: 90%">Quick Service</th>
                </tr>
                <?php
                $no = 1;
                foreach ($generalRepairRegistration->registrationQuickServices as $quickService) {
                    ?>
                    <tr class="isi">
                        <td class="noo"><?php echo $no ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($quickService, 'quickService.name')); ?></td>
                    </tr>
                    <?php $no++;
                } ?>
            </table>
            <br />
        <?php endif; ?>
        <?php if (count($generalRepairRegistration->registrationServices) > 0): ?>
            <table>
                <tr>
                    <th class="no">No</th>
                    <th class="item" style="width: 75%">Service</th>
                    <th class="qty">Claim</th>
                </tr>
                <?php
                $no = 1;
                foreach ($generalRepairRegistration->registrationServices as $service) {
                    ?>
                    <tr class="isi">
                        <td class="noo"><?php echo $no ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($service, 'service.name')); ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($service, 'claim')); ?></td>
                    </tr>
                <?php $no++;
            } ?>
            </table>
            <br />
        <?php endif; ?>
        <?php if (count($generalRepairRegistration->registrationProducts) > 0): ?>
            <table>
                <tr>
                    <th class="no">No</th>
                    <th class="item" style="width: 75%">Product</th>
                    <th class="no">Qty</th>
                    <th class="no">Unit</th>
                </tr>
                <?php
                $no = 1;
                foreach ($generalRepairRegistration->registrationProducts as $product) {
                ?>
                    <tr class="isi">
                        <td class="noo"><?php echo $no ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'product.name')); ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'quantity')); ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'product.unit.name')); ?></td>
                    </tr>
                <?php $no++;
                } ?>
            </table>
            <br />
        <?php endif; ?>
        <p class="authorized"><?php echo tanggal(date('Y-m-d')); ?></p>
    </div>
</div>