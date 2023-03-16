<?php

class SaleRetailServiceDetailController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleServiceReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : array());
        $serviceDataProvider = $service->search();

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $saleRetailServiceSummary = new SaleRetailServiceSummary($serviceDataProvider);
        $saleRetailServiceSummary->setupLoading();
        $saleRetailServiceSummary->setupPaging($pageSize, $currentPage);
        $saleRetailServiceSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
        );
        $saleRetailServiceSummary->setupFilter($filters);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleRetailServiceSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'saleRetailServiceSummary' => $saleRetailServiceSummary,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentPage' => $currentPage,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAjaxJsonService() {
        if (Yii::app()->request->isAjaxRequest) {
            $serviceId = (isset($_POST['Service']['id'])) ? $_POST['Service']['id'] : '';
            $service = Service::model()->findByPk($serviceId);

            $object = array(
                'service_name' => CHtml::value($service, 'name'),
            );
            
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $startDate = $options['startDate'];
        $endDate = $options['endDate'];
        
        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Retail Service Detail');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Retail Service Detail');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');

        $worksheet->getStyle('A1:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G6')->getFont()->setBold(true);

        $worksheet->setCellValue('A2', 'Penjualan Retail Service Detail');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:G5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Code');
        $worksheet->setCellValue('B5', 'Name');
        $worksheet->setCellValue('C5', 'Category');
        $worksheet->setCellValue('D5', 'Type');

        $worksheet->setCellValue('A6', 'Penjualan #');
        $worksheet->setCellValue('B6', 'Tanggal');
        $worksheet->setCellValue('C6', 'Jenis');
        $worksheet->setCellValue('D6', 'Customer');
        $worksheet->setCellValue('E6', 'Vehicle');
        $worksheet->setCellValue('F6', 'Type');
        $worksheet->setCellValue('G6', 'Harga');

        $worksheet->getStyle('A6:G6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        foreach ($dataProvider->data as $header) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($header->code));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'name')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'serviceCategory.name')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'serviceType.name')));
            
            $counter++;
            
            $saleRetailData = $header->getSaleRetailReport($startDate, $endDate);
            $totalSale = 0.00;
            foreach ($saleRetailData as $saleRetailRow) {
                $total = $saleRetailRow['total_price'];
                
                $worksheet->getStyle("I{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::encode($saleRetailRow['transaction_number']));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($saleRetailRow['transaction_date']));
                $worksheet->setCellValue("C{$counter}", CHtml::encode($saleRetailRow['repair_type']));
                $worksheet->setCellValue("D{$counter}", CHtml::encode($saleRetailRow['customer']));
                $worksheet->setCellValue("E{$counter}", CHtml::encode($saleRetailRow['vehicle']));
                $worksheet->setCellValue("F{$counter}", CHtml::encode($saleRetailRow['type']));
                $worksheet->setCellValue("G{$counter}", CHtml::encode($total));

                $counter++;
                $totalSale += $total;

            }

            $worksheet->getStyle("F{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

            $worksheet->setCellValue("F{$counter}", 'TOTAL');
            $worksheet->setCellValue("G{$counter}", CHtml::encode($totalSale));
            $counter++;$counter++;

        }

        for ($col = 'A'; $col !== 'H'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Penjualan Retail Service Detail.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
