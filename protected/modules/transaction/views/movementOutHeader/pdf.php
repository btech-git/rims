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
                <h4>MOVEMENT OUT<?php if ($i > 0): ?><span style="color: red"> - COPY</span><?php endif; ?></h4>
            </div>

            <div class="body-memo">
                <table style="font-size: 10px">
                    <tr>
                        <td>Movement #</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo CHtml::encode(CHtml::value($model, 'movement_out_no')); ?></td>
                        <td>Reference #</td>
                        <td style="width: 5%">:</td>
                        <td>
                            <?php
                            if ($model->movement_type == 1) {
                                $referenceNumber = $model->deliveryOrder->delivery_order_no;
                            } elseif ($model->movement_type == 2) {
                                $referenceNumber = $model->returnOrder->return_order_no;
                            } elseif ($model->movement_type == 3) {
                                $referenceNumber = $model->registrationTransaction->transaction_number;
                            } elseif ($model->movement_type == 4) {
                                $referenceNumber = $model->materialRequestHeader->transaction_number;
                            } else {
                                $referenceNumber = "";
                            }
                            ?>
                            <?php echo CHtml::encode($referenceNumber); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy H:m:s", CHtml::value($model, 'date_posting'))); ?></td>
                        <td>Movement Type</td>
                        <td>:</td>
                        <td><?php echo CHtml::encode($model->getMovementType($model->movement_type)); ?></td>
                    </tr>
                    <tr>
                        <td>Dibuat oleh</td>
                        <td>:</td>
                        <td><?php echo CHtml::encode(CHtml::value($model, 'user.username')); ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>

            <hr />

            <div class="purchase-order">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 1%; text-align: center">NO</th>
                            <th width="15%">Code</th>
                            <th>Product</th>
                            <th width="20%">Brand</th>
                            <th width="8%">Qty Request</th>
                            <th width="8%">Qty Movement</th>
                            <th width="5%">Satuan</th>
                        </tr>
                    </thead>
                    <tbody style="height: 100px;">
                        <?php $no = 1;?>
                        <?php if (count($model->movementOutDetails) > 0): ?>
                            <?php foreach ($model->movementOutDetails as $detail): ?>
                                <?php $product = $detail->product; ?>
                                <tr class="isi">
                                    <td class="noo"><?php echo $no; ?></td>
                                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?></td>
                                    <td style="text-align: center">&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'quantity_transaction')); ?></td>
                                    <td style="text-align: center">&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?></td>
                                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?></td>
                                </tr>
                                <?php $no++; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div>
                <p style="text-align: right">Jakarta, <?php echo tanggal(date('Y-m-d')); ?></p>
                <p style="text-align: right">Yang Mengeluarkan,</p>
                <p class="authorized"></p>
            </div>
        </div>
    </div>
<?php endfor; ?>