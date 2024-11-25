<?php

class CompanyController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/backend';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('masterCompanyCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'edit' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'restore' || 
            $filterChain->action->id === 'updateBank'
        ) {
            if (!(Yii::app()->user->checkAccess('masterCompanyEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'profile' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(Yii::app()->user->checkAccess('masterCompanyCreate')) || !(Yii::app()->user->checkAccess('masterCompanyEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $companyBanks = CompanyBank::model()->findAllByAttributes(array('company_id' => $id));
        $companyBranches = CompanyBranch::model()->findAllByAttributes(array('company_id' => $id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'companyBanks' => $companyBanks,
            'companyBranches' => $companyBranches,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Company;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // if(isset($_POST['Company']))
        // {
        // 	$model->attributes=$_POST['Company'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }

        $bank = new Bank('search');
        $bank->unsetAttributes();  // clear any default values
        if (isset($_GET['Bank']))
            $bank->attributes = $_GET['Bank'];

        $bankCriteria = new CDbCriteria;
        $bankCriteria->compare('t.code', $bank->code . '%', true, 'AND', false);
        $bankCriteria->compare('t.name', $bank->name, true);

        $bankDataProvider = new CActiveDataProvider('Bank', array(
            'criteria' => $bankCriteria,
        ));

        $coa = new Coa('search');
        $coa->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coa->attributes = $_GET['Coa'];

        $coaCriteria = new CDbCriteria;
        //$coaCriteria->addCondition("coa_sub_category_id = 2");
        $coaCriteria->compare('t.code', $coa->code . '%', true, 'AND', false);
        $coaCriteria->compare('t.name', $coa->name, true);

        $coaDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaCriteria,
        ));

        $branch = new Branch('search');
        $branch->unsetAttributes();  // clear any default values
        if (isset($_GET['Branch']))
            $branch->attributes = $_GET['Branch'];

        $branchCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $branchCriteria->compare('name', $branch->name, true);

        $branchDataProvider = new CActiveDataProvider('Branch', array(
            'criteria' => $branchCriteria,
        ));
        $branchArray = array();

        $company = $this->instantiate(null);
        if (isset($_POST['Company'])) {
            $this->loadState($company);
            if ($company->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $company->header->id));
            }
        }

        $this->render('create', array(
            'company' => $company,
            'bank' => $bank,
            'bankDataProvider' => $bankDataProvider,
            'branch' => $branch,
            'branchDataProvider' => $branchDataProvider,
            'branchArray' => $branchArray,
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
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

        $bank = new Bank('search');
        $bank->unsetAttributes();  // clear any default values
        if (isset($_GET['Bank']))
            $bank->attributes = $_GET['Bank'];

        $bankCriteria = new CDbCriteria;
        $bankCriteria->compare('t.code', $bank->code . '%', true, 'AND', false);
        $bankCriteria->compare('t.name', $bank->name, true);

        $bankDataProvider = new CActiveDataProvider('Bank', array(
            'criteria' => $bankCriteria,
        ));
        $coa = new Coa('search');
        $coa->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coa->attributes = $_GET['COA'];

        $coaCriteria = new CDbCriteria;
        //$coaCriteria->addCondition("coa_sub_category_id = 2");
        $coaCriteria->compare('t.code', $coa->code . '%', true, 'AND', false);
        $coaCriteria->compare('t.name', $coa->name, true);
        $coaCriteria->compare('t.coa_sub_category_id', 2);

        $coaDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaCriteria,
        ));

        $branch = new Branch('search');
        $branch->unsetAttributes();  // clear any default values
        if (isset($_GET['Branch']))
            $branch->attributes = $_GET['Branch'];

        $branchCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $branchCriteria->compare('name', $branch->name, true);

        $branchDataProvider = new CActiveDataProvider('Branch', array(
            'criteria' => $branchCriteria,
        ));

        $branchChecks = CompanyBranch::model()->findAllByAttributes(array('company_id' => $id));
        $branchArray = array();
        foreach ($branchChecks as $key => $branchCheck) {
            array_push($branchArray, $branchCheck->branch_id);
        }

        $company = $this->instantiate($id);

        $this->performAjaxValidation($company->header);

        if (isset($_POST['Company'])) {
            // $model->attributes=$_POST['Company'];
            // if($model->save())
            // 	$this->redirect(array('view','id'=>$model->id));
            $this->loadState($company);
            if ($company->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $company->header->id));
            }
        }

        $this->render('update', array(
            'company' => $company,
            'bank' => $bank,
            'bankDataProvider' => $bankDataProvider,
            'branch' => $branch,
            'branchDataProvider' => $branchDataProvider,
            'branchArray' => $branchArray,
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->remove();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionRestore($id) {
        // var_dump($id); die("S");
        $this->loadModel($id)->restore();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Company');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Company('search');
        //$model->disableBehavior('SoftDelete');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Company']))
            $model->attributes = $_GET['Company'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    //Add Branch Detail
    public function actionAjaxHtmlAddBranchDetail($id, $branchId) {
        if (Yii::app()->request->isAjaxRequest) {
            $company = $this->instantiate($id);
            $this->loadState($company);

            $company->addBranchDetail($branchId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailBranch', array('company' => $company), false, true);
        }
    }

    //Delete Branch Detail
    public function actionAjaxHtmlRemoveBranchDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $company = $this->instantiate($id);
            $this->loadState($company);
            //print_r(CJSON::encode($salesOrder->details));
            $company->removeBranchDetailAt($index);
            $this->renderPartial('_detailBranch', array('company' => $company), false, true);
        }
    }

    //Add Bank Detail
    public function actionAjaxHtmlAddBankDetail($id, $bankId) {
        if (Yii::app()->request->isAjaxRequest) {
            $company = $this->instantiate($id);
            $this->loadState($company);

            $company->addBankDetail($bankId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailBank', array('company' => $company), false, true);
        }
    }

    //Delete Mobile Detail
    public function actionAjaxHtmlRemoveBankDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $company = $this->instantiate($id);
            $this->loadState($company);
            //print_r(CJSON::encode($salesOrder->details));
            $company->removeBankDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailBank', array('company' => $company), false, true);
        }
    }

    // Ajax Get Bank
    public function actionAjaxBank($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $bank = Bank::model()->findByPk($id);

            $object = array(
                'id' => $bank->id,
                'code' => $bank->code,
                'name' => $bank->name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxCoa($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $coa = Coa::model()->findByPk($id);

            $object = array(
                'id' => $coa->id,
                'code' => $coa->code,
                'name' => $coa->name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionUpdateBank($companyId, $bankId) {

        $bank = new Bank('search');
        $bank->unsetAttributes();  // clear any default values
        if (isset($_GET['Bank']))
            $bank->attributes = $_GET['Bank'];

        $bankCriteria = new CDbCriteria;
        $bankCriteria->compare('code', $bank->code . '%', true, 'AND', false);
        $bankCriteria->compare('name', $bank->name, true);

        $bankDataProvider = new CActiveDataProvider('Bank', array(
            'criteria' => $bankCriteria,
        ));
        $coa = new Coa('search');
        $coa->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coa->attributes = $_GET['COA'];

        $coaCriteria = new CDbCriteria;
        $coaCriteria->addCondition("coa_sub_category_id IN (1, 2, 3)");
        $coaCriteria->compare('code', $coa->code . '%', true, 'AND', false);
        $coaCriteria->compare('name', $coa->name, true);

        $coaDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaCriteria,
        ));

        $company = $this->instantiate($companyId);


        $model = CompanyBank::model()->findByPk($bankId);
        //$this->performAjaxValidation($model);
        if (isset($_POST['CompanyBank'])) {
            $model->attributes = $_POST['CompanyBank'];
            // if($model->save())
            // 	$this->redirect(array('view','id'=>$model->company_id));
            $model->bank_id = $_POST['CompanyBank']['bank_id'];
            $model->account_name = $_POST['CompanyBank']['account_name'];
            $model->account_no = $_POST['CompanyBank']['account_no'];
            $model->swift_code = $_POST['CompanyBank']['swift_code'];
            $model->coa_id = $_POST['CompanyBank']['coa_id'];


            if ($model->update(array('bank_id', 'account_name', 'account_no', 'swift_code', 'coa_id')))
                $this->redirect(array('view', 'id' => $model->company_id));
        }

        $this->render('update', array(
            'company' => $company,
            'model' => $model,
            'bank' => $bank,
            'bankDataProvider' => $bankDataProvider,
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
        ));
    }

    public function actionAjaxGetCity() {


        $data = City::model()->findAllByAttributes(array('province_id' => $_POST['Company']['province_id']), array('order' => 'name ASC'));

        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
            foreach ($data as $value => $name) {

                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Company the loaded model
     * @throws CHttpException
     */
    public function instantiate($id) {
        if (empty($id)) {
            $company = new Companies(new Company(), array(), array());
            //print_r("test");
        } else {
            $companyModel = $this->loadModel($id);
            $company = new Companies($companyModel, $companyModel->companyBanks, $companyModel->companyBranches);
        }
        return $company;
    }

    public function loadState($company) {
        if (isset($_POST['Company'])) {
            $company->header->attributes = $_POST['Company'];
        }
        if (isset($_POST['CompanyBranch'])) {
            foreach ($_POST['CompanyBranch'] as $i => $item) {
                if (isset($company->branchDetails[$i]))
                    $company->branchDetails[$i]->attributes = $item;
                else {
                    $detail = new CompanyBranch();
                    $detail->attributes = $item;
                    $company->branchDetails[] = $detail;
                }
            }
            if (count($_POST['CompanyBranch']) < count($company->branchDetails))
                array_splice($company->branchDetails, $i + 1);
        } else
            $company->branchDetails = array();


        if (isset($_POST['CompanyBank'])) {
            foreach ($_POST['CompanyBank'] as $i => $item) {
                if (isset($company->bankDetails[$i]))
                    $company->bankDetails[$i]->attributes = $item;
                else {
                    $detail = new CompanyBank();
                    $detail->attributes = $item;
                    $company->bankDetails[] = $detail;
                }
            }
            if (count($_POST['CompanyBank']) < count($company->bankDetails))
                array_splice($company->bankDetails, $i + 1);
        } else
            $company->bankDetails = array();
    }

    public function loadModel($id) {
        $model = Company::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Company $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'company-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
