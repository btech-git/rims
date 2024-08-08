<?php

class PurchaseOrderController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('purchaseSupplierReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $supplierDataProvider = $supplier->search();
        $supplierDataProvider->pagination->pageVar = 'page_dialog';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $supplierId = (isset($_GET['SupplierId'])) ? $_GET['SupplierId'] : '';
//        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

        $purchaseReport = $supplier->getPurchaseReport($supplierId, $startDate, $endDate, $branchId);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($purchaseReport, array('startDate' => $startDate, 'endDate' => $endDate, 'branchId' => $branchId));
        }

        $this->render('summary', array(
            'purchaseReport' => $purchaseReport,
            'supplier'=>$supplier,
            'supplierDataProvider'=>$supplierDataProvider,
            'supplierId' => $supplierId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentPage' => $currentPage,
            'currentSort' => $currentSort,
            'branchId' => $branchId,
        ));
    }

    public function actionAjaxJsonSupplier($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplier = Supplier::model()->findByPk($id);

            $object = array(
                'supplier_name' => CHtml::value($supplier, 'company'),
                'supplier_code' => CHtml::value($supplier, 'code'),
            );
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($purchaseReport, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $startDate = $options['startDate'];
        $endDate = $options['endDate']; 
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Rincian Pembelian per Pemasok');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Rincian Pembelian per Pemasok');

        $worksheet->mergeCells('A1:H1');
        $worksheet->mergeCells('A2:H2');
        $worksheet->mergeCells('A3:H3');
        
        $worksheet->getStyle('A1:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:H5')->getFont()->setBold(true);

        $worksheet->setCellValue('A2', 'Rincian Pembelian per Pemasok');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:H5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Code');
        $worksheet->setCellValue('B5', 'Company');
        $worksheet->setCellValue('C5', 'Name');
        $worksheet->setCellValue('D5', 'Pembelian #');
        $worksheet->setCellValue('E5', 'Tanggal');
        $worksheet->setCellValue('F5', 'Payment');
        $worksheet->setCellValue('G5', 'Status');
        $worksheet->setCellValue('H5', 'Total Price');

        $worksheet->getStyle('A5:H5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($purchaseReport as $purchaseItem) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $totalPurchase = '0.00';
            $purchaseOrders = TransactionPurchaseOrder::model()->findAll(array(
                'condition' => 'supplier_id = :supplier_id AND purchase_order_date BETWEEN :start_date AND :end_date', 
                'params' => array(
                    ':supplier_id' => $purchaseItem['id'],
                    ':start_date' => $startDate,
                    ':end_date' => $endDate,
                )
            ));
            
            if (!empty($purchaseOrders)) {
                foreach ($purchaseOrders as $detail) {
                    $grandTotal = CHtml::value($detail, 'total_price'); 

                    $worksheet->setCellValue("A{$counter}", CHtml::encode($purchaseItem['code']));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($purchaseItem['company']));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode($purchaseItem['name']));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode($detail->purchase_order_no));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode($detail->purchase_order_date));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($detail, 'payment_type')));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail, 'payment_status')));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode($grandTotal));

                    $counter++;
                    
                    $totalPurchase += $grandTotal;
                    
                }
                
                $worksheet->getStyle("G{$counter}:H{$counter}")->getFont()->setBold(true);
                $worksheet->getStyle("G{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

                $worksheet->setCellValue("G{$counter}", 'TOTAL');
                $worksheet->setCellValue("H{$counter}", CHtml::encode($totalPurchase));
                $counter++;$counter++;
            }
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Rincian Pembelian per Pemasok.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
