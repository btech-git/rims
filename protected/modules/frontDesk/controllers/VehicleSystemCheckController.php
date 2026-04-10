<?php

class VehicleSystemCheckController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('vehicleSystemCheckCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'delete' ||
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('vehicleSystemCheckEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('vehicleSystemCheckApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'view'
        ) {
            if (
                !(Yii::app()->user->checkAccess('vehicleSystemCheckCreate')) || 
                !(Yii::app()->user->checkAccess('vehicleSystemCheckEdit')) || 
                !(Yii::app()->user->checkAccess('vehicleSystemCheckApproval'))
            ) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionRegistrationTransactionList() {
        $registrationTransaction = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $customerName = isset($_GET['CustomerName']) ? $_GET['CustomerName'] : '';
        $vehicleNumber = isset($_GET['VehicleNumber']) ? $_GET['VehicleNumber'] : '';

        $registrationTransactionDataProvider = $registrationTransaction->searchByVehicleSystemCheck();
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

        $this->render('registrationTransactionList', array(
            'registrationTransaction' => $registrationTransaction,
            'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
            'customerName' => $customerName,
            'vehicleNumber' => $vehicleNumber,
        ));
    }

    public function actionCreate($registrationTransactionId) {
        $vehicleSystemCheck = $this->instantiate(null);
        $vehicleSystemCheck->header->user_id_created = Yii::app()->user->id;
        $vehicleSystemCheck->header->transaction_date = date('Y-m-d');
        $vehicleSystemCheck->header->created_datetime = date('Y-m-d H:i:s');
        $vehicleSystemCheck->header->branch_id = Users::model()->findByPk(Yii::app()->user->id)->branch_id;
        $vehicleSystemCheck->header->registration_transaction_id = $registrationTransactionId;
        
        $vehicleSystemCheck->addDetailComponent();
        $vehicleSystemCheck->addDetailTire();
        
        $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationTransactionId);

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($vehicleSystemCheck);
            $vehicleSystemCheck->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($vehicleSystemCheck->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($vehicleSystemCheck->header->transaction_date)), $vehicleSystemCheck->header->branch_id);

            if ($vehicleSystemCheck->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $vehicleSystemCheck->header->id));
            }
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'vehicleSystemCheck' => $vehicleSystemCheck,
            'registrationTransaction' => $registrationTransaction,
        ));
    }

    public function actionUpdate($id) {
        $vehicleSystemCheck = $this->instantiate($id);
        $vehicleSystemCheck->header->setCodeNumberByRevision('transaction_number');

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($vehicleSystemCheck);

            if ($vehicleSystemCheck->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $vehicleSystemCheck->header->id));
            }
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'vehicleSystemCheck' => $vehicleSystemCheck,
        ));
    }

    public function actionView($id) {
        $vehicleSystemCheck = $this->loadModel($id);
        $vehicleSystemCheckTireDetails = VehicleSystemCheckTireDetail::model()->findAllByAttributes(array('vehicle_system_check_header_id' => $id));
        $vehicleSystemCheckComponentDetails = VehicleSystemCheckComponentDetail::model()->findAllByAttributes(array('vehicle_system_check_header_id' => $id));

        $this->render('view', array(
            'vehicleSystemCheck' => $vehicleSystemCheck,
            'vehicleSystemCheckDetails' => $vehicleSystemCheckTireDetails,
            'vehicleSystemCheckComponentDetails' => $vehicleSystemCheckComponentDetails,
        ));
    }

    public function actionShow($id) {
        $vehicleSystemCheck = $this->loadModel($id);
        $vehicleSystemCheckTireDetails = VehicleSystemCheckTireDetail::model()->findAllByAttributes(array('vehicle_system_check_header_id' => $id));
        $vehicleSystemCheckComponentDetails = VehicleSystemCheckComponentDetail::model()->findAllByAttributes(array('vehicle_system_check_header_id' => $id));

        $this->render('show', array(
            'vehicleSystemCheck' => $vehicleSystemCheck,
            'vehicleSystemCheckTireDetails' => $vehicleSystemCheckTireDetails,
            'vehicleSystemCheckComponentDetails' => $vehicleSystemCheckComponentDetails,
        ));
    }

    public function actionAdmin() {
        $model = new VehicleSystemCheckHeader('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['VehicleSystemCheckHeader'])) {
            $model->attributes = $_GET['VehicleSystemCheckHeader'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->instantiate($id);

            foreach ($model->detailTires as $detailTire) {
                $detailTire->delete();
            }

            foreach ($model->detailComponents as $detailComponent) {
                $detailComponent->delete();
            }

            $model->header->delete();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $vehicleSystemCheck = new VehicleSystemCheck(new VehicleSystemCheckHeader(), array(), array());
        } else {
            $vehicleSystemCheckHeader = $this->loadModel($id);
            $vehicleSystemCheck = new VehicleSystemCheck($vehicleSystemCheckHeader, $vehicleSystemCheckHeader->detailTires, $vehicleSystemCheckHeader->detailComponents);
        }

        return $vehicleSystemCheck;
    }

    public function loadModel($id) {
        $model = VehicleSystemCheckHeader::model()->findByPk($id);
        
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    
        return $model;
    }

    public function loadState($vehicleSystemCheck) {
        if (isset($_POST['VehicleSystemCheckHeader'])) {
            $vehicleSystemCheck->header->attributes = $_POST['VehicleSystemCheckHeader'];
        }
        
        if (isset($_POST['VehicleSystemCheckTireDetail'])) {
            foreach ($_POST['VehicleSystemCheckTireDetail'] as $i => $item) {
                if (isset($vehicleSystemCheck->detailTires[$i])) {
                    $vehicleSystemCheck->detailTires[$i]->attributes = $item;
                } else {
                    $detail = new VehicleSystemCheckTireDetail();
                    $detail->attributes = $item;
                    $vehicleSystemCheck->detailTires[] = $detail;
                }
            }
            
//            if (count($_POST['VehicleSystemCheckTireDetail']) < count($vehicleSystemCheck->detailTires)) {
//                array_splice($vehicleSystemCheck->detailTires, $i + 1);
//            }
        } else {
            $vehicleSystemCheck->detailTires = array();
        }
        
        if (isset($_POST['VehicleSystemCheckComponentDetail'])) {
            foreach ($_POST['VehicleSystemCheckComponentDetail'] as $groupId => $groupItem) {
                foreach ($groupItem as $i => $item) {
                    if (isset($vehicleSystemCheck->detailComponents[$groupId][$i])) {
                        $vehicleSystemCheck->detailComponents[$groupId][$i]->attributes = $item;
                    } else {
                        $detail = new VehicleSystemCheckComponentDetail();
                        $detail->attributes = $item;
                        $vehicleSystemCheck->detailComponents[$groupId][] = $detail;
                    }
                }
            }
            
//            if (count($_POST['VehicleSystemCheckComponentDetail']) < count($vehicleSystemCheck->detailComponents)) {
//                array_splice($vehicleSystemCheck->detailComponents, $i + 1);
//            }
        } else {
            $vehicleSystemCheck->detailComponents = array();
        }
    }
}