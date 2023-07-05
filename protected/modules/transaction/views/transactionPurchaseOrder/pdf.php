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
        <img src="images/rims po head.jpg" alt="">
    </div>

    <div class="supplier">
        <div class="left">
            <table>
                <tr>
                    <td>To</td>
                    <td>:</td>
                    <td><?php echo CHtml::encode(CHtml::value($supplier, 'name')); ?></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>:</td>
                    <td><?php echo CHtml::encode(CHtml::value($supplier, 'address')); ?></td>
                </tr>
                <tr>
                    <td>TOP</td>
                    <td>:</td>
                    <td><?php echo CHtml::encode(CHtml::value($supplier, 'tenor')); ?> Hari</td>
                </tr>
            </table>
        </div>
        <div class="right">
            <h3>Purchase Order</h3>
            <table>
                <tr>
                    <td>Date</td>
                    <td>:</td>
                    <td><?php echo tanggal($po->purchase_order_date); ?></td>
                </tr>
                <tr>
                    <td>PO#</td>
                    <td>:</td>
                    <td><?php echo CHtml::encode(CHtml::value($po, 'purchase_order_no')); ?></td>
                </tr>
                <tr>
                    <td>From</td>
                    <td>:</td>
                    <td><?php echo CHtml::encode(CHtml::value($po, 'mainBranch.name')); ?></td>
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
    </div>

    <div class="purchase-order">
        <table>
            <tr>
                <th class="no">No</th>
                <?php if ($po->purchase_type === TransactionPurchaseOrder::TIRE): ?>
                    <th class="code">Brand</th>
                    <th class="item">Type</th>
                    <th class="brand">Ukuran</th>
                <?php else: ?>
                    <th class="code">Code</th>
                    <th class="item">Item Name</th>
                    <th class="brand">Brand Name</th>
                <?php endif; ?>
                <th class="price">Price</th>
                <th class="discount">Disc</th>
                <th class="after">After Disc</th>
                <th class="qty">Qty</th>
                <th class="unit">Unit</th>
                <th class="subtotal">Sub Total</th>
                <th class="note">Notes</th>
            </tr>
            <?php
            $no = 1;
            foreach ($po_detail as $x) {
                ?>
                <tr class="isi">
                    <td class="noo"><?php echo $no; ?></td>
                    <?php if ($po->purchase_type === TransactionPurchaseOrder::TIRE): ?>
                        <td>&nbsp;  <?php echo CHtml::encode(CHtml::value($x, 'product.brand.name')); ?></td>
                        <td>&nbsp;  <?php echo CHtml::encode(CHtml::value($x, 'product.subBrandSeries.name')); ?></td>
                        <td>&nbsp;  <?php echo CHtml::encode(CHtml::value($x, 'product.manufacturer_code')); ?></td>
                    <?php else: ?>
                        <td>&nbsp;  <?php echo CHtml::encode(CHtml::value($x, 'product.manufacturer_code')); ?></td>
                        <td>&nbsp;  <?php echo CHtml::encode(CHtml::value($x, 'product.name')); ?></td>
                        <td>&nbsp;  <?php echo CHtml::encode(CHtml::value($x, 'product.brand.name')); ?></td>
                    <?php endif; ?>
                    <td>&nbsp;  Rp. <?php echo number_format($x->retail_price, 2, ',', '.') ?></td>
                    <td>&nbsp;  Rp. <?php echo number_format($x->discount, 2, ',', '.') ?></td>
                    <td>&nbsp;  Rp. <?php echo number_format($x->price_before_tax, 2, ',', '.') ?></td>
                    <td style="text-align:center"><?php echo $x->quantity ?></td>
                    <td style="text-align:center"><?php echo $x->unit->name ?></td>
                    <td style="text-align:right">Rp. <?php echo number_format($x->total_price, 2, ',', '.') ?> &nbsp; </td>
                    <td style="text-align:center"><?php echo $x->memo ?></td>
                </tr>
                <?php $no++;
            } ?>
            <tr class="r">
                <td colspan="8" class="result">Sub Total</td>
                <td style="text-align:right">Rp. <?php echo number_format($po->subtotal, 2, ',', '.') ?> &nbsp; </td>
                <td></td>
            </tr>
            <tr class="r">
                <td colspan="8" class="result">PPN</td>
                <td style="text-align:right">Rp. <?php echo number_format($po->ppn_price, 2, ',', '.') ?> &nbsp; </td>
                <td></td>
            </tr>
            <tr class="r">
                <td colspan="8" class="result">Total</td>
                <td style="text-align:right">Rp. <?php echo number_format($po->total_price, 2, ',', '.') ?> &nbsp; </td>
                <td></td>
            </tr>
        </table>
        
        <div class="row">
            <?php echo CHtml::encode(CHtml::value($po, 'note')); ?>
        </div>
    </div>
    
    <div class="memosig">
        <div class="divtable">
            <div class="divtablecell sig1">
                <div>Dibuat,</div>
                <div>(Sausan)</div>
            </div>
            <div class="divtablecell sig2">
                <div>Menyetujui,</div>
                <div>(Grace)</div>
            </div>
            <div class="divtablecell sig2">
                <div>Mengetahui,</div>
                <div>(Newira)</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <img src="images/rims po foot.jpg" alt="">
    </div>
</div>
