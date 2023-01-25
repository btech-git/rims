<?php

class LaporanpenjualanController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
                $filterChain->action->id === 'index' || 
                $filterChain->action->id === 'bulanan' || 
                $filterChain->action->id === 'export' || 
                $filterChain->action->id === 'harian' || 
                $filterChain->action->id === 'tahunan'
            ) {
            if (!(Yii::app()->user->checkAccess('saleOrderReport')) || !(Yii::app()->user->checkAccess('saleInvoiceReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionIndex() {
        $reportingComponets = new ReportingComponents();

        $type = (isset($_GET['type'])) ? $_GET['type'] : 1;
        $tanggal = (isset($_GET['tanggal'])) ? $_GET['tanggal'] : date("Y-m-d");
        $brand = (isset($_GET['brand'])) ? $_GET['brand'] : '';
        $sparepart = $reportingComponets->getListSparepart();
        // echo $reportingComponets->getListSparepart()array($type);
        // var_dump($sparepartarray(1));

        if (isset($_GET['ExportExcel'])) {
            $this->getXls($type, $tanggal);
        }

        $this->render('index', array('type' => $type, 'tanggal' => $tanggal, 'brand' => $brand, 'sparepart' => $sparepart, 'reportingComponets' => $reportingComponets));
    }

    public function actionExport($type = 'ban') {
        $this->getXls($type);
    }

    public function actionHarian() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

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

        if (isset($_GET['ExportExcel']))
            $this->getXlsHarian($tanggal, $type);

        $this->render('hari', array(
            'tanggal' => $tanggal,
            'brand' => $brand,
            'brandname' => $brandname,
            'type' => $type,
            'branch' => $branch,
            'jumlah_branch' => $jumlah_branch,
            'reportingComponets' => $reportingComponets,
        ));
    }

    public function actionBulanan() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $reportingComponets = new ReportingComponents();

        $tanggal = (isset($_GET['tanggal'])) ? $_GET['tanggal']: date("Y-m-d");
        $brand = (isset($_GET['brand'])) ? $_GET['brand'] : '';
        $type = (isset($_GET['type'])) ? $_GET['type']: 'ban';

        if ($type == 'ban') {
            $brandname = Brand::model()->findAllByAttributes(array('id' => $reportingComponets->getListBrandTire())); //Brand::model()->findAllByAttributes(array('brand_id'=>''));
            $branch = Branch::model()->findAll();
            $jumlah_branch = count($branch);
        } else {
            $brandname = Brand::model()->findAllByAttributes(array('id' => $reportingComponets->getListBrandOil())); //Brand::model()->
            $branch = Branch::model()->findAll();
            $jumlah_branch = count($branch);
        }

        if (isset($_GET['ExportExcel']))
            $this->getXlsBulanan($tanggal, $type);

        $this->render('bulan', array(
            'tanggal' => $tanggal,
            'brand' => $brand,
            'brandname' => $brandname,
            'type' => $type,
            'branch' => $branch,
            'jumlah_branch' => $jumlah_branch,
            'reportingComponets' => $reportingComponets,
        ));
    }

    public function actionTahunan() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $reportingComponets = new ReportingComponents();

        $tahun = (isset($_GET['tahun'])) ? $_GET['tahun'] : date("Y");
        $brand = (isset($_GET['brand'])) ? $_GET['brand'] : '';
        $type = (isset($_GET['type'])) ? $_GET['type'] : 'ban';

        if ($type == 'ban') {
            $brandname = Brand::model()->findAllByAttributes(array('id' => $reportingComponets->getListBrandTire())); //Brand::model()->findAllByAttributes(array('brand_id'=>''));
            $branch = Branch::model()->findAll();
            $jumlah_branch = count($branch);
        } else {
            $brandname = Brand::model()->findAllByAttributes(array('id' => $reportingComponets->getListBrandOil())); //Brand::model()->
            $branch = Branch::model()->findAll();
            $jumlah_branch = count($branch);
        }

        if (isset($_GET['ExportExcel']))
            $this->getXlsTahunan($tahun, $type);

        $this->render('tahun', array(
            'tahun' => $tahun,
            'brand' => $brand,
            'brandname' => $brandname,
            'type' => $type,
            'branch' => $branch,
            'jumlah_branch' => $jumlah_branch,
            'reportingComponets' => $reportingComponets,
        ));
    }

    public function getXls($type, $tanggal) {
        // die($type.$tanggal);
        if (empty($tanggal)) {
            $tanggal2 = date('d-m-Y');
        } else {
            $tanggal2 = $tanggal;
        }
        $reportingComponets = new ReportingComponents();
        $typeName = preg_replace("/array(^a-z_\-\ 0-9)/i", "-", $reportingComponets->getListSparepart()[$type]);

        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
                ->setLastModifiedBy("Apri Pebriana")
                ->setTitle("Laporan Penjualan " . date('d-m-Y'))
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
                'size' => 9
            ),
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
        $brandname = Brand::model()->findAllByAttributes(array('id' => $reportingComponets->getSparepartId($type))); //Brand::model()->findAllByAttributes(array('brand_id'=>''));
        $branch = Branch::model()->findAll();
        $jumlah_branch = count($branch);
        // Add some data
        $typeName = substr($typeName, 0, 15);
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B1', 'REKAP STOK ' . date('F Y', strtotime($tanggal2)));
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:N1');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'STOK ' . strtoupper($typeName) . ' ' . date('d F Y', strtotime($tanggal2)));

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('B1:AZ1')->applyFromArray($styleHorizontalVertivalCenterBold);
        $objPHPExcel->getActiveSheet()->freezePane('D5');

        $arrayLetter = array();
        for ($letter = 'A'; $letter !== 'ZZ'; $letter++) {
            $arrayLetter[] = $letter;
        }

        // $objPHPExcel->getActiveSheet()->getColumnDimension('A3')->setHeight(20);
        $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);
        $objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);

        // prepare for header loop
        $letterStep11 = 0;
        foreach ($brandname as $key => $value) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($arrayLetter[$letterStep11] . '3', 'NO')
                    ->setCellValue($arrayLetter[$letterStep11 + 1] . '3', 'TYPE ' . strtoupper($typeName))
                    ->setCellValue($arrayLetter[$letterStep11 + 2] . '3', 'KODE')
                    ->setCellValue($arrayLetter[$letterStep11 + 1] . '4', $value->name)
                    ->setCellValue($arrayLetter[$letterStep11 + 3] . '3', ' ');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep11 + 1] . '4:' . $arrayLetter[$letterStep11 + 2] . '4');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep11] . '3:' . $arrayLetter[$letterStep11] . '4');

            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11])->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11 + 1])->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11 + 2])->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11 + 3])->setWidth(2);

            $sheet->getStyle('A3:' . $arrayLetter[$letterStep11] . '4')->applyFromArray($styleHorizontalVertivalCenter);

            $starbranchheading = $letterStep11 + 4;
            foreach ($branch as $key => $bcan) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($arrayLetter[$starbranchheading] . '3', $bcan->name);
                $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$starbranchheading])->setWidth(3);
                $objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$starbranchheading]. '3')->getAlignment()->setTextRotation(90);

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$starbranchheading]. '3:' . $arrayLetter[$starbranchheading] . '4');

                $starbranchheading++;
            }
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($arrayLetter[$letterStep11 + $jumlah_branch + 4] . '3', 'Total')
                    ->setCellValue($arrayLetter[$letterStep11 + $jumlah_branch + 5] . '3', ' ');

            $sheet->getStyle($arrayLetter[$letterStep11 + $jumlah_branch + 5] . '3' . ':' . $arrayLetter[$letterStep11 + $jumlah_branch + 5] . '5')->applyFromArray($styleBGColorGray);

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep11 + $jumlah_branch + 4] . '3:' . $arrayLetter[$letterStep11 + $jumlah_branch + 4] . '4');
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11 + $jumlah_branch + 4])->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11 + $jumlah_branch + 5])->setWidth(2);

            $letterStep11 = $letterStep11 + $jumlah_branch + 6;
        }
        // end header loop//

        $sheet->getStyle('A3:' . $arrayLetter[$letterStep11] . '4')->applyFromArray($styleFontSize);
        $sheet->getStyle('A3:' . $arrayLetter[$letterStep11]. '4')->applyFromArray($styleBorderAll);

        //	prepare for row content 
        $letterContentStep11 = 0;
        $startRow = 5;
        foreach ($brandname as $key => $value) {
            $products = Product::model()->findAllByAttributes(array('brand_id' => $value->id)); //product sub category
            // var_dump(count($product)); die();
            // for ($nomor=1; $nomor < count($product); $nomor++) { 
            $nomor = 1;
            foreach ($products as $key => $product) {
                # code...
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($arrayLetter[$letterContentStep11] . $startRow, $nomor)
                        ->setCellValue($arrayLetter[$letterContentStep11 + 1] . $startRow, (empty($product->subBrandSeries) ? '' : $product->subBrandSeries->name))
                        ->setCellValue($arrayLetter[$letterContentStep11 + 2] . $startRow, $product->manufacturer_code)
                        ->setCellValue($arrayLetter[$letterContentStep11 + 3] . $startRow, '');

                $starbranchContent = $letterContentStep11 + 4;
                foreach ($branch as $key => $bcan) {

                    if ($tanggal != NULL) {
                        $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue($arrayLetter[$starbranchContent] . $startRow, $this->getStockDate($product->id, $bcan->id, $tanggal));
                    } else {
                        $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue($arrayLetter[$starbranchContent] . $startRow, $this->getStock($product->id, $bcan->id));
                    }

                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($arrayLetter[$letterContentStep11 + $jumlah_branch + 4] . $startRow, '=SUM(' . $arrayLetter[$letterContentStep11 + 4] . $startRow . ':' . $arrayLetter[$starbranchContent] . $startRow . ')')
                            ->setCellValue($arrayLetter[$letterContentStep11 + $jumlah_branch + 5] . $startRow, ' ');

                    $sheet->getStyle($arrayLetter[$letterContentStep11 + $jumlah_branch + 5] . ($startRow + 1))->applyFromArray($styleBGColorGray);

                    $starbranchContent++;
                }
                
                $nomor ++;
                $startRow ++;
            }

            if (count($products) > 0) {
                // set total
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($arrayLetter[$letterContentStep11 + 1] . $startRow, 'Total ' . $value->name)
                        ->setCellValue($arrayLetter[$letterContentStep11 + 3] . $startRow, '');
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterContentStep11 + 1] . $startRow . ':' . $arrayLetter[$letterContentStep11 + 2] . $startRow);
                // total branch
                $totalstarbranchContent = $letterContentStep11 + 4;
                foreach ($branch as $key => $bcan) {
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($arrayLetter[$totalstarbranchContent] . $startRow, '=SUM(' . $arrayLetter[$totalstarbranchContent] . '5:' . $arrayLetter[$totalstarbranchContent] . ($startRow - 1) . ')');
                    $totalstarbranchContent ++;
                }
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($arrayLetter[$letterContentStep11 + $jumlah_branch + 4] . $startRow, '=SUM(' . $arrayLetter[$letterContentStep11 + $jumlah_branch + 4] . '5:' . $arrayLetter[$letterContentStep11 + $jumlah_branch + 4] . ($startRow - 1) . ')');
            }

            //style the content//
            //jump to next branch
            $letterContentStep11 = $letterContentStep11 + $jumlah_branch + 6;
            $sheet->getStyle('A5:' . $arrayLetter[$letterContentStep11 - 2] . $startRow)->applyFromArray($styleFontSize);
            $sheet->getStyle('A5:' . $arrayLetter[$letterContentStep11 - 2] . $startRow)->applyFromArray($styleBorderAll);

            // reset to default
            $startRow = 5;
        }

        // end row content
        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Laporan Stok ' . strtoupper($typeName));

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Save a xls file
        $filename = 'Laporan Posisi Stok - ' . strtoupper($type) . ' ' . $tanggal2;
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
    }

    public function getXlsHarian($tanggal, $type) {

        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        ini_set('memory_limit', '2048M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $reportingComponets = new ReportingComponents();
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("BloomingTech")
                ->setLastModifiedBy("Apri Pebriana")
                ->setTitle("REKAP HARIAN " . date('d-m-Y'))
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
                'size' => 9
            ),
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

        $arrayLetter = array();
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
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:ZZ1');
        // $objPHPExcel->setActiveSheetIndex(0)
        //     ->setCellValue('A2', 'STOK '.strtoupper($type).date(' d F Y'));

        $sheet = $objPHPExcel->getActiveSheet();
        // $sheet->getStyle('B1:AZ1')->applyFromArray($styleHorizontalVertivalCenterBold);
        $objPHPExcel->getActiveSheet()->freezePane('D5');

        // echo $jumlah_branch * 31; 
        // var_dump($arrayLetter); die();
        // $objPHPExcel->getActiveSheet()->getColumnDimension('A3')->setHeight(20);
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

        $mergestart = 0;
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
                            ->setCellValue($arrayLetter[$letterStep11]. '4', $i);
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
                        // $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep1))->setWidth(3);
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
        $sheet->getStyle('A3:' . $arrayLetter[0] . $startRow)->applyFromArray($styleFontSize);
        $sheet->getStyle('A3:' . $arrayLetter[0] . $startRow)->applyFromArray($styleBorderAll);
        // end header loop//
        // end row content
        // Rename worksheet
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

    public function getXlsBulanan($bulan, $type) {

        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        ini_set('memory_limit', '2048M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $reportingComponets = new ReportingComponents();
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("BloomingTech")
                ->setLastModifiedBy("Apri Pebriana")
                ->setTitle("Laporan Penjualan " . date('d-m-Y'))
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
                'size' => 9
            ),
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

        if ($type == 'ban') {
            $brandname = Brand::model()->findAllByAttributes(array('id' => $reportingComponets->getListBrandTire())); //Brand::model()->findAllByAttributes(array('brand_id'=>''));
            $branch = Branch::model()->findAll();
            $jumlah_branch = count($branch);
        } else {
            $brandname = Brand::model()->findAllByAttributes(array('id' => $reportingComponets->getListBrandOil())); //Brand::model()->
            $branch = Branch::model()->findAll();
            $jumlah_branch = count($branch);
        }

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B1', 'REKAP JUAL PER CABANG ' . strtoupper(date("F", strtotime($bulan))));
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:N1');
        
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('B1:AZ1')->applyFromArray($styleHorizontalVertivalCenterBold);
        $objPHPExcel->getActiveSheet()->freezePane('D5');

        $arrayLetter = array();
        for ($letter = 'A'; $letter !== 'ZZ'; $letter++) {
            $arrayLetter[] = $letter;
        }

        // $objPHPExcel->getActiveSheet()->getColumnDimension('A3')->setHeight(20);
        $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);
        $objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);

        // prepare for header loop
        $letterStep11 = 0;
        foreach ($brandname as $key => $value) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($arrayLetter[$letterStep11] . '3', 'NO')
                    ->setCellValue($arrayLetter[$letterStep11 + 1] . '3', 'TYPE ' . strtoupper($type))
                    ->setCellValue($arrayLetter[$letterStep11 + 2] . '3', 'KODE')
                    ->setCellValue($arrayLetter[$letterStep11 + 1] . '4', $value->name)
                    ->setCellValue($arrayLetter[$letterStep11 + 3] . '3', ' ');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep11 + 1] . '4:' . $arrayLetter[$letterStep11 + 2] . '4');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep11] . '3:' . $arrayLetter[$letterStep11]. '4');

            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11])->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11 + 1])->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11 + 2])->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11 + 3])->setWidth(2);

            $sheet->getStyle('A3:' . $arrayLetter[$letterStep11] . '4')->applyFromArray($styleHorizontalVertivalCenter);

            $starbranchheading = $letterStep11 + 4;
            foreach ($branch as $key => $bcan) {

                $objPHPExcel->setActiveSheetIndex(0)
                        // ->setCellValue($arrayLetter[$starbranchheading).'3', $bulan)
                        ->setCellValue($arrayLetter[$starbranchheading] . '4', $bcan->name);
                $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$starbranchheading])->setWidth(3);
                $objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$starbranchheading]. '4')->getAlignment()->setTextRotation(90);

                // $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$starbranchheading).'3:'.$arrayLetter[$starbranchheading).'4');

                $starbranchheading++;
            }

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($arrayLetter[$letterStep11 + 4] . '3', strtoupper(date("F", strtotime($bulan))))
                    ->setCellValue($arrayLetter[$letterStep11 + $jumlah_branch + 4] . '3', 'Total')
                    ->setCellValue($arrayLetter[$letterStep11 + $jumlah_branch + 5] . '3', ' ');

            $sheet->getStyle($arrayLetter[$letterStep11 + $jumlah_branch + 5] . '3' . ':' . $arrayLetter[$letterStep11 + $jumlah_branch + 5] . '5')->applyFromArray($styleBGColorGray);

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep11 + 4] . '3:' . $arrayLetter[$letterStep11 + $jumlah_branch + 3] . '3');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep11 + $jumlah_branch + 4] . '3:' . $arrayLetter[$letterStep11 + $jumlah_branch + 4] . '4');
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11 + $jumlah_branch + 4])->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11 + $jumlah_branch + 5])->setWidth(2);


            $letterStep11 = $letterStep11 + $jumlah_branch + 6;
        }
        // end header loop//

        $sheet->getStyle('A3:' . $arrayLetter[$letterStep11] . '4')->applyFromArray($styleFontSize);
        $sheet->getStyle('A3:' . $arrayLetter[$letterStep11] . '4')->applyFromArray($styleBorderAll);

        // for content loop
        $letterContentStep11 = 0;
        $startRow = 5;
        foreach ($brandname as $key => $value) {
            $products = Product::model()->findAllByAttributes(array('brand_id' => $value->id)); //product sub category
            $nomor = 1;
            foreach ($products as $key => $product) {
                # code...
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($arrayLetter[$letterContentStep11] . $startRow, $nomor)
                        ->setCellValue($arrayLetter[$letterContentStep11 + 1] . $startRow, empty($product->subBrandSeries) ? '' : $product->subBrandSeries->name)
                        ->setCellValue($arrayLetter[$letterContentStep11 + 2] . $startRow, $product->manufacturer_code)
                        ->setCellValue($arrayLetter[$letterContentStep11 + 3] . $startRow, '');

                $starbranchContent = $letterContentStep11 + 4;
                foreach ($branch as $key => $bcan) {
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($arrayLetter[$starbranchContent] . $startRow, $this->getRekapBulanan($bulan, $product->id, $bcan->id));
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($arrayLetter[$letterContentStep11 + $jumlah_branch + 4] . $startRow, '=SUM(' . $arrayLetter[$letterContentStep11 + 4] . $startRow . ':' . $arrayLetter[$starbranchContent] . $startRow . ')')
                            ->setCellValue($arrayLetter[$letterContentStep11 + $jumlah_branch + 5]. $startRow, ' ');

                    $sheet->getStyle($arrayLetter[$letterContentStep11 + $jumlah_branch + 5] . ($startRow + 1))->applyFromArray($styleBGColorGray);

                    $starbranchContent++;
                }
                
                $nomor ++;
                $startRow ++;
            }

            if (count($products) > 0) {
                // set total
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($arrayLetter[$letterContentStep11 + 1] . $startRow, 'Total ' . $value->name)
                        ->setCellValue($arrayLetter[$letterContentStep11 + 3] . $startRow, '');
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterContentStep11 + 1] . $startRow . ':' . $arrayLetter[$letterContentStep11 + 2] . $startRow);
                // total branch
                $totalstarbranchContent = $letterContentStep11 + 4;
                foreach ($branch as $key => $bcan) {
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($arrayLetter[$totalstarbranchContent] . $startRow, '=SUM(' . $arrayLetter[$totalstarbranchContent] . '5:' . $arrayLetter[$totalstarbranchContent] . ($startRow - 1) . ')');
                    $totalstarbranchContent ++;
                }
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($arrayLetter[$letterContentStep11 + $jumlah_branch + 4] . $startRow, '=SUM(' . $arrayLetter[$letterContentStep11 + $jumlah_branch + 4] . '5:' . $arrayLetter[$letterContentStep11 + $jumlah_branch + 4] . ($startRow - 1) . ')');
            }

            //style the content//
            //jump to next branch
            $letterContentStep11 = $letterContentStep11 + $jumlah_branch + 6;
            $sheet->getStyle('A5:' . $arrayLetter[$letterContentStep11 - 2] . $startRow)->applyFromArray($styleFontSize);
            $sheet->getStyle('A5:' . $arrayLetter[$letterContentStep11 - 2] . $startRow)->applyFromArray($styleBorderAll);

            // reset to default
            $startRow = 5;
        }

        // end row content
        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Laporan Stok ' . strtoupper($type));

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Save a xls file
        $filename = 'Laporan Bulanan - ' . strtoupper($type) . date(" Ymd");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
    }

    public function getXlsTahunan($tahun, $type) {

        ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        ini_set('memory_limit', '2048M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        if ($tahun == '') {
            $tahun = date("Y");
        } else {
            $tahun;
        }

        $reportingComponets = new ReportingComponents();
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("BloomingTech")
                ->setLastModifiedBy("Apri Pebriana")
                ->setTitle("Laporan Penjualan " . date('d-m-Y'))
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
                'size' => 9
            ),
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

        if ($type == 'ban') {
            $brandname = Brand::model()->findAllByAttributes(array('id' => $reportingComponets->getListBrandTire())); //Brand::model()->findAllByAttributes(array('brand_id'=>''));
            $branch = Branch::model()->findAll();
            $jumlah_branch = count($branch);
        } else {
            $brandname = Brand::model()->findAllByAttributes(array('id' => $reportingComponets->getListBrandOil())); //Brand::model()->
            $branch = Branch::model()->findAll();
            $jumlah_branch = count($branch);
        }

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B1', 'REKAP JUALAN GABUNGAN ' . strtoupper($tahun));
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:N1');

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('B1:AZ1')->applyFromArray($styleHorizontalVertivalCenterBold);
        $objPHPExcel->getActiveSheet()->freezePane('D5');

        $arrayLetter = array();
        for ($letter = 'A'; $letter !== 'ZZ'; $letter++) {
            $arrayLetter[] = $letter;
        }

        // $objPHPExcel->getActiveSheet()->getColumnDimension('A3')->setHeight(20);
        $objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);
        $objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);

        // prepare for header loop
        $letterStep11 = 0;
        foreach ($brandname as $key => $value) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($arrayLetter[$letterStep11] . '3', 'NO')
                    ->setCellValue($arrayLetter[$letterStep11 + 1] . '3', 'TYPE ' . strtoupper($type))
                    ->setCellValue($arrayLetter[$letterStep11 + 2] . '3', 'KODE')
                    ->setCellValue($arrayLetter[$letterStep11 + 1] . '4', $value->name)
                    ->setCellValue($arrayLetter[$letterStep11 + 3] . '3', ' ');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep11 + 1] . '4:' . $arrayLetter[$letterStep11 + 2] . '4');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep11] . '3:' . $arrayLetter[$letterStep11] . '4');

            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11])->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11 + 1])->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11 + 2])->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11 + 3])->setWidth(2);

            $sheet->getStyle('A3:' . $arrayLetter[$letterStep11] . '4')->applyFromArray($styleHorizontalVertivalBottom);

            $starbranchheading = $letterStep11 + 4;

            for ($i = 1; $i <= 12; $i++) {
                $tgl = $tahun . '-' . sprintf("%02d", $i) . '-01';
                // var_dump($tgl); 
                $objPHPExcel->setActiveSheetIndex(0)
                        // ->setCellValue($arrayLetter[$starbranchheading).'3', $bulan)
                        ->setCellValue($arrayLetter[$starbranchheading] . '4', strtoupper(date("M", strtotime($tgl))));
                $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$starbranchheading])->setWidth(3);
                $objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$starbranchheading] . '4')->getAlignment()->setTextRotation(90);

                $starbranchheading++;
            }

            // die();
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($arrayLetter[$letterStep11 + 4] . '3', strtoupper('Penjualan Tahun ' . $tahun))
                    ->setCellValue($arrayLetter[$starbranchheading] . '3', 'Total')
                    ->setCellValue($arrayLetter[$starbranchheading + 1] . '3', ' ');

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep11 + 4] . '3:' . $arrayLetter[$starbranchheading - 1] . '3');
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$starbranchheading] . '3:' . $arrayLetter[$starbranchheading]. '4');
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$starbranchheading])->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$starbranchheading + 1])->setWidth(2);

            $letterStep11 = $letterStep11 + 18;
        }
        // end header loop//

        $sheet->getStyle('A3:' . $arrayLetter[$letterStep11] . '4')->applyFromArray($styleFontSize);
        $sheet->getStyle('A3:' . $arrayLetter[$letterStep11] . '4')->applyFromArray($styleBorderAll);

        // for content loop
        $letterContentStep11 = 0;
        $startRow = 5;
        foreach ($brandname as $key => $value) {
            $products = Product::model()->findAllByAttributes(array('brand_id' => $value->id)); //product sub category
            // var_dump(count($product)); die();
            // for ($nomor=1; $nomor < count($product); $nomor++) { 
            $nomor = 1;
            foreach ($products as $key => $product) {
                # code...
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($arrayLetter[$letterContentStep11] . $startRow, $nomor)
                        ->setCellValue($arrayLetter[$letterContentStep11 + 1] . $startRow, (empty($product->subBrandSeries) ? '' : $product->subBrandSeries->name))
                        ->setCellValue($arrayLetter[$letterContentStep11 + 2] . $startRow, $product->manufacturer_code)
                        ->setCellValue($arrayLetter[$letterContentStep11 + 3]. $startRow, '');

                $starbranchContent = $letterContentStep11 + 4;
                for ($i = 1; $i <= 12; $i++) {
                    // foreach (range(1, 12) as $month)
                    $tgl = $tahun . '-' . sprintf('%02d', $i) . '-01';
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($arrayLetter[$starbranchContent] . $startRow, $this->getRekapTahunan($tgl, $product->id));

                    $starbranchContent++;
                }
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($arrayLetter[$starbranchContent] . $startRow, '=SUM(' . $arrayLetter[$letterContentStep11 + 4] . $startRow . ':' . $arrayLetter[$starbranchContent - 1] . $startRow . ')')
                        ->setCellValue($arrayLetter[$starbranchContent + 1] . $startRow, ' ');

                $sheet->getStyle($arrayLetter[$starbranchContent + 1] . ($startRow - 2))->applyFromArray($styleBGColorGray);
                // if ($startRow % 2 ) {
                // 	$sheet->getStyle('A'.$startRow.':X'.$startRow)->applyFromArray($styleBgColorGanjil);
                // }
                $nomor ++;
                $startRow ++;
            }

            if (count($products) > 0) {
                // set total
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($arrayLetter[$letterContentStep11 + 1] . $startRow, 'Total ' . $value->name)
                        ->setCellValue($arrayLetter[$letterContentStep11 + 3]. $startRow, '');
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterContentStep11 + 1]. $startRow . ':' . $arrayLetter[$letterContentStep11 + 2] . $startRow);
                // total branch
                $totalstarbranchContent = $letterContentStep11 + 4;
                for ($i = 1; $i <= 12; $i++) {
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue($arrayLetter[$totalstarbranchContent] . $startRow, '=SUM(' . $arrayLetter[$totalstarbranchContent] . '5:' . $arrayLetter[$totalstarbranchContent] . ($startRow - 1) . ')');
                    $totalstarbranchContent ++;
                }
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($arrayLetter[$totalstarbranchContent] . $startRow, '=SUM(' . $arrayLetter[$totalstarbranchContent]. '5:' . $arrayLetter[$totalstarbranchContent] . ($startRow - 1) . ')');
            }

            //style the content//
            //jump to next branch
            $letterContentStep11 = $letterContentStep11 + 18;
            $sheet->getStyle('A5:' . $arrayLetter[$letterContentStep11 - 2] . $startRow)->applyFromArray($styleFontSize);
            $sheet->getStyle('A5:' . $arrayLetter[$letterContentStep11 - 2] . $startRow)->applyFromArray($styleBorderAll);

            // reset to default
            $startRow = 5;
        }

        // end row content*/
        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Laporan Stok ' . strtoupper($type));

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Save a xls file
        $filename = 'Laporan Tahunan - ' . strtoupper($type) . date(" Ymd");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
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

    public function getStock($productid, $branchid) {
        $getWarehouse = Warehouse::model()->findAllByAttributes(array("branch_id" => $branchid));
        if ($getWarehouse == NULL) {
            $totalstok = 0;
        } else {
            $totalstok = 0;
            foreach ($getWarehouse as $key => $value) {
                $inventoryStock = Inventory::model()->findByAttributes(array('product_id' => $productid, 'warehouse_id' => $value->id));
                if ($inventoryStock != NULL) {
                    $totalstok = $totalstok + $inventoryStock->total_stock;
                } else {
                    $totalstok = 0;
                }
            }
        }
        return $totalstok;
    }

    public function getStockDate($productid, $branchid, $tanggal) {
        $getWarehouse = Warehouse::model()->findAllByAttributes(array("branch_id" => $branchid));
        if ($getWarehouse == NULL) {
            $totalstok = 0;
        } else {
            $totalstok = 0;
            foreach ($getWarehouse as $key => $value) {
                /* $inventoryStock = Inventory::model()->findByAttributes(array('product_id'=>$productid,'warehouse_id'=>$value->id));
                  if ($inventoryStock != NULL) {
                  $totalstok = $totalstok + $inventoryStock->total_stock;
                  }else{
                  $totalstok =0;
                  } */

                $inventoryStock = InventoryDetail::model()->findAllByAttributes(array('product_id' => $productid, 'warehouse_id' => $value->id, 'transaction_date' => $tanggal));
                if ($inventoryStock != NULL) {
                    foreach ($inventoryStock as $keya => $valuea) {
                        # code...
                        $totalstok = $totalstok + $valuea->stock_in;
                    }
                } else {
                    $totalstok = 0;
                }
            }
        }
        return $totalstok;
    }

    public function getRekapHarian($tgl = '2017-02-02', $branch = 1, $product = 1) {
        // $salesorder = TransactionSalesOrder::model()->findAllByAttributes(array('sale_order_date')=>$tgl);

        $totalPenjualan = 0;
        $criteria = new CDbCriteria();
        $criteria->with = array('transactionSalesOrderDetails');
        $criteria->compare('t.requester_branch_id', $branch, true);
        $criteria->compare('t.sale_order_date', $tgl, true);
        $criteria->compare('transactionSalesOrderDetails.product_id', $product, true);
        // find all posts
        $salesOrder = TransactionSalesOrder::model()->findAll($criteria);

        if ($salesOrder != NULL) {
            foreach ($salesOrder as $post) {
                $totalPenjualan = $totalPenjualan + $post->total_quantity;
            }
            return $totalPenjualan;
        } else {
            return '';
        }
        // return 0;
    }

    public function getRekapBulanan($bulan, $branch = 1, $product = 1) {

        $totalPenjualan = 0;
        $criteria = new CDbCriteria();
        $criteria->with = array('transactionSalesOrderDetails');
        $criteria->compare('t.requester_branch_id', $branch, true);
        $criteria->addBetweenCondition('t.sale_order_date', date("Y-m-01", strtotime($bulan)), date("Y-m-t", strtotime($bulan)));

        $criteria->compare('transactionSalesOrderDetails.product_id', $product, true);
        // find all posts
        $salesOrder = TransactionSalesOrder::model()->findAll($criteria);

        if ($salesOrder != NULL) {
            foreach ($salesOrder as $post) {
                $totalPenjualan = $totalPenjualan + $post->total_quantity;
            }
            return $totalPenjualan;
        } else {
            return '';
        }
    }

    public function getRekapTahunan($tahun, $product) {
        // $salesorder = TransactionSalesOrder::model()->findAllByAttributes(array('sale_order_date')=>$tgl);

        $totalPenjualan = 0;
        $criteria = new CDbCriteria();
        $criteria->with = array('transactionSalesOrderDetails');
        $criteria->addBetweenCondition('t.sale_order_date', date("Y-m-01", strtotime($tahun)), date("Y-m-t", strtotime($tahun)));

        $criteria->compare('transactionSalesOrderDetails.product_id', $product, true);
        // find all posts
        $salesOrder = TransactionSalesOrder::model()->findAll($criteria);

        if ($salesOrder != NULL) {
            foreach ($salesOrder as $post) {
                $totalPenjualan = $totalPenjualan + $post->total_quantity;
            }
            return (int) $totalPenjualan;
        } else {
            return '';
        }
    }
}
