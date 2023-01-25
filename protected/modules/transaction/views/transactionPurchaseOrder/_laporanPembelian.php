<?php
Yii::app()->clientScript->registerCss('_report', '
	.price {text-align: right;}
');
?>

<div class="reportHeader">
    <div>PT RATU PERDANA INDAH JAYA</div>
    <div>LAPORAN PEMBELIAN</div>
    <div>Periode: <?php echo $tanggal_mulai . ' s/d ' . $tanggal_sampai; ?></div>
    <div>Branch: <?php echo $branch; ?></div>
    <span></span><br>
    <div>Tanggal Cetak: <?php echo date('d/m/Y'); ?></div>
</div>
<p></p>
<table>
    <tr>
        <th>Tanggal</th>
        <th>No Dokumen</th>
        <th>Supplier</th>
        <th>T/K</th>
        <th></th>
        <th></th>
        <th></th>
        <th>Subtotal<th>
        <th></th>
        <th>Discount</th>
        <th>PPN</th>
        <th>Total</th>
    </tr>
    <tr>
        <th>Product Code</th>
        <th>Product Name</th>
        <th>Product Master Category</th>
        <th>Product Sub Master Category</th>
        <th>Product Sub Category</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Brutto</th>
        <th>Discounts</th>
        <th>Discount Price</th>
        <th>Netto</th>
        <th>Biaya</th>
        <th>Total</th>
    </tr>
    <?php $grandPbd = $grandDisc = $grandPpn = $grandSubtotal = $grandTotal = 0; ?>
    <?php foreach ($transactions as $key => $transaction): ?>
        <tr style="background:#fff;border:0px;">
            <td><?php echo $transaction->purchase_order_date; ?></td>
            <td><?php echo $transaction->purchase_order_no; ?></td>
            <td><?php echo $transaction->supplier->name; ?></td>
            <td><?php echo $transaction->payment_type; ?></td>
            <td></td>
            <td></td>
        </tr>
        <?php foreach ($transaction->transactionPurchaseOrderDetails as $key => $transactionDetail): ?>
            <tr style="background:#efefef;border:0px;">
                <td><?php echo $transactionDetail->product->code; ?></td>
                <td><?php echo CHtml::encode(CHtml::value($transactionDetail, 'product.name')); ?></td>
                <td><?php echo $transactionDetail->product->productMasterCategory->name; ?></td>
                <td><?php echo $transactionDetail->product->productSubMasterCategory->name; ?></td>
                <td><?php echo $transactionDetail->product->productSubCategory->name; ?></td>
                <td><?php echo $transactionDetail->quantity; ?></td>
                <td><?php echo number_format($transactionDetail->unit_price, 2); ?></td>
                <td><?php echo number_format($transactionDetail->quantity * $transactionDetail->unit_price, 2); ?></td>

                <td>
                    <table>
                        <tr>
                            <td>
                                <?php echo ($transactionDetail->discount1_type == 1 ? $transactionDetail->discount1_nominal . ' %' : (($transactionDetail->discount1_type == 2) ? $transactionDetail->discount1_nominal : (($transactionDetail->discount1_type == 3) ? 'Bonus' . ' ' . $transactionDetail->discount1_nominal : '-'))); ?>
                            </td>
                            <td><?php echo ($transactionDetail->discount2_type == 1 ? $transactionDetail->discount2_nominal . ' %' : (($transactionDetail->discount2_type == 2) ? $transactionDetail->discount2_nominal : (($transactionDetail->discount2_type == 3) ? 'Bonus' . ' ' . $transactionDetail->discount2_nominal : '-'))); ?></td>
                            <td><?php echo ($transactionDetail->discount3_type == 1 ? $transactionDetail->discount3_nominal . ' %' : (($transactionDetail->discount3_type == 2) ? $transactionDetail->discount3_nominal : (($transactionDetail->discount3_type == 3) ? 'Bonus' . ' ' . $transactionDetail->discount3_nominal : '-'))); ?></td>
                            <td><?php echo ($transactionDetail->discount4_type == 1 ? $transactionDetail->discount4_nominal . ' %' : (($transactionDetail->discount4_type == 2) ? $transactionDetail->discount4_nominal : (($transactionDetail->discount4_type == 3) ? 'Bonus' . ' ' . $transactionDetail->discount4_nominal : '-'))); ?></td>
                            <td><?php echo ($transactionDetail->discount5_type == 1 ? $transactionDetail->discount5_nominal . ' %' : (($transactionDetail->discount5_type == 2) ? $transactionDetail->discount5_nominal : (($transactionDetail->discount5_type == 3) ? 'Bonus' . ' ' . $transactionDetail->discount5_nominal : '-'))); ?></td>
                        </tr>
                    </table>
                </td>
                <td><?php echo number_format($transactionDetail->discount, 2); ?></td>
                <td> </td>
                <td></td>
                <td><?php echo number_format($transactionDetail->total_price, 2); ?></td>
            </tr>
        <?php endforeach ?>
        <tr>
            <td colspan="6"></td>
            <td>Subtotal</td>
            <td><?php echo number_format($transaction->price_before_discount, 2); ?></td>
            <td></td>
            <td></td>
            <td><?php echo number_format($transaction->discount, 2); ?></td>
            <td><?php echo number_format($transaction->ppn_price, 2); ?></td>

            <td><?php echo number_format($transaction->total_price, 2); ?></td>
        </tr>
        <?php
        $grandPbd += $transaction->price_before_discount;
        $grandDisc += $transaction->discount;
        $grandPpn += $transaction->ppn_price;
        $grandSubtotal += $transaction->subtotal;
        $grandTotal += $transaction->total_price;
        ?>
<?php endforeach ?>
    <tr>

        <td colspan="6"></td>
        <td><b>Grand Total</b></td>
        <td><b><?php echo number_format($grandPbd, 2); ?></b></td>
        <td></td>
        <td></td>
        <td><b><?php echo number_format($grandDisc, 2); ?></b></td>
        <td><b><?php echo number_format($grandPpn, 2); ?></b></td>

        <td><b><?php echo number_format($grandTotal, 2); ?></b></td>
    </tr>
</table>




