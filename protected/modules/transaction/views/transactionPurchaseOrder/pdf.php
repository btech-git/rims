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
<div style="margin-top: 0px; font-size: 12px">
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
                <tr>
                    <td>From</td>
                    <td>:</td>
                    <td><?php echo CHtml::encode(CHtml::value($po, 'mainBranch.name')); ?></td>
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
                    <th style="width:10%">Brand</th>
                    <th style="width:10%">Type</th>
                    <th style="width:10%">Ukuran</th>
                <?php else: ?>
                    <th style="width:10%">Code</th>
                    <th style="width:10%">Item Name</th>
                    <th style="width:10%">Brand Name</th>
                <?php endif; ?>
                <th style="width:10%">Price</th>
                <th style="width:10%">Disc</th>
                <th style="width:10%">After Disc</th>
                <th style="width:10%">Qty</th>
                <th style="width:5%">Unit</th>
                <th style="width:15%">Sub Total</th>
                <th style="width:10%">Notes</th>
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
                    <td style="text-align:right">&nbsp;  Rp. <?php echo number_format($x->retail_price, 2, ',', '.') ?></td>
                    <td style="text-align:right">&nbsp;  Rp. <?php echo number_format($x->discount, 2, ',', '.') ?></td>
                    <td style="text-align:right">&nbsp;  Rp. <?php echo number_format($x->price_before_tax, 2, ',', '.') ?></td>
                    <td style="text-align:center"><?php echo $x->quantity ?></td>
                    <td style="text-align:center"><?php echo $x->unit->name ?></td>
                    <td style="text-align:right">Rp. <?php echo number_format($x->total_price, 2, ',', '.') ?> &nbsp; </td>
                    <td style="text-align:center"><?php echo $x->memo ?></td>
                </tr>
                <?php $no++;
            } ?>
                
            <?php for ($j = 5, $i = $i % $j + 1; $j > $i; $j--): ?>
                <tr class="isi">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            <?php endfor; ?>
                
            <tr class="r">
                <td colspan="9" style="text-align:right" class="result">Sub Total</td>
                <td style="text-align:right">Rp. <?php echo number_format($po->subtotal, 2, ',', '.') ?> &nbsp; </td>
                <td></td>
            </tr>
            <tr class="r">
                <td colspan="9" style="text-align:right" class="result">PPN</td>
                <td style="text-align:right">Rp. <?php echo number_format($po->ppn_price, 2, ',', '.') ?> &nbsp; </td>
                <td></td>
            </tr>
            <tr class="r">
                <td colspan="9" style="text-align:right" class="result">Total</td>
                <td style="text-align:right">Rp. <?php echo number_format($po->total_price, 2, ',', '.') ?> &nbsp; </td>
                <td></td>
            </tr>
        </table>
        
        <div class="row">
            Catatan: 
            <?php echo CHtml::encode(CHtml::value($po, 'note')); ?>
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
                <td style="height: 100px">&nbsp;</td>
                <td style="height: 100px">&nbsp;</td>
                <td style="height: 100px">&nbsp;</td>
            </tr>
            <tr>
                <td>(Sausan)</td>
                <td>(Grace)</td>
                <td>(Newira)</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <img src="images/rims po foot.jpg" alt="">
    </div>
</div>
