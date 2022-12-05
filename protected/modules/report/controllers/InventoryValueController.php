<?php
class InventoryValueController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('accounting')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $product = Search::bind(new Product(), isset($_GET['Product']) ? $_GET['Product'] : '');
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
        
        $productDataProvider = $product->searchByStockCheck($pageNumber);
        $branches = Branch::model()->findAll();

        if (isset($_GET['Clear'])) {
            $product->unsetAttributes();
        }

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($productDataProvider, array());
        }
        
        $this->render('summary', array(
            'currentSort' => $currentSort,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'branches' => $branches,
        ));
    }

    public function actionDetail($id) {
        $product = Product::model()->findByPk($id);
        $branches = Branch::model()->findAllByAttributes(array('status' => 'Active'));
        $detailTabs = array();
        
        foreach ($branches as $branch) {
            $tabContent = $this->renderPartial('_viewStock', array(
                'dataProvider' => $this->getInventoryDetailDataProvider($product->id, $branch->id, 0),
                'productId' => $product->id,
                'branchId' => $branch->id,
            ), true);
            $detailTabs[$branch->name] = array('content' => $tabContent);
        }
        $tabContent = $this->renderPartial('_viewStock', array(
            'dataProvider' => $this->getInventoryDetailDataProvider($product->id, '', 0),
            'productId' => $product->id,
            'branchId' => '',
        ), true);
        $detailTabs['All'] = array('content' => $tabContent);

        $this->render('detail', array(
            'detailTabs' => $detailTabs,
            'product' => $product,
            'branches' => $branches,
        ));
    }

    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productBrandId = isset($_GET['Product']['brand_id']) ? $_GET['Product']['brand_id'] : 0;

            $this->renderPartial('_productSubBrandSelect', array(
                'productBrandId' => $productBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubBrandId = isset($_GET['Product']['sub_brand_id']) ? $_GET['Product']['sub_brand_id'] : 0;

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'productSubBrandId' => $productSubBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategoryId = isset($_GET['Product']['product_master_category_id']) ? $_GET['Product']['product_master_category_id'] : 0;

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'productMasterCategoryId' => $productMasterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategoryId = isset($_GET['Product']['product_sub_master_category_id']) ? $_GET['Product']['product_sub_master_category_id'] : 0;

            $this->renderPartial('_productSubCategorySelect', array(
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductStockTable() {
        if (Yii::app()->request->isAjaxRequest) {
            $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
            $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
            $productDataProvider = $product->searchByStockCheck($pageNumber);
            $branches = Branch::model()->findAll();

            $this->renderPartial('_productStockTable', array(
                'productDataProvider' => $productDataProvider,
                'branches' => $branches,
            ));
        }
    }
    
    public function getInventoryDetailDataProvider($productId, $branchId, $currentPage) {
        $inventoryDetail = Search::bind(new InventoryDetail(), '');
        $inventoryDetail->product_id = $productId;
        $inventoryDetailDataProvider = $inventoryDetail->searchByStock($branchId, $currentPage);
        
        return $inventoryDetailDataProvider;
    }

    protected function saveToExcel($dataProvider, array $options = array()) {
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('PT. Raperind Motor');
        $documentProperties->setTitle('Laporan Nilai Persediaan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Nilai Persediaan');

        $worksheet->mergeCells('A1:Q1');
        $worksheet->mergeCells('A2:Q2');
        $worksheet->mergeCells('A3:Q3');

        $worksheet->getStyle('A1:Q5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:Q5')->getFont()->setBold(true);

        $worksheet->setCellValue('A2', 'Laporan Nilai Persediaan');

        $worksheet->getStyle('A5:Q5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'ID');        
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('C5', 'Name');
        $worksheet->setCellValue('D5', 'Brand');
        $worksheet->setCellValue('E5', 'Sub Brand');
        $worksheet->setCellValue('F5', 'Sub Brand Series');
        $worksheet->setCellValue('G5', 'Kategori');
        $branches = Branch::model()->findAll();
        $column = 'H';
        foreach ($branches as $branch) {
            $worksheet->setCellValue($column . '5', $branch->code);
            $column++;
        }
        $worksheet->setCellValue('O5', 'Stock');
        $worksheet->setCellValue('P5', 'HPP');
        $worksheet->setCellValue('Q5', 'Inventory');

        $worksheet->getStyle('A5:Q5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;

        foreach ($dataProvider->data as $header) {
            $inventoryTotalQuantities = $header->getInventoryTotalQuantities(); 
            $inventoryCostOfGoodsSold = $header->getInventoryCostOfGoodsSold(); 
            $totalStock = 0; 
            $totalCogs = 0; 
            $totalValue = 0; 
            
            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'id')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'manufacturer_code')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'name')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'brand.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'subBrand.name')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'subBrandSeries.name')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'masterSubCategoryCode')));
            
            $column = 'H'; 
            foreach ($branches as $branch) {
                $index = -1;
                foreach ($inventoryTotalQuantities as $i => $inventoryTotalQuantity) {
                    if ($inventoryTotalQuantity['branch_id'] == $branch->id) {
                        $index = $i;
                        break;
                    }
                }
                $stockValue = CHtml::value($inventoryTotalQuantities[$i], 'total_stock');
                if ($index >= 0) {
                    $worksheet->setCellValue($column . "{$counter}", CHtml::encode($stockValue));
                } else {
                    $worksheet->setCellValue($column . "{$counter}", "0");
                }
                
                $column++;
                $totalStock += $stockValue; 
                $totalCogs += CHtml::value($inventoryCostOfGoodsSold[$i], 'cogs'); 
                $totalValue += CHtml::value($inventoryCostOfGoodsSold[$i], 'value'); 
            }
                        
            $worksheet->setCellValue("O{$counter}", CHtml::encode($totalStock));
            $worksheet->setCellValue("P{$counter}", CHtml::encode($totalCogs));
            $worksheet->setCellValue("Q{$counter}", CHtml::encode($totalValue));
            $counter++;

        }

        for ($col = 'A'; $col !== 'R'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Nilai Persediaan.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    public function actionRedirectTransaction($codeNumber) {
        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'PO') {
            $model = TransactionPurchaseOrder::model()->findByAttributes(array('purchase_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionPurchaseOrder/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'RG') {
            $model = RegistrationTransaction::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/frontDesk/registrationTransaction/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'DO') {
            $model = TransactionDeliveryOrder::model()->findByAttributes(array('delivery_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionDeliveryOrder/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'RCI') {
            $model = TransactionReceiveItem::model()->findByAttributes(array('receive_item_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionReceiveItem/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'CASH') {
            $model = CashTransaction::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/transaction/cashTransaction/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'CSI') {
            $model = ConsignmentInHeader::model()->findByAttributes(array('consignment_in_number' => $codeNumber));
            $this->redirect(array('/transaction/consignmentInHeader/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'CSO') {
            $model = ConsignmentOutHeader::model()->findByAttributes(array('consignment_out_no' => $codeNumber));
            $this->redirect(array('/transaction/consignmentOutHeader/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'MO') {
            $model = MovementOutHeader::model()->findByAttributes(array('movement_out_no' => $codeNumber));
            $this->redirect(array('/transaction/movementOutHeader/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'MI') {
            $model = MovementInHeader::model()->findByAttributes(array('movement_in_number' => $codeNumber));
            $this->redirect(array('/transaction/movementInHeader/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'Pin') {
            $model = PaymentIn::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/transaction/paymentIn/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'Pout') {
            $model = PaymentOut::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/transaction/paymentOut/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'RTI') {
            $model = TransactionReturnItem::model()->findByAttributes(array('return_item_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionReturnItem/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'TR') {
            $model = TransactionTransferRequest::model()->findByAttributes(array('transfer_request_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionTransferRequest/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'SR') {
            $model = TransactionSentRequest::model()->findByAttributes(array('sent_request_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionSentRequest/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'JAD') {
            $model = JournalAdjustmentHeader::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/journalAdjustment/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'SA') {
            $model = StockAdjustmentHeader::model()->findByAttributes(array('stock_adjustment_number' => $codeNumber));
            $this->redirect(array('/frontDest/adjustment/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'DAS') {
            $model = AssetDepreciation::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/assetDepreciation/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'SAS') {
            $model = AssetSale::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/assetSale/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'PAS') {
            $model = AssetPurchase::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/assetPurchase/view', 'id' => $model->id));
        }
    }
}