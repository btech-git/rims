<?php

class InvoiceHeaderController extends Controller {

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
            if (!(Yii::app()->user->checkAccess('saleInvoiceCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'delete' ||
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('saleInvoiceEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'index' ||
            $filterChain->action->id === 'view' ||
            $filterChain->action->id === 'viewInvoices'
        ) {
            if (!(Yii::app()->user->checkAccess('saleInvoiceCreate')) || !(Yii::app()->user->checkAccess('saleInvoiceEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $details = InvoiceDetail::model()->findAllByAttributes(array('invoice_id' => $id));
        $payments = PaymentIn::model()->findAllByAttributes(array('invoice_id' => $id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'details' => $details,
            'payments' => $payments,
        ));
    }

    public function actionViewInvoices() {
        // $id = array(4,5);
        (!empty(Yii::app()->session['pr'])) ? $pr = Yii::app()->session['pr'] : $pr = array();
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $pr);
        $invoices = InvoiceHeader::model()->findAll($criteria);

        //$details = InvoiceDetail::model()->findAllByAttributes(array('invoice_id'=>$id));
        $this->render('viewInvoices', array(
            //'model'=>$this->loadModel($id),
            //'details'=>$details,
            'invoices' => $invoices,
        ));
    }

    public function actionUpdateEstimateDate($id) {
        $model = $this->loadModel($id);
        $details = InvoiceDetail::model()->findAllByAttributes(array('invoice_id' => $id));
        $payments = PaymentIn::model()->findAllByAttributes(array('invoice_id' => $id));
        
        if (isset($_POST['Update'])) {
            $model->payment_date_estimate = $_POST['InvoiceHeader']['payment_date_estimate'];
            $model->coa_bank_id_estimate = $_POST['InvoiceHeader']['coa_bank_id_estimate'];
            $model->update(array('coa_bank_id_estimate', 'payment_date_estimate'));

            $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('updateEstimateDate', array(
            'model' => $model,
            'details' => $details,
            'payments' => $payments,
        ));
    }

    public function actionPdfAll() {
        $this->layout = '//layouts/invoice';
        (!empty(Yii::app()->session['pr'])) ? $pr = Yii::app()->session['pr'] : $pr = array();
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $pr);
        $invoices = InvoiceHeader::model()->findAll($criteria);

        $mPDF1 = Yii::app()->ePdf->mpdf();
        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A5-L');

        # render (full page)
        // $mPDF1->WriteHTML($this->render('index', array(), true));
        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/invoices.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML(
                $this->renderPartial('pdfInvoices', array(
                    'invoices' => $invoices,
                        ), true)
        );
        // $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));
        $mPDF1->Output('Invoice.pdf', 'D');
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //$model=new InvoiceHeader;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $invoice = $this->instantiate(null);
        $this->performAjaxValidation($invoice->header);

        // if(isset($_POST['InvoiceHeader']))
        // {
        // 	$model->attributes=$_POST['InvoiceHeader'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['InvoiceHeader'])) {

            $this->loadState($invoice);
            if ($invoice->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $invoice->header->id));
            }
        }

        $this->render('create', array(
            //'model'=>$model,
            'invoice' => $invoice,
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
        $invoice = $this->instantiate($id);
        $invoice->header->setCodeNumberByRevision('invoice_number');
        $this->performAjaxValidation($invoice->header);

        // if(isset($_POST['InvoiceHeader']))
        // {
        // 	$model->attributes=$_POST['InvoiceHeader'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['InvoiceHeader'])) {


            $this->loadState($invoice);
            if ($invoice->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $invoice->header->id));
            }
        }

        $this->render('update', array(
            //'model'=>$model,
            'invoice' => $invoice,
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

        $dataProvider = new CActiveDataProvider('InvoiceHeader');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new InvoiceHeader('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['InvoiceHeader']))
            $model->attributes = $_GET['InvoiceHeader'];

        (!empty(Yii::app()->session['pr'])) ? $pr = Yii::app()->session['pr'] : $pr = array();
        $this->render('admin', array(
            'model' => $model,
            'prChecked' => $pr,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return InvoiceHeader the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = InvoiceHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param InvoiceHeader $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'invoice-header-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $invoice = new Invoices(new InvoiceHeader(), array());
        } else {
            $invoiceModel = $this->loadModel($id);
            $invoice = new Invoices($invoiceModel, $invoiceModel->invoiceDetails);
            //print_r("test");
        }
        return $invoice;
    }

    public function loadState($invoice) {
        if (isset($_POST['InvoiceHeader'])) {
            $invoice->header->attributes = $_POST['InvoiceHeader'];
        }


        if (isset($_POST['InvoiceDetail'])) {
            foreach ($_POST['InvoiceDetail'] as $i => $item) {
                if (isset($invoice->details[$i])) {
                    $invoice->details[$i]->attributes = $item;
                } else {
                    $detail = new InvoiceDetail();
                    $detail->attributes = $item;
                    $invoice->details[] = $detail;
                }
            }
            if (count($_POST['InvoiceDetail']) < count($invoice->details))
                array_splice($invoice->details, $i + 1);
        }
        else {
            $invoice->details = array();
        }
    }

    //Add Detail
    public function actionAjaxHtmlAddDetail($id, $productId) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product']))
                $product->attributes = $_GET['Product'];

            $productCriteria = new CDbCriteria;

            $productCriteria->together = true;
            $productCriteria->select = 't.id,t.name, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
            $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
            $productCriteria->compare('t.name', $product->name, true);
            $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
            $productCriteria->compare('findkeyword', $product->findkeyword, true);
            $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
            $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name, true);
            $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
            $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,));

            $consignmentIn = $this->instantiate($id);
            $this->loadState($consignmentIn);

            $consignmentIn->addDetail($productId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            $this->renderPartial('_detail', array('consignmentIn' => $consignmentIn, 'product' => $product,
                'productDataProvider' => $productDataProvider,
                    ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product']))
                $product->attributes = $_GET['Product'];

            $productCriteria = new CDbCriteria;
            $productCriteria->compare('name', $product->name, true);
            $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
            $productCriteria->together = true;
            $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
            $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
            $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
            $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name, true);
            $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
            $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,));

            $consignmentIn = $this->instantiate($id);
            $this->loadState($consignmentIn);

            $consignmentIn->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            $this->renderPartial('_detail', array('consignmentIn' => $consignmentIn, 'product' => $product,
                'productDataProvider' => $productDataProvider,
                    ), false, true);
        }
    }

    public function actionPrTemp() {
        if (Yii::app()->request->isAjaxRequest) {
            // var_dump($_GET['productChecked']);die("s");
            if ($_GET['checked'] == 'clear') {
                Yii::app()->session->remove('pr');
            } else {
                Yii::app()->session['pr'] = $_GET['checked'];
            }
        }
    }

    public function actionAjaxCustomer($id) {

        if (Yii::app()->request->isAjaxRequest) {
            // $invoice = $this->instantiate($id);
            // $this->loadState($invoice);

            $customer = Customer::model()->findByPk($id);

            $object = array(
                'name' => $customer->name,
                'address' => $customer->address,
                'type' => $customer->customer_type,
                'province' => $customer->province_id,
                'city' => $customer->city_id,
                'zipcode' => $customer->zipcode,
                'email' => $customer->email,
                'rate' => $customer->flat_rate,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionPpn($id, $ppn_type, $ref) {
        $model = $this->loadModel($id);

        if ($ref == 1) {
            //$salesOrder = TransactionSalesOrder::model()->findByPk($model->sales_order_id);
            if ($ppn_type == 1) {
                $model->ppn = 1;
                $model->ppn_total = $model->product_price * 0.1;
                $model->total_price = $model->product_price * 1.1;
                if ($model->update(array('ppn', 'ppn_total', 'total_price')))
                    $this->redirect(array('view', 'id' => $model->id));
            }
            else {
                $model->ppn = 0;
                $model->ppn_total = 0;
                $model->total_price = $model->product_price;
                if ($model->update(array('ppn', 'ppn_total', 'total_price')))
                    $this->redirect(array('view', 'id' => $model->id));
            }
        }
        else {
            //$registration = RegistrationTransaction::model()->findByPk($model->registration_transaction_id);
            $totalPrice = $model->quick_service_price + $model->service_price + $model->product_price;
            if ($ppn_type == 1) {
                $model->ppn = 1;
                $model->ppn_total = $totalPrice * 0.1;
                $model->total_price = $totalPrice * 1.1;
                if ($model->update(array('ppn', 'ppn_total', 'total_price')))
                    $this->redirect(array('view', 'id' => $model->id));
            }
            else {
                $model->ppn = 0;
                $model->ppn_total = 0;
                $model->total_price = $totalPrice;
                if ($model->update(array('ppn', 'ppn_total', 'total_price')))
                    $this->redirect(array('view', 'id' => $model->id));
            }
        }
    }

    // public function actionPph($id,$pph){
    // 	$model = $this->loadModel($id);
    // 	$registration = RegistrationTransaction::model()->findByPk($model->registration_transaction_id);
    // 		$totalPrice = $registration->total_quickservice_price + $registration->subtotal_service + $registration->subtotal_product;
    // 	if($pph == 1){
    // 		$model->pph = 1;
    // 		$model->pph_total = $
    // 	}
    // }
}
