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
            'access',
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
            if (!(Yii::app()->user->checkAccess('cashTransactionApproval'))) {
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
                !(Yii::app()->user->checkAccess('cashTransactionEdit')) || 
                !(Yii::app()->user->checkAccess('cashTransactionApproval'))
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
        $details = CashTransactionDetail::model()->findAllByAttributes(array('cash_transaction_id' => $id));
        $revisionHistories = CashTransactionApproval::model()->findAllByAttributes(array('cash_transaction_id' => $id));
        $postImages = CashTransactionImages::model()->findAllByAttributes(array('cash_transaction_id' => $id, 'is_inactive' => 0));
        $this->render('view', array(
            'model' => $this->loadModel($id),
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
        $cashTransaction = $this->instantiate(null);
        
        $cashTransaction->header->branch_id = $cashTransaction->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $cashTransaction->header->branch_id;
        $cashTransaction->header->payment_type_id = 1;
        $cashTransaction->header->transaction_time = date('H:i:s');
        $this->performAjaxValidation($cashTransaction->header);

        $coaKas = new Coa('search');
        $coaKas->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Coa']))
            $coaKas->attributes = $_GET['Coa'];
        
        $coaKasCriteria = new CDbCriteria;
        $coaKasCriteria->addCondition("SUBSTRING(code, -3 , 3) <> 000 AND coa_sub_category_id BETWEEN 1 AND 3 AND status = 'Approved'");
        $coaKasCriteria->compare('code', $coaKas->code . '%', true, 'AND', false);
        $coaKasCriteria->compare('name', $coaKas->name, true);
        $coaKasCriteria->compare('normal_balance', $coaKas->normal_balance, true);
        $coaKasDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaKasCriteria,
        ));

        $coaDetail = new Coa('search');
        $coaDetail->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Coa']))
            $coaDetail->attributes = $_GET['Coa'];
        
        $coaDetailCriteria = new CDbCriteria;
        $coaDetailCriteria->addCondition("SUBSTRING(code, -3 , 3) <> 000 AND status = 'Approved'");
        $coaDetailCriteria->compare('code', $coaDetail->code . '%', true, 'AND', false);
        $coaDetailCriteria->compare('name', $coaDetail->name, true);
        $coaDetailCriteria->compare('t.coa_category_id', $coaDetail->coa_category_id);
        $coaDetailCriteria->compare('t.coa_sub_category_id', $coaDetail->coa_sub_category_id);
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
        //$model=$this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $cashTransaction = $this->instantiate($id);
        $cashTransaction->header->setCodeNumberByRevision('transaction_number');
        $this->performAjaxValidation($cashTransaction->header);

        $coaKas = new Coa('search');
        $coaKas->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coaKas->attributes = $_GET['Coa'];
        
        $coaKasCriteria = new CDbCriteria;
        $coaKasCriteria->addCondition("SUBSTRING(code, -3 , 3) <> 000 AND coa_sub_category_id BETWEEN 1 AND 3 AND status = 'Approved'");
        $coaKasCriteria->compare('code', $coaKas->code . '%', true, 'AND', false);
        $coaKasCriteria->compare('name', $coaKas->name, true);
        $coaKasCriteria->compare('normal_balance', $coaKas->normal_balance, true);
        $coaKasDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaKasCriteria,
        ));

        $coaDetail = new Coa('search');
        $coaDetail->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coaDetail->attributes = $_GET['Coa'];
        
        $coaDetailCriteria = new CDbCriteria;
        $coaDetailCriteria->addCondition("SUBSTRING(code, -3 , 3) <> 000 AND status = 'Approved'");
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

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['CashTransaction']) && IdempotentManager::check()) {
            $this->loadState($cashTransaction);

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
        
        $cashInTransactionDataProvider = $model->search();
        $cashInTransactionDataProvider->criteria->addCondition('t.transaction_type = "In" ');

        $cashOutTransactionDataProvider = $model->search();
        $cashOutTransactionDataProvider->criteria->addCondition('t.transaction_type = "Out" ');
        
        if ((int) $user->branch_id != 6) {
            $cashInTransactionDataProvider->criteria->addCondition('t.branch_id = ' . $user->branch_id);
            $cashOutTransactionDataProvider->criteria->addCondition('t.branch_id = ' . $user->branch_id);
        }

        $this->render('admin', array(
            'model' => $model,
            'user' => $user,
            'cashInTransactionDataProvider' => $cashInTransactionDataProvider,
            'cashOutTransactionDataProvider' => $cashOutTransactionDataProvider,
        ));
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

    public function instantiate($id) {
        
        if (empty($id)) {
            $cashTransaction = new Cashs(new CashTransaction(), array());
        } else {
            $cashTransactionModel = $this->loadModel($id);
            $cashTransaction = new Cashs($cashTransactionModel, $cashTransactionModel->cashTransactionDetails);
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
            $cashTransaction = $this->instantiate($id);
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

            $cashTransaction = $this->instantiate($id);
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

    public function actionAjaxGetTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $cashTransaction = $this->instantiate($id);
            $this->loadState($cashTransaction);
            $total = 0;

            foreach ($cashTransaction->details as $key => $detail) {
                $total += $detail->amount;
            }
            
            $object = array('total' => $total);
            echo CJSON::encode($object);
        }
    }

    public function actionUpdateApproval($headerId) {
        $cashTransaction = CashTransaction::model()->findByPK($headerId);
        $historis = CashTransactionApproval::model()->findAllByAttributes(array('cash_transaction_id' => $headerId));
        $model = new CashTransactionApproval;
        $model->date = date('Y-m-d H:i:s');
        $branch = Branch::model()->findByPk($cashTransaction->branch_id);
        $getCoa = "";
        $getCoaDetail = "";

        if (isset($_POST['CashTransactionApproval'])) {
            $model->attributes = $_POST['CashTransactionApproval'];
            if ($model->save()) {
                $cashTransaction->status = $model->approval_type;
                $cashTransaction->save(false);
                
                if ($model->approval_type == "Approved") {
                    JurnalUmum::model()->deleteAllByAttributes(array(
                        'kode_transaksi' => $cashTransaction->transaction_number,
                        'tanggal_transaksi' => $cashTransaction->transaction_date,
                        'branch_id' => $cashTransaction->branch_id,
                    ));

                    $coa = Coa::model()->findByPk($cashTransaction->coa_id);

                    $getCoa = $coa->code;
                    $coaWithCode = Coa::model()->findByAttributes(array('code' => $getCoa));
                    if ($cashTransaction->transaction_type == "In") {
                        $jurnalUmum = new JurnalUmum;
                        $jurnalUmum->kode_transaksi = $cashTransaction->transaction_number;
                        $jurnalUmum->tanggal_transaksi = $cashTransaction->transaction_date;
                        $jurnalUmum->coa_id = $coaWithCode->id;
                        $jurnalUmum->total = $cashTransaction->credit_amount;
                        $jurnalUmum->debet_kredit = 'D';
                        $jurnalUmum->tanggal_posting = date('Y-m-d');
                        $jurnalUmum->branch_id = $cashTransaction->branch_id;
                        $jurnalUmum->transaction_subject = 'Cash Transaction In';
                        $jurnalUmum->is_coa_category = 0;
                        $jurnalUmum->transaction_type = 'CASH';
                        $jurnalUmum->save();
                    } else {
                        $jurnalUmum = new JurnalUmum;
                        $jurnalUmum->kode_transaksi = $cashTransaction->transaction_number;
                        $jurnalUmum->tanggal_transaksi = $cashTransaction->transaction_date;
                        $jurnalUmum->coa_id = $coaWithCode->id;
                        $jurnalUmum->total = $cashTransaction->debit_amount;
                        $jurnalUmum->debet_kredit = 'K';
                        $jurnalUmum->tanggal_posting = date('Y-m-d');
                        $jurnalUmum->branch_id = $cashTransaction->branch_id;
                        $jurnalUmum->transaction_subject = 'Cash Transaction Out';
                        $jurnalUmum->is_coa_category = 0;
                        $jurnalUmum->transaction_type = 'CASH';
                        $jurnalUmum->save();
                    }

                    foreach ($cashTransaction->cashTransactionDetails as $key => $ctDetail) {
                        $coaDetail = Coa::model()->findByPk($ctDetail->coa_id);
                        $getCoaDetail = $coaDetail->code;
                        $coaDetailWithCode = Coa::model()->findByAttributes(array('code' => $getCoaDetail));

                        if ($cashTransaction->transaction_type == "In") {
                            $jurnalUmum = new JurnalUmum;
                            $jurnalUmum->kode_transaksi = $cashTransaction->transaction_number;
                            $jurnalUmum->tanggal_transaksi = $cashTransaction->transaction_date;
                            $jurnalUmum->coa_id = $coaDetailWithCode->id;
                            $jurnalUmum->total = $ctDetail->amount;
                            $jurnalUmum->debet_kredit = 'K';
                            $jurnalUmum->tanggal_posting = date('Y-m-d');
                            $jurnalUmum->branch_id = $cashTransaction->branch_id;
                            $jurnalUmum->transaction_subject = 'Cash Transaction In';
                            $jurnalUmum->is_coa_category = 0;
                            $jurnalUmum->transaction_type = 'CASH';
                            $jurnalUmum->save(false);
                        } else {
                            $jurnalUmum = new JurnalUmum;
                            $jurnalUmum->kode_transaksi = $cashTransaction->transaction_number;
                            $jurnalUmum->tanggal_transaksi = $cashTransaction->transaction_date;
                            $jurnalUmum->coa_id = $coaDetailWithCode->id;
                            $jurnalUmum->total = $ctDetail->amount;
                            $jurnalUmum->debet_kredit = 'D';
                            $jurnalUmum->tanggal_posting = date('Y-m-d');
                            $jurnalUmum->branch_id = $cashTransaction->branch_id;
                            $jurnalUmum->transaction_subject = 'Cash Transaction Out';
                            $jurnalUmum->is_coa_category = 0;
                            $jurnalUmum->transaction_type = 'CASH';
                            $jurnalUmum->save(false);
                        }
                    }
                }
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'cashTransaction' => $cashTransaction,
            'historis' => $historis,
        ));
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