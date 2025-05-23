<?php

class JournalAdjustmentController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('adjustmentJournalCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('adjustmentJournalEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('adjustmentJournalApproval') || Yii::app()->user->checkAccess('adjustmentJournalSupervisor'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'update' ||
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'view'
        ) {
            if (!(
                Yii::app()->user->checkAccess('adjustmentJournalCreate') || 
                Yii::app()->user->checkAccess('adjustmentJournalEdit') || 
                Yii::app()->user->checkAccess('adjustmentJournalView')
            )) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $journalVoucher = $this->instantiate(null);
        $journalVoucher->header->date = date('Y-m-d');
        $journalVoucher->header->time = date('H:i:s');
        $journalVoucher->header->status = 'Draft';
        $journalVoucher->header->created_datetime = date('Y-m-d H:i:s');
        $journalVoucher->header->user_id = Yii::app()->user->id;
        $journalVoucher->header->branch_id = Yii::app()->user->branch_id;

        $account = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $dataProvider = $account->search();
//        $dataProvider->criteria->addCondition("t.status = 'Approved'");

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($journalVoucher);
            $journalVoucher->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($journalVoucher->header->date)), Yii::app()->dateFormatter->format('yyyy', strtotime($journalVoucher->header->date)), $journalVoucher->header->branch_id);

            if ($journalVoucher->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $journalVoucher->header->id));
            }
        }

        $this->render('create', array(
            'journalVoucher' => $journalVoucher,
            'account' => $account,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $journalVoucher = $this->instantiate($id);
        $journalVoucher->header->status = 'Draft';
        $journalVoucher->header->updated_datetime = date('Y-m-d H:i:s');
        $journalVoucher->header->user_id_updated = Yii::app()->user->id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $account = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $dataProvider = $account->search();
        $dataProvider->criteria->addCondition("t.status = 'Approved'");

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($journalVoucher);

            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $journalVoucher->header->transaction_number,
            ));

            $journalVoucher->header->setCodeNumberByRevision('transaction_number');

            if ($journalVoucher->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $journalVoucher->header->id));
            }
        }

        $this->render('update', array(
            'journalVoucher' => $journalVoucher,
            'account' => $account,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        
        $journalAdjustmentHeader = Search::bind(new JournalAdjustmentHeader('search'), isset($_GET['JournalAdjustmentHeader']) ? $_GET['JournalAdjustmentHeader'] : array());
        $journalAdjustmentHeaderDataProvider = $journalAdjustmentHeader->searchByAdmin();
        $journalAdjustmentHeaderDataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        
        if (!Yii::app()->user->checkAccess('director')) {
            $journalAdjustmentHeaderDataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $journalAdjustmentHeaderDataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        }
        
        $this->render('admin', array(
            'journalAdjustmentHeader' => $journalAdjustmentHeader,
            'journalAdjustmentHeaderDataProvider' => $journalAdjustmentHeaderDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }

    public function actionView($id) {
        $journalVoucher = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('journal_adjustment_header_id', $journalVoucher->id);
        $detailsDataProvider = new CActiveDataProvider('JournalAdjustmentDetail', array(
            'criteria' => $criteria,
        ));

        $detailsDataProvider->criteria->with = array('coa');

        if (isset($_POST['Process'])) {
            
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $journalVoucher->transaction_number,
            ));

            foreach ($journalVoucher->journalAdjustmentDetails as $detail) {
                $jurnalUmum = new JurnalUmum;
                $jurnalUmum->kode_transaksi = $journalVoucher->transaction_number;
                $jurnalUmum->tanggal_transaksi = $journalVoucher->date;
                $jurnalUmum->coa_id = $detail->coa_id;
                $jurnalUmum->branch_id = $journalVoucher->branch_id;
                $jurnalUmum->total = ($detail->debit == 0.00) ? $detail->credit : $detail->debit;
                $jurnalUmum->debet_kredit = ($detail->debit == 0.00) ? 'K' : 'D';
                $jurnalUmum->tanggal_posting = date('Y-m-d');
                $jurnalUmum->transaction_subject = $journalVoucher->note;
                $jurnalUmum->is_coa_category = 0;
                $jurnalUmum->transaction_type = 'JP';

                $jurnalUmum->save(false);
            }
        }
        
        $this->render('view', array(
            'journalVoucher' => $journalVoucher,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionShow($id) {
        $journalVoucher = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('journal_adjustment_header_id', $journalVoucher->id);
        $detailsDataProvider = new CActiveDataProvider('JournalAdjustmentDetail', array(
            'criteria' => $criteria,
        ));

        $detailsDataProvider->criteria->with = array('coa');

        $this->render('show', array(
            'journalVoucher' => $journalVoucher,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionUpdateApproval($headerId) {
        $journalVoucher = $this->loadModel($headerId);
        $historis = JournalAdjustmentApproval::model()->findAllByAttributes(array('journal_adjustment_header_id' => $headerId));
        
        $model = new JournalAdjustmentApproval;
        $model->journal_adjustment_header_id = $headerId;
        $model->date = date('Y-m-d');
        $model->time = date('H:i:s');

        if (isset($_POST['JournalAdjustmentApproval'])) {
            $model->attributes = $_POST['JournalAdjustmentApproval'];

            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $journalVoucher->transaction_number,
            ));

            if ($model->save()) {
                $journalVoucher->status = $model->approval_type;
                $journalVoucher->update(array('status'));
                
                if ($model->approval_type === "Approved") {
                    foreach ($journalVoucher->journalAdjustmentDetails as $detail) {
                        $jurnalUmum = new JurnalUmum;
                        $jurnalUmum->kode_transaksi = $journalVoucher->transaction_number;
                        $jurnalUmum->tanggal_transaksi = $journalVoucher->date;
                        $jurnalUmum->coa_id = $detail->coa_id;
                        $jurnalUmum->branch_id = $journalVoucher->branch_id;
                        $jurnalUmum->total = ($detail->debit == 0.00) ? $detail->credit : $detail->debit;
                        $jurnalUmum->debet_kredit = ($detail->debit == 0.00) ? 'K' : 'D';
                        $jurnalUmum->tanggal_posting = date('Y-m-d');
                        $jurnalUmum->transaction_subject = $detail->memo;
                        $jurnalUmum->is_coa_category = 0;
                        $jurnalUmum->transaction_type = 'JP';

                        $jurnalUmum->save(false);
                    }
                }
                
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'journalVoucher' => $journalVoucher,
            'historis' => $historis,
        ));
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $journalVoucher = $this->instantiate($id);
            $this->loadState($journalVoucher);

            if (isset($_POST['selectedIds'])) {
                $coaIds = array();
                $coaIds = $_POST['selectedIds'];

                foreach ($coaIds as $coaId) {
                    $journalVoucher->addDetail($coaId);
                }
            }

            $this->renderPartial('_detail', array(
                'journalVoucher' => $journalVoucher,
            ));
        }
    }

    public function actionAjaxHtmlRemoveAccountDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $journalVoucher = $this->instantiate($id);
            $this->loadState($journalVoucher);

            $journalVoucher->removeAccountDetailAt($index);

            $this->renderPartial('_detail', array(
                'journalVoucher' => $journalVoucher,
            ));
        }
    }

    public function actionAjaxJsonTotalDebit($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $journalVoucher = $this->instantiate($id);
            $this->loadState($journalVoucher);

            $debit = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($journalVoucher->details[$index], 'debit')));
            $totalDebit = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $journalVoucher->totalDebit));

            echo CJSON::encode(array(
                'debit' => $debit,
                'totalDebit' => $totalDebit,
            ));
        }
    }

    public function actionAjaxJsonTotalCredit($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $journalVoucher = $this->instantiate($id);
            $this->loadState($journalVoucher);

            $credit = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($journalVoucher->details[$index], 'credit')));
            $totalCredit = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $journalVoucher->totalCredit));

            echo CJSON::encode(array(
                'credit' => $credit,
                'totalCredit' => $totalCredit,
            ));
        }
    }

    public function actionAjaxHtmlUpdateSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $categoryId = isset($_GET['Coa']['coa_category_id']) ? $_GET['Coa']['coa_category_id'] : 0;

            $this->renderPartial('_subCategorySelect', array(
                'categoryId' => $categoryId,
            ), false, true);
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $journalVoucher = new JournalAdjustment(new JournalAdjustmentHeader(), array());
        } else {
            $journalVoucherHeader = $this->loadModel($id);
            $journalVoucher = new JournalAdjustment($journalVoucherHeader, $journalVoucherHeader->journalAdjustmentDetails);
        }

        return $journalVoucher;
    }

    public function loadModel($id) {
        $model = JournalAdjustmentHeader::model()->findByPk($id);

        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    protected function loadState($journalVoucher) {
        if (isset($_POST['JournalAdjustmentHeader'])) {
            $journalVoucher->header->attributes = $_POST['JournalAdjustmentHeader'];
        }
        
        if (isset($_POST['JournalAdjustmentDetail'])) {
            foreach ($_POST['JournalAdjustmentDetail'] as $i => $item) {
                if (isset($journalVoucher->details[$i])) {
                    $journalVoucher->details[$i]->attributes = $item;
                } else {
                    $detail = new JournalAdjustmentDetail();
                    $detail->attributes = $item;
                    $journalVoucher->details[] = $detail;
                }
            }
            if (count($_POST['JournalAdjustmentDetail']) < count($journalVoucher->details))
                array_splice($journalVoucher->details, $i + 1);
        } else {
            $journalVoucher->details = array();
        }
    }
}