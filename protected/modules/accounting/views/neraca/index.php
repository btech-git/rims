<?php
/* @var $this JurnalUmumController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=
array(
	'Accounting',
	'Neraca',
	); 
$neracacomponent=new NeracaComponents();
?>

	<h1>Laporan Posisi Keuangan (Neraca)</h1>

	<?php

		if ($branch != '00') {
			$getBranch = Branch::model()->findByPk($branch);
			$branchname = $getBranch->name;
		}else{
			$branchname = 'HeadOffice';
		}

		$date = (isset($_GET['date_from'])) ?  date('Y-m-d', strtotime($_GET['date_from'])): date("Y-m-d");

		// var_dump($date.$branch);
		// $tgl = 
	?>	
	<div id="maincontent">
		<div class="row">
			<div class="small-12 medium-12 columns">
				<div class="search-bar">
					<div class="clearfix button-bar">

						<div class="row">
							<div class="medium-12 columns">
								<?php $form=$this->beginWidget('CActiveForm', array(
									// 'action'=>Yii::app()->baseUrl.'/accounting/neraca/xls',
									// 'method'=>'pos',
									'action'=>Yii::app()->createUrl($this->route),
									'method'=>'get',

									)
								);
								?>
								<div class="row">
									<div class="small-3 columns">
										<?php
											$this->widget('zii.widgets.jui.CJuiDatePicker', array(
											    'name' => 'date_from',
											    'value' => $date,
											    'options'=>array(
													'dateFormat' => 'yy-mm-dd',
													'changeMonth'=>true,
													'changeYear'=>true,
													'yearRange'=>'1900:2020',
												),
											    'htmlOptions' => array(
											        'size' => '10',         // textField size
											        'maxlength' => '10',    // textField maxlength
											    ),
											));
										?>

										<?php /*$this->widget('zii.widgets.jui.CJuiDatePicker',array(
											'model' => $model,
											'attribute' => "tanggal_mulai",
											'options'=>array(
												'dateFormat' => 'yy-mm-dd',
												'changeMonth'=>true,
												'changeYear'=>true,
												'yearRange'=>'1900:2020',
												),
											'htmlOptions'=>array(
												'placeholder'=>'Start Date',
												'value'=>date("d-m-Y"),
												'id'=>'start_date',
												'style'=>'margin-bottom:0px;'
												),
											)
										);*/
										?>
									</div>
									<div class="small-3 columns">
										<?php
										echo CHtml::dropDownList('branch_id',($branch == '00')?'':$branch, 
							              CHtml::listData($modelBranch,
							              'id', 'name'),
							              array('empty' => '[--Select a Branch--]'));
							            ?>
										<?php //echo  $form->dropDownList($model, 'branch_id', $modelBranch, array('prompt' => '[--Select Branch--]',"style"=>"margin-bottom:0px;")); ?>
									</div>

									<div class="small-3 columns">
										<div class="field buttons text-right">
											<?php echo CHtml::submitButton('View Neraca', array('name'=>'viewNeraca','class' => 'button cbutton','id'=>'viewNeraca')); ?>
											<?php echo CHtml::submitButton('Download Neraca', array('name'=>'downloadNeraca','class' => 'button cbutton','id'=>'exportXls')); ?>
										</div>
									</div>
								</div>
								<?php $this->endWidget(); ?>
							</div>
						</div>
					</div>
				</div><!-- search-form -->
			</div>
		<div class="small-12 columns">
			<table class="neraca_table">
				<tr>
					<td colspan="8" class="text-center"><strong>RAPERIND MOTOR</strong></td>
				</tr>
				<tr>
					<td colspan="8" class="text-center"><strong>NERACA - <?php echo  ($branch == '00')?'HeadOffice':$branchname; ?></strong></td>
				</tr>
				<tr>
					<td colspan="8"  class="text-center"><strong><?php echo (isset($_GET['date_from'])) ?  date('d F Y', strtotime($_GET['date_from'])): date("d F Y");?></strong></td>
				</tr>
				<tr>
					<td colspan="4"><strong>AKTIVA</strong></td>
					<td colspan="4"><strong>KEWAJIBAN</strong></td>
				</tr>
				<tr>
					<td colspan="4"><strong>AKTIVA LANCAR</strong></td>
					<td colspan="4"><strong>JANGKA PENDEK</strong></td>
				</tr>
				<tr>
					<td width="15%">KAS</td>
					<td width="15%"></td>
					<td width="10%"><?php echo $k1 = $neracacomponent->getKas($date,$branch);?></td>
					<td width="10%"></td>
					<td width="15%">HUTANG DAGANG</td>
					<td width="15%"></td>
					<td width="10%"><?php echo $h1 = $neracacomponent->getOtherCoa($date,$branch,2844,'201.000');?></td>
					<td width="10%"></td>
				</tr>
				<tr>
					<td width="15%">KAS BANK</td>
					<td width="15%"></td>
					<td width="10%"><?php echo $k2 = $neracacomponent->getKasBank($date,$branch);?></td>
					<td width="10%"></td>
					<td width="15%">HUTANG MODAL KERJA</td>
					<td width="15%"></td>
					<td width="10%"><?php echo $h2 = $neracacomponent->getOtherCoa($date,$branch,3574,'202.000');?></td>
					<td width="10%"></td>
				</tr>
				<tr><td>KAS KECIL</td><td></td><td><?php echo $k3 = $neracacomponent->getKasKecil($date,$branch);?></td><td></td><td>HUTANG CABANG</td><td></td><td><?php echo $h3 = $neracacomponent->getOtherCoa($date,$branch,3614,'203.000');?></td><td></td></tr>
				<tr><td>PERSEDIAAN BARANG DAGANG</td><td></td><td><?php echo $k4=$neracacomponent->getOtherCoa($date,$branch,193,'104.000'); ?></td><td></td><td>PENDAPATAN DITERIMA DIMUKA</td><td></td><td><?php echo $h4 = $neracacomponent->getOtherCoa($date,$branch,3632,'204.000');?></td><td></td></tr>
				<tr><td>PIUTANG USAHA</td><td></td><td><?php echo $k5=$neracacomponent->getOtherCoa($date,$branch,1163,'105.000');?></td><td></td><td>HUTANG PAJAK</td><td></td><td><?php echo $h5 = 0?></td><td></td></tr>
				<tr><td>PIUTANG KARYAWAN</td><td></td><td><?php echo $k6=$neracacomponent->getOtherCoa($date,$branch,1713,'106.000');?></td><td></td><td></td><td><strong>TOTAL KEWAJIBAN JK.PENDEK</strong></td><td></td><td><?php echo $h_total_1 = ($h1+$h2+$h3+$h4+$h5)?></td></tr>
				<tr><td>PIUTANG CABANG</td><td></td><td><?php echo $k7=0; ?></td><td></td><td>JANGKA PANJANG</td><td></td><td></td><td></td></tr>
				<tr><td>PPN MASUKAN</td><td></td><td><?php echo $k8=$neracacomponent->getOtherCoa($date,$branch,1732,'108.000');?></td><td></td><td>HUTANG JANGKA PANJANG</td><td></td><td><?php echo $h6 = $neracacomponent->getOtherCoa($date,$branch,4383,'251.000');?></td><td></td></tr>
				<tr><td></td><td><strong>TOTAL AKTIVA LANCAR</strong></td><td></td><td><?php echo $k_total_1 = ($k1+$k2+$k3+$k4+$k5+$k6+$k7+$k8);?></td><td></td><td><strong>TOTAL KEWAJIBAN JK.PANJANG</strong></td><td></td><td><?php echo $h_total_2=$h6?></td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td><td><strong>TOTAL KEWAJIBAN</strong></td><td></td><td><?php echo $h_total_3 = ($h_total_1 + $h_total_2) ?></td></tr>
				<tr><td>AKTIVA TETAP</td><td></td><td></td><td></td><td>EKUITAS</td><td></td><td></td><td></td></tr>
				<tr><td>INVENTARIS</td><td></td><td><?php echo $k9=$neracacomponent->getOtherCoa($date,$branch,2713,'151.000');?></td><td></td><td>MODAL</td><td></td><td><?php echo $h7 = $neracacomponent->getOtherCoa($date,$branch,4394,'301.000');?></td></tr>
				<tr><td>AKUMULASI PENYUSUTAN</td><td></td><td><?php echo $k10=$neracacomponent->getOtherCoa($date,$branch,2773,'152.000');?></td><td></td><td>PRIVE</td><td></td><td><?php echo $h8=$neracacomponent->getOtherCoa($date,$branch,4404,'302.000');?></td><td></td></tr>
				<tr><td>HARTA TIDAK BERWUJUD</td><td></td><td><?php echo $k11=0;?></td><td></td><td>LABA DITAHAN</td><td></td><td><?php echo $h9=0;?></td><td></td></tr>
				<tr><td></td><td><strong>TOTAL AKTIVA TETAP</strong></td><td></td><td><?php echo $k_total_2=($k9+$k10+$k11);?></td><td>LABA TAHUN BERJALAN</td><td></td><td><?php echo $h10=0;?></td><td></td></tr>
				<tr><td></td><td></td><td></td><td></td><td></td><td><strong>TOTAL EKUITAS</strong></td><td></td><td><?php echo $h_total_4= ($h7+$h8+$h9+$h10);?></td></tr>
				<tr><td></td><td><strong>TOTAL AKTIVA</strong></td><td></td><td><?php echo ($k_total_1 + $k_total_2);?></td><td></td><td><strong>TOTAL KEWAJIBAN &amp; EKUITAS</strong></td><td></td><td><?php echo ($h_total_3+$h_total_4);?></td></tr>

			</table>
									
									


		</div>
	</div>
