<?php

class ForecastingController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
    public $defaultAction = 'test';

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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('Admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Forecasting;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Forecasting']))
		{
			$model->attributes=$_POST['Forecasting'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionPriode() {

		$begin = new DateTime( '2017-02-01' );
		$end = new DateTime( '2017-08-31' );
		$end = $end->modify( '+1 day' ); 

		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);

		// var_dump($daterange); die("S");
		foreach($daterange as $date){
			// var_dump($date); die("S");
			echo $date->format("m"); 
		    echo $date->format("Ymd") . "<br>";
		}
	}

	public function actionCheck()
	{
		// $forecastingBank = ForecastingBank::model()->findAll();
		/* id bank
			3 	BCA HUFADHA | 5 	BCA PD	| 7 	BCA PT	| 10 	CIMB NIAGA | 14 	Mandiri KMK | 17 	MANDIRI TBM
		*/

		$listbank=new ForecastingComponents();

		$criteria = new CDbCriteria;
		$criteria->addInCondition('id', array(23)); 
		// $criteria->limit=3;
		// $forecastingBank = ForecastingBank::model()->findAll($criteria);
		$forecastingBank = Coa::model()->findAll($criteria);
		$priodeStep = 1;
		$priodeStart= date('Y-02-01');
		$dateStart  = substr($priodeStart,-2); 
		// $priodeStart = (isset($_GET['Forecasting']['payment_date'])?$_GET['Forecasting']['payment_date']:date('Y-m-d'));
		$priodeEnd	= date('Y-m-01', strtotime('+'.$priodeStep.' months'));
		// $priodeEnd2	= date('m', strtotime('+'.$priodeStep.' months'));
		// var_dump($priodeStep . $priodeStart .$priodeEnd . $priodeEnd2);die();

		$begin = new DateTime($priodeStart);
		$end = new DateTime($priodeEnd);
		// var_dump($end); die();
		// $end = $end->modify( '+1 day' ); 
		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);

		foreach ($daterange as $key => $date) {
			echo $date->format("d")."=>";
			foreach ($forecastingBank as $key => $value) {
				echo $value->id ." | ";
				$bankid = Forecasting::model()->getCoaBank($value->id);
				echo array_sum(Forecasting::model()->getValue('amount',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid)));
			}
			echo '<br />';

		}
	}
	public function actionTest()
	{
		// $forecastingBank = ForecastingBank::model()->findAll();
		/* id bank
			3 	BCA HUFADHA | 5 	BCA PD	| 7 	BCA PT	| 10 	CIMB NIAGA | 14 	Mandiri KMK | 17 	MANDIRI TBM
		*/

		$listbank=new ForecastingComponents();

		$criteria = new CDbCriteria;
		$criteria->addInCondition('id', $listbank->getListbank()); 
		// $criteria->limit=3;
		// $forecastingBank = ForecastingBank::model()->findAll($criteria);
		$forecastingBank = Coa::model()->findAll($criteria);
		$model=new Forecasting;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Forecasting']))
		{
			$model->attributes=$_POST['Forecasting'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$priodeStep = (isset($_GET['Forecasting']['priode']) ? $_GET['Forecasting']['priode']:0);
		$priodeStart= (isset($_GET['Forecasting']['payment_date'])?$_GET['Forecasting']['payment_date']:date('Y-m-01'));
		$dateStart  = substr($priodeStart,-2); 
		// $priodeStart = (isset($_GET['Forecasting']['payment_date'])?$_GET['Forecasting']['payment_date']:date('Y-m-d'));
		$priodeEnd	= date('Y-m-01', strtotime('+'.$priodeStep.' months'));
		// $priodeEnd2	= date('m', strtotime('+'.$priodeStep.' months'));
		// var_dump($priodeStep . $priodeStart .$priodeEnd . $priodeEnd2);die();

		$begin = new DateTime($priodeStart);
		$end = new DateTime($priodeEnd);
		// var_dump($end); die();
		// $end = $end->modify( '+1 day' ); 
		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);

		// setting saldo awal berdasarkan bank//
		// $saldo_awal = [];
		// foreach ($forecastingBank as $key => $value) {
		// 	$bankid = Forecasting::model()->getCoaBank($value->id);
		// 	$saldo_awal[$bankid] = Forecasting::model()->getSaldoAwal($bankid,'2017-04-01');
		// }
		// var_dump($saldo_awal); die();
		// foreach($daterange as $key => $date){
		// 	if ($date->format("d") == '01') {
		// 		echo "tgl". $date->format("Y-m-d"); 
		// 		// foreach ($forecastingBank as $key => $value) {
		// 			// $bankid = Forecasting::model()->getCoaBank($value->id);
		// 		echo $saldo_awal = Forecasting::model()->getSaldoAwal(5,$date->format("Y-m-01"));
		// 		// }
		// 		echo "<br />";
		// 	}
		// }

		// die();
		// $lastmonth = date('2016-12-01'); 
		// $resource_cnt = Forecasting::model()->findAll(array(
		//   'select'=>'id,bank_id,payment_date, SUM(amount) as amt',
		//   'condition'=>'bank_id=:bank_id AND YEAR(payment_date) = YEAR(:priodeStart - INTERVAL 1 MONTH) AND MONTH(payment_date) = MONTH(:priodeStart - INTERVAL 1 MONTH)',
		//   'params'=>array(':bank_id'=>1,':priodeStart'=>$priodeStart))
		// );
		// foreach ($resource_cnt as $key => $value) {
		// 	echo "string ".$value->amt; 
		// }
		// var_dump($resource_cnt);
		// die();

		// var_dump($daterange); die();
		// echo $startDate;
		// echo $priodeStep;
		// echo $begin;
		// echo $endpriode;
		// echo $interval;
		// var_dump($daterange);
		// die();
		$this->render('test',array(
			'model'=>$model,
			'forecastingBank'=>$forecastingBank,
			// 'forecastingBalance'=>$forecastingBalance,
			'daterange'=>$daterange,
			// 'saldo_awal'=>$saldo_awal,
		));
	}

	public function actionAjax() {
		// $model=new Forecasting;

		// uncomment the following code to enable ajax-based validation
		/*
		if(isset($_POST['ajax']) && $_POST['ajax']==='person-form-edit_person-form')
		{
		    echo CActiveForm::validate($model);
		    Yii::app()->end();
		}
		*/

		if(isset($_POST['Forecasting']))
		{
			$id = $_POST['Forecasting']['id'];	
			$model = $this->loadModel($id);
			// var_dump($_POST['Forecasting']); die("S");
		    $model->attributes=$_POST['Forecasting'];
		    if($model->save())
		    {
		       print_r($_REQUEST);
		       return;
		    }
		}
	}

	public function actionUpdatestatus() {
		if(isset($_POST['Forecasting']))
		{
			$id = $_POST['Forecasting']['id'];	
			$model = $this->loadModel($id);
			// var_dump($_POST['Forecasting']); die("S");
		    $model->status=$_POST['Forecasting']['status'];
		    if($model->save())
		    {
		       print_r($_REQUEST);
		       return;
		    }
		}
	}



	public function actionExportXls()
	{

		// echo $_GET['startdate'];
		// die("s");
		/* id bank 
			3 	BCA HUFADHA | 5 	BCA PD	| 7 	BCA PT	| 10 	CIMB NIAGA | 14 	Mandiri KMK | 17 	MANDIRI TBM
		*/
		$listbank=new ForecastingComponents();
		$criteria = new CDbCriteria;
		$criteria->addInCondition('id', $listbank->getListbank()); 
		$forecastingBank = Coa::model()->findAll($criteria);
		// $forecastingBalance = ForecastingBalance::model()->findAll();
		$model=new Forecasting;

		$priodeStep = (isset($_GET['priode']) ? $_GET['priode']:0);
		$priodeStart= (isset($_GET['startdate'])?$_GET['startdate']:date('Y-m-01'));
		$dateStart  = substr($priodeStart,-2); 
		$priodeEnd	= date('Y-m-01', strtotime('+'.$priodeStep.' months'));
		$begin = new DateTime($priodeStart);
		$end = new DateTime($priodeEnd);
		// var_dump($end); die();
		// $end = $end->modify( '+1 day' ); 
		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval ,$end);

		// setting saldo awal berdasarkan bank//
//		$saldo_awal = [];
		foreach ($forecastingBank as $key => $value) {
			$bankid = Forecasting::model()->getCoaBank($value->id);
			$saldo_awal[$bankid] = Forecasting::model()->getSaldoAwal($bankid,$priodeStart);
		}

		// $arrayLetter = array();
		// for($letter = 'C'; $letter !== 'BB'; $letter++) {
		// 	$arrayLetter[] = $letter;
		// }
		// $step6 = 0; 
		// foreach ($forecastingBank as $key => $value) {
		//  	echo $arrayLetter[$step6];
		//  	$step6 = $step6 + 6;
		//  }


		// var_dump($arrayLetter);
		// // // echo count($forecastingBank); 
		// echo 'string(1) "1" string(1) "3" string(1) "5" string(1) "8" string(2) "12" string(2) "15"';
		// var_dump($saldo_awal); die();
		$this->getXls($forecastingBank,$priodeStart,$daterange,$priodeStep);
	}
	
	public function getXls($forecastingBank,$startDate,$daterange,$periode) 
	{
		$listbank=new ForecastingComponents();
		$objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
             ->setLastModifiedBy("Apri Pebriana")
             ->setTitle("Forecasting Finance ".date('d-m-Y'))
             ->setSubject("Forecasting Finance")
             ->setDescription("Export Forecasting Finance, generated using PHP classes.")
             ->setKeywords("Forecasting Finance")
             ->setCategory("Export Forecasting");        
        
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
            ->setCellValue('A1', 'BANK ACCOUNTS')
            ->setCellValue('A2', 'Day')
            ->setCellValue('B2', 'Date');
        
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:B1');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:A3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:B3');
		
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->getStyle('A1:B1')->applyFromArray($styleHorizontalVertivalCenterBold);
		$sheet->getStyle('A2:A3')->applyFromArray($styleVerticalCenter);
		$sheet->getStyle('B2:B3')->applyFromArray($styleVerticalCenter);

		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
		$objPHPExcel->getActiveSheet()->freezePane('C4');

         // DEFINE HEADER LIKE THIS!!
		// BCA PD				
		// Status	Debit		Credit		Balance
		// Hutang Supplier	Lain-Lain	Pelunasan/CR	Setoran & Pendapatan/Lain2	SALDO

		$arrayLetter = array();
		for($letter = 'C'; $letter !== 'AZ'; $letter++) {
			$arrayLetter[] = $letter;
		}

		$step6 = 0;
        foreach ($forecastingBank as $key => $value) {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6].'1', $forecastingBank[$key]->name);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6].'2', 'Status');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6 + 1].'2', 'Debit');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6 + 3].'2', 'Kredit');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6 + 5].'2', 'Balance');

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6 + 1].'3', 'Hutang Supplier');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6 + 2].'3', 'Lain Lain');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6 + 3].'3', 'Pelunasan CR');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6 + 4].'3', 'Setoran Pendapatan');

        	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$step6].'2:'.$arrayLetter[$step6].'3'); // merge status
        	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$step6].'1:'.$arrayLetter[$step6 + 5].'1'); // merge bank name
        	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$step6 + 1].'2:'.$arrayLetter[$step6 + 2].'2'); // merge debit
        	$objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$step6 + 3].'2:'.$arrayLetter[$step6 + 4].'2'); // merge kredit

        	//style for heading
			$sheet->getStyle($arrayLetter[$step6].'1:'.$arrayLetter[$step6 + 5].'1')->applyFromArray($styleHorizontalVertivalCenterBold);
			$sheet->getStyle($arrayLetter[$step6].'2:'.$arrayLetter[$step6].'3')->applyFromArray($styleVerticalCenter);
			$sheet->getStyle($arrayLetter[$step6 + 1].'2:'.$arrayLetter[$step6 + 2].'2')->applyFromArray($styleHorizontalVertivalCenter);
			$sheet->getStyle($arrayLetter[$step6 + 3].'2:'.$arrayLetter[$step6 + 4].'2')->applyFromArray($styleHorizontalVertivalCenter);

			$step6 = $step6 + 6;
        }

        $startrow=4;$saldorow=4; 
		$totaldc = $listbank->getListbankValue();
		$saldoawal_array = $listbank->getListbankValue();
		// var_dump($saldo_awal); die();
		foreach($daterange as $key => $date){

			// for heading and balance bulan sebelumnya
			if (($date->format("d") == "1") OR ($date->format("d") == "01")){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$saldorow, $date->format("F Y"));
		        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$saldorow.':B'.$saldorow);
				$sheet->getStyle('A'.$saldorow.':B'.$saldorow)->applyFromArray($styleHorizontalVertivalCenterBold);

				// var_dump($forecastingBank); die();
				$heading_start = 0;
				foreach ($forecastingBank as $key => $valuesaldoawal) {
					$bankid = Forecasting::model()->getCoaBank($valuesaldoawal->id);
					$saldo_awal_ = Forecasting::model()->getSaldoAwal($bankid,$date->format("Y-m-01"));
					$saldoawalKas = Forecasting::model()->getSaldoAwalKas($valuesaldoawal->id,$date->format("Y-m-01"));
					// $totaldc = $totaldc + $saldo_awal_;
					$saldoawal_array[$valuesaldoawal->id] = $saldo_awal_ + $saldoawalKas;

					// var_dump($saldo_awal_);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$heading_start + 5].$startrow, $totaldc[$valuesaldoawal->id]);
					$objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$heading_start + 5].$startrow)->getNumberFormat()->setFormatCode('#,###;-#,###');

					// $totaldc[$valuesaldoawal->id] = $totaldc[$valuesaldoawal->id] + $saldoawal_array[$valuesaldoawal->id];
					$heading_start = $heading_start + 6;
				}
				// die();
		        $startrow++;$saldorow++;
			}
			// $heading_start = $heading_start + 6;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$startrow, $date->format("l"));
			if ($date->format("N") == 6 OR $date->format("N") == 7) {
				$sheet->getStyle('A'.$startrow)->applyFromArray($styleColorRED);
			}  
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$startrow, $date->format("d"));

			$step6_row = 0;
	        foreach ($forecastingBank as $key => $value) {
				$bankid = Forecasting::model()->getCoaBank($value->id);
				$id = Forecasting::model()->getValue('id',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid));
				$status = Forecasting::model()->getValue('status',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid));
				$status2 = ($status == 'OK') ? 'OK': 'NOT OK';
				$debit1 = Forecasting::model()->getValues('amount',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid,'type_forecasting'=>Forecasting::TYPE_PO));
				$debit2 = Forecasting::model()->getValues('amount',array('payment_date'=>$date->format("Y-m-d"),'coa_id'=>$value->id,'type_forecasting'=>Forecasting::TYPE_CASH_OUT));
				
				$credit1 = Forecasting::model()->getValues('amount',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid,'type_forecasting'=>Forecasting::TYPE_SO));
				$credit2 = Forecasting::model()->getValues('amount',array('payment_date'=>$date->format("Y-m-d"),'coa_id'=>$value->id,'type_forecasting'=>Forecasting::TYPE_CASH_IN));
				
				$credit1notes = Forecasting::model()->getValue('notes',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid,'type_forecasting'=>Forecasting::TYPE_SO));
				$credit2notes = Forecasting::model()->getValue('notes',array('payment_date'=>$date->format("Y-m-d"),'coa_id'=>$value->id,'type_forecasting'=>Forecasting::TYPE_CASH_OUT));
				$debit1notes = Forecasting::model()->getValue('notes',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid,'type_forecasting'=>Forecasting::TYPE_PO));
				$debit2notes = Forecasting::model()->getValue('notes',array('payment_date'=>$date->format("Y-m-d"),'coa_id'=>$value->id,'type_forecasting'=>Forecasting::TYPE_CASH_IN));


				// $cektgl = Forecasting::model()->getValue('payment_date',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid));
				// $totaldc += (($credit1 + $credit2) - ($debit1 + $debit2));

				$cektgl_1 = Forecasting::model()->getValue('payment_date',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid));
				$cektgl_2 = Forecasting::model()->getValue('payment_date',array('payment_date'=>$date->format("Y-m-d"),'coa_id'=>$value->id));
				$totaldc[$value->id] += (($credit1 + $credit2) - ($debit1 + $debit2));

				// $totaldc = (($credit1+ $credit2) - ($debit1+$debit2)); 
				// $saldo_awal[$bankid] = ($saldo_awal[$bankid] + $totaldc);
				// $saldo_awal[$bankid] = ($saldo_awal[$bankid] + $totaldc);
				// echo "string". ;
				// die();
				// $balance = ($saldo_awal[$bankid] + $totaldc);
				if (!empty($cektgl_1) OR !empty($cektgl_2)) {
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6_row].$startrow, $status2);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6_row + 1].$startrow, ($debit1 > 0)?'-'.$debit1:0);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6_row + 2].$startrow, ($debit2 > 0)?'-'.$debit2:0);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6_row + 3].$startrow, $credit1);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6_row + 4].$startrow, $credit2);
					// $objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6_row + 5].$startrow, $totaldc);
					// if ($startrow == 4) {
					// 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6_row + 5].$startrow, $saldo_awal[$bankid]);
					// }else{
					// 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6_row + 5].$startrow, '='.$arrayLetter[$step6_row + 5].($startrow -1).'+'.$arrayLetter[$step6_row + 1].$startrow.'+'.$arrayLetter[$step6_row + 2].$startrow.'+'.$arrayLetter[$step6_row + 3].$startrow.'+'.$arrayLetter[$step6_row + 4].$startrow);
					// }
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6_row + 5].$startrow, '='.$arrayLetter[$step6_row + 5].($startrow -1).'+'.$arrayLetter[$step6_row + 1].$startrow.'+'.$arrayLetter[$step6_row + 2].$startrow.'+'.$arrayLetter[$step6_row + 3].$startrow.'+'.$arrayLetter[$step6_row + 4].$startrow);


					$objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$step6_row + 1].$startrow)->getNumberFormat()->setFormatCode('#,###;#,###');
					$objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$step6_row + 2].$startrow)->getNumberFormat()->setFormatCode('#,###;#,###');
					$objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$step6_row + 3].$startrow)->getNumberFormat()->setFormatCode('#,###;#,###');
					$objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$step6_row + 4].$startrow)->getNumberFormat()->setFormatCode('#,###;#,###');

					$objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$step6_row + 5].$startrow)->getNumberFormat()->setFormatCode('#,###;-#,###');


					$objPHPExcel->setActiveSheetIndex(0)->getComment($arrayLetter[$step6_row + 5].$startrow)->getText()->createTextRun('Total amount on the current invoice, excluding VAT.');

					// $objPHPExcel->getActiveSheet()->getComment($arrayLetter[$step6_row + 1].$startrow)->getText()->createTextRun("\r\n");
					// $objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$step6_row + 5].$startrow)->getNumberFormat()->setFormatCode("#.##0,00");
				}else{
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6_row].$startrow, '');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6_row + 1].$startrow, '');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6_row + 2].$startrow, '');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6_row + 3].$startrow, '');
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6_row + 4].$startrow, '');
					
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6_row + 5].$startrow, '='.$arrayLetter[$step6_row + 5].($startrow -1).'+'.$arrayLetter[$step6_row + 1].$startrow.'+'.$arrayLetter[$step6_row + 2].$startrow.'+'.$arrayLetter[$step6_row + 3].$startrow.'+'.$arrayLetter[$step6_row + 4].$startrow);

					$objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$step6_row + 5].$startrow)->getNumberFormat()->setFormatCode('#,###;-#,###');

					//$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$step6_row + 5].$startrow, '='.$arrayLetter[$step6_row + 5].($startrow -1).'+'.$arrayLetter[$step6_row + 1].$startrow.'+'.$arrayLetter[$step6_row + 2].$startrow.'+'.$arrayLetter[$step6_row + 3].$startrow.'+'.$arrayLetter[$step6_row + 4].$startrow);
				}
				$step6_row = $step6_row + 6;
		        // $objPHPExcel->setActiveSheetIndex(0)
		        //     ->setCellValue('A4', 'Miscellaneous glyphs')
		        //     ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
	        }
			$startrow++;
			$saldorow++;
	    }
	        // die();
		$objCommentRichText = $objPHPExcel->getActiveSheet(0)->getComment('E5')->getText()->createTextRun('My first comment :)');

        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('YiiExcel');
        
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Save a xls file
        $filename = 'Forecasting_'.$startDate.'_'.$periode.'_months';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		// $path=Yii::getPathOfAlias('webroot');
		// die();
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Forecasting']))
		{
			$model->attributes=$_POST['Forecasting'];
			// $model->image=CUploadedFile::getInstance($model,'image');
            $imageUploadFile = CUploadedFile::getInstance($model, 'image');
            if($imageUploadFile !== null){ // only do if file is really uploaded
                $imageFileName = mktime().'_'.$imageUploadFile->name;
                $model->image = $imageFileName;
                $model->image_attach = $imageFileName;
            }         
			if($model->save()) {
                // $model->image->saveAs($path.'/uploads/forecasting');
                if($imageUploadFile !== null) // validate to save file
                    $imageUploadFile->saveAs($path.'/uploads/forecasting/'.$imageFileName);

				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		// $dataProvider=new CActiveDataProvider('Forecasting');
		// $this->render('index',array(
		// 	'dataProvider'=>$dataProvider,
		// ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$modelpo=new ForecastingPo('search');
		$modelpo->unsetAttributes();  // clear any default values
		// $modelcash->type_forecasting = 'po';
		if(isset($_GET['ForecastingPo']))
			$modelpo->attributes=$_GET['ForecastingPo'];

		$modelso=new ForecastingSo('search');
		$modelso->unsetAttributes();  // clear any default values
		if(isset($_GET['ForecastingSo']))
			$modelso->attributes=$_GET['ForecastingSo'];

		$modelcash=new ForecastingCash('search');
		// var_dump($modelcash); die();
		$modelcash->unsetAttributes();  // clear any default values
		if(isset($_GET['ForecastingCash']))
			$modelcash->attributes=$_GET['ForecastingCash'];

		$this->render('admin',array(
			'modelpo'=>$modelpo,
			'modelso'=>$modelso,
			'modelcash'=>$modelcash,
		));
		// $this->redirect(array('test'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Forecasting the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Forecasting::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Forecasting $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='forecasting-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionDetail($date,$bankid,$tipe) {

		if ($tipe == 'po' || $tipe == 'so') {
			$forecasting = Forecasting::model()->findAllByAttributes(array('payment_date'=>$date,'bank_id'=>$bankid,'type_forecasting'=>$tipe));
		}else{
			$forecasting = Forecasting::model()->findAllByAttributes(array('payment_date'=>$date,'coa_id'=>$bankid,'type_forecasting'=>$tipe));
		}
		// var_dump(count($forecasting));
		$countForecasting = count($forecasting);
		$saved = false; 
		if(isset($_POST['Forecasting']))
		{
			for ($i=1; $i <= $countForecasting; $i++) { 
				$path=Yii::getPathOfAlias('webroot');
				$id = (int) $_POST['Forecasting'][$i-1]['id'];
				// echo $id;
				$model = $this->loadModel($id);
				// var_dump($model); die();
				$model->attributes=$_POST['Forecasting'][$i-1];
				// $model->image=CUploadedFile::getInstance($model,$_POST['Forecasting'][$i-1]['image']);
	   //          $imageUploadFile = CUploadedFile::getInstance($model, $_POST['Forecasting'][$i-1]['image']);
	   //          if($imageUploadFile !== null){ // only do if file is really uploaded
	   //              $imageFileName = mktime().'_'.$imageUploadFile->name;
	   //              $model->image = $imageFileName;
	   //              $model->image_attach = $imageFileName;
	   //          }         
				if($model->save()) {
	                // if($imageUploadFile !== null) // validate to save file
	                //     $imageUploadFile->saveAs($path.'/uploads/forecasting/'.$imageFileName);
					// echo "OK";
					$saved = true;
					// $this->redirect(array('view','id'=>$model->id));
				}
			}
			if ($saved == true) {
				echo '<script type="text/javascript">alert("transaction success saved"); window.close();</script>';
			}else{
				return false;
			}
		}
		// var_dump($forecasting);
		$this->render('detail',array(
			'modelforecasting'=>$forecasting,
		));

	}
}
