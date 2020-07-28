<?php

class KasharianController extends Controller
{
	public function actionIndex() {

		$tanggal = (isset($_GET['tanggal'])) ? $_GET['tanggal'] : date("Y-m-d");
		$type = (isset($_GET['type'])) ? $_GET['type'] : 'cashin';

		// var_dump($tanggal); die()
	  	if (isset($_GET['ExportExcel']) && $type == 'cashin') {
			$this->getXlsCashin($tanggal);
	  	}elseif(isset($_GET['ExportExcel']) && $type == 'cashout') {
			$this->getXlsCashout($tanggal);
	  	}


		$this->render('harian', array(
			'tanggal'=>$tanggal,
			'type'=>$type,
		));
 	}

 	public function actionReport() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
		$kascomponent=new KasharianComponents();
		$tanggal = (isset($_GET['tanggal'])) ? $_GET['tanggal'] : date("Y-m-d");
		$branchs = Branch::model()->findAll();
        
		$criteria = new CDbCriteria;
		$criteria->addInCondition('id', $kascomponent->getListBank()); 
		$listBank = Coa::model()->findAll($criteria);

	  	if (isset($_GET['ExportExcel'])) {
			$this->getXlsReport($tanggal);
	  	}

		$this->render('report', array(
			'tanggal'=>$tanggal,
			'kascomponent'=>$kascomponent,
			'branchs' => $branchs,
			'banks' =>$listBank,
		));
 	}

 	public function getXlsReport($tanggal) {
		$kascomponent=new KasharianComponents();
		$criteria = new CDbCriteria;
		$criteria->addInCondition('id', $kascomponent->getListBank()); 
		$banks = Coa::model()->findAll($criteria);
		$branchs = Branch::model()->findAll();

		// $type = 'cash out'; 
		$objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
             ->setLastModifiedBy("Apri Pebriana")
             ->setTitle("Laporan Kas Harian ".date('d-m-Y'))
             ->setSubject("Laporan Kas Harian")
             ->setDescription("Export Laporan Kas Harian, generated using PHP classes.")
             ->setKeywords("Laporan Kas Harian")
             ->setCategory("Export Laporan Kas Harian");        
        
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
		    );
			
			$styleBGColorGray = array(
			    'fill' => array(
			        'type' => PHPExcel_Style_Fill::FILL_SOLID,
			        'color' => array('rgb' => '777777')
			    )
			);

			$styleFontSize = array(
		        'font' => array(
					'size'=>9
		        ),
		    );
			$styleFontSize10 = array(
		        'font' => array(
					'size'=>10
		        ),
		    );
			
			$styleFontSize15 = array(
		        'font' => array(
					'size'=>15
		        ),
		    );
		
			$styleBorderAll = array(
				'borders' => array(
					'allborders'=>array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			);

			$styleBgColorHeader = 
			array(
				'font' => array(
					'bold' => true,
				),
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'BBDEFB')
		        )
		    );

			$styleBgColorGanjil = 
			array(
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'E3F2FD')
		        )
		    );

			$styleBorderBottom = array(
				'borders' => array(
					'bottom'=>array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						// 'color' => array('rgb' => 'FF0000')
					)
				)
			);
		// end style

		// $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);
		// $objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);

        // Add some data
		// kas masuk

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'LAPORAN KAS HARIAN - KAS MASUK');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', date(' d F Y'));

		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->getStyle('A1:N1')->applyFromArray($styleHorizontalVertivalCenter);
		// $objPHPExcel->getActiveSheet()->freezePane('C5');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:B3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:B4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C3:C4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D3:E3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F3:G3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H3:H4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I3:I4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J3:J4');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Branch')
            ->setCellValue('C3', 'Cash')
            ->setCellValue('D3', 'Credit')
            ->setCellValue('D4', 'BCA')
            ->setCellValue('E4', 'Mandiri')
            ->setCellValue('F3', 'Debit')
            ->setCellValue('F4', 'BCA')
            ->setCellValue('G4', 'Mandiri')
            ->setCellValue('H3', 'Hutang')
            ->setCellValue('I3', 'DP')
            ->setCellValue('J3', 'Total');

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);

		for($letter = 'C'; $letter !== 'K'; $letter++) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setWidth(15);
		}

		$sheet->getStyle('A3:J4')->applyFromArray($styleHorizontalVertivalCenter);

		$startrow = 5; $nomor =1;
		foreach ($branchs as $key => $branch) {
	        $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$startrow, $nomor)
	            ->setCellValue('B'.$startrow, $branch->name)
	            ->setCellValue('C'.$startrow, $this->getCashout($tanggal, $branch->id))
	            ->setCellValue('D'.$startrow, $this->getCreditCout($tanggal, $branch->id,7)) //7 bca //3 mandiri
	            ->setCellValue('E'.$startrow, $this->getCreditCout($tanggal, $branch->id,3))
	            ->setCellValue('F'.$startrow, $this->getDebitCout($tanggal, $branch->id,7))
	            ->setCellValue('G'.$startrow, $this->getDebitCout($tanggal, $branch->id,3))
	            ->setCellValue('H'.$startrow, $this->getPiutangCout($tanggal, $branch->id))
	            ->setCellValue('I'.$startrow, $this->getDp($tanggal, $branch->id))
	            ->setCellValue('J'.$startrow, '=sum(C'.$startrow.':I'.$startrow.')');			
	            // ->setCellValue('J'.$startrow, '=C'.$startrow.'+D'.$startrow);			
	        $nomor ++;
	        $startrow ++;

		}

		/*** 
			for excel kas keluar
		**/
		$startrow = $startrow + 1; 
		$laststartrow = $startrow; 

		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.($laststartrow +1), 'LAPORAN KAS HARIAN - KAS KELUAR');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.($laststartrow +1).':J'.($laststartrow +1));
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.($laststartrow+3), date(' d F Y'));

		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->getStyle('A'.($laststartrow +1).':N'.($laststartrow+1))->applyFromArray($styleHorizontalVertivalCenter);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.($laststartrow+3).':B'.($laststartrow+3));
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.($laststartrow+4).':B'.($laststartrow+4));
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.($laststartrow+3).':C'.($laststartrow+4));
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.($laststartrow+3).':E'.($laststartrow+3));
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.($laststartrow+3).':G'.($laststartrow+3));
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.($laststartrow+3).':H'.($laststartrow+4));
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I'.($laststartrow+3).':I'.($laststartrow+4));
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J'.($laststartrow+3).':J'.($laststartrow+4));

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.($laststartrow+4), 'Branch')
            ->setCellValue('C'.($laststartrow+3), 'Cash')
            ->setCellValue('D'.($laststartrow+3), 'Credit')
            ->setCellValue('D'.($laststartrow+4), 'BCA')
            ->setCellValue('E'.($laststartrow+4), 'Mandiri')
            ->setCellValue('F'.($laststartrow+3), 'Debit')
            ->setCellValue('F'.($laststartrow+4), 'BCA')
            ->setCellValue('G'.($laststartrow+4), 'Mandiri')
            ->setCellValue('H'.($laststartrow+3), 'Hutang')
            ->setCellValue('I'.($laststartrow+3), 'DP')
            ->setCellValue('J'.($laststartrow+3), 'Total');

		$sheet->getStyle('A'.($laststartrow+3).':J'.($laststartrow+4))->applyFromArray($styleHorizontalVertivalCenter);

        $startrow = ($laststartrow + 5);
		$nomorin = 1;
		foreach ($branchs as $key => $branch) {
	        $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$startrow, $nomorin)
	            ->setCellValue('B'.$startrow, $branch->name)
	            ->setCellValue('C'.$startrow, $this->getCashout($tanggal, $branch->id))
	            ->setCellValue('D'.$startrow, $this->getCreditCout($tanggal, $branch->id,7)) //7 bca //3 mandiri
	            ->setCellValue('E'.$startrow, $this->getCreditCout($tanggal, $branch->id,3))
	            ->setCellValue('F'.$startrow, $this->getDebitCout($tanggal, $branch->id,7))
	            ->setCellValue('G'.$startrow, $this->getDebitCout($tanggal, $branch->id,3))
	            ->setCellValue('H'.$startrow, $this->getPiutangCout($tanggal, $branch->id))
	            ->setCellValue('I'.$startrow, $this->getDp($tanggal, $branch->id))
	            ->setCellValue('J'.$startrow, '=sum(C'.$startrow.':I'.$startrow.')');			
	            // ->setCellValue('J'.$startrow, '=C'.$startrow.'+D'.$startrow);			
	        $nomorin ++;
	        $startrow ++;

		}

		$objPHPExcel->getActiveSheet()->getStyle('C5:J'.$startrow)->getNumberFormat()->setFormatCode("#,##0_-");
		// $objPHPExcel->getActiveSheet()->getStyle('C'.$laststartrow.':J'.$startrow)->getNumberFormat()->setFormatCode("#,##0_-");


		/*** 
			for excel setor bank
		**/

		$laststorbank=$startrow;  
		$startrow = ($laststorbank +5);
		$nomorsaldo=1;
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.($laststorbank +2), 'LAPORAN KAS HARIAN - SETOR BANK');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.($laststorbank +2).':J'.($laststorbank +2));

	    $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A'.($laststorbank+4), 'NO.')
            ->setCellValue('B'.($laststorbank+4), 'SETOR BANK')
            ->setCellValue('C'.($laststorbank+4), 'SALDO');

        foreach ($banks as $key => $bank) {
	        $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$startrow, $nomorsaldo)
	            ->setCellValue('B'.$startrow, $bank->name)
	            ->setCellValue('C'.$startrow,$kascomponent->getSetorbank($tanggal, $bank->id));
	            
	        $nomorsaldo ++;
	        $startrow ++;
        }

		$objPHPExcel->setActiveSheetIndex(0)
	        ->setCellValue('B'.$startrow, 'SALDO')
			->setCellValue('C'.$startrow, '=SUM(C'.($laststorbank + 5).':C'.($startrow -1).')');			

        $startrow ++;


		/*** 
			for excel saldo awal dan saldo akhir
		**/
		$lastsaldo=$startrow;  
		$startrow = ($lastsaldo +5);
		$nomorsaldo2=1;
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.($lastsaldo +2), 'LAPORAN KAS HARIAN - SALDO AWAL/SALDO AKHIR');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.($lastsaldo +2).':D'.($lastsaldo +2));

		$sheet->getStyle('A'.($lastsaldo +2).':D'.($lastsaldo+2))->applyFromArray($styleHorizontalVertivalCenter);

	    $objPHPExcel->setActiveSheetIndex(0)
            // ->setCellValue('A'.($laststorbank+4), 'NO.')
            ->setCellValue('B'.($lastsaldo+4), 'CABANG/BANK')
            ->setCellValue('C'.($lastsaldo+4), 'SALDO AWAL')
            ->setCellValue('D'.($lastsaldo+4), 'SALDO AKHIR');

        foreach ($branchs as $key => $branch) {
	        $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$startrow, $nomorsaldo2)
	            ->setCellValue('B'.$startrow, $branch->name)
	            ->setCellValue('C'.$startrow,$kascomponent->getSaldoAwal($tanggal, $branch->id,'In'))
	            ->setCellValue('D'.$startrow,$kascomponent->getSaldoAkhir($tanggal, $branch->id));
	            
	        $nomorsaldo2 ++;
	        $startrow ++;
        }

        foreach ($banks as $key => $bank) {
	        $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$startrow, $nomorsaldo2)
	            ->setCellValue('B'.$startrow, $bank->name)
	            ->setCellValue('C'.$startrow,$kascomponent->getSaldoAwalBank($tanggal, $bank->id,'In'))
	            ->setCellValue('D'.$startrow,$kascomponent->getSaldoAkhirBank($tanggal, $bank->id));
	            
	        $nomorsaldo2 ++;
	        $startrow ++;
        }

		$objPHPExcel->setActiveSheetIndex(0)
	        ->setCellValue('B'.$startrow, 'TOTAL SALDO')
			->setCellValue('C'.$startrow, '=SUM(C'.($lastsaldo + 5).':C'.($startrow -1).')')			
			->setCellValue('D'.$startrow, '=SUM(D'.($lastsaldo + 5).':D'.($startrow -1).')');			



        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Laporan Kas Harian '.strtoupper($tanggal));
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Save a xls file
        $filename = 'Laporan Kas Harian - '.strtoupper($tanggal);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->setPreCalculateFormulas(true);
        // $objWriter->setPreCalculateFormulas(true);

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
 	}

	public function getXlsCashout($tanggal)
	{
		$type = 'cash out';
		$objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
             ->setLastModifiedBy("Apri Pebriana")
             ->setTitle("Laporan Kas Harian ".date('d-m-Y'))
             ->setSubject("Laporan Kas Harian")
             ->setDescription("Export Laporan Kas Harian, generated using PHP classes.")
             ->setKeywords("Laporan Kas Harian")
             ->setCategory("Export Laporan Kas Harian");        
        
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
		    );
			
			$styleBGColorGray = array(
			    'fill' => array(
			        'type' => PHPExcel_Style_Fill::FILL_SOLID,
			        'color' => array('rgb' => '777777')
			    )
			);

			$styleFontSize = array(
		        'font' => array(
					'size'=>9
		        ),
		    );
			$styleFontSize10 = array(
		        'font' => array(
					'size'=>10
		        ),
		    );
			
			$styleFontSize15 = array(
		        'font' => array(
					'size'=>15
		        ),
		    );
		
			$styleBorderAll = array(
				'borders' => array(
					'allborders'=>array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			);

			$styleBgColorHeader = 
			array(
				'font' => array(
					'bold' => true,
				),
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'BBDEFB')
		        )
		    );

			$styleBgColorGanjil = 
			array(
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'E3F2FD')
		        )
		    );

			$styleBorderBottom = array(
				'borders' => array(
					'bottom'=>array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						// 'color' => array('rgb' => 'FF0000')
					)
				)
			);
		// end style

		// $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);
		// $objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B1', 'KAS HARIAN - Kas Keluar');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:N1');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', date(' d F Y'));

		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->getStyle('B1:AZ1')->applyFromArray($styleHorizontalVertivalCenter);
		$objPHPExcel->getActiveSheet()->freezePane('C5');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:B3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:B4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C3:C4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D3:E3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F3:G3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H3:H4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I3:I4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J3:J4');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Branch')
            ->setCellValue('C3', 'Cash')
            ->setCellValue('D3', 'Credit')
            ->setCellValue('D4', 'BCA')
            ->setCellValue('E4', 'Mandiri')
            ->setCellValue('F3', 'Debit')
            ->setCellValue('F4', 'BCA')
            ->setCellValue('G4', 'Mandiri')
            ->setCellValue('H3', 'Hutang')
            ->setCellValue('I3', 'DP')
            ->setCellValue('J3', 'Total');



		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		for($letter = 'C'; $letter !== 'K'; $letter++) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setWidth(15);
		}

		$sheet->getStyle('A3:J4')->applyFromArray($styleHorizontalVertivalCenter);

		$branchs = Branch::model()->findAll();

		$startrow = 5; $nomor =1;
		foreach ($branchs as $key => $branch) {
	        $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$startrow, $nomor)
	            ->setCellValue('B'.$startrow, $branch->name)
	            ->setCellValue('C'.$startrow, $this->getCashout($tanggal, $branch->id))
	            ->setCellValue('D'.$startrow, $this->getCreditCout($tanggal, $branch->id,7)) //7 bca //3 mandiri
	            ->setCellValue('E'.$startrow, $this->getCreditCout($tanggal, $branch->id,3))
	            ->setCellValue('F'.$startrow, $this->getDebitCout($tanggal, $branch->id,7))
	            ->setCellValue('G'.$startrow, $this->getDebitCout($tanggal, $branch->id,3))
	            ->setCellValue('H'.$startrow, $this->getPiutangCout($tanggal, $branch->id))
	            ->setCellValue('I'.$startrow, $this->getDp($tanggal, $branch->id))
	            ->setCellValue('J'.$startrow, '=sum(C'.$startrow.':I'.$startrow.')');			
	            // ->setCellValue('J'.$startrow, '=C'.$startrow.'+D'.$startrow);			
	        $nomor ++;
	        $startrow ++;

		}

		$objPHPExcel->getActiveSheet()->getStyle('C5:J'.$startrow)->getNumberFormat()->setFormatCode("#,##0_-");

        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Laporan Kas Harian '.strtoupper($tanggal));
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Save a xls file
        $filename = 'Laporan Kas Harian - '.strtoupper($tanggal).' - '.strtoupper($type);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->setPreCalculateFormulas(true);
        // $objWriter->setPreCalculateFormulas(true);

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
    }

	public function getXlsCashin($tanggal)
	{
		$type = 'cash in';
		$objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
             ->setLastModifiedBy("Apri Pebriana")
             ->setTitle("Laporan Kas Harian ".date('d-m-Y'))
             ->setSubject("Laporan Kas Harian")
             ->setDescription("Export Laporan Kas Harian, generated using PHP classes.")
             ->setKeywords("Laporan Kas Harian")
             ->setCategory("Export Laporan Kas Harian");        
        
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
		    );
			
			$styleBGColorGray = array(
			    'fill' => array(
			        'type' => PHPExcel_Style_Fill::FILL_SOLID,
			        'color' => array('rgb' => '777777')
			    )
			);

			$styleFontSize = array(
		        'font' => array(
					'size'=>9
		        ),
		    );
			$styleFontSize10 = array(
		        'font' => array(
					'size'=>10
		        ),
		    );
			
			$styleFontSize15 = array(
		        'font' => array(
					'size'=>15
		        ),
		    );
		
			$styleBorderAll = array(
				'borders' => array(
					'allborders'=>array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			);

			$styleBgColorHeader = 
			array(
				'font' => array(
					'bold' => true,
				),
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'BBDEFB')
		        )
		    );

			$styleBgColorGanjil = 
			array(
		        'fill' => array(
		            'type' => PHPExcel_Style_Fill::FILL_SOLID,
		            'color' => array('rgb' => 'E3F2FD')
		        )
		    );

			$styleBorderBottom = array(
				'borders' => array(
					'bottom'=>array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						// 'color' => array('rgb' => 'FF0000')
					)
				)
			);
		// end style

		// $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);
		// $objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B1', 'KAS HARIAN - Kas Masuk');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:N1');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', date(' d F Y'));

		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->getStyle('B1:AZ1')->applyFromArray($styleHorizontalVertivalCenter);
		$objPHPExcel->getActiveSheet()->freezePane('C5');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:B3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:B4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C3:C4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D3:E3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F3:G3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H3:H4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I3:I4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J3:J4');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Branch')
            ->setCellValue('C3', 'Cash')
            ->setCellValue('D3', 'Credit')
            ->setCellValue('D4', 'BCA')
            ->setCellValue('E4', 'Mandiri')
            ->setCellValue('F3', 'Debit')
            ->setCellValue('F4', 'BCA')
            ->setCellValue('G4', 'Mandiri')
            ->setCellValue('H3', 'Piutang')
            ->setCellValue('I3', 'DP')
            ->setCellValue('J3', 'Total');

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		for($letter = 'C'; $letter !== 'K'; $letter++) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setWidth(15);
		}

		$sheet->getStyle('A3:J4')->applyFromArray($styleHorizontalVertivalCenter);

		$branchs = Branch::model()->findAll();

		$startrow = 5; $nomor =1;
		foreach ($branchs as $key => $branch) {
	        $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$startrow, $nomor)
	            ->setCellValue('B'.$startrow, $branch->name)
	            ->setCellValue('C'.$startrow, $this->getCashin($tanggal, $branch->id))
	            ->setCellValue('D'.$startrow, $this->getCredit($tanggal, $branch->id,7)) //7 bca //3 mandiri
	            ->setCellValue('E'.$startrow, $this->getCredit($tanggal, $branch->id,3))
	            ->setCellValue('F'.$startrow, $this->getDebit($tanggal, $branch->id,7))
	            ->setCellValue('G'.$startrow, $this->getDebit($tanggal, $branch->id,3))
	            ->setCellValue('H'.$startrow, $this->getPiutang($tanggal, $branch->id))
	            ->setCellValue('I'.$startrow, $this->getDp($tanggal, $branch->id))
	            ->setCellValue('J'.$startrow, '=sum(C'.$startrow.':I'.$startrow.')');			
	            // ->setCellValue('J'.$startrow, '=C'.$startrow.'+D'.$startrow);			
	        $nomor ++;
	        $startrow ++;

		}

		$objPHPExcel->getActiveSheet()->getStyle('C5:J'.$startrow)->getNumberFormat()->setFormatCode("#,##0_-");

        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Laporan Kas Harian '.strtoupper($tanggal));
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Save a xls file
        $filename = 'Laporan Kas Harian - '.strtoupper($tanggal).' - '.strtoupper($type);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->setPreCalculateFormulas(true);
        // $objWriter->setPreCalculateFormulas(true);

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
    }

    public function getCashin($tanggal,$branch) {
    	$total  = 0;
    	$cashin = PaymentIn::model()->findAllByAttributes(array('payment_date'=>$tanggal,'branch_id'=>$branch,'payment_type'=>'Cash'));
    	foreach ($cashin as $key => $value) {
    		$total = $total + $value->payment_amount;
    	}
    	return $total;
    }

    public function getCashout($tanggal,$branch) {
    	$total  = 0;
    	$cashin = PaymentOut::model()->findAllByAttributes(array('payment_date'=>$tanggal,'branch_id'=>$branch,'payment_type'=>'Cash'));
    	foreach ($cashin as $key => $value) {
    		$total = $total + $value->payment_amount;
    	}
    	return $total;
    }

    public function getCredit($tanggal,$branch, $bank) {
    	$total  = 0;
    	if ($bank == 3 ) {
        	$cashin = PaymentIn::model()->findAllByAttributes(array('payment_date'=>$tanggal,'branch_id'=>$branch,'payment_type'=>'Credit','bank_id'=>3));
	    	foreach ($cashin as $key => $value) {
	    		$total = $total + $value->payment_amount;
	    	}
    	}elseif ($bank == 7 ) {
        	$cashin = PaymentIn::model()->findAllByAttributes(array('payment_date'=>$tanggal,'branch_id'=>$branch,'payment_type'=>'Credit','bank_id'=>7));
	    	foreach ($cashin as $key => $value) {
	    		$total = $total + $value->payment_amount;
	    	}
    	}else{
	    	return $total;
    	}
    	return $total;
    }
    public function getCreditCout($tanggal,$branch, $bank) {
    	$total  = 0;
    	if ($bank == 3 ) {
        	$cashin = PaymentOut::model()->findAllByAttributes(array('payment_date'=>$tanggal,'branch_id'=>$branch,'payment_type'=>'Credit','bank_id'=>3));
	    	foreach ($cashin as $key => $value) {
	    		$total = $total + $value->payment_amount;
	    	}
    	}elseif ($bank == 7 ) {
        	$cashin = PaymentOut::model()->findAllByAttributes(array('payment_date'=>$tanggal,'branch_id'=>$branch,'payment_type'=>'Credit','bank_id'=>7));
	    	foreach ($cashin as $key => $value) {
	    		$total = $total + $value->payment_amount;
	    	}
    	}else{
	    	return $total;
    	}
    	return $total;
    }

    public function getDebit($tanggal,$branch, $bank) {
    	$total  = 0;
    	if ($bank == 3 ) {
        	$cashin = PaymentIn::model()->findAllByAttributes(array('payment_date'=>$tanggal,'branch_id'=>$branch,'payment_type'=>'Debit','bank_id'=>3));
	    	foreach ($cashin as $key => $value) {
	    		$total = $total + $value->payment_amount;
	    	}
    	}elseif ($bank == 7 ) {
        	$cashin = PaymentIn::model()->findAllByAttributes(array('payment_date'=>$tanggal,'branch_id'=>$branch,'payment_type'=>'Debit','bank_id'=>7));
	    	foreach ($cashin as $key => $value) {
	    		$total = $total + $value->payment_amount;
	    	}
    	}else{
	    	return $total;
    	}

    	return $total;
    }

    public function getDebitCout($tanggal,$branch, $bank) {
    	$total  = 0;
    	if ($bank == 3 ) {
        	$cashin = PaymentOut::model()->findAllByAttributes(array('payment_date'=>$tanggal,'branch_id'=>$branch,'payment_type'=>'Debit','bank_id'=>3));
	    	foreach ($cashin as $key => $value) {
	    		$total = $total + $value->payment_amount;
	    	}
    	}elseif ($bank == 7 ) {
        	$cashin = PaymentOut::model()->findAllByAttributes(array('payment_date'=>$tanggal,'branch_id'=>$branch,'payment_type'=>'Debit','bank_id'=>7));
	    	foreach ($cashin as $key => $value) {
	    		$total = $total + $value->payment_amount;
	    	}
    	}else{
	    	return $total;
    	}

    	return $total;
    }

    public function getPiutang($tanggal,$branch) {
    	$total  = 0;
    	$cashin = TransactionSalesOrder::model()->findAllByAttributes(array('sale_order_date'=>$tanggal,'requester_branch_id'=>$branch));
    	foreach ($cashin as $key => $value) {
    		$total = $total + $value->total_price;
    	}
    	return $total;
    }

    public function getPiutangCout($tanggal,$branch) {
    	$total  = 0;
    	$cashin = TransactionPurchaseOrder::model()->findAllByAttributes(array('purchase_order_date'=>$tanggal,'main_branch_id'=>$branch));
    	foreach ($cashin as $key => $value) {
    		$total = $total + $value->total_price;
    	}
    	return $total;
    }

    public function getDp($tanggal,$branch) {
    	return 0;
    }
}