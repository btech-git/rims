<?php

class AdjustmentController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('stockAdjustmentCreate')) || !(Yii::app()->user->checkAccess('stockAdjustmentEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $adjustment = $this->instantiate(null);
        $adjustment->header->user_id = Yii::app()->user->id;
        $adjustment->header->status = 'Draft';
        $adjustment->header->date_posting = date('Y-m-d');
        $adjustment->header->created_datetime = date('Y-m-d H:i:s');
        $adjustment->header->branch_id = $adjustment->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $adjustment->header->branch_id;

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($adjustment);
            $adjustment->header->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($adjustment->header->date_posting)), Yii::app()->dateFormatter->format('yyyy', strtotime($adjustment->header->date_posting)), $adjustment->header->branch_id);

            if ($adjustment->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $adjustment->header->id));
        }

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        $this->render('create', array(
            'adjustment' => $adjustment,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
        ));
    }

    public function actionView($id) {
        $listApproval = StockAdjustmentApproval::model()->findAllByAttributes(array('stock_adjustment_header_id' => $id));
        $product = new Product('search');
        $warehouse = Warehouse::model()->findAll();


        $this->render('view', array(
            'model' => $this->loadModel($id),
            'product' => $product,
            'warehouse' => $warehouse,
            'listApproval' => $listApproval,
        ));
    }

    public function actionAdmin() {
        $model = new StockAdjustmentHeader('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StockAdjustmentHeader']))
            $model->attributes = $_GET['StockAdjustmentHeader'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAjaxHtmlAddProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $adjustment = $this->instantiate($id);
            $this->loadState($adjustment);

            if (isset($_POST['ProductId']))
                $adjustment->addDetail($_POST['ProductId'], $_POST['StockAdjustmentHeader']['branch_id']);

            $this->renderPartial('_detail', array(
                'adjustment' => $adjustment,
            ));
        }
    }

    public function actionAjaxHtmlRemoveProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $adjustment = $this->instantiate($id);
            $this->loadState($adjustment);

            $adjustment->removeProductAt($index);

            $this->renderPartial('_detail', array(
                'adjustment' => $adjustment,
            ));
        }
    }

    public function actionAjaxHtmlUpdateAllProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $adjustment = $this->instantiate($id);
            $this->loadState($adjustment);

            $adjustment->updateProducts();

            $this->renderPartial('_detail', array(
                'adjustment' => $adjustment,
            ));
        }
    }

    public function actionAjaxJsonDifference($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $adjustment = $this->instantiate($id);
            $this->loadState($adjustment);

            $quantityDifference = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $adjustment->details[$index]->getQuantityDifference($_POST['StockAdjustmentHeader']['warehouse_id'])));

            echo CJSON::encode(array(
                'quantityDifference' => $quantityDifference,
            ));
        }
    }

    public function actionAjaxHtmlUpdateWarehouseSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $adjustment = $this->instantiate(null);
            $branchId = isset($_GET['StockAdjustmentHeader']['branch_id']) ? $_GET['StockAdjustmentHeader']['branch_id'] : 0;

            $this->renderPartial('_warehouseSelect', array(
                'adjustment' => $adjustment,
                'branchId' => $branchId,
            ));
        }
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

    public function instantiate($id) {
        if (empty($id))
            $adjustment = new Adjustment(new StockAdjustmentHeader(), array());
        else {
            $adjustmentHeader = $this->loadModel($id);
            $adjustment = new Adjustment($adjustmentHeader, $adjustmentHeader->stockAdjustmentDetails);
        }

        return $adjustment;
    }

    public function loadModel($id) {
        $model = StockAdjustmentHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function loadState(&$adjustment) {
        if (isset($_POST['StockAdjustmentHeader']))
            $adjustment->header->attributes = $_POST['StockAdjustmentHeader'];

        if (isset($_POST['StockAdjustmentDetail'])) {
            foreach ($_POST['StockAdjustmentDetail'] as $item) {
                $detail = new StockAdjustmentDetail();
                $detail->attributes = $item;
                $adjustment->details[] = $detail;
            }
            if (count($_POST['StockAdjustmentDetail']) < count($adjustment->details))
                array_splice($adjustment->details, $i + 1);
        } else
            $adjustment->details = array();
    }

}
