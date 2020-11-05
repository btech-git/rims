<?php

class MaterialRequestController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'view' || $filterChain->action->id === 'create' || $filterChain->action->id === 'update' || $filterChain->action->id === 'admin' || $filterChain->action->id === 'memo') {
            if (!(Yii::app()->user->checkAccess('purchaseCreate') || Yii::app()->user->checkAccess('purchaseEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'admin' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('deleteTransaction')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $materialRequest = $this->instantiate(null);
        $materialRequest->header->user_id = Yii::app()->user->id;
        $materialRequest->header->transaction_date = date('Y-m-d');
        $materialRequest->header->transaction_time = date('H:i:s');
        $materialRequest->header->branch_id = Users::model()->findByPk(Yii::app()->user->id)->branch_id;
        $materialRequest->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($materialRequest->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($materialRequest->header->transaction_date)), $materialRequest->header->branch_id);

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();

        if (isset($_POST['Submit'])) {
            $this->loadState($materialRequest);

            if ($materialRequest->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $materialRequest->header->id));
            }
        }

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        $this->render('create', array(
            'materialRequest' => $materialRequest,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
        ));
    }

    public function actionUpdate($id) {
        $materialRequest = $this->instantiate($id);
        $materialRequest->header->setCodeNumberByRevision('transaction_number');

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();

        $details = array();
        foreach ($materialRequest->details as $detail) {
            $details[] = $detail;
        }
        $materialRequest->details = $details;

        if (isset($_POST['Submit'])) {
            $this->loadState($materialRequest);

            if ($materialRequest->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $materialRequest->header->id));
        }

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        $this->render('update', array(
            'materialRequest' => $materialRequest,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
        ));
    }

    public function actionView($id) {
        $materialRequest = $this->loadModel($id);
        $materialRequestDetails = MaterialRequestDetail::model()->findAllByAttributes(array('material_request_header_id' => $id));

        $this->render('view', array(
            'materialRequest' => $materialRequest,
            'materialRequestDetails' => $materialRequestDetails,
        ));
    }

    public function actionAdmin() {
        $model = new MaterialRequestHeader('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['MaterialRequestHeader'])) {
            $model->attributes = $_GET['MaterialRequestHeader'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->instantiate($id);

            if ($model->header->movementOutHeaders != NULL) {
                Yii::app()->user->setFlash('message', 'Cannot DELETE this transaction');
            } else {
                foreach ($model->details as $detail) {
                    $detail->delete();
                }

                $model->header->delete();
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $materialRequest = $this->instantiate($id);
            $this->loadState($materialRequest);

            $totalQuantity = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $materialRequest->totalQuantity));

            echo CJSON::encode(array(
                'totalQuantity' => $totalQuantity,
            ));
        }
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $materialRequest = $this->instantiate($id);
            $this->loadState($materialRequest);

            if (isset($_POST['ProductId'])) {
                $materialRequest->addDetail($_POST['ProductId']);
            }

            $this->renderPartial('_detail', array(
                'materialRequest' => $materialRequest,
            ));
        }
    }

    public function actionAjaxHtmlRemoveProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $materialRequest = $this->instantiate($id);
            $this->loadState($materialRequest);

            $materialRequest->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'materialRequest' => $materialRequest,
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
            $materialRequest = new MaterialRequest(new MaterialRequestHeader(), array());
        else {
            $materialRequestHeader = $this->loadModel($id);
            $materialRequest = new MaterialRequest($materialRequestHeader, $materialRequestHeader->materialRequestDetails);
        }

        return $materialRequest;
    }

    public function loadModel($id) {
        $model = MaterialRequestHeader::model()->findByPk($id);
        
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    
        return $model;
    }

    public function loadState($materialRequest) {
        if (isset($_POST['MaterialRequestHeader'])) {
            $materialRequest->header->attributes = $_POST['MaterialRequestHeader'];
        }
        if (isset($_POST['MaterialRequestDetail'])) {
            foreach ($_POST['MaterialRequestDetail'] as $i => $item) {
                if (isset($materialRequest->details[$i]))
                    $materialRequest->details[$i]->attributes = $item;
                else {
                    $detail = new MaterialRequestDetail();
                    $detail->attributes = $item;
                    $materialRequest->details[] = $detail;
                }
            }
            if (count($_POST['MaterialRequestDetail']) < count($materialRequest->details))
                array_splice($materialRequest->details, $i + 1);
        } else
            $materialRequest->details = array();
    }
}