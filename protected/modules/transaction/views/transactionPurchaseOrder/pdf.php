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
        <h4>PURCHASE ORDER</h4>
    </div>

    <div class="body-memo">
        <table>
            <tr>
                <td>To</td>
                <td>:</td>
                <td><?php echo CHtml::encode(CHtml::value($supplier, 'name')); ?></td>
                <td>PO#</td>
                <td>:</td>
                <td><?php echo CHtml::encode(CHtml::value($po, 'purchase_order_no')); ?></td>
            </tr>
            <tr>
                <td>Address</td>
                <td>:</td>
                <td><?php echo CHtml::encode(CHtml::value($supplier, 'address')); ?></td>
                <td>Date</td>
                <td>:</td>
                <td><?php echo tanggal($po->purchase_order_date); ?></td>
            </tr>
            <tr>
                <td>TOP</td>
                <td>:</td>
                <td><?php echo CHtml::encode(CHtml::value($supplier, 'tenor')); ?> Hari</td>
                <td>From</td>
                <td>:</td>
                <td><?php echo CHtml::encode(CHtml::value($po, 'user.username')); ?></td>
            </tr>
            <?php if ($po->purchase_type === TransactionPurchaseOrder::TIRE): ?>
                <tr>
                    <td>Type</td>
                    <td>:</td>
                    <td><?php echo CHtml::encode($po->getPurchaseStatus($po->purchase_type)); ?></td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="purchase-order">
        <table style="margin-top: 0px; font-size: 10px">
            <tr>
                <th class="no">No</th>
                <?php if ($po->purchase_type === TransactionPurchaseOrder::TIRE): ?>
                    <th style="width:10%">Brand</th>
                    <th style="width:10%">Type</th>
                    <th style="width:10%">Ukuran</th>
                <?php else: ?>
                    <th style="width:10%">Code</th>
                    <th style="width:10%">Item Name</th>
                    <th style="width:10%">Brand</th>
                <?php endif; ?>
                <th style="width:10%">Qty</th>
                <th style="width:5%">Unit</th>
                <th style="width:10%">Price</th>
                <th style="width:10%">Disc</th>
                <th style="width:10%">After Disc</th>
                <th style="width:15%">Total</th>
                <!--<th style="width:10%">Notes</th>-->
            </tr>
            <?php
            $no = 1;
            foreach ($po_detail as $x) {
            ?>
                <tr>
                    <td class="noo"><?php echo $no; ?></td>
                    <?php if ($po->purchase_type === TransactionPurchaseOrder::TIRE): ?>
                        <td style="margin-top: 0px">&nbsp;  <?php echo CHtml::encode(CHtml::value($x, 'product.brand.name')); ?></td>
                        <td style="margin-top: 0px">&nbsp;  <?php echo CHtml::encode(CHtml::value($x, 'product.subBrandSeries.name')); ?></td>
                        <td style="margin-top: 0px">&nbsp;  <?php echo CHtml::encode(CHtml::value($x, 'product.manufacturer_code')); ?></td>
                    <?php else: ?>
                        <td style="margin-top: 0px">&nbsp;  <?php echo CHtml::encode(CHtml::value($x, 'product.manufacturer_code')); ?></td>
                        <td style="margin-top: 0px">&nbsp;  <?php echo CHtml::encode(CHtml::value($x, 'product.name')); ?></td>
                        <td style="margin-top: 0px">&nbsp;  <?php echo CHtml::encode(CHtml::value($x, 'product.brand.name')); ?></td>
                    <?php endif; ?>
                    <td style="text-align:center"><?php echo $x->quantity ?></td>
                    <td style="text-align:center"><?php echo $x->unit->name ?></td>
                    <td style="text-align:right">Rp. <?php echo number_format($x->retail_price, 2, ',', '.') ?></td>
                    <td style="text-align:right">Rp. <?php echo number_format($x->discount, 2, ',', '.') ?></td>
                    <td style="text-align:right">Rp. <?php echo number_format($x->unit_price, 2, ',', '.') ?></td>
                    <td style="text-align:right">Rp. <?php echo number_format($x->total_price, 2, ',', '.') ?> &nbsp; </td>
                </tr>
                <?php $no++;
            } ?>

            <tr class="r">
                <td colspan="9" style="text-align:right; font-size: 11px">Sub Total</td>
                <td style="text-align:right">Rp. <?php echo number_format($po->subtotal, 2, ',', '.') ?> &nbsp; </td>
            </tr>
            
            <?php if ($po->ppn_price > 0): ?>
                <tr class="r">
                    <td colspan="9" style="text-align:right; font-size: 11px"
                        >PPN</td>
                    <td style="text-align:right">Rp. <?php echo number_format($po->ppn_price, 2, ',', '.') ?> &nbsp; </td>
                </tr>
            <?php endif; ?>
            
            <tr class="r">
                <td colspan="9" style="text-align:right; font-size: 11px">Total</td>
                <td style="text-align:right">Rp. <?php echo number_format($po->total_price, 2, ',', '.') ?> &nbsp; </td>
            </tr>
        </table>

        <div class="row result" style="font-size: 11px; background-color:lightgrey">
            Catatan: <?php echo CHtml::encode(CHtml::value($po, 'note')); ?>
        </div>
    </div>

    <div class="purchase-order">
        <table style="width: 100%">
            <tr>
                <td style="width: 30%">Dibuat,</td>
                <td style="width: 30%">Menyetujui,</td>
                <td style="width: 30%">Mengetahui,</td>
            </tr>
            <tr>
                <td style="height: 80px">&nbsp;</td>
                <td style="height: 80px">&nbsp;</td>
                <td style="height: 80px">&nbsp;</td>
            </tr>
            <tr>
                <td>(<?php echo CHtml::encode(CHtml::value($po, 'user.username')); ?>)</td>
                <td>(<?php echo CHtml::encode(CHtml::value($approval, 'supervisor.username')); ?>)</td>
                <td>(Newira)</td>
            </tr>
        </table>
    </div>
</div>
