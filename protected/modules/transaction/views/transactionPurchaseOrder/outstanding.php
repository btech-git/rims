<?php
/* @var $this PaymentInController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Outstanding Hutang',
);

// $this->menu=array(
// 	array('label'=>'Create PaymentIn', 'url'=>array('create')),
// 	array('label'=>'Manage PaymentIn', 'url'=>array('admin')),
// );
?>
<div id="maincontent">
	<div class="row">
		<table>
			<thead>
				<tr>
					<th>Nama Supplier</th>
					<th>Tgl Pembelian</th>
					<th>Tgl Jatuh Tempo</th>
					<th>No. Document</th>
					<th>Kode Barang</th>
					<th>Total Pembelian</th>
					<th>PPN</th>
					<th>Diskon</th>
					<th>Total Bayar</th>
					<th>Total Hutang</th>
					<th>Tgl Bayar</th>
					<th>No. Pelunasan</th>
					<th>Kode Bank</th>
				</tr>
			</thead>
			<tbody>
				<?php $subtotals = $ppns = $discounts = $payments = $hutangs = 0; ?>
				<?php foreach ($outstandings as $key => $outstanding): ?>
					<tr>
						<td><?php echo $outstanding->supplier->name; ?></td>
						<td><?php echo $outstanding->purchase_order_date; ?></td>
						<td></td>
						<td><?php echo $outstanding->purchase_order_no; ?></td>
						<td></td>
						<td><?php echo $outstanding->subtotal; ?></td>
						<td><?php echo $outstanding->ppn_price; ?></td>
						<td><?php echo $outstanding->discount; ?></td>
						<td><?php echo $outstanding->payment_amount; ?></td>
						<?php $total = $outstanding->subtotal - $outstanding->ppn_price - $outstanding->discount - $outstanding->payment_amount; ?>
						<td><?php echo $total; ?></td>
						<td>
							<?php foreach ($outstanding->paymentOuts as $key => $payment): ?>
								<?php echo $payment->payment_date.' , '; ?>
							<?php endforeach ?>
						</td>
						<td>
							<?php foreach ($outstanding->paymentOuts as $key => $payment): ?>
								<?php echo $payment->payment_number.' , '; ?>
							<?php endforeach ?>
						</td>
						<td><?php echo $outstanding->companyBank!=""?$outstanding->companyBank->coa->name:'-' ?></td>
					</tr>
					<?php $subtotals += $outstanding->subtotal; ?>
					<?php $ppns += $outstanding->ppn_price; ?>
					<?php $discounts += $outstanding->discount; ?>
					<?php $payments += $outstanding->payment_amount; ?>
					<?php $hutangs += $total; ?>
				<?php endforeach ?>
				<tr>
					<td></td>
					<td></td>
					<td><strong>Total</strong></td>
					<td></td>
					<td></td>
					<td><strong><?php echo $subtotals ?></strong></td>
					<td><strong><?php echo $ppns ?></strong></td>
					<td><strong><?php echo $discounts ?></strong></td>
					<td><strong><?php echo $payments ?></strong></td>
					<td><strong><?php echo $hutangs ?></strong></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>