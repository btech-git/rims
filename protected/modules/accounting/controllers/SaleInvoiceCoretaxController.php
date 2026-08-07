<?php

class SaleInvoiceCoretaxController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('coretaxInvoiceView'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionView($id) {
        $saleInvoice = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('sale_invoice_header_id', $saleInvoice->id);
        $detailsDataProvider = new CActiveDataProvider('SaleInvoiceDetail', array(
            'criteria' => $criteria,
        ));


        $this->render('view', array(
            'saleInvoice' => $saleInvoice,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new InvoiceHeader('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['InvoiceHeader'])) {
            $model->attributes = $_GET['InvoiceHeader'];
        }
        
        $dataProvider = $model->searchByAdmin();
        $dataProvider->criteria->addCondition('t.status NOT LIKE "%CANCEL%" AND t.ppn_total > 0 AND t.transaction_tax_number IS NULL');
        
        if (!(Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6)) {
            $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        }
        
        $arr_category = array();
        if (isset($_GET['SaveXml'])) {
            if (isset($_GET['selectedIds'])) {
                foreach ($_GET['selectedIds'] as $id) {
                    $saleInvoice = InvoiceHeader::model()->findByPk($id);
                    array_push($arr_category, $saleInvoice);
                }
            }
        }

        if ($arr_category) {
            if (isset($_GET['SaveXml'])) {
                $this->saveToXml($arr_category);
            }
        }

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function saveToXml($saleInvoiceHeaders) {
        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="eFaktur Coretax.xml"');
        header('Cache-Control: max-age=0');
        
        $this->renderPartial('exportXml', array(
            'saleInvoiceHeaders' => $saleInvoiceHeaders,
        ));

        Yii::app()->end();
    }
    
    public function actionImportCoretax() {
        
        $errorMessage = '';
                
        if (isset($_FILES['TaxImportData'])) {
            $uploadedFiles = CUploadedFile::getInstancesByName('TaxImportData');
            
            $dbTransaction = Yii::app()->db->beginTransaction();
            try {
                $valid = $this->updateTaxNumberAndDate($uploadedFiles[0]->tempName);
                if ($valid) {
                    $dbTransaction->commit();
                } else {
                    $dbTransaction->rollback();
                }
            } catch (Exception $e) {
                $dbTransaction->rollback();
                $valid = false;
                $this->header->addError('error', $e->getMessage());
            }
            
            if (!$valid) {
                $errorMessage = 'Data CSV gagal diimport.';
            } else {
                $this->redirect(array('admin'));
            }
        }
        
        $this->render('importCoretax', array(
            'errorMessage' => $errorMessage,
        ));

    }
    
    public function updateTaxNumberAndDate($filename) {
        $data = array_map('str_getcsv', file($filename));
        
        $valid = true;
        foreach ($data as $i => $item) {
            if ($i > 0) {
                $invoiceHeader = InvoiceHeader::model()->find(array('condition' => 'invoice_number LIKE :invoice_number', 'params' => array(':invoice_number' => $invoiceNumber . '%')));
                
                $coretaxNumber = $item[3];
                $coretaxDate = $item[4];
                $coretaxTotal = $invoiceHeader->subTotal;
                $coretaxTaxAmount = $item[11];
                $invoiceNumber = substr($item[14], 0, -2);
                
                if ($invoiceHeader !== null) {
                    $invoiceHeader->transaction_tax_number = $coretaxNumber;
                    $invoiceHeader->transaction_tax_date = $coretaxDate;
                    $invoiceHeader->grand_total_coretax = $coretaxTotal;
                    $invoiceHeader->tax_amount_coretax = $coretaxTaxAmount;
                    $valid = $valid && $invoiceHeader->save();
                }
            }
            if (!$valid) {
                break;
            }
        }
        
        return $valid;
    }
}
