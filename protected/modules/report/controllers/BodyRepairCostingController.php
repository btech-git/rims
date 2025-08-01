<?php

class BodyRepairCostingController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('director'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransaction = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        $bodyRepairCostingSummary = new BodyRepairCostingSummary($registrationTransaction->search());
        $bodyRepairCostingSummary->setupLoading();
        $bodyRepairCostingSummary->setupPaging($pageSize, $currentPage);
        $bodyRepairCostingSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        );
        $bodyRepairCostingSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($bodyRepairCostingSummary->dataProvider, array(
                'startDate' => $startDate, 
                'endDate' => $endDate,
                'branchId' => $branchId,
            ));
        }

        $this->render('summary', array(
            'bodyRepairCostingSummary' => $bodyRepairCostingSummary,
            'registrationTransaction' => $registrationTransaction,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAjaxJsonCustomer() {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['Customer']['id'])) ? $_POST['Customer']['id'] : '';
            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_name' => CHtml::value($customer, 'name'),
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

        $objPHPExcel = new PHPExcel();

        $startDate = $options['startDate'];
        $endDate = $options['endDate']; 
        $branchId = $options['branchId']; 
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Body Repair Costing');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Body Repair Costing');

        $worksheet->mergeCells('A1:L1');
        $worksheet->mergeCells('A2:L2');
        $worksheet->mergeCells('A3:L3');

        $worksheet->getStyle('A1:L6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:L6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Body Repair Costing');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:L5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'RG #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Plate #');
        $worksheet->setCellValue('D5', 'Kendaraan');
        $worksheet->setCellValue('E5', 'Customer');
        $worksheet->setCellValue('F5', 'Asuransi');
        $worksheet->setCellValue('G5', 'WO #');
        $worksheet->setCellValue('H5', 'WO Status');
        $worksheet->setCellValue('I5', 'Total');
        $worksheet->setCellValue('J5', 'HPP');
        $worksheet->setCellValue('K5', 'Sub Luar');
        $worksheet->setCellValue('L5', 'Bahan');

        $worksheet->getStyle('A6:L6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        
        foreach ($dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'transaction_number')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'transaction_date')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'vehicle.plate_number')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'vehicle.carMake.name')) . ' - ' . CHtml::encode(CHtml::value($header, 'vehicle.carModel.name')) . ' - ' . CHtml::encode(CHtml::value($header, 'vehicle.carSubModel.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'insuranceCompany.name')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'work_order_number')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'status')));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'grand_total')));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'totalHpp')));
            $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($header, 'totalWorkOrderExpense')));
            $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($header, 'totalMaterialRequest')));
//            $workOrderExpenses = WorkOrderExpenseHeader::model()->findAllByAttributes(array('registration_transaction_id' => $header->id));
//            if (!empty($workOrderExpenses)) {
//                foreach ($workOrderExpenses as $workOrderExpense) {
//                    foreach ($workOrderExpense->workOrderExpenseDetails as $detail) {
//                        $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($workOrderExpense, 'transaction_number')));
//                        $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($workOrderExpense, 'transaction_date')));
//                        $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($workOrderExpense, 'note')));
//                        $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($workOrderExpense, 'supplier.name')));
//                        $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'description')));
//                        $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($detail, 'memo')));
//                        $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($detail, 'amount')));
//                        
//                        $counter++;
//                    }                    
//                }
//            }
//            $materialRequestHeaders = MaterialRequestHeader::model()->findAllByAttributes(array('registration_transaction_id' => $header->id));
//            if (!empty($materialRequestHeaders)) {
//                foreach ($materialRequestHeaders as $materialRequestHeader) {
//                    $movementOutHeaders = MovementOutHeader::model()->findAllByAttributes(array('material_request_header_id' => $materialRequestHeader->id));
//                    foreach ($movementOutHeaders as $movementOutHeader) {
//                        foreach ($movementOutHeader->movementOutDetails as $detail) {
//                            $quantity = CHtml::encode(CHtml::value($detail, 'quantity'));
//                            $cogs = CHtml::encode(CHtml::value($detail, 'product.hpp'));
//                            $totalCost = $quantity * $cogs;
//                            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($movementOutHeader, 'movement_out_no')));
//                            $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($movementOutHeader, 'date_posting')));
//                            $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'product.name')));
//                            $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, 'warehouse.name')));
//                            $worksheet->setCellValue("N{$counter}", CHtml::encode($quantity));
//                            $worksheet->setCellValue("O{$counter}", CHtml::encode($cogs));
//                            $worksheet->setCellValue("P{$counter}", CHtml::encode($totalCost));
//
//                            $counter++;
//                        }
//                    }
//                }
//            }
            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:L{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Body Repair Costing.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
