<?php
Yii::app()->clientScript->registerCss('_report', '
	.price {text-align: right;}
');
?>
<?php //echo(CJSON::encode($orderPenjualanPendingSummary->dataProvider->data)); ?>

	
	<?php if($transaksiPembelianSummary->dataProvider->data != NULL) { ?>
		<div class="reportHeader">
		    <div>PT. Bahtera Adi Jaya</div>
		    <div>Daftar Transaksi Pembelian</div>
		    <div>Periode: <?php echo $tanggal_mulai .' s/d '.$tanggal_sampai; ?></div>
		   
		    <span></span><br>
		    <div>Tanggal Cetak: <?php echo date('d/m/Y'); ?></div>
		</div>
		<p></p>
		<table class="table addDetail">
			<tr>
				<th>Kode Transaksi</th>
				<th>Tanggal Transaksi</th>
				<th>No Pemasok</th>
				<th>Nama Pemasok</th>
				<th>FC</th>
				<th>No Persediaan</th>
				<th>Nama Persediaan</th>
				<th>Satuan</th>
				<th>Kuantitas</th>
				<th>Pecahan</th>
				<th>Harga Satuan</th>
				<th>Jumlah HC</th>
				<th>Jumlah FC</th>
				<th>Tanggal/Jam Entry</th>
				<th>User ID</th>
			</tr>
			<?php $totalPembelianHc =0;
					$dppHc = 0;
					$ppnHc = 0;
			 ?>
			<?php foreach ($transaksiPembelianSummary->dataProvider->data as $header): ?>
				<?php foreach ($header->transaksiOrderPembelianDetails as $detail): ?>
					<tr>
						<td><?php echo $header->kode; ?></td>
						<td><?php echo $header->tanggal_order_pembelian; ?></td>
						<td><?php echo $header->pemasok->kode; ?></td>
						<td><?php echo $header->pemasok->nama; ?></td>
						<td><?php echo $header->valas; ?></td>
						<td><?php echo $detail->jenisPersediaan->kode; ?></td>
						<td><?php echo $detail->jenisPersediaan->nama; ?></td>
						<td><?php echo $detail->satuan; ?></td>
						<td><?php echo $detail->kuantitas_order_pembelian; ?></td>
						<td><?php echo $detail->pecahan_order_pembelian; ?></td>
						<td class="price"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->harga_satuan)); ?></td>
						<td class="price"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->jumlah_mata_uang_lokal)); ?></td>
						<td class="price"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->jumlah_mata_uang_asing)); ?></td>
						<td><?php echo $header->tanggal_input; ?></td>
						<td><?php echo $header->user_id; ?></td>
					</tr>

				<?php endforeach; ?>
				<tr>
					
					<td></td>
					<td></td>
					<td></td>
					<td>No pesanan</td>
					<td><?php echo $detail->permintaanPembelian->kode; ?></td>
					<td></td>
					<td></td>
					<td></td>
					<td>Distribusi GL Hutang</td>
					<td><?php echo $header->pemasok->distribusiGlHutangDagang->kode; ?></td>
					<td><?php echo $header->pemasok->distribusiGlHutangDagang->nama; ?></td>
					<td>HC</td>
					<td>FC</td>
					<td></td>
					<td></td>
					
					
				</tr>
				<tr>
					
					<td></td>
					<td></td>
					<td></td>
					<td>Tanggal pesanan</td>
					<td><?php echo $detail->tanggal_permintaan_pembelian; ?></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>Subtotal</td>
					<td class="price"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->jumlah_mata_uang_lokal)); ?></td>
					<td class="price"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->jumlah_mata_uang_asing)); ?></td>
					<td></td>
					<td></td>
					
					
				</tr>
				<tr>
					
					<td></td>
					<td></td>
					<td></td>
					<td>Jk Waktu Kredit</td>
					<td><?php echo $header->pemasok->tenor; ?></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>Dasar Kena Pajak</td>
					<td class="price"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->dasar_pengenaan_pajak_mata_uang_lokal)); ?></td>
					<td class="price"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->dasar_pengenaan_pajak_mata_uang_asing)); ?></td>
					<td></td>
					<td></td>
					
					
				</tr>
				<tr>
					
					<td></td>
					<td></td>
					<td></td>
					<td>Keterangan</td>
					<td><?php //echo $header->tenor; ?></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>PPN non PPN</td>
					<td class="price"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->ppn_hc)); ?></td>
					<td class="price"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->ppn_fc)); ?></td>
					<td></td>
					<td></td>
					
					
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>Total</td>
					<td class="price"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->total_mata_uang_lokal)); ?></td>
					<td class="price"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->total_mata_uang_asing)); ?></td>
					<td></td>
					<td></td>
					
					
				</tr>
				<?php 
					$totalPembelianHc += $header->total_mata_uang_lokal;
					$dppHc += $header->dasar_pengenaan_pajak_mata_uang_lokal;
					$ppnHc += $header->ppn_hc;
				 ?>
				
			<?php endforeach; ?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>Grand Total</td>
				<td>Dasar Kena Pajak</td>
				<td class="price"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dppHc)); ?></td>
				<td></td>
				<td></td>
					
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>PPN</td>
				<td class="price"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $ppnHc)); ?></td>
				<td></td>
				<td></td>
					
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>Total</td>
				<td class="price"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPembelianHc)); ?></td>
				<td></td>
				<td></td>
					
			</tr>
		</table>
	<?php } ?>
	
