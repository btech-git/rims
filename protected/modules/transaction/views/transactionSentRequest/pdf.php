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
                <h4>PERMINTAAN BARANG<?php if ($i > 0): ?><span style="color: red"> - COPY</span><?php endif; ?></h4>
            </div>

            <div class="body-memo">
                <table style="font-size: 10px">
                    <tr>
                        <td>Request #</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo CHtml::encode(CHtml::value($sentRequest, 'sent_request_no')); ?></td>
                        <td>Tanggal Request</td>
                        <td style="width: 5%">:</td>
                        <td>
                            <?php echo tanggal(CHtml::encode(CHtml::value($sentRequest, 'sent_request_date'))); ?> 
                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format("H:m:s", CHtml::value($sentRequest, 'sent_request_time'))); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tujuan</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo CHtml::encode(CHtml::value($sentRequest, 'destinationBranch.code')); ?></td>
                        <td>ETA</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo tanggal(CHtml::encode(CHtml::value($sentRequest, 'estimate_arrival_date'))); ?></td>
                    </tr>
                    <tr>
                        <td>User Request</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo tanggal(CHtml::encode(CHtml::value($sentRequest, 'user.username'))); ?></td>
                        <td>Approved oleh Cabang</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo tanggal(CHtml::encode(CHtml::value($sentRequest, 'destinationApprovedBy.username'))); ?></td>
                    </tr>
                </table>
            </div>

            <hr />

            <div class="purchase-order">
                <div class="detail">
                    <?php if (count($sentRequest->transactionSentRequestDetails) > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 1%">No</th>
                                    <th width="10%">Code</th>
                                    <th>Item Name</th>
                                    <th width="15%">Brand</th>
                                    <th width="8%">Qty</th>
                                    <th width="6%">Unit</th>
                                </tr>
                            </thead>
                            <?php $no = 1; ?>
                            <tbody style="height: 100px;">
                                <?php foreach ($sentRequest->transactionSentRequestDetails as $key => $sentRequestDetail): ?>
                                    <tr>
                                        <td class="noo"><?php echo $no; ?></td>
                                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($sentRequestDetail, 'product.manufacturer_code')); ?></td>
                                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($sentRequestDetail, 'product.name')); ?></td>
                                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($sentRequestDetail, 'product.brand.name')); ?></td>
                                        <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($sentRequestDetail, 'quantity')); ?></td>
                                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($sentRequestDetail, 'unit.name')); ?></td>
                                    </tr>
                                    <?php $no++; ?>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="text-align: right; font-weight: bold">Total Quantity</td>
                                    <td style="text-align: center; font-weight: bold">
                                        <?php echo CHtml::encode(CHtml::value($sentRequest, 'total_quantity')); ?>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </tfoot>
                        </table>    
                    <?php else: ?>
                        <?php echo 'No Details Available'; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <br />

            <div style="width: 100%">
                <table style="border: 1px solid; font-size: 10px; width: 100%; float: center">
                    <tr>
                        <td style="border-bottom: 1px solid; text-align: center; border-right: 1px solid;">Dibuat,</td>
                        <td style="border-bottom: 1px solid; text-align: center; border-right: 1px solid;">Menyetujui,</td>
                        <td style="border-bottom: 1px solid; text-align: center">Mengetahui,</td>
                    </tr>
                    <tr>
                        <td style="width: 30%; height: 70px; border-right: 1px solid;">&nbsp;</td>
                        <td style="width: 30%; border-right: 1px solid">&nbsp;</td>
                        <td style="width: 30%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align: center; border-right: 1px solid; border-top: 1px solid;">(Mella)</td>
                        <td style="text-align: center; border-right: 1px solid; border-top: 1px solid;">(Regina)</td>
                        <td style="text-align: center; border-top: 1px solid;">(Newira)</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php endfor; ?>