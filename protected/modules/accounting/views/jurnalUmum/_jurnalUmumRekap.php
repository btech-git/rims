<?php
Yii::app()->clientScript->registerCss('_report', '
	.price {text-align: right;}
');
?>
<?php //echo(CJSON::encode($orderPenjualanPendingSummary->dataProvider->data)); ?>

	
	<?php //if($jurnals != NULL) { ?>
		<div class="reportHeader">
		    <div>PT RATU PERDANA INDAH JAYA</div>
		    <div>JURNAL UMUM REKAP</div>
		    <div>Periode: <?php echo $year; ?></div>
		   
		    <span></span><br>
		    <div>Tanggal Cetak: <?php echo date('d/m/Y'); ?></div>
		</div>
		<p></p>
		<table>
		<tr>
			<th rowspan="2">Kode AKUN</th>
			<th rowspan="2">NAMA AKUN</th>
			<th colspan="2">JANUARI</th>
			<th colspan="2">FEBRUARI</th>
			<th colspan="2">MARET</th>
			<th colspan="2">APRIL</th>
			<th colspan="2">MEI</th>
			<th colspan="2">JUNI</th>
			<th colspan="2">JULI</th>
			<th colspan="2">AGUSTUS</th>
			<th colspan="2">SEPTEMBER</th>
			<th colspan="2">OKTOBER</th>
			<th colspan="2">NOVEMBER</th>
			<th colspan="2">DESEMBER</th>
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
			$year = $year == "" ? date('Y') : $year;
		 ?>
		 <?php $mutasiDebetJanTotal = $mutasiDebetFebTotal = $mutasiDebetMarTotal = $mutasiDebetAprTotal = $mutasiDebetMeiTotal = $mutasiDebetJunTotal = $mutasiDebetJulTotal = $mutasiDebetAugTotal = $mutasiDebetSepTotal = $mutasiDebetOktTotal = $mutasiDebetNovTotal = $mutasiDebetDesTotal = 0; 
		 	$mutasiKreditJanTotal = $mutasiKreditFebTotal = $mutasiKreditMarTotal = $mutasiKreditAprTotal = $mutasiKreditMeiTotal = $mutasiKreditJunTotal = $mutasiKreditJulTotal = $mutasiKreditAugTotal = $mutasiKreditSepTotal = $mutasiKreditOktTotal = $mutasiKreditNovTotal = $mutasiKreditDesTotal = 0;

		 ?>
		<?php foreach ($showCoas as $key => $showCoa): ?>
			<tr>
				<td><?php echo $showCoa->code; ?></td>
				<td><?php echo $showCoa->name; ?></td>

				
				<?php 
				$janCriteria = new CDbCriteria;
				$janCriteria->together = true;
				$janCriteria->with = array('coa');
				$janCriteria->addCondition("coa.coa_id = ".$showCoa->id);
				if ($company!= "") {
					$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
					$arrBranch = array();
					foreach ($branches as $key => $branchId) {
						$arrBranch[] = $branchId->id;
					}
					if ($branch != "") {
						$janCriteria->addCondition("branch_id = ".$branch);
					}
					else{
						$janCriteria->addInCondition('branch_id',$arrBranch);
					}
				}
				else{
					if ($branch != "") {
						$janCriteria->addCondition("branch_id = ".$branch);
					}
				}
				$janCriteria->addCondition("YEAR(tanggal_transaksi) = ".$year);
					$janCriteria->addCondition("MONTH(tanggal_transaksi) = 1");
				// $criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
				$jurnals = JurnalUmum::model()->findAll($janCriteria);
				$mutasiDebetJan = $mutasiKreditJan = 0;
				foreach ($jurnals as $key => $jurnal) {
					$mutasiDebetJan += $jurnal->debet_kredit == "D" ? $jurnal->total:0;
					$mutasiKreditJan += $jurnal->debet_kredit == "K" ? $jurnal->total:0;
					
					
				}
				
				?>
				<td><?php echo number_format($mutasiDebetJan,2); ?></td>
				<td><?php echo number_format($mutasiKreditJan,2); ?></td>
				<?php 
				$febCriteria = new CDbCriteria;
				$febCriteria->together = true;
				$febCriteria->with = array('coa');
				$febCriteria->addCondition("coa.coa_id = ".$showCoa->id);
				if ($company!= "") {
					$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
					$arrBranch = array();
					foreach ($branches as $key => $branchId) {
						$arrBranch[] = $branchId->id;
					}
					if ($branch != "") {
						$febCriteria->addCondition("branch_id = ".$branch);
					}
					else{
						$febCriteria->addInCondition('branch_id',$arrBranch);
					}
				}
				else{
					if ($branch != "") {
						$febCriteria->addCondition("branch_id = ".$branch);
					}
				}
				$febCriteria->addCondition("YEAR(tanggal_transaksi) = " .$year);
					$febCriteria->addCondition("MONTH(tanggal_transaksi) = 2");
				// $criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
				$jurnalFebs = JurnalUmum::model()->findAll($febCriteria);
				$mutasiDebetFeb = $mutasiKreditFeb = 0;
				foreach ($jurnalFebs as $key => $jurnal) {
					$mutasiDebetFeb += $jurnal->debet_kredit == "D" ? $jurnal->total:0;
					$mutasiKreditFeb += $jurnal->debet_kredit == "K" ? $jurnal->total:0;
					
				}
				
				?>
				<td><?php echo number_format($mutasiDebetFeb,2); ?></td>
				<td><?php echo number_format($mutasiKreditFeb,2); ?></td>
				<?php 
				$marCriteria = new CDbCriteria;
				$marCriteria->together = true;
				$marCriteria->with = array('coa');
				$marCriteria->addCondition("coa.coa_id = ".$showCoa->id);
				if ($company!= "") {
					$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
					$arrBranch = array();
					foreach ($branches as $key => $branchId) {
						$arrBranch[] = $branchId->id;
					}
					if ($branch != "") {
						$marCriteria->addCondition("branch_id = ".$branch);
					}
					else{
						$marCriteria->addInCondition('branch_id',$arrBranch);
					}
				}
				else{
					if ($branch != "") {
						$marCriteria->addCondition("branch_id = ".$branch);
					}
				}
				$marCriteria->addCondition("YEAR(tanggal_transaksi) = " .$year);
					$marCriteria->addCondition("MONTH(tanggal_transaksi) = 3");
				// $criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
				$jurnalMars = JurnalUmum::model()->findAll($marCriteria);
				$mutasiDebetMar = $mutasiKreditMar = 0;
				foreach ($jurnalMars as $key => $jurnal) {
					$mutasiDebetMar += $jurnal->debet_kredit == "D" ? $jurnal->total:0;
					$mutasiKreditMar += $jurnal->debet_kredit == "K" ? $jurnal->total:0;
					
				}
				
				?>
				<td><?php echo number_format($mutasiDebetMar,2); ?></td>
				<td><?php echo number_format($mutasiKreditMar,2); ?></td>
				<?php 
				$aprCriteria = new CDbCriteria;
				$aprCriteria->together = true;
				$aprCriteria->with = array('coa');
				$aprCriteria->addCondition("coa.coa_id = ".$showCoa->id);
				if ($company!= "") {
					$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
					$arrBranch = array();
					foreach ($branches as $key => $branchId) {
						$arrBranch[] = $branchId->id;
					}
					if ($branch != "") {
						$aprCriteria->addCondition("branch_id = ".$branch);
					}
					else{
						$aprCriteria->addInCondition('branch_id',$arrBranch);
					}
				}
				else{
					if ($branch != "") {
						$aprCriteria->addCondition("branch_id = ".$branch);
					}
				}
				$aprCriteria->addCondition("YEAR(tanggal_transaksi) = " .$year);
					$aprCriteria->addCondition("MONTH(tanggal_transaksi) = 4");
				// $criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
				$jurnalAprs = JurnalUmum::model()->findAll($aprCriteria);
				$mutasiDebetApr = $mutasiKreditApr = 0;
				foreach ($jurnalAprs as $key => $jurnal) {
					$mutasiDebetApr += $jurnal->debet_kredit == "D" ? $jurnal->total:0;
					$mutasiKreditApr += $jurnal->debet_kredit == "K" ? $jurnal->total:0;
					
				}
				
				?>
				<td><?php echo number_format($mutasiDebetApr,2); ?></td>
				<td><?php echo number_format($mutasiKreditApr,2); ?></td>
				<?php 
				$meiCriteria = new CDbCriteria;
				$meiCriteria->together = true;
				$meiCriteria->with = array('coa');
				$meiCriteria->addCondition("coa.coa_id = ".$showCoa->id);
				if ($company!= "") {
					$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
					$arrBranch = array();
					foreach ($branches as $key => $branchId) {
						$arrBranch[] = $branchId->id;
					}
					if ($branch != "") {
						$meiCriteria->addCondition("branch_id = ".$branch);
					}
					else{
						$meiCriteria->addInCondition('branch_id',$arrBranch);
					}
				}
				else{
					if ($branch != "") {
						$meiCriteria->addCondition("branch_id = ".$branch);
					}
				}
				$meiCriteria->addCondition("YEAR(tanggal_transaksi) = " .$year);
					$meiCriteria->addCondition("MONTH(tanggal_transaksi) = 5");
				// $criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
				$jurnalMeis = JurnalUmum::model()->findAll($meiCriteria);
				$mutasiDebetMei = $mutasiKreditMei = 0;
				foreach ($jurnalMeis as $key => $jurnal) {
					$mutasiDebetMei += $jurnal->debet_kredit == "D" ? $jurnal->total:0;
					$mutasiKreditMei += $jurnal->debet_kredit == "K" ? $jurnal->total:0;
					
				}
				
				?>
				<td><?php echo number_format($mutasiDebetMei,2); ?></td>
				<td><?php echo number_format($mutasiKreditMei,2); ?></td>
				<?php 
				$juniCriteria = new CDbCriteria;
				$juniCriteria->together = true;
				$juniCriteria->with = array('coa');
				$juniCriteria->addCondition("coa.coa_id = ".$showCoa->id);
				if ($company!= "") {
					$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
					$arrBranch = array();
					foreach ($branches as $key => $branchId) {
						$arrBranch[] = $branchId->id;
					}
					if ($branch != "") {
						$juniCriteria->addCondition("branch_id = ".$branch);
					}
					else{
						$juniCriteria->addInCondition('branch_id',$arrBranch);
					}
				}
				else{
					if ($branch != "") {
						$juniCriteria->addCondition("branch_id = ".$branch);
					}
				}
				$juniCriteria->addCondition("YEAR(tanggal_transaksi) = " .$year);
					$juniCriteria->addCondition("MONTH(tanggal_transaksi) = 6");
				// $criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
				$jurnalJunis = JurnalUmum::model()->findAll($juniCriteria);
				$mutasiDebetJuni = $mutasiKreditJuni = 0;
				foreach ($jurnalJunis as $key => $jurnal) {
					$mutasiDebetJuni += $jurnal->debet_kredit == "D" ? $jurnal->total:0;
					$mutasiKreditJuni += $jurnal->debet_kredit == "K" ? $jurnal->total:0;
					
				}
				
				?>
				<td><?php echo number_format($mutasiDebetJuni,2); ?></td>
				<td><?php echo number_format($mutasiKreditJuni,2); ?></td>


				
				<?php 
				$juliCriteria = new CDbCriteria;
				$juliCriteria->together = true;
				$juliCriteria->with = array('coa');
				$juliCriteria->addCondition("coa.coa_id = ".$showCoa->id);
				if ($company!= "") {
					$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
					$arrBranch = array();
					foreach ($branches as $key => $branchId) {
						$arrBranch[] = $branchId->id;
					}
					if ($branch != "") {
						$juliCriteria->addCondition("branch_id = ".$branch);
					}
					else{
						$juliCriteria->addInCondition('branch_id',$arrBranch);
					}
				}
				else{
					if ($branch != "") {
						$juliCriteria->addCondition("branch_id = ".$branch);
					}
				}
				$juliCriteria->addCondition("YEAR(tanggal_transaksi) = " .$year);
					$juliCriteria->addCondition("MONTH(tanggal_transaksi) = 7");
				// $criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
				$jurnalJulis = JurnalUmum::model()->findAll($juliCriteria);
				$mutasiDebetJuli = $mutasiKreditJuli = 0;
				foreach ($jurnalJulis as $key => $jurnal) {
					$mutasiDebetJuli += $jurnal->debet_kredit == "D" ? $jurnal->total:0;
					$mutasiKreditJuli += $jurnal->debet_kredit == "K" ? $jurnal->total:0;
					
				}
				
				?>
				<td><?php echo number_format($mutasiDebetJuli,2); ?></td>
				<td><?php echo number_format($mutasiKreditJuli,2); ?></td>
				<?php 
				$AgCriteria = new CDbCriteria;
				$AgCriteria->together = true;
				$AgCriteria->with = array('coa');
				$AgCriteria->addCondition("coa.coa_id = ".$showCoa->id);
				if ($company!= "") {
					$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
					$arrBranch = array();
					foreach ($branches as $key => $branchId) {
						$arrBranch[] = $branchId->id;
					}
					if ($branch != "") {
						$AgCriteria->addCondition("branch_id = ".$branch);
					}
					else{
						$AgCriteria->addInCondition('branch_id',$arrBranch);
					}
				}
				else{
					if ($branch != "") {
						$AgCriteria->addCondition("branch_id = ".$branch);
					}
				}
				$AgCriteria->addCondition("YEAR(tanggal_transaksi) = " .$year);
					$AgCriteria->addCondition("MONTH(tanggal_transaksi) = 8");
				// $criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
				$jurnalAgs = JurnalUmum::model()->findAll($AgCriteria);
				$mutasiDebetAg = $mutasiKreditAg = 0;
				foreach ($jurnalAgs as $key => $jurnal) {
					$mutasiDebetAg += $jurnal->debet_kredit == "D" ? $jurnal->total:0;
					$mutasiKreditAg += $jurnal->debet_kredit == "K" ? $jurnal->total:0;
					
				}
				
				?>
				<td><?php echo number_format($mutasiDebetAg,2); ?></td>
				<td><?php echo number_format($mutasiKreditAg,2); ?></td>

				<?php 
				$sepCriteria = new CDbCriteria;
				$sepCriteria->together = true;
				$sepCriteria->with = array('coa');
				$sepCriteria->addCondition("coa.coa_id = ".$showCoa->id);
				if ($company!= "") {
					$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
					$arrBranch = array();
					foreach ($branches as $key => $branchId) {
						$arrBranch[] = $branchId->id;
					}
					if ($branch != "") {
						$sepCriteria->addCondition("branch_id = ".$branch);
					}
					else{
						$sepCriteria->addInCondition('branch_id',$arrBranch);
					}
				}
				else{
					if ($branch != "") {
						$sepCriteria->addCondition("branch_id = ".$branch);
					}
				}
				$sepCriteria->addCondition("YEAR(tanggal_transaksi) = " .$year);
					$sepCriteria->addCondition("MONTH(tanggal_transaksi) = 9");
				// $criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
				$jurnalSeps = JurnalUmum::model()->findAll($sepCriteria);
				$mutasiDebetSep = $mutasiKreditSep = 0;
				foreach ($jurnalSeps as $key => $jurnal) {
					$mutasiDebetSep += $jurnal->debet_kredit == "D" ? $jurnal->total:0;
					$mutasiKreditSep += $jurnal->debet_kredit == "K" ? $jurnal->total:0;
					
				}
				
				?>
				<td><?php echo number_format($mutasiDebetSep,2); ?></td>
				<td><?php echo number_format($mutasiKreditSep,2); ?></td>
				<?php 
				$oktCriteria = new CDbCriteria;
				$oktCriteria->together = true;
				$oktCriteria->with = array('coa');
				$oktCriteria->addCondition("coa.coa_id = ".$showCoa->id);
				if ($company!= "") {
					$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
					$arrBranch = array();
					foreach ($branches as $key => $branchId) {
						$arrBranch[] = $branchId->id;
					}
					if ($branch != "") {
						$oktCriteria->addCondition("branch_id = ".$branch);
					}
					else{
						$oktCriteria->addInCondition('branch_id',$arrBranch);
					}
				}
				else{
					if ($branch != "") {
						$oktCriteria->addCondition("branch_id = ".$branch);
					}
				}

				$oktCriteria->addCondition("YEAR(tanggal_transaksi) = " .$year);
					$oktCriteria->addCondition("MONTH(tanggal_transaksi) = 10");
				// $criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
				$jurnalOkts = JurnalUmum::model()->findAll($oktCriteria);
				$mutasiDebetOkt = $mutasiKreditOkt = 0;
				foreach ($jurnalOkts as $key => $jurnal) {
					$mutasiDebetOkt += $jurnal->debet_kredit == "D" ? $jurnal->total:0;
					$mutasiKreditOkt += $jurnal->debet_kredit == "K" ? $jurnal->total:0;
					
				}
				
				?>
				<td><?php echo number_format($mutasiDebetOkt,2); ?></td>
				<td><?php echo number_format($mutasiKreditOkt,2); ?></td>
				<?php 
				$novCriteria = new CDbCriteria;
				$novCriteria->together = true;
				$novCriteria->with = array('coa');
				$novCriteria->addCondition("coa.coa_id = ".$showCoa->id);
				if ($company!= "") {
					$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
					$arrBranch = array();
					foreach ($branches as $key => $branchId) {
						$arrBranch[] = $branchId->id;
					}
					if ($branch != "") {
						$novCriteria->addCondition("branch_id = ".$branch);
					}
					else{
						$novCriteria->addInCondition('branch_id',$arrBranch);
					}
				}
				else{
					if ($branch != "") {
						$novCriteria->addCondition("branch_id = ".$branch);
					}
				}
				$novCriteria->addCondition("YEAR(tanggal_transaksi) = " .$year);
					$novCriteria->addCondition("MONTH(tanggal_transaksi) = 11");
				// $criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
				$jurnalNovs = JurnalUmum::model()->findAll($novCriteria);
				$mutasiDebetNov = $mutasiKreditNov = 0;
				foreach ($jurnalNovs as $key => $jurnal) {
					$mutasiDebetNov += $jurnal->debet_kredit == "D" ? $jurnal->total:0;
					$mutasiKreditNov += $jurnal->debet_kredit == "K" ? $jurnal->total:0;
					
				}
				
				?>
				<td><?php echo number_format($mutasiDebetNov,2); ?></td>
				<td><?php echo number_format($mutasiKreditNov,2); ?></td>
				<?php 
				$desCriteria = new CDbCriteria;
				$desCriteria->together = true;
				$desCriteria->with = array('coa');
				$desCriteria->addCondition("coa.coa_id = ".$showCoa->id);
				if ($company!= "") {
					$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
					$arrBranch = array();
					foreach ($branches as $key => $branchId) {
						$arrBranch[] = $branchId->id;
					}
					if ($branch != "") {
						$desCriteria->addCondition("branch_id = ".$branch);
					}
					else{
						$desCriteria->addInCondition('branch_id',$arrBranch);
					}
				}
				else{
					if ($branch != "") {
						$desCriteria->addCondition("branch_id = ".$branch);
					}
				}
				$desCriteria->addCondition("YEAR(tanggal_transaksi) = ".$year);
				$desCriteria->addCondition("MONTH(tanggal_transaksi) = 12");
				// $criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
				$jurnalDess = JurnalUmum::model()->findAll($desCriteria);
				$mutasiDebetDes = $mutasiKreditDes = 0;
				foreach ($jurnalDess as $key => $jurnal) {
					$mutasiDebetDes += $jurnal->debet_kredit == "D" ? $jurnal->total:0;
					$mutasiKreditDes += $jurnal->debet_kredit == "K" ? $jurnal->total:0;
					
				}
				
				?>
				<td><?php echo number_format($mutasiDebetDes,2); ?></td>
				<td><?php echo number_format($mutasiKreditDes,2); ?></td>

				<?php 
					$mutasiDebetJanTotal += $mutasiDebetJan;
					$mutasiDebetFebTotal += $mutasiDebetFeb;
					$mutasiDebetMarTotal += $mutasiDebetMar;
					$mutasiDebetAprTotal += $mutasiDebetApr;
					$mutasiDebetMeiTotal += $mutasiDebetMei;
					$mutasiDebetJunTotal += $mutasiDebetJuni;
					$mutasiDebetJulTotal += $mutasiDebetJuli;
					$mutasiDebetAugTotal += $mutasiDebetAg;
					$mutasiDebetSepTotal += $mutasiDebetSep;
					$mutasiDebetOktTotal += $mutasiDebetOkt;
					$mutasiDebetNovTotal += $mutasiDebetNov;
					$mutasiDebetDesTotal += $mutasiDebetDes;

		 			$mutasiKreditJanTotal += $mutasiKreditJan;
		 			$mutasiKreditFebTotal += $mutasiKreditFeb;
		 			$mutasiKreditMarTotal += $mutasiKreditMar;
		 			$mutasiKreditAprTotal += $mutasiKreditApr;
		 			$mutasiKreditMeiTotal += $mutasiKreditMei;
		 			$mutasiKreditJunTotal += $mutasiKreditJuni;
		 			$mutasiKreditJulTotal += $mutasiKreditJuli;
		 			$mutasiKreditAugTotal += $mutasiKreditAg;
		 			$mutasiKreditSepTotal += $mutasiKreditSep;
		 			$mutasiKreditOktTotal += $mutasiKreditOkt;
		 			$mutasiKreditNovTotal += $mutasiKreditNov;
		 			$mutasiKreditDesTotal += $mutasiKreditDes;
				?>
			</tr>
		<?php endforeach ?>
		<tr>
			<td colspan="2">Total</td>
			<td><?php echo number_format($mutasiDebetJanTotal,2);?></td>
			<td><?php echo number_format($mutasiKreditJanTotal,2);?></td>
			<td><?php echo number_format($mutasiDebetFebTotal,2);?></td>
			<td><?php echo number_format($mutasiKreditFebTotal,2);?></td>
			<td><?php echo number_format($mutasiDebetMarTotal,2);?></td>
			<td><?php echo number_format($mutasiKreditMarTotal,2);?></td>
			<td><?php echo number_format($mutasiDebetAprTotal,2);?></td>
			<td><?php echo number_format($mutasiKreditAprTotal,2);?></td>
			<td><?php echo number_format($mutasiDebetMeiTotal,2);?></td>
			<td><?php echo number_format($mutasiKreditMeiTotal,2);?></td>
			<td><?php echo number_format($mutasiDebetJunTotal,2);?></td>
			<td><?php echo number_format($mutasiKreditJunTotal,2);?></td>
			<td><?php echo number_format($mutasiDebetJulTotal,2);?></td>
			<td><?php echo number_format($mutasiKreditJulTotal,2);?></td>
			<td><?php echo number_format($mutasiDebetAugTotal,2);?></td>
			<td><?php echo number_format($mutasiKreditAugTotal,2);?></td>
			<td><?php echo number_format($mutasiDebetSepTotal,2);?></td>
			<td><?php echo number_format($mutasiKreditSepTotal,2);?></td>
			<td><?php echo number_format($mutasiDebetOktTotal,2);?></td>
			<td><?php echo number_format($mutasiKreditOktTotal,2);?></td>
			<td><?php echo number_format($mutasiDebetNovTotal,2);?></td>
			<td><?php echo number_format($mutasiKreditNovTotal,2);?></td>
			<td><?php echo number_format($mutasiDebetDesTotal,2);?></td>
			<td><?php echo number_format($mutasiKreditDesTotal,2);?></td>
		</tr>
		
	</table>
	<?php //} ?>
	
