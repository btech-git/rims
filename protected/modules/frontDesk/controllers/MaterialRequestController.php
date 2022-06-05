<?php

class MaterialRequestController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('materialRequestCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'delete' ||
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('materialRequestEdit')))
                $this->redirect(array('/site/login'));
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('materialRequestApproval')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('materialRequestCreate')) || !(Yii::app()->user->checkAccess('materialRequestEdit')) || !(Yii::app()->user->checkAccess('materialRequestApproval')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $materialRequest = $this->instantiate(null);
        $materialRequest->header->user_id = Yii::app()->user->id;
        $materialRequest->header->transaction_date = date('Y-m-d');
        $materialRequest->header->transaction_time = date('H:i:s');
        $materialRequest->header->date_created = date('Y-m-d H:i:s');
        $materialRequest->header->status_document = 'Draft';
        $materialRequest->header->status_progress = 'NO MOVEMENT';
        $materialRequest->header->branch_id = Users::model()->findByPk(Yii::app()->user->id)->branch_id;

        $branches = Branch::model()->findAll();
        
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();
        $productDataProvider->criteria->compare('t.product_master_category_id', 7);

        $registrationTransaction = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $customerName = isset($_GET['CustomerName']) ? $_GET['CustomerName'] : '';
        $vehicleNumber = isset($_GET['VehicleNumber']) ? $_GET['VehicleNumber'] : '';

        $registrationTransactionDataProvider = $registrationTransaction->search();
        $registrationTransactionDataProvider->criteria->with = array(
            'customer',
            'vehicle',
            'branch',
        );

        if (!empty($customerName)) {
            $registrationTransactionDataProvider->criteria->addCondition('customer.name LIKE :customer_name');
            $registrationTransactionDataProvider->criteria->params[':customer_name'] = "%{$customerName}%";
        }

        if (!empty($vehicleNumber)) {
            $registrationTransactionDataProvider->criteria->addCondition("vehicle.plate_number LIKE :vehicle_number");
            $registrationTransactionDataProvider->criteria->params[':vehicle_number'] = "%{$vehicleNumber}%";
        }

        $registrationTransactionDataProvider->criteria->order = 't.transaction_date DESC';

        if (isset($_POST['Submit'])) {
            $this->loadState($materialRequest);
            $materialRequest->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($materialRequest->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($materialRequest->header->transaction_date)), $materialRequest->header->branch_id);

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
            'branches' => $branches,
            'registrationTransaction' => $registrationTransaction,
            'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
            'customerName' => $customerName,
            'vehicleNumber' => $vehicleNumber,
        ));
    }

    public function actionUpdate($id) {
        $materialRequest = $this->instantiate($id);
        $registrationTransaction = RegistrationTransaction::model()->findByPk($materialRequest->header->registration_transaction_id);

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();

        $branches = Branch::model()->findAll();
        
        $details = array();
        foreach ($materialRequest->details as $detail) {
            $details[] = $detail;
        }
        $materialRequest->details = $details;

        if (isset($_POST['Submit'])) {
            $this->loadState($materialRequest);
            $materialRequest->header->setCodeNumberByRevision('transaction_number');

            if ($materialRequest->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $materialRequest->header->id));
        }

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        $this->render('update', array(
            'materialRequest' => $materialRequest,
            'registrationTransaction' => $registrationTransaction,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'branches' => $branches,
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

    public function actionUpdateApproval($headerId) {
        $materialRequest = $this->instantiate($headerId);
        $historis = MaterialRequestApproval::model()->findAllByAttributes(array('material_request_header_id' => $headerId));
        $model = new MaterialRequestApproval;
        $model->date = date('Y-m-d');
        $model->time = date('H:i:s');

        if (isset($_POST['MaterialRequestApproval'])) {
            $model->attributes = $_POST['MaterialRequestApproval'];
            
            if ($model->save()) {
                $materialRequest->header->status_document = $model->approval_type;
                $materialRequest->header->update(array('status_document'));
                
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'materialRequest' => $materialRequest,
            'historis' => $historis,
        ));
    }

    public function actionAjaxJsonWorkOrder($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransactionId = (isset($_POST['MaterialRequestHeader']['registration_transaction_id'])) ? $_POST['MaterialRequestHeader']['registration_transaction_id'] : '';
            
            $materialRequest = $this->instantiate($id);
            $this->loadState($materialRequest);

            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationTransactionId);
        
            $object = array(
                'workOrderNumber' => CHtml::value($registrationTransaction, 'work_order_number'),
                'workOrderDate' => CHtml::value($registrationTransaction, 'transaction_date'),
                'workOrderCustomer' => CHtml::value($registrationTransaction, 'customer.name'),
                'workOrderVehicle' => nl2br(CHtml::value($registrationTransaction, 'vehicle.carMakeModelSubCombination')),
                'workOrderPlate' => nl2br(CHtml::value($registrationTransaction, 'vehicle.plate_number')),
                'workOrderType' => nl2br(CHtml::value($registrationTransaction, 'repair_type')),
                
            );
            echo CJSON::encode($object);
        }
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

    public function actionAjaxHtmlAddProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $materialRequest = $this->instantiate($id);
            $this->loadState($materialRequest);

            $this->renderPartial('_detailProduct', array(
                'materialRequest' => $materialRequest,
            ));
        }
    }

    public function actionAjaxHtmlAddService($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $materialRequest = $this->instantiate($id);
            $this->loadState($materialRequest);

            $this->renderPartial('_detailService', array(
                'materialRequest' => $materialRequest,
            ));
        }
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $materialRequest = $this->instantiate($id);
            $this->loadState($materialRequest);

            $branches = Branch::model()->findAll();
        
            if (isset($_POST['ProductId'])) {
                $materialRequest->addDetail($_POST['ProductId']);
            }

            $this->renderPartial('_detail', array(
                'materialRequest' => $materialRequest,
                'branches' => $branches,
            ));
        }
    }

    public function actionAjaxHtmlRemoveProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $materialRequest = $this->instantiate($id);
            $this->loadState($materialRequest);

            $branches = Branch::model()->findAll();
            $materialRequest->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'materialRequest' => $materialRequest,
                'branches' => $branches,
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