<?php

class DeliveryController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('deliveryReport') ))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $deliveryOrder = Search::bind(new TransactionDeliveryOrder('search'), isset($_GET['TransactionDeliveryOrder']) ? $_GET['TransactionDeliveryOrder'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $deliveryOrderSummary = new DeliverySummary($deliveryOrder->search());
        $deliveryOrderSummary->setupLoading();
        $deliveryOrderSummary->setupPaging($pageSize, $currentPage);
        $deliveryOrderSummary->setupSorting();
        $deliveryOrderSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($deliveryOrderSummary, $branchId, $deliveryOrderSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'deliveryOrder' => $deliveryOrder,
            'deliveryOrderSummary' => $deliveryOrderSummary,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($deliveryOrderSummary, $branchId, $dataProvider, array $options = array()) {

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Delivery Order');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Delivery Order');

        $worksheet->getColumnDimension('A')->setAutoSize(true);
        $worksheet->getColumnDimension('B')->setAutoSize(true);
        $worksheet->getColumnDimension('C')->setAutoSize(true);
        $worksheet->getColumnDimension('D')->setAutoSize(true);
        $worksheet->getColumnDimension('E')->setAutoSize(true);
        $worksheet->getColumnDimension('F')->setAutoSize(true);
        $worksheet->getColumnDimension('G')->setAutoSize(true);
        $worksheet->getColumnDimension('H')->setAutoSize(true);
        $worksheet->getColumnDimension('I')->setAutoSize(true);
        $worksheet->getColumnDimension('J')->setAutoSize(true);
        $worksheet->getColumnDimension('K')->setAutoSize(true);
        $worksheet->getColumnDimension('L')->setAutoSize(true);
        $worksheet->getColumnDimension('M')->setAutoSize(true);
        $worksheet->getColumnDimension('N')->setAutoSize(true);

        $worksheet->mergeCells('A1:N1');
        $worksheet->mergeCells('A2:N2');
        $worksheet->mergeCells('A3:N3');

        $worksheet->getStyle('A1:N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:N5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Delivery Order');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:N5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Delivery #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Type');
        $worksheet->setCellValue('D5', 'Customer');
        $worksheet->setCellValue('E5', 'SO #');
        $worksheet->setCellValue('F5', 'Request #');
        $worksheet->setCellValue('G5', 'Consignment #');
        $worksheet->setCellValue('H5', 'Transfer #');
        $worksheet->setCellValue('I5', 'Branch');
        $worksheet->setCellValue('J5', 'Pengirim');
        $worksheet->setCellValue('K5', 'Product');
        $worksheet->setCellValue('L5', 'Quantity Request');
        $worksheet->setCellValue('M5', 'Quantity Kirim');
        $worksheet->setCellValue('N5', 'Memo');

        $worksheet->getStyle('A5:N5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($header->delivery_order_no));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($header->delivery_date));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'request_type')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'saleOrder.sale_order_no')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'sentRequest.sent_request_no')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'consigmentOut.consignment_out_no')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'transferRequest. transfer_request_no')));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'branch.name')));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));
            $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($header, 'product.name')));
            $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($header, 'quantity_request')));
            $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($header, 'quantity_delivery')));
            $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($header, 'note')));

            $counter++;
        }

        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Laporan Delivery Order.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
