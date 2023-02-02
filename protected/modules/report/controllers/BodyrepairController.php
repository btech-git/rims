<?php

class BodyrepairController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'index') {
            if (!(Yii::app()->user->checkAccess('bodyRepairReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionIndex() {
        $type = (isset($_GET['type'])) ? $_GET['type'] : 1;
        $tanggal = (isset($_GET['tanggal'])) ? $_GET['tanggal'] : date("Y-m-d");

        if (isset($_GET['ExportExcelGeneral'])) {
            $this->getXlsGeneral($tanggal);
        } else if (isset($_GET['ExportExcelBody'])) {
            $this->getXlsBody($tanggal);
        }

        $this->render('index', array('type' => $type, 'tanggal' => $tanggal));
    }

    public function getXlsBody($tanggal) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        // $tanggal = (empty($tanggal))? 

        $modelCriteria = new CDbCriteria;
        $modelCriteria->addCondition("work_order_number != ''");
        $modelCriteria->addCondition("repair_type = 'BR'");

        $modelCriteria->addBetweenCondition('transaction_date', date("Y-m-01", strtotime($tanggal)), date("Y-m-t", strtotime($tanggal)));

        $models = RegistrationTransaction::model()->findAll($modelCriteria);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
                ->setLastModifiedBy("Apri Pebriana")
                ->setTitle("Body Repair " . date('d-m-Y'))
                ->setSubject("Body Repair")
                ->setDescription("Export Body Repair, generated using PHP classes.")
                ->setKeywords("Body Repair")
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

        $styleFontSize = array(
            'font' => array(
                'size' => 9
            ),
                // 'fill' => array(
                //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //     'color' => array('rgb' => 'FF0000')
                // )
        );
        $styleFontSize10 = array(
            'font' => array(
                'size' => 10
            ),
        );

        $styleFontSize15 = array(
            'font' => array(
                'size' => 15
            ),
        );

        $styleBorderAll = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            )
        );
        $styleBorderRight = array(
            'borders' => array(
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                // 'color' => array('rgb' => 'FF0000')
                )
            )
        );

        $styleBgColorHeader = array(
                    'font' => array(
                        'bold' => true,
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'BBDEFB')
                    )
        );

        $styleBgColorGanjil = array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'E3F2FD')
                    )
        );

        $styleBorderBottom = array(
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                // 'color' => array('rgb' => 'FF0000')
                )
            )
        );
        // end style
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B1', 'DAFTAR PROGRES KENDARAAN BODY REPAIR PER ' . date('F Y'));

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:N1');

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A3', 'CAR#')
                ->setCellValue('B3', 'Form#')
                ->setCellValue('C3', 'Code')
                ->setCellValue('D3', 'WO#')
                ->setCellValue('E3', 'Car Make')
                ->setCellValue('F3', 'Car Type')
                ->setCellValue('G3', 'License#')
                ->setCellValue('H3', 'Insurance')
                ->setCellValue('I3', 'Date In')
                ->setCellValue('J3', 'Date Start Work')
                ->setCellValue('K3', 'Estimation Finish Date')
                ->setCellValue('L3', 'Date Out')
                ->setCellValue('M3', 'of Panels(s)')
                ->setCellValue('N3', 'Damage Type(L<M<H<T)')
                ->setCellValue('O3', 'Position')
                ->setCellValue('P3', 'Customer PIC')
                ->setCellValue('Q3', 'Description')
                ->setCellValue('R3', 'PIC Bongkar')
                ->setCellValue('S3', 'PIC Las')
                ->setCellValue('T3', 'PIC Dempul')
                ->setCellValue('U3', 'PIC Gosok')
                ->setCellValue('V3', 'PIC Cat')
                ->setCellValue('W3', 'PIC Pasang')
                ->setCellValue('X3', 'PIC Poles');

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('B1:N1')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('B1:N1')->applyFromArray($styleBorderAll);
        $sheet->getStyle('B1:N1')->applyFromArray($styleFontSize15);
        $sheet->getStyle('A3:X3')->applyFromArray($styleFontSize10);
        $sheet->getStyle('A3:X3')->applyFromArray($styleBgColorHeader);


        //	for header #42A5F5
        // for ganjil #BBDEFB genap #E3F2FD
        //set header
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
        //end set header
        // here for content
        $startRow = 4;
        foreach ($models as $key => $value) {
            # code...
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $startRow, ($value->vehicle != null) ? $value->vehicle->plate_number : '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $startRow, ($value->work_order_number != null) ? '\'' . $value->work_order_number : '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $startRow, ($value->vehicle->carMake != null) ? $value->vehicle->carMake->name : '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $startRow, ($value->vehicle->carModel != null) ? $value->vehicle->carModel->name : '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startRow, ($value->insuranceCompany != null) ? $value->insuranceCompany->name : '-');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $startRow, ($value->status != null) ? $value->status : '-');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $startRow, ($value->pic != null) ? $value->pic->name : '-');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $startRow, ($value->problem != null) ? $value->problem : '-');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X' . $startRow, '');

            // style for bgcolor ganjil
            if ($startRow % 2) {
                $sheet->getStyle('A' . $startRow . ':X' . $startRow)->applyFromArray($styleBgColorGanjil);
            }
            $startRow ++;
        }
        // style after looping
        $sheet->getStyle('A4:X' . $startRow)->applyFromArray($styleFontSize);
        $sheet->getStyle('A3:X' . $startRow)->applyFromArray($styleBorderAll);



        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D9',  $this->getKasBank($date,$branch));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D10', $this->getKasKecil($date,$branch));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D11', $this->getOtherCoa($date,$branch,193,'104.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D12', $this->getOtherCoa($date,$branch,1163,'105.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D13', $this->getOtherCoa($date,$branch,1713,'106.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D14', 0); // next id $this->getOtherCoa($date,$branch,1723,'104.000')
        // 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D15', $this->getOtherCoa($date,$branch,1732,'108.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D20', $this->getOtherCoa($date,$branch,2713,'151.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D21', $this->getOtherCoa($date,$branch,2773,'152.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D22', $this->getOtherCoa($date,$branch,2833,'153.000')); 	
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J8',  $this->getOtherCoa($date,$branch,2844,'201.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J9',  $this->getOtherCoa($date,$branch,3574,'202.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J10', $this->getOtherCoa($date,$branch,3614,'203.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J11', $this->getOtherCoa($date,$branch,3632,'204.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J12', 0);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J15', $this->getOtherCoa($date,$branch,4383,'251.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J20', $this->getOtherCoa($date,$branch,4394,'301.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J21', $this->getOtherCoa($date,$branch,4404,'302.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J22', 0);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J23', 0);
        //
			// end content
        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Body Repair Report');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();

        // Save a xls file
        $filename = 'Body Repair Report - ' . date("Ymd");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
    }

    public function getXlsGeneral($tanggal) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        // $tanggal = (empty($tanggal))? 

        $modelCriteria = new CDbCriteria;
        $modelCriteria->addCondition("work_order_number != ''");
        $modelCriteria->addCondition("repair_type = 'GR'");

        $modelCriteria->addBetweenCondition('transaction_date', date("Y-m-01", strtotime($tanggal)), date("Y-m-t", strtotime($tanggal)));

        $models = RegistrationTransaction::model()->findAll($modelCriteria);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
                ->setLastModifiedBy("Apri Pebriana")
                ->setTitle("General Repair " . date('d-m-Y'))
                ->setSubject("General Repair")
                ->setDescription("Export General Repair, generated using PHP classes.")
                ->setKeywords("General Repair")
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

        $styleFontSize = array(
            'font' => array(
                'size' => 9
            ),
                // 'fill' => array(
                //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //     'color' => array('rgb' => 'FF0000')
                // )
        );
        $styleFontSize10 = array(
            'font' => array(
                'size' => 10
            ),
        );

        $styleFontSize15 = array(
            'font' => array(
                'size' => 15
            ),
        );

        $styleBorderAll = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            )
        );
        $styleBorderRight = array(
            'borders' => array(
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                // 'color' => array('rgb' => 'FF0000')
                )
            )
        );

        $styleBgColorHeader = array(
                    'font' => array(
                        'bold' => true,
                    ),
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'BBDEFB')
                    )
        );

        $styleBgColorGanjil = array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'E3F2FD')
                    )
        );

        $styleBorderBottom = array(
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                // 'color' => array('rgb' => 'FF0000')
                )
            )
        );
        // end style
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B1', 'DAFTAR PROGRES KENDARAAN GENERAL REPAIR PER ' . date('F Y'));

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:N1');

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A3', 'CAR#')
                ->setCellValue('B3', 'Form#')
                ->setCellValue('C3', 'Code')
                ->setCellValue('D3', 'WO#')
                ->setCellValue('E3', 'Car Make')
                ->setCellValue('F3', 'Car Type')
                ->setCellValue('G3', 'License#')
                ->setCellValue('H3', 'Insurance')
                ->setCellValue('I3', 'Date In')
                ->setCellValue('J3', 'Date Start Work')
                ->setCellValue('K3', 'Estimation Finish Date')
                ->setCellValue('L3', 'Date Out')
                ->setCellValue('M3', 'of Panels(s)')
                ->setCellValue('N3', 'Damage Type(L<M<H<T)')
                ->setCellValue('O3', 'Position')
                ->setCellValue('P3', 'Customer PIC')
                ->setCellValue('Q3', 'Description')
                ->setCellValue('R3', 'PIC Bongkar')
                ->setCellValue('S3', 'PIC Las')
                ->setCellValue('T3', 'PIC Dempul')
                ->setCellValue('U3', 'PIC Gosok')
                ->setCellValue('V3', 'PIC Cat')
                ->setCellValue('W3', 'PIC Pasang')
                ->setCellValue('X3', 'PIC Poles');

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('B1:N1')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('B1:N1')->applyFromArray($styleBorderAll);
        $sheet->getStyle('B1:N1')->applyFromArray($styleFontSize15);
        $sheet->getStyle('A3:X3')->applyFromArray($styleFontSize10);
        $sheet->getStyle('A3:X3')->applyFromArray($styleBgColorHeader);


        //	for header #42A5F5
        // for ganjil #BBDEFB genap #E3F2FD
        //set header
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
        //end set header
        // here for content
        $startRow = 4;
        foreach ($models as $key => $value) {
            # code...
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $startRow, ($value->vehicle != null) ? $value->vehicle->plate_number : '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $startRow, ($value->work_order_number != null) ? '\'' . $value->work_order_number : '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $startRow, ($value->vehicle->carMake != null) ? $value->vehicle->carMake->name : '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $startRow, ($value->vehicle->carModel != null) ? $value->vehicle->carModel->name : '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startRow, ($value->insuranceCompany != null) ? $value->insuranceCompany->name : '-');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $startRow, ($value->status != null) ? $value->status : '-');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $startRow, ($value->pic != null) ? $value->pic->name : '-');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q' . $startRow, ($value->problem != null) ? $value->problem : '-');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W' . $startRow, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X' . $startRow, '');

            // style for bgcolor ganjil
            if ($startRow % 2) {
                $sheet->getStyle('A' . $startRow . ':X' . $startRow)->applyFromArray($styleBgColorGanjil);
            }
            $startRow ++;
        }
        // style after looping
        $sheet->getStyle('A4:X' . $startRow)->applyFromArray($styleFontSize);
        $sheet->getStyle('A3:X' . $startRow)->applyFromArray($styleBorderAll);



        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D9',  $this->getKasBank($date,$branch));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D10', $this->getKasKecil($date,$branch));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D11', $this->getOtherCoa($date,$branch,193,'104.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D12', $this->getOtherCoa($date,$branch,1163,'105.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D13', $this->getOtherCoa($date,$branch,1713,'106.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D14', 0); // next id $this->getOtherCoa($date,$branch,1723,'104.000')
        // 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D15', $this->getOtherCoa($date,$branch,1732,'108.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D20', $this->getOtherCoa($date,$branch,2713,'151.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D21', $this->getOtherCoa($date,$branch,2773,'152.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D22', $this->getOtherCoa($date,$branch,2833,'153.000')); 	
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J8',  $this->getOtherCoa($date,$branch,2844,'201.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J9',  $this->getOtherCoa($date,$branch,3574,'202.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J10', $this->getOtherCoa($date,$branch,3614,'203.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J11', $this->getOtherCoa($date,$branch,3632,'204.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J12', 0);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J15', $this->getOtherCoa($date,$branch,4383,'251.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J20', $this->getOtherCoa($date,$branch,4394,'301.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J21', $this->getOtherCoa($date,$branch,4404,'302.000'));
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J22', 0);
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J23', 0);
        //
			// end content
        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('General Repair Report');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();

        // Save a xls file
        $filename = 'General Repair Report - ' . date("Ymd");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
    }

}
