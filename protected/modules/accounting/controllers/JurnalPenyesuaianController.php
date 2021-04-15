<?php

class JurnalPenyesuaianController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';

    /**
     * @return array action filters
     */
    // public function filters()
    // {
    // 	return array(
    // 		'accessControl', // perform access control for CRUD operations
    // 		'postOnly + delete', // we only allow deletion via POST request
    // 	);
    // }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('Admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new JurnalPenyesuaian;

        $model->branch_id = $model->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $model->branch_id;
        $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->transaction_date)), $model->branch_id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $coaBiaya = new Coa('search');
        $coaBiaya->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Coa']))
            $coaBiaya->attributes = $_GET['Coa'];
        
        $coaBiayaCriteria = new CDbCriteria;
//        $coaBiayaCriteria->addCondition("coa_sub_category_id = 43  and coa_id = 0");
        $coaBiayaCriteria->compare('code', $coaBiaya->code . '%', true, 'AND', false);
        $coaBiayaCriteria->compare('name', $coaBiaya->name, true);
        $coaBiayaCriteria->compare('normal_balance', $coaBiaya->normal_balance, true);
        $coaBiayaDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaBiayaCriteria,
        ));
        $coaAkumulasi = new Coa('search');
        $coaAkumulasi->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coaAkumulasi->attributes = $_GET['Coa'];
        $coaAkumulasiCriteria = new CDbCriteria;
//        $coaAkumulasiCriteria->addCondition("coa_sub_category_id = 11  and coa_id = 0");
        $coaAkumulasiCriteria->compare('code', $coaAkumulasi->code . '%', true, 'AND', false);
        $coaAkumulasiCriteria->compare('name', $coaAkumulasi->name, true);
        $coaAkumulasiCriteria->compare('normal_balance', $coaAkumulasi->normal_balance, true);
        $coaAkumulasiDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaAkumulasiCriteria,
        ));

        if (isset($_POST['JurnalPenyesuaian'])) {
            $model->attributes = $_POST['JurnalPenyesuaian'];
            if ($model->save()) {

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'coaBiaya' => $coaBiaya,
            'coaBiayaDataProvider' => $coaBiayaDataProvider,
            'coaAkumulasi' => $coaAkumulasi,
            'coaAkumulasiDataProvider' => $coaAkumulasiDataProvider,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $coaBiaya = new Coa('search');
        $coaBiaya->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coaBiaya->attributes = $_GET['Coa'];
        $coaBiayaCriteria = new CDbCriteria;
        $coaBiayaCriteria->addCondition("coa_sub_category_id = 43 and coa_id = 0");
        $coaBiayaCriteria->compare('code', $coaBiaya->code . '%', true, 'AND', false);
        $coaBiayaCriteria->compare('name', $coaBiaya->name, true);
        $coaBiayaCriteria->compare('normal_balance', $coaBiaya->normal_balance, true);
        $coaBiayaDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaBiayaCriteria,
        ));
        $coaAkumulasi = new Coa('search');
        $coaAkumulasi->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coaAkumulasi->attributes = $_GET['Coa'];
        $coaAkumulasiCriteria = new CDbCriteria;
        $coaAkumulasiCriteria->addCondition("coa_sub_category_id = 11 and coa_id = 0");
        $coaAkumulasiCriteria->compare('code', $coaAkumulasi->code . '%', true, 'AND', false);
        $coaAkumulasiCriteria->compare('name', $coaAkumulasi->name, true);
        $coaAkumulasiCriteria->compare('normal_balance', $coaAkumulasi->normal_balance, true);
        $coaAkumulasiDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaAkumulasiCriteria,
        ));

        if (isset($_POST['JurnalPenyesuaian'])) {
            $model->attributes = $_POST['JurnalPenyesuaian'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
            'coaBiaya' => $coaBiaya,
            'coaBiayaDataProvider' => $coaBiayaDataProvider,
            'coaAkumulasi' => $coaAkumulasi,
            'coaAkumulasiDataProvider' => $coaAkumulasiDataProvider,
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
        $dataProvider = new CActiveDataProvider('JurnalPenyesuaian');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new JurnalPenyesuaian('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['JurnalPenyesuaian']))
            $model->attributes = $_GET['JurnalPenyesuaian'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return JurnalPenyesuaian the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = JurnalPenyesuaian::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param JurnalPenyesuaian $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'jurnal-penyesuaian-form') {
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

    public function actionUpdateApproval($headerId) {
        $jurnalPenyesuaian = JurnalPenyesuaian::model()->findByPK($headerId);
        $historis = JurnalPenyesuaianApproval::model()->findAllByAttributes(array('jurnal_penyesuaian_id' => $headerId));
        $model = new JurnalPenyesuaianApproval;
        $branch = Branch::model()->findByPK($jurnalPenyesuaian->branch_id);
        //$model = $this->loadModelDetail($detailId);
        if (isset($_POST['JurnalPenyesuaianApproval'])) {
            $model->attributes = $_POST['JurnalPenyesuaianApproval'];
            if ($model->save()) {
                $jurnalPenyesuaian->status = $model->approval_type;
                $jurnalPenyesuaian->save(false);
                if ($model->approval_type == "Approved") {
                    JurnalUmum::model()->deleteAllByAttributes(array(
                        'kode_transaksi' => $jurnalPenyesuaian->transaction_number,
                        'tanggal_transaksi' => $jurnalPenyesuaian->transaction_date,
                        'branch_id' => $jurnalPenyesuaian->branch_id,
                    ));

                    $coaBiaya = Coa::model()->findByPK($jurnalPenyesuaian->coa_biaya_id);
                    $getCoaBiaya = $branch->coa_prefix . '.' . $coaBiaya->code;
                    $coaBiayaWithCode = Coa::model()->findByAttributes(array('code' => $getCoaBiaya));
                    $jurnalUmumBiaya = new JurnalUmum;
                    $jurnalUmumBiaya->kode_transaksi = $jurnalPenyesuaian->transaction_number;
                    $jurnalUmumBiaya->tanggal_transaksi = $jurnalPenyesuaian->transaction_date;
                    $jurnalUmumBiaya->coa_id = $coaBiayaWithCode->id;
                    $jurnalUmumBiaya->branch_id = $jurnalPenyesuaian->branch_id;
                    $jurnalUmumBiaya->total = $jurnalPenyesuaian->amount;
                    $jurnalUmumBiaya->debet_kredit = 'D';
                    $jurnalUmumBiaya->tanggal_posting = date('Y-m-d');
                    $jurnalUmumBiaya->save();

                    $coaAkumulasi = Coa::model()->findByPK($jurnalPenyesuaian->coa_akumulasi_id);
                    $getCoaAkumulasi = $branch->coa_prefix . '.' . $coaAkumulasi->code;
                    $coaAkumulasiWithCode = Coa::model()->findByAttributes(array('code' => $getCoaAkumulasi));
                    $jurnalUmumAkumulasi = new JurnalUmum;
                    $jurnalUmumAkumulasi->kode_transaksi = $jurnalPenyesuaian->transaction_number;
                    $jurnalUmumAkumulasi->tanggal_transaksi = $jurnalPenyesuaian->transaction_date;
                    $jurnalUmumAkumulasi->coa_id = $coaAkumulasiWithCode->id;
                    $jurnalUmumAkumulasi->branch_id = $jurnalPenyesuaian->branch_id;
                    $jurnalUmumAkumulasi->total = $jurnalPenyesuaian->amount;
                    $jurnalUmumAkumulasi->debet_kredit = 'K';
                    $jurnalUmumAkumulasi->tanggal_posting = date('Y-m-d');
                    $jurnalUmumAkumulasi->save();
                }
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'jurnalPenyesuaian' => $jurnalPenyesuaian,
            'historis' => $historis,
                //'jenisPersediaan'=>$jenisPersediaan,
                //'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
        ));
    }

}
