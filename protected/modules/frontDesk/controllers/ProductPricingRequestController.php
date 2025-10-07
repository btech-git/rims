<?php

class ProductPricingRequestController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'addInterbranch'
        ) {
            if (!(Yii::app()->user->checkAccess('productPricingRequestCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'edit' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'updateDivision'
        ) {
            if (!(Yii::app()->user->checkAccess('productPricingRequestUpdate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(Yii::app()->user->checkAccess('productPricingRequestCreate') || Yii::app()->user->checkAccess('productPricingRequestUpdate') || Yii::app()->user->checkAccess('productPricingRequestView'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionShow($id) {
        $model = $this->loadModel($id);
        
        $this->render('show', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        $productPricingRequest = $this->instantiate(null, 'create');
        $productPricingRequest->header->user_id_request = Yii::app()->user->id;
        $productPricingRequest->header->request_date = date('Y-m-d');
        $productPricingRequest->header->request_time = date('H:i:s');
        $productPricingRequest->header->branch_id_request = Yii::app()->user->branch_id;
        $productPricingRequest->header->status = 'Draft';
        $productPricingRequest->header->user_id_reply = null;
        $productPricingRequest->header->reply_date = null;
        $productPricingRequest->header->reply_time = null;
        $productPricingRequest->header->reply_note = null;
        $productPricingRequest->header->branch_id_reply = null;

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($productPricingRequest);
            $productPricingRequest->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($productPricingRequest->header->request_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($productPricingRequest->header->request_date)), $productPricingRequest->header->branch_id_request);

            if ($productPricingRequest->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $productPricingRequest->header->id));
            }
        }

        $this->render('create', array(
            'productPricingRequest' => $productPricingRequest,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $productPricingRequest = $this->instantiate($id, 'update');

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($productPricingRequest);
            
            if ($productPricingRequest->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $productPricingRequest->header->id));
            } 
        }
        $this->render('update', array(
            'productPricingRequest' => $productPricingRequest,
        ));
    }

    public function actionReply($id) {
        $productPricingRequest = $this->instantiate($id, 'update');
        $productPricingRequest->header->user_id_reply = Yii::app()->user->id;
        $productPricingRequest->header->reply_date = date('Y-m-d');
        $productPricingRequest->header->reply_time = date('H:i:s');
        $productPricingRequest->header->branch_id_reply = Yii::app()->user->branch_id;

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($productPricingRequest);
            
            if ($productPricingRequest->save(Yii::app()->db)) {
                $this->redirect(array('show', 'id' => $productPricingRequest->header->id));
            } 
        }
        $this->render('reply', array(
            'productPricingRequest' => $productPricingRequest,
        ));
    }

    public function actionUpdateReply($id) {
        $productPricingRequest = $this->instantiate($id, 'update');

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($productPricingRequest);
            
            if ($productPricingRequest->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $productPricingRequest->header->id));
            } 
        }
        $this->render('updateReply', array(
            'productPricingRequest' => $productPricingRequest,
        ));
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $productPricingRequest = $this->instantiate($id, 'create');
            $this->loadState($productPricingRequest);

            $productPricingRequest->addDetail();

            $this->renderPartial('_detail', array(
                'productPricingRequest' => $productPricingRequest,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $productPricingRequest = $this->instantiate($id, 'create');
            $this->loadState($productPricingRequest);

            $productPricingRequest->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'productPricingRequest' => $productPricingRequest,
            ));
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ProductPricingRequestHeader('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['ProductPricingRequestHeader'])) {
            $model->attributes = $_GET['ProductPricingRequestHeader'];
        }
        
        $dataProvider = $model->searchRequest();

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdminPending() {
        $model = new ProductPricingRequestHeader('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['ProductPricingRequestHeader'])) {
            $model->attributes = $_GET['ProductPricingRequestHeader'];
        }
        
        $dataProviderReply = $model->searchReply();
        $dataProviderReply->criteria->addCondition('t.user_id_reply IS NULL AND t.is_inactive = 0');

        $dataProviderRequest = $model->searchRequest();
        
        $this->render('adminPending', array(
            'model' => $model,
            'dataProviderReply' => $dataProviderReply,
            'dataProviderRequest' => $dataProviderRequest,
        ));
    }

    public function actionUpdateApproval($headerId) {
        $productPricingRequest = $this->instantiate($headerId, 'Approval');
        $historis = ProductPricingRequestApproval::model()->findAllByAttributes(array('product_pricing_request_header_id' => $headerId));
        $model = new ProductPricingRequestApproval;
        $model->product_pricing_request_header_id = $headerId;
        $model->date = date('Y-m-d');
        $model->time = date('H:i:s');

        if (isset($_POST['ProductPricingRequestApproval'])) {
            $model->attributes = $_POST['ProductPricingRequestApproval'];
            
            if ($model->save()) {
                $productPricingRequest->header->status = $model->approval_type;
                $productPricingRequest->header->update(array('status'));
                
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'productPricingRequest' => $productPricingRequest,
            'historis' => $historis,
        ));
    }

    public function instantiate($id, $actionType) {
        if (empty($id)) {
            $productPricingRequest = new ProductPricingRequest($actionType, new ProductPricingRequestHeader(), array());
        } else {
            $productPricingRequestHeader = $this->loadModel($id);
            $productPricingRequest = new ProductPricingRequest($actionType, $productPricingRequestHeader, $productPricingRequestHeader->productPricingRequestDetails);
        }

        return $productPricingRequest;
    }

    public function loadModel($id) {
        $model = ProductPricingRequestHeader::model()->findByPk($id);
        
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    
        return $model;
    }

    public function loadState($productPricingRequest) {
        if (isset($_POST['ProductPricingRequestHeader'])) {
            $productPricingRequest->header->attributes = $_POST['ProductPricingRequestHeader'];
        }
        if (isset($_POST['ProductPricingRequestDetail'])) {
            foreach ($_POST['ProductPricingRequestDetail'] as $i => $item) {
                if (isset($productPricingRequest->details[$i])) {
                    $productPricingRequest->details[$i]->attributes = $item;
                } else {
                    $detail = new ProductPricingRequestDetail();
                    $detail->attributes = $item;
                    $productPricingRequest->details[] = $detail;
                }
            }
            if (count($_POST['ProductPricingRequestDetail']) < count($productPricingRequest->details)) {
                array_splice($productPricingRequest->details, $i + 1);
            }
        } else {
            $productPricingRequest->details = array();
        }
    }
}