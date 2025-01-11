<?php

class CashTransactionController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('cashTransactionCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('cashTransactionEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('cashTransactionApproval')) || 
                !(Yii::app()->user->checkAccess('cashTransactionSupervisor'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'index' ||
            $filterChain->action->id === 'view'
        ) {
            if (
                !(Yii::app()->user->checkAccess('cashTransactionCreate')) || 
                !(Yii::app()->user->checkAccess('cashTransactionEdit'))
            ) {
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
        $cashTransaction = $this->loadModel($id);
        $details = CashTransactionDetail::model()->findAllByAttributes(array('cash_transaction_id' => $id));
        $revisionHistories = CashTransactionApproval::model()->findAllByAttributes(array('cash_transaction_id' => $id));
        $postImages = CashTransactionImages::model()->findAllByAttributes(array('cash_transaction_id' => $id, 'is_inactive' => 0));
        
        if (isset($_POST['Process'])) {
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $cashTransaction->transaction_number,
                'branch_id' => $cashTransaction->branch_id,
            ));

            foreach ($cashTransaction->cashTransactionDetails as $key => $ctDetail) {
                $jurnalUmumHeader = new JurnalUmum;
                $jurnalUmumHeader->kode_transaksi = $cashTransaction->transaction_number;
                $jurnalUmumHeader->tanggal_transaksi = $cashTransaction->transaction_date;
                $jurnalUmumHeader->coa_id = $cashTransaction->coa_id;
                $jurnalUmumHeader->total = $ctDetail->amount;
                $jurnalUmumHeader->debet_kredit = $cashTransaction->transaction_type == "In" ? 'D' : 'K';
                $jurnalUmumHeader->tanggal_posting = date('Y-m-d');
                $jurnalUmumHeader->branch_id = $cashTransaction->branch_id;
                $jurnalUmumHeader->transaction_subject = $ctDetail->notes;
                $jurnalUmumHeader->is_coa_category = 0;
                $jurnalUmumHeader->transaction_type = 'CASH'; //$cashTransaction->transaction_type == "In" ? 'CASH IN' : 'CASH OUT';
                $jurnalUmumHeader->save();

                $jurnalUmumDetail = new JurnalUmum;
                $jurnalUmumDetail->kode_transaksi = $cashTransaction->transaction_number;
                $jurnalUmumDetail->tanggal_transaksi = $cashTransaction->transaction_date;
                $jurnalUmumDetail->coa_id = $ctDetail->coa_id;
                $jurnalUmumDetail->total = $ctDetail->amount;
                $jurnalUmumDetail->debet_kredit = $cashTransaction->transaction_type == "In" ? 'K' : 'D';
                $jurnalUmumDetail->tanggal_posting = date('Y-m-d');
                $jurnalUmumDetail->branch_id = $cashTransaction->branch_id;
                $jurnalUmumDetail->transaction_subject = $ctDetail->notes;
                $jurnalUmumDetail->is_coa_category = 0;
                $jurnalUmumDetail->transaction_type = 'CASH'; //$cashTransaction->transaction_type == "In" ? 'CASH IN' : 'CASH OUT';
                $jurnalUmumDetail->save(false);
            }
        }
        
        $this->render('view', array(
            'model' => $cashTransaction,
            'details' => $details,
            'postImages' => $postImages,
            'revisionHistories' => $revisionHistories,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //$model=new CashTransaction;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $cashTransaction = $this->instantiate(null, 'create');
        
        $cashTransaction->header->branch_id = Yii::app()->user->branch_id;
        $cashTransaction->header->payment_type_id = 1;
        $cashTransaction->header->transaction_date = date('Y-m-d');
        $cashTransaction->header->transaction_time = date('H:i:s');
        $cashTransaction->header->created_datetime = date('Y-m-d H:i:s');
        $this->performAjaxValidation($cashTransaction->header);

        $coaKas = new Coa('search');
        $coaKas->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Coa'])) {
            $coaKas->attributes = $_GET['Coa'];
        }
        
        $coaKasCriteria = new CDbCriteria;
        $coaKasCriteria->addCondition("SUBSTRING(code, -3 , 3) <> 000 AND t.coa_sub_category_id IN (1, 2, 3, 72) AND t.status = 'Approved'");
        $coaKasCriteria->compare('code', $coaKas->code . '%', true, 'AND', false);
        $coaKasCriteria->compare('name', $coaKas->name, true);
        $coaKasCriteria->compare('normal_balance', $coaKas->normal_balance, true);
        $coaKasCriteria->compare('t.is_approved', 1);
        $coaKasDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaKasCriteria,
        ));

        $coaDetail = new Coa('search');
        $coaDetail->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Coa']))
            $coaDetail->attributes = $_GET['Coa'];
        
        $coaDetailCriteria = new CDbCriteria;
        $coaDetailCriteria->addCondition("SUBSTRING(t.code, -3 , 3) <> 000 AND t.coa_sub_category_id NOT IN (1, 2, 3) AND t.status = 'Approved'");
        $coaDetailCriteria->compare('t.code', $coaDetail->code . '%', true, 'AND', false);
        $coaDetailCriteria->compare('t.name', $coaDetail->name, true);
        $coaDetailCriteria->compare('t.coa_category_id', $coaDetail->coa_category_id);
        $coaDetailCriteria->compare('t.coa_sub_category_id', $coaDetail->coa_sub_category_id);
        $coaDetailCriteria->compare('t.is_approved', 1);
        $coaDetailCriteria->compare('normal_balance', $coaDetail->normal_balance, true);
        $coaDetailCriteria->order = 'code ASC';
        $coaDetailDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaDetailCriteria,
        ));
        
        $images = $cashTransaction->header->images = CUploadedFile::getInstances($cashTransaction->header, 'images');

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['CashTransaction']) && IdempotentManager::check()) {
            
            $this->loadState($cashTransaction);
            $cashTransaction->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($cashTransaction->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($cashTransaction->header->transaction_date)), $cashTransaction->header->branch_id);
            
            if ($cashTransaction->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $cashTransaction->header->id));
            }
        }

        $this->render('create', array(
            'cashTransaction' => $cashTransaction,
            'coaKas' => $coaKas,
            'coaKasDataProvider' => $coaKasDataProvider,
            'coaDetail' => $coaDetail,
            'coaDetailDataProvider' => $coaDetailDataProvider,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        
        $cashTransaction = $this->instantiate($id, 'update');
        $cashTransaction->header->updated_datetime = date('Y-m-d H:i:s');
        $cashTransaction->header->user_id_updated = Yii::app()->user->id;
        
        $this->performAjaxValidation($cashTransaction->header);

        $coaKas = new Coa('search');
        $coaKas->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa'])) {
            $coaKas->attributes = $_GET['Coa'];
        }
        
        $coaKasCriteria = new CDbCriteria;
        $coaKasCriteria->addCondition("SUBSTRING(code, -3 , 3) <> 000 AND t.coa_sub_category_id IN (1, 2, 3, 72) AND t.status = 'Approved'");
        $coaKasCriteria->compare('code', $coaKas->code . '%', true, 'AND', false);
        $coaKasCriteria->compare('name', $coaKas->name, true);
        $coaKasCriteria->compare('normal_balance', $coaKas->normal_balance, true);
        $coaKasDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaKasCriteria,
        ));

        $coaDetail = new Coa('search');
        $coaDetail->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa'])) {
            $coaDetail->attributes = $_GET['Coa'];
        }
        
        $coaDetailCriteria = new CDbCriteria;
        $coaDetailCriteria->addCondition("SUBSTRING(t.code, -3 , 3) <> 000 AND t.coa_sub_category_id NOT IN (1, 2, 3, 72) AND t.status = 'Approved'");
        $coaDetailCriteria->compare('code', $coaDetail->code . '%', true, 'AND', false);
        $coaDetailCriteria->compare('name', $coaDetail->name, true);
        $coaDetailCriteria->compare('t.coa_category_id', $coaDetail->coa_category_id);
        $coaDetailCriteria->compare('t.coa_sub_category_id', $coaDetail->coa_sub_category_id);
        $coaDetailCriteria->compare('normal_balance', $coaDetail->normal_balance, true);
        $coaDetailCriteria->order = 'code ASC';
        $coaDetailDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaDetailCriteria,
        ));
        
        $cashTransaction->header->images = CUploadedFile::getInstances($cashTransaction->header, 'images');
        $postImages = CashTransactionImages::model()->findAllByAttributes(array('cash_transaction_id' => $cashTransaction->header->id, 'is_inactive' => 0));
        $countPostImage = count($postImages);
        $maxImage = 10;
        $allowedImages = $maxImage - $countPostImage;

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['CashTransaction']) && IdempotentManager::check()) {
            $this->loadState($cashTransaction);
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $cashTransaction->header->transaction_number,
            ));
            $cashTransaction->header->setCodeNumberByRevision('transaction_number');

            if ($cashTransaction->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $cashTransaction->header->id));
            }
        }

        $this->render('update', array(
            'cashTransaction' => $cashTransaction,
            'coaKas' => $coaKas,
            'coaKasDataProvider' => $coaKasDataProvider,
            'coaDetail' => $coaDetail,
            'coaDetailDataProvider' => $coaDetailDataProvider,
            'postImages' => $postImages,
            'allowedImages' => $allowedImages,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('CashTransaction');
        
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CashTransaction('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['CashTransaction']))
            $model->attributes = $_GET['CashTransaction'];
        
        $user = Users::model()->findByPk(Yii::app()->user->getId());
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        
        $cashInTransactionDataProvider = $model->search();
        $cashInTransactionDataProvider->criteria->addCondition('t.transaction_type = "In"');
        $cashInTransactionDataProvider->criteria->addBetweenCondition('t.transaction_date', $startDate, $endDate);

        $cashOutTransactionDataProvider = $model->search();
        $cashOutTransactionDataProvider->criteria->addCondition('t.transaction_type = "Out"');
        $cashOutTransactionDataProvider->criteria->addBetweenCondition('t.transaction_date', $startDate, $endDate);
        
        if (!Yii::app()->user->checkAccess('director')) {
            $cashInTransactionDataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $cashInTransactionDataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
            $cashOutTransactionDataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $cashOutTransactionDataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        }
        
        $this->render('admin', array(
            'model' => $model,
            'user' => $user,
            'cashInTransactionDataProvider' => $cashInTransactionDataProvider,
            'cashOutTransactionDataProvider' => $cashOutTransactionDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }

    public function actionCancel($id) {
        $model = $this->loadModel($id);
        $model->status = 'CANCELLED!!!';
        $model->debit_amount = 0; 
        $model->credit_amount = 0;
        $model->payment_type_id = null;
        $model->note = '';
        $model->cancelled_datetime = date('Y-m-d H:i:s');
        $model->user_id_cancelled = Yii::app()->user->id;
        $model->update(array('status', 'debit_amount', 'credit_amount', 'payment_type_id', 'note', 'cancelled_datetime', 'user_id_cancelled'));

        $this->saveTransactionLog('cancel', $model);

        JurnalUmum::model()->deleteAllByAttributes(array(
            'kode_transaksi' => $model->transaction_number,
        ));

        $this->redirect(array('admin'));
    }

    public function actionAjaxHtmlUpdateSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $categoryId = isset($_GET['Coa']['coa_category_id']) ? $_GET['Coa']['coa_category_id'] : 0;

            $this->renderPartial('_subCategorySelect', array(
                'categoryId' => $categoryId,
            ), false, true);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CashTransaction the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = CashTransaction::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CashTransaction $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cash-transaction-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxCoa($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $coa = Coa::model()->findByPk($id);

            $object = array(
                'id' => $coa->id,
                'code' => $coa->code,
                'name' => $coa->name,
                'opening_balance' => !empty($coa->opening_balance) ? $coa->opening_balance : 0,
                'debit' => !empty($coa->debit) ? $coa->debit : 0,
                'credit' => !empty($coa->credit) ? $coa->credit : 0,
            );

            echo CJSON::encode($object);
        }
    }

    public function instantiate($id, $actionType) {
        
        if (empty($id)) {
            $cashTransaction = new Cashs($actionType, new CashTransaction(), array());
        } else {
            $cashTransactionModel = $this->loadModel($id);
            $cashTransaction = new Cashs($actionType, $cashTransactionModel, $cashTransactionModel->cashTransactionDetails);
        }
        
        return $cashTransaction;
    }

    public function loadState($cashTransaction) {
        if (isset($_POST['CashTransaction'])) {
            $cashTransaction->header->attributes = $_POST['CashTransaction'];
        }

        if (isset($_POST['CashTransactionDetail'])) {
            foreach ($_POST['CashTransactionDetail'] as $i => $item) {
                if (isset($cashTransaction->details[$i])) {
                    $cashTransaction->details[$i]->attributes = $item;
                } else {
                    $detail = new CashTransactionDetail();
                    $detail->attributes = $item;
                    $cashTransaction->details[] = $detail;
                }
            }
            if (count($_POST['CashTransactionDetail']) < count($cashTransaction->details))
                array_splice($cashTransaction->details, $i + 1);
        } else {
            $cashTransaction->details = array();
        }
    }

    //Add Detail
    public function actionAjaxHtmlAddDetail($id, $coaId) {
        if (Yii::app()->request->isAjaxRequest) {
            $cashTransaction = $this->instantiate($id, '');
            $this->loadState($cashTransaction);

            $cashTransaction->addDetail($coaId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            
            $this->renderPartial('_detail', array(
                'cashTransaction' => $cashTransaction
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $cashTransaction = $this->instantiate($id, '');
            $this->loadState($cashTransaction);

            $cashTransaction->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            
            $this->renderPartial(
                '_detail', array('cashTransaction' => $cashTransaction
            ), false, true);
        }
    }

    public function actionDeleteImage($id) {
        $model = CashTransactionImages::model()->findByPk($id);
        $model->scenario = 'delete';

        $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/cashTransaction/' . $model->cash_transaction_id . '/' . $model->filename;
        $dir_thumb = dirname(Yii::app()->request->scriptFile) . '/images/uploads/cashTransaction/' . $model->cash_transaction_id . '/' . $model->thumbname;
        $dir_square = dirname(Yii::app()->request->scriptFile) . '/images/uploads/cashTransaction/' . $model->cash_transaction_id . '/' . $model->squarename;

        if (file_exists($dir)) {
            unlink($dir);
        }
        
        if (file_exists($dir_thumb)) {
            unlink($dir_thumb);
        }
        
        if (file_exists($dir_square)) {
            unlink($dir_square);
        }

        $model->is_inactive = 1;
        $model->update(array('is_inactive'));

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionAjaxJsonTotal($id, $index, $type) {
        if (Yii::app()->request->isAjaxRequest) {
            $cashTransaction = $this->instantiate($id, '');
            $this->loadState($cashTransaction);
            
            $amountCredit = 0.00;
            $amountDebit = 0.00;
            $totalCredit = 0.00;
            $totalDebit = 0.00;
            $totalCreditFormatted = 0.00;
            $totalDebitFormatted = 0.00;
            $totalDetail = $cashTransaction->totalDetails;

            if ($type == "In") {
                $amountCredit = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $cashTransaction->details[$index]->amount));
                $totalCreditFormatted = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalDetail));
                $totalCredit = $totalDetail;
            } else {
                $amountDebit = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $cashTransaction->details[$index]->amount));
                $totalDebitFormatted = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalDetail));
                $totalDebit = $totalDetail;
            }
            
            $object = array(
                'amountCredit' => $amountCredit,
                'amountDebit' => $amountDebit,
                'totalCredit' => $totalCredit,
                'totalDebit' => $totalDebit,
                'totalDebitFormatted' => $totalDebitFormatted,
                'totalCreditFormatted' => $totalCreditFormatted,
            );
            
            echo CJSON::encode($object);
        }
    }

    public function actionUpdateApproval($headerId) {
        $cashTransaction = CashTransaction::model()->findByPK($headerId);
        $historis = CashTransactionApproval::model()->findAllByAttributes(array('cash_transaction_id' => $headerId));
        $model = new CashTransactionApproval;
        $model->date = date('Y-m-d H:i:s');
        
        JurnalUmum::model()->deleteAllByAttributes(array(
            'kode_transaksi' => $cashTransaction->transaction_number,
            'branch_id' => $cashTransaction->branch_id,
        ));

        if (isset($_POST['CashTransactionApproval'])) {
            $model->attributes = $_POST['CashTransactionApproval'];
            if ($model->save()) {
                $cashTransaction->status = $model->approval_type;
                $cashTransaction->save(false);
                
                if ($cashTransaction->status === 'Approved') {
                    foreach ($cashTransaction->cashTransactionDetails as $key => $ctDetail) {
                        $jurnalUmumHeader = new JurnalUmum;
                        $jurnalUmumHeader->kode_transaksi = $cashTransaction->transaction_number;
                        $jurnalUmumHeader->tanggal_transaksi = $cashTransaction->transaction_date;
                        $jurnalUmumHeader->coa_id = $cashTransaction->coa_id;
                        $jurnalUmumHeader->total = $ctDetail->amount;
                        $jurnalUmumHeader->debet_kredit = $cashTransaction->transaction_type == "In" ? 'D' : 'K';
                        $jurnalUmumHeader->tanggal_posting = date('Y-m-d');
                        $jurnalUmumHeader->branch_id = $cashTransaction->branch_id;
                        $jurnalUmumHeader->transaction_subject = $ctDetail->notes;
                        $jurnalUmumHeader->is_coa_category = 0;
                        $jurnalUmumHeader->transaction_type = 'CASH'; //$cashTransaction->transaction_type == "In" ? 'CASH IN' : 'CASH OUT';
                        $jurnalUmumHeader->save();

                        $jurnalUmumDetail = new JurnalUmum;
                        $jurnalUmumDetail->kode_transaksi = $cashTransaction->transaction_number;
                        $jurnalUmumDetail->tanggal_transaksi = $cashTransaction->transaction_date;
                        $jurnalUmumDetail->coa_id = $ctDetail->coa_id;
                        $jurnalUmumDetail->total = $ctDetail->amount;
                        $jurnalUmumDetail->debet_kredit = $cashTransaction->transaction_type == "In" ? 'K' : 'D';
                        $jurnalUmumDetail->tanggal_posting = date('Y-m-d');
                        $jurnalUmumDetail->branch_id = $cashTransaction->branch_id;
                        $jurnalUmumDetail->transaction_subject = $ctDetail->notes;
                        $jurnalUmumDetail->is_coa_category = 0;
                        $jurnalUmumDetail->transaction_type = 'CASH'; //$cashTransaction->transaction_type == "In" ? 'CASH IN' : 'CASH OUT';
                        $jurnalUmumDetail->save();
                    }
                }
                
                $this->saveTransactionLog('approval', $cashTransaction);
        
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'cashTransaction' => $cashTransaction,
            'historis' => $historis,
        ));
    }

    public function saveTransactionLog($actionType, $cashTransaction) {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $cashTransaction->transaction_number;
        $transactionLog->transaction_date = $cashTransaction->transaction_date;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $cashTransaction->tableName();
        $transactionLog->table_id = $cashTransaction->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        $transactionLog->action_type = $actionType;
        
        $newData = $cashTransaction->attributes;
        
        if ($actionType === 'approval') {
            $newData['cashTransactionApprovals'] = array();
            foreach($cashTransaction->cashTransactionApprovals as $detail) {
                $newData['cashTransactionApprovals'][] = $detail->attributes;
            }
        } else {
            $newData['cashTransactionDetails'] = array();
            foreach($cashTransaction->cashTransactionDetails as $detail) {
                $newData['cashTransactionDetails'][] = $detail->attributes;
            }
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }

    public function actionAjaxGetCount($coaId, $amount, $type) {
        if (Yii::app()->request->isAjaxRequest) {
            $coa = Coa::model()->findByPk($coaId);
            
            if ($type == "In") {
                $total = $coa->credit + $amount;
            } else {
                $total = $coa->debit + $amount;
            }
            
            $object = array('total' => $total);
            echo CJSON::encode($object);
        }
    }
}