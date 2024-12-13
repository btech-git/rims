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
        <div style="float: left; width: 50%; text-align: center">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/rap-logo.png" alt="" width="35%"/>
        </div>
        <div style="float: right; width: 45%">
            <p>
                Jl. Raya Jati Asih/Jati Kramat - 84993984/77 Fax. 84993989 <br />
                Jl. Raya Kalimalang No. 8, Kp. Dua - 8843656 Fax. 88966753<br />
                Jl. Raya Kalimalang Q/2D - 8643594/95 Fax. 8645008<br />
                Jl. Raya Radin Inten II No. 9 - 8629545/46 Fax. 8627313<br />
                Jl. Celebration Boulevard Blok AA 9/35 - 8261594<br />
                Email info@raperind.com
            </p>
        </div>
    </div>
    
    <div style="text-align: center">
        <h4>INVOICE</h4>
    </div>

    <div class="body-memo">
        <table>
            <tr>
                <td>INVOICE #</td>
                <td>:</td>
                <td><?php echo $invoiceHeader->invoice_number; ?></td>
                <td>TGL INVOICE</td>
                <td>:</td>
                <td><?php echo tanggal($invoiceHeader->invoice_date); ?></td>
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
                <td>PHONE</td>
                <td>:</td>
                <td><?php echo $customer->mobile_phone; ?></td>
                <td>KENDARAAN</td>
                <td>:</td>
                <td>
                    <?php echo $invoiceHeader->vehicle->carMake->name; ?> -
                    <?php echo $invoiceHeader->vehicle->carModel->name; ?> -
                    <?php echo $invoiceHeader->vehicle->carSubModel->name; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
        </table>
    </div>
    
    <hr />
    
    <?php if (count($invoiceHeader->invoiceDetails) > 0): ?>
        <div class="purchase-order">
            <table>
                <tr style="background-color: skyblue">
                    <th colspan="7">SUKU CADANG - SPAREPARTS</th>
                </tr>
                <tr>
                    <th class="no">NO</th>
                    <th class="item">CODE</th>
                    <th class="item">PRODUCT</th>
                    <th class="no">QTY</th>
                    <th class="price">UNIT PRICE</th>
                    <th class="price">TOTAL</th>
                </tr>
                <?php $no = 1; ?>
                <?php foreach ($invoiceHeader->invoiceDetails as $detail): ?>
                    <?php if (!empty($detail->product_id)): ?>
                        <tr class="isi">
                            <td class="noo"><?php echo $no; ?></td>
                            <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')); ?></td>
                            <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                            <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?></td>
                            <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($detail->unit_price, 2, ',', '.'); ?></td>
                            <td style="text-align: right;">&nbsp;  Rp. <?php echo number_format($detail->total_price, 2, ',', '.'); ?></td>
                        </tr>
                        <?php $no++; ?>
                    <?php else: ?>
                        <tr class="isi">
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5" style="font-weight: bold; text-align: right;">TOTAL SUKU CADANG</td>
                    <td style="font-weight: bold; text-align: right;">
                        &nbsp;  Rp. <?php echo number_format($invoiceHeader->subtotal_product, 2, ',', '.'); ?>
                    </td>
                </tr>
            </table>
        </div>
    <?php endif; ?>
    
    <?php if (count($invoiceHeader->registrationQuickServices) > 0 || count($invoiceHeader->registrationServices) > 0): ?>
        <div class="purchase-order">
            <table>
                <tr style="background-color: skyblue">
                    <th colspan="5">JASA PERBAIKAN - SERVICE</th>
                </tr>
                <tr>
                    <th class="no">NO</th>
                    <th class="item">SERVICE</th>
                    <th class="price">PRICE</th>
                </tr>
                <?php $no = 1;?>
                <?php foreach ($invoiceHeader->invoiceDetails as $detail): ?>
                    <?php if (!empty($detail->quick_service_id)): ?>
                    <tr class="isi">
                        <td class="noo"><?php echo $no; ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'quickService.name')); ?></td>
                        <td style="text-align: right">&nbsp;  Rp. <?php echo number_format($detail->total_price, 2, ',', '.') ?></td>
                    </tr>
                    <?php $no++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php foreach ($invoiceHeader->invoiceDetails as $detail): ?>
                    <?php if (!empty($detail->service_id)): ?>
                    <tr class="isi">
                        <td class="noo"><?php echo $no; ?></td>
                        <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'service.name')); ?></td>
                        <td style="text-align: right">&nbsp; Rp. <?php echo number_format($detail->total_price, 2, ',', '.') ?></td>
                    </tr>
                    <?php $no++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2" style="font-weight: bold; text-align: right">TOTAL JASA PERBAIKAN</td>
                    <td style="font-weight: bold; text-align: right">
                        &nbsp;  Rp. <?php echo number_format($invoiceHeader->subtotal_service, 2, ',', '.'); ?>
                    </td>
                </tr>
            </table>
        </div>
    <?php endif; ?>
    <div class="purchase-order">
        <table>
            <tr>
                <td style="width: 45%; text-align: center">Yang membuat,</td>
                <td>TOTAL PRODUCT & SERVICE</td>
                <td style="text-align:right">Rp. <?php echo number_format($invoiceHeader->subtotal, 2, ',', '.') ?> &nbsp; </td>
            </tr>
            
            <tr>
                <td style="border-bottom: none">&nbsp;</td>
                <td>PPN - <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'tax_percentage')); ?>%</td>
                <td style="text-align:right">Rp. <?php echo number_format($invoiceHeader->ppn_price, 2, ',', '.') ?> &nbsp; </td>
            </tr>
                
            <tr>
                <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($invoiceHeader, 'user.username')); ?></td>
                <td style="font-weight: bold">GRAND TOTAL</td>
                <td style="font-weight: bold; text-align:right">Rp. <?php echo number_format($invoiceHeader->grand_total, 2, ',', '.') ?> &nbsp; </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center">* Note: Jasa Perbaikan & Suku Cadang diluar Estimasi, akan diinformasikan lebih lanjut</td>
            </tr>
        </table>
    </div>
</div>