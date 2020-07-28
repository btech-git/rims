<?php
Yii::app()->clientScript->registerScript('memo', '
    $("#header").addClass("hide");
    $("#mainmenu").addClass("hide");
    $(".breadcrumbs").addClass("hide");
    $("#footer").addClass("hide");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo.css');
Yii::app()->clientScript->registerCss('memo', '
     @page {
            size:auto;
            margin: 5px 0px 0px 0px;
        }
        
        div.memonote {
            width: 100%;
            margin: 0 auto;
            font-size: 12px;
        } 

    .hcolumn1 { width: 50% }
    .hcolumn2 { width: 50% }

    .hcolumn1header { width: 35% }
    .hcolumn1value { width: 65% }
    .hcolumn2header { width: 35% }
    .hcolumn2value { width: 65% }

    .sig1 { width: 25% }
    .sig2 { width: 25% }
    .sig3 { width: 25% }
	.sig4 { width: 25% }
');
?>

<div class="memonote">
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div style="display: table-caption;">
                    <span style="font-size: 24px;font-weight: bold;">PT.KARYA TIRTA PERKASA</span>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">&nbsp;</div>
                    <div class="divtablecell info hcolumn1value"></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">NOTA PEMBELIAN NO</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($purchase->getCodeNumber(PurchaseHeader::CN_CONSTANT)); ?></div>
                </div>
            </div>
        </div>
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold"></div>
                    <div class="divtablecell info hcolumn1value">Jakarta, <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($purchase, 'date')))); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Kepada Yth : </div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(CHtml::value($purchase, 'supplier.company')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold"> </div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(CHtml::value($purchase, 'supplier.address')); ?></div>
                </div>
                <!--                <div class="divtablerow">
                                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Faktur Pajak #</div>
                                    <div class="divtablecell info hcolumn1value"><?php //echo CHtml::encode(CHtml::value($purchaseInvoice, 'tax_invoice_number'));     ?></div>
                                </div>-->
            </div>
        </div>
    </div>
</div>


<br />

<table class="memo">
    <tr id="theader">
        <th>No</th>
        <th>Nama Barang</th>
        <th>Size</th>
        <th style="width: 10%">Merk</th>
        <th style="width: 5%">Jumlah</th>
        <th style="width: 5%">Satuan</th>
        <th style="width: 15%" colspan="2">Harga</th>
        <th style="width: 10%">Diskon(%)</th>
        <th style="width: 15%" colspan="2">Total</th>
    </tr>
    <?php $nomor = 1; ?>
    <?php foreach ($purchase->purchaseDetails as $i => $detail): ?>
        <?php if ($detail->is_inactive == 0): ?>
            <tr class="titems">
                <td style="text-align: center"><?php echo $nomor; ?></td> 
                <td>
                    <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?><br />
                </td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($detail, 'product.size')); ?><br />
                </td>
                <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name')); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->quantity)); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'product.unit.name')); ?></td>
                <td style="width: 3%; border-right: none">Rp. </td>
                <td style="text-align: right; border-left: none"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'unit_price'))); ?></td>
                <td style="text-align: center;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount'))); ?></td>
                <td style="width: 3%; border-right: none">Rp. </td>
                <td style="text-align: right; border-left: none"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total'))); ?></td>
            </tr>
            <?php $nomor++; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php for ($j = 12, $i = $i % $j + 1; $j > $i; $j--): ?>
        <tr class="titems">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-right: none">&nbsp;</td>
            <td style="border-left: none">&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-right: none">&nbsp;</td>
            <td style="border-left: none">&nbsp;</td>
        </tr>
    <?php endfor; ?>
    <tr>
        <td style="border-left: 1px solid; border-top: 2px solid; text-align:right; font-weight: bold" colspan="4">Total</td>
        <td style="border-top: 2px solid; text-align: center;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $purchase->getPurchaseQuantityTotal())); ?></td>
        <td style="border-top: 2px solid; text-align: right;font-weight: bold" colspan="4">Sub Total</td>
        <td style="border-top: 2px solid">Rp. </td>
        <td style="border-top: 2px solid; border-right: 1px solid; text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', floor(CHtml::value($purchase, 'subTotal')))); ?></td>
    </tr>
    <tr>
        <td style="text-align: right;font-weight: bold; border-left: 1px solid" colspan="9">
            Diskon <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', floor(CHtml::value($purchase, 'discount_percentage')))); ?>%
        </td>
        <td>Rp. </td>
        <td style="text-align: right; border-right: 1px solid">
            (<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', floor(CHtml::value($purchase, 'discount_value')))); ?>)
        </td>
    </tr>

    <?php if ($purchase->is_tax): ?>
        <tr>
            <td style="text-align: right;font-weight: bold; border-left: 1px solid" colspan="9">
                PPN <?php echo ((int) $purchase->is_tax === 0) ? 0 : 10; ?>%
            </td>
            <td>Rp. </td>
            <td style="text-align: right; border-right: 1px solid">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', floor(CHtml::value($purchase, 'calculatedTax')))); ?>
            </td>
        </tr>
    <?php endif; ?>

    <tr>
        <td style="text-align: right; font-weight: bold; border-left: 1px solid" colspan="9">Grand Total</td>
        <td>Rp. </td>
        <td style="text-align: right; border-right: 1px solid; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', floor(CHtml::value($purchase, 'grandTotal')))); ?>
        </td>
    </tr>



</table>

<div style="text-transform: capitalize">
    Terbilang:
    <?php echo CHtml::encode(NumberWord::numberName(CHtml::value($purchase, 'grandTotal'))); ?>
    rupiah
</div>
<br />


<div class="memoCatatan">Catatan: <?php echo CHtml::encode(CHtml::value($purchase, 'note')); ?></div>

<div class="memosig">
    <div style="font-weight:bold; font-style: italic;" class="divtable">

        <div  class="divtablecell sig2">
            <div>Mengetahui,</div>
            <div style="height: 50px;"></div>
            <div><?php //echo CHtml::encode(CHtml::value($purchase, 'employeeIdAuthorized.name'));      ?></div>
        </div>
        <div  class="divtablecell sig3">
            <div>Disetujui,</div>
            <div style="height: 50px;"></div>
            <div><?php //echo CHtml::encode(CHtml::value($purchase, 'employeeIdApproved.name'));      ?></div>
        </div>
        <div class="divtablecell sig4">
            <div >Supplier,</div>
        </div>
    </div>
</div>
