<?php

class CoaController extends Controller {

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
            if (!(Yii::app()->user->checkAccess('masterCoaCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'edit' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete'
        ) {
            if (!(Yii::app()->user->checkAccess('masterCoaEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'cutoOff' || 
            $filterChain->action->id === 'kertasKerja' || 
            $filterChain->action->id === 'viewCoa'
        ) {
            if (!(Yii::app()->user->checkAccess('masterCoaCreate')) || !(Yii::app()->user->checkAccess('masterCoaEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $coaDetails = JurnalUmum::model()->findAllByAttributes(array('coa_id' => $id));
        
        if (isset($_POST['Approve']) && (int) $model->is_approved !== 1) {
            $model->is_approved = 1;
            $model->date_approval = date('Y-m-d');
            
            if ($model->save(true, array('is_approved', 'date_approval'))) {
                Yii::app()->user->setFlash('confirm', 'Your data has been approved!!!');
            }
        } elseif (isset($_POST['Reject'])) {
            $model->is_approved = 2;
            
            if ($model->save(true, array('is_approved')))
                Yii::app()->user->setFlash('error', 'Your data has been rejected!!!');
        }

        $this->render('view', array(
            'model' => $model,
            'coaDetails' => $coaDetails,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewCoa() {
        //$coaDetails = CoaDetail::model()->findAllByAttributes(array('coa_id'=>$id));
        $this->render('viewCoa', array(
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Coa;
        $model->date = date('Y-m-d');
        $model->time_created = date('H:i:s');
        $model->date_approval = null;
        $model->time_approval = null;
        $model->status = 'Not Approved';
        $model->user_id = Yii::app()->user->id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Coa'])) {
            $model->attributes = $_POST['Coa'];
            $model->coa_category_id = $model->coaSubCategory->coa_category_id;
            $model->getCodeNumber($model->coa_sub_category_id, $model->coaSubCategory->code, $model->coaCategory->code);

            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Coa'])) {
            $model->attributes = $_POST['Coa'];
//            $model->coa_category_id = $model->coaSubCategory->coa_category_id;

            if ($model->save()) {
                $coaLog = new CoaLog();
                $coaLog->name = $model->name;
                $coaLog->code = $model->code;
                $coaLog->coa_category_id = $model->coa_category_id;
                $coaLog->coa_sub_category_id = $model->coa_sub_category_id;
                $coaLog->date_updated = date('Y-m-d');
                $coaLog->time_updated = date('H:i:s');
                $coaLog->user_updated_id = Yii::app()->user->id;
                $coaLog->coa_id = $model->id;
                $coaLog->save();
                
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
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
        $dataProvider = new CActiveDataProvider('Coa');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Coa('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $model->attributes = $_GET['Coa'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Coa the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Coa::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Coa $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'coa-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxHtmlSave() {
        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['Coa'])) {
                // var_dump($_POST['Level']); die("S");
                $isiID = $_POST['Coa']['id'];
                if (!empty($isiID)) {
                    $model = $this->loadModel($isiID);
                } else {
                    $model = new Coa;
                }
                $model->opening_balance = $_POST['Coa']['opening_balance'];
                $model->date = date('Y-m-d');
                if ($model->save()) {

                    $coaDetail = CoaDetail::model()->findByAttributes(array('coa_id' => $model->id, 'periode' => date('Y')));
                    if (count($coaDetail) == 0) {
                        $coaDetail = new CoaDetail;
                        $coaDetail->coa_id = $model->id;
                        $coaDetail->periode = date('Y');
                        $coaDetail->opening_balance = $model->opening_balance;
                        $coaDetail->closing_balance = 0;
                        $coaDetail->debit = 0;
                        $coaDetail->credit = 0;
                        $coaDetail->save();
                    }
                    echo CHtml::script('window.location.href = "' . Yii::app()->user->getReturnUrl(array('admin')) . '";');
                    Yii::app()->end();
                }
            }
        }
    }

    public function actionAjaxHtmlUpdate($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id);

            // if (isset($_POST['Level']))
            // {
            // 	$model->attributes = $_POST['Level'];
            // 	if ($model->save())
            // 	{
            // 		echo CHtml::script('window.location.href = "' . Yii::app()->user->getReturnUrl(array('admin')) . '";');
            // 		Yii::app()->end();
            // 	}
            // }

            $this->renderPartial('_update-dialog', array(
                'model' => $model,
                    ), false, true);
        }
    }

    public function actionAjaxGetCoaSubCategory() {
        $data = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $_POST['Coa']['coa_category_id']), array('order' => 'name ASC'));

        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Coa SubCategory--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Coa SubCategory--]', true);
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

    public function actionKertasKerja() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $this->pageTitle = "RIMS - Kertas Kerja";

        $tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : date('Y-m-d');
        $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : date('Y-m-d');
        $branch = (isset($_GET['branch'])) ? $_GET['branch'] : '';
        $company = (isset($_GET['company'])) ? $_GET['company'] : '';

        $criteria = new CDbCriteria;
        $criteria->addCondition("coa_id = 0");
        $showCoas = Coa::model()->findAll($criteria);

        $coa = new Coa('search');
        $coa->unsetAttributes();  // clear any default values

        if (isset($_GET['Coa']))
            $coa->attributes = $_GET['Coa'];

        $coaCriteria = new CDbCriteria;
        $coaCriteria->addCondition("coa_id = 0");
        $coaCriteria->compare('code', $coa->code . '%', true, 'AND', false);
        $coaCriteria->compare('name', $coa->name, true);

        $coaDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaCriteria,
        ));

        if (isset($_GET['SaveExcel']))
            $this->getXlsKartu($showCoas, $tanggal_mulai, $tanggal_sampai, $branch, $company);

        $dataProvider = new CActiveDataProvider('JurnalUmum');

        $this->render('kertasKerja', array(
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_sampai' => $tanggal_sampai,
            'showCoas' => $showCoas,
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
            'branch' => $branch,
            'company' => $company,
        ));
    }

    public function getXlsKartu($showCoas, $tanggal_mulai, $tanggal_sampai, $branch) {
        // $lastkode = "";
        // var_dump($customer); die();
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("BloomingTech")
                ->setLastModifiedBy("RIMS")
                ->setTitle("Kertas Kerja Data " . date('d-m-Y'))
                ->setSubject("Kertas Kerja")
                ->setDescription("Export Data Kertas Kerja.")
                ->setKeywords("Kertas Kerja Data")
                ->setCategory("Export Kertas Kerja");

        // style for horizontal vertical center
        $styleHorizontalVerticalCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleHorizontalVerticalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleLeftVerticalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleHorizontalCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $styleVerticalCenter = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $styleBold = array(
            'font' => array(
                'bold' => true,
            )
        );

        // style color red
        $styleColorRED = array(
            'font' => array(
                'color' => array('rgb' => 'FF0000'),
                'bold' => true,
            ),
                // 'fill' => array(
                //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //     'color' => array('rgb' => 'FF0000')
                // )
        );

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'PT RATU PERDANA INDAH JAYA')
                ->setCellValue('A3', 'KERTAS KERJA')
                ->setCellValue('A4', 'PERIODE (' . $tanggal_mulai . '-' . $tanggal_sampai . ')')
                ->setCellValue('A7', 'KODE AKUN')
                ->setCellValue('B7', 'NAMA AKUN')
                ->setCellValue('C7', 'SALDO AWAL')
                ->setCellValue('E7', 'MUTASI')
                ->setCellValue('G7', 'NERACA SALDO')
                ->setCellValue('I7', 'PENYESUAIAN')
                ->setCellValue('K7', 'NERACA SALDO SETELAH PENYESUAIAN')
                ->setCellValue('M7', 'LAPORAN LABA RUGI')
                ->setCellValue('O7', 'NERACA')
                ->setCellValue('C8', 'DEBIT')
                ->setCellValue('D8', 'KREDIT')
                ->setCellValue('E8', 'DEBIT')
                ->setCellValue('F8', 'KREDIT')
                ->setCellValue('G8', 'DEBIT')
                ->setCellValue('H8', 'KREDIT')
                ->setCellValue('I8', 'DEBIT')
                ->setCellValue('J8', 'KREDIT')
                ->setCellValue('K8', 'DEBIT')
                ->setCellValue('L8', 'KREDIT')
                ->setCellValue('M8', 'DEBIT')
                ->setCellValue('N8', 'KREDIT')
                ->setCellValue('O8', 'DEBIT')
                ->setCellValue('P8', 'KREDIT');


        // ->setCellValue('L2', 'Historical');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:N2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:N3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:N4');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:A8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B7:B8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C7:D7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E7:F7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G7:H7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I7:J7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K7:L7');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M7:N7');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E7:F7');
        //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:D2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:G2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:H3');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I2:K2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L2:L3');

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('A2:N2')->applyFromArray($styleHorizontalVerticalCenterBold);
        $sheet->getStyle('A3:N3')->applyFromArray($styleHorizontalVerticalCenterBold);
        $sheet->getStyle('A4:N4')->applyFromArray($styleHorizontalVerticalCenterBold);
        //$sheet->getStyle('H2:H3')->applyFromArray($styleVerticalCenter);
        // $sheet->getStyle('I2:K2')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('L2:L3')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('H2:H3')->applyFromArray($styleVerticalCenter);
        $sheet->getStyle('A7:N7')->applyFromArray($styleHorizontalVerticalCenterBold);
        $sheet->getStyle('A8:N8')->applyFromArray($styleHorizontalVerticalCenterBold);

        // $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(13);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);

        // $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
        $objPHPExcel->getActiveSheet()->freezePane('A9');
        $yesterday = date('Y-m-d', strtotime($tanggal_mulai . '-1 days'));
        //echo $yesterday; 
        $count = 0;
        $startrow = 9;
        $saldoAwalDebitTotal = $saldoAwalCreditTotal = $mutasiDebetTotal = $mutasiKreditTotal = $neracaDebitTotal = $neracaKreditTotal = $penyesuaianDebitTotal = $penyesuaianKreditTotal = $neracaPenyesuaianDebitTotal = $neracaPenyesuaianKreditTotal = $labaRugiDebitTotal = $labaRugiKreditTotal = $neracaSaldoDebitTotal = $neracaSaldoKreditTotal = 0;
        foreach ($showCoas as $key => $showCoa) {

            //$phone = ($value->customerPhones !=NULL)?$this->phoneNumber($value->customerPhones):'';
            //$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$startrow, $val,PHPExcel_Cell_DataType::TYPE_STRING);
            // $objPHPExcel->getActiveSheet()
            //     ->getStyle('A'.$startrow)
            //     ->getNumberFormat()
            //     ->setFormatCode(
            //         PHPExcel_Style_NumberFormat::FORMAT_TEXT
            //     );

            $JurnalCriteria = new CDbCriteria;
            $JurnalCriteria->addCondition("coa_id = " . $showCoa->id);
            // if ($company!= "") {
            // 	$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
            // 	$arrBranch = array();
            // 	foreach ($branches as $key => $branchId) {
            // 		$arrBranch[] = $branchId->id;
            // 	}
            // 	if ($branch != "") {
            // 		$JurnalCriteria->addCondition("branch_id = ".$branch);
            // 	}
            // 	else{
            // 		$JurnalCriteria->addInCondition('branch_id',$arrBranch);
            // 							// }
            // else{
            // 	if ($branch != "") {
            // 		$JurnalCriteria->addCondition("branch_id = ".$branch);
            // 	}
            // }

            $JurnalCriteria->addBetweenCondition('tanggal_transaksi', $showCoa->date, $tanggal_mulai);
            $allJurnals = JurnalUmum::model()->findAll($JurnalCriteria);
            //echo $yesterday;
            $debitTotal = $creditTotal = 0;
            foreach ($allJurnals as $key => $allJurnal) {
                if ($allJurnal->debet_kredit == "D")
                    $debitTotal += $allJurnal->total;
                else
                    $creditTotal += $allJurnal->total;
            }
            if ($showCoa->normal_balance == "DEBET") {
                $count = $count + $debitTotal - $creditTotal;
            } else {
                $count = $count + $creditTotal - $debitTotal;
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $startrow, $showCoa->code);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $startrow, $showCoa->name);
            $saldoAwalDebit = $showCoa->normal_balance == 'DEBET' ? $count : 0;
            $saldoAwalCredit = $showCoa->normal_balance == 'KREDIT' ? $count : 0;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $startrow, $saldoAwalDebit == 0 ? $saldoAwalDebit : '-');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $startrow, $saldoAwalCredit == 0 ? $saldoAwalCredit : '-');
            //$customertype = (($value->customer_type == 'Individual')?"P":(($value->customer_type == 'Company')?"K":""));

            $criteria = new CDbCriteria;
            $criteria->together = true;
            $criteria->with = array('coa');
            $criteria->addCondition("coa.coa_id = " . $showCoa->id);
            if ($branch != "")
                $criteria->addCondition("t.branch_id = " . $branch);
            $criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
            $jurnals = JurnalUmum::model()->findAll($criteria);
            $mutasiDebet = $mutasiKredit = 0;
            foreach ($jurnals as $key => $jurnal) {
                $mutasiDebet += $jurnal->debet_kredit == "D" ? $jurnal->total : 0;
                $mutasiKredit += $jurnal->debet_kredit == "K" ? $jurnal->total : 0;
                //$neracaSaldoDebit = $showCoa->normal_balance == 'D'? $count + $mutasiDebet - $mutasiKredit : 0;
                //$neracaSaldoCredit = $showCoa->normal_balance == 'K'? $count + $showCoa->credit - $showCoa->debit:0;
            }
            $neracaSaldoDebit = $showCoa->normal_balance == 'DEBET' ? $count + $mutasiDebet - $mutasiKredit : 0;
            $neracaSaldoCredit = $showCoa->normal_balance == 'KREDIT' ? $count + $mutasiKredit - $mutasiDebet : 0;
            $penyesuaianDebit = ($showCoa->coa_sub_category_id == 11 || $showCoa->coa_sub_category_id == 43 ? ($showCoa->normal_balance == 'DEBET' ? $mutasiDebet : 0) : 0);
            $penyesuaianCredit = ($showCoa->coa_sub_category_id == 11 || $showCoa->coa_sub_category_id == 43 ? ($showCoa->normal_balance == 'KREDIT' ? $mutasiKredit : 0) : 0);
            $neracaSetelahPenyesuaianDebit = $neracaSaldoDebit - $penyesuaianDebit;
            $neracaSetelahPenyesuaianCredit = $neracaSaldoCredit - $penyesuaianCredit;
            $labaRugiDebit = ($showCoa->coa_category_id == 7 || $showCoa->coa_category_id == 8 ? ($showCoa->normal_balance == 'DEBET' ? $mutasiDebet : 0) : 0);
            $labaRugiCredit = ($showCoa->coa_category_id == 7 || $showCoa->coa_category_id == 8 ? ($showCoa->normal_balance == 'KREDIT' ? $mutasiDebet : 0) : 0);
            $neracaDebit = ($showCoa->coa_category_id == 1 || $showCoa->coa_category_id == 2 || $showCoa->coa_category_id == 3 || $showCoa->coa_category_id == 4 || $showCoa->coa_category_id == 5 || $showCoa->coa_category_id == 6 ? ($showCoa->normal_balance == 'DEBET' ? $neracaSetelahPenyesuaianDebit : 0) : 0);
            $neracaCredit = ($showCoa->coa_category_id == 1 || $showCoa->coa_category_id == 2 || $showCoa->coa_category_id == 3 || $showCoa->coa_category_id == 4 || $showCoa->coa_category_id == 5 || $showCoa->coa_category_id == 6 ? ($showCoa->normal_balance == 'KREDIT' ? $neracaSetelahPenyesuaianCredit : 0) : 0);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $startrow, $mutasiDebet == "" ? '-' : $mutasiDebet);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $startrow, $mutasiKredit == "" ? '-' : $mutasiKredit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, $neracaSaldoDebit == 0 ? '-' : $neracaSaldoDebit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow, $neracaSaldoCredit == 0 ? '-' : $neracaSaldoCredit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $startrow, $penyesuaianDebit == 0 ? '-' : $penyesuaianDebit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $startrow, $penyesuaianCredit == 0 ? '-' : $penyesuaianCredit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $startrow, $neracaSetelahPenyesuaianDebit == 0 ? '-' : $neracaSetelahPenyesuaianDebit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $startrow, $neracaSetelahPenyesuaianCredit == 0 ? '-' : $neracaSetelahPenyesuaianCredit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $startrow, $labaRugiDebit == 0 ? '-' : $labaRugiDebit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $startrow, $labaRugiCredit == 0 ? '-' : $labaRugiCredit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $startrow, $neracaDebit == 0 ? '-' : $neracaDebit);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $startrow, $neracaCredit == 0 ? '-' : $neracaCredit);

            $startrow++;
            $saldoAwalDebitTotal += $saldoAwalDebit;
            $saldoAwalCreditTotal += $saldoAwalCredit;
            $mutasiDebetTotal += $mutasiDebet;
            $mutasiKreditTotal += $mutasiKredit;
            $neracaDebitTotal += $neracaDebit;
            $neracaKreditTotal += $neracaCredit;
            $penyesuaianDebitTotal += $penyesuaianDebit;
            $penyesuaianKreditTotal += $penyesuaianCredit;
            $neracaPenyesuaianDebitTotal += $neracaSetelahPenyesuaianDebit;
            $neracaPenyesuaianKreditTotal += $neracaSetelahPenyesuaianCredit;
            $labaRugiDebitTotal += $labaRugiDebit;
            $labaRugiKreditTotal += $labaRugiCredit;
            $neracaSaldoDebitTotal += $neracaSaldoDebit;
            $neracaSaldoKreditTotal += $neracaSaldoCredit;
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $startrow, 'Total');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $startrow, $saldoAwalDebitTotal == 0 ? $saldoAwalDebitTotal : '-');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $startrow, $saldoAwalCreditTotal == 0 ? $saldoAwalCreditTotal : '-');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $startrow, $mutasiDebetTotal == "" ? '-' : $mutasiDebetTotal);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $startrow, $mutasiKreditTotal == "" ? '-' : $mutasiKreditTotal);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, $neracaSaldoDebitTotal == 0 ? '-' : $neracaSaldoDebitTotal);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow, $neracaSaldoKreditTotal == 0 ? '-' : $neracaSaldoKreditTotal);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $startrow, $penyesuaianDebitTotal == 0 ? '-' : $penyesuaianDebitTotal);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $startrow, $penyesuaianKreditTotal == 0 ? '-' : $penyesuaianKreditTotal);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $startrow, $neracaPenyesuaianDebitTotal == 0 ? '-' : $neracaPenyesuaianDebitTotal);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $startrow, $neracaPenyesuaianKreditTotal == 0 ? '-' : $neracaPenyesuaianKreditTotal);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $startrow, $labaRugiDebitTotal == 0 ? '-' : $labaRugiDebitTotal);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $startrow, $labaRugiKreditTotal == 0 ? '-' : $labaRugiKreditTotal);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $startrow, $neracaDebitTotal == 0 ? '-' : $neracaDebitTotal);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . $startrow, $neracaKreditTotal == 0 ? '-' : $neracaKreditTotal);



        $netlossDebit = 0;
        $netlossCredit = $labaRugiDebitTotal - $labaRugiKreditTotal;
        $netlossNeracaDebit = $neracaKreditTotal - $neracaDebitTotal;
        $netlossNeracaCredit = 0;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . ($startrow + 1), 'Netloss');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . ($startrow + 1), $netlossDebit == 0 ? '-' : $netlossDebit);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . ($startrow + 1), $netlossCredit == 0 ? '-' : $netlossCredit);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . ($startrow + 1), $netlossNeracaDebit == 0 ? '-' : $netlossNeracaDebit);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . ($startrow + 1), $netlossNeracaCredit == 0 ? '-' : $netlossNeracaCredit);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . ($startrow + 2), '-');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . ($startrow + 2), $labaRugiDebitTotal + $netlossDebit);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . ($startrow + 2), $labaRugiKreditTotal + $netlossCredit);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . ($startrow + 2), $neracaDebitTotal + $netlossNeracaDebit);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P' . ($startrow + 2), $neracaKreditTotal + $netlossNeracaCredit);
        // die();
        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('KERTAS KERJA');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0);

        // Save a xls file
        $filename = 'kertas_kerja_data_' . date("Y-m-d");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
    }

    public function actionCutOff() {
        $coaAll = Coa::model()->findAll();
        $closing = 0;
        foreach ($coaAll as $key => $coa) {
            $debitAmount = $creditAmount = 0;
            $jurnalUmums = JurnalUmum::model()->findAllByAttributes(array('coa_id' => $coa->id));
            foreach ($jurnalUmums as $key => $jurnal) {
                if ($jurnal->debet_kredit == 'D')
                    $debitAmount += $jurnal->total;
                else
                    $creditAmount += $jurnal->total;
            }

            if ($coa->coa_id != 0) {
                //$coaDetailCriteria = new CDbCriteria;
                //$coaDetailCriteria->addCondition("coa_id = ".$coa->id);
                //$coaDetailCriteria->addCondition("coa_id != ".$coa->coa_id);
                //$coaDetailCriteria->addCondition("periode = ".date('Y'));
                //$coaDetail = CoaDetail::model()->find($coaDetailCriteria);
                $coaDetail = CoaDetail::model()->findByAttributes(array('coa_id' => $coa->id, 'periode' => date('Y')));
                if (count($coaDetail) != 0) {
                    if ($coaDetail->coa_id != $coa->coa_id) {
                        if ($coa->normal_balance == 'DEBET') {
                            $closing = $coaDetail->opening_balance + $debitAmount - $creditAmount;
                        } else {
                            $closing = $coaDetail->opening_balance + $creditAmount - $debitAmount;
                        }
                        $coaDetail->closing_balance = $closing;
                        $coaDetail->debit = $debitAmount;
                        $coaDetail->credit = $creditAmount;
                        $coaDetail->save();
                    }

                    // $coaHeaderCriteria = new CDbCriteria;
                    // $coaHeaderCriteria->addCondition("coa_id != $coa_id")
                    $coaHeader = CoaDetail::model()->findByAttributes(array('coa_id' => $coa->coa_id, 'periode' => date('Y')));
                    if (count($coaHeader) != 0) {
                        $coaHeader->debit += $coaDetail->debit;
                        $coaHeader->credit += $coaDetail->credit;
                        $coaHeader->closing_balance += $coaDetail->closing_balance;
                        $coaHeader->save();
                    }
                }
            }
        }
    }

    public function actionAjaxGetBranch() {


        $data = Branch::model()->findAllByAttributes(array('company_id' => $_POST['company']));

        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '-- All Branch --', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            $data = Branch::model()->findAll();
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
            echo CHtml::tag('option', array('value' => ''), '-- All Branch --', true);
        }
    }

}
