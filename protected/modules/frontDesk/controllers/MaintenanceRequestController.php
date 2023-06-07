<?php

class MaintenanceRequestController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('maintenanceRequestCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'delete' ||
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('maintenanceRequestEdit')))
                $this->redirect(array('/site/login'));
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('maintenanceRequestApproval')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('maintenanceRequestCreate')) || !(Yii::app()->user->checkAccess('maintenanceRequestEdit')) || !(Yii::app()->user->checkAccess('maintenanceRequestApproval')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $maintenanceRequest = $this->instantiate(null);
        $maintenanceRequest->header->user_id = Yii::app()->user->id;
        $maintenanceRequest->header->transaction_date = date('Y-m-d');
        $maintenanceRequest->header->transaction_time = date('H:i:s');
        $maintenanceRequest->header->created_datetime = date('Y-m-d H:i:s');
        $maintenanceRequest->header->status = 'PENDING';
        $maintenanceRequest->header->branch_id = Users::model()->findByPk(Yii::app()->user->id)->branch_id;

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($maintenanceRequest);
            $maintenanceRequest->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($maintenanceRequest->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($maintenanceRequest->header->transaction_date)), $maintenanceRequest->header->branch_id);

            if ($maintenanceRequest->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $maintenanceRequest->header->id));
            }
        }

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        $this->render('create', array(
            'maintenanceRequest' => $maintenanceRequest,
        ));
    }

    public function actionUpdate($id) {
        $maintenanceRequest = $this->instantiate($id);
        $maintenanceRequest->header->setCodeNumberByRevision('transaction_number');

        $details = array();
        foreach ($maintenanceRequest->details as $detail) {
            $details[] = $detail;
        }
        $maintenanceRequest->details = $details;

        if (isset($_POST['Submit'])) {
            $this->loadState($maintenanceRequest);

            if ($maintenanceRequest->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $maintenanceRequest->header->id));
        }

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        $this->render('update', array(
            'maintenanceRequest' => $maintenanceRequest,
        ));
    }

    public function actionView($id) {
        $maintenanceRequest = $this->loadModel($id);
        $maintenanceRequestDetails = MaintenanceRequestDetail::model()->findAllByAttributes(array('maintenance_request_header_id' => $id));

        $this->render('view', array(
            'maintenanceRequest' => $maintenanceRequest,
            'maintenanceRequestDetails' => $maintenanceRequestDetails,
        ));
    }

    public function actionAdmin() {
        $model = new MaintenanceRequestHeader('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['MaintenanceRequestHeader'])) {
            $model->attributes = $_GET['MaintenanceRequestHeader'];
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
        $maintenanceRequest = $this->loadModel($headerId);
        $historis = MaintenanceRequestApproval::model()->findAllByAttributes(array('maintenance_request_header_id' => $headerId));
        $model = new MaintenanceRequestApproval;
        $model->date = date('Y-m-d');
        $model->time = date('H:i:s');

        if (isset($_POST['MaintenanceRequestApproval'])) {
            $model->attributes = $_POST['MaintenanceRequestApproval'];
            
            if ($model->save()) {
                $maintenanceRequest->header->status = $model->approval_type;
                $maintenanceRequest->header->update(array('status'));
                
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'maintenanceRequest' => $maintenanceRequest,
            'historis' => $historis,
        ));
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $maintenanceRequest = $this->instantiate($id);
            $this->loadState($maintenanceRequest);

            $maintenanceRequest->addDetail();

            $this->renderPartial('_detail', array(
                'maintenanceRequest' => $maintenanceRequest,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $maintenanceRequest = $this->instantiate($id);
            $this->loadState($maintenanceRequest);

            $maintenanceRequest->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'maintenanceRequest' => $maintenanceRequest,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $maintenanceRequest = new MaintenanceRequest(new MaintenanceRequestHeader(), array());
        } else {
            $maintenanceRequestHeader = $this->loadModel($id);
            $maintenanceRequest = new MaintenanceRequest($maintenanceRequestHeader, $maintenanceRequestHeader->maintenanceRequestDetails);
        }

        return $maintenanceRequest;
    }

    public function loadModel($id) {
        $model = MaintenanceRequestHeader::model()->findByPk($id);
        
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    
        return $model;
    }

    public function loadState($maintenanceRequest) {
        if (isset($_POST['MaintenanceRequestHeader'])) {
            $maintenanceRequest->header->attributes = $_POST['MaintenanceRequestHeader'];
        }
        
        if (isset($_POST['MaintenanceRequestDetail'])) {
            foreach ($_POST['MaintenanceRequestDetail'] as $i => $item) {
                if (isset($maintenanceRequest->details[$i])) {
                    $maintenanceRequest->details[$i]->attributes = $item;
                } else {
                    $detail = new MaintenanceRequestDetail();
                    $detail->attributes = $item;
                    $maintenanceRequest->details[] = $detail;
                }
            }
            
            if (count($_POST['MaintenanceRequestDetail']) < count($maintenanceRequest->details)) {
                array_splice($maintenanceRequest->details, $i + 1);
            }
        } else {
            $maintenanceRequest->details = array();
        }
    }
}