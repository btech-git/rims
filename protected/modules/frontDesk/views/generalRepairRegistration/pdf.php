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
<?php $numberOfPages = 3; ?>
<?php for ($i = 0; $i < $numberOfPages; $i++): ?>
    <div <?php if ($i > 0): ?>style=" page-break-before: always"<?php endif; ?>>
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
                <h4>FORM ESTIMASI<?php if ($i > 0): ?><span style="color: red"> - COPY</span><?php endif; ?></h4>
            </div>

            <div class="body-memo">
                <table>
                    <tr>
                        <td>ESTIMASI #</td>
                        <td>:</td>
                        <td><?php echo $generalRepairRegistration->transaction_number; ?></td>
                        <td>TANGGAL</td>
                        <td>:</td>
                        <td><?php echo tanggal($generalRepairRegistration->transaction_date) . ' ' . Yii::app()->dateFormatter->formatDateTime($generalRepairRegistration->transaction_date, '', 'short'); ?></td>
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

            <?php if (count($generalRepairRegistration->registrationProducts) > 0): ?>
                <div class="purchase-order">
                    <table>
                        <tr style="background-color: skyblue">
                            <th colspan="10">SUKU CADANG - SPAREPARTS</th>
                        </tr>
                        <tr>
                            <th style="width: 1%">No</th>
                            <th>Code</th>
                            <th>Item Name</th>
                            <th>Brand Name</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th style="width: 10%">Price</th>
                            <th style="width: 10%">Disc</th>
                            <th style="width: 10%">After Disc</th>
                            <th style="width: 10%">Sub Total</th>
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
                                <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($product->sale_price, 2, ',', '.'); ?></td>
                                <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($product->discountAmount, 2, ',', '.'); ?></td>
                                <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($product->totalAmountProduct, 2, ',', '.'); ?></td>
                                <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($product->total_price, 2, ',', '.'); ?></td>
                            </tr>
                            <?php $no++;
                        } ?>
                        <tr>
                            <td colspan="8" style="font-weight: bold; text-align: right;">TOTAL SUKU CADANG</td>
                            <td colspan="2" style="font-weight: bold; text-align: right;">
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
                            <th style="width: 1%">No</th>
                            <th>Service</th>
                            <th style="width: 10%">Price</th>
                            <th style="width: 10%">Disc</th>
                            <th style="width: 10%">Sub Total</th>
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
                                <td style="text-align: center">&nbsp; <?php echo $service->discount_price; ?></td>
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
            <div>
                <table style="width: 100%">
                    <tr>
                        <td style="text-align:right; font-size: 11px">TOTAL PRODUCT & SERVICE</td>
                        <td style="width: 25%; text-align:right; font-size: 11px">Rp. <?php echo number_format($generalRepairRegistration->subtotal, 2, ',', '.') ?> &nbsp; </td>
                    </tr>

                    <tr>
                        <?php if ($generalRepairRegistration->ppn_price > 0.00): ?>
                            <td style="text-align:right; font-size: 11px">PPN - <?php echo CHtml::encode(CHtml::value($generalRepairRegistration, 'tax_percentage')); ?>%</td>
                            <td style="text-align:right; font-size: 11px">Rp. <?php echo number_format($generalRepairRegistration->ppn_price, 2, ',', '.') ?> &nbsp; </td>
                        <?php endif; ?>
                    </tr>

                    <tr>
                        <?php if ($generalRepairRegistration->pph_price > 0.00): ?>
                            <td style="text-align:right; font-size: 11px">PPH 23</td>
                            <td style="text-align:right; font-size: 11px">Rp. <?php echo number_format($generalRepairRegistration->pph_price, 2, ',', '.') ?> &nbsp; </td>
                        <?php endif; ?>
                    </tr>

                    <tr>
                        <td style="font-weight: bold; text-align:right; font-size: 11px">GRAND TOTAL</td>
                        <td style="font-weight: bold; text-align:right; font-size: 11px">Rp. <?php echo number_format($generalRepairRegistration->grand_total, 2, ',', '.') ?> &nbsp; </td>
                    </tr>
                </table>
            </div>
            
            <br />

            <div style="width: 100%">
                <table style="border: 1px solid; font-size: 10px; width: 100%; float: center">
                    <tr>
                        <td style="border-bottom: 1px solid; text-align: center">Yang membuat,</td>
                    </tr>
                    <tr>
                        <td style="height: 70px; width: 30%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align: center;"><?php echo CHtml::encode(CHtml::value($generalRepairRegistration, 'user.username')); ?></td>
                    </tr>
                </table>
            </div>

            <br />
            
            <div style="font-size: 10px; text-align: left">* Note: Jasa Perbaikan & Suku Cadang diluar Estimasi, akan diinformasikan lebih lanjut</div>

        </div>
    </div>
<?php endfor; ?>