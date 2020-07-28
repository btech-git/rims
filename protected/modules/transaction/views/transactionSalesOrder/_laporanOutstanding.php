<?php
Yii::app()->clientScript->registerCss('_resort', '
	.price {text-align: right;}
');
?>
<?php //echo(CJSON::encode($orderPenjualanPendingSummary->dataProvider->data)); ?>

	
	
		<div class="resortHeader">
		    <div>PT RATU PERDANA INDAH JAYA</div>
		    <div>OUTSTANDING PENJUALAN</div>
		    <div>Periode: <?php echo $tanggal_mulai .' s/d '.$tanggal_sampai; ?></div>
		   
		    <span></span><br>
		    <div>Tanggal Cetak: <?php echo date('d/m/Y'); ?></div>
		</div>
		<p></p>
		<table>
			<tr>
				<th>Nama Customer</th>
				<th>TGL NOTA</th>
				<th>TGL Jatuh Tempo</th>
				<th>No NOTA</th>
				<th>No Polisi</th>
				<th>Total Nota</th>
				<th>PPH 23</th>
				<th>Lain2</th>
				<th>Total Bayar</th>
				<th>Total Piutang</th>
				<th>TGL Bayar</th>
				<th>NO Pelunasan</th>
				<th>Kode Bank</th>
			</tr>
		<?php  $totalNota = $ppn = $lain = $bayar = $piutang = 0;  ?>
		<?php foreach ($transactions as $key => $transaction): ?>
			<?php $so = TransactionSalesOrder::model()->findByPk($transaction->transaction_id); ?>
			<?php if (count($so)!=0) :?>
				<tr>
				<td><?php echo $so->customer->name; ?></td>
				<td><?php echo $so->sale_order_date; ?></td>
				<td><?php echo $transaction->due_date; ?></td>
				<td><?php echo $so->sale_order_no; ?></td>
				<td></td>
				<td><?php echo number_format($so->subtotal,2); ?></td>
				<td><?php echo number_format($so->ppn_price,2); ?></td>
				<td><?php echo number_format($so->discount,2); ?></td>
				<td><?php echo number_format($transaction->realization_balance,2); ?></td>
				<td><?php echo number_format($so->total_price,2); ?></td>
				<td><?php echo $transaction->realization_date; ?></td>
				<td></td>
				<td></td>
			</tr>
			<?php 
				$totalNota += $so->subtotal;
				$ppn += $so->ppn_price;
				$lain += $so->discount;
				$bayar += $transaction->realization_balance;
				$piutang += $so->total_price;
			 ?>
			<?php endif; ?>
			
		<?php endforeach ?>
		<tr>
			<td colspan="4">&nbsp;</td>
			<td><b>Total</b></td>
			<td><b><?php echo number_format($totalNota,2); ?></b></td>
			<td><b><?php echo number_format($ppn,2); ?></b></td>
			<td><b><?php echo number_format($lain,2); ?></b></td>
			<td><b><?php echo number_format($bayar,2); ?></b></td>
			<td><b><?php echo number_format($piutang,2); ?></b></td>
		</tr>
		</table>
			
	
	
