<?php

class ItemRequestController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('itemRequestCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'delete' ||
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('itemRequestEdit')))
                $this->redirect(array('/site/login'));
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('itemRequestApproval')) || !(Yii::app()->user->checkAccess('itemRequestSupervisor')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('itemRequestCreate')) || !(Yii::app()->user->checkAccess('itemRequestEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $itemRequest = $this->instantiate(null);
        $itemRequest->header->user_id = Yii::app()->user->id;
        $itemRequest->header->transaction_date = date('Y-m-d');
        $itemRequest->header->transaction_time = date('H:i:s');
        $itemRequest->header->created_datetime = date('Y-m-d H:i:s');
        $itemRequest->header->status_document = 'Draft';
        $itemRequest->header->branch_id = Yii::app()->user->branch_id;

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($itemRequest);
            $itemRequest->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($itemRequest->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($itemRequest->header->transaction_date)), $itemRequest->header->branch_id);

            if ($itemRequest->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $itemRequest->header->id));
            }
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'itemRequest' => $itemRequest,
        ));
    }

    public function actionUpdate($id) {
        $itemRequest = $this->instantiate($id);
        $registrationTransaction = RegistrationTransaction::model()->findByPk($itemRequest->header->registration_transaction_id);

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();

        $branches = Branch::model()->findAll();
        
        $details = array();
        foreach ($itemRequest->details as $detail) {
            $details[] = $detail;
        }
        $itemRequest->details = $details;

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($itemRequest);
            $itemRequest->header->setCodeNumberByRevision('transaction_number');

            if ($itemRequest->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $itemRequest->header->id));
            }
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'itemRequest' => $itemRequest,
            'registrationTransaction' => $registrationTransaction,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'branches' => $branches,
        ));
    }

    public function actionView($id) {
        $itemRequest = $this->loadModel($id);

        $this->render('view', array(
            'itemRequest' => $itemRequest,
        ));
    }

    public function actionAdmin() {
        $model = new ItemRequestHeader('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['ItemRequestHeader'])) {
            $model->attributes = $_GET['ItemRequestHeader'];
        }
        
        $dataProvider = $model->search();
        if (!Yii::app()->user->checkAccess('director')) {
            $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        }
        
        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
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
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionUpdateApproval($headerId) {
        $itemRequest = $this->instantiate($headerId);
        $historis = ItemRequestApproval::model()->findAllByAttributes(array('item_request_header_id' => $headerId));
        $model = new ItemRequestApproval;
        $model->date = date('Y-m-d');
        $model->time = date('H:i:s');

        if (isset($_POST['ItemRequestApproval'])) {
            $model->attributes = $_POST['ItemRequestApproval'];
            
            if ($model->save()) {
                $itemRequest->header->status_document = $model->approval_type;
                $itemRequest->header->update(array('status_document'));
                
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'itemRequest' => $itemRequest,
            'historis' => $historis,
        ));
    }

    public function actionAjaxHtmlAddProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $itemRequest = $this->instantiate($id);
            $this->loadState($itemRequest);

            $detail = new ItemRequestDetail();
            $itemRequest->details[] = $detail;

            $this->renderPartial('_detail', array(
                'itemRequest' => $itemRequest,
            ));
        }
    }

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $itemRequest = $this->instantiate($id);
            $this->loadState($itemRequest);

            $object = array(
                'total_price' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($itemRequest->details[$index], 'totalPrice'))),
                'total_quantity' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($itemRequest, 'totalQuantity'))),
                'grand_total' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($itemRequest, 'totalPrice'))),
            );

            echo CJSON::encode($object);
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $itemRequest = new ItemRequest(new ItemRequestHeader(), array());
        } else {
            $itemRequestHeader = $this->loadModel($id);
            $itemRequest = new ItemRequest($itemRequestHeader, $itemRequestHeader->itemRequestDetails);
        }

        return $itemRequest;
    }

    public function loadModel($id) {
        $model = ItemRequestHeader::model()->findByPk($id);
        
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    
        return $model;
    }

    public function loadState($itemRequest) {
        if (isset($_POST['ItemRequestHeader'])) {
            $itemRequest->header->attributes = $_POST['ItemRequestHeader'];
        }
        if (isset($_POST['ItemRequestDetail'])) {
            foreach ($_POST['ItemRequestDetail'] as $i => $item) {
                if (isset($itemRequest->details[$i])) {
                    $itemRequest->details[$i]->attributes = $item;
                } else {
                    $detail = new ItemRequestDetail();
                    $detail->attributes = $item;
                    $itemRequest->details[] = $detail;
                }
            }
            if (count($_POST['ItemRequestDetail']) < count($itemRequest->details)) {
                array_splice($itemRequest->details, $i + 1);
            }
        } else {
            $itemRequest->details = array();
        }
    }
}