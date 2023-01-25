<?php

class PenjualanTransaksiController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('paymentOutReport') ))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionDaily() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $reportingComponets = new ReportingComponents();

        $tanggal = (isset($_GET['tanggal'])) ? $_GET['tanggal'] : date("Y-m-d");
        $brand = (isset($_GET['brand'])) ? $_GET['brand'] : '';
        $type = (isset($_GET['type'])) ? $_GET['type'] : 'ban';

        if ($type == 'ban') {
            $brandname = Brand::model()->findAllByAttributes(array('id' => $reportingComponets->getListBrandTire()));
            $branch = Branch::model()->findAll();
            $jumlah_branch = count($branch);
        } else {
            $brandname = Brand::model()->findAllByAttributes(array('id' => $reportingComponets->getListBrandOil()));
            $branch = Branch::model()->findAll();
            $jumlah_branch = count($branch);
        }

        if (isset($_GET['ExportExcel'])) {
            $this->getXlsHarian($tanggal, $type);
        }

        $this->render('daily', array(
            'tanggal' => $tanggal,
            'brand' => $brand,
            'type' => $type,
            'brandname' => $brandname,
            'branch' => $branch,
            'jumlah_branch' => $jumlah_branch,
            'reportingComponets' => $reportingComponets,
        ));
    }

    public function getXlsHarian($tanggal, $type) {

        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        ini_set('memory_limit', '2048M');

        $reportingComponets = new ReportingComponents();
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
                ->setLastModifiedBy("Apri Pebriana")
                ->setTitle("REKAP HARIAN " . date('d-m-Y'))
                ->setSubject("Laporan Penjualan")
                ->setDescription("Export Laporan Penjualan, generated using PHP classes.")
                ->setKeywords("Laporan Penjualan")
                ->setCategory("Export Laporan Penjualan");

        // style for horizontal vertical center
//        $styleHorizontalVertivalCenter = array(
//            'alignment' => array(
//                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
//            )
//        );
//        $styleHorizontalVertivalCenterBold = array(
//            'font' => array(
//                'bold' => true,
//            ),
//            'alignment' => array(
//                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
//            )
//        );
//        $styleHorizontalCenter = array(
//            'alignment' => array(
//                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//            )
//        );
//        $styleVerticalCenter = array(
//            'alignment' => array(
//                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
//            )
//        );
//
//        // style color red
//        $styleColorRED = array(
//            'font' => array(
//                'color' => array('rgb' => 'FF0000'),
//                'bold' => true,
//            ),
//        );

        $styleBGColorGray = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '777777')
            )
        );

        $styleFontSize = array(
            'font' => array(
                'size' => 9
            ),
        );
//        $styleFontSize10 = array(
//            'font' => array(
//                'size' => 10
//            ),
//        );
//
//        $styleFontSize15 = array(
//            'font' => array(
//                'size' => 15
//            ),
//        );

        $styleBorderAll = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            )
        );

//        $styleBgColorHeader = array(
//                    'font' => array(
//                        'bold' => true,
//                    ),
//                    'fill' => array(
//                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
//                        'color' => array('rgb' => 'BBDEFB')
//                    )
//        );
//
//        $styleBgColorGanjil = array(
//                    'fill' => array(
//                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
//                        'color' => array('rgb' => 'E3F2FD')
//                    )
//        );
//
//        $styleBorderBottom = array(
//            'borders' => array(
//                'bottom' => array(
//                    'style' => PHPExcel_Style_Border::BORDER_THIN,
//                )
//            )
//        );
//
//        $arrayLetter = array();
        for ($letter = 'E'; $letter !== 'ZZZ'; $letter++) {
            $arrayLetter[] = $letter;
        }

        if ($type == 'ban') {
            $brandname = Brand::model()->findAllByAttributes(array('id' => $reportingComponets->getListBrandTire())); //Brand::model()->findAllByAttributes(array('brand_id'=>''));
            $branchs = Branch::model()->findAll();
            $jumlah_branch = count($branchs);
        } else {
            $brandname = Brand::model()->findAllByAttributes(array('id' => $reportingComponets->getListBrandOil())); //Brand::model()->
            $branchs = Branch::model()->findAll();
            $jumlah_branch = count($branchs);
        }

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B1', 'REKAP PENJUALAN ' . date('F Y'));

        $sheet = $objPHPExcel->getActiveSheet();
        $objPHPExcel->getActiveSheet()->freezePane('D5');

        $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);
        $objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);

        // prepare for header loop
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A3', 'NO')
                ->setCellValue('B3', 'TYPE ' . strtoupper($type))
                ->setCellValue('C3', 'KODE')
                ->setCellValue('D3', ' ');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:A4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B3:B4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C3:C4');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D3:D4');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(2);

//        $mergestart = 0;
        $letterStep11 = 0;
        foreach ($branchs as $key => $branch) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($arrayLetter[$letterStep11] . '3', $branch->name);
            for ($i = 1; $i <= 32; $i++) {

                if ($i == 32) {
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($arrayLetter[$letterStep11] . '3', 'Total');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11])->setWidth(5);
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep11] . '3:' . $arrayLetter[$letterStep11] . '4');
                } else {
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($arrayLetter[$letterStep11] . '4', $i);
                    $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11])->setWidth(3);
                }

                $letterStep11 = $letterStep11 + 1;
            }
        }

        $startRow = 5;
        foreach ($brandname as $key => $value) {
            /// start row values/
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $startRow, ' ')
                    ->setCellValue('B' . $startRow, $value->name);

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B' . $startRow . ':C' . $startRow);

            $startRow ++;
            $nomor = 1;
            $products = Product::model()->findAllByAttributes(array('brand_id' => $value->id)); //product sub category
            foreach ($products as $key => $product) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $startRow, $nomor)
                        ->setCellValue('B' . $startRow, $product->name);

                $letterStep1 = 0;
                foreach ($branchs as $key => $branch) {
                    
                    for ($i = 1; $i <= 32; $i++) {
                        $tgl = date("m", strtotime($tanggal));
                        $querytgl = date("Y-m-", strtotime($tanggal)) . $i;

                        if (date("d", strtotime($tanggal)) < $i) {
                            if ($i == 32) {
                                $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue($arrayLetter[$letterStep1] . $startRow, '=SUM(' . $arrayLetter[$letterStep1 - 31] . $startRow . ':' . $arrayLetter[$letterStep1 - 1] . $startRow . ')');
                            } else {
                                $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue($arrayLetter[$letterStep1] . $startRow, '');
                            }
                        } else {
                            if ($i == 32) {
                                $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue($arrayLetter[$letterStep1] . $startRow, '=SUM(' . $arrayLetter[$letterStep1 - 31] . $startRow . ':' . $arrayLetter[$letterStep1 - 1] . $startRow . ')');
                            } else {
                                $objPHPExcel->setActiveSheetIndex(0)
                                        ->setCellValue($arrayLetter[$letterStep1] . $startRow, $this->getRekapHarian($querytgl, $branch->id, $product->id));
                            }
                        }
                        $letterStep1 = $letterStep1 + 1;
                    }
                }
                $nomor ++;
                $startRow ++;
            }

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $startRow, ' ')
                    ->setCellValue('B' . $startRow, 'Total ' . $value->name);

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B' . $startRow . ':C' . $startRow);
            $sheet->getStyle('B' . $startRow . ':' . 'C' . $startRow)->applyFromArray($styleBGColorGray);

            $startRow++;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $startRow, ' ');

            $startRow++;
        }
        $sheet->getStyle('A3:' . $arrayLetterarray(0) . $startRow)->applyFromArray($styleFontSize);
        $sheet->getStyle('A3:' . $arrayLetterarray(0) . $startRow)->applyFromArray($styleBorderAll);
        $objPHPExcel->getActiveSheet()->setTitle('REKAP HARIAN ' . strtoupper($type));

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Save a xls file
        $filename = 'Rekap harian - ' . strtoupper($type) . date(" Ymd");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
    }
}
