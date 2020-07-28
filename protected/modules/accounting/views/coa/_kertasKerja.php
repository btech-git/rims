<?php
Yii::app()->clientScript->registerCss('_report', '
	.price {text-align: right;}
');
?>
<?php //echo(CJSON::encode($orderPenjualanPendingSummary->dataProvider->data)); ?>

	
	<?php //if($jurnals != NULL) { ?>
	<?php $tanggal_mulai = $tanggal_mulai == "" ? date('Y-m-d') : $tanggal_mulai;
		$tanggal_sampai = $tanggal_sampai == "" ? date('Y-m-d') : $tanggal_sampai;  ?>
		<div class="reportHeader">
		    <div>PT RATU PERDANA INDAH JAYA</div>
		    <div>KERTAS KERJA</div>
		    <div>Periode: <?php //echo $tanggal_mulai .' s/d '.$tanggal_sampai; ?></div>
		   
		    <span></span><br>
		    <div>Tanggal Cetak: <?php echo date('d/m/Y'); ?></div>
		    <?php  $yesterday = date('Y-m-d', strtotime( $tanggal_mulai .'-1 days'));
			//echo $yesterday; 
		    $count = 0; ?>
		</div>
		<p></p>
		<table>
		<tr>
			<th rowspan="2">Kode AKUN</th>
			<th rowspan="2">NAMA AKUN</th>
			<th colspan="2">Saldo Awal</th>
			<th colspan="2">Mutasi</th>
			<th colspan="2">Neraca Saldo</th>
			<th colspan="2">Penyesuaian</th>
			<th colspan="2">Neraca saldo setelah penyusutan</th>
			<th colspan="2">Laporan Laba Rugi</th>
			<th colspan="2">Neraca</th>
		</tr>
		<tr>
			<th>Debet</th>
			<th>Kredit</th>
			<th>Debet</th>
			<th>Kredit</th>
			<th>Debet</th>
			<th>Kredit</th>
			<th>Debet</th>
			<th>Kredit</th>
			<th>Debet</th>
			<th>Kredit</th>
			<th>Debet</th>
			<th>Kredit</th>
			<th>Debet</th>
			<th>Kredit</th>
		</tr>
		<?php 
		 ?>
		 <?php $saldoAwalDebitTotal = $saldoAwalCreditTotal = $mutasiDebetTotal = $mutasiKreditTotal = $neracaDebitTotal = $neracaKreditTotal = $penyesuaianDebitTotal = $penyesuaianKreditTotal = $neracaPenyesuaianDebitTotal = $neracaPenyesuaianKreditTotal = $labaRugiDebitTotal = $labaRugiKreditTotal = $neracaSaldoDebitTotal = $neracaSaldoKreditTotal = 0; ?>
		<?php foreach ($showCoas as $key => $showCoa): ?>
			<?php 
					
						$JurnalCriteria = new CDbCriteria; 
						$JurnalCriteria->addCondition("coa_id = ".$showCoa->id);
						if ($company!= "") {
							$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
							$arrBranch = array();
							foreach ($branches as $key => $branchId) {
								$arrBranch[] = $branchId->id;
							}
							if ($branch != "") {
								$JurnalCriteria->addCondition("branch_id = ".$branch);
							}
							else{
								$JurnalCriteria->addInCondition('branch_id',$arrBranch);
							}
						}
						else{
							if ($branch != "") {
								$JurnalCriteria->addCondition("branch_id = ".$branch);
							}
						}
						
					  	$JurnalCriteria->addBetweenCondition('tanggal_transaksi', $showCoa->date, $tanggal_mulai);
					  	$allJurnals = JurnalUmum::model()->findAll($JurnalCriteria);
					  	//echo $yesterday;
					  	$debitTotal = $creditTotal = 0;
					  	foreach ($allJurnals as $key => $allJurnal) {
					  		if($allJurnal->debet_kredit == "D")
					  			$debitTotal += $allJurnal->total;
					  		else
					  			$creditTotal += $allJurnal->total;
					  	}

					  	if($showCoa->normal_balance== "DEBET"){
					  		$count = $showCoa->date == $tanggal_mulai ? $showCoa->opening_balance : $showCoa->opening_balance + $debitTotal - $creditTotal;
					  		//$count = $showCoa->opening_balance + $debitTotal - $creditTotal;
					  	}
					  	else{
					  		$count = $showCoa->date == $tanggal_mulai ? $showCoa->opening_balance : $showCoa->opening_balance + $creditTotal - $debitTotal;
					  		//$count = $showCoa->opening_balance + $creditTotal - $debitTotal;
					  	}
					  	// echo "DEBIT TOTAL = ".$debitTotal;
					  	// echo "KREDIT TOTAL = ".$creditTotal;
					 ?>
			<tr>
				<td><?php echo $showCoa->code; ?></td>
				<td><?php echo $showCoa->name; ?></td>
				<?php $saldoAwalDebit = $showCoa->normal_balance == 'DEBET'?$count :0;
					$saldoAwalCredit = $showCoa->normal_balance == 'KREDIT'?$count:0;
				?>
				<td><?php echo $saldoAwalDebit != 0? $saldoAwalDebit:'-'; ?></td>
				<td><?php echo $saldoAwalCredit != 0?$saldoAwalCredit:'-'; ?></td>
				<?php 
				$criteria = new CDbCriteria;
				$criteria->together = true;
				$criteria->with = array('coa');
				$criteria->addCondition("coa.coa_id = ".$showCoa->id);
				if ($branch != "")
					$criteria->addCondition("t.branch_id = ".$branch);
				$criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
				$jurnals = JurnalUmum::model()->findAll($criteria);
				$mutasiDebet = $mutasiKredit = 0;

				foreach ($jurnals as $key => $jurnal) {
					$mutasiDebet += $jurnal->debet_kredit == "D" ? $jurnal->total:0;
					$mutasiKredit += $jurnal->debet_kredit == "K" ? $jurnal->total:0;
					//$neracaSaldoDebit = $showCoa->normal_balance == 'D'? $count + $mutasiDebet - $mutasiKredit : 0;
					//$neracaSaldoCredit = $showCoa->normal_balance == 'K'? $count + $showCoa->credit - $showCoa->debit:0;
				}
				$neracaSaldoDebit = $showCoa->normal_balance == 'DEBET'? $count + $mutasiDebet - $mutasiKredit : 0;
				$neracaSaldoCredit = $showCoa->normal_balance == 'KREDIT'? $count + $mutasiKredit - $mutasiDebet:0;
				$penyesuaianDebit = ($showCoa->coa_sub_category_id == 11 || $showCoa->coa_sub_category_id == 43 ? ($showCoa->normal_balance == 'DEBET'?$mutasiDebet:0):0);
				$penyesuaianCredit = ($showCoa->coa_sub_category_id == 11 || $showCoa->coa_sub_category_id == 43 ? ($showCoa->normal_balance == 'KREDIT'?$mutasiKredit:0):0);
				$neracaSetelahPenyesuaianDebit = $neracaSaldoDebit - $penyesuaianDebit;
				$neracaSetelahPenyesuaianCredit = $neracaSaldoCredit - $penyesuaianCredit;
				$labaRugiDebit = ($showCoa->coa_category_id == 7 || $showCoa->coa_category_id == 8 ? ($showCoa->normal_balance == 'DEBET'?$mutasiDebet:0):0);
				$labaRugiCredit = ($showCoa->coa_category_id == 7 || $showCoa->coa_category_id == 8 ? ($showCoa->normal_balance == 'KREDIT'?$mutasiDebet:0):0);
				$neracaDebit = ($showCoa->coa_category_id == 1 || $showCoa->coa_category_id == 2 || $showCoa->coa_category_id == 3 || $showCoa->coa_category_id == 4 || $showCoa->coa_category_id == 5 || $showCoa->coa_category_id == 6  ? ($showCoa->normal_balance == 'DEBET'?$neracaSetelahPenyesuaianDebit:0):0);
				$neracaCredit = ($showCoa->coa_category_id == 1 || $showCoa->coa_category_id == 2 || $showCoa->coa_category_id == 3 || $showCoa->coa_category_id == 4 || $showCoa->coa_category_id == 5 || $showCoa->coa_category_id == 6  ? ($showCoa->normal_balance == 'KREDIT'?$neracaSetelahPenyesuaianCredit:0):0);
				?>
				<td><?php echo $mutasiDebet; ?></td>
				<td><?php echo $mutasiKredit; ?></td>
				<?php 
					// $totalNeraca = 0;
					// //$coaId = Array();
					// $criteria = new CDbCriteria;
					// $criteria->together = true;
					// $criteria->with = array('coa');
					// $criteria->addCondition("coa.coa_id = ".$showCoa->id);
					// $criteria->addCondition("coa.coa_category_id IN (1,2,3,4,5,6)");
					// $jurnals = JurnalUmum::model()->findAll($criteria);
					// foreach ($jurnals as $key => $jurnal) {
					// 	$totalNeraca += $jurnal->total;
					// 	//$coaId[] = $jurnal->coa_id;
					// }
				 ?>
				 <td><?php 
				 	// $neracaSaldoDebit = $showCoa->EBIT == 'D'? $count + $showCoa->debit - $showCoa->credit : 0;
				 	echo $neracaSaldoDebit == 0 ?'-': $neracaSaldoDebit; ?></td>
				 <td><?php 
				 	// $neracaSaldoCredit = $showCoa->normal_balance == 'K'? $count + $showCoa->credit - $showCoa->debit:0;
				 	echo $neracaSaldoCredit == 0? '-' : $neracaSaldoCredit; ?></td>
				
				 <td><?php 
				 	
				 	echo $penyesuaianDebit == 0 ? '-' : $penyesuaianDebit;?></td>
				 <td><?php 
				 	
				 	echo $penyesuaianCredit == 0 ? '-' : $penyesuaianCredit;?></td>
				 <td><?php 
				 	
				 echo $neracaSetelahPenyesuaianDebit == 0? '-' :$neracaSetelahPenyesuaianDebit;?></td>
				<td>
					<?php 
					echo $neracaSetelahPenyesuaianCredit == 0? '-' :$neracaSetelahPenyesuaianCredit;
					?>
				</td>
				<td><?php 
				 	
				 echo $labaRugiDebit == 0? '-' :$labaRugiDebit;?></td>
				<td>
					<?php 
					echo $labaRugiCredit == 0? '-' :$labaRugiCredit;
					?>
				</td>
				<td>
					<?php 
					echo $neracaDebit == 0? '-' :$neracaDebit;
					?>
				</td>
				<td>
					<?php 
					echo $neracaCredit == 0? '-' :$neracaCredit;
					?>
				</td>
				<?php  
					$saldoAwalDebitTotal += $saldoAwalDebit;
					$saldoAwalCreditTotal += $saldoAwalCredit;
					$mutasiDebetTotal += $mutasiDebet;
					$mutasiKreditTotal += $mutasiKredit;
					$neracaDebitTotal += $neracaDebit;
					$neracaKreditTotal += $neracaCredit;
					$penyesuaianDebitTotal += $penyesuaianDebit;
					$penyesuaianKreditTotal += $penyesuaianCredit;
					$neracaPenyesuaianDebitTotal += $neracaSetelahPenyesuaianDebit;
					$neracaPenyesuaianKreditTotal += $neracaSetelahPenyesuaianCredit;
					$labaRugiDebitTotal += $labaRugiDebit;
					$labaRugiKreditTotal += $labaRugiCredit;
					$neracaSaldoDebitTotal += $neracaSaldoDebit;
					$neracaSaldoKreditTotal += $neracaSaldoCredit;
				?>
			</tr>
		<?php endforeach ?>
		<tr>
			<td colspan="2">Total</td>
			<td><?php echo $saldoAwalDebitTotal; ?></td>
			<td><?php echo $saldoAwalCreditTotal; ?></td>
			<td><?php echo $mutasiDebetTotal; ?></td>
			<td><?php echo $mutasiKreditTotal; ?></td>
			<td><?php echo $neracaSaldoDebitTotal; ?></td>
			<td><?php echo $neracaSaldoKreditTotal; ?></td>
			<td><?php echo $penyesuaianDebitTotal; ?></td>
			<td><?php echo $penyesuaianKreditTotal; ?></td>
			<td><?php echo $neracaPenyesuaianDebitTotal; ?></td>
			<td><?php echo $neracaPenyesuaianKreditTotal; ?></td>
			<td><?php echo $labaRugiDebitTotal; ?></td>
			<td><?php echo $labaRugiKreditTotal; ?></td>
			<td><?php echo $neracaDebitTotal; ?></td>
			<td><?php echo $neracaKreditTotal; ?></td>
		</tr>
		<tr>
			<td colspan="2">Netloss</td>
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
			<td><?php $netlossDebit = 0; echo $netlossDebit == 0 ? '-' : $netlossDebit; ?></td>
			<td><?php $netlossCredit = $labaRugiDebitTotal - $labaRugiKreditTotal; echo $netlossCredit == 0 ? '-' : $netlossCredit;  ?></td>
			<td><?php $netlossNeracaDebit = $neracaKreditTotal - $neracaDebitTotal; echo $netlossNeracaDebit ==  0 ? '-' : $netlossNeracaDebit; ?></td>
			<td><?php $netlossNeracaCredit = 0; echo $netlossNeracaCredit == 0 ?'-' :$netlossNeracaCredit; ?></td>
		</tr>
		<tr>
			<td colspan="2">-</td>
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
			<td><?php echo $labaRugiDebitTotal + $netlossDebit; ?></td>
			<td><?php echo $labaRugiKreditTotal + $netlossCredit; ?></td>
			<td><?php echo $neracaDebitTotal + $netlossNeracaDebit; ?></td>
			<td><?php echo $neracaKreditTotal + $netlossNeracaCredit; ?></td>
		</tr>
	</table>
	<?php //} ?>
	
