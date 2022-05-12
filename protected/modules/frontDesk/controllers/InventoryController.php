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
            if (!(Yii::app()->user->checkAccess('inventoryHead')) || !(Yii::app()->user->checkAccess('consignmentOutEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCheck() {
        $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
        $product = Search::bind(new Product(), isset($_GET['Product']) ? $_GET['Product'] : '');
        $productDataProvider = $product->searchByStockCheck($pageNumber);
        $branches = Branch::model()->findAll();

        if (isset($_GET['Clear']))
            $product->unsetAttributes();

        $this->render('check', array(
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'branches' => $branches,
            'pageNumber' => $pageNumber,
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
}
