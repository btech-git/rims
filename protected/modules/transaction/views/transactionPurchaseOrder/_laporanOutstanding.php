<?php
Yii::app()->clientScript->registerCss('_report', '
	.price {text-align: right;}
');
?>

<div class="reportHeader">
    <div>PT RATU PERDANA INDAH JAYA</div>
    <div>OUTSTANDING PEMBELIAN</div>
    <div>Periode: <?php echo $tanggal_mulai . ' s/d ' . $tanggal_sampai; ?></div>

    <span></span><br />
    <div>Tanggal Cetak: <?php echo date('d/m/Y'); ?></div>
</div>

<br />

<table class="reportTable">
    <tr>
        <th>Nama Supplier</th>
        <th>TGL Pembelian</th>
        <th>TGL Jatuh Tempo</th>
        <th>No Dokumen</th>
        <th>Kode Barang</th>
        <th>Total Pembelian</th>
        <th>PPN</th>
        <th>Diskon</th>
        <th>Total Bayar</th>
        <th>Total Hutang</th>
        <th>TGL Bayar</th>
        <th>NO Pelunasan</th>
        <th>Kode Bank</th>
    </tr>
    <?php $totalPembelian = $ppn = $discount = $bayar = $hutang = 0; ?>
    <?php foreach ($transactions as $key => $transaction): ?>
        <?php $po = TransactionPurchaseOrder::model()->findByPk($transaction->transaction_id); ?>
        <?php if (!empty($po)) :?>
        <tr>
            <td><?php echo CHtml::encode(CHtml::value($po, 'supplier.name')); ?></td>
            <td><?php echo $po->purchase_order_date; ?></td>
            <td><?php echo $transaction->due_date; ?></td>
            <td><?php echo $po->purchase_order_no; ?></td>
            <td></td>
            <td><?php echo number_format($po->subtotal, 2); ?></td>
            <td><?php echo number_format($po->ppn_price, 2); ?></td>
            <td><?php echo number_format($po->discount, 2); ?></td>
            <td><?php echo number_format($transaction->realization_balance, 2); ?></td>
            <td><?php echo number_format($po->total_price, 2); ?></td>
            <td><?php echo $transaction->realization_date; ?></td>
            <td></td>
            <td></td>
        </tr>
        <?php endif; ?>
        
        <?php
        $totalPembelian += $po->subtotal;
        $ppn += $po->ppn_price;
        $discount += $po->discount;
        $bayar += $transaction->realization_balance;
        $hutang += $po->total_price;
        ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="4">&nbsp;</td>
        <td><b>Total</b></td>
        <td><b><?php echo number_format($totalPembelian, 2); ?></b></td>
        <td><b><?php echo number_format($ppn, 2); ?></b></td>
        <td><b><?php echo number_format($discount, 2); ?></b></td>
        <td><b><?php echo number_format($bayar, 2); ?></b></td>
        <td><b><?php echo number_format($hutang, 2); ?></b></td>
    </tr>
</table>



