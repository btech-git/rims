<?php

class CashierController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2-1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'cashier') {
            if (!(Yii::app()->user->checkAccess('cashierApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }
        
        if ($filterChain->action->id === 'customerWaitlist') {
            if (!(Yii::app()->user->checkAccess('customerQueueApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionAdmin() {
        $invoice = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : '');
        $invoice->unsetAttributes();
        
        if (isset($_GET['InvoiceHeader'])) {
            $invoice->attributes = $_GET['InvoiceHeader'];
        }
        
        $invoiceCriteria = new CDbCriteria;
        $invoiceCriteria->compare('t.invoice_number', $invoice->invoice_number, true);
        $invoiceCriteria->compare('t.status', $invoice->status);
        $invoiceCriteria->compare('t.branch_id', $invoice->branch_id);
        $invoiceCriteria->compare('t.insurance_company_id', $invoice->insurance_company_id);
        $invoiceCriteria->addCondition('t.branch_id = :branch_id');
        $invoiceCriteria->params[':branch_id'] = Yii::app()->user->branch_id;
        $invoiceCriteria->addCondition("t.status != 'CANCELLED' AND t.registration_transaction_id IS NOT NULL AND invoice_date > '2021-01-01'");
        $invoiceCriteria->together = true;
        $invoiceCriteria->with = array(
            'customer', 
            'vehicle',
        );
        $invoiceCriteria->compare('vehicle.plate_number', $invoice->plate_number, true);
        $invoiceCriteria->addSearchCondition('customer.name', $invoice->customer_name, true);
        $invoiceCriteria->addSearchCondition('customer.customer_type', $invoice->customer_type, true);

        if (!empty($invoice->invoice_date) || !empty($invoice->invoice_date_to)) {
            $invoiceCriteria->addBetweenCondition('t.invoice_date', $invoice->invoice_date, $invoice->invoice_date_to);
        }
        
        $invoiceDataProvider = new CActiveDataProvider('InvoiceHeader', array(
            'criteria' => $invoiceCriteria, 
            'sort' => array(
                'defaultOrder' => 'invoice_date ASC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            )
        ));

        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values

        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }

        $customerCriteria = new CDbCriteria;
        $customerCriteria->compare('name', $customer->name, true);
        $customerCriteria->compare('customer_type', $customer->customer_type, true);
        $customerCriteria->compare('email', $customer->email . '%', true, 'AND', false);

        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));

        $this->render('admin', array(
            'invoice' => $invoice,
            'invoiceDataProvider' => $invoiceDataProvider,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
        ));
    }

    public function actionMemo($id) {
        $model = $this->loadModel($id);
        $services = RegistrationService::model()->findAllByAttributes(array(
            'registration_transaction_id' => $id,
            'is_body_repair' => 0
        ));
        $products = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $id));

        $this->render('memo', array(
            'model' => $model,
            'services' => $services,
            'products' => $products,
        ));
    }
    
    public function loadModel($id) {
        $model = RegistrationTransaction::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

}
