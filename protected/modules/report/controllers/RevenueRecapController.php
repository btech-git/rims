<?php

class RevenueRecapController extends Controller
{
	public function actionTest(){
		$this->getRevenueValue('2016-09-20',1,1);
	}

	public function actionIndex()
	{
		$branch = (isset($_GET['branch'])) ? $_GET['branch'] : 'all';
		$tahun = (isset($_GET['tahun'])) ? $_GET['tahun'] : date("Y");

	  	if (isset($_GET['ExportExcel']))
			$this->getXlsRevenueRecap($tahun,$branch);

		$this->render('index', array('year'=>$tahun,'branch'=>$branch));
	}

	public function getXlsRevenueRecap($tahun,$branchid) {

		ini_set('max_execution_time', 300); //300 seconds = 5 minutes
		ini_set('memory_limit', '2048M');

		$reportingComponets=new ReportingComponents();
		$objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
             ->setLastModifiedBy("Apri Pebriana")
             ->setTitle("Laporan Penjualan ".date('d-m-Y'))
             ->setSubject("Laporan Penjualan")
             ->setDescription("Export Laporan Penjualan, generated using PHP classes.")
             ->setKeywords("Laporan Penjualan")
             ->setCategory("Export Laporan Penjualan");        
        
	        // style for horizontal vertical center
				$styleHorizontalVertivalCenter = array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					)
				);
				$styleHorizontalVertivalBottom = array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
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
						'italic' => true,
			        ),
			    );
				$styleBoldItalic = array(
					'font' => array(
						'bold' => true,
						'italic' => true,
					),
				);
				$styleBold = array(
					'font' => array(
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


				$styleBorderBottom = array(
					'borders' => array(
						'bottom'=>array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							// 'color' => array('rgb' => 'FF0000')
						)
					)
				);
			// end style

			if (($branchid == 'all') OR ($branchid == '')) {
				$branchs =  Branch::model()->findAll();
			}else{
				$branchs =  Branch::model()->findAllByAttributes(array('id'=>$branchid));
			}
			$jumlah_branch = count($branchs);
			$a1 = ($tahun == date("Y"))?date("m"):12;
			$a2 = ($tahun == date("Y"))?date("F"):"December";

	        // Add some data
	        $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'REVENUE RECAP '.strtoupper($tahun))
	            ->setCellValue('A2', strtoupper($tahun).' January - '.$a2);
	        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:N1');

			$sheet = $objPHPExcel->getActiveSheet();
			$sheet->getStyle('A1:A2')->applyFromArray($styleBoldItalic);
			$objPHPExcel->getActiveSheet()->freezePane('E11');

			$arrayLetter = array();
			for($letter = 'B'; $letter !== 'ZZ'; $letter++) {
				$arrayLetter[] = $letter;
			}


			// $objPHPExcel->getActiveSheet()->getColumnDimension('A3')->setHeight(20);
			$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);
			$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);

			// prepare for header loop
				$letterStep11 = 0;
		        foreach ($branchs as $key => $branch) {
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($arrayLetter[$letterStep11 + 3].'7', $branch->name)
						->setCellValue($arrayLetter[$letterStep11 + 1].'9', 'DIVISION')
						->mergeCells($arrayLetter[$letterStep11 + 1].'9:'.$arrayLetter[$letterStep11 + 2].'10');


					$starbranchheading = $letterStep11 + 3;
					for ($i=1; $i <=12; $i++) { 
						$tgl = $tahun.'-'.$i.'-01';

						$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($arrayLetter[$starbranchheading].'9', date("F",strtotime($tgl)) );
						$objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$starbranchheading])->setWidth(12);
				        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$starbranchheading].'9:'.$arrayLetter[$starbranchheading].'10');
				        // $objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$starbranchheading].'9')->getAlignment()->setTextRotation(90);

						$starbranchheading++;
					}

			        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep11 + 3].'7:'.$arrayLetter[$starbranchheading].'8');

					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($arrayLetter[$starbranchheading].'9', 'Sub Total')
						->mergeCells($arrayLetter[$starbranchheading].'9:'.$arrayLetter[$starbranchheading].'10');
						// ->setCellValue($arrayLetter[$starbranchheading + 2].'7', ' ');

					// $sheet->getStyle($arrayLetter[$letterStep11].'4')->applyFromArray($styleHorizontalVertivalCenter);
					
			  		// $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep11].'3:'.$arrayLetter[$letterStep11].'4');

					// $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11])->setWidth(5);
					// $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11 + 1])->setWidth(15);
					// $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11 + 2])->setWidth(15);
					// $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11 + 3])->setWidth(2);



					// $sheet->getStyle($arrayLetter[$letterStep11 + 5].'3'.':'.$arrayLetter[$letterStep11 + 5].'5')->applyFromArray($styleBGColorGray);

			        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep11 + 4].'3:'.$arrayLetter[$starbranchheading -1].'3');
			        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$starbranchheading].'3:'.$arrayLetter[$starbranchheading].'4');
					$objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$starbranchheading])->setWidth(10);
					$objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$starbranchheading + 1])->setWidth(2);


					$letterStep11 = $letterStep11 + 18;
		        	

		        }
		    // end header loop//

				// $sheet->getStyle('A3:'.$arrayLetter[$letterStep11].'4')->applyFromArray($styleBorderAll);

				// start row content
				$letterStep = 0; $sumvalue1= array();$sumvalue2= array();
		        foreach ($branchs as $key => $branch) {

		        	$sumservicerevenue1 =  array();
					$startRow = 11;
					$startservicerow = $startRow; 
					$servicetypes = ServiceType::model()->findAll();
					foreach ($servicetypes as $key => $servicetype) {
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue($arrayLetter[$letterStep].$startservicerow, 'Service Revenue')
							->setCellValue($arrayLetter[$letterStep + 1].$startservicerow, $servicetype->name);
	
						$servicecategories = ServiceCategory::model()->findAllByAttributes(array('service_type_id'=>$servicetype->id));
						$jmlcategories = Count($servicecategories);
						foreach ($servicecategories as $key => $servicecategory) {
							$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue($arrayLetter[$letterStep + 2].$startservicerow, $servicecategory->name);						

							$monthcontent = $letterStep + 3;
							for ($i=1; $i <=$a1; $i++) {

								$tgl = $tahun.'-'.$i.'-01';

								$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue($arrayLetter[$monthcontent].$startservicerow, $this->getRevenueValue($tgl,$servicecategory->id,$branch->id));
						        // $objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$monthcontent].'9')->getAlignment()->setTextRotation(90);
								$objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$monthcontent].$startservicerow)->getNumberFormat()->setFormatCode("#,##0.00_-");
								$monthcontent++;
							}
							$startservicerow ++;
						}
						// $startservicerow ++;
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue($arrayLetter[$letterStep + 2].$startservicerow, 'Sub-total');
						
						if ($jmlcategories >=1) {
							$monthcontent = $letterStep + 3;
							for ($i=1; $i <=$a1; $i++) {
								$sumvalue1[$arrayLetter[$monthcontent]][] = $arrayLetter[$monthcontent].$startservicerow;
								$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue($arrayLetter[$monthcontent].$startservicerow, '=SUM('.$arrayLetter[$monthcontent].($startservicerow - $jmlcategories).':'.$arrayLetter[$monthcontent].($startservicerow - 1).')');
								$objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$monthcontent].$startservicerow)->getNumberFormat()->setFormatCode("#,##0.00_-");
								$monthcontent++;
							}
						}

						$sheet->getStyle($arrayLetter[$letterStep + 2].$startservicerow)->applyFromArray($styleBoldItalic);

						$startservicerow = $startservicerow +2;
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue($arrayLetter[$letterStep + 2].$startservicerow, ' ');

			        	// $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep].$startRow.':'.$arrayLetter[$letterStep].$startservicerow);
			        	// $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep +1].$startRow.':'.$arrayLetter[$letterStep +1].$startservicerow);
			        	$startRow = $startRow + $startservicerow;
			        	// $startRow = $startservicerow;
					}

					$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue($arrayLetter[$letterStep].$startservicerow, 'Service Revenue')
							->setCellValue($arrayLetter[$letterStep +2].$startservicerow, 'Sub Total');
					$lastkey = '';
					foreach ($sumvalue1 as $key => $value) {
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue($key.$startservicerow, '=SUM('.implode("+", $sumvalue1[$key]).')');
						$objPHPExcel->getActiveSheet()->getStyle($key.$startservicerow)->getNumberFormat()->setFormatCode("#,##0.00_-");
						// $sheet->getStyle($key.$startservicerow)->applyFromArray($styleColorRED);
						$lastkey = $key;
					}
					if($lastkey !='') {
						$sheet->getStyle($arrayLetter[$letterStep].$startservicerow .':'.$lastkey.$startservicerow)->applyFromArray($styleColorRED);
					}
					$servicerowrevenue = $startservicerow;

					$startservicerow  = $startservicerow + 2;

						//loop for sparepart 
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue($arrayLetter[$letterStep].$startservicerow, 'Support & Item');
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue($arrayLetter[$letterStep + 1].$startservicerow, 'Sparepart / Inventory');

						$productcategories = ProductMasterCategory::model()->findAll();
						$jmlprodcategories = Count($productcategories);
						foreach ($productcategories as $key => $productcategory) {
							$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue($arrayLetter[$letterStep + 2].$startservicerow, $productcategory->name);						

							$monthcontent = $letterStep + 3;
							for ($i=1; $i <=$a1; $i++) {

								$tgl = $tahun.'-'.$i.'-01';

								$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue($arrayLetter[$monthcontent].$startservicerow, $this->getRevenueProductValue($tgl,$productcategory->id,$branch->id));
						        // $objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$monthcontent].'9')->getAlignment()->setTextRotation(90);
								$objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$monthcontent].$startservicerow)->getNumberFormat()->setFormatCode("#,##0.00_-");
								$monthcontent++;
							}
							$startservicerow ++;
						}
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue($arrayLetter[$letterStep + 2].$startservicerow, 'Sub-total');
						if ($jmlprodcategories >=1) {
							$monthcontent = $letterStep + 3;
							for ($i=1; $i <=$a1; $i++) {
								$sumvalue2[$arrayLetter[$monthcontent]][] = $arrayLetter[$monthcontent].$startservicerow;
								$objPHPExcel->setActiveSheetIndex(0)
									->setCellValue($arrayLetter[$monthcontent].$startservicerow, '=SUM('.$arrayLetter[$monthcontent].($startservicerow - $jmlprodcategories).':'.$arrayLetter[$monthcontent].($startservicerow - 1).')');
								$objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$monthcontent].$startservicerow)->getNumberFormat()->setFormatCode("#,##0.00_-");
								$monthcontent++;
							}
						}

						$servicerowrevenue2 = $startservicerow;

					$sheet->getStyle($arrayLetter[$letterStep + 2].$startservicerow)->applyFromArray($styleBoldItalic);
					$startservicerow = $startservicerow +2;

					$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue($arrayLetter[$letterStep].$startservicerow, 'Service + Part Revenue ')
							->setCellValue($arrayLetter[$letterStep +2].$startservicerow, 'Sub Total');

					$lastkey2='';
					foreach ($sumvalue1 as $key => $value) {
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue($key.$startservicerow, '='.$key.$servicerowrevenue.'+'.$key.$servicerowrevenue2);
						$objPHPExcel->getActiveSheet()->getStyle($key.$startservicerow)->getNumberFormat()->setFormatCode("#,##0.00_-");
						// $sheet->getStyle($key.$startservicerow)->applyFromArray($styleColorRED);
						$lastkey2 = $key;
					}
					if($lastkey2 !='') {
						$sheet->getStyle($arrayLetter[$letterStep].$startservicerow .':'.$lastkey2.$startservicerow)->applyFromArray($styleColorRED);
					}


					$objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep])->setWidth(12);
					$objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep+1])->setWidth(15);
					$objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep+2])->setWidth(20);
					
					$letterStep = $letterStep + 18;
					// $startRow = $startRow + $startservicerow;
				}
				// end row content
						// var_dump($sumvalue2);
						// var_dump($sumvalue1); die();

				$sheet->getStyle('A3:'.$arrayLetter[$letterStep11].$startRow)->applyFromArray($styleFontSize);
				$sheet->getStyle('A7:'.$arrayLetter[$letterStep11].$startRow)->applyFromArray($styleHorizontalVertivalCenter);
				$objPHPExcel->getActiveSheet()->getStyle('A7:'.$arrayLetter[$letterStep11].'10')->getFont()->setUnderline(true);


	        // Miscellaneous glyphs, UTF-8
	        // Rename worksheet
	        $objPHPExcel->getActiveSheet()->setTitle(strtoupper('Revenue Recap '.$tahun));
	        
	        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
	        $objPHPExcel->setActiveSheetIndex(0);
	        // Save a xls file
	        $filename = 'Revenue Recap - '.$tahun;
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
	        header('Cache-Control: max-age=0');
	        
	        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');	
	        $objWriter->setPreCalculateFormulas(true);

	        $objWriter->save('php://output');
	        unset($this->objWriter);
	        unset($this->objWorksheet);
	        unset($this->objReader);
	        unset($this->objPHPExcel);
	        exit();			
	}

	public function getRevenueValue($bulan,$service,$branchid) {


 		$totalPenjualan = 0;
	    $criteria = new CDbCriteria();
	    $criteria->with = array('registrationTransaction','service');
	    $criteria->compare('registrationTransaction.branch_id', $branchid, true);
	    // $criteria->compare('t.sale_order_date', $tgl, true);
		$criteria->addBetweenCondition('registrationTransaction.transaction_date', date("Y-m-01", strtotime($bulan)), date("Y-m-t", strtotime($bulan)));
		
	    $criteria->compare('service.service_category_id', $service, true);
	    // find all posts
	    $getservice = RegistrationService::model()->findAll($criteria);

	    // var_dump($getservice); die();

	    if ($getservice !=NULL) {
		    foreach($getservice as $post)
		    {
		        $totalPenjualan = $totalPenjualan + $post->total_price;
		    }
		    return $totalPenjualan;
	    }else{
	    	return '';
	    }

		// return 0;
	}

	public function getRevenueProductValue($bulan,$product,$branchid) {
 		$totalPenjualan = 0;
	    $criteria = new CDbCriteria();
	    $criteria->with = array('registrationTransaction','product');
	    $criteria->compare('registrationTransaction.branch_id', $branchid, true);
	    // $criteria->compare('t.sale_order_date', $tgl, true);
		$criteria->addBetweenCondition('registrationTransaction.transaction_date', date("Y-m-01", strtotime($bulan)), date("Y-m-t", strtotime($bulan)));
		
	    $criteria->compare('product.product_master_category_id', $product, true);
	    // find all posts
	    $getservice = RegistrationProduct::model()->findAll($criteria);

	    // var_dump($getservice); die();

	    if ($getservice !=NULL) {
		    foreach($getservice as $post)
		    {
		        $totalPenjualan = $totalPenjualan + $post->total_price;
		    }
		    return $totalPenjualan;
	    }else{
	    	return '';
	    }
	}
}