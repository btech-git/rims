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
                        <td><?php echo CHtml::encode(CHtml::value($saleEstimationHeader, 'transaction_number')); ?></td>
                        <td>TANGGAL</td>
                        <td>:</td>
                        <td><?php echo tanggal($saleEstimationHeader->transaction_date) . ' ' . Yii::app()->dateFormatter->formatDateTime($saleEstimationHeader->transaction_date, '', 'short'); ?></td>
                    </tr>
                    <tr>
                        <td>JENIS KENDARAAN</td>
                        <td>:</td>
                        <td>
                            <?php echo CHtml::encode(CHtml::value($vehicle, 'carMake.name')); ?> -
                            <?php echo CHtml::encode(CHtml::value($vehicle, 'carModel.name')); ?> -
                            <?php echo CHtml::encode(CHtml::value($vehicle, 'carSubModel.name')); ?>
                        </td>
                        <td>NAMA</td>
                        <td>:</td>
                        <td><?php echo CHtml::encode(CHtml::value($customer, 'name')); ?></td>
                    </tr>
                    <tr>
                        <td>NO. POLISI</td>
                        <td>:</td>
                        <td><?php echo CHtml::encode(CHtml::value($vehicle, 'plate_number')); ?></td>
                        <td>PHONE</td>
                        <td>:</td>
                        <td><?php echo CHtml::encode(CHtml::value($customer, 'mobile_phone')); ?></td>
                    </tr>
                    <tr>
                        <td>NO. RANGKA</td>
                        <td>:</td>
                        <td><?php echo CHtml::encode(CHtml::value($vehicle, 'frame_number')); ?></td>
                        <td>ALAMAT</td>
                        <td>:</td>
                        <td><?php echo nl2br(CHtml::encode(CHtml::value($customer, 'address'))); ?></td>
                    </tr>
                    <tr>
                        <td>PROBLEM</td>
                        <td>:</td>
                        <td><?php echo CHtml::encode(CHtml::value($saleEstimationHeader, 'problem')); ?></td>
                        <td>KM</td>
                        <td>:</td>
                        <td><?php echo CHtml::encode(CHtml::value($saleEstimationHeader, 'vehicle_mileage')); ?></td>
                    </tr>
                </table>
            </div>

            <?php if (count($saleEstimationHeader->saleEstimationProductDetails) > 0): ?>
                <div class="purchase-order">
                    <table>
                        <tr style="background-color: skyblue">
                            <th colspan="9">SUKU CADANG - SPAREPARTS</th>
                        </tr>
                        <tr>
                            <th style="width: 1%">No</th>
                            <th style="width: 10%">Code</th>
                            <th>Item Name</th>
                            <th>Brand Name</th>
                            <th style="width: 5%">Qty</th>
                            <th style="width: 5%">Unit</th>
                            <th style="width: 10%">Price</th>
                            <th style="width: 10%">Disc</th>
                            <th style="width: 15%">Total</th>
                        </tr>
                        <?php
                        $no = 1;
                        foreach ($saleEstimationHeader->saleEstimationProductDetails as $product) {
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
                                <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($product->total_price, 2, ',', '.'); ?></td>
                            </tr>
                            <?php $no++;
                        } ?>
                        <tr>
                            <td colspan="8" style="font-weight: bold; text-align: right;">TOTAL SUKU CADANG</td>
                            <td style="font-weight: bold; text-align: right;">
                                &nbsp;  Rp. <?php echo number_format($saleEstimationHeader->sub_total_product, 2, ',', '.'); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endif; ?>

            <?php if (count($saleEstimationHeader->saleEstimationServiceDetails) > 0): ?>
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
                            <th style="width: 15%">Total</th>
                        </tr>
                        <?php $no = 1;?>
                        <?php foreach ($saleEstimationHeader->saleEstimationServiceDetails as $service): ?>
                            <tr class="isi">
                                <td class="noo"><?php echo $no; ?></td>
                                <td>&nbsp; <?php echo CHtml::encode(CHtml::value($service, 'service.name')); ?></td>
                                <td style="text-align: right">&nbsp; Rp. <?php echo number_format($service->price, 2, ',', '.'); ?></td>
                                <td style="text-align: right">&nbsp; Rp. <?php echo number_format($service->discountAmount, 2, ',', '.'); ?></td>
                                <td style="text-align: right">&nbsp; Rp. <?php echo number_format($service->total_price, 2, ',', '.'); ?></td>
                            </tr>
                            <?php $no++; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4" style="font-weight: bold; text-align: right">TOTAL JASA PERBAIKAN</td>
                            <td style="font-weight: bold; text-align: right">
                                &nbsp;  Rp. <?php echo number_format($saleEstimationHeader->sub_total_service, 2, ',', '.'); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endif; ?>
            <div>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 35%; text-align: center">Yang membuat,</td>
                        <td style="text-align:right; font-size: 11px">TOTAL PARTS & JASA</td>
                        <td style="width: 15%; text-align:right; font-size: 11px">Rp. <?php echo number_format($saleEstimationHeader->sub_total, 2, ',', '.') ?> &nbsp; </td>
                    </tr>

                    <tr>
                        <td style="border-bottom: none">&nbsp;</td>
                        <td style="text-align:right; font-size: 11px">TOTAL DISKON</td>
                        <td style="width: 15%; text-align:right; font-size: 11px">Rp. <?php echo number_format($saleEstimationHeader->totalDiscount, 2, ',', '.') ?> &nbsp; </td>
                    </tr>

                    <tr>
                        <?php if ($saleEstimationHeader->tax_product_amount > 0.00): ?>
                            <td style="border-bottom: none">&nbsp;</td>
                            <td style="text-align:right; font-size: 11px">PPN - <?php echo CHtml::encode(CHtml::value($saleEstimationHeader, 'tax_product_percentage')); ?>%</td>
                            <td style="text-align:right; font-size: 11px">Rp. <?php echo number_format($saleEstimationHeader->tax_product_amount, 2, ',', '.') ?> &nbsp; </td>
                        <?php endif; ?>
                    </tr>

                    <tr>
                        <?php if ($saleEstimationHeader->tax_service_amount > 0.00): ?>
                            <td style="border-top: none">&nbsp;</td>
                            <td style="text-align:right; font-size: 11px">PPH 23</td>
                            <td style="text-align:right; font-size: 11px">Rp. <?php echo number_format($saleEstimationHeader->tax_service_amount, 2, ',', '.') ?> &nbsp; </td>
                        <?php endif; ?>
                    </tr>

                    <tr>
                        <td style="border-top: none">&nbsp;</td>
                        <td style="font-weight: bold; text-align:right; font-size: 11px">GRAND TOTAL</td>
                        <td style="font-weight: bold; text-align:right; font-size: 11px">Rp. <?php echo number_format($saleEstimationHeader->grand_total, 2, ',', '.') ?> &nbsp; </td>
                    </tr>
                    <tr>
                        <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($saleEstimationHeader, 'userIdCreated.username')); ?></td>
                        <td colspan="2">* Note: Jasa Perbaikan & Suku Cadang diluar Estimasi, akan diinformasikan lebih lanjut</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php endfor; ?>