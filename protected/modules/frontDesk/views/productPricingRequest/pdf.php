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
<?php $numberOfPages = 1; ?>
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
                        <td>Permintaan Harga #</td>
                        <td>:</td>
                        <td><?php echo CHtml::encode(CHtml::value($productPricingRequestHeader, 'transaction_number')); ?></td>
                        <td>JENIS KENDARAAN</td>
                        <td>:</td>
                        <td>
                            <?php echo CHtml::encode(CHtml::value($productPricingRequestHeader, 'vehicleCarMake.name')); ?> -
                            <?php echo CHtml::encode(CHtml::value($productPricingRequestHeader, 'vehicleCarModel.name')); ?> -
                            <?php echo CHtml::encode(CHtml::value($productPricingRequestHeader, 'vehicleCarSubModel.name')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Request</td>
                        <td>:</td>
                        <td><?php echo tanggal($productPricingRequestHeader->request_date) . ' ' . CHtml::encode($productPricingRequestHeader->request_time); ?></td>
                        <td>Tanggal Reply</td>
                        <td>:</td>
                        <td><?php echo tanggal($productPricingRequestHeader->reply_date) . ' ' . CHtml::encode($productPricingRequestHeader->reply_time); ?></td>
                        
                    </tr>
                    <tr>
                        <td>User Request</td>
                        <td>:</td>
                        <td><?php echo CHtml::encode(CHtml::value($productPricingRequestHeader, 'userIdRequest.username')); ?></td>
                        <td>User Reply</td>
                        <td>:</td>
                        <td><?php echo CHtml::encode(CHtml::value($productPricingRequestHeader, 'userIdReply.username')); ?></td>
                    </tr>
                    <tr>
                        <td>Cabang Request</td>
                        <td>:</td>
                        <td><?php echo CHtml::encode(CHtml::value($productPricingRequestHeader, 'branchIdRequest.code')); ?></td>
                        <td>Cabang Reply</td>
                        <td>:</td>
                        <td><?php echo CHtml::encode(CHtml::value($productPricingRequestHeader, 'branchIdReply.code')); ?></td>
                    </tr>
                    <tr>
                        <td>Permintaan</td>
                        <td>:</td>
                        <td><?php echo CHtml::encode(CHtml::value($productPricingRequestHeader, 'request_note')); ?></td>
                        <td>Balasan</td>
                        <td>:</td>
                        <td><?php echo nl2br(CHtml::encode(CHtml::value($productPricingRequestHeader, 'reply_note'))); ?></td>
                    </tr>
                </table>
            </div>

            <hr />
            
            <?php if (count($productPricingRequestHeader->productPricingRequestDetails) > 0): ?>
                <div class="purchase-order">
                    <table>
                        <tr>
                            <th style="width: 1%">No</th>
                            <th style="width: 10%">Code</th>
                            <th>Item</th>
                            <th>Brand</th>
                            <th style="width: 10%">Category</th>
                            <th>Tahun Produksi</th>
                            <th style="width: 5%">Qty</th>
                            <th style="width: 5%">Satuan</th>
                            <th>Rec. Harga Jual</th>
                            <th>Memo</th>
                        </tr>
                        <?php
                        $no = 1;
                        foreach ($productPricingRequestHeader->productPricingRequestDetails as $detail) {
                        ?>
                            <tr class="isi">
                                <td class="noo"><?php echo $no; ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'product_code')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?></td>
                                <td>
                                    <?php echo CHtml::encode(CHtml::value($detail, 'brand.name')); ?> - 
                                    <?php echo CHtml::encode(CHtml::value($detail, 'subBrand.name')); ?> - 
                                    <?php echo CHtml::encode(CHtml::value($detail, 'subBrandSeries.name')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::encode(CHtml::value($detail, 'productMasterCategory.name')); ?> -
                                    <?php echo CHtml::encode(CHtml::value($detail, 'productSubMasterCategory.name')); ?> - 
                                    <?php echo CHtml::encode(CHtml::value($detail, 'productSubCategory.name')); ?>
                                </td>
                                <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'production_year')); ?></td>
                                <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?></td>
                                <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?></td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'recommended_price'))); ?>
                                </td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                            </tr>
                            <?php $no++;
                        } ?>
                    </table>
                </div>
            <?php endif; ?>

            <br />
            
            <div>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 35%; height: 100px; text-align: center; vertical-align: top;">Yang membuat,</td>
                        <td style="vertical-align: top;">* Note: Jasa Perbaikan & Suku Cadang diluar Estimasi, akan diinformasikan lebih lanjut</td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            <?php echo CHtml::encode(CHtml::value($productPricingRequestHeader, 'userIdRequest.username')); ?>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php endfor; ?>