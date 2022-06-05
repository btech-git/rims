<?php

class StockAnalysisController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
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

    public function actionSummary() {
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
        $inventoryDetail = Search::bind(new InventoryDetail(), isset($_GET['InventoryDetail']) ? $_GET['InventoryDetail'] : '');

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $brandId = (isset($_GET['BrandId'])) ? $_GET['BrandId'] : '';
        $subBrandId = (isset($_GET['SubBrandId'])) ? $_GET['SubBrandId'] : '';
        $subBrandSeriesId = (isset($_GET['SubBrandSeriesId'])) ? $_GET['SubBrandSeriesId'] : '';
        $productMasterCategoryId = (isset($_GET['ProductMasterCategoryId'])) ? $_GET['ProductMasterCategoryId'] : '';
        $productSubMasterCategoryId = (isset($_GET['ProductSubMasterCategoryId'])) ? $_GET['ProductSubMasterCategoryId'] : '';
        $productSubCategoryId = (isset($_GET['ProductSubCategoryId'])) ? $_GET['ProductSubCategoryId'] : '';
        
        $this->render('summary', array(
            'inventoryDetail' => $inventoryDetail,
            'product' => $product,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'brandId' => $brandId,
            'subBrandId' => $subBrandId,
            'subBrandSeriesId' => $subBrandSeriesId,
            'productMasterCategoryId' => $productMasterCategoryId,
            'productSubMasterCategoryId' => $productSubMasterCategoryId,
            'productSubCategoryId' => $productSubCategoryId,
        ));
    }
    
    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $brandId = (isset($_GET['BrandId'])) ? $_GET['BrandId'] : '';
            $subBrandId = isset($_GET['SubBrandId']) ? $_GET['SubBrandId'] : '';

            $this->renderPartial('_productSubBrandSelect', array(
                'brandId' => $brandId,
                'subBrandId' => $subBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $subBrandId = (isset($_GET['SubBrandId'])) ? $_GET['SubBrandId'] : '';
            $subBrandSeriesId = (isset($_GET['SubBrandSeriesId'])) ? $_GET['SubBrandSeriesId'] : '';

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'subBrandId' => $subBrandId,
                'subBrandSeriesId' => $subBrandSeriesId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategoryId = (isset($_GET['ProductMasterCategoryId'])) ? $_GET['ProductMasterCategoryId'] : '';
            $productSubMasterCategoryId = (isset($_GET['ProductSubMasterCategoryId'])) ? $_GET['ProductSubMasterCategoryId'] : '';

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'productMasterCategoryId' => $productMasterCategoryId,
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategoryId = (isset($_GET['ProductSubMasterCategoryId'])) ? $_GET['ProductSubMasterCategoryId'] : '';
            $productSubCategoryId = (isset($_GET['ProductSubCategoryId'])) ? $_GET['ProductSubCategoryId'] : '';

            $this->renderPartial('_productSubCategorySelect', array(
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
                'productSubCategoryId' => $productSubCategoryId,
            ));
        }
    }

}