<?php

class SentRequestController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'view'
                || $filterChain->action->id === 'create'
                || $filterChain->action->id === 'update'
                || $filterChain->action->id === 'admin'
                || $filterChain->action->id === 'memo') {
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
        $sentRequest = $this->instantiate(null);
        $sentRequest->header->requester_id = 1; //Yii::app()->user->id;
        $sentRequest->header->requester_branch_id = 1;
        $sentRequest->header->status_document = 'Draft';
        $sentRequest->header->total_quantity =  0;
        $sentRequest->header->total_price = 0;
        $sentRequest->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($sentRequest->header->sent_request_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($sentRequest->header->sent_request_date)), $sentRequest->header->requester_branch_id);

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();

        if (isset($_POST['Submit'])) {
            $this->loadState($sentRequest);
            $sentRequest->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($sentRequest->header->sent_request_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($sentRequest->header->sent_request_date)), $sentRequest->header->requester_branch_id);
            
            if ($sentRequest->save(Yii::app()->db)) 
                $this->redirect(array('view', 'id' => $sentRequest->header->id));
        }

        if (isset($_POST['Cancel'])) 
            $this->redirect(array('admin'));

        $this->render('create', array(
            'sentRequest' => $sentRequest,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
        ));
    }

    public function actionUpdate($id) {
        $sentRequest = $this->instantiate($id);
        $sentRequest->header->setCodeNumberByRevision('sent_request_no');

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();

        $details = array();
        foreach ($sentRequest->details as $detail) {
            $details[] = $detail;
        }
        $sentRequest->details = $details;

        if (isset($_POST['Submit'])) {
            $this->loadState($sentRequest);

            if ($sentRequest->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $sentRequest->header->id));
        }

        if (isset($_POST['Cancel'])) 
            $this->redirect(array('admin'));

        $this->render('update', array(
            'sentRequest' => $sentRequest,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
        ));
    }

    public function actionView($id) {
        $sentRequest = $this->loadModel($id);
        $sentDetails = TransactionSentRequestDetail::model()->findAllByAttributes(array('sent_request_id' => $id));

        $this->render('view', array(
            'sentRequest' => $sentRequest,
            'sentDetails' => $sentDetails,
        ));
    }


    public function actionUpdateApproval($headerId)
    {
        $sentRequest = TransactionSentRequest::model()->findByPk($headerId);
        $historis = TransactionSentRequestApproval::model()->findAllByAttributes(array('sent_request_id' => $headerId));
        $model = new TransactionSentRequestApproval;
        if (isset($_POST['TransactionSentRequestApproval'])) {
            $model->attributes = $_POST['TransactionSentRequestApproval'];
            if ($model->save()) {
                $sentRequest->status_document = $model->approval_type;
                if ($model->approval_type == 'Approved') {
                    $sentRequest->approved_by = $model->supervisor_id;
                }
                $sentRequest->save(false);
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'sentRequest' => $sentRequest,
            'historis' => $historis,
        ));
    }

    public function actionAdmin() {
        $model = new TransactionSentRequest('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionSentRequest'])) {
            $model->attributes = $_GET['TransactionSentRequest'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->instantiate($id);

            if ($model->header->purchaseReturnHeaders != NULL || $model->header->receiveHeaders != NULL) {
                Yii::app()->user->setFlash('message', 'Cannot DELETE this transaction');
            } else {
                foreach ($model->details as $detail) 
                    $detail->delete();
                
                $model->header->delete();
            }
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $sentRequest = $this->instantiate($id);
            $this->loadState($sentRequest);

            $unitPrice = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($sentRequest->details[$index], 'unit_price')));
            $total = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($sentRequest->details[$index], 'total')));
            $totalQuantity = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $sentRequest->totalQuantity));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $sentRequest->getGrandTotal()));

            echo CJSON::encode(array(
                'unitPrice' => $unitPrice,
                'total' => $total,
                'totalQuantity' => $totalQuantity,
                'grandTotal' => $grandTotal,
            ));
        }
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $sentRequest = $this->instantiate($id);
            $this->loadState($sentRequest);

            if (isset($_POST['ProductId']))
                $sentRequest->addDetail($_POST['ProductId']);

            $this->renderPartial('_detail', array(
                'sentRequest' => $sentRequest,
            ));
        }
    }

    public function actionAjaxHtmlRemoveProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $sentRequest = $this->instantiate($id);
            $this->loadState($sentRequest);

            $sentRequest->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'sentRequest' => $sentRequest,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $sentRequest = new SentRequest(new TransactionSentRequest(), array());
        else {
            $sentRequestHeader = $this->loadModel($id);
            $sentRequest = new SentRequest($sentRequestHeader, $sentRequestHeader->transactionSentRequestDetails);
        }

        return $sentRequest;
    }

    public function loadModel($id) {
        $model = TransactionSentRequest::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($sentRequest) {
        if (isset($_POST['TransactionSentRequest'])) {
            $sentRequest->header->attributes = $_POST['TransactionSentRequest'];
        }
        if (isset($_POST['TransactionSentRequestDetail'])) {
            foreach ($_POST['TransactionSentRequestDetail'] as $i => $item) {
                if (isset($sentRequest->details[$i]))
                    $sentRequest->details[$i]->attributes = $item;
                else {
                    $detail = new TransactionSentRequestDetail();
                    $detail->attributes = $item;
                    $sentRequest->details[] = $detail;
                }
            }
            if (count($_POST['TransactionSentRequestDetail']) < count($sentRequest->details))
                array_splice($sentRequest->details, $i + 1);
        }
        else
            $sentRequest->details = array();
    }
}
