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
                <h4>SUPPLIER INVOICE<?php if ($i > 0): ?><span style="color: red"> - COPY</span><?php endif; ?></h4>
            </div>

            <div class="body-memo">
                <table style="font-size: 10px">
                    <tr>
                        <?php if (empty($receiveItem->purchase_order_id)): ?>
                            <td>Invoice #</td>
                            <td style="width: 5%">:</td>
                            <td><?php echo CHtml::encode(CHtml::value($receiveItem, 'invoice_number')); ?></td>
                        <?php endif; ?>
                        <?php if (!empty($receiveItem->purchase_order_id)): ?>
                            <td>SJ #</td>
                            <td style="width: 5%">:</td>
                            <td><?php echo CHtml::encode(CHtml::value($receiveItem, 'supplier_delivery_number')); ?></td>
                            <td>PO #</td>
                            <td style="width: 5%">:</td>
                            <td><?php echo CHtml::encode(CHtml::value($receiveItem, 'purchaseOrder.purchase_order_no')); ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <?php if (!empty($receiveItem->purchase_order_id)): ?>
                            <td>Supplier</td>
                            <td style="width: 5%">:</td>
                            <td><?php echo CHtml::encode(CHtml::value($receiveItem, 'supplier.name')); ?></td>
                        <?php else: ?>
                            <td>Tujuan</td>
                            <td style="width: 5%">:</td>
                            <td><?php echo CHtml::encode(CHtml::value($receiveItem, 'destinationBranch.code')); ?></td>
                        <?php endif; ?>
                        <td>Pembuat</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo CHtml::encode(CHtml::value($receiveItem, 'user.username')); ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Invoice</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo tanggal(CHtml::encode(CHtml::value($receiveItem, 'invoice_date'))); ?></td>
                        <td>F. Pajak</td>
                        <td style="width: 5%">:</td>
                        <td><?php echo CHtml::encode(CHtml::value($receiveItem, 'invoice_tax_number')); ?></td>
                    </tr>
                </table>
            </div>

            <hr />

            <div class="purchase-order">
                <div class="detail">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 1%">No</th>
                                <th width="10%">Code</th>
                                <th>Item Name</th>
                                <th width="15%">Brand</th>
                                <th width="8%">Qty</th>
                                <th width="6%">Unit</th>
                                <th width="10%">Harga</th>
                                <th width="10%">Total</th>
                                <th width="30%">Notes</th>
                            </tr>
                        </thead>
                        <?php $no = 1; ?>
                        <tbody style="height: 100px;">
                            <?php foreach ($receiveItem->transactionReceiveItemDetails as $key => $receiveDetail): ?>
                                <tr>
                                    <td class="noo"><?php echo $no; ?></td>
                                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($receiveDetail, 'product.manufacturer_code')); ?></td>
                                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($receiveDetail, 'product.name')); ?></td>
                                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($receiveDetail, 'product.brand.name')); ?></td>
                                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($receiveDetail, 'qty_received')); ?></td>
                                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($receiveDetail, 'product.unit.name')); ?></td>
                                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($receiveDetail, 'purchaseOrderDetail.retail_price')); ?></td>
                                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($receiveDetail, 'purchaseRetailPrice')); ?></td>
                                    <td><?php echo $receiveDetail->note== ''?'-':$receiveDetail->note; ?></td>
                                </tr>
                                <?php $no++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="detail-notes">
                <table width="100%">
                    <tr>
                        <td class="tengah">Pengirim/Supplier</td>
                        <td class="tengah">Bagian Penerimaan</td>
                        <td class="tengah">Petugas Gudang</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="tengah h250"><div class="garisbawah">Pengirim/Supplier</div></td>
                        <td class="tengah h250"><div class="garisbawah">Bagian Penerimaan</div></td>
                        <td class="tengah h250"><div class="garisbawah">Petugas Gudang</div></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php endfor; ?>