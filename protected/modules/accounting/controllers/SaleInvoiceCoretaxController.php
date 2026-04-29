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
        
        if (!Yii::app()->user->checkAccess('director')) {
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
}