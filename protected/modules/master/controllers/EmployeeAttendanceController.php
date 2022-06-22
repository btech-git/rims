<?php

class EmployeeAttendanceController extends Controller {

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
        if ($filterChain->action->id === 'create' ) {
            if (!(Yii::app()->user->checkAccess('masterEmployeeCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'restore' || 
            $filterChain->action->id === 'edit' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete'
        ) {
            if (!(Yii::app()->user->checkAccess('masterEmployeeEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'updateBank' || 
            $filterChain->action->id === 'updateDeduction' || 
            $filterChain->action->id === 'updateIncentive'
        ) {
            if (!(Yii::app()->user->checkAccess('masterEmployeeCreate')) || !(Yii::app()->user->checkAccess('masterEmployeeEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
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
        $model = new EmployeeAttendance;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['EmployeeAttendance'])) {
            $model->attributes = $_POST['EmployeeAttendance'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['EmployeeAttendance'])) {
            $model->attributes = $_POST['EmployeeAttendance'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
        //$dataProvider=new CActiveDataProvider('EmployeeAttendance');
        //$attendances = EmployeeAttendance::model()->findAllbyAttributes(array('user_id'=>Yii::app()->user->id));

        $attendance = new EmployeeAttendance('search');
        $attendance->unsetAttributes();  // clear any default values
        if (isset($_GET['EmployeeAttendance']))
            $attendance->attributes = $_GET['EmployeeAttendance'];

        $attendanceCriteria = new CDbCriteria;
        $attendanceCriteria->addCondition("user_id = " . Yii::app()->user->id);
        // $attendanceCriteria->compare('code',$coa->code.'%',true,'AND', false);
        // $attendanceCriteria->compare('name',$coa->name,true);


        $dataProvider = new CActiveDataProvider('EmployeeAttendance', array(
            'criteria' => $attendanceCriteria,
            'pagination' => array('pageSize' => 31),
        ));
        $this->render('index', array(
            'attendance' => $attendance,
            'dataProvider' => $dataProvider,
                //'attendances'=>$attendances,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new EmployeeAttendance('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['EmployeeAttendance']))
            $model->attributes = $_GET['EmployeeAttendance'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return EmployeeAttendance the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = EmployeeAttendance::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param EmployeeAttendance $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-attendance-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSaveData() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['model_id'];
            $notes = $_POST['notes'];

            $updateAttendance = $this->loadModel($id);
            $updateAttendance->notes = $notes;
            $updateAttendance->save(false);

            var_dump($updateAttendance);
        }
    }

    public function actionAttendance() {
        $this->pageTitle = "RIMS - Absency";

        $year = (isset($_GET['year'])) ? $_GET['year'] : date('Y');
        $month = (isset($_GET['month'])) ? $_GET['month'] : date('n');
        $branch = (isset($_GET['branch'])) ? $_GET['branch'] : '';
        $division = (isset($_GET['division'])) ? $_GET['division'] : '';
        $position = (isset($_GET['position'])) ? $_GET['position'] : '';
        $level = (isset($_GET['level'])) ? $_GET['level'] : '';
        $type = (isset($_GET['type'])) ? $_GET['type'] : ' ';

        $criteria = new CDbCriteria;
        $criteria->addCondition("YEAR(date) = " . $year);
        if ($type == "Monthly") {
            $criteria->addCondition("MONTH(date) = " . $month);
        }
        $attendances = EmployeeAttendance::model()->findAll($criteria);

        // if ($branch!="") {
        // 	$criteria->addCondition("branch_id = ".$branch);
        // }
        if (isset($_GET['SaveExcel']))
            $this->getXlAttendance($year, $month, $type, $branch);

        $this->render('attendances', array(
            // 'dataProvider'=>$dataProvider,
            //'jurnals'=>$jurnals,
            // 'tanggal_mulai'=>$tanggal_mulai,
            // 'tanggal_sampai'=>$tanggal_sampai,
            'attendances' => $attendances,
            'branch' => $branch,
            'division' => $division,
            'position' => $position,
            'level' => $level,
            'year' => $year,
            'month' => $month,
            'type' => $type,
                // 'customer_id'=>$customer_id,
                // 'customer_name'=>$customer_name,
                // 'customerType'=>$customerType,
                // 'serviceType'=>$serviceType,
                // 'paymentType'=>$paymentType,
                // 'customer'=>$customer,
                // 'customerDataProvider'=>$customerDataProvider,
        ));
    }

    public function actionSalary() {
        $this->pageTitle = "RIMS - Salary";

        $year = (isset($_GET['year'])) ? $_GET['year'] : date('Y');
        $month = (isset($_GET['month'])) ? $_GET['month'] : date('n');
        $branch = (isset($_GET['branch'])) ? $_GET['branch'] : '';
        $division = (isset($_GET['division'])) ? $_GET['division'] : '';
        $position = (isset($_GET['position'])) ? $_GET['position'] : '';
        $level = (isset($_GET['level'])) ? $_GET['level'] : '';
        $type = (isset($_GET['type'])) ? $_GET['type'] : 'All';

        //       $criteria = new CDbCriteria;
        // $criteria->addCondition("YEAR(date) = ".$year);
        // if($type == "Monthly"){
        // 	$criteria->addCondition("MONTH(date) = ".$month);
        // }
        // $attendances = EmployeeAttendance::model()->findAll($criteria);
        // if ($branch!="") {
        // 	$criteria->addCondition("branch_id = ".$branch);
        // }

        if (isset($_GET['SaveExcel']))
            $this->getXlSalary($year, $month, $type, $branch);
        $this->render('salary', array(
            // 'dataProvider'=>$dataProvider,
            //'jurnals'=>$jurnals,
            // 'tanggal_mulai'=>$tanggal_mulai,
            // 'tanggal_sampai'=>$tanggal_sampai,
            //'attendances'=>$attendances,

            'branch' => $branch,
            'division' => $division,
            'position' => $position,
            'level' => $level,
            'year' => $year,
            'month' => $month,
            'type' => $type,
                // 'customer_id'=>$customer_id,
                // 'customer_name'=>$customer_name,
                // 'customerType'=>$customerType,
                // 'serviceType'=>$serviceType,
                // 'paymentType'=>$paymentType,
                // 'customer'=>$customer,
                // 'customerDataProvider'=>$customerDataProvider,
        ));
    }

    public function getXlAttendance($year, $month, $type, $branch) {

        // var_dump($customer); die();

        switch ($month) {
            case '1':
                $bulan = "Januari";
                break;
            case '2':
                $bulan = "Februari";
                break;
            case '3':
                $bulan = "Maret";
                break;
            case '4':
                $bulan = "April";
                break;
            case '5':
                $bulan = "Mei";
                break;
            case '6':
                $bulan = "Juni";
                break;
            case '7':
                $bulan = "Juli";
                break;
            case '8':
                $bulan = "Agustus";
                break;
            case '9':
                $bulan = "September";
                break;
            case '10':
                $bulan = "Oktober";
                break;
            case '11':
                $bulan = "Nopember";
                break;

            default:
                $bulan = "Desember";
                break;
        }

        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
                ->setLastModifiedBy("RIMS")
                ->setTitle("Absency report " . date('d-m-Y'))
                ->setSubject("Absency Report")
                ->setDescription("Export Data Absency Report.")
                ->setKeywords("Absency Report")
                ->setCategory("Export Absency");

        // style for horizontal vertical center
        $styleHorizontalVertivalCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleHorizontalVertivalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleLeftVertivalCenterBold = array(
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
                ->setCellValue('A1', 'PT RATU PERDANA INDAH JAYA')
                ->setCellValue('A2', 'ABSENCY')
                ->setCellValue('A3', 'BULAN ' . $bulan)
                ->setCellValue('A5', 'NAMA')
                ->setCellValue('B5', 'OFF DAY')
                ->setCellValue('C5', 'MASUK')
                ->setCellValue('D5', 'IZIN')
                ->setCellValue('E5', 'ALPHA')
                ->setCellValue('F5', 'OVERTIME');

        // ->setCellValue('L2', 'Historical');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:F2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:F3');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E7:F7');
        //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:D2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:G2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:H3');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I2:K2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L2:L3');

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('A1:J1')->applyFromArray($styleLeftVertivalCenterBold);
        $sheet->getStyle('A2:J2')->applyFromArray($styleLeftVertivalCenterBold);
        $sheet->getStyle('A3:J3')->applyFromArray($styleLeftVertivalCenterBold);

        // $sheet->getStyle('I2:K2')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('L2:L3')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('H2:H3')->applyFromArray($styleVerticalCenter);
        $sheet->getStyle('A5:I5')->applyFromArray($styleBold);

        // $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);



        // $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
        //$objPHPExcel->getActiveSheet()->freezePane('E4');

        $startrow = 6;
        $criteria = new CDbCriteria;
        if ($type != "")
            $criteria->addCondition("salary_type = '" . $type . "'");
        $employees = Employee::model()->findAll($criteria);

        foreach ($employees as $key => $employee) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $startrow, $employee->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $startrow, $employee->off_day);
            $masukCriteria = new CDbCriteria;
            $masukCriteria->addCondition("YEAR(date) = " . $year);
            $masukCriteria->addCondition("Month(date) = " . $month);
            $masukCriteria->addCondition("employee_id = " . $employee->id);
            $masukCriteria->addCondition("login_time != '00:00:00'");
            $masukCriteria->addCondition("notes = ' ' OR notes = 'No Overtime'");
            $countMasuk = count(EmployeeAttendance::model()->findAll($masukCriteria));

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $startrow, $countMasuk);

            $izinCriteria = new CDbCriteria;
            $izinCriteria->addCondition("YEAR(date) = " . $year);
            $izinCriteria->addCondition("Month(date) = " . $month);
            $izinCriteria->addCondition("employee_id = " . $employee->id);
            $izinCriteria->addCondition("notes = 'Izin'");
            $countIzin = count(EmployeeAttendance::model()->findAll($izinCriteria));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $startrow, $countIzin);

            $alphaCriteria = new CDbCriteria;
            $alphaCriteria->addCondition("YEAR(date) = " . $year);
            $alphaCriteria->addCondition("Month(date) = " . $month);
            $alphaCriteria->addCondition("employee_id = " . $employee->id);
            $alphaCriteria->addCondition("notes = 'Alpha'");
            $countAlpha = count(EmployeeAttendance::model()->findAll($alphaCriteria));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $startrow, $countAlpha);

            $overtimeCriteria = new CDbCriteria;
            $overtimeCriteria->addCondition("YEAR(date) = " . $year);
            $overtimeCriteria->addCondition("Month(date) = " . $month);
            $overtimeCriteria->addCondition("employee_id = " . $employee->id);
            $overtimeCriteria->addCondition("notes = 'Overtime'");
            $countOvertime = count(EmployeeAttendance::model()->findAll($overtimeCriteria));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $startrow, $countOvertime);

            $objPHPExcel->getActiveSheet()
                    ->getStyle('C' . $startrow)
                    ->getNumberFormat()
                    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

            $startrow++;
        }

        // die();
        $objCommentRichText = $objPHPExcel->getActiveSheet(0)->getComment('E5')->getText()->createTextRun('My first comment :)');
        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('ABSENCY');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0);

        // Save a xls file
        $filename = 'rims_absency_' . $month . '_' . date("Y-m-d");
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

    public function getXlSalary($year, $month, $type, $branch) {

        // var_dump($customer); die();

        switch ($month) {
            case '1':
                $bulan = "Januari";
                break;
            case '2':
                $bulan = "Februari";
                break;
            case '3':
                $bulan = "Maret";
                break;
            case '4':
                $bulan = "April";
                break;
            case '5':
                $bulan = "Mei";
                break;
            case '6':
                $bulan = "Juni";
                break;
            case '7':
                $bulan = "Juli";
                break;
            case '8':
                $bulan = "Agustus";
                break;
            case '9':
                $bulan = "September";
                break;
            case '10':
                $bulan = "Oktober";
                break;
            case '11':
                $bulan = "Nopember";
                break;

            default:
                $bulan = "Desember";
                break;
        }

        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
                ->setLastModifiedBy("RIMS")
                ->setTitle("Salary report " . date('d-m-Y'))
                ->setSubject("Salary Report")
                ->setDescription("Export Data Salary Report.")
                ->setKeywords("Salary Report")
                ->setCategory("Export Salary");

        // style for horizontal vertical center
        $styleHorizontalVertivalCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleHorizontalVertivalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleLeftVertivalCenterBold = array(
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
                ->setCellValue('A1', 'PT RATU PERDANA INDAH JAYA')
                ->setCellValue('A2', 'SALARY')
                ->setCellValue('A3', 'BULAN ' . $bulan)
                ->setCellValue('A5', 'NAMA')
                ->setCellValue('B5', 'SALARY TYPE')
                ->setCellValue('C5', 'TOTAL HARI MASUK')
                ->setCellValue('D5', 'TOTAL OVERTIME')
                ->setCellValue('E5', 'SALARY')
                ->setCellValue('F5', 'INCENTIVE')
                ->setCellValue('G5', 'DEDUCTION')
                ->setCellValue('H5', 'OVERTIME FEE')
                ->setCellValue('I5', 'TOTAL SALARY');

        // ->setCellValue('L2', 'Historical');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:I2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:I3');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E7:F7');
        //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:D2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:G2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:H3');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I2:K2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L2:L3');

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('A1:I1')->applyFromArray($styleLeftVertivalCenterBold);
        $sheet->getStyle('A2:I2')->applyFromArray($styleLeftVertivalCenterBold);
        $sheet->getStyle('A3:I3')->applyFromArray($styleLeftVertivalCenterBold);

        // $sheet->getStyle('I2:K2')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('L2:L3')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('H2:H3')->applyFromArray($styleVerticalCenter);
        $sheet->getStyle('A5:I5')->applyFromArray($styleBold);

        // $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);

        // $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        // $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
        //$objPHPExcel->getActiveSheet()->freezePane('E4');

        $startrow = 6;
        $criteria = new CDbCriteria;
        if ($type != "")
            $criteria->addCondition("salary_type = '" . $type . "'");
        $employees = Employee::model()->findAll($criteria);

        foreach ($employees as $key => $employee) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $startrow, $employee->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $startrow, $employee->salary_type);

            $masukCriteria = new CDbCriteria;
            $masukCriteria->addCondition("YEAR(date) = " . $year);
            $masukCriteria->addCondition("Month(date) = " . $month);
            $masukCriteria->addCondition("employee_id = " . $employee->id);
            $masukCriteria->addCondition("login_time != '00:00:00'");
            $masukCriteria->addCondition("notes = ' ' OR notes = 'No Overtime'");
            $countMasuk = count(EmployeeAttendance::model()->findAll($masukCriteria));

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $startrow, $countMasuk);

            $overtimeCriteria = new CDbCriteria;
            $overtimeCriteria->addCondition("YEAR(date) = " . $year);
            $overtimeCriteria->addCondition("Month(date) = " . $month);
            $overtimeCriteria->addCondition("employee_id = " . $employee->id);
            $overtimeCriteria->addCondition("notes = 'Overtime'");
            $countOvertime = count(EmployeeAttendance::model()->findAll($overtimeCriteria));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $startrow, $countOvertime);


            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $startrow, $employee->basic_salary);

            $totalIncentives = EmployeeIncentives::model()->findAllByAttributes(array('employee_id' => $employee->id));
            $totalIncentive = 0;
            foreach ($totalIncentives as $key => $incentive) {
                $totalIncentive += $incentive->amount;
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $startrow, $totalIncentive);
            $totalDeductions = EmployeeDeductions::model()->findAllByAttributes(array('employee_id' => $employee->id));
            $totalDeduction = 0;
            foreach ($totalDeductions as $key => $deduction) {
                $totalDeduction += $deduction->amount;
            }
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, $totalDeduction);
            if ($employee->salary_type == "Monthly") {
                $bs = $employee->basic_salary / 25;
            } elseif ($employee->salary_type == "Weekly") {
                $bs = $employee->basic_salary / 7;
            } elseif ($employee->salary_type == "Hourly") {
                $bs = $employee->basic_salary * 8;
            } else {
                $bs = $employee->basic_salary;
            }
            $ot = $countOvertime * $bs;
            $allOt = 1.5 * $ot;
            $totalSalary = $employee->basic_salary + $totalIncentive + $allOt - $totalDeduction;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow, $allOt);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $startrow, $totalSalary);
            $objPHPExcel->getActiveSheet()
                    ->getStyle('C' . $startrow)
                    ->getNumberFormat()
                    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

            $startrow++;
        }

        // die();
        $objCommentRichText = $objPHPExcel->getActiveSheet(0)->getComment('E5')->getText()->createTextRun('My first comment :)');
        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('SALARY');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0);

        // Save a xls file
        $filename = 'rims_salary_' . $month . '_' . date("Y-m-d");
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

}
