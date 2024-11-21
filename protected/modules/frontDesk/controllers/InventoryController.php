<?php

class InventoryController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'check' || 
            $filterChain->action->id === 'detail' || 
            $filterChain->action->id === 'redirectTransaction'
        ) {
            if (!(Yii::app()->user->checkAccess('warehouseStockReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCheck() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $stockOperator = isset($_GET['StockOperator']) ? $_GET['StockOperator'] : '<>';
        $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
        $endDate = isset($_GET['EndDate']) ? $_GET['EndDate'] : date('Y-m-d');
        $product = Search::bind(new Product(), isset($_GET['Product']) ? $_GET['Product'] : '');
        $productDataProvider = $product->searchByStockCheck($pageNumber, $endDate, $stockOperator);
        $branches = Branch::model()->findAll();

        if (isset($_GET['ResetFilter'])) {
            $product->unsetAttributes();
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($productDataProvider, $branches, $endDate);
        }

        $this->render('check', array(
            'endDate' => $endDate,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'branches' => $branches,
            'pageNumber' => $pageNumber,
            'stockOperator' => $stockOperator,
        ));
    }

    public function actionDetail($id, $endDate) {
        $product = Product::model()->findByPk($id);
        $branches = Branch::model()->findAllByAttributes(array('status' => 'Active'));
        $detailTabs = array();
        
        $limit = 500;
        
        foreach ($branches as $branch) {
            $latestInventoryData = InventoryDetail::getLatestInventoryData($product->id, $branch->id, $limit, $endDate);
            $excludeInventoryIds = array_map(function($item) { return $item['id']; }, $latestInventoryData);
            $inventoryBeginningStock = InventoryDetail::getInventoryBeginningStock($product->id, $branch->id, $excludeInventoryIds);
            $tabContent = $this->renderPartial('_viewStock', array(
                'latestInventoryData' => $latestInventoryData,
                'inventoryBeginningStock' => $inventoryBeginningStock,
            ), true);
            $detailTabs[$branch->name] = array('content' => $tabContent);
        }
        $latestInventoryData = InventoryDetail::getLatestInventoryData($product->id, '', $limit, $endDate);
        $excludeInventoryIds = array_map(function($item) { return $item['id']; }, $latestInventoryData);
        $inventoryBeginningStock = InventoryDetail::getInventoryBeginningStock($product->id, '', $excludeInventoryIds);
        $tabContent = $this->renderPartial('_viewStock', array(
            'latestInventoryData' => $latestInventoryData,
            'inventoryBeginningStock' => $inventoryBeginningStock,
        ), true);
        $detailTabs['All'] = array('content' => $tabContent);

        $this->render('detail', array(
            'detailTabs' => $detailTabs,
            'product' => $product,
            'branches' => $branches,
            'endDate' => $endDate,
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
            $stockOperator = isset($_GET['StockOperator']) ? $_GET['StockOperator'] : '<>';
            $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
            $endDate = isset($_GET['EndDate']) ? $_GET['EndDate'] : date('Y-m-d');
            $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
            $productDataProvider = $product->searchByStockCheck($pageNumber, $endDate, $stockOperator);
            $branches = Branch::model()->findAll();

            $this->renderPartial('_productStockTable', array(
                'productDataProvider' => $productDataProvider,
                'branches' => $branches,
                'endDate' => $endDate,
                'stockOperator' => $stockOperator,
            ));
        }
    }

    public function actionRedirectTransaction($codeNumber) {
        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'MI') {
            $model = MovementInHeader::model()->findByAttributes(array('movement_in_number' => $codeNumber));
            $this->redirect(array('/transaction/movementInHeader/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'MO') {
            $model = MovementOutHeader::model()->findByAttributes(array('movement_out_no' => $codeNumber));
            $this->redirect(array('/transaction/movementOutHeader/view', 'id' => $model->id));
        }
    }

    public function actionAjaxHtmlUpdateInventoryDetailGrid($productId, $branchId, $currentPage) {
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('_viewStock', array(
                'dataProvider' => $this->getInventoryDetailDataProvider($productId, $branchId, $currentPage),
                'productId' => $productId,
                'branchId' => $branchId,
            ));
        }
    }
    
    public function getInventoryDetailDataProvider($productId, $branchId, $currentPage) {
        $inventoryDetail = Search::bind(new InventoryDetail(), '');
        $inventoryDetail->product_id = $productId;
        $inventoryDetailDataProvider = $inventoryDetail->searchByStock($branchId, $currentPage);
        
        return $inventoryDetailDataProvider;
    }
    
    public function actionScript() {
        $sql = "SELECT GROUP_CONCAT(id SEPARATOR ',') AS ids
                FROM rims_inventory_detail
                WHERE transaction_number NOT IN ('Beginning Stock', 'Adjustment Stock')
                GROUP BY transaction_number, product_id
                HAVING COUNT(*) > 1";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);
        
        $str = '';
        foreach ($resultSet as $row) {
            $str .= strstr($row['ids'], ',');
        }
        
        $deleteSql = "DELETE FROM rims_inventory_detail WHERE id IN (" . ltrim($str, ',') . ")";
        
        echo $deleteSql;
    }

    protected function saveToExcel($dataProvider, $branches, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Kartu Stok Gudang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Kartu Stok Gudang');

        $worksheet->mergeCells('A1:H1');
        $worksheet->mergeCells('A2:H2');
        $worksheet->mergeCells('A3:H3');
        
        $worksheet->getStyle('A1:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $worksheet->getStyle("A1:A2")->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Kartu Stok Gudang');

        $column = 'I'; 
        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('C5', 'Name');
        $worksheet->setCellValue('D5', 'Brand');
        $worksheet->setCellValue('E5', 'Sub Brand');
        $worksheet->setCellValue('F5', 'Sub Brand Series');
        $worksheet->setCellValue('G5', 'Category');
        $worksheet->setCellValue('H5', 'Unit');
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$column}5", CHtml::value($branch, 'code'));
            $column++;
        }
        $worksheet->setCellValue("{$column}5", 'Total');

        $worksheet->getStyle("A5:{$column}5")->getFont()->setBold(true);
        $worksheet->getStyle("A5:{$column}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:{$column}5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $inventoryTotalQuantities = $header->getInventoryTotalQuantitiesByPeriodic($endDate);
            $totalStock = 0;

            $column = 'I'; 
            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'id')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'manufacturer_code')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'name')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'brand.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'subBrand.name')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'subBrandSeries.name')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'masterSubCategoryCode')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'unit.name')));
            foreach ($branches as $branch) {
                $stockValue = 0;
                foreach ($inventoryTotalQuantities as $i => $inventoryTotalQuantity) {
                    if ($inventoryTotalQuantity['branch_id'] == $branch->id) {
                        $stockValue = CHtml::value($inventoryTotalQuantities[$i], 'total_stock');
                    }
                }
                $worksheet->setCellValue("{$column}{$counter}", CHtml::encode($stockValue));
                $totalStock += $stockValue;
                $column++;
            }
            $worksheet->setCellValue("{$column}{$counter}", CHtml::encode($totalStock));

            $counter++;

        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Kartu Stok Gudang.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
