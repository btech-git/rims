<?php

class JournalBeginningController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create' || $filterChain->action->id === 'update' || $filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('director'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $journalBeginning = $this->instantiate(null);
        $journalBeginning->header->transaction_date = date('Y-m-d');
        $journalBeginning->header->status = 'Draft';
        $journalBeginning->header->branch_id = Yii::app()->user->branch_id;
        $journalBeginning->header->created_datetime = date('Y-m-d H:i:s');
        $journalBeginning->header->updated_datetime = null;
        $journalBeginning->header->cancelled_datetime = null;
        $journalBeginning->header->user_id_created = Yii::app()->user->id;
        $journalBeginning->header->user_id_updated = null;
        $journalBeginning->header->user_id_cancelled = null;

        $account = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $dataProvider = $account->search();
        $dataProvider->criteria->addCondition("t.status = 'Approved' AND t.is_approved = 1");

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($journalBeginning);
            $journalBeginning->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($journalBeginning->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($journalBeginning->header->transaction_date)), $journalBeginning->header->branch_id);

            if ($journalBeginning->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $journalBeginning->header->id));
            }
        }

        $this->render('create', array(
            'journalBeginning' => $journalBeginning,
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
        $journalBeginning = $this->instantiate($id);
        $journalBeginning->header->status = 'Draft';
        $journalBeginning->header->updated_datetime = date('Y-m-d H:i:s');
        $journalBeginning->header->user_id_updated = Yii::app()->user->id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $account = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $dataProvider = $account->search();
        $dataProvider->criteria->addCondition("t.status = 'Approved' AND t.is_approved = 1");

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($journalBeginning);

            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $journalBeginning->header->transaction_number,
            ));

            $journalBeginning->header->setCodeNumberByRevision('transaction_number');

            if ($journalBeginning->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $journalBeginning->header->id));
            }
        }

        $this->render('update', array(
            'journalVoucher' => $journalBeginning,
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
        
        $journalBeginning = Search::bind(new JournalBeginningHeader('search'), isset($_GET['JournalBeginningHeader']) ? $_GET['JournalBeginningHeader'] : array());
        $journalBeginningDataProvider = $journalBeginning->search();
        $journalBeginningDataProvider->criteria->addBetweenCondition('t.transaction_date', $startDate, $endDate);
        
        if (!Yii::app()->user->checkAccess('director')) {
            $journalBeginningDataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $journalBeginningDataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        }
        
        $this->render('admin', array(
            'journalBeginning' => $journalBeginning,
            'journalBeginningDataProvider' => $journalBeginningDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }

    public function actionView($id) {
        $journalBeginning = $this->loadModel($id);

        if (isset($_POST['Process'])) {
            
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $journalBeginning->transaction_number,
            ));

            foreach ($journalBeginning->journalBeginningDetails as $detail) {
                $jurnalUmum = new JurnalUmum;
                $jurnalUmum->kode_transaksi = $journalBeginning->transaction_number;
                $jurnalUmum->tanggal_transaksi = $journalBeginning->transaction_date;
                $jurnalUmum->coa_id = $detail->coa_id;
                $jurnalUmum->branch_id = $journalBeginning->branch_id;
                $jurnalUmum->total = $detail->difference_balance;
                $jurnalUmum->debet_kredit = $detail->coa->normal_balance == 'KREDIT' ? 'K' : 'D';
                $jurnalUmum->tanggal_posting = date('Y-m-d');
                $jurnalUmum->transaction_subject = $journalBeginning->note;
                $jurnalUmum->remark = $detail->memo;
                $jurnalUmum->is_coa_category = 0;
                $jurnalUmum->transaction_type = 'JBB';

                $jurnalUmum->save(false);
            }
        }
        
        $this->render('view', array(
            'journalBeginning' => $journalBeginning,
        ));
    }

    public function actionShow($id) {
        $journalBeginning = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('journal_beginning_header_id', $journalBeginning->id);
        $detailsDataProvider = new CActiveDataProvider('JournalBeginningDetail', array(
            'criteria' => $criteria,
        ));

        $detailsDataProvider->criteria->with = array('coa');

        $this->render('show', array(
            'journalVoucher' => $journalBeginning,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionUpdateApproval($headerId) {
        $journalBeginning = $this->loadModel($headerId);
        $historis = JournalBeginningApproval::model()->findAllByAttributes(array('journal_beginning_header_id' => $headerId));
        
        $model = new JournalBeginningApproval;
        $model->journal_beginning_header_id = $headerId;
        $model->user_id_approval = Yii::app()->user->getId();
        $model->date = date('Y-m-d');
        $model->time = date('H:i:s');
        $userIdApproval = Users::model()->findByPk($model->user_id_approval);

        if (isset($_POST['JournalBeginningApproval'])) {
            $model->attributes = $_POST['JournalBeginningApproval'];

            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $journalBeginning->transaction_number,
            ));

            if ($model->save()) {
                $journalBeginning->status = $model->approval_type;
                $journalBeginning->update(array('status'));
                
                if ($model->approval_type === "Approved") {
                    foreach ($journalBeginning->journalBeginningDetails as $detail) {
                        $jurnalUmum = new JurnalUmum;
                        $jurnalUmum->kode_transaksi = $journalBeginning->transaction_number;
                        $jurnalUmum->tanggal_transaksi = $journalBeginning->transaction_date;
                        $jurnalUmum->coa_id = $detail->coa_id;
                        $jurnalUmum->branch_id = $journalBeginning->branch_id;
                        $jurnalUmum->total = $detail->difference_balance;
                        $jurnalUmum->debet_kredit = $detail->coa->normal_balance == 'KREDIT' ? 'K' : 'D';
                        $jurnalUmum->tanggal_posting = date('Y-m-d');
                        $jurnalUmum->transaction_subject = $journalBeginning->note;
                        $jurnalUmum->remark = $detail->memo;
                        $jurnalUmum->is_coa_category = 0;
                        $jurnalUmum->transaction_type = 'JBB';

                        $jurnalUmum->save(false);
                    }
                }
                
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'journalBeginning' => $journalBeginning,
            'historis' => $historis,
            'userIdApproval' => $userIdApproval,
        ));
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $journalBeginning = $this->instantiate($id);
            $this->loadState($journalBeginning);

            if (isset($_POST['selectedIds'])) {
                $coaIds = array();
                $coaIds = $_POST['selectedIds'];
                
                $ledgerBeginningBalances = JurnalUmum::getLedgerBeginningBalances($coaIds, $journalBeginning->header->transaction_date, $journalBeginning->header->branch_id);
                
                $beginningBalances = array();
                foreach ($ledgerBeginningBalances as $ledgerBeginningBalance) {
                    $beginningBalances[$ledgerBeginningBalance['coa_id']] = $ledgerBeginningBalance['beginning_balance'];
                }

                foreach ($coaIds as $coaId) {
                    $journalBeginning->addDetail($coaId);
                }

                foreach ($journalBeginning->details as $detail) {
                    $detail->current_balance = isset($beginningBalances[$detail->coa_id]) ? $beginningBalances[$detail->coa_id] : '0.00';
                    $detail->difference_balance = $detail->balanceDifference;
                }
            }

            $this->renderPartial('_detail', array(
                'journalBeginning' => $journalBeginning,
            ));
        }
    }

    public function actionAjaxHtmlRemoveAccountDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $journalBeginning = $this->instantiate($id);
            $this->loadState($journalBeginning);

            $journalBeginning->removeAccountDetailAt($index);

            $this->renderPartial('_detail', array(
                'journalVoucher' => $journalBeginning,
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

    public function actionAjaxJsonAdjustmentBalance($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $journalBeginning = $this->instantiate($id);
            $this->loadState($journalBeginning);

            $differenceBalanceRaw = $journalBeginning->details[$index]->balanceDifference;
            $adjustmentBalance = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($journalBeginning->details[$index], 'adjustment_balance')));
            $differenceBalance = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $differenceBalanceRaw));
            $journalBeginning->details[$index]->difference_balance = $differenceBalanceRaw;

            echo CJSON::encode(array(
                'adjustmentBalance' => $adjustmentBalance,
                'differenceBalance' => $differenceBalance,
                'differenceBalanceRaw' => $differenceBalanceRaw,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $journalBeginning = new JournalBeginning(new JournalBeginningHeader(), array());
        } else {
            $journalBeginningHeader = $this->loadModel($id);
            $journalBeginning = new JournalBeginning($journalBeginningHeader, $journalBeginningHeader->journalBeginningDetails);
        }

        return $journalBeginning;
    }

    public function loadModel($id) {
        $model = JournalBeginningHeader::model()->findByPk($id);

        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    protected function loadState($journalBeginning) {
        if (isset($_POST['JournalBeginningHeader'])) {
            $journalBeginning->header->attributes = $_POST['JournalBeginningHeader'];
        }
        
        if (isset($_POST['JournalBeginningDetail'])) {
            foreach ($_POST['JournalBeginningDetail'] as $i => $item) {
                if (isset($journalBeginning->details[$i])) {
                    $journalBeginning->details[$i]->attributes = $item;
                } else {
                    $detail = new JournalBeginningDetail();
                    $detail->attributes = $item;
                    $journalBeginning->details[] = $detail;
                }
            }
            if (count($_POST['JournalBeginningDetail']) < count($journalBeginning->details)) {
                array_splice($journalBeginning->details, $i + 1);
            }
        } else {
            $journalBeginning->details = array();
        }
    }
}