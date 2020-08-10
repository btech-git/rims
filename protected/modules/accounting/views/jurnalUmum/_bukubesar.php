<?php
Yii::app()->clientScript->registerCss('_report', '
	.price {text-align: right;}
');
?>
<?php //echo(CJSON::encode($orderPenjualanPendingSummary->dataProvider->data)); ?>

	
<?php 
$tanggal_mulai = $tanggal_mulai == "" ? date('Y-m-d') : $tanggal_mulai;
$tanggal_sampai = $tanggal_sampai == "" ? date('Y-m-d') : $tanggal_sampai; ?>
<div class="reportHeader">
    <div>PT RATU PERDANA INDAH JAYA</div>
    <div>BUKU BESAR</div>
    <div>Periode: <?php echo $tanggal_mulai .' s/d '.$tanggal_sampai; ?></div>
    <div>Branch: <?php echo $branch; ?></div>
    <span></span><br>
    <div>Tanggal Cetak: <?php echo date('d/m/Y'); ?></div>
    <?php 
    $yesterday = date('Y-m-d', strtotime( $tanggal_mulai .'-1 days'));
    //echo $yesterday; 
    $count = 0;
    ?>
</div>
<p></p>

<?php //if (empty($coaSub) && empty($coaCategory)): ?>
    <table>
        <?php foreach ($allCoa as $key => $coaDetail): ?>
            <tr>
                <td><b>Nama Akun</b></td>
                <td><b>:</b></td>
                <td><b><?php echo $coaDetail->name; ?></b></td>
                <td><b>Kode Akun</b></td>
                <td><b>:</b></td>
                <td><b><?php echo $coaDetail->code; ?></b></td>
            </tr>
            <tr style="background:#fff;">
                <td colspan="6">
                    <table>
                        <?php 
                            $JurnalCriteria = new CDbCriteria; 
                            $JurnalCriteria->addCondition("coa_id = ".$coaDetail->id);
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

                            $JurnalCriteria->addBetweenCondition('tanggal_transaksi', $coaDetail->date, $tanggal_mulai);
                            $allJurnals = JurnalUmum::model()->findAll($JurnalCriteria);
                            //echo $yesterday;
                            $debitTotal = $creditTotal = 0;
                            foreach ($allJurnals as $key => $allJurnal) {
                                if ($allJurnal->debet_kredit == "D")
                                    $debitTotal += $allJurnal->total;
                                else
                                    $creditTotal += $allJurnal->total;
                            }
                            if ($coaDetail->normal_balance=="DEBET"){
                                $count = $coaDetail->opening_balance + $debitTotal - $creditTotal;
                            }
                            else{
                                $count = $coaDetail->opening_balance + $creditTotal - $debitTotal;
                            }
                            // echo "DEBIT TOTAL = ".$debitTotal;
                            // echo "KREDIT TOTAL = ".$creditTotal;
                         ?>
                        <?php $lastkode = ""; ?>
                        <?php $totalDebet =  $totalkredit = 0; ?>
                        <?php $criteria = new CDbCriteria; 
                            $criteria->addCondition("coa_id = ".$coaDetail->id);
                            if ($company!= "") {
                                $branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
                                $arrBranch = array();
                                foreach ($branches as $key => $branchId) {
                                    $arrBranch[] = $branchId->id;
                                }
                                if ($branch != "") {
                                    $criteria->addCondition("branch_id = ".$branch);
                                }
                                else{
                                    $criteria->addInCondition('branch_id',$arrBranch);
                                }
                            }
                            else{
                                if ($branch != "") {
                                    $criteria->addCondition("branch_id = ".$branch);
                                }
                            }
                            $criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
                        ?>
                        <?php $coaJurnals = JurnalUmum::model()->findAll($criteria); ?>
                        <thead>
                            <tr>
                                <th rowspan="2" >TANGGAL</th>
                                <th rowspan="2" >KODE TRANSAKSI</th>
                                <th rowspan="2" >BRANCH</th>
                                <th rowspan="2" >KETERANGAN</th>
                                <th rowspan="2" >DEBET</th>
                                <th rowspan="2" >KREDIT</th>
                                <th colspan="2">Saldo</th>
                            </tr>
                            <tr><th>Debet</th><th>Kredit</th></tr>
                        </thead>
                        <tr>
                            <td></td>
                            <td>SALDO AWAL</td>
                            <td colspan="4"></td>
                            <td><?php echo $coaDetail->normal_balance == 'DEBET'? $count :'' ?></td>
                            <td><?php echo $coaDetail->normal_balance == 'KREDIT'? $count :'' ?></td>
                        </tr>
                        <?php foreach ($coaJurnals as $key => $jurnal): ?>
                            <tr>
                                <td><?php echo $jurnal->tanggal_posting; ?></td>
                                <td><?php echo $jurnal->kode_transaksi; ?></td>
                                <td><?php echo $jurnal->branch->name; ?></td>
                                <td><?php echo $jurnal->transaction_subject ?></td>
                                <td><?php echo $jurnal->debet_kredit == 'D'? number_format($jurnal->total,2) : '' ?></td>
                                <td><?php echo $jurnal->debet_kredit == 'K'? number_format($jurnal->total,2) : '' ?></td>
                                <?php if ($key == 0) {
                                    $lastcount = $jurnal->debet_kredit == "D" ? $count + $jurnal->total : $count - $jurnal->total;
                                } 
                                else{
                                    $lastcount = $jurnal->debet_kredit == "D" ? $lastcount + $jurnal->total : $lastcount - $jurnal->total;
                                }
                                ?>
                                <td><?php echo $coaDetail->normal_balance == 'DEBET'? number_format($lastcount,2):'-' ?></td>
                                <td><?php echo $coaDetail->normal_balance == 'KREDIT'?  number_format($lastcount,2):'-' ?></td>
                                <?php if ($jurnal->debet_kredit == 'D') {
                                    $totalDebet += $jurnal->total;
                                } ?>
                                <?php if ($jurnal->debet_kredit == 'K') {
                                    $totalkredit += $jurnal->total;
                                } ?>

                            </tr>
                            <?php $lastkode = $jurnal->kode_transaksi; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4">&nbsp;</td>
                            <td><b><?php echo number_format($totalDebet,2); ?></b></td>
                            <td><b><?php echo number_format($totalkredit,2); ?></b></td>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php //endif; ?>

<?php /*if (!empty($coaSub)): ?>
    <table>
        <?php $coa = Coa::model()->findByPk($coaData); ?>
        <?php $lastkode = ""; ?>
        <?php $totalDebet =  $totalkredit = 0; ?>
        <tr>
            <td><b>Nama Akun</b></td>
            <td><b>:</b></td>
            <td><b><?php echo empty($coa) ? "" : $coa->name; ?></b></td>
            <td><b>Kode Akun</b></td>
            <td><b>:</b></td>
            <td><b><?php echo empty($coa) ? "" : $coa->code; ?></b></td>
        </tr>
        <tr>
            <th rowspan="2" >TANGGAL</th>
            <th rowspan="2" >KODE TRANSAKSI</th>
            <th rowspan="2" >KODE</th>
            <th rowspan="2" >NAMA</th>
            <th rowspan="2" >DEBET</th>
            <th rowspan="2" >KREDIT</th>
            <th colspan="2">Saldo</th>
        </tr>
        <tr>
            <th>Debet</th>
            <th>Kredit</th>
        </tr>
        <tr>
            <td></td>
            <td>SALDO AWAL</td>
            <td colspan="4"></td>
            <td><?php echo empty($coa) ? "" : $coa->normal_balance == 'DEBET'? $count :'' ?></td>
            <td><?php echo empty($coa) ? "" : $coa->normal_balance == 'KREDIT'? $count :'' ?></td>
        </tr>
        <?php 
        $grandTotalkredit = $grandTotaldebet = 0;
        $total = $count;  
        ?>
        <?php foreach ($coaSubDataProvider->data as $coaSub): ?>
            <?php $totalDebet = $totalkredit = 0; ?>
            <?php foreach ($coaSub->jurnalUmums as $jurnalUmum): ?>
                <tr>
                    <?php $total = $jurnalUmum->debet_kredit == "D" ? $total + $jurnalUmum->total : $total - $jurnalUmum->total; ?>
                    <td><?php echo $jurnalUmum->tanggal_posting; ?></td>
                    <td><?php echo $jurnalUmum->kode_transaksi; ?></td>
                    <td><?php echo $jurnalUmum->branchAccountCode; ?></td>
                    <td><?php echo $jurnalUmum->coa->name ?></td>
                    <td><?php echo $jurnalUmum->debet_kredit == 'D'? number_format($jurnalUmum->total,2) : '' ?></td>
                    <td><?php echo $jurnalUmum->debet_kredit == 'K'? number_format($jurnalUmum->total,2) : '' ?></td>
                    <td><?php echo $coaSub->normal_balance == 'DEBET'? number_format($total,2):'-' ?></td>
                    <td><?php echo $coaSub->normal_balance == 'KREDIT'?  number_format($total,2):'-' ?></td>
                    <?php if ($jurnalUmum->debet_kredit == 'D') {
                        $totalDebet += $jurnalUmum->total;
                    } ?>
                    <?php if ($jurnalUmum->debet_kredit == 'K') {
                        $totalkredit -= $jurnalUmum->total;
                    } ?>
                </tr>
            <?php endforeach; ?>
            <?php 
                $grandTotaldebet += $totalDebet;
                $grandTotalkredit += $totalkredit;
            ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="4">&nbsp;</td>
            <td><b><?php echo number_format($grandTotaldebet,2); ?></b></td>
            <td><b><?php echo number_format($grandTotalkredit,2); ?></b></td>
        </tr>
    </table>
<?php endif; ?>

<?php /*if (!empty($coaCategory)): ?>
    <table>
        <?php $coa = Coa::model()->findByPk($coaData); ?>
        <?php $lastkode = ""; ?>
        <?php $totalDebet =  $totalkredit = 0; ?>
        <tr>
            <td><b>Nama Akun</b></td>
            <td><b>:</b></td>
            <td><b><?php echo empty($coa) ? "" : $coa->name; ?></b></td>
            <td><b>Kode Akun</b></td>
            <td><b>:</b></td>
            <td><b><?php echo empty($coa) ? "" : $coa->code; ?></b></td>
        </tr>
        <tr>
            <th rowspan="2" >TANGGAL</th>
            <th rowspan="2" >KODE TRANSAKSI</th>
            <th rowspan="2" >KODE</th>
            <th rowspan="2" >NAMA</th>
            <th rowspan="2" >DEBET</th>
            <th rowspan="2" >KREDIT</th>
            <th colspan="2">Saldo</th>
        </tr>
        <tr>
            <th>Debet</th>
            <th>Kredit</th>
        </tr>
        <tr>
            <td></td>
            <td>SALDO AWAL</td>
            <td colspan="4"></td>
            <td><?php echo empty($coa) ? "" : $coa->normal_balance == 'DEBET'? $count :'' ?></td>
            <td><?php echo empty($coa) ? "" : $coa->normal_balance == 'KREDIT'? $count :'' ?></td>
        </tr>
        <?php 
        $grandTotalkredit = $grandTotaldebet = 0;
        $total = $count;  
        ?>
        <?php foreach ($coaCategoryDataProvider->data as $coaCategory): ?>
            <?php foreach ($coaCategory->coaIds as $coaSub): ?>
                <?php $totalDebet = $totalkredit = 0; ?>
                <?php foreach ($coaSub->jurnalUmums as $jurnalUmum): ?>
                    <tr>
                        <?php $total = $jurnalUmum->debet_kredit == "D" ? $total + $jurnalUmum->total : $total - $jurnalUmum->total; ?>
                        <td><?php echo $jurnalUmum->tanggal_posting; ?></td>
                        <td><?php echo $jurnalUmum->kode_transaksi; ?></td>
                        <td><?php echo $jurnalUmum->branchAccountCode; ?></td>
                        <td><?php echo $jurnalUmum->coa->name ?></td>
                        <td><?php echo $jurnalUmum->debet_kredit == 'D'? number_format($jurnalUmum->total,2) : '' ?></td>
                        <td><?php echo $jurnalUmum->debet_kredit == 'K'? number_format($jurnalUmum->total,2) : '' ?></td>
                        <td><?php echo $coaSub->normal_balance == 'DEBET'? number_format($total,2):'-' ?></td>
                        <td><?php echo $coaSub->normal_balance == 'KREDIT'?  number_format($total,2):'-' ?></td>
                        <?php if ($jurnalUmum->debet_kredit == 'D') {
                            $totalDebet += $jurnalUmum->total;
                        } ?>
                        <?php if ($jurnalUmum->debet_kredit == 'K') {
                            $totalkredit -= $jurnalUmum->total;
                        } ?>
                    </tr>
                <?php endforeach; ?>
                <?php 
                    $grandTotaldebet += $totalDebet;
                    $grandTotalkredit += $totalkredit;
                ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="4">&nbsp;</td>
            <td><b><?php echo number_format($grandTotaldebet,2); ?></b></td>
            <td><b><?php echo number_format($grandTotalkredit,2); ?></b></td>
        </tr>
    </table>
<?php endif; ?>