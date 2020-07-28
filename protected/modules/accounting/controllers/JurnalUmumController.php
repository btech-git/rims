<?php

class JurnalUmumController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

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
		$model=new JurnalUmum;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['JurnalUmum']))
		{
			$model->attributes=$_POST['JurnalUmum'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['JurnalUmum']))
		{
			$model->attributes=$_POST['JurnalUmum'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
		$this->pageTitle = "RIMS - Jurnal Umum Detail";
		$tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : date('Y-m-d');
        $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : date('Y-m-d');
        $coaData = (isset($_GET['coa_id'])) ? $_GET['coa_id'] : '';
        $branch = (isset($_GET['branch'])) ? $_GET['branch'] : '';
        $company = (isset($_GET['company'])) ? $_GET['company'] : ''; 
        $transactionType = (isset($_GET['TransactionType'])) ? $_GET['TransactionType'] : ''; 
        
		$criteria = new CDbCriteria;
		
		if (!empty($coaData)) {
			$criteria->addCondition("coa_id = " . $coaData);
		}
        
		if ($company!= "") {
			$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
			$arrBranch = array();
            
			foreach ($branches as $key => $branchId) {
				$arrBranch[] = $branchId->id;
			}
            
			if ($branch != "") {
				$criteria->addCondition("branch_id = ".$branch);
			} else {
				$criteria->addInCondition('branch_id',$arrBranch);
			}
		} else {
			if ($branch != "") {
				$criteria->addCondition("branch_id = ".$branch);
			}
		}
        
        if (!empty($transactionType)) {
            $criteria->compare('transaction_type ', $transactionType);
        }
		
		$criteria->addBetweenCondition('t.tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
        $criteria->order = 't.tanggal_transaksi DESC, t.kode_transaksi DESC';
		$jurnals = JurnalUmum::model()->findAll($criteria);

		$coa = new Coa('search');
      	$coa->unsetAttributes();  // clear any default values
        
      	if (isset($_GET['Coa']))
        	$coa->attributes = $_GET['Coa'];

		$coaCriteria = new CDbCriteria;
		$coaCriteria->addCondition("coa_category_id != 0 and coa_id != 0");
		$coaCriteria->compare('code',$coa->code,true);
		$coaCriteria->compare('name',$coa->name,true);

	  	$coaDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaCriteria,
	  	));	

	  	if (isset($_GET['SaveExcel']))
			$this->getXlsJurnal($jurnals, $tanggal_mulai, $tanggal_sampai);
        
		$dataProvider=new CActiveDataProvider('JurnalUmum');

		$this->render('summary',array(
			'dataProvider'=>$dataProvider,
			'jurnals'=>$jurnals,
			'tanggal_mulai'=>$tanggal_mulai,
			'tanggal_sampai'=>$tanggal_sampai,
			'coaData'=>$coaData,
			'coa'=>$coa,
			'coaDataProvider'=>$coaDataProvider,
			'branch'=>$branch,
			'company'=>$company,
            'transactionType' => $transactionType,
		));
	}
    
    public function actionRedirectTransaction($codeNumber) {
        list($leftPart, , ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);
        
        if ($codeNumberConstant === 'PO') {
            $model = TransactionPurchaseOrder::model()->findByAttributes(array('purchase_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionPurchaseOrder/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'RG') {
            $model = RegistrationTransaction::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/frontDesk/registrationTransaction/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'DO') {
            $model = TransactionDeliveryOrder::model()->findByAttributes(array('delivery_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionDeliveryOrder/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'RCI') {
            $model = TransactionReceiveItem::model()->findByAttributes(array('receive_item_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionReceiveItem/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'CASH') {
            $model = CashTransaction::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/transaction/cashTransaction/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'CSI') {
            $model = ConsignmentInHeader::model()->findByAttributes(array('consignment_in_number' => $codeNumber));
            $this->redirect(array('/transaction/consignmentInHeader/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'CSO') {
            $model = ConsignmentOutHeader::model()->findByAttributes(array('consignment_out_no' => $codeNumber));
            $this->redirect(array('/transaction/consignmentOutHeader/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'MO') {
            $model = MovementOutHeader::model()->findByAttributes(array('movement_out_no' => $codeNumber));
            $this->redirect(array('/transaction/movementOutHeader/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'Pin') {
            $model = PaymentIn::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/transaction/paymentIn/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'Pout') {
            $model = PaymentOut::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/transaction/paymentOut/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'RTI') {
            $model = TransactionReturnItem::model()->findByAttributes(array('return_item_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionReturnItem/view', 'id' => $model->id));
        }
    }

	public function actionBuku()
	{	
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
		$this->pageTitle = "RIMS - Buku Besar";

		$tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : date('Y-m-d');
        $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : date('Y-m-d');
        $coaData = (isset($_GET['coa_id'])) ? $_GET['coa_id'] : '';
        $company = (isset($_GET['company'])) ? $_GET['company'] : '';
        $branch = (isset($_GET['branch'])) ? $_GET['branch'] : '';
        
//        $getCoa = "";
//        $prefix = $branch != "" ? Branch::model()->findByPk($branch)->coa_prefix : '';
//        if($coaData != ""){
//        	$coaCode = Coa::model()->findByPk($coaData)->code;
//		    if ($prefix != "") {
//		    	$coaPrefix = $prefix.'.'.$coaCode;
//		    	//var_dump($coaPrefix);
//		    	$getCoa = Coa::model()->findByAttributes(array('code'=>$coaPrefix))->id;
//		    	//$getCoa1 = Coa::model()->findByAttributes(array('code'=>$coaPrefix))->code;
//		    }
//        }
        
		 $criteria = new CDbCriteria;
		if ($company!= "") {
			$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
			$arrBranch = array();
			foreach ($branches as $key => $branchId) {
				$arrBranch[] = $branchId->id;
			}
			if ($branch != "") {
				$criteria->addCondition("branch_id = ".$branch);
			}
			else{
				$criteria->addInCondition('branch_id',$arrBranch);
			}
		} else{
			if ($branch != "") {
				$criteria->addCondition("branch_id = ".$branch);
			}
		}
		if (!empty($coaData)) {
			$criteria->addCondition("t.coa_id = ".$coaData);
		}
		
		$criteria->addBetweenCondition('t.tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
		$criteria->together = true;
		$criteria->with = array('coa');
		
		$showJurnals = JurnalUmum::model()->findAll($criteria);
		// /$allCoa = Coa::model()->findAll();
		$arrCoa= array();
		foreach ($showJurnals as $key => $varCoa) {
			$arrCoa[] = $varCoa->coa_id;
		}
		
		$coaCriteria = new CDbCriteria;
		$coaCriteria->addInCondition('id',$arrCoa);
		$allCoa = Coa::model()->findAll($coaCriteria);

		//$jurnals = JurnalUmum::model()->findAll($coaCriteria);
		$coa = new Coa('search');
      	$coa->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coa->attributes = $_GET['Coa'];

		$coaCriteria = new CDbCriteria;
//		$coaCriteria->addCondition("coa_id != 0");
		$coaCriteria->compare('code',$coa->code.'%',true,'AND', false);
		$coaCriteria->compare('name',$coa->name,true);
		$coaCriteria->compare('coa_sub_category_id',$coa->coa_sub_category_id);
		$coaCriteria->compare('coa_category_id',$coa->coa_category_id);

	  	$coaDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaCriteria,
	  	));	
        
        $coaSub = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $coaSubDataProvider = $coaSub->search();
        $coaSubDataProvider->criteria->with = array(
            'jurnalUmums'
        );
        
        $coaSubDataProvider->criteria->compare('t.coa_id', $coaData);
        $coaSubDataProvider->criteria->order = 't.code ASC, jurnalUmums.tanggal_transaksi ASC';
        $coaSubDataProvider->criteria->addBetweenCondition('jurnalUmums.tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
        $coaSubDataProvider->pagination->pageSize = 1000;

        $coaCategory = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $coaCategoryDataProvider = $coaCategory->search();
        $coaCategoryDataProvider->criteria->with = array(
            'coaIds' => array(
                'with' => array(
                    'jurnalUmums'
                ),
            ),
        );
        
        $coaCategoryDataProvider->criteria->compare('t.coa_id', null);
        $coaCategoryDataProvider->criteria->order = 't.code ASC, jurnalUmums.tanggal_transaksi ASC';
        $coaCategoryDataProvider->criteria->addBetweenCondition('jurnalUmums.tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
        $coaCategoryDataProvider->pagination->pageSize = 1000;

	  	if (isset($_GET['SaveExcel']))
			$this->getXlsBuku($allCoa, $tanggal_mulai, $tanggal_sampai,$branch,$company);
        
		$dataProvider=new CActiveDataProvider('JurnalUmum');

		$this->render('bukubesar',array(
			'tanggal_mulai'=>$tanggal_mulai,
			'tanggal_sampai'=>$tanggal_sampai,
			'allCoa'=>$allCoa,
			'coaData'=>$coaData,
			'coa'=>$coa,
			'coaDataProvider'=>$coaDataProvider,
            'coaSub' => $coaSub,
            'coaSubDataProvider' => $coaSubDataProvider,
            'coaCategory' => $coaCategory,
            'coaCategoryDataProvider' => $coaCategoryDataProvider,
			'branch'=>$branch,
			'company'=>$company,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new JurnalUmum('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['JurnalUmum']))
			$model->attributes=$_GET['JurnalUmum'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return JurnalUmum the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=JurnalUmum::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param JurnalUmum $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='jurnal-umum-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionExportExcel($tanggal_mulai,$tanggal_sampai) {
		// $tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : '';
  //       $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : '';
        $criteria = new CDbCriteria;
		$criteria->addBetweenCondition('t.tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);

		$jurnals = JurnalUmum::model()->findAll($criteria);
		var_dump($tanggal_mulai);
		//$this->getXlsJurnal($jurnals,$tanggal_mulai,$tanggal_sampai);
  		// if ($id == NULL) {
  		// 	$dataJurnal = JurnalUmum::model()->findAll();
	  	// 	$this->getXlsJurnal($dataJurnal);
  		// }
  	}

  	public function getXlsJurnal($jurnals,$tanggal_mulai,$tanggal_sampai) {
  		$lastkode = "";
  		// var_dump($customer); die();
  		$objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
             ->setLastModifiedBy("RIMS")
             ->setTitle("Jurnal Umum Data ".date('d-m-Y'))
             ->setSubject("Jurnal Umum")
             ->setDescription("Export Data Jurnal Umum.")
             ->setKeywords("Jurnal Umum Data")
             ->setCategory("Export Jurnal Umum");        
        
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
            ->setCellValue('A2', 'PT RATU PERDANA INDAH JAYA')
            ->setCellValue('A3', 'JURNAL UMUM')
            ->setCellValue('A4', 'PERIODE ('.$tanggal_mulai.'-'.$tanggal_sampai.')')
            ->setCellValue('B7', 'TANGGAL')
            ->setCellValue('C7', 'KODE TRANSAKSI')
            ->setCellValue('D7', 'KODE AKUN')
            ->setCellValue('E7', 'NAMA AKUN')
            ->setCellValue('F7', 'KETERANGAN')
            ->setCellValue('G7', 'DEBET')
            ->setCellValue('H7', 'KREDIT');
           
           
            // ->setCellValue('L2', 'Historical');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:J2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:J3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:J4');
       // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E7:F7');
        //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:D2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:G2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:H3');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I2:K2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L2:L3');
		
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->getStyle('A2:J2')->applyFromArray($styleHorizontalVertivalCenterBold);
		$sheet->getStyle('A3:J3')->applyFromArray($styleHorizontalVertivalCenterBold);
		$sheet->getStyle('A4:J4')->applyFromArray($styleHorizontalVertivalCenterBold);
		// $sheet->getStyle('I2:K2')->applyFromArray($styleHorizontalVertivalCenterBold);
		// $sheet->getStyle('L2:L3')->applyFromArray($styleHorizontalVertivalCenterBold);
		// $sheet->getStyle('H2:H3')->applyFromArray($styleVerticalCenter);
		 $sheet->getStyle('A7:I7')->applyFromArray($styleBold);

		// $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);

		// $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
		//$objPHPExcel->getActiveSheet()->freezePane('E4');

		$startrow = 8;
		$totalDebet = $totalKredit = 0;
		foreach ($jurnals as $key => $jurnal) {

			//$phone = ($value->customerPhones !=NULL)?$this->phoneNumber($value->customerPhones):'';

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$startrow, $lastkode == $jurnal->kode_transaksi ?"": $jurnal->tanggal_posting);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$startrow, $lastkode == $jurnal->kode_transaksi ?"": $jurnal->kode_transaksi);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$startrow, $jurnal->branchAccountCode);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$startrow, $jurnal->coa->name);
			//$customertype = (($value->customer_type == 'Individual')?"P":(($value->customer_type == 'Company')?"K":""));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$startrow, "");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$startrow, $jurnal->debet_kredit == 'D'? number_format($jurnal->total,2) : '');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$startrow, $jurnal->debet_kredit == 'K'? number_format($jurnal->total,2) : '');
			
			if ($jurnal->debet_kredit == 'D') {
				$totalDebet += $jurnal->total;
			}
			if ($jurnal->debet_kredit == 'K') {
				$totalKredit += $jurnal->total;
			}
			// $objPHPExcel->getActiveSheet()->setCellValue('L'.$startrow,'see details');
			// $objPHPExcel->getActiveSheet()->getCell('L'.$startrow)->getHyperlink()->setUrl("sheet://'Historical'!A1");

			
			
			$objPHPExcel->getActiveSheet()
			    ->getStyle('C'.$startrow)
			    ->getNumberFormat()
			    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
			$lastkode = $jurnal->kode_transaksi;
			$startrow++;
		}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$startrow, number_format($totalDebet,2));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$startrow, number_format($totalKredit,2));
	        // die();
		$objCommentRichText = $objPHPExcel->getActiveSheet(0)->getComment('E5')->getText()->createTextRun('My first comment :)');
        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('JURNALUMUM');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0);

        // Save a xls file
        $filename = 'jurnal_umum_data_'.date("Y-m-d");
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

  	public function getXlsBuku($allCoa,$tanggal_mulai,$tanggal_sampai,$branch,$company) {
  		$lastkode = "";
  		$tanggal_mulai = $tanggal_mulai == "" ? date('Y-m-d') : $tanggal_mulai;
		$tanggal_sampai = $tanggal_sampai == "" ? date('Y-m-d') : $tanggal_sampai;
		$yesterday = date('Y-m-d', strtotime( $tanggal_mulai .'-1 days'));
 		$count = 0;
  		// var_dump($customer); die();
  		$objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
             ->setLastModifiedBy("RIMS")
             ->setTitle("Buku Besar Data ".date('d-m-Y'))
             ->setSubject("Buku Besar")
             ->setDescription("Export Data Buku Besar.")
             ->setKeywords("Buku Besar Data")
             ->setCategory("Export Buku Besar");        
        
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
	     $styleBorder = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		);
	     $styleOutline = array(
		  'borders' => array(
		    'outline' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		);

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'PT RATU PERDANA INDAH JAYA')
            ->setCellValue('A3', 'BUKU BESAR')
            ->setCellValue('A4', 'PERIODE ('.$tanggal_mulai.'-'.$tanggal_sampai.')');
            // ->setCellValue('B7', 'TANGGAL')
            // ->setCellValue('C7', 'KODE TRANSAKSI')
            // ->setCellValue('D7', 'KODE AKUN')
            // ->setCellValue('E7', 'NAMA AKUN')
            // ->setCellValue('F7', 'KETERANGAN')
            // ->setCellValue('G7', 'DEBET')
            // ->setCellValue('H7', 'KREDIT');
           
           
            // ->setCellValue('L2', 'Historical');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:J2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:J3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:J4');
       // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E7:F7');
        //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:D2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:G2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:H3');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I2:K2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L2:L3');
		
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->getStyle('A2:J2')->applyFromArray($styleHorizontalVertivalCenterBold);
		$sheet->getStyle('A3:J3')->applyFromArray($styleHorizontalVertivalCenterBold);
		$sheet->getStyle('A4:J4')->applyFromArray($styleHorizontalVertivalCenterBold);
		// $sheet->getStyle('I2:K2')->applyFromArray($styleHorizontalVertivalCenterBold);
		// $sheet->getStyle('L2:L3')->applyFromArray($styleHorizontalVertivalCenterBold);
		// $sheet->getStyle('H2:H3')->applyFromArray($styleVerticalCenter);
		 $sheet->getStyle('A7:I7')->applyFromArray($styleBold);

		// $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(32);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);

	
		$objPHPExcel->getActiveSheet()->freezePane('A5');

		$startrow = 5;
		$totalDebet = $totalKredit = 0;
		
		 foreach ($allCoa as $key => $coaDetail) {

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($startrow+1), 'Nama Akun');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($startrow+1), ':'.$coaDetail->name);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($startrow+1), 'Kode Akun');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($startrow+1), ':'.$coaDetail->code);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($startrow+2), 'Tanggal ');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($startrow+2), 'Ref ');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($startrow+2), 'Keterangan');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($startrow+2), 'Debet');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($startrow+2), 'Kredit');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($startrow+2), 'Saldo');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($startrow+3), 'Debet');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($startrow+3), 'Kredit');
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("G".($startrow+2).":H".($startrow+2));     
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("B".($startrow+2).":B".($startrow+3));     
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("C".($startrow+2).":C".($startrow+3));     
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("D".($startrow+2).":D".($startrow+3));     
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("E".($startrow+2).":E".($startrow+3));     
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells("F".($startrow+2).":F".($startrow+3));     
			$sheet = $objPHPExcel->getActiveSheet();
			$sheet->getStyle("B".($startrow+1).":H".($startrow+1))->applyFromArray($styleBold);
			$sheet->getStyle("B".($startrow+2).":H".($startrow+2))->applyFromArray($styleBorder);
		 	$sheet->getStyle("B".($startrow+3).":H".($startrow+3))->applyFromArray($styleBorder);
		 	$sheet->getStyle("B".($startrow+4).":H".($startrow+4))->applyFromArray($styleBorder);
		 	$sheet->getStyle("B".($startrow+5).":H".($startrow+5))->applyFromArray($styleBorder);
		 	$JurnalCriteria = new CDbCriteria; 
						$JurnalCriteria->addCondition("coa_id = ".$coaDetail->id);
						if ($company!= "") {
							$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
							$arrBranch = array();
							foreach ($branches as $key => $branchId) {
								$arrBranch[] = $branchId->id;
							}
							if ($branch != "") {
								$JurnalCriteria->addCondition("branch_id = ".$branch);
							}
							else{
								$JurnalCriteria->addInCondition('branch_id',$arrBranch);
							}
						}
						else{
							if ($branch != "") {
								$JurnalCriteria->addCondition("branch_id = ".$branch);
							}
						}
						
					  	$JurnalCriteria->addBetweenCondition('tanggal_transaksi', $coaDetail->date, $tanggal_mulai);
					  	$allJurnals = JurnalUmum::model()->findAll($JurnalCriteria);
					  	//echo $yesterday;
					  	$debitTotal = $creditTotal = 0;
					  	foreach ($allJurnals as $key => $allJurnal) {
					  		if($allJurnal->debet_kredit == "D")
					  			$debitTotal += $allJurnal->total;
					  		else
					  			$creditTotal += $allJurnal->total;
					  	}
					  	if($coaDetail->normal_balance=="DEBET"){
					  		$count = $coaDetail->opening_balance + $debitTotal - $creditTotal;
					  	}
					  	else{
					  		$count = $coaDetail->opening_balance + $creditTotal - $debitTotal;
					  	}
			$criteria = new CDbCriteria; 
			$criteria->addCondition("coa_id = ".$coaDetail->id);
			if($branch != "")
				$criteria->addCondition("branch_id = ".$branch);
		  	$criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
		  	$coaJurnals = JurnalUmum::model()->findAll($criteria);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($startrow+4), "SALDO AWAL");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($startrow+4), $coaDetail->normal_balance == 'DEBET'? $count :'-');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($startrow+4), $coaDetail->normal_balance == 'KREDIT'? $count :'-');
			$startrow = $startrow+5;
			foreach ($coaJurnals as $key => $jurnal)
			{
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($startrow), $jurnal->tanggal_posting);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($startrow), ' ');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.($startrow), $jurnal->kode_transaksi);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($startrow), $jurnal->debet_kredit == 'D'? number_format($jurnal->total,2) : '' );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($startrow), $jurnal->debet_kredit == 'K'? number_format($jurnal->total,2) : '');
				if ($key == 0) {
					$lastcount = $jurnal->debet_kredit == "D" ? $coaDetail->opening_balance + $jurnal->total : $count - $jurnal->total;
				} 
				else{
					$lastcount = $jurnal->debet_kredit == "D" ? $lastcount + $jurnal->total : $lastcount - $jurnal->total;
				}
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($startrow), $coaDetail->normal_balance == 'DEBET'? number_format($lastcount,2):'-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($startrow), $coaDetail->normal_balance == 'KREDIT'?  number_format($lastcount,2):'-');
				$startrow++;
				$sheet = $objPHPExcel->getActiveSheet();
				$sheet->getStyle("B".($startrow).":H".($startrow))->applyFromArray($styleBorder);
			}
			
		}
		// 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$startrow, $lastkode == $jurnal->kode_transaksi ?"": $jurnal->kode_transaksi);
		// 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$startrow, $jurnal->coa->code);
		// 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$startrow, $jurnal->coa->name);
		// 	//$customertype = (($value->customer_type == 'Individual')?"P":(($value->customer_type == 'Company')?"K":""));
		// 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$startrow, "");
		// 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$startrow, $jurnal->debet_kredit == 'D'? number_format($jurnal->total,2) : '');
		// 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$startrow, $jurnal->debet_kredit == 'K'? number_format($jurnal->total,2) : '');
		 	
       		
		// 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$startrow, $lastkode == $jurnal->kode_transaksi ?"": $jurnal->tanggal_posting);
		// 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$startrow, $lastkode == $jurnal->kode_transaksi ?"": $jurnal->kode_transaksi);
		// 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$startrow, $jurnal->coa->code);
		// 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$startrow, $jurnal->coa->name);
		// 	//$customertype = (($value->customer_type == 'Individual')?"P":(($value->customer_type == 'Company')?"K":""));
		// 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$startrow, "");
		// 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$startrow, $jurnal->debet_kredit == 'D'? number_format($jurnal->total,2) : '');
		// 	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$startrow, $jurnal->debet_kredit == 'K'? number_format($jurnal->total,2) : '');
			
		// 	if ($jurnal->debet_kredit == 'D') {
		// 		$totalDebet += $jurnal->total;
		// 	}
		// 	if ($jurnal->debet_kredit == 'K') {
		// 		$totalKredit += $jurnal->total;
		// 	}
		
		

			
			
		// 	$objPHPExcel->getActiveSheet()
		// 	    ->getStyle('C'.$startrow)
		// 	    ->getNumberFormat()
		// 	    ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
		// 	$lastkode = $jurnal->kode_transaksi;
			
		//}
		// $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$startrow, $totalDebet);
		// $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$startrow, $totalKredit);
	        // die();
		//$objCommentRichText = $objPHPExcel->getActiveSheet(0)->getComment('E5')->getText()->createTextRun('My first comment :)');
        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('BUKU BESAR');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0);

        // Save a xls file
        $filename = 'buku_besar_data_'.date("Y-m-d");
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
  	public function actionAjaxCoa($id){
        if (Yii::app()->request->isAjaxRequest)
        {
            $coa = Coa::model()->findByPk($id);

            $object = array(
        		'id' => $coa->id,
                'code' => $coa->code,
                'name' => $coa->name,
            );

            echo CJSON::encode($object);
        }
  	}
  	public function actionJurnalUmumRekap()
	{	
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
		$this->pageTitle = "RIMS - JURNAL UMUM REKAP";

		// $tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : '';
  //       $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : '';
        // $coaData = (isset($_GET['coa_id'])) ? $_GET['coa_id'] : '';
        $branch = (isset($_GET['branch'])) ? $_GET['branch'] : '';
        $company = (isset($_GET['company'])) ? $_GET['company'] : '';
        $year = (isset($_GET['year'])) ? $_GET['year'] : '';
      //   $getCoa = "";
      //   $prefix = $branch != "" ? Branch::model()->findByPk($branch)->coa_prefix : '';
      //   if($coaData != ""){
      //   	$coaCode = Coa::model()->findByPk($coaData)->code;
		    // if ($prefix != "") {
		    // 	$coaPrefix = $prefix.'.'.$coaCode;
		    // 	//var_dump($coaPrefix);
		    // 	$getCoa = Coa::model()->findByAttributes(array('code'=>$coaPrefix))->id;
		    // 	//$getCoa1 = Coa::model()->findByAttributes(array('code'=>$coaPrefix))->code;
		    // }
      //   }
        
		$criteria = new CDbCriteria;
		// if ($branch != "") {
		// 	$criteria->addCondition("branch_id = ".$branch);
		// }
		// if ($getCoa != "") {
		// 	$criteria->addCondition("t.coa_id = ".$getCoa);
		// }
		
		//$criteria->addBetweenCondition('t.tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
		// $criteria->together = true;
		// $criteria->with = array('coa');
		$criteria->addCondition("coa_id = 0");
		$showCoas = Coa::model()->findAll($criteria);
		// /$allCoa = Coa::model()->findAll();
		// $arrCoa= array();
		// foreach ($showJurnals as $key => $varCoa) {
		// 	$arrCoa[] = $varCoa->coa_id;
		// }
		
		// $coaCriteria = new CDbCriteria;
		// $coaCriteria->addInCondition('id',$arrCoa);
		// $allCoa = Coa::model()->findAll($coaCriteria);

		//$jurnals = JurnalUmum::model()->findAll($coaCriteria);
		$coa = new Coa('search');
      	$coa->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coa->attributes = $_GET['Coa'];

		$coaCriteria = new CDbCriteria;
		$coaCriteria->addCondition("coa_id = 0");
		$coaCriteria->compare('code',$coa->code.'%',true,'AND', false);
		$coaCriteria->compare('name',$coa->name,true);


	  	$coaDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaCriteria,
	  	));	
	  	//print_r($jurnals);

	  	if (isset($_GET['SaveExcel']))
			$this->getXlsJurnalRekap($showCoas,$branch, $year,$company);
		$dataProvider=new CActiveDataProvider('JurnalUmum');
		// $model=new JurnalUmum('search');
		// $model->unsetAttributes();  // clear any default values
		// if(isset($_GET['JurnalUmum']))
		// 	$model->attributes=$_GET['JurnalUmum'];

		$this->render('jurnalUmumRekap',array(
			// 'dataProvider'=>$dataProvider,
			//'jurnals'=>$jurnals,
			// 'tanggal_mulai'=>$tanggal_mulai,
			// 'tanggal_sampai'=>$tanggal_sampai,
			'showCoas'=>$showCoas,
			// 'coaData'=>$coaData,
			'coa'=>$coa,
			'coaDataProvider'=>$coaDataProvider,
			'branch'=>$branch,
			'company'=>$company,
			'year'=>$year,
			// 'getCoa'=>$getCoa,
			//'model'=>$model,
		));


	}
	public function getXlsJurnalRekap($showCoas,$branch,$year,$company) {
  		// $lastkode = "";
  		// var_dump($customer); die();
  		ini_set('max_execution_time', 300); //300 seconds = 5 minutes
		ini_set('memory_limit', '2048M');

  		$objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
             ->setLastModifiedBy("RIMS")
             ->setTitle("Jurnal Umum Rekap Data ".date('d-m-Y'))
             ->setSubject("Jurnal Umum Rekap")
             ->setDescription("Export Data Jurnal Umum Rekap.")
             ->setKeywords("Jurnal Umum Rekap Data")
             ->setCategory("Export Jurnal Umum Rekap");        
        
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
			$year = $year == "" ? date('Y') : $year;
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'PT RATU PERDANA INDAH JAYA')
            ->setCellValue('A3', 'JURNAL UMUM REKAP')
            ->setCellValue('A4', 'PERIODE ('.$year.')')

            ->setCellValue('A7', 'KODE AKUN')
            ->setCellValue('B7', 'NAMA AKUN');
            // ->setCellValue('C7', 'JANUARI')
            // ->setCellValue('E7', 'FEBRUARI')
            // ->setCellValue('G7', 'MARET')
            // ->setCellValue('I7', 'APRIL')
            // ->setCellValue('K7', 'MEI')
            // ->setCellValue('M7', 'JUNI')
            // ->setCellValue('O7', 'JULI')
            // ->setCellValue('Q7', 'AGUSTUS')
            // ->setCellValue('S7', 'SEPTEMBER')
            // ->setCellValue('U7', 'OKTOBER')
            // ->setCellValue('W7', 'NOVEMBER')
            // ->setCellValue('Y7', 'DESEMBER')

            
            // ->setCellValue('C8', 'DEBIT')
            // ->setCellValue('D8', 'KREDIT')
            // ->setCellValue('E8', 'DEBIT')
            // ->setCellValue('F8', 'KREDIT')
            // ->setCellValue('G8', 'DEBIT')
            // ->setCellValue('H8', 'KREDIT')
            // ->setCellValue('I8', 'DEBIT')
            // ->setCellValue('J8', 'KREDIT')
            // ->setCellValue('K8', 'DEBIT')
            // ->setCellValue('L8', 'KREDIT')
            // ->setCellValue('M8', 'DEBIT')
            // ->setCellValue('N8', 'KREDIT')
            // ->setCellValue('O8', 'DEBIT')
            // ->setCellValue('P8', 'KREDIT')
            // ->setCellValue('Q8', 'DEBIT')
            // ->setCellValue('R8', 'KREDIT')
            // ->setCellValue('S8', 'DEBIT')
            // ->setCellValue('T8', 'KREDIT')
            // ->setCellValue('U8', 'DEBIT')
            // ->setCellValue('V8', 'KREDIT')
            // ->setCellValue('W8', 'DEBIT')
            // ->setCellValue('X8', 'KREDIT')
            // ->setCellValue('Y8', 'DEBIT')
            // ->setCellValue('Z8', 'KREDIT');
           
           
            // ->setCellValue('L2', 'Historical');
        $arrayLetter = array();
		for($letter = 'C'; $letter !== 'AA'; $letter++) {
			$arrayLetter[] = $letter;
		}

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:Z2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:Z3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:Z4');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:A8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B7:B8');
        //MONTHS
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C7:D7');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E7:F7');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G7:H7');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I7:J7');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K7:L7');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M7:N7');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O7:P7');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q7:R7');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('S7:T7');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('U7:V7');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('W7:X7');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Y7:Z7');
        // TILL HERE

       // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E7:F7');
        //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:D2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:G2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:H3');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I2:K2');
        // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L2:L3');

        //prepare for header loop
		$letterStep11 = 0; $bulan = "";
		for ($i=1; $i <=12; $i++) { 
			switch ($i) {
        		case '1':
        			$bulan = "January";
        			break;
        		case '2':
        			$bulan = "February";
        			break;
        		case '3':
        			$bulan = "March";
        			break;
        		case '4':
        			$bulan = "April";
        			break;
        		case '5':
        			$bulan = "May";
        			break;
        		case '6':
        			$bulan = "June";
        			break;
        		case '7':
        			$bulan = "July";
        			break;
        		case '8':
        			$bulan = "August";
        			break;
        		case '9':
        			$bulan = "September";
        			break;
        		case '10':
        			$bulan = "October";
        			break;
        		case '11':
        			$bulan = "November";
        			break;
        		
        		default:
        			$bulan = "December";
        			break;
        	}
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue($arrayLetter[$letterStep11].'7', $bulan);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue($arrayLetter[$letterStep11].'8', 'Debit')
			->setCellValue(($arrayLetter[$letterStep11+1]).'8', 'Credit');
			$objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11])->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension($arrayLetter[$letterStep11+1])->setWidth(20);
	        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($arrayLetter[$letterStep11].'7:'.($arrayLetter[$letterStep11+1]).'7');
	        $letterStep11 = $letterStep11+2;
		}
		
		$sheet = $objPHPExcel->getActiveSheet();
		$sheet->getStyle('A2:Z2')->applyFromArray($styleHorizontalVerticalCenterBold);
		$sheet->getStyle('A3:Z3')->applyFromArray($styleHorizontalVerticalCenterBold);
		$sheet->getStyle('A4:Z4')->applyFromArray($styleHorizontalVerticalCenterBold);
		//$sheet->getStyle('H2:H3')->applyFromArray($styleVerticalCenter);
		// $sheet->getStyle('I2:K2')->applyFromArray($styleHorizontalVertivalCenterBold);
		// $sheet->getStyle('L2:L3')->applyFromArray($styleHorizontalVertivalCenterBold);
		// $sheet->getStyle('H2:H3')->applyFromArray($styleVerticalCenter);
		 $sheet->getStyle('A7:Z7')->applyFromArray($styleHorizontalVerticalCenterBold);
		 $sheet->getStyle('A8:Z8')->applyFromArray($styleHorizontalVerticalCenterBold);

		// $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(15);

		// $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
		//$objPHPExcel->getActiveSheet()->freezePane('E4');
		$startrow = 9;
		//$mutasiDebet = $mutasiKredit = 0;
		$sumvalue1 = array();
		foreach ($showCoas as $key => $showCoa) {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$startrow, $showCoa->code);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$startrow, $showCoa->name);
			$letterStep =0;
			for ($i=1; $i <= 12 ; $i++) { 

				
				$janCriteria = new CDbCriteria;
				$janCriteria->together = true;
				$janCriteria->with = array('coa');
				$janCriteria->addCondition("coa.coa_id = ".$showCoa->id);
				if ($company!= "") {
					$branches = Branch::model()->findAllByAttributes(array('company_id'=>$company));
					$arrBranch = array();
					foreach ($branches as $key => $branchId) {
						$arrBranch[] = $branchId->id;
					}
					if ($branch != "") {
						$janCriteria->addCondition("branch_id = ".$branch);
					}
					else{
						$janCriteria->addInCondition('branch_id',$arrBranch);
					}
				}
				else{
					if ($branch != "") {
						$janCriteria->addCondition("branch_id = ".$branch);
					}
				}
				$janCriteria->addCondition("YEAR(tanggal_transaksi) = ".$year);
					$janCriteria->addCondition("MONTH(tanggal_transaksi) = ".$i);
				// $criteria->addBetweenCondition('tanggal_transaksi', $tanggal_mulai, $tanggal_sampai);
				$jurnals = JurnalUmum::model()->findAll($janCriteria);
				$mutasiDebet = $mutasiKredit = 0;
				foreach ($jurnals as $key => $jurnal) {
					$mutasiDebet += $jurnal->debet_kredit == "D" ? $jurnal->total:0;
					$mutasiKredit += $jurnal->debet_kredit == "K" ? $jurnal->total:0;
					
					
				}
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$letterStep].$startrow, $mutasiDebet);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($arrayLetter[$letterStep+1].$startrow, $mutasiKredit);
				$objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$letterStep].$startrow)->getNumberFormat()->setFormatCode("#,##0.00_-");
				$objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$letterStep+1].$startrow)->getNumberFormat()->setFormatCode("#,##0.00_-");
				$letterStep = $letterStep +2;
			}
			$startrow++;
		}
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($startrow), 'TOTAL');
		$sheet->getStyle('B'.($startrow))->applyFromArray($styleBold);
		$jumCoa = count($showCoas);
		$letterStep12 = 0;
		$startrowNew = 9;
		$totalRow = $jumCoa+9;
		for ($i=1; $i <= 24; $i++) { 
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue($arrayLetter[$letterStep12].$totalRow, '=SUM('.$arrayLetter[$letterStep12].$startrowNew.':'.$arrayLetter[$letterStep12].($totalRow - 1).')');
			$objPHPExcel->getActiveSheet()->getStyle($arrayLetter[$letterStep12].$totalRow)->getNumberFormat()->setFormatCode("#,##0.00_-");

			$letterStep12++;
		}
		
		
		
		//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('"A".($startrow).":B".($startrow)');
		//$startrow ++;
	        // die();
		$objCommentRichText = $objPHPExcel->getActiveSheet(0)->getComment('E5')->getText()->createTextRun('My first comment :)');
        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('JURNAL UMUM REKAP');
        //$objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('0.000');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0);

        // Save a xls file
        $filename = 'jurnal_umum_rekap_data_'.date("Y-m-d");
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

  	public function actionAjaxGetBranch()
	{
		

		$data = Branch::model()->findAllByAttributes(array('company_id'=>$_POST['company'])); 

		if(count($data) > 0)
		{
			$data=CHtml::listData($data,'id','name');
			echo CHtml::tag('option',array('value'=>''),'-- All Branch --',true);
			foreach($data as $value=>$name)
			{		
				echo CHtml::tag('option', array('value'=>$value), CHtml::encode($name), true);
			}
		}
		else
		{
			$data = Branch::model()->findAll();
			foreach($data as $value=>$name)
			{		
				echo CHtml::tag('option', array('value'=>$value), CHtml::encode($name), true);
			}
			echo CHtml::tag('option',array('value'=>''),'-- All Branch --',true);
		}
	}
}
