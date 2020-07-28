<?php

class NeracaController extends Controller
{

	public $layout='//layouts/column1';
	public $defaultAction = 'index';

	public function ActionIndex()
	{
		$id=1;
		$modelBranch = Branch::model()->findAll();
		$modelJurnal = JurnalUmum::model()->findAll();
		$coaDetails = CoaDetail::model()->findAllByAttributes(array('coa_id'=>$id));

		$date = empty($_GET['date_from'])?date("Y-m-01"):$_GET['date_from']; 
		$branch = empty($_GET['branch_id'])?'00':$_GET['branch_id']; 

		if(isset($_GET['downloadNeraca']) && $_GET['downloadNeraca'] !=NULL) {
			$this->getXls($date,$branch);
		}

		$this->render('index',array(
			'model'=>$modelJurnal,
			'coaDetails'=>$coaDetails,
			'modelBranch'=>$modelBranch,
			'branch'=>$branch,
		));

	}

	// public function loadModelJurnal($id)
	// {
	// 	$model=Coa::model()->findByPk($id);
	// 	if($model===null)
	// 		throw new CHttpException(404,'The requested page does not exist.');
	// 	return $model;
	// }

	public function loadModel($id)
	{
		$model=Coa::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	// public function getXls($date_from,$branch_id) {
	// 	// var_dump($_POST[]);
	// 	// $date = empty($_GET['date_from'])?date("Y-m-01"):$_GET['date_from']; 
	// 	// $branch = empty($_GET['branch_id'])?'00':$_GET['branch_id']; 
	// 	$date = $date_from; $branch=$branch_id; 

	// 	// $opening_balance = Coa::model()->findByAttributes(['code'=>$branch.'.101.000']);
	// 	// var_dump($kas);
	// 	// echo date("Y-m-01", strtotime($date));
	// 	// $coa = Coa::model()->findAllByAttributes(['coa_id'=>3]);
	// 	// 	$array = CHtml::listData($coa, 'id', 'id');
	// 	// 	var_dump($array); die();
	// 	// die();
	// 	// die($branch);
	// 	$this->getXls($date,$branch);

	// }
	
	public function getXls($date=NULL, $branch=NULL) {

		// empty($date)?$date = date('d F Y'):$date;
		$getBranch = Branch::model()->findByPk($branch);
		$branchname = ($branch == '00')?'HeadOffice':$getBranch->name;

		$objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
             ->setLastModifiedBy("Apri Pebriana")
             ->setTitle("NERACA ".date('d-m-Y'))
             ->setSubject("NERACA")
             ->setDescription("Export NERACA, generated using PHP classes.")
             ->setKeywords("NERACA")
             ->setCategory("Export Forecasting");        
        
        // style for horizontal vertical center
		$styleHorizontalVertivalCenter = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		$styleHorizontalVertivalCenterBold = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);
		$styleHorizontalCenter = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);
		$styleVerticalCenter = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			)
		);

		// style color red
		$styleColorRED = array(
	        'font' => array(
	            'color' => array('rgb' => 'FF0000'),
				'bold' => true,
	        ),
	        // 'fill' => array(
	        //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
	        //     'color' => array('rgb' => 'FF0000')
	        // )
	    );
		// style color red
		$styleFontSize = array(
	        'font' => array(
				'size'=>9
	        ),
	        // 'fill' => array(
	        //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
	        //     'color' => array('rgb' => 'FF0000')
	        // )
	    );
	
//		$styleBorderRight = [
//			'borders' => array(
//				'right'=>array(
//					'style' => PHPExcel_Style_Border::BORDER_THIN,
//					// 'color' => array('rgb' => 'FF0000')
//				)
//			)
//		];
//
//		$styleBorderBottom = [
//			'borders' => array(
//				'bottom'=>array(
//					'style' => PHPExcel_Style_Border::BORDER_THIN,
//					// 'color' => array('rgb' => 'FF0000')
//				)
//			)
//		];

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'RAPERIND MOTOR')
            ->setCellValue('B3', 'NERACA - '.$branchname)
            ->setCellValue('B4', date('d F Y', strtotime($date)));
        
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:K2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B3:K3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B4:K4');
		
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('B6', 'AKTIVA')
		->setCellValue('B7', 'AKTIVA LANCAR')	
		->setCellValue('B8', 'KAS')
		->setCellValue('B9', 'KAS BANK')	
		->setCellValue('B10', 'KAS KECIL')	
		->setCellValue('B11', 'PERSEDIAAN BARANG DAGANG')	
		->setCellValue('B12', 'PIUTANG USAHA')	
		->setCellValue('B13', 'PIUTANG KARYAWAN')	
		->setCellValue('B14', 'PIUTANG CABANG')	
		->setCellValue('B15', 'PPN MASUKAN')	
		->setCellValue('C16', 'TOTAL AKTIVA LANCAR')
		->setCellValue('B19', 'AKTIVA TETAP')	
		->setCellValue('B20', 'INVENTARIS	')
		->setCellValue('B21', 'AKUMULASI PENYUSUTAN')	
		->setCellValue('B22', 'HARTA TIDAK BERWUJUD')	
		->setCellValue('C23', 'TOTAL AKTIVA TETAP')
		->setCellValue('C26', 'TOTAL AKTIVA');

		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('H6','KEWAJIBAN')
		->setCellValue('H7','JANGKA PENDEK')
		->setCellValue('H8','HUTANG DAGANG')
		->setCellValue('H9','HUTANG MODAL KERJA')
		->setCellValue('H10','HUTANG CABANG')
		->setCellValue('H11','PENDAPATAN DITERIMA DIMUKA')
		->setCellValue('H12','HUTANG PAJAK')
		->setCellValue('I13','TOTAL KEWAJIBAN JK.PENDEK')
		->setCellValue('H14','JANGKA PANJANG')
		->setCellValue('H15','HUTANG JANGKA PANJANG')
		->setCellValue('I16','TOTAL KEWAJIBAN JK.PANJANG')
		->setCellValue('I17','TOTAL KEWAJIBAN')
		->setCellValue('H19','EKUITAS')
		->setCellValue('H20','MODAL')
		->setCellValue('H21','PRIVE')
		->setCellValue('H22','LABA DITAHAN')
		->setCellValue('H23','LABA TAHUN BERJALAN')
		->setCellValue('I24','TOTAL EKUITAS')
		->setCellValue('I26','TOTAL KEWAJIBAN & EKUITAS');

		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->getStyle('B2:K2')->applyFromArray($styleHorizontalVertivalCenterBold);
		$sheet->getStyle('B3:K3')->applyFromArray($styleHorizontalVertivalCenterBold);
		$sheet->getStyle('B4:K4')->applyFromArray($styleHorizontalVertivalCenterBold);
		$sheet->getStyle('A1:K26')->applyFromArray($styleFontSize);
		$sheet->getStyle('F6:F27')->applyFromArray($styleBorderRight);
		$sheet->getStyle('D15')->applyFromArray($styleBorderBottom);
		$sheet->getStyle('D23')->applyFromArray($styleBorderBottom);
		$sheet->getStyle('E25')->applyFromArray($styleBorderBottom);
		$sheet->getStyle('J12')->applyFromArray($styleBorderBottom);
		$sheet->getStyle('J15')->applyFromArray($styleBorderBottom);
		$sheet->getStyle('J23')->applyFromArray($styleBorderBottom);
		$sheet->getStyle('J23')->applyFromArray($styleBorderBottom);
		$sheet->getStyle('K16')->applyFromArray($styleBorderBottom);
		$sheet->getStyle('K25')->applyFromArray($styleBorderBottom);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(23);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(23);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(11);

			// here for content
			//
				$neracacomponent=new NeracaComponents();

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D8',  $neracacomponent->getKas($date,$branch));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D9',  $neracacomponent->getKasBank($date,$branch));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D10', $neracacomponent->getKasKecil($date,$branch));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D11', $neracacomponent->getOtherCoa($date,$branch,193,'104.000'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D12', $neracacomponent->getOtherCoa($date,$branch,1163,'105.000'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D13', $neracacomponent->getOtherCoa($date,$branch,1713,'106.000'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D14', 0); // next id $this->getOtherCoa($date,$branch,1723,'104.000')
 				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D15', $neracacomponent->getOtherCoa($date,$branch,1732,'108.000'));

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D20', $neracacomponent->getOtherCoa($date,$branch,2713,'151.000'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D21', $neracacomponent->getOtherCoa($date,$branch,2773,'152.000'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D22', $neracacomponent->getOtherCoa($date,$branch,2833,'153.000')); 	

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J8',  $neracacomponent->getOtherCoa($date,$branch,2844,'201.000'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J9',  $neracacomponent->getOtherCoa($date,$branch,3574,'202.000'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J10', $neracacomponent->getOtherCoa($date,$branch,3614,'203.000'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J11', $neracacomponent->getOtherCoa($date,$branch,3632,'204.000'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J12', 0);

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J15', $neracacomponent->getOtherCoa($date,$branch,4383,'251.000'));

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J20', $neracacomponent->getOtherCoa($date,$branch,4394,'301.000'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J21', $neracacomponent->getOtherCoa($date,$branch,4404,'302.000'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J22', 0);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J23', 0);
			//
			// end content



		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E16', '=SUM(D6:D16)');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E23', '=SUM(D19:D22)');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E26', '=E16+E23');

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K13', '=SUM(J6:J13)');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K16', '=J15');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K17', '=K13+K16');

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K24', '=SUM(J19:J23)');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K26', '=K17+K24');

        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('YiiExcel');
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Save a xls file
        $filename = 'Neraca - '.$branchname.' - '.$date;
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();

	}

	public function getKas($date,$branch) {
		$saldo = 0;

		$date_start = date("Y-m-01", strtotime($date));

		if ($branch == '00') {
			$coaid = 3;
			$coaob = Coa::model()->findByPk($coaid);
			$ob = $coaob->opening_balance;

				$trips = Coa::model()->findAllByAttributes(array('coa_id'=>3));
				$arr = array();
				foreach($trips as $t)
				{
				    $arr[] = $t->id;
				}
			$criteria=new CDbCriteria;
			$criteria->addInCondition('coa_id',$arr); 
			$criteria->addBetweenCondition("tanggal_transaksi",$date_start,$date);
		}else{
			$coa = Coa::model()->findByAttributes(array('code'=>'0'.$branch.'.101.000'));
			$ob = empty($coa->opening_balance)?0:$coa->opening_balance;
			$coaid=$coa->id;
			// $date_start = '2015-10-15';
			$criteria=new CDbCriteria;
			$criteria->compare('branch_id',$branch);   
			$criteria->compare('coa_id',$coaid);   
			$criteria->addBetweenCondition("tanggal_transaksi",$date_start,$date);
		}
		$kas = JurnalUmum::model()->findAll($criteria);

		$saldo = $saldo + $ob;
		foreach ($kas as $key => $value) {
			if ($value->debet_kredit == 'D') {
				$saldo = $saldo + $value->total; 
			}else{
				$saldo = $saldo - $value->total; 
			}
		}

		return $saldo;
	}

	public function getKasBank($date,$branch) {
		$saldo = 0;

		$date_start = date("Y-m-01", strtotime($date));

		if ($branch == '00') {
			$coaid = 13;
			$coaob = Coa::model()->findByPk($coaid);
			$ob = $coaob->opening_balance;

				$trips = Coa::model()->findAllByAttributes(array('coa_id'=>13));
				$arr = array();
				foreach($trips as $t)
				{
				    $arr[] = $t->id;
				}
			$criteria=new CDbCriteria;
			$criteria->addInCondition('coa_id',$arr); 
			$criteria->addBetweenCondition("tanggal_transaksi",$date_start,$date);
		}else{
			$coa = Coa::model()->findByAttributes(array('code'=>'0'.$branch.'.102.000'));
			$ob = empty($coa->opening_balance)?0:$coa->opening_balance;
			$coaid=$coa->id;
			// $date_start = '2015-10-15';
			$criteria=new CDbCriteria;
			$criteria->compare('branch_id',$branch);   
			$criteria->compare('coa_id',$coaid);   
			$criteria->addBetweenCondition("tanggal_transaksi",$date_start,$date);
		}
		$kas = JurnalUmum::model()->findAll($criteria);

		$saldo = $saldo + $ob;
		foreach ($kas as $key => $value) {
			if ($value->debet_kredit == 'D') {
				$saldo = $saldo + $value->total; 
			}else{
				$saldo = $saldo - $value->total; 
			}
		}

		return $saldo;
	}

	public function getKasKecil($date,$branch) {
		$saldo = 0;

		$date_start = date("Y-m-01", strtotime($date));

		if ($branch == '00') {
			$coaid = 183;
			$coaob = Coa::model()->findByPk($coaid);
			$ob = $coaob->opening_balance;

				$trips = Coa::model()->findAllByAttributes(array('coa_id'=>183));
				$arr = array();
				foreach($trips as $t)
				{
				    $arr[] = $t->id;
				}
			$criteria=new CDbCriteria;
			$criteria->addInCondition('coa_id',$arr); 
			$criteria->addBetweenCondition("tanggal_transaksi",$date_start,$date);
		}else{
			$coa = Coa::model()->findByAttributes(array('code'=>'0'.$branch.'.102.000'));
			$ob = empty($coa->opening_balance)?0:$coa->opening_balance;
			$coaid=$coa->id;
			// $date_start = '2015-10-15';
			$criteria=new CDbCriteria;
			$criteria->compare('branch_id',$branch);   
			$criteria->compare('coa_id',$coaid);   
			$criteria->addBetweenCondition("tanggal_transaksi",$date_start,$date);
		}
		$kas = JurnalUmum::model()->findAll($criteria);

		$saldo = $saldo + $ob;
		foreach ($kas as $key => $value) {
			if ($value->debet_kredit == 'D') {
				$saldo = $saldo + $value->total; 
			}else{
				$saldo = $saldo - $value->total; 
			}
		}

		return $saldo;
	}

	public function getOtherCoa($date,$branch, $coaid, $coacode) {
		$saldo = 0;

		$date_start = date("Y-m-01", strtotime($date));

		if ($branch == '00') {
			$coaob = Coa::model()->findByPk($coaid);
			$ob = $coaob->opening_balance;

				$trips = Coa::model()->findAllByAttributes(array('coa_id'=>$coaid));
				$arr = array();
				foreach($trips as $t)
				{
				    $arr[] = $t->id;
				}
			$criteria=new CDbCriteria;
			$criteria->addInCondition('coa_id',$arr); 
			$criteria->addBetweenCondition("tanggal_transaksi",$date_start,$date);
		}else{
			$coa = Coa::model()->findByAttributes(array('code'=>'0'.$branch.'.'.$coacode));
			$ob = empty($coa->opening_balance)?0:$coa->opening_balance;
			$coaid=$coa->id;
			// $date_start = '2015-10-15';
			$criteria=new CDbCriteria;
			$criteria->compare('branch_id',$branch);   
			$criteria->compare('coa_id',$coaid);   
			$criteria->addBetweenCondition("tanggal_transaksi",$date_start,$date);
		}
		$kas = JurnalUmum::model()->findAll($criteria);

		$saldo = $saldo + $ob;
		foreach ($kas as $key => $value) {
			if ($value->debet_kredit == 'D') {
				$saldo = $saldo + $value->total; 
			}else{
				$saldo = $saldo - $value->total; 
			}
		}

		return $saldo;
	}

}