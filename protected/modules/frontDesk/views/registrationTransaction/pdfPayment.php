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
<?php $numberOfCopies = 3; ?>
<?php $numberOfPages = count($invoiceDetailsData['items']); ?>

<?php for ($i = 0; $i < $numberOfCopies; $i++): ?>
    <?php $productDetailRowNumber = 0; ?>
    <?php $serviceDetailRowNumber = 0; ?>
    <?php for ($j = 0; $j < $numberOfPages; $j++): ?>
        <?php $detailItems = $invoiceDetailsData['items'][$j]; ?>
        <div class="page" style="<?php if ($i > 0 || $j > 0): ?>page-break-before: always;<?php endif; ?>">
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
                    <h4>TANDA TERIMA PEMBAYARAN<?php if ($i > 0): ?><span style="color: red"> - COPY</span><?php endif; ?></h4>
                </div>

                <div class="body-memo">
                    <table>
                        <tr>
                            <td>PAYMENT #</td>
                            <td>:</td>
                            <td><?php echo $paymentInDetail->paymentIn->payment_number; ?></td>
                            <td>TGL PAYMENT</td>
                            <td>:</td>
                            <td><?php echo tanggal($paymentInDetail->paymentIn->payment_date) . ' ' . Yii::app()->dateFormatter->formatDateTime($paymentInDetail->paymentIn->payment_time, '', 'short'); ?></td>
                        </tr>
                        <tr>
                            <td>INVOICE #</td>
                            <td>:</td>
                            <td><?php echo $invoiceHeader->invoice_number; ?></td>
                            <td>TGL INVOICE</td>
                            <td>:</td>
                            <td><?php echo tanggal($invoiceHeader->invoice_date) . ' ' . Yii::app()->dateFormatter->formatDateTime($invoiceHeader->created_datetime, '', 'short'); ?></td>
                        </tr>
                        <tr>
                            <td>NAMA</td>
                            <td>:</td>
                            <td><?php echo $customer->name; ?></td>
                            <td>NO. POLISI</td>
                            <td>:</td>
                            <td><?php echo $invoiceHeader->vehicle->plate_number; ?></td>
                        </tr>
                        <tr>
                            <td>PAYMENT TYPE</td>
                            <td>:</td>
                            <td><?php echo $paymentInDetail->paymentIn->paymentType->name; ?></td>
                            <td>KENDARAAN</td>
                            <td>:</td>
                            <td>
                                <?php echo $invoiceHeader->vehicle->carMake->name; ?> -
                                <?php echo $invoiceHeader->vehicle->carModel->name; ?> -
                                <?php echo $invoiceHeader->vehicle->carSubModel->name; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>CREATED BY</td>
                            <td>:</td>
                            <td><?php echo $invoiceHeader->user->username; ?></td>
                            <td>KM</td>
                            <td>:</td>
                            <td><?php echo $invoiceHeader->registrationTransaction->vehicle_mileage; ?></td>
                        </tr>
                    </table>
                </div>

                <?php if (isset($detailItems['p']) && count($detailItems['p']) > 0): ?>
                    <div class="purchase-order">
                        <table>
                            <tr>
                                <th colspan="10" style="text-align: left">SUKU CADANG - SPAREPARTS</th>
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
                            <?php foreach ($detailItems['p'] as $detail): ?>
                                <tr class="isi">
                                        <td class="noo"><?php echo ++$productDetailRowNumber; ?></td>
                                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')); ?></td>
                                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name')); ?></td>
                                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?></td>
                                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'product.unit.name')); ?></td>
                                    <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($detail->unit_price, 2, ',', '.'); ?></td>
                                    <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($detail->discount, 2, ',', '.'); ?></td>
                                    <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($detail->priceAfterDiscount, 2, ',', '.'); ?></td>
                                    <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($detail->total_price, 2, ',', '.'); ?></td>
                                </tr>
                                <?php $no++; ?>
                            <?php endforeach; ?>
                            <?php if ($j === $invoiceDetailsData['lastpage']['p']): ?>
                                <tr>
                                    <td colspan="9" style="text-align: right;">Total Parts</td>
                                    <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($invoiceHeader->product_price, 2, ',', '.'); ?></td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if (isset($detailItems['s']) && count($detailItems['s']) > 0): ?>
                    <div class="purchase-order">
                        <table>
                            <tr>
                                <th colspan="5" style="text-align: left">JASA PERBAIKAN - SERVICE</th>
                            </tr>
                            <tr>
                                <th style="width: 1%">No</th>
                                <th>Service</th>
                                <th style="width: 10%">Price</th>
                                <th style="width: 10%">Disc</th>
                                <th style="width: 10%">Sub Total</th>
                            </tr>
                            <?php foreach ($detailItems['s'] as $detail): ?>
                                <tr class="isi">
                                    <td class="noo"><?php echo ++$serviceDetailRowNumber; ?></td>
                                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'service.name')); ?></td>
                                    <td style="text-align: right">&nbsp; Rp. <?php echo number_format($detail->unit_price, 2, ',', '.') ?></td>
                                    <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($detail->discount, 2, ',', '.'); ?></td>
                                    <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($detail->total_price, 2, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if ($j === $invoiceDetailsData['lastpage']['s']): ?>
                                <tr>
                                    <td colspan="4" style="text-align: right;">Total Jasa</td>
                                    <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($invoiceHeader->service_price, 2, ',', '.'); ?></td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if ($j === $numberOfPages - 1): ?>
                    <div>
                        <table style="width: 100%">
                            <tr>
                                <td style="font-size: 11px">Printed by : <?php echo Yii::app()->user->getName(); ?></td>
                                <td style="text-align:right; width: 20%; font-size: 11px">TOTAL PARTS & JASA</td>
                                <td style="text-align:right; width: 20%; font-size: 11px">Rp. <?php echo number_format($invoiceHeader->subTotal, 2, ',', '.') ?> &nbsp; </td>
                            </tr>

                            <tr>
                                <td style="font-size: 11px">Note : <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'note')); ?></td>
                                <td style="text-align:right; width: 20%; font-size: 11px">TOTAL DISKON</td>
                                <td style="text-align:right; width: 20%; font-size: 11px">Rp. <?php echo number_format($invoiceHeader->totalDiscountProductService, 2, ',', '.') ?> &nbsp; </td>
                            </tr>

                            <?php if ($invoiceHeader->ppn_total > 0): ?>
                                <tr>
                                    <td></td>
                                    <td style="text-align:right; font-size: 11px">PPN - <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'tax_percentage')); ?>%</td>
                                    <td style="text-align:right; font-size: 11px">Rp. <?php echo number_format($invoiceHeader->ppn_total, 2, ',', '.') ?> &nbsp; </td>
                                </tr>
                            <?php endif; ?>

                            <?php if ($invoiceHeader->pph_total > 0): ?>
                                <tr>
                                    <td></td>
                                    <td style="text-align:right; font-size: 11px">PPH 23</td>
                                    <td style="text-align:right; font-size: 11px">Rp. <?php echo number_format($invoiceHeader->pph_total, 2, ',', '.') ?> &nbsp; </td>
                                </tr>
                            <?php endif; ?>

                            <tr>
                                <td></td>
                                <td style="font-weight: bold; text-align:right; font-size: 11px">GRAND TOTAL</td>
                                <td style="font-weight: bold; text-align:right; font-size: 11px">Rp. <?php echo number_format($invoiceHeader->total_price, 2, ',', '.') ?> &nbsp; </td>
                            </tr>
                        </table>

                        <div style="font-size: 10px; text-align: left">1. Raperind Motor tidak bertanggung jawab atas kendaraan yang tidak diambil dalam waktu 30 hari setelah kendaraan selesai</div>
                        <div style="font-size: 10px; text-align: left">2. Raperind Motor bertanggung jawab atas keamanan kendaraan yang ditinggal di workshop dengan penggantian sebesar 10x Jasa, kecuali atas kejadian Force Majeure (Pencurian Kendaraan, Kebakaran, dll)</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endfor; ?>
<?php endfor; ?>