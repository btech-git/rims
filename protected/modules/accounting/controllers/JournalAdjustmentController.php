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
            if (!(Yii::app()->user->checkAccess('adjustmentJournalCreate')))
                $this->redirect(array('/site/login'));
        }

        if ($filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('adjustmentJournalEdit')))
                $this->redirect(array('/site/login'));
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('adjustmentJournalApproval')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'update' ||
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('adjustmentJournalCreate')) || !(Yii::app()->user->checkAccess('adjustmentJournalEdit')) || !(Yii::app()->user->checkAccess('adjustmentJournalApproval')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $journalVoucher = $this->instantiate(null);
        $journalVoucher->header->date = date('Y-m-d');
        $journalVoucher->header->time = date('H:i:s');
        $journalVoucher->header->status = 'Draft';
        $journalVoucher->header->user_id = Yii::app()->user->id;

        $account = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $dataProvider = $account->search();
//        $dataProvider->criteria->addCondition("t.status = 'Approved'");

        if (isset($_POST['Submit'])) {
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $account = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $dataProvider = $account->search();
        $dataProvider->criteria->addCondition("t.status = 'Approved'");

        if (isset($_POST['Submit'])) {
            $this->loadState($journalVoucher);

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
        $journalVoucher = new JournalAdjustmentHeader('search');
        $journalVoucher->unsetAttributes();  // clear any default values
        
        if (isset($_GET['CashTransaction'])) {
            $journalVoucher->attributes = $_GET['CashTransaction'];
        }
        
        $this->render('admin', array(
            'journalVoucher' => $journalVoucher,
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

        $this->render('view', array(
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
            if ($model->save()) {
                $journalVoucher->status = $model->approval_type;
                $journalVoucher->save(false);
                
                if ($model->approval_type == "Approved") {
                    JurnalUmum::model()->deleteAllByAttributes(array(
                        'kode_transaksi' => $journalVoucher->transaction_number,
                        'branch_id' => $journalVoucher->branch_id,
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