<?php

class EmployeeScheduleController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
//            'accessControl', // perform access control for CRUD operations
//            'postOnly + delete', // we only allow deletion via POST request
        );
    }

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
                'users' => array('admin'),
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
    public function actionGenerate() {
        
        $model = new Employee('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Employee'])) {
            $model->attributes = $_GET['Employee'];
        }
        
        $dataProvider = $model->search();
        $dataProvider->criteria->addCondition("t.status = 'Active'");

        if (isset($_POST['Submit'])) {
            $valid = true;
            
            $lastEmployeeSchedule = EmployeeSchedule::model()->find(array('condition' => 't.working_date IS NOT NULL', 'order' => 't.id DESC'));
            
            $dayNumbers = array_flip(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'));
            $lastWorkingDate = $lastEmployeeSchedule === null ? date('Y-m-d') : $lastEmployeeSchedule->working_date;
            $lastWorkingDay = date('D', strtotime($lastWorkingDate));
            $nextDateDifference = $dayNumbers['Mon'] + ($dayNumbers['Mon'] < $dayNumbers[$lastWorkingDay] ? 7 : 0) - $dayNumbers[$lastWorkingDay];
            $firstDate = date('Y-m-d', strtotime($lastWorkingDate . " + {$nextDateDifference} days"));
            
            $dayToDayNames = array('Minggu' => 'Sun', 'Senin' => 'Mon', 'Selasa' => 'Tue', 'Rabu' => 'Wed', 'Kamis' => 'Thu', 'Jumat' => 'Fri', 'Sabtu' => 'Sat');

            $employees = Employee::model()->findAllByAttributes(array('status' => 'Active'));

            $dbTransaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($employees as $employee) {
                    $offDayName = $dayToDayNames[$employee->off_day];
                    for ($i = 0; $i < 7; $i++) {
                        $currentDay = date('D', strtotime($firstDate . " + {$i} days"));
                        if ($currentDay !== $offDayName) {
                            $currentDate = date('Y-m-d', strtotime($firstDate . " + {$i} days"));

                            $model = new EmployeeSchedule;
                            $model->employee_id = $employee->id;
                            $model->branch_id = $employee->branch_id;
                            $model->working_date = $currentDate;

                            $valid = $valid && $model->save(false);
                        }
                    }
                }
                            
                if ($valid) {
                    $dbTransaction->commit();
                } else {
                    $dbTransaction->rollback();
                }
            } catch (Exception $e) {
                $dbTransaction->rollback();
                $valid = false;
            }
            
            if ($valid) {
                $this->redirect(array('index'));
            }
        }

        $this->render('generate', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionIndex() {

        $currentDate = date('Y-m-d');
        
        $employeeSchedules = EmployeeSchedule::model()->findAll(array(
            'condition' => 't.working_date BETWEEN :start_date AND :end_date', 
            'params' => array(':start_date' => $currentDate, ':end_date' => date('Y-m-d', strtotime($currentDate . " + 6 days"))),
            'order' => 't.id ASC',
        ));
        
        $branches = Branch::model()->findAll();
        
        $employeeScheduleData = array();
        foreach ($employeeSchedules as $employeeSchedule) {
            if (!isset($employeeScheduleData[$employeeSchedule->working_date][$employeeSchedule->branch_id])) {
                $employeeScheduleData[$employeeSchedule->working_date][$employeeSchedule->branch_id] = array();
            }
            $employeeScheduleData[$employeeSchedule->working_date][$employeeSchedule->branch_id][] = $employeeSchedule->employee->name;
        }

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($employeeScheduleData, $branches, $currentDate);
        }

        $this->render('index', array(
            'employeeScheduleData' => $employeeScheduleData,
            'branches' => $branches,
            'currentDate' => $currentDate,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new EmployeeSchedule('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['EmployeeSchedule']))
            $model->attributes = $_GET['EmployeeSchedule'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return EmployeeSchedule the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = EmployeeSchedule::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param EmployeeSchedule $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-schedule-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function saveToExcel($employeeScheduleData, $branches, $currentDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Jadwal Karyawan Mingguan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Jadwal Karyawan Mingguan');

        $worksheet->mergeCells('A1:I1');
        $worksheet->mergeCells('A2:I2');

        $worksheet->getStyle('A1:I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:I5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Jadwal Karyawan Mingguan');

        $columnCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnCounter}5", CHtml::value($branch, 'code'));
            $columnCounter++;
        }

        $worksheet->getStyle("A5:{$columnCounter}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:{$columnCounter}5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        for ($i = 0; $i < 7; $i++) {
            $columnCounter = 'B';
            $date = date('Y-m-d', strtotime($currentDate . " + {$i} days")); 

            $worksheet->setCellValue("A{$counter}", date('D, d M Y', strtotime($date)));
            foreach ($branches as $branch) {
                if (isset($employeeScheduleData[$date][$branch->id])) {
                    $employeeNames = implode("\r\n", $employeeScheduleData[$date][$branch->id]);
                    $worksheet->setCellValue("{$columnCounter}{$counter}", $employeeNames);
                }
                
                $columnCounter++;
            }
            
            $counter++;
        }
        
        for ($j = 7; $j < $counter; $j++) {
            $objPHPExcel->getActiveSheet()
                ->getRowDimension($j)
                ->setRowHeight(256);
        }
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="jadwal_karyawan_mingguan.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
